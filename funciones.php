<?php

/**
 * WHMCS Sample Payment Callback File
 *
 * This sample file demonstrates how a payment gateway callback should be
 * handled within WHMCS.
 *
 * It demonstrates verifying that the payment gateway module is active,
 * validating an Invoice ID, checking for the existence of a Transaction ID,
 * Logging the Transaction for debugging and Adding Payment to an Invoice.
 *
 * For more information, please refer to the online documentation.
 *
 * @see https://developers.whmcs.com/payment-gateways/callbacks/
 *
 * @copyright Copyright (c) WHMCS Limited 2017
 * @license http://www.whmcs.com/license/ WHMCS Eula
 */

// Require libraries needed for gateway module functions.
require_once __DIR__ . '/../../../init.php';
//require_once __DIR__ . '/../../../includes/gatewayfunctions.php';
//require_once __DIR__ . '/../../../includes/invoicefunctions.php';

$gatewayModuleName = ("GetNetModule");
$gatewayParams = getGatewayVariables($gatewayModuleName);
if (!$gatewayParams['type']) {
  $responseArray = array("msg" => "Module Not Activated");
  echo json_encode($responseArray);
  die("");
}


try {

  //leer input
  $postdata = json_decode(file_get_contents("php://input"), true);
  $responseDate = $postdata["status"]["date"];
  $status = $postdata["status"]["status"];
  $success = ($status == "APPROVED");
  $transactionId = $postdata["requestId"];
  $reference = $postdata["reference"];
  $signature = $postdata["signature"];

  $secretKey = $gatewayParams['gnTrankey'];
  $computedSignature = sha1($transactionId . $responseStatus . $responseDate . $secretKey);
  if ($signature != $computedSignature) {
    $responseArray = array("msg" => "Hash Verification Failure");
    die(json_encode($responseArray));
  };

  checkCbTransID($reference); //si ya estaba registrada sale  
  $jsonEstado = obtenerEstadoGetNet($transactionId, $gatewayParams['gnLogin'], $gatewayParams['gnTrankey'], $gatewayParams["testMode"]);
  $paymentAmount = $jsonEstado["payment"]["amount"]["to"]["total"];

  /*extraer el documento de la descripcion*/

  $invoiceIdDescrip = 0;
  $patron = '/Nro\. (\d+)/';
  $cadena = $jsonEstado["request"]["payment"]["description"];

  if (preg_match($patron, $cadena, $coincidencias)) {
    $invoiceIdDescrip = $coincidencias[1];
  }

  $invoiceId = checkCbInvoiceID($invoiceIdDescrip, $gatewayParams['name']);

  logTransaction($gatewayParams['name'], $jsonEstado, $jsonEstado["status"]["status"]);
  if ($success) {
    addInvoicePayment(
      $invoiceId,
      $reference,
      $paymentAmount,
      0,
      $gatewayModuleName
    );
  }

  echo json_encode(array("msg" => "OK"));
} catch (Exception $ex) {
  $errorMsg = $ex->getMessage();
  $responseArray = array("msg" => "Exception: $errorMsg");
  echo json_encode(array($responseArray));
}

function obtenerEstadoGetNet($request_id, $loginRest, $trankeyRest, $testMode)
{
  $urlGetnet = ($testMode) ? "https://checkout.test.getnet.cl" : "https://checkout.getnet.cl";
  date_default_timezone_set("America/Santiago");
  $nonce = rand();
  $nonce64 = base64_encode($nonce);
  $seed = (new DateTime())->format('c'); //la semilla es la fecha
  $auth = array(
    "login" => $loginRest,
    "nonce" => $nonce64,
    "seed" => $seed,
    "tranKey" => base64_encode(hash('sha256', $nonce . $seed . $trankeyRest, true))
  );

  $request = array("auth" => $auth);

  $arrContexto = ['http' => [
    'method'  => 'POST',
    'header'  => 'Content-type: application/json',
    'content' => json_encode($request)
  ]];

  //echo json_encode($request);
  $contexto = stream_context_create($arrContexto);
  $enlace = $urlGetnet . "/api/session/$request_id"; //$this->urlGetnet;
  ini_set('user_agent', 'Mozilla/4.0 (compatible; MSIE 6.0)'); //sino se genera un error 403
  $respuesta = file_get_contents($enlace, false, $contexto);
  $respuesta = json_decode($respuesta, true);

  //
  return $respuesta;
}

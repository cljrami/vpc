<?php

// if (!defined("WHMCS")) {
//     die("This file cannot be accessed directly");
// }

/*-------------------------------------------------------------- 
## FUNCION NETADATA 
----------------------------------------------------------------*/
function vpc_ChangePassword_MetaData()
{
  return array(
    'DisplayName' => 'XHVPC_ChangePassword',
    'APIVersion' => '1.1', // Use API Version 1.1
    'RequiresServer' => false, // Set true if module requires a server to work
    'DefaultNonSSLPort' => '5985', // Default Non-SSL Connection Port
    'DefaultSSLPort' => '5986', // Default SSL Connection Port
    //'ServiceSingleSignOnLabel' => 'Login to Panel as User',
    //'AdminSingleSignOnLabel' => 'Login to Panel as Admin',
  );
}
/*-------------------------------------------------------------- 
## FIN FUNCION NETADATA 
----------------------------------------------------------------*/

/*-------------------------------------------------------------- 
## CONFIGURACION DEL MODULO 
----------------------------------------------------------------*/
//function vpc_ChangePassword_config()
function vpc_ChangePassword_ConfigOptions()
{
  return array(
    // the friendly display name for a payment gateway should be
    // defined here for backwards compatibility
    'FriendlyName' => array(
      'Type' => 'System',
      'Value' => 'vpc_ChangePassword_Module', //Sample Third Party Payment Gateway Module
    ),
  );
}
/*-------------------------------------------------------------- 
## FIN CONFIGURACION DEL MODULO 
----------------------------------------------------------------*/

/*-------------------------------------------------------------- 
## FUNCION CURL ACTUALIZADA con $params
----------------------------------------------------------------*/
// Parámetros para la función vpc_ChangePassword
$params = array(
  'serverusername' => "olson",
  'passwordserver' => "123",
  'domain' => "192.168.5.125",
  'user' => "1234",
  'pass' => "123456789"
);

function vpc_ChangePassword(array $params)
{
  try {
    $postvars = array(
      'username' => $params['serverusername'],
      'passwd' => $params['passwordserver'],
      'domain' => $params['domain'],
      'user' => $params['user'],
      'pass' => $params['pass'],
    );

    // Verificar si la función cURL está disponible en este servidor
    if (!is_callable('curl_exec')) {
      return json_encode(array('result' => 'Error: La función cURL no está disponible en este servidor.'));
    }

    // URL de destino
    $url = 'https://vps065.xhost.cl/prueba_whmcs/vpc_ChangePassword.php';

    // Verificar si la URL de destino es válida
    if (!$url) {
      return json_encode(array('result' => 'Error: La URL de destino no es válida.'));
    }

    // Inicializar la sesión cURL
    $curl = curl_init();

    // Configurar las opciones de cURL
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postvars);

    // Ejecutar la petición cURL y obtener la respuesta
    $response = curl_exec($curl);

    // Verificar si la petición tuvo éxito
    if ($response === false) {
      return json_encode(array('result' => 'Error: La acción cURL falló: ' . curl_error($curl)));
    } else {
      // Imprimir los resultados de las validaciones hechas en el servidor remoto
      return $response;
    }

    // Cerrar la conexión cURL
    curl_close($curl);
  } catch (Exception $e) {
    return json_encode(array('result' => 'Error: ' . $e->getMessage()));
  }
}

// Llamar a la función para datos por cURL y obtener la respuesta en formato JSON
echo vpc_ChangePassword($params);
/*-------------------------------------------------------------- 
## FIN FUNCION CURL ACTUALIZADA con $params
----------------------------------------------------------------*/

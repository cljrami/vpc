<?php
// if (!defined("WHMCS")) {
//     die("This file cannot be accessed directly");
// }
// Función para obtener los datos de Metadata
// Función para obtener los datos de Metadata
function vpc_ChangePassword_MetaData()
{
    return array(
        'DisplayName' => 'XHVPC_ChangePassword',
        'APIVersion' => '1.1',
        'RequiresServer' => false,
        'DefaultNonSSLPort' => '5985',
        'DefaultSSLPort' => '5986',
    );
}

// Función para configurar las opciones del módulo
function vpc_ChangePassword_ConfigOptions()
{
    return array(
        'FriendlyName' => array(
            'Type' => 'System',
            'Value' => 'vpc_ChangePassword_Module',
        ),
    );
}

// Función para realizar la solicitud cURL
function vpc_ChangePassword($params)
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
            echo "La función cURL no está disponible en este servidor.";
            return;
        }

        // URL de destino
        $url = 'https://vps06.xhost.cl/prueba_whmcs/vpc_ChangePassword_bk.php';

        // Verificar si la URL de destino es válida
        if (!$url) {
            echo "La URL de destino no es válida.";
            return;
        }

        // Inicializar la sesión cURL


        $postdata = http_build_query($postvars);

        $curl = curl_init();
        // Configurar las opciones de cURL
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postvars);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);

        // Ejecutar la petición cURL y obtener la respuesta
        $response = curl_exec($curl);

        // Verificar si la petición tuvo éxito
        if ($response === false) {
            echo 'La acción cURL falló: ' . curl_error($curl);
        } else {
            echo 'La acción cURL se realizó correctamente.';

            // Imprimir los resultados de las validaciones hechas en el servidor remoto
            echo $response;

            // Añadir un registro en la consola del navegador con los parámetros enviados
            echo '<script>';
            echo 'console.log("Parámetros enviados por cURL:", ' . json_encode($postvars) . ');';
            echo '</script>';
        }

        // Cerrar la conexión cURL
        curl_close($curl);
    } catch (Exception $e) {
        logModuleCall(
            'vpc',
            __FUNCTION__,
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );
        return $e->getMessage();
    }
}

// Obtener los parámetros de WHMCS
$params = $_REQUEST;

// Llamar a la función para realizar la solicitud cURL
vpc_ChangePassword($params);

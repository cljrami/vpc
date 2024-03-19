<?php
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
    // Definir los parámetros para la solicitud cURL
    $postvars = array(
        'username' => $params['serverusername'],
        'passwd' => $params['passwordserver'],
        'domain' => $params['domain'],
        'user' => $params['user'],
        'pass' => $params['pass'],
    );

    // Inicializar la sesión cURL
    $curl = curl_init();

    // URL de destino
    $url = 'https://vps06.xhost.cl/prueba_whmcs/vpc_ChangePassword_bk.php';

    // Configurar las opciones de cURL
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postvars);

    // Ejecutar la petición cURL y obtener la respuesta
    $responseText = curl_exec($curl);

    // Verificar si la petición tuvo éxito
    if ($responseText === false) {
        $response = array(
            'status' => 'error',
            'message' => 'La acción cURL falló: ' . curl_error($curl)
        );
    } else {
        // Decodificar la respuesta JSON de la solicitud cURL
        $responseData = json_decode($responseText, true);

        // Comprobar si la respuesta contiene el campo "result"
        if (isset($responseData['result'])) {
            $response = array(
                'status' => 'success',
                'message' => 'La acción fue exitosa: ' . $responseData['result']
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'La respuesta no contiene el campo "result"'
            );
        }
    }

    // Cerrar la conexión cURL
    curl_close($curl);

    // Convertir la respuesta a formato JSON
    echo json_encode($response);
}

// Obtener los parámetros de WHMCS
$params = $_REQUEST;

// Llamar a la función para realizar la solicitud cURL
vpc_ChangePassword($params);

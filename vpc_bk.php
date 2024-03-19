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
        'APIVersion' => '1.1', // Usar la versión de API 1.1
        'RequiresServer' => false, // Establecer en true si el módulo requiere un servidor para funcionar
        'DefaultNonSSLPort' => '5985', // Puerto de conexión no SSL por defecto
        'DefaultSSLPort' => '5986', // Puerto de conexión SSL por defecto
    );
}
/*-------------------------------------------------------------- 
## FIN FUNCION NETADATA 
----------------------------------------------------------------*/

/*-------------------------------------------------------------- 
## CONFIGURACION DEL MODULO 
----------------------------------------------------------------*/
function vpc_ChangePassword_ConfigOptions()
{
    return array(
        'FriendlyName' => array(
            'Type' => 'System',
            'Value' => 'vpc_ChangePassword_Module',
        ),
    );
}
/*-------------------------------------------------------------- 
## FIN CONFIGURACION DEL MODULO 
----------------------------------------------------------------*/

/*-------------------------------------------------------------- 
## FUNCION CURL ACTUALIZADA con $params
----------------------------------------------------------------*/
$params = array(
    'serverusername' => "olson",
    'passwordserver' => "123",
    'domain' => "192.168.5.125",
    'user' => "123",
    'pass' => "123456789"
);

$response = array(); // Inicializar la variable $response como un array vacío

function vpc_ChangePassword(array $params)
{
    global $response; // Usar la variable global $response dentro de la función

    try {
        $postvars =
            array(
                'username' => $params['serverusername'],
                'passwd' => $params['passwordserver'],
                'domain' => $params['domain'],
                'user' => $params['user'],
                'pass' => $params['pass'],

            );

        // Verificar si la función cURL está disponible en este servidor
        if (!is_callable('curl_exec')) {
            $response = array(
                'status' => 'error',
                'message' => 'La función cURL no está disponible en este servidor.'
            );
        } else {
            // URL de destino
            $url = 'https://vps06.xhost.cl/prueba_whmcs/vpc_ChangePassword_bk.php';

            // Verificar si la URL de destino es válida
            if (!$url) {
                $response = array(
                    'status' => 'error',
                    'message' => 'La URL de destino no es válida.'
                );
            } else {
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
                $responseText = curl_exec($curl);

                // Verificar si la petición tuvo éxito
                if ($responseText === false) {
                    $response = array(
                        'status' => 'error',
                        'message' => 'La acción cURL falló: ' . curl_error($curl)
                    );
                } else {
                    // Cerrar la conexión cURL
                    curl_close($curl);

                    // Decodificar la respuesta JSON de la solicitud cURL
                    $responseData = json_decode($responseText, true);

                    // Guardar la respuesta JSON en un archivo de manera estructurada
                    $filename = 'response.json';
                    file_put_contents($filename, json_encode($responseData, JSON_PRETTY_PRINT));

                    // Depuración: Imprimir la respuesta de cURL
                    echo $responseText;
                }
            }
        }
    } catch (Exception $e) {
        $response = array(
            'status' => 'error',
            'message' => $e->getMessage()
        );
    }

    // Convertir la respuesta a formato JSON
    echo json_encode($response);
}

// Llamar a la función para datos por cURL
vpc_ChangePassword($params);

//ok

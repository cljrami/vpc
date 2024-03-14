<?php

// URL de la API de Mindicador.cl
$url_api = 'https://mindicador.cl/api';

// Realizar la solicitud GET a la API
$response = file_get_contents($url_api);

// Verificar si hubo un error al realizar la solicitud
if ($response === false) {
    die("Error al conectar con la API.\n");
}

// Decodificar la respuesta JSON
$data = json_decode($response, true);

// Verificar si la respuesta es válida
if (!$data || !isset($data['indicadores'])) {
    die("Error al obtener los índices desde la API.\n");
}

// Obtener todos los índices disponibles
$indices = $data['indicadores'];

// Mostrar los índices
echo "Índices disponibles:\n";
foreach ($indices as $indice) {
    echo "- {$indice['nombre']} ({$indice['unidad_medida']})\n";
}

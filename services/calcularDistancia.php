<?php
function obtenerDistancia($origen, $destino) {
    require('geocodificar.php');
    $coord_origen = geocodificar($origen);
    $coord_destino = geocodificar($destino);
    if ($coord_origen === null || $coord_destino === null) {
        return "No se pudieron obtener las coordenadas de las ubicaciones.";
    }

    $apiKey = getenv('API_KEY'); 
    $url = "https://api.openrouteservice.org/v2/directions/driving-car?start={$coord_origen['lon']},{$coord_origen['lat']}&end={$coord_destino['lon']},{$coord_destino['lat']}";

    $options = [
        "http" => [
            "header" => [
                "Authorization: $apiKey",
                "Content-Type: application/json"
            ],
            "method" => "GET"
        ]
    ];
    $context = stream_context_create($options);
    $respuesta = file_get_contents($url, false, $context);
    // print_r($respuesta);
    // Verificar si la solicitud fue exitosa

    if ($respuesta === false) {
        return "Error: No se pudo conectar a la API.";
    }

    $datos = json_decode($respuesta, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        return "Error al decodificar la respuesta JSON: " . json_last_error_msg();
    }

    // Verificar si la respuesta contiene rutas y la estructura esperada
    if (isset($datos['features'][0]['properties']['segments'][0]['distance'])) {
        $distancia = $datos['features'][0]['properties']['segments'][0]['distance']; // Distancia en metros
        return $distancia / 1000; // Convertir a kilómetros
    } else {
        return "Error al obtener la distancia.";
    }
}

?>
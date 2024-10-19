
<?php
function geocodificar($nombreUbicacion) {
    $url = 'https://nominatim.openstreetmap.org/search?q=' . urlencode($nombreUbicacion) . '&format=json';
    
    // Crear un contexto de stream con un encabezado User-Agent
    $context = stream_context_create([
        'http' => [
            'header' => 'User-Agent: MiAplicacion/1.0' // Cambia esto por un identificador adecuado para tu aplicación
        ]
    ]);
    
    $respuesta = file_get_contents($url, false, $context);
    $datos = json_decode($respuesta, true);
    
    if (!empty($datos)) {
        return [
            'lat' => $datos[0]['lat'],
            'lon' => $datos[0]['lon'],
        ];
    } else {
        return null;
    }
}
?>
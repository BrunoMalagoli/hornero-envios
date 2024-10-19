<?php
function verificarVariableEntorno(){
    // Acceder a la variable de entorno
    $mapsKey = getenv('MAPS_KEY');
    
    if ($mapsKey) {
        echo 'Tu clave de Maps es: ' . $mapsKey;
    } else {
        echo 'MAPS_KEY no está definida';
    }

}

?>
<?php

    function calculo_Envio($envio){

        $precio = $envio["peso"]*2 + $envio["ancho"]*2 +$envio["largo"]*2 +$envio["alto"]*2;
        return $precio;
    }
?>
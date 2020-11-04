<?php

$arrayRuters = explode("/", $_SERVER['REQUEST_URI']);
echo json_encode(array_filter($arrayRuters));

if (count(array_filter($arrayRuters)) <= 0) {
    /*
        Cuando no hay ninguna ruta especifica en la peticion
        me devuelve un array vacio gracias a que se lo filtra 
        con array filter
        {
            0 -> ruta
            1 -> rutae
        }
    */
    $json = array(
        "detalle" => "no encontrado"
    );
    echo json_encode($json, true);
} else {

    if (count(array_filter($arrayRuters)) == 3) {
        /*
        Cuando se hace peticiones de las lineas de produccion api-produccion.com/lineas
        */
        if (array_filter($arrayRuters)[3] == "lineas") {
            if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                $Objetolineas = new ControladorLineas();
                $Objetolineas->index();
            }
        }
    }
}

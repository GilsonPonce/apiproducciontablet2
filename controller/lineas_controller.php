<?php

class ControladorLineas
{
    /**
     * crear una linea
     */
    public function create()
    {
    }

    /*
     mostrar todos las lineas
     */
    public function index()
    {
        $lineas = ModelosLineas::index("linea");
        $json = array(
            "status" => 200,
            "total_registro" => count($lineas),
            "detalle" => $lineas
        );
        echo json_encode($json, true);
    }
}

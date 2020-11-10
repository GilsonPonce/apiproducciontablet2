<?php

class ControladorLineas
{
    /*================
     * crear una linea
     =================*/
    public function create($datos)
    {
        if(isset($datos['nombre']) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $datos["nombre"])){
            $json = array(

				"status"=>404,
				"detalle"=>"Error"
			);

			echo json_encode($json, true);

			return; 
        }

        /*================================
        validar credenciales del cliente
        ==================================*/
        


    }

    /*========================
     mostrar todos las lineas
     =========================*/
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

<?php
class ControladorOrden
{


    public function index()
    {
        $usuario = ModeloUsuario::index("usuario");
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            foreach ($usuario as $key => $valueUsuario) {
                if (
                    "Basic " . base64_encode($_SERVER['PHP_AUTH_USER'] . ":" . $_SERVER['PHP_AUTH_PW']) ==
                    "Basic " . base64_encode($valueUsuario["llave"] . ":" . $valueUsuario["codigo"])
                ) {
                    $orden = ModeloOrden::index("orden");
                    $json = array(
                        "status" => 200,
                        "total_registro" => count($orden),
                        "detalle" => $orden
                    );
                    echo json_encode($json, true);
                }
            }
        }
    }

    public function show($id)
    {
        $usuario = ModeloUsuario::index("usuario");
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            foreach ($usuario as $key => $valueUsuario) {
                if (
                    "Basic " . base64_encode($_SERVER['PHP_AUTH_USER'] . ":" . $_SERVER['PHP_AUTH_PW']) ==
                    "Basic " . base64_encode($valueUsuario["llave"] . ":" . $valueUsuario["codigo"])
                ) {
                    $Orden = ModeloOrden::show("orden",$id);
                    $json = array(
                        "status" => 200,
                        "total_registro" => count($Orden),
                        "detalle" => $Orden
                    );
                    echo json_encode($json, true);
                }else{
                    $json = array(

                        "status" => 404,
                        "detalle" => "No Autorizado"
                    );

                    echo json_encode($json, true);

                    return;
                }
            }
        }else{
            $json = array(

                "status" => 404,
                "detalle" => "No Autorizado"
            );

            echo json_encode($json, true);

            return;
        }
    }

    public function create($datos)
    {

        if ( isset($datos['orden_codigo'])  && !is_numeric($datos['orden_codigo']) ){ 
            $json = array(

                "status" => 404,
                "detalle" => "Error codigo"
            );

            echo json_encode($json, true);

            return;
        }

        if ( isset($datos['hora_peso']) && !is_numeric($datos['hora_peso']) ) {
            $json = array(

                "status" => 404,
                "detalle" => "Error hora peso"
            );

            echo json_encode($json, true);

            return;
        }

        if (isset($datos['peso_producir']) && !is_numeric($datos['peso_producir']) ) {
            $json = array(

                "status" => 404,
                "detalle" => "Error peso"
            );

            echo json_encode($json, true);

            return;
        }

        if ( isset($datos['id_tipo_material']) && !is_numeric($datos['id_tipo_material']) ) {
            $json = array(

                "status" => 404,
                "detalle" => "Error tipo material"
            );

            echo json_encode($json, true);

            return;
        }

        if (isset($datos['id_color']) && !is_numeric($datos['id_color']) ) {
            $json = array(

                "status" => 404,
                "detalle" => "Error color"
            );

            echo json_encode($json, true);

            return;
        }

        if (isset($datos['id_proceso']) && !is_numeric($datos['id_proceso'])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error proceso"
            );

            echo json_encode($json, true);

            return;
        }

        if ( isset($datos['id_estado_orden']) &&  !is_numeric($datos['id_estado_orden'])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error estado orden"
            );

            echo json_encode($json, true);

            return;
        }

        $buscarOrden = ModeloOrden::index("orden");
        foreach($buscarOrden as $key => $valueOrden){
            if($valueOrden['orden_codigo'] == $datos['orden_codigo']){
                $json = array(

                    "status" => 404,
                    "detalle" => "Error"
                );
    
                echo json_encode($json, true);
    
                return;
            }
        }

        $datos = array(
            "orden_codigo" => $datos['orden_codigo'],
            "hora_peso" => $datos['hora_peso'],
            "peso_producir" => $datos['peso_producir'],
            "id_tipo_material" => $datos['id_tipo_material'],
            "id_color" => $datos['id_color'],
            "id_proceso" => $datos['id_proceso'],
            "id_estado_orden" => $datos['id_estado_orden']
        );

        $usuario = ModeloUsuario::index("usuario");
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            foreach ($usuario as $key => $valueUsuario) {
                if (
                    "Basic " . base64_encode($_SERVER['PHP_AUTH_USER'] . ":" . $_SERVER['PHP_AUTH_PW']) ==
                    "Basic " . base64_encode($valueUsuario["llave"] . ":" . $valueUsuario["codigo"])
                ) {
                    $create = ModeloOrden::create("orden", $datos);

                    if ($create == 'ok') {
                        $json = array(

                            "status" => 200,
                            "detalle" => "Registro exitoso de orden"
                        );

                        echo json_encode($json, true);

                        return;
                    }
                }
            }
        }
    }

    public function update($id,$datos){

        $usuario = ModeloUsuario::index("usuario");
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            foreach ($usuario as $key => $valueUsuario) {
                if (
                    "Basic " . base64_encode($_SERVER['PHP_AUTH_USER'] . ":" . $_SERVER['PHP_AUTH_PW']) ==
                    "Basic " . base64_encode($valueUsuario["llave"] . ":" . $valueUsuario["codigo"])
                ) {

                    /*=============================================
					Validar datos
					=============================================*/

					foreach ($datos as $key => $valueDatos) {

						if(isset($valueDatos) && !preg_match('/^[(\\)\\=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $valueDatos)){

							$json = array(

								"status"=>404,
								"detalle"=>"Error en el campo ".$key

							);

							echo json_encode($json, true);

							return;
						}

                    }

                    /*=============================================
					Validar id creador
					=============================================*/

                    
                    $color = ModeloOrden::show("orden", $id);

                    if (!empty($color)) {

                        $update = ModeloOrden::update("orden",$datos);

                        if($update == 'ok'){
                            
                            $json = array(

                                "status" => 200,
                                "detalle" => "Actualizacion exitosa de orden"
                            );
    
                            echo json_encode($json, true);
    
                            return;
                        }else{
                            $json = array(

                                "status" => 404,
                                "detalle" => "No se pudo actualizar"
                            );
    
                            echo json_encode($json, true);
    
                            return;
                        }
                    }else{
                        $json = array(

                            "status" => 404,
                            "detalle" => "No se pudo actualizar"
                        );

                        echo json_encode($json, true);

                        return;
                    }
                }else{
                    $json = array(

                        "status" => 404,
                        "detalle" => "No Autorizado"
                    );
        
                    echo json_encode($json, true);
        
                    return; 
                }
            }
        }else{
            $json = array(

                "status" => 404,
                "detalle" => "No Autorizado"
            );

            echo json_encode($json, true);

            return;
        }
    }

    public function delete($id)
    {

        $usuario = ModeloUsuario::index("usuario");

        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            foreach ($usuario as $key => $valueUsuario) {
                if (
                    "Basic " . base64_encode($_SERVER['PHP_AUTH_USER'] . ":" . $_SERVER['PHP_AUTH_PW']) ==
                    "Basic " . base64_encode($valueUsuario["llave"] . ":" . $valueUsuario["codigo"])
                ) {
                    $area = ModeloOrden::show('orden', $id);

                    if (!empty($area)) {

                        $delete = ModeloOrden::delete("orden", $id);

                        if ($delete == 'ok') {
                            $json = array(
                                "status" => 200,
                                "detalle" => "Eliminacion exitosa de orden"
                            );

                            echo json_encode($json, true);

                            return;
                        } else {
                            $json = array(
                                "status" => 404,
                                "detalle" => "No se pudo eliminar"

                            );

                            echo json_encode($json, true);

                            return;
                        }
                    }
                } else {
                    $json = array(
                        "status" => 404,
                        "detalle" => "No Autorizado"

                    );

                    echo json_encode($json, true);

                    return;
                }
            }
        } else {
            $json = array(
                "status" => 404,
                "detalle" => "No Autorizado"

            );

            echo json_encode($json, true);

            return;
        }
    }
}

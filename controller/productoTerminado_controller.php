<?php
class ControladorProductoTerminado
{


    public function index()
    {
        $usuario = ModeloUsuario::index("usuario");
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            foreach ($usuario as $key => $valueUsuario) {
                if (
                    "Basic " . base64_encode($_SERVER['PHP_AUTH_USER'] . ":" . $_SERVER['PHP_AUTH_PW']) ==
                    "Basic " . base64_encode($valueUsuario["padlock"] . ":" . $valueUsuario["keylock"])
                ) {
                    $productoterminado = ModeloProductoTerminado::index("productoterminado");
                    $json = array(
                        "status" => 200,
                        "total_registro" => count($productoterminado),
                        "detalle" => $productoterminado
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
                    "Basic " . base64_encode($valueUsuario["padlock"] . ":" . $valueUsuario["keylock"])
                ) {
                    $productoterminado = ModeloProductoTerminado::show("productoterminado",$id);
                    $json = array(
                        "status" => 200,
                        "total_registro" => count($productoterminado),
                        "detalle" => $productoterminado
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

        if (isset($datos['id_informe']) &&!is_numeric($datos['id_informe'])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error en informe"
            );

            echo json_encode($json, true);

            return;
        }

        if (isset($datos['color']) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $datos["color"])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error en color"
            );

            echo json_encode($json, true);

            return;
        }
        
        if (isset($datos['peso']) && !is_numeric($datos['peso'])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error en peso"
            );

            echo json_encode($json, true);

            return;
        }

        if (isset($datos['id_proceso']) && !is_numeric($datos['id_proceso'])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error campo id proceso"
            );

            echo json_encode($json, true);

            return;
        }

        if (isset($datos['material']) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $datos["material"])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error campo material"
            );

            echo json_encode($json, true);

            return;
        }

        if (isset($datos['tipo_material']) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $datos["tipo_material"])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error tipo material"
            );

            echo json_encode($json, true);

            return;
        }

        if (isset($datos['tipo']) && !preg_match('/^[\sa-zA-ZáéíóúÁÉÍÓÚñÑ]+$/', $datos["tipo"])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error en tipo"
            );

            echo json_encode($json, true);

            return;
        }

        $id_configuracion = 0;
        $configuracion = ModeloConfiguracion::index("configuracion");
        foreach($configuracion as $key => $value){
            $val = $value["id_proceso"] == $datos["id_proceso"];
            $val1 = $value["material"] == $datos["material"];
            $val2 =  $value["tipo_material"] == $datos["tipo_material"];
            if($val && $val1 && $val2){
              $id_configuracion = $value["id_configuracion"];
              break;
            }else{
                $json = array(

                    "status" => 404,
                    "detalle" => "Error en hallar configuracion"
                );
    
                echo json_encode($json, true);
    
                return;
            }
        }


        $datos = array(
            "id_informe" => $datos['id_informe'],
            "color" => $datos['color'],
            "peso" => $datos['peso'], 
            "id_configuracion" => $id_configuracion,
            "tipo" => $datos['tipo']
        );


        $usuario = ModeloUsuario::index("usuario");
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            foreach ($usuario as $key => $valueUsuario) {
                if (
                    "Basic " . base64_encode($_SERVER['PHP_AUTH_USER'] . ":" . $_SERVER['PHP_AUTH_PW']) ==
                    "Basic " . base64_encode($valueUsuario["padlock"] . ":" . $valueUsuario["keylock"])
                ) {
                    $create = ModeloProductoTerminado::create("productoterminado", $datos);

                    if ($create == 'ok') {
                        $json = array(

                            "status" => 200,
                            "detalle" => "Registro exitoso de producto terminado"
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
                    "Basic " . base64_encode($valueUsuario["padlock"] . ":" . $valueUsuario["keylock"])
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

                    
                    $tipodesperdicio = ModeloProductoTerminado::show("productoterminado", $id);

                    if (!empty($tipodesperdicio)) {

                        $update = ModeloProductoTerminado::update("productoterminado",$datos);

                        if($update == 'ok'){
                            
                            $json = array(

                                "status" => 200,
                                "detalle" => "Registro exitoso de producto terminado"
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
                    "Basic " . base64_encode($valueUsuario["padlock"] . ":" . $valueUsuario["keylock"])
                ) {
                    $tipodesperdicio = ModeloProductoTerminado::show('productoterminado', $id);

                    if (!empty($tipodesperdicio)) {

                        $delete = ModeloProductoTerminado::delete("productoterminado", $id);

                        if ($delete == 'ok') {
                            $json = array(
                                "status" => 200,
                                "detalle" => "Eliminacion exitosa de producto terminado"
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
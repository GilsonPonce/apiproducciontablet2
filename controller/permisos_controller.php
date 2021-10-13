<?php
class ControladorPermisos
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
                    $permisos = ModeloPermisos::index("permisos");
                    $json = array(
                        "status" => 200,
                        "total_registro" => count($permisos),
                        "detalle" => $permisos
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
                    $permisos = ModeloProceso::show("permisos",$id);
                    $json = array(
                        "status" => 200,
                        "total_registro" => count($permisos),
                        "detalle" => $permisos
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

        if (isset($datos['nombre_pestaña']) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+$/', $datos["nombre_pestaña"])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error"
            );

            echo json_encode($json, true);

            return;
        }

        if (isset($datos['id_usuario']) && !is_numeric($datos['id_usuario'])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error"
            );

            echo json_encode($json, true);

            return;
        }

        $datos = array(
            "nombre_pestaña" => $datos['nombre_pestaña'],
            "id_usuario" => $datos['id_usuario']//recibo el numero de id
        );

        $usuario = ModeloUsuario::index("usuario");
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            foreach ($usuario as $key => $valueUsuario) {
                if (
                    "Basic " . base64_encode($_SERVER['PHP_AUTH_USER'] . ":" . $_SERVER['PHP_AUTH_PW']) ==
                    "Basic " . base64_encode($valueUsuario["padlock"] . ":" . $valueUsuario["keylock"])
                ) {
                    $create = ModeloPermisos::create("permisos", $datos);

                    if ($create == 'ok') {
                        $json = array(

                            "status" => 200,
                            "detalle" => "Registro exitoso de permisos"
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

                    
                    $proceso = ModeloPermisos::show("permisos", $id);

                    if (!empty($proceso)) {

                        $update = ModeloPermisos::update("permisos",$datos);

                        if($update == 'ok'){
                            
                            $json = array(

                                "status" => 200,
                                "detalle" => "Actualizacion exitoso de permisos"
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
                    $area = ModeloPermisos::show('permisos', $id);

                    if (!empty($area)) {

                        $delete = ModeloPermisos::delete("permisos", $id);

                        if ($delete == 'ok') {
                            $json = array(
                                "status" => 200,
                                "detalle" => "Eliminacion exitosa del permiso"
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

<?php
class ControladorScrap
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
                    $scrap = ModeloScrap::index("scrap");
                    $json = array(
                        "status" => 200,
                        "total_registro" => count($scrap),
                        "detalle" => $scrap
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
                    $scrap = ModeloScrap::show("scrap",$id);
                    $json = array(
                        "status" => 200,
                        "total_registro" => count($scrap),
                        "detalle" => $scrap
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

        if (isset($datos['id_scrap']) &&!is_numeric($datos['id_scrap'])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error en scrap"
            );

            echo json_encode($json, true);

            return;
        }

        if (isset($datos['peso']) &&!is_numeric($datos['peso'])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error en peso"
            );

            echo json_encode($json, true);

            return;
        }

        if (isset($datos['id_informe']) &&!is_numeric($datos['id_informe'])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error en informe"
            );

            echo json_encode($json, true);

            return;
        }
        
        if (isset($datos['motivo']) && $datos['motivo'] != "" &&!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $datos["motivo"])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error en motivo"
            );

            echo json_encode($json, true);

            return;
        }

        if (isset($datos['sacos']) && $datos['sacos'] != "" && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $datos["sacos"])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error en sacos"
            );

            echo json_encode($json, true);

            return;
        }


        $datos = array(
            "id_scrap" => $datos['id_scrap'],
            "motivo" => $datos['motivo'],
            "sacos" => $datos['sacos'],
            "peso" => $datos['peso'],
            "id_informe" => $datos['id_informe']
        );


        $usuario = ModeloUsuario::index("usuario");
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            foreach ($usuario as $key => $valueUsuario) {
                if (
                    "Basic " . base64_encode($_SERVER['PHP_AUTH_USER'] . ":" . $_SERVER['PHP_AUTH_PW']) ==
                    "Basic " . base64_encode($valueUsuario["padlock"] . ":" . $valueUsuario["keylock"])
                ) {
                    $create = ModeloScrap::create("scrap", $datos);

                    if ($create == 'ok') {
                        $json = array(

                            "status" => 200,
                            "detalle" => "Registro exitoso de scrap"
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

                    
                    $tipodesperdicio = ModeloScrap::show("scrap", $id);

                    if (!empty($tipodesperdicio)) {

                        $update = ModeloScrap::update("scrap",$datos);

                        if($update == 'ok'){
                            
                            $json = array(

                                "status" => 200,
                                "detalle" => "Registro exitoso de scrap"
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
                    $tipodesperdicio = ModeloScrap::show('scrap', $id);

                    if (!empty($tipodesperdicio)) {

                        $delete = ModeloScrap::delete("scrap", $id);

                        if ($delete == 'ok') {
                            $json = array(
                                "status" => 200,
                                "detalle" => "Eliminacion exitosa de scrap"
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
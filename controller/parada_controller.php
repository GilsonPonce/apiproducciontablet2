<?php
class ControladorParada
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
                    $indexall = ModeloParada::index("parada");
                    if (!empty($indexall)) {
                        $json = array(
                            "status" => 200,
                            "total_registro" => count($indexall),
                            "detalle" => $indexall
                        );
                        echo json_encode($json, true);
                    } else {
                        $json = array(
                            "status" => 200,
                            "total_registro" => 0,
                            "detalle" => []
                        );
                        echo json_encode($json, true);
                    }
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
                    $showonli = ModeloParada::show("parada", $id);
                    $json = array(
                        "status" => 200,
                        "total_registro" => count($showonli),
                        "detalle" => $showonli
                    );
                    echo json_encode($json, true);
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

    public function create($datos)
    {

        //valido el unico campo que ingresa el usuario
        if (isset($datos['id_informe']) && !is_numeric($datos['id_informe'])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error registro informe"
            );

            echo json_encode($json, true);

            return;
        }

        if (isset($datos['motivo']) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+$/', $datos["motivo"])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error en motivo"
            );

            echo json_encode($json, true);

            return;
        }

        $datos = array(
            "fecha_hora_inicio" => date("Y-m-d H:i:s"),
            "fecha_hora_fin" => date("Y-m-d H:i:s"),
            "id_informe" => $datos['id_informe'],
            "motivo" => $datos['motivo']
        );
    
        $usuario = ModeloUsuario::index("usuario");
  
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            foreach ($usuario as $key => $valueUsuario) {
                if (
                    "Basic " . base64_encode($_SERVER['PHP_AUTH_USER'] . ":" . $_SERVER['PHP_AUTH_PW']) ==
                    "Basic " . base64_encode($valueUsuario["padlock"] . ":" . $valueUsuario["keylock"])
                ) {
                    $create = ModeloParada::create("parada", $datos);

                    if ($create == 'ok') {
                        $json = array(

                            "status" => 200,
                            "detalle" => "Registro exitoso de parada"
                        );

                        echo json_encode($json, true);

                        return;
                    } else {
                        $json = array(

                            "status" => 404,
                            "detalle" => "Error en registro"
                        );

                        echo json_encode($json, true);

                        return;
                    }
                }
            }
        }
    }

    public function update($id, $datos)
    {

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

                        if (isset($valueDatos) && !preg_match('/^[(\\)\\=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $valueDatos)) {

                            $json = array(

                                "status" => 404,
                                "detalle" => "Error en el campo " . $key

                            );

                            echo json_encode($json, true);

                            return;
                        }
                    }


                    $registro1 = ModeloParada::show("parada", $id);

                    if (!empty($registro1)) {

                        $update = ModeloParada::update("parada", $datos);

                        if ($update == 'ok') {

                            $json = array(

                                "status" => 200,
                                "detalle" => "Actualizacion exitoso parada"
                            );

                            echo json_encode($json, true);

                            return;
                        } else {
                            $json = array(

                                "status" => 404,
                                "detalle" => "No se pudo actualizar"
                            );

                            echo json_encode($json, true);

                            return;
                        }
                    } else {
                        $json = array(

                            "status" => 404,
                            "detalle" => "No se pudo actualizar"
                        );

                        echo json_encode($json, true);

                        return;
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

    public function delete($id)
    {

        $usuario = ModeloUsuario::index("usuario");

        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            foreach ($usuario as $key => $valueUsuario) {
                if (
                    "Basic " . base64_encode($_SERVER['PHP_AUTH_USER'] . ":" . $_SERVER['PHP_AUTH_PW']) ==
                    "Basic " . base64_encode($valueUsuario["padlock"] . ":" . $valueUsuario["keylock"])
                ) {
                    $area = ModeloParada::show('parada', $id);

                    if (!empty($area)) {

                        $delete = ModeloParada::delete("parada", $id);

                        if ($delete == 'ok') {
                            $json = array(
                                "status" => 200,
                                "detalle" => "Eliminacion exitosa de parada"
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

<?php
class ControladorConfiguracion
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
                    $configuracion = ModeloConfiguracion::index("configuracion");
                    $json = array(
                        "status" => 200,
                        "total_registro" => count($configuracion),
                        "detalle" => $configuracion
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
                    $configuracion = ModeloConfiguracion::show("configuracion", $id);
                    $json = array(
                        "status" => 200,
                        "total_registro" => count($configuracion),
                        "detalle" => $configuracion
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


        if (isset($datos['estado']) && !is_numeric($datos['estado'])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error estado"
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

        if (isset($datos['id_material']) &&  !is_numeric($datos['id_material'])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error material"
            );

            echo json_encode($json, true);

            return;
        }

        if (isset($datos['id_tipo_material']) &&  !is_numeric($datos['id_tipo_material'])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error tipo material"
            );

            echo json_encode($json, true);

            return;
        }

        if (isset($datos['kilogramo_diario']) &&  !is_numeric($datos['kilogramo_diario'])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error kilogramo diario"
            );

            echo json_encode($json, true);

            return;
        }

        if (isset($datos['kilogramo_hora']) &&  !is_numeric($datos['kilogramo_hora'])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error kilogramo hora"
            );

            echo json_encode($json, true);

            return;
        }

        if (isset($datos['tarifa_kilogramo_producidos']) &&  !is_numeric($datos['tarifa_kilogramo_producidos'])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error tarifa kilogramos producidos"
            );

            echo json_encode($json, true);

            return;
        }

        $buscarConfiguracion = ModeloConfiguracion::index("configuracion");
        foreach ($buscarConfiguracion as $key => $valueOrden) {

            $validacion4 = $valueOrden['estado'] == $datos['estado'];
            $validacion5 = $valueOrden['id_proceso'] == $datos['id_proceso'];
            $validacion6 = $valueOrden['id_material'] == $datos['id_material'];
            $validacion7 = $valueOrden['id_tipo_material'] == $datos['id_tipo_material'];

            if ($validacion4 && $validacion5 && $validacion6 && $validacion7) {
                $json = array(

                    "status" => 404,
                    "detalle" => "Error configuracion duplicada"
                );

                echo json_encode($json, true);

                return;
            }
        }

        $datos = array(
            "kilogramo_diario" => $datos['kilogramo_diario'],
            "kilogramo_hora" => $datos['kilogramo_hora'],
            "tarifa_kilogramo_producidos" => $datos['tarifa_kilogramo_producidos'],
            "estado" => $datos['estado'],
            "id_proceso" => $datos['id_proceso'],
            "id_material" => $datos['id_material'],
            "id_tipo_material" => $datos['id_tipo_material']
        );

        $usuario = ModeloUsuario::index("usuario");
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            foreach ($usuario as $key => $valueUsuario) {
                if (
                    "Basic " . base64_encode($_SERVER['PHP_AUTH_USER'] . ":" . $_SERVER['PHP_AUTH_PW']) ==
                    "Basic " . base64_encode($valueUsuario["padlock"] . ":" . $valueUsuario["keylock"])
                ) {
                    $create = ModeloConfiguracion::create("configuracion", $datos);

                    if ($create == 'ok') {
                        $json = array(

                            "status" => 200,
                            "detalle" => "Registro exitoso de configuracion"
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

                    /*=============================================
					Validar id creador
					=============================================*/


                    $configuracion = ModeloConfiguracion::show("configuracion", $id);

                    if (!empty($configuracion)) {

                        $update = ModeloConfiguracion::update("configuracion", $datos);

                        if ($update == 'ok') {

                            $json = array(

                                "status" => 200,
                                "detalle" => "Actualizacion exitosa de configuracion"
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
                    $configuracion = ModeloConfiguracion::show('configuracion', $id);

                    if (!empty($configuracion)) {

                        $delete = ModeloConfiguracion::delete("configuracion", $id);

                        if ($delete == 'ok') {
                            $json = array(
                                "status" => 200,
                                "detalle" => "Eliminacion exitosa de configuracion"
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

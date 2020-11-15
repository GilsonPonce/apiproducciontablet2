<?php
class ControladorPeso
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
                    $orden = ModeloPeso::index("peso");
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

    public function create($datos)
    {

        if (isset($datos['numero']) && !is_numeric($datos['numero'])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error"
            );

            echo json_encode($json, true);

            return;
        }

        if (isset($datos['codigo']) && !preg_match('/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ]+$/', $datos["codigo"])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error"
            );

            echo json_encode($json, true);

            return;
        }

        if (isset($datos['cantidad']) && !is_numeric($datos['cantidad'])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error"
            );

            echo json_encode($json, true);

            return;
        }

        if (isset($datos['peso']) && !is_numeric($datos['peso'])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error"
            );

            echo json_encode($json, true);

            return;
        }

        if (isset($datos['id_informe']) && !is_numeric($datos['id_informe'])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error"
            );

            echo json_encode($json, true);

            return;
        }

        if (isset($datos['id_color']) && !is_numeric($datos['id_color'])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error"
            );

            echo json_encode($json, true);

            return;
        }

        if (isset($datos['id_tipo_material']) && !is_numeric($datos['id_tipo_material'])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error"
            );

            echo json_encode($json, true);

            return;
        }

        if (isset($datos['id_tipo_peso']) && !is_numeric($datos['id_tipo_peso'])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error"
            );

            echo json_encode($json, true);

            return;
        }

        if (isset($datos['id_personal']) && !is_numeric($datos['id_personal'])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error"
            );

            echo json_encode($json, true);

            return;
        }

        if (isset($datos['id_estado_peso']) && !is_numeric($datos['id_estado_peso'])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error"
            );

            echo json_encode($json, true);

            return;

        }

        //valida que el usuario exista
        $validacion = false;
        $personal = ModeloPersonal::index("personal");
        foreach ($personal as $id => $valor) {
            if ($valor["id_personal"] == $datos['id_personal']) {
                $validacion = true;
            }
        }

        //validar otras tareas en ejecucion del personal para finalizarla
        if ($validacion) {
            $datosenv = array(
                "numero" => $datos['numero'],
                "cantidad" => $datos['cantidad'],
                "peso" => $datos['peso'],
                "id_informe" => $datos['id_informe'],
                "id_color" => $datos['id_color'],
                "id_tipo_material" => $datos['id_tipo_material'],
                "id_tipo_peso" => $datos['id_tipo_peso'],
                "id_personal" => $datos['id_personal'],
                "id_estado_peso" => $datos['id_estado_peso']
            );
            $usuario = ModeloUsuario::index("usuario");
            if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
                foreach ($usuario as $key => $valueUsuario) {
                    if (
                        "Basic " . base64_encode($_SERVER['PHP_AUTH_USER'] . ":" . $_SERVER['PHP_AUTH_PW']) ==
                        "Basic " . base64_encode($valueUsuario["llave"] . ":" . $valueUsuario["codigo"])
                    ) {
                        $create = ModeloPeso::create("peso", $datosenv);

                        if ($create == 'ok') {
                            $json = array(

                                "status" => 200,
                                "detalle" => "Registro exitoso de peso" 
                            );

                            echo json_encode($json, true);

                            return;
                        } else {
                            $json = array(

                                "status" => 404,
                                "detalle" => "Error"
                            );

                            echo json_encode($json, true);

                            return;
                        }
                    }
                }
            }
        } else {
            $json = array(

                "status" => 404,
                "detalle" => "Error"
            );

            echo json_encode($json, true);

            return;
        }
    }
}

<?php

class ControladorLineas
{
    /*================
     * crear una linea
     =================*/
    public function create($datos)
    {
        if (isset($datos['nombre']) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $datos["nombre"])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error"
            );

            echo json_encode($json, true);

            return;
        }

        $datos = array(
            "nombre" => $datos['nombre']
        );
        /*================================
        validar credenciales del cliente
        ==================================*/
        $usuario = ModeloUsuario::index("usuario");
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            foreach ($usuario as $key => $valueUsuario) {
                if (
                    "Basic " . base64_encode($_SERVER['PHP_AUTH_USER'] . ":" . $_SERVER['PHP_AUTH_PW']) ==
                    "Basic " . base64_encode($valueUsuario["llave"] . ":" . $valueUsuario["codigo"])
                ) {

                    $create = ModelosLineas::create("linea", $datos);

                    if ($create == 'ok') {
                        $json = array(

                            "status" => 200,
                            "detalle" => "Registro exitoso de linea"
                        );

                        echo json_encode($json, true);

                        return;
                    }
                }
            }
        }
    }

    /*========================
     mostrar todos las lineas
     =========================*/
    public function index()
    {
        $usuario = ModeloUsuario::index("usuario");
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            foreach ($usuario as $key => $valueUsuario) {
                if (
                    "Basic " . base64_encode($_SERVER['PHP_AUTH_USER'] . ":" . $_SERVER['PHP_AUTH_PW']) ==
                    "Basic " . base64_encode($valueUsuario["llave"] . ":" . $valueUsuario["codigo"])
                ) {
                    $lineas = ModelosLineas::index("linea");
                    $json = array(
                        "status" => 200,
                        "total_registro" => count($lineas),
                        "detalle" => $lineas
                    );
                    echo json_encode($json, true);
                }
            }
        }
    }
}

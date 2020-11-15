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
                    "Basic " . base64_encode($valueUsuario["llave"] . ":" . $valueUsuario["codigo"])
                ) {
                    $orden = ModeloPersonal::index("parada");
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

        //valido el unico campo que ingresa el usuario
        if (isset($datos['id_personal']) && !is_numeric($datos['id_personal'])) {
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

        if ($validacion) {
            
            $datosenv = array(
                "fecha_hora_inicio" => date('Y-m-d h:i:s'),
                "fecha_hora_fin" => date('Y-m-d h:i:s'),
                "id_motivo" => $datos['id_motivo'],
                "id_personal" => $datos['id_personal']
            );

            $usuario = ModeloUsuario::index("usuario");
            if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
                foreach ($usuario as $key => $valueUsuario) {
                    if (
                        "Basic " . base64_encode($_SERVER['PHP_AUTH_USER'] . ":" . $_SERVER['PHP_AUTH_PW']) ==
                        "Basic " . base64_encode($valueUsuario["llave"] . ":" . $valueUsuario["codigo"])
                    ) {
                        $create = ModeloPersonal::create("parada", $datosenv);

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
                                "detalle" => "Error"
                            );

                            echo json_encode($json, true);

                            return;
                        }
                    }
                }
            }
        }else{
            $json = array(

                "status" => 404,
                "detalle" => "Error"
            );

            echo json_encode($json, true);

            return;
        }
    }
}

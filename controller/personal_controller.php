<?php
class ControladorPersonal
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
                    $orden = ModeloPersonal::index("personal");
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
        if (isset($datos['cedula']) && !is_numeric($datos['cedula'])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error"
            );

            echo json_encode($json, true);

            return;
        }

        if (isset($datos['id_tipo_personal']) && !is_numeric($datos['id_tipo_personal'])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error"
            );

            echo json_encode($json, true);

            return;
        }

        if (isset($datos['id_area_trabajo']) && !is_numeric($datos['id_area_trabajo'])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error"
            );

            echo json_encode($json, true);

            return;
        }

        if (isset($datos['nombre']) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+$/', $datos["nombre"])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error"
            );

            echo json_encode($json, true);

            return;
        }

        if (isset($datos['apellido']) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+$/', $datos["apellido"])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error"
            );

            echo json_encode($json, true);

            return;
        }

        //validamos usuario repetidos
        $personal = ModeloPersonal::index("personal");
        foreach($personal as $indice => $valor){    
            if($valor['cedula'] == $datos['cedula']){
                $json = array(

                    "status" => 404,
                    "detalle" => "Error de personal"
                );
    
                echo json_encode($json, true);
    
                return;
            }
        }

        $datos = array(
            "nombre" => $datos['nombre'],
            "apellido" => $datos['apellido'],
            "cedula" => $datos['cedula'],
            "id_tipo_personal" => $datos['id_tipo_personal'],
            "id_area_trabajo" => $datos['id_area_trabajo']
        );

        $usuario = ModeloUsuario::index("usuario");
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            foreach ($usuario as $key => $valueUsuario) {
                if (
                    "Basic " . base64_encode($_SERVER['PHP_AUTH_USER'] . ":" . $_SERVER['PHP_AUTH_PW']) ==
                    "Basic " . base64_encode($valueUsuario["llave"] . ":" . $valueUsuario["codigo"])
                ) {
                    $create = ModeloPersonal::create("personal", $datos);

                    if ($create == 'ok') {
                        $json = array(

                            "status" => 200,
                            "detalle" => "Registro exitoso de personal"
                        );

                        echo json_encode($json, true);

                        return;
                    } else {
                        $json = array(

                            "status" => 404,
                            "detalle" => "Error de personal"
                        );

                        echo json_encode($json, true);

                        return;
                    }
                }
            }
        }
    }
}

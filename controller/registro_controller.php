<?php
class ControladorRegistro
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
                    $orden = ModeloRegistro::index("registro");
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

        //validar otras tareas en ejecucion del personal para finalizarla
        if ($validacion) {
            $activo = '';
            $inactivo = '';
            $estadosregistro = ModeloEstadoRegistro::index("estado_registro");
            foreach ($estadosregistro as $i => $a) {
                if ($a['nombre'] == 'activo') {
                    $activo = $a['id_estado_registro'];
                } else if ($a['nombre'] == 'inactivo') {
                    $inactivo = $a['id_estado_registro'];
                }else{
                    $json = array(

                        "status" => 404,
                        "detalle" => "Error"
                    );
        
                    echo json_encode($json, true);
        
                    return;
                }
            }
            $registros = ModeloRegistro::index("registro");
            foreach ($registros as $clave => $valor2) {
                if ($valor2['id_personal'] == $datos['id_personal'] && $valor2['id_estado_registro'] == $activo) {
                    $datosac = array(
                        "fecha_hora_fin" => date('Y-m-d h:i:s'),//lo que realmente se actualiza
                        "fecha_hora_inicio" => $valor2['fecha_hora_inicio'],
                        "linea" => $valor2['linea'],
                        "proceso" => $valor2['proceso'],
                        "id_personal" => $valor2['id_personal'],
                        "orden_codigo" => $valor2['orden_codigo'],
                        "id_estado_registro" => $inactivo,//lo que realmente se actualiza
                        "id_registro" => $valor2['id_registro']
                    );
                    $actualizar = ModeloRegistro::update("registro", $datosac);
                }else{
                    $actualizar = "ok";
                }
            }

            if ($actualizar == "ok") {
                $datos = array(
                    "fecha_hora_inicio" => date('Y-m-d h:i:s'),
                    "fecha_hora_fin" => date('Y-m-d h:i:s'),
                    "linea" => $datos['linea'],
                    "proceso" => $datos['proceso'],
                    "id_personal" => $datos['id_personal'],
                    "orden_codigo" => $datos['orden_codigo'],
                    "id_estado_registro" => $activo
                );
                $usuario = ModeloUsuario::index("usuario");
                if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
                    foreach ($usuario as $key => $valueUsuario) {
                        if (
                            "Basic " . base64_encode($_SERVER['PHP_AUTH_USER'] . ":" . $_SERVER['PHP_AUTH_PW']) ==
                            "Basic " . base64_encode($valueUsuario["llave"] . ":" . $valueUsuario["codigo"])
                        ) {
                            $create = ModeloTipoMaterial::create("registro", $datos);

                            if ($create == 'ok') {
                                $json = array(

                                    "status" => 200,
                                    "detalle" => "Registro exitoso de registro"
                                );

                                echo json_encode($json, true);

                                return;
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

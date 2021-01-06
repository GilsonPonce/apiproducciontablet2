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
                    if(!empty($orden)){
                        $json = array(
                            "status" => 200,
                            "total_registro" => count($orden),
                            "detalle" => $orden
                        );
                        echo json_encode($json, true);
                    }else{
                        $json = array(
                            "status" => 200,
                            "total_registro" => 0,
                            "detalle" => 'No hay registros'
                        );
                        echo json_encode($json, true);
                    }
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
                "detalle" => "Error registro id_personal"
            );

            echo json_encode($json, true);

            return;
        }

        //valida que el usuario exista
        $validacion = false;
        //print_r($validacion);
        $personal = ModeloPersonal::index("personal");
        foreach ($personal as $id => $valor) {
            if ($valor['id_personal'] == $datos['id_personal']) {
                $validacion = true;
            }
        }
        //print_r($validacion);
        //validar otras tareas en ejecucion del personal para finalizarla
        if ($validacion) {
            $activo = '';
            $inactivo = '';
            $estadosregistro = ModeloEstadoRegistro::index("estado_registro");
            foreach ($estadosregistro as $i => $a) {
                //print_r($a->nombre);
                if ($a->nombre == 'ACTIVO') {
                    $activo = $a->id_estado_registro;
                    //print_r($activo);
                } else if ($a->nombre == 'FINALIZADO') {
                    $inactivo = $a->id_estado_registro;
                }else{
                    $json = array(

                        "status" => 404,
                        "detalle" => "Error en registro estado"
                    );
        
                    echo json_encode($json, true);
        
                    return;
                }
            }
            
            $registros = ModeloRegistro::index("registro");
            //print_r($registros);
            if(!empty($registros)){
                foreach ($registros as $clave => $valor2) {
                    if ($valor2['id_personal'] == $datos['id_personal'] && $valor2['id_estado_registro'] == $activo) {
                        $datosac = array(
                            "fecha_hora_fin" => date('Y-m-d h:i:s'),//lo que realmente se actualiza
                            "fecha_hora_inicio" => $valor2['fecha_hora_inicio'],
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
            }else{
                $actualizar = "ok";
            }
            //print_r($actualizar);
            if (isset($actualizar) && $actualizar == "ok") {
                $datos = array(
                    "fecha_hora_inicio" => date('Y-m-d h:i:s'),
                    "fecha_hora_fin" => date('Y-m-d h:i:s'),
                    "id_personal" => $datos['id_personal'],
                    "orden_codigo" => $datos['orden_codigo'],
                    "id_estado_registro" => $activo
                );
                //print_r($datos);
                $usuario = ModeloUsuario::index("usuario");
                //print_r($usuario);
                if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
                    foreach ($usuario as $key => $valueUsuario) {
                        if (
                            "Basic " . base64_encode($_SERVER['PHP_AUTH_USER'] . ":" . $_SERVER['PHP_AUTH_PW']) ==
                            "Basic " . base64_encode($valueUsuario["llave"] . ":" . $valueUsuario["codigo"])
                        ) {
                            $create = ModeloRegistro::create("registro", $datos);
                            //print_r($create);
                            
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
                                    "detalle" => "Error en registro"
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
                "detalle" => "Error usuario no encontrado"
            );

            echo json_encode($json, true);

            return;
        }
    }
}

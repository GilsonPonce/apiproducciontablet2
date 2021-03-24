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
                    "Basic " . base64_encode($valueUsuario["padlock"] . ":" . $valueUsuario["keylock"])
                ) {
                    $registros = ModeloRegistro::index("registro");
                    if(!empty($registros)){
                        $json = array(
                            "status" => 200,
                            "total_registro" => count($registros),
                            "detalle" => $registros
                        );
                        echo json_encode($json, true);
                    }else{
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
                    $registro = ModeloRegistro::show("registro",$id);
                    $json = array(
                        "status" => 200,
                        "total_registro" => count($registro),
                        "detalle" => $registro
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

        //cierra en la tarea anterior
        $registros = ModeloRegistro::index("registro");
        foreach($registros as $id => $valor){
            if($valor['id_personal'] == $datos['id_personal'] && $valor['activo'] > 0){
                $datos = array(
                    "id_registro" => $valor['id_registro'],
                    "id_personal" => $valor['id_personal'],
                    "fecha_hora_inicio" => $valor['fecha_hora_inicio'],
                    "fecha_hora_fin" => date("Y-m-d H:i:s"),
                    "id_informe" => $valor['id_informe'],
                    "activo" => 0
                );
                ModeloRegistro::update("registro",$datos);
            }
        }

        //print_r($validacion);
        //validar otras tareas en ejecucion del personal para finalizarla
        if ($validacion) {
            $datos = array(
                "id_registro" => $datos['id_registro'],
                "id_personal" => $datos['id_personal'],
                "fecha_hora_inicio" => $datos['fecha_hora_inicio'],
                "fecha_hora_fin" => $datos['fecha_hora_fin'],
                "id_informe" => $datos['id_informe'],
                "activo" => 1
            );
            //print_r($datos);
            $usuario = ModeloUsuario::index("usuario");
            //print_r($usuario);
            if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
                foreach ($usuario as $key => $valueUsuario) {
                    if (
                        "Basic " . base64_encode($_SERVER['PHP_AUTH_USER'] . ":" . $_SERVER['PHP_AUTH_PW']) ==
                        "Basic " . base64_encode($valueUsuario["padlock"] . ":" . $valueUsuario["keylock"])
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
        }else{
            $json = array(

                "status" => 404,
                "detalle" => "Error usuario no encontrado"
            );

            echo json_encode($json, true);

            return;
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

                    
                    $registro1 = ModeloRegistro::show("registro", $id);

                    if (!empty($registro1)) {

                        $update = ModeloRegistro::update("registro",$datos);

                        if($update == 'ok'){
                            
                            $json = array(

                                "status" => 200,
                                "detalle" => "Actualizacion exitoso del registro"
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
                    $area = ModeloRegistro::show('registro', $id);

                    if (!empty($area)) {

                        $delete = ModeloRegistro::delete("registro", $id);

                        if ($delete == 'ok') {
                            $json = array(
                                "status" => 200,
                                "detalle" => "Eliminacion exitosa de registro"
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

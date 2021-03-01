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
                    $orden = ModeloParada::index("parada");
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

    public function show($id)
    {
        $usuario = ModeloUsuario::index("usuario");
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            foreach ($usuario as $key => $valueUsuario) {
                if (
                    "Basic " . base64_encode($_SERVER['PHP_AUTH_USER'] . ":" . $_SERVER['PHP_AUTH_PW']) ==
                    "Basic " . base64_encode($valueUsuario["llave"] . ":" . $valueUsuario["codigo"])
                ) {
                    $parada = ModeloParada::show("parada",$id);
                    $json = array(
                        "status" => 200,
                        "total_registro" => count($parada),
                        "detalle" => $parada
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
                "detalle" => "Error codigo personal"
            );

            echo json_encode($json, true);

            return;
        }

        if(!empty($datos['orden_codigo'])){
            if (isset($datos['orden_codigo']) && !is_numeric($datos['orden_codigo'])) {
                $json = array(
    
                    "status" => 404,
                    "detalle" => "Error orden codigo"
                );
    
                echo json_encode($json, true);
    
                return;
            }
        }

        if (isset($datos['id_motivo']) && !is_numeric($datos['id_motivo'])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error en motivo"
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
            
            $registro = ModeloRegistro::index("registro");
            if(!empty($registro)){
                foreach($registro as $item => $value){
                    if($value["id_personal"] == $datos["id_personal"] && $value['id_estado_registro'] == 1){
                        $datosac = array(
                            "fecha_hora_fin" => date('Y-m-d h:i:s'),//lo que realmente se actualiza
                            "fecha_hora_inicio" => $value['fecha_hora_inicio'],
                            "id_personal" => $value['id_personal'],
                            "orden_codigo" => $value['orden_codigo'],
                            "id_estado_registro" => 2,//lo que realmente se actualiza
                            "id_registro" => $value['id_registro']
                        );
                        ModeloRegistro::update("registro",$datosac);
                    }
                }
            }

            $parada = ModeloParada::index("parada");
            if(!empty($parada)){
                foreach($parada as $item => $value1){
                    if($value["id_personal"] == $datos["id_personal"] && $value1['estado'] == 1){
                        $datosac = array(
                            "id_parada" => $value1['id_parada'],
                            "orden_codigo" => $value1['orden_codigo'],
                            "fecha_hora_fin" => date('Y-m-d h:i:s'),//lo que realmente se actualiza
                            "fecha_hora_inicio" => $value1['fecha_hora_inicio'],
                            "id_personal" => $value1['id_personal'],
                            "id_motivo" => $value1['id_motivo'],
                            "estado" => 0//lo que realmente se actualiza
                        );
                        ModeloParada::update("parada",$datosac);
                    }
                }
            }


            $datosenv = array(
                "fecha_hora_inicio" => date('Y-m-d h:i:s'),
                "fecha_hora_fin" => date('Y-m-d h:i:s'),
                "id_motivo" => $datos['id_motivo'],
                "id_personal" => $datos['id_personal'],
                "orden_codigo" => $datos['orden_codigo'],
                "estado" => $datos['estado']
            );

            $usuario = ModeloUsuario::index("usuario");
            if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
                foreach ($usuario as $key => $valueUsuario) {
                    if (
                        "Basic " . base64_encode($_SERVER['PHP_AUTH_USER'] . ":" . $_SERVER['PHP_AUTH_PW']) ==
                        "Basic " . base64_encode($valueUsuario["llave"] . ":" . $valueUsuario["codigo"])
                    ) {
                        $create = ModeloParada::create("parada", $datosenv);

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

    public function update($id,$datos){

        $usuario = ModeloUsuario::index("usuario");
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            foreach ($usuario as $key => $valueUsuario) {
                if (
                    "Basic " . base64_encode($_SERVER['PHP_AUTH_USER'] . ":" . $_SERVER['PHP_AUTH_PW']) ==
                    "Basic " . base64_encode($valueUsuario["llave"] . ":" . $valueUsuario["codigo"])
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

                    if(isset($datos["estado"])&& $datos["estado"] == 0){
                        $datos["fecha_hora_fin"] =  date('Y-m-d h:i:s');
                    }

                    if(isset($datos["estado"])&& $datos["estado"] > 0){
                        $datos["fecha_hora_inicio"] =  date('Y-m-d h:i:s');
                    }

                    /*=============================================
					Validar id creador
					=============================================*/

                    
                    $color = ModeloParada::show("parada", $id);

                    if (!empty($color)) {

                        $update = ModeloParada::update("parada",$datos);

                        if($update == 'ok'){
                            
                            $json = array(

                                "status" => 200,
                                "detalle" => "Actualizacion exitoso de parada"
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
                    "Basic " . base64_encode($valueUsuario["llave"] . ":" . $valueUsuario["codigo"])
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

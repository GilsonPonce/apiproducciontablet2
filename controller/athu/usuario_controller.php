<?php

class ControladorUsuario
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
                    $orden = ModeloUsuario::index("usuario");
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
                    $usuario = ModeloUsuario::show("usuario",$id);
                    $json = array(
                        "status" => 200,
                        "total_registro" => count($usuario),
                        "detalle" => $usuario
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
        /*=============================================
		Validar nombre
		=============================================*/
        if (isset($datos['nombre']) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9]+$/', $datos["nombre"])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error nombre"
            );

            echo json_encode($json, true);

            return;
        }

        /*=============================================
		            Validar apellido
		=============================================*/
        if (isset($datos['apellido']) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $datos["apellido"])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error apellido"
            );

            echo json_encode($json, true);

            return;
        }

        /*=============================================
		            Validar cedula
		=============================================*/
        if (isset($datos['cedula']) && !is_numeric($datos['cedula'])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error cedula"
            );

            echo json_encode($json, true);

            return;
        }

        /*=============================================
		Validar correo
		=============================================*/

        if (isset($datos["correo"]) && !preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $datos["correo"])) {

            $json = array(

                "status" => 404,
                "detalle" => "Error correo"

            );

            echo json_encode($json, true);

            return;
        }

        /*=============================================
		Validar que el email no esté repetido
		=============================================*/

        $usuario  = ModeloUsuario::index("usuario");

        foreach ($usuario as $key => $value) {

            if ($value["correo"] == $datos["correo"]) {

                $json = array(

                    "status" => 404,
                    "detalle" => "El email ya existe en la base de datos"

                );

                echo json_encode($json, true);

                return;
            }
        }

        /*=============================================
		Extraer tipo de usuario
		=============================================*/
        $id_tipo_personal = ModeloTipoUsuario::select("tipo_usuario",$datos["tipo_usuario"]);

        /*=============================================
		Extraer tipo de usuario
		=============================================*/
        $id_area_trabajo = ModeloAreaTrabajoAthu::select("area_trabajo",$datos["area_trabajo"]);

        /*=============================================
		Generar credenciales del cliente
		=============================================*/

        $codigo = str_replace("$", "a", crypt($datos["nombre"] . $datos["apellido"] . $datos["correo"], '$2a$07$afartwetsdAD52356FEDGsfhsd$'));

        $llave = str_replace("$", "o", crypt($datos["correo"] . $datos["apellido"] . $datos["nombre"], '$2a$07$afartwetsdAD52356FEDGsfhsd$'));


        /*=============================================
		Llevar datos al modelo
		=============================================*/

        $datos = array(
            "nombre" => $datos["nombre"],
            "apellido" => $datos["apellido"],
            "cedula" => $datos["cedula"],
            "correo" => $datos["correo"],
            "fecha_creacion" => date('Y-m-d h:i:s'),
            "llave" => $llave,
            "codigo" => $codigo,
            "id_tipo_usuario" => $id_tipo_personal,
            "id_area_trabajo" => $id_area_trabajo
        );

        $create = ModeloUsuario::create("usuario", $datos);

        /*=============================================
		Respuesta del modelo
		=============================================*/

		if($create == "ok"){

			$json = array(

					"status"=>200,
					"detalle"=>"Registro exitoso, tome sus credenciales y guárdelas",
					"credenciales"=>array("llave"=>$llave, "codigo"=>$codigo)

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

                    /*=============================================
					Validar id creador
					=============================================*/

                    
                    $color = ModeloUsuario::show("usuario", $id);

                    if (!empty($color)) {

                        $update = ModeloUsuario::update("usuario",$datos);

                        if($update == 'ok'){
                            
                            $json = array(

                                "status" => 200,
                                "detalle" => "Actualizacion exitoso de usuario"
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
                    $area = ModeloUsuario::show('usuario', $id);

                    if (!empty($area)) {

                        $delete = ModeloUsuario::delete("usuario", $id);

                        if ($delete == 'ok') {
                            $json = array(
                                "status" => 200,
                                "detalle" => "Eliminacion exitosa de usuario"
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

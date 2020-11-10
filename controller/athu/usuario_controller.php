<?php

class ControladorUsuario
{
    /*================
     * crear una linea
     =================*/
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
        $id_area_trabajo = ModeloAreaTrabajo::select("area_trabajo",$datos["area_trabajo"]);

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
}

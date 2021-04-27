<?php

class ControladorLogin
{

    public function create($datos)
    {
        /*=============================================
		            Validar password
		=============================================*/
        if (isset($datos['pass']) && !preg_match('/^[a-z0-9A-ZáéíóúÁÉÍÓÚñÑ_]+$/', $datos["pass"])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error"
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
                "detalle" => "Formato en usuario no correcto"

            );

            echo json_encode($json, true);

            return;
        }

        /*=============================================
		Validar que el email no esté repetido
		=============================================*/

        $usuario  = ModeloUsuario::index("usuario");

        foreach ($usuario as $key => $value) {
            $validacionPass = password_verify($datos["pass"],$value["pass"]); 
            if ($value["correo"] == $datos["correo"] && $validacionPass){
                $envio = array(
                    "nombre" => $value["nombre"],
                    "apellido" => $value["apellido"],
                    "cedula" => $value["cedula"],
                    "correo" => $value["correo"],
                    "padlock" => $value["padlock"],
                    "keylock" => $value["keylock"]  
                );

                $json = array( 
                    "status" => 200,
                    "detalle" => $envio
                );

                echo json_encode($json, true);

                return;
               
            }
        }

        $json = array(
                    
            "status" => 404,
            "detalle" => "Usuario y/o contraseña no validas"

        );

        echo json_encode($json, true);

        return;

    }

    
}

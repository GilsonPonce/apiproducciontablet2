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
                    "Basic " . base64_encode($valueUsuario["padlock"] . ":" . $valueUsuario["keylock"])
                ) {
                    $usuario = ModeloUsuario::index("usuario");
                    $json = array(
                        "status" => 200,
                        "total_registro" => count($usuario),
                        "detalle" => $usuario
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
                    "Basic " . base64_encode($valueUsuario["padlock"] . ":" . $valueUsuario["keylock"])
                ) {
                    $usuario = ModeloUsuario::show("usuario", $id);
                    $json = array(
                        "status" => 200,
                        "total_registro" => count($usuario),
                        "detalle" => $usuario
                    );
                    echo json_encode($json, true);
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


        if (isset($datos['activo']) && !is_numeric($datos['activo'])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error en estado"
            );

            echo json_encode($json, true);

            return;
        }

        /*=============================================
		            Validar password
		=============================================*/
        if (isset($datos['pass']) && !preg_match('/^[a-z0-9A-ZáéíóúÁÉÍÓÚñÑ ]+$/', $datos["pass"])) {
            $json = array(

                "status" => 404,
                "detalle" => "Error contrasena"
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
                    "detalle" => "Error cuenta ya registrada"

                );

                echo json_encode($json, true);

                return;
            }
        }


        /*=============================================
		Generar credenciales del cliente
		=============================================*/

        $padlock = str_replace("$", "a", crypt($datos["pass"] . $datos["correo"], '$2a$07$afartwetsdAD52356FEDGsfhsd$'));
        $paylock = substr($padlock, 0, 500);

        $keylock = str_replace("$", "o", crypt($datos["correo"] . $datos["pass"], '$2a$07$afartwetsdAD52356FEDGsfhsd$'));
        $keylock = substr($keylock, 0, 500);

        /*CIFRADO DE CONTRASENA */
        $opciones = [
            'cost' => 10,
        ];

        /*SE LA DECIFRA CON LAS FUNCION password_verify('rasmuslerdorf', $hash) */

        /*=============================================
		Llevar datos al modelo
		=============================================*/

        $datos = array(
            "nombre" => $datos["nombre"],
            "apellido" => $datos["apellido"],
            "cedula" => $datos["cedula"],
            "correo" => $datos["correo"],
            "fecha_creacion" => date('Y-m-d h:i:s'),
            "pass" => password_hash($datos["pass"], PASSWORD_BCRYPT, $opciones),
            "padlock" => $padlock,
            "keylock" => $keylock,
            "activo" => $datos["activo"],
        );

        $create = ModeloUsuario::create("usuario", $datos);

        /*=============================================
		Respuesta del modelo
		=============================================*/

        if ($create == "ok") {

            $json = array(

                "status" => 200,
                "detalle" => "Registro exitoso, tome sus credenciales y guárdelas",
                "credenciales" => array("candado" => $paylock, "llave" => $keylock)

            );

            echo json_encode($json, true);

            return;
        }
    }

    public function update($id, $datos)
    {

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

                        if (isset($valueDatos) && !preg_match('/^[(\\)\\=\\@\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $valueDatos)) {

                            $json = array(

                                "status" => 404,
                                "detalle" => "Error en el campo " . $key

                            );

                            echo json_encode($json, true);

                            return;
                        }
                    }

                    $opciones = [
                        'cost' => 10,
                    ];

                    $pass = "";

                    $usuario2  = ModeloUsuario::show("usuario",$id);
                    foreach ($usuario2 as $key => $value) {
                        if($datos["pass"] == $value["pass"]){
                            $pass = $datos["pass"];
                        }else{
                            $pass = password_hash($datos["pass"], PASSWORD_BCRYPT, $opciones);
                        }
                    }

                    /*=============================================
					Validar id creador
					=============================================*/
                    $padlock = str_replace("$", "a", crypt($datos["pass"] . $datos["correo"], '$2a$07$afartwetsdAD52356FEDGsfhsd$'));
                    $paylock = substr($padlock, 0, 500);

                    $keylock = str_replace("$", "o", crypt($datos["correo"] . $datos["pass"], '$2a$07$afartwetsdAD52356FEDGsfhsd$'));
                    $keylock = substr($keylock, 0, 500);

                   

                    /*SE LA DECIFRA CON LAS FUNCION password_verify('rasmuslerdorf', $hash) */

                    $datos = array(
                        "id_usuario" => $datos["id_usuario"],
                        "nombre" => $datos["nombre"],
                        "apellido" => $datos["apellido"],
                        "cedula" => $datos["cedula"],
                        "correo" => $datos["correo"],
                        "pass" => $pass,
                        "padlock" => $padlock,
                        "keylock" => $keylock,
                        "activo" => $datos["activo"],
                    );


                    $color = ModeloUsuario::show("usuario", $id);

                    if (!empty($color)) {

                        $update = ModeloUsuario::update("usuario", $datos);

                        if ($update == 'ok') {

                            $json = array(

                                "status" => 200,
                                "detalle" => "Actualizacion exitoso de usuario"
                            );

                            echo json_encode($json, true);

                            return;
                        } else {
                            $json = array(

                                "status" => 404,
                                "detalle" => "No se pudo actualizar"
                            );

                            echo json_encode($json, true);

                            return;
                        }
                    } else {
                        $json = array(

                            "status" => 404,
                            "detalle" => "No se pudo actualizar"
                        );

                        echo json_encode($json, true);

                        return;
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

    public function delete($id)
    {

        $usuario = ModeloUsuario::index("usuario");

        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            foreach ($usuario as $key => $valueUsuario) {
                if (
                    "Basic " . base64_encode($_SERVER['PHP_AUTH_USER'] . ":" . $_SERVER['PHP_AUTH_PW']) ==
                    "Basic " . base64_encode($valueUsuario["padlock"] . ":" . $valueUsuario["keylock"])
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

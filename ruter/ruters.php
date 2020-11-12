<?php

$arrayRuters = explode("/", $_SERVER['REQUEST_URI']);
//echo json_encode(array_filter($arrayRuters));

if (count(array_filter($arrayRuters)) == 0) {
    /*=================================================
        Cuando no se hace ninguna peticion a la API
    ===================================================*/
    $json = array(
        "detalle" => "no encontrado"
    );
    echo json_encode($json, true);
} else {
    if (count(array_filter($arrayRuters)) == 1) {
        /*=====================================
        Cuando se hace peticiones de una sola
        =======================================*/
        if (array_filter($arrayRuters)[1] == "linea") {
            /*=====================================================
        Cuando se hace peticiones nova-apiproduccion.com/lineas
        =======================================================*/
            $Objetolineas = new ControladorLineas();
            if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                $Objetolineas->index();
            } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
                $datos = array(
                    "nombre" => $_POST["nombre"],
                );
                $Objetolineas->create($datos);
            } else {
                $json = array(

                    "detalle" => "No encontrado metodo http linea"

                );

                echo json_encode($json, true);

                return;
            }
        } else if (array_filter($arrayRuters)[1] == "proceso") {
            /*=====================================================
            Cuando se hace peticiones nova-apiproduccion.com/proceso
            =======================================================*/
            $Objetoproceso = new ControladorProceso();
            if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                $Objetoproceso->index();
            } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
                $datos = array(
                    "nombre" => $_POST["nombre"],
                    "id_linea" =>$_POST["id_linea"]
                );
                $Objetoproceso->create($datos);
            }else {
                $json = array(

                    "detalle" => "No encontrado metodo http proceso"

                );

                echo json_encode($json, true);

                return;
            }
        } else if (array_filter($arrayRuters)[1] == "orden") {
            /*=====================================================
            Cuando se hace peticiones nova-apiproduccion.com/orden
            =======================================================*/
            $ObjetoOrden = new ControladorOrden();
            if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                $ObjetoOrden->index();
            } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
                $datos = array(
                    "orden_codigo" => $_POST["orden_codigo"],
                    "id_proceso" =>$_POST["id_proceso"],
                    "id_estado_orden" => $_POST["id_estado_orden"]
                );
                $ObjetoOrden->create($datos);
            }else {
                $json = array(
                    "detalle" => "No encontrado metodo http orden"
                );

                echo json_encode($json, true);

                return;
            }
        }else if (array_filter($arrayRuters)[1] == "peso") {
        } else if (array_filter($arrayRuters)[1] == "tipo_peso") {
        } else if (array_filter($arrayRuters)[1] == "color") {
        } else if (array_filter($arrayRuters)[1] == "tipo_material") {
        } else if (array_filter($arrayRuters)[1] == "material") {
        } else if (array_filter($arrayRuters)[1] == "informe") {
        } else if (array_filter($arrayRuters)[1] == "observacion") {
        } else if (array_filter($arrayRuters)[1] == "registro") {
        } else if (array_filter($arrayRuters)[1] == "personal") {
        } else if (array_filter($arrayRuters)[1] == "parada") {
        } else if (array_filter($arrayRuters)[1] == "motivo") {
        } else if (array_filter($arrayRuters)[1] == "tipo_personal") {
        } else if (array_filter($arrayRuters)[1] == "area_trabajo") {
        } else if (array_filter($arrayRuters)[1] == "usuario") {
            /*=====================================================
            Cuando se hace peticiones nova-apiproduccion.com/usuario
            =======================================================*/
            if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
            } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
                $datos = array(
                    "nombre" => $_POST["nombre"],
                    "apellido" => $_POST["apellido"],
                    "cedula" => $_POST["cedula"],
                    "correo" => $_POST["correo"],
                    "tipo_usuario" => $_POST["tipo_usuario"],
                    "area_trabajo" => $_POST["area_trabajo"],
                );
                $registro = new ControladorUsuario();
                $registro->create($datos);
            } else {
                $json = array(

                    "detalle" => "no encontrado"

                );

                echo json_encode($json, true);

                return;
            }
        } else {
            $json = array(

                "detalle" => "no encontrado en un"

            );

            echo json_encode($json, true);

            return;
        }
    } else if (count(array_filter($arrayRuters)) == 2) {
        if (array_filter($arrayRutas)[1] == "lineas" && is_numeric(array_filter($arrayRutas)[2])) {
            if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "PUT") {
            } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "DELETE") {
            } else {
                $json = array(

                    "detalle" => "no encontrado"

                );

                echo json_encode($json, true);

                return;
            }
        }
    }
}

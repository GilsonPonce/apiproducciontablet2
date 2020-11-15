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
                    "status" => 404,
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
                    "id_linea" => $_POST["id_linea"]
                );
                $Objetoproceso->create($datos);
            } else {
                $json = array(
                    "status" => 404,
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
                    "id_proceso" => $_POST["id_proceso"],
                    "id_estado_orden" => $_POST["id_estado_orden"]
                );
                $ObjetoOrden->create($datos);
            } else {
                $json = array(
                    "status" => 404,
                    "detalle" => "No encontrado metodo http orden"
                );

                echo json_encode($json, true);

                return;
            }
        } else if (array_filter($arrayRuters)[1] == "peso") {
            /*=====================================================
            Cuando se hace peticiones nova-apiproduccion.com/peso
            =======================================================*/
            $Objetopeso = new ControladorPeso();
            if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                $Objetopeso->index();
            } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
                $datos = array(
                    "numero" => $_POST['numero'],
                    "cantidad" => $_POST['cantidad'],
                    "peso" => $_POST['peso'],
                    "id_informe" => $_POST['id_informe'],
                    "id_color" => $_POST['id_color'],
                    "id_tipo_material" => $_POST['id_tipo_material'],
                    "id_tipo_peso" => $_POST['id_tipo_peso'],
                    "id_personal" => $_POST['id_personal'],
                    "id_estado_peso" => $_POST['id_estado_peso']
                );
                $Objetopeso->create($datos);
            } else {
                $json = array(
                    "status" => 404,
                    "detalle" => "No encontrado metodo http peso"

                );

                echo json_encode($json, true);

                return;
            }
        } else if (array_filter($arrayRuters)[1] == "tipo_peso") {
            /*=====================================================
            Cuando se hace peticiones nova-apiproduccion.com/tipo_peso
            =======================================================*/
            $Objetotipopeso = new ControladorTipoPeso();
            if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                $Objetotipopeso->index();
            } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
                $datos = array(
                    "nombre" => $_POST['nombre']
                );
                $Objetotipopeso->create($datos);
            } else {
                $json = array(
                    "status" => 404,
                    "detalle" => "No encontrado metodo http tipo de peso"

                );

                echo json_encode($json, true);

                return;
            }
        } else if (array_filter($arrayRuters)[1] == "color") {
            /*=====================================================
            Cuando se hace peticiones nova-apiproduccion.com/color
            =======================================================*/
            $Objetocolor = new ControladorColor();
            if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                $Objetocolor->index();
            } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
                $datos = array(
                    "nombre" => $_POST['nombre']
                );
                $Objetocolor->create($datos);
            } else {
                $json = array(
                    "status" => 404,
                    "detalle" => "No encontrado metodo http color"

                );

                echo json_encode($json, true);

                return;
            }
        } else if (array_filter($arrayRuters)[1] == "tipo_material") {
            /*=====================================================
            Cuando se hace peticiones nova-apiproduccion.com/tipo_material
            =======================================================*/
            $Objetotipomaterial = new ControladorTipoMaterial();
            if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                $Objetotipomaterial->index();
            } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
                $datos = array(
                    "nombre" => $_POST['nombre'],
                    "id_material" => $_POST['id_material']
                );
                $Objetotipomaterial->create($datos);
            } else {
                $json = array(

                    "status" => 404,
                    "detalle" => "No encontrado metodo http tipo material"

                );

                echo json_encode($json, true);

                return;
            }
        } else if (array_filter($arrayRuters)[1] == "material") {
            /*=====================================================
            Cuando se hace peticiones nova-apiproduccion.com/material
            =======================================================*/
            $Objetomaterial = new ControladorMaterial();
            if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                $Objetomaterial->index();
            } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
                $datos = array(
                    "nombre" => $_POST['nombre']
                );
                $Objetomaterial->create($datos);
            } else {
                $json = array(

                    "status" => 404,
                    "detalle" => "No encontrado metodo http material"

                );

                echo json_encode($json, true);

                return;
            }
        } else if (array_filter($arrayRuters)[1] == "informe") {
            /*=====================================================
            Cuando se hace peticiones nova-apiproduccion.com/informe
            =======================================================*/
            $Objetoinforme = new ControladorInforme();
            if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                $Objetoinforme->index();
            } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
                $datos = array(
                    "orden_codigo" => $_POST['orden_codigo']
                );
                $Objetoinforme->create($datos);
            } else {
                $json = array(
                    "status" => 404,
                    "detalle" => "No encontrado metodo http informe"

                );

                echo json_encode($json, true);

                return;
            }
        } else if (array_filter($arrayRuters)[1] == "observacion") {
            /*=====================================================
            Cuando se hace peticiones nova-apiproduccion.com/observacion
            =======================================================*/
            $Objetoobservacion = new ControladorObservacion();
            if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                $Objetoobservacion->index();
            } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
                $datos = array(
                    "detalle" => $_POST['detalle'],
                    "id_informe" => $_POST['id_informe']
                );
                $Objetoobservacion->create($datos);
            } else {
                $json = array(
                    "status" => 404,
                    "detalle" => "No encontrado metodo http informe"

                );

                echo json_encode($json, true);

                return;
            }
        } else if (array_filter($arrayRuters)[1] == "registro") {
            /*=====================================================
            Cuando se hace peticiones nova-apiproduccion.com/registro
            =======================================================*/
            $Objetoregistro = new ControladorRegistro();
            if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                $Objetoregistro->index();
            } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
                $datos = array(
                    "linea" => $_POST['linea'],
                    "proceso" => $_POST['proceso'],
                    "id_personal" => $_POST['id_personal'],
                    "orden_codigo" => $_POST['orden_codigo']
                );
                $Objetoregistro->create($datos);
            } else {
                $json = array(
                    "status" => 404,
                    "detalle" => "No encontrado metodo http registro"

                );

                echo json_encode($json, true);

                return;
            }
        } else if (array_filter($arrayRuters)[1] == "personal") {
            /*=====================================================
            Cuando se hace peticiones nova-apiproduccion.com/personal
            =======================================================*/
            $Objetopersonal = new ControladorPersonal();
            if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                $Objetopersonal->index();
            } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
                $datos = array(
                    "nombre" => $_POST['nombre'],
                    "apellido" => $_POST['apellido'],
                    "cedula" => $_POST['cedula'],
                    "id_tipo_personal" => $_POST['id_tipo_personal'],
                    "id_area_trabajo" => $_POST['id_area_trabajo']
                );
                $Objetopersonal->create($datos);
            } else {
                $json = array(
                    "status" => 404,
                    "detalle" => "No encontrado metodo http personal"

                );

                echo json_encode($json, true);

                return;
            }
        } else if (array_filter($arrayRuters)[1] == "parada") {
            /*=====================================================
            Cuando se hace peticiones nova-apiproduccion.com/parada
            =======================================================*/
            $Objetoparada = new Controladorparada();
            if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                $Objetoparada->index();
            } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
                $datos = array(
                    "id_motivo" => $_POST['id_motivo'],
                    "id_personal" => $_POST['id_personal']
                );
                $Objetoparada->create($datos);
            } else {
                $json = array(
                    "status" => 404,
                    "detalle" => "No encontrado metodo http parada"

                );

                echo json_encode($json, true);

                return;
            }
        } else if (array_filter($arrayRuters)[1] == "motivo") {
            /*=====================================================
            Cuando se hace peticiones nova-apiproduccion.com/motivo
            =======================================================*/
            $Objetomotivo = new ControladorMotivo();
            if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                $Objetomotivo->index();
            } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
                $datos = array(
                    "id_motivo" => $_POST['id_motivo'],
                    "id_personal" => $_POST['id_personal']
                );
                $Objetomotivo->create($datos);
            } else {
                $json = array(
                    "status" => 404,
                    "detalle" => "No encontrado metodo http motivo"

                );

                echo json_encode($json, true);

                return;
            }
        } else if (array_filter($arrayRuters)[1] == "tipo_personal") {
            /*=====================================================
            Cuando se hace peticiones nova-apiproduccion.com/tipo_personal
            =======================================================*/
            $Objetotipopersonal = new ControladorTipoPersonal();
            if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                $Objetotipopersonal->index();
            } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
                $datos = array(
                    "nombre" => $_POST['nombre']
                );
                $Objetotipopersonal->create($datos);
            } else {
                $json = array(
                    "status" => 404,
                    "detalle" => "No encontrado metodo http tipo personal"

                );

                echo json_encode($json, true);

                return;
            }
        } else if (array_filter($arrayRuters)[1] == "area_trabajo") {
            /*=====================================================
            Cuando se hace peticiones nova-apiproduccion.com/area_trabajo
            =======================================================*/
            $Objetoareatrabajo = new ControladorAreaTrabajo();
            if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                $Objetoareatrabajo->index();
            } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
                $datos = array(
                    "nombre" => $_POST['nombre']
                );
                $Objetoareatrabajo->create($datos);
            } else {
                $json = array(
                    "status" => 404,
                    "detalle" => "No encontrado metodo http area trabajo"

                );

                echo json_encode($json, true);

                return;
            }
        } else if (array_filter($arrayRuters)[1] == "estado_orden") {
            /*=====================================================
           Cuando se hace peticiones nova-apiproduccion.com/estado_orden
           =======================================================*/
            $Objetoestadoorden = new ControladorEstadoOrden();
            if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                $Objetoestadoorden->index();
            } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
                $datos = array(
                    "nombre" => $_POST['nombre']
                );
                $Objetoestadoorden->create($datos);
            } else {
                $json = array(
                    "status" => 404,
                    "detalle" => "No encontrado metodo http estado orden"

                );

                echo json_encode($json, true);

                return;
            }
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
                    "status" => 404,
                    "detalle" => "no encontrado"

                );

                echo json_encode($json, true);

                return;
            }
        } else {
            $json = array(
                "status" => 404,
                "detalle" => "No encontrado metodo http usuario"

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
                    "status" => 404,
                    "detalle" => "no encontrado"

                );

                echo json_encode($json, true);

                return;
            }
        }
    }
}

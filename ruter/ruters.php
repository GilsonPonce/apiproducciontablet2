<?php

$arrayRuters = explode("/", $_SERVER['REQUEST_URI']);
// json_encode(array_filter($arrayRuters));

if(isset($_GET["page"]) && is_numeric($_GET["page"])){


}else{
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
            if (array_filter($arrayRuters)[1] == "linea") {
                /*=====================================================
            Cuando se hace peticiones dominio/lineas
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
                        "peso_producir" => $_POST["peso_producir"],
                        "id_configuracion" => $_POST["id_configuracion"],
                        "id_color" => $_POST["id_color"],
                        "id_turno" => $_POST["id_turno"],
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
                        "kilogramo" => $_POST['kilogramo'],
                        "orden_codigo" => $_POST['orden_codigo'],
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
            }else if (array_filter($arrayRuters)[1] == "color") {
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
                        "nombre" => $_POST['nombre'],
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
            }else if (array_filter($arrayRuters)[1] == "registro") {
                /*=====================================================
                Cuando se hace peticiones nova-apiproduccion.com/registro
                =======================================================*/
                $Objetoregistro = new ControladorRegistro();
                if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                    $Objetoregistro->index();
                } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
                    $datos = array(
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
                        "nombre" => $_POST['nombre']
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
            }else if (array_filter($arrayRuters)[1] == "propiedad") {
                /*=====================================================
                Cuando se hace peticiones nova-apiproduccion.com/motivo
                =======================================================*/
                $Objetomotivo = new ControladorPropiedad();
                if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                    $Objetomotivo->index();
                } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
                    $datos = array(
                        "nombre" => $_POST['nombre']
                    );
                    $Objetomotivo->create($datos);
                } else {
                    $json = array(
                        "status" => 404,
                        "detalle" => "No encontrado metodo http propiedad"
    
                    );
    
                    echo json_encode($json, true);
    
                    return;
                }
            }else if (array_filter($arrayRuters)[1] == "turno") {
                /*=====================================================
                Cuando se hace peticiones nova-apiproduccion.com/motivo
                =======================================================*/
                $Objetomotivo = new ControladorTurno();
                if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                    $Objetomotivo->index();
                } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
                    $datos = array(
                        "nombre" => $_POST['nombre']
                    );
                    $Objetomotivo->create($datos);
                } else {
                    $json = array(
                        "status" => 404,
                        "detalle" => "No encontrado metodo http turno"
    
                    );
    
                    echo json_encode($json, true);
    
                    return;
                }
            }else if (array_filter($arrayRuters)[1] == "configuracion") {
                /*=====================================================
                Cuando se hace peticiones nova-apiproduccion.com/motivo
                =======================================================*/
                $Objetomotivo = new ControladorConfiguracion();
                if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                    $Objetomotivo->index();
                } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
                    $datos = array(
                        "kilogramo_diario" => $_POST['kilogramo_diario'],
                        "kilogramo_hora" => $_POST['kilogramo_hora'],
                        "tarifa_kilogramos_producidos" => $_POST['tarifa_kilogramos_producidos'],
                        "estado" => $_POST['estado'],
                        "id_proceso" => $_POST['id_proceso'],
                        "id_material" => $_POST['id_material'],
                        "id_tipo_material" => $_POST['id_tipo_material'],
                        "id_propiedad" => $_POST['id_propiedad']
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
            }
            else if (array_filter($arrayRuters)[1] == "estado_registro") {
                /*=====================================================
               Cuando se hace peticiones nova-apiproduccion.com/estado_orden
               =======================================================*/
                $Objetoestadoregistro = new ControladorEstadoRegistro();
                if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                    $Objetoestadoregistro->index();
                } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
                    $datos = array(
                        "nombre" => $_POST['nombre']
                    );
                    $Objetoestadoregistro->create($datos);
                } else {
                    $json = array(
                        "status" => 404,
                        "detalle" => "No encontrado metodo http estado registro"
    
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
            } else if (array_filter($arrayRuters)[1] == "estado_peso") {
                /*=====================================================
                Cuando se hace peticiones nova-apiproduccion.com/area_trabajo
                =======================================================*/
                $Objetoestadopeso = new ControladorEstadoPeso();
                if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                    $Objetoestadopeso->index();
                } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
                    $datos = array(
                        "nombre" => $_POST['nombre']
                    );
                    $Objetoestadopeso->create($datos);
                } else {
                    $json = array(
                        "status" => 404,
                        "detalle" => "No encontrado metodo http estado peso"
    
                    );
    
                    echo json_encode($json, true);
    
                    return;
                }
            }else {
                $json = array(
                    "status" => 404,
                    "detalle" => "No encontrado metodo http"
    
                );
    
                echo json_encode($json, true);
    
                return;
            }
        } else if (count(array_filter($arrayRuters)) == 2) {
            //array_filter($arrayRutas)[2] es la id
            if (array_filter($arrayRuters)[1] == "linea" && is_numeric(array_filter($arrayRuters)[2])) {
                if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "PUT") {
                    $datos = array();
                    parse_str(file_get_contents('php://input'),$datos);
                    $editarlinea = new ControladorLineas();
                    $editarlinea -> update(array_filter($arrayRuters)[2],$datos);
                }else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                    $linea = new ControladorLineas();
                    $linea -> show(array_filter($arrayRuters)[2]);
                } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "DELETE") {
                    $borrarlinea = new ControladorLineas();
                    $borrarlinea -> delete(array_filter($arrayRuters)[2]);
                } else {
                    $json = array(
                        "status" => 404,
                        "detalle" => "metodo no encontrado"
    
                    );
    
                    echo json_encode($json, true);
    
                    return;
                }
            }else if (array_filter($arrayRuters)[1] == "proceso" && is_numeric(array_filter($arrayRuters)[2])){
                if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "PUT") {
                    $datos = array();
                    parse_str(file_get_contents('php://input'),$datos);
                    $editarproceso = new ControladorProceso();
                    $editarproceso -> update(array_filter($arrayRuters)[2],$datos);
                }else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                    $proceso = new ControladorProceso();
                    $proceso -> show(array_filter($arrayRuters)[2]);
                } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "DELETE") {
                    $borrarproceso = new ControladorProceso();
                    $borrarproceso -> delete(array_filter($arrayRuters)[2]);
                } else {
                    $json = array(
                        "status" => 404,
                        "detalle" => "metodo no encontrado"
    
                    );
    
                    echo json_encode($json, true);
    
                    return;
                }
            }else if (array_filter($arrayRuters)[1] == "propiedad" && is_numeric(array_filter($arrayRuters)[2])){
                if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "PUT") {
                    $datos = array();
                    parse_str(file_get_contents('php://input'),$datos);
                    $editarpropiedad = new ControladorPropiedad();
                    $editarpropiedad -> update(array_filter($arrayRuters)[2],$datos);
                }else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                    $propiedad = new ControladorPropiedad();
                    $propiedad -> show(array_filter($arrayRuters)[2]);
                } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "DELETE") {
                    $borrarpropiedad = new ControladorPropiedad();
                    $borrarpropiedad -> delete(array_filter($arrayRuters)[2]);
                } else {
                    $json = array(
                        "status" => 404,
                        "detalle" => "metodo no encontrado"
    
                    );
    
                    echo json_encode($json, true);
    
                    return;
                }
            }else if (array_filter($arrayRuters)[1] == "turno" && is_numeric(array_filter($arrayRuters)[2])){
                if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "PUT") {
                    $datos = array();
                    parse_str(file_get_contents('php://input'),$datos);
                    $editarturno = new ControladorTurno();
                    $editarturno -> update(array_filter($arrayRuters)[2],$datos);
                }else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                    $turno = new ControladorTurno();
                    $turno -> show(array_filter($arrayRuters)[2]);
                } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "DELETE") {
                    $borrarturno = new ControladorTurno();
                    $borrarturno -> delete(array_filter($arrayRuters)[2]);
                } else {
                    $json = array(
                        "status" => 404,
                        "detalle" => "metodo no encontrado"
    
                    );
    
                    echo json_encode($json, true);
    
                    return;
                }
            }else if (array_filter($arrayRuters)[1] == "configuracion" && is_numeric(array_filter($arrayRuters)[2])){
                if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "PUT") {
                    $datos = array();
                    parse_str(file_get_contents('php://input'),$datos);
                    $editarconfiguracion = new ControladorConfiguracion();
                    $editarconfiguracion -> update(array_filter($arrayRuters)[2],$datos);
                }else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                    $configuracion = new ControladorConfiguracion();
                    $configuracion -> show(array_filter($arrayRuters)[2]);
                } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "DELETE") {
                    $borrarconfiguracion = new ControladorConfiguracion();
                    $borrarconfiguracion -> delete(array_filter($arrayRuters)[2]);
                } else {
                    $json = array(
                        "status" => 404,
                        "detalle" => "metodo no encontrado"
    
                    );
    
                    echo json_encode($json, true);
    
                    return;
                }
            }else if (array_filter($arrayRuters)[1] == "orden" && is_numeric(array_filter($arrayRuters)[2])){
                if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "PUT") {
                    $datos = array();
                    parse_str(file_get_contents('php://input'),$datos);
                    $editarorden = new ControladorOrden();
                    $editarorden -> update(array_filter($arrayRuters)[2],$datos);
                }else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                    $orden = new ControladorOrden();
                    $orden -> show(array_filter($arrayRuters)[2]);
                } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "DELETE") {
                    $borrarorden = new ControladorOrden();
                    $borrarorden -> delete(array_filter($arrayRuters)[2]);
                } else {
                    $json = array(
                        "status" => 404,
                        "detalle" => "metodo no encontrado"
    
                    );
    
                    echo json_encode($json, true);
    
                    return;
                }
            }else if (array_filter($arrayRuters)[1] == "peso" && is_numeric(array_filter($arrayRuters)[2])){
                if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "PUT") {
                    $datos = array();
                    parse_str(file_get_contents('php://input'),$datos);
                    $editarpeso = new ControladorPeso();
                    $editarpeso -> update(array_filter($arrayRuters)[2],$datos);
                }else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                    $peso = new ControladorPeso();
                    $peso -> show(array_filter($arrayRuters)[2]);
                } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "DELETE") {
                    $borrarpeso = new ControladorPeso();
                    $borrarpeso -> delete(array_filter($arrayRuters)[2]);
                } else {
                    $json = array(
                        "status" => 404,
                        "detalle" => "metodo no encontrado"
    
                    );
    
                    echo json_encode($json, true);
    
                    return;
                }
            }else if (array_filter($arrayRuters)[1] == "color" && is_numeric(array_filter($arrayRuters)[2])){
                if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "PUT") {
                    $datos = array();
                    parse_str(file_get_contents('php://input'),$datos);
                    $editarcolor = new ControladorColor();
                    $editarcolor -> update(array_filter($arrayRuters)[2],$datos);
                }else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                    $color = new ControladorColor();
                    $color -> show(array_filter($arrayRuters)[2]);
                } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "DELETE") {
                    $borrarcolor = new ControladorColor();
                    $borrarcolor -> delete(array_filter($arrayRuters)[2]);
                } else {
                    $json = array(
                        "status" => 404,
                        "detalle" => "metodo no encontrado"
    
                    );
    
                    echo json_encode($json, true);
    
                    return;
                }
            }else if (array_filter($arrayRuters)[1] == "tipo_material" && is_numeric(array_filter($arrayRuters)[2])){
                if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "PUT") {
                    $datos = array();
                    parse_str(file_get_contents('php://input'),$datos);
                    $editartipo_material = new ControladorTipoMaterial();
                    $editartipo_material -> update(array_filter($arrayRuters)[2],$datos);
                }else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                    $tipo_material = new ControladorTipoMaterial();
                    $tipo_material -> show(array_filter($arrayRuters)[2]);
                } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "DELETE") {
                    $borrartipo_material = new ControladorTipoMaterial();
                    $borrartipo_material -> delete(array_filter($arrayRuters)[2]);
                } else {
                    $json = array(
                        "status" => 404,
                        "detalle" => "metodo no encontrado"
    
                    );
    
                    echo json_encode($json, true);
    
                    return;
                }
            }else if (array_filter($arrayRuters)[1] == "material" && is_numeric(array_filter($arrayRuters)[2])){
                if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "PUT") {
                    $datos = array();
                    parse_str(file_get_contents('php://input'),$datos);
                    $editarmaterial = new ControladorMaterial();
                    $editarmaterial -> update(array_filter($arrayRuters)[2],$datos);
                }else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                    $material = new ControladorMaterial();
                    $material -> show(array_filter($arrayRuters)[2]);
                } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "DELETE") {
                    $borrarmaterial = new ControladorMaterial();
                    $borrarmaterial -> delete(array_filter($arrayRuters)[2]);
                } else {
                    $json = array(
                        "status" => 404,
                        "detalle" => "metodo no encontrado"
    
                    );
    
                    echo json_encode($json, true);
    
                    return;
                }
            }else if (array_filter($arrayRuters)[1] == "informe" && is_numeric(array_filter($arrayRuters)[2])){
                if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "PUT") {
                    $datos = array();
                    parse_str(file_get_contents('php://input'),$datos);
                    $editarinforme = new ControladorInforme();
                    $editarinforme -> update(array_filter($arrayRuters)[2],$datos);
                }else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                    $informe = new ControladorInforme();
                    $informe -> show(array_filter($arrayRuters)[2]);
                } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "DELETE") {
                    $borrarinforme = new ControladorInforme();
                    $borrarinforme -> delete(array_filter($arrayRuters)[2]);
                } else {
                    $json = array(
                        "status" => 404,
                        "detalle" => "metodo no encontrado"
    
                    );
    
                    echo json_encode($json, true);
    
                    return;
                }
            }else if (array_filter($arrayRuters)[1] == "registro" && is_numeric(array_filter($arrayRuters)[2])){
                if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "PUT") {
                    $datos = array();
                    parse_str(file_get_contents('php://input'),$datos);
                    $editarregistro = new ControladorRegistro();
                    $editarregistro -> update(array_filter($arrayRuters)[2],$datos);
                }else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                    $registro = new ControladorRegistro();
                    $registro -> show(array_filter($arrayRuters)[2]);
                } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "DELETE") {
                    $borrarregistro = new ControladorRegistro();
                    $borrarregistro -> delete(array_filter($arrayRuters)[2]);
                } else {
                    $json = array(
                        "status" => 404,
                        "detalle" => "metodo no encontrado"
    
                    );
    
                    echo json_encode($json, true);
    
                    return;
                }
            }else if (array_filter($arrayRuters)[1] == "personal" && is_numeric(array_filter($arrayRuters)[2])){
                if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "PUT") {
                    $datos = array();
                    parse_str(file_get_contents('php://input'),$datos);
                    $editarpersonal = new ControladorPersonal();
                    $editarpersonal -> update(array_filter($arrayRuters)[2],$datos);
                }else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                    $personal = new ControladorPersonal();
                    $personal -> show(array_filter($arrayRuters)[2]);
                } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "DELETE") {
                    $borrarpersonal = new ControladorPersonal();
                    $borrarpersonal -> delete(array_filter($arrayRuters)[2]);
                } else {
                    $json = array(
                        "status" => 404,
                        "detalle" => "metodo no encontrado"
    
                    );
    
                    echo json_encode($json, true);
    
                    return;
                }
            }else if (array_filter($arrayRuters)[1] == "parada" && is_numeric(array_filter($arrayRuters)[2])){
                if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "PUT") {
                    $datos = array();
                    parse_str(file_get_contents('php://input'),$datos);
                    $editarparada = new ControladorParada();
                    $editarparada -> update(array_filter($arrayRuters)[2],$datos);
                }else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                    $parada = new ControladorParada();
                    $parada -> show(array_filter($arrayRuters)[2]);
                } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "DELETE") {
                    $borrarparada = new ControladorParada();
                    $borrarparada -> delete(array_filter($arrayRuters)[2]);
                } else {
                    $json = array(
                        "status" => 404,
                        "detalle" => "metodo no encontrado"
    
                    );
    
                    echo json_encode($json, true);
    
                    return;
                }
            }else if (array_filter($arrayRuters)[1] == "motivo" && is_numeric(array_filter($arrayRuters)[2])){
                if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "PUT") {
                    $datos = array();
                    parse_str(file_get_contents('php://input'),$datos);
                    $editarmotivo = new ControladorMotivo();
                    $editarmotivo -> update(array_filter($arrayRuters)[2],$datos);
                }else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                    $motivo = new ControladorMotivo();
                    $motivo -> show(array_filter($arrayRuters)[2]);
                } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "DELETE") {
                    $borrarmotivo = new ControladorMotivo();
                    $borrarmotivo -> delete(array_filter($arrayRuters)[2]);
                } else {
                    $json = array(
                        "status" => 404,
                        "detalle" => "metodo no encontrado"
    
                    );
    
                    echo json_encode($json, true);
    
                    return;
                }
            }else if (array_filter($arrayRuters)[1] == "tipo_personal" && is_numeric(array_filter($arrayRuters)[2])){
                if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "PUT") {
                    $datos = array();
                    parse_str(file_get_contents('php://input'),$datos);
                    $editartipo_personal = new ControladorTipoPersonal();
                    $editartipo_personal -> update(array_filter($arrayRuters)[2],$datos);
                }else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                    $tipo_personal = new ControladorTipoPersonal();
                    $tipo_personal -> show(array_filter($arrayRuters)[2]);
                } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "DELETE") {
                    $borrartipo_personal = new ControladorTipoPersonal();
                    $borrartipo_personal -> delete(array_filter($arrayRuters)[2]);
                } else {
                    $json = array(
                        "status" => 404,
                        "detalle" => "metodo no encontrado"
    
                    );
    
                    echo json_encode($json, true);
    
                    return;
                }
            }else if (array_filter($arrayRuters)[1] == "area_trabajo" && is_numeric(array_filter($arrayRuters)[2])){
                if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "PUT") {
                    $datos = array();
                    parse_str(file_get_contents('php://input'),$datos);
                    $editararea_trabajo = new ControladorAreaTrabajo();
                    $editararea_trabajo -> update(array_filter($arrayRuters)[2],$datos);
                }else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                    $area_trabajo = new ControladorAreaTrabajo();
                    $area_trabajo -> show(array_filter($arrayRuters)[2]);
                } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "DELETE") {
                    $borrararea_trabajo = new ControladorAreaTrabajo();
                    $borrararea_trabajo -> delete(array_filter($arrayRuters)[2]);
                } else {
                    $json = array(
                        "status" => 404,
                        "detalle" => "metodo no encontrado"
    
                    );
    
                    echo json_encode($json, true);
    
                    return;
                }
            }else if (array_filter($arrayRuters)[1] == "estado_orden" && is_numeric(array_filter($arrayRuters)[2])){
                if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "PUT") {
                    $datos = array();
                    parse_str(file_get_contents('php://input'),$datos);
                    $editarestado_orden = new ControladorEstadoOrden();
                    $editarestado_orden -> update(array_filter($arrayRuters)[2],$datos);
                }else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                    $estado_orden = new ControladorEstadoOrden();
                    $estado_orden -> show(array_filter($arrayRuters)[2]);
                } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "DELETE") {
                    $borrarestado_orden = new ControladorEstadoOrden();
                    $borrarestado_orden -> delete(array_filter($arrayRuters)[2]);
                } else {
                    $json = array(
                        "status" => 404,
                        "detalle" => "metodo no encontrado"
    
                    );
    
                    echo json_encode($json, true);
    
                    return;
                }
            }else if (array_filter($arrayRuters)[1] == "usuario" && is_numeric(array_filter($arrayRuters)[2])){
                if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "PUT") {
                    $datos = array();
                    parse_str(file_get_contents('php://input'),$datos);
                    $editarusuario = new ControladorUsuario();
                    $editarusuario -> update(array_filter($arrayRuters)[2],$datos);
                }else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                    $usuario = new ControladorUsuario();
                    $usuario -> show(array_filter($arrayRuters)[2]);
                } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "DELETE") {
                    $borrarusuario = new ControladorUsuario();
                    $borrarusuario -> delete(array_filter($arrayRuters)[2]);
                } else {
                    $json = array(
                        "status" => 404,
                        "detalle" => "metodo no encontrado"
    
                    );
    
                    echo json_encode($json, true);
    
                    return;
                }
            }else {
                $json = array(
                    "status" => 404,
                    "detalle" => "No encontrado metodo http"
    
                );
    
                echo json_encode($json, true);
    
                return;
            }
        }else{
            $json = array(
                "status" => 404,
                "detalle" => "No encontrado"
    
            );
    
            echo json_encode($json, true);
    
            return;
        }
    }
    
}
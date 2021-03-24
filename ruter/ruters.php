<?php
header("Content-type: application/json; charset=utf-8");

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
                $Objetolineas = new ControladorLinea();
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
                        "id_informe" => $_POST['id_informe'],
                        "id" => $_POST['id'],
                        "turno" => $_POST['turno'],
                        "saldo_anterior" => $_POST['saldo_anterior'],
                        "observacion" => $_POST['observacion'],
                        "completado" => $_POST['completado'],
                        "id_proceso" => $_POST['id_proceso'],
                        "id_material" => $_POST['id_material'],
                        "id_tipo_material" => $_POST['id_tipo_material']
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
                        "id_registro" => $_POST['id_registro'],
                        "fecha_hora_inicio" => date("Y-m-d H:i:s"),
                        "fecha_hora_fin" => date("Y-m-d H:i:s"),
                        "id_personal" => $_POST['id_personal'],
                        "id_informe" => $_POST['id_informe']
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
                        "id_personal" => $_POST['id_personal'],
                        "nombre" => $_POST['nombre'],
                        "apellido" => $_POST['apellido'],
                        "cedula" => $_POST['cedula']
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
            } else if (array_filter($arrayRuters)[1] == "tipo_desperdicio") {
                /*=====================================================
                Cuando se hace peticiones nova-apiproduccion.com/motivo
                =======================================================*/
                $Objetotipodesperdicio = new ControladorTipoDesperdicio();
                if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                    $Objetotipodesperdicio->index();
                } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
                    $datos = array(
                        "nombre" => $_POST['nombre']
                    );
                    $Objetotipodesperdicio->create($datos);
                } else {
                    $json = array(
                        "status" => 404,
                        "detalle" => "No encontrado metodo http tipo de desperdicio"
    
                    );
    
                    echo json_encode($json, true);
    
                    return;
                }
            }else if (array_filter($arrayRuters)[1] == "scrap") {
                /*=====================================================
                Cuando se hace peticiones nova-apiproduccion.com/motivo
                =======================================================*/
                $Objetoscrap = new ControladorScrap();
                if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                    $Objetoscrap->index();
                } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
                    $datos = array(
                        "id_scrap" => $_POST['id_scrap'],
                        "motivo" => $_POST['motivo'],
                        "sacos" => $_POST['sacos'],
                        "peso" => $_POST['peso'],
                        "id_informe" => $_POST['id_informe']
                    );
                    $Objetoscrap->create($datos);
                } else {
                    $json = array(
                        "status" => 404,
                        "detalle" => "No encontrado metodo http scrap"
    
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
                        "tarifa_kilogramo_producidos" => $_POST['tarifa_kilogramo_producidos'],
                        "estado" => $_POST['estado'],
                        "id_proceso" => $_POST['id_proceso'],
                        "id_material" => $_POST['id_material'],
                        "id_tipo_material" => $_POST['id_tipo_material']
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
            } else if (array_filter($arrayRuters)[1] == "materia_prima") {
                /*=====================================================
                Cuando se hace peticiones nova-apiproduccion.com/tipo_personal
                =======================================================*/
                $Objetomateriaprima = new ControladorMateriaPrima();
                if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                    $Objetomateriaprima->index();
                } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
                    $datos = array(
                        "id_materia_prima"=>$_POST['id_materia_prima'],
                        "id_configuracion" => $_POST['id_configuracion'],
                        "id_color" => $_POST['id_color'],
                        "id_informe" => $_POST['id_informe'],
                        "peso" => $_POST['peso'],
                    );
                    $Objetomateriaprima->create($datos);
                } else {
                    $json = array(
                        "status" => 404,
                        "detalle" => "No encontrado metodo http materia prima"
    
                    );
    
                    echo json_encode($json, true);
    
                    return;
                }
            } else if (array_filter($arrayRuters)[1] == "producto_terminado") {
                /*=====================================================
                Cuando se hace peticiones nova-apiproduccion.com/area_trabajo
                =======================================================*/
                $Objetoproductoterminado = new ControladorProductoTerminado();
                if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                    $Objetoproductoterminado->index();
                } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
                    $datos = array(
                        "id_producto_terminado"=>$_POST['id_producto_terminado'],
                        "id_informe" => $_POST['id_informe'],
                        "id_color" => $_POST['id_color'],
                        "tipo" => $_POST['tipo'],
                        "peso" => $_POST['peso']
                    );
                    $Objetoproductoterminado->create($datos);
                } else {
                    $json = array(
                        "status" => 404,
                        "detalle" => "No encontrado metodo http producto terminado"
    
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
                        "pass" => $_POST["pass"]
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
                    $editarlinea = new ControladorLinea();
                    $editarlinea -> update(array_filter($arrayRuters)[2],$datos);
                }else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                    $linea = new ControladorLinea();
                    $linea -> show(array_filter($arrayRuters)[2]);
                } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "DELETE") {
                    $borrarlinea = new ControladorLinea();
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
            }else if (array_filter($arrayRuters)[1] == "tipo_desperdicio" && is_numeric(array_filter($arrayRuters)[2])){
                if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "PUT") {
                    $datos = array();
                    parse_str(file_get_contents('php://input'),$datos);
                    $editartipodesperdicio = new ControladorTipoDesperdicio();
                    $editartipodesperdicio -> update(array_filter($arrayRuters)[2],$datos);
                }else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                    $tipodesperdicio = new ControladorTipoDesperdicio();
                    $tipodesperdicio -> show(array_filter($arrayRuters)[2]);
                } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "DELETE") {
                    $borrartipodesperdicio = new ControladorTipoDesperdicio();
                    $borrartipodesperdicio -> delete(array_filter($arrayRuters)[2]);
                } else {
                    $json = array(
                        "status" => 404,
                        "detalle" => "metodo no encontrado"
    
                    );
    
                    echo json_encode($json, true);
    
                    return;
                }
            }else if (array_filter($arrayRuters)[1] == "scrap" && is_numeric(array_filter($arrayRuters)[2])){
                if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "PUT") {
                    $datos = array();
                    parse_str(file_get_contents('php://input'),$datos);
                    $editarscrap = new ControladorScrap();
                    $editarscrap -> update(array_filter($arrayRuters)[2],$datos);
                }else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                    $scrap = new ControladorScrap();
                    $scrap -> show(array_filter($arrayRuters)[2]);
                } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "DELETE") {
                    $borrarscrap = new ControladorScrap();
                    $borrarscrap -> delete(array_filter($arrayRuters)[2]);
                } else {
                    $json = array(
                        "status" => 404,
                        "detalle" => "metodo no encontrado"
    
                    );
    
                    echo json_encode($json, true);
    
                    return;
                }
            }else if (array_filter($arrayRuters)[1] == "materia_prima" && is_numeric(array_filter($arrayRuters)[2])){
                if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "PUT") {
                    $datos = array();
                    parse_str(file_get_contents('php://input'),$datos);
                    $editarmateria_prima = new ControladorMateriaPrima();
                    $editarmateria_prima -> update(array_filter($arrayRuters)[2],$datos);
                }else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                    $materia_prima = new ControladorMateriaPrima();
                    $materia_prima -> show(array_filter($arrayRuters)[2]);
                } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "DELETE") {
                    $borrarmateria_prima = new ControladorMateriaPrima();
                    $borrarmateria_prima -> delete(array_filter($arrayRuters)[2]);
                } else {
                    $json = array(
                        "status" => 404,
                        "detalle" => "metodo no encontrado"
    
                    );
    
                    echo json_encode($json, true);
    
                    return;
                }
            }else if (array_filter($arrayRuters)[1] == "producto_terminado" && is_numeric(array_filter($arrayRuters)[2])){
                if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "PUT") {
                    $datos = array();
                    parse_str(file_get_contents('php://input'),$datos);
                    $editarproductoterminado = new ControladorProductoTerminado();
                    $editarproductoterminado -> update(array_filter($arrayRuters)[2],$datos);
                }else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                    $productoterminado = new ControladorProductoTerminado();
                    $productoterminado -> show(array_filter($arrayRuters)[2]);
                } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "DELETE") {
                    $borrarproductoterminado = new ControladorProductoTerminado();
                    $borrarproductoterminado -> delete(array_filter($arrayRuters)[2]);
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
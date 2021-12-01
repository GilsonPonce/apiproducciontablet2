<?php

header('Access-Control-Allow-Origin','*' );
header('Access-Control-Allow-Credentials', true);
//header('Content-Type: application/json; charset=utf-8');
//header('Access-Control-Allow-Origin: *.novared.local');
//header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
//header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");

/* controladores */
require_once "controller/rutas_controller.php";
require_once "controller/login_controller.php";
require_once "controller/reporte_controller.php";

require_once "controller/lineas_controller.php";
require_once "controller/proceso_controller.php";
require_once "controller/color_controller.php";
require_once "controller/informe_controller.php";
require_once "controller/material_controller.php";
require_once "controller/personal_controller.php";
require_once "controller/registro_controller.php";
require_once "controller/tipoMaterial_controller.php";
require_once "controller/configuracion_controller.php";
require_once "controller/materiaPrima_controller.php";
require_once "controller/productoTerminado_controller.php";
require_once "controller/scrap_controller.php";
require_once "controller/tipoScrap_controller.php";
require_once "controller/usuario_controller.php";
require_once "controller/permisos_controller.php";
require_once "controller/motivoParada_controller.php";
require_once "controller/parada_controller.php";
require_once "controller/pdf_function.php";



/* modelos */
require_once "model/reporte_model.php";
require_once "model/linea_model.php";
require_once "model/proceso_model.php";
require_once "model/color_model.php";
require_once "model/informe_model.php";
require_once "model/material_model.php";
require_once "model/personal_model.php";
require_once "model/registro_model.php";
require_once "model/tipoMaterial_model.php";
require_once "model/configuracion_model.php";
require_once "model/materiaPrima_model.php";
require_once "model/productoTerminado_model.php";
require_once "model/scrap_model.php";
require_once "model/tipoScrap_model.php";
require_once "model/usuario_model.php";
require_once "model/permisos_model.php";
require_once "model/motivoParada_model.php";
require_once "model/parada_model.php";


$rutas = new ControllerRuter();
$rutas->index();

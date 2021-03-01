<?php

header('Access-Control-Allow-Origin: *');

/* controladores */
require_once "controller/rutas_controller.php";
require_once "controller/lineas_controller.php";
require_once "controller/athu/usuario_controller.php";
require_once "controller/proceso_controller.php";
require_once "controller/orden_controller.php";
require_once "controller/areaTrabajo_controller.php";
require_once "controller/color_controller.php";
require_once "controller/estadoorden_controller.php";
require_once "controller/estadoregistro_controller.php";
require_once "controller/informe_controller.php";
require_once "controller/material_controller.php";
require_once "controller/motivo_controller.php";
require_once "controller/parada_controller.php";
require_once "controller/personal_controller.php";
require_once "controller/peso_controller.php";
require_once "controller/registro_controller.php";
require_once "controller/tipoMaterial_controller.php";
require_once "controller/tipoPersonal_controller.php";
require_once "controller/estadopeso_controller.php";
require_once "controller/propiedad_controller.php";
require_once "controller/configuracion_controller.php";
require_once "controller/turno_controller.php";

/* modelos */
require_once "model/lineas_model.php";
require_once "model/athu/areatrabajo_model.php";
require_once "model/athu/tipousuario_model.php";
require_once "model/athu/usuario_model.php";
require_once "model/proceso_model.php";
require_once "model/orden_model.php";
require_once "model/areaTrabajo_model.php";
require_once "model/color_model.php";
require_once "model/estadoorden_model.php";
require_once "model/estadoregistro_model.php";
require_once "model/informe_model.php";
require_once "model/material_model.php";
require_once "model/motivo_model.php";
require_once "model/personal_model.php";
require_once "model/peso_model.php";
require_once "model/registro_model.php";
require_once "model/tipoMaterial_model.php";
require_once "model/tipoPersonal_model.php";
require_once "model/estadopeso_model.php";
require_once "model/parada_model.php";
require_once "model/propiedad_model.php";
require_once "model/configuracion_model.php";
require_once "model/turno_model.php";


$rutas = new ControllerRuter();
$rutas->index();

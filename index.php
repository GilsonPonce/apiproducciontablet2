<?php

/* controladores */
require_once "controller/rutas_controller.php";
require_once "controller/lineas_controller.php";
require_once "controller/athu/usuario_controller.php";
require_once "controller/proceso_controller.php";

/* modelos */
require_once "model/lineas_model.php";
require_once "model/athu/areatrabajo_model.php";
require_once "model/athu/tipousuario_model.php";
require_once "model/athu/usuario_model.php";
require_once "model/proceso_model.php";


$rutas = new ControllerRuter();
$rutas->index();

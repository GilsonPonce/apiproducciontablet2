<?php

/* controladores */
require_once "controller/rutas_controller.php";
/**Lineas de produccion*/
require_once "controller/lineas_controller.php";

/* modelos */
require_once "model/lineas_model.php";


$rutas = new ControllerRuter();
$rutas->index();

<?php

require_once("model/conexion.php");

class ModeloAreaTrabajoAthu{
    static public function select($tabla,$nombre){
        $stmt = Conexion::conectarAthu()->prepare("SELECT id_area_trabajo FROM $tabla WHERE nombre = ?");
        if($stmt->execute(array($nombre))){
            while ($fila = $stmt->fetch()){
                return $fila;
            }
        }
    }
}
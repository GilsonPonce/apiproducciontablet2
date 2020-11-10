<?php
require_once "model/conexion.php";
class ModeloTipoUsuario{
    static public function select($tabla, $nombre){
        $stmt = Conexion::conectarAthu()->prepare("SELECT id_tipo_usuario FROM $tabla WHERE nombre = ?");
        if($stmt->execute(array($nombre))){
            while ($fila = $stmt->fetch()){
                return $fila;
            }
        }
    }
}
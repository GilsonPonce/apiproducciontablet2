<?php

require_once "conexion.php";

class ModelosLineas
{
    static public function index($tabla)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function create($tabla, $nombre)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_linea, nombre) VALUES (null,:nombre)");
        $stmt->bindParam(':nombre',$nombre);
        $stmt->execute();
    }
}

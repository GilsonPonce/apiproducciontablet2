<?php

require_once "conexion.php";

class ModeloPeso
{
    static public function index($tabla)
    {
        $stmt = Conexion::conectarProduccion()->prepare("SELECT * FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function create($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("INSERT INTO $tabla(peso,id_informe,id_personal,id_estado_peso) 
        VALUES (:peso,:id_informe,:id_personal,:id_estado_peso)");

        $stmt->bindParam(":peso", $datos["peso"], PDO::PARAM_INT);
        $stmt->bindParam(":id_informe", $datos["id_informe"], PDO::PARAM_INT);
        $stmt->bindParam(":id_personal", $datos["id_personal"], PDO::PARAM_INT); 
        $stmt->bindParam(":id_estado_peso", $datos["id_estado_peso"], PDO::PARAM_INT); 

        if ($stmt->execute()) {

            return "ok";
        } else {

            print_r(Conexion::conectarProduccion()->errorInfo());
        }
        $stmt = null;
    }
}

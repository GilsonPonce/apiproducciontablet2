<?php

require_once "conexion.php";

class ModeloPersonal
{
    static public function index($tabla)
    {
        $stmt = Conexion::conectarProduccion()->prepare("SELECT * FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function create($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("INSERT INTO $tabla(nombre,apellido,cedula,id_tipo_personal,id_area_trabajo) 
        VALUES (:nombre,:apellido,:cedula,:id_tipo_personal,:id_area_trabajo)");

        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":apellido", $datos["apellido"], PDO::PARAM_STR);
        $stmt->bindParam(":cedula", $datos["cedula"], PDO::PARAM_STR);
        $stmt->bindParam(":id_tipo_personal", $datos["id_tipo_personal"], PDO::PARAM_INT);
        $stmt->bindParam(":id_area_trabajo", $datos["id_area_trabajo"], PDO::PARAM_INT);

        if ($stmt->execute()) {

            return "ok";
        } else {

            print_r(Conexion::conectarProduccion()->errorInfo());
        }
        $stmt = null;
    }
}

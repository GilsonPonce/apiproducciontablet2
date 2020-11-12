<?php

require_once "conexion.php";

class ModeloInforme
{
    static public function index($tabla)
    {
        $stmt = Conexion::conectarProduccion()->prepare("SELECT * FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function create($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("INSERT INTO $tabla(fecha_hora_inicio,fecha_hora_fin,orden_codigo) 
        VALUES (:fecha_hora_inicio,:fecha_hora_fin,:orden_codigo)");

        $stmt->bindParam(":fecha_hora_inicio", $datos["fecha_hora_inicio"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_hora_fin", $datos["fecha_hora_fin"], PDO::PARAM_STR);
        $stmt->bindParam(":orden_codigo", $datos["orden_codigo"], PDO::PARAM_STR);


        if ($stmt->execute()) {

            return "ok";
        } else {

            print_r(Conexion::conectarProduccion()->errorInfo());
        }
        $stmt = null;
    }
}
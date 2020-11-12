<?php

require_once "conexion.php";

class ModeloRegistro
{
    static public function index($tabla)
    {
        $stmt = Conexion::conectarProduccion()->prepare("SELECT * FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function create($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("INSERT INTO $tabla(fecha_hora_inicio,fecha_hora_fin,linea,proceso,id_personal,orden_codigo) 
        VALUES (:fecha_hora_inicio,:fecha_hora_fin,:linea,proceso,:id_personal,:orden_codigo)");

        $stmt->bindParam(":fecha_hora_inicio", $datos["fecha_hora_inicio"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_hora_fin", $datos["fecha_hora_fin"], PDO::PARAM_STR);
        $stmt->bindParam(":linea", $datos["linea"], PDO::PARAM_STR);
        $stmt->bindParam(":proceso", $datos["proceso"], PDO::PARAM_STR);
        $stmt->bindParam(":id_personal", $datos["id_personal"], PDO::PARAM_INT);
        $stmt->bindParam(":orden_codigo", $datos["orden_codigo"], PDO::PARAM_STR);

        if ($stmt->execute()) {

            return "ok";
        } else {

            print_r(Conexion::conectarProduccion()->errorInfo());
        }
        $stmt = null;
    }
}

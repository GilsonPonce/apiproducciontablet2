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
        $stmt = Conexion::conectarProduccion()->prepare("INSERT INTO $tabla(fecha_hora_inicio,fecha_hora_fin,linea,proceso,id_personal,orden_codigo,id_estado_registro) 
        VALUES (:fecha_hora_inicio,:fecha_hora_fin,:linea,proceso,:id_personal,:orden_codigo,:id_estado_registro)");

        $stmt->bindParam(":fecha_hora_inicio", $datos["fecha_hora_inicio"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_hora_fin", $datos["fecha_hora_fin"], PDO::PARAM_STR);
        $stmt->bindParam(":linea", $datos["linea"], PDO::PARAM_STR);
        $stmt->bindParam(":proceso", $datos["proceso"], PDO::PARAM_STR);
        $stmt->bindParam(":id_personal", $datos["id_personal"], PDO::PARAM_INT);
        $stmt->bindParam(":orden_codigo", $datos["orden_codigo"], PDO::PARAM_STR);
        $stmt->bindParam(":id_estado_registro", $datos["id_estado_registro"], PDO::PARAM_INT);

        if ($stmt->execute()) {

            return "ok";
        } else {

            print_r(Conexion::conectarProduccion()->errorInfo());
        }
        $stmt = null;
    }

    static public function update($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("UPDATE $tabla SET fecha_hora_inicio = :fecha_hora_inicio, fecha_hora_fin = :fecha_hora_fin, id_estado_registro = :id_estado_registro, linea = :linea, proceso = :proceso, id_personal = :id_personal, orden_codigo = :orden_codigo, id_estado_registro = :id_estado_registro WHERE id_registro = :id_registro");

        $stmt->bindParam(":fecha_hora_inicio", $datos["fecha_hora_inicio"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_hora_fin", $datos["fecha_hora_fin"], PDO::PARAM_STR);
        $stmt->bindParam(":linea", $datos["linea"], PDO::PARAM_STR);
        $stmt->bindParam(":proceso", $datos["proceso"], PDO::PARAM_STR);
        $stmt->bindParam(":id_personal", $datos["id_personal"], PDO::PARAM_INT);
        $stmt->bindParam(":orden_codigo", $datos["orden_codigo"], PDO::PARAM_STR);
        $stmt->bindParam(":id_estado_registro", $datos["id_estado_registro"], PDO::PARAM_INT);
        $stmt->bindParam(":id_registro", $datos["id_registro"], PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            print_r(Conexion::conectarProduccion()->errorInfo());
        }
        $stmt = null;
    }
}

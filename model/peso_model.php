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
        $stmt = Conexion::conectarProduccion()->prepare("INSERT INTO $tabla(numero,cantidad,peso,id_informe,id_color,id_tipo_material,id_tipo_peso,id_personal) 
        VALUES (:numero,:cantidad,:peso,:id_informe,:id_color,:id_tipo_material,:id_tipo_peso,:id_personal)");

        $stmt->bindParam(":numero", $datos["numero"], PDO::PARAM_INT);
        $stmt->bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_INT);
        $stmt->bindParam(":peso", $datos["peso"], PDO::PARAM_INT);
        $stmt->bindParam(":id_informe", $datos["id_informe"], PDO::PARAM_INT);
        $stmt->bindParam(":id_color", $datos["id_color"], PDO::PARAM_INT);
        $stmt->bindParam(":id_tipo_material", $datos["id_tipo_material"], PDO::PARAM_INT);
        $stmt->bindParam(":id_tipo_peso", $datos["id_tipo_peso"], PDO::PARAM_INT);
        $stmt->bindParam(":id_personal", $datos["id_personal"], PDO::PARAM_INT);

        if ($stmt->execute()) {

            return "ok";
        } else {

            print_r(Conexion::conectarProduccion()->errorInfo());
        }
        $stmt = null;
    }
}

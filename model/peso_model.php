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

    static public function show($tabla, $id)
    {
        $stmt = Conexion::conectarProduccion()->prepare("SELECT * FROM $tabla WHERE id_peso=:id_peso");
        $stmt->bindParam(":id_peso", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function create($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("INSERT INTO $tabla(kilogramo,orden_codigo,id_personal,id_estado_peso) 
        VALUES (:kilogramo,:orden_codigo,:id_personal,:id_estado_peso)");

        $stmt->bindParam(":kilogramo", $datos["kilogramo"], PDO::PARAM_INT);
        $stmt->bindParam(":orden_codigo", $datos["orden_codigo"], PDO::PARAM_STR);
        $stmt->bindParam(":id_personal", $datos["id_personal"], PDO::PARAM_INT);
        $stmt->bindParam(":id_estado_peso", $datos["id_estado_peso"], PDO::PARAM_INT);

        if ($stmt->execute()) {

            return "ok";
        } else {

            print_r(Conexion::conectarProduccion()->errorInfo());
        }
        $stmt = null;
    }

    static public function update($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("UPDATE $tabla SET kilogramo=:kilogramo,orden_codigo=:orden_codigo,id_personal=:id_personal,id_estado_peso=:id_estado_peso WHERE id_peso=:id_peso");

        $stmt->bindParam(":kilogramo", $datos["kilogramo"], PDO::PARAM_INT);
        $stmt->bindParam(":orden_codigo", $datos["orden_codigo"], PDO::PARAM_STR);
        $stmt->bindParam(":id_personal", $datos["id_personal"], PDO::PARAM_INT);
        $stmt->bindParam(":id_estado_peso", $datos["id_estado_peso"], PDO::PARAM_INT);

        if ($stmt->execute()) {

            return "ok";
        } else {

            print_r(Conexion::conectarProduccion()->errorInfo());
        }
        $stmt = null;
    }

    static public function delete($tabla, $id)
    {

        $stmt = Conexion::conectarProduccion()->prepare("DELETE FROM $tabla WHERE id_peso = :id_peso");

        $stmt->bindParam(":id_peso", $id, PDO::PARAM_INT);

        if ($stmt->execute()) {

            return "ok";
        } else {

            print_r(Conexion::conectarProduccion()->errorInfo());
        }

        $stmt->close();

        $stmt = null;
    }
}

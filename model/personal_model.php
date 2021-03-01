<?php

require_once "conexion.php";

class ModeloPersonal
{
    static public function index($tabla)
    {
        $sql ="Select per.id_personal, per.nombre, per.apellido, per.cedula, per.id_tipo_personal, per.id_area_trabajo,
        ti.nombre as tipo, are.nombre as area from $tabla per, tipo_personal ti, area_trabajo are where 
        ti.id_tipo_personal = per.id_tipo_personal and are.id_area_trabajo = per.id_area_trabajo";
        $stmt = Conexion::conectarProduccion()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function show($tabla,$id)
    {
        $sql ="Select per.id_personal, per.nombre, per.apellido, per.cedula, per.id_tipo_personal, per.id_area_trabajo,
        ti.nombre as tipo, are.nombre as area from $tabla per, tipo_personal ti, area_trabajo are where 
        ti.id_tipo_personal = per.id_tipo_personal and are.id_area_trabajo = per.id_area_trabajo and per.id_personal = :id_personal";
        $stmt = Conexion::conectarProduccion()->prepare($sql);
        $stmt -> bindParam(":id_personal", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function create($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("INSERT INTO $tabla(id_personal,nombre,apellido,cedula,id_tipo_personal,id_area_trabajo) 
        VALUES (:id_personal,:nombre,:apellido,:cedula,:id_tipo_personal,:id_area_trabajo)");

        $stmt->bindParam(":id_personal", $datos["id_personal"], PDO::PARAM_STR);
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
        $stmt-> close();
        $stmt = null;
    }

    static public function update($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("UPDATE $tabla SET nombre=:nombre,apellido=:apellido,cedula=:cedula,id_tipo_personal=:id_tipo_personal,id_area_trabajo=:id_area_trabajo WHERE id_personal=:id_personal");   
        
        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":apellido", $datos["apellido"], PDO::PARAM_STR);
        $stmt->bindParam(":cedula", $datos["cedula"], PDO::PARAM_STR);
        $stmt->bindParam(":id_tipo_personal", $datos["id_tipo_personal"], PDO::PARAM_INT);
        $stmt->bindParam(":id_area_trabajo", $datos["id_area_trabajo"], PDO::PARAM_INT);
        $stmt->bindParam(":id_personal", $datos["id_personal"], PDO::PARAM_INT);

        if ($stmt->execute()) {

            return "ok";
        } else {

            print_r(Conexion::conectarProduccion()->errorInfo());
        }
        $stmt-> close();
        $stmt = null;
    }

    static public function delete($tabla, $id){

		$stmt = Conexion::conectarProduccion()->prepare("DELETE FROM $tabla WHERE id_personal = :id_personal");

		$stmt -> bindParam(":id_personal", $id, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarProduccion()->errorInfo());
		}

		$stmt-> close();

		$stmt = null;

	}
}
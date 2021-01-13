<?php

require_once("model/conexion.php");

class ModeloAreaTrabajoAthu{
    
    static public function select($tabla,$nombre){
        $stmt = Conexion::conectarAthu()->prepare("SELECT id_area_trabajo FROM $tabla WHERE nombre = ?");
        if($stmt->execute(array($nombre))){
            while ($fila = $stmt->fetch()){
                return $fila;
            }
        }
    }

    static public function index($tabla)
    {
        $stmt = Conexion::conectarAthu()->prepare("SELECT * FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function show($tabla,$id)
    {
        $stmt = Conexion::conectarAthu()->prepare("SELECT * FROM $tabla WHERE id_area_trabajo=:id_area_trabajo");
        $stmt -> bindParam(":id_area_trabajo", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function create($tabla, $datos)
    {
        $stmt = Conexion::conectarAthu()->prepare("INSERT INTO $tabla(nombre) VALUES (:nombre)");

		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarAthu()->errorInfo());

		}
		$stmt = null;
    }

    static public function update($tabla, $datos)
    {
        $stmt = Conexion::conectarAthu()->prepare("UPDATE $tabla SET nombre=:nombre WHERE id_area_trabajo=:id_area_trabajo");

        $stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt -> bindParam(":id_area_trabajo", $datos["id_area_trabajo"], PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarAthu()->errorInfo());

		}
		$stmt = null;
    }

    static public function delete($tabla, $id){

		$stmt = Conexion::conectarAthu()->prepare("DELETE FROM $tabla WHERE id_area_trabajo = :id_area_trabajo");

		$stmt -> bindParam(":id_area_trabajo", $id, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarAthu()->errorInfo());
		}

		$stmt-> close();

		$stmt = null;

	}
}
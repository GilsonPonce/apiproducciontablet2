<?php

require_once "conexion.php";

class ModeloPropiedad
{
    static public function index($tabla)
    {
        $stmt = Conexion::conectarProduccion()->prepare("SELECT * FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function show($tabla,$id)
    {
        $stmt = Conexion::conectarProduccion()->prepare("SELECT * FROM $tabla WHERE id_propiedad=:id_propiedad");
        $stmt -> bindParam(":id_propiedad", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function create($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("INSERT INTO $tabla(id_propiedad,nombre) VALUES (null,:nombre)");

        $stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        //$stmt -> bindParam(":id_linea", $datos["id_linea"], PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarProduccion()->errorInfo());

		}
		$stmt = null;
    }

    static public function update($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("UPDATE $tabla SET nombre=:nombre WHERE id_propiedad=:id_propiedad");

        $stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        //$stmt -> bindParam(":id_linea", $datos["id_linea"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_propiedad", $datos["id_propiedad"], PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarProduccion()->errorInfo());

		}
		$stmt = null;
    }

    static public function delete($tabla, $id){

		$stmt = Conexion::conectarProduccion()->prepare("DELETE FROM $tabla WHERE id_propiedad = :id_propiedad");

		$stmt -> bindParam(":id_propiedad", $id, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarProduccion()->errorInfo());
		}

		$stmt-> close();

		$stmt = null;

	}
}
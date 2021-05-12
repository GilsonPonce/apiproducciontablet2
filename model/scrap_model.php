<?php

require_once "conexion.php";

class ModeloScrap
{
    static public function index($tabla)
    {
        $stmt = Conexion::conectarProduccion()->prepare("SELECT * FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function show($tabla,$id)
    {
        $stmt = Conexion::conectarProduccion()->prepare("SELECT * FROM $tabla WHERE id_scrap=:id_scrap");
        $stmt -> bindParam(":id_scrap", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function create($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("INSERT INTO $tabla(motivo,sacos,peso,id_informe) VALUES (:motivo,:sacos,:peso,:id_informe)");

        
		$stmt -> bindParam(":motivo", $datos["motivo"], PDO::PARAM_STR);
        $stmt -> bindParam(":sacos", $datos["sacos"], PDO::PARAM_STR);
        $stmt -> bindParam(":peso", $datos["peso"], PDO::PARAM_STR);
        $stmt -> bindParam(":id_informe", $datos["id_informe"], PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarProduccion()->errorInfo());

		}
		$stmt = null;
    }

    static public function update($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("UPDATE $tabla SET motivo=:motivo,sacos=:sacos,peso=:peso,id_informe=:id_informe WHERE id_scrap=:id_scrap");

        $stmt -> bindParam(":id_scrap", $datos["id_scrap"], PDO::PARAM_INT);
        $stmt -> bindParam(":motivo", $datos["motivo"], PDO::PARAM_STR);
        $stmt -> bindParam(":sacos", $datos["sacos"], PDO::PARAM_STR);
        $stmt -> bindParam(":peso", $datos["peso"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_informe", $datos["id_informe"], PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarProduccion()->errorInfo());

		}
		$stmt = null;
    }

    static public function delete($tabla, $id){

		$stmt = Conexion::conectarProduccion()->prepare("DELETE FROM $tabla WHERE id_scrap = :id_scrap");

		$stmt -> bindParam(":id_scrap", $id, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarProduccion()->errorInfo());
		}

		$stmt-> close();

		$stmt = null;

	}
}

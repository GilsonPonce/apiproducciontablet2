<?php

require_once "conexion.php";

class ModeloObservacion
{
    static public function index($tabla)
    {
        $stmt = Conexion::conectarProduccion()->prepare("SELECT * FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function create($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("INSERT INTO $tabla(detalle,id_informe) VALUES (:detalle,:id_informe)");

        $stmt -> bindParam(":detalle", $datos["detalle"], PDO::PARAM_STR);
        $stmt -> bindParam(":id_informe", $datos["id_informe"], PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarProduccion()->errorInfo());

		}
		$stmt = null;
    }
}
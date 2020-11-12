<?php

require_once "conexion.php";

class ModeloTipoMaterial
{
    static public function index($tabla)
    {
        $stmt = Conexion::conectarProduccion()->prepare("SELECT * FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function create($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("INSERT INTO $tabla(nombre,id_material) VALUES (:nombre,:id_material)");

        $stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt -> bindParam(":id_material", $datos["id_material"], PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarProduccion()->errorInfo());

		}
		$stmt = null;
    }
}
<?php

require_once "conexion.php";

class ModeloProductoTerminado
{
    static public function index($tabla)
    {
        $stmt = Conexion::conectarProduccion()->prepare("SELECT * FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function show($tabla,$id)
    {
        $stmt = Conexion::conectarProduccion()->prepare("SELECT * FROM $tabla WHERE id_producto_terminado=:id_producto_terminado");
        $stmt -> bindParam(":id_producto_terminado", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function create($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("INSERT INTO $tabla(id_producto_terminado,id_informe,id_color,peso,tipo) VALUES (:id_producto_terminado,:id_informe,:id_color,:peso,:tipo)");

        $stmt -> bindParam(":id_producto_terminado", $datos["id_producto_terminado"], PDO::PARAM_INT);
		$stmt -> bindParam(":id_informe", $datos["id_informe"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_color", $datos["id_color"], PDO::PARAM_INT);
        $stmt -> bindParam(":peso", $datos["peso"], PDO::PARAM_STR);
        $stmt -> bindParam(":tipo", $datos["tipo"], PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarProduccion()->errorInfo());

		}
		$stmt = null;
    }

    static public function update($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("UPDATE $tabla SET id_informe=:id_informe, id_color=:id_color, peso=:peso, tipo=:tipo WHERE id_producto_terminado=:id_producto_terminado");

        $stmt -> bindParam(":id_informe", $datos["id_informe"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_color", $datos["id_color"], PDO::PARAM_INT);
        $stmt -> bindParam(":peso", $datos["peso"], PDO::PARAM_STR);
        $stmt -> bindParam(":tipo", $datos["tipo"], PDO::PARAM_STR);
        $stmt -> bindParam(":id_producto_terminado", $datos["id_producto_terminado"], PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarProduccion()->errorInfo());

		}
		$stmt = null;
    }

    static public function delete($tabla, $id){

		$stmt = Conexion::conectarProduccion()->prepare("DELETE FROM $tabla WHERE id_producto_terminado = :id_producto_terminado");

		$stmt -> bindParam(":id_producto_terminado", $id, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarProduccion()->errorInfo());
		}

		$stmt-> close();

		$stmt = null;

	}
}

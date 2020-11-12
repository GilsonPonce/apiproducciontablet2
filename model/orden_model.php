<?php

require_once "conexion.php";

class ModeloOrden
{
    static public function index($tabla)
    {
        $stmt = Conexion::conectarProduccion()->prepare("SELECT * FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function create($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("INSERT INTO $tabla(orden_codigo,id_proceso,id_estado_orden) VALUES (:orden_codigo,:id_proceso,:id_estado_orden)");
        $stmt -> bindParam(":orden_codigo", $datos["orden_codigo"], PDO::PARAM_STR);
        $stmt -> bindParam(":id_proceso", $datos["id_proceso"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_estado_orden", $datos["id_estado_orden"], PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarProduccion()->errorInfo());

		}
		$stmt = null;
    }
}
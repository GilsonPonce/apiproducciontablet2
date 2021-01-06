<?php

require_once "conexion.php";

class ModeloOrden
{
    static public function index($tabla)
    {
        $stmt = Conexion::conectarProduccion()->prepare("SELECT * FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function show($tabla,$id)
    {
        $stmt = Conexion::conectarProduccion()->prepare("SELECT * FROM $tabla WHERE orden_codigo=:orden_codigo");
        $stmt -> bindParam(":orden_codigo", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function create($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("INSERT INTO $tabla(orden_codigo,hora_peso,peso_producir,id_tipo_material,id_color,id_proceso,id_estado_orden) VALUES (:orden_codigo,:hora_peso,:peso_producir,:id_tipo_material,:id_color,:id_proceso,:id_estado_orden)");
        $stmt -> bindParam(":orden_codigo", $datos["orden_codigo"], PDO::PARAM_STR);
        $stmt -> bindParam(":hora_peso", $datos["hora_peso"], PDO::PARAM_INT);
        $stmt -> bindParam(":peso_producir", $datos["peso_producir"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_tipo_material", $datos["id_tipo_material"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_color", $datos["id_color"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_proceso", $datos["id_proceso"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_estado_orden", $datos["id_estado_orden"], PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarProduccion()->errorInfo());

		}
		$stmt = null;
    }

    static public function update($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("UPDATE $tabla SET orden_codigo=:orden_codigo,hora_peso=:hora_peso,peso_producir=:peso_producir,id_tipo_material=:id_tipo_material,id_color=:id_color,id_proceso=:id_proceso,id_estado_orden=:id_estado_orden WHERE orden_codigo=:orden_codigo");
        $stmt -> bindParam(":orden_codigo", $datos["orden_codigo"], PDO::PARAM_STR);
        $stmt -> bindParam(":hora_peso", $datos["hora_peso"], PDO::PARAM_INT);
        $stmt -> bindParam(":peso_producir", $datos["peso_producir"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_tipo_material", $datos["id_tipo_material"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_color", $datos["id_color"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_proceso", $datos["id_proceso"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_estado_orden", $datos["id_estado_orden"], PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarProduccion()->errorInfo());

		}
		$stmt = null;
    }

    static public function delete($tabla, $id){

		$stmt = Conexion::conectarProduccion()->prepare("DELETE FROM $tabla WHERE orden_codigo = :orden_codigo");

		$stmt -> bindParam(":orden_codigo", $id, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarProduccion()->errorInfo());
		}

		$stmt-> close();

		$stmt = null;

	}
}
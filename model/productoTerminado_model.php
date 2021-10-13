<?php

require_once "conexion.php";

class ModeloProductoTerminado
{
    static public function index($tabla)
    {
        $sql = "SELECT pt.id_producto_terminado, pt.id_informe, pt.color, pt.peso, pt.tipo,
        li.id_linea, li.nombre as linea, pro.id_proceso, pro.nombre as proceso, cof.tipo_material,
        cof.material FROM $tabla pt, linea li, proceso pro, configuracion cof
        WHERE li.id_linea = pro.id_linea and pro.id_proceso = cof.id_proceso and
        cof.id_configuracion = pt.id_configuracion";
        $stmt = Conexion::conectarProduccion()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function show($tabla,$id)
    {
        $sql = "SELECT pt.id_producto_terminado, pt.id_informe, pt.color, pt.peso, pt.tipo,
        li.id_linea, li.nombre as linea, pro.id_proceso, pro.nombre as proceso, cof.tipo_material,
        cof.material FROM $tabla pt, linea li, proceso pro, configuracion cof
        WHERE li.id_linea = pro.id_linea and pro.id_proceso = cof.id_proceso and
        cof.id_configuracion = pt.id_configuracion and pt.id_producto_terminado = :id_producto_terminado";
        $stmt = Conexion::conectarProduccion()->prepare($sql);
        $stmt -> bindParam(":id_producto_terminado", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function create($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("INSERT INTO $tabla(id_informe,id_color,peso,tipo) VALUES (:id_informe,:id_color,:peso,:tipo)");

       
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

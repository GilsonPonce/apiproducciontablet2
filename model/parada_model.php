<?php

require_once "conexion.php";

class ModeloParada
{
    static public function index($tabla)
    {
        $sql="select pa.id_parada, pa.fecha_hora_inicio, pa.fecha_hora_fin, pa.id_motivo, pa.id_personal,
        concat(pe.apellido,' ',pe.nombre) as personal, mo.nombre as motivo, pa.estado, pa.orden_codigo from $tabla pa, personal pe, motivo mo
        where mo.id_motivo = pa.id_motivo and pe.id_personal = pa.id_personal";
        $stmt = Conexion::conectarProduccion()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function show($tabla,$id)
    {
        $sql="select pa.id_parada, pa.fecha_hora_inicio, pa.fecha_hora_fin, pa.id_motivo, pa.id_personal,
        concat(pe.apellido,' ',pe.nombre) as personal, mo.nombre as motivo, pa.estado, pa.orden_codigo from $tabla pa, personal pe, motivo mo
        where mo.id_motivo = pa.id_motivo and pe.id_personal = pa.id_personal and pa.id_parada=:id_parada";
        $stmt = Conexion::conectarProduccion()->prepare($sql);
        $stmt -> bindParam(":id_parada", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function create($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("INSERT INTO $tabla(orden_codigo,fecha_hora_inicio,fecha_hora_fin,id_motivo,id_personal,estado) 
        VALUES (:orden_codigo,:fecha_hora_inicio,:fecha_hora_fin,:id_motivo,:id_personal,:estado)");

        $stmt->bindParam(":orden_codigo", $datos["orden_codigo"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_hora_inicio", $datos["fecha_hora_inicio"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_hora_fin", $datos["fecha_hora_fin"], PDO::PARAM_STR);
        $stmt->bindParam(":id_motivo", $datos["id_motivo"], PDO::PARAM_INT);
        $stmt->bindParam(":id_personal", $datos["id_personal"], PDO::PARAM_INT);
        $stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_INT);

        if ($stmt->execute()) {

            return "ok";
        } else {

            print_r(Conexion::conectarProduccion()->errorInfo());
        }
        $stmt = null;
    }

    static public function update($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("UPDATE $tabla SET orden_codigo=:orden_codigo, fecha_hora_inicio=:fecha_hora_inicio,fecha_hora_fin=:fecha_hora_fin,id_motivo=:id_motivo,id_personal=:id_personal, estado=:estado WHERE id_parada=:id_parada");

        $stmt->bindParam(":orden_codigo", $datos["orden_codigo"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_hora_inicio", $datos["fecha_hora_inicio"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_hora_fin", $datos["fecha_hora_fin"], PDO::PARAM_STR);
        $stmt->bindParam(":id_motivo", $datos["id_motivo"], PDO::PARAM_INT);
        $stmt->bindParam(":id_personal", $datos["id_personal"], PDO::PARAM_INT);
        $stmt->bindParam(":id_parada", $datos["id_parada"], PDO::PARAM_INT);
        $stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_INT);

        if ($stmt->execute()) {

            return "ok";
        } else {

            print_r(Conexion::conectarProduccion()->errorInfo());
        }
        $stmt = null;
    }

    static public function delete($tabla, $id){

		$stmt = Conexion::conectarProduccion()->prepare("DELETE FROM $tabla WHERE id_parada = :id_parada");

		$stmt -> bindParam(":id_parada", $id, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarProduccion()->errorInfo());
		}

		$stmt-> close();

		$stmt = null;

	}
}

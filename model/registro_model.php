<?php

require_once "conexion.php";

class ModeloRegistro
{
    static public function index($tabla)
    {
        $sql="Select re.id_registro, re.fecha_hora_inicio, re.fecha_hora_fin, re.id_personal, re.orden_codigo, re.id_estado_registro,
        estre.nombre as estado, concat(per.nombre,' ',per.apellido) as personal from $tabla re, estado_registro estre, personal per
        where estre.id_estado_registro = re.id_estado_registro and per.id_personal = re.id_personal";
        $stmt = Conexion::conectarProduccion()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function show($tabla,$id)
    {
        $sql="Select re.id_registro, re.fecha_hora_inicio, re.fecha_hora_fin, re.id_personal, re.orden_codigo, re.id_estado_registro,
        estre.nombre as estado, concat(per.nombre,' ',per.apellido) as personal from $tabla re, estado_registro estre, personal per
        where estre.id_estado_registro = re.id_estado_registro and per.id_personal = re.id_personal and re.id_registro = :id_registro";
        $stmt = Conexion::conectarProduccion()->prepare($sql);
        $stmt -> bindParam(":id_registro", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function create($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("INSERT INTO $tabla(fecha_hora_inicio,fecha_hora_fin,id_personal,orden_codigo,id_estado_registro) 
        VALUES (:fecha_hora_inicio,:fecha_hora_fin,:id_personal,:orden_codigo,:id_estado_registro)");

        $stmt->bindParam(":fecha_hora_inicio", $datos["fecha_hora_inicio"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_hora_fin", $datos["fecha_hora_fin"], PDO::PARAM_STR);
        $stmt->bindParam(":id_personal", $datos["id_personal"], PDO::PARAM_INT);
        $stmt->bindParam(":orden_codigo", $datos["orden_codigo"], PDO::PARAM_STR);
        $stmt->bindParam(":id_estado_registro", $datos["id_estado_registro"], PDO::PARAM_INT);

        if ($stmt->execute()) {

            return "ok";
        } else {

            print_r(Conexion::conectarProduccion()->errorInfo());
        }
        $stmt = null;
    }

    static public function update($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("UPDATE $tabla SET fecha_hora_inicio = :fecha_hora_inicio, fecha_hora_fin = :fecha_hora_fin, id_estado_registro = :id_estado_registro, id_personal = :id_personal, orden_codigo = :orden_codigo, id_estado_registro = :id_estado_registro WHERE id_registro = :id_registro");

        $stmt->bindParam(":fecha_hora_inicio", $datos["fecha_hora_inicio"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_hora_fin", $datos["fecha_hora_fin"], PDO::PARAM_STR);
        $stmt->bindParam(":id_personal", $datos["id_personal"], PDO::PARAM_INT);
        $stmt->bindParam(":orden_codigo", $datos["orden_codigo"], PDO::PARAM_STR);
        $stmt->bindParam(":id_estado_registro", $datos["id_estado_registro"], PDO::PARAM_INT);
        $stmt->bindParam(":id_registro", $datos["id_registro"], PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            print_r(Conexion::conectarProduccion()->errorInfo());
        }
        $stmt = null;
    }

    static public function delete($tabla, $id){

		$stmt = Conexion::conectarProduccion()->prepare("DELETE FROM $tabla WHERE id_registro = :id_registro");

		$stmt -> bindParam(":id_registro", $id, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarProduccion()->errorInfo());
		}

		$stmt-> close();

		$stmt = null;

	}
}

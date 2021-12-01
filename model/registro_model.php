<?php

require_once "conexion.php";

class ModeloRegistro
{
    static public function index($tabla)
    {
        $sql="Select re.fecha_hora_inicio,re.fecha_hora_fin,re.activo,re.id_registro, re.id_personal, re.id_informe, concat(per.nombre,' ',per.apellido) as personal, re.motivo from $tabla re, personal per
        where per.id_personal = re.id_personal";
        $stmt = Conexion::conectarProduccion()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function show($tabla,$id)
    {
        $sql="Select re.fecha_hora_inicio, re.fecha_hora_fin,re.activo, re.id_registro, re.id_personal, re.id_informe, concat(per.nombre,' ',per.apellido) as personal, re.motivo from $tabla re, personal per
        where per.id_personal = re.id_personal and re.id_registro = :id_registro";
        $stmt = Conexion::conectarProduccion()->prepare($sql);
        $stmt -> bindParam(":id_registro", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function create($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("INSERT INTO $tabla(fecha_hora_inicio, fecha_hora_fin,activo, id_personal, id_informe,motivo) 
        VALUES (:fecha_hora_inicio, :fecha_hora_fin,:activo, :id_personal, :id_informe,:motivo)");

        $stmt->bindParam(":fecha_hora_fin", $datos["fecha_hora_fin"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_hora_inicio", $datos["fecha_hora_inicio"], PDO::PARAM_STR);  
        $stmt->bindParam(":id_personal", $datos["id_personal"], PDO::PARAM_INT);
        $stmt->bindParam(":id_informe", $datos["id_informe"], PDO::PARAM_INT);
        $stmt->bindParam(":activo", $datos["activo"], PDO::PARAM_INT);
        $stmt->bindParam(":motivo", $datos["motivo"], PDO::PARAM_STR);

        if ($stmt->execute()) {

            return "ok";
        } else {

            print_r(Conexion::conectarProduccion()->errorInfo());
        }
        $stmt = null;
    }

    static public function update($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("UPDATE $tabla SET fecha_hora_inicio=:fecha_hora_inicio, fecha_hora_fin=:fecha_hora_fin, activo=:activo ,id_personal=:id_personal, id_informe=:id_informe, motivo=:motivo WHERE id_registro = :id_registro");

        $stmt->bindParam(":fecha_hora_fin", $datos["fecha_hora_fin"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_hora_inicio", $datos["fecha_hora_inicio"], PDO::PARAM_STR);        
        $stmt->bindParam(":id_personal", $datos["id_personal"], PDO::PARAM_INT);
        $stmt->bindParam(":id_informe", $datos["id_informe"], PDO::PARAM_STR);
        $stmt->bindParam(":id_registro", $datos["id_registro"], PDO::PARAM_INT);
        $stmt->bindParam(":activo", $datos["activo"], PDO::PARAM_INT);
        $stmt->bindParam(":motivo", $datos["motivo"], PDO::PARAM_STR);

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

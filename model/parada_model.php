<?php

require_once "conexion.php";

class ModeloParada
{
    static public function index($tabla)
    {
        $sql="Select * from $tabla";
        $stmt = Conexion::conectarProduccion()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function show($tabla,$id)
    {
        $sql="Select * from $tabla where id_parada = :id_parada";
        $stmt = Conexion::conectarProduccion()->prepare($sql);
        $stmt -> bindParam(":id_parada", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function create($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("INSERT INTO $tabla(fecha_hora_inicio, fecha_hora_fin, motivo, id_informe) 
        VALUES (:fecha_hora_inicio, :fecha_hora_fin, :motivo, :id_informe)");

        $stmt->bindParam(":fecha_hora_fin", $datos["fecha_hora_fin"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_hora_inicio", $datos["fecha_hora_inicio"], PDO::PARAM_STR);  
        $stmt->bindParam(":motivo", $datos["motivo"], PDO::PARAM_STR);
        $stmt->bindParam(":id_informe", $datos["id_informe"], PDO::PARAM_INT);

        if ($stmt->execute()) {

            return "ok";
        } else {

            print_r(Conexion::conectarProduccion()->errorInfo());
        }
        $stmt = null;
    }

    static public function update($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("UPDATE $tabla SET fecha_hora_inicio=:fecha_hora_inicio, fecha_hora_fin=:fecha_hora_fin, id_informe=:id_informe, motivo=:motivo WHERE id_parada = :id_parada");

        $stmt->bindParam(":fecha_hora_fin", $datos["fecha_hora_fin"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_hora_inicio", $datos["fecha_hora_inicio"], PDO::PARAM_STR);  
        $stmt->bindParam(":id_parada", $datos["id_parada"], PDO::PARAM_INT);
        $stmt->bindParam(":motivo", $datos["motivo"], PDO::PARAM_STR);
        $stmt->bindParam(":id_informe", $datos["id_informe"], PDO::PARAM_STR);

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

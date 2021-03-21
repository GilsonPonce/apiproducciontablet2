<?php

require_once "conexion.php";

class ModeloInforme
{
    static public function index($tabla)
    {
        $stmt = Conexion::conectarProduccion()->prepare("SELECT * FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function show($tabla,$id)
    {
        $stmt = Conexion::conectarProduccion()->prepare("SELECT * FROM $tabla WHERE id_informe=:id_informe");
        $stmt -> bindParam(":id_informe", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function create($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("INSERT INTO $tabla(id,fecha,turno,saldo_anterior,observacion,completado,id_proceso,id_material,id_tipo_material) 
        VALUES (:id,:fecha,:turno,:saldo_anterior,:observacion,:completado,:id_proceso,:id_material,:id_tipo_material)");

        $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
        $stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
        $stmt->bindParam(":turno", $datos["turno"], PDO::PARAM_STR);
        $stmt->bindParam(":saldo_anterior", $datos["saldo_anterior"], PDO::PARAM_STR);
        $stmt->bindParam(":observacion", $datos["observacion"], PDO::PARAM_STR);
        $stmt->bindParam(":completado", $datos["completado"], PDO::PARAM_INT);
        $stmt->bindParam(":id_proceso", $datos["id_proceso"], PDO::PARAM_INT);
        $stmt->bindParam(":id_material", $datos["id_material"], PDO::PARAM_INT);
        $stmt->bindParam(":id_tipo_material", $datos["id_tipo_material"], PDO::PARAM_INT);
       


        if ($stmt->execute()) {

            return "ok";
        } else {

            print_r(Conexion::conectarProduccion()->errorInfo());
        }
        $stmt = null;
    }

    static public function update($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("UPDATE $tabla SET id=:id ,fecha=:fecha, turno=:turno, saldo_anterior=:saldo_anterior, observacion=:observacion, completado=:completado, id_proceso=:id_proceso, id_material=:id_material, id_tipo_material = id_tipo_material WHERE id_informe=:id_informe");

        $stmt->bindParam(":id_informe", $datos["id_informe"], PDO::PARAM_INT);
        $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
        $stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
        $stmt->bindParam(":turno", $datos["turno"], PDO::PARAM_STR);
        $stmt->bindParam(":saldo_anterior", $datos["saldo_anterior"], PDO::PARAM_STR);
        $stmt->bindParam(":observacion", $datos["observacion"], PDO::PARAM_STR);
        $stmt->bindParam(":completado", $datos["completado"], PDO::PARAM_INT);
        $stmt->bindParam(":id_proceso", $datos["id_proceso"], PDO::PARAM_INT);
        $stmt->bindParam(":id_material", $datos["id_material"], PDO::PARAM_INT);
        $stmt->bindParam(":id_tipo_material", $datos["id_tipo_material"], PDO::PARAM_INT);
       

        if ($stmt->execute()) {

            return "ok";
        } else {

            print_r(Conexion::conectarProduccion()->errorInfo());
        }
        $stmt = null;
    }

    static public function delete($tabla, $id){

		$stmt = Conexion::conectarProduccion()->prepare("DELETE FROM $tabla WHERE id_informe = :id_informe");

		$stmt -> bindParam(":id_informe", $id, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarProduccion()->errorInfo());
		}

		$stmt-> close();

		$stmt = null;

	}
}
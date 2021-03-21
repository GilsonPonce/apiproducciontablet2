<?php
require_once "model/conexion.php";
class ModeloUsuario
{
    static public function index($tabla){
        $stmt = Conexion::conectarProduccion()->prepare("SELECT * FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function show($tabla,$id)
    {
        $stmt = Conexion::conectarProduccion()->prepare("SELECT * FROM $tabla WHERE id_usuario=:id_usuario");
        $stmt -> bindParam(":id_usuario", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function create($tabla,$datos){
        $stmt = Conexion::conectarProduccion()->prepare("INSERT INTO $tabla(nombre, apellido, cedula, correo, fecha_creacion, pass, padlock, keylock) VALUES (:nombre, :apellido, :cedula, :correo, :fecha_creacion, :pass, :padlock, :keylock)");

		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt -> bindParam(":apellido", $datos["apellido"], PDO::PARAM_STR);
        $stmt -> bindParam(":cedula", $datos["cedula"], PDO::PARAM_STR);
		$stmt -> bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha_creacion", $datos["fecha_creacion"], PDO::PARAM_STR);
		$stmt -> bindParam(":pass", $datos["pass"], PDO::PARAM_STR);
		$stmt -> bindParam(":padlock", $datos["padlock"], PDO::PARAM_STR);
        $stmt -> bindParam(":keylock", $datos["keylock"], PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarProduccion()->errorInfo());

		}
		$stmt = null;
    }

    static public function update($tabla,$datos){
        $stmt = Conexion::conectarProduccion()->prepare("UPDATE $tabla SET nombre=:nombre, apellido=:apellido, cedula=:cedula, correo=:correo, fecha_creacion=:fecha_creacion, pass=:pass, padlock=:padlock, keylock=:keylock WHERE id_usuario=:id_usuario");

		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt -> bindParam(":apellido", $datos["apellido"], PDO::PARAM_STR);
        $stmt -> bindParam(":cedula", $datos["cedula"], PDO::PARAM_STR);
		$stmt -> bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha_creacion", $datos["fecha_creacion"], PDO::PARAM_STR);
		$stmt -> bindParam(":pass", $datos["pass"], PDO::PARAM_STR);
		$stmt -> bindParam(":padlock", $datos["padlock"], PDO::PARAM_STR);
        $stmt -> bindParam(":keylock", $datos["keylock"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarProduccion()->errorInfo());

		}
		$stmt = null;
    }

    static public function delete($tabla, $id){

		$stmt = Conexion::conectarProduccion()->prepare("DELETE FROM $tabla WHERE id_usuario = :id_usuario");

		$stmt -> bindParam(":id_usuario", $id, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarProduccion()->errorInfo());
		}

		$stmt-> close();

		$stmt = null;

	}

}
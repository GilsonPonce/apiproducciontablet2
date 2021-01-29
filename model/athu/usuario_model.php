<?php
require_once "model/conexion.php";
class ModeloUsuario
{
    static public function index($tabla){
        $stmt = Conexion::conectarAthu()->prepare("SELECT * FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function show($tabla,$id)
    {
        $stmt = Conexion::conectarAthu()->prepare("SELECT * FROM $tabla WHERE id_usuario=:id_usuario");
        $stmt -> bindParam(":id_usuario", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function create($tabla,$datos){
        $stmt = Conexion::conectarAthu()->prepare("INSERT INTO $tabla(nombre, apellido, cedula, correo, fecha_creacion, llave, codigo, id_tipo_usuario, id_area_trabajo) VALUES (:nombre, :apellido, :cedula, :correo, :fecha_creacion, :llave, :codigo, :id_tipo_usuario, :id_area_trabajo)");

		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt -> bindParam(":apellido", $datos["apellido"], PDO::PARAM_STR);
        $stmt -> bindParam(":cedula", $datos["cedula"], PDO::PARAM_STR);
		$stmt -> bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha_creacion", $datos["fecha_creacion"], PDO::PARAM_STR);
		$stmt -> bindParam(":llave", $datos["llave"], PDO::PARAM_STR);
		$stmt -> bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
        $stmt -> bindParam(":id_tipo_usuario", $datos["id_tipo_usuario"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_area_trabajo", $datos["id_area_trabajo"], PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarAthu()->errorInfo());

		}
		$stmt = null;
    }

    static public function update($tabla,$datos){
        $stmt = Conexion::conectarAthu()->prepare("UPDATE $tabla SET nombre=:nombre, apellido=:apellido, cedula=:cedula, correo=:correo, fecha_creacion=:fecha_creacion, llave=:llave, codigo=:codigo, id_tipo_usuario=:id_tipo_usuario, id_area_trabajo=:id_area_trabajo WHERE id_usuario=:id_usuario");

		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt -> bindParam(":apellido", $datos["apellido"], PDO::PARAM_STR);
        $stmt -> bindParam(":cedula", $datos["cedula"], PDO::PARAM_STR);
		$stmt -> bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha_creacion", $datos["fecha_creacion"], PDO::PARAM_STR);
		$stmt -> bindParam(":llave", $datos["llave"], PDO::PARAM_STR);
		$stmt -> bindParam(":codigo", $d+atos["codigo"], PDO::PARAM_STR);
        $stmt -> bindParam(":id_tipo_usuario", $datos["id_tipo_usuario"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_area_trabajo", $datos["id_area_trabajo"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarAthu()->errorInfo());

		}
		$stmt = null;
    }

    static public function delete($tabla, $id){

		$stmt = Conexion::conectarAthu()->prepare("DELETE FROM $tabla WHERE id_usuario = :id_usuario");

		$stmt -> bindParam(":id_usuario", $id, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarAthu()->errorInfo());
		}

		$stmt-> close();

		$stmt = null;

	}

}
<?php
require_once "model/conexion.php";
class ModeloUsuario
{
    static public function index($tabla){
        $stmt = Conexion::conectarAthu()->prepare("SELECT * FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll();
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

}
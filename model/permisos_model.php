<?php
class ModeloPermisos{

    static public function index($tabla){
        $sql = "Select per.id_permiso, per.nombre_pestaña, concat(usu.nombre,' ',usu.apellido) as personal
        from $tabla per, usuario usu";
        $stmt = Conexion::conectarProduccion()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function show($tabla,$id)
    {
        $sql = "Select per.id_permiso, per.nombre_pestaña, concat(usu.nombre,' ',usu.apellido) as personal
        from $tabla per, usuario usu WHERE per.id_permiso = :id_permiso";
        $stmt = Conexion::conectarProduccion()->prepare($sql);
        $stmt -> bindParam(":id_permiso", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function create($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("INSERT INTO $tabla(nombre_pestaña,id_usuario) VALUES (:nombre_pestaña,:id_usuario)");
        
        $stmt -> bindParam(":nombre_pestaña", $datos["nombre_pestaña"], PDO::PARAM_STR);
        $stmt -> bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarProduccion()->errorInfo());

		}
		$stmt = null;
    }

    static public function update($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("UPDATE $tabla SET nombre_pestaña=:nombre_pestaña, id_usuario=:id_usuario WHERE id_permiso=:id_permiso");
        
        $stmt -> bindParam(":nombre_pestaña", $datos["nombre_pestaña"], PDO::PARAM_STR);
        $stmt -> bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_permiso", $datos["id_permiso"], PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarProduccion()->errorInfo());

		}
		$stmt = null;
    }

    static public function delete($tabla, $id){

		$stmt = Conexion::conectarProduccion()->prepare("DELETE FROM $tabla WHERE id_permiso = :id_permiso");

		$stmt -> bindParam(":id_permiso", $id, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarProduccion()->errorInfo());
		}

		$stmt-> close();

		$stmt = null;

	}
}
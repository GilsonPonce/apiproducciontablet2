<?php
class ModeloProceso{

    static public function index($tabla){
        $sql = "Select pro.id_proceso, pro.nombre, pro.id_linea, li.nombre as linea 
        from $tabla pro, linea li where li.id_linea=pro.id_linea";
        $stmt = Conexion::conectarProduccion()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function show($tabla,$id)
    {
        $sql = "Select pro.id_proceso, pro.nombre, pro.id_linea, li.nombre as linea 
        from $tabla pro, linea li where li.id_linea=pro.id_linea and pro.id_proceso = :id_proceso";
        $stmt = Conexion::conectarProduccion()->prepare($sql);
        $stmt -> bindParam(":id_proceso", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function create($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("INSERT INTO $tabla(nombre,id_linea) VALUES (:nombre,:id_linea)");
        
        $stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt -> bindParam(":id_linea", $datos["id_linea"], PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarProduccion()->errorInfo());

		}
		$stmt = null;
    }

    static public function update($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("UPDATE $tabla SET nombre=:nombre, id_linea=:id_linea WHERE id_proceso=:id_proceso");
        
        $stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt -> bindParam(":id_linea", $datos["id_linea"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_proceso", $datos["id_proceso"], PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarProduccion()->errorInfo());

		}
		$stmt = null;
    }

    static public function delete($tabla, $id){

		$stmt = Conexion::conectarProduccion()->prepare("DELETE FROM $tabla WHERE id_proceso = :id_proceso");

		$stmt -> bindParam(":id_proceso", $id, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarProduccion()->errorInfo());
		}

		$stmt-> close();

		$stmt = null;

	}
}
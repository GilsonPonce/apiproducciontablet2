<?php

require_once "conexion.php";

class ModeloMateriaPrima
{
    static public function index($tabla)
    {
        $sql = "SELECT mp.id_materia_prima, mp.id_configuracion, mp.id_informe, mp.peso,
        li.id_linea, li.nombre as linea, pro.id_proceso, pro.nombre as proceso, cof.tipo_material,
        cof.material, mp.color 
        FROM $tabla mp, configuracion cof, linea li, proceso pro
        WHERE cof.id_configuracion = mp.id_configuracion and li.id_linea = pro.id_linea
        and pro.id_proceso = cof.id_proceso";
        $stmt = Conexion::conectarProduccion()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function show($tabla,$id)
    {
        $sql = "SELECT mp.id_materia_prima, mp.id_configuracion, mp.id_informe, mp.peso,
        li.id_linea, li.nombre as linea, pro.id_proceso, pro.nombre as proceso, cof.tipo_material,
        cof.material, mp.color 
        FROM $tabla mp, configuracion cof, linea li, proceso pro
        WHERE cof.id_configuracion = mp.id_configuracion and li.id_linea = pro.id_linea
        and pro.id_proceso = cof.id_proceso and mp.id_materia_prima = :id_materia_prima";
    
        $stmt = Conexion::conectarProduccion()->prepare($sql);
        $stmt -> bindParam(":id_materia_prima", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function create($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("INSERT INTO $tabla(id_configuracion,color,id_informe,peso) VALUES (:id_configuracion,:color,:id_informe,:peso)");

    
        $stmt -> bindParam(":id_configuracion", $datos["id_configuracion"], PDO::PARAM_INT);
        $stmt -> bindParam(":color", $datos["color"], PDO::PARAM_STR);
        $stmt -> bindParam(":id_informe", $datos["id_informe"], PDO::PARAM_INT);
        $stmt -> bindParam(":peso", $datos["peso"], PDO::PARAM_STR);    

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarProduccion()->errorInfo());

		}
		$stmt = null;
    }

    static public function update($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("UPDATE $tabla SET id_configuracion=:id_configuracion, color=:color, id_informe=:id_informe, peso=:peso WHERE id_materia_prima=:id_materia_prima");

        $stmt -> bindParam(":id_configuracion", $datos["id_configuracion"], PDO::PARAM_INT);
        $stmt -> bindParam(":color", $datos["color"], PDO::PARAM_STR);
        $stmt -> bindParam(":id_informe", $datos["id_informe"], PDO::PARAM_INT);
        $stmt -> bindParam(":peso", $datos["peso"], PDO::PARAM_STR);    
        $stmt -> bindParam(":id_materia_prima", $datos["id_materia_prima"], PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarProduccion()->errorInfo());

		}
		$stmt = null;
    }

    static public function delete($tabla, $id){

		$stmt = Conexion::conectarProduccion()->prepare("DELETE FROM $tabla WHERE id_materia_prima = :id_materia_prima");

		$stmt -> bindParam(":id_materia_prima", $id, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarProduccion()->errorInfo());
		}

		$stmt-> close();

		$stmt = null;

	}
}

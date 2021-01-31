<?php

require_once "conexion.php";

class ModeloConfiguracion
{
    static public function index($tabla)
    {
        $sql = "SELECT * FROM $tabla";
        $stmt = Conexion::conectarProduccion()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function show($tabla,$id)
    {
        $sql = "SELECT * FROM $tabla WHERE id_configuracion = :id_configuracion";
        $stmt = Conexion::conectarProduccion()->prepare($sql);
        $stmt -> bindParam(":id_configuracion", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function create($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("INSERT INTO $tabla(kilogramo_diario,kilogramo_hora,tarifa_kilogramos_producidos,estado,id_proceso,id_material,id_tipo_material,id_propiedad) VALUES (:kilogramo_diario,:kilogramo_hora,:tarifa_kilogramos_producidos,:estado,:id_proceso,:id_material,:id_tipo_material,:id_propiedad)");
        $stmt -> bindParam(":kilogramo_diario", $datos["kilogramo_diario"], PDO::PARAM_INT);
        $stmt -> bindParam(":kilogramo_hora", $datos["kilogramo_hora"], PDO::PARAM_INT);
        $stmt -> bindParam(":tarifa_kilogramos_producidos", $datos["tarifa_kilogramos_producidos"], PDO::PARAM_INT);
        $stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_proceso", $datos["id_proceso"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_material", $datos["id_material"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_tipo_material", $datos["id_tipo_material"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_propiedad", $datos["id_propiedad"], PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarProduccion()->errorInfo());

		}
		$stmt = null;
    }

    static public function update($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("UPDATE $tabla SET kilogramo_diario = :kilogramo_diario,kilogramo_hora=:kilogramo_hora,tarifa_kilogramos_producidos=:tarifa_kilogramos_producidos,estado=:estado,id_proceso = :id_proceso,id_material = :id_material,id_tipo_material = :id_tipo_material,id_propiedad=:id_propiedad WHERE id_configuracion=:id_configuracion");
        $stmt -> bindParam(":id_configuracion", $datos["id_configuracion"], PDO::PARAM_INT);
        $stmt -> bindParam(":kilogramo_diario", $datos["kilogramo_diario"], PDO::PARAM_INT);
        $stmt -> bindParam(":kilogramo_hora", $datos["kilogramo_hora"], PDO::PARAM_INT);
        $stmt -> bindParam(":tarifa_kilogramos_producidos", $datos["tarifa_kilogramos_producidos"], PDO::PARAM_INT);
        $stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_proceso", $datos["id_proceso"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_material", $datos["id_material"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_tipo_material", $datos["id_tipo_material"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_propiedad", $datos["id_propiedad"], PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarProduccion()->errorInfo());

		}
		$stmt = null;
    }

    static public function delete($tabla, $id){

		$stmt = Conexion::conectarProduccion()->prepare("DELETE FROM $tabla WHERE id_configuracion = :id_configuracion");

		$stmt -> bindParam(":id_configuracion", $id, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarProduccion()->errorInfo());
		}

		$stmt-> close();

		$stmt = null;

	}
}
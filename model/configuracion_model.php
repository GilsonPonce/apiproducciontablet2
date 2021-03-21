<?php

require_once "conexion.php";

class ModeloConfiguracion
{
    static public function index($tabla)
    {
        //$sql = "SELECT * FROM $tabla";
        $sql = "select confi.id_configuracion,li.id_linea, li.nombre as linea, pro.id_proceso, pro.nombre as proceso, ma.id_material,
        ma.nombre as material, tma.id_tipo_material, tma.nombre as tipo_material, confi.estado, confi.kilogramo_diario, confi.kilogramo_hora,
        confi.tarifa_kilogramo_producidos from linea li, proceso pro, tipo_material tma, material ma, $tabla confi
        where li.id_linea = pro.id_linea and pro.id_proceso = confi.id_proceso and tma.id_tipo_material = confi.id_tipo_material 
        and ma.id_material = confi.id_material";
        $stmt = Conexion::conectarProduccion()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function show($tabla,$id)
    {
        //$sql = "SELECT * FROM $tabla WHERE id_configuracion = :id_configuracion";
        $sql = "select confi.id_configuracion,li.id_linea, li.nombre as linea, pro.id_proceso, pro.nombre as proceso, ma.id_material,
        ma.nombre as material, tma.id_tipo_material, tma.nombre as tipo_material, confi.estado, confi.kilogramo_diario, confi.kilogramo_hora,
        confi.tarifa_kilogramo_producidos from linea li, proceso pro, tipo_material tma, material ma, $tabla confi
        where li.id_linea = pro.id_linea and pro.id_proceso = confi.id_proceso and tma.id_tipo_material = confi.id_tipo_material 
        and ma.id_material = confi.id_material and confi.id_configuracion = :id_configuracion";
        $stmt = Conexion::conectarProduccion()->prepare($sql);
        $stmt -> bindParam(":id_configuracion", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function create($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("INSERT INTO $tabla(kilogramo_diario,kilogramo_hora,tarifa_kilogramo_producidos,estado,id_proceso,id_material,id_tipo_material) VALUES (:kilogramo_diario,:kilogramo_hora,:tarifa_kilogramo_producidos,:estado,:id_proceso,:id_material,:id_tipo_material)");
        $stmt -> bindParam(":kilogramo_diario", $datos["kilogramo_diario"], PDO::PARAM_STR);
        $stmt -> bindParam(":kilogramo_hora", $datos["kilogramo_hora"], PDO::PARAM_STR);
        $stmt -> bindParam(":tarifa_kilogramo_producidos", $datos["tarifa_kilogramo_producidos"], PDO::PARAM_STR);
        $stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_proceso", $datos["id_proceso"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_material", $datos["id_material"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_tipo_material", $datos["id_tipo_material"], PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarProduccion()->errorInfo());

		}
		$stmt = null;
    }

    static public function update($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("UPDATE $tabla SET kilogramo_diario=:kilogramo_diario,kilogramo_hora=:kilogramo_hora,tarifa_kilogramo_producidos=:tarifa_kilogramo_producidos,estado=:estado,id_proceso = :id_proceso,id_material = :id_material,id_tipo_material = :id_tipo_material WHERE id_configuracion=:id_configuracion");
        $stmt -> bindParam(":kilogramo_diario", $datos["kilogramo_diario"], PDO::PARAM_STR);
        $stmt -> bindParam(":kilogramo_hora", $datos["kilogramo_hora"], PDO::PARAM_STR);
        $stmt -> bindParam(":tarifa_kilogramo_producidos", $datos["tarifa_kilogramo_producidos"], PDO::PARAM_STR);
        $stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_proceso", $datos["id_proceso"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_material", $datos["id_material"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_tipo_material", $datos["id_tipo_material"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_configuracion", $datos["id_configuracion"], PDO::PARAM_INT);

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
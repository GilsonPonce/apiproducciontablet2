<?php

require_once "conexion.php";

class ModeloOrden
{
    static public function index($tabla)
    {
        $sql = "SELECT o.orden_codigo AS codigo,o.orden_codigo,inf.fecha_hora_inicio,inf.fecha_hora_fin,o.hora_peso AS horapeso, 
        o.peso_producir AS peso,m.id_material,m.nombre AS material, tm.id_tipo_material, tm.nombre AS tipomaterial,
        li.id_linea,li.nombre AS linea,pro.id_proceso,pro.nombre AS proceso,c.id_color, c.nombre AS color ,eo.id_estado_orden, 
        eo.nombre AS estado
        FROM informe inf, $tabla o, proceso pro, linea li, material m, tipo_material tm, color c, estado_orden eo
        WHERE  o.orden_codigo = inf.orden_codigo AND o.id_estado_orden = eo.id_estado_orden AND c.id_color = o.id_color
        AND pro.id_proceso = o.id_proceso AND li.id_linea = pro.id_linea AND li.id_linea = m.id_linea AND m.id_material = tm.id_material
        AND tm.id_tipo_material = o.id_tipo_material"; 
        $stmt = Conexion::conectarProduccion()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function show($tabla,$id)
    {
        $sql = "SELECT o.orden_codigo AS codigo,o.orden_codigo,inf.fecha_hora_inicio,inf.fecha_hora_fin,o.hora_peso AS horapeso, 
        o.peso_producir AS peso,m.id_material,m.nombre AS material, tm.id_tipo_material, tm.nombre AS tipomaterial,
        li.id_linea,li.nombre AS linea,pro.id_proceso,pro.nombre AS proceso,c.id_color, c.nombre AS color ,eo.id_estado_orden, 
        eo.nombre AS estado
        FROM informe inf, $tabla o, proceso pro, linea li, material m, tipo_material tm, color c, estado_orden eo
        WHERE  o.orden_codigo = inf.orden_codigo AND o.id_estado_orden = eo.id_estado_orden AND c.id_color = o.id_color
        AND pro.id_proceso = o.id_proceso AND li.id_linea = pro.id_linea AND li.id_linea = m.id_linea AND m.id_material = tm.id_material
        AND tm.id_tipo_material = o.id_tipo_material AND o.orden_codigo = :orden_codigo"; 
        $stmt = Conexion::conectarProduccion()->prepare($sql);
        $stmt -> bindParam(":orden_codigo", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function create($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("INSERT INTO $tabla(orden_codigo,hora_peso,peso_producir,id_tipo_material,id_color,id_proceso,id_estado_orden) VALUES (:orden_codigo,:hora_peso,:peso_producir,:id_tipo_material,:id_color,:id_proceso,:id_estado_orden)");
        $stmt -> bindParam(":orden_codigo", $datos["orden_codigo"], PDO::PARAM_STR);
        $stmt -> bindParam(":hora_peso", $datos["hora_peso"], PDO::PARAM_INT);
        $stmt -> bindParam(":peso_producir", $datos["peso_producir"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_tipo_material", $datos["id_tipo_material"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_color", $datos["id_color"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_proceso", $datos["id_proceso"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_estado_orden", $datos["id_estado_orden"], PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarProduccion()->errorInfo());

		}
		$stmt = null;
    }

    static public function update($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("UPDATE $tabla SET orden_codigo=:orden_codigo,hora_peso=:hora_peso,peso_producir=:peso_producir,id_tipo_material=:id_tipo_material,id_color=:id_color,id_proceso=:id_proceso,id_estado_orden=:id_estado_orden WHERE orden_codigo=:orden_codigo");
        $stmt -> bindParam(":orden_codigo", $datos["orden_codigo"], PDO::PARAM_STR);
        $stmt -> bindParam(":hora_peso", $datos["hora_peso"], PDO::PARAM_INT);
        $stmt -> bindParam(":peso_producir", $datos["peso_producir"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_tipo_material", $datos["id_tipo_material"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_color", $datos["id_color"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_proceso", $datos["id_proceso"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_estado_orden", $datos["id_estado_orden"], PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarProduccion()->errorInfo());

		}
		$stmt = null;
    }

    static public function delete($tabla, $id){

		$stmt = Conexion::conectarProduccion()->prepare("DELETE FROM $tabla WHERE orden_codigo = :orden_codigo");

		$stmt -> bindParam(":orden_codigo", $id, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectarProduccion()->errorInfo());
		}

		$stmt-> close();

		$stmt = null;

	}
}
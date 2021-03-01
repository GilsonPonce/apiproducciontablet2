<?php

require_once "conexion.php";

class ModeloOrden
{
    static public function index($tabla)
    {
        $sql = "select ord.orden_codigo, ord.fecha_hora_inicio, ord.fecha_hora_fin, ord.peso_producir, ord.id_configuracion, ord.id_color,
        ord.id_turno, ord.id_estado_orden, co.nombre as color, tur.nombre as turno, estor.nombre as estado, li.id_linea, li.nombre as linea,
        pro.id_proceso, pro.nombre as proceso, propi.id_propiedad, propi.nombre as propiedad, tma.id_tipo_material, tma.nombre as tipo_material,
        ma.id_material, ma.nombre as material
        from $tabla ord, color co, turno tur, estado_orden estor, linea li, proceso pro, propiedad propi, tipo_material tma, material ma, configuracion confi
        where tur.id_turno = ord.id_turno and co.id_color = ord.id_color and estor.id_estado_orden = ord.id_estado_orden 
        and confi.id_configuracion = ord.id_configuracion and li.id_linea = pro.id_linea and pro.id_proceso = confi.id_proceso
        and propi.id_propiedad = confi.id_propiedad and tma.id_tipo_material = confi.id_tipo_material and ma.id_material = confi.id_material";
       // $sql = "SELECT * FROM $tabla";
        $stmt = Conexion::conectarProduccion()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function show($tabla, $id)
    {
        $sql = "select ord.orden_codigo, ord.fecha_hora_inicio, ord.fecha_hora_fin, ord.peso_producir, ord.id_configuracion, ord.id_color,
        ord.id_turno, ord.id_estado_orden, co.nombre as color, tur.nombre as turno, estor.nombre as estado, li.id_linea, li.nombre as linea,
        pro.id_proceso, pro.nombre as proceso, propi.id_propiedad, propi.nombre as propiedad, tma.id_tipo_material, tma.nombre as tipo_material,
        ma.id_material, ma.nombre as material
        from $tabla ord, color co, turno tur, estado_orden estor, linea li, proceso pro, propiedad propi, tipo_material tma, material ma, configuracion confi
        where tur.id_turno = ord.id_turno and co.id_color = ord.id_color and estor.id_estado_orden = ord.id_estado_orden 
        and confi.id_configuracion = ord.id_configuracion and li.id_linea = pro.id_linea and pro.id_proceso = confi.id_proceso
        and propi.id_propiedad = confi.id_propiedad and tma.id_tipo_material = confi.id_tipo_material and ma.id_material = confi.id_material and ord.orden_codigo = :orden_codigo";
        //$sql = "SELECT * FROM $tabla WHERE orden_codigo = :orden_codigo";
        $stmt = Conexion::conectarProduccion()->prepare($sql);
        $stmt->bindParam(":orden_codigo", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function create($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("INSERT INTO $tabla(orden_codigo,fecha_hora_inicio,fecha_hora_fin,peso_producir,id_configuracion,id_color,id_turno,id_estado_orden) VALUES (:orden_codigo,now(),now(),:peso_producir,:id_configuracion,:id_color,:id_turno,:id_estado_orden)");
        $stmt->bindParam(":orden_codigo", $datos["orden_codigo"], PDO::PARAM_STR);
        $stmt->bindParam(":peso_producir", $datos["peso_producir"], PDO::PARAM_STR);
        $stmt->bindParam(":id_configuracion", $datos["id_configuracion"], PDO::PARAM_INT);
        $stmt->bindParam(":id_color", $datos["id_color"], PDO::PARAM_INT);
        $stmt->bindParam(":id_turno", $datos["id_turno"], PDO::PARAM_INT);
        $stmt->bindParam(":id_estado_orden", $datos["id_estado_orden"], PDO::PARAM_INT);

        if ($stmt->execute()) {

            return "ok";
        } else {

            print_r(Conexion::conectarProduccion()->errorInfo());
        }
        $stmt = null;
    }

    static public function update($tabla, $datos)
    {
        $stmt = Conexion::conectarProduccion()->prepare("UPDATE $tabla SET peso_producir=:peso_producir,id_configuracion=:id_configuracion,id_color=:id_color,id_turno=:id_turno,id_estado_orden=:id_estado_orden WHERE orden_codigo=:orden_codigo");
        $stmt->bindParam(":orden_codigo", $datos["orden_codigo"], PDO::PARAM_STR);
        $stmt->bindParam(":peso_producir", $datos["peso_producir"], PDO::PARAM_INT);
        $stmt->bindParam(":id_configuracion", $datos["id_configuracion"], PDO::PARAM_INT);
        $stmt->bindParam(":id_color", $datos["id_color"], PDO::PARAM_INT);
        $stmt->bindParam(":id_turno", $datos["id_turno"], PDO::PARAM_INT);
        $stmt->bindParam(":id_estado_orden", $datos["id_estado_orden"], PDO::PARAM_INT);

        if ($stmt->execute()) {

            return "ok";
        } else {

            print_r(Conexion::conectarProduccion()->errorInfo());
        }
        $stmt = null;
    }

    static public function delete($tabla, $id)
    {

        $stmt = Conexion::conectarProduccion()->prepare("DELETE FROM $tabla WHERE orden_codigo = :orden_codigo");

        $stmt->bindParam(":orden_codigo", $id, PDO::PARAM_INT);

        if ($stmt->execute()) {

            return "ok";
        } else {

            print_r(Conexion::conectarProduccion()->errorInfo());
        }

        $stmt->close();

        $stmt = null;
    }
}

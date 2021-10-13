<?php

require_once "conexion.php";

class ModeloReporte
{
    static public function show($id)
    {
        $stmt = Conexion::conectarProduccion()->prepare("CALL getReporte($id)");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function index($arrIds)
    {
        $datos = [];
        $tamanio = count($arrIds);
        for ($x = 0; $x < $tamanio; $x++) {
            $sql = "CALL getReporte($arrIds[$x])";
            try {
                $sentencia =Conexion::conectarProduccion()->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                $sentencia->execute();
                while ($fila = $sentencia->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
                    $datos[] = $fila;
                }
                $sentencia = null;
            } catch (PDOException $e) {
                print $e->getMessage();
            }
        }
        return $datos;
    }
}

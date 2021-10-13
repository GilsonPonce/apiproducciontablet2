<?php

class Conexion
{
    //"mysql:host=localhost;port=3306;dbname=athu", "gjponce", "N0vaR3d."
    static public function conectarProduccion()
    {
        $link = new PDO("mysql:host=127.0.0.1;port=3306;dbname=produccion", "root", "SYSsys1223+",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        //$link = new PDO("mysql:host=192.168.35.21;port=3306;dbname=produccion", "novared", "N0vaR3d.",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        return $link;
    }
}

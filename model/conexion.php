<?php

class Conexion
{
    //"mysql:host=localhost;port=3306;dbname=athu", "gjponce", "N0vaR3d."
    static public function conectarProduccion()
    {
        $link = new PDO("mysql:host=127.0.0.1;port=3306;dbname=produccion2", "root", "SYSsys1223+",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        return $link;
    }
}

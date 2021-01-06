<?php

class Conexion
{
    static public function conectarProduccion()
    {
        $link = new PDO("mysql:host=192.168.35.21;port=3306;dbname=produccion", "gjponce", "N0vaR3d.");
        return $link;
    }

    static public function conectarAthu()
    {
        $link = new PDO("mysql:host=192.168.35.21;port=3306;dbname=athu", "gjponce", "N0vaR3d.");
        return $link;
    }
}

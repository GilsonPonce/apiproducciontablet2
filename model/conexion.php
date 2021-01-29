<?php

class Conexion
{
    //"mysql:host=localhost;port=3306;dbname=athu", "gjponce", "N0vaR3d."
    static public function conectarProduccion()
    {
        $link = new PDO("mysql:host=127.0.0.1;port=3306;dbname=produccion", "root", "SYSsys1223+");
        return $link;
    }

    static public function conectarAthu()
    {
        $link = new PDO("mysql:host=127.0.0.1;port=3306;dbname=athu", "root", "SYSsys1223+");
        return $link;
    }
}

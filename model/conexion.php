<?php

class Conexion
{
    static public function conectarProduccion()
    {
        $link = new PDO("mysql:host=localhost;dbname=produccion", "root", "SYSsys1223+");
        return $link;
    }

    static public function conectarAthu()
    {
        $link = new PDO("mysql:host=localhost;dbname=athu", "root", "SYSsys1223+");
        return $link;
    }
}

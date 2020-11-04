<?php

class Conexion
{
    static public function conectar()
    {
        $link = new PDO("mysql:host=107.180.28.117:3306;dbname=produccion", "ponceg", "admin1223");
        return $link;
    }
}

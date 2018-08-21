<?php
class Modelo_Jornada
{

    public static function obtieneListado()
    {

        $sql = "SELECT * FROM mfo_jornada";
        return $GLOBALS['db']->auto_array($sql, array(), true);

    }

}

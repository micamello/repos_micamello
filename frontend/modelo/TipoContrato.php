<?php
class Modelo_TipoContrato
{

    public static function obtieneListado()
    {
        $sql = "SELECT * FROM mfo_tipocontrato";
        return $GLOBALS['db']->auto_array($sql, array(), true);
    }

}

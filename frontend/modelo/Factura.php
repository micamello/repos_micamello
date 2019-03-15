<?php
class Modelo_Factura{
  
  const NOENVIADO = 0;
  const RECIBIDO = 1;
  const DEVUELTO = 2;
  const AUTORIZADO = 3;
  const NOAUTORIZADO = 4;

  public static function obtenerFactura($id_factura,$estado){
  	if(empty($id_factura)){return false;}
  	 $sql = "SELECT * FROM mfo_factura f WHERE f.id_factura = ".$id_factura." AND f.estado = ".$estado;
    return $GLOBALS['db']->auto_array($sql,array());
  }

  public static function guardar($claveAcceso,$xml,$idusuario,$tipousuario,$sucursal){
    if (empty($claveAcceso) || empty($xml) || empty($idusuario) || empty($tipousuario) || empty($sucursal)){ return false; }    
    $valorinsert = array("fecha_creacion" => date('Y-m-d H:i:s'),
                         "clave_acceso" => $claveAcceso,
                         "xml" => $xml,
                         "id_user_emp_plan" => $idusuario,
                         "tipo_usuario" => $tipousuario,
                         "estado" => self::NOENVIADO,
                         "id_sucursal" => $sucursal);
    return $GLOBALS['db']->insert("mfo_factura",$valorinsert);
  }

  public static function actualizar($claveAcceso,$valores){
    if (empty($claveAcceso) || empty($valores)){ return false; }    
    $valupdate = array();
    if (!isset($valores["msg_error"]) || empty($valores["msg_error"])){
      $valupdate["estado"] = $valores["estado"];
    }
    else{
      $valupdate["estado"] = $valores["estado"];
      $valupdate["msg_error"] = $valores["msg_error"];
    }
    return $GLOBALS['db']->update("mfo_factura",$valupdate,"clave_acceso='".$claveAcceso."'");
  }
}  
?>

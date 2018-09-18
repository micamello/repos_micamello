<?php
class Modelo_Comprobante{
  
  const TIPO_PAGOS = array('1'=>'Pago verificado','2'=>'Pago incorrecto','3'=>'En proceso');
  const METODOS_PAGOS = array('1'=>'Dep&oacute;sito Bancario','2'=>'Paypal'/*,'3'=>'Paymentez'*/);

  const PAGO_PROCESO = 3;
  const PAGO_VERIFICADO = 1;
  const METODO_DEPOSITO = 1;
  const METODO_PAYPAL = 2;
  const METODO_PAYMENTEZ = 3;

  public static function obtieneComprobante($id_comprobante){
    $sql = "SELECT * FROM mfo_rcomprobantescam WHERE id_comprobante = ".$id_comprobante;
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }

  public static function guardarComprobante($numero, $nombre, $correo, $telefono, $dni, $ciudad, 
  																					$tipopago, $imagen, $valor, $usuario, $plan, $estado = self::PAGO_PROCESO){
    if (empty($numero) || empty($nombre) || empty($correo) || empty($telefono) ||
    	  empty($dni) || empty($ciudad) || empty($tipopago) || empty($valor) || 
    	  empty($usuario) || empty($plan)){ 
    	return false; 
    }
    $data_insert = array('num_comprobante'=>$numero,'nombre'=>$nombre,'correo'=>$correo,'telefono'=>$telefono,
                         'fecha_creacion'=>date('Y-m-d H:i:s'),'id_ciudad'=>$ciudad,'tipo_pago'=>$tipopago,
                         'ext_imagen'=>$imagen,'valor'=>$valor,'estado'=>$estado,'id_plan'=>$plan,
                         'id_usuario'=>$usuario,'dni'=>$dni);
    return $GLOBALS['db']->insert('mfo_rcomprobantescam',$data_insert);                      
  }
}  
?>
<?php
class Modelo_UsuarioxNivelIdioma{
  
  public static function guardarUsuarioNivelIdioma($id_usuario, $data_idiomas){
  	if (empty($id_usuario) || empty($data_idiomas)) {return false;}
  	$result = false;
  	self::eliminarConfiguracionIdioma($id_usuario);
  	foreach ($data_idiomas as $key => $idiomas) {
        $result = $GLOBALS['db']->insert("mfo_usuario_nivelidioma", array("id_usuario"=>$id_usuario, "id_nivelIdioma_idioma"=>$idiomas));
    }
    return $result;
  }

  public static function obtenerIdiomasUsuario($idUsuario){

  	$sql = "SELECT i.descripcion,i.id_idioma,n.id_nivelIdioma,n.nombre FROM mfo_usuario_nivelidioma ni, mfo_nivelidioma_idioma nii, mfo_idioma i, mfo_nivelidioma n
		WHERE ni.id_nivelIdioma_idioma = nii.id_nivelIdioma_idioma
		AND i.id_idioma = nii.id_idioma
		AND n.id_nivelIdioma = nii.id_nivelIdioma AND id_usuario = ".$idUsuario.";";

	$arrdatos = $GLOBALS['db']->auto_array($sql,array(),true);
    $datos = array();
    if (!empty($arrdatos) && is_array($arrdatos)){

    	foreach ($arrdatos as $key => $value) {
    		$datos[utf8_encode($value['descripcion'])] = array($value['id_idioma'],$value['id_nivelIdioma'],$value['nombre']);
    	}
    }
    return $datos;
  }

  public static function eliminarConfiguracionIdioma($idUsuario){
  	$result = $GLOBALS['db']->delete('mfo_usuario_nivelidioma','id_usuario = '.$idUsuario);
    return $result;
  }
}  
?>
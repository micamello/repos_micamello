<?php
class Modelo_UsuarioLogin{
  
  public static function crearUsuarioLogin($usuario_login){
    if(empty($usuario_login)){return false;}
    $password = md5($usuario_login['password']);
    $result = $GLOBALS['db']->insert('mfo_usuario_login',
                                    array("tipo_usuario"=>$usuario_login['tipo_usuario'],
                                          "username"=>$usuario_login['username'],
                                          "password"=>$password,
                                          "correo"=>$usuario_login['correo'],
                                          "dni"=>$usuario_login['dni']));
    return $result;
  }

  public static function editarDniLogin($idUsuario,$dni){

  	$datos = array("dni"=>$dni);
  	return $GLOBALS['db']->update("mfo_usuario_login",$datos,"id_usuario_login=".$idUsuario);
  }

}  
?>

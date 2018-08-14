<?php
class Modelo_Usuario{

  const CANDIDATO = 1;
  const EMPRESA = 2;

  public static function obtieneNroCandidato(){
    $sql = "SELECT COUNT(id_usuario) AS cont FROM mfo_usuario where tipo_usuario=? and estado=1";
    $rs = $GLOBALS['db']->auto_array($sql,array(self::CANDIDATO));
    return (!empty($rs['cont'])) ? $rs['cont'] : 0;
  }

  public static function obtieneNroEmpresa(){
    $sql = "SELECT COUNT(id_usuario) AS cont FROM mfo_usuario where tipo_usuario=? and estado=1";
    $rs = $GLOBALS['db']->auto_array($sql,array(self::EMPRESA));
    return (!empty($rs['cont'])) ? $rs['cont'] : 0;
  }

  public static function estaLogueado(){
    Utils::log(__METHOD__. " sesion ". print_r($_SESSION, true) );
    if ( !Utils::getArrayParam('mfo_datos', $_SESSION) || !Utils::getArrayParam('usuario', $_SESSION['mfo_datos'] )){      
      Utils::log(__METHOD__. " sesion no econtrada: ". print_r($_SESSION, true) );
      return false;
    }
    return true;
  }

  public static function autenticacion($username, $password){
    $password = md5($password);             
    return $GLOBALS['db']->auto_array("SELECT * FROM mfo_usuario WHERE username = ? AND password = ? AND estado = 1",array($username,$password)); 
  }

  public static function busquedaPorCorreo($correo){
    if (empty($correo)){ return false; }
    $sql = "select * from mfo_usuario where correo = ?";
    $rs = $GLOBALS['db']->auto_array($sql,array($correo));
    return (!empty($rs['id_usuario'])) ? $rs : false;
  }

  public static function modificarPassword($pass,$id){
    if (empty($pass) || empty($id)){ return false; }
    $password = md5($pass);
    return $GLOBALS['db']->update("mfo_usuario",array("password"=>$password),"id_usuario=".$id);
  }

  public static function modificarFechaLogin($id){
    if (empty($id)){ return false; }
    return $GLOBALS['db']->update("mfo_usuario",array("ultima_sesion"=>date("Y-m-d H:i:s")),"id_usuario=".$id);
  }

  // Búsqueda del username en la BD
  public static function existeUsuario($username){
    if(empty($username)){ return false; }
    $sql = "select * from mfo_usuario where username = ?";
    $rs = $GLOBALS['db']->auto_array($sql,array($username));
    return (!empty($rs['id_usuario'])) ? false : true;
  }

  public static function existeCorreo($correo){
    if(empty($correo)){ return false; }
    $sql = "select * from mfo_usuario where correo = ?";
    $rs = $GLOBALS['db']->auto_array($sql,array($correo));
    return (!empty($rs['id_usuario'])) ? false : true;
  }

  public static function existeDni($dni){
    if(empty($dni)){ return false; }
    $sql = "select * from mfo_usuario where dni = ?";
    $rs = $GLOBALS['db']->auto_array($sql,array($dni));
    return (!empty($rs['id_usuario'])) ? false : true;
  }

  public static function crearUsuario($data){
    Utils::log("Eder ".print_r($data, true));
    if(empty($data)){return false;}
    
    return $GLOBALS['db']->update("mfo_usuario",array("ultima_sesion"=>date("Y-m-d H:i:s")),"id_usuario=".$id);
    
  }

  public static function obtieneFoto(){

    if($_SESSION['mfo_datos']['usuario']['foto'] == 0){
      $rutaImagen = PUERTO.'://'.HOST.'/imagenes/user.png';
    }else{
      $rutaImagen = PUERTO.'://'.HOST.'/imagenes/usuarios/profile/'.$_SESSION['mfo_datos']['usuario']['id_usuario'].'jpg';
    }
    return $rutaImagen;
  }

}  
?>
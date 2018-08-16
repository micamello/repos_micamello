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

  public static function obtieneFoto(){

    if($_SESSION['mfo_datos']['usuario']['foto'] == 0){
      $rutaImagen = PUERTO.'://'.HOST.'/imagenes/user.png';
    }else{
      $rutaImagen = PUERTO.'://'.HOST.'/imagenes/usuarios/profile/'.$_SESSION['mfo_datos']['usuario']['id_usuario'].'.jpg';
    }
    return $rutaImagen;
  }
  
  public static function actualizarSession($idUsuario){
    return $GLOBALS['db']->auto_array("SELECT * FROM mfo_usuario WHERE id_usuario = ".$idUsuario); 
  }

  public static function updateUsuario($data,$idUsuario,$file=false){

    $foto = 0;
    if($file['error'] != 4 )
    { 
      $foto = 1;

    }else if($file['error'] == 4 && $_SESSION['mfo_datos']['usuario']['foto'] == 1){
      $foto = 1;
    }

    Utils::imagen_upload($file,$idUsuario,PATH_PROFILE);
    if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == 1){
      $datos = array("foto"=>$foto,"nombres"=>$data['nombres'],"apellidos"=>$data['apellidos'],"telefono"=>$data['telefono'],"id_ciudad"=>$data['ciudad'],"fecha_nacimiento"=>$data['fecha_nacimiento'],"genero"=>$data['genero'],"discapacidad"=>$data['discapacidad'],"anosexp"=>$data['experiencia'],"status_carrera"=>$data['status_carrera'],"id_escolaridad"=>$data['escolaridad']);
    }else{
      $datos = array("foto"=>$foto,"nombres"=>$data['nombres'],"telefono"=>$data['telefono'],"id_ciudad"=>$data['ciudad'],"fecha_nacimiento"=>$data['fecha_nacimiento']);
    }

    $result = $GLOBALS['db']->update("mfo_usuario",$datos,"id_usuario=".$idUsuario);

    return $result;
  }
}  
?>
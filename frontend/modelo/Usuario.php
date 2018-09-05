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
    //Utils::log(__METHOD__. " sesion ". print_r($_SESSION, true) );
    if ( !Utils::getArrayParam('mfo_datos', $_SESSION) || !Utils::getArrayParam('usuario', $_SESSION['mfo_datos'] )){      
      //Utils::log(__METHOD__. " sesion no econtrada: ". print_r($_SESSION, true) );
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
    return (!empty($rs['id_usuario'])) ? false : $rs;
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

  public static function crearUsuario($data, $defaultDataUser){
    if(empty($data)||empty($defaultDataUser)){return false;}

    $password = md5($data['password']);

      if ($data['tipo_usuario'] == 2) {
        $data["apell_user"] = $data['name_user'];
      }

    $result = $GLOBALS['db']->insert('mfo_usuario',array("username"=>$data['username'],"password"=>$password,"correo"=>$data['correo'],"telefono"=>$data['numero_cand'],"dni"=>$data['cedula'],"nombres"=>$data['name_user'],"apellidos"=>$data['apell_user'],"fecha_nacimiento"=>$defaultDataUser['fecha_nacimiento'],"fecha_creacion"=>$defaultDataUser['fecha_creacion'],"token"=>$defaultDataUser['token'],"estado"=>$defaultDataUser['estado'],"term_cond"=>$data['term_cond'],"conf_datos"=>$data['conf_datos'],"status_carrera"=>$defaultDataUser['status_carrera'],"tipo_usuario"=>$data['tipo_usuario'],"id_escolaridad"=>$defaultDataUser['id_escolaridad'],"id_ciudad"=>$defaultDataUser['id_ciudad'],"ultima_sesion"=>$defaultDataUser['ultima_sesion']));
    return $result;
  }

  public static function activarCuenta($id_usuario){
    if(empty($id_usuario)){return false;}
      return $GLOBALS['db']->update("mfo_usuario",array("estado"=>1),"id_usuario=".$id_usuario);
  }

  public static function obtieneFoto($idUsuario){
    $rutaImagen = PUERTO.'://'.HOST.'/imagenes/usuarios/profile/'.$idUsuario.'.jpg';
    return $rutaImagen;   
  }

  public static function actualizarSession($idUsuario){
    return $GLOBALS['db']->auto_array("SELECT * FROM mfo_usuario WHERE id_usuario = ".$idUsuario); 
  }

  public static function updateUsuario($data,$idUsuario,$imagen=false,$session_foto,$tipo_usuario){

    $foto = 0;
    if($imagen['error'] != 4)
    { 
      $foto = 1;

    }else if($imagen['error'] == 4 && $session_foto == 1){
      $foto = 1;
    }

    if($tipo_usuario == 1){
      $datos = array("foto"=>$foto,"nombres"=>$data['nombres'],"apellidos"=>$data['apellidos'],"telefono"=>$data['telefono'],"id_ciudad"=>$data['ciudad'],"fecha_nacimiento"=>$data['fecha_nacimiento'],"genero"=>$data['genero'],"discapacidad"=>$data['discapacidad'],"anosexp"=>$data['experiencia'],"status_carrera"=>$data['status_carrera'],"id_escolaridad"=>$data['escolaridad']);
    }else{
      $datos = array("foto"=>$foto,"nombres"=>$data['nombres'],"telefono"=>$data['telefono'],"id_ciudad"=>$data['ciudad'],"fecha_nacimiento"=>$data['fecha_nacimiento']);
    }

    return $GLOBALS['db']->update("mfo_usuario",$datos,"id_usuario=".$idUsuario);
  }

  public static function validarFechaNac($fecha){

    //Creamos objeto fecha desde los valores recibidos
    $nacio = DateTime::createFromFormat('Y-m-d', $fecha);

    //Calculamos usando diff y la fecha actual
    $calculo = $nacio->diff(new DateTime());

    //Obtenemos la edad
    $edad =  $calculo->y;    

    if ($edad < 18) 
    {
        //echo "Usted es menor de edad. Su edad es: $edad\n";
        return false;  
     }else{
        //echo "Usted es mayor de edad. Su edad es: $edad\n";
        return true;  
    }
  }


  public static function obtenerAspirantes($idOferta,$page){

    $sql = "SELECT o.id_ofertas, u.id_usuario, u.username, u.nombres, u.apellidos, p.fecha_postulado 
            FROM mfo_usuario u, mfo_postulacion p, mfo_oferta o, mfo_infohv i
            WHERE u.id_usuario = p.id_usuario 
            AND p.id_ofertas = o.id_ofertas
            AND i.id_usuario = u.id_usuario
            AND o.id_ofertas = $idOferta
            ORDER BY p.fecha_postulado DESC";

    $page = ($page - 1) * REGISTRO_PAGINA;
    $sql .= " LIMIT ".$page.",".REGISTRO_PAGINA;

    return $GLOBALS['db']->auto_array($sql,array(),true); 
  }

  public static function filtrarAspirantes($idOferta,$fecha,$prioridad,$ubicacion,$salario,$genero,$page){

    $sql = "SELECT o.id_ofertas, u.id_usuario, u.username, u.nombres, u.apellidos, p.fecha_postulado 
            FROM mfo_usuario u, mfo_postulacion p, mfo_oferta o, mfo_infohv i
            WHERE u.id_usuario = p.id_usuario 
            AND p.id_ofertas = o.id_ofertas
            AND i.id_usuario = u.id_usuario
            AND o.id_ofertas = $idOferta
            ";

    //segun el escogido calcular fecha y ponersela a la consulta
    if (!empty($fecha)){ 
       $sql .= " AND p.fecha_postulado = ".$fecha;
    }
    
    //obtener los aspirantes por los que pagaron y los q no pagaron
    if (!empty($prioridad)){ 
      $sql .= " AND a.id_area = ".$id_area;
    }

    //obtiene los aspirantes pra esa ubicacion 
    if (!empty($ubicacion)){ 
      $sql .= " AND u.id_ciudad = ".$ubicacion;
    }

    //calcular que el salario este en el rango especificado
    if (!empty($salario)){ 
      $sql .= " AND p.salario = ".$id_contrato;
    }

    //obtiene los aspirantes por genero
    if (!empty($genero)){ 
      $sql .= " AND u.genero = ".$genero;
    }

    //$sql .= " ORDER BY p.fecha_postulado DESC";

    $page = ($page - 1) * REGISTRO_PAGINA;
    $sql .= " LIMIT ".$page.",".REGISTRO_PAGINA;
    return $rs = $GLOBALS['db']->auto_array($sql,array(),true);
  }

  public static function busquedaPorId($id){
    if (empty($id)){ return false; }
    $sql = "SELECT * FROM mfo_usuario WHERE id_usuario = ?";
    return $GLOBALS['db']->auto_array($sql,array($id)); 
  }

}  
?>
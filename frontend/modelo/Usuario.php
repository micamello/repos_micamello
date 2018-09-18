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
<<<<<<< HEAD
    $sql = "SELECT u.id_usuario, u.username, u.correo, u.telefono, 
                   u.dni, u.nombres, u.fecha_nacimiento, u.foto,
                   u.tipo_usuario, u.id_ciudad, r.estado_civil,
                   r.tiene_trabajo, r.viajar, r.licencia,
                   r.discapacidad,r.anosexp, r.status_carrera, 
                   r.id_escolaridad, r.genero, r.apellidos, r.id_univ, u.id_nacionalidad
            FROM mfo_usuario u LEFT JOIN mfo_requisitosusuario r ON r.id_usuario = u.id_usuario
            WHERE u.username = ? AND u.password = ? AND u.estado = 1";        
    return $GLOBALS['db']->auto_array($sql,array($username,$password)); 
=======
    $sql = "SELECT u.id_usuario, u.username, u.correo, u.telefono, u.dni, u.nombres,
                   u.fecha_nacimiento, u.foto, u.tipo_usuario, u.id_ciudad,
                   r.estado_civil, r.tiene_trabajo, r.viajar, r.licencia,
                   r.discapacidad,r.anosexp, r.status_carrera, r.id_escolaridad, 
                   r.genero, r.apellidos
            FROM mfo_usuario u LEFT JOIN mfo_requisitosusuario r ON r.id_usuario = u.id_usuario
            WHERE (u.username = ? OR u.correo = ?) AND u.password = ? AND u.estado = 1";        
    return $GLOBALS['db']->auto_array($sql,array($username,$username,$password)); 
>>>>>>> FF
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
    return (!empty($rs['id_usuario'])) ? $rs : false;
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

    $result = $GLOBALS['db']->insert('mfo_usuario',array("username"=>strtolower($data['username']),"password"=>$password,"correo"=>strtolower($data['correo']),"telefono"=>$data['numero_cand'],"dni"=>$data['cedula'],"nombres"=>$data['name_user'],"fecha_nacimiento"=>$defaultDataUser['fecha_nacimiento'],"fecha_creacion"=>$defaultDataUser['fecha_creacion'],"token"=>$defaultDataUser['token'],"estado"=>$defaultDataUser['estado'],"term_cond"=>$data['term_cond'],"conf_datos"=>$data['conf_datos'],"tipo_usuario"=>$data['tipo_usuario'],"id_ciudad"=>$defaultDataUser['id_ciudad'],"ultima_sesion"=>$defaultDataUser['ultima_sesion']));
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

    $sql = "SELECT u.id_usuario, u.username, u.correo, u.telefono, 
                   u.dni, u.nombres, u.fecha_nacimiento, u.foto,
                   u.tipo_usuario, u.id_ciudad, r.estado_civil,
                   r.tiene_trabajo, r.viajar, r.licencia,
                   r.discapacidad,r.anosexp, r.status_carrera, 
                   r.id_escolaridad, r.genero, r.apellidos, r.id_univ, r.status_carrera, u.id_nacionalidad
            FROM mfo_usuario u LEFT JOIN mfo_requisitosusuario r ON r.id_usuario = u.id_usuario
            WHERE u.id_usuario = ? AND u.estado = 1";        
    return $GLOBALS['db']->auto_array($sql,array($idUsuario)); 
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
      $datos = array("foto"=>$foto,"nombres"=>$data['nombres'],/*,"apellidos"=>$data['apellidos'],*/"telefono"=>$data['telefono'],"id_ciudad"=>$data['ciudad'],"fecha_nacimiento"=>$data['fecha_nacimiento']/*,"genero"=>$data['genero'],"discapacidad"=>$data['discapacidad'],"anosexp"=>$data['experiencia'],"status_carrera"=>$data['status_carrera'],"id_escolaridad"=>$data['escolaridad'],"id_univ"=>$data['universidad']*/,"id_nacionalidad"=>$data['id_pais']);
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


  public static function obtenerAspirantes($idOferta,$page,$obtCantdRegistros=false){

    $sql = "SELECT ";

    if($obtCantdRegistros == false){
      $sql .= "o.id_ofertas, u.id_usuario, u.username, u.nombres, r.apellidos, p.fecha_postulado, u.fecha_nacimiento, YEAR(now()) - YEAR(u.fecha_nacimiento) as edad"; 
    }else{
      $sql .= "count(1) AS cantd_aspirantes";
    }
    
    $sql .= " FROM mfo_usuario u, mfo_postulacion p, mfo_oferta o, mfo_requisitosusuario r
            WHERE u.id_usuario = p.id_usuario 
            AND p.id_ofertas = o.id_ofertas
            AND r.id_usuario = u.id_usuario
            AND o.id_ofertas = $idOferta";

    if($obtCantdRegistros == false){
      $sql .= " ORDER BY p.fecha_postulado DESC";
      $page = ($page - 1) * REGISTRO_PAGINA;
      $sql .= " LIMIT ".$page.",".REGISTRO_PAGINA; 
      $rs = $GLOBALS['db']->auto_array($sql,array(),true);
    }else{
      $rs = $GLOBALS['db']->auto_array($sql,array()); 
      $rs = $rs['cantd_aspirantes'];
    }
    return $rs; 

  }

  public static function filtrarAspirantes($idOferta,&$filtros,$page,$obtCantdRegistros=false){

    $sql = "SELECT ";

    if($obtCantdRegistros == false){
      $sql .= "o.id_ofertas, u.id_usuario, u.username, u.nombres, r.apellidos, p.fecha_postulado, u.fecha_nacimiento, YEAR(now()) - YEAR(u.fecha_nacimiento) as edad"; 
    }else{
      $sql .= "count(1) AS cantd_aspirantes";
    }

    $sql .= " FROM mfo_usuario u, mfo_postulacion p, mfo_oferta o, mfo_requisitosusuario r";

    if(!empty($filtros['P']) && $filtros['P'] != 0){
      $sql .= ", mfo_usuario_plan up, mfo_plan pl ";
    }

    if(!empty($filtros['U']) && $filtros['U'] != 0){
      $sql .= ", mfo_provincia pro, mfo_ciudad c ";
    }

    $sql .= " WHERE u.id_usuario = p.id_usuario 
              AND p.id_ofertas = o.id_ofertas
              AND o.id_ofertas = $idOferta
              AND r.id_usuario = u.id_usuario
            ";

    //segun el escogido calcular fecha y ponersela a la consulta
    if(!empty($filtros['F']) && $filtros['F'] != 0){

       if($filtros['F'] == 1){
        $sql .= " AND p.fecha_postulado BETWEEN DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00') AND NOW()";
       }
       
       if($filtros['F'] == 2){
        $sql .= " AND p.fecha_postulado BETWEEN DATE_SUB(NOW(), INTERVAL 3 DAY) AND NOW()";
       }
       
       if($filtros['F'] == 3){
        $sql .= " AND p.fecha_postulado BETWEEN DATE_SUB(NOW(), INTERVAL 1 WEEK) AND NOW()";
       }

       if($filtros['F'] == 4){
        $sql .= " AND p.fecha_postulado BETWEEN DATE_SUB(NOW(), INTERVAL 1 MONTH) AND NOW()";
       }
    }
    
    //obtener los aspirantes por los que pagaron y los q no pagaron
    if(!empty($filtros['P']) && $filtros['P'] != 0){

      $sql .= " AND up.id_usuario = u.id_usuario AND up.id_plan = pl.id_plan";
      if(PRIORIDAD[$filtros['P']] == 'Pagado'){
        $sql .=  " AND pl.costo > 0" ;
      }else{
        $sql .=  " AND pl.costo = 0 AND up.estado = 1" ;
      }
    }

    //obtiene los aspirantes para esa ubicacion 
    if(!empty($filtros['U']) && $filtros['U'] != 0){ 

      $sql .= " AND pro.id_provincia = c.id_provincia and u.id_ciudad = c.id_ciudad AND pro.id_provincia = ".$filtros['U'];
    }

    //calcular que el salario este en el rango especificado
    if(!empty($filtros['S']) && $filtros['S'] != 0){

      if($filtros['S'] == 1){
        $sql .= " AND p.asp_salarial < 341";
      }

      if($filtros['S'] == 2){
        $sql .= " AND p.asp_salarial between '341' and '700'";
      }

      if($filtros['S'] == 3){
        $sql .= " AND p.asp_salarial >= 700";
      }
    }

    //obtiene los aspirantes por genero
    if(!empty($filtros['G']) && $filtros['G'] != 0){
      $g = array_search($filtros['G'],VALOR_GENERO);
      if($g != false){
        $sql .= " AND r.genero = '".$g."'";
      }
    }

    //obtiene los aspirantes por nacionalidad
    if(!empty($filtros['N']) && $filtros['N'] != 0){
      $sql .= " AND u.id_nacionalidad = ".$filtros['N'];
    }

    //obtiene los aspirantes por escolaridad
    if(!empty($filtros['E']) && $filtros['E'] != 0){ 
      $sql .= " AND r.id_escolaridad = ".$filtros['E'];
    }

    //Hace la busqueda por palabra clave
    if(!empty($filtros['Q']) && $filtros['Q'] != 0 || $filtros['Q'] != ''){

      $pos = strpos($filtros['Q'], "-");
      if ($pos != false) {

        $datos_fecha = explode("-",$filtros['Q']);
        if(count($datos_fecha) == 3 && checkdate($datos_fecha[1], $datos_fecha[2], $datos_fecha[0])){
            $pclave = $datos_fecha[0].'-'.$datos_fecha[1].'-'.$datos_fecha[2];
        }else if(count($datos_fecha) == 3 && checkdate($datos_fecha[1], $datos_fecha[0], $datos_fecha[2])){
            $pclave = $datos_fecha[2].'-'.$datos_fecha[1].'-'.$datos_fecha[0];
        }
      }else{
        $pclave = $filtros['Q'];
      }

      $sql .= " AND (u.nombres LIKE '%".$pclave."%' OR r.apellidos LIKE '%".$pclave."%' OR (YEAR(now()) - YEAR(u.fecha_nacimiento)) = '".$pclave."' OR p.fecha_postulado LIKE '%".$pclave."%')";
    }

    if(!empty($filtros['O']) && $filtros['O'] != 0){

      $tipo = substr($filtros['O'],0,1);
      $t = substr($filtros['O'],1,2);
      if($tipo == 1){
        if($t == 1){
          $filtros['O'] = 2;
          $sql .= " ORDER BY edad ASC";
        }
        if($t == 2){
          $filtros['O'] = 1;
          $sql .= " ORDER BY edad DESC";
        }
        
      }else{
        if($t == 1){
          $filtros['O'] = 2;
          $sql .= " ORDER BY p.fecha_postulado ASC";
        }
        if($t == 2){
          $filtros['O'] = 1;
          $sql .= " ORDER BY p.fecha_postulado DESC";
        }
      }
    }else{
      $sql .= " ORDER BY u.nombres";
    }

    if($obtCantdRegistros == false){
      $page = ($page - 1) * REGISTRO_PAGINA;
      $sql .= " LIMIT ".$page.",".REGISTRO_PAGINA; 
      $rs = $GLOBALS['db']->auto_array($sql,array(),true);
    }else{
      $rs = $GLOBALS['db']->auto_array($sql,array());
      $rs = $rs['cantd_aspirantes'];
    }

    return $rs;
  }

  public static function busquedaPorId($id){
    if (empty($id)){ return false; }
    $sql = "SELECT * FROM mfo_usuario WHERE id_usuario = ?";
    return $GLOBALS['db']->auto_array($sql,array($id)); 
  }

  public static function validaPermisos($tipousuario,$idusuario,$infohv,$planes){
<<<<<<< HEAD

    if ($tipousuario == Modelo_Usuario::CANDIDATO){   
      //si no tiene hoja de vida cargada       
      if (empty($infohv)){
        $_SESSION['mostrar_error'] = "Cargar la hoja de vida es obligatorio";
=======
    if ($tipousuario == Modelo_Usuario::CANDIDATO){   
      //si no tiene hoja de vida cargada       
      if (empty($infohv)){
>>>>>>> FF
        Utils::doRedirect(PUERTO.'://'.HOST.'/perfil/');
      }   
      $nrotest = Modelo_Cuestionario::totalTest();             
      $nrotestxusuario = Modelo_Cuestionario::totalTestxUsuario($idusuario);
      
      //si no tengo plan o mi plan no tiene permiso para el tercer formulario, debe tener uno menos del total de test          
      if ((!isset($planes) || !Modelo_PermisoPlan::tienePermiso($planes,'tercerFormulario')) && $nrotestxusuario < ($nrotest-1)){
<<<<<<< HEAD
        $_SESSION['mostrar_error'] = "Debe completar el cuestionario";
=======
>>>>>>> FF
        Utils::doRedirect(PUERTO.'://'.HOST.'/cuestionario/');
      }
      //si tengo plan y mi plan tiene permiso para el tercer formulario, debe tener el total de test
      elseif(isset($planes) && Modelo_PermisoPlan::tienePermiso($planes,'tercerFormulario') && $nrotestxusuario < $nrotest){
<<<<<<< HEAD
        $_SESSION['mostrar_error'] = "Debe completar el cuestionario";
=======
>>>>>>> FF
        Utils::doRedirect(PUERTO.'://'.HOST.'/cuestionario/');
      }  
      else{                    
        Utils::doRedirect(PUERTO.'://'.HOST.'/oferta/');  
      }                
    }
    //si es empresa
    else{  
      if (isset($planes)){
        Utils::doRedirect(PUERTO.'://'.HOST.'/publicar/');
      }
      else{
<<<<<<< HEAD
        $_SESSION['mostrar_error'] = "No tiene un plan contratado. Para poder publicar una oferta, por favor aplique a uno de nuestros planes";
=======
>>>>>>> FF
        Utils::doRedirect(PUERTO.'://'.HOST.'/planes/');
      }          
    }
  }

}  
?>
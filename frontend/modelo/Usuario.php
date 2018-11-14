<?php
/*Modelo que servira para la tabla de candidatos(usuario) y para la tabla de empresas*/
class Modelo_Usuario{

  const CANDIDATO = 1;
  const EMPRESA = 2;

  public static function obtieneNroUsuarios($pais,$tipo=self::CANDIDATO){
    if (empty($pais)){ return false; }
    $sql = "SELECT COUNT(1) AS cont 
            FROM mfo_usuario u 
            INNER JOIN mfo_ciudad c ON c.id_ciudad = u.id_ciudad 
            INNER JOIN mfo_provincia p ON p.id_provincia = c.id_provincia
            WHERE u.tipo_usuario=? AND u.estado=1 AND p.id_pais = ?";
    $rs = $GLOBALS['db']->auto_array($sql,array($tipo,$pais));
    return (!empty($rs['cont'])) ? $rs['cont'] : 0;
  }

  public static function estaLogueado(){    
    if ( !Utils::getArrayParam('mfo_datos', $_SESSION) || !Utils::getArrayParam('usuario', $_SESSION['mfo_datos'] )){            
      return false;
    }
    return true;
  }

  public static function autenticacion($username, $password){
    $password = md5($password);         
    $sql = "SELECT id_usuario_login, tipo_usuario, username, correo, dni
            FROM mfo_usuario_login 
            WHERE (username = ? OR correo = ?) AND password = ?";
    $rs = $GLOBALS['db']->auto_array($sql,array($username,$username,$password)); 
    if (empty($rs)){ return false; }
    if ($rs["tipo_usuario"] == self::CANDIDATO){
      $sql = "SELECT u.id_usuario, u.telefono, u.nombres, u.apellidos, u.fecha_nacimiento, u.fecha_creacion, u.foto,                       
                     u.token, u.id_ciudad, u.ultima_sesion, u.id_nacionalidad, u.tipo_doc, u.estado_civil,
                     u.tiene_trabajo, u.viajar, u.licencia, u.discapacidad, u.anosexp, u.status_carrera,                       
                     u.id_escolaridad, u.genero, u.id_univ, u.nombre_univ, p.id_pais 
              FROM mfo_usuario u
              INNER JOIN mfo_ciudad c ON c.id_ciudad = u.id_ciudad
              INNER JOIN mfo_provincia p ON p.id_provincia = c.id_provincia
              WHERE u.id_usuario_login = ? AND u.estado = 1";
    }
    else{
      $sql = "SELECT e.id_empresa AS id_usuario, e.telefono, e.nombres, e.fecha_nacimiento, e.fecha_creacion,
                      e.foto, e.id_ciudad,
                     e.ultima_sesion, e.id_nacionalidad, e.padre, t.nombres AS nombres_contacto,
                     t.apellidos AS apellidos_contacto, t.telefono1, t.telefono2, p.id_pais
              FROM mfo_empresa e
              INNER JOIN mfo_ciudad c ON c.id_ciudad = e.id_ciudad
              INNER JOIN mfo_provincia p ON p.id_provincia = c.id_provincia
              INNER JOIN mfo_contactoempresa t ON t.id_empresa = e.id_empresa
              WHERE e.id_usuario_login = ? AND e.estado = 1";
    }
    $rs2 = $GLOBALS['db']->auto_array($sql,array($rs["id_usuario_login"])); 
    if (empty($rs2)){ return false; }
    return array_merge($rs,$rs2);
  }

  public static function busquedaPorCorreo($correo){
    if (empty($correo)){ return false; }
    $sql = "SELECT u.id_usuario,u.correo,u.nombres,r.apellidos 
            FROM mfo_usuario u LEFT JOIN mfo_requisitosusuario r ON u.id_usuario = r.id_usuario 
            WHERE u.correo = ? LIMIT 1";
    $rs = $GLOBALS['db']->auto_array($sql,array($correo));
    return (!empty($rs['id_usuario'])) ? $rs : false;
  }

  public static function modificarPassword($pass,$id){
    if (empty($pass) || empty($id)){ return false; }
    $password = md5($pass);
    return $GLOBALS['db']->update("mfo_usuario",array("password"=>$password),"id_usuario=".$id);
  }

  public static function modificarFechaLogin($id,$tipo){
    if (empty($id) || empty($tipo)){ return false; }
    if ($tipo == self::CANDIDATO){
      return $GLOBALS['db']->update("mfo_usuario",array("ultima_sesion"=>date("Y-m-d H:i:s")),"id_usuario=".$id);
    }
    else{
      return $GLOBALS['db']->update("mfo_empresa",array("ultima_sesion"=>date("Y-m-d H:i:s")),"id_empresa=".$id); 
    }
  }

//   Búsqueda del username en la BD

public static function existeUsuario($username){
    if(empty($username)){ return false; }
    $sql = "SELECT IFNULL(u.id_usuario,e.id_empresa) AS id_usuario, 
                   IFNULL(u.nombres,e.nombres) AS nombres, 
                   u.apellidos, l.username, l.correo, u.telefono, l.dni
            FROM mfo_usuario_login l
            LEFT JOIN mfo_usuario u ON u.id_usuario_login = l.id_usuario_login
            LEFT JOIN mfo_empresa e ON e.id_usuario_login = l.id_usuario_login
            WHERE l.username = ?";
    $rs = $GLOBALS['db']->auto_array($sql,array($username));
    return (!empty($rs['id_usuario'])) ? $rs : false;
  }

public static function existeUsername($username){
  if(empty($username)){return false;}
  $sql = "SELECT * FROM mfo_usuario_login WHERE username = ?;";
  $rs = $GLOBALS['db']->auto_array($sql,array($username), true);
  return $rs;
} 


  public static function existeCorreo($correo){
    if(empty($correo)){ return false; }
    $sql = "select * from mfo_usuario_login where correo = ?";
    $rs = $GLOBALS['db']->auto_array($sql,array($correo));
    return (!empty($rs['correo'])) ? false : true;
  }

  public static function existeDni($dni){
    if(empty($dni)){ return false; }
    $sql = "select * from mfo_usuario_login where dni = ?";
    $rs = $GLOBALS['db']->auto_array($sql,array($dni));
    return (!empty($rs['dni'])) ? false : true;
  }

  public static function crearUsuario($dato_registro){
    if(empty($dato_registro)){return false;}
    // Utils::log("empresa datos en el modelo: ".print_r($dato_registro, true));
    // exit();

      if ($dato_registro['tipo_usuario'] == 1) {
        $result = $GLOBALS['db']->insert('mfo_usuario',array('telefono'=>$dato_registro['telefono'], 'nombres'=>$dato_registro['nombres'], 'apellidos'=>$dato_registro['apellidos'], 'fecha_nacimiento'=>$dato_registro['fecha_nacimiento'], 'fecha_creacion'=>$dato_registro['fecha_creacion'], "token"=>$dato_registro['token'], 'estado'=>$dato_registro['estado'], 'term_cond'=>$dato_registro['term_cond'], 'conf_datos'=>$dato_registro['conf_datos'], 'id_ciudad'=>$dato_registro['id_ciudad']['id_ciudad'], 'ultima_sesion'=>$dato_registro['ultima_sesion'], 'id_nacionalidad'=>$dato_registro['id_nacionalidad'], 'tipo_doc'=>$dato_registro['tipo_doc'], 'status_carrera'=>$dato_registro['status_carrera'], 'id_escolaridad'=>$dato_registro['id_escolaridad'], 'genero'=>$dato_registro['genero'], 'id_usuario_login'=>$dato_registro['id_usuario_login']));
      }
      else{
        $result = $GLOBALS['db']->insert('mfo_empresa',array('telefono'=>$dato_registro['telefono'], 'nombres'=>$dato_registro['nombres'],'fecha_nacimiento'=>$dato_registro['fecha_nacimiento'], 'fecha_creacion'=>$dato_registro['fecha_creacion'], 'term_cond'=>$dato_registro['term_cond'], 'conf_datos'=>$dato_registro['conf_datos'], 'id_ciudad'=>$dato_registro['id_ciudad']['id_ciudad'], 'ultima_sesion'=>$dato_registro['ultima_sesion'], 'id_nacionalidad'=>$dato_registro['id_nacionalidad'], 'id_usuario_login'=>$dato_registro['id_usuario_login']));
      }
      // Utils::log("datos del registro: ".print_r($dato_registro, true));
      // exit();
    return $result;
  }

  public static function activarCuenta($id_usuario, $tipousuario){
    if(empty($id_usuario) || empty($tipousuario)){return false;}
    if($tipousuario == 1){
      return $GLOBALS['db']->update("mfo_usuario",array("estado"=>1),"id_usuario=".$id_usuario);
    }else{
      return $GLOBALS['db']->update("mfo_empresa",array("estado"=>1),"id_empresa=".$id_usuario);
    }
  }

  public static function obtieneFoto($idUsuario){
    $rutaImagen = PUERTO.'://'.HOST.'/imagenes/usuarios/profile/'.$idUsuario.'.jpg';
    return $rutaImagen;   
  }

  // public static function obtieneRequisitosUsuario($id_usuario){
  //   $sql = "";
  // }

  public static function actualizarSession($idUsuario){

    $sql = "SELECT u.id_usuario, u.username, u.correo, u.telefono, u.dni, u.nombres,
                   u.fecha_nacimiento, u.foto, u.tipo_usuario, u.id_ciudad,
                   r.estado_civil, r.tiene_trabajo, r.viajar, r.licencia,
                   r.discapacidad,r.anosexp, r.status_carrera, r.id_escolaridad, 
                   r.genero, r.apellidos, u.id_nacionalidad, r.id_univ, r.nombre_univ, p.id_pais, ce.nombres AS nombres_contacto, 
                   ce.apellidos AS apellidos_contacto, ce.telefono1, ce.telefono2
            FROM mfo_usuario u 
            INNER JOIN mfo_ciudad c ON c.id_ciudad = u.id_ciudad
            INNER JOIN mfo_provincia p ON p.id_provincia = c.id_provincia   
            LEFT JOIN mfo_requisitosusuario r ON r.id_usuario = u.id_usuario
            LEFT JOIN mfo_contactoempresa ce ON ce.id_empresa = u.id_usuario
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
      $datos = array("foto"=>$foto,"nombres"=>$data['nombres'],"telefono"=>$data['telefono'],"id_ciudad"=>$data['ciudad'],"fecha_nacimiento"=>$data['fecha_nacimiento'],"id_nacionalidad"=>$data['id_nacionalidad']);
    }else{
      $datos = array("foto"=>$foto,"nombres"=>$data['nombres'],"telefono"=>$data['telefono'],"id_ciudad"=>$data['ciudad'],"fecha_nacimiento"=>$data['fecha_nacimiento'],"id_nacionalidad"=>$data['id_nacionalidad']);
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
      $sql .= "o.id_ofertas, u.id_usuario, u.username, u.nombres, r.apellidos, p.fecha_postulado, u.fecha_nacimiento, YEAR(now()) - YEAR(u.fecha_nacimiento) AS edad, p.asp_salarial, e.descripcion AS estudios, n.nombre_abr AS nacionalidad, n.id_pais, pr.id_provincia, pr.nombre AS ubicacion"; 
    }else{
      $sql .= "count(1) AS cantd_aspirantes";
    }
    
    $sql .= " FROM mfo_usuario u, mfo_postulacion p, mfo_oferta o, mfo_requisitosusuario r, mfo_escolaridad e, mfo_provincia pr, mfo_ciudad c, mfo_pais n
            WHERE u.id_usuario = p.id_usuario 
            AND p.id_ofertas = o.id_ofertas
            AND r.id_usuario = u.id_usuario
            AND e.id_escolaridad = r.id_escolaridad
            AND c.id_provincia = pr.id_provincia
            AND u.id_ciudad = c.id_ciudad
            AND n.id_pais = u.id_nacionalidad
            AND o.id_ofertas = $idOferta";

    if($obtCantdRegistros == false){
      $sql .= " ORDER BY u.nombres ASC";
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
      $sql .= "o.id_ofertas, u.id_usuario, u.username, u.nombres, r.apellidos, p.fecha_postulado, u.fecha_nacimiento, YEAR(now()) - YEAR(u.fecha_nacimiento) AS edad, p.asp_salarial, e.descripcion AS estudios, r.discapacidad, n.nombre_abr AS nacionalidad, n.id_pais, pro.id_provincia, pro.nombre AS ubicacion"; 
    }else{
      $sql .= "count(1) AS cantd_aspirantes";
    }

    $sql .= " FROM mfo_usuario u, mfo_postulacion p, mfo_oferta o, mfo_requisitosusuario r, mfo_escolaridad e, mfo_pais n, mfo_provincia pro, mfo_ciudad c";

    if(!empty($filtros['P']) && $filtros['P'] != 0){
      $sql .= ", mfo_usuario_plan up, mfo_plan pl ";
    }

    $sql .= " WHERE u.id_usuario = p.id_usuario 
              AND p.id_ofertas = o.id_ofertas
              AND e.id_escolaridad = r.id_escolaridad
              AND n.id_pais = u.id_nacionalidad
              AND c.id_provincia = pro.id_provincia
              AND u.id_ciudad = c.id_ciudad
              AND o.id_ofertas = $idOferta
              AND r.id_usuario = u.id_usuario
            ";

    if(!empty($filtros['F']) && $filtros['F'] != 0){
       if($filtros['F'] == 1){
        $sql .= " AND DATE_FORMAT(p.fecha_postulado, '%Y-%m-%d') = DATE_FORMAT(NOW(), '%Y-%m-%d')";
       }
       
       if($filtros['F'] == 2){
        $sql .= " AND DATE_FORMAT(p.fecha_postulado, '%Y-%m-%d') BETWEEN DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 3 DAY), '%Y-%m-%d') AND DATE_FORMAT(NOW(), '%Y-%m-%d')";
       }
       
       if($filtros['F'] == 3){
         $sql .= " AND DATE_FORMAT(p.fecha_postulado, '%Y-%m-%d') BETWEEN DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 WEEK), '%Y-%m-%d') AND DATE_FORMAT(NOW(), '%Y-%m-%d')";
       }

       if($filtros['F'] == 4){
        $sql .= " AND DATE_FORMAT(p.fecha_postulado, '%Y-%m-%d') BETWEEN DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 MONTH), '%Y-%m-%d') AND DATE_FORMAT(NOW(), '%Y-%m-%d')";
       }
    }
    
    //obtener los aspirantes por los que pagaron y los q no pagaron
    if(!empty($filtros['P']) && $filtros['P'] != 0){

      $sql .= " AND up.id_usuario = u.id_usuario AND up.id_plan = pl.id_plan";
      if($filtros['P'] == 2){
        $sql .=  " AND pl.costo > 0" ;
      }else{
        $sql .=  " AND pl.costo = 0 AND up.estado = 1" ;
      }
    }

    //obtiene los aspirantes para esa ubicacion 
    if(!empty($filtros['U']) && $filtros['U'] != 0){ 

      $sql .= " AND pro.id_provincia = ".$filtros['U'];
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

    //filtra los candidatos por ciertos requisitos
    if(!empty($filtros['D']) && $filtros['D'] != 0){ 
      if($filtros['D'] == 2){
        $req = 0;
      }else{
        $req = 1;
      }
      $sql .= " AND r.discapacidad = ".$req;
    }

    if(!empty($filtros['T']) && $filtros['T'] != 0){ 
      if($filtros['T'] == 2){
        $req = 0;
      }else{
        $req = 1;
      }
      $sql .= " AND r.tiene_trabajo = ".$req;
    }

    if(!empty($filtros['L']) && $filtros['L'] != 0){ 
      if($filtros['L'] == 2){
        $req = 0;
      }else{
        $req = 1;
      }
      $sql .= " AND r.licencia = ".$req;
    }

    if(!empty($filtros['V']) && $filtros['V'] != 0){ 
      if($filtros['V'] == 2){
        $req = 0;
      }else{
        $req = 1;
      }
      $sql .= " AND r.viajar = ".$req;
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

    if(!empty($filtros['P']) && $filtros['P'] != 0){

      if($filtros['P'] == 2){
        $sql .= ' GROUP BY up.id_usuario';
      }
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
      }else if($tipo == 2){
        if($t == 1){
          $filtros['O'] = 2;
          $sql .= " ORDER BY p.fecha_postulado ASC";
        }
        if($t == 2){
          $filtros['O'] = 1;
          $sql .= " ORDER BY p.fecha_postulado DESC";
        }
      }else if($tipo == 3){
        if($t == 1){
          $filtros['O'] = 2;
          $sql .= " ORDER BY e.descripcion ASC";
        }
        if($t == 2){
          $filtros['O'] = 1;
          $sql .= " ORDER BY e.descripcion DESC";
        }
      }else if($tipo == 4){
        if($t == 1){
          $filtros['O'] = 2;
          $sql .= " ORDER BY p.asp_salarial ASC";
        }
        if($t == 2){
          $filtros['O'] = 1;
          $sql .= " ORDER BY p.asp_salarial DESC";
        }
      }

    }else{
      $sql .= " ORDER BY u.nombres ASC";
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

  public static function busquedaGlobalAspirantes($id_pais_empresa,$page,$obtCantdRegistros=false){

    $sql = 'SELECT ';
    if($obtCantdRegistros == false){

      $sql .= 'u.id_usuario, u.username, u.nombres, r.apellidos, u.fecha_nacimiento,u.fecha_creacion, YEAR(now()) - YEAR(u.fecha_nacimiento) AS edad, e.descripcion AS estudios, u.id_nacionalidad AS id_pais, pr.nombre AS ubicacion, pr.id_provincia';
    }else{
      $sql .= "count(1) AS cantd_aspirantes";
    }

    $sql .= ' FROM mfo_usuario u, mfo_requisitosusuario r, mfo_escolaridad e, mfo_provincia pr, mfo_ciudad c
            WHERE 
             r.id_usuario = u.id_usuario
            AND c.id_provincia = pr.id_provincia
            AND u.id_ciudad = c.id_ciudad
            AND e.id_escolaridad = r.id_escolaridad
            AND u.tipo_usuario = 1
            AND u.id_usuario = (SELECT p.id_usuario FROM mfo_porcentajextest p WHERE p.id_usuario = u.id_usuario LIMIT 1)
            AND pr.id_pais = '.$id_pais_empresa;

    if($obtCantdRegistros == false){
      $sql .= " ORDER BY u.nombres ASC";
      $page = ($page - 1) * REGISTRO_PAGINA;
      $sql .= " LIMIT ".$page.",".REGISTRO_PAGINA; 
      $rs = $GLOBALS['db']->auto_array($sql,array(),true);
    }else{
      $rs = $GLOBALS['db']->auto_array($sql,array()); 
      $rs = $rs['cantd_aspirantes'];
    }
    return $rs; 
  }

  public static function filtrarAspirantesGlobal($id_pais_empresa,&$filtros,$page,$obtCantdRegistros=false){

    $sql = "SELECT ";

    if($obtCantdRegistros == false){
      $sql .= "u.id_usuario, u.username, u.nombres, r.apellidos, u.fecha_nacimiento,u.fecha_creacion, YEAR(now()) - YEAR(u.fecha_nacimiento) AS edad, e.descripcion AS estudios, u.id_nacionalidad AS id_pais, pr.nombre AS ubicacion, pr.id_provincia"; 
    }else{
      $sql .= "count(1) AS cantd_aspirantes";
    }

    $sql .= " FROM mfo_usuario u, mfo_requisitosusuario r, mfo_escolaridad e, mfo_provincia pr, mfo_ciudad c";

    if(!empty($filtros['A']) && $filtros['A'] != 0){
      $sql .= ",  mfo_usuarioxarea ua ";
    }

    if(!empty($filtros['P']) && $filtros['P'] != 0){
      $sql .= ", mfo_usuario_plan up, mfo_plan pl ";
    }

    $sql .= " WHERE r.id_usuario = u.id_usuario
            AND c.id_provincia = pr.id_provincia
            AND u.id_ciudad = c.id_ciudad
            AND e.id_escolaridad = r.id_escolaridad
            AND u.tipo_usuario = 1
            AND u.id_usuario = (SELECT p.id_usuario FROM mfo_porcentajextest p WHERE p.id_usuario = u.id_usuario LIMIT 1)
            AND pr.id_pais = ".$id_pais_empresa;
   
    //segun el escogido calcular fecha y ponersela a la consulta
    if(!empty($filtros['F']) && $filtros['F'] != 0){
       if($filtros['F'] == 1){
        $sql .= " AND DATE_FORMAT(p.fecha_creacion, '%Y-%m-%d') = DATE_FORMAT(NOW(), '%Y-%m-%d')";
       }
       
       if($filtros['F'] == 2){
        $sql .= " AND DATE_FORMAT(p.fecha_creacion, '%Y-%m-%d') BETWEEN DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 3 DAY), '%Y-%m-%d') AND DATE_FORMAT(NOW(), '%Y-%m-%d')";
       }
       
       if($filtros['F'] == 3){
         $sql .= " AND DATE_FORMAT(p.fecha_creacion, '%Y-%m-%d') BETWEEN DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 WEEK), '%Y-%m-%d') AND DATE_FORMAT(NOW(), '%Y-%m-%d')";
       }

       if($filtros['F'] == 4){
        $sql .= " AND DATE_FORMAT(p.fecha_creacion, '%Y-%m-%d') BETWEEN DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 MONTH), '%Y-%m-%d') AND DATE_FORMAT(NOW(), '%Y-%m-%d')";
       }
    }

    if(!empty($filtros['A']) && $filtros['A'] != 0){
      $sql .= " AND ua.id_usuario = u.id_usuario AND ua.id_area = ".$filtros['A'];
    }

    //obtener los aspirantes por los que pagaron y los q no pagaron
    if(!empty($filtros['P']) && $filtros['P'] != 0){

      $sql .= " AND up.id_usuario = u.id_usuario AND up.id_plan = pl.id_plan";
      if($filtros['P'] == 2){
        $sql .=  " AND pl.costo > 0" ;
      }else{
        $sql .=  " AND pl.costo = 0 AND up.estado = 1" ;
      }
    }

    //obtiene los aspirantes para esa ubicacion 
    if(!empty($filtros['U']) && $filtros['U'] != 0){ 

      $sql .= " AND pr.id_provincia = ".$filtros['U'];
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

    //filtra los candidatos por ciertos requisitos
    if(!empty($filtros['D']) && $filtros['D'] != 0){ 
      if($filtros['D'] == 2){
        $req = 0;
      }else{
        $req = 1;
      }
      $sql .= " AND r.discapacidad = ".$req;
    }

    if(!empty($filtros['T']) && $filtros['T'] != 0){ 
      if($filtros['T'] == 2){
        $req = 0;
      }else{
        $req = 1;
      }
      $sql .= " AND r.tiene_trabajo = ".$req;
    }

    if(!empty($filtros['L']) && $filtros['L'] != 0){ 
      if($filtros['L'] == 2){
        $req = 0;
      }else{
        $req = 1;
      }
      $sql .= " AND r.licencia = ".$req;
    }

    if(!empty($filtros['V']) && $filtros['V'] != 0){ 
      if($filtros['V'] == 2){
        $req = 0;
      }else{
        $req = 1;
      }
      $sql .= " AND r.viajar = ".$req;
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

      $sql .= " AND (u.nombres LIKE '%".$pclave."%' OR r.apellidos LIKE '%".$pclave."%' OR (YEAR(now()) - YEAR(u.fecha_nacimiento)) = '".$pclave."' OR u.fecha_creacion LIKE '%".$pclave."%')";
    }

    if(!empty($filtros['P']) && $filtros['P'] != 0){

      if($filtros['P'] == 2){
        $sql .= ' GROUP BY up.id_usuario';
      }
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
      }else if($tipo == 2){
        if($t == 1){
          $filtros['O'] = 2;
          $sql .= " ORDER BY u.fecha_creacion ASC";
        }
        if($t == 2){
          $filtros['O'] = 1;
          $sql .= " ORDER BY u.fecha_creacion DESC";
        }
      }else if($tipo == 3){
        if($t == 1){
          $filtros['O'] = 2;
          $sql .= " ORDER BY e.descripcion ASC";
        }
        if($t == 2){
          $filtros['O'] = 1;
          $sql .= " ORDER BY e.descripcion DESC";
        }
      }

    }else{
      $sql .= " ORDER BY u.nombres ASC";
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

  public static function busquedaPorId($id,$todos=false){
    if (empty($id)){ return false; }
    if (!$todos){
      $sql = "SELECT id_usuario, tipo_usuario, nombres FROM mfo_usuario WHERE id_usuario = ?";
    }
    else{
      $sql = "SELECT u.id_usuario, u.nombres, u.correo, u.tipo_usuario, p.id_pais, r.apellidos 
              FROM mfo_usuario u 
              INNER JOIN mfo_ciudad c ON c.id_ciudad = u.id_ciudad
              INNER JOIN mfo_provincia p ON p.id_provincia = c.id_provincia
              LEFT JOIN mfo_requisitosusuario r ON r.id_usuario = u.id_usuario 
              WHERE u.id_usuario = ?";
    }
    return $GLOBALS['db']->auto_array($sql,array($id)); 
  }

  public static function validaPermisos($tipousuario,$idusuario,$infohv,$planes,$controlador=false){
    if ($tipousuario == Modelo_Usuario::CANDIDATO){   
      //si no tiene hoja de vida cargada       
      if (empty($infohv)){
        $_SESSION['mostrar_error'] = "Cargar la hoja de vida es obligatorio";
        Utils::doRedirect(PUERTO.'://'.HOST.'/perfil/');
      }   
      $nrotest = Modelo_Cuestionario::totalTest();             
      $nrotestxusuario = Modelo_Cuestionario::totalTestxUsuario($idusuario);
      
      //si no tengo plan o mi plan no tiene permiso para el tercer formulario, debe tener uno menos del total de test          
      if ((!isset($planes) || !Modelo_PermisoPlan::tienePermiso($planes,'tercerFormulario')) && $nrotestxusuario < ($nrotest-1)){
        $_SESSION['mostrar_error'] = "Debe completar el cuestionario";
        Utils::doRedirect(PUERTO.'://'.HOST.'/cuestionario/');
      }
      //si tengo plan y mi plan tiene permiso para el tercer formulario, debe tener el total de test
      elseif(isset($planes) && Modelo_PermisoPlan::tienePermiso($planes,'tercerFormulario') && $nrotestxusuario < $nrotest){
        $_SESSION['mostrar_error'] = "Debe completar el cuestionario";
        Utils::doRedirect(PUERTO.'://'.HOST.'/cuestionario/');
      }
      elseif (isset($planes) && !Modelo_PermisoPlan::tienePermiso($planes, 'busquedaOferta')) {
        Utils::doRedirect(PUERTO.'://'.HOST.'/');  
      }  
      else{           
        if ($controlador == 'login'){
          Utils::doRedirect(PUERTO.'://'.HOST.'/oferta/');  
        }                         
      }                
    }
    //si es empresa
    else{  
      if (isset($planes)){
        Utils::doRedirect(PUERTO.'://'.HOST.'/publicar/');
      }
      else{
        $_SESSION['mostrar_error'] = "No tiene un plan contratado. Para poder publicar una oferta, por favor aplique a uno de nuestros planes";
        Utils::doRedirect(PUERTO.'://'.HOST.'/planes/');
      }          
    }
  }


  public static function aspSalarial($id_usuario, $id_oferta){
    if(empty($id_usuario) || empty($id_oferta)){return false;}
    $sql = "SELECT asp_salarial FROM mfo_postulacion WHERE id_usuario = ? AND id_ofertas = ? LIMIT 1;";
    return $GLOBALS['db']->auto_array($sql,array($id_usuario,$id_oferta));
  }

  public static function infoUsuario($id_usuario){
    if(empty($id_usuario)){return false;}
    $sql = "SELECT 
    mu.*,
    mul.tipo_usuario as tipo,
    mul.username as username,
    mul.correo as correo,
    mul.dni as dni,
    mpais.nombre_abr as pais,
    mpro.nombre as provincia,
    mc.nombre as ciudad,
    me.descripcion as escolaridad,
    DATE_FORMAT(mu.fecha_nacimiento, '%Y-%m-%d') AS fecha_nacimiento,
    YEAR(NOW()) - YEAR(mu.fecha_nacimiento) AS edad,
    pais.nombre_abr as nacionalidad,
    muni.nombre as universidad,
    GROUP_CONCAT(nii.id_nivelIdioma_idioma) AS idiomas
FROM
    mfo_usuario_login mul,
    mfo_ciudad mc,
    mfo_provincia mpro,
    mfo_pais mpais,
    mfo_pais pais,
    mfo_escolaridad me,
    mfo_usuario mu
    LEFT JOIN mfo_universidades muni ON mu.id_univ = muni.id_univ
    LEFT JOIN mfo_usuario_nivelidioma niu ON mu.id_usuario = niu.id_usuario
    LEFT JOIN mfo_nivelidioma_idioma nii ON nii.id_nivelIdioma_idioma = niu.id_nivelIdioma_idioma
WHERE
    mpais.id_pais = mpro.id_pais
    AND me.id_escolaridad = mu.id_escolaridad
        AND mpro.id_provincia = mc.id_provincia
        AND mc.id_ciudad = mu.id_ciudad
        AND mu.id_nacionalidad = pais.id_pais
        AND mul.tipo_usuario = 1
        AND mul.id_usuario_login = mu.id_usuario_login
        AND mu.id_usuario = ?;";
    return $GLOBALS['db']->auto_array($sql,array($id_usuario));
  }

  public static function obtieneTodosCandidatos(){
    $sql = "SELECT u.id_usuario, u.nombres, u.correo, r.apellidos, r.viajar, 
                   p.id_provincia, p.id_pais 
            FROM mfo_usuario u 
            INNER JOIN mfo_requisitosusuario r ON u.id_usuario = r.id_usuario 
            INNER JOIN mfo_ciudad c ON c.id_ciudad = u.id_ciudad
            INNER JOIN mfo_provincia p ON p.id_provincia = c.id_provincia 
            WHERE u.estado = 1 AND u.tipo_usuario = ?
            ORDER BY u.id_usuario";
    return $GLOBALS['db']->Query($sql,array(Modelo_Usuario::CANDIDATO));                 

  }

}  
?>
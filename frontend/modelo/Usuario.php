<?php
/*Modelo que servira para la tabla de candidatos(usuario) y para la tabla de empresas*/
class Modelo_Usuario{

  const CANDIDATO = 1;
  const EMPRESA = 2;

  public static function obtieneNroUsuarios($pais,$tipo=self::CANDIDATO){
    if (empty($pais)){ return false; }
    if ($tipo == self::CANDIDATO){
      $sql = "SELECT COUNT(1) AS cont 
              FROM mfo_usuario u 
              INNER JOIN mfo_ciudad c ON c.id_ciudad = u.id_ciudad 
              INNER JOIN mfo_provincia p ON p.id_provincia = c.id_provincia
              WHERE u.estado=1 AND p.id_pais = ?";
    }        
    else{
      $sql = "SELECT COUNT(1) AS cont 
              FROM mfo_empresa e 
              INNER JOIN mfo_ciudad c ON c.id_ciudad = e.id_ciudad 
              INNER JOIN mfo_provincia p ON p.id_provincia = c.id_provincia
              WHERE e.estado=1 AND p.id_pais = ?";
    }
    $rs = $GLOBALS['db']->auto_array($sql,array($pais));
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
                     u.id_escolaridad, u.genero, u.id_univ, u.nombre_univ, p.id_pais, u.estado 
              FROM mfo_usuario u
              INNER JOIN mfo_ciudad c ON c.id_ciudad = u.id_ciudad
              INNER JOIN mfo_provincia p ON p.id_provincia = c.id_provincia
              WHERE u.id_usuario_login = ?";
    }
    else{
      $sql = "SELECT e.id_empresa AS id_usuario, e.telefono, e.nombres, e.fecha_nacimiento, e.fecha_creacion,
                     e.foto, e.id_ciudad, e.ultima_sesion, e.id_nacionalidad, e.padre, t.nombres AS nombres_contacto,
                     t.apellidos AS apellidos_contacto, t.telefono1, t.telefono2, p.id_pais, e.estado
              FROM mfo_empresa e
              INNER JOIN mfo_ciudad c ON c.id_ciudad = e.id_ciudad
              INNER JOIN mfo_provincia p ON p.id_provincia = c.id_provincia
              INNER JOIN mfo_contactoempresa t ON t.id_empresa = e.id_empresa
              WHERE e.id_usuario_login = ?";
    }
    $rs2 = $GLOBALS['db']->auto_array($sql,array($rs["id_usuario_login"])); 
    if (empty($rs2)){ return false; }
    return array_merge($rs,$rs2);
  }

  public static function busquedaPorCorreo($correo){
    if (empty($correo)){ return false; }    
    $sql = "SELECT id_usuario_login, tipo_usuario, correo FROM mfo_usuario_login WHERE correo = ? LIMIT 1";          
    $rs = $GLOBALS['db']->auto_array($sql,array($correo));
    if (empty($rs)){ return false; }
    if ($rs["tipo_usuario"] == self::CANDIDATO){
      $sql = "SELECT id_usuario, nombres, apellidos FROM mfo_usuario WHERE id_usuario_login = ?";
    }
    else{
      $sql = "SELECT id_empresa AS id_usuario, nombres FROM mfo_empresa WHERE id_usuario_login = ?";      
    }
    $rs2 = $GLOBALS['db']->auto_array($sql,array($rs["id_usuario_login"]));
    if (empty($rs2)){ return false; }
    return array_merge($rs,$rs2);    
  }

  public static function modificarPassword($pass,$id){
    if (empty($pass) || empty($id)){ return false; }
    $password = md5($pass);
    return $GLOBALS['db']->update("mfo_usuario_login",array("password"=>$password),"id_usuario_login=".$id);
  }

  public static function modificarFechaLogin($id,$tipo=self::CANDIDATO){
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
    $sql = "SELECT IFNULL(u.id_usuario,e.id_empresa) AS id_usuario, IFNULL(u.nombres,e.nombres) AS nombres, 
                   u.apellidos, l.username, l.correo, u.telefono, l.dni, l.tipo_usuario
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
 
    if ($dato_registro['tipo_usuario'] == 1) {
      $result = $GLOBALS['db']->insert('mfo_usuario',array('telefono'=>$dato_registro['telefono'], 'nombres'=>$dato_registro['nombres'], 'apellidos'=>$dato_registro['apellidos'], 'fecha_nacimiento'=>$dato_registro['fecha_nacimiento'], 'fecha_creacion'=>$dato_registro['fecha_creacion'], "token"=>$dato_registro['token'], 'estado'=>$dato_registro['estado'], 'term_cond'=>$dato_registro['term_cond'], 'conf_datos'=>$dato_registro['conf_datos'], 'id_ciudad'=>$dato_registro['id_ciudad'], 'ultima_sesion'=>$dato_registro['ultima_sesion'], 'id_nacionalidad'=>$dato_registro['id_nacionalidad'], 'tipo_doc'=>$dato_registro['tipo_doc'], 'status_carrera'=>$dato_registro['status_carrera'], 'id_escolaridad'=>$dato_registro['id_escolaridad'], 'genero'=>$dato_registro['genero'], 'id_usuario_login'=>$dato_registro['id_usuario_login']));
    }
    else{

      $arreglo_datos = array('telefono'=>$dato_registro['telefono'], 'nombres'=>$dato_registro['nombres'],'fecha_nacimiento'=>$dato_registro['fecha_nacimiento'], 'fecha_creacion'=>$dato_registro['fecha_creacion'], 'term_cond'=>$dato_registro['term_cond'], 'conf_datos'=>$dato_registro['conf_datos'], 'id_ciudad'=>$dato_registro['id_ciudad'], 'ultima_sesion'=>$dato_registro['ultima_sesion'], 'id_nacionalidad'=>$dato_registro['id_nacionalidad'], 'id_usuario_login'=>$dato_registro['id_usuario_login'],'estado'=>$dato_registro['estado']);

      if(isset($dato_registro['padre'])){
        $arreglo_datos['padre'] = $dato_registro['padre'];
      }

      $result = $GLOBALS['db']->insert('mfo_empresa',$arreglo_datos);
    }      

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
  public static function desactivarCuenta($id_usuario,$tipo=self::CANDIDATO){
    if(empty($id_usuario)){ return false; }
    if ($tipo == self::CANDIDATO){
      return $GLOBALS['db']->update("mfo_usuario",array("estado"=>0),"id_usuario=".$id_usuario);
    }
    else{
      return $GLOBALS['db']->update("mfo_empresa",array("estado"=>0),"id_empresa=".$id_usuario); 
    }
  }

  public static function obtieneFoto($username){
    $rutaImagen = PUERTO.'://'.HOST.'/imagenes/usuarios/'.$username.'/';
    return $rutaImagen;   
  }

  public static function actualizarSession($idUsuario,$tipo_usuario){

    if ($tipo_usuario == self::CANDIDATO){
      $sql = "SELECT u.id_usuario, u.telefono, u.nombres, u.apellidos, u.fecha_nacimiento, u.fecha_creacion, u.foto,                       
                     u.token, u.id_ciudad, u.ultima_sesion, u.id_nacionalidad, u.tipo_doc, u.estado_civil,
                     u.tiene_trabajo, u.viajar, u.licencia, u.discapacidad, u.anosexp, u.status_carrera,                       
                     u.id_escolaridad, u.genero, u.id_univ, u.nombre_univ, p.id_pais, ul.id_usuario_login, ul.correo, ul.dni, ul.username, ul.tipo_usuario
              FROM mfo_usuario u
              INNER JOIN mfo_usuario_login ul ON ul.id_usuario_login = u.id_usuario_login
              INNER JOIN mfo_ciudad c ON c.id_ciudad = u.id_ciudad
              INNER JOIN mfo_provincia p ON p.id_provincia = c.id_provincia
              WHERE u.id_usuario = ? AND u.estado = 1";
    }
    else{
      $sql = "SELECT e.id_empresa AS id_usuario, e.telefono, e.nombres, e.fecha_nacimiento, e.fecha_creacion,
                      e.foto, e.id_ciudad, e.ultima_sesion, e.id_nacionalidad, e.padre, t.nombres AS nombres_contacto,
                     t.apellidos AS apellidos_contacto, t.telefono1, t.telefono2, ul.id_usuario_login, ul.correo, ul.dni, ul.username, ul.tipo_usuario,p.id_pais

              FROM mfo_empresa e
              INNER JOIN mfo_usuario_login ul ON ul.id_usuario_login = e.id_usuario_login
              INNER JOIN mfo_ciudad c ON c.id_ciudad = e.id_ciudad
              INNER JOIN mfo_provincia p ON p.id_provincia = c.id_provincia
              INNER JOIN mfo_contactoempresa t ON t.id_empresa = e.id_empresa
              WHERE e.id_empresa = ? AND e.estado = 1";
    }
    return $rs2 = $GLOBALS['db']->auto_array($sql,array($idUsuario)); 
  }

  public static function updateUsuario($data,$idUsuario,$imagen=false,$session_foto,$tipo_usuario){

    $foto = 0;
    if($imagen['error'] != 4)
    { 
      $foto = 1;

    }else if($imagen['error'] == 4 && $session_foto == 1){
      $foto = 1;
    }

    if($tipo_usuario == self::CANDIDATO){

        $datos = array("foto"=>$foto,"nombres"=>$data['nombres'],"telefono"=>$data['telefono'],"id_ciudad"=>$data['ciudad'],"fecha_nacimiento"=>$data['fecha_nacimiento'],"id_nacionalidad"=>$data['id_nacionalidad'],"apellidos"=>$data['apellidos'],"genero"=>$data['genero'],"discapacidad"=>$data['discapacidad'],"anosexp"=>$data['experiencia'],"status_carrera"=>$data['estatus'],"id_escolaridad"=>$data['escolaridad'],"licencia"=>$data['licencia'],"viajar"=>$data['viajar'],"tiene_trabajo"=>$data['tiene_trabajo'],"estado_civil"=>$data['estado_civil'],"tipo_doc"=>$data['tipo_doc']); 

        if(isset($_POST['lugar_estudio']) && $_POST['lugar_estudio'] != -1){
          if($_POST['lugar_estudio'] == 1){
            $datos['nombre_univ'] = $_POST['universidad2'];
            $datos['id_univ'] = 'null';
          }else{
            $datos['id_univ'] = $_POST['universidad'];
            $datos['nombre_univ'] = ' ';
          }
        }else{
          $datos['id_univ'] = 'null';
          $datos['nombre_univ'] = ' ';
        }

        return $GLOBALS['db']->update("mfo_usuario",$datos,"id_usuario=".$idUsuario);

    }else{

      $datos = array("foto"=>$foto,"nombres"=>$data['nombres'],"telefono"=>$data['telefono'],"id_ciudad"=>$data['ciudad'],"fecha_nacimiento"=>$data['fecha_nacimiento'],"id_nacionalidad"=>$data['id_nacionalidad']);
      return $GLOBALS['db']->update("mfo_empresa",$datos,"id_empresa=".$idUsuario);
    }
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
      $sql .= "o.id_ofertas, u.id_usuario, ul.username, u.nombres, u.apellidos, p.fecha_postulado, u.fecha_nacimiento, YEAR(now()) - YEAR(u.fecha_nacimiento) AS edad, p.asp_salarial, e.descripcion AS estudios, n.nombre_abr AS nacionalidad, n.id_pais, pr.id_provincia, pr.nombre AS ubicacion"; 
    }else{
      $sql .= "n.id_pais, pr.id_provincia, pr.nombre AS ubicacion";
    }
    
    $sql .= " FROM mfo_usuario u, mfo_postulacion p, mfo_oferta o, mfo_escolaridad e, mfo_provincia pr, mfo_ciudad c, mfo_pais n, mfo_usuario_login ul
            WHERE u.id_usuario = p.id_usuario 
            AND p.id_ofertas = o.id_ofertas
            AND e.id_escolaridad = u.id_escolaridad
            AND c.id_provincia = pr.id_provincia
            AND u.id_ciudad = c.id_ciudad
            AND n.id_pais = u.id_nacionalidad
            AND u.id_usuario_login = ul.id_usuario_login
            AND u.id_usuario = (SELECT pt.id_usuario FROM mfo_porcentajextest pt WHERE pt.id_usuario = u.id_usuario LIMIT 1)
            AND o.id_ofertas = $idOferta";

    if($obtCantdRegistros == false){
      $sql .= " ORDER BY u.nombres ASC";
      $page = ($page - 1) * REGISTRO_PAGINA;
      $sql .= " LIMIT ".$page.",".REGISTRO_PAGINA; 
    }
    $rs = $GLOBALS['db']->auto_array($sql,array(),true);
    return $rs; 
  }

  public static function filtrarAspirantes($idOferta,&$filtros,$page,$obtCantdRegistros=false){

    $sql = "SELECT ";

    if($obtCantdRegistros == false){
      $sql .= "o.id_ofertas, u.id_usuario, ul.username, u.nombres, u.apellidos, p.fecha_postulado, u.fecha_nacimiento, YEAR(now()) - YEAR(u.fecha_nacimiento) AS edad, p.asp_salarial, e.descripcion AS estudios, u.discapacidad, n.nombre_abr AS nacionalidad, n.id_pais, pro.id_provincia, pro.nombre AS ubicacion"; 
    }else{
      $sql .= "n.id_pais, pr.id_provincia, pro.nombre AS ubicacion";
    }

    $sql .= " FROM mfo_usuario u, mfo_postulacion p, mfo_oferta o, mfo_usuario_login ul, mfo_escolaridad e, mfo_pais n, mfo_provincia pro, mfo_ciudad c";

    if(!empty($filtros['A']) && $filtros['A'] != 0){
      $sql .= ",  mfo_usuarioxarea ua ";
    }

    if(!empty($filtros['P']) && $filtros['P'] != 0){
      $sql .= ", mfo_usuario_plan up, mfo_plan pl ";
    }

    $sql .= " WHERE u.id_usuario = p.id_usuario 
              AND u.id_usuario_login = ul.id_usuario_login
              AND p.id_ofertas = o.id_ofertas
              AND e.id_escolaridad = u.id_escolaridad
              AND n.id_pais = u.id_nacionalidad
              AND c.id_provincia = pro.id_provincia
              AND u.id_ciudad = c.id_ciudad
              AND u.id_usuario = (SELECT pt.id_usuario FROM mfo_porcentajextest pt WHERE pt.id_usuario = u.id_usuario LIMIT 1)
              AND o.id_ofertas = $idOferta";

    if(!empty($filtros['A']) && $filtros['A'] != 0){
      $sql .= " AND ua.id_usuario = u.id_usuario AND ua.id_area = ".$filtros['A'];
    }

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
        $sql .= " AND p.asp_salarial BETWEEN '386' and '700'";
      }

      if($filtros['S'] == 3){
        $sql .= " p.asp_salarial BETWEEN '700' AND '1200'";
      }

      if($filtros['S'] == 4){
        $sql .= " AND p.asp_salarial >= 1200";
      }
    }

    //obtiene los aspirantes por genero
    if(!empty($filtros['G']) && $filtros['G'] != 0){
      $g = array_search($filtros['G'],VALOR_GENERO);
      if($g != false){
        $sql .= " AND u.genero = '".$g."'";
      }
    }

    //obtiene los aspirantes por nacionalidad
    if(!empty($filtros['N']) && $filtros['N'] != 0){
      $sql .= " AND u.id_nacionalidad = ".$filtros['N'];
    }

    //obtiene los aspirantes por escolaridad
    if(!empty($filtros['E']) && $filtros['E'] != 0){ 
      $sql .= " AND u.id_escolaridad = ".$filtros['E'];
    }

    //filtra los candidatos por ciertos requisitos
    if(!empty($filtros['D']) && $filtros['D'] != 0){ 
      if($filtros['D'] == 2){
        $req = 0;
      }else{
        $req = 1;
      }
      $sql .= " AND u.discapacidad = ".$req;
    }

    if(!empty($filtros['T']) && $filtros['T'] != 0){ 
      if($filtros['T'] == 2){
        $req = 0;
      }else{
        $req = 1;
      }
      $sql .= " AND u.tiene_trabajo = ".$req;
    }

    if(!empty($filtros['L']) && $filtros['L'] != 0){ 
      if($filtros['L'] == 2){
        $req = 0;
      }else{
        $req = 1;
      }
      $sql .= " AND u.licencia = ".$req;
    }

    if(!empty($filtros['V']) && $filtros['V'] != 0){ 
      if($filtros['V'] == 2){
        $req = 0;
      }else{
        $req = 1;
      }
      $sql .= " AND u.viajar = ".$req;
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

      $sql .= " AND (u.nombres LIKE '%".htmlentities($pclave,ENT_QUOTES,'UTF-8')."%' OR u.apellidos LIKE '%".htmlentities($pclave,ENT_QUOTES,'UTF-8')."%' OR (YEAR(now()) - YEAR(u.fecha_nacimiento)) = '".$pclave."' OR p.asp_salarial LIKE '%".$pclave."%' OR p.fecha_postulado LIKE '%".$pclave."%')";
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
    }

    $rs = $GLOBALS['db']->auto_array($sql,array(),true);
    return $rs;
  }

  public static function busquedaGlobalAspirantes($id_pais_empresa,$page,$obtCantdRegistros=false){

    $sql = 'SELECT ';
    if($obtCantdRegistros == false){

      $sql .= 'u.id_usuario, ul.username, u.nombres, u.apellidos, u.fecha_nacimiento,u.fecha_creacion, YEAR(now()) - YEAR(u.fecha_nacimiento) AS edad, e.descripcion AS estudios, u.id_nacionalidad AS id_pais, pr.nombre AS ubicacion, pr.id_provincia';
    }else{
      $sql .= "u.id_nacionalidad AS id_pais, pr.id_provincia, pr.nombre AS ubicacion";
    }

    $sql .= ' FROM mfo_usuario u, mfo_escolaridad e, mfo_provincia pr, mfo_ciudad c, mfo_usuario_login ul
            WHERE 
            ul.id_usuario_login = u.id_usuario_login
            AND c.id_provincia = pr.id_provincia
            AND u.id_ciudad = c.id_ciudad
            AND e.id_escolaridad = u.id_escolaridad
            AND ul.tipo_usuario = 1
            AND u.id_usuario = (SELECT p.id_usuario FROM mfo_porcentajextest p WHERE p.id_usuario = u.id_usuario LIMIT 1)
            AND pr.id_pais = '.$id_pais_empresa;

    if($obtCantdRegistros == false){
      $sql .= " ORDER BY u.nombres ASC";
      $page = ($page - 1) * REGISTRO_PAGINA;
      $sql .= " LIMIT ".$page.",".REGISTRO_PAGINA; 
    }
    $rs = $GLOBALS['db']->auto_array($sql,array(),true);
    return $rs; 
  }

  public static function filtrarAspirantesGlobal($id_pais_empresa,&$filtros,$page,$obtCantdRegistros=false){

    $sql = "SELECT ";

    if($obtCantdRegistros == false){
      $sql .= "u.id_usuario, ul.username, u.nombres, u.apellidos, u.fecha_nacimiento,u.fecha_creacion, YEAR(now()) - YEAR(u.fecha_nacimiento) AS edad, e.descripcion AS estudios, u.id_nacionalidad AS id_pais, pr.nombre AS ubicacion, pr.id_provincia"; 
    }else{
      $sql .= "u.id_nacionalidad AS id_pais, pr.id_provincia, pr.nombre AS ubicacion";
    }

    $sql .= " FROM mfo_usuario u, mfo_escolaridad e, mfo_provincia pr, mfo_ciudad c, mfo_usuario_login ul";

    if(!empty($filtros['A']) && $filtros['A'] != 0){
      $sql .= ",  mfo_usuarioxarea ua ";
    }

    if(!empty($filtros['P']) && $filtros['P'] != 0){
      $sql .= ", mfo_usuario_plan up, mfo_plan pl ";
    }

    $sql .= " WHERE ul.id_usuario_login = u.id_usuario_login
            AND c.id_provincia = pr.id_provincia
            AND u.id_ciudad = c.id_ciudad
            AND e.id_escolaridad = u.id_escolaridad
            AND ul.tipo_usuario = 1
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
        $sql .= " AND u.genero = '".$g."'";
      }
    }

    //obtiene los aspirantes por nacionalidad
    if(!empty($filtros['N']) && $filtros['N'] != 0){
      $sql .= " AND u.id_nacionalidad = ".$filtros['N'];
    }

    //obtiene los aspirantes por escolaridad
    if(!empty($filtros['E']) && $filtros['E'] != 0){ 
      $sql .= " AND u.id_escolaridad = ".$filtros['E'];
    }

    //filtra los candidatos por ciertos requisitos
    if(!empty($filtros['D']) && $filtros['D'] != 0){ 
      if($filtros['D'] == 2){
        $req = 0;
      }else{
        $req = 1;
      }
      $sql .= " AND u.discapacidad = ".$req;
    }

    if(!empty($filtros['T']) && $filtros['T'] != 0){ 
      if($filtros['T'] == 2){
        $req = 0;
      }else{
        $req = 1;
      }
      $sql .= " AND u.tiene_trabajo = ".$req;
    }

    if(!empty($filtros['L']) && $filtros['L'] != 0){ 
      if($filtros['L'] == 2){
        $req = 0;
      }else{
        $req = 1;
      }
      $sql .= " AND u.licencia = ".$req;
    }

    if(!empty($filtros['V']) && $filtros['V'] != 0){ 
      if($filtros['V'] == 2){
        $req = 0;
      }else{
        $req = 1;
      }
      $sql .= " AND u.viajar = ".$req;
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

      $sql .= " AND (u.nombres LIKE '%".htmlentities($pclave,ENT_QUOTES,'UTF-8')."%' OR u.apellidos LIKE '%".htmlentities($pclave,ENT_QUOTES,'UTF-8')."%' OR (YEAR(now()) - YEAR(u.fecha_nacimiento)) = '".$pclave."' OR u.fecha_creacion LIKE '%".$pclave."%')";
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
    }
    $rs = $GLOBALS['db']->auto_array($sql,array(),true);
    return $rs;
  }
  public static function busquedaPorId($id,$tipo=self::CANDIDATO){
    if (empty($id)){ return false; }
    if ($tipo == self::CANDIDATO){
      $sql = "SELECT u.id_usuario, u.nombres, l.correo, l.tipo_usuario, p.id_pais, u.apellidos 
              FROM mfo_usuario u 
              INNER JOIN mfo_ciudad c ON c.id_ciudad = u.id_ciudad
              INNER JOIN mfo_provincia p ON p.id_provincia = c.id_provincia
              INNER JOIN mfo_usuario_login l ON l.id_usuario_login = u.id_usuario_login
              WHERE u.id_usuario = ?";
    }
    else{
      $sql = "SELECT e.id_empresa AS id_usuario, e.nombres, l.correo, l.tipo_usuario, p.id_pais, e.padre
              FROM mfo_empresa e 
              INNER JOIN mfo_ciudad c ON c.id_ciudad = e.id_ciudad
              INNER JOIN mfo_provincia p ON p.id_provincia = c.id_provincia
              INNER JOIN mfo_usuario_login l ON l.id_usuario_login = e.id_usuario_login
              WHERE e.id_empresa = ?";
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
      elseif (isset($planes) && Modelo_PermisoPlan::tienePermiso($planes, 'autopostulacion') && $controlador == 'login') {                
        Utils::doRedirect(PUERTO.'://'.HOST.'/postulacion/');  
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
    IFNULL(muni.nombre, mu.nombre_univ) as universidad,
    GROUP_CONCAT(DISTINCT nii.id_nivelIdioma_idioma) AS idiomas,
    GROUP_CONCAT(DISTINCT ai.id_area) AS areas,
    GROUP_CONCAT(DISTINCT nin.id_nivelInteres) AS nivel
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
  LEFT JOIN mfo_usuarioxarea ai ON mu.id_usuario = ai.id_usuario
    LEFT JOIN mfo_usuarioxnivel nin ON ai.id_usuario = nin.id_usuario
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
    $sql = "SELECT u.id_usuario, u.nombres, u.apellidos, u.viajar, p.id_pais, l.correo, 
                   p.id_provincia, u.id_ciudad, u.residencia
            FROM mfo_usuario u
            INNER JOIN mfo_ciudad c ON c.id_ciudad = u.id_ciudad
            INNER JOIN mfo_provincia p ON p.id_provincia = c.id_provincia
            INNER JOIN mfo_usuario_login l ON l.id_usuario_login = u.id_usuario_login
            WHERE u.estado = 1 
            ORDER BY u.id_usuario";
    return $GLOBALS['db']->Query($sql,array());
  }

  public static function obtieneNivel($idpadre){
    if (empty($idpadre)) { return false; }
    $nivel = 0;
    do{
      $sql = "SELECT id_empresa,padre FROM mfo_empresa where id_empresa = ?";
      $padre = $GLOBALS['db']->auto_array($sql,array($idpadre));
      $nivel++;
      $idpadre = $padre["padre"];
    }
    while(!empty($padre["padre"]));    
    return $nivel;
  }
  public static function obtieneHerenciaEmpresa($idpadre){

    if (empty($idpadre)) { return false; }

    $strpadre = '';
    $sql = "SELECT e.id_empresa, e.padre FROM mfo_empresa e
            WHERE e.padre IN(?) AND e.id_empresa IN (SELECT id_empresa FROM mfo_empresa_plan WHERE id_empresa = e.id_empresa AND estado = 1)";
    $padre = $GLOBALS['db']->auto_array($sql,array($idpadre),true);
    if (!empty($padre) && is_array($padre)){
      $numreg = count($padre);
      foreach($padre as $key=>$registro){
        $strpadre .= $registro["id_empresa"].(($key+1 < $numreg) ? ',' : '');
      }
    }      
    return $idpadre = $strpadre;    
  }

  #OBTIENE LAS EMPRESAS HIJAS Y SUS PLANES
  public static function obtieneSubempresasYplanes($padre,$page,$subempresa=false,$obtCantdRegistros=false){

    if (empty($padre)) { return false; }

     $sql = "SELECT ";
    if($obtCantdRegistros == false){
      $sql .= "e.nombres, e.id_empresa,GROUP_CONCAT(ep.id_empresa_plan) AS ids_empresasPlans,GROUP_CONCAT(ep.id_plan) AS ids_Planes,GROUP_CONCAT(ep.fecha_caducidad) AS fechas_caducidades, GROUP_CONCAT(pl.nombre) AS planes, GROUP_CONCAT(IF(ep.num_publicaciones_rest = -1,'Ilimitado',ep.num_publicaciones_rest)) AS num_publicaciones_rest, GROUP_CONCAT(IF(ep.num_descarga_rest = -1,'Ilimitado',ep.num_descarga_rest)) AS num_descarga_rest,GROUP_CONCAT(IF(ep.estado = 1,'Activo','Inactivo')) AS estado";
    }else{
      $sql .= "*";
    }

    $sql .= " FROM mfo_empresa e 
      INNER JOIN mfo_empresa_plan ep ON ep.id_empresa = e.id_empresa
      INNER JOIN mfo_plan pl ON pl.id_plan = ep.id_plan
      WHERE e.padre = ? AND ep.id_empresa_plan_parent IS NOT NULL AND pl.num_cuenta > 0";

    $page = ($page - 1) * REGISTRO_PAGINA;
    if($subempresa != false){
      $sql .= " AND e.id_empresa = $subempresa";
    }

    if($obtCantdRegistros == false){
      $sql .= " GROUP BY e.id_empresa LIMIT ".$page.",".REGISTRO_PAGINA;
    } 
    else{
      $sql .= " GROUP BY e.id_empresa";
    }

    return $GLOBALS['db']->auto_array($sql,array($padre),true);
  }

}  
?>
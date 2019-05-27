<?php
/*Modelo que servira para la tabla de candidatos(usuario) y para la tabla de empresas*/
class Modelo_Usuario{
  const CANDIDATO = 1;
  const EMPRESA = 2;
  const TEST_PARCIAL = 1;
  const TEST_COMPLETO = 2;
  const PRIMER_TEST = 1;
  const SEGUNDO_TEST = 2;
  const COMPLETO_TEST = 5;
  const PRE_REG = 1; 
  const REDSOCIAL_REG = 3; 
  const NORMAL_REG = 2; 
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
    $sql = "SELECT id_usuario_login, tipo_usuario, username, correo, dni, tipo_registro
            FROM mfo_usuario_login 
            WHERE (username = ? OR correo = ?) AND password = ?";
    $rs = $GLOBALS['db']->auto_array($sql,array($username,$username,$password));     
    if (empty($rs)){ return false; }
    if ($rs["tipo_usuario"] == self::CANDIDATO){
      $sql = "SELECT u.id_usuario, u.telefono, u.nombres, u.apellidos, u.fecha_nacimiento, u.fecha_creacion, 
                     u.foto, u.id_ciudad, u.ultima_sesion, u.id_nacionalidad, u.tipo_doc, 
                     u.id_situacionlaboral, u.viajar, u.id_tipolicencia, u.discapacidad, u.residencia,        
                     u.id_escolaridad, u.id_genero, u.id_univ, u.nombre_univ, p.id_pais, u.estado, u.tlf_convencional, u.pendiente_test, u.id_estadocivil
              FROM mfo_usuario u
              INNER JOIN mfo_ciudad c ON c.id_ciudad = u.id_ciudad
              INNER JOIN mfo_provincia p ON p.id_provincia = c.id_provincia
              WHERE u.id_usuario_login = ?";
    }
    else{
      $sql = "SELECT e.id_empresa AS id_usuario, e.telefono, e.nombres, e.fecha_creacion,
                     e.foto, e.id_ciudad, e.ultima_sesion, e.id_nacionalidad, e.padre, t.nombres AS nombres_contacto,
                     t.apellidos AS apellidos_contacto, t.telefono1, t.telefono2, p.id_pais, e.estado, e.id_sectorindustrial, e.nro_trabajadores, e.pagina_web, t.id_cargo
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
  //Búsqueda del username en la BD
  public static function existeUsuario($username){
    if(empty($username)){ return false; }
    $sql = "SELECT IFNULL(u.id_usuario,e.id_empresa) AS id_usuario, IFNULL(u.nombres,e.nombres) AS nombres, 
                   u.apellidos, l.username, l.correo, u.telefono, l.dni, l.tipo_usuario, u.grafico
            FROM mfo_usuario_login l
            LEFT JOIN mfo_usuario u ON u.id_usuario_login = l.id_usuario_login
            LEFT JOIN mfo_empresa e ON e.id_usuario_login = l.id_usuario_login
            WHERE l.username = ?";
    $rs = $GLOBALS['db']->auto_array($sql,array($username));
    return (!empty($rs['id_usuario'])) ? $rs : false;
  }
  public static function informacionPerfilUsuario($idUsuario){
    $sql = "SELECT 
    u.telefono,
    DATE_FORMAT(u.fecha_nacimiento, '%Y-%m-%d') AS fecha_nacimiento,
    YEAR(NOW()) - YEAR(u.fecha_nacimiento) AS edad,
    u.tipo_doc,
    IF(u.viajar = '0' , 'NO', 'SI') as viajar,
    IF(u.residencia = '0' , 'NO', 'SI') as residencia,
    IF(u.discapacidad = '0' , 'NO', 'SI') as discapacidad,
    IF(u.tlf_convencional != '', u.tlf_convencional, '-') as telefonoConvencional,
    g.descripcion AS genero,
    e.descripcion AS escolaridad,
    sl.descripcion AS situacionLaboral,
    c.nombre AS ciudad,
    pais.nombre_abr AS pais,
    pr.nombre AS provincia,
    mpais.nombre_abr AS nacionalidad,
    ifnull(tl.descripcion, '-') AS licencia,
    if(nombre_univ != '', 'SI', 'NO') as extranjero,
    if (u.id_univ, uni.nombre, if(nombre_univ, nombre_univ, '-')) as universidad,
    ifnull(es.descripcion, '-') as estadocivil
FROM
    mfo_usuario u
    LEFT JOIN
    mfo_tipolicencia tl ON tl.id_tipolicencia = u.id_tipolicencia
  LEFT JOIN mfo_universidades uni ON uni.id_univ = u.id_univ,
    mfo_genero g,
    mfo_escolaridad e,
    mfo_situacionlaboral sl,
    mfo_ciudad c,
    mfo_provincia pr,
    mfo_pais pais,
    mfo_pais mpais,
    mfo_estadocivil es
        
WHERE
    g.id_genero = u.id_genero
        AND e.id_escolaridad = u.id_escolaridad
        AND sl.id_situacionlaboral = u.id_situacionlaboral
        AND pais.id_pais = pr.id_pais
        AND pr.id_provincia = c.id_provincia
        AND u.id_nacionalidad = mpais.id_pais
        AND c.id_ciudad = u.id_ciudad
        AND es.id_estadocivil = u.id_estadocivil
        AND u.id_usuario = ?;";
    return $GLOBALS['db']->auto_array($sql,array($idUsuario));
  }
  public static function existeUsername($username){
    if(empty($username)){return false;}
    $sql = "SELECT * FROM mfo_usuario_login WHERE username = ?;";
    $rs = $GLOBALS['db']->auto_array($sql,array($username), true);
    return $rs;
  } 
  // se utiliza esta funcion en el registro modal--------------------
  public static function existeCorreo($correo){
    if(empty($correo)){ return false; }
    $sql = "SELECT * FROM mfo_usuario_login WHERE correo = ?";
    $rs = $GLOBALS['db']->auto_array($sql,array($correo));
    return (empty($rs['correo'])) ? false : $rs['id_usuario_login'];
  }
  // se utiliza esta funcion en el registro modal--------------------
  public static function existeDni($dni,$idUsuarioLogin=false){
    if(empty($dni)){ return false; }
    $sql = "SELECT * FROM mfo_usuario_login WHERE dni = ?";
    if($idUsuarioLogin != false){
      $sql .= " AND id_usuario_login <> ".$idUsuarioLogin;
    }
    $rs = $GLOBALS['db']->auto_array($sql,array($dni));
    return (empty($rs['dni'])) ? false : $rs['id_usuario_login'];
  }
  public static function crearUsuario($dato_registro){       
    if(empty($dato_registro)){return false;}
    if ($dato_registro['tipo_usuario'] == 1) {
      $result = $GLOBALS['db']->insert('mfo_usuario',array('telefono'=>$dato_registro['telefono'], 
                'nombres'=>$dato_registro['nombres'], 
                'apellidos'=>$dato_registro['apellidos'], 
                'fecha_nacimiento'=>$dato_registro['fecha_nacimiento'], 
                'fecha_creacion'=>$dato_registro['fecha_creacion'], 
                'estado'=>$dato_registro['estado'], 
                'term_cond'=>$dato_registro['term_cond'], 
                'id_ciudad'=>$dato_registro['id_ciudad'], 
                'id_nacionalidad'=>$dato_registro['id_nacionalidad'], 
                'tipo_doc'=>$dato_registro['tipo_doc'], 
                'id_escolaridad'=>$dato_registro['id_escolaridad'], 
                'id_genero'=>$dato_registro['genero'],
                'id_estadocivil'=>$dato_registro['id_estadocivil'],
                'id_situacionlaboral'=>$dato_registro['id_situacionlaboral'],
                'id_usuario_login'=>$dato_registro['id_usuario_login']));
    }
    else{
      $arreglo_datos = array('telefono'=>$dato_registro['telefono'], 'nombres'=>$dato_registro['nombres'],'nro_trabajadores'=>$dato_registro['nro_trabajadores'], 'fecha_creacion'=>$dato_registro['fecha_creacion'], 'term_cond'=>$dato_registro['term_cond'], 'id_ciudad'=>$dato_registro['id_ciudad'], 'id_nacionalidad'=>$dato_registro['id_nacionalidad'], 'id_usuario_login'=>$dato_registro['id_usuario_login'],'estado'=>$dato_registro['estado'], 'id_sectorindustrial'=>$dato_registro['id_sectorindustrial']);
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
      $sql = "SELECT u.id_usuario, u.telefono, u.nombres, u.apellidos, u.fecha_nacimiento, u.fecha_creacion, u.foto, u.id_ciudad, u.ultima_sesion, u.id_nacionalidad, u.tipo_doc, u.viajar, u.discapacidad, u.residencia, u.id_escolaridad, u.id_univ, u.nombre_univ, p.id_pais, ul.id_usuario_login, 
        ul.correo, ul.dni, ul.username, ul.tipo_usuario, u.tlf_convencional,u.id_genero,u.id_estadocivil,u.id_tipolicencia, u.id_situacionlaboral
        FROM mfo_usuario u
        INNER JOIN mfo_usuario_login ul ON ul.id_usuario_login = u.id_usuario_login
        INNER JOIN mfo_ciudad c ON c.id_ciudad = u.id_ciudad
        INNER JOIN mfo_provincia p ON p.id_provincia = c.id_provincia
        WHERE u.id_usuario = ? AND u.estado = 1";
    }
    else{
      $sql = "SELECT e.id_empresa AS id_usuario, e.telefono, e.nombres, e.fecha_creacion,
                      e.foto, e.id_ciudad, e.ultima_sesion, e.id_nacionalidad, e.padre, t.nombres AS nombres_contacto,
                     t.apellidos AS apellidos_contacto, t.telefono1, t.telefono2, ul.id_usuario_login, ul.correo, 
                     ul.dni, ul.username, ul.tipo_usuario,p.id_pais, e.id_sectorindustrial, e.nro_trabajadores, e.pagina_web, t.id_cargo
              FROM mfo_empresa e
              INNER JOIN mfo_usuario_login ul ON ul.id_usuario_login = e.id_usuario_login
              INNER JOIN mfo_ciudad c ON c.id_ciudad = e.id_ciudad
              INNER JOIN mfo_provincia p ON p.id_provincia = c.id_provincia
              INNER JOIN mfo_contactoempresa t ON t.id_empresa = e.id_empresa
              WHERE e.id_empresa = ? AND e.estado = 1";
    }
    //echo $sql;
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
      $licencia = $data['licencia'];
      if($licencia == 0){
        $licencia = "null";
      }
      $datos = array("foto"=>$foto,"nombres"=>$data['nombres'],"telefono"=>$data['telefono'],"id_ciudad"=>$data['ciudad'],"fecha_nacimiento"=>$data['fecha_nacimiento'],"id_nacionalidad"=>$data['id_nacionalidad'],"apellidos"=>$data['apellidos'],"id_genero"=>$data['genero'],"discapacidad"=>$data['discapacidad'],"id_escolaridad"=>$data['escolaridad'],"id_tipolicencia"=>$licencia,"id_estadocivil"=>$data['estado_civil'],"viajar"=>$data['viajar'],"id_situacionlaboral"=>$data['tiene_trabajo'],"tlf_convencional"=>$data['convencional'],"residencia"=>$data['residencia']); 
      if (!empty($data['documentacion'])){          
        $datos['tipo_doc'] = $data['documentacion'];
      }
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
      $datos = array("foto"=>$foto,"nombres"=>$data['nombres'],"telefono"=>$data['telefono'],"id_ciudad"=>$data['ciudad'],"id_nacionalidad"=>$data['id_nacionalidad'],"id_sectorindustrial"=>$data['sectorind'],"nro_trabajadores"=>$data['nro_trabajadores'],"pagina_web" => $_POST['pagina_web']);

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
  public static function obtenerAspirantes($idOferta,$page,$limite,$cantd_faceta,$obtCantdRegistros=false){
    
    $subquery1 = "(SELECT o.id_ofertas, u.id_usuario,ul.username,u.nombres,u.apellidos,u.id_genero,p.fecha_postulado,
    u.fecha_nacimiento,YEAR(NOW()) - YEAR(u.fecha_nacimiento) AS edad, p.asp_salarial,u.discapacidad,u.viajar,u.id_situacionlaboral,u.id_tipolicencia,
    u.id_escolaridad, u.id_nacionalidad,u.id_ciudad,IF(SUM(pl.costo) > 0 && up.estado = 1,1,0) AS pago 
    FROM
      mfo_usuario u, mfo_usuario_login ul,mfo_postulacion p, 
      mfo_oferta o,mfo_usuario_plan up,mfo_plan pl 
    WHERE
      u.id_usuario = p.id_usuario AND up.id_usuario = u.id_usuario AND up.id_plan = pl.id_plan
        AND u.id_usuario_login = ul.id_usuario_login AND p.id_ofertas = o.id_ofertas AND o.id_ofertas = $idOferta GROUP BY u.id_usuario";
    
    $subquery1 .= " ORDER BY pago DESC, p.fecha_postulado ASC";
    
    if($obtCantdRegistros === false && !empty($limite)){  
      $subquery1 .= " LIMIT 0,".$limite; 
    }
    $subquery1 .= ") t2"; 
    $subquery2 = '(SELECT id_usuario,IF(SUM(estado) = '.$cantd_faceta.',2,1) AS test_realizados, COUNT(1) AS numero_test FROM mfo_porcentajexfaceta pt GROUP BY id_usuario) t1';
    $sql = "SELECT ";
    if($obtCantdRegistros == false){
      $sql .= "t2.id_ofertas, t2.id_usuario,t2.username,t2.nombres,t2.apellidos,t2.id_genero,t2.fecha_postulado, t2.fecha_nacimiento, t2.edad, t2.asp_salarial, e.descripcion AS estudios,t2.discapacidad,t2.id_situacionlaboral,t2.id_tipolicencia,n.nombre_abr AS nacionalidad, n.id_pais, pro.id_provincia, pro.nombre AS ubicacion,t2.pago, t1.test_realizados, t1.numero_test"; 
    }else{
      $sql .= "n.id_pais, pro.id_provincia, pro.nombre AS ubicacion, t2.pago, t1.test_realizados, t1.numero_test";
    }
    
    $sql .= " FROM mfo_escolaridad e, mfo_pais n, mfo_provincia pro, mfo_ciudad c, ";
    $sql .= $subquery1.', '.$subquery2;
    $sql .= " WHERE e.id_escolaridad = t2.id_escolaridad
          AND n.id_pais = t2.id_nacionalidad
          AND c.id_provincia = pro.id_provincia
          AND c.id_ciudad = t2.id_ciudad
          AND t1.id_usuario = t2.id_usuario";   
    if($obtCantdRegistros === false){
      $page = ($page - 1) * REGISTRO_PAGINA;
      $sql .= " LIMIT ".$page.",".REGISTRO_PAGINA;
    }
    //echo $sql;
    $rs = $GLOBALS['db']->auto_array($sql,array(),true);
    return $rs; 
  }
  public static function filtrarAspirantes($idOferta,&$filtros,$page,$facetas,$limite,$obtCantdRegistros=false){
    //print_r($filtros['R']);

    $subquery1 = "(SELECT o.id_ofertas, u.id_usuario,ul.username,u.nombres,u.apellidos,u.id_genero,p.fecha_postulado,u.id_situacionlaboral,u.id_tipolicencia, u.viajar, u.fecha_nacimiento,YEAR(NOW()) - YEAR(u.fecha_nacimiento) AS edad, p.asp_salarial,u.discapacidad,
    u.id_escolaridad, u.id_nacionalidad,u.id_ciudad,IF(SUM(pl.costo) > 0 && up.estado = 1,1,0) AS pago 
    FROM
      mfo_usuario u, mfo_usuario_login ul,mfo_postulacion p, 
      mfo_oferta o,mfo_usuario_plan up,mfo_plan pl 
    WHERE
      u.id_usuario = p.id_usuario AND up.id_usuario = u.id_usuario AND up.id_plan = pl.id_plan
        AND u.id_usuario_login = ul.id_usuario_login AND p.id_ofertas = o.id_ofertas AND o.id_ofertas = $idOferta GROUP BY u.id_usuario";
    
    $subquery1 .= " ORDER BY pago DESC, p.fecha_postulado ASC";
    if($obtCantdRegistros === false && !empty($limite)){
      $subquery1 .= " LIMIT 0,".$limite; 
    }
   // echo $subquery1;
    $subquery1 .= ") t2";
    $subquery2 = '(SELECT id_usuario,IF(SUM(estado) = '.count($facetas).',2,1) AS test_realizados, COUNT(1) AS numero_test FROM mfo_porcentajexfaceta pt GROUP BY id_usuario) t1';
    $sql = "SELECT ";
    if($obtCantdRegistros == false){
      $sql .= "t2.id_ofertas, t2.id_usuario,t2.username,t2.nombres,t2.apellidos,t2.id_genero,t2.fecha_postulado, t2.fecha_nacimiento, t2.edad, t2.asp_salarial, e.descripcion AS estudios,t2.discapacidad,t2.id_situacionlaboral,t2.id_tipolicencia,n.nombre_abr AS nacionalidad, n.id_pais, pro.id_provincia, pro.nombre AS ubicacion,t2.pago, t1.test_realizados, t1.numero_test"; 
    }else{
      $sql .= "n.id_pais, pro.id_provincia, pro.nombre AS ubicacion, t2.pago, t1.test_realizados, t1.numero_test";
    }
    if(!empty($filtros['R']) && $filtros['R'] != ''){
      $sql .= ", IF(t1.test_realizados = 2,(".VALORES_ORDENAMIENTO[0]."*t.total)+".VALORES_ORDENAMIENTO[1].",t.total) AS ranqueo"; 
    }
    
    $sql .= " FROM mfo_escolaridad e, mfo_pais n, mfo_provincia pro, mfo_ciudad c, ";
    $sql .= $subquery1.', '.$subquery2;
    if(!empty($filtros['R']) && $filtros['R'] != ''){
      $facetas_porcentajes = array();
      $facetas_pesos = array();
      $exp = '/';
      
      foreach ($facetas as $clave => $c) {
        $letra = $c['literal'];//substr($c,0,1);
        if($letra == 'A' && $a > 1){
          $letra = 'P';
        }
        $pos = strstr($filtros['R'], $letra);
        if($pos !== false){
          $exp .= '('.$letra.'[0-9]{1,3})';
          $literales[$letra] = $clave;
        }
        $a++;
      }
      $exp .= '/';
      preg_match_all($exp,$filtros['R'],$salida, PREG_PATTERN_ORDER);
      unset($salida[0]);
      $existe_otro = array();
      foreach ($salida as $key => $value) {
        $l = substr($value[0],0,1);
        $i = substr($value[0],1);
        $facetas_porcentajes[$literales[$l]] = $i;
      }
      $valores_unicos = array_unique($facetas_porcentajes);
      arsort($valores_unicos);
      $peso = count($facetas);
      $orden_canea = array();
      foreach ($valores_unicos as $k => $valor) {
        $orden_canea[$valor] = array();
      }
      foreach ($facetas_porcentajes as $key => $value) {
        array_push($orden_canea[$value], $key);
      }
      
      $if = $parentesis = '';
      $posicionamiento_valores = '';
      foreach ($orden_canea as $pos => $ids_facetas) {
        foreach ($ids_facetas as $c => $id) {
          $if .= 'IF(id_faceta = '.$id.', valor*'.$peso.',';
          $peso--;
          $parentesis .= ')';
        }
      }
      
      $if .= 'valor'.$parentesis.' AS f1'; 
      $subquery3 = ", (SELECT SUM(ROUND(res.f1)) AS total, res.id_usuario 
                FROM (SELECT id_usuario, ".$if."  FROM mfo_porcentajexfaceta WHERE id_faceta IN(".implode(',',$literales).")) res 
                GROUP BY res.id_usuario) t";
      $sql .= $subquery3;
    }
    if(!empty($filtros['A']) && $filtros['A'] != 0){
      $sql .= ",  mfo_usuarioxarea ua ";
    }
    $sql .= " WHERE e.id_escolaridad = t2.id_escolaridad
              AND n.id_pais = t2.id_nacionalidad
              AND c.id_provincia = pro.id_provincia
              AND c.id_ciudad = t2.id_ciudad
              AND t1.id_usuario = t2.id_usuario";
    if(!empty($filtros['R']) && $filtros['R'] != ''){
      $sql .= " AND t.id_usuario = t2.id_usuario";
    }
    if(!empty($filtros['P']) && $filtros['P'] != 0){
      $sql .= " AND t1.test_realizados = ".$filtros['P'];
    } 
    if(!empty($filtros['A']) && $filtros['A'] != 0){
      $sql .= " AND ua.id_usuario = t2.id_usuario AND ua.id_areas_subareas IN(SELECT asu.id_areas_subareas FROM mfo_area_subareas asu WHERE asu.id_area = ".$filtros['A'].")";
    }
    if(!empty($filtros['F']) && $filtros['F'] != 0){
       if($filtros['F'] == 1){
        $sql .= " AND DATE_FORMAT(t2.fecha_postulado, '%Y-%m-%d') = DATE_FORMAT(NOW(), '%Y-%m-%d')";
       }
       
       if($filtros['F'] == 2){
        $sql .= " AND DATE_FORMAT(p.fecha_postulado, '%Y-%m-%d') BETWEEN DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 3 DAY), '%Y-%m-%d') AND DATE_FORMAT(NOW(), '%Y-%m-%d')";
       }
       
       if($filtros['F'] == 3){
         $sql .= " AND DATE_FORMAT(t2.fecha_postulado, '%Y-%m-%d') BETWEEN DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 WEEK), '%Y-%m-%d') AND DATE_FORMAT(NOW(), '%Y-%m-%d')";
       }
       if($filtros['F'] == 4){
        $sql .= " AND DATE_FORMAT(t2.fecha_postulado, '%Y-%m-%d') BETWEEN DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 MONTH), '%Y-%m-%d') AND DATE_FORMAT(NOW(), '%Y-%m-%d')";
       }
    }
    if(!empty($filtros['C']) && $filtros['C'] != 0){
       if($filtros['C'] == 1){
        $sql .= " AND t2.edad BETWEEN '18' and '25'";
      }
      if($filtros['C'] == 2){
        $sql .= " AND t2.edad BETWEEN '25' and '35'";
      }
      if($filtros['C'] == 3){
        $sql .= " AND t2.edad BETWEEN '35' AND '45'";
      }
      if($filtros['C'] == 4){
        $sql .= " AND t2.edad >= 45";
      }
    }
    //obtiene los aspirantes para esa ubicacion 
    if(!empty($filtros['U']) && $filtros['U'] != 0){ 
      $sql .= " AND pro.id_provincia = ".$filtros['U'];
    }
    //calcular que el salario este en el rango especificado
    if(!empty($filtros['S']) && $filtros['S'] != 0){
      if($filtros['S'] == 1){
        $sql .= " AND t2.asp_salarial < 341";
      }
      if($filtros['S'] == 2){
        $sql .= " AND t2.asp_salarial BETWEEN '386' and '700'";
      }
      if($filtros['S'] == 3){
        $sql .= " AND t2.asp_salarial BETWEEN '700' AND '1200'";
      }
      if($filtros['S'] == 4){
        $sql .= " AND t2.asp_salarial >= 1200";
      }
    }
    //obtiene los aspirantes por genero
    if(!empty($filtros['G']) && $filtros['G'] != 0){      
        $sql .= " AND t2.id_genero = ".$filtros['G'];      
    }
    //obtiene los aspirantes por nacionalidad
    if(!empty($filtros['N']) && $filtros['N'] != 0){
      $sql .= " AND t2.id_nacionalidad = ".$filtros['N'];
    }
    //obtiene los aspirantes por escolaridad
    if(!empty($filtros['E']) && $filtros['E'] != 0){ 
      $sql .= " AND t2.id_escolaridad = ".$filtros['E'];
    }
    //filtra los candidatos por ciertos requisitos
    if(!empty($filtros['D']) && $filtros['D'] != 0){ 
      if($filtros['D'] == 2){
        $req = 0;
      }else{
        $req = 1;
      }
      $sql .= " AND t2.discapacidad = ".$req;
    }
    if(!empty($filtros['T']) && $filtros['T'] != 0){ 
      $sql .= " AND t2.id_situacionlaboral = ".$filtros['T'];
    }
    if($filtros['L'] != -1 && $filtros['L'] >= 0){ 
      if($filtros['L'] == 0){
        $sql .= " AND t2.id_tipolicencia IS NULL"; 
      }else{
        $sql .= " AND t2.id_tipolicencia = ".$filtros['L'];
      }
    }
    if(!empty($filtros['V']) && $filtros['V'] != 0){ 
      if($filtros['V'] == 2){
        $req = 0;
      }else{
        $req = 1;
      }
      $sql .= " AND t2.viajar = ".$req;
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
      $sql .= " AND (t2.nombres LIKE '%".htmlentities($pclave,ENT_QUOTES,'UTF-8')."%' OR t2.apellidos LIKE '%".htmlentities($pclave,ENT_QUOTES,'UTF-8')."%' OR t2.asp_salarial LIKE '%".$pclave."%' OR t2.fecha_postulado LIKE '%".$pclave."%')";
    }

    $sql .= ' GROUP BY t2.id_usuario';

    if($obtCantdRegistros === false){
      if(!empty($filtros['O']) && $filtros['O'] != 0 && strlen($filtros['O'])>1){
        $tipo = substr($filtros['O'],0,1);
        $t = substr($filtros['O'],1,2);
        if($tipo == 1){
          if($t == 1){
            $filtros['O'] = 2;
            $sql .= " ORDER BY t2.edad ASC";
          }
          if($t == 2){
            $filtros['O'] = 1;
            $sql .= " ORDER BY t2.edad DESC";
          }        
        }else if($tipo == 2){
          if($t == 1){
            $filtros['O'] = 2;
            $sql .= " ORDER BY t2.fecha_postulado ASC";
          }
          if($t == 2){
            $filtros['O'] = 1;
            $sql .= " ORDER BY t2.fecha_postulado DESC";
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
            $sql .= " ORDER BY t2.asp_salarial ASC";
          }
          if($t == 2){
            $filtros['O'] = 1;
            $sql .= " ORDER BY t2.asp_salarial DESC";
          }
        }
      }else{
        if(!empty($filtros['R']) && $filtros['R'] != ''){
          $sql .= " ORDER BY ranqueo DESC";
        }else{
          $sql .= " ORDER BY t2.pago DESC, t2.fecha_postulado ASC";
        }
      }
      $page = ($page - 1) * REGISTRO_PAGINA;
      $sql .= " LIMIT ".$page.",".REGISTRO_PAGINA;
    }
    //echo 'SQL1: '.$sql;
    $rs = $GLOBALS['db']->auto_array($sql,array(),true);
    return $rs;
  }
  public static function busquedaGlobalAspirantes($id_pais_empresa,$cantd_faceta,$page,$obtCantdRegistros=false){     
    $sql = "SELECT ";
    $subquery1 = "(SELECT o.id_ofertas, u.id_usuario,ul.username,u.nombres,u.apellidos,u.id_genero,u.fecha_creacion,
    u.fecha_nacimiento,YEAR(NOW()) - YEAR(u.fecha_nacimiento) AS edad,u.discapacidad,u.viajar,u.id_situacionlaboral,u.id_tipolicencia,
    u.id_escolaridad, u.id_nacionalidad,u.id_ciudad,IF(SUM(pl.costo) > 0 && up.estado = 1,1,0) AS pago 
    FROM
      mfo_usuario u, mfo_usuario_login ul,  
      mfo_oferta o,mfo_usuario_plan up,mfo_plan pl 
    WHERE
      up.id_usuario = u.id_usuario AND up.id_plan = pl.id_plan
        AND u.id_usuario_login = ul.id_usuario_login AND ul.tipo_usuario = 1 GROUP BY u.id_usuario";
    
    $subquery1 .= " ORDER BY pago DESC, u.fecha_creacion ASC";
    $subquery1 .= ") t2"; 
    $subquery2 = '(SELECT id_usuario,IF(SUM(estado) = '.$cantd_faceta.',2,1) AS test_realizados FROM mfo_porcentajexfaceta pt GROUP BY id_usuario) t1';
    if($obtCantdRegistros == false){
      $sql .= "t2.id_usuario,t2.username,t2.nombres,t2.apellidos,t2.id_genero,t2.fecha_creacion, t2.fecha_nacimiento, t2.edad, t2.id_nacionalidad AS id_pais,e.descripcion AS estudios,t2.discapacidad,n.nombre_abr AS nacionalidad, n.id_pais, pro.id_provincia, pro.nombre AS ubicacion,t2.pago,t1.test_realizados"; 
    }else{
      $sql .= "t2.id_nacionalidad AS id_pais, pro.id_provincia, pro.nombre AS ubicacion, t2.pago, t1.test_realizados";
    }
    $sql .= " FROM mfo_escolaridad e, mfo_pais n, mfo_provincia pro, mfo_ciudad c, ";
    $sql .= $subquery1.', '.$subquery2;
    $sql .= " WHERE e.id_escolaridad = t2.id_escolaridad
          AND n.id_pais = t2.id_nacionalidad
          AND c.id_provincia = pro.id_provincia
          AND c.id_ciudad = t2.id_ciudad
          AND t1.id_usuario = t2.id_usuario
          AND pro.id_pais = ".$id_pais_empresa;
    if($obtCantdRegistros === false){
      $page = ($page - 1) * REGISTRO_PAGINA;
      $sql .= " LIMIT ".$page.",".REGISTRO_PAGINA; 
    }
    //echo $sql;
    $rs = $GLOBALS['db']->auto_array($sql,array(),true);
    return $rs; 
  }
  public static function filtrarAspirantesGlobal($id_pais_empresa,&$filtros,$page,$facetas,$obtCantdRegistros=false){
    $subquery1 = "(SELECT u.id_usuario,ul.username,u.nombres,u.apellidos,u.id_genero,u.fecha_creacion, u.id_situacionlaboral,u.id_tipolicencia, u.viajar, u.fecha_nacimiento,YEAR(NOW()) - YEAR(u.fecha_nacimiento) AS edad,u.discapacidad,
    u.id_escolaridad, u.id_nacionalidad,u.id_ciudad,IF(SUM(pl.costo) > 0 && up.estado = 1,1,0) AS pago 
    FROM
      mfo_usuario u, mfo_usuario_login ul, 
      mfo_oferta o,mfo_usuario_plan up,mfo_plan pl 
    WHERE
      up.id_usuario = u.id_usuario AND up.id_plan = pl.id_plan
        AND u.id_usuario_login = ul.id_usuario_login AND ul.tipo_usuario = 1 GROUP BY u.id_usuario";
    $subquery1 .= " ORDER BY pago DESC, u.fecha_creacion ASC) t2";
    $subquery2 = '(SELECT id_usuario,IF(SUM(estado) = '.count($facetas).',2,1) AS test_realizados FROM mfo_porcentajexfaceta pt GROUP BY id_usuario) t1';
    $sql = "SELECT ";
    if($obtCantdRegistros == false){
      $sql .= "t2.id_usuario, t2.username, t2.nombres, t2.apellidos, t2.id_genero,t2.discapacidad, t2.fecha_nacimiento,t2.fecha_creacion, t2.edad, e.descripcion AS estudios, t2.id_nacionalidad AS id_pais, pr.nombre AS ubicacion, pr.id_provincia, t2.pago, t1.test_realizados";
    }else{
      $sql .= "t2.id_nacionalidad AS id_pais, pr.id_provincia, pr.nombre AS ubicacion, t2.pago, t1.test_realizados";
    }
    if(!empty($filtros['R']) && $filtros['R'] != ''){
      $sql .= ", IF(t1.test_realizados = 2,(".VALORES_ORDENAMIENTO[0]."*t.total)+".VALORES_ORDENAMIENTO[1].",t.total) AS ranqueo"; 
    } 
    $sql .= " FROM mfo_escolaridad e, mfo_provincia pr, mfo_ciudad c, ";
    $sql .= $subquery1.', '.$subquery2;
    if(!empty($filtros['R']) && $filtros['R'] != ''){
      $facetas_porcentajes = array();
      $facetas_pesos = array();
      $exp = '/';   
      foreach ($facetas as $clave => $c) {
        $letra = substr($c,0,1);
        if($letra == 'A' && $a > 1){
          $letra = 'P';
        }
        $pos = strstr($filtros['R'], $letra);
        if($pos !== false){
          $exp .= '('.$letra.'[0-9]{1,3})';
          $literales[$letra] = $clave;
        }
        $a++;
      }
      $exp .= '/';
      preg_match_all($exp,$filtros['R'],$salida, PREG_PATTERN_ORDER);
      unset($salida[0]);
      $existe_otro = array();
      foreach ($salida as $key => $value) {
        $l = substr($value[0],0,1);
        $i = substr($value[0],1);
        $facetas_porcentajes[$literales[$l]] = $i;
      }
      $valores_unicos = array_unique($facetas_porcentajes);
      arsort($valores_unicos);
      $peso = count($facetas);
      $orden_canea = array();
      foreach ($valores_unicos as $k => $valor) {
        $orden_canea[$valor] = array();
      }
      foreach ($facetas_porcentajes as $key => $value) {
        array_push($orden_canea[$value], $key);
      }
      $if = $parentesis = '';
      $posicionamiento_valores = '';
      foreach ($orden_canea as $pos => $ids_facetas) {
        foreach ($ids_facetas as $c => $id) {
          $if .= 'if(id_faceta = '.$id.', valor*'.$peso.',';
          $peso--;
          $parentesis .= ')';
        }
      }      
      $if .= 'valor'.$parentesis.' AS f1'; 
      $subquery3 = ", (SELECT SUM(ROUND(res.f1)) AS total, res.id_usuario 
                FROM (SELECT id_usuario, ".$if."  FROM mfo_porcentajexfaceta WHERE id_faceta IN(".implode(',',$literales).")) res 
                GROUP BY res.id_usuario) t";
      $sql .= $subquery3;
    }
    if(!empty($filtros['A']) && $filtros['A'] != 0){
      $sql .= ",  mfo_usuarioxarea ua ";
    }
      $sql .= " WHERE c.id_provincia = pr.id_provincia
            AND c.id_ciudad = t2.id_ciudad
            AND e.id_escolaridad = t2.id_escolaridad
            AND t1.id_usuario = t2.id_usuario";
    if(!empty($filtros['P']) && $filtros['P'] != 0){
      $sql .= " AND t1.test_realizados = ".$filtros['P'];
    }        
    $sql .= " AND pr.id_pais = ".$id_pais_empresa;
    if(!empty($filtros['R']) && $filtros['R'] != ''){
      $sql .= " AND t.id_usuario = t2.id_usuario";
    }
    //segun el escogido calcular fecha y ponersela a la consulta
    if(!empty($filtros['F']) && $filtros['F'] != 0){
       if($filtros['F'] == 1){
        $sql .= " AND DATE_FORMAT(t2.fecha_creacion, '%Y-%m-%d') = DATE_FORMAT(NOW(), '%Y-%m-%d')";
       }
       if($filtros['F'] == 2){
        $sql .= " AND DATE_FORMAT(t2.fecha_creacion, '%Y-%m-%d') BETWEEN DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 3 DAY), '%Y-%m-%d') AND DATE_FORMAT(NOW(), '%Y-%m-%d')";
       }
       if($filtros['F'] == 3){
         $sql .= " AND DATE_FORMAT(t2.fecha_creacion, '%Y-%m-%d') BETWEEN DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 WEEK), '%Y-%m-%d') AND DATE_FORMAT(NOW(), '%Y-%m-%d')";
       }
       if($filtros['F'] == 4){
        $sql .= " AND DATE_FORMAT(t2.fecha_creacion, '%Y-%m-%d') BETWEEN DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 MONTH), '%Y-%m-%d') AND DATE_FORMAT(NOW(), '%Y-%m-%d')";
       }
    }
    if(!empty($filtros['C']) && $filtros['C'] != 0){
       if($filtros['C'] == 1){
        $sql .= " AND t2.edad BETWEEN '18' and '25'";
      }
      if($filtros['C'] == 2){
        $sql .= " AND t2.edad BETWEEN '25' and '35'";
      }
      if($filtros['C'] == 3){
        $sql .= " AND t2.edad BETWEEN '35' AND '45'";
      }
      if($filtros['C'] == 4){
        $sql .= " AND t2.edad >= 45";
      }
    }
    
    if(!empty($filtros['A']) && $filtros['A'] != 0){
      $sql .= " AND ua.id_usuario = t2.id_usuario AND ua.id_areas_subareas IN(SELECT asu.id_areas_subareas FROM mfo_area_subareas asu WHERE asu.id_area = ".$filtros['A'].")";
    }
    //obtiene los aspirantes para esa ubicacion 
    if(!empty($filtros['U']) && $filtros['U'] != 0){ 
      $sql .= " AND pr.id_provincia = ".$filtros['U'];
    }
    //obtiene los aspirantes por genero
    if(!empty($filtros['G']) && $filtros['G'] != 0){      
        $sql .= " AND t2.id_genero = ".$filtros['G'];      
    }
    //obtiene los aspirantes por nacionalidad
    if(!empty($filtros['N']) && $filtros['N'] != 0){
      $sql .= " AND t2.id_nacionalidad = ".$filtros['N'];
    }
    //obtiene los aspirantes por escolaridad
    if(!empty($filtros['E']) && $filtros['E'] != 0){ 
      $sql .= " AND t2.id_escolaridad = ".$filtros['E'];
    }
    //filtra los candidatos por ciertos requisitos
    if(!empty($filtros['D']) && $filtros['D'] != 0){ 
      if($filtros['D'] == 2){
        $req = 0;
      }else{
        $req = 1;
      }
      $sql .= " AND t2.discapacidad = ".$req;
    }
    if(!empty($filtros['T']) && $filtros['T'] != 0){ 
      $sql .= " AND t2.id_situacionlaboral = ".$filtros['T'];
    }
    if($filtros['L'] != -1 && $filtros['L'] >= 0){ 
      if($filtros['L'] == 0){
        $sql .= " AND t2.id_tipolicencia IS NULL"; 
      }else{
        $sql .= " AND t2.id_tipolicencia = ".$filtros['L'];
      }
    }
    if(!empty($filtros['V']) && $filtros['V'] != 0){ 
      if($filtros['V'] == 2){
        $req = 0;
      }else{
        $req = 1;
      }
      $sql .= " AND t2.viajar = ".$req;
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
      $sql .= " AND (t2.nombres LIKE '%".htmlentities($pclave,ENT_QUOTES,'UTF-8')."%' OR t2.apellidos LIKE '%".htmlentities($pclave,ENT_QUOTES,'UTF-8')."%' OR t2.fecha_creacion LIKE '%".$pclave."%')";
    }
    if(!empty($filtros['A']) && $filtros['A'] != 0){
      $sql .= " GROUP BY t2.id_usuario";
    }
    if($obtCantdRegistros === false){
      if(!empty($filtros['O']) && $filtros['O'] != 0 && strlen($filtros['O'])>1){
        $tipo = substr($filtros['O'],0,1);
        $t = substr($filtros['O'],1,2);
        if($tipo == 1){
          if($t == 1){
            $filtros['O'] = 2;
            $sql .= " ORDER BY t2.edad ASC";
          }
          if($t == 2){
            $filtros['O'] = 1;
            $sql .= " ORDER BY t2.edad DESC";
          }        
        }else if($tipo == 2){
          if($t == 1){
            $filtros['O'] = 2;
            $sql .= " ORDER BY t2.fecha_creacion ASC";
          }
          if($t == 2){
            $filtros['O'] = 1;
            $sql .= " ORDER BY t2.fecha_creacion DESC";
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
        if(!empty($filtros['R']) && $filtros['R'] != ''){
          $sql .= " ORDER BY ranqueo DESC";
        }
      }
      $page = ($page - 1) * REGISTRO_PAGINA;
      $sql .= " LIMIT ".$page.",".REGISTRO_PAGINA; 
    }
    //echo $sql;
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
      //si no tiene hoja de vida cargada  y si campos de telefonos correo areas y cedula     
          
      if(empty($_SESSION['mfo_datos']['usuario']['ultima_sesion']) && ($_SESSION['mfo_datos']['usuario']['tipo_registro'] == self::PRE_REG || $_SESSION['mfo_datos']['usuario']['tipo_registro'] == self::REDSOCIAL_REG)){ 
        Utils::doRedirect(PUERTO.'://'.HOST.'/cambioClave/');
      }    

      if (empty($infohv)){
        $_SESSION['mostrar_error'] = "Cargar la hoja de vida es obligatorio";
        Utils::doRedirect(PUERTO.'://'.HOST.'/perfil/');
      }   
      
      $nrotest = Modelo_Cuestionario::totalTest();             
      $nrotestxusuario = Modelo_Cuestionario::totalTestxUsuario($idusuario);
      
      //si no tengo plan o mi plan no tiene permiso para el tercer formulario, debe tener uno menos del total de test  
      if ((!isset($planes) || !Modelo_PermisoPlan::tienePermiso($planes,'tercerFormulario')) && $nrotestxusuario < ($nrotest-3)){
        //$_SESSION['mostrar_error'] = "Debe completar el test";        
        Utils::doRedirect(PUERTO.'://'.HOST.'/cuestionario/');
      }
      //si tengo plan y mi plan tiene permiso para el tercer formulario, debe tener el total de test
      elseif(isset($planes) && Modelo_PermisoPlan::tienePermiso($planes,'tercerFormulario') && $nrotestxusuario < $nrotest){
        //si existe un acceso eliminar la notificacion del acceso
        
        //$_SESSION['mostrar_error'] = "Debe completar el test";
        Utils::doRedirect(PUERTO.'://'.HOST.'/cuestionario/');
      }
      elseif($_SESSION['mfo_datos']['usuario']['pendiente_test']){
        Utils::doRedirect(PUERTO.'://'.HOST.'/preguntas/'); 
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

      if(!empty($_SESSION['mfo_datos']['usuario']['tipo_usuario']) && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA && (empty($_SESSION['mfo_datos']['usuario']['id_cargo']) || empty($_SESSION['mfo_datos']['usuario']['nro_trabajadores']))){ 

        $_SESSION['mostrar_error'] = "Debe completar el perfil para continuar";
        Utils::doRedirect(PUERTO.'://'.HOST.'/perfil/');
      }  
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
    $sql = "SELECT e.id_empresa,ep.id_plan,ep.id_empresa_plan_parent
            FROM mfo_empresa e
            INNER JOIN mfo_empresa_plan ep ON ep.id_empresa = e.id_empresa 
            WHERE e.padre IN(?)";
    $padre = $GLOBALS['db']->auto_array($sql,array($idpadre),true);
    if (!empty($padre) && is_array($padre)){
      //$numreg = count($padre);
      $cuentaPlan = array();
      foreach($padre as $key=>$registro){
        if(!isset($cuentaPlan[$registro["id_empresa"]])){
          $cuentaPlan[$registro["id_empresa"]] = $registro["id_empresa_plan_parent"];
        }
        //$strpadre .= $registro["id_empresa"].(($key+1 < $numreg) ? ',' : '');
      }
    }      
    return $cuentaPlan;    
  }
  #OBTIENE LAS EMPRESAS HIJAS Y SUS PLANES
  public static function obtieneSubempresasYplanes($padre,$page,$subempresa=false,$obtCantdRegistros=false){
    if (empty($padre)) { return false; }
     $sql = "SELECT ";
    if($obtCantdRegistros == false){
      $sql .= "e.nombres, e.id_empresa,GROUP_CONCAT(ep.id_empresa_plan) AS ids_empresasPlans,GROUP_CONCAT(ep.id_plan) AS ids_planes,GROUP_CONCAT(ep.id_empresa_plan_parent) AS ids_parents,GROUP_CONCAT(ep.fecha_caducidad) AS fechas_caducidades, GROUP_CONCAT(pl.nombre) AS planes,GROUP_CONCAT(DATE_FORMAT(ep.fecha_compra, '%Y-%m-%d')) AS fecha_compra, GROUP_CONCAT(IF(ep.num_publicaciones_rest = -1,'Ilimitado',ep.num_publicaciones_rest)) AS num_publicaciones_rest, GROUP_CONCAT(IF(ep.num_descarga_rest = -1,'Ilimitado',ep.num_descarga_rest)) AS num_descarga_rest,GROUP_CONCAT(IF(ep.estado = 1,'Activo','Inactivo')) AS estado";
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
    //echo $sql;
    return $GLOBALS['db']->auto_array($sql,array($padre),true);
  }
  /******************MINISITIO*****************/
  /*public static function buscaUsuario($id_usuario){
    if (empty($id_usuario)){ return false; }
    $sql = "SELECT id_usuario FROM mfo_usuariom2 WHERE id_usuario = ?";
    $rs = $GLOBALS['db']->auto_array($sql,array($id_usuario));
    if (empty($rs['id_usuario'])){ return false; } else{ return true; }
  }
  public static function obtieneNombres($idusuario){
    if (empty($idusuario)){ return false; }
    $sql = "SELECT nombres, apellidos FROM mfo_usuariom2 WHERE id_usuario = ? LIMIT 1";
    return $GLOBALS['db']->auto_array($sql,array($idusuario));
  }
  public static function prueba(){
    $sql = "SELECT gender, count(*) as number FROM tbl_employee GROUP BY gender";
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }
  public static function guardarUsuario($data){
    if (empty($data)) {return false;}
    $term_cond = 0;
    if($data['terminos_condiciones'] == 'on'){
      $term_cond = 1;
    }
    $data_usuario = array("nombres"=>$data['nombres'], "apellidos"=>$data['apellidos'], "fecha_nacimiento"=>$data['fecha_nacimiento'], "id_nacionalidad"=>$data['pais'], "id_ciudad"=>$data['cantonnac'], "genero"=>$data['genero'], "estado_civil"=>$data['estado_civil'], "id_escolaridad"=>$data['nivel_instruccion'], "fecha_creacion"=>date("Y-m-d H:i:s"), "term_cond"=>$term_cond, "correo"=>$data['correo'], "asp_salarial"=>$data['aspiracion_salarial'], "id_parroquia"=>$data['parroquia_res'], "id_profesion"=>$data['profesion'], "id_ocupacion"=>$data['ocupacion']);
    if($data['cantonnac'] == NULL || $data['cantonnac'] == ""){
      $data_usuario = array("nombres"=>$data['nombres'], "apellidos"=>$data['apellidos'], "fecha_nacimiento"=>$data['fecha_nacimiento'], "id_nacionalidad"=>$data['pais'], "genero"=>$data['genero'], "estado_civil"=>$data['estado_civil'], "id_escolaridad"=>$data['nivel_instruccion'], "fecha_creacion"=>date("Y-m-d H:i:s"), "term_cond"=>$term_cond, "correo"=>$data['correo'], "asp_salarial"=>$data['aspiracion_salarial'], "id_parroquia"=>$data['parroquia_res'], "id_profesion"=>$data['profesion'], "id_ocupacion"=>$data['ocupacion']);
    }
      $result = $GLOBALS['db']->insert('mfo_usuariom2', $data_usuario);
      return $result;
  }*/
  public static function actualizarMetodoSeleccion($id_usuario, $modo){
    if(empty($id_usuario) || (empty($modo) && is_numeric($modo))){return false;}
    return $GLOBALS['db']->update("mfo_usuario",array("metodo_resp"=>$modo),"id_usuario=".$id_usuario);
  }
  public static function consultarMetodoASeleccion($id_usuario){
    $sql = "SELECT metodo_resp FROM mfo_usuario WHERE id_usuario = ?";
    $rs = $GLOBALS['db']->auto_array($sql,array($id_usuario));
    if (empty($rs['metodo_resp'])){ return false; } else{ return $rs; }
  }
  public static function actualizarAceptarAcceso($id_usuario,$estado=1){
    if(empty($id_usuario)){return false;}
    return $GLOBALS['db']->update("mfo_usuario",array("pendiente_test"=>$estado),"id_usuario=".$id_usuario);
  }

  public static function actualizarGrafico($id_usuario,$imagen){
    if(empty($id_usuario) || empty($imagen)){return false;}
    return $GLOBALS['db']->update("mfo_usuario",array("grafico"=>$imagen),"id_usuario=".$id_usuario);
  }

  public static function obtenerPassAnt($id_usuario_login){
    if(empty($id_usuario_login)){return false;}
    $sql = "SELECT password FROM mfo_usuario_login WHERE id_usuario_login = ?";
    $rs = $GLOBALS['db']->auto_array($sql,array($id_usuario_login));
    if (empty($rs['password'])){ return false; } else{ return $rs['password']; }
  }
  public static function consultarTestIncompleto($usuarios,$cantd_facetas){
    if(empty($cantd_facetas) || empty($usuarios)){return false;}
    $sql = 'SELECT GROUP_CONCAT(t.id_usuario) AS usuarios FROM (SELECT id_usuario, IF(SUM(estado) = '.$cantd_facetas.',1,0) AS test_terminado 
      FROM mfo_porcentajexfaceta WHERE id_usuario IN('.$usuarios.')
      GROUP BY id_usuario
      HAVING test_terminado = 0) t';
    $rs = $GLOBALS['db']->auto_array($sql,array(),false);
    if (empty($rs['usuarios'])){ return false; } else{ return $rs['usuarios']; }
  }
  public static function obtenerDatos($usuarios){
    if(empty($usuarios)){return false;}
    $sql = 'SELECT u.id_usuario,u.nombres,u.apellidos,ul.correo FROM mfo_usuario u, mfo_usuario_login ul WHERE u.id_usuario IN('.$usuarios.') AND u.id_usuario_login = ul.id_usuario_login';
    $arrdatos = $GLOBALS['db']->auto_array($sql,array(),true);
    $datos = array();
    if (!empty($arrdatos) && is_array($arrdatos)){
      foreach ($arrdatos as $key => $value) {
        $datos[$value['id_usuario']] = array('nombres' => $value['nombres'],'apellidos'=>$value['apellidos'],'correo'=>$value['correo']);
      }
    }
    return $datos;
  }
  public static function obtenerUsuariosPreregistrados(){
    $sql = "SELECT 
    *
FROM
    (SELECT 
        e.nombres, '' apellidos, e.id_empresa id_reg, e.id_usuario_login, e.ultima_sesion, e.estado
    FROM
        mfo_empresa e UNION SELECT u.nombres, u.apellidos apellidos, u.id_usuario id_reg,
        u.id_usuario_login, u.ultima_sesion, u.estado
    FROM
        mfo_usuario u) AS data,
    mfo_usuario_login AS ul
WHERE
    data.ultima_sesion IS NULL
        AND ul.tipo_registro = 1
        AND data.estado = 0
        AND ul.id_usuario_login = data.id_usuario_login;";
    return $GLOBALS['db']->auto_array($sql,array(), true);
  }
  public static function obtenerFacetasxUsuario($id_usuario,$facetas=false){

    if($facetas == false){
      $sql = 'SELECT id_faceta,valor,literal FROM mfo_porcentajexfaceta pf WHERE pf.id_usuario = ? ORDER BY id_faceta';
    }else{
      $sql = 'SELECT pf.valor, pf.id_faceta, d.descripcion, d.id_puntaje FROM mfo_porcentajexfaceta pf 
        INNER JOIN mfo_baremo2 b on b.porcentaje = pf.valor
        INNER JOIN mfo_descriptor2 d on d.id_faceta = pf.id_faceta
        WHERE pf.id_usuario = ? and pf.id_faceta in('.$facetas.')
        AND b.id_puntaje = d.id_puntaje;';
    }
//echo $sql;
    return $GLOBALS['db']->auto_array($sql,array($id_usuario), true);
  }
}  
?>
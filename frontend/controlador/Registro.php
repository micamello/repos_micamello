<?php 
class Controlador_Registro extends Controlador_Base {

  public function construirPagina(){
    if( Modelo_Usuario::estaLogueado() ){
      Utils::doRedirect(PUERTO.'://'.HOST.'/perfil/');
    }

    $opcion = Utils::getParam('opcion','',$this->data);
    $buscar = "";
    switch($opcion){      
      case 'activacion':
        $this->validarToken();
      break;
      case 'buscarDni':
        $dni = Utils::getParam('dni', '', $this->data);
        $buscardni = Modelo_Usuario::existeDni($dni);
        Utils::log("eder");
        Vista::renderJSON(array("dato"=>$buscardni));
      break;
      case 'buscarCorreo':
        $correo = Utils::getParam('correo', '', $this->data);
        $buscarcorreo = Modelo_Usuario::existeCorreo($correo);
        Vista::renderJSON(array("dato"=>$buscarcorreo));
      break;
      case 'procesoGuardar':
        $this->procesoGuardado();
      break;
      default:
        $this->mostrarDefault();
      break;
    } 
  }

  public function mostrarDefault(){
    $this->linkRedesSociales();
    $social_reg = array('fb'=>$this->loginURL, 'gg'=>$this->gg_URL, 'lk'=>$this->lk, 'tw'=>$this->tw);
    $arrgenero = Modelo_Genero::obtenerListadoGenero();
    $arrsectorind = Modelo_SectorIndustrial::consulta();
    $tags = array('arrgenero'=>$arrgenero,
                  'arrsectorind'=>$arrsectorind,
                  'social'=>$social_reg,
                  'vista'=>'registro');

    $tags["template_css"][] = "DateTimePicker";
    $tags["template_js"][] = "DniRuc_Validador";
    $tags["template_js"][] = "DateTimePicker";
    $tags["template_js"][] = "registroUsuarios";
    Vista::render('formularioRegistro', $tags);
  }

  public function procesoGuardado(){
    $iso = SUCURSAL_ISO;
    $url = "";
    if ( Utils::getParam('formularioRegistro') == 1 ){
      try {        
        if($_POST['tipo_usuario'] == Modelo_Usuario::CANDIDATO){
          $campos = array('tipo_usuario'=>1, 'tipo_documentacion'=>1, 'formularioRegistro'=>1, 'nombresCandEmp'=>1, 'apellidosCand'=>1, 'correoCandEmp'=>1, 'celularCandEmp'=>1, 'tipoDoc'=>1, 'documentoCandEmp'=>1, 'fechaNac'=>1, 'generoUsuario'=>1, 'password_1'=>1, 'password_2'=>1);
        }
        if($_POST['tipo_usuario'] == Modelo_Usuario::EMPRESA){
          $campos = array('tipo_usuario'=>1, 'tipo_documentacion'=>1, 'formularioRegistro'=>1, 'nombresCandEmp'=>1, 'correoCandEmp'=>1, 'celularCandEmp'=>1, 'documentoCandEmp'=>1, 'password_1'=>1, 'password_2'=>1, 'nombreConEmp'=>1, 'apellidoConEmp'=>1, 'tel1ConEmp'=>1, 'sectorind'=>1);
          if(isset($_POST['tel2ConEmp']) && $_POST['tel2ConEmp'] != ""){
            $campos = array_merge($campos, array('tel2ConEmp'=>1));
          }
        }        
        $datosReg = $this->camposRequeridos($campos);
        
        $datosValidos = self::validarCamposReg($datosReg);

        $GLOBALS['db']->beginTrans();
        $id_usuario = self::guardarDatosUsuario($datosValidos);
        if (empty($id_usuario)){
          throw new Exception("Error en el sistema, por favor intente de nuevo");
        }
        $GLOBALS['db']->commit();
        setcookie('preRegistro', null, -1, '/');
        // setcookie("showModal", "", time()-3600);
        $nombres = ucfirst($datosReg['nombresCandEmp']).((isset($datosReg['apellidosCand'])) ? " ".ucfirst($datosReg['apellidosCand']) : '');

        if($datosValidos['tipo_usuario'] == Modelo_Usuario::CANDIDATO){
          $token = Utils::generarToken($id_usuario,"ACTIVACION");
          if (empty($token)){
            throw new Exception("Error en el sistema, por favor intente de nuevo");
          }
          $token .= "||".$id_usuario."||".$datosValidos['tipo_usuario']."||".date("Y-m-d H:i:s");
          $token = Utils::encriptar($token);
          if (!$this->correoActivacionCuenta($datosValidos['correoCandEmp'],$nombres,$token,$datosValidos['username'] , Modelo_Usuario::CANDIDATO)){
              throw new Exception("Error en el env\u00EDo de correo, por favor intente de nuevo");
          }
          $_SESSION['mostrar_exito'] = 'Se ha registrado correctamente, revise su bandeja de entrada o spam para activar su cuenta';
        }
        if($datosValidos['tipo_usuario'] == Modelo_Usuario::EMPRESA){
          $token = "";
            if (!$this->correoActivacionCuenta($datosValidos['correoCandEmp'],$nombres,$token,$datosValidos['username'] , Modelo_Usuario::EMPRESA)){
              throw new Exception("Error en el env\u00EDo de correo, por favor intente de nuevo");
          }
          $_SESSION['mostrar_exito'] = 'Se ha registrado correctamente, revise su bandeja de entrada.';
          foreach (DIRECTORIOCORREOS as $key => $value) {
            Utils::envioCorreo($value,"Registro de empresa","Se registro una empresa. Verificar datos");
          }
        }

// $datosValidos['tipoEmpresa'] != "" -> SI LA EMPRESA ES PERSONA NATURAL
        
      } 
      catch (Exception $e) {
        setcookie('preRegistro', $_POST['tipo_usuario'], time() + (86400 * 30), "/");
        $url = "registro/";
        $GLOBALS['db']->rollback();
        $_SESSION['mostrar_error'] = $e->getMessage();
      }
    }
    Utils::doRedirect(PUERTO . '://' . HOST.'/'.$url);
  }

  public function validarCamposReg($datosReg){
    $tipoEmpresa = "";
    $datosReg['correoCandEmp'] = trim(strtolower($datosReg['correoCandEmp']));
    $iso = SUCURSAL_ISO;
    if(!Utils::es_correo_valido($datosReg['correoCandEmp'])){
      throw new Exception("El correo ingresado no es v\u00E1lido");
    }
    if(Modelo_Usuario::existeCorreo($datosReg['correoCandEmp'])){
      throw new Exception("El correo ingresado ya existe");
    }

    if($datosReg['tipo_documentacion'] == 1 || $datosReg['tipo_documentacion'] == 2){
      if (method_exists(new Utils, 'validar_'.$iso)){
        $function = 'validar_'.$iso;
        $retornoDNIRUC = Utils::$function($datosReg['documentoCandEmp'], 2 , $datosReg['tipo_documentacion']);
        if(is_array($retornoDNIRUC)){
          $tipoEmpresa = $retornoDNIRUC['tipo'];
          $retornoDNIRUC = $retornoDNIRUC['estado'];
        }
        if(!$retornoDNIRUC){
          throw new Exception("El documento ingresado no es v\u00E1lido");
        }
      }
    }
    else{
      if(!Utils::validarPasaporte($datosReg['documentoCandEmp'])){
        throw new Exception("Ingrese un pasaporte v\u00E1lido");
      }
    }

    if($datosReg['tipo_usuario'] Modelo_Usuario::CANDIDATO){
      if(!Utils::valida_fecha($datosReg['fechaNac'])){
        throw new Exception("Ingrese una fecha v\u00E1lida");
      }

      if(!Utils::valida_fecha_mayor_edad($datosReg['fechaNac'])){
        throw new Exception("Debe ser mayor de edad");
      }

      if(!Utils::validarTelefono($datosReg['celularCandEmp'])){
        throw new Exception("Ingrese un n\u00FAmero de celular v\u00E1lido (10d\u00EDgitos)");
      }
    }


    if($datosReg['tipo_usuario'] == 2){

      if(!Utils::validarCelularConvencional($datosReg['celularCandEmp'])){
        throw new Exception("Ingrese un n\u00FAmero de celular v\u00E1lido (entre 9 y 15 d\u00EDgitos)");
      }


      if(!Utils::validarTelefono($datosReg['tel1ConEmp'])){
        throw new Exception("Ingrese un n\u00FAmero de celular v\u00E1lido (10 d\u00EDgitos)");
      }

      if(isset($datosReg['tel2ConEmp'])){
        if(!Utils::validarTelefonoConvencional($datosReg['tel2ConEmp'])){
          throw new Exception("Ingrese un n\u00FAmero de tel\u00E9fono convencional v\u00E1lido (9 d\u00CDgitos)");
        }
      }
    }

    if(Modelo_Usuario::existeDni($datosReg['documentoCandEmp'])){
      throw new Exception("El documento ingresado ya existe");
    }
    if(!Utils::validarPassword($datosReg['password_1']) || !Utils::validarPassword($datosReg['password_2'])){
      throw new Exception("La contrase\u00F1a ingresada no cumple el formato");
    }
    if(!Utils::passCoinciden($datosReg['password_1'], $datosReg['password_2'])){
      throw new Exception("Las contrase\u00F1as ingresadas no coinciden");
    }

    // generar username
    // username para candidato
    $nombreCorreo = array();
    $nombreCandidatoEmpresa = explode(" ", Utils::no_carac(utf8_decode($datosReg['nombresCandEmp'])));
    if($datosReg['tipo_usuario'] == Modelo_Usuario::CANDIDATO){
      $nombreCorreo = array('nombreCorreo'=>$nombreCandidatoEmpresa[0]." ".$apellidoCandidato[0]);
      $apellidoCandidato = explode(" ", Utils::no_carac(utf8_decode($datosReg['apellidosCand'])));
      $username = array("username"=>Utils::generarUsername(strtolower($nombreCandidatoEmpresa[0].$apellidoCandidato[0])));
    }
    else{
      $nombreCorreo = array('nombreCorreo'=>$nombreCandidatoEmpresa[0]);
      $username = array("username"=>Utils::generarUsername(strtolower($nombreCandidatoEmpresa[0])));
    }
    $datosReg = array_merge($datosReg, $username);
    $datosReg = array_merge($datosReg, $nombreCorreo);
    $datosReg = array_merge($datosReg, array('tipoEmpresa'=>$tipoEmpresa));

    return $datosReg;
  }

  public function guardarDatosUsuario($datosValidos){
    $data = array(); $id_usuario = "";    
    $usuario_login = array("tipo_usuario"=>$datosValidos['tipo_usuario'], "username"=>$datosValidos['username'], 
                           "password"=>$datosValidos['password_1'], "correo"=>$datosValidos['correoCandEmp'], "dni"=>$datosValidos['documentoCandEmp'], "tipo_registro"=>2);
    if(!Modelo_UsuarioLogin::crearUsuarioLogin($usuario_login)){      
      throw new Exception("Ha ocurrido un error, por favor intente nuevamente");
    }
    $id_usuario_login = $GLOBALS['db']->insert_id();
    $fechaDefault = date("Y-m-d H:i:s");
    $fechaNacimientoDefault = date("Y-m-d H:i:s",strtotime($fechaDefault."- 18 year")); 
    /*Debe ser mayor de edad fecha default*/
    $ciudadDefault = Modelo_Sucursal::obtieneCiudadDefault();    
    // usuario tipo candidato
    if($datosValidos['tipo_usuario'] == Modelo_Usuario::CANDIDATO){
      $id_estadocivil = Modelo_EstadoCivil::obtieneListado();
      $id_situacionlaboral = Modelo_SituacionLaboral::obtieneListadoAsociativo();
      foreach ($id_situacionlaboral as $key => $value) {
        $id_situacionlaboral = $key;
        break;
      }
      $datosValidos = array_merge($datosValidos, array('id_estadocivil'=>$id_estadocivil[0]['id_estadocivil'], 'id_situacionlaboral'=>$id_situacionlaboral));
      $escolaridad = Modelo_Escolaridad::obtieneListado();
      $data = array(
                    "nombres"=>$datosValidos['nombresCandEmp'], /*data -----*/
                      "apellidos"=>$datosValidos['apellidosCand'],/*data -----*/
                      "telefono"=>$datosValidos['celularCandEmp'],/*data -----*/
                      "fecha_nacimiento"=>$datosValidos['fechaNac'], /* -----*/
                      "fecha_creacion"=>$fechaDefault,/* -----*/
                      "estado"=>0,
                      "term_cond"=>1,/*data*/
                      "id_ciudad"=>$ciudadDefault['id_ciudad'],/**/
                      "id_nacionalidad"=>SUCURSAL_PAISID,/*--*/
                      "tipo_doc"=>$datosValidos['tipo_documentacion'],/*data*/
                      "id_escolaridad"=>$escolaridad[0]['id_escolaridad'],/**/
                      "genero"=>$datosValidos['generoUsuario'],/*--*/
                      "id_usuario_login"=>$id_usuario_login, 
                      "tipo_usuario"=>$datosValidos['tipo_usuario'],
                      "id_estadocivil"=>$datosValidos['id_estadocivil'],
                      "id_situacionlaboral"=>$datosValidos['id_situacionlaboral']);/**/
      if(!Modelo_Usuario::crearUsuario($data)){
        throw new Exception("Ha ocurrido un error, por favor intente nuevamente");
      }
      $id_usuario = $GLOBALS['db']->insert_id();
    }
    else{
      $data = array("nombres"=>$datosValidos['nombresCandEmp'],
                    "telefono"=>$datosValidos['celularCandEmp'],
                    //"fecha_nacimiento"=>$fechaNacimientoDefault,
                    "nro_trabajadores" => 0,                    
                    "fecha_creacion"=>$fechaDefault,/* -----*/
                    "estado"=>0,
                    "term_cond"=>1,
                    "id_ciudad"=>$ciudadDefault['id_ciudad'],
                    "id_nacionalidad"=>SUCURSAL_PAISID,
                    "id_usuario_login"=>$id_usuario_login, 
                    "tipo_usuario"=>$datosValidos['tipo_usuario'],
                    "id_sectorindustrial"=>$datosValidos['sectorind']);
      if(!Modelo_Usuario::crearUsuario($data)){
        throw new Exception("Ha ocurrido un error, por favor intente nuevamente");
      }
      $id_usuario = $GLOBALS['db']->insert_id();
      if(!Modelo_ContactoEmpresa::crearContactoEmpresa($datosValidos, $id_usuario)){
        throw new Exception("Ha ocurrido un error, por favor intente nuevamente");
      }
    }
    return $id_usuario;
  }

  public function validarToken(){
    $tags = array();
    try{            
      $respuesta = Utils::getParam('token', '', false);
      if (empty($respuesta)){
        throw new Exception("La activaci\u00F3n de la cuenta es fallida, por favor intente de nuevo");
      }  
      $tags["token"] = $respuesta;              
      $respuesta = Utils::desencriptar($respuesta);          
      $valores = explode("||",$respuesta);      
      $token = $valores[0];
      $idusuario = $valores[1];
      $tipousuario = $valores[2];
      $fecha = $valores[3];
      $token_valido = Utils::generarToken($idusuario,"ACTIVACION");
      if($token_valido != $token){
        throw new Exception("El enlace para recuperaci\u00F3n es incorrecto, por favor ingrese denuevo su correo para el env\u00EDo");      
      }
      if(!Modelo_Usuario::activarCuenta($idusuario, $tipousuario)){
        throw new Exception("Ha ocurrido un error al activar la cuenta, por favor intente nuevamente");
      }
      $_SESSION['mostrar_exito'] = "Su cuenta se ha activado correctamente";
      $this->redirectToController('login');
    }
    catch( Exception $e ){
      $_SESSION['mostrar_error'] = $e->getMessage(); 
      Utils::doRedirect(PUERTO.'://'.HOST.'/');
    }        
  }

  public function google($userdata){
    $this->registroRedSocial($userdata["email"],$userdata['given_name'],$userdata['family_name']);    
  } 

  public function linkedin($userdata){
    $this->registroRedSocial($userdata["emailAddress"],$userdata['firstName'],$userdata['lastName']);    
  }

  public function twitter($userdata){    
    $this->registroRedSocial($userdata["email"],$userdata['name'],$userdata['screen_name']);    
  }

  public function facebook($userdata){
    $this->registroRedSocial($userdata["email"],$userdata['first_name'],$userdata['last_name']);    
  }

  public function registroRedSocial($correo,$nombre,$apellido){
    $url = "";
    $correo = strtolower($correo);
    $id_estadocivil = Modelo_EstadoCivil::obtieneListado();
    $id_situacionlaboral = Modelo_SituacionLaboral::obtieneListadoAsociativo();
    $id_genero = Modelo_Genero::obtenerListadoGenero();
    $id_genero = $id_genero[0]['id_genero'];
    $id_estadocivil = $id_estadocivil[0]['id_estadocivil'];


    foreach ($id_situacionlaboral as $key => $value) {
      $id_situacionlaboral = $key;
      break;
    }

    $default_city = Modelo_Sucursal::obtieneCiudadDefault();
    $escolaridad = Modelo_Escolaridad::obtieneListado();
    $campo_fecha = date("Y-m-d H:i:s");
    $mayor_edad = date("Y-m-d H:i:s",strtotime($campo_fecha."- 18 year"));
    try {      
      $GLOBALS['db']->beginTrans();
      $datocorreo = Modelo_Usuario::existeCorreo($correo);
      if (!empty($datocorreo)){
        throw new Exception("El correo asociado con su red social ya se encuentra ingresada");
      }
      $apell_user = Utils::no_carac(explode(" ", ucfirst(trim($apellido))));
      $nombre_user = Utils::no_carac(explode(" ", ucfirst(trim($nombre))));
      $username = $nombre_user[0].$apell_user[0];
      $username = Utils::generarUsername(strtolower($username));      
      $password = Utils::generarPassword();
      $usuario_login = array("tipo_usuario"=>Modelo_Usuario::CANDIDATO, "username"=>$username, 
                             "password"=>$password, "correo"=>$correo, "dni"=>0, 'tipo_registro'=>3);
      if(!Modelo_UsuarioLogin::crearUsuarioLogin($usuario_login)){
        throw new Exception("Ha ocurrido un error, por favor intente denuevo");
      }
      $id_usuario_login = $GLOBALS['db']->insert_id();                  
      $dato_registro = array("telefono"=>"-", "nombres"=>$nombre, "apellidos"=>$apellido, "fecha_nacimiento"=>$mayor_edad,
                             "fecha_creacion"=>$campo_fecha, "estado"=>0, "term_cond"=>1, "id_ciudad"=>$default_city['id_ciudad'],
                             "ultima_sesion"=>$campo_fecha, "id_nacionalidad"=>SUCURSAL_PAISID, "tipo_doc"=>0, 
                             "id_escolaridad"=>$escolaridad[0]['id_escolaridad'], "genero"=>$id_genero, 
                             "id_usuario_login"=>$id_usuario_login, "tipo_usuario"=>Modelo_Usuario::CANDIDATO,
                             "id_estadocivil"=>$id_estadocivil, "id_situacionlaboral"=>$id_situacionlaboral);
         
      if(!Modelo_Usuario::crearUsuario($dato_registro)){
        throw new Exception("Ha ocurrido un error, por favor intente nuevamente");
      }
      $user_id = $GLOBALS['db']->insert_id();
      $GLOBALS['db']->commit();        
      $nombres = $nombre." ".$apellido;      
      $token = Utils::generarToken($user_id,"ACTIVACION");
      if (empty($token)){
        throw new Exception("Error en el sistema, por favor intente de nuevo");
      }
      $token .= "||".$user_id."||".Modelo_Usuario::CANDIDATO."||".date("Y-m-d H:i:s");
      $token = Utils::encriptar($token);
      if (!$this->correoActivacionRedSocial($correo,$nombres,$token,$username,$password)){
        throw new Exception("Error en el env\u00EDo de correo, por favor intente denuevo");
      }
      $_SESSION['mostrar_exito'] = 'Se ha registrado correctamente, revise su bandeja de entrada o spam para activar tu cuenta';  
    } 
    catch (Exception $e) {
      $url = "registro/";
      $GLOBALS['db']->rollback();
      $_SESSION['mostrar_error'] = $e->getMessage();
    }    
    Utils::doRedirect(PUERTO.'://'.HOST.'/'.$url);
  } 

  public function correoActivacionCuenta($correo,$nombres,$token, $username, $tipoempresa){
    $email_body = "";
    if($tipoempresa == 1){
      $email_body = Modelo_TemplateEmail::obtieneHTML("REGISTRO_USUARIO");
      $enlace = "<a style='background-color: #22b573; color: white; padding: 8px 20px; text-decoration: none; border-radius: 5px;' href='".PUERTO."://".HOST."/registro/".$token."/'>click aqui</a>";
      $email_body = str_replace("%ENLACE%", $enlace, $email_body);
    }
    else{
      $email_body = Modelo_TemplateEmail::obtieneHTML("REGISTRO_EMPRESA");
    }
    $email_body = str_replace("%NOMBRES%", $nombres, $email_body);   
    $email_body = str_replace("%USUARIO%", $username, $email_body);
    $email_body = str_replace("%CORREO%", $correo, $email_body); 
    
    if (Utils::envioCorreo($correo,"Registro de Empresa",$email_body)){
      return true;
    }
    else{
      return false;
    }
  }

  public function correoActivacionRedSocial($correo,$nombres,$token,$username,$clave){
    $enlace = "<a style='background-color: #22b573; color: white; padding: 8px 20px; text-decoration: none; border-radius: 5px;' href='".PUERTO."://".HOST."/registro/".$token."/'>click aqui</a>";
    $email_body = Modelo_TemplateEmail::obtieneHTML("REGISTRO_USUA_REDSOCIAL");
    $email_body = str_replace("%NOMBRES%", $nombres, $email_body);   
    $email_body = str_replace("%USUARIO%", $username, $email_body);
    $email_body = str_replace("%CORREO%", $correo, $email_body);
    $email_body = str_replace("%PASSWORD%", $clave, $email_body);   
    $email_body = str_replace("%ENLACE%", $enlace, $email_body);   
    if (Utils::envioCorreo($correo,"Registro de Candidato Con Red Social",$email_body)){
      return true;
    }
    else{
      return false;
    }
  }
}
?>
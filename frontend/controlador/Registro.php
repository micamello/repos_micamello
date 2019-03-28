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
      case 'buscarCorreo':
        $buscar = Utils::getParam('correo','',$this->data);
        $datocorreo = Modelo_Usuario::existeCorreo($buscar);
        Vista::renderJSON(array("dato"=>$datocorreo));
      break;  
      case 'buscarDocumento':
        $buscar = Utils::getParam('documento','',$this->data);
        $datoDocumento = Modelo_Usuario::existeDni($buscar);
        Vista::renderJSON(array("dato"=>$datoDocumento));
      break;
      default:
        // $this->validateCampos();
        $this->procesoGuardado();
      break;
    } 
  }

  public function procesoGuardado(){
    // Utils::log("eder");
    $iso = SUCURSAL_ISO;
    if ( Utils::getParam('formularioRegistro') == 1 ){
      try {
        // Usuario candidato
        if($_POST['tipo_usuario'] == 1){
          $campos = array('tipo_usuario'=>1, 'tipo_documentacion'=>1, 'formularioRegistro'=>1, 'nombresCandEmp'=>1, 'apellidosCand'=>1, 'correoCandEmp'=>1, 'celularCandEmp'=>1, 'tipoDoc'=>1, 'documentoCandEmp'=>1, 'areaCand'=>1, 'subareasCand'=>1, 'password_1'=>1, 'password_2'=>1);
        }  

        $datosReg = $this->camposRequeridos($campos);
        // Utils::log(print_r($datosReg, true));

        $datosValidos = self::validarCamposReg($datosReg);
        // var_dump($datosValidos);
        $GLOBALS['db']->beginTrans();
          self::guardarDatosUsuario($datosValidos);
        $GLOBALS['db']->commit();

      } catch (Exception $e) {
        $GLOBALS['db']->rollback();
        $_SESSION['mostrar_error'] = $e->getMessage();
      }
    }
  }

  public function validarCamposReg($datosReg){
    $iso = SUCURSAL_ISO;
    $arraySubareas = array();

    if(!Utils::es_correo_valido($datosReg['correoCandEmp'])){
      throw new Exception("El correo ingresado no es válido");
    }

    if(Modelo_Usuario::existeCorreo($datosReg['correoCandEmp'])){
      throw new Exception("El correo ingresado ya existe");
    }

    if (method_exists(new Utils, 'validar_'.$iso)){
      $function = 'validar_'.$iso;
      if(!Utils::$function($datosReg['documentoCandEmp'])){
        throw new Exception("El documento ingresado no es válido");
      }
    }

    if(Modelo_Usuario::existeDni($datosReg['documentoCandEmp'])){
      throw new Exception("El documento ingresado ya existe");
    }

    if(!Utils::validarPassword($datosReg['password_1']) || !Utils::validarPassword($datosReg['password_2'])){
      throw new Exception("La contraseña ingresada no cumple el formato");
    }

    if(!Utils::passCoinciden($datosReg['password_1'], $datosReg['password_2'])){
      throw new Exception("Las contraseñas ingresadas no coinciden");
    }

    // validacion de que area y subarea existe
    for ($i=0; $i < count($datosReg['subareasCand']); $i++) { 
      $subareas = explode("_", $datosReg['subareasCand'][$i]);
      if(!in_array($subareas[0], array_keys($GLOBALS['ListAreas'])) && !in_array($subareas[1], array_keys($GLOBALS['ListSubareas']))){
          throw new Exception("Una o más áreas o subáreas seleccionadas no estan disponibles");
        }
        else{
          array_push($arraySubareas, $subareas[2]);
        }
    }
    array_push($datosReg, $arraySubareas);

    if(empty($arraySubareas)){
      throw new Exception("Debe seleccionar al menos una subárea por área");
    }

    if(count($datosReg['areaCand']) < 1 || count($datosReg['areaCand']) > AREASPERMITIDAS){
      throw new Exception("Seleccione el máximo o mínimo permitido de áreas");
    }

    // generar username
    var_dump($_POST);
    Utils::log("FERNANDA".print_r($datosReg, true));
    // username para candidato
    $nombreCandidato = explode(" ", Utils::no_carac($_POST['nombresCandEmp']));
    //$apellidoCandidato = explode(" ", Utils::no_carac($datosReg['apellidosCand']));
    //$username = array("username"=>Utils::generarUsername($nombreCandidato[0].$apellidoCandidato[0]));
    // print_r($_POST);
    //Utils::log(print_r($nombreCandidato,true));
    
    //array_push($datosReg, $username);
    //return $datosReg;

  }

  public function guardarDatosUsuario($datosValidos){
    $data = array();
    // var_dump($datosValidos);
    // exit();
    // guardar mfo_usuario_login
    if(!Modelo_UsuarioLogin::crearUsuarioLogin($datosValidos)){
      print_r("error usuario login");
      throw new Exception("Ha ocurrido un error, intente nuevamente usuario login");
    }

    // usuario tipo candidato
    if($datosValidos['tipo_usuario'] == 1){
      $fechaDefault = date("Y-m-d H:i:s");
      $fechaNacimientoDefault = date("Y-m-d H:i:s",strtotime($fechaDefault."- 18 year")); /*Debe ser mayor de edad fecha default*/
      $ciudadDefault = Modelo_Sucursal::obtieneCiudadDefault();
      $escolaridad = Modelo_Escolaridad::obtieneListado();
      $id_usuario_login = $GLOBALS['db']->insert_id();
      // print_r($escolaridad[0]['id_escolaridad']);
      // exit();

      $data = array(
                    "nombres"=>$datosValidos['nombresCandEmp'], /*data -----*/
                      "apellidos"=>$datosValidos['apellidosCand'],/*data -----*/
                      "telefono"=>$datosValidos['celularCandEmp'],/*data -----*/
                      "fecha_nacimiento"=>$fechaNacimientoDefault, /* -----*/
                      "fecha_creacion"=>$fechaDefault,/* -----*/
                      "estado"=>0,
                      "term_cond"=>1,/*data*/
                      "id_ciudad"=>$ciudadDefault['id_ciudad'],/**/
                      "ultima_sesion"=>$fechaDefault,/* -----*/
                      "id_nacionalidad"=>SUCURSAL_PAISID,/*--*/
                      "tipo_doc"=>$datosValidos['tipo_documentacion'],/*data*/
                      "id_escolaridad"=>$escolaridad[0]['id_escolaridad'],/**/
                      "genero"=>'M',/*--*/
                      "id_usuario_login"=>$id_usuario_login);/**/
    }
    // var_dump($data);
    if(!Modelo_Usuario::crearUsuario($data)){
      print_r("error usuario");
      throw new Exception("Ha ocurrido un error, intente nuevamente usuario");
    }
  }



  // public function validarToken(){
  //   $tags = array();
  //   try{            
  //     $respuesta = Utils::getParam('token', '', false);
  //     if (empty($respuesta)){
  //       throw new Exception("La activacion de la cuenta es fallida, por favor intente de nuevo");
  //     }  
  //       $tags["token"] = $respuesta;              
  //       $respuesta = Utils::desencriptar($respuesta);     
  //       $valores = explode("||",$respuesta);      
  //       $token = $valores[0];
  //       $idusuario = $valores[1];
  //       $tipousuario = $valores[2];
  //       $fecha = $valores[3];
  //       $token_valido = Utils::generarToken($idusuario,"ACTIVACION");
        
  //         if($token_valido != $token){
  //           throw new Exception("El enlace para recuperacion es incorrecto, por favor ingrese denuevo su correo para el envio");      
  //         }

  //         if(!Modelo_Usuario::activarCuenta($idusuario, $tipousuario)){
  //           throw new Exception("Ha ocurrido un error al activar la cuenta, intente nuevamente");
  //         }
  //         $_SESSION['mostrar_exito'] = "Su cuenta se ha activado correctamente";
  //         $this->redirectToController('login');
  //       }
  //     catch( Exception $e ){
  //       $_SESSION['mostrar_error'] = $e->getMessage(); 
  //       Utils::doRedirect(PUERTO.'://'.HOST.'/');
  //     }        
  //   }


  // public function validateCampos(){    
  //   $iso = SUCURSAL_ISO;

  //   if ( Utils::getParam('register_form') == 1 ){
  //     try{
  //       if ($_POST['tipo_usuario'] == 1) {
  //         $campos = array('correo'=>1,'name_user'=>1,'apell_user'=>1,'password'=>1, 'password_two'=>1,'numero_cand'=>1,'cedula'=>1, 'tipo_doc'=>1,'term_cond'=>1,'conf_datos'=>1, 'tipo_usuario'=>1, 'area'=>1, 'subareas'=>1);        
  //       }

  //       if ($_POST['tipo_usuario'] == 2) {
  //         $campos = array('correo'=>1, 'name_user'=>1,'password'=>1, 'password_two'=>1,'numero_cand'=>1,'cedula'=>1,'ruc'=>1,'term_cond'=>1,'conf_datos'=>1, 'tipo_usuario'=>1, "nombre_contact"=>1, "apellido_contact"=>1, "tel_one_contact"=>1, "tel_two_contact"=>0);          
  //       }

  //       $data = $this->camposRequeridos($campos);

  //       $datocorreo = Modelo_Usuario::existeCorreo($data["correo"]);
  //       if (empty($datocorreo)){
  //         throw new Exception("El correo ".$data["correo"]." ya existe");
  //       }

  //       $datodni = Modelo_Usuario::existeDni($data["cedula"]);
  //       if (empty($datodni)){
  //         throw new Exception("El dni ".$data["cedula"]." ya existe");
  //       }

  //       if ($data["password"] != $data["password_two"]){
  //         throw new Exception("Contraseña y confirmación de contraseña no coinciden");
  //       }

  //       $passwordValido = Utils::valida_password($data["password"]);
  //       if ($passwordValido == false){
  //         throw new Exception("Ingrese una contraseña con el formato especificado");
  //       }
  //       $nombres = Utils::no_carac(explode(" ", strtolower($data['name_user'])));
  //       $username = $nombres;
  //       // if(count($nombres)>1){
  //       //   $username = $nombres[0];
  //       // }

  //       if ($_POST['tipo_usuario'] == 1) {
  //         $apell_user = Utils::no_carac(explode(" ", strtolower($data['apell_user'])));
  //         $username = $username[0].$apell_user[0];
  //         if($_POST['tipo_doc'] == 2){ 
  //           if (method_exists(new Utils, 'validar_'.$iso)) {
  //               $function = 'validar_'.$iso;
  //               $validaCedula = Utils::$function($data['cedula']);
  //                 if ($validaCedula == false){
  //                   throw new Exception("El DNI ingresado no es válido");
  //                 }
  //               }
  //             }
  //           }else{
  //             $username = $username[0];
  //             if (method_exists(new Utils, 'validar_'.$iso)) {
  //               $function = 'validar_'.$iso;
  //               $validaCedula = Utils::$function($data['cedula']);
  //                 if ($validaCedula == false){
  //                   throw new Exception("El DNI ingresado no es válido");
  //                 }
  //               }
  //             }

  //       $correoValido = Utils::es_correo_valido($data["correo"]);
  //       if ($correoValido == false){
  //         throw new Exception("Ingrese un correo válido");
  //       }

  //       $username = Utils::no_carac(html_entity_decode($username));
        
  //       $username_generated = self::generarUsername($username);
  //       // Utils::log("eend: ".$username_generated);

  //       $GLOBALS['db']->beginTrans();
  //       // print_r($username_generated);
  //       // print_r($data);
  //       // exit();
  //       self::guardarUsuario($data, $username_generated);
                
  //     }
  //     catch( Exception $e ){
  //       $GLOBALS['db']->rollback();
  //       $_SESSION['mostrar_error'] = $e->getMessage();  
  //     }
      
  //     Utils::doRedirect(PUERTO.'://'.HOST.'/');
  //   }    

  // }

  // public function guardarUsuario($data, $username_generated){
  //   var_dump($data);
  //   var_dump($username_generated);
  //   // exit();
  //   $nombres_correo = "";
  //   $default_city = Modelo_Sucursal::obtieneCiudadDefault();
  //   $campo_fecha = date("Y-m-d H:i:s");
  //   $mayor_edad = date("Y-m-d H:i:s",strtotime($campo_fecha."- 18 year"));

  //   $usuario_login = array('tipo_usuario'=>$data['tipo_usuario'], 'username'=>$username_generated, 'password'=>$data['password'], 'correo'=>$data['correo'], 'dni'=>$data['cedula']);


  //   if(!Modelo_UsuarioLogin::crearUsuarioLogin($usuario_login)){
  //     throw new Exception("Ha ocurrido un error, intente nuevamente");
  //   } // yes---

  //   $id_usuario_login = $GLOBALS['db']->insert_id();

  //   if($data['tipo_usuario'] == 1){
  //     $escolaridad = Modelo_Escolaridad::obtieneListado();
  //     $nombres_correo = $data['name_user']." ".$data['apell_user'];
  //     $dato_registro = array('telefono'=>$data['numero_cand'], 'nombres'=>$data['name_user'], 'apellidos'=>$data['apell_user'], 'fecha_nacimiento'=>$mayor_edad, 'fecha_creacion'=>$campo_fecha, 'estado'=>0, 'term_cond'=>$data['term_cond'], 'conf_datos'=>$data['conf_datos'], 'id_ciudad'=>$default_city['id_ciudad'], 'ultima_sesion'=>$campo_fecha, 'id_nacionalidad'=>SUCURSAL_PAISID, 'tipo_doc'=>$data['tipo_doc'], 'id_escolaridad'=>$escolaridad[0]['id_escolaridad'] , 'genero'=>'M', 'id_usuario_login'=>$id_usuario_login, "estado"=>0, 'tipo_usuario'=>$data['tipo_usuario']);
  //   }
  //   else{
  //     $nombres_correo = $data['name_user'];
  //     $dato_registro = array('telefono'=>$data['numero_cand'], 'nombres'=>$data['name_user'], 'fecha_nacimiento'=>$campo_fecha, 'fecha_creacion'=>$mayor_edad, 'term_cond'=>$data['term_cond'], 'conf_datos'=>$data['conf_datos'], 'id_ciudad'=>$default_city['id_ciudad'], 'ultima_sesion'=>$campo_fecha, 'id_nacionalidad'=>SUCURSAL_PAISID, 'id_usuario_login'=>$id_usuario_login, 'tipo_usuario'=>$data['tipo_usuario'],"estado"=>0);
  //   }
  //       if(!Modelo_Usuario::crearUsuario($dato_registro)){
  //           throw new Exception("Ha ocurrido un error, intente nuevamente");
  //       }
                
  //       $user_id = $GLOBALS['db']->insert_id();
  //       Utils::log($user_id);

  //         // if ($data['tipo_usuario'] == 1) {
  //         //   // $area_select = $data['area_select'];
  //         //   // $nivel_interes = $data['nivel_interes'];

  //         //         // if(!Modelo_UsuarioxArea::crearUsuarioArea($area_select, $user_id)){
  //         //         //     throw new Exception("Ha ocurrido un error, intente nuevamente");
  //         //         // }

  //         //         // if(!Modelo_UsuarioxNivel::crearUsuarioNivel($nivel_interes, $user_id)){
  //         //         //     throw new Exception("Ha ocurrido un error, intente nuevamente");
  //         //         // }
  //         // }
  //         // else{
  //         //   $dato_contacto = array('nombre_contact'=>$data['nombre_contact'], 'apellido_contact'=>$data['apellido_contact'], 'tel_one_contact'=>$data['tel_one_contact'], 'tel_two_contact'=>$data['tel_two_contact']);
            
  //         //   if(!Modelo_ContactoEmpresa::crearContactoEmpresa($dato_contacto, $user_id)){
  //         //     throw new Exception("Ha ocurrido un error el registrar, intente nuevamente");
  //         //   }
  //         // }


  //               $GLOBALS['db']->commit();

  //               $token = Utils::generarToken($user_id,"ACTIVACION");
  //                 if (empty($token)){
  //                   throw new Exception("Error en el sistema, por favor intente de nuevo");
  //                 }

  //               $token .= "||".$user_id."||".$data['tipo_usuario']."||".date("Y-m-d H:i:s");
  //               $token = Utils::encriptar($token);
  //               // if (!$this->correoActivacionCuenta($data['correo'], $nombres_correo,$token, $usuario_login['username'])){
  //               //     throw new Exception("Error en el envio de correo, por favor intente denuevo");
  //               //   }
  //               $parametros = array("tipo"=>1, "correo"=>$data['correo'], "nombres_mostrar"=>$nombres_correo, "usuario_login"=>$usuario_login['username'], "token"=>$token);
  //               if(!Utils::enviarEmail($parametros)){
  //                 throw new Exception("Error en el envio de correo, por favor intente denuevo");
  //               }
  //               // $_SESSION['mostrar_exito'] = "Te has registrado correctamente. Revisa tu cuenta de correo o bandeja de spam y haz clic en el enlace para activar tu cuenta";
  //               // echo "<script type='text/javascript'>alert('Te has registrado correctamente. Revisa tu cuenta de correo o bandeja de spam');</script>";
  //               $_SESSION['registro'] = 1;
  //               Utils::doRedirect(PUERTO."://".HOST."/");
  // }

  // public function facebook($userdata, $tipo_usuario){
  //   $nombres_correo = "";
  //   $default_city = Modelo_Sucursal::obtieneCiudadDefault();
  //   $campo_fecha = date("Y-m-d H:i:s");
  //   $mayor_edad = date("Y-m-d H:i:s",strtotime($campo_fecha."- 18 year"));
  
  //   try {
  //     $datocorreo = Modelo_Usuario::existeCorreo($userdata["email"]);
  //       if (empty($datocorreo)){
  //         throw new Exception("La cuenta ya consta en nuestros registros. Revise su cuenta de correo para activarla.");
  //       }

  //   $apell_user = Utils::no_carac(explode(" ", strtolower($userdata['last_name'])));
  //   $nombre_user = Utils::no_carac(explode(" ", strtolower($userdata['first_name'])));
  //   $username = $nombre_user[0].$apell_user[0];
  //     $username = Utils::generarUsername(strtolower($username));

  //     $GLOBALS['db']->beginTrans();

  //     $password = Utils::generarPassword();
  //     $usuario_login = array("tipo_usuario"=>$tipo_usuario, "username"=>$username, "password"=>$password, "correo"=>$userdata['email'], "dni"=>0);
  //         if(!Modelo_UsuarioLogin::crearUsuarioLogin($usuario_login)){
  //           throw new Exception("Ha ocurrido un error, intente nuevamente");
  //         }

  //     $id_usuario_login = $GLOBALS['db']->insert_id();
  //       if ($tipo_usuario == 1) {
  //         $nombres_correo = $userdata['first_name']." ".$userdata['last_name'];
  //         $escolaridad = Modelo_Escolaridad::obtieneListado();
  //         $dato_registro = array("telefono"=>"0000000000", "nombres"=>$userdata['first_name'], "apellidos"=>$userdata['last_name'], "fecha_nacimiento"=>$mayor_edad, "fecha_creacion"=>$campo_fecha, "token"=>$userdata['id'], "estado"=>0, "term_cond"=>1, "conf_datos"=>1, "id_ciudad"=>$default_city['id_ciudad'], "ultima_sesion"=>$campo_fecha, "id_nacionalidad"=>1, "tipo_doc"=>0, "status_carrera"=>1, "id_escolaridad"=>$escolaridad[0]['id_escolaridad'], "genero"=>"M", "id_usuario_login"=>$id_usuario_login, "tipo_usuario"=>$tipo_usuario);
  //       }


  //       if(!Modelo_Usuario::crearUsuario($dato_registro)){
  //           throw new Exception("Ha ocurrido un error, intente nuevamente");
  //       }
        
  //       $user_id = $GLOBALS['db']->insert_id();

  //     $GLOBALS['db']->commit();
      
  //           $token = Utils::generarToken($user_id,"ACTIVACION");
  //           if (empty($token)){
  //             throw new Exception("Error en el sistema, por favor intente de nuevo");
  //           }

  //         $token .= "||".$user_id."||".$tipo_usuario."||".date("Y-m-d H:i:s");
  //         $token = Utils::encriptar($token);

  //         // if (!$this->credencialSocial($usuario_login['correo'], $nombres_correo, $username, $usuario_login['password'], $token)){
  //         //     throw new Exception("Error al enviar credenciales. Intente nuevamente");
  //         //   }

  //         $parametros = array("tipo"=>2, "correo"=>$usuario_login['correo'], "nombres_mostrar"=>$nombres_correo, "usuario_login"=>$usuario_login['correo'], "token"=>$token);
  //         if(!Utils::enviarEmail($parametros)){
  //           throw new Exception("Error en el envio de correo, por favor intente denuevo");
  //         }
          
  //           $_SESSION['registro'] = 1;
  //   }
  //     catch( Exception $e ){
  //       $GLOBALS['db']->rollback();
  //       $_SESSION['mostrar_error'] = $e->getMessage();  
  //     }
      
  //    Utils::doRedirect(PUERTO.'://'.HOST.'/');
  // }

  // public function google($userdata, $tipo_usuario){
  //   $nombres_correo = "";
  //   $default_city = Modelo_Sucursal::obtieneCiudadDefault();
  //   $campo_fecha = date("Y-m-d H:i:s");
  //   $mayor_edad = date("Y-m-d H:i:s",strtotime($campo_fecha."- 18 year"));

  //   try {
  //     $datocorreo = Modelo_Usuario::existeCorreo($userdata["email"]);
  //       if (empty($datocorreo)){
  //         throw new Exception("El correo asociado a la cuenta de Google con la que desea registrarse ya se encuentra en nuestros registros.");
  //       }

  //     $apell_user = Utils::no_carac(explode(" ", strtolower($userdata['family_name'])));
  //     $nombre_user = Utils::no_carac(explode(" ", strtolower($userdata['given_name'])));
  //     $username = $nombre_user[0].$apell_user[0];

  //     $username = Utils::generarUsername(strtolower($username));

  //     $GLOBALS['db']->beginTrans();

  //     $password = Utils::generarPassword();
  //     $usuario_login = array("tipo_usuario"=>$tipo_usuario, "username"=>$username, "password"=>$password, "correo"=>$userdata['email'], "dni"=>0);
  //         if(!Modelo_UsuarioLogin::crearUsuarioLogin($usuario_login)){
  //           throw new Exception("Ha ocurrido un error, intente nuevamente");
  //         }

  //     $id_usuario_login = $GLOBALS['db']->insert_id();
  //       if ($tipo_usuario == 1) {
  //         $nombres_correo = $userdata['given_name']." ".$userdata['family_name'];
  //         $escolaridad = Modelo_Escolaridad::obtieneListado();
  //         $dato_registro = array("telefono"=>"0000000000", "nombres"=>$userdata['given_name'], "apellidos"=>$userdata['family_name'], "fecha_nacimiento"=>$mayor_edad, "fecha_creacion"=>$campo_fecha, "token"=>$userdata['id'], "estado"=>0, "term_cond"=>1, "conf_datos"=>1, "id_ciudad"=>$default_city['id_ciudad'], "ultima_sesion"=>$campo_fecha, "id_nacionalidad"=>1, "tipo_doc"=>0, "status_carrera"=>1, "id_escolaridad"=>$escolaridad[0]['id_escolaridad'], "genero"=>"M", "id_usuario_login"=>$id_usuario_login, "tipo_usuario"=>$tipo_usuario);
  //       }

  //       if(!Modelo_Usuario::crearUsuario($dato_registro)){
  //           throw new Exception("Ha ocurrido un error, intente nuevamente");
  //       }
  //       $user_id = $GLOBALS['db']->insert_id();

  //       $GLOBALS['db']->commit();

  //       $token = Utils::generarToken($user_id,"ACTIVACION");
  //           if (empty($token)){
  //             throw new Exception("Error en el sistema, por favor intente de nuevo");
  //           }

  //         $token .= "||".$user_id."||".$tipo_usuario."||".date("Y-m-d H:i:s");
  //         $token = Utils::encriptar($token);
  //         if (!$this->credencialSocial($usuario_login['correo'], $nombres_correo, $username, $usuario_login['password'], $token)){
  //             throw new Exception("Error al enviar credenciales. Intente nuevamente");
  //           }
          
  //         $_SESSION['registro'] = 1;
  //   } catch (Exception $e) {
  //       $GLOBALS['db']->rollback();
  //       $_SESSION['mostrar_error'] = $e->getMessage();
  //   }
    
  //   Utils::doRedirect(PUERTO.'://'.HOST.'/');
  // }

  // public function linkedin($userdata, $tipo_usuario){
  //   $nombres_correo = "";
  //   $default_city = Modelo_Sucursal::obtieneCiudadDefault();
  //   $campo_fecha = date("Y-m-d H:i:s");
  //   $mayor_edad = date("Y-m-d H:i:s",strtotime($campo_fecha."- 18 year"));
  //   try {
  //     $datocorreo = Modelo_Usuario::existeCorreo($userdata['emailAddress']);
  //       if (empty($datocorreo)){
  //         throw new Exception("El correo asociado a la cuenta de LinkedIn con la que desea registrarse ya se encuentra en nuestros registros.");
  //       }
  //     $apell_user = Utils::no_carac(explode(" ", strtolower($userdata['lastName'])));
  //     $nombre_user = Utils::no_carac(explode(" ", strtolower($userdata['firstName'])));
  //     $username = $nombre_user[0].$apell_user[0];
  //     $username = self::generarUsername(strtolower($username));
  //     $GLOBALS['db']->beginTrans();
  //     $password = Utils::generarPassword();
  //     $usuario_login = array("tipo_usuario"=>$tipo_usuario, "username"=>$username, "password"=>$password, "correo"=>$userdata['emailAddress'], "dni"=>0);
  //         if(!Modelo_UsuarioLogin::crearUsuarioLogin($usuario_login)){
  //           throw new Exception("Ha ocurrido un error, intente nuevamente 1");
  //         }
  //     $id_usuario_login = $GLOBALS['db']->insert_id();
  //       if ($tipo_usuario == 1) {
  //         $nombres_correo = $userdata['firstName']." ".$userdata['lastName'];
  //         $escolaridad = Modelo_Escolaridad::obtieneListado();
  //         $dato_registro = array("telefono"=>"0000000000", "nombres"=>$userdata['firstName'], "apellidos"=>$userdata['lastName'], "fecha_nacimiento"=>$mayor_edad, "fecha_creacion"=>$campo_fecha, "token"=>$userdata['id'], "estado"=>0, "term_cond"=>1, "conf_datos"=>1, "id_ciudad"=>$default_city['id_ciudad'], "ultima_sesion"=>$campo_fecha, "id_nacionalidad"=>1, "tipo_doc"=>0, "status_carrera"=>1, "id_escolaridad"=>$escolaridad[0]['id_escolaridad'], "genero"=>"M", "id_usuario_login"=>$id_usuario_login, "tipo_usuario"=>$tipo_usuario);
  //       }
  //       if(!Modelo_Usuario::crearUsuario($dato_registro)){
  //           throw new Exception("Ha ocurrido un error, intente nuevamente 2");
  //           Utils::log("eder");
  //       }
  //       $user_id = $GLOBALS['db']->insert_id();
  //       $GLOBALS['db']->commit();
  //       $token = Utils::generarToken($user_id,"ACTIVACION");
  //           if (empty($token)){
  //             throw new Exception("Error en el sistema, por favor intente de nuevo");
  //           }
  //         $token .= "||".$user_id."||".$tipo_usuario."||".date("Y-m-d H:i:s");
  //         $token = Utils::encriptar($token);
  //         if (!$this->credencialSocial($usuario_login['correo'], $nombres_correo, $username, $usuario_login['password'], $token)){
  //             throw new Exception("Error al enviar credenciales. Intente nuevamente");
  //           }
          
  //           $_SESSION['registro'] = 1;
      
  //   } catch (Exception $e) {
  //       $GLOBALS['db']->rollback();
  //       $_SESSION['mostrar_error'] = $e->getMessage();
  //   }
  //   // produccion
  
  //   unset($_SESSION['OAUTH_ACCESS_TOKEN']);
    
  //   Utils::doRedirect(PUERTO.'://'.HOST.'/');
  // }

  // public function twitter($userdata, $tipo_usuario){
  //   $nombres_correo = "";
  //   $default_city = Modelo_Sucursal::obtieneCiudadDefault();
  //   $campo_fecha = date("Y-m-d H:i:s");
  //   $mayor_edad = date("Y-m-d H:i:s",strtotime($campo_fecha."- 18 year"));
  //   try {
  //     $datocorreo = Modelo_Usuario::existeCorreo($userdata["email"]);
  //       if (empty($datocorreo)){
  //         throw new Exception("El correo asociado a la cuenta de Twitter con la que desea registrarse ya se encuentra en nuestros registros.");
  //       }
  //     $apell_user = Utils::no_carac(explode(" ", strtolower($userdata['screen_name'])));
  //     $nombre_user = Utils::no_carac(explode(" ", strtolower($userdata['screen_name'])));
  //     $username = $nombre_user[0].$apell_user[0];
  //     $username = self::generarUsername(strtolower($username));
  //     $GLOBALS['db']->beginTrans();
  //     $password = Utils::generarPassword();
  //     $usuario_login = array("tipo_usuario"=>$tipo_usuario, "username"=>$username, "password"=>$password, "correo"=>strtolower($userdata['email']), "dni"=>0);
  //         if(!Modelo_UsuarioLogin::crearUsuarioLogin($usuario_login)){
  //           throw new Exception("Ha ocurrido un error, intente nuevamente");
  //         }
  //     $id_usuario_login = $GLOBALS['db']->insert_id();
  //       if ($tipo_usuario == 1) {
  //         $nombres_correo = $userdata['screen_name']." ".$userdata['screen_name'];
  //         $escolaridad = Modelo_Escolaridad::obtieneListado();
  //         $dato_registro = array("telefono"=>"0000000000", "nombres"=>$userdata['screen_name'], "apellidos"=>$userdata['screen_name'], "fecha_nacimiento"=>$mayor_edad, "fecha_creacion"=>$campo_fecha, "token"=>$userdata['id'], "estado"=>0, "term_cond"=>1, "conf_datos"=>1, "id_ciudad"=>$default_city['id_ciudad'], "ultima_sesion"=>$campo_fecha, "id_nacionalidad"=>1, "tipo_doc"=>0, "status_carrera"=>1, "id_escolaridad"=>$escolaridad[0]['id_escolaridad'], "genero"=>"M", "id_usuario_login"=>$id_usuario_login, "tipo_usuario"=>$tipo_usuario);
  //       }
  //       if(!Modelo_Usuario::crearUsuario($dato_registro)){
  //           throw new Exception("Ha ocurrido un error, intente nuevamente  ");
  //       }
  //       $user_id = $GLOBALS['db']->insert_id();
  //       $GLOBALS['db']->commit();
  //       $token = Utils::generarToken($user_id,"ACTIVACION");
  //           if (empty($token)){
  //             throw new Exception("Error en el sistema, por favor intente de nuevo");
  //           }
  //         $token .= "||".$user_id."||".$tipo_usuario."||".date("Y-m-d H:i:s");
  //         $token = Utils::encriptar($token);
  //         if (!$this->credencialSocial($usuario_login['correo'], $nombres_correo, $username, $usuario_login['password'], $token)){
  //             throw new Exception("Error al enviar credenciales. Intente nuevamente");
  //           }
          
  //         $_SESSION['registro'] = 1;
  //   } catch (Exception $e) {
  //       $GLOBALS['db']->rollback();
  //       $_SESSION['mostrar_error'] = $e->getMessage();
  //   }
    
  //   Utils::doRedirect(PUERTO.'://'.HOST.'/');
  // }

  // public function generarUsername($name){
  //   $count = 0;
  //   $username = ($name);
  //   $username_generated = $username;
  //     do{
  //       if($count != 0){
  //         $username_generated = $username.$count;
  //       }
  //       $count++;
  //     }
  //   while(!empty(Modelo_Usuario::existeUsuario($username_generated)));
  //   return $username_generated;
  // }

  // public function correoActivacionCuenta($correo,$nombres,$token, $username){
  //   $asunto = "Activación de cuenta";
  //   $body = "Estimado, ".$nombres."<br>";
  //   $body .= "<br>Una vez activada su cuenta puede ingresar mediante su correo electrónico o el siguiente Usuario: <br><b>".$username."</b><br><br>";
  //   $body .= "Click en este enlace para activar su cuenta de usuario&nbsp;";
  //   $body .= "<a href='".PUERTO."://".HOST."/registro/".$token."/'>click aqui</a> <br>";
  //   if (Utils::envioCorreo($correo,$asunto,$body)){
  //     return true;
  //   }
  //   else{
  //     return false;
  //   }
  // }

  // public function credencialSocial($correo,$nombres,$username, $password, $token){
  //   $asunto = "Credenciales de cuenta";
  //   $body = "Estimado, ".$nombres.",<br><br>";
  //   $body .= "Se ha registrado correctamente, de click en este <a href='".PUERTO."://".HOST."/registro/".$token."/'>enlace</a> para activar su cuenta e ingresar al sistema con los siguientes datos.<br><br>";
  //   $body .= "Correo electrónico: <b>".$correo."</b><br>";
  //   $body .= "Usuario: <b>".$username."</b><br>";
  //   $body .= "Contraseña: <b>".$password."</b><br><br>";    
  //   $body .= "Recuerde no entregar sus credenciales de acceso.</b>";
  //   if (Utils::envioCorreo($correo,$asunto,$body)){
  //     return true;
  //   }
  //   else{
  //     return false;
  //   }
  // }
}
?>
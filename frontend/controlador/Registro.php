<?php 
class Controlador_Registro extends Controlador_Base {
  function __construct(){
    global $_SUBMIT;
    $this->data = $_SUBMIT;
  }

  public function construirPagina(){
    if( Modelo_Usuario::estaLogueado() ){
      Utils::doRedirect(PUERTO.'://'.HOST.'/perfil/');
    }

    $opcion = Utils::getParam('opcion','',$this->data);  
    switch($opcion){      
      case 'activacion':
        $this->validarToken();
      break;     
      default:
        $this->validateCampos();
      break;
    } 
  }

  public function validarToken(){
    $tags = array();
    try{            
      $respuesta = Utils::getParam('token', '', false);
      if (empty($respuesta)){
        throw new Exception("La activacion de la cuenta es fallida, por favor intente de nuevo");
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
            throw new Exception("El enlace para recuperacion es incorrecto, por favor ingrese denuevo su correo para el envio");      
          }

          if(!Modelo_Usuario::activarCuenta($idusuario, $tipousuario)){
            throw new Exception("Ha ocurrido un error al activar la cuenta, intente nuevamente");
          }
          $_SESSION['mostrar_exito'] = "Su cuenta se ha activado correctamente";
          $this->redirectToController('login');
        }
      catch( Exception $e ){
        $_SESSION['mostrar_error'] = $e->getMessage(); 
        Utils::doRedirect(PUERTO.'://'.HOST.'/');
      }        
    }


  public function validateCampos(){    
    $iso = SUCURSAL_ISO;

    if ( Utils::getParam('register_form') == 1 ){
      try{
        if ($_POST['tipo_usuario'] == 1) {
          $campos = array('correo'=>1,'name_user'=>1,'apell_user'=>1,'password'=>1, 'password_two'=>1,'numero_cand'=>1,'cedula'=>1, 'tipo_doc'=>1,'term_cond'=>1,'conf_datos'=>1, 'tipo_usuario'=>1, 'area_select'=>1,'nivel_interes'=>1);        
        }

        if ($_POST['tipo_usuario'] == 2) {
          $campos = array('correo'=>1, 'name_user'=>1,'password'=>1, 'password_two'=>1,'numero_cand'=>1,'cedula'=>1,'ruc'=>1,'term_cond'=>1,'conf_datos'=>1, 'tipo_usuario'=>1, "nombre_contact"=>1, "apellido_contact"=>1, "tel_one_contact"=>1, "tel_two_contact"=>0);          
        }

        $data = $this->camposRequeridos($campos);

        $datocorreo = Modelo_Usuario::existeCorreo($data["correo"]);
        if (empty($datocorreo)){
          throw new Exception("El correo ".$data["correo"]." ya existe");
        }

        $datodni = Modelo_Usuario::existeDni($data["cedula"]);
        if (empty($datodni)){
          throw new Exception("El dni ".$data["cedula"]." ya existe");
        }

        if ($data["password"] != $data["password_two"]){
          throw new Exception("Contraseña y confirmación de contraseña no coinciden");
        }

        $passwordValido = Utils::valida_password($data["password"]);
        if ($passwordValido == false){
          throw new Exception("Ingrese una contraseña con el formato especificado");
        }
        $nombres = Utils::no_carac(explode(" ", strtolower($data['name_user'])));
        $username = $nombres;
        // if(count($nombres)>1){
        //   $username = $nombres[0];
        // }

        if ($_POST['tipo_usuario'] == 1) {
          $apell_user = Utils::no_carac(explode(" ", strtolower($data['apell_user'])));
          $username = $username[0].$apell_user[0];
          if($_POST['tipo_doc'] == 2){ 
            if (method_exists(new Utils, 'validar_'.$iso)) {
                $function = 'validar_'.$iso;
                $validaCedula = Utils::$function($data['cedula']);
                  if ($validaCedula == false){
                    throw new Exception("El DNI ingresado no es válido");
                  }
                }
              }
            }else{
              $username = $username[0];
              if (method_exists(new Utils, 'validar_'.$iso)) {
                $function = 'validar_'.$iso;
                $validaCedula = Utils::$function($data['cedula']);
                  if ($validaCedula == false){
                    throw new Exception("El DNI ingresado no es válido");
                  }
                }
              }

        $correoValido = Utils::es_correo_valido($data["correo"]);
        if ($correoValido == false){
          throw new Exception("Ingrese un correo válido");
        }

        $username = Utils::no_carac(html_entity_decode($username));
        
        $username_generated = Utils::generarUsername($username);
        // Utils::log("eend: ".$username_generated);

        $GLOBALS['db']->beginTrans();

        self::guardarUsuario($data, $username_generated);
                
      }
      catch( Exception $e ){
        $GLOBALS['db']->rollback();
        $_SESSION['mostrar_error'] = $e->getMessage();  
      }
      
      Utils::doRedirect(PUERTO.'://'.HOST.'/');
    }    

  }

  public function guardarUsuario($data, $username_generated){
    $nombres_correo = "";
    $default_city = Modelo_Sucursal::obtieneCiudadDefault();
    $campo_fecha = date("Y-m-d H:i:s");
    $mayor_edad = date("Y-m-d H:i:s",strtotime($campo_fecha."- 18 year"));

    $usuario_login = array('tipo_usuario'=>$data['tipo_usuario'], 'username'=>$username_generated, 'password'=>$data['password'], 'correo'=>$data['correo'], 'dni'=>$data['cedula']);

    if(!Modelo_UsuarioLogin::crearUsuarioLogin($usuario_login)){
      throw new Exception("Ha ocurrido un error, intente nuevamente");
    }

    $id_usuario_login = $GLOBALS['db']->insert_id();

    if($data['tipo_usuario'] == 1){
      $escolaridad = Modelo_Escolaridad::obtieneListado();
      $nombres_correo = $data['name_user']." ".$data['apell_user'];
      $dato_registro = array('telefono'=>$data['numero_cand'], 'nombres'=>$data['name_user'], 'apellidos'=>$data['apell_user'], 'fecha_nacimiento'=>$mayor_edad, 'fecha_creacion'=>$campo_fecha, "token"=>NULL, 'estado'=>0, 'term_cond'=>$data['term_cond'], 'conf_datos'=>$data['conf_datos'], 'id_ciudad'=>$default_city['id_ciudad'], 'ultima_sesion'=>$campo_fecha, 'id_nacionalidad'=>SUCURSAL_PAISID, 'tipo_doc'=>$data['tipo_doc'], 'status_carrera'=>1, 'id_escolaridad'=>$escolaridad[0]['id_escolaridad'] , 'genero'=>'M', 'id_usuario_login'=>$id_usuario_login, 'tipo_usuario'=>$data['tipo_usuario'], "estado"=>0);
    }
    else{
      $nombres_correo = $data['name_user'];
      $dato_registro = array('telefono'=>$data['numero_cand'], 'nombres'=>$data['name_user'], 'fecha_nacimiento'=>$campo_fecha, 'fecha_creacion'=>$mayor_edad, 'term_cond'=>$data['term_cond'], 'conf_datos'=>$data['conf_datos'], 'id_ciudad'=>$default_city['id_ciudad'], 'ultima_sesion'=>$campo_fecha, 'id_nacionalidad'=>SUCURSAL_PAISID, 'id_usuario_login'=>$id_usuario_login, 'tipo_usuario'=>$data['tipo_usuario'],"estado"=>0);
    }
        if(!Modelo_Usuario::crearUsuario($dato_registro)){
            throw new Exception("Ha ocurrido un error, intente nuevamente");
        }
                
        $user_id = $GLOBALS['db']->insert_id();

          if ($data['tipo_usuario'] == 1) {
            $area_select = $data['area_select'];
            $nivel_interes = $data['nivel_interes'];

                  if(!Modelo_UsuarioxArea::crearUsuarioArea($area_select, $user_id)){
                      throw new Exception("Ha ocurrido un error, intente nuevamente");
                  }

                  if(!Modelo_UsuarioxNivel::crearUsuarioNivel($nivel_interes, $user_id)){
                      throw new Exception("Ha ocurrido un error, intente nuevamente");
                  }
                }
                else{
                  $dato_contacto = array('nombres'=>$data['nombre_contact'], 'apellidos'=>$data['apellido_contact'], 'telefono1'=>$data['tel_one_contact'], 'telefono2'=>$data['tel_two_contact']);
                  if(!Modelo_ContactoEmpresa::crearContactoEmpresa($dato_contacto, $user_id)){
                    throw new Exception("Ha ocurrido un error el registrar, intente nuevamente");
                  }
                }

                $GLOBALS['db']->commit();

                $token = Utils::generarToken($user_id,"ACTIVACION");
                  if (empty($token)){
                    throw new Exception("Error en el sistema, por favor intente de nuevo");
                  }

                $token .= "||".$user_id."||".$data['tipo_usuario']."||".date("Y-m-d H:i:s");
                $token = Utils::encriptar($token);
                if (!$this->correoActivacionCuenta($data['correo'], $nombres_correo,$token, $usuario_login['username'])){
                    throw new Exception("Error en el envio de correo, por favor intente denuevo");
                  }
                $_SESSION['mostrar_exito'] = "Te has registrado correctamente. Revisa tu cuenta de correo o bandeja de spam y haz clic en el enlace para activar tu cuenta";
                Utils::doRedirect(PUERTO."://".HOST."/");
  }

  public function facebook($userdata, $tipo_usuario){
    $nombres_correo = "";
    $default_city = Modelo_Sucursal::obtieneCiudadDefault();
    $campo_fecha = date("Y-m-d H:i:s");
    $mayor_edad = date("Y-m-d H:i:s",strtotime($campo_fecha."- 18 year"));
  
    try {
      $datocorreo = Modelo_Usuario::existeCorreo($userdata["email"]);
        if (empty($datocorreo)){
          throw new Exception("La cuenta ya consta en nuestros registros. Revise su cuenta de correo para activarla.");
        }

    $apell_user = Utils::no_carac(explode(" ", strtolower($userdata['last_name'])));
    $nombre_user = Utils::no_carac(explode(" ", strtolower($userdata['first_name'])));
    $username = $nombre_user[0].$apell_user[0];
      $username = Utils::generarUsername(strtolower($username));

      $GLOBALS['db']->beginTrans();

      $password = Utils::generarPassword();
      $usuario_login = array("tipo_usuario"=>$tipo_usuario, "username"=>$username, "password"=>$password, "correo"=>$userdata['email'], "dni"=>0);
          if(!Modelo_UsuarioLogin::crearUsuarioLogin($usuario_login)){
            throw new Exception("Ha ocurrido un error, intente nuevamente");
          }

      $id_usuario_login = $GLOBALS['db']->insert_id();
        if ($tipo_usuario == 1) {
          $nombres_correo = $userdata['first_name']." ".$userdata['last_name'];
          $escolaridad = Modelo_Escolaridad::obtieneListado();
          $dato_registro = array("telefono"=>"0000000000", "nombres"=>$userdata['first_name'], "apellidos"=>$userdata['last_name'], "fecha_nacimiento"=>$mayor_edad, "fecha_creacion"=>$campo_fecha, "token"=>$userdata['id'], "estado"=>0, "term_cond"=>1, "conf_datos"=>1, "id_ciudad"=>$default_city['id_ciudad'], "ultima_sesion"=>$campo_fecha, "id_nacionalidad"=>1, "tipo_doc"=>2, "status_carrera"=>1, "id_escolaridad"=>$escolaridad[0]['id_escolaridad'], "genero"=>"M", "id_usuario_login"=>$id_usuario_login, "tipo_usuario"=>$tipo_usuario);
        }


        if(!Modelo_Usuario::crearUsuario($dato_registro)){
            throw new Exception("Ha ocurrido un error, intente nuevamente");
        }
        
        $user_id = $GLOBALS['db']->insert_id();

      $GLOBALS['db']->commit();
      
            $token = Utils::generarToken($user_id,"ACTIVACION");
            if (empty($token)){
              throw new Exception("Error en el sistema, por favor intente de nuevo");
            }

          $token .= "||".$user_id."||".$tipo_usuario."||".date("Y-m-d H:i:s");
          $token = Utils::encriptar($token);

          if (!$this->credencialSocial($usuario_login['correo'], $nombres_correo, $username, $usuario_login['password'], $token)){
              throw new Exception("Error al enviar credenciales. Intente nuevamente");
            }
          $_SESSION['mostrar_exito'] = "Te has registrado correctamente. Revisa tu cuenta de correo o bandeja de spam";
    }
      catch( Exception $e ){
        $GLOBALS['db']->rollback();
        $_SESSION['mostrar_error'] = $e->getMessage();  
      }
     Utils::doRedirect(PUERTO.'://'.HOST.'/');
  }

  public function google($userdata, $tipo_usuario){
    $nombres_correo = "";
    $default_city = Modelo_Sucursal::obtieneCiudadDefault();
    $campo_fecha = date("Y-m-d H:i:s");
    $mayor_edad = date("Y-m-d H:i:s",strtotime($campo_fecha."- 18 year"));

    try {
      $datocorreo = Modelo_Usuario::existeCorreo($userdata["email"]);
        if (empty($datocorreo)){
          throw new Exception("El correo asociado a la cuenta de Google con la que desea registrarse ya se encuentra en nuestros registros.");
        }

      $apell_user = Utils::no_carac(explode(" ", strtolower($userdata['family_name'])));
      $nombre_user = Utils::no_carac(explode(" ", strtolower($userdata['given_name'])));
      $username = $nombre_user[0].$apell_user[0];

      $username = Utils::generarUsername(strtolower($username));

      $GLOBALS['db']->beginTrans();

      $password = Utils::generarPassword();
      $usuario_login = array("tipo_usuario"=>$tipo_usuario, "username"=>$username, "password"=>$password, "correo"=>$userdata['email'], "dni"=>0);
          if(!Modelo_UsuarioLogin::crearUsuarioLogin($usuario_login)){
            throw new Exception("Ha ocurrido un error, intente nuevamente");
          }

      $id_usuario_login = $GLOBALS['db']->insert_id();
        if ($tipo_usuario == 1) {
          $nombres_correo = $userdata['given_name']." ".$userdata['family_name'];
          $escolaridad = Modelo_Escolaridad::obtieneListado();
          $dato_registro = array("telefono"=>"0000000000", "nombres"=>$userdata['given_name'], "apellidos"=>$userdata['family_name'], "fecha_nacimiento"=>$mayor_edad, "fecha_creacion"=>$campo_fecha, "token"=>$userdata['id'], "estado"=>0, "term_cond"=>1, "conf_datos"=>1, "id_ciudad"=>$default_city['id_ciudad'], "ultima_sesion"=>$campo_fecha, "id_nacionalidad"=>1, "tipo_doc"=>2, "status_carrera"=>1, "id_escolaridad"=>$escolaridad[0]['id_escolaridad'], "genero"=>"M", "id_usuario_login"=>$id_usuario_login, "tipo_usuario"=>$tipo_usuario);
        }

        if(!Modelo_Usuario::crearUsuario($dato_registro)){
            throw new Exception("Ha ocurrido un error, intente nuevamente");
        }
        $user_id = $GLOBALS['db']->insert_id();

        $GLOBALS['db']->commit();

        $token = Utils::generarToken($user_id,"ACTIVACION");
            if (empty($token)){
              throw new Exception("Error en el sistema, por favor intente de nuevo");
            }

          $token .= "||".$user_id."||".$tipo_usuario."||".date("Y-m-d H:i:s");
          $token = Utils::encriptar($token);
          if (!$this->credencialSocial($usuario_login['correo'], $nombres_correo, $username, $usuario_login['password'], $token)){
              throw new Exception("Error al enviar credenciales. Intente nuevamente");
            }
          $_SESSION['mostrar_exito'] = "Te has registrado correctamente. Revisa tu cuenta de correo o bandeja de spam y haz clic en el enlace para activar tu cuenta";
      
    } catch (Exception $e) {
        $GLOBALS['db']->rollback();
        $_SESSION['mostrar_error'] = $e->getMessage();
    }
    Utils::doRedirect(PUERTO.'://'.HOST.'/');
  }

  public function linkedin($userdata, $tipo_usuario){
    print_r("");
    // print_r($userdata);exit();
    $nombres_correo = "";
    $default_city = Modelo_Sucursal::obtieneCiudadDefault();
    $campo_fecha = date("Y-m-d H:i:s");
    $mayor_edad = date("Y-m-d H:i:s",strtotime($campo_fecha."- 18 year"));
    try {
      $datocorreo = Modelo_Usuario::existeCorreo($userdata['emailAddress']);
        if (empty($datocorreo)){
          throw new Exception("El correo asociado a la cuenta de LinkedIn con la que desea registrarse ya se encuentra en nuestros registros.");
        }
      $apell_user = Utils::no_carac(explode(" ", strtolower($userdata['lastName'])));
      $nombre_user = Utils::no_carac(explode(" ", strtolower($userdata['firstName'])));
      $username = $nombre_user[0].$apell_user[0];
      $username = self::generarUsername(strtolower($username));
      $GLOBALS['db']->beginTrans();
      $password = Utils::generarPassword();
      $usuario_login = array("tipo_usuario"=>$tipo_usuario, "username"=>$username, "password"=>$password, "correo"=>$userdata['emailAddress'], "dni"=>0);
          if(!Modelo_UsuarioLogin::crearUsuarioLogin($usuario_login)){
            throw new Exception("Ha ocurrido un error, intente nuevamente 1");
          }
      $id_usuario_login = $GLOBALS['db']->insert_id();
        if ($tipo_usuario == 1) {
          $nombres_correo = $userdata['firstName']." ".$userdata['lastName'];
          $escolaridad = Modelo_Escolaridad::obtieneListado();
          $dato_registro = array("telefono"=>"0000000000", "nombres"=>$userdata['firstName'], "apellidos"=>$userdata['lastName'], "fecha_nacimiento"=>$mayor_edad, "fecha_creacion"=>$campo_fecha, "token"=>$userdata['id'], "estado"=>0, "term_cond"=>1, "conf_datos"=>1, "id_ciudad"=>$default_city['id_ciudad'], "ultima_sesion"=>$campo_fecha, "id_nacionalidad"=>1, "tipo_doc"=>2, "status_carrera"=>1, "id_escolaridad"=>$escolaridad[0]['id_escolaridad'], "genero"=>"M", "id_usuario_login"=>$id_usuario_login, "tipo_usuario"=>$tipo_usuario);
        }
        if(!Modelo_Usuario::crearUsuario($dato_registro)){
            throw new Exception("Ha ocurrido un error, intente nuevamente 2");
        }
        $user_id = $GLOBALS['db']->insert_id();
        $GLOBALS['db']->commit();
        $token = Utils::generarToken($user_id,"ACTIVACION");
            if (empty($token)){
              throw new Exception("Error en el sistema, por favor intente de nuevo");
            }
          $token .= "||".$user_id."||".$tipo_usuario."||".date("Y-m-d H:i:s");
          $token = Utils::encriptar($token);
          if (!$this->credencialSocial($usuario_login['correo'], $nombres_correo, $username, $usuario_login['password'], $token)){
              throw new Exception("Error al enviar credenciales. Intente nuevamente");
            }
          $_SESSION['mostrar_exito'] = "Te has registrado correctamente. Revisa tu cuenta de correo o bandeja de spam y haz clic en el enlace para activar tu cuenta";
      
    } catch (Exception $e) {
        $GLOBALS['db']->rollback();
        $_SESSION['mostrar_error'] = $e->getMessage();
    }
    // produccion
    Utils::doRedirect(PUERTO.'://'.HOST.'/');
    // local
    // Utils::doRedirect('http://localhost/repos_micamello/');
  }

  public function twitter($userdata, $tipo_usuario){
    $nombres_correo = "";
    $default_city = Modelo_Sucursal::obtieneCiudadDefault();
    $campo_fecha = date("Y-m-d H:i:s");
    $mayor_edad = date("Y-m-d H:i:s",strtotime($campo_fecha."- 18 year"));
    try {
      $datocorreo = Modelo_Usuario::existeCorreo($userdata["email"]);
        if (empty($datocorreo)){
          throw new Exception("El correo asociado a la cuenta de Twitter con la que desea registrarse ya se encuentra en nuestros registros.");
        }
      $apell_user = Utils::no_carac(explode(" ", strtolower($userdata['screen_name'])));
      $nombre_user = Utils::no_carac(explode(" ", strtolower($userdata['screen_name'])));
      $username = $nombre_user[0].$apell_user[0];
      $username = self::generarUsername(strtolower($username));
      $GLOBALS['db']->beginTrans();
      $password = Utils::generarPassword();
      $usuario_login = array("tipo_usuario"=>$tipo_usuario, "username"=>$username, "password"=>$password, "correo"=>strtolower($userdata['email']), "dni"=>0);
          if(!Modelo_UsuarioLogin::crearUsuarioLogin($usuario_login)){
            throw new Exception("Ha ocurrido un error, intente nuevamente");
          }
      $id_usuario_login = $GLOBALS['db']->insert_id();
        if ($tipo_usuario == 1) {
          $nombres_correo = $userdata['screen_name']." ".$userdata['screen_name'];
          $escolaridad = Modelo_Escolaridad::obtieneListado();
          $dato_registro = array("telefono"=>"0000000000", "nombres"=>$userdata['screen_name'], "apellidos"=>$userdata['screen_name'], "fecha_nacimiento"=>$mayor_edad, "fecha_creacion"=>$campo_fecha, "token"=>$userdata['id'], "estado"=>0, "term_cond"=>1, "conf_datos"=>1, "id_ciudad"=>$default_city['id_ciudad'], "ultima_sesion"=>$campo_fecha, "id_nacionalidad"=>1, "tipo_doc"=>2, "status_carrera"=>1, "id_escolaridad"=>$escolaridad[0]['id_escolaridad'], "genero"=>"M", "id_usuario_login"=>$id_usuario_login, "tipo_usuario"=>$tipo_usuario);
        }
        if(!Modelo_Usuario::crearUsuario($dato_registro)){
            throw new Exception("Ha ocurrido un error, intente nuevamente  ");
        }
        $user_id = $GLOBALS['db']->insert_id();
        $GLOBALS['db']->commit();
        $token = Utils::generarToken($user_id,"ACTIVACION");
            if (empty($token)){
              throw new Exception("Error en el sistema, por favor intente de nuevo");
            }
          $token .= "||".$user_id."||".$tipo_usuario."||".date("Y-m-d H:i:s");
          $token = Utils::encriptar($token);
          if (!$this->credencialSocial($usuario_login['correo'], $nombres_correo, $username, $usuario_login['password'], $token)){
              throw new Exception("Error al enviar credenciales. Intente nuevamente");
            }
          $_SESSION['mostrar_exito'] = "Te has registrado correctamente. Revisa tu cuenta de correo o bandeja de spam y haz clic en el enlace para activar tu cuenta";
      
    } catch (Exception $e) {
        $GLOBALS['db']->rollback();
        $_SESSION['mostrar_error'] = $e->getMessage();
    }
    Utils::doRedirect(PUERTO.'://'.HOST.'/');
  }

  public function generarUsername($name){
    $count = 0;
    $username = ($name);
    $username_generated = $username;
      do{
        if($count != 0){
          $username_generated = $username.$count;
        }
        $count++;
      }
    while(!empty(Modelo_Usuario::existeUsuario($username_generated)));
    return $username_generated;
  }

  public function correoActivacionCuenta($correo,$nombres,$token, $username){
    $asunto = "Activación de cuenta";
    $body = "Estimado, ".$nombres."<br>";
    $body .= "<br>Una vez activada su cuenta puede ingresar mediante su correo electrónico o el siguiente username: <br><b>".$username."</b><br><br>";
    $body .= "Click en este enlace para activar su cuenta de usuario&nbsp;";
    $body .= "<a href='".PUERTO."://".HOST."/registro/".$token."/'>click aqui</a> <br>";
    if (Utils::envioCorreo($correo,$asunto,$body)){
      return true;
    }
    else{
      return false;
    }
  }

  public function credencialSocial($correo,$nombres,$username, $password, $token){
    $asunto = "Credenciales de cuenta mi camello";
    $body = "Estimado, ".$nombres."<br>";
    $body .= "Te has registrado correctamente, haz click en el enlace de abajo para activar tu cuenta y luego podrás acc";
    $body .="acc a tu mediante tu correo electrónico:  <b>".$correo."</b> ó username:  <b>".$username."</b> y tu contraseña: <b>".$password."</b><br><br><br>";
    $body .= "<a href='".PUERTO."://".HOST."/registro/".$token."/'>click aqui</a> <br>";
    $body .= "<br>Recuerda no entregar tus credenciales de acceso.</b><br><br>";
    if (Utils::envioCorreo($correo,$asunto,$body)){
      return true;
    }
    else{
      return false;
    }
  }
}
?>
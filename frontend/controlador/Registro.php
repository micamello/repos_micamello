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
        throw new Exception("La activacion de la cuenta es fallida, por favor intente denuevo");
      }  
        $tags["token"] = $respuesta;              
        $respuesta = Utils::desencriptar($respuesta);     
        $valores = explode("||",$respuesta);      
        $token = $valores[0];
        $idusuario = $valores[1];
        $fecha = $valores[2];
        $token_valido = Utils::generarToken($idusuario,"ACTIVACION");
        
          if($token_valido != $token){
            throw new Exception("El enlace para recuperacion es incorrecto, por favor ingrese denuevo su correo para el envio");      
          }

          if(!Modelo_Usuario::activarCuenta($idusuario)){
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
          $campos = array('correo'=>1,'name_user'=>1,'apell_user'=>1,'password'=>1, 'password_two'=>1,'numero_cand'=>1,'cedula'=>1,'term_cond'=>1,'conf_datos'=>1, 'tipo_usuario'=>1, 'area_select'=>1,'nivel_interes'=>1);          
        }

        if ($_POST['tipo_usuario'] == 2) {
          $campos = array('correo'=>1, 'name_user'=>1,'password'=>1, 'password_two'=>1,'numero_cand'=>1,'cedula'=>1,'term_cond'=>1,'conf_datos'=>1, 'tipo_usuario'=>1, "nombre_contact"=>1, "apellido_contact"=>1, "tel_one_contact"=>1, "tel_two_contact"=>0);          
        }

        $data = $this->camposRequeridos($campos);

        // $datousername = Modelo_Usuario::existeUsuario($data["username"]);
        // if (!empty($datousername)){
        //   throw new Exception("El usuario ".$data["username"]." ya existe");
        // }
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

        if (method_exists(new Utils, 'validar_'.$iso)) {
            $function = 'validar_'.$iso;
            // Utils::log("eder: ".$data['cedula']);
            $validaCedula = Utils::$function($data['cedula']);
            // Utils::log("eder: ".$validaCedula); exit;
              if ($validaCedula == false){
                throw new Exception("El DNI ingresado no es válido ruc");
              }
          }
          else
          {
            $validaCedula = Utils::valida_telefono($data['cedula']);
            if ($validaCedula == false){
                throw new Exception("El DNI ingresado no es válido"); 
                }   
          }

        $correoValido = Utils::es_correo_valido($data["correo"]);
        if ($correoValido == false){
          throw new Exception("Ingrese un correo válido");
        }

        do{
          $username = Utils::generarUsername($data['correo']);
          $datousername = Modelo_Usuario::existeUsuario($username);
        }
        while (!empty($datousername));

        $GLOBALS['db']->beginTrans();

        self::guardarUsuario($data, $username);
                
      }
      catch( Exception $e ){
        $GLOBALS['db']->rollback();
        $_SESSION['mostrar_error'] = $e->getMessage();  
      }
      
      Utils::doRedirect(PUERTO.'://'.HOST.'/');
    }    

  }

  public function guardarUsuario($data, $username){
    $default_city = Modelo_Sucursal::obtieneCiudadDefault();
    $campo_fecha = date("Y-m-d H:i:s");
    $defaultDataUser = array('fecha_nacimiento'=>$campo_fecha, 'fecha_creacion'=>$campo_fecha, 'token'=>0, 'estado'=>0, 'id_ciudad'=>$default_city['id_ciudad'], 'ultima_sesion'=>$campo_fecha);

                if(!Modelo_Usuario::crearUsuario($data, $defaultDataUser, $username)){
                    throw new Exception("Ha ocurrido un error, intente nuevamente");
                }

                $user_id = $GLOBALS['db']->insert_id();

                if ($data['tipo_usuario'] == 1) {
                  
                  $escolaridad = Modelo_Escolaridad::obtieneListado();
                  $universidad = Modelo_Universidad::obtieneListado(SUCURSAL_PAISID);
                  $apellidos = $data['apell_user'];

                  $area_select = $data['area_select'];
                  $nivel_interes = $data['nivel_interes'];

                  $requisitos = array('id_usuario'=>$user_id, 'estado_civil'=>1, 'anosexp'=>1, 'status_carrera'=>1, 'id_escolaridad'=>$escolaridad[0]['id_escolaridad'], 'genero'=>'M', 'apellidos'=>$apellidos);

                  //Utils::log("datos de requisitos: ".print_r($requisitos, true));

                  if(!Modelo_RequisitoxUsuario::crearRequisitoUsuario($requisitos)){
                    throw new Exception("Ha ocurrido un error el registrar los requisitos, intente nuevamente");
                  }

                  if(!Modelo_UsuarioxArea::crearUsuarioArea($area_select, $user_id)){
                      throw new Exception("Ha ocurrido un error, intente nuevamente");
                  }

                  if(!Modelo_UsuarioxNivel::crearUsuarioNivel($nivel_interes, $user_id)){
                      throw new Exception("Ha ocurrido un error, intente nuevamente");
                  }
                }
                else{
                  if(!Modelo_ContactoEmpresa::crearContactoEmpresa($data, $user_id)){
                    throw new Exception("Ha ocurrido un error el registrar los requisitos, intente nuevamente");
                  }
                }

                $GLOBALS['db']->commit();

                $token = Utils::generarToken($user_id,"ACTIVACION");
                  if (empty($token)){
                    throw new Exception("Error en el sistema, por favor intente de nuevo");
                  }

                $token .= "||".$user_id."||".date("Y-m-d H:i:s");
                $token = Utils::encriptar($token);
                if (!$this->correoActivacionCuenta($data['correo'],$data['name_user'].' '.$data['apell_user'],$token, $username)){
                    throw new Exception("Error en el envio de correo, por favor intente denuevo");
                  }
                $_SESSION['mostrar_exito'] = "Te has registrado correctamente. Revisa tu cuenta de correo o bandeja de spam y haz clic en el enlace para activar tu cuenta";
  }

  public function correoActivacionCuenta($correo,$nombres,$token, $username){
    $asunto = "Activación de cuenta";
    $body = "Estimado, ".$nombres."<br>";
    $body .= "<br>Una vez activada su cuenta puede ingresar mediante su correo electrónico o el siguiente username: <br><b>".$username."</b><br><br>";
    $body .= "Click en este enlace para activar su cuenta de usuario";
    $body .= "<a href='".PUERTO."://".HOST."/registro/".$token."/'>click aqui</a> <br>";
    if (Utils::envioCorreo($correo,$asunto,$body)){
      return true;
    }
    else{
      return false;
    }
  }
}
?>
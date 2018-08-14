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
      default:
        $this->validateCampos();
      break;
    }   
  }


  public function validateCampos(){
    if ( Utils::getParam('register_form') == 1 ){
      try{

        $campos = array('username'=>1, 'correo'=>1, 'name_user'=>1, 'apell_user'=>1, 'password'=>1, 'numero_cand'=>1, 'cedula'=>1, 'term_cond'=>1, 'term_data'=>1);
        $area_select = array('area_select'=>$_POST['area_select']);
        $nivel_interes = array('nivel_interes'=>$_POST['nivel_interes']);

        $data = $this->camposRequeridos($campos);

        Utils::log(print_r($data, true));
        Utils::log(print_r($area_select, true));
        Utils::log(print_r($nivel_interes, true));

        $datousername = Modelo_Usuario::existeUsuario($data["username"]);
        if (empty($datousername)){
          throw new Exception("El usuario ".$data["username"]." ya existe");
        }
        $datocorreo = Modelo_Usuario::existeCorreo($data["correo"]);
        if (empty($datocorreo)){
          throw new Exception("El correo".$datousername." ya existe");
        }
        $datodni = Modelo_Usuario::existeDni($data["numero_cand"]);
        if (empty($datodni)){
          throw new Exception("El dni".$datousername." ya existe");
        }
        // Validaciones PHP servidor

        $passwordValido = Utils::valida_password($data["password"]);
        if ($passwordValido == false){
          throw new Exception("Ingrese una contraseña con el formato especificado");
        }

        $correoValido = Utils::es_correo_valido($data["correo"]);
        if ($correoValido == false){
          throw new Exception("Ingrese un correo válido");
        }
        // Validaciones PHP servidor


          self::guardarUsuario($data);
          Utils::doRedirect(PUERTO.'://'.HOST.'/');
          
      }
      catch( Exception $e ){
        $_SESSION['mostrar_error'] = $e->getMessage();  
        Utils::doRedirect(PUERTO.'://'.HOST.'/');    
      }
    } 

    
    $tags["template_js"][] = "validator";
    $tags["template_js"][] = "ruc_jquery_validator";

    Vista::render('inicio', $tags);
  }

  public function guardarUsuario($data){
    $insertUsuario =  Modelo_Usuario::crearUsuario($data);
  }
}
?>
<?php
abstract class Controlador_Base{
  
  protected $ajax_enabled;
  protected $device;
  protected $data;

  public $loginURL;
  public $gg_URL;
  public $tw;
  public $lk;
  public $nrofactura;
  
  function __construct($device='web'){
    global $_SUBMIT;
    $this->device = $device;
    $this->data = $_SUBMIT;        
    self::verificaCompra();    
  }
  
  public function redirectToController($controladorNombre, $params = array()){  
    Utils::doRedirect(PUERTO.'://'.HOST.'/'.$controladorNombre.'/');
  }
  
  public function camposRequeridos($campos = array()){
    $data = array();     
    if (count($campos) > 0){ 
      foreach($campos as $campo=>$requerido){        
        $valor = Utils::getParam($campo,'',$this->data);
        if (is_array($valor)){
          if (count($valor)<=0 && $requerido == 1){
            throw new Exception("Los campos marcado con asterisco son obligatorios");
          }         
          foreach($valor as $key=>$val){
            $val = strip_tags($val);
            $val = str_replace("\r\n","<br>",$val);
            //$val = htmlentities($val,ENT_QUOTES,'UTF-8');
            $data[$campo][$key] = $val;
          }          
        }
        else{
          $valor = trim($valor);
          if ($valor == "" && $requerido == 1){                    
            throw new Exception("Los campos marcado con asterisco son obligatorios");
          }
          $valor = strip_tags($valor);
          $valor = str_replace("\r\n","<br>",$valor);
          //$valor = htmlentities($valor,ENT_QUOTES,'UTF-8');
          $data[$campo] = $valor;
        }        
      } 
    }
    return $data;
  }
  
  public function verificaCompra(){    
    if (isset($_SESSION['mfo_datos']['actualizar_planes']) && $_SESSION['mfo_datos']['actualizar_planes'] == 1){      
      $arrplanes = Modelo_UsuarioxPlan::planesActivos($_SESSION["mfo_datos"]["usuario"]["id_usuario"],
                                                      $_SESSION["mfo_datos"]["usuario"]["tipo_usuario"]);
      if (count($_SESSION['mfo_datos']['planes']) <> count($arrplanes)){
        $_SESSION['mfo_datos']['planes'] = $arrplanes;
        unset($_SESSION['mfo_datos']['actualizar_planes']);       
      }      
    }
  }

  public function linkRedesSociales(){
    //if( strstr(dirname(__FILE__), 'C:') ){        
      $this->loginURL = ''; $this->gg_URL = ''; $this->lk = ''; $this->tw = '';
    //}
    /*else{
      // FACEBOOK
      require_once "includes/fb_api/config.php";
      $redirectURL = PUERTO."://".HOST."/desarrollov2/facebook.php?tipo_user=1";
      //$redirectURL = "https://www.micamello.com.ec/desarrollov2/facebook.php?tipo_user=1";
      $permissions = ['email'];
      $this->loginURL = $helper->getLoginUrl($redirectURL, $permissions);

      // GOOGLE
      require_once "includes/gg_api/config.php";
      $this->gg_URL = $gClient->createAuthUrl();

      // LINKEDIN
      $this->lk = "linkedin.php?tipo_usuario=1";

      // TWITTER
      require_once "includes/tw_api/config.php";
      $this->tw = $connection->url("oauth/authorize", array('oauth_token' => $request_token['oauth_token']));
    }*/ 
  }

  public abstract function construirPagina();
  
}
?>
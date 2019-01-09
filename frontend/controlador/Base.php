<?php
abstract class Controlador_Base{
  
  protected $ajax_enabled;
  protected $device;
  protected $datos;
  protected $data;
  
  function __construct($device='web'){
    global $_SUBMIT;
    $this->device = $device;
    $this->datos = $_SUBMIT;    
    $this->data = $_SUBMIT;    
    self::verificaCompra();
  }
  
  public function redirectToController($controladorNombre, $params = array()){  
    Utils::doRedirect(PUERTO.'://'.HOST.'/'.$controladorNombre.'/');
  }
  
  public function camposRequeridos($campos = array()){
    $data = array(); 
    //print_r($this->datos);
    if (count($campos) > 0){ 
      foreach($campos as $campo=>$requerido){        
        $valor = Utils::getParam($campo,'',$this->datos);
        if (is_array($valor)){
          if (count($valor)<=0 && $requerido == 1){
            throw new Exception("Los campos marcado con asterisco son obligatorios");
          }         
          foreach($valor as $key=>$val){
            $val = strip_tags($val);
            $val = str_replace("\r\n","<br>",$val);
            $val = htmlentities($val,ENT_QUOTES,'UTF-8');
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
          $valor = htmlentities($valor,ENT_QUOTES,'UTF-8');
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

  public abstract function construirPagina();
  
}
?>
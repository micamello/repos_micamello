<?php
abstract class Controlador_Base{
  
  protected $ajax_enabled;
  protected $device;
  protected $datos;
  
  function __construct($device='web'){
    global $_SUBMIT;
    $this->device = $device;
    $this->datos = $_SUBMIT;
    
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
            throw new Exception(" El campo ".$campo." debe ser obligatorio");
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
          if (empty($valor) && $requerido == 1){                    
            throw new Exception(" El campo ".$campo." debe ser obligatorio");
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
  
  public abstract function construirPagina();
  
}
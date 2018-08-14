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
    Utils::doRedirect('http://'.HOST.'/'.$controladorNombre.'/');
  }
  
  public function camposRequeridos($campos = array()){
    $data = array(); 
    if (count($campos) > 0){ 
      foreach($campos as $campo=>$requerido){
        $valor = trim(Utils::getParam($campo,'',$this->datos));           
        if (empty($valor) && $requerido == 1){                    
          throw new Exception(" El campo ".$campo." debe ser obligatorio");
        }
        $valor = strip_tags($valor);
        $valor = str_replace("\r\n","<br>",$valor);
        $valor = htmlentities($valor,ENT_QUOTES,'UTF-8');
        $data[$campo] = $valor;
      } 
    }
    return $data;
  }
  
  

  public abstract function construirPagina();
  
}

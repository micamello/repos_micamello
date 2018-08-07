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
  
  public function obtenerMenu(){
    $menu = array();
    if( !Modelo_Usuario::estaLogueado() ){
      $menu["menu"][] = array("href"=>PUERTO."://".HOST."/", "nombre"=>"Inicio");
      $menu["menu"][] = array("href"=>"#", "onclick"=>"hidden_menuuser_small();", "nombre"=>"Candidato", "modal"=>"myModal");
      $menu["menu"][] = array("href"=>"#", "onclick"=>"hidden_menuuser_small();", "nombre"=>"Empresa", "modal"=>"myModal2");
    }
    else{
      $menu["menu"][] = array("href"=>PUERTO."://".HOST."/", "nombre"=>"Inicio"); 
      if ($_SESSION['mfo_datos']['usuario']['rol'] == Modelo_Usuario::CANDIDATO){        
        $menu["menu"][] = array("href"=>PUERTO."://".HOST."/empleos/", "nombre"=>"Empleos");
        $menu["menu"][] = array("href"=>PUERTO."://".HOST."/postulaciones/", "nombre"=>"Mis Postulaciones");
      }
      else{
        $menu["menu"][] = array("href"=>PUERTO."://".HOST."/publicar/", "nombre"=>"Publicar Vacantes");
        $menu["menu"][] = array("href"=>PUERTO."://".HOST."/vacantes/", "nombre"=>"Mis Vacantes");
      }
      $menu["submenu"][] = array("href"=>PUERTO."://".HOST."/facturas/", "nombre"=>"Mis Facturas");
      $menu["submenu"][] = array("href"=>PUERTO."://".HOST."/perfil/", "nombre"=>"Mi Perfil"); 
      if ($_SESSION['mfo_datos']['usuario']['rol'] == Modelo_Usuario::EMPRESA){        
        $menu["submenu"][] = array("href"=>PUERTO."://".HOST."/planes/", "nombre"=>"Mis Planes");
      }
      $menu["submenu"][] = array("href"=>PUERTO."://".HOST."/configuracion/", "nombre"=>"Configuración");
      $menu["submenu"][] = array("href"=>PUERTO."://".HOST."/logout/", "nombre"=>"Cerrar Sesión");
    }
    Utils::log("menu ".print_r($menu,true));
    return $menu;
  }

  public abstract function construirPagina();
  
}

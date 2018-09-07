<?php
class Vista {
  
  public static function render($pagina, $template_vars = array(),$cabecera='cabecera', $piepagina='piepagina'){
    if (!empty($template_vars))
        extract($template_vars);
      
    $sess_err_msg = self::obtieneMsgError();
    $sess_suc_msg = self::obtieneMsgExito();
    $menu = self::obtieneMenu();
    if( !$sess_err_msg ){
      $sess_err_msg = '';
    }
    if (!$sess_suc_msg){
      $sess_suc_msg = '';
    } 
    ob_start();

    if (!empty ($cabecera)){      
      require RUTA_VISTA . "html/". $cabecera . '.php';
    }

    $ruta = RUTA_VISTA . "html/". $pagina . '.php';
    if( file_exists($ruta) ){
        require $ruta;       
    }    
    else{
        echo 'Esta pagina no existe : '. $pagina;  
    }
    if (!empty($piepagina)){
      require RUTA_VISTA . "html/" . $piepagina . '.php';
    }    
    ob_end_flush();
  }

  public static function display($pagina, $template_vars = array()){    
    if (!empty($template_vars))
        extract($template_vars);
    
    ob_start();

    $ruta = RUTA_VISTA . "html/". $pagina . '.php';
    if( file_exists($ruta) ){
        require $ruta;       
    }    
    else{
        echo 'Esta pagina no existe : '. $pagina;  
    }
        
    $to_return = ob_get_clean();
    return $to_return;
  }
  
  private static function obtieneMsgError(){
    $msg = "";
    if( isset($_SESSION['mostrar_error']) && !empty($_SESSION['mostrar_error']) ){
      $msg = $_SESSION['mostrar_error'];
      $msg = str_replace (array("\r\n", "\n", "\r"), '', $msg);
      $msg = htmlentities($msg, ENT_QUOTES, 'UTF-8');
      unset($_SESSION['mostrar_error']);
    }
    return $msg;
  }
  
  private static function obtieneMsgExito(){
    $msg = "";
    if( isset($_SESSION['mostrar_exito']) && !empty($_SESSION['mostrar_exito']) ){
      $msg = $_SESSION['mostrar_exito'];
      $msg = str_replace (array("\r\n", "\n", "\r"), '', $msg);
      $msg = htmlentities($msg, ENT_QUOTES, 'UTF-8');
      unset($_SESSION['mostrar_exito']);
    }
    return $msg;
  }  

  private static function obtieneMenu(){
    $menu = array();
    if( !Modelo_Usuario::estaLogueado() ){
      $menu["menu"][] = array("href"=>PUERTO."://".HOST."/", "nombre"=>"Inicio");
      $menu["menu"][] = array("href"=>"#", "onclick"=>"modal_set(1);", "nombre"=>"Candidato");
      $menu["menu"][] = array("href"=>"#", "onclick"=>"modal_set(2);", "nombre"=>"Empresa");
      $menu["menu"][] = array("href"=>PUERTO."://".HOST."/login/", "nombre"=>"Iniciar sesi&oacute;n");
    }
    else{
      $menu["menu"][] = array("href"=>PUERTO."://".HOST."/", "nombre"=>"Inicio"); 
      if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO){        
        $menu["menu"][] = array("href"=>PUERTO."://".HOST."/oferta/", "nombre"=>"Empleos");
        $menu["menu"][] = array("href"=>PUERTO."://".HOST."/postulacion/", "nombre"=>"Mis Postulaciones");
      }
      else{
        $menu["menu"][] = array("href"=>PUERTO."://".HOST."/publicar/", "nombre"=>"Publicar Vacantes");
        $menu["menu"][] = array("href"=>PUERTO."://".HOST."/vacantes/", "nombre"=>"Mis Vacantes");
      }
      $menu["submenu"][] = array("href"=>PUERTO."://".HOST."/planesUsuario/", "nombre"=>"Mis Planes");
      $menu["submenu"][] = array("href"=>PUERTO."://".HOST."/perfil/", "nombre"=>"Mi Perfil"); 
      $menu["submenu"][] = array("href"=>PUERTO."://".HOST."/logout/", "nombre"=>"Cerrar Sesión");
    }
    return $menu;
  }

  public static function renderJSON($template_vars=array()){
    array_walk_recursive($template_vars, function(&$item){
          $item = utf8_encode($item); 
    });
    echo json_encode($template_vars);
  }

}
?>
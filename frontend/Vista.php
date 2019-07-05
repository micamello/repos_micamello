<?php
class Vista {
  
  public static function render($pagina, $template_vars = array(),$cabecera='cabecera', $piepagina='piepagina',$deshabilitarmenu=''){
    if (!empty($template_vars))
        extract($template_vars);
      
    $sess_err_msg = self::obtieneMsgError();
    $sess_suc_msg = self::obtieneMsgExito();
    $sess_not_msg = self::obtieneMsgNotif();
    $menu = self::obtieneMenu($deshabilitarmenu);
    if( !$sess_err_msg ){
      $sess_err_msg = '';
    }
    if (!$sess_suc_msg){
      $sess_suc_msg = '';
    } 
    if (!$sess_not_msg){
      $sess_not_msg = '';
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
    if(file_exists($ruta) ){
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

  private static function obtieneMsgNotif(){
    $msg = "";    
    if( isset($_SESSION['mostrar_notif']) && !empty($_SESSION['mostrar_notif']) ){
      $msg = $_SESSION['mostrar_notif'];
      $msg = str_replace (array("\r\n", "\n", "\r"), '', $msg);
      $msg = htmlentities($msg, ENT_QUOTES, 'UTF-8');
      unset($_SESSION['mostrar_notif']);
    }
    return $msg;
  }  

  private static function obtieneMenu($deshabilitarmenu){
    $menu = array();
    if( !Modelo_Usuario::estaLogueado() ){
      $menu["menu"][] = array("href"=>PUERTO."://".HOST."/", "nombre"=>"Inicio");
      //$menu["menu"][] = array("href"=>"#", "id"=>"regEmpMic", "nombre"=>"Registro Empresa");
      $menu["menu"][] = array("href"=>PUERTO."://".HOST."/login/", "nombre"=>"Ingresar");
      $menu["menu"][] = array("href"=>PUERTO."://".HOST."/registro/", "id"=>"regCandMic", "nombre"=>"Reg&iacute;strate");
    }
    else{      
      $menu["menu"][] = array("href"=>($deshabilitarmenu) ? "javascript:void(0);" : PUERTO."://".HOST."/", "nombre"=>"Inicio","vista"=>"inicio"); 
      if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO){           
        $menu["menu"][] = array("href"=>($deshabilitarmenu) ? "javascript:void(0);" : PUERTO."://".HOST."/oferta/", "nombre"=>"Empleos", "vista"=>"oferta");
        $menu["menu"][] = array("href"=>($deshabilitarmenu) ? "javascript:void(0);" : PUERTO."://".HOST."/postulacion/", "nombre"=>"Mis Postulaciones", "vista"=>"postulacion");
      }
      else{
        $menu["menu"][] = array("href"=>($deshabilitarmenu) ? "javascript:void(0);" : PUERTO."://".HOST."/publicar/", "nombre"=>"Publicar Ofertas", "vista"=>"publicar");
        $menu["menu"][] = array("href"=>($deshabilitarmenu) ? "javascript:void(0);" : PUERTO."://".HOST."/vacantes/", "nombre"=>"Mis Ofertas", "vista"=>"vacantes");   

        /*if (isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'buscarCandidatos')){
            $menu["menu"][] = array("href"=>($deshabilitarmenu) ? "javascript:void(0);" : PUERTO."://".HOST."/verAspirantes/2/0/1/", "nombre"=>"Buscar Candidatos");
        }else{
          $menu["menu"][] = array("onclick"=>($deshabilitarmenu) ? "javascript:void(0);" : 'redireccionar(\''.PUERTO."://".HOST."/planes/".'\')', "nombre"=>"Buscar Candidatos");
        }*/
      }
      if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA){
        if(isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'adminEmpresas') && Modelo_UsuarioxPlan::planCuentaPropio($_SESSION['mfo_datos']['usuario']['id_usuario'])){
          $menu["submenu_cuentas"][] = array("href"=>($deshabilitarmenu) ? "javascript:void(0);" : PUERTO."://".HOST."/adminEmpresas/", "nombre"=>"Cuentas","vista"=>"adminEmpresas");

          if(isset($_SESSION['mfo_datos']['subempresas'])){
            $menu["submenu_cuentas"][] = array("href"=>($deshabilitarmenu) ? "javascript:void(0);" : PUERTO."://".HOST."/cuentas/", "nombre"=>"Ofertas - Subcuentas","vista"=>"cuentas");
          }
        }
      }
      /*if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA){
        $menu["menu"][] = array("href"=>($deshabilitarmenu) ? "javascript:void(0);" : PUERTO."://".HOST."/planes_empresa/", "nombre"=>"Planes");
      }else{*/
        $menu["menu"][] = array("href"=>($deshabilitarmenu) ? "javascript:void(0);" : PUERTO."://".HOST."/planes/", "nombre"=>"Planes" ,"vista"=>"planes");
      /*}*/

      $menu["submenu"][] = array("href"=>($deshabilitarmenu) ? "javascript:void(0);" : PUERTO."://".HOST."/perfil/", "nombre"=>"Mi Perfil"); 
      $menu["submenu"][] = array("href"=>($deshabilitarmenu) ? "javascript:void(0);" : PUERTO."://".HOST."/planesUsuario/", "nombre"=>"Mis Planes");
      
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
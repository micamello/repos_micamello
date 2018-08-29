<?php
class Controlador_Plan extends Controlador_Base {
  
  function __construct(){
    global $_SUBMIT;
    $this->data = $_SUBMIT;
  }
  
  public function construirPagina(){
    if( !Modelo_Usuario::estaLogueado() ){
      Utils::doRedirect(PUERTO.'://'.HOST.'/login/');
    }
    
    $opcion = Utils::getParam('opcion', '', $this->data);
    switch ($opcion) {
      case 'planes_usuario':

        $desactivarPlan = Utils::getParam('desactivarPlan', '', $this->data);

        if(!empty($desactivarPlan)){
            $r = Modelo_UsuarioxPlan::desactivarPlan($desactivarPlan);
            if(!$r){
                $_SESSION['mostrar_error'] = 'No se pudo eliminar la suscripción, intentelo de nuevo';
            }else{
                $_SESSION['mostrar_exito'] = 'Se ha eliminado la afiliación del plan exitosamente';
            }
            Utils::doRedirect(PUERTO.'://'.HOST.'/planesUsuario/');
        }

        //Obtiene todos los banner activos segun el tipo
        $arrbanner = Modelo_Banner::obtieneListado(Modelo_Banner::BANNER_PERFIL);

        $orden                      = rand(1, count($arrbanner)) - 1;
        $_SESSION['mostrar_banner'] = PUERTO . '://' . HOST . '/imagenes/banner/' . $arrbanner[$orden]['id_banner'] . '.' . $arrbanner[$orden]['extension'];

        $idUsuario = $_SESSION["mfo_datos"]["usuario"]["id_usuario"];
        $planUsuario = Modelo_Plan::listadoPlanesUsuario($idUsuario);

        $tags = self::mostrarPlanes();
        $tags["show_banner"] = 1;
        $tags["planUsuario"] = $planUsuario;

        Vista::render('planes_usuario',$tags); 
      break;

      default:
      
        $tags = self::mostrarPlanes();

        Vista::render('planes', $tags); 
      break;
    }   
  }

  public function mostrarPlanes(){

    $tipousu = $_SESSION["mfo_datos"]["usuario"]["tipo_usuario"];
    $sucursal = $_SESSION["mfo_datos"]["sucursal"]["id_sucursal"]; 
    
    $planes = Modelo_Plan::listadoPlanAccion($tipousu,$sucursal,Modelo_Plan::PAQUETE);
    $avisos = Modelo_Plan::listadoPlanAccion($tipousu,$sucursal,Modelo_Plan::AVISO); 

    $tags['planes'] = trim(Vista::display('detalle_plan',array('arreglo'=>$planes)));    
    $tags['avisos'] = trim(Vista::display('detalle_plan',array('arreglo'=>$avisos)));

    $arrbanner = Modelo_Banner::obtieneListado(Modelo_Banner::BANNER_CANDIDATO);
    $orden = rand(1,count($arrbanner))-1;
    $_SESSION['mostrar_banner'] = PUERTO.'://'.HOST.'/imagenes/banner/'.$arrbanner[$orden]['id_banner'].'.'.$arrbanner[$orden]['extension'];
    $tags["show_banner"] = 1;
    
    $tags["template_css"][] = "planes";
    $tags["template_js"][] = "planes";

    return $tags;
  }
}  
?>
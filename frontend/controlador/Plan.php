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
    
    $opcion = Utils::getParam('opcion','',$this->data);  
    switch($opcion){      
      case 'compra':
        $this->compra();
      break;     
      case 'desposito':
        $this->deposito();
      break; 
      default:
        $this->mostrarDefault();
      break;
    }   
    
  }

  public function mostrarDefault(){
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

    Vista::render('planes', $tags);      
  }

  public function compra(){
    $idplan = Utils::getParam('idplan','',$this->data);
    try{ 
      if (empty($idplan)){
        throw new Exception("Debe seleccionar un plan para la compra");
      }
      
      $idusu = $_SESSION["mfo_datos"]["usuario"]["id_usuario"];
      $tipousu = $_SESSION["mfo_datos"]["usuario"]["tipo_usuario"];
      $sucursal = $_SESSION["mfo_datos"]["sucursal"]["id_sucursal"]; 

      $tipoplan = ($tipousu == Modelo_Usuario::CANDIDATO) ? Modelo_Plan::CANDIDATO : Modelo_Plan::EMPRESA;
      $infoplan = Modelo_Plan::busquedaActivoxTipo($idplan,$tipoplan,$sucursal);
      if (!isset($infoplan["id_plan"]) || empty($infoplan["id_plan"])){
        throw new Exception("El plan seleccionado no esta activo o no esta disponible");
      }
      if (empty($infoplan["costo"])){        
        if ($this->existePlan($infoplan["id_plan"])){
          throw new Exception("Ya esta subscrito al plan seleccionado");   
        }
        if (!Modelo_UsuarioxPlan::guardarPlan($idusu,$infoplan["id_plan"],$infoplan["num_post"],$infoplan["duracion"])){
          throw new Exception("Error al registrar la subscripción, por favor intente denuevo");   
        }
        $_SESSION['mfo_datos']['planes'] = Modelo_UsuarioxPlan::planesActivos($idusu);
        $_SESSION['mostrar_exito'] = "Subcripción exitosa, ahora puede cargar su hoja de vida"; 
        $this->redirectToController('editarperfil');
      }
      else{
        //presenta metodos de pago
        $arrbanner = Modelo_Banner::obtieneListado(Modelo_Banner::BANNER_CANDIDATO);
        $orden = rand(1,count($arrbanner))-1;
        $_SESSION['mostrar_banner'] = PUERTO.'://'.HOST.'/imagenes/banner/'.$arrbanner[$orden]['id_banner'].'.'.$arrbanner[$orden]['extension'];
        $tags["show_banner"] = 1;
        $tags["plan"] = $infoplan;

        $tags["template_js"][] = "validator";
        $tags["template_js"][] = "mic";
        $tags["template_js"][] = "metodospago";

        Vista::render('metodos_pago', $tags);      
      }
      
    }
    catch( Exception $e ){
      $_SESSION['mostrar_error'] = $e->getMessage();  
      $this->redirectToController('planes');
    } 
  }

  public function existePlan($idplan){
    if (isset($_SESSION['mfo_datos']['planes'])){
      foreach($_SESSION['mfo_datos']['planes'] as $planactivo){
        if ($planactivo["id_plan"] == $idplan){
          return true;
        }
      }
    }
    return false;
  }

  public function deposito(){
    
  }
}  
?>
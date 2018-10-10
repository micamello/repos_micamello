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
    $breadcrumbs = array();
    $opcion = Utils::getParam('opcion','',$this->data);      
    switch($opcion){      
      case 'compra':
        $this->compra();
      break;     
      case 'deposito':
        $this->deposito();
      break; 
      case 'paypal':
        $this->paypal();
      break;
      case 'planes_usuario':
        $this->planesUsuario();
      break;
      default:        
        $this->mostrarDefault(1);
      break;
    }   
  }

  public function planesUsuario(){
    $breadcrumbs['planesUsuario'] = 'Mis planes';
    $desactivarPlan = Utils::getParam('desactivarPlan', '', $this->data);

    if(!empty($desactivarPlan)){

        $id_usuario = $_SESSION["mfo_datos"]["usuario"]["id_usuario"];
        $aspirantes = Modelo_UsuarioxPlan::obtenerAspiranteSegunPlanContratado($id_usuario,$desactivarPlan);

        if($aspirantes['aspirantes'] == 0){
          $r = Modelo_UsuarioxPlan::desactivarPlan($desactivarPlan);
          if(!$r){
              $_SESSION['mostrar_error'] = 'No se pudo eliminar la suscripción, intentelo de nuevo';
          }else{
              $_SESSION['mostrar_exito'] = 'Se ha eliminado la afiliación del plan exitosamente';
          }
        }else{
          $_SESSION['mostrar_error'] = 'No se puede eliminar la suscripción, ya existen postulados';
        }
        Utils::doRedirect(PUERTO.'://'.HOST.'/planesUsuario/');
    }

    //Obtiene todos los banner activos segun el tipo
    $arrbanner = Modelo_Banner::obtieneAleatorio(Modelo_Banner::BANNER_PERFIL);    
    $_SESSION['mostrar_banner'] = PUERTO . '://' . HOST . '/imagenes/banner/' . $arrbanner['id_banner'] . '.' . $arrbanner['extension'];

    $idUsuario = $_SESSION["mfo_datos"]["usuario"]["id_usuario"];
    $planUsuario = Modelo_Plan::listadoPlanesUsuario($idUsuario);

    $tags = self::mostrarDefault(2);    
    $tags["show_banner"] = 1;
    $tags["planUsuario"] = $planUsuario;
    $tags['breadcrumbs'] = $breadcrumbs;

    Vista::render('planes_usuario',$tags); 
  }

  public function mostrarDefault($tipo){
    $tipousu = $_SESSION["mfo_datos"]["usuario"]["tipo_usuario"];
    $sucursal = SUCURSAL_ID; 
    
    if ($tipousu == Modelo_Usuario::CANDIDATO){
      $tags['planes'] = Modelo_Plan::busquedaPlanes(Modelo_Usuario::CANDIDATO,$sucursal);       
    }
    else{
      $tags['gratuitos'] = Modelo_Plan::busquedaPlanes(Modelo_Usuario::EMPRESA,$sucursal,1);
      $tags['planes'] = Modelo_Plan::busquedaPlanes(Modelo_Usuario::EMPRESA,$sucursal,2,Modelo_Plan::PAQUETE);
      $tags['avisos'] = Modelo_Plan::busquedaPlanes(Modelo_Usuario::EMPRESA,$sucursal,2,Modelo_Plan::AVISO);
    }    

    $arrbanner = Modelo_Banner::obtieneAleatorio(Modelo_Banner::BANNER_CANDIDATO);    
    $_SESSION['mostrar_banner'] = PUERTO.'://'.HOST.'/imagenes/banner/'.$arrbanner['id_banner'].'.'.$arrbanner['extension'];
    $tags["show_banner"] = 1;
    
    $tags["template_css"][] = "planes";
    $tags["template_js"][] = "planes";

    $render = ($tipousu == Modelo_usuario::CANDIDATO) ? "planes_candidato" : "planes_empresa";          

    if($tipo == 1){    
      Vista::render($render, $tags); 
    }else{            
      $tags['html'] = Vista::display($render, $tags);    
      return $tags;
    }
  }

  public function compra(){    
    $idplan = Utils::getParam('idplan','',$this->data);
    try{ 
      if (empty($idplan)){
        throw new Exception("Debe seleccionar un plan para la compra");
      }
      
      $idusu = $_SESSION["mfo_datos"]["usuario"]["id_usuario"];
      $tipousu = $_SESSION["mfo_datos"]["usuario"]["tipo_usuario"];
      $sucursal = SUCURSAL_ID; 
      $tipoplan = ($tipousu == Modelo_Usuario::CANDIDATO) ? Modelo_Plan::CANDIDATO : Modelo_Plan::EMPRESA;
      $infoplan = Modelo_Plan::busquedaActivoxTipo($idplan,$tipoplan,$sucursal);
      if (!isset($infoplan["id_plan"]) || empty($infoplan["id_plan"])){
        throw new Exception("El plan seleccionado no esta activo o no esta disponible");
      }
      if (empty($infoplan["costo"])){        
        if ($this->existePlan($infoplan["id_plan"])){
          throw new Exception("Ya esta subscrito al plan seleccionado");   
        }

        if (Modelo_UsuarioxPlan::existePlan($idusu,$infoplan["id_plan"])){
          if (!Modelo_UsuarioxPlan::modificarPlan($idusu,$infoplan["id_plan"],$infoplan["num_post"],$infoplan["duracion"])){
            throw new Exception("Error al registrar la subscripción, por favor intente denuevo");   
          }
        }
        else{
          if (!Modelo_UsuarioxPlan::guardarPlan($idusu,$infoplan["id_plan"],$infoplan["num_post"],$infoplan["duracion"])){
            throw new Exception("Error al registrar la subscripción, por favor intente denuevo");   
          }  
        }   
        
        $_SESSION['mfo_datos']['planes'] = Modelo_UsuarioxPlan::planesActivos($idusu);

        if ($tipousu == Modelo_Usuario::CANDIDATO){
          $_SESSION['mostrar_exito'] = "Subcripción exitosa, ahora puede postular a una oferta"; 
          $this->redirectToController('oferta');
        }
        else{
          $_SESSION['mostrar_exito'] = "Subcripción exitosa, ahora puede publicar una oferta"; 
          $this->redirectToController('publicar');
        }
      }
      else{
        //presenta metodos de pago
        $arrbanner = Modelo_Banner::obtieneAleatorio(Modelo_Banner::BANNER_CANDIDATO);        
        $_SESSION['mostrar_banner'] = PUERTO.'://'.HOST.'/imagenes/banner/'.$arrbanner['id_banner'].'.'.$arrbanner['extension'];
        $tags["show_banner"] = 1;
        $tags["plan"] = $infoplan;

        $provincia = Modelo_Provincia::obtieneProvincia($_SESSION['mfo_datos']['usuario']['id_ciudad']);
        $tags["provincia"] = $provincia["id_provincia"];
        $tags["arrprovincia"] = Modelo_Provincia::obtieneListado();
        $tags["arrciudad"] = Modelo_Ciudad::obtieneCiudadxProvincia($provincia['id_provincia']);                
        $tags["ctabancaria"] = Modelo_Ctabancaria::obtieneListado();          

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
    try{
      $campos = array('idplan'=>1,'num_comprobante'=>1,'valor'=>1,'nombre'=>1,'correo'=>1,'direccion'=>1,'provincia'=>1,'ciudad'=>1,'telefono'=>1,'dni'=>1);
      $data = $this->camposRequeridos($campos);   
      
      if (!Utils::alfanumerico($data["num_comprobante"])){
        throw new Exception("Número de comprobante no es válido");
      }
      if (!Utils::formatoDinero($data["valor"])){
        throw new Exception("Valor del comprobante no es válido");
      }
      if (!Utils::es_correo_valido($data["correo"])){
        throw new Exception("Dirección de correo electrónico no es válido");
      }
      if (!Utils::valida_telefono($data["telefono"])){
        throw new Exception("Número de teléfono no es válido");
      }
      //agregar validacion para dni
      if (!Utils::long_minima($data["dni"],10)){
        throw new Exception("Cédula/Ruc no es válido");
      }
      if(!isset($_FILES['imagen'])){
        throw new Exception("Debe subir una imagen con formato jpg o png y menor a 1 MB");         
      } 
      if (!Utils::valida_upload($_FILES['imagen'], 3)) {
        throw new Exception("La imagen debe ser en formato .jpg .jpeg .png y con un peso máximo de 1MB");
      }
      
      $archivo = Utils::validaExt($_FILES['imagen'],3);
      if (!Modelo_Comprobante::guardarComprobante($data["num_comprobante"],$data["nombre"],$data["correo"],$data["telefono"],
                                                  $data["dni"],$data["ciudad"],Modelo_Comprobante::METODO_DEPOSITO,$archivo[1],
                                                  $data["valor"],$_SESSION['mfo_datos']['usuario']['id_usuario'],$data["idplan"],
                                                  $data['direccion'])){
        throw new Exception("Error al ingresar el deposito, por favor intente denuevo");
      }

      $id_comprobante = $GLOBALS['db']->insert_id();

      if (!Utils::upload($_FILES['imagen'],$id_comprobante,PATH_COMPROBANTE,3)){
        throw new Exception("Error al cargar la imagen, por favor intente denuevo");
      }

      $_SESSION['mostrar_exito'] = "Ingreso de comprobante exitoso, su plan será aprobado en un máximo de 48 horas";  
      Utils::doRedirect(PUERTO.'://'.HOST.'/oferta/');
    }
    catch(Exception $e){
      $_SESSION['mostrar_error'] = $e->getMessage();            
      Utils::doRedirect(PUERTO.'://'.HOST.'/compraplan/'.$data["idplan"].'/');             
    }     
  }

  public function paypal(){
    $arrbanner = Modelo_Banner::obtieneAleatorio(Modelo_Banner::BANNER_CANDIDATO);    
    $_SESSION['mostrar_banner'] = PUERTO.'://'.HOST.'/imagenes/banner/'.$arrbanner['id_banner'].'.'.$arrbanner['extension'];
    $tags["show_banner"] = 1;
    unset($_SESSION['mfo_datos']['planes']);
    $_SESSION['mfo_datos']['planes'] = Modelo_UsuarioxPlan::planesActivos($_SESSION['mfo_datos']['usuario']['id_usuario']);
    Vista::render('mensaje_paypal', $tags);       
  }
}  
?>
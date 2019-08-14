<?php
class Controlador_Plan extends Controlador_Base {
   
  public function construirPagina(){        
    if( !Modelo_Usuario::estaLogueado() ){
      Utils::doRedirect(PUERTO.'://'.HOST.'/login/');
    }    
    if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO){
       Modelo_Usuario::validaPermisos($_SESSION['mfo_datos']['usuario']['tipo_usuario'],
                                      $_SESSION['mfo_datos']['usuario']['id_usuario'],
                                      (isset($_SESSION['mfo_datos']['usuario']['infohv']) ? $_SESSION['mfo_datos']['usuario']['infohv'] : null),
                                      (isset($_SESSION['mfo_datos']['planes']) ? $_SESSION['mfo_datos']['planes'] : null)); 
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
      case 'resultado':
        $this->resultado();
      break;
      case 'error':
        $this->error();
      break;
      case 'planes_usuario':
        $this->planesUsuario();
      break;
      case 'file':
        $this->crearFile();
      break;
      default:        
        $this->mostrarDefault(1);
      break;
    }   
  }
 
  public function planesUsuario(){
    $breadcrumbs['planesUsuario'] = 'Mis planes';
    /*$desactivarPlan = Utils::getParam('desactivarPlan', '', $this->data);
    if(!empty($desactivarPlan)){
        $id_usuario = $_SESSION["mfo_datos"]["usuario"]["id_usuario"];
        $aspirantes = Modelo_UsuarioxPlan::obtenerAspiranteSegunPlanContratado($id_usuario,$desactivarPlan);
        if($aspirantes['aspirantes'] == 0){
          $r = Modelo_UsuarioxPlan::desactivarPlan($desactivarPlan);
          if(!$r){
              $_SESSION['mostrar_error'] = 'No se pudo eliminar la suscripci\u00F3n, intentelo de nuevo';
          }else{
              $_SESSION['mostrar_exito'] = 'Se ha eliminado la afiliaci\u00F3n del plan exitosamente';
          }
        }else{
          $_SESSION['mostrar_error'] = 'No se puede eliminar la suscripci\u00F3n, ya existen postulados';
        }
        Utils::doRedirect(PUERTO.'://'.HOST.'/planesUsuario/');
    }*/    

    $idUsuario = $_SESSION["mfo_datos"]["usuario"]["id_usuario"];
    $planUsuario = Modelo_Plan::listadoPlanesUsuario($idUsuario,$_SESSION["mfo_datos"]["usuario"]["tipo_usuario"]);
    //$tags = self::mostrarDefault(2);        
    $tags["planUsuario"] = $planUsuario;
    $tags['breadcrumbs'] = $breadcrumbs;
    Vista::render('planes_usuario',$tags); 
  }
 
  public function mostrarDefault($tipo){
    $breadcrumbs['planes'] = 'Planes';
    $tipousu = $_SESSION["mfo_datos"]["usuario"]["tipo_usuario"];
    $sucursal = SUCURSAL_ID;           
    if ($tipousu == Modelo_Usuario::CANDIDATO){
      $tags['planes'] = Modelo_Plan::busquedaPlanes(Modelo_Usuario::CANDIDATO,$sucursal); 
      $planesUsuario = Modelo_Plan::listadoPlanesUsuario($_SESSION["mfo_datos"]["usuario"]["id_usuario"], Modelo_Usuario::CANDIDATO);
      foreach($planesUsuario as $planCosto):
        if($planCosto['costo'] > 0){break;}
        else{
          // id plan 11 autopostulacion
          foreach ($tags['planes'] as $key => $value) {
            if($value['id_plan'] == 11 && !next($planesUsuario)){
              unset($tags['planes'][$key]);
              break;
            }
          }
        }
      endforeach;  
    }
    else{
      $nivel = Modelo_Usuario::obtieneNivel($_SESSION["mfo_datos"]["usuario"]["padre"]);        
      $gratuitos = Modelo_Plan::busquedaPlanes(Modelo_Usuario::EMPRESA,$sucursal,1,false);      
      $idplanes = '';
      $totgratuitos = count($gratuitos);
      foreach($gratuitos as $key=>$gratuito){
        $idplanes .= $gratuito["id_plan"].((($key+1)==$totgratuitos) ? "" : ",");
      }  
          
      //si ya tiene un gratuito comprado este mes      
      if (!Modelo_UsuarioxPlan::existePlanEmpresa($idplanes,$_SESSION["mfo_datos"]["usuario"]["id_usuario"]) /*&& 
          isset($_SESSION['mfo_datos']['planes']) && !empty($_SESSION['mfo_datos']['planes'])*/){        
          $tags['gratuitos'] = $gratuitos;          
      }      
      $tags['planes'] = Modelo_Plan::busquedaPlanes(Modelo_Usuario::EMPRESA,$sucursal,2,Modelo_Plan::PAQUETE,$nivel);     
      /*$avisos = Modelo_Plan::busquedaPlanes(Modelo_Usuario::EMPRESA,$sucursal,2,Modelo_Plan::AVISO,$nivel);
      $idplanes = '';
      $totavisos = count($avisos);
      foreach($avisos as $key=>$aviso){
        if ($aviso["promocional"] == 1){
          $idplanes .= $aviso["id_plan"].((($key+1)==$totavisos) ? "" : ",");
        }
      }
      //consulta si nunca ha comprado el aviso como promocional      
      if (!empty($idplanes) && !Modelo_UsuarioxPlan::existePlanEmpresa($idplanes,$_SESSION["mfo_datos"]["usuario"]["id_usuario"],0)){
        $tags['aviso_promocional'] = 1;
        unset($tags['gratuitos']);
      }
      $tags['avisos'] = $avisos;*/
      $tags['avisos'] = Modelo_Plan::busquedaPlanes(Modelo_Usuario::EMPRESA,$sucursal,2,Modelo_Plan::AVISO,$nivel);
    }     
    $tags["template_css"][] = "media-queries";
    // $tags["template_css"][] = "planes";
    $tags["template_js"][] = "planes";
    $tags['breadcrumbs'] = $breadcrumbs;
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
      $idplan = Utils::desencriptar($idplan);
      $idusu = $_SESSION["mfo_datos"]["usuario"]["id_usuario"];
      $tipousu = $_SESSION["mfo_datos"]["usuario"]["tipo_usuario"];
      $sucursal = SUCURSAL_ID; 
      $tipoplan = ($tipousu == Modelo_Usuario::CANDIDATO) ? Modelo_Plan::CANDIDATO : Modelo_Plan::EMPRESA;
      $infoplan = Modelo_Plan::busquedaActivoxTipo($idplan,$tipoplan,$sucursal);      
      if (!isset($infoplan["id_plan"]) || empty($infoplan["id_plan"])){
        throw new Exception("El plan seleccionado no esta activo o no esta disponible");
      }          
      //$gratuito = 0;
      //if ($infoplan["promocional"] == 1 && !Modelo_UsuarioxPlan::existePlanEmpresa($infoplan["id_plan"],$_SESSION["mfo_datos"]["usuario"]["id_usuario"],0)){
      //  $gratuito = 1;
      //}      

      /*|| $gratuito == 1(empty($_SESSION['mfo_datos']['planes']) && $infoplan["promocional"] == 1) ||
          (!empty($nivel) && $gratuitos == 0)*/

      if (empty($infoplan["costo"])){
        $limiteperfiles = '';  
        if ($_SESSION["mfo_datos"]["usuario"]["tipo_usuario"] == Modelo_Usuario::CANDIDATO){
          if ($this->existePlan($infoplan["id_plan"])){
            throw new Exception("Ya esta suscrito al plan seleccionado");   
          }                 
        }  
        else{
          if ($this->existePlan($infoplan["id_plan"])){
            throw new Exception("El plan seleccionado se encuentra activo");   
          }          
          if (!empty($infoplan["limite_perfiles"])){
            $limiteperfiles = $infoplan["limite_perfiles"];  
          }
          //if (Modelo_UsuarioxPlan::existePlanEmpresa($infoplan["id_plan"],$_SESSION["mfo_datos"]["usuario"]["id_usuario"],0)){
          //  $limiteperfiles = $infoplan["limite_perfiles"];  
          //}
          //else{
          //  $limiteperfiles = $infoplan["prom_limiteperfiles"];   
          //}
        }      
        if (!Modelo_UsuarioxPlan::guardarPlan($idusu,$tipousu,$infoplan["id_plan"],$infoplan["num_post"],$infoplan["duracion"],$infoplan["porc_descarga"],'',false,false,false,$infoplan["num_accesos"],$limiteperfiles)){
          throw new Exception("Error al registrar la suscripci\u00F3n, por favor intente denuevo");   
        }          
        $_SESSION['mfo_datos']['planes'] = Modelo_UsuarioxPlan::planesActivos($idusu,$tipousu);
        if ($tipousu == Modelo_Usuario::CANDIDATO){
          $_SESSION['mostrar_exito'] = "Suscripci\u00F3n exitosa, ahora puede postular a una oferta"; 
          $this->redirectToController('oferta');
        }
        else{
          $_SESSION['mostrar_exito'] = "Suscripci\u00F3n exitosa, ahora puede publicar una oferta"; 
          $this->redirectToController('publicar');
        }
      }

      else{                
        //presenta metodos de pago
        $tags["plan"] = $infoplan;        
        //datos para payme
        //$precio = $infoplan["costo"]; 
        $infoplan["costo"] = round($infoplan["costo"],2);       
        $decimal = strpos($infoplan["costo"], ".");                
        if ($decimal === false){
          $precio = $infoplan["costo"]."00";
        }
        else{
          $vldecimal = str_replace(".","",strstr($infoplan["costo"], "."));
          $vldecimal = str_pad($vldecimal,2,"0",STR_PAD_RIGHT);
          $vlentero = strstr($infoplan["costo"], ".",true);
          $precio = (!empty($vlentero)) ? $vlentero.$vldecimal : $vldecimal;        
        }

        $taxMontoGravaIva = round($infoplan["costo"] / GRAVAIVA,2);
        $taxMontoIVA = round($infoplan["costo"] - $taxMontoGravaIva,2);
        $decimal = strpos($taxMontoGravaIva, ".");
        if ($decimal === false){
          $taxMontoGravaIva = $taxMontoGravaIva."00";
        }
        else{
          $vldecimal = str_replace(".","",strstr($taxMontoGravaIva, "."));
          $vldecimal = str_pad($vldecimal,2,"0",STR_PAD_RIGHT);
          $vlentero = strstr($taxMontoGravaIva, ".",true);
          $taxMontoGravaIva = (!empty($vlentero)) ? $vlentero.$vldecimal : $vldecimal;        
        }
        //$taxMontoGravaIva = ($decimal === false) ? $taxMontoGravaIva."00" : str_replace(".","",$taxMontoGravaIva);

        $decimal = strpos($taxMontoIVA, ".");  
        if ($decimal === false){
          $taxMontoIVA = $taxMontoIVA."00";
        }
        else{
          $vldecimal = str_replace(".","",strstr($taxMontoIVA, "."));
          $vldecimal = str_pad($vldecimal,2,"0",STR_PAD_RIGHT);
          $vlentero = strstr($taxMontoIVA, ".",true);
          $taxMontoIVA = (!empty($vlentero)) ? $vlentero.$vldecimal : $vldecimal;        
        }
        //$taxMontoIVA = ($decimal === false) ? $taxMontoIVA."00" : str_replace(".","",$taxMontoIVA);
        $tags["precio"] = $precio;
        $tags["taxMontoGravaIva"] = $taxMontoGravaIva;
        $tags["taxMontoIVA"] = $taxMontoIVA;
        $tags["purchaseOperationNumber"] = $this->generarTransactionId();       
        $tags["purchaseVerification"] = openssl_digest(PAYME_ACQUIRERID . 
                                                       PAYME_IDCOMMERCE . 
                                                       $tags["purchaseOperationNumber"] . 
                                                       $precio . 
                                                       PAYME_CURRENCY_CODE . 
                                                       PAYME_SECRET_KEY, 'sha512'); 
        
        $tags["arrprovincia"] = Modelo_Provincia::obtieneProvinciasSucursal(SUCURSAL_PAISID);
        //datos para transferencia bancaria
        $tags["ctabancaria"] = Modelo_Ctabancaria::obtieneListado();          
        $tags["template_js"][] = "DniRuc_Validador";        
        $tags["template_js"][] = "metodospago";   
        $tags["template_js"][] = "alignet";   
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
      $campos = array('idplan'=>1,'num_comprobante'=>1,'valor'=>1,'nombre'=>1,'apellido'=>1,'correo'=>1,'direccion'=>1,'tipo_doc'=>1,'telefono'=>1,'dni'=>1,'provincia'=>1,'ciudad'=>1,'shipping'=>1);
      $data = $this->camposRequeridos($campos);   
      
      if (!Utils::alfanumerico($data["num_comprobante"]) || strlen($data["num_comprobante"]) > 50){
        throw new Exception("N\u00FAmero de comprobante no es v\u00E1lido");
      }
      if (!Utils::formatoDineroDecimal($data["valor"]) || strlen($data["valor"]) > 10){
        throw new Exception("Valor del comprobante no es v\u00E1lido");
      }
      if (!Utils::es_correo_valido($data["correo"]) || strlen($data["correo"]) > 100){
        throw new Exception("Direcci\u00F3n de correo electr\u00F3nico no es v\u00E1lido");
      }
      if (!Utils::valida_telefono($data["telefono"]) || strlen($data["telefono"]) > 25){
        throw new Exception("Solo se permite ingresar valores de tipo n\u00FAmero m\u00EDn. 9 y m\u00E1x. 15.");
      }      
      if (!Utils::alfanumerico($data["shipping"]) || strlen($data["shipping"]) > 10){
        throw new Exception("C\u00F3digo postal no es v\u00E1lido");
      }

      if($data["tipo_doc"] == 1 || $data["tipo_doc"] == 2){
        if (method_exists(new Utils, 'validar_'.SUCURSAL_ISO)) {
          $function = 'validar_'.SUCURSAL_ISO;
          $validaCedula = Utils::$function($data['dni'], 2, $data["tipo_doc"]);
          if ($validaCedula == false){
            throw new Exception("El documento ingresado no es v\u00E1lido");
          }
        }
      }
      if(!isset($_FILES['imagen'])){
        throw new Exception("Debe subir una imagen con formato jpg o png y menor a 1 MB");         
      } 
      if (!Utils::valida_upload($_FILES['imagen'], 3)) {
        throw new Exception("La imagen debe ser en formato .jpg .jpeg .png y con un peso m\u00E1ximo de 1MB");
      }
       
      $archivo = Utils::validaExt($_FILES['imagen'],3);
      
      if (!Modelo_Comprobante::guardarComprobante($data["num_comprobante"],$data["nombre"]." ".$data["apellido"],$data["correo"],
                                                  $data["telefono"],$data["dni"],$data["tipo_doc"],
                                                  Modelo_Comprobante::METODO_DEPOSITO,$archivo[1],
                                                  $data["valor"],$_SESSION['mfo_datos']['usuario']['id_usuario'],
                                                  $data["idplan"],$data['direccion'],
                                                  $_SESSION['mfo_datos']['usuario']['tipo_usuario'], 
                                                  Modelo_Comprobante::PAGO_PROCESO,$data["provincia"],
                                                  $data["ciudad"],$data["shipping"],
                                                  Proceso_Facturacion::FORMA_PAGO["SINFINANCIERO"])){
        throw new Exception("Error al ingresar el dep\u00F3sito, por favor intente denuevo");
      }

      $id_comprobante = $GLOBALS['db']->insert_id();
 
      if (!Utils::upload($_FILES['imagen'],$id_comprobante,PATH_COMPROBANTE,3)){
        throw new Exception("Error al cargar la imagen, por favor intente denuevo");
      }
      $tiempo = Modelo_Parametro::obtieneValor('tiempo_espera');
      $_SESSION['mostrar_exito'] = "Ingreso de comprobante exitoso, su plan ser\u00E1 aprobado en un m\u00E1ximo de ".$tiempo." horas";
      foreach (DIRECTORIOCORREOS as $key => $value) {
        $emailBody = "Se debe aprobar un Plan:<br><br>Id comprobante : ".$id_comprobante."<br>id usuario/empresa: ".$_SESSION['mfo_datos']['usuario']['id_usuario']."<br>Tipo usuario: ".$_SESSION['mfo_datos']['usuario']['tipo_usuario']."<br>Número de comprobante: ".$data["num_comprobante"];        
        Utils::envioCorreo($value, 'Se debe aprobar un depósito', $emailBody);
      } 
      $_SESSION['mfo_datos']['actualizar_planes'] = 1;
      $redirect = "";
      if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == 1){
        $redirect = "oferta";
      }
      else{
        $redirect = "vacantes";
      }
      Utils::doRedirect(PUERTO.'://'.HOST.'/'.$redirect.'/');
    }
    catch(Exception $e){
      $_SESSION['mostrar_error'] = $e->getMessage();            
      Utils::doRedirect(PUERTO.'://'.HOST.'/compraplan/'.Utils::encriptar($data["idplan"]).'/');             
    }     
  }

  public function resultado(){            
    $mensaje = Utils::getParam('mensaje','',$this->data);         
    $template = ($mensaje == 'exito') ? "mensajeplan_exito" : "mensajeplan_error";       
    if ($mensaje == "exito"){    
      if (isset($_SESSION['mfo_datos']['actualizar_planes']) && $_SESSION['mfo_datos']['actualizar_planes'] == 1){
        if(isset($_SESSION['mfo_datos']['usuario']['ofertaConvertir']) && !empty($_SESSION['mfo_datos']['usuario']['ofertaConvertir'])){
          $tags["ofertaConvertir"] = $_SESSION['mfo_datos']['usuario']['ofertaConvertir'];
        }
        $nrotest = Modelo_Cuestionario::totalTest();             
        $nrotestxusuario = Modelo_Cuestionario::totalTestxUsuario($_SESSION['mfo_datos']['usuario']['id_usuario']);
        // $tags["template_js"][] = "planValidarActivacion";        
        $tags['msg_cuestionario'] = ($nrotestxusuario < $nrotest) ? 1 : 0; 
        //$_SESSION['mfo_datos']['actualizar_planes'] = 1;      
      }
      else{                
        Utils::doRedirect(PUERTO.'://'.HOST.'/planes/');
      }
    }
    $cab = ''; $pie = '';
    if($mensaje != 'exito'){$cab = 'cabecera'; $pie = 'piepagina';}    
    Vista::render($template, $tags,$cab, $pie);        
  }

  public function generarTransactionId(){
    $random = Utils::random(000000001, 999999999);
    if(strlen($random) < 9){
      $random = str_pad($random, 9, "0", STR_PAD_LEFT);
    }
    return $random;
  }

  public function crearFile(){
    $idusuario = Utils::getParam('id','',$this->data);
    $idoperation = Utils::getParam('idoperation','',$this->data);      
    $rs = 0; $msg = 'Error en la conexion, por favor intente denuevo';
    if (!empty($idusuario) && !empty($idoperation)){
      if ($this->buscarUsuariosFile($idusuario)){
        $rs = 2; $msg = 'Usted ya tiene una compra en proceso por favor espere unos minutos';
      }
      else{        
        $fp = fopen(FRONTEND_RUTA.'cache/compras/'.$idusuario.'_'.$idoperation.'.txt', "w");
        fputs($fp, '');
        if (fclose($fp)){
          $rs = 1; $msg ='Error por favor intente denuevo';
        }
      }      
    }        
    Vista::renderJSON(array("resultado"=>$rs,"mensaje"=>$msg));
  }

  public function buscarUsuariosFile($idusuario){
    $directorio = opendir(FRONTEND_RUTA.'cache/compras');     
    while ($archivo = readdir($directorio)) {
      if (!is_dir($archivo)){
        preg_match_all("/([0-9]+)_([0-9]+)/i",$archivo,$matches);
        if (is_array($matches)){          
          if ($matches[1][0] == $idusuario){          
            return true;
          }          
        }        
      }      
    }    
    return false;
  }
}  
?>

<?php
require_once 'includes/mpdf/mpdf.php';
require_once 'includes/generarBarcode.php';

class Controlador_Plan extends Controlador_Base {
   
  public function construirPagina(){
    if( !Modelo_Usuario::estaLogueado() ){
      Utils::doRedirect(PUERTO.'://'.HOST.'/login/');
    }

    if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO){
      Modelo_Usuario::validaPermisos($_SESSION['mfo_datos']['usuario']['tipo_usuario'],
                                     $_SESSION['mfo_datos']['usuario']['id_usuario'],
                                     (isset($_SESSION['mfo_datos']['infohv']) ? $_SESSION['mfo_datos']['infohv'] : null),
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
      default:        
        //$this->mostrarDefault(1);
        $this->generarRIDE();
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
    $planUsuario = Modelo_Plan::listadoPlanesUsuario($idUsuario,$_SESSION["mfo_datos"]["usuario"]["tipo_usuario"]);

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
      $nivel = Modelo_Usuario::obtieneNivel($_SESSION["mfo_datos"]["usuario"]["padre"]);      
      $tags['gratuitos'] = Modelo_Plan::busquedaPlanes(Modelo_Usuario::EMPRESA,$sucursal,1,false);
      $tags['planes'] = Modelo_Plan::busquedaPlanes(Modelo_Usuario::EMPRESA,$sucursal,2,Modelo_Plan::PAQUETE,$nivel);
      $tags['avisos'] = Modelo_Plan::busquedaPlanes(Modelo_Usuario::EMPRESA,$sucursal,2,Modelo_Plan::AVISO,$nivel);
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
                 
        if (!Modelo_UsuarioxPlan::guardarPlan($idusu,$tipousu,$infoplan["id_plan"],$infoplan["num_post"],$infoplan["duracion"],$infoplan["porc_descarga"])){
          throw new Exception("Error al registrar la subscripción, por favor intente denuevo");   
        }  
        
        $_SESSION['mfo_datos']['planes'] = Modelo_UsuarioxPlan::planesActivos($idusu,$tipousu);
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
        $tags["ctabancaria"] = Modelo_Ctabancaria::obtieneListado();          
 
        $tags["template_js"][] = "ruc_jquery_validator";
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
      $campos = array('idplan'=>1,'num_comprobante'=>1,'valor'=>1,'nombre'=>1,'correo'=>1,'direccion'=>1,'tipo_doc'=>1,'telefono'=>1,'dni'=>1);
      $data = $this->camposRequeridos($campos);   
       
      if (!Utils::alfanumerico($data["num_comprobante"]) || strlen($data["num_comprobante"]) > 50){
        throw new Exception("Número de comprobante no es válido");
      }
      if (!Utils::formatoDinero($data["valor"]) || strlen($data["valor"]) > 10){
        throw new Exception("Valor del comprobante no es válido");
      }
      if (!Utils::es_correo_valido($data["correo"]) || strlen($data["correo"]) > 100){
        throw new Exception("Dirección de correo electrónico no es válido");
      }
      if (!Utils::valida_telefono($data["telefono"]) || strlen($data["telefono"]) > 25){
        throw new Exception("Número de teléfono no es válido");
      }
      if($data["tipo_doc"] == 1 || $data["tipo_doc"] == 2){
        if (method_exists(new Utils, 'validar_'.SUCURSAL_ISO)) {
          $function = 'validar_'.SUCURSAL_ISO;
          $validaCedula = Utils::$function($data['dni']);
          if ($validaCedula == false){
            throw new Exception("El DNI ingresado no es válido");
          }
        }
      }
      if(!isset($_FILES['imagen'])){
        throw new Exception("Debe subir una imagen con formato jpg o png y menor a 1 MB");         
      } 
      if (!Utils::valida_upload($_FILES['imagen'], 3)) {
        throw new Exception("La imagen debe ser en formato .jpg .jpeg .png y con un peso máximo de 1MB");
      }
       
      $archivo = Utils::validaExt($_FILES['imagen'],3);

      if (!Modelo_Comprobante::guardarComprobante($data["num_comprobante"],$data["nombre"],$data["correo"],$data["telefono"],
                                                  $data["dni"],$data["tipo_doc"],Modelo_Comprobante::METODO_DEPOSITO,$archivo[1],
                                                  $data["valor"],$_SESSION['mfo_datos']['usuario']['id_usuario'],$data["idplan"],
                                                  $data['direccion'],$_SESSION['mfo_datos']['usuario']['tipo_usuario'])){
        throw new Exception("Error al ingresar el deposito, por favor intente denuevo");
      }
 
      $id_comprobante = $GLOBALS['db']->insert_id();
 
      if (!Utils::upload($_FILES['imagen'],$id_comprobante,PATH_COMPROBANTE,3)){
        throw new Exception("Error al cargar la imagen, por favor intente denuevo");
      }

      $tiempo = Modelo_Parametro::obtieneValor('tiempo_espera');
      $_SESSION['mostrar_exito'] = "Ingreso de comprobante exitoso, su plan será aprobado en un máximo de ".$tiempo." horas";  
      Utils::doRedirect(PUERTO.'://'.HOST.'/oferta/');
    }
    catch(Exception $e){
      $_SESSION['mostrar_error'] = $e->getMessage();            
      Utils::doRedirect(PUERTO.'://'.HOST.'/compraplan/'.$data["idplan"].'/');             
    }     
  }
  
  public function resultado(){
    $arrbanner = Modelo_Banner::obtieneAleatorio(Modelo_Banner::BANNER_CANDIDATO);    
    $_SESSION['mostrar_banner'] = PUERTO.'://'.HOST.'/imagenes/banner/'.$arrbanner['id_banner'].'.'.$arrbanner['extension'];
    $tags["show_banner"] = 1;
    $mensaje = Utils::getParam('mensaje','',$this->data);     
    $template = ($mensaje == 'exito') ? "mensajeplan_exito" : "mensajeplan_error";
    if ($mensaje == "exito"){
      $nrotest = Modelo_Cuestionario::totalTest();             
      $nrotestxusuario = Modelo_Cuestionario::totalTestxUsuario($_SESSION['mfo_datos']['usuario']['id_usuario']);
      $tags['msg_cuestionario'] = ($nrotestxusuario < $nrotest) ? 1 : 0; 
      $_SESSION['mfo_datos']['actualizar_planes'] = 1;      
    }  
    Vista::render($template, $tags);       
  }

  public function generarRIDE(){

    $id_factura = 1;
    $estado = 2;
    //header('Content-Type: text/html');
    $tipo_emision = array(1=>"NORMAL");
    $ambiente = array(1=>"PRUEBAS", 2=>"PRODUCCION");
    $tipo_documento = array("01"=>"FACTURA");  
    $tipo_identif_comprador = array("04"=>"R.U.C.","05"=>"CÉDULA","PASAPORTE"=>"06");
    $codigo_impuesto = array(2=>"IVA",3=>"ICE",5=>"IRBPNR");  
    $tarifa_iva = array(2=>"12",3=>"14");
    $moneda = array(1=>'DOLAR');
    $forma_pago = array("01"=>"SIN UTILIZACION DEL SISTEMA FINANCIERO","15"=>"COMPENSACIÓN DE DEUDAS", "16"=>"TARJETA DE DÉBITO", "17"=>"DINERO ELECTRÓNICO", "18"=>"TARJETA PREPAGO", "19"=>"TARJETA DE CRÉDITO", "20"=>"OTROS CON UTILIZACION DEL SISTEMA FINANCIERO", "21"=>"ENDOSO DE TÍTULOS"); 

    /*Instancio la clase DOM que nos permitira operar con el XML*/
    $doc = new DOMDocument();
    $xml_bd = Modelo_Factura::obtenerFactura($id_factura,$estado);
    $xml = utf8_encode($xml_bd['xml']);
  
    /*Cargo el XML con loadXML si desamos leer de un string*/
    $autorizacion = simplexml_load_string($xml);
    $factura = simplexml_load_string($autorizacion->comprobante);
    $infoTributaria = $factura->infoTributaria;
    $infoFactura = $factura->infoFactura;
    $detalles = $factura->detalles;
    $infoAdicional = $factura->infoAdicional;

    $obj_generar = new GenerarBarcode((string)$autorizacion->numeroAutorizacion,FRONTEND_RUTA.'/imagenes/imagenesCod/');
    $obj_generar->imprimirbarcode();
    //header('Content-Type: text/html');
    //ob_flush();

    $mpdf=new mPDF('','A4','','',3,3,3,3,6,3); 

    $logo = "<img src='http://localhost/repos_micamello/imagenes/logo.png' alt='Mi camello Logo' height='150'>";
    $eslogan = "Eficiencia, innovación y transparencia";

    $style1 = ' style="padding: 5px 5px 5px 5px;" ';
    $abrir_interlineado = '<tr><td colspan="2" style="height:';
    $cerrar_interlineado = 'px;"></td></tr>';

    $contenido .= "<table width='1000' style='font-size: 18px; border-spacing: 5px;'>";
    $contenido .= "<tr>";
    $contenido .= "<td width='500' style='text-align:center;'>";
    $contenido .= "<br>".$logo."<br><span atyle='text-align:center;color: #0d0d13;font-size: 10px;'>".$eslogan."<span>";
    $contenido .= "</td>";
    $contenido .= "<td rowspan='2' width='600' style=''>";
    $contenido .= '<table width="600" style="border: 1px solid #000;text-align:left;padding-top: 20px;padding-left: 15px;padding-right: 15px;">
                    <tr>
                      <td colspan="2"><h1><b>R.U.C.:</b> '.$infoTributaria->ruc.'</h1></td>
                    </tr>'
                    .$abrir_interlineado.'10'.$cerrar_interlineado.
                    '<tr>
                      <td colspan="2"><b><h1>'.$tipo_documento[(string)$infoTributaria->codDoc].'</h1></b></td>
                    </tr>
                    <tr>
                      <td colspan="2" style="color:red;"><h2><b>No. '.$infoTributaria->estab.'-'.$infoTributaria->ptoEmi.'-'.$infoTributaria->secuencial.'</b></h2></td>
                    </tr>'
                    .$abrir_interlineado.'10'.$cerrar_interlineado.
                    '<tr>
                      <td colspan="2"><b>NÚMERO DE AUTORIZACIÓN</b></td>
                    </tr>
                    <tr>
                      <td colspan="2">'.$autorizacion->numeroAutorizacion.'</td>
                    </tr>'
                    .$abrir_interlineado.'30'.$cerrar_interlineado.
                    '<tr>
                      <td width="200"><b>FECHA Y HORA DE AUTORIZACIÓN:</b></td>
                      <td>'.str_replace("T", " ", $autorizacion->fechaAutorizacion).'</td>
                    </tr>'
                    .$abrir_interlineado.'10'.$cerrar_interlineado.
                    '<tr>
                      <td width="200"><b>AMBIENTE:</b></td>
                      <td>'.str_replace("?", "Ó", $autorizacion->ambiente).'</td>
                    </tr>'
                    .$abrir_interlineado.'10'.$cerrar_interlineado.
                    '<tr>
                      <td width="200"><b>EMISIÓN:</b></td>
                      <td>'.$tipo_emision[(string)$infoTributaria->tipoEmision].'</td>
                    </tr>'
                    .$abrir_interlineado.'10'.$cerrar_interlineado.
                    '<tr>
                      <td><b>CLAVE DE ACCESO:</b></td>
                    </tr>
                    <tr>
                     <td colspan="2"><img style="width: 560px; height: 90px;" alt="codigo de barra" src="'.PUERTO.'://'.HOST.'/imagenes/imagenesCod/'.(string)$autorizacion->numeroAutorizacion.'.png'.'" /></td>
                    </tr>
                    <tr>
                      <td colspan="2" style="text-align:center;">'.(string)$infoTributaria->claveAcceso.'</td>
                    </tr>'
                    .$abrir_interlineado.'10'.$cerrar_interlineado.
                    '</table>';
    $contenido .= "</td>";
    $contenido .= "</tr>";
    $contenido .= "<tr>";
    $contenido .= "<td width='400'>";
    $contenido .= '<table style="border: 1px solid #000; text-align:left; padding: 15px 20px 15px 15px;">
                      <tr><td style="padding-left: 15px; padding-right: 5px;" colspan="2"><h2><b>'.$infoTributaria->razonSocial.'</b></h2></td>
                      </tr>'
                      .$abrir_interlineado.'15'.$cerrar_interlineado.
                      '<tr><td style="padding-right: 5px;"><b>Dirección Matriz:</b></td><td width="500" style="padding-right: 15px;">'.$infoTributaria->dirMatriz.'</td>
                      </tr>'
                      .$abrir_interlineado.'15'.$cerrar_interlineado.
                      '<tr><td colspan="2" style=""><b>OBLIGADO A LLEVAR CONTABILIDAD:</b>&nbsp;&nbsp;&nbsp;&nbsp;'.$infoFactura->obligadoContabilidad.'</td>
                      </tr>
                    </table>
                    ';
    $contenido .= "</td>";
    $contenido .= "</tr>"; 
    $contenido .= "<tr>";
    $contenido .= "<td colspan='2'>";
    $contenido .= '<table width="1000" style="border: 1px solid #000;padding: 10px 10px 10px 10px;" >
                    <tr>
                      <td '.$style1.'><b>Razón Social / Nombres y Apellidos: </b></td>
                      <td '.$style1.'>'.strtoupper($infoFactura->razonSocialComprador).'</td>
                      <td '.$style1.'><b>RUC / CI: </b></td>
                      <td '.$style1.'>'.$infoFactura->identificacionComprador.'</td>
                    </tr>
                    <tr>
                      <td '.$style1.'><b>Fecha de Emisión: </b></td>
                      <td '.$style1.'>'.$infoFactura->fechaEmision.'</td>
                      <td '.$style1.'><b>Guía de Remisión: </b></td>
                      <td '.$style1.'></td>
                    </tr>
                </table>';
    $contenido .= "</td>";
    $contenido .= "</tr>"; 
    $contenido .= "<tr>";
    $contenido .= "<td colspan='2'>";
    $contenido .= '<table width="1000" border="1" style="text-align:center; border-collapse: collapse;" >
                      <tr>
                        <td width="10"><b>Cod. Principal</b></td>
                        <td width="10"><b>Cant.</b></td>
                        <td width="950"><b>Descripción</b></td>
                        <td width="10"><b>Precio Unitario</b></td>
                        <td width="10"><b>Descuento</b></td>
                        <td width="10"><b>Precio Toral</b></td>
                      </tr>';
    foreach ($detalles->detalle as $detalle) {

      $contenido .= '<tr>
        <td '.$style1.' align="right">'.$detalle->codigoPrincipal.'</td>
        <td '.$style1.' align="right">'.$detalle->cantidad.'</td>
        <td '.$style1.' >'.$detalle->descripcion.'</td>
        <td '.$style1.' align="right">'.number_format((float)$detalle->precioUnitario, 2, '.', ',').'</td>
        <td '.$style1.' align="right">'.number_format((float)$detalle->descuento, 2, '.', ',').'</td>
        <td '.$style1.' align="right">'.number_format((float)$detalle->precioTotalSinImpuesto, 2, '.', ',').'</td>
      </tr>';
    }
    $contenido .= '</table>';
    $contenido .= "</td>";
    $contenido .= "</tr>"; 
    $contenido .= "<tr>";
    $contenido .= "<td>";
    $contenido .= '<table width="500" style="border: 1px solid #000; padding-top: 20px;padding-left: 15px;padding-bottom: 15px;padding-right: 15px;">
                      <tr><td align="center" style="padding-left: 15px; padding-right: 5px;" colspan="2"><b>Información Adicional</b></td></tr>';

    foreach ($infoAdicional->campoAdicional as $nodo) 
    {
      $atributos = $nodo->attributes();
      $contenido .= '<tr><td colspan="2" style="height: 15px;"></td></tr>
                    <tr><td style="padding-right: 5px;"><b>'.$atributos->nombre.'</b></td><td width="500" style="padding-right: 15px;">'.$nodo[0].'</td>
                    </tr>';
    }
    $contenido .= '</table>
                  <br>
                  <table width="500" border="1" style="text-align:center; border-collapse: collapse;">
                      <tr>
                        <td '.$style1.' align="center"><b>Forma de Pago</b></td>
                        <td '.$style1.' align="center"><b>Valor</b></td>
                      </tr>
                      <tr>
                        <td '.$style1.' align="center">'.$forma_pago[(string)$infoFactura->pagos->pago->formaPago].'</td>
                        <td '.$style1.' align="center">'.$infoFactura->pagos->pago->total.'</td>
                      </tr>
                  </table>
                  ';
    $contenido .= "</td>";
    $contenido .= "<td valign='top' align='right'>";

    $contenido .= '<table width="500" border="1" style="text-align:center; border-collapse: collapse;">
                          <tr>
                            <td '.$style1.' colspan="2" align="left"><b>SUBTOTAL 12%</b></td>
                            <td '.$style1.' align="right">'.$infoFactura->totalConImpuestos->totalImpuesto->baseImponible.'</td>
                          </tr>
                          <tr>
                            <td '.$style1.' colspan="2" align="left"><b>SUBTOTAL 0%</b></td>
                            <td '.$style1.' align="right">0.00</td>
                          </tr>
                          <tr>
                            <td '.$style1.' colspan="2" align="left"><b>SUBTOTAL no objeto de IVA</b></td>
                            <td '.$style1.' align="right">0.00</td>
                          </tr>
                          <tr>
                            <td '.$style1.' colspan="2" align="left"><b>SUBTOTAL exento de IVA</b></td>
                            <td '.$style1.' align="right">0.00</td>
                          </tr>
                          <tr>
                            <td '.$style1.' colspan="2" align="left"><b>SUBTOTAL SIN IMPUESTOS</b></td>
                            <td '.$style1.' align="right">'.$infoFactura->totalSinImpuestos.'</td>
                          </tr>
                          <tr>
                            <td '.$style1.' colspan="2" align="left"><b>TOTAL DESCUENTO</b></td>
                            <td '.$style1.' align="right">'.$infoFactura->totalDescuento.'</td>
                          </tr>
                          <tr>
                            <td '.$style1.' colspan="2" align="left"><b>ICE</b></td>
                            <td '.$style1.' align="right">0.00</td>
                          </tr>
                          <tr>
                            <td '.$style1.' colspan="2" align="left"><b>IVA '.$infoFactura->totalConImpuestos->totalImpuesto->tarifa.'%</b></td>
                            <td '.$style1.' align="right">'.$infoFactura->totalConImpuestos->totalImpuesto->valor.'</td>
                          </tr>
                          <tr>
                            <td '.$style1.' colspan="2" align="left"><b>IRBPNR</b></td>
                            <td '.$style1.' align="right">0.00</td>
                          </tr>
                          <tr>
                            <td '.$style1.' colspan="2" align="left"><b>PROPINA</b></td>
                            <td '.$style1.' align="right">'.$infoFactura->propina.'</td>
                          </tr>
                          <tr>
                            <td '.$style1.' colspan="2" align="left"><b>VALOR TOTAL</b></td>
                            <td '.$style1.' align="right">'.$infoFactura->importeTotal.'</td>
                          </tr>
                      </table>';
    $contenido .= "</td>";
    $contenido .= "</tr>";                            
    $contenido .= "</table>";

    $mpdf->setHTMLFooter('<footer align="center" style="font-size:10px; color:#5d5858;">Provincia: Guayas Cantón: DAULE Parroquia LA AURORA (SATÉLITE) <br>km. 12 Av. Febres Cordero Cdla. Villa Club etapa Krypton Mz. 14 Solar 3 (a cuatro cuadras de la garita). <br>Teléfono: 2753106 Celular: 099234268. E-mail: infor@micamello.com.ec</footer>');

    $mpdf->WriteHTML($contenido);

    unlink(FRONTEND_RUTA.'/imagenes/imagenesCod/'.$autorizacion->numeroAutorizacion.'.png');
    //echo $contenido;
    $mpdf->Output('FACTURA_'.'001'.".pdf", 'I');
  }
}  
?>
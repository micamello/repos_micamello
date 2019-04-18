<?php
class Controlador_Aspirante extends Controlador_Base
{

    public function construirPagina()
    {
        $idUsuario = $_SESSION['mfo_datos']['usuario']['id_usuario'];
        $tipoUsuario = $_SESSION['mfo_datos']['usuario']['tipo_usuario'];

        if (!Modelo_Usuario::estaLogueado()) {
            Utils::doRedirect(PUERTO . '://' . HOST . '/login/');
        }

        if ($tipoUsuario != Modelo_Usuario::EMPRESA || !isset($_SESSION['mfo_datos']['planes'])){
          Utils::doRedirect(PUERTO . '://' . HOST . '/');  
        }

        //Valida los permisos 
        if(isset($_SESSION['mfo_datos']['planes']) && !Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'buscarCandidatos')){
           $this->redirectToController('vacantes');
        }

        $mostrar = Utils::getParam('mostrar', '', $this->data);
        $opcion = Utils::getParam('opcion', '', $this->data);
        $page = Utils::getParam('page', '1', $this->data);
        $id_oferta = Utils::getParam('id_oferta', '', $this->data); 
        $id_oferta = (!empty($id_oferta)) ? Utils::desencriptar($id_oferta) : $id_oferta;        
        $type = Utils::getParam('type', '', $this->data); 
        $vista = Utils::getParam('vista', '', $this->data);
        $username = Utils::getParam('username', '', $this->data);

        $listado_planes = array();
        $breadcrumbs = array();
        $array_empresas = array();      

        if($vista != '' && $vista != $_SESSION['mfo_datos']['ultimaVistaActiva']){

            //echo 'entro1';
            unset($_SESSION['mfo_datos']['accesos']);
            unset($_SESSION['mfo_datos']['planSeleccionado']);
            $_SESSION['mfo_datos']['usuarioSeleccionado'] = array();
            $_SESSION['mfo_datos']['ultimaVistaActiva'] = $vista;
        }

        if(!isset($_SESSION['mfo_datos']['Filtrar_aspirantes'])){
            $_SESSION['mfo_datos']['Filtrar_aspirantes'] = array('A'=>0,'F'=>0,'P'=>0,'U'=>0,'G'=>0,'S'=>0,'N'=>0,'E'=>0,'D'=>0,'L'=>0,'T'=>0,'V'=>0,'O'=>1,'Q'=>0,'R'=>0);
        }

        $facetas = Modelo_Faceta::obtenerFacetas();
        $datos_usuarios = Modelo_PorcentajexFaceta::usuariosxfaceta();

        switch ($opcion) {
            case 'filtrar':                
                $arrarea       = Modelo_Area::obtieneListadoAsociativo();
                $arrprovincia  = Modelo_Provincia::obtieneListadoAsociativo(SUCURSAL_PAISID);
                $nacionalidades       = Modelo_Pais::obtieneListadoAsociativo();
                $escolaridad      = Modelo_Escolaridad::obtieneListadoAsociativo();
                $datosOfertas = Modelo_Oferta::ofertaPostuladoPor($id_oferta);
                $situacionLaboral = Modelo_SituacionLaboral::obtieneListadoAsociativo();
                $licencia = Modelo_TipoLicencia::obtieneListadoAsociativo();

                unset($this->data['mostrar'],$this->data['opcion'],$this->data['page'],$this->data['type'],$this->data['id_oferta'],$this->data['vista']);

                $cadena = '';
                $array_datos = $aspirantesFiltrados = array();
               
                foreach ($this->data as $param => $value) {
                    
                    $letra = substr($value,0,1);
                    $id = substr($value,1);
                    $cadena .= '/'.$value;
                    if($letra == 'F' && $type == 1){
                        
                        if(isset(FECHA_POSTULADO[$id])){
                            $_SESSION['mfo_datos']['Filtrar_aspirantes'][$letra] = $id;
                        }
                    }
                    else if($letra == 'A' && $type == 1){
                          
                        if(isset($arrarea[$id])){
                            $_SESSION['mfo_datos']['Filtrar_aspirantes'][$letra] = $id;
                        }
                    }
                    else if($letra == 'P' && $type == 1){
                        
                        if(isset(PRIORIDAD[$id])){
                            $_SESSION['mfo_datos']['Filtrar_aspirantes'][$letra] = $id;
                        }
                    }
                    else if($letra == 'G' && $type == 1){
                        
                        $g = array_search($id,VALOR_GENERO); 
                        if($g != false){

                            if(isset(GENERO[$g])){
                                $_SESSION['mfo_datos']['Filtrar_aspirantes'][$letra] = $id;
                            }
                        }
                    }
                    else if($letra == 'U' && $type == 1){
                        
                        if(isset($arrprovincia[$id])){
                            $_SESSION['mfo_datos']['Filtrar_aspirantes'][$letra] = $id; 
                        }

                    }else if($letra == 'S' && $type == 1){
                        
                        if(isset(SALARIO[$id])){
                            $_SESSION['mfo_datos']['Filtrar_aspirantes'][$letra] = $id;
                        }

                    }else if($letra == 'N' && $type == 1){
                        
                        if(isset($nacionalidades[$id])){
                            $_SESSION['mfo_datos']['Filtrar_aspirantes'][$letra] = $id;
                        }

                    }else if($letra == 'E' && $type == 1){
                        
                        if(isset($escolaridad[$id])){
                            $_SESSION['mfo_datos']['Filtrar_aspirantes'][$letra] = $id;
                            
                        }

                    }else if($letra == 'D' && $type == 1){
                        
                        $_SESSION['mfo_datos']['Filtrar_aspirantes'][$letra] = $id;
                        
                    }else if($letra == 'L' && $type == 1){
                        
                        if(isset($licencia[$id]) || $id == 0){
                            $_SESSION['mfo_datos']['Filtrar_aspirantes'][$letra] = $id;
                        }
                        
                    }else if($letra == 'T' && $type == 1){

                        if(isset($situacionLaboral[$id])){
                            $_SESSION['mfo_datos']['Filtrar_aspirantes'][$letra] = $id;
                        }
                        
                    }else if($letra == 'V' && $type == 1){
                        
                        $_SESSION['mfo_datos']['Filtrar_aspirantes'][$letra] = $id;
                        
                    }else if($letra == 'R' && $type == 1){
                        
                        $_SESSION['mfo_datos']['Filtrar_aspirantes'][$letra] = $id;

                    }else if($letra == 'Q' && $type == 1){
                        
                        $_SESSION['mfo_datos']['Filtrar_aspirantes'][$letra] = $id;
                    }
                    else if($letra == 'O' && $type == 1){
                        
                        $_SESSION['mfo_datos']['Filtrar_aspirantes'][$letra] = $id; 

                    }else if($type == 2){

                        if($letra == 'L'){
                            $_SESSION['mfo_datos']['Filtrar_aspirantes'][$letra] = -1;
                        }else{
                            $_SESSION['mfo_datos']['Filtrar_aspirantes'][$letra] = 0;
                        }
                    }
                }

                foreach ($_SESSION['mfo_datos']['Filtrar_aspirantes'] as $letra => $value) {

                    if($value !=0 || $value != ''){

                        if($letra == 'F'){
                            if(isset(FECHA_POSTULADO[$value])){
                                $array_datos[$letra] = array('id'=>$value,'nombre'=>FECHA_POSTULADO[$value]);
                            }
                        }

                        if($letra == 'A'){
                            if(isset($arrarea[$value])){
                                $array_datos[$letra] = array('id'=>$value,'nombre'=>$arrarea[$value]);
                            }
                        }

                        if($letra == 'P'){
                            if(isset(PRIORIDAD[$value])){
                                $array_datos[$letra] = array('id'=>$value,'nombre'=>PRIORIDAD[$value]);
                            }
                        }
                        if($letra == 'G'){
                            $g = array_search($value,VALOR_GENERO); 
                            if($g != false){
                                $array_datos['G'] = array('id'=>$value,'nombre'=>GENERO[$g]);
                            }

                        }
                        if($letra == 'U'){
                            if(isset($arrprovincia[$value])){
                                $array_datos[$letra] = array('id'=>$value,'nombre'=>$arrprovincia[$value]);
                            }
                        }
                        if($letra == 'S'){
                            if(isset(SALARIO[$value])){
                                $array_datos[$letra] = array('id'=>$value,'nombre'=>SALARIO[$value]);
                            }
                        }
                        if($letra == 'D'){
                            $array_datos[$letra] = array('id'=>$value,'nombre'=>$value);
                        }
                        if($letra == 'L'){
                            if(isset($licencia[$value]) || $value == 0){

                                if($value == 0){
                                    $array_datos[$letra] = array('id'=>$value,'nombre'=>'No posee licencia');
                                }else{
                                    $array_datos[$letra] = array('id'=>$value,'nombre'=>'Licencia: '.$licencia[$value]);
                                }
                            }
                        }
                        if($letra == 'T'){
                            if(isset($situacionLaboral[$value])){
                                $array_datos[$letra] = array('id'=>$value,'nombre'=>$situacionLaboral[$value]);
                            }
                        }
                        if($letra == 'V'){
                            $array_datos[$letra] = array('id'=>$value,'nombre'=>$value);
                        }
                        if($letra == 'N'){
                            if(isset($nacionalidades[$value])){
                                $array_datos[$letra] = array('id'=>$value,'nombre'=>$nacionalidades[$value]);
                            }
                        }
                        if($letra == 'E'){
                            if(isset($escolaridad[$value])){
                                $array_datos[$letra] = array('id'=>$value,'nombre'=>$escolaridad[$value]);
                            }
                        }
                        if($letra == 'R'){
                            $array_datos[$letra] = array('id'=>$value,'nombre'=>$value);
                           
                        }
                        if($letra == 'O'){
                            $array_datos[$letra] = array('id'=>$value,'nombre'=>$value);
                        }
                        if($letra == 'Q'){
                            $array_datos[$letra] = array('id'=>$value,'nombre'=>htmlentities($value,ENT_QUOTES,'UTF-8'));
                        }
                    }
                }

                if($vista == 1){

                    if(isset($_SESSION['mfo_datos']['subempresas'])){
                        $subempresas = $_SESSION['mfo_datos']['subempresas'];  
                        //$array_empresas = explode(",",$subempresas);
                        foreach ($subempresas as $key => $id) {
                            array_push($array_empresas, $key);
                        }
                    }

                    if(isset($datosOfertas[0]['id_empresa']) && in_array($datosOfertas[0]['id_empresa'], $array_empresas)){
                        $breadcrumbs['cuentas'] = 'Ver Ofertas';
                    }else{
                        $breadcrumbs['vacantes'] = 'Ver Ofertas';
                    }
                    $breadcrumbs['aspirante'] = 'Ver Aspirantes';

                    $datos_plan = Modelo_Oferta::obtenerPlanOferta($id_oferta);
                    $limite_plan = (int)$datos_plan['limite_perfiles'];
                    $id_plan = $datos_plan['id_plan'];
                    $nombre_plan = $datos_plan['nombre_plan'];
                    $costo = $datos_plan['costo'];

                    if(!empty($limite_plan)){
                        $limite_aspirantes = $limite_plan;
                    }else{
                        $limite_aspirantes = count($paises);
                    } 

                    $cantd_aspirantes = Modelo_Usuario::filtrarAspirantes($id_oferta,$_SESSION['mfo_datos']['Filtrar_aspirantes'],$page,$facetas,$limite_plan,true);   

                    $aspirantesFiltrados    = Modelo_Usuario::filtrarAspirantes($id_oferta,$_SESSION['mfo_datos']['Filtrar_aspirantes'],$page,$facetas,$limite_plan,false);

                }else{

                    $id_oferta = 0;
                    $breadcrumbs['vacantes'] = 'Ver Ofertas';
                    $breadcrumbs['aspirante'] = 'Ver Aspirantes';
                    
                    $cantd_aspirantes = Modelo_Usuario::filtrarAspirantesGlobal(SUCURSAL_PAISID,$_SESSION['mfo_datos']['Filtrar_aspirantes'],$page,array(),true);

                    $aspirantesFiltrados    = Modelo_Usuario::filtrarAspirantesGlobal(SUCURSAL_PAISID,$_SESSION['mfo_datos']['Filtrar_aspirantes'],$page,$facetas,false);

                    $listado_planes = Modelo_Plan::listadoPlanesUsuario($idUsuario,$tipoUsuario);

                    $limite_aspirantes = count($cantd_aspirantes);

                    $nombre_plan = '';
                    $limite_plan = '';
                    $id_plan = false;
                    $costo = -1;
                }

                $posibilidades = Modelo_UsuarioxPlan::disponibilidadDescarga($idUsuario);
                $descargas = Modelo_Descarga::cantidadDescarga($idUsuario);

                $nacionalidades = $_SESSION['mfo_datos']['nacionalidades'];
                $arrprovincia = $_SESSION['mfo_datos']['arrprovincia'];

                $link = Vista::display('filtrarAspirantes',array('data'=>$array_datos,'mostrar'=>$mostrar,'id_oferta'=>((!empty($id_oferta)) ? Utils::encriptar($id_oferta) : $id_oferta),'vista'=>$vista,'facetas'=>$facetas)); 

                $tags = array(
                    'arrarea'       => $arrarea,
                    'breadcrumbs'=>$breadcrumbs,
                    'aspirantes'       => $aspirantesFiltrados,
                    'arrprovincia'=>$arrprovincia,
                    'nacionalidades'=>$nacionalidades,
                    'escolaridad'=>$escolaridad,
                    'link'=>$link,
                    'page' =>$page,
                    'mostrar'=>$mostrar,
                    'vista'=>$vista,
                    'array_empresas'=>$array_empresas,
                    'datosOfertas'=>$datosOfertas,
                    'id_oferta'=>(!empty($id_oferta)) ? Utils::encriptar($id_oferta) : $id_oferta,
                    'posibilidades'=>$posibilidades,
                    'descargas'=>$descargas,
                    'facetas'=>$facetas,
                    'datos_usuarios'=>$datos_usuarios,
                    'limite_plan'=>$limite_plan,
                    'nombre_plan'=>$nombre_plan,
                    'costo'=>$costo,
                    'id_plan'=>$id_plan,
                    'listado_planes'=>$listado_planes,
                    'situacionLaboral'=>$situacionLaboral,
                    'licencia'=>$licencia
                );
         
                $url = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.((!empty($id_oferta)) ? Utils::encriptar($id_oferta) : $id_oferta) .'/'.$type.$cadena;

                $pagination = new Pagination($limite_aspirantes,REGISTRO_PAGINA,$url);
                $pagination->setPage($page);
                $tags['paginas'] = $pagination->showPage();

                $tags["template_js"][] = "ion.rangeSlider.min";
                $tags["template_js"][] = "aspirantes";
                
                $tags["template_css"][] = "ion.rangeSlider";
                $tags["template_css"][] = "ion.rangeSlider.skinModern";

                Vista::render('aspirantes', $tags);
            break;

            case 'detallePerfil':
                if (Modelo_Usuario::EMPRESA) {

                    $this->perfilAspirante($username, $id_oferta, $vista);
                }
            break;

            case 'enviarAccesos':
                //verificar que los seleccionados no tengan el informe completo
                //verificar si el usuario tiene el numero de accesos disponible para el plan seleccionado
                //verificar si las variables de sesion existen
            break;

            case 'activarAccesos':
                $accesos = Utils::getParam('accesos', '', $this->data);
                $vista = Utils::getParam('vista', '', $this->data);
                $_SESSION['mfo_datos']['accesos'] = $accesos;

                if($accesos == 0){
                    $_SESSION['mfo_datos']['planSeleccionado'] = 0;
                    $_SESSION['mfo_datos']['usuarioSeleccionado'] = array();
                }
            break;

            case 'guardarPlanSeleccionado':
                $idPlan = Utils::getParam('idPlan', '', $this->data);
                $_SESSION['mfo_datos']['planSeleccionado'] = $idPlan;
            break;

            case 'buscarCantdAccesos':
              $idPlan = Utils::getParam('idPlan', '', $this->data);
              $idPlan = (!empty($idPlan)) ? Utils::desencriptar($idPlan) : $idPlan;                 
              $cantd = Modelo_Plan::listadoPlanesUsuario($idUsuario,$tipoUsuario,$idPlan);
              if(!empty($cantd)){
                $cantd_accesos_restantes = array('cantd'=>$cantd[0]['num_accesos_rest']);
              }else{
                $cantd_accesos_restantes = array('cantd'=>0);
              }
              Vista::renderJSON($cantd_accesos_restantes);
            break;

            case 'guardarUsuariosSeleccionados':
                $usuario = Utils::getParam('usuario', '', $this->data);

                if($usuario != ''){
                    $usuarios = explode(',',$usuario);
                    foreach ($usuarios as $key => $id) {
                       array_push($_SESSION['mfo_datos']['usuarioSeleccionado'], $id);
                    }
                }else{
                    $_SESSION['mfo_datos']['usuarioSeleccionado'] = array();
                }
            break;

            default:
                
                $_SESSION['mfo_datos']['Filtrar_aspirantes'] = array('A'=>0,'F'=>0,'P'=>0,'U'=>0,'G'=>0,'S'=>0,'N'=>0,'E'=>0,'D'=>0,'L'=>-1,'T'=>0,'V'=>0,'O'=>1,'Q'=>0,'R'=>0);

                $arrarea       = Modelo_Area::obtieneListadoAsociativo();
                $datosOfertas = Modelo_Oferta::ofertaPostuladoPor($id_oferta); 

                //solo empresa 
                if ($tipoUsuario != Modelo_Usuario::EMPRESA){
                  Utils::doRedirect(PUERTO.'://'.HOST.'/'); 
                }

                $escolaridad      = Modelo_Escolaridad::obtieneListadoAsociativo();
                $situacionLaboral = Modelo_SituacionLaboral::obtieneListadoAsociativo();
                $licencia = Modelo_TipoLicencia::obtieneListadoAsociativo();

                if(isset($_SESSION['mfo_datos']['subempresas'])){
                    $subempresas = $_SESSION['mfo_datos']['subempresas'];  
                    //$array_empresas = explode(",",$subempresas);
                    foreach ($subempresas as $key => $id) {
                        array_push($array_empresas, $key);
                    }
                }

                if($vista == 1){

                    if(isset($datosOfertas[0]['id_empresa']) && !in_array($datosOfertas[0]['id_empresa'], $array_empresas)){
                        $breadcrumbs['vacantes'] = 'Ver Ofertas';
                    }else{
                        $breadcrumbs['cuentas'] = 'Ver Ofertas subempresas';
                    }
                    $breadcrumbs['aspirante'] = 'Ver Aspirantes';

                    $datos_plan = Modelo_Oferta::obtenerPlanOferta($id_oferta);
                    $limite_plan = (int)$datos_plan['limite_perfiles'];
                    $id_plan = $datos_plan['id_plan'];
                    $nombre_plan = $datos_plan['nombre_plan'];
                    $costo = $datos_plan['costo'];
                   
                    $aspirantes = Modelo_Usuario::obtenerAspirantes($id_oferta,$page,$limite_plan,false);
                    $paises = Modelo_Usuario::obtenerAspirantes($id_oferta,$page,$limite_plan,true);

                    if(!empty($limite_plan)){
                        $limite_aspirantes = $limite_plan;
                    }else{
                        $limite_aspirantes = count($paises);
                    }         

                    //$url = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.Utils::encriptar($id_oferta);
                }else{
                    $id_oferta = 0;
                   
                    $breadcrumbs['aspirante'] = 'Buscar Aspirantes';

                    $aspirantes = Modelo_Usuario::busquedaGlobalAspirantes(SUCURSAL_PAISID,$page,false);
                    $paises = Modelo_Usuario::busquedaGlobalAspirantes(SUCURSAL_PAISID,$page,true); 
                    $listado_planes = Modelo_Plan::listadoPlanesUsuario($idUsuario,$tipoUsuario);                    
                    $limite_aspirantes = count($paises);

                    $nombre_plan = '';
                    $limite_plan = '';
                    $id_plan = false;
                    $costo = -1;
                    //$url = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.Utils::encriptar(0);
                }

                $posibilidades = Modelo_UsuarioxPlan::disponibilidadDescarga($idUsuario);
                $descargas = Modelo_Descarga::cantidadDescarga($idUsuario);
                
                $arranacionalidades = Modelo_Pais::obtieneListadoAsociativo();

                $arrprovincia = $nacionalidades = array();
                foreach ($paises as $key => $value) {
                   if (!empty($arranacionalidades[$value['id_pais']])){
                     $nacionalidades[$value['id_pais']] = $arranacionalidades[$value['id_pais']];
                   }
                   $arrprovincia[$value['id_provincia']] = $value['ubicacion'];
                }                            

                $_SESSION['mfo_datos']['nacionalidades'] = $nacionalidades;
                $_SESSION['mfo_datos']['arrprovincia'] = $arrprovincia;                

                if($id_oferta == ''){ 
                    $id_oferta = 0;
                }

                $tags = array(
                    'arrarea'       => $arrarea,
                    'breadcrumbs'=>$breadcrumbs,
                    'arrprovincia'  => $arrprovincia,
                    'nacionalidades'=>$nacionalidades,
                    'escolaridad'=>$escolaridad,
                    'aspirantes'       => $aspirantes,
                    'page' => $page,
                    'mostrar'=>$mostrar,
                    'vista'=>$vista,
                    'id_oferta'=> (!empty($id_oferta)) ? Utils::encriptar($id_oferta) : $id_oferta,
                    'datosOfertas'=>$datosOfertas,
                    'array_empresas'=>$array_empresas,
                    'posibilidades'=>$posibilidades,
                    'descargas'=>$descargas,
                    'facetas'=>$facetas,
                    'datos_usuarios'=>$datos_usuarios,
                    'limite_plan'=>$limite_plan,
                    'nombre_plan'=>$nombre_plan,
                    'costo'=>$costo,
                    'id_plan'=>$id_plan,
                    'listado_planes'=>$listado_planes,
                    'situacionLaboral'=>$situacionLaboral,
                    'licencia'=>$licencia
                );

                $tags["template_js"][] = "ion.rangeSlider.min";
                $tags["template_js"][] = "aspirantes";
                
                $tags["template_css"][] = "ion.rangeSlider";
                $tags["template_css"][] = "ion.rangeSlider.skinModern";
                
                $url = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.((!empty($id_oferta)) ? Utils::encriptar($id_oferta) : $id_oferta);
                $pagination = new Pagination($limite_aspirantes,REGISTRO_PAGINA,$url);
                $pagination->setPage($page);
                $tags['paginas'] = $pagination->showPage();

                Vista::render('aspirantes', $tags);
            break;
        }
    }

    public function perfilAspirante($username, $id_oferta, $vista){
            $data_user = self::datauser($username, $id_oferta, $vista);
            
            $breadcrumbs = array();
            $breadcrumbs['verAspirantes/'.$vista.'/'.$id_oferta."/1"] = "Ver aspirantes";
            $breadcrumbs['perfil'] = 'perfil Candidato ('.$username.')';
            $planes = array();
            if(isset($_SESSION['mfo_datos']['planes'])){
                $planes = $_SESSION['mfo_datos']['planes'];
            }else{
                array_push($planes, array('fecha_caducidad'=>'','num_rest'=>''));
            }

            $enlaceCompraPlan = Vista::display('btnComprarPlan',array('presentarBtnCompra'=>$planes));

            $tags = array("breadcrumbs"=>$breadcrumbs,
                    "infoUsuario"=>$data_user['infoUsuario'],
                    "escolaridad"=>$data_user['escolaridad'],
                    "Conf"=>$data_user['Conf'],
                    "Resultados"=>$data_user['Resultados'],
                    "asp_sararial"=>$data_user['asp_sararial'],
                    "enlaceCompraPlan"=>$enlaceCompraPlan,
                    "id_oferta"=>$id_oferta,
                    "vista"=>$vista
              );
            
        $tags["template_js"][] = "html2canvas.min";
        $tags["template_js"][] = "jsPDF-1.4.1/dist/jspdf.debug";
        //$tags["template_js"][] = "mic";
        $tags["template_js"][] = "Chart.min";
        Vista::render('perfilAspirante', $tags);
    }

    public function datauser($username, $id_oferta, $vista){
        $datos = Modelo_Usuario::existeUsuario($username);
        $info_usuario = Modelo_Usuario::infoUsuario($datos['id_usuario']);
        $escolaridad = Modelo_Escolaridad::obtieneListadoAsociativo();
        $asp_salarial = Modelo_Usuario::aspSalarial($datos['id_usuario'], $id_oferta);
        $contacto = array();
        $array_rasgosxusuario = array();


        if (isset($_SESSION['mfo_datos']['planes']) && !Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'detallePerfilCandidatos')){
                $contacto = ["correo"=>Utils::ocultarEmail($info_usuario['correo']), "telefono"=>Utils::ocultarCaracteres($info_usuario['telefono'], 0, 0), "dni"=>Utils::ocultarCaracteres($info_usuario['dni'], 0, 0)];
            }
            else{
                $contacto = ["correo"=>$info_usuario['correo'], "telefono"=>$info_usuario['telefono'], "dni"=>$info_usuario['dni']];
            }

        if (isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'descargarInformePerso')){
                $cuestionariosUsuario = Modelo_Cuestionario::listadoCuestionariosxUsuario($info_usuario['id_usuario']);
                
                $resultados = array();
                $rasgoxtest = array();
                foreach ($cuestionariosUsuario as $cuestionarios) {
                  $test = "Test".$cuestionarios['id_cuestionario'];
                  $rasgoxtest = Modelo_InformePDF::obtieneValorxRasgoxTest($info_usuario['id_usuario'], $cuestionarios['id_cuestionario']);
                  foreach ($rasgoxtest as $res) {
                    array_push($array_rasgosxusuario, array("nombre"=>$res['nombre'], "valor"=>$res['valor']));
                  }
                }
            }

        return array("infoUsuario"=>$info_usuario,
                    "escolaridad"=>$escolaridad,
                    "Conf"=>$contacto,
                    "Resultados"=>$array_rasgosxusuario,
                    "asp_sararial"=>$asp_salarial);
    }

}
?>
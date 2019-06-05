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
        if(isset($_SESSION['mfo_datos']['planes'])){

            if($vista == 1 && !Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'buscarCandidatosPostulados')){
                $_SESSION['mostrar_error'] = 'Su plan no permite ver inscritos';
               $this->redirectToController('vacantes');
            }elseif($vista == 2 && !Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'buscarCandidatos')){
                $_SESSION['mostrar_error'] = 'Su plan no permite ver candidatos registrados';
                $this->redirectToController('vacantes');
            }
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

        if(($vista != '' && $vista != $_SESSION['mfo_datos']['ultimaVistaActiva']) || ($opcion == 'filtrar' && $vista != $_SESSION['mfo_datos']['ultimaVistaActiva'])){

            unset($_SESSION['mfo_datos']['accesos']);
            unset($_SESSION['mfo_datos']['planSeleccionado']);
            $_SESSION['mfo_datos']['usuarioSeleccionado'] = array();
            $_SESSION['mfo_datos']['ultimaVistaActiva'] = $vista;
            $_SESSION['mfo_datos']['usuariosHabilitados'] = array(); 
        }

        if(!isset($_SESSION['mfo_datos']['Filtrar_aspirantes'])){
            $_SESSION['mfo_datos']['Filtrar_aspirantes'] = array('A'=>0,/*'F'=>0,*/'P'=>0,'U'=>0,'G'=>0,'S'=>0,'N'=>0,'E'=>0,'D'=>0,'L'=>-1,'T'=>0,'V'=>0,'O'=>1,'Q'=>0,'R'=>0,'C'=>0);
        }

        $facetas = Modelo_Faceta::obtenerFacetas();
        $cantd_facetas = count($facetas);
        $datos_usuarios = Modelo_PorcentajexFaceta::usuariosxfaceta();


        switch ($opcion) {
            case 'filtrar':       

                $enviar_accesos = Utils::getParam('enviar_accesos', '', $this->data);
                $arrarea       = Modelo_Area::obtieneListadoAsociativo();
                $arrprovincia  = Modelo_Provincia::obtieneListadoAsociativo(SUCURSAL_PAISID);
                $nacionalidades       = Modelo_Pais::obtieneListadoAsociativo();
                $escolaridad      = Modelo_Escolaridad::obtieneListadoAsociativo();
                $datosOfertas = Modelo_Oferta::ofertaPostuladoPor($id_oferta);
                $situacionLaboral = Modelo_SituacionLaboral::obtieneListadoAsociativo();
                $licencia = Modelo_TipoLicencia::obtieneListadoAsociativo();
                $usuariosConAccesos = Modelo_AccesoEmpresa::obtenerUsuariosConAccesos($idUsuario);
                $planes = $datosOferta = array();

                unset($this->data['mostrar'],$this->data['opcion'],$this->data['page'],$this->data['type'],$this->data['id_oferta'],$this->data['vista'],$this->data['enviar_accesos']);

                $cadena = '';
                $array_datos = $aspirantesFiltrados = array();

                if($vista == 1){
                    $datos_plan = Modelo_Oferta::obtenerPlanOferta($id_oferta);
                    $limite_plan = (int)$datos_plan['limite_perfiles'];
                    $id_plan = $datos_plan['id_plan'];
                    $id_empresa_plan = $datos_plan['id_empresa_plan'];
                    $num_accesos_rest = $datos_plan['num_accesos_rest'];
                    $nombre_plan = $datos_plan['nombre_plan'];
                    $costo = $datos_plan['costo'];
                }else{
                    $nombre_plan = '';
                    $limite_plan = '';
                    $id_plan = false;
                    $id_empresa_plan = false;
                    $num_accesos_rest = 0;
                    $costo = -1;
                }

                foreach ($this->data as $param => $value) {
                    
                    $letra = substr($value,0,1);
                    $id = substr($value,1);
                    $cadena .= '/'.$value;
                    /*if($letra == 'F' && $type == 1){
                        
                        if(isset(FECHA_POSTULADO[$id])){
                            $_SESSION['mfo_datos']['Filtrar_aspirantes'][$letra] = $id;
                        }
                    }else */if($letra == 'C' && $type == 1){
                          
                        if(isset(EDADES[$id])){
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

                        /*if($letra == 'F'){
                            if(isset(FECHA_POSTULADO[$value])){
                                $array_datos[$letra] = array('id'=>$value,'nombre'=>FECHA_POSTULADO[$value]);
                            }
                        }*/

                        if($letra == 'A'){
                            if(isset($arrarea[$value])){
                                $array_datos[$letra] = array('id'=>$value,'nombre'=>$arrarea[$value]);
                            }
                        }

                        if($letra == 'C'){
                            if(isset(EDADES[$value])){
                                $array_datos[$letra] = array('id'=>$value,'nombre'=>EDADES[$value]);
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
                                    $array_datos[$letra] = array('id'=>$value,'nombre'=>'Sin licencia');
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

                    /*$datos_plan = Modelo_Oferta::obtenerPlanOferta($id_oferta);
                    $limite_plan = (int)$datos_plan['limite_perfiles'];
                    $id_plan = $datos_plan['id_plan'];
                    $id_empresa_plan = $datos_plan['id_empresa_plan'];
                    $num_accesos_rest = $datos_plan['num_accesos_rest'];
                    $nombre_plan = $datos_plan['nombre_plan'];
                    $costo = $datos_plan['costo'];*/

                    $filtros = $_SESSION['mfo_datos']['Filtrar_aspirantes'];
                    //print_r($filtros);
                    $fill = true;
                    if(empty($filtros['A']) && empty($filtros['P']) && empty($filtros['U']) && empty($filtros['G']) && empty($filtros['S']) && empty($filtros['N']) && empty($filtros['E']) && empty($filtros['D']) && $filtros['L'] == -1 && empty($filtros['V']) /*&& $filtros['O'] == 1 */&& empty($filtros['Q']) && empty($filtros['R']) && empty($filtros['C']) && empty($filtros['T'])){
                        /*echo 'limite_filtrado: '.*/$limite_filtrado = '';
                    }else{
                        /*echo 'limite_filtrado: '.*/$limite_filtrado = $limite_plan;
                        $fill = false;
                    }

                    $aspirantesFiltrados    = Modelo_Usuario::filtrarAspirantes($id_oferta,$filtros,$page,$facetas,$limite_filtrado,false);
                    $cantd_aspirantes = Modelo_Usuario::filtrarAspirantes($id_oferta,$filtros,$page,$facetas,$limite_filtrado,$fill);
                    $cantd_total = count($cantd_aspirantes);

                    $_SESSION['mfo_datos']['Filtrar_aspirantes'] = $filtros;

                    if(!empty($limite_plan)){

                        foreach ($_SESSION['mfo_datos']['planes'] as $plan) {
                          $planUsuario = Modelo_UsuarioxPlan::consultarRecursosAretornar($plan['id_empresa_plan']);
                            if($plan['num_rest'] > 0){
                              array_push($planes, $planUsuario);
                            }
                        }

                        /*if($limite_plan >= count($cantd_aspirantes)){
                            $limite_aspirantes = count($cantd_aspirantes);
                        }else{
                            $limite_aspirantes = $limite_plan;
                        }*/
                    }/*else{*/
                        $limite_aspirantes = $cantd_total;
                    //} 

                }else{

                    $id_oferta = 0;
                    $breadcrumbs['vacantes'] = 'Ver Ofertas';
                    $breadcrumbs['aspirante'] = 'Ver Aspirantes';
                    $cantd_aspirantes = Modelo_Usuario::filtrarAspirantesGlobal(SUCURSAL_PAISID,$_SESSION['mfo_datos']['Filtrar_aspirantes'],$page,$facetas,true);
                    $aspirantesFiltrados    = Modelo_Usuario::filtrarAspirantesGlobal(SUCURSAL_PAISID,$_SESSION['mfo_datos']['Filtrar_aspirantes'],$page,$facetas,false);
                    $listado_planes = Modelo_Plan::listadoPlanesUsuario($idUsuario,$tipoUsuario);
                    $limite_aspirantes = count($cantd_aspirantes);
                }

                $ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.((!empty($id_oferta)) ? Utils::encriptar($id_oferta) : $id_oferta) .'/'.$type.$cadena;
                if(!empty($enviar_accesos)){

                    $this->enviarAccesos($idUsuario,$tipoUsuario,$ruta.'/'.$page.'/',$vista,$cantd_facetas,$id_empresa_plan);
                }

                $posibilidades = Modelo_UsuarioxPlan::disponibilidadDescarga($idUsuario,$id_oferta);
                $descargas = Modelo_Descarga::descargas($idUsuario,$id_oferta);

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
                    'ruta_redirect'=>$ruta,
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
                    'id_empresa_plan'=>$id_empresa_plan,
                    'listado_planes'=>$listado_planes,
                    'situacionLaboral'=>$situacionLaboral,
                    'licencia'=>$licencia,
                    'usuariosConAccesos'=>$usuariosConAccesos,
                    'num_accesos_rest'=>$num_accesos_rest,
                    'cantd_total'=>$cantd_total,
                    'planes'=>$planes
                );
         
                //$url = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.((!empty($id_oferta)) ? Utils::encriptar($id_oferta) : $id_oferta) .'/'.$type.$cadena;

                $pagination = new Pagination($limite_aspirantes,REGISTRO_PAGINA,$ruta);
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
                    if (isset($_SESSION['mfo_datos']['planes']) && !Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'detallePerfilCandidatos')){
                        Utils::doRedirect(PUERTO . '://' . HOST . '/planes/');
                    }
                    $this->perfilAspirante($username, $id_oferta, $vista);
                }
            break;

            case 'activarAccesos':
                $accesos = Utils::getParam('accesos', '', $this->data);
                $vista = Utils::getParam('vista', '', $this->data);
                $_SESSION['mfo_datos']['accesos'] = $accesos;

                if($accesos == 0){
                    $_SESSION['mfo_datos']['planSeleccionado'] = 0;
                    $_SESSION['mfo_datos']['usuarioSeleccionado'] = array();
                    $_SESSION['mfo_datos']['usuariosHabilitados'] = array();
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
                $marcar = Utils::getParam('marcar', '0', $this->data);
                //$marcarTo = 0;

                if($usuario != ''){
                    $usuarios = explode(',',$usuario);
                }else{
                    $usuarios = array();
                }

                if(count($usuarios) > 0){
                    
                    if(count($usuarios) >= 1 && $marcar == 1){
                        foreach ($usuarios as $key => $id) {
                            if(!in_array($id,$_SESSION['mfo_datos']['usuarioSeleccionado'])){
                                array_push($_SESSION['mfo_datos']['usuarioSeleccionado'], $id);
                            }
                        }
                    }else if(count($usuarios) == 1 && $marcar == 0){
                        $clave = array_search($usuarios[0], $_SESSION['mfo_datos']['usuarioSeleccionado']);
                        unset($_SESSION['mfo_datos']['usuarioSeleccionado'][$clave]);
                    }
                }else{
                    $_SESSION['mfo_datos']['usuarioSeleccionado'] = array();
                }

                /*if(count($_SESSION['mfo_datos']['usuarioSeleccionado']) == count($_SESSION['mfo_datos']['usuariosHabilitados'])){
                    $marcarTo = 1;
                }
                Vista::renderJSON(array('marcarTo'=>$marcarTo));*/
            break;

            default:
                
                unset($_SESSION['mfo_datos']['usuario']['ofertaConvertir']);
                $_SESSION['mfo_datos']['Filtrar_aspirantes'] = array('A'=>0,/*'F'=>0,*/'P'=>0,'U'=>0,'G'=>0,'S'=>0,'N'=>0,'E'=>0,'D'=>0,'L'=>-1,'T'=>0,'V'=>0,'O'=>1,'Q'=>0,'R'=>0, 'C'=>0);

                $arrarea       = Modelo_Area::obtieneListadoAsociativo();
                $datosOfertas = Modelo_Oferta::ofertaPostuladoPor($id_oferta); 
                $usuariosConAccesos = Modelo_AccesoEmpresa::obtenerUsuariosConAccesos($idUsuario);
                $planes = array();

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
                    $id_empresa_plan = $datos_plan['id_empresa_plan'];
                    $num_accesos_rest = $datos_plan['num_accesos_rest'];
                    $nombre_plan = $datos_plan['nombre_plan'];
                    $costo = $datos_plan['costo'];
                   
                    $aspirantes = Modelo_Usuario::obtenerAspirantes($id_oferta,$page,'',$cantd_facetas,false);
                    $paises = Modelo_Usuario::obtenerAspirantes($id_oferta,$page,'',$cantd_facetas,true);
                    $cantd_total = count($paises);

                    $_SESSION['mfo_datos']['usuario']['cantd_total'] = array($id_oferta=>$cantd_total);
                    if(!empty($limite_plan)){
                        
                        foreach ($_SESSION['mfo_datos']['planes'] as $plan) {
                          $planUsuario = Modelo_UsuarioxPlan::consultarRecursosAretornar($plan['id_empresa_plan']);
                            if($plan['num_rest'] > 0){
                              array_push($planes, $planUsuario);
                            }
                        }

                        /*if($limite_plan >= $cantd_total){
                            $limite_aspirantes = $cantd_total;
                        }else{
                            $limite_aspirantes = $limite_plan;
                        }*/
                    }/*else{*/
                        $limite_aspirantes = $cantd_total;
                    //}         

                    //$url = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.Utils::encriptar($id_oferta);
                }else{
                    $id_oferta = 0;
                   
                    $breadcrumbs['aspirante'] = 'Buscar Aspirantes';

                    $aspirantes = Modelo_Usuario::busquedaGlobalAspirantes(SUCURSAL_PAISID,$cantd_facetas,$page,false);
                    $paises = Modelo_Usuario::busquedaGlobalAspirantes(SUCURSAL_PAISID,$cantd_facetas,$page,true); 
                    $listado_planes = Modelo_Plan::listadoPlanesUsuario($idUsuario,$tipoUsuario);                    
                    $limite_aspirantes = count($paises);
                    $cantd_total = count($paises);

                    $nombre_plan = '';
                    $limite_plan = '';
                    $id_plan = false;
                    $id_empresa_plan = false;
                    $num_accesos_rest = 0;
                    $costo = -1;
                    //$url = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.Utils::encriptar(0);
                }

                $enviar_accesos = Utils::getParam('enviar_accesos', '', $this->data);
                $ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.((!empty($id_oferta)) ? Utils::  encriptar($id_oferta) : $id_oferta);
                if(!empty($enviar_accesos)){

                    $this->enviarAccesos($idUsuario,$tipoUsuario,$ruta.'/'.$page.'/',$vista,$cantd_facetas,$id_empresa_plan);
                }

                $posibilidades = Modelo_UsuarioxPlan::disponibilidadDescarga($idUsuario,$id_oferta);
                $descargas = Modelo_Descarga::descargas($idUsuario,$id_oferta);
                
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
                    'ruta_redirect'=>$ruta,
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
                    'id_empresa_plan'=>$id_empresa_plan,
                    'listado_planes'=>$listado_planes,
                    'situacionLaboral'=>$situacionLaboral,
                    'licencia'=>$licencia,
                    'usuariosConAccesos'=>$usuariosConAccesos,
                    'num_accesos_rest'=>$num_accesos_rest,
                    'cantd_total'=>$cantd_total,
                    'planes'=>$planes
                );

                $tags["template_js"][] = "ion.rangeSlider.min";
                $tags["template_js"][] = "aspirantes";
                
                $tags["template_css"][] = "ion.rangeSlider";
                $tags["template_css"][] = "ion.rangeSlider.skinModern";
                
                //$url = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.((!empty($id_oferta)) ? Utils::encriptar($id_oferta) : $id_oferta);

                $pagination = new Pagination($limite_aspirantes,REGISTRO_PAGINA,$ruta);
                $pagination->setPage($page);
                $tags['paginas'] = $pagination->showPage();
                //print_r($tags);
                Vista::render('aspirantes', $tags);
            break;
        }
    }

    public function perfilAspirante($username, $id_oferta, $vista){
            if($vista == 1){
                $planOferta = Modelo_Oferta::obtenerPlanOferta($id_oferta);
                $id_plan = $planOferta['id_plan'];
                if(!Modelo_PermisoPlan::busquedaPermisoxPlan($id_plan, 'detallePerfilCandidatos')){
                    Utils::doRedirect(PUERTO . '://' . HOST . '/planes/');  
                }
            }
            $data_user = self::datauser($username, $id_oferta, $vista);
            $breadcrumbs = array();
            $breadcrumbs['verAspirantes/'.$vista.'/'.Utils::encriptar($id_oferta)."/1"] = "Ver aspirantes";
            $breadcrumbs['perfil'] = 'perfil Candidato ('.$username.')';
            $enlaceCompraPlan = Vista::display('btnComprarPlan',array('presentarBtnCompra'=>$planes));
            $tags["template_js"][] = "detalleperfil";
            $tags1 = array("breadcrumbs"=>$breadcrumbs,
                    "datosUsuario"=>$data_user,
                    "enlaceCompraPlan"=>$enlaceCompraPlan,
                    "id_oferta"=>$id_oferta,
                    "vista"=>$vista
              );
            $tags = array_merge($tags, $tags1);
        Vista::render('perfilAspirante', $tags);
    }

    public function datauser($username, $id_oferta, $vista){
        $datos = Modelo_Usuario::existeUsuario($username);
        $mfoUsuario = Modelo_Usuario::informacionPerfilUsuario($datos['id_usuario']);
        $datos = array_merge($datos, $mfoUsuario);
        if($vista == 1){
            $aspSalarial = Modelo_Usuario::aspSalarial($datos['id_usuario'], $id_oferta);
            $datos = array_merge($datos, array('aspSalarial'=>$aspSalarial['asp_salarial']));
        }
        $classHidden = "";
        $usuarioxarea = Modelo_UsuarioxArea::listado($datos['id_usuario']);
        $dataareasubarea = array();
        foreach ($usuarioxarea as $key=>$value) {
            array_push($dataareasubarea, $value['id_areas_subareas']);
        }
        $dataareasubarea = implode(",", $dataareasubarea);
        $areasubarea = Modelo_UsuarioxAreaSubarea::obtieneAreas_Subareas($dataareasubarea);
        $array_group = array();
        foreach ($areasubarea as $key => $value) {
            $array_group[$value['id_area']][$key] = $value;
        }
        $areasubarea = $array_group;
        $usuarioxnivelidioma = Modelo_UsuarioxNivelIdioma::obtenerIdiomasUsuario($datos['id_usuario']);
        $datos = array_merge($datos, array("usuarioxarea"=>$areasubarea));
        $datos = array_merge($datos, array("usuarioxnivelidioma"=>$usuarioxnivelidioma));
        return $datos;
        
    }

    public function enviarAccesos($idUsuario,$tipoUsuario,$ruta,$vista,$cantd_facetas,$id_plan=false){

        try{

            $GLOBALS['db']->beginTrans();
            $u = '';

            //verificar que existan las variables de session llenas
            if(($vista == 2 && isset($_SESSION['mfo_datos']['planSeleccionado']) && isset($_SESSION['mfo_datos']['usuarioSeleccionado'])) || ($vista == 1 && isset($_SESSION['mfo_datos']['usuarioSeleccionado']))){

                if($vista == 1){
                    $idPlan = $id_plan;
                }else{
                    $plan = $_SESSION['mfo_datos']['planSeleccionado'];
                    $idPlan = (!empty($plan)) ? Utils::desencriptar($plan) : '';
                }

                if($idPlan != ''){
                    $cantd = Modelo_Plan::listadoPlanesUsuario($idUsuario,$tipoUsuario,$idPlan);

                    //Consultar que el plan tenga realmente la cantidad de accesos disponibles para los que selecciono
                    if(!empty($cantd) && $cantd[0]['num_accesos_rest'] >= count($_SESSION['mfo_datos']['usuarioSeleccionado'])){

                        if(!empty($_SESSION['mfo_datos']['usuarioSeleccionado'])){

                            $usuarios = $_SESSION['mfo_datos']['usuarioSeleccionado'];
                            foreach ($usuarios as $key => $id) {
                                if($u == ''){
                                    $u = Utils::desencriptar($id);
                                }else{
                                    $u .= ','.Utils::desencriptar($id);
                                }
                            } 

                            //consultar los datos de los usuarios seleccionados
                            $datos_usuarios = Modelo_Usuario::obtenerDatos($u);

                            //consultar los id de los usuarios y que tengan el informe incompleto para esa empresa y asi enviar los correos
                            $usuariosTestIncompletos = Modelo_Usuario::consultarTestIncompleto($u,$cantd_facetas);

                            $usuariosEnviosPrevios = Modelo_AccesoEmpresa::consultarEnvioPrevio($usuariosTestIncompletos,$idUsuario);

                            $usuarios_con_accesos = Modelo_AccesoEmpresa::obtenerAccesosDistintaEmp($idUsuario);

                            if(!empty($usuariosTestIncompletos)){
                                $a1 = explode(",",$usuariosTestIncompletos);
                            }else{
                                $a1 = array();
                            }

                            if(!empty($usuariosEnviosPrevios)){
                                $a2 = explode(",",$usuariosEnviosPrevios);
                            }else{
                                $a2 = array();
                            }
                            //print_r($usuarios_con_accesos); 
                            //print_r($a1); 
                            //La diferencia de los usuarios en $usuariosTestIncompletos y $usuariosEnviosPrevios permitirá saber a cuales usuarios deben enviarsele el correo para que completen el test
                            $diff = array_diff($a1,$a2);

                            //print_r($diff); //exit;

                            //print_r($usuarios_con_accesos); 
                            //exit;
                            $email_body = Modelo_TemplateEmail::obtieneHTML("ENVIO_ACCESO");
                            $fecha = date('Y-m-d H:i:s');
                            $cantd_a_restar = 0;
                            foreach ($diff as $key => $id) {
                                
                                if(Modelo_AccesoEmpresa::guardarAcceso($id,$fecha,$idPlan,$idUsuario)){
                                    $cantd_a_restar++;

                                    if(!in_array($id, $usuarios_con_accesos)){
                                        //echo 'enviara correo a: '.$id;
                                        $datos = $datos_usuarios[$id];
                                        $nombre_mostrar = utf8_encode($datos["nombres"])." ".utf8_encode($datos["apellidos"]);    
                                        $template = $email_body;
                                        $enlace = PUERTO.'://'.HOST.'/login/';

                                        $notif_body = "Estimado <b>".$nombre_mostrar."</b>.<br><br>Hoy (".$fecha.") una importante empresa del sector est&aacute; interesado en su perfil y desea conocer un poco m&aacute;s de usted, complete el test si desea continuar en el proceso de selecci&oacute;n";

                                        $template = str_replace("%NOMBRES%", $nombre_mostrar, $template);
                                        $template = str_replace("%ENLACE%", $enlace, $template);      
                                        $template = str_replace("%FECHA%", $fecha, $template);

                                        Utils::envioCorreo($datos['correo'],"Completar Test C.A.N.E.A",$template);

                                        Modelo_Notificacion::insertarNotificacion($id,$notif_body,Modelo_Usuario::CANDIDATO,Modelo_Notificacion::DESBLOQUEO_ACCESO);
                                    }
                                }else{
                                    throw new Exception("Ha ocurrido un error al enviar los accesos, intente nuevamente1");
                                }
                            }
                            
                            //Descontar la cantidad de accesos enviados de los restantes del plan
                            if(!Modelo_UsuarioxPlan::restarNumeroAccesos($idPlan,$cantd_a_restar)){
                                throw new Exception("Ha ocurrido un error al enviar los accesos, intente nuevamente3");
                            }
                        }else{
                            throw new Exception("No selecciono ning\u00FAn usuario, intente nuevamente");
                        }
                    }else{
                        throw new Exception("La cantidad de usuarios seleccionados supera el l\u00EDmite del plan, intente nuevamente");
                    }
                }else{
                    throw new Exception("Debe seleccionar un plan, intente nuevamente");
                }
            }else{
                throw new Exception("Ha ocurrido un error al enviar los accesos, intente nuevamente4");
            }

            $GLOBALS['db']->commit();
            $_SESSION['mostrar_exito'] = 'Los accesos fueron enviados satisfactoriamente.';
            unset($_SESSION['mfo_datos']['accesos']);
            unset($_SESSION['mfo_datos']['planSeleccionado']);
            $_SESSION['mfo_datos']['usuarioSeleccionado'] = array();
            $_SESSION['mfo_datos']['ultimaVistaActiva'] = $vista;
            $_SESSION['mfo_datos']['usuariosHabilitados'] = array(); 
            Utils::doRedirect($ruta); 

        }catch (Exception $e) {
          $_SESSION['mostrar_error'] = $e->getMessage();
          $GLOBALS['db']->rollback();
        }
    }

}
?>
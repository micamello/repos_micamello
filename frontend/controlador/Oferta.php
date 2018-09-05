<?php
class Controlador_Oferta extends Controlador_Base
{

    public function __construct()
    {
        global $_SUBMIT;
        $this->data = $_SUBMIT;
    }

    public function construirPagina()
    {

        if (!Modelo_Usuario::estaLogueado()) {
            Utils::doRedirect(PUERTO . '://' . HOST . '/login/');
        }

        //Obtiene todos los banner activos segun el tipo
        $arrbanner     = Modelo_Banner::obtieneListado(Modelo_Banner::BANNER_CANDIDATO);

        //Muestra solo un banner de tipo candidato para no dar impresion que cambia de pagina
        $orden = 0;
        $_SESSION['mostrar_banner'] = PUERTO . '://' . HOST . '/imagenes/banner/' . $arrbanner[$orden]['id_banner'] . '.' . $arrbanner[$orden]['extension'];

        $arrbanner = Modelo_Banner::obtieneListado(Modelo_Banner::PUBLICIDAD);

        //obtiene el orden del banner de forma aleatoria segun la cantidad de banner
        $orden = rand(1, count($arrbanner)) - 1;
        $_SESSION['publicidad'] = PUERTO . '://' . HOST . '/imagenes/banner/' . $arrbanner[$orden]['id_banner'] . '.' . $arrbanner[$orden]['extension'];

        $mostrar = Utils::getParam('mostrar', '', $this->data);
        $opcion = Utils::getParam('opcion', '', $this->data);
        $page = Utils::getParam('page', '1', $this->data);
        $type = Utils::getParam('type', '', $this->data); 
        $vista = Utils::getParam('vista', '', $this->data);
        $postulacionesUserLogueado = array();
        $breadcrumbs = array();

        switch ($opcion) {
            case 'filtrar':

                $arrarea       = Modelo_Area::obtieneListadoAsociativo();
                $arrprovincia  = Modelo_Provincia::obtieneListadoAsociativo();
                $arrjornadas      = Modelo_Jornada::obtieneListadoAsociativo();
                $tiposContrato = Modelo_TipoContrato::obtieneListadoAsociativo();

                unset($this->data['mostrar'],$this->data['opcion'],$this->data['page'],$this->data['type'],$this->data['vista']);
                
                if($vista == 'oferta'){
                    $postulacionesUserLogueado = Modelo_Postulacion::obtienePostulaciones($_SESSION['mfo_datos']['usuario']['id_usuario']);
                    $breadcrumbs['oferta'] = 'Ofertas de empleo';
                }else if($vista == 'vacantes'){
                    $breadcrumbs['oferta'] = 'Mis Vacantes';
                }else{
                    $breadcrumbs['postulacion'] = 'Mis postulaciones';
                }

                $id_area = '';
                $id_provincia = '';
                $id_jornada = '';
                $id_contrato = '';
                $cadena = '';
                $array_datos = $result = array();
                foreach ($this->data as $param => $value) {
                    
                    $letra = substr($value,0,1);
                    $id = substr($value,1,2);
                    $cadena .= '/'.$value;
                    array_push($result, strval($value));

                    if($letra == 'A' && $type == 1){
                        
                        $_SESSION['mfo_datos']['Filtrar_ofertas']['A'] = $id;
                        $id_area = $id;
                        $array_datos['A'] = array('id'=>$id,'nombre'=>$arrarea[$id_area]);

                    }
                    else if($letra == 'P' && $type == 1){
                        
                        $_SESSION['mfo_datos']['Filtrar_ofertas']['P'] = $id;
                        $id_provincia = $id;
                        $array_datos['P'] = array('id'=>$id,'nombre'=>$arrprovincia[$id_provincia]);

                    }
                    else if($letra == 'J' && $type == 1){
                        
                        $_SESSION['mfo_datos']['Filtrar_ofertas']['J'] = $id;
                        $id_jornada = $id;
                        $array_datos['J'] = array('id'=>$id,'nombre'=>$arrjornadas[$id_jornada]);

                    }
                    else if($letra == 'C' && $type == 1){
                        
                        $_SESSION['mfo_datos']['Filtrar_ofertas']['C'] = $id;
                        $id_contrato = $id;
                        $array_datos['C'] = array('id'=>$id,'nombre'=>$tiposContrato[$id_contrato]);

                    }else if($type == 2){

                        $_SESSION['mfo_datos']['Filtrar_ofertas'][$letra] = 0;
                    }
                }

                foreach ($_SESSION['mfo_datos']['Filtrar_ofertas'] as $letra => $value) {

                    if($value!=0){

                        if($letra == 'A'){
                            $array_datos[$letra] = array('id'=>$value,'nombre'=>$arrarea[$value]);
                        }

                        if($letra == 'P'){
                            $array_datos[$letra] = array('id'=>$value,'nombre'=>$arrprovincia[$value]);
                        }
                        if($letra == 'J'){
                            $array_datos[$letra] = array('id'=>$value,'nombre'=>$arrjornadas[$value]);
                        }
                        if($letra == 'C'){
                            $array_datos[$letra] = array('id'=>$value,'nombre'=>$tiposContrato[$value]);
                        }
                    }
                }

                $postulacionesFiltradas    = Modelo_Oferta::filtrarOfertas($_SESSION['mfo_datos']['Filtrar_ofertas']['A'],$_SESSION['mfo_datos']['Filtrar_ofertas']['P'],$_SESSION['mfo_datos']['Filtrar_ofertas']['J'],$_SESSION['mfo_datos']['Filtrar_ofertas']['C'],$page,$vista);

                $link = Vista::display('filtrarOfertas',array('data'=>$array_datos,'page'=>$page,'mostrar'=>$mostrar,'vista'=>$vista)); 
                 
                $tags = array(
                    'breadcrumbs'=>$breadcrumbs,
                    'arrarea'       => $arrarea,
                    'tiposContrato' => $tiposContrato,
                    'arrprovincia'  => $arrprovincia,
                    'jornadas'      => $arrjornadas,
                    'ofertas'       => $postulacionesFiltradas,
                    'postulacionesUserLogueado' => $postulacionesUserLogueado,
                    'link'=>$link,
                    'page' =>$page,
                    'mostrar'=>$mostrar,
                    'vista'=>$vista
                );

                if($vista != 'vacantes'){
                    $tags["show_banner"] = 1;
                }
                
                $tags["template_js"][] = "oferta";
  
                $url = PUERTO.'://'.HOST.'/'.$vista.'/'.$type.$cadena;
                
                $pagination = new Pagination(count($postulacionesFiltradas),REGISTRO_PAGINA,$url);
                $pagination->setPage($page);
                $tags['paginas'] = $pagination->showPage();

                Vista::render('ofertas', $tags);
            break;
    
            case 'detalleOferta':

                //solo candidatos 
                if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::CANDIDATO){
                  Utils::doRedirect(PUERTO.'://'.HOST.'/'); 
                }

                $idOferta = Utils::getParam('id', '', $this->data);
                $status = Utils::getParam('status', '', $this->data);
                $oferta = Modelo_Oferta::obtieneOfertas($idOferta,$page);
                $idUsuario = $_SESSION['mfo_datos']['usuario']['id_usuario'];

                if (Utils::getParam('postulado') == 1) {

                    if(!empty($status)){
                        self::guardarEstatus($idUsuario,$idOferta,$status);
                    }else{
                        self::guardarPostulacion($idUsuario,$idOferta,$vista);
                    }
                }

                $postulado = Modelo_Postulacion::obtienePostuladoxUsuario($idUsuario,$idOferta);

                $breadcrumbs[Modelo_Oferta::NOMBRE_OFERTA[$vista]] = ucfirst(Modelo_Oferta::NOMBRE_OFERTA[$vista]);
                $breadcrumbs['detalleOferta'] = 'Ver detalle';

                $tags = array(
                    'breadcrumbs'=>$breadcrumbs,
                    'oferta'=> $oferta,
                    'postulado'=>$postulado,
                    'vista'=>$vista
                );

                $tags["show_banner"] = 1;
                Vista::render('detalle_oferta', $tags);
            break;

            case 'vacantes':

                $vista = $opcion;

                //solo empresas
                if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::EMPRESA){
                  Utils::doRedirect(PUERTO.'://'.HOST.'/'); 
                }

                $_SESSION['mfo_datos']['Filtrar_ofertas'] = array('A'=>0,'P'=>0,'J'=>0,'C'=>0);
                $arrarea       = Modelo_Area::obtieneListadoAsociativo();
                $arrprovincia  = Modelo_Provincia::obtieneListadoAsociativo();
                $jornadas      = Modelo_Jornada::obtieneListadoAsociativo();
                $tiposContrato = Modelo_TipoContrato::obtieneListadoAsociativo();
                $ofertas = Modelo_Oferta::obtieneOfertas(false,$page,$vista);

                $breadcrumbs['oferta'] = 'Mis vacantes';

                $tags = array(
                    'breadcrumbs'=>$breadcrumbs,
                    'arrarea'       => $arrarea,
                    'tiposContrato' => $tiposContrato,
                    'arrprovincia'  => $arrprovincia,
                    'jornadas'      => $jornadas,
                    'ofertas'       => $ofertas,
                    'page' => $page,
                    'mostrar'=>$mostrar,
                    'vista'=>$vista
                );

                $tags["template_js"][] = "oferta";

                $url = PUERTO.'://'.HOST.'/'.$vista;
                $pagination = new Pagination(count($ofertas),REGISTRO_PAGINA,$url);
                $pagination->setPage($page);
                $tags['paginas'] = $pagination->showPage();

                Vista::render('ofertas', $tags);

            break;

            default:
                
                //solo candidatos 
                if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::CANDIDATO){
                  Utils::doRedirect(PUERTO.'://'.HOST.'/'); 
                }

                $eliminarPostulacion = Utils::getParam('eliminarPostulacion', '', $this->data);

                if(!empty($eliminarPostulacion)){
                    $r = Modelo_Postulacion::eliminarPostulacion($eliminarPostulacion);
                    if(!$r){
                        $_SESSION['mostrar_error'] = 'No se pudo eliminar la postulación, intente de nuevo';
                    }else{
                        $_SESSION['mostrar_exito'] = 'Se ha eliminado la postulacion exitosamente';
                    }
                }

                $_SESSION['mfo_datos']['Filtrar_ofertas'] = array('A'=>0,'P'=>0,'J'=>0,'C'=>0);
                $arrarea       = Modelo_Area::obtieneListadoAsociativo();
                $arrprovincia  = Modelo_Provincia::obtieneListadoAsociativo();
                $jornadas      = Modelo_Jornada::obtieneListadoAsociativo();
                $tiposContrato = Modelo_TipoContrato::obtieneListadoAsociativo();
                $ofertas = Modelo_Oferta::obtieneOfertas(false,$page,$vista);

                if($vista != 'postulacion'){
                    $postulacionesUserLogueado = Modelo_Postulacion::obtienePostulaciones($_SESSION['mfo_datos']['usuario']['id_usuario'],$page);
                    $breadcrumbs['oferta'] = 'Ofertas de empleo';
                }else{
                    $breadcrumbs['postulacion'] = 'Mis postulaciones';
                }

                $tags = array(
                    'breadcrumbs'=>$breadcrumbs,
                    'arrarea'       => $arrarea,
                    'tiposContrato' => $tiposContrato,
                    'arrprovincia'  => $arrprovincia,
                    'jornadas'      => $jornadas,
                    'ofertas'       => $ofertas,
                    'postulacionesUserLogueado' => $postulacionesUserLogueado,
                    'page' => $page,
                    'mostrar'=>$mostrar,
                    'vista'=>$vista
                );

                $tags["template_js"][] = "oferta";
                $tags["show_banner"] = 1;
                
                $url = PUERTO.'://'.HOST.'/'.$vista;
                $pagination = new Pagination(count($ofertas),REGISTRO_PAGINA,$url);
                $pagination->setPage($page);
                $tags['paginas'] = $pagination->showPage();

                Vista::render('ofertas', $tags);
                break;
        }
    }

    public function guardarPostulacion($id_usuario,$id_oferta,$vista){

        try{

            if (isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'postulacion') && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) {

                if (!Modelo_Postulacion::postularse($id_usuario,$id_oferta)) {
                    throw new Exception("Ha ocurrido un error la postulación, intente nuevamente");
                }
                $GLOBALS['db']->commit();
                $_SESSION['mostrar_exito'] = 'Se ha postulado a esta oferta exitosamente';

            }else{

                $_SESSION['mostrar_error'] = "No tiene permiso para postularse";
                $this->redirectToController('detalleOferta/'.$vista.'/'.$id_oferta);
            }

        }catch (Exception $e) {
            $_SESSION['mostrar_error'] = $e->getMessage();
            $GLOBALS['db']->rollback();
            $this->redirectToController('detalle_oferta');
        }
    }

    public function guardarEstatus($id_usuario,$id_oferta,$resultado){

        try{

            if (!Modelo_Postulacion::cambiarEstatus($id_usuario,$id_oferta,$resultado)) {
                throw new Exception("Ha ocurrido un error en el cambio de estatus, intente nuevamente");
            }
            $GLOBALS['db']->commit();
            $_SESSION['mostrar_exito'] = 'El estatus de la oferta fue editado exitosamente';

        }catch (Exception $e) {
            $_SESSION['mostrar_error'] = $e->getMessage();
            $GLOBALS['db']->rollback();
            $this->redirectToController('detalle_oferta');
        }
    }
}

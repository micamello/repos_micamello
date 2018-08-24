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

        //solo candidatos pueden ingresar a los test
        if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::CANDIDATO){
          Utils::doRedirect(PUERTO.'://'.HOST.'/'); 
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

        $opcion = Utils::getParam('opcion', '', $this->data);
        $page = Utils::getParam('page', '1', $this->data);

        switch ($opcion) {
            case 'filtrar':

                $arrarea       = Modelo_Area::obtieneListadoAsociativo();
                $arrprovincia  = Modelo_Provincia::obtieneListadoAsociativo();
                $arrjornadas      = Modelo_Jornada::obtieneListadoAsociativo();
                $tiposContrato = Modelo_TipoContrato::obtieneListadoAsociativo();
                $page = Utils::getParam('page', '', $this->data);
                $type = Utils::getParam('type', '', $this->data); 

                unset($this->data['mostrar'],$this->data['opcion'],$this->data['page'],$this->data['type']);
                
                $postulacionesUserLogueado = Modelo_Oferta::obtienePostulaciones($_SESSION['mfo_datos']['usuario']['id_usuario']);

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

                $postulacionesFiltradas    = Modelo_Oferta::filtrarOfertas($_SESSION['mfo_datos']['Filtrar_ofertas']['A'],$_SESSION['mfo_datos']['Filtrar_ofertas']['P'],$_SESSION['mfo_datos']['Filtrar_ofertas']['J'],$_SESSION['mfo_datos']['Filtrar_ofertas']['C'],$page);

                $link = Vista::display('filtrarOfertas',array('data'=>$array_datos,'page'=>$page)); 
                 
                $tags = array(
                    'arrarea'       => $arrarea,
                    'tiposContrato' => $tiposContrato,
                    'arrprovincia'  => $arrprovincia,
                    'jornadas'      => $arrjornadas,
                    'ofertas'       => $postulacionesFiltradas,
                    'postulacionesUserLogueado' => $postulacionesUserLogueado,
                    'link'=>$link,
                    'page' =>$page
                );

                $tags["template_js"][] = "oferta";
                $tags["show_banner"] = 1;
                
                $url = PUERTO.'://'.HOST.'/oferta/'.$type.$cadena;
                
                $pagination = new Pagination(count($postulacionesFiltradas),REGISTRO_PAGINA,$url);
                $pagination->setPage($page);
                $tags['paginas'] = $pagination->showPage();

                Vista::render('ofertas', $tags);
            break;
    
            case 'detalleOferta':

                $idOferta = Utils::getParam('id', '', $this->data);
                $oferta = Modelo_Oferta::obtieneOfertas($idOferta,$page);
                $idUsuario = $_SESSION['mfo_datos']['usuario']['id_usuario'];

                if (Utils::getParam('postulado') == 1) {

                    self::guardarPostulacion($idUsuario,$idOferta);
                }

                $postulado = Modelo_Postulacion::obtienePostuladoxUsuario($idUsuario,$idOferta);
                $tags = array(
                    'oferta'=> $oferta,
                    'postulado'=>$postulado
                );

                $tags["show_banner"] = 1;

                Vista::render('detalle_oferta', $tags);
            break;

            default:
                
                $_SESSION['mfo_datos']['Filtrar_ofertas'] = array('A'=>0,'P'=>0,'J'=>0,'C'=>0);
                $arrarea       = Modelo_Area::obtieneListadoAsociativo();
                $arrprovincia  = Modelo_Provincia::obtieneListadoAsociativo();
                $jornadas      = Modelo_Jornada::obtieneListadoAsociativo();
                $tiposContrato = Modelo_TipoContrato::obtieneListadoAsociativo();
                $ofertas = Modelo_Oferta::obtieneOfertas(false,$page);
                $postulacionesUserLogueado = Modelo_Oferta::obtienePostulaciones($_SESSION['mfo_datos']['usuario']['id_usuario'],$page);

                $tags = array(
                    'arrarea'       => $arrarea,
                    'tiposContrato' => $tiposContrato,
                    'arrprovincia'  => $arrprovincia,
                    'jornadas'      => $jornadas,
                    'ofertas'       => $ofertas,
                    'postulacionesUserLogueado' => $postulacionesUserLogueado,
                    'page' => $page
                );

                $tags["template_js"][] = "oferta";
                $url = 'http://localhost/repos_micamello/oferta';
                $pagination = new Pagination(count($ofertas),REGISTRO_PAGINA,$url);
                $pagination->setPage($page);
                $tags['paginas'] = $pagination->showPage();

                Vista::render('ofertas', $tags);
                break;
        }
    }

    public function guardarPostulacion($id_usuario,$id_oferta){

        try{

            if (isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'postulacion') && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) {

                if (!Modelo_Postulacion::postularse($id_usuario,$id_oferta)) {
                    throw new Exception("Ha ocurrido un error la postulación, intente nuevamente");
                }
                 $GLOBALS['db']->commit();
                $_SESSION['mostrar_exito'] = 'Se ha postulado a esta oferta exitosamente';

            }else{

                $_SESSION['mostrar_error'] = "No tiene permiso para postularse";
                $this->redirectToController('detalleOferta/'.$id_oferta);
            }

        }catch (Exception $e) {
            $_SESSION['mostrar_error'] = $e->getMessage();
            $GLOBALS['db']->rollback();
            $this->redirectToController('detalle_oferta');
        }
    }
}

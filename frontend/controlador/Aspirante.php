<?php
class Controlador_Aspirante extends Controlador_Base
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

        $mostrar = Utils::getParam('mostrar', '', $this->data);
        $opcion = Utils::getParam('opcion', '', $this->data);
        $page = Utils::getParam('page', '1', $this->data);
        $id_oferta = Utils::getParam('id_oferta', '', $this->data); 
        $type = Utils::getParam('type', '', $this->data); 
        $vista = Utils::getParam('vista', '', $this->data);
        //$postulacionesUserLogueado = array();
        $username = Utils::getParam('username', '', $this->data);
        $breadcrumbs = array();

        switch ($opcion) {
            case 'filtrar':
                
                $arrprovincia  = Modelo_Provincia::obtieneListadoAsociativo();
               /* $arrarea       = Modelo_Area::obtieneListadoAsociativo();
                
                $arrjornadas      = Modelo_Jornada::obtieneListadoAsociativo();
                $tiposContrato = Modelo_TipoContrato::obtieneListadoAsociativo();*/

                unset($this->data['mostrar'],$this->data['opcion'],$this->data['page'],$this->data['type'],$this->data['id_oferta']);
                
               /* if($vista == 'oferta'){
                    $postulacionesUserLogueado = Modelo_Postulacion::obtienePostulaciones($_SESSION['mfo_datos']['usuario']['id_usuario']);
                    $breadcrumbs['oferta'] = 'Ofertas de empleo';
                }else if($vista == 'vacantes'){
                    $breadcrumbs['oferta'] = 'Mis Vacantes';
                }else{
                    $breadcrumbs['postulacion'] = 'Mis postulaciones';
                }*/

                /*$id_area = '';
                $id_provincia = '';
                $id_jornada = '';
                $id_contrato = '';*/
                $cadena = '';
                $array_datos = $aspirantesFiltrados = array();
                foreach ($this->data as $param => $value) {
                    
                    $letra = substr($value,0,1);
                    $id = substr($value,1,2);
                    $cadena .= '/'.$value;
                    //array_push($result, strval($value));

                    if($letra == 'F' && $type == 1){
                        
                        $_SESSION['mfo_datos']['Filtrar_aspirantes']['F'] = $id;
                        $array_datos['F'] = array('id'=>$id,'nombre'=>FECHA_POSTULADO[$id]);

                    }
                    else if($letra == 'P' && $type == 1){
                        
                        $_SESSION['mfo_datos']['Filtrar_aspirantes']['P'] = $id;
                        $array_datos['P'] = array('id'=>$id,'nombre'=>PRIORIDAD[$id]);

                    }
                    else if($letra == 'G' && $type == 1){
                        
                        $_SESSION['mfo_datos']['Filtrar_aspirantes']['G'] = $id;
                        $array_datos['G'] = array('id'=>$id,'nombre'=>GENERO[$id]);

                    }
                    else if($letra == 'U' && $type == 1){
                        
                        $_SESSION['mfo_datos']['Filtrar_aspirantes']['U'] = $id;
                        $array_datos['U'] = array('id'=>$id,'nombre'=>$arrprovincia[$id]);

                    }else if($letra == 'S' && $type == 1){
                        
                        $_SESSION['mfo_datos']['Filtrar_aspirantes']['S'] = $id;
                        $array_datos['S'] = array('id'=>$id,'nombre'=>SALARIO[$id]);

                    }else if($type == 2){

                        $_SESSION['mfo_datos']['Filtrar_aspirantes'][$letra] = 0;
                    }
                }

                foreach ($_SESSION['mfo_datos']['Filtrar_aspirantes'] as $letra => $value) {

                    if($value!=0){

                        if($letra == 'F'){
                            $array_datos[$letra] = array('id'=>$value,'nombre'=>FECHA_POSTULADO[$value]);
                        }

                        if($letra == 'P'){
                            $array_datos[$letra] = array('id'=>$value,'nombre'=>PRIORIDAD[$value]);
                        }
                        if($letra == 'G'){
                            $array_datos[$letra] = array('id'=>$value,'nombre'=>GENERO[$value]);
                        }
                        if($letra == 'U'){
                            $array_datos[$letra] = array('id'=>$value,'nombre'=>$arrprovincia[$value]);
                        }
                        if($letra == 'S'){
                            $array_datos[$letra] = array('id'=>$value,'nombre'=>SALARIO[$value]);
                        }
                    }
                }

                $aspirantesFiltrados    = Modelo_Usuario::filtrarAspirantes($id_oferta,$_SESSION['mfo_datos']['Filtrar_aspirantes']['F'],$_SESSION['mfo_datos']['Filtrar_aspirantes']['P'],$_SESSION['mfo_datos']['Filtrar_aspirantes']['U'],$_SESSION['mfo_datos']['Filtrar_aspirantes']['S'],$_SESSION['mfo_datos']['Filtrar_aspirantes']['G'],$page);

                $link = Vista::display('filtrarAspirantes',array('data'=>$array_datos,'page'=>$page,'mostrar'=>$mostrar,'vista'=>$vista,'id_oferta'=>$id_oferta)); 
                 
                $tags = array(
                    'breadcrumbs'=>$breadcrumbs,
                    'aspirantes'       => $aspirantesFiltrados,
                    'arrprovincia'=>$arrprovincia,
                    'link'=>$link,
                    'page' =>$page,
                    'mostrar'=>$mostrar,
                    'vista'=>$vista,
                    'id_oferta'=>$id_oferta
                );
               
                $url = PUERTO.'://'.HOST.'/verAspirantes/'.$cadena;
                
                $pagination = new Pagination(count($aspirantesFiltrados),REGISTRO_PAGINA,$url);
                $pagination->setPage($page);
                $tags['paginas'] = $pagination->showPage();

                Vista::render('aspirantes', $tags);
            break;

            case 'detallePerfil':
                $this->perfilAspirante($username);
            break;

            default:
                
                $id_oferta = Utils::getParam('id_oferta', '', $this->data);

                //solo empresa 
                if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::EMPRESA){
                  Utils::doRedirect(PUERTO.'://'.HOST.'/'); 
                }

                $_SESSION['mfo_datos']['Filtrar_aspirantes'] = array('F'=>0,'P'=>0,'U'=>0,'G'=>0,'S'=>0);
                $arrprovincia  = Modelo_Provincia::obtieneListadoAsociativo();
                $aspirantes = Modelo_Usuario::obtenerAspirantes($id_oferta,$page);
                $breadcrumbs['vacantes'] = 'Ver vacantes';
                $breadcrumbs['aspirante'] = 'Aspirantes de la oferta';

                $tags = array(
                    'breadcrumbs'=>$breadcrumbs,
                    'arrprovincia'  => $arrprovincia,
                    'aspirantes'       => $aspirantes,
                    'page' => $page,
                    'mostrar'=>$mostrar,
                    'vista'=>$vista,
                    'id_oferta'=>$id_oferta
                );

                //$tags["template_js"][] = "oferta";
                //$tags["show_banner"] = 1;
                
                $url = PUERTO.'://'.HOST.'/'.$vista;
                $pagination = new Pagination(count($aspirantes),REGISTRO_PAGINA,$url);
                $pagination->setPage($page);
                $tags['paginas'] = $pagination->showPage();

                Vista::render('aspirantes', $tags);
            break;
        }
    }

    public function perfilAspirante($username){
        $datos_usuario = ["datos_Usuario"=>Modelo_Usuario::existeUsuario($username)];

        Utils::log(print_r($datos_usuario, true));
        Vista::render('perfilAspirante', $datos_usuario);
    }

}

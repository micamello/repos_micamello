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

        //obtiene el orden del banner de forma aleatoria segun la cantidad de banner de tipo perfil
        $orden                      = rand(1, count($arrbanner)) - 1;
        $_SESSION['mostrar_banner'] = PUERTO . '://' . HOST . '/imagenes/banner/' . $arrbanner[$orden]['id_banner'] . '.' . $arrbanner[$orden]['extension'];

        $opcion = Utils::getParam('opcion', '', $this->data);
        switch ($opcion) {
            case 'filtrar':
                $id_provincia = Utils::getParam('id_provincia', '', $this->data);
                $id_jornada = Utils::getParam('id_jornada', '', $this->data);
                $id_contrato = Utils::getParam('id_contrato', '', $this->data);
                $id_area = Utils::getParam('id_area', '', $this->data);
                $postulacionesUserLogueado    = Modelo_Oferta::filtrarOfertas($id_provincia,$id_jornada,$id_contrato,$id_area);
                Vista::renderJSON($postulacionesUserLogueado);
                break;
            default:
                
                $arrarea       = Modelo_Area::obtieneListado();
                $arrprovincia  = Modelo_Provincia::obtieneListado();
                $jornadas      = Modelo_Jornada::obtieneListado();
                $tiposContrato = Modelo_TipoContrato::obtieneListado();
                $ofertas = Modelo_Oferta::obtieneOfertas();
                $postulacionesUserLogueado = Modelo_Oferta::obtienePostulaciones($_SESSION['mfo_datos']['usuario']['id_usuario']);

                $tags = array(
                    'arrarea'       => $arrarea,
                    'tiposContrato' => $tiposContrato,
                    'arrprovincia'  => $arrprovincia,
                    'jornadas'      => $jornadas,
                    'ofertas'       => $ofertas,
                    'postulacionesUserLogueado' => $postulacionesUserLogueado
                );

                /*$tags["template_js"][] = "selectr";
                $tags["template_js"][] = "validator";
                $tags["template_js"][] = "mic";*/
                $tags["template_js"][] = "oferta";
                $tags["show_banner"] = 1;
                Vista::render('ofertas', $tags);
                break;
        }
    }

}

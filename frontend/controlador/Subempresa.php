<?php
class Controlador_Subempresa extends Controlador_Base
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
        $idUsuario = $_SESSION['mfo_datos']['usuario']['id_usuario'];
        $subempresas = Modelo_Usuario::obtieneSubempresasYplanes($idUsuario,$page,false);
        
        
        $breadcrumbs['adminEmpresas'] = 'Listado de sub empresas';
        $cantd_empresas = Modelo_Usuario::obtieneSubempresasYplanes($idUsuario,$page,true);
        $url = PUERTO.'://'.HOST.'/adminEmpresas';
        $pagination = new Pagination($cantd_empresas,REGISTRO_PAGINA,$url);
        $pagination->setPage($page);

        $tags = array(
            'breadcrumbs'=>$breadcrumbs,
            'subempresas' => $subempresas,
            'cantd_empresas'=>$cantd_empresas,
            'paginas'=>$pagination->showPage()
        );      
        
        Vista::render('subempresas', $tags);
    }
}
?>
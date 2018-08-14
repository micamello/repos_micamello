<?php
class Controlador_Perfil extends Controlador_Base {
  
  function __construct(){
    global $_SUBMIT;
    $this->data = $_SUBMIT;
  }
  
  public function construirPagina(){

    if( !Modelo_Usuario::estaLogueado() ){
      Utils::doRedirect(PUERTO.'://'.HOST.'/login/');    
    }

    //Obtiene todos los banner activos segun el tipo
    $arrbanner = Modelo_Banner::obtieneListado(Modelo_Banner::BANNER_PERFIL);

    //obtiene el orden del baner de forma aleatoria segun la cantidad de banner de tipo perfil
    $orden = rand(1,count($arrbanner))-1;
    $_SESSION['mostrar_banner'] = PUERTO.'://'.HOST.'/imagenes/banner/'.$arrbanner[$orden]['id_banner'].'.'.$arrbanner[$orden]['extension'];

    $opcion = Utils::getParam('opcion','',$this->data);  

    switch($opcion){      
      case 'paso1':
        $escolaridad = Modelo_Escolaridad::obtieneListado();
        $arrarea = Modelo_Area::obtieneListado();
        $arrinteres = Modelo_Interes::obtieneListado();
        $areaxusuario = Modelo_UsuarioxArea::obtieneListado($_SESSION['mfo_datos']['usuario']['id_usuario']);
        $nivelxusuario = Modelo_UsuarioxNivel::obtieneListado($_SESSION['mfo_datos']['usuario']['id_usuario']);
        $arrprovincia = Modelo_Provincia::obtieneListado();
        $tags = array('escolaridad'=>$escolaridad,
                      'arrarea'=>$arrarea,
                      'arrinteres'=>$arrinteres,
                      'areaxusuario'=>$areaxusuario,
                      'arrprovincia'=>$arrprovincia,
                      'nivelxusuario'=>$nivelxusuario
                    );
        $tags["template_js"][] = "selectr";
        $tags["template_js"][] = "mic";
        $tags["template_js"][] = "editarPerfil";
        Vista::render('perfil_paso1',$tags);
      break;
      case 'buscaCiudad':
        $id_provincia = Utils::getParam('id_provincia','',$this->data);
        $arrciudad = $this->buscaCiudad($id_provincia);
        Vista::renderJSON($arrciudad);
      break;
      default:
        Vista::render('perfil');
      break;
    }     
  }

  public function buscaCiudad($id_provincia){
    return $ciudadxprovincia = Modelo_Ciudad::obtieneCiudadxProvincia($id_provincia);
  }
}  
?>
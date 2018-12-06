<?php
require_once 'constantes.php';
require_once 'init.php';
include 'multisitios.php';

/*if( (!isset($_GET['mostrar']) || $_GET['mostrar'] != 'logout') && !Model_Usuario::isLoggedIn() && 
    (!isset($_GET['mostrar']))){
  $_GET['mostrar'] = 'inicio';
  $_SUBMIT['mostrar'] = 'inicio'; 
}*/

dispatch();
$GLOBALS['db']->close();


function dispatch() {
    global $_SUBMIT;
    $pagina = Utils::getParam('mostrar', 'inicio');
    $controlador_nombre = obtieneControlador($pagina);
    $clase = 'Controlador_' . $controlador_nombre;
    if(class_exists($clase)){
      $controlador = new $clase();
    }else{
      //no existe controlador
    }
    return $controlador->construirPagina();
  }
  
function obtieneControlador($nombre){
  switch($nombre){
    case 'login':
      return 'Login';
    break;
    case 'contrasena':
      return 'Contrasena';
    break;
    case 'logout':
      return 'Logout';
    break;
    case 'perfil':
      return 'Perfil';
    break;
    case 'cuestionario':
      return 'Cuestionario';
    case 'registro':
      return 'Registro';
    break;
    case 'velocimetro':
      return 'Velocimetro';
    break;
    case 'publicar':
      return 'Publicar';
    break;
    case 'plan':
      return 'Plan';
    break;
    case 'oferta':
      return 'Oferta';
    break;
    case 'postulacion':
      return 'Postulacion';
    break;
    case 'recomendacion':
      return 'Recomendacion';
    break;
    case 'vacantes':
      return 'Vacantes';
    break;
    case 'aspirante':
      return 'Aspirante';
    break;
    case 'informePDF':
      return 'InformePDF';
    break;
    case 'notificacion':
      return 'Notificacion';
    break;
    case 'subempresa':
      return 'Subempresa';
    break;
    default:
      return 'Inicio'; 
    break;
  }
  return ucfirst($nombre);
}
?>
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

        $provincia = Modelo_Provincia::obtieneProvincia($_SESSION['mfo_datos']['usuario']['id_ciudad']);
        $arrciudad = $this->buscaCiudad($provincia['id_provincia']);

        $areaxusuario = Modelo_UsuarioxArea::obtieneListado($_SESSION['mfo_datos']['usuario']['id_usuario']);
        $nivelxusuario = Modelo_UsuarioxNivel::obtieneListado($_SESSION['mfo_datos']['usuario']['id_usuario']);
        $arrprovincia = Modelo_Provincia::obtieneListado();
        $area_select = $nivel_interes = false;
        if ( Utils::getParam('actualizar') == 1 ){

          try{

            if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == 1){

              $campos = array('nombres'=>1, 'apellidos'=>1, 'ciudad'=>1, 'provincia'=>1, 'discapacidad'=>0, 'experiencia'=>1,'fecha_nacimiento'=>1, 'telefono'=>1, 'genero'=>1, 'escolaridad'=>1, 'status_carrera'=>1);

              $area_select = $_POST['area_select'];
              $nivel_interes = $_POST['nivel_interes'];

            }else{

              $campos = array('nombres'=>1, 'ciudad'=>1, 'provincia'=>1,'fecha_nacimiento'=>1, 'telefono'=>1);
            }
            
            $data = $this->camposRequeridos($campos);
            if($_FILES['file-input']['error'] != 4 )
            {   
              $validaImg = Utils::valida_imagen_upload($_FILES['file-input']);
              if (empty($validaImg)){
                throw new Exception("La imagen debe ser en formato .jpg .jpeg .pjpeg y con un peso máx de 2MB");
              }
            }

            $validaTlf = Utils::valida_telefono($data['telefono']);
            if (empty($validaTlf)){
              throw new Exception("El telefono ".$data['telefono']." no es válido");
            }

            $validaFecha = Utils::valida_fecha($data['fecha_nacimiento']);
            if (empty($validaFecha)){
              throw new Exception("La fecha ".$data['fecha_nacimiento']." no es válida");
            }

            self::guardarPerfil($data,$area_select,$nivel_interes,$_FILES['file-input'],$_SESSION['mfo_datos']['usuario']['id_usuario']);
            $_SESSION['mostrar_exito'] = 'El perfil fue completado exitosamente'; 
          }
          catch( Exception $e ){
            $_SESSION['mostrar_error'] = $e->getMessage();      
          }
        }  

        $tags = array('escolaridad'=>$escolaridad,
                      'arrarea'=>$arrarea,
                      'arrinteres'=>$arrinteres,
                      'areaxusuario'=>$areaxusuario,
                      'arrprovincia'=>$arrprovincia,
                      'nivelxusuario'=>$nivelxusuario,
                      'provincia'=>$provincia['id_provincia'],
                      'arrciudad'=>$arrciudad
                    );
        
        $tags["template_js"][] = "selectr";

		    $tags["template_js"][] = "validator";

        $tags["template_js"][] = "mic";
        $tags["template_js"][] = "editarPerfil";
        $tags["show_banner"] = 1;
        Vista::render('perfil_paso1',$tags);
      break;
      case 'buscaCiudad':
        $id_provincia = Utils::getParam('id_provincia','',$this->data);
        $arrciudad = $this->buscaCiudad($id_provincia);
        Vista::renderJSON($arrciudad);
      break;
      default:
        $tags["show_banner"] = 1;
        Vista::render('perfil',$tags);
      break;
    }     
  }

  public function buscaCiudad($id_provincia){
    return $ciudadxprovincia = Modelo_Ciudad::obtieneCiudadxProvincia($id_provincia);
  }

  public function guardarPerfil($data, $area_select=false, $nivel_interes=false,$file,$idUsuario){

    try{
      $GLOBALS['db']->beginTrans();
      if(!Modelo_Usuario::updateUsuario($data,4,$file)){
          throw new Exception("Ha ocurrido un error al guardar el usuario, intente nuevamente");
      }
      if(is_array($area_select)){
        if(!Modelo_UsuarioxArea::updateAreas($area_select,$idUsuario)){
            throw new Exception("Ha ocurrido un error al guardar las areas de interes, intente nuevamente");
        }

        if(!Modelo_UsuarioxNivel::updateNiveles($nivel_interes,$idUsuario)){
            throw new Exception("Ha ocurrido un error al guardar los niveles de interes, intente nuevamente");
        }
      }
      $GLOBALS['db']->commit();
      Controlador_Login::registroSesion(Modelo_Usuario::actualizarSession($idUsuario)); 
    }
    catch( Exception $e ){
      $_SESSION['mostrar_error'] = $e->getMessage();
      $GLOBALS['db']->rollback();
      $this->redirectToController('editarperfil');      
    }
  }
}  
?>
<?php
class Controlador_RegTest extends Controlador_Base {
  
  public function construirPagina(){ 
    if(isset($_SESSION['id_usuario'])){
      unset($_SESSION['id_usuario']);
    }
    if(isset($_SESSION['id_pregunta'])){
      unset($_SESSION['id_pregunta']);
    }
    $opcion = Utils::getParam('opcion','',$this->data);
    switch($opcion){
      case 'buscaProvincia':
        $id_pais = Utils::getParam('id_pais', '', $this->data);
        $provincias = Modelo_Provincia::obtieneListadoAsociativo($id_pais);
        Vista::renderJSON($provincias);
      break;
      case 'buscaCiudad':
        $id_provincia = Utils::getParam('id_provincia', '', $this->data);
        $arrciudad    = Modelo_Ciudad::obtieneCiudadxProvincia($id_provincia);
        Vista::renderJSON($arrciudad);
      break;
      case 'buscaParroquia':
        $id_canton = Utils::getParam('id_canton', '', $this->data);
        Utils::log("eder1 ".$id_canton);
        $parroquia = Modelo_Parroquia::obtieneParroquiaxCanton($id_canton);
        Vista::renderJSON($parroquia);
      break;
      case 'guardardatostest':
        $this->guardarDatosTest();
      break;
      default:
        $pais = Modelo_Pais::obtieneListado();
        $provincia = Modelo_Provincia::obtieneListado();
        $escolaridad = Modelo_Escolaridad::obtieneListado();
        $profesion = Modelo_ProfesionTest::obtenerListado();
        $ocupacion = Modelo_Ocupacion::obtenerListado();
        Vista::render('registrotest',array('pais'=>$pais, 'provincia'=>$provincia, 'escolaridad'=>$escolaridad, 'profesion'=>$profesion, 'ocupacion'=>$ocupacion), '', '');
      break;
    }    
  }

  public function guardarDatosTest(){
    $url = "";
    if ( Utils::getParam('form_register') == 1 ){
      try{
        $campos = array('nombres'=>1, 'apellidos'=>1, 'fecha_nacimiento'=>1, 'pais'=>1, 'cantonnac'=>0, 'genero'=>1, 'estado_civil'=>1, 'nivel_instruccion'=>1, 'terminos_condiciones'=>1, 'correo'=>1, 'aspiracion_salarial'=>1, 'parroquia_res'=>1, 'profesion'=>1, 'ocupacion'=>1);
        $data = $this->camposRequeridos($campos);
        self::validarTipoDato($data);
        self::guardarDatosUsuarioTest($data);
        $url = "test";
        $_SESSION['id_usuario'] = $GLOBALS['db']->insert_id();
        $_SESSION['mostrar_exito'] = "Te has registrado correctamente.";
      }
      catch( Exception $e ){
        $url = "registroM";
        $GLOBALS['db']->rollback();
        $_SESSION['mostrar_error'] = $e->getMessage();
      }
      Utils::doRedirect(PUERTO.'://'.HOST.'/'.$url);
    }
  }

  public function validarTipoDato($data){
    // validar letras y espacios
    if (!preg_match('/^[\p{L} ]+$/u', html_entity_decode($data['nombres']))){
      throw new Exception("El campo solo acepta espacios y números");
      
    }
    if (!preg_match('/^[\p{L} ]+$/u', html_entity_decode($data['apellidos']))){
      throw new Exception("El campo solo acepta espacios y números");
    }
    // validar fecha
    if(Utils::validatFormatoFecha($data['fecha_nacimiento']) == false){
      throw new Exception("La fecha ingresada es incorrecta");
    }
    // valida correo
    if(Utils::es_correo_valido($data['correo']) == false){
      throw new Exception("La correo ingresado no es válido");
    }
    // valida formato dinero
    if(Utils::formatoDinero($data['aspiracion_salarial']) == false){
      throw new Exception("La formato de dinero ingresado no es válido");
    }
  }

  public function guardarDatosUsuarioTest($data){
    if(!Modelo_Usuario::guardarUsuario($data)){
      throw new Exception("Ha ocurrido un error, intente nuevamente");
    }
  }
}  
?>
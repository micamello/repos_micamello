<?php 
class Controlador_Publicar extends Controlador_Base {

  function __construct(){
    global $_SUBMIT;
    $this->data = $_SUBMIT;
  }

  public function construirPagina(){
    if(!Modelo_Usuario::estaLogueado() ){
      Utils::doRedirect(PUERTO.'://'.HOST.'/login/');
    }

    if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::EMPRESA){
      Utils::doRedirect(PUERTO.'://'.HOST.'/'); 
    }

    

    $opcion = Utils::getParam('opcion','',$this->data);
    switch($opcion){
      case 'buscaCiudad':
        $id_provincia = Utils::getParam('id_provincia', '', $this->data);
        $arrciudad    = Modelo_Ciudad::obtieneCiudadxProvincia($id_provincia);
        Vista::renderJSON($arrciudad);
      break;
      default:
        $this->mostrarDefault();
      break;
    } 
  }

  public function mostrarDefault(){
      $arrarea = Modelo_Area::obtieneListado();
      $arrinteres = Modelo_Interes::obtieneListado();
      $arrprovinciasucursal = Modelo_Provincia::obtieneProvinciasSucursal($_SESSION['mfo_datos']['sucursal']['id_pais']);
      $arrciudad = Modelo_Ciudad::obtieneCiudadxProvincia($arrprovinciasucursal[0]['id_provincia']);
      $arrjornada = Modelo_Jornada::obtieneListado();
      $arrtipo = Modelo_TipoContrato::obtieneListado();
      $arridioma = Modelo_Idioma::obtieneListado();
      $arrnivelidioma = Modelo_NivelIdioma::obtieneListado();
      $arrescolaridad = Modelo_Escolaridad::obtieneListado();

      $tags = array('arrarea'=>$arrarea,
                    'intereses'=>$arrinteres,
                    'arrprovinciasucursal'=>$arrprovinciasucursal,
                    'arrciudad'=>$arrciudad,
                    'arrjornada'=>$arrjornada,
                    'arrtipo'=>$arrtipo,
                    'arridioma'=>$arridioma,
                    'arrnivelidioma'=>$arrnivelidioma,
                    'arrescolaridad'=>$arrescolaridad
                  );
      
      if ( Utils::getParam('form_publicar') == 1 ){
        try{
          // print_r($_POST['confidencial']);
          $campos = array('titu_of'=>1, 'salario'=>1, 'confidencial'=>1, 'des_of'=>1, 'area_select'=>1, 'nivel_interes'=>1, 'ciudad_of'=>1, 'jornada_of'=>1, 'tipo_cont_of'=>1, 'edad_min'=>1, 'edad_max'=>1, 'viaje'=>1, 'cambio_residencia'=>1, 'discapacidad'=>1, 'experiencia'=>1, 'licencia'=>1, 'fecha_contratacion'=>1, 'vacantes'=>1, 'nivel_idioma'=>1);

          $data = $this->camposRequeridos($campos);

          self::validarCampos($data);
        }
        catch( Exception $e ){
          $_SESSION['mostrar_error'] = $e->getMessage();
        }
      }

      $tags["template_js"][] = "tinymce/tinymce.min";
      $tags["template_js"][] = "selectr";
      $tags["template_js"][] = "validator";
      $tags["template_js"][] = "mic";
      $tags["template_js"][] = "publicar_oferta";
      Vista::render('publicar_vacante', $tags);

  }

  public function validarCampos($data){
    Utils::log("eder pozo datos: ".print_r($data, true));

    if (Utils::validarNumeros($data['salario']) == false) {
      throw new Exception("El campo salario solo permite números");
    }

    if (Utils::validarNumeros($data['vacantes']) == false) {
      throw new Exception("El campo vacantes solo permite números");
    }

    $valida_fecha = Utils::valida_fecha($data['fecha_contratacion']);
    if(empty($valida_fecha)){
      throw new Exception("El formato o la fecha ingresada no es válida");
    }

    if (Utils::validarNumeros($data['edad_min']) == false) {
      throw new Exception("El campo de edad mínima solo permite números");
    }

    if (Utils::validarNumeros($data['edad_max']) == false) {
      throw new Exception("El campo edad máxima solo permite números");
    }

    if (Utils::validarLongitudMultiselect($data['area_select'], 1) == false) {
      throw new Exception("Supero el límite de opciones permitidas en el campo categorías");
    }

    if (Utils::validarLongitudMultiselect($data['nivel_interes'], 1) == false) {
      throw new Exception("Supero el límite de opciones permitidas en el campo nivel");
    }

    $listado_idiomas_niveles_db = Modelo_NivelxIdioma::obtieneListado();
    $array_nivel_idioma = array();
    for ($i=0; $i < count($data['nivel_idioma']); $i++) {
      $explode = explode("_", $data['nivel_idioma'][$i]);
      array_push($array_nivel_idioma, $explode);
    }
    $data_idioma_nivel = array();

    for ($i=0; $i < count($listado_idiomas_niveles_db); $i++) { 
      for ($j=0; $j < count($array_nivel_idioma); $j++) { 
        if (($listado_idiomas_niveles_db[$i]['id_idioma'] == $array_nivel_idioma[$j][0]) && ($listado_idiomas_niveles_db[$i]['id_nivelIdioma']) == $array_nivel_idioma[$j][1]) {
          array_push($data_idioma_nivel, $listado_idiomas_niveles_db[$i]['id_nivelIdioma_idioma']);
        }
      }
    }

    if (count($data_idioma_nivel) != count($array_nivel_idioma)) {
          throw new Exception("Uno o más de los idiomas seleccionados no esta disponible");
        }



  }
}
 ?>
<?php 
class Controlador_Publicar extends Controlador_Base {

  function __construct(){
    global $_SUBMIT;
    $this->data = $_SUBMIT;
  }

  public function construirPagina(){

    $idusu = $_SESSION["mfo_datos"]["usuario"]["id_usuario"];
    unset($_SESSION['mfo_datos']['planes']);
    $_SESSION['mfo_datos']['planes'] = Modelo_UsuarioxPlan::planesActivos($idusu, $_SESSION['mfo_datos']['usuario']['tipo_usuario']);
    
    if(!Modelo_Usuario::estaLogueado() ){
      Utils::doRedirect(PUERTO.'://'.HOST.'/login/');
    }

    if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::EMPRESA){
      Utils::doRedirect(PUERTO.'://'.HOST.'/'); 
    }

    if (!isset($_SESSION['mfo_datos']['planes']) || empty($_SESSION['mfo_datos']['planes'])){
      $_SESSION['mostrar_error'] = "No tiene un plan contratado. Para poder publicar una oferta, por favor aplique a uno de nuestros planes";
      Utils::doRedirect(PUERTO.'://'.HOST.'/planes/');
    }

    if (isset($_SESSION['mfo_datos']['planes']) && !Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'publicarOferta')){
      $_SESSION['mostrar_error'] = "No tiene permisos para publicar oferta";
      Utils::doRedirect(PUERTO.'://'.HOST.'/planes/');
    }

    $opcion = Utils::getParam('opcion','',$this->data);
    switch($opcion){
      case 'buscaCiudad':
        $id_provincia = Utils::getParam('id_provincia', '', $this->data);
        $arrciudad    = Modelo_Ciudad::obtieneCiudadxProvincia($id_provincia);
        Vista::renderJSON($arrciudad);
      break;
      default:
      // print_r("eder");
        
        // print_r($_SESSION['mfo_datos']['planes']);
        // exit();
        $publicaciones_restantes = $_SESSION['mfo_datos']['planes'];
        // print_r($publicaciones_restantes);
        $rest = 0;
        foreach ($publicaciones_restantes as $value) {
          if($value['num_publicaciones_rest'] < 0){
            // $rest = "&infin;";
            $rest = "&infin;";
            break;
          }
          else{
            $rest += $value['num_publicaciones_rest'];
          }
        }

        // print_r("rest: ".$rest);
        // exit();
        if ($rest <= 0 && $rest != "&infin;") {
          $_SESSION['mostrar_error'] = "Actualmente no dispone de publicaciones. Si desea seguir publicando vacantes proceda con la contratación o renovación del Plan.";
          Utils::doRedirect(PUERTO.'://'.HOST.'/planes/');       
        }
        else{
          $this->mostrarDefault($idusu,$rest);
        }
      break;
    } 
  }


  public function mostrarDefault($idusu,$publicaciones_restantes){
      $arrarea = Modelo_Area::obtieneListado();
      $arrinteres = Modelo_Interes::obtieneListado();
      $arrprovinciasucursal = Modelo_Provincia::obtieneProvinciasSucursal(SUCURSAL_PAISID);
      $arrciudad = Modelo_Ciudad::obtieneCiudadxProvincia($arrprovinciasucursal[0]['id_provincia']);
      $arrjornada = Modelo_Jornada::obtieneListado();
      $arridioma = Modelo_Idioma::obtieneListado();
      $arrnivelidioma = Modelo_NivelIdioma::obtieneListado();
      $arrescolaridad = Modelo_Escolaridad::obtieneListado();            

      $tags = array('arrarea'=>$arrarea,
                    'intereses'=>$arrinteres,
                    'arrprovinciasucursal'=>$arrprovinciasucursal,
                    'arrciudad'=>$arrciudad,
                    'arrjornada'=>$arrjornada,
                    'arridioma'=>$arridioma,
                    'arrnivelidioma'=>$arrnivelidioma,
                    'arrescolaridad'=>$arrescolaridad,
                    'publicaciones_restantes'=>$publicaciones_restantes
                  );
      
      if ( Utils::getParam('form_publicar') == 1 ){
        try{          
          $campos = array('titu_of'=>1, 'salario'=>1, 'confidencial'=>0, 'des_of'=>1, 'area_select'=>1, 'nivel_interes'=>1, 'ciudad_of'=>1, 'jornada_of'=>1, 'edad_min'=>1, 'edad_max'=>1, 'viaje'=>0, 'cambio_residencia'=>0, 'discapacidad'=>0, 'experiencia'=>1, 'escolaridad'=>1, 'licencia'=>0, 'fecha_contratacion'=>1, 'vacantes'=>1, 'nivel_idioma'=>1, 'urgente'=>0);             
          $data = $this->camposRequeridos($campos);
          $data["des_of"] = str_replace("\r\n","<br>",$_POST["des_of"]);
          $data["des_of"] = htmlentities($data["des_of"],ENT_QUOTES,'UTF-8'); 

          // Utils::log("eder: ----------------------------".print_r($data));
          // exit();
          
          $data_idiomas = self::validarCampos($data);

          $GLOBALS['db']->beginTrans();
          self::guardarPublicacion($data, $data_idiomas, $idusu);
          $GLOBALS['db']->commit();
          
          $_SESSION['mostrar_exito'] = "La oferta se ha registrado correctamente. Pronto un administrador habilitará la oferta";

          $this->redirectToController('vacantes');
        }
        catch( Exception $e ){
          $GLOBALS['db']->rollback();
          $_SESSION['mostrar_error'] = $e->getMessage();
          $this->redirectToController('publicar');
        }
      }

      $tags["template_js"][] = "assets/js/main";
      $tags["template_js"][] = "tinymce/tinymce.min";
      $tags["template_js"][] = "selectr";
      $tags["template_js"][] = "mic";
      $tags["template_js"][] = "validatePublicar";
      Vista::render('publicar_vacante', $tags);

  }

  public function validarCampos($data){

    // if (Utils::validarPalabras(array($data['titu_of'], $data['des_of'])) == false) {
    //   throw new Exception("Se han encontrado palabras no permitidas en la publicación de su oferta. Por favor revise su contenido e intente nuevamente");
    // }

    if (Utils::formatoDinero($data['salario']) == false) {
      throw new Exception("El campo salario solo permite números");
    }

    if (Utils::validarNumeros($data['vacantes']) == false) {
      throw new Exception("El campo vacantes solo permite números");
    }

    $valida_fecha = Utils::valida_fecha($data['fecha_contratacion']);
    $valida_fecha_mayor = Utils::valida_fecha_mayor($data['fecha_contratacion']);
    if(empty($valida_fecha) || ($valida_fecha_mayor)==false){
      throw new Exception("El formato o la fecha ingresada no es válida");
    }

    if (Utils::validarNumeros($data['edad_min']) == false) {
      throw new Exception("El campo de edad mínima solo permite números");
    }

    if (Utils::validarNumeros($data['edad_max']) == false) {
      throw new Exception("El campo edad máxima solo permite números");
    }

    if(Utils::validarEminEmax($data['edad_min'], $data['edad_max']) == false){
       throw new Exception("Verifique los valores de los campos edad mínima y máxima");
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
    return $data_idioma_nivel;
  }

  public function guardarPublicacion($data, $data_idiomas, $idusu){

    if (!Modelo_Oferta::guardarRequisitosOferta($data, $data_idiomas)) {
      throw new Exception("Ha ocurrido un error, intente nuevamente1");
    }

    $id_reqOf = $GLOBALS['db']->insert_id();
    $num_post = 0;
    $id_empresa_plan = 0;
    $id_empresa = 0;

    foreach($_SESSION['mfo_datos']['planes'] as $key=>$plan){
      if ($plan["num_publicaciones_rest"] > 0){
        $id_empresa = $plan['id_empresa'];
        $id_empresa_plan = $plan["id_empresa_plan"];
        $num_post = $plan["num_publicaciones_rest"];
        break;
      }
      else{
        $id_empresa = $plan['id_empresa']; 
       $id_empresa_plan = $plan["id_empresa_plan"];
        $num_post = -1;
      }
    }    

    // print_r("empresa plan: ". $id_empresa_plan);
    // exit();

    //VERIFICAR TIENE PARA PUBLICAR OFERTA 
    if (!Modelo_Oferta::guardarOferta($data, $id_reqOf, $id_empresa_plan, $id_empresa)) {

      throw new Exception("Ha ocurrido un error, intente nuevamente2"); 
    }

    $id_oferta = $GLOBALS['db']->insert_id();

    if(!Modelo_OfertaxNivelIdioma::guardarOfertaNivelIdioma($id_oferta, $data_idiomas)){
      throw new Exception("Ha ocurrido un error, intente nuevamente3");
    }

    if($num_post > 0){
      if(!Modelo_UsuarioxPlan::restarPublicaciones($id_empresa_plan, $num_post, Modelo_Usuario::EMPRESA)){
        throw new Exception("Ha ocurrido un error, intente nuevamente4");
      }
    }

  }
}
?>
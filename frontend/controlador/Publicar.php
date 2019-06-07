<?php 
class Controlador_Publicar extends Controlador_Base {
  
  public function construirPagina(){
    
    if(!Modelo_Usuario::estaLogueado()){
      Utils::doRedirect(PUERTO.'://'.HOST.'/login/');
    }

    if(!empty($_SESSION['mfo_datos']['usuario']['tipo_usuario']) && ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA) && (empty($_SESSION['mfo_datos']['usuario']['id_cargo']) || empty($_SESSION['mfo_datos']['usuario']['nro_trabajadores']))){ 
      $_SESSION['mostrar_error'] = "Debe completar el perfil para continuar";
      Utils::doRedirect(PUERTO.'://'.HOST.'/perfil/');
    }

    if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::EMPRESA){
      Utils::doRedirect(PUERTO.'://'.HOST.'/'); 
    }
    $id_usuario = $_SESSION["mfo_datos"]["usuario"]["id_usuario"];
    $_SESSION['mfo_datos']['planes'] = Modelo_UsuarioxPlan::planesActivos($id_usuario, $_SESSION['mfo_datos']['usuario']['tipo_usuario']);

    if (!isset($_SESSION['mfo_datos']['planes']) || empty($_SESSION['mfo_datos']['planes'])){
      $_SESSION['mostrar_notif'] = "No tiene un plan contratado. Para poder publicar una oferta, por favor aplique a uno de nuestros planes";
      Utils::doRedirect(PUERTO.'://'.HOST.'/planes/');
    }
    
    if (isset($_SESSION['mfo_datos']['planes']) && 
      !Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'publicarOferta') && !Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'publicarOfertaConfidencial')){
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
      case 'buscaPlan':
        $id_plan_empresa = Utils::getParam('id_plan', '', $this->data);                      
        $explodePlanEmpresa = explode("_", Utils::desencriptar($id_plan_empresa));                        
        $id_plan = $explodePlanEmpresa[0];
        $id_empresa_plan = $explodePlanEmpresa[1];                
        $plan = Modelo_UsuarioxPlan::consultarRecursosAretornar($id_empresa_plan);           
        $confidencialPlan = array();
        //Utils::log("FER ".print_r($plan,true));
        if(Modelo_PermisoPlan::busquedaPermisoxPlan($id_plan, 'publicarOfertaConfidencial')){
          $confidencialPlan = array_merge($plan, array('confidencial'=>0));
        }
        else{
          $confidencialPlan = array_merge($plan, array('confidencial'=>1));
        }
        Vista::renderJSON($confidencialPlan);
      break;
      // case 'registroOferta':

        
         // Utils::doRedirect(PUERTO.'://'.HOST.'/'.$url);
      // break;

      default:
            $this->mostrarDefault();
      break;
    } 
  }

  public function mostrarDefault(){
    $planes = array();
    $sumPub = 0;
    foreach ($_SESSION['mfo_datos']['planes'] as $plan) {
      $planUsuario = Modelo_UsuarioxPlan::consultarRecursosAretornar($plan['id_empresa_plan']);
        if($plan['num_rest'] > 0){
          array_push($planes, $planUsuario);
          $sumPub += $plan['num_rest'];
        }
    }
    if($sumPub == 0){
      $_SESSION['mostrar_error'] = "Por el momento no dispone de publicaciones restantes. Por favor adquiera un Plan para poder publicar una oferta";
      Utils::doRedirect(PUERTO.'://'.HOST.'/planes/');
    }

    $breadcrumbs['publicar'] = 'publicar oferta';
    $idProvinciaSucursal = $arrprovinciasucursal[0]['id_provincia'];
    if(!empty($_POST['provinciaOf']) && $_POST){$idProvinciaSucursal = $_POST['provinciaOf'];}
    $arrprovinciasucursal = Modelo_Provincia::obtieneProvinciasSucursal(SUCURSAL_PAISID);
    $arrciudad = Modelo_Ciudad::obtieneCiudadxProvincia($idProvinciaSucursal);
    $arrjornada = Modelo_Jornada::obtieneListado();
    $arridioma = Modelo_Idioma::obtieneListado();
    $arrnivelidioma = Modelo_NivelIdioma::obtieneListado();
    $arrescolaridad = Modelo_Escolaridad::obtieneListado();   
    $fechacontratacion = date('Y-m-d',strtotime('+1 day',strtotime(date('Y-m-d H:i:s')))); 
    $listSubareas = Modelo_AreaSubarea::obtieneAreas_Subareas();
    $tipolicencia = Modelo_TipoLicencia::obtieneListadoAsociativo();


    $tags = array('areasSubareas'=> $listSubareas,
                  'arrprovinciasucursal'=>$arrprovinciasucursal,
                  'arrciudad'=>$arrciudad,
                  'arrjornada'=>$arrjornada,
                  'arridioma'=>$arridioma,
                  'arrnivelidioma'=>$arrnivelidioma,
                  'arrescolaridad'=>$arrescolaridad,
                  'fecha_contratacion'=>$fechacontratacion,
                  'planes'=>$planes,
                  'tipolicencia'=>$tipolicencia,
                  'breadcrumbs'=>$breadcrumbs,
                  'vista'=>'publicar'
                );
    $tags["template_css"][] = "multiple_select";
    $tags["template_css"][] = "DateTimePicker";
    $tags["template_js"][] = "assets/js/main";
    $tags["template_js"][] = "tinymce/tinymce.min";      
    $tags["template_js"][] = "multiple_select";
    $tags["template_js"][] = "DateTimePicker";
    $tags["template_js"][] = "validatePublicar";

    if(isset($_POST) && !empty($_POST)){
      $datos = $_POST;
        try {
          $validados = $this->validarCampos($datos);
          $GLOBALS['db']->beginTrans();
          $this->guardarDatosOferta($validados);
          $GLOBALS['db']->commit();
          $_SESSION['mostrar_exito'] = 'Su oferta se ha publicado correctamente'; 
          $url = "vacantes/";
          Utils::doRedirect(PUERTO.'://'.HOST.'/'.$url);
         }
         catch (Exception $e) {
          $_SESSION['dataPublicar'] = $_POST;
          $GLOBALS['db']->rollback();
          $_SESSION['mostrar_error'] = $e->getMessage();
        }
      }
    Vista::render('publicar_vacante', $tags);
  }

  public function validarCampos($datos){
    if(Utils::getParam('registroOferta') == 1){
      $campos = array('planUsuario'=>1,
                      'nombreOferta'=>1,
                      'salarioOf'=>1,
                      'salarioConv'=>1,
                      'fechaCont'=>1,
                      'cantVac'=>1,
                      'provinciaOf'=>1,
                      'ciudadOf'=>1,
                      'area_select'=>1,
                      'subareasCand'=>1,
                      'jornadaOf'=>1,
                      'escolaridadOf'=>1,
                      'nivel_idioma'=>1,
                      'primerEmpleoOf'=>1,
                      'ofertaUrgenteOf'=>1,
                      'anosexp'=>1,
                      'licenciaOf'=>1, 
                      'DispOf'=>1, 
                      'residenciaOf'=>1,
                      'discapacidadOf'=>1,
                      'edadMinOf'=>1,
                      'edadMaxOf'=>1);
      $datosReg = $this->camposRequeridos($campos);
      $planCombo = explode("_", Utils::desencriptar($datosReg['planUsuario']));
      $confidencial = 1;//Por defecto es confidencial
      if(!Modelo_PermisoPlan::busquedaPermisoxPlan($planCombo[0], 'publicarOfertaConfidencial')){
        $confidencial = $_POST['confidencialOf'];
      }
      $datosReg = array_merge($datosReg, array('confidencialOf'=>$confidencial));
      
      $plan = $_SESSION['mfo_datos']['planes'];
      $id_empresa = null;
      $id_empresa_plan = null;
      foreach ($_SESSION['mfo_datos']['planes'] as $planes) {
        if($planes['id_empresa_plan'] == $planCombo[1]){
          $id_empresa = $planes['id_empresa'];
          $id_empresa_plan = $planes['id_empresa_plan'];
          $num_publicaciones = $planes['num_publicaciones_rest'];
        }
      }

      if($id_empresa == null){
        throw new Exception("Ha ocurrido un error");
        
      }
      if($id_empresa_plan == null){
        throw new Exception("Ha ocurrido un error");
        
      }

      $arraySubareas = array();
      $listAreas = Modelo_Area::obtieneListadoAsociativo();
      $listSubareas = Modelo_AreaSubarea::obtieneListadoAsociativo();

      for ($i=0; $i < count($datosReg['subareasCand']); $i++) { 
        $subareas = explode("_", $datosReg['subareasCand'][$i]);
        if(!in_array($subareas[0], array_keys($listAreas)) && !in_array($subareas[1], array_keys($listSubareas))){
            throw new Exception("Una o m\u00E1s \u00E1reas o sub\u00E1reas seleccionadas no est\u00E1n disponibles");
          }
          else{
            array_push($arraySubareas, $subareas[2]);
          }
      }

      if(empty($arraySubareas)){
        throw new Exception("Debe seleccionar al menos una sub\u00E1rea por \u00E1rea");
      }

      //Utils::log(print_r($datosReg,true));
      //if(count($datosReg['area_select']) != 1){
      //    throw new Exception("Seleccione el m\u00E1ximo o m\u00CDnimo permitido de \u00E1reas");
      //}

      $listadoIdiomasNivel = Modelo_NivelxIdioma::obtieneListado();
      $idiomaNivelIdioma = array();
      $arrayIdiomasSel = array();
      foreach ($listadoIdiomasNivel as $idiomas_nivel) {
        foreach ($datosReg['nivel_idioma'] as $listado_POST) {
          $idiomaList = explode("_", $listado_POST)[0];
          $idiomaNivelList = explode("_", $listado_POST)[1];
          if($idiomas_nivel['id_idioma'] == $idiomaList && $idiomas_nivel['id_nivelIdioma'] == $idiomaNivelList){
            array_push($arrayIdiomasSel, $idiomas_nivel['id_nivelIdioma_idioma']);
          }
        }
      }

      if(empty($arrayIdiomasSel)){
        throw new Exception("Seleccione al menos un idioma");
        
      }

      $datosReg = array_merge($datosReg, array("descripcion"=>$_POST['descripcionOferta'], 
                                                "id_empresa"=>$id_empresa,
                                                'id_empresa_plan'=>$id_empresa_plan,
                                                'id_areas_subareas'=> $arraySubareas,
                                                'listadoNivelIdioma'=>$arrayIdiomasSel,
                                                'numeroPub'=>$num_publicaciones));

      if(ctype_space($datosReg['nombreOferta']) 
        || Utils::validarTituloOferta($datosReg['nombreOferta'] == false 
        || Utils::validarLongitudCampos($datosReg['nombreOferta'], 100) == false)){
        throw new Exception("Ingrese un título válido para la oferta");
        
      }

      if(ctype_space($datosReg['descripcion']) && (empty($$datosReg['descripcion']) || $datosReg['descripcion'] == "")){
        throw new Exception("El campo descripci\u00F3n es obligatorio");
      }

      /*if(!Utils::formatoDinero($datosReg['salarioOf'])){
        throw new Exception("El campo salario solo permite n\u00FAmeros");
      }*/

      if (Utils::validarNumeros($datosReg['cantVac']) == false) {
        throw new Exception("El campo vacantes solo permite n\u00FAmeros");
      }

      $valida_fecha = Utils::valida_fecha($datosReg['fechaCont']);
      $valida_fecha_mayor = Utils::valida_fecha_mayor($datosReg['fechaCont']);
      if(empty($valida_fecha) || ($valida_fecha_mayor)==false){
        throw new Exception("El formato o la fecha ingresada no es v\u00E1lida");
      }
      if (Utils::validarNumeros($datosReg['edadMinOf']) == false) {
        throw new Exception("El campo de edad m\u00EDnima solo permite n\u00FAmeros");
      }
      if (Utils::validarNumeros($datosReg['edadMaxOf']) == false) {
        throw new Exception("El campo edad m\u00E1xima solo permite n\u00FAmeros");
      }
      if(Utils::validarEminEmax($datosReg['edadMinOf'], $datosReg['edadMaxOf']) == false){
         throw new Exception("Verifique los valores de los campos edad m\u00EDnima y m\u00E1xima");
      }
      return $datosReg;
    }
  }

  public function guardarDatosOferta($datos){
    $datosRequisitoOferta = array('viajar'=>$datos['DispOf'],
                                  'residencia'=>$datos['residenciaOf'],
                                  'discapacidad'=>$datos['discapacidadOf'],
                                  'confidencial'=>$datos['confidencialOf'],
                                  'edad_minima'=>$datos['edadMinOf'],
                                  'edad_maxima'=>$datos['edadMaxOf']);
    if(!Modelo_Oferta::guardarRequisitosOferta($datosRequisitoOferta)){
      throw new Exception("Ha ocurrido un error al guardar los requisitos de la oferta");
    }

    $id_requisitoOferta = $GLOBALS['db']->insert_id();      
    $fechaActual = date('Y-m-d H:m:s');
    $datosOferta = array('id_empresa'=>$datos['id_empresa'],
                         'titulo'=>$datos['nombreOferta'],
                         'descripcion'=>$datos['descripcion'],
                         'salario'=>$datos['salarioOf'],
                         'a_convenir'=>$datos['salarioConv'],
                         'fecha_contratacion'=>$datos['fechaCont'],
                         'vacantes'=>$datos['cantVac'],
                         'anosexp'=>$datos['anosexp'],
                         'estado'=>2,
                         'fecha_creado'=>$fechaActual,
                         'tipo'=>$datos['ofertaUrgenteOf'],
                         'primer_empleo'=>$datos['primerEmpleoOf'],
                         'id_jornada'=>$datos['jornadaOf'],
                         'id_ciudad'=>$datos['ciudadOf'],
                         'id_requisitoOferta'=>$id_requisitoOferta,
                         'id_escolaridad'=>$datos['escolaridadOf'],
                         'id_empresa_plan'=>$datos['id_empresa_plan'],
                         'id_tipolicencia'=>$datos['licenciaOf']
                          );
      if(!Modelo_Oferta::guardarOferta($datosOferta)){
        throw new Exception("Ha ocurrido un error al guardar los datos de la oferta");
      }

      $id_Oferta = $GLOBALS['db']->insert_id();
      if(!Modelo_OfertaxAreaSubarea::guardarOfertaAreasSubareas($id_Oferta, $datos['id_areas_subareas'])){
        throw new Exception("Ha ocurrido un error al guardar las subareas de la oferta");
      }

      if(!Modelo_OfertaxNivelIdioma::guardarOfertaNivelIdioma($id_Oferta, $datos['listadoNivelIdioma'])){
        throw new Exception("Ha ocurrido un error al guardar los idiomas de la oferta");
      }
      if(!Modelo_UsuarioxPlan::restarPublicaciones($datos['id_empresa_plan'], $datos['numeroPub'], Modelo_Usuario::EMPRESA)){
        throw new Exception("Ha ocurrido un error. Intente nuevamente");
      }      
  }




}
?>
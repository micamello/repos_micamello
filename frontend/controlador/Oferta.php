<?php
class Controlador_Oferta extends Controlador_Base{
          
    public function construirPagina()
    {
      if (!Modelo_Usuario::estaLogueado()) {
          Utils::doRedirect(PUERTO . '://' . HOST . '/login/');
      }

      //Obtiene todos los banner activos segun el tipo
      $arrbanner     = Modelo_Banner::obtieneAleatorio(Modelo_Banner::BANNER_CANDIDATO);
      //Muestra solo un banner de tipo candidato para no dar impresion que cambia de pagina        
      $_SESSION['mostrar_banner'] = PUERTO . '://' . HOST . '/imagenes/banner/' . $arrbanner['id_banner'] . '.' . $arrbanner['extension'];
      $arrbanner = Modelo_Banner::obtieneAleatorio(Modelo_Banner::PUBLICIDAD);
      //obtiene el orden del banner de forma aleatoria segun la cantidad de banner
      $_SESSION['publicidad'] = PUERTO . '://' . HOST . '/imagenes/banner/' . $arrbanner['id_banner'] . '.' . $arrbanner['extension'];
      $opcion = Utils::getParam('opcion', '', $this->data); 
      $page = Utils::getParam('page', '1', $this->data);
      $type = Utils::getParam('type', '', $this->data); 
      $vista = Utils::getParam('vista', '', $this->data); 
      $postulacionesUserLogueado = array();
      $breadcrumbs = array();
      $aspirantesXoferta = '';

      $planes = array();
      if(isset($_SESSION['mfo_datos']['planes'])){
        $planes = $_SESSION['mfo_datos']['planes'];
      }else{
       array_push($planes, array('fecha_caducidad'=>'','num_rest'=>''));
      }

      if($vista == 'oferta'){
        
        Modelo_Usuario::validaPermisos($_SESSION['mfo_datos']['usuario']['tipo_usuario'],$_SESSION['mfo_datos']['usuario']['id_usuario'],$_SESSION['mfo_datos']['infohv'],$planes,$vista);
      }

      if(!isset($_SESSION['mfo_datos']['Filtrar_ofertas']) || $opcion == '' || $opcion == 'vacantes' || $opcion == 'cuentas'){

          $_SESSION['mfo_datos']['Filtrar_ofertas'] = array('A'=>0,'P'=>0,'J'=>0,'O'=>1,'S'=>0,'Q'=>0,'K'=>0);
      }
      
      $idUsuario = $_SESSION['mfo_datos']['usuario']['id_usuario'];
      $autopostulaciones_restantes['p_restantes'] = 0;
      $postulado = array();
      $subempresas = '';
      $ofertasSubempresas = array();

      $areasInteres = $cambioRes = false;
      $areas_subareas = array();
      if(isset($_SESSION['mfo_datos']['usuario']['usuarioxarea'])){
        $areasInteres = $_SESSION['mfo_datos']['usuario']['subareas'];//implode(",",$_SESSION['mfo_datos']['usuario']['usuarioxarea']); 
        $areas_subareas = Modelo_AreaSubarea::obtieneAreas_subareas_usuario($idUsuario);
      }

      if(isset($_SESSION['mfo_datos']['usuario']['residencia']) && $_SESSION['mfo_datos']['usuario']['residencia'] == 0){
        $cambioRes = $_SESSION['mfo_datos']['usuario']['id_ciudad']; 
      }

      switch ($opcion) {
        case 'buscaDescripcion':
          $idOferta = Utils::desencriptar(Utils::getParam('idOferta', '', $this->data));
          $resultado = Modelo_Oferta::consultarDescripcionOferta($idOferta);
          Vista::renderJSON($resultado);
        break;
        case 'filtrar':

          $arrarea       = Modelo_Area::obtieneListadoAsociativo();
          $arrnivel      = Modelo_Interes::obtieneListadoAsociativo();
          $arrprovincia  = Modelo_Provincia::obtieneListadoAsociativo(SUCURSAL_PAISID);
          $arrjornadas      = Modelo_Jornada::obtieneListadoAsociativo();
          $array_empresas = Modelo_Usuario::obtieneSubempresasYplanes($idUsuario,$page,false,true);

          $empresas = array();

          foreach ($array_empresas as $key => $value) {
            $empresas[$value['id_empresa']] = $value['nombres'];
          }

          unset($this->data['mostrar'],$this->data['opcion'],$this->data['page'],$this->data['type'],$this->data['vista']);
          
          if($vista == 'oferta'){
            $autopostulaciones_restantes = Modelo_UsuarioxPlan::publicacionesRestantes($idUsuario);
            $breadcrumbs['oferta'] = 'Ofertas de empleo';
          }else if($vista == 'vacantes'){
            $breadcrumbs['vacantes'] = 'Mis Ofertas';
          }else if($vista == 'cuentas'){
            $breadcrumbs['cuentas'] = 'Ofertas subempresas';
          }else{
              $breadcrumbs['postulacion'] = 'Mis postulaciones';
          }
          $id_area = '';
          $id_provincia = '';
          $id_jornada = '';
          $cadena = '';
          $array_datos = array();
          foreach ($this->data as $param => $value) {
            $letra = substr($value,0,1);
            $id = substr($value,1);

            $cadena .= '/'.$value;
            
            if(isset($_SESSION['mfo_datos']['Filtrar_ofertas'][$letra])){
              if($letra == 'A' && $type == 1){
                if(isset($arrarea[$id])){
                  $_SESSION['mfo_datos']['Filtrar_ofertas']['A'] = $id;
                  $array_datos['A'] = array('id'=>$id,'nombre'=>$arrarea[$id]);
                }
              }
              else if($letra == 'P' && $type == 1){
                if(isset($arrprovincia[$id])){
                    $_SESSION['mfo_datos']['Filtrar_ofertas']['P'] = $id;
                    $array_datos['P'] = array('id'=>$id,'nombre'=>$arrprovincia[$id]);
                }
              }
              else if($letra == 'J' && $type == 1){
                if(isset($arrjornadas[$id])){
                    $_SESSION['mfo_datos']['Filtrar_ofertas']['J'] = $id;
                    $array_datos['J'] = array('id'=>$id,'nombre'=>$arrjornadas[$id]);
                }
              }else if($letra == 'O' && $type == 1){
                $_SESSION['mfo_datos']['Filtrar_ofertas']['O'] = $id; 
              }
              else if($letra == 'S' && $type == 1){
                $_SESSION['mfo_datos']['Filtrar_ofertas']['S'] = $id; 
              }
              else if($letra == 'K' && $type == 1){
                $_SESSION['mfo_datos']['Filtrar_ofertas']['K'] = $id; 
              }
              else if($letra == 'Q' && $type == 1){
                $_SESSION['mfo_datos']['Filtrar_ofertas']['Q'] = $id;
                $array_datos['Q'] = array('id'=>$id,'nombre'=>htmlentities($id,ENT_QUOTES,'UTF-8'));
              }else if($type == 2){
                $_SESSION['mfo_datos']['Filtrar_ofertas'][$letra] = 0;
              }
            }
          }

          foreach ($_SESSION['mfo_datos']['Filtrar_ofertas'] as $letra => $value) {

            if($value!=0 || $value != ''){

              if($letra == 'A'){
                  if(isset($arrarea[$value])){
                      $array_datos[$letra] = array('id'=>$value,'nombre'=>$arrarea[$value]);
                  }
              }
              else if($letra == 'P'){
                  if(isset($arrprovincia[$value])){
                      $array_datos[$letra] = array('id'=>$value,'nombre'=>$arrprovincia[$value]);
                  }
              }
              else if($letra == 'J'){
                  if(isset($arrjornadas[$value])){
                      $array_datos[$letra] = array('id'=>$value,'nombre'=>$arrjornadas[$value]);
                  }
              }
              else if($letra == 'S'){
                  if(isset($empresas[$value])){
                      $array_datos[$letra] = array('id'=>$value,'nombre'=>$empresas[$value]);
                  }
              }
              else if($letra == 'O'){
                  $array_datos[$letra] = array('id'=>$value,'nombre'=>$value);
              }
              else if($letra == 'K'){
                      
                if(isset(SALARIO[$value])){
                    $array_datos[$letra] = array('id'=>$value,'nombre'=>SALARIO[$value]);
                }
              }
              else if($letra == 'Q'){ 
                
                $array_datos[$letra] = array('id'=>$value,'nombre'=>htmlentities($value,ENT_QUOTES,'UTF-8'));
              }
            }
          }

          if($vista == 'cuentas'){
            $array_subempresas = array();
            $sub = $_SESSION['mfo_datos']['subempresas'];
            foreach ($sub as $key => $id) {
                array_push($array_subempresas, $key);
            }
            $idUsuario = implode(",", $array_subempresas);

            $array_empresas_hijas = $_SESSION['mfo_datos']['array_empresas_hijas'];
          }else{
            $array_empresas_hijas = array();
          }

          $filtros = $_SESSION['mfo_datos']['Filtrar_ofertas'];

          if(empty($filtros['A']) && empty($filtros['P']) && empty($filtros['J']) && empty($filtros['K']) && empty($filtros['S']) && empty($filtros['Q'])){

            if(isset($_POST['filtro'])){
              $_SESSION['mfo_datos']['filtro'] = $_POST['filtro'];
            }

            if(isset($_SESSION['mfo_datos']['filtro']) && $_SESSION['mfo_datos']['filtro'] == 0){

              $filtro = 1;
              $_SESSION['mfo_datos']['filtro'] = 0;
              $ofertas = Modelo_Oferta::obtieneOfertas(false,$page,$vista,$idUsuario,false,SUCURSAL_PAISID,false,false,$filtros);

              //Para obtener la cantidad de registros totales de la consulta
              $registros = Modelo_Oferta::obtieneOfertas(false,$page,$vista,$idUsuario,true,SUCURSAL_PAISID,false,false,$filtros); 

            }else{

              $filtro = 0;
              $_SESSION['mfo_datos']['filtro'] = 1;
              $ofertas = Modelo_Oferta::obtieneOfertas(false,$page,$vista,$idUsuario,false,SUCURSAL_PAISID,$areasInteres,$cambioRes,$filtros);     

              //Para obtener la cantidad de registros totales de la consulta
              $registros = Modelo_Oferta::obtieneOfertas(false,$page,$vista,$idUsuario,true,SUCURSAL_PAISID,$areasInteres,$cambioRes,$filtros); 
            }

          }else{

            $filtro = 1;
            $ofertas = Modelo_Oferta::filtrarOfertas($filtros,$page,$vista,$idUsuario,false,SUCURSAL_PAISID);

            //Para obtener la cantidad de registros totales de la consulta
            $registros = Modelo_Oferta::filtrarOfertas($filtros,$page,$vista,$idUsuario,true,SUCURSAL_PAISID);
          }
          
          $_SESSION['mfo_datos']['Filtrar_ofertas'] = $filtros;

          if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA){
            $aspirantesXoferta = Modelo_Oferta::aspirantesXofertas();
          }

          $enlaceCompraPlan = Vista::display('btnComprarPlan',array('presentarBtnCompra'=>$planes));

          $link = Vista::display('filtrarOfertas',array('data'=>$array_datos,'page'=>$page,'vista'=>$vista));  

          $tags = array(
            'breadcrumbs'=>$breadcrumbs,
            'arrarea'       => $arrarea,
            'arrnivel'       => $arrnivel,
            'arrprovincia'  => $arrprovincia,
            'jornadas'      => $arrjornadas,
            'ofertas'       => $ofertas,
            'enlaceCompraPlan'=>$enlaceCompraPlan,
            'autopostulaciones_restantes'=>$autopostulaciones_restantes,
            'link'=>$link,
            'vista'=>$vista,
            'filtro'=>$filtro,
            'aspirantesXoferta'=>$aspirantesXoferta,
            'array_empresas_hijas'=>$array_empresas_hijas,
            'areas_subareas'=>$areas_subareas,
          );

          if($vista != 'vacantes' && $vista != 'cuentas'){
              $tags["show_banner"] = 1;
          }
          
          $tags["template_js"][] = "tinymce/tinymce.min";
          $tags["template_js"][] = "oferta";
          $url = PUERTO.'://'.HOST.'/'.$vista.'/'.$type.$cadena;

          $pagination = new Pagination(count($registros),REGISTRO_PAGINA,$url);
          
          $pagination->setPage($page);
          $tags['paginas'] = $pagination->showPage();
          Vista::render('ofertas', $tags);
        break;
        case 'detalleOferta':

          //solo candidatos 
          if (($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) && (!isset($_SESSION['mfo_datos']['planes']) || !Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'verOfertaTrabajo'))){

            $_SESSION['mostrar_error'] = "Debe subscribirse a un plan para poder postularse a las ofertas.";
             Utils::doRedirect(PUERTO.'://'.HOST.'/planes/'); 
          }
          
          $idOferta = Utils::getParam('id', '', $this->data);
          $status = Utils::getParam('status', '', $this->data);
          
          $idOferta = Utils::desencriptar($idOferta);
          $aspiracion = Utils::getParam('aspiracion', '', $this->data);

          if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA){

            $subempresas = $_SESSION['mfo_datos']['subempresas']; 
            $array_subempresas = array();
            foreach ($subempresas as $key => $id) {
              array_push($array_subempresas, $key);
            }

            if(!empty($array_subempresas)){
              $idUsuario = $idUsuario.",".implode(",", $array_subempresas);
            }
          }

          $oferta = Modelo_Oferta::obtieneOfertas($idOferta,$page,$vista,$idUsuario,false,SUCURSAL_PAISID);

          if (Utils::getParam('postulado') == 1) {
          
            if(!empty($status)){
              self::guardarEstatus($idUsuario,$idOferta,$status);
            }else{

              if($aspiracion > 0){
                self::guardarPostulacion($idUsuario,$idOferta,$aspiracion,$vista);
                Utils::doRedirect(PUERTO.'://'.HOST.'/postulacion/'); 
              }else{
                $_SESSION['mostrar_error'] = "La aspiraci\u00f3n salarial debe ser mayor a 0";
              }
            }
          }
          
          if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO){
            $postulado = Modelo_Postulacion::obtienePostuladoxUsuario($idUsuario,$idOferta);
          }
          
          $breadcrumbs[$vista] = 'Ofertas';
          $breadcrumbs['detalleOferta'] = 'Ver detalle';
          
          $tags = array(
            'breadcrumbs'=>$breadcrumbs,
            'oferta'=> $oferta,
            'postulado'=>$postulado,
            'autopostulaciones_restantes'=>$autopostulaciones_restantes,
            'vista'=>$vista
          );
          
          $tags["show_banner"] = 1;
          $tags["template_js"][] = "oferta";
          
          Vista::render('detalle_oferta', $tags);
        break;
        case 'vacantes':
          $vista = $opcion;

          //solo empresas
          if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::EMPRESA ){
            Utils::doRedirect(PUERTO.'://'.HOST.'/'); 
          }
          
          if (Utils::getParam('guardarEdicion') == 1) {
            $idOferta = Utils::getParam('idOferta');
            self::guardarDescripcion($idOferta);
          }

          $aspirantesXoferta = Modelo_Oferta::aspirantesXofertas();
          $arrarea       = Modelo_Area::obtieneListadoAsociativo();
          $arrprovincia  = Modelo_Provincia::obtieneListadoAsociativo(SUCURSAL_PAISID);
          $jornadas      = Modelo_Jornada::obtieneListadoAsociativo();

          $ofertas = Modelo_Oferta::obtieneOfertas(false,$page,$vista,$idUsuario,false,SUCURSAL_PAISID);

          //Para obtener la cantidad de registros totales de la consulta
          $registros = Modelo_Oferta::obtieneOfertas(false,$page,$vista,$idUsuario,true,SUCURSAL_PAISID);

          $planes = array();
          if(isset($_SESSION['mfo_datos']['planes'])){
            $planes = $_SESSION['mfo_datos']['planes'];
          }else{
            array_push($planes, array('fecha_caducidad'=>'','num_rest'=>''));
          }

          $enlaceCompraPlan = Vista::display('btnComprarPlan',array('presentarBtnCompra'=>$planes));

          $breadcrumbs['vacantes'] = 'Mis Ofertas';

          $tags = array(
            'breadcrumbs'=>$breadcrumbs,
            'arrarea'       => $arrarea,
            'arrprovincia'  => $arrprovincia,
            'jornadas'      => $jornadas,
            'ofertas'       => $ofertas,
            'page' => $page,
            'vista'=>$vista,
            'ofertasSubempresas' => $ofertasSubempresas,
            'aspirantesXoferta'=>$aspirantesXoferta,
            'enlaceCompraPlan'=>$enlaceCompraPlan
          );
          
          $tags["template_js"][] = "tinymce/tinymce.min";
          $tags["template_js"][] = "oferta";
          
          $url = PUERTO.'://'.HOST.'/'.$vista;
          $pagination = new Pagination(count($registros),REGISTRO_PAGINA,$url);
          $pagination->setPage($page);
          $tags['paginas'] = $pagination->showPage();
          
          Vista::render('ofertas', $tags);
        break;
        case 'cuentas':
          $vista = $opcion;

          //solo empresas
          $subempresas = $_SESSION['mfo_datos']['subempresas']; 
          $array_subempresas = array();
          foreach ($subempresas as $key => $id) {
            array_push($array_subempresas, $key);
          }

          if(!empty($array_subempresas)){
            $subempresas = implode(",", $array_subempresas);
          } 
          
          if ($subempresas == '') {
            Utils::doRedirect(PUERTO . '://' . HOST . '/vacantes/');
          }

          $ofertas = Modelo_Oferta::obtieneOfertas(false,$page,$vista,$subempresas,false,SUCURSAL_PAISID);

          //Para obtener la cantidad de registros totales de la consulta
          $cantidad_ofertas = Modelo_Oferta::obtieneOfertas(false,$page,$vista,$subempresas,true,SUCURSAL_PAISID);

          $array_empresas_hijas = array();
          foreach ($cantidad_ofertas as $key => $value) {
            if (!isset($array_empresas_hijas[$value['id_usuario']])){
              $array_empresas_hijas[$value['id_usuario']] = $value['nombres'];
            }
          }

          $_SESSION['mfo_datos']['array_empresas_hijas'] = $array_empresas_hijas;

          $aspirantesXoferta = Modelo_Oferta::aspirantesXofertas();
          $arrarea       = Modelo_Area::obtieneListadoAsociativo();
          $arrprovincia  = Modelo_Provincia::obtieneListadoAsociativo(SUCURSAL_PAISID);
          $jornadas      = Modelo_Jornada::obtieneListadoAsociativo();

          $breadcrumbs['cuentas'] = 'Ofertas subempresas';

          $tags = array(
            'breadcrumbs'=>$breadcrumbs,
            'arrarea'       => $arrarea,
            'arrprovincia'  => $arrprovincia,
            'jornadas'      => $jornadas,
            'ofertas'       => $ofertas,
            'page' => $page,
            'vista'=>$vista,
            'aspirantesXoferta'=>$aspirantesXoferta,
            'array_empresas_hijas'=>$array_empresas_hijas
          );
          
          $tags["template_js"][] = "tinymce/tinymce.min";
          $tags["template_js"][] = "oferta";
          
          $url = PUERTO.'://'.HOST.'/'.$vista;
          $pagination = new Pagination(count($cantidad_ofertas),REGISTRO_PAGINA,$url);
          $pagination->setPage($page);
          $tags['paginas'] = $pagination->showPage();
          
          Vista::render('ofertas', $tags);
        break;
        default:            
          //solo candidatos 
          if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::CANDIDATO){
            Utils::doRedirect(PUERTO.'://'.HOST.'/');               
          }

          if(isset($_SESSION['mfo_datos']['planes'])){            
            $planes = $_SESSION['mfo_datos']['planes'];
          }else{
            $planes = null;
          }
          //Modelo_Usuario::validaPermisos($_SESSION['mfo_datos']['usuario']['tipo_usuario'],$_SESSION['mfo_datos']['usuario']['id_usuario'],$_SESSION['mfo_datos']['infohv'],$planes,$vista);

          $eliminarPostulacion = Utils::getParam('eliminarPostulacion', '', $this->data);
          $empresa = Utils::getParam('empresa', '', $this->data);

          if(!empty($eliminarPostulacion)){

            $tiempo = Modelo_Parametro::obtieneValor('eliminar_postulacion');
            if(!empty($empresa)){
              $tipo_post = 1; 
            }else{
              $tipo_post = 2;
            }

            $r = Modelo_Postulacion::postAutoxIdPostAeliminar($_SESSION['mfo_datos']['usuario']['id_usuario'],$empresa,$tiempo);
          
            if(!empty($r['ids_postulaciones'])){
              $resultado = Modelo_Postulacion::eliminarPostulacion($r['ids_postulaciones'],$tipo_post);
              if(empty($resultado)){
                $_SESSION['mostrar_error'] = 'No se pudo eliminar la postulaci\u00f3n, intente de nuevo1';
              }else{
                Modelo_EmpresaBloq::insertEmpresa($_SESSION['mfo_datos']['usuario']['id_usuario'],$empresa);
                  self::devolverPostulaciones(explode(",",$r['ids_usuariosplanes']));
                  $_SESSION['mostrar_exito'] = 'Se ha eliminado la postulaci\u00f3n exitosamente';                    
                  //Utils::doRedirect(PUERTO.'://'.HOST.'/'.$vista.'/');
              }
            }else{

              if($tipo_post == 1){
                 $_SESSION['mostrar_error'] = 'No se pudo eliminar la postulaci\u00f3n, Ya pasaron las '.$tiempo.' horas de postulado.';
              }else{
                $resultado = Modelo_Postulacion::eliminarPostulacion($eliminarPostulacion,$tipo_post);
                if(empty($resultado)){
                    $_SESSION['mostrar_error'] = 'No se pudo eliminar la postulaci\u00f3n, intente de nuevo';
                }else{                    
                  $_SESSION['mostrar_exito'] = 'Se ha eliminado la postulaci\u00f3n exitosamente';
                  //Utils::doRedirect(PUERTO.'://'.HOST.'/'.$vista.'/');
                }
              }
            }
          }

          $arrarea       = Modelo_Area::obtieneListadoAsociativo();
          $arrprovincia  = Modelo_Provincia::obtieneListadoAsociativo(SUCURSAL_PAISID);
          $jornadas      = Modelo_Jornada::obtieneListadoAsociativo();

          $enlaceCompraPlan = Vista::display('btnComprarPlan',array('presentarBtnCompra'=>$planes));
          if($vista == 'oferta'){

            if(isset($_POST['filtro'])){
              $_SESSION['mfo_datos']['filtro'] = $_POST['filtro'];
            }

            if(isset($_SESSION['mfo_datos']['filtro']) && $_SESSION['mfo_datos']['filtro'] == 0){

              $filtro = 1;
              $_SESSION['mfo_datos']['filtro'] = 0;
              $ofertas = Modelo_Oferta::obtieneOfertas(false,$page,$vista,$idUsuario,false,SUCURSAL_PAISID);

              //Para obtener la cantidad de registros totales de la consulta
              $registros = Modelo_Oferta::obtieneOfertas(false,$page,$vista,$idUsuario,true,SUCURSAL_PAISID); 
            }else{

              $filtro = 0;
              $_SESSION['mfo_datos']['filtro'] = 1;
              $ofertas = Modelo_Oferta::obtieneOfertas(false,$page,$vista,$idUsuario,false,SUCURSAL_PAISID,$areasInteres,$cambioRes);     

              //Para obtener la cantidad de registros totales de la consulta
              $registros = Modelo_Oferta::obtieneOfertas(false,$page,$vista,$idUsuario,true,SUCURSAL_PAISID,$areasInteres,$cambioRes); 
            }
          }
          
          if($vista != 'postulacion'){             
            $autopostulaciones_restantes = Modelo_UsuarioxPlan::publicacionesRestantes($idUsuario);
            $breadcrumbs['oferta'] = 'Ofertas de empleo';
          }else{

            $filtro = 0;
            //$tiempo = Modelo_Parametro::obtieneValor('eliminar_postulacion');
            $ofertas = Modelo_Oferta::obtieneOfertas(false,$page,$vista,$idUsuario,false,SUCURSAL_PAISID);
            //print_r($ofertas);
            //Para obtener la cantidad de registros totales de la consulta
            $registros = Modelo_Oferta::obtieneOfertas(false,$page,$vista,$idUsuario,true,SUCURSAL_PAISID); 
            $breadcrumbs['postulacion'] = 'Mis postulaciones';
          }

          $tags = array(
            'breadcrumbs'=>$breadcrumbs,
            'arrarea'       => $arrarea,
            'arrnivel'      => $arrnivel,
            'arrprovincia'  => $arrprovincia,
            'jornadas'      => $jornadas,
            'ofertas'       => $ofertas,
            'enlaceCompraPlan'=>$enlaceCompraPlan,
            'autopostulaciones_restantes'=>$autopostulaciones_restantes,
            'page' => $page,
            'filtro'=>$filtro,
            'areas_subareas'=>$areas_subareas,
            'vista'=>$vista
          );
          $tags["template_js"][] = "tinymce/tinymce.min";
          $tags["template_js"][] = "oferta";
          $tags["show_banner"] = 1;
          
          $url = PUERTO.'://'.HOST.'/'.$vista; 

          $pagination = new Pagination(count($registros),REGISTRO_PAGINA,$url);
          $pagination->setPage($page);
          $tags['paginas'] = $pagination->showPage();
          Vista::render('ofertas', $tags);
        break;
      }
    }


    public function guardarDescripcion($idOferta){

      try{
          if (!Modelo_Oferta::guardarDescripcion($idOferta,str_replace('"', "'", $_POST['des_of']))) {
              throw new Exception("Ha ocurrido un error al guardar la descripcion, intente nuevamente");
          }
          $GLOBALS['db']->commit();
          $tiempo = Modelo_Parametro::obtieneValor('tiempo_espera');
          $_SESSION['mostrar_exito'] = 'La descripci\u00f3n fue editada exitosamente, debe esperar un máximo de '.$tiempo.' horas para que el administrador apruebe el nuevo contenido.';
      }catch (Exception $e) {
          $_SESSION['mostrar_error'] = $e->getMessage();
          $GLOBALS['db']->rollback();
      }
    }

    public function guardarPostulacion($id_usuario,$id_oferta,$aspiracion,$vista){
      try{
          if (isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'postulacion') && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) {
              if (!Modelo_Postulacion::postularse($id_usuario,$id_oferta,$aspiracion)) {
                  throw new Exception("Ha ocurrido un error la postulaci\u00f3n, intente nuevamente");
              }
              $GLOBALS['db']->commit();
              $_SESSION['mostrar_exito'] = 'Se ha postulado a esta oferta exitosamente';
              $this->redirectToController('oferta');
          }else{
              $_SESSION['mostrar_error'] = "No tiene permiso para postularse, contrate un plan"; 
              $this->redirectToController('detalleOferta/'.$vista.'/'.$id_oferta);
          }
      }catch (Exception $e) {
          $_SESSION['mostrar_error'] = $e->getMessage();
          $GLOBALS['db']->rollback();
          $this->redirectToController('detalleOferta/'.$vista.'/'.$id_oferta); 
      }
    }

    public function guardarEstatus($id_usuario,$id_oferta,$resultado){
      try{
          if (!Modelo_Postulacion::cambiarEstatus($id_usuario,$id_oferta,$resultado)) {
              throw new Exception("Ha ocurrido un error en el cambio de estatus, intente nuevamente");
          }
          $GLOBALS['db']->commit();
          $_SESSION['mostrar_exito'] = 'El estatus de la oferta fue editado exitosamente';
          $this->redirectToController('postulacion');
      }catch (Exception $e) {
          $_SESSION['mostrar_error'] = $e->getMessage();
          $GLOBALS['db']->rollback();
          $this->redirectToController('detalle_oferta');
      }
    }

    /*public static function calcularRuta($ruta,$letraDescartar){
      foreach ($_SESSION['mfo_datos']['Filtrar_ofertas'] as $key => $v) {
        if($letraDescartar != $key){
          if($key == 'A' && $v != 0){
              $ruta .= 'A'.$v.'/';
          }
          if($key == 'P' && $v != 0){
              $ruta .= 'P'.$v.'/';
          }
          if($key == 'J' && $v != 0){
              $ruta .= 'J'.$v.'/';
          }
          if($key == 'S' && $v != 0){
              $ruta .= 'S'.$v.'/';
          }
          if($key == 'Q' && $v != 0){
              $ruta .= 'Q'.$v.'/';
          }
        }
      }
      return $ruta;
    }*/

    public static function devolverPostulaciones($ids_planes){

      foreach ($ids_planes as $key => $id_plan_usuario) {
        Modelo_UsuarioxPlan::sumarPublicaciones($id_plan_usuario);
      }

    }
}
?>
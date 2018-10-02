<?php
class Controlador_Oferta extends Controlador_Base{
    
      function __construct(){
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

        //Muestra solo un banner de tipo candidato para no dar impresion que cambia de pagina
        $orden = 0;
        $_SESSION['mostrar_banner'] = PUERTO . '://' . HOST . '/imagenes/banner/' . $arrbanner[$orden]['id_banner'] . '.' . $arrbanner[$orden]['extension'];

        $arrbanner = Modelo_Banner::obtieneListado(Modelo_Banner::PUBLICIDAD);

        //obtiene el orden del banner de forma aleatoria segun la cantidad de banner
        $orden = rand(1, count($arrbanner)) - 1;
        $_SESSION['publicidad'] = PUERTO . '://' . HOST . '/imagenes/banner/' . $arrbanner[$orden]['id_banner'] . '.' . $arrbanner[$orden]['extension'];

        $opcion = Utils::getParam('opcion', '', $this->data);
        $page = Utils::getParam('page', '1', $this->data);
        $type = Utils::getParam('type', '', $this->data); 
        $vista = Utils::getParam('vista', '', $this->data);
        $postulacionesUserLogueado = array();
        $breadcrumbs = array();
        $aspirantesXoferta = '';

        if($vista == 'oferta'){

          if(isset($_SESSION['mfo_datos']['planes'])){            
            $planes = $_SESSION['mfo_datos']['planes'];
          }else{
            $planes = null;
          }

          Modelo_Usuario::validaPermisos($_SESSION['mfo_datos']['usuario']['tipo_usuario'],$_SESSION['mfo_datos']['usuario']['id_usuario'],$_SESSION['mfo_datos']['infohv'],$planes,$vista);
        }

        if(!isset($_SESSION['mfo_datos']['Filtrar_ofertas']) || $opcion == ''){
            $_SESSION['mfo_datos']['Filtrar_ofertas'] = array('A'=>0,'P'=>0,'J'=>0,'O'=>1,'Q'=>0);
        }
        
        $idUsuario = $_SESSION['mfo_datos']['usuario']['id_usuario'];
        $autopostulaciones_restantes['p_restantes'] = 0;
        switch ($opcion) {
        	case 'filtrar':

              $arrarea       = Modelo_Area::obtieneListadoAsociativo();
              $arrprovincia  = Modelo_Provincia::obtieneListadoAsociativo($_SESSION['mfo_datos']['sucursal']['id_pais']);
              $arrjornadas      = Modelo_Jornada::obtieneListadoAsociativo();

              unset($this->data['mostrar'],$this->data['opcion'],$this->data['page'],$this->data['type'],$this->data['vista']);
              
              if($vista == 'oferta'){
                  $postulacionesUserLogueado = Modelo_Postulacion::obtienePostulaciones($idUsuario);
                  $breadcrumbs['oferta'] = 'Ofertas de empleo';
              }else if($vista == 'vacantes'){
                  $breadcrumbs['vacantes'] = 'Mis Ofertas';
                  $aspirantesXoferta = Modelo_Oferta::aspirantesXofertas();
              }else{
                  $breadcrumbs['postulacion'] = 'Mis postulaciones';
              }

              $id_area = '';
              $id_provincia = '';
              $id_jornada = '';
              $cadena = '';
              $array_datos = $result = array();

              foreach ($this->data as $param => $value) {
                  
                  $letra = substr($value,0,1);
                  $id = substr($value,1);
                  $cadena .= '/'.$value;
                  array_push($result, strval($value));

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
                      else if($letra == 'Q' && $type == 1){

                          $_SESSION['mfo_datos']['Filtrar_ofertas']['Q'] = $id;
                          $array_datos['Q'] = array('id'=>$id,'nombre'=>$id);

                      }else if($type == 2){

                          $_SESSION['mfo_datos']['Filtrar_ofertas'][$letra] = 0;
                      }
                  }
              }

              foreach ($_SESSION['mfo_datos']['Filtrar_ofertas'] as $letra => $value) {

                  if($value!=0){

                      if($letra == 'A'){
                          if(isset($arrarea[$value])){
                              $array_datos[$letra] = array('id'=>$value,'nombre'=>$arrarea[$value]);
                          }
                      }

                      if($letra == 'P'){
                          if(isset($arrprovincia[$value])){
                              $array_datos[$letra] = array('id'=>$value,'nombre'=>$arrprovincia[$value]);
                          }
                      }
                      if($letra == 'J'){
                          if(isset($arrjornadas[$value])){
                              $array_datos[$letra] = array('id'=>$value,'nombre'=>$arrjornadas[$value]);
                          }
                      }
                      if($letra == 'O'){
                          $array_datos[$letra] = array('id'=>$value,'nombre'=>$value);
                      }
                      if($letra == 'Q'){
                          $array_datos[$letra] = array('id'=>$value,'nombre'=>$value);
                      }
                  }
              }

              $ofertas = Modelo_Oferta::filtrarOfertas($_SESSION['mfo_datos']['Filtrar_ofertas'],$page,$vista,$idUsuario,false,14);
              $ofertas = self::ordenarOfertasXareasUsuario($idUsuario,$ofertas);

              $link = Vista::display('filtrarOfertas',array('data'=>$array_datos,'page'=>$page,'vista'=>$vista));  

              $tags = array(
                  'breadcrumbs'=>$breadcrumbs,
                  'arrarea'       => $arrarea,
                  'arrprovincia'  => $arrprovincia,
                  'jornadas'      => $arrjornadas,
                  'ofertas'       => $ofertas,
                  'postulacionesUserLogueado' => $postulacionesUserLogueado,
                  'autopostulaciones_restantes'=>$autopostulaciones_restantes,
                  'link'=>$link,
                  'vista'=>$vista,
                  'aspirantesXoferta'=>$aspirantesXoferta
              );

              if($vista != 'vacantes'){
                  $tags["show_banner"] = 1;
              }
              
              $tags["template_js"][] = "validator";
              $tags["template_js"][] = "oferta";

              $url = PUERTO.'://'.HOST.'/'.$vista.'/'.$type.$cadena;
              $pagination = new Pagination(Modelo_Oferta::filtrarOfertas($_SESSION['mfo_datos']['Filtrar_ofertas'],$page,$vista,$idUsuario,true,14),REGISTRO_PAGINA,$url);
              $pagination->setPage($page);
              $tags['paginas'] = $pagination->showPage();

              Vista::render('ofertas', $tags);
            break;
            case 'detalleOferta':

                //solo candidatos 
                if (($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) && (!isset($_SESSION['mfo_datos']['planes']) || !Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'verOfertaTrabajo'))){
                    Utils::doRedirect(PUERTO.'://'.HOST.'/'); 
                }
                
                $idOferta = Utils::getParam('id', '', $this->data);
                $status = Utils::getParam('status', '', $this->data);
                
                $aspiracion = Utils::getParam('aspiracion', '', $this->data);
                $oferta = Modelo_Oferta::obtieneOfertas($idOferta,$page,$vista,$idUsuario,false,14);
                
                if (Utils::getParam('postulado') == 1) {
                
                    if(!empty($status)){
                        self::guardarEstatus($idUsuario,$idOferta,$status);
                    }else{
                        self::guardarPostulacion($idUsuario,$idOferta,$aspiracion,$vista);
                    }
                    Utils::doRedirect(PUERTO.'://'.HOST.'/postulacion/'); 
                }
                
                $postulado = Modelo_Postulacion::obtienePostuladoxUsuario($idUsuario,$idOferta);
                
                $breadcrumbs[$vista] = ucfirst($vista);
                $breadcrumbs['detalleOferta'] = 'Ver detalle';
                
                $tags = array(
                    'breadcrumbs'=>$breadcrumbs,
                    'oferta'=> $oferta,
                    'postulado'=>$postulado,
                    'autopostulaciones_restantes'=>$autopostulaciones_restantes,
                    'vista'=>$vista
                );
                
                $tags["show_banner"] = 1;
                $tags["template_js"][] = "validator";
                $tags["template_js"][] = "oferta";
                
                Vista::render('detalle_oferta', $tags);
            break;
            case 'vacantes':

                $vista = $opcion;
                
                //solo empresas
                if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::EMPRESA ){
                    Utils::doRedirect(PUERTO.'://'.HOST.'/'); 
                }

                $aspirantesXoferta = Modelo_Oferta::aspirantesXofertas();
                $arrarea       = Modelo_Area::obtieneListadoAsociativo();
                $arrprovincia  = Modelo_Provincia::obtieneListadoAsociativo($_SESSION['mfo_datos']['sucursal']['id_pais']);
                $jornadas      = Modelo_Jornada::obtieneListadoAsociativo();
                $ofertas = Modelo_Oferta::obtieneOfertas(false,$page,$vista,$idUsuario,false,14);
                
                $breadcrumbs['vacantes'] = 'Mis Ofertas';
   
                $tags = array(
                    'breadcrumbs'=>$breadcrumbs,
                    'arrarea'       => $arrarea,
                    'arrprovincia'  => $arrprovincia,
                    'jornadas'      => $jornadas,
                    'ofertas'       => $ofertas,
                    'page' => $page,
                    'vista'=>$vista,
                    'aspirantesXoferta'=>$aspirantesXoferta
                );
                
                $tags["template_js"][] = "oferta";
                
                $url = PUERTO.'://'.HOST.'/'.$vista;
                $pagination = new Pagination(Modelo_Oferta::obtieneOfertas(false,$page,$vista,$idUsuario,true,14),REGISTRO_PAGINA,$url);
                $pagination->setPage($page);
                $tags['paginas'] = $pagination->showPage();
                
                Vista::render('ofertas', $tags);
            break;
            default:

    	      //solo candidatos 
    	      if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::CANDIDATO){
    	        Utils::doRedirect(PUERTO.'://'.HOST.'/'); 
    	      }

    	      $eliminarPostulacion = Utils::getParam('eliminarPostulacion', '', $this->data);

    	      if(!empty($eliminarPostulacion)){
    	          $r = Modelo_Postulacion::eliminarPostulacion($eliminarPostulacion);
    	          if(!$r){
    	              $_SESSION['mostrar_error'] = 'No se pudo eliminar la postulación, intente de nuevo';
    	          }else{
    	              $_SESSION['mostrar_exito'] = 'Se ha eliminado la postulacion exitosamente';
    	          }
    	      }

    	      $arrarea       = Modelo_Area::obtieneListadoAsociativo();
    	      $arrprovincia  = Modelo_Provincia::obtieneListadoAsociativo($_SESSION['mfo_datos']['sucursal']['id_pais']);
    	      $jornadas      = Modelo_Jornada::obtieneListadoAsociativo();

    	      $ofertas = Modelo_Oferta::obtieneOfertas(false,$page,$vista,$idUsuario,false,14);
            $ofertas = self::ordenarOfertasXareasUsuario($idUsuario,$ofertas);

    	      if($vista != 'postulacion'){
    	          $postulacionesUserLogueado = Modelo_Postulacion::obtienePostulaciones($idUsuario,$page);
    	          $breadcrumbs['oferta'] = 'Ofertas de empleo';
    	      }else{
    	          $breadcrumbs['postulacion'] = 'Mis postulaciones';
                $autopostulaciones_restantes = Modelo_UsuarioxPlan::publicacionesRestantes($idUsuario);
    	      }

    	      $tags = array(
    	          'breadcrumbs'=>$breadcrumbs,
    	          'arrarea'       => $arrarea,
    	          'arrprovincia'  => $arrprovincia,
    	          'jornadas'      => $jornadas,
    	          'ofertas'       => $ofertas,
                'autopostulaciones_restantes'=>$autopostulaciones_restantes,
    	          'postulacionesUserLogueado' => $postulacionesUserLogueado,
    	          'page' => $page,
    	          'vista'=>$vista
    	      );

    	      $tags["template_js"][] = "validator";
    	      $tags["template_js"][] = "oferta";
    	      $tags["show_banner"] = 1;
    	      
    	      $url = PUERTO.'://'.HOST.'/'.$vista; 
    	      $pagination = new Pagination(Modelo_Oferta::obtieneOfertas(false,$page,$vista,$idUsuario,true,14),REGISTRO_PAGINA,$url);
    	      $pagination->setPage($page);
    	      $tags['paginas'] = $pagination->showPage();

    	      Vista::render('ofertas', $tags);
    	      break;
        }
    }


    public function ordenarOfertasXareasUsuario($idUsuario,$ofertas){

      $usuarioxarea = Modelo_UsuarioxArea::obtieneListado($idUsuario);
      $array_ofertasXarea = $array_ofertaxRestantes = array(); 
      foreach ($ofertas as $key => $value) {
        if(in_array($value['id_area'], $usuarioxarea)){
          $array_ofertasXarea[] = $value;
        }else{
          $array_ofertaxRestantes[] = $value;
        } 
      }
      return $ofertas = array_merge($array_ofertasXarea,$array_ofertaxRestantes);
    }

    public function guardarPostulacion($id_usuario,$id_oferta,$aspiracion,$vista){
      try{
          if (isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'postulacion') && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) {
              if (!Modelo_Postulacion::postularse($id_usuario,$id_oferta,$aspiracion)) {
                  throw new Exception("Ha ocurrido un error la postulación, intente nuevamente");
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

    public static function calcularRuta($ruta,$letraDescartar){

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
          if($key == 'Q' && $v != 0){
              $ruta .= 'Q'.$v.'/';
          }
        }
      }
      return $ruta;
    }
}
?>
<?php
class Controlador_Perfil extends Controlador_Base
{
    public function construirPagina()
    {
        //Si el usuario no esta logueado lo retorna a la página de logueo
        if (!Modelo_Usuario::estaLogueado()) {
            Utils::doRedirect(PUERTO . '://' . HOST . '/login/');
        }    

        if(empty($_SESSION['mfo_datos']['usuario']['ultima_sesion']) && ($_SESSION['mfo_datos']['usuario']['tipo_registro'] == Modelo_Usuario::PRE_REG || $_SESSION['mfo_datos']['usuario']['tipo_registro'] == Modelo_Usuario::REDSOCIAL_REG)){
            Utils::doRedirect(PUERTO.'://'.HOST.'/cambioClave/');
        }
                        
        $msj1 = $imgArch1 = $btnDescarga = '';
        $tipo_usuario = $_SESSION['mfo_datos']['usuario']['tipo_usuario'];

        $breadcrumbs = array();

        $opcion = Utils::getParam('opcion', '', $this->data);
        switch ($opcion) {
            //case 'guardarGrafico':
            //   $_SESSION['mfo_datos']['grafico'] = $_POST['imagen'];
            //break;
            case 'buscarDni':
                $dni = Utils::getParam('dni', '', $this->data); 
                //Permite determinar si el documento ingresado ya esta registrado en base de datos
                $datodni = Modelo_Usuario::existeDni($dni);
                Vista::renderJSON(array('resultado' => $datodni));
            break;
            case 'buscaDependencia':
                $id_escolaridad = Utils::getParam('id_escolaridad', '', $this->data); 
                //Permite obtener cuales de las ecolaridades es dependiente 
                $dependencia    = Modelo_Escolaridad::obtieneDependencia($id_escolaridad);
                Vista::renderJSON($dependencia);
            break;
            case 'buscaCiudad':
                $id_provincia = Utils::getParam('id_provincia', '', $this->data);
                //Permite buscar todas las ciudades relacionadas con la provincia pasada por parametro
                $arrciudad    = Modelo_Ciudad::obtieneCiudadxProvincia($id_provincia);
                Vista::renderJSON($arrciudad);
                break;
            default:                
                $arridioma = $arrnivelidioma = $escolaridad = $arrarea = $universidades = $puedeDescargarInforme = $genero = $situacionLaboral = $licencia = $estado_civil = $areas = $arrsectorind = $nivelIdiomas = $cargo = array();          

                //Listados de datos para llenar los select de la vista
                if ($tipo_usuario == Modelo_Usuario::CANDIDATO) {
                    $arridioma = Modelo_Idioma::obtieneListado();
                    $arrnivelidioma = Modelo_NivelIdioma::obtieneListado();
                    $escolaridad  = Modelo_Escolaridad::obtieneListado();
                    $arrarea      = Modelo_Area::obtieneListado();
                    $universidades   = Modelo_Universidad::obtieneListado(SUCURSAL_PAISID);
                    $puedeDescargarInforme = self::obtenerPermiso($_SESSION['mfo_datos']['usuario']['id_usuario']);
                    $genero = Modelo_Genero::obtenerListadoGenero();
                    $situacionLaboral = Modelo_SituacionLaboral::obtieneListadoAsociativo();
                    $licencia = Modelo_TipoLicencia::obtieneListadoAsociativo();
                    $estado_civil = Modelo_EstadoCivil::obtieneListado();
                    $areas = Modelo_AreaSubarea::obtieneAreas_Subareas();
                    $nivelIdiomas = Modelo_UsuarioxNivelIdioma::obtenerIdiomasUsuario($_SESSION['mfo_datos']['usuario']['id_usuario']);
                }else{
                    $arrsectorind = Modelo_SectorIndustrial::consulta();
                    $cargo = Modelo_Cargo::consulta();
                }
                
                $arrprovincia = Modelo_Provincia::obtieneProvinciasSucursal(SUCURSAL_PAISID);
                $nacionalidades = Modelo_Pais::obtieneListado();

                $area_select  = $nivel_interes  = false;
                $btnSig       = 0;
                $ruta_arch = '#';
                $btnSubir  = 1;
                $btnDescarga = 0;
                $data = array();

                //Detecta si el parametro actualizar viene por post para así acceder a la edición
                if (Utils::getParam('actualizar') == 1) {
                    $btnSig = 1;
                    if(!isset($_FILES['subirCV'])){
                        $_FILES['subirCV'] = ''; 
                    }
                    $btnSubir  = 0;
                    //Guarda los datos editados por el usuario
                    $data = self::guardarPerfil($_FILES['file-input'], $_FILES['subirCV'], $_SESSION['mfo_datos']['usuario']['id_usuario'],$tipo_usuario);
                    $nivelIdiomas = Modelo_UsuarioxNivelIdioma::obtenerIdiomasUsuario($_SESSION['mfo_datos']['usuario']['id_usuario']);
                }

                if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA && 
                    (empty($_SESSION['mfo_datos']['usuario']['id_cargo']) || 
                     empty($_SESSION['mfo_datos']['usuario']['nro_trabajadores']))){           
                  $_SESSION['mostrar_notif'] = "Debe completar el perfil para continuar";        
                } 
                
                //Detecta si el parametro cambiarClave viene por post para así acceder al cambio de clave
                if (Utils::getParam('cambiarClave') == 1) {

                    //Guarda el cambio de clave
                    $existeError = self::guardarClave($_SESSION['mfo_datos']['usuario']['id_usuario_login'],1);

                    if($existeError == 1){
                        $this->redirectToController('perfil');
                    }else{
                        $_SESSION['mostrar_exito'] = 'La contrase\u00F1a fue modificada exitosamente.';
                    }
                }

                //Obtiene los datos necesarios según los datos del usuario
                $provincia    = Modelo_Provincia::obtieneProvincia($_SESSION['mfo_datos']['usuario']['id_ciudad']);
                $arrciudad    = Modelo_Ciudad::obtieneCiudadxProvincia($provincia['id_provincia']);

                //Valida que el único que guarda foto es el candidato y si tiene o no cargado uno previo
                if (isset($_SESSION['mfo_datos']['usuario']['infohv']) && $tipo_usuario == Modelo_Usuario::CANDIDATO) {
                    $nombre_arch = $_SESSION['mfo_datos']['usuario']['username'] . '.' . $_SESSION['mfo_datos']['usuario']['infohv']['formato'];
                    $ruta_arch   = PUERTO."://".HOST.'/hojasDeVida/'.$_SESSION['mfo_datos']['usuario']['username'].'/';
                    $btnDescarga = 1;                   
                }

                //Verifica si el usuario tiene datos en la variable de session para las areas y subareas seleccionadas
                if(isset($_SESSION['mfo_datos']['usuario']['usuarioxarea'])){
                    $areaxusuario  = $_SESSION['mfo_datos']['usuario']['usuarioxarea'];
                }else{
                    $areaxusuario  = Modelo_UsuarioxArea::obtieneListado($_SESSION['mfo_datos']['usuario']['id_usuario']);
                }

                $breadcrumbs['perfil'] = 'Editar mi perfil';
                $nrototalfacetas = count(Modelo_Faceta::obtenerFacetas());
                $porcentaje_por_usuario = Modelo_PorcentajexFaceta::consultaxUsuario($_SESSION['mfo_datos']['usuario']["id_usuario"]);                
                if (!isset($_SESSION['mfo_datos']['usuario']['grafico']) || empty($_SESSION['mfo_datos']['usuario']['grafico'])){
                    $result_faceta = Modelo_PorcentajexFaceta::consultaxUsuario($_SESSION['mfo_datos']['usuario']['id_usuario']);
                    $str_grafico = '';
                    $reg_ultimo = array_shift($result_faceta);
                    foreach($result_faceta as $rs){
                      $str_grafico .= $rs["literal"].":".$rs["valor"].",".$rs["valor"]."|";
                    }
                    $str_grafico .= $reg_ultimo["literal"].":".$reg_ultimo["valor"].",".$reg_ultimo["valor"];       
                }

                $tags = array('escolaridad' => $escolaridad,
                    'arrarea'                   => $arrarea,
                    'areaxusuario'              => $areaxusuario,
                    'arrprovincia'              => $arrprovincia,
                    'nivelxusuario'             => $nivelxusuario,
                    'provincia'                 => $provincia['id_provincia'],
                    'arrciudad'                 => $arrciudad,
                    'btnSig'                    => $btnSig,
                    'btnSubir'                  => $btnSubir,
                    'btnDescarga'               => $btnDescarga,
                    'ruta_arch'                 => $ruta_arch,
                    'porcentaje_por_usuario'    =>$porcentaje_por_usuario,
                    'nrototalfacetas'            =>$nrototalfacetas,
                    'nacionalidades'            =>$nacionalidades,
                    'universidades'             =>$universidades,
                    'arridioma'                 =>$arridioma,
                    'arrnivelidioma'            =>$arrnivelidioma,
                    'nivelIdiomas'              => $nivelIdiomas,
                    'puedeDescargarInforme'     =>$puedeDescargarInforme,
                    'genero'=>$genero,
                    'situacionLaboral'=>$situacionLaboral,
                    'licencia'=>$licencia,
                    'estado_civil'=>$estado_civil,
                    'areas'=>$areas,
                    'arrsectorind'=>$arrsectorind,
                    'cargo'=>$cargo,
                    'val_grafico'=>$str_grafico,
                    'breadcrumbs'=>$breadcrumbs
                );

                //Pasar a la vista los js y css que se van a necesitar
                $tags["template_css"][] = "DateTimePicker";
                $tags["template_css"][] = "multiple_select";
                $tags["template_js"][] = "multiple_select";
                $tags["template_js"][] = "DniRuc_Validador";
                $tags["template_js"][] = "DateTimePicker";
                $tags["template_js"][] = "editarPerfil";
                $tags["show_banner"] = 1;

                //En caso de lanzar algún error se guarda en la variable data para mostrar en los campos y no tenga que volverlos a escribir el usuario
                if(!empty($_SESSION['mostrar_error'])){
                    $tags['data'] = $data;
                    $tags['btnSig'] = 0;
                }
                Vista::render('perfil', $tags);                
            break;
        }
    }

    //Función para hacer el validado de todos los campos del módulo de perfil y si no hay ningun problema proceder al guardado, sino hace un rollback
    public function guardarPerfil($imagen, $archivo, $idUsuario,$tipo_usuario){
        try {

            $listAreas = Modelo_Area::obtieneListadoAsociativo();
            $listSubareas = Modelo_AreaSubarea::obtieneListadoAsociativo();

            if ($tipo_usuario == Modelo_Usuario::CANDIDATO) {

                $campos = array('nombres' => 1, 'apellidos' => 1, 'ciudad' => 1, 'provincia' => 1, 'estado_civil' => 1,'discapacidad' => 0, 'fecha_nacimiento' => 1, 'telefono' => 1, 'genero' => 1, 'escolaridad' => 1, 'area' => 1, 'id_nacionalidad' => 1, 'licencia' => 0, 'viajar' => 0, 'tiene_trabajo' => 0, 'nivel_idioma'=>1,'lugar_estudio'=>0, 'universidad'=>0, 'universidad2'=>0,'residencia'=>1, 'convencional' => 0);

                if (isset($_POST['dni'])){
                  $campos['dni'] = 1;
                }

                if (empty($_SESSION['mfo_datos']['usuario']['tipo_doc'])){
                    $campos['documentacion'] = 1;
                }
            } else {
                $campos = array('nombres' => 1, 'ciudad' => 1, 'provincia' => 1, 'telefono' => 1, 'id_nacionalidad' => 1, 'nombre_contact'=>1,'apellido_contact'=>1,'tel_one_contact'=>1,'tel_two_contact'=>0,'pagina_web'=>0,'nro_trabajadores'=>1,'sectorind'=>1,'cargo'=>1);
            }

            $data = $this->camposRequeridos($campos);

            if(isset($_POST['subareas']) && !empty($_POST['subareas']) && count($_POST['area']) >= 1 && count($_POST['area']) <= 3){

                $array_subareas_seleccionadas = array();
                $areas_subareas = array();
                foreach ($_POST['subareas'] as $i => $datos_select_area) {
                    
                    $valor = explode("_", $datos_select_area);

                    if(isset($listAreas[$valor[0]]) && isset($listSubareas[$valor[1]])){
                        $areas_subareas[$valor[0]][] = $valor[2];
                        array_push($array_subareas_seleccionadas, $valor[2]);
                    }
                }
                $data['areaxusuario'] = $areas_subareas;
            }else{
                $data['areaxusuario'] = array();
            }

            if (!isset($data['dni'])){
                $data['dni'] = $_SESSION['mfo_datos']['usuario']['dni'];
            }

            if ($imagen['error'] != 4) {
                $validaImg = Utils::valida_upload($imagen, 1);
                if (!$validaImg) {
                    
                }
            }

            if ($tipo_usuario == Modelo_Usuario::CANDIDATO) {
                if (!empty($archivo) && $archivo['error'] != 4) {
                    $validaFile = Utils::valida_upload($archivo, 2);
                    
                    if (!$validaFile) {
                        throw new Exception("El archivo debe tener formato .pdf .doc .docx y con un peso m\u00E1x de 2MB");
                    }
                }

                $validaFecha = Utils::valida_fecha($data['fecha_nacimiento']);
                if (empty($validaFecha)) {
                    throw new Exception("La fecha " . $data['fecha_nacimiento'] . " no es v\u00E1lida");
                }

                $validaTlf = Utils::validarTelefono($data['telefono']);
                if (empty($validaTlf)) {
                    throw new Exception("El celular " . $data['telefono'] . " no es v\u00E1lido");
                }
                if (strlen($data['telefono']) > 15) {
                    throw new Exception("El celular " . $data['telefono'] . " supera el l\u00CDmite permitido");
                }
                if (strlen($data['telefono']) < 10) {
                    throw new Exception("El celular " . $data['telefono'] . " no alcanza el l\u00CDmite m\u00CDn. permitido");
                }

                if(!empty($data['convencional'])){
                    $validaTlf = Utils::validarTelefonoConvencional($data['convencional']);
                    if (empty($validaTlf)) {
                        throw new Exception("El tel\u00E9fono convencional " . $data['telefono'] . " no es v\u00E1lido");
                    }
                    if (strlen($data['telefono']) > 15) {
                        throw new Exception("El tel\u00E9fono convencional " . $data['telefono'] . " supera el l\u00CDmite permitido");
                    }
                    if (strlen($data['telefono']) < 6) {
                        throw new Exception("El tel\u00E9fono convencional " . $data['telefono'] . " no alcanza el l\u00CDmite m\u00CDn. permitido");
                    }
                }

                $validaFechaNac = Modelo_Usuario::validarFechaNac($data['fecha_nacimiento']);
                if (empty($validaFechaNac)) {
                    throw new Exception("Debe ser Mayor de edad");
                }
                if(strlen($data['apellidos']) > 100){
                    throw new Exception("Apellidos: " . $data['apellidos'] . " supera el l\u00CDmite permitido");
                }
                if (!Utils::alfabetico($data['apellidos'],Modelo_Usuario::CANDIDATO)){
                  throw new Exception("Apellidos: " . $data['apellidos'] . " formato no permitido");  
                }
                if (!Utils::alfabetico($data['nombres'],Modelo_Usuario::CANDIDATO)){
                  throw new Exception("Nombres: " . $data['nombres'] . " formato no permitido");  
                } 

                $validaTlf = Utils::validarTelefono($data['telefono']);
                if (!$validaTlf) {
                    throw new Exception("El celular " . $data['telefono'] . " no es v\u00E1lido");
                }
                if (strlen($data['telefono']) > 15) {
                    throw new Exception("El celular " . $data['telefono'] . " supera el l\u00CDmite permitido");
                }
                if (strlen($data['telefono']) < 10) {
                    throw new Exception("El celular " . $data['telefono'] . " no alcanza el l\u00CDmite m\u00CDn. permitido");
                }

            }else{
                $validaTlf2 = Utils::validarTelefono($data['tel_one_contact']);
                if (empty($validaTlf2)){
                    throw new Exception("El celular de contacto " . $data['tel_one_contact'] . " no es v\u00E1lido");
                }
                if (strlen($data['tel_one_contact']) > 15) {
                    throw new Exception("El celular de contacto " . $data['tel_one_contact'] . " supera el l\u00CDmite permitido");
                }
                if (strlen($data['tel_one_contact']) < 10) {
                    throw new Exception("El celular de contacto " . $data['tel_one_contact'] . " no alcanza el l\u00CDmite m\u00CDnimo permitido");
                }
                if(isset($_POST['tel_two_contact']) && !empty($_POST['tel_two_contact'])){
                    $validaTlf3 = Utils::validarTelefonoConvencional($data['tel_two_contact']);
                    if (empty($validaTlf3)) {
                        throw new Exception("El tel\u00E9fono convencional " . $data['tel_two_contact'] . " no es v\u00E1lido");
                    }
                    if (strlen($data['tel_two_contact']) > 15) {
                        throw new Exception("El tel\u00E9fono convencional " . $data['tel_two_contact'] . " supera el l\u00CDmite permitido");
                    }
                    if (strlen($data['tel_two_contact']) < 6) {
                        throw new Exception("El tel\u00E9fono convencional " . $data['tel_two_contact'] . " no alcanza el l\u00CDmite m\u00CDn. permitido");
                    }
                }
                if (!Utils::alfabetico($data['nombres'],Modelo_Usuario::EMPRESA)){
                  throw new Exception("Nombres: " . $data['nombres'] . " formato no permitido");  
                }

                $validaTlf = Utils::validarCelularConvencional($data['telefono']);
                if (!$validaTlf) {
                    throw new Exception("El tel\u00E9fono " . $data['telefono'] . " no es v\u00E1lido");
                }
                if (strlen($data['telefono']) > 15) {
                    throw new Exception("El tel\u00E9fono " . $data['telefono'] . " supera el l\u00CDmite permitido");
                }
                if (strlen($data['telefono']) < 9) {
                    throw new Exception("El tel\u00E9fono " . $data['telefono'] . " no alcanza el l\u00CDmite m\u00CDn. permitido");
                }
            }

            if(strlen($data['nombres']) > 100){
              throw new Exception("Nombres: " . $data['nombres'] . " supera el l\u00CDmite permitido");
            }

            $GLOBALS['db']->beginTrans();
            if($tipo_usuario == Modelo_Usuario::CANDIDATO) { 
                $dependencia    = Modelo_Escolaridad::obtieneDependencia($data['escolaridad']);                
                if($dependencia['dependencia'] == 0 || ($_POST['universidad'] != '' || $_POST['universidad2'] != '')){
                    if(isset($_POST['lugar_estudio']) && $_POST['lugar_estudio'] != -1){
                      if($_POST['lugar_estudio'] == 1 && strlen($data['universidad2']) > 100){
                        throw new Exception("El nombre de la universidad: " . $data['universidad2'] . " supera el l\u00CDmite permitido");
                      }
                    }            
          
                    $datodni = Modelo_Usuario::existeDni($data['dni'],$_SESSION['mfo_datos']['usuario']['id_usuario_login']);
                    if (!empty($datodni)){                        
                      throw new Exception("La c\u00E9dula o pasaporte ".$data["dni"]." ya existe");
                    }

                    if (!empty($data['dni'])){
                        if (!Modelo_UsuarioLogin::editarDniLogin($_SESSION['mfo_datos']['usuario']['id_usuario_login'],$data['dni'])) {
                            throw new Exception("Ha ocurrido un error al guardar la c\u00E9dula , intente nuevamente");
                        }
                    }                    

                    if (!Modelo_Usuario::updateUsuario($data, $idUsuario, $imagen, $_SESSION['mfo_datos']['usuario']['foto'],$tipo_usuario)) {
                        throw new Exception("Ha ocurrido un error al guardar el usuario, intente nuevamente");
                    }
                }else{
                    throw new Exception("Debe ingresar una universidad");
                }
            }else{             

                if(isset($data['pagina_web']) && $data['pagina_web'] != ''){
                    if (!Utils::validaURL($data['pagina_web'])){
                      throw new Exception("La p\u00E1gina web: " . $data['pagina_web'] . " formato no permitido");  
                    }
                }

                if (!Modelo_Usuario::updateUsuario($data, $idUsuario, $imagen, $_SESSION['mfo_datos']['usuario']['foto'],$tipo_usuario)) {
                    throw new Exception("Ha ocurrido un error al guardar el usuario, intente nuevamente");
                }
                if (!Modelo_ContactoEmpresa::editarContactoEmpresa($data, $idUsuario)) {
                    throw new Exception("Ha ocurrido un error al guardar los datos de la persona de contacto, intente nuevamente");
                }
            }
            if (!empty($imagen) && $imagen['error'] != 4) {
              if (!Utils::upload($imagen,$_SESSION['mfo_datos']['usuario']['username'],PATH_PROFILE,1)){
                throw new Exception("Ha ocurrido un error al guardar la imagen del perfil, intente nuevamente");  
              }
              Utils::crearThumbnail(PATH_PROFILE.$_SESSION['mfo_datos']['usuario']['username'].'.jpg',PATH_PROFILE.$_SESSION['mfo_datos']['usuario']['username'].'.jpg',300,0);
              Utils::crearThumbnail(PATH_PROFILE.$_SESSION['mfo_datos']['usuario']['username'].'.jpg',PATH_PROFILE.$_SESSION['mfo_datos']['usuario']['username'].'-thumb.jpg',50,0);    
            } 
            if($tipo_usuario == Modelo_Usuario::CANDIDATO) { 
                if (!empty($archivo) && $archivo['error'] != 4) {
                    $arch = Utils::validaExt($archivo, 2); 

                    if (!empty($_SESSION['mfo_datos']['usuario']['infohv'])) {
                        //if ($arch[1] != $_SESSION['mfo_datos']['usuario']['infohv']['formato']) {
                            if (!Modelo_InfoHv::actualizarHv($_SESSION['mfo_datos']['usuario']['infohv']['id_infohv'], $arch[1])) {
                                   
                            } else {
                                if (!Utils::upload($archivo, $_SESSION['mfo_datos']['usuario']['username'], PATH_ARCHIVO, 2)){
                                  throw new Exception("Ha ocurrido un error al guardar el archivo, intente nuevamente2");
                                }
                            }
                       // }
                    } else {                    
                       
                        if (!Modelo_InfoHv::cargarHv($idUsuario, $arch[1])) {
                            throw new Exception("Ha ocurrido un error al guardar el archivo, intente nuevamente3");
                        } else {
                            if (!Utils::upload($archivo, $_SESSION['mfo_datos']['usuario']['username'], PATH_ARCHIVO, 2)){
                              throw new Exception("Ha ocurrido un error al guardar el archivo, intente nuevamente4");  
                            }
                        }
                    }
                }else if (!isset($_SESSION['mfo_datos']['usuario']['infohv'])) {
                    throw new Exception("Cargar la hoja de vida es obligatorio");
                }
                $validaFechaNac = Modelo_Usuario::validarFechaNac($data['fecha_nacimiento']);
                if (empty($validaFechaNac)) {
                    throw new Exception("Debe ser Mayor de edad");
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
                  throw new Exception("Uno o m\u00E1s de los idiomas seleccionados no esta disponible");
                }else{
                    
                    if (!Modelo_UsuarioxNivelIdioma::guardarUsuarioNivelIdioma($idUsuario,$data_idioma_nivel)) {
                        throw new Exception("Ha ocurrido un error al guardar los idiomas del usuario, intente nuevamente");
                    }
                }   
                $array_data_area = array();
                if(isset($_SESSION['mfo_datos']['usuario']['subareas'])){
                    $array_data_area = explode(",",$_SESSION['mfo_datos']['usuario']['subareas']);
                }

                if(!empty($array_subareas_seleccionadas)){

                    if (!Modelo_UsuarioxArea::updateAreas($array_data_area, $array_subareas_seleccionadas,$areas_subareas, $idUsuario)) {
                        throw new Exception("Ha ocurrido un error al guardar las \u00E1reas de interes, intente nuevamente");
                    }
                }
            }            
            $GLOBALS['db']->commit();
            $sess_usuario = Modelo_Usuario::actualizarSession($idUsuario,$tipo_usuario);            
            Controlador_Login::registroSesion($sess_usuario);            
            $_SESSION['mostrar_exito'] = 'El perfil fue completado exitosamente';
            
        } catch (Exception $e) {
            $_SESSION['mostrar_error'] = $e->getMessage();
            $GLOBALS['db']->rollback();
        }
        return $data;
    }

    //Función que permite el cambio de clave, verifica que no existe ningún error y procede a registrarlas
    public function guardarClave($id_login,$tipo_vista){

        $error = 0;
        try {
            if($_POST["password"] != "" || $_POST["password_two"] != ""){
                if ($_POST["password"] != $_POST["password_two"]){
                  throw new Exception("Contrase\u00F1a y confirmaci\u00F3n de contrase\u00F1a no coinciden");
                }
                $passwordValido = Utils::valida_password($_POST["password"]);
                if ($passwordValido == false){
                  throw new Exception("Ingrese una contrase\u00F1a con el formato especificado");
                }
            }
            if($_POST["password"] != "" && $_POST["password_two"] != ""){
                if (!Modelo_Usuario::modificarPassword($_POST["password"],$id_login)) {
                    throw new Exception("Ha ocurrido un error al guardar las contrase\u00F1as, intente nuevamente");
                }

                if($tipo_vista == 2){
                    if (!Modelo_Usuario::modificarFechaLogin($_SESSION['mfo_datos']['usuario']['id_usuario'],$_SESSION['mfo_datos']['usuario']['tipo_usuario'])){            
                        throw new Exception("Error en el sistema, por favor intente denuevo");
                    }
                }
            }
        } catch (Exception $e) {
            $_SESSION['mostrar_error'] = $e->getMessage();
            $GLOBALS['db']->rollback();
            $error = 1;
        }
        return $error;
    }

    //Función que permite saber si el usuario puede o no descargar un informe de personalidad parcial o completo
    public function obtenerPermiso($idusuario){

        $informe = 0;
        if(isset($_SESSION['mfo_datos']['planes']) && (Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'descargarInformePerso') || Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'descargarInformePersoParcial'))){
            $cantd_facetas = Modelo_PorcentajexFaceta::obtienePermisoDescargar($idusuario);
            if($cantd_facetas > 0){
                $informe = 1;
            }
        }
        return $informe;
    }
}
?>
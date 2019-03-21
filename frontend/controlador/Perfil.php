<?php
class Controlador_Perfil extends Controlador_Base
{
    public function construirPagina()
    {
        if (!Modelo_Usuario::estaLogueado()) {
            Utils::doRedirect(PUERTO . '://' . HOST . '/login/');
        }    
        //Obtiene todos los banner activos segun el tipo
        $arrbanner = Modelo_Banner::obtieneAleatorio(Modelo_Banner::BANNER_PERFIL);        
        $_SESSION['mostrar_banner'] = PUERTO . '://' . HOST . '/imagenes/banner/' . $arrbanner['id_banner'] . '.' . $arrbanner['extension'];
        $msj1 = $imgArch1 = $btnDescarga = '';
        
        $opcion = Utils::getParam('opcion', '', $this->data);
        switch ($opcion) {
            case 'buscarDni':
                $dni = Utils::getParam('dni', '', $this->data); 
                $datodni = Modelo_Usuario::existeDni($dni,$_SESSION['mfo_datos']['usuario']['id_usuario_login']);
                /*if (empty($datodni)){
                  throw new Exception("La c\u00E9dula o pasaporte ".$data["dni"]." ya existe");
                }*/
                Vista::renderJSON(array('resultado' => $datodni));
            break;
            case 'buscaDependencia':
                $id_escolaridad = Utils::getParam('id_escolaridad', '', $this->data); 
                $dependencia    = Modelo_Escolaridad::obtieneDependencia($id_escolaridad);
                Vista::renderJSON($dependencia);
            break;
            case 'buscaCiudad':
                $id_provincia = Utils::getParam('id_provincia', '', $this->data);
                $arrciudad    = Modelo_Ciudad::obtieneCiudadxProvincia($id_provincia);
                Vista::renderJSON($arrciudad);
                break;
            default:
                $arridioma = Modelo_Idioma::obtieneListado();
                $arrnivelidioma = Modelo_NivelIdioma::obtieneListado();
                $escolaridad  = Modelo_Escolaridad::obtieneListado();
                $arrarea      = Modelo_Area::obtieneListado();
                $arrinteres   = Modelo_Interes::obtieneListado();
                $universidades   = Modelo_Universidad::obtieneListado(SUCURSAL_PAISID);
                $puedeDescargarInforme = self::obtenerPermiso($_SESSION['mfo_datos']['usuario']['id_usuario']);
                
                $arrprovincia = Modelo_Provincia::obtieneProvinciasSucursal(SUCURSAL_PAISID);
                $nacionalidades = Modelo_Pais::obtieneListado();
                $area_select  = $nivel_interes  = false;
                $btnSig       = 0;
                $imgArch2  = 'upload-icon.png';
                $msj2      = 'Subir CV';
                $ruta_arch = '#';
                $btnSubir  = 1;
                $btnDescarga = 0;
                $data = array();
                if (Utils::getParam('actualizar') == 1) {
                    $btnSig = 1;
                    if(!isset($_FILES['subirCV'])){
                        $_FILES['subirCV'] = ''; 
                    }
                    $btnSubir  = 0;
                    $data = self::guardarPerfil($_FILES['file-input'], $_FILES['subirCV'], $_SESSION['mfo_datos']['usuario']['id_usuario'],$_SESSION['mfo_datos']['usuario']['tipo_usuario']);

                }
                if (Utils::getParam('cambiarClave') == 1) {
                    self::guardarClave($_SESSION['mfo_datos']['usuario']['id_usuario_login']);
                    $_SESSION['mostrar_exito'] = 'La contrase\u00F1a fue modificada exitosamente.';
                }
                $provincia    = Modelo_Provincia::obtieneProvincia($_SESSION['mfo_datos']['usuario']['id_ciudad']);
                $arrciudad    = Modelo_Ciudad::obtieneCiudadxProvincia($provincia['id_provincia']);
                $nivelIdiomas = Modelo_UsuarioxNivelIdioma::obtenerIdiomasUsuario($_SESSION['mfo_datos']['usuario']['id_usuario']);
                if (isset($_SESSION['mfo_datos']['infohv']) && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) {
                    if($_SESSION['mfo_datos']['infohv']['formato'] == ''){
                        $imgArch1 = 'actualizar.png';
                    }else{
                        $imgArch1    = $_SESSION['mfo_datos']['infohv']['formato'] . '.png';
                    }
                    $msj1        = 'Cv Cargado';
                    $nombre_arch = $_SESSION['mfo_datos']['usuario']['username'] . '.' . $_SESSION['mfo_datos']['infohv']['formato'];
                    $ruta_arch   = PUERTO."://".HOST.'/hojasDeVida/'.$_SESSION['mfo_datos']['usuario']['username'].'/';
                    $btnDescarga = 1;
                    /*if(!isset($data)){
                        $btnSubir  = 0;
                        $btnDescarga = 1;
                    }else{
                        $btnSubir  = 1;
                        $btnDescarga = 0;
                    }*/
                    
                    $msj2        = 'Actualizar CV';
                }

                if(isset($_SESSION['mfo_datos']['usuario']['usuarioxarea'])){
                    $areaxusuario  = $_SESSION['mfo_datos']['usuario']['usuarioxarea'];
                    $nivelxusuario = $_SESSION['mfo_datos']['usuario']['usuarioxnivel'];
                }else{
                    $areaxusuario  = Modelo_UsuarioxArea::obtieneListado($_SESSION['mfo_datos']['usuario']['id_usuario']);
                    $nivelxusuario = Modelo_UsuarioxNivel::obtieneListado($_SESSION['mfo_datos']['usuario']['id_usuario']);
                }
                $nrototaltest = Modelo_Cuestionario::totalTest();
                //$cuestionario = Modelo_Cuestionario::testxUsuario($_SESSION['mfo_datos']['usuario']["id_usuario"]);
                $nrotestusuario = Modelo_Cuestionario::totalTestxUsuario($_SESSION['mfo_datos']['usuario']["id_usuario"]);
                $tags = array('escolaridad' => $escolaridad,
                    'arrarea'                   => $arrarea,
                    'arrinteres'                => $arrinteres,
                    'areaxusuario'              => $areaxusuario,
                    'arrprovincia'              => $arrprovincia,
                    'nivelxusuario'             => $nivelxusuario,
                    'provincia'                 => $provincia['id_provincia'],
                    'arrciudad'                 => $arrciudad,
                    'btnSig'                    => $btnSig,
                    'imgArch1'                  => $imgArch1,
                    'imgArch2'                  => $imgArch2,
                    'msj1'                      => $msj1,
                    'msj2'                      => $msj2,
                    'btnSubir'                  => $btnSubir,
                    'btnDescarga'               => $btnDescarga,
                    'ruta_arch'                 => $ruta_arch,
                    'nrototaltest'              =>$nrototaltest,
                    'nrotestusuario'            =>$nrotestusuario,
                    'nacionalidades'            =>$nacionalidades,
                    'universidades'             =>$universidades,
                    'arridioma'                 =>$arridioma,
                    'arrnivelidioma'            =>$arrnivelidioma,
                    'nivelIdiomas'              => $nivelIdiomas,
                    'puedeDescargarInforme'     =>$puedeDescargarInforme
                );
                $tags["template_css"][] = "bootstrap-multiselect";
                $tags["template_css"][] = "DateTimePicker";
                $tags["template_js"][] = "bootstrap-multiselect";
                $tags["template_js"][] = "mic";
                $tags["template_js"][] = "DniRuc_Validador";
                $tags["template_js"][] = "DateTimePicker";
                $tags["template_js"][] = "editarPerfil";
                $tags["show_banner"] = 1;
                if(!empty($_SESSION['mostrar_error'])){
                    $tags['data'] = $data;
                    $tags['btnSig'] = 0;
                }
                Vista::render('perfil', $tags);                
            break;
        }
    }
    public function guardarPerfil($imagen, $archivo, $idUsuario,$tipo_usuario)
    {
        try {
            if ($tipo_usuario == Modelo_Usuario::CANDIDATO) {
                $campos = array('nombres' => 1, 'apellidos' => 1, 'ciudad' => 1, 'provincia' => 1, 'discapacidad' => 0, 'fecha_nacimiento' => 1, 'telefono' => 1, 'genero' => 1, 'escolaridad' => 1/*, 'area_select' => 1, 'nivel_interes' => 1*/, 'id_nacionalidad' => 1, 'licencia' => 0, 'viajar' => 0, 'tiene_trabajo' => 0, 'nivel_idioma'=>1,'lugar_estudio'=>0, 'universidad'=>0, 'universidad2'=>0,'residencia'=>1);

                if (isset($_POST['dni'])){
                  $campos['dni'] = 1;
                }

                if (empty($_SESSION['mfo_datos']['usuario']['tipo_doc'])){
                    $campos['documentacion'] = 1;
                }
            } else {
                $campos = array('nombres' => 1, 'ciudad' => 1, 'provincia' => 1, 'fecha_nacimiento' => 1, 'telefono' => 1, 'id_nacionalidad' => 1, 'nombre_contact'=>1,'apellido_contact'=>1,'tel_one_contact'=>1,'tel_two_contact'=>0);
            }
            //print_r('aaaa:'.print_r($this->data,true));
            $data = $this->camposRequeridos($campos);
            //print_r('bbbb:'.print_r($data,true)); 
            if (!isset($data['dni'])){
                $data['dni'] = $_SESSION['mfo_datos']['usuario']['dni'];
            }

            if ($imagen['error'] != 4) {
                $validaImg = Utils::valida_upload($imagen, 1);
                if (empty($validaImg)) {
                    throw new Exception("La imagen debe ser en formato .jpg .jpeg .pjpeg y con un peso m\u00E1x de 1MB");
                }
            }
            if ($tipo_usuario == Modelo_Usuario::CANDIDATO) {
                if (!empty($archivo) && $archivo['error'] != 4) {
                    $validaFile = Utils::valida_upload($archivo, 2);
                    if (empty($validaFile)) {
                        throw new Exception("El archivo debe tener formato .pdf .doc .docx y con un peso m\u00E1x de 2MB");
                    }
                }
            }else{
                $validaTlf2 = Utils::valida_telefono($data['tel_one_contact']);
                if (empty($validaTlf2)){
                    throw new Exception("El telefono de contacto 1 " . $data['tel_one_contact'] . " no es v\u00E1lido");
                }
                if (strlen($data['tel_one_contact']) > 25) {
                    throw new Exception("El telefono de contacto 1 " . $data['tel_one_contact'] . " supera el l\u00CDmite permitido");
                }
                if(isset($_POST['tel_two_contact']) && !empty($_POST['tel_two_contact'])){
                    $validaTlf3 = Utils::valida_telefono($data['tel_two_contact']);
                    if (empty($validaTlf3)) {
                        throw new Exception("El telefono de contacto 2 " . $data['tel_two_contact'] . " no es v\u00E1lido");
                    }
                    if (strlen($data['tel_two_contact']) > 25) {
                        throw new Exception("El telefono de contacto 2 " . $data['tel_two_contact'] . " supera el l\u00CDmite permitido");
                    }
                }
            }
            $validaTlf = Utils::valida_telefono($data['telefono']);
            if (empty($validaTlf)) {
                throw new Exception("El telefono " . $data['telefono'] . " no es v\u00E1lido");
            }
            if (strlen($data['telefono']) > 25) {
                throw new Exception("El telefono " . $data['telefono'] . " supera el l\u00CDmite permitido");
            }
            $validaFecha = Utils::valida_fecha($data['fecha_nacimiento']);
            if (empty($validaFecha)) {
                throw new Exception("La fecha " . $data['fecha_nacimiento'] . " no es v\u00E1lida");
            }
            if($tipo_usuario == Modelo_Usuario::CANDIDATO) { 
                $validaFechaNac = Modelo_Usuario::validarFechaNac($data['fecha_nacimiento']);
                if (empty($validaFechaNac)) {
                    throw new Exception("Debe ser Mayor de edad");
                }
                if(strlen($data['apellidos']) > 100){
                    throw new Exception("Apellidos: " . $data['apellidos'] . " supera el l\u00CDmite permitido");
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
                    if (empty($datodni)){
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
            } 
            if($tipo_usuario == Modelo_Usuario::CANDIDATO) { 
                if (!empty($archivo) && $archivo['error'] != 4) {
                    $arch = Utils::validaExt($archivo, 2);
                    if (isset($_SESSION['mfo_datos']['infohv'])) {
                        if ($arch[1] != $_SESSION['mfo_datos']['infohv']['formato']) {
                            if (!Modelo_InfoHv::actualizarHv($_SESSION['mfo_datos']['infohv']['id_infohv'], $arch[1])) {
                                throw new Exception("Ha ocurrido un error al guardar el archivo, intente nuevamente");
                            } else {
                                if (!Utils::upload($archivo, $_SESSION['mfo_datos']['usuario']['username'], PATH_ARCHIVO, 2)){
                                  throw new Exception("Ha ocurrido un error al guardar el archivo, intente nuevamente");
                                }
                            }
                        }
                    } else {
                        if (!Modelo_InfoHv::cargarHv($idUsuario, $arch[1])) {
                            throw new Exception("Ha ocurrido un error al guardar el archivo, intente nuevamente");
                        } else {
                            if (!Utils::upload($archivo, $_SESSION['mfo_datos']['usuario']['username'], PATH_ARCHIVO, 2)){
                              throw new Exception("Ha ocurrido un error al guardar el archivo, intente nuevamente");  
                            }
                        }
                    }
                }else if (!isset($_SESSION['mfo_datos']['infohv'])) {
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
                $array_data_area = $array_data_nivel =array();
                if(isset($_SESSION['mfo_datos']['usuarioxarea'])){
                    $array_data_area = $_SESSION['mfo_datos']['usuarioxarea'];
                }
                if(isset($_SESSION['mfo_datos']['usuarioxnivel'])){
                    $array_data_nivel = $_SESSION['mfo_datos']['usuarioxnivel'];
                }
                /*if (!Modelo_UsuarioxArea::updateAreas($array_data_area, $data['area_select'], $idUsuario)) {
                    throw new Exception("Ha ocurrido un error al guardar las areas de interes, intente nuevamente");
                }
                if (!Modelo_UsuarioxNivel::updateNiveles($array_data_nivel, $data['nivel_interes'], $idUsuario)) {
                    throw new Exception("Ha ocurrido un error al guardar los niveles de interes, intente nuevamente");
                }*/
            }            
            $GLOBALS['db']->commit();
            Controlador_Login::registroSesion(Modelo_Usuario::actualizarSession($idUsuario,$tipo_usuario));
            $_SESSION['mostrar_exito'] = 'El perfil fue completado';
        } catch (Exception $e) {
            $_SESSION['mostrar_error'] = $e->getMessage();
            $GLOBALS['db']->rollback();
        }
        return $data;
    }

    public function guardarClave($id_login){
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
            }
        } catch (Exception $e) {
            $_SESSION['mostrar_error'] = $e->getMessage();
            $GLOBALS['db']->rollback();
            $this->redirectToController('perfil');
        }
    }

    public function obtenerPermiso($idusuario){

        $cantd_facetas = Modelo_PorcentajexFaceta::obtienePermisoDescargar($idusuario);
        $informe = 0;
        if($cantd_facetas > 0){
            $informe = 1;
        }
        return $informe;
    }
}
?>
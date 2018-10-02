<?php
class Controlador_Perfil extends Controlador_Base
{

    public function __construct()
    {
        global $_SUBMIT;
        $this->data = $_SUBMIT;
    }

    public function construirPagina()
    {
        if (!Modelo_Usuario::estaLogueado()) {
            Utils::doRedirect(PUERTO . '://' . HOST . '/login/');
        }    

        //Obtiene todos los banner activos segun el tipo
        $arrbanner = Modelo_Banner::obtieneListado(Modelo_Banner::BANNER_PERFIL);

        //obtiene el orden del banner de forma aleatoria segun la cantidad de banner de tipo perfil
        $orden                      = rand(1, count($arrbanner)) - 1;
        $_SESSION['mostrar_banner'] = PUERTO . '://' . HOST . '/imagenes/banner/' . $arrbanner[$orden]['id_banner'] . '.' . $arrbanner[$orden]['extension'];

        $msj1 = $imgArch1 = $btnDescarga = '';
        

        $opcion = Utils::getParam('opcion', '', $this->data);
        switch ($opcion) {
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
                $universidades   = Modelo_Universidad::obtieneListado($_SESSION['mfo_datos']['sucursal']['id_pais']);
                $provincia    = Modelo_Provincia::obtieneProvincia($_SESSION['mfo_datos']['usuario']['id_ciudad']);
                $arrciudad    = Modelo_Ciudad::obtieneCiudadxProvincia($provincia['id_provincia']);
                $arrprovincia = Modelo_Provincia::obtieneProvinciasSucursal($_SESSION['mfo_datos']['sucursal']['id_pais']);
                $nacionalidades = Modelo_Pais::obtieneListado();
                $area_select  = $nivel_interes  = false;
                $btnSig       = 0;

                $imgArch2  = 'upload-icon.png';
                $msj2      = 'Subir CV';
                $ruta_arch = '#';
                $btnSubir  = 1;

                if (Utils::getParam('actualizar') == 1) {

                    $btnSig = 1;
                    if(!isset($_FILES['subirCV'])){
                        $_FILES['subirCV'] = '';
                        
                    }
                    $btnSubir  = 0;

                    self::guardarPerfil($_FILES['file-input'], $_FILES['subirCV'], $_SESSION['mfo_datos']['usuario']['id_usuario']);
                    $_SESSION['mostrar_exito'] = 'El perfil fue completado exitosamente';
                }

                if (Utils::getParam('cambiarClave') == 1) {

                    self::guardarClave($_SESSION['mfo_datos']['usuario']['id_usuario']);
                    $_SESSION['mostrar_exito'] = 'La contraseña fue modificada exitosamente.';
                }


                $nivelIdiomas = Modelo_UsuarioxNivelIdioma::obtenerIdiomasUsuario($_SESSION['mfo_datos']['usuario']['id_usuario']);

                if (isset($_SESSION['mfo_datos']['infohv'])) {

                    if($_SESSION['mfo_datos']['infohv']['formato'] == ''){
                        $imgArch1 = 'actualizar.png';
                    }else{
                        $imgArch1    = $_SESSION['mfo_datos']['infohv']['formato'] . '.png';
                    }
                    $msj1        = 'Cv Cargado';
                    $nombre_arch = $_SESSION['mfo_datos']['usuario']['username'] . '.' . $_SESSION['mfo_datos']['infohv']['formato'];
                    $ruta_arch   = PUERTO . "://" . HOST . '/hojasDeVida/' . $nombre_arch;
                    $btnDescarga = 1;
                    
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
                    'nacionalidades'            =>$nacionalidades,
                    'universidades'             =>$universidades,
                    'arridioma'                 =>$arridioma,
                    'arrnivelidioma'            =>$arrnivelidioma,
                    'nivelIdiomas'              => $nivelIdiomas

                );

                $tags["template_js"][] = "selectr";
                $tags["template_js"][] = "validator";
                $tags["template_js"][] = "mic";
                $tags["template_js"][] = "editarPerfil";
                $tags["template_js"][] = "publicar_oferta";
                $tags["show_banner"] = 1;


                Vista::render('perfil', $tags);                
            break;
        }
    }

    public function guardarPerfil($imagen, $archivo, $idUsuario)
    {

        try {

            if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) {

                $campos = array('nombres' => 1, 'apellidos' => 1, 'ciudad' => 1, 'provincia' => 1, 'discapacidad' => 0, 'experiencia' => 1, 'fecha_nacimiento' => 1, 'telefono' => 1, 'genero' => 1, 'escolaridad' => 1, 'estatus' => 1, 'area_select' => 1, 'nivel_interes' => 1, 'id_nacionalidad' => 1, 'licencia' => 0, 'viajar' => 0, 'tiene_trabajo' => 0, 'estado_civil' => 0, 'id_nacionalidad' => 1, 'nivel_idioma'=>1,'lugar_estudio'=>0, 'universidad2'=>0);
            } else {

                $campos = array('nombres' => 1, 'ciudad' => 1, 'provincia' => 1, 'fecha_nacimiento' => 1, 'telefono' => 1, 'id_nacionalidad' => 1);
            }

            $data = $this->camposRequeridos($campos);

            if ($imagen['error'] != 4) {
                $validaImg = Utils::valida_upload($imagen, 1);
                if (empty($validaImg)) {
                    throw new Exception("La imagen debe ser en formato .jpg .jpeg .pjpeg y con un peso máx de 1MB");
                }
            }

            if (!empty($archivo) && $archivo['error'] != 4) {

                $validaFile = Utils::valida_upload($archivo, 2);
                if (empty($validaFile)) {
                    throw new Exception("El archivo debe tener formato .pdf .doc .docx y con un peso máx de 2MB");
                }
            }

            $validaTlf = Utils::valida_telefono($data['telefono']);
            if (empty($validaTlf)) {
                throw new Exception("El telefono " . $data['telefono'] . " no es válido");
            }

            $validaFecha = Utils::valida_fecha($data['fecha_nacimiento']);
            if (empty($validaFecha)) {
                throw new Exception("La fecha " . $data['fecha_nacimiento'] . " no es válida");
            }

            if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { 

                $validaFechaNac = Modelo_Usuario::validarFechaNac($data['fecha_nacimiento']);
                if (empty($validaFechaNac)) {
                    throw new Exception("Debe ser Mayor de edad");
                }
            }

            $GLOBALS['db']->beginTrans();
            if (!Modelo_Usuario::updateUsuario($data, $idUsuario, $imagen, $_SESSION['mfo_datos']['usuario']['foto'],$_SESSION['mfo_datos']['usuario']['tipo_usuario'])) {
                throw new Exception("Ha ocurrido un error al guardar el usuario, intente nuevamente");
            }

            if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { 

                if($_POST['lugar_estudio'] != 0 && ($_POST['universidad'] != 0 || $_POST['universidad2'] != 0)){
                    
                    if (!Modelo_RequisitosUsuario::updateRequisitosUsuario($data, $idUsuario)) {
                        throw new Exception("Ha ocurrido un error al guardar los datos del usuario, intente nuevamente");
                    }
                }else{
                    throw new Exception("Debe ingresar una universidad");
                }

                if (!empty($archivo) && $archivo['error'] != 4) {

                    $arch = Utils::validaExt($archivo, 2);
                    if (isset($_SESSION['mfo_datos']['infohv'])) {

                        if ($arch[1] != $_SESSION['mfo_datos']['infohv']['formato']) {

                            if (!Modelo_InfoHv::actualizarHv($_SESSION['mfo_datos']['infohv']['id_infohv'], $arch[1])) {
                                throw new Exception("Ha ocurrido un error al guardar el archivo, intente nuevamente");
                            } else {
                                if (!Utils::upload($archivo, $idUsuario, PATH_ARCHIVO, 2)){
                                  throw new Exception("Ha ocurrido un error al guardar el archivo, intente nuevamente");
                                }
                            }
                        }
                    } else {
                        if (!Modelo_InfoHv::cargarHv($_SESSION['mfo_datos']['usuario']['id_usuario'], $arch[1])) {
                            throw new Exception("Ha ocurrido un error al guardar el archivo, intente nuevamente");
                        } else {
                            if (!Utils::upload($archivo, $idUsuario, PATH_ARCHIVO, 2)){
                              throw new Exception("Ha ocurrido un error al guardar el archivo, intente nuevamente");  
                            }
                        }
                    }
                }else if (!isset($_SESSION['mfo_datos']['infohv'])) {
                    throw new Exception("Cargar la hoja de vida es obligatorio");
                }

                if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) { 

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
                      throw new Exception("Uno o más de los idiomas seleccionados no esta disponible");
                    }else{
                        
                        if (!Modelo_UsuarioxNivelIdioma::guardarUsuarioNivelIdioma($idUsuario,$data_idioma_nivel)) {
                            throw new Exception("Ha ocurrido un error al guardar los idiomas del usuario, intente nuevamente");
                        }
                    }
                }
            }

            if (!empty($imagen) && $imagen['error'] != 4) {
              if (!Utils::upload($imagen,$idUsuario,PATH_PROFILE,1)){
                throw new Exception("Ha ocurrido un error al guardar la imagen del perfil, intente nuevamente");  
              }  
            } 

            if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO){

                if (!Modelo_UsuarioxArea::updateAreas($_SESSION['mfo_datos']['usuarioxarea'], $data['area_select'], $idUsuario)) {
                    throw new Exception("Ha ocurrido un error al guardar las areas de interes, intente nuevamente");
                }

                if (!Modelo_UsuarioxNivel::updateNiveles($_SESSION['mfo_datos']['usuarioxnivel'], $data['nivel_interes'], $idUsuario)) {
                    throw new Exception("Ha ocurrido un error al guardar los niveles de interes, intente nuevamente");
                }

            }

            $GLOBALS['db']->commit();
            Controlador_Login::registroSesion(Modelo_Usuario::actualizarSession($idUsuario));
        } catch (Exception $e) {
            $_SESSION['mostrar_error'] = $e->getMessage();
            $GLOBALS['db']->rollback();
            $this->redirectToController('perfil');
        }
    }

    public function guardarClave($idUsuario){

        try {
            if($_POST["password"] != "" || $_POST["password_two"] != ""){

                if ($_POST["password"] != $_POST["password_two"]){
                  throw new Exception("Contraseña y confirmación de contraseña no coinciden");
                }

                $passwordValido = Utils::valida_password($_POST["password"]);
                if ($passwordValido == false){
                  throw new Exception("Ingrese una contraseña con el formato especificado");
                }
            }

            if($_POST["password"] != "" && $_POST["password_two"] != ""){
                if (!Modelo_Usuario::modificarPassword($_POST["password"],$idUsuario)) {
                    throw new Exception("Ha ocurrido un error al guardar las contraseñas, intente nuevamente");
                }
            }
        } catch (Exception $e) {
            $_SESSION['mostrar_error'] = $e->getMessage();
            $GLOBALS['db']->rollback();
            $this->redirectToController('perfil');
        }
    }
}
?>
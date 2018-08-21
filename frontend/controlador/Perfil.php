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
            case 'paso1':
                $escolaridad  = Modelo_Escolaridad::obtieneListado();
                $arrarea      = Modelo_Area::obtieneListado();
                $arrinteres   = Modelo_Interes::obtieneListado();
                $provincia    = Modelo_Provincia::obtieneProvincia($_SESSION['mfo_datos']['usuario']['id_ciudad']);
                $arrciudad    = Modelo_Ciudad::obtieneCiudadxProvincia($provincia['id_provincia']);
                $arrprovincia = Modelo_Provincia::obtieneListado();
                $area_select  = $nivel_interes  = false;
                $btnSig       = 0;

                if (Utils::getParam('actualizar') == 1) {
                    $btnSig = 1;
                    self::guardarPerfil($_FILES['file-input'], $_FILES['subirCV'], $_SESSION['mfo_datos']['usuario']['id_usuario']);
                }

                $areaxusuario  = Modelo_UsuarioxArea::obtieneListado($_SESSION['mfo_datos']['usuario']['id_usuario']);
                $nivelxusuario = Modelo_UsuarioxNivel::obtieneListado($_SESSION['mfo_datos']['usuario']['id_usuario']);

                if (isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'cargarHv')) {
                    $cargarHv = 1;
                } else {
                    $cargarHv = 0;
                }

                $imgArch2  = 'upload-icon.png';
                $msj2      = 'Subir CV';
                $ruta_arch = '#';
                $btnSubir  = 1;

                if (isset($_SESSION['mfo_datos']['infohv'])) {

                    $imgArch1    = $_SESSION['mfo_datos']['infohv']['formato'] . '.png';
                    $msj1        = 'Hoja de vida Cargada';
                    $nombre_arch = $_SESSION['mfo_datos']['usuario']['id_usuario'] . '.' . $_SESSION['mfo_datos']['infohv']['formato'];
                    $ruta_arch   = PUERTO . "://" . HOST . '/imagenes/usuarios/hv/' . $nombre_arch;
                    $btnDescarga = 1;
                    $msj2        = 'Actualizar CV';
                }

                $tags = array('escolaridad' => $escolaridad,
                    'arrarea'                   => $arrarea,
                    'arrinteres'                => $arrinteres,
                    'areaxusuario'              => $areaxusuario,
                    'arrprovincia'              => $arrprovincia,
                    'nivelxusuario'             => $nivelxusuario,
                    'provincia'                 => $provincia['id_provincia'],
                    'arrciudad'                 => $arrciudad,
                    'btnSig'                    => $btnSig,
                    'cargarHv'                  => $cargarHv,
                    'imgArch1'                  => $imgArch1,
                    'imgArch2'                  => $imgArch2,
                    'msj1'                      => $msj1,
                    'msj2'                      => $msj2,
                    'btnSubir'                  => $btnSubir,
                    'btnDescarga'               => $btnDescarga,
                    'ruta_arch'                 => $ruta_arch,
                );

                $tags["template_js"][] = "selectr";
                $tags["template_js"][] = "validator";
                $tags["template_js"][] = "mic";
                $tags["template_js"][] = "editarPerfil";
                $tags["show_banner"]   = 1;
                Vista::render('perfil_paso1', $tags);
                break;
            case 'buscaCiudad':
                $id_provincia = Utils::getParam('id_provincia', '', $this->data);
                $arrciudad    = Modelo_Ciudad::obtieneCiudadxProvincia($id_provincia);
                Vista::renderJSON($arrciudad);
                break;
            default:
                $tags["show_banner"] = 1;
                Vista::render('perfil', $tags);
                break;
        }
    }

    public function guardarPerfil($imagen, $archivo, $idUsuario)
    {

        try {

            if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == 1) {

                $campos = array('nombres' => 1, 'apellidos' => 1, 'ciudad' => 1, 'provincia' => 1, 'discapacidad' => 0, 'experiencia' => 1, 'fecha_nacimiento' => 1, 'telefono' => 1, 'genero' => 1, 'escolaridad' => 1, 'status_carrera' => 1, 'area_select' => 1, 'nivel_interes' => 1);
            } else {

                $campos = array('nombres' => 1, 'ciudad' => 1, 'provincia' => 1, 'fecha_nacimiento' => 1, 'telefono' => 1);
            }

            $data = $this->camposRequeridos($campos);

            if ($_FILES['file-input']['error'] != 4) {
                $validaImg = Utils::valida_upload($_FILES['file-input'], 1);
                if (empty($validaImg)) {
                    throw new Exception("La imagen debe ser en formato .jpg .jpeg .pjpeg y con un peso máx de 1MB");
                }
            }

            if ($_FILES['subirCV']['error'] != 4) {
                $validaFile = Utils::valida_upload($_FILES['subirCV'], 2);
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

            $GLOBALS['db']->beginTrans();
            if (!Modelo_Usuario::updateUsuario($data, $idUsuario, $imagen, $_SESSION['mfo_datos']['usuario']['foto'])) {
                throw new Exception("Ha ocurrido un error al guardar el usuario, intente nuevamente");
            }
            
            if ($_FILES['subirCV']['error'] != 4) {
                $arch = Utils::validaExt($_FILES['subirCV'], 2);
                if (isset($_SESSION['mfo_datos']['infohv'])) {

                    if ($arch[1] != $_SESSION['mfo_datos']['infohv']['formato']) {

                        if (!Modelo_InfoHv::actualizarHv($_SESSION['mfo_datos']['infohv']['id_infohv'], $arch[1])) {
                            throw new Exception("Ha ocurrido un error al guardar el archivo, intente nuevamente");
                        } else {
                            Utils::upload($archivo, $idUsuario, PATH_ARCHIVO, 2);
                        }
                    }
                } else {
                    if (!Modelo_InfoHv::cargarHv($_SESSION['mfo_datos']['usuario']['id_usuario'], $arch[1])) {
                        throw new Exception("Ha ocurrido un error al guardar el archivo, intente nuevamente");
                    } else {
                        Utils::upload($archivo, $idUsuario, PATH_ARCHIVO, 2);
                    }
                }
            }

            if (!Modelo_UsuarioxArea::updateAreas($_SESSION['mfo_datos']['usuarioxarea'], $data['area_select'], $idUsuario)) {
                throw new Exception("Ha ocurrido un error al guardar las areas de interes, intente nuevamente");
            }

            if (!Modelo_UsuarioxNivel::updateNiveles($_SESSION['mfo_datos']['usuarioxnivel'], $data['nivel_interes'], $idUsuario)) {
                throw new Exception("Ha ocurrido un error al guardar los niveles de interes, intente nuevamente");
            }

            $GLOBALS['db']->commit();
            $_SESSION['mostrar_exito'] = 'El perfil fue completado exitosamente';
            Controlador_Login::registroSesion(Modelo_Usuario::actualizarSession($idUsuario));
        } catch (Exception $e) {
            $_SESSION['mostrar_error'] = $e->getMessage();
            $GLOBALS['db']->rollback();
            $this->redirectToController('editarperfil');
        }
    }
}

<?php
class Controlador_Aspirante extends Controlador_Base
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

        if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::EMPRESA || !isset($_SESSION['mfo_datos']['planes'])){
          Utils::doRedirect(PUERTO . '://' . HOST . '/');  
        }

        //Valida los permisos 
        if(isset($_SESSION['mfo_datos']['planes']) && !Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'verCandidatos')){
           $this->redirectToController('vacantes');
        }

        $mostrar = Utils::getParam('mostrar', '', $this->data);
        $opcion = Utils::getParam('opcion', '', $this->data);
        $page = Utils::getParam('page', '1', $this->data);
        $id_oferta = Utils::getParam('id_oferta', '', $this->data); 
        $type = Utils::getParam('type', '', $this->data); 
        $idUsuario = $_SESSION['mfo_datos']['usuario']['id_usuario'];
        $vista = Utils::getParam('vista', '1', $this->data);

        $username = Utils::getParam('username', '', $this->data);
        $breadcrumbs = array();
        $array_empresas = array();

        if(!isset($_SESSION['mfo_datos']['Filtrar_aspirantes']) || $opcion == '' || $vista == 2 || $vista == 1){
            $_SESSION['mfo_datos']['Filtrar_aspirantes'] = array('A'=>0,'F'=>0,'P'=>0,'U'=>0,'G'=>0,'S'=>0,'N'=>0,'E'=>0,'D'=>0,'L'=>0,'T'=>0,'V'=>0,'O'=>1,'Q'=>0);
        }

        switch ($opcion) {
            case 'filtrar':                
                $arrarea       = Modelo_Area::obtieneListadoAsociativo();
                $arrprovincia  = Modelo_Provincia::obtieneListadoAsociativo(SUCURSAL_PAISID);
                $nacionalidades       = Modelo_Pais::obtieneListadoAsociativo();
                $escolaridad      = Modelo_Escolaridad::obtieneListadoAsociativo();
                $datosOfertas = Modelo_Oferta::ofertaPostuladoPor($id_oferta);

                unset($this->data['mostrar'],$this->data['opcion'],$this->data['page'],$this->data['type'],$this->data['id_oferta'],$this->data['vista']);

                $cadena = '';
                $array_datos = $aspirantesFiltrados = array();
               
                foreach ($this->data as $param => $value) {
                    
                    $letra = substr($value,0,1);
                    $id = substr($value,1);
                    $cadena .= '/'.$value;
                    if($letra == 'F' && $type == 1){
                        
                        if(isset(FECHA_POSTULADO[$id])){
                            $_SESSION['mfo_datos']['Filtrar_aspirantes']['F'] = $id;
                            $array_datos['F'] = array('id'=>$id,'nombre'=>FECHA_POSTULADO[$id]);
                        }
                    }
                    else if($letra == 'A' && $type == 1){
                          
                        if(isset($arrarea[$id])){
                            $_SESSION['mfo_datos']['Filtrar_aspirantes']['A'] = $id;
                            $array_datos['A'] = array('id'=>$id,'nombre'=>$arrarea[$id]);
                        }
                    }
                    else if($letra == 'P' && $type == 1){
                        
                        if(isset(PRIORIDAD[$id])){
                            $_SESSION['mfo_datos']['Filtrar_aspirantes']['P'] = $id;
                            $array_datos['P'] = array('id'=>$id,'nombre'=>PRIORIDAD[$id]);
                        }
                    }
                    else if($letra == 'G' && $type == 1){
                        
                        $g = array_search($id,VALOR_GENERO); 
                        if($g != false){

                            if(isset(GENERO[$g])){
                                $_SESSION['mfo_datos']['Filtrar_aspirantes']['G'] = $id;
                                $array_datos['G'] = array('id'=>$id,'nombre'=>GENERO[$g]);
                            }
                        }
                    }
                    else if($letra == 'U' && $type == 1){
                        
                        if(isset($arrprovincia[$id])){
                            $_SESSION['mfo_datos']['Filtrar_aspirantes']['U'] = $id;
                            $array_datos['U'] = array('id'=>$id,'nombre'=>$arrprovincia[$id]);
                        }

                    }else if($letra == 'S' && $type == 1){
                        
                        if(isset(SALARIO[$id])){
                            $_SESSION['mfo_datos']['Filtrar_aspirantes']['S'] = $id;
                            $array_datos['S'] = array('id'=>$id,'nombre'=>SALARIO[$id]);
                        }

                    }else if($letra == 'N' && $type == 1){
                        
                        if(isset($nacionalidades[$id])){
                            $_SESSION['mfo_datos']['Filtrar_aspirantes']['N'] = $id;
                        $array_datos['N'] = array('id'=>$id,'nombre'=>$nacionalidades[$id]);
                        }

                    }
                    else if($letra == 'E' && $type == 1){
                        
                        if(isset($escolaridad[$id])){
                            $_SESSION['mfo_datos']['Filtrar_aspirantes']['E'] = $id;
                            $array_datos['E'] = array('id'=>$id,'nombre'=>$escolaridad[$id]);
                        }

                    }else if($letra == 'D' && $type == 1){
                        
                        $_SESSION['mfo_datos']['Filtrar_aspirantes']['D'] = $id;
                        $array_datos['D'] = array('id'=>$id,'nombre'=>$id);

                    }else if($letra == 'L' && $type == 1){
                        
                        $_SESSION['mfo_datos']['Filtrar_aspirantes']['L'] = $id;
                        $array_datos['L'] = array('id'=>$id,'nombre'=>$id);

                    }else if($letra == 'T' && $type == 1){
                        
                        $_SESSION['mfo_datos']['Filtrar_aspirantes']['T'] = $id;
                        $array_datos['T'] = array('id'=>$id,'nombre'=>$id);

                    }else if($letra == 'V' && $type == 1){
                        
                        $_SESSION['mfo_datos']['Filtrar_aspirantes']['V'] = $id;
                        $array_datos['V'] = array('id'=>$id,'nombre'=>$id);

                    }else if($letra == 'Q' && $type == 1){
                        
                        $_SESSION['mfo_datos']['Filtrar_aspirantes']['Q'] = $id;
                        $array_datos['Q'] = array('id'=>$id,'nombre'=>htmlentities($id,ENT_QUOTES,'UTF-8'));
                    }
                    else if($letra == 'O' && $type == 1){
                        
                        $_SESSION['mfo_datos']['Filtrar_aspirantes']['O'] = $id; 

                    }else if($type == 2){

                        $_SESSION['mfo_datos']['Filtrar_aspirantes'][$letra] = 0;
                    }
                }

                foreach ($_SESSION['mfo_datos']['Filtrar_aspirantes'] as $letra => $value) {

                    if($value !=0 || $value != ''){

                        if($letra == 'F'){
                            if(isset(FECHA_POSTULADO[$value])){
                                $array_datos[$letra] = array('id'=>$value,'nombre'=>FECHA_POSTULADO[$value]);
                            }
                        }

                        if($letra == 'A'){
                            if(isset($arrarea[$value])){
                                $array_datos[$letra] = array('id'=>$value,'nombre'=>$arrarea[$value]);
                            }
                        }

                        if($letra == 'P'){
                            if(isset(PRIORIDAD[$value])){
                                $array_datos[$letra] = array('id'=>$value,'nombre'=>PRIORIDAD[$value]);
                            }
                        }
                        if($letra == 'G'){
                            $g = array_search($value,VALOR_GENERO); 
                            if($g != false){
                                $array_datos['G'] = array('id'=>$value,'nombre'=>GENERO[$g]);
                            }

                        }
                        if($letra == 'U'){
                            if(isset($arrprovincia[$value])){
                                $array_datos[$letra] = array('id'=>$value,'nombre'=>$arrprovincia[$value]);
                            }
                        }
                        if($letra == 'S'){
                            if(isset(SALARIO[$value])){
                                $array_datos[$letra] = array('id'=>$value,'nombre'=>SALARIO[$value]);
                            }
                        }
                        if($letra == 'D'){
                            $array_datos[$letra] = array('id'=>$value,'nombre'=>$value);
                        }
                        if($letra == 'L'){
                            $array_datos[$letra] = array('id'=>$value,'nombre'=>$value);
                        }
                        if($letra == 'T'){
                            $array_datos[$letra] = array('id'=>$value,'nombre'=>$value);
                        }
                        if($letra == 'V'){
                            $array_datos[$letra] = array('id'=>$value,'nombre'=>$value);
                        }
                        if($letra == 'N'){
                            if(isset($nacionalidades[$value])){
                                $array_datos[$letra] = array('id'=>$value,'nombre'=>$nacionalidades[$value]);
                            }
                        }
                        if($letra == 'E'){
                            if(isset($escolaridad[$value])){
                                $array_datos[$letra] = array('id'=>$value,'nombre'=>$escolaridad[$value]);
                            }
                        }
                        if($letra == 'O'){
                            $array_datos[$letra] = array('id'=>$value,'nombre'=>$value);
                        }
                        if($letra == 'Q'){
                            $array_datos[$letra] = array('id'=>$value,'nombre'=>htmlentities($value,ENT_QUOTES,'UTF-8'));
                        }
                    }
                }

                if($vista == 1){

                    if(isset($_SESSION['mfo_datos']['subempresas'])){
                        $subempresas = $_SESSION['mfo_datos']['subempresas'];  
                        $array_empresas = explode(",",$subempresas);
                    }

                    if(isset($datosOfertas[0]['id_empresa']) && in_array($datosOfertas[0]['id_empresa'], $array_empresas)){
                        $breadcrumbs['cuentas'] = 'Ver Ofertas';
                    }else{
                        $breadcrumbs['vacantes'] = 'Ver Ofertas';
                    }
                    $breadcrumbs['aspirante'] = 'Ver Aspirantes';

                    $aspirantesFiltrados    = Modelo_Usuario::filtrarAspirantes($id_oferta,$_SESSION['mfo_datos']['Filtrar_aspirantes'],$page,false);

                    $cantd_aspirantes = Modelo_Usuario::filtrarAspirantes($id_oferta,$_SESSION['mfo_datos']['Filtrar_aspirantes'],$page,true);

                }else{

                    $breadcrumbs['vacantes'] = 'Ver Ofertas';
                    $breadcrumbs['aspirante'] = 'Ver Aspirantes';

                    $aspirantesFiltrados    = Modelo_Usuario::filtrarAspirantesGlobal(SUCURSAL_PAISID,$_SESSION['mfo_datos']['Filtrar_aspirantes'],$page,false);
                    $cantd_aspirantes = Modelo_Usuario::filtrarAspirantesGlobal(SUCURSAL_PAISID,$_SESSION['mfo_datos']['Filtrar_aspirantes'],$page,true);
                }

                $posibilidades = Modelo_UsuarioxPlan::disponibilidadDescarga($idUsuario);
                $descargas = Modelo_Descarga::cantidadDescarga($idUsuario);

                $nacionalidades = $_SESSION['mfo_datos']['nacionalidades'];
                $arrprovincia = $_SESSION['mfo_datos']['arrprovincia'];

                $link = Vista::display('filtrarAspirantes',array('data'=>$array_datos,'mostrar'=>$mostrar,'id_oferta'=>$id_oferta,'vista'=>$vista)); 

                $tags = array(
                    'arrarea'       => $arrarea,
                    'breadcrumbs'=>$breadcrumbs,
                    'aspirantes'       => $aspirantesFiltrados,
                    'arrprovincia'=>$arrprovincia,
                    'nacionalidades'=>$nacionalidades,
                    'escolaridad'=>$escolaridad,
                    'link'=>$link,
                    'page' =>$page,
                    'mostrar'=>$mostrar,
                    'vista'=>$vista,
                    'array_empresas'=>$array_empresas,
                    'datosOfertas'=>$datosOfertas,
                    'id_oferta'=>$id_oferta,
                    'posibilidades'=>$posibilidades,
                    'descargas'=>$descargas
                );
         
                $url = PUERTO.'://'.HOST.'/verAspirantes/'.$vista.'/'.$id_oferta.'/'.$type.$cadena;

                $pagination = new Pagination(count($cantd_aspirantes),REGISTRO_PAGINA,$url);
                $pagination->setPage($page);
                $tags['paginas'] = $pagination->showPage();
                $tags["template_js"][] = "aspirantes";
                
                Vista::render('aspirantes', $tags);
               
            break;

            case 'detallePerfil':
            if (Modelo_Usuario::EMPRESA) {

                $this->perfilAspirante($username, $id_oferta, $vista);
            }
            break;

            default:
                
                $arrarea       = Modelo_Area::obtieneListadoAsociativo();
                $datosOfertas = Modelo_Oferta::ofertaPostuladoPor($id_oferta); 

                //solo empresa 
                if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::EMPRESA){
                  Utils::doRedirect(PUERTO.'://'.HOST.'/'); 
                }

                $escolaridad      = Modelo_Escolaridad::obtieneListadoAsociativo();
                $idUsuario = $_SESSION['mfo_datos']['usuario']['id_usuario'];

                if(isset($_SESSION['mfo_datos']['subempresas'])){
                    $subempresas = $_SESSION['mfo_datos']['subempresas'];  
                    $array_empresas = explode(",",$subempresas);
                }

                if($vista == 1){

                    if(isset($datosOfertas[0]['id_empresa']) && !in_array($datosOfertas[0]['id_empresa'], $array_empresas)){
                        $breadcrumbs['vacantes'] = 'Ver Ofertas';
                    }else{
                        $breadcrumbs['cuentas'] = 'Ver Ofertas subempresas';
                    }
                    $breadcrumbs['aspirante'] = 'Ver Aspirantes';

                    $aspirantes = Modelo_Usuario::obtenerAspirantes($id_oferta,$page,false);
                    $paises = Modelo_Usuario::obtenerAspirantes($id_oferta,$page,true);
                    $url = PUERTO.'://'.HOST.'/verAspirantes/1/'.$id_oferta;
                }else{
                    $id_oferta = 0;
                    $breadcrumbs['aspirante'] = 'Buscar Aspirantes';
                    $aspirantes = Modelo_Usuario::busquedaGlobalAspirantes(SUCURSAL_PAISID,$page,false);
                    $paises = Modelo_Usuario::busquedaGlobalAspirantes(SUCURSAL_PAISID,$page,true);
                    $url = PUERTO.'://'.HOST.'/verAspirantes/2/0';
                }

                $posibilidades = Modelo_UsuarioxPlan::disponibilidadDescarga($idUsuario);
                $descargas = Modelo_Descarga::cantidadDescarga($idUsuario);
                
                $arranacionalidades = Modelo_Pais::obtieneListadoAsociativo();

                $arrprovincia = $nacionalidades = array();
                foreach ($paises as $key => $value) {
                   if (!empty($arranacionalidades[$value['id_pais']])){
                     $nacionalidades[$value['id_pais']] = $arranacionalidades[$value['id_pais']];
                   }
                   $arrprovincia[$value['id_provincia']] = $value['ubicacion'];
                }                            

                $_SESSION['mfo_datos']['nacionalidades'] = $nacionalidades;
                $_SESSION['mfo_datos']['arrprovincia'] = $arrprovincia;                

                $tags = array(
                    'arrarea'       => $arrarea,
                    'breadcrumbs'=>$breadcrumbs,
                    'arrprovincia'  => $arrprovincia,
                    'nacionalidades'=>$nacionalidades,
                    'escolaridad'=>$escolaridad,
                    'aspirantes'       => $aspirantes,
                    'page' => $page,
                    'mostrar'=>$mostrar,
                    'vista'=>$vista,
                    'id_oferta'=>$id_oferta,
                    'datosOfertas'=>$datosOfertas,
                    'array_empresas'=>$array_empresas,
                    'posibilidades'=>$posibilidades,
                    'descargas'=>$descargas
                );

                $tags["template_js"][] = "aspirantes";
                $pagination = new Pagination(count($paises),REGISTRO_PAGINA,$url);
                $pagination->setPage($page);
                $tags['paginas'] = $pagination->showPage();

                Vista::render('aspirantes', $tags);
            break;
        }
    }


    public static function calcularRuta($ruta,$letraDescartar){

        foreach ($_SESSION['mfo_datos']['Filtrar_aspirantes'] as $key => $v) {

            if($letraDescartar != $key){

                if($key == 'F' && $v != 0){
                    $ruta .= 'F'.$v.'/';
                }
                if($key == 'A' && $v != 0){
                    $ruta .= 'A'.$v.'/';
                }
                if($key == 'P' && $v != 0){
                    $ruta .= 'P'.$v.'/';
                }
                if($key == 'N' && $v != 0){
                    $ruta .= 'N'.$v.'/';
                }
                if($key == 'U' && $v != 0){
                    $ruta .= 'U'.$v.'/';
                }
                if($key == 'S' && $v != 0){
                    $ruta .= 'S'.$v.'/';
                }   
                if($key == 'E' && $v != 0){
                    $ruta .= 'E'.$v.'/';
                } 
                if($key == 'D' && $v != 0){
                    $ruta .= 'D'.$v.'/';
                }  
                if($key == 'T' && $v != 0){
                    $ruta .= 'T'.$v.'/';
                }  
                if($key == 'L' && $v != 0){
                    $ruta .= 'L'.$v.'/';
                }  
                if($key == 'V' && $v != 0){
                    $ruta .= 'V'.$v.'/';
                }   
                if($key == 'G' && $v != 0){
                    $ruta .= 'G'.$v.'/';
                }
                if($key == 'Q' && ($v != 0 || $v != '')){
                    $ruta .= 'Q'.$v.'/';
                }
            }
        }
        return $ruta;
    }

    public function perfilAspirante($username, $id_oferta, $vista){
        $datos = Modelo_Usuario::existeUsuario($username);
        $info_usuario = Modelo_Usuario::infoUsuario($datos['id_usuario']);

        $asp_salarial = Modelo_Usuario::aspSalarial($datos['id_usuario'], $id_oferta);
        $contacto = array();
        $array_rasgosxusuario = array();

        if (isset($_SESSION['mfo_datos']['planes']) && !Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'detallePerfilCandidatos')){
                $contacto = ["correo"=>Utils::ocultarEmail($info_usuario['correo']), "telefono"=>Utils::ocultarCaracteres($info_usuario['telefono'], 0, 0), "dni"=>Utils::ocultarCaracteres($info_usuario['dni'], 0, 0)];
            }
            else{
                $contacto = ["correo"=>$info_usuario['correo'], "telefono"=>$info_usuario['telefono'], "dni"=>$info_usuario['dni']];
            }

        if (isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'descargarInformePerso')){
                $cuestionariosUsuario = Modelo_Cuestionario::listadoCuestionariosxUsuario($info_usuario['id_usuario']);
                
                $resultados = array();
                $rasgoxtest = array();
                foreach ($cuestionariosUsuario as $cuestionarios) {
                  $test = "Test".$cuestionarios['id_cuestionario'];
                  $rasgoxtest = Modelo_InformePDF::obtieneValorxRasgoxTest($info_usuario['id_usuario'], $cuestionarios['id_cuestionario']);
                  foreach ($rasgoxtest as $res) {
                    array_push($array_rasgosxusuario, array("nombre"=>$res['nombre'], "valor"=>$res['valor']));
                  }
                }
            }

            $planes = array();
            if(isset($_SESSION['mfo_datos']['planes'])){
                $planes = $_SESSION['mfo_datos']['planes'];
            }else{
                array_push($planes, array('fecha_caducidad'=>'','num_rest'=>''));
            }

            $enlaceCompraPlan = Vista::display('btnComprarPlan',array('presentarBtnCompra'=>$planes));

            $tags = array("infoUsuario"=>$info_usuario,
                    "Conf"=>$contacto,
                    "Resultados"=>$array_rasgosxusuario,
                    "asp_sararial"=>$asp_salarial,
                    "enlaceCompraPlan"=>$enlaceCompraPlan,
                    "vista"=>$vista
              );

        $tags["template_js"][] = "mic";
        $tags["template_js"][] = "Chart.min";
        Vista::render('perfilAspirante', $tags);
    }

}
?>
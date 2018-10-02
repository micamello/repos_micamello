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
        if (isset($_SESSION['mfo_datos']['planes']) && !Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'verCandidatos')){
           $this->redirectToController('vacantes');
        }

        $mostrar = Utils::getParam('mostrar', '', $this->data);
        $opcion = Utils::getParam('opcion', '', $this->data);
        $page = Utils::getParam('page', '1', $this->data);
        $id_oferta = Utils::getParam('id_oferta', '', $this->data); 
        $type = Utils::getParam('type', '', $this->data); 

        $vista = Utils::getParam('vista', '', $this->data);

        $username = Utils::getParam('username', '', $this->data);

        $breadcrumbs = array();

        switch ($opcion) {
            case 'filtrar':
                                
                $arrprovincia  = Modelo_Provincia::obtieneListadoAsociativo(SUCURSAL_PAISID);
                $nacionalidades       = Modelo_Pais::obtieneListadoAsociativo();
                $escolaridad      = Modelo_Escolaridad::obtieneListadoAsociativo();

                unset($this->data['mostrar'],$this->data['opcion'],$this->data['page'],$this->data['type'],$this->data['id_oferta']);

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

                    }else if($letra == 'Q' && $type == 1){
                        
                        $_SESSION['mfo_datos']['Filtrar_aspirantes']['Q'] = $id;
                        $array_datos['Q'] = array('id'=>$id,'nombre'=>$id);
                    }
                    else if($letra == 'O' && $type == 1){
                        
                        $_SESSION['mfo_datos']['Filtrar_aspirantes']['O'] = $id; 

                    }else if($type == 2){

                        $_SESSION['mfo_datos']['Filtrar_aspirantes'][$letra] = 0;
                    }
                }

                foreach ($_SESSION['mfo_datos']['Filtrar_aspirantes'] as $letra => $value) {

                    if($value!=0 || $value != ''){

                        if($letra == 'F'){
                            if(isset(FECHA_POSTULADO[$value])){
                                $array_datos[$letra] = array('id'=>$value,'nombre'=>FECHA_POSTULADO[$value]);
                            }
                        }

                        if($letra == 'P'){
                            if(isset(PRIORIDAD[$value])){
                                $array_datos[$letra] = array('id'=>$value,'nombre'=>PRIORIDAD[$value]);
                            }
                        }
                        if($letra == 'G'){

                            $g = array_search($id,VALOR_GENERO); 
                            if($g != false){
                                $array_datos['G'] = array('id'=>$id,'nombre'=>GENERO[$g]);
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
                            $array_datos[$letra] = array('id'=>$value,'nombre'=>$value);
                        }
                    }
                }

                $aspirantesFiltrados    = Modelo_Usuario::filtrarAspirantes($id_oferta,$_SESSION['mfo_datos']['Filtrar_aspirantes'],$page,false);

                $link = Vista::display('filtrarAspirantes',array('data'=>$array_datos,'page'=>$page,'mostrar'=>$mostrar,'id_oferta'=>$id_oferta)); 
                 
                $breadcrumbs['vacantes'] = 'Ver vacantes';
                $breadcrumbs['aspirante'] = 'Ver Aspirantes';

                $tags = array(
                    'breadcrumbs'=>$breadcrumbs,
                    'aspirantes'       => $aspirantesFiltrados,
                    'arrprovincia'=>$arrprovincia,
                    'nacionalidades'=>$nacionalidades,
                    'escolaridad'=>$escolaridad,
                    'link'=>$link,
                    'page' =>$page,
                    'mostrar'=>$mostrar,
                    'id_oferta'=>$id_oferta
                );
               
                $url = PUERTO.'://'.HOST.'/verAspirantes/'.$cadena;
                
                $pagination = new Pagination(Modelo_Usuario::filtrarAspirantes($id_oferta,$_SESSION['mfo_datos']['Filtrar_aspirantes'],$page,true),REGISTRO_PAGINA,$url);
                $pagination->setPage($page);
                $tags['paginas'] = $pagination->showPage();
                $tags["template_js"][] = "aspirantes";

                Vista::render('aspirantes', $tags);
            break;

            case 'detallePerfil':
                $this->perfilAspirante($username);
            break;

            default:
                
                $id_oferta = Utils::getParam('id_oferta', '', $this->data);

                //solo empresa 
                if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::EMPRESA){
                  Utils::doRedirect(PUERTO.'://'.HOST.'/'); 
                }

                $_SESSION['mfo_datos']['Filtrar_aspirantes'] = array('F'=>0,'P'=>0,'U'=>0,'G'=>0,'S'=>0,'N'=>0,'E'=>0,'O'=>1,'Q'=>0);
                $arrprovincia  = Modelo_Provincia::obtieneListadoAsociativo(SUCURSAL_PAISID);
                $nacionalidades       = Modelo_Pais::obtieneListadoAsociativo();
                $escolaridad      = Modelo_Escolaridad::obtieneListadoAsociativo();
                $aspirantes = Modelo_Usuario::obtenerAspirantes($id_oferta,$page,false);
                $breadcrumbs['vacantes'] = 'Ver vacantes';
                $breadcrumbs['aspirante'] = 'Ver aspirantes';

                $tags = array(
                    'breadcrumbs'=>$breadcrumbs,
                    'arrprovincia'  => $arrprovincia,
                    'nacionalidades'=>$nacionalidades,
                    'escolaridad'=>$escolaridad,
                    'aspirantes'       => $aspirantes,
                    'page' => $page,
                    'mostrar'=>$mostrar,
                    'id_oferta'=>$id_oferta,
                );

                $tags["template_js"][] = "aspirantes";

                $url = PUERTO.'://'.HOST.'/verAspirantes/'.$id_oferta;
                $pagination = new Pagination(Modelo_Usuario::obtenerAspirantes($id_oferta,$page,true),REGISTRO_PAGINA,$url);
                $pagination->setPage($page);
                $tags['paginas'] = $pagination->showPage();


                Vista::render('aspirantes', $tags);
            break;
        }
    }


    public static function calcularRuta($ruta,$letraDescartar){

        foreach ($_SESSION['mfo_datos']['Filtrar_ofertas'] as $key => $v) {

            if($letraDescartar != $key){

                if($key == 'F' && $v != 0){
                    $ruta .= 'F'.$v.'/';
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
                if($key == 'G' && $v != 0){
                    $ruta .= 'G'.$v.'/';
                }
                if($key == 'Q' && $v != 0){
                    $ruta .= 'Q'.$v.'/';
                }
            }
        }
        return $ruta;
    }

    public function perfilAspirante($username, $requisito = 1){
        $datos_usuario = ["datos_Usuario"=>Modelo_Usuario::existeUsuario($username, $requisito)];

        Utils::log(print_r($datos_usuario, true));
        Vista::render('perfilAspirante', $datos_usuario);
    }

}
?>
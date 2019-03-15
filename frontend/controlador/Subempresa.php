<?php
class Controlador_Subempresa extends Controlador_Base
{

    public function construirPagina()
    {

        if (!Modelo_Usuario::estaLogueado()) {
            Utils::doRedirect(PUERTO . '://' . HOST . '/login/');
        }


        if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::EMPRESA){
          Utils::doRedirect(PUERTO . '://' . HOST . '/');  
        }

        //Valida los permisos 
        if(isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'adminEmpresas') && !Modelo_UsuarioxPlan::planCuentaPropio($_SESSION['mfo_datos']['usuario']['id_usuario'])){
            $this->redirectToController('vacantes');
        }

        $mostrar = Utils::getParam('mostrar', '', $this->data); 
        $opcion = Utils::getParam('opcion', '', $this->data);
        $page = Utils::getParam('page', '1', $this->data);
        $idUsuario = $_SESSION['mfo_datos']['usuario']['id_usuario'];
        $idPlanEmpresa = Utils::getParam('idPlanEmpresa', '', $this->data);
        $idPlanEmpresa = Utils::desencriptar($idPlanEmpresa);
        $breadcrumbs = array();

        switch ($opcion) {
            case 'buscaRecursos':
                $resultado = Modelo_UsuarioxPlan::consultarRecursosAretornar($idPlanEmpresa);
                $result = array('num_publicaciones_rest'=>$resultado['num_publicaciones_rest'],'num_descarga_rest'=>$resultado['num_descarga_rest']);
                Vista::renderJSON($result);
            break;
            case 'eliminar': 
                self::eliminarPlan($idPlanEmpresa);
                Utils::doRedirect(PUERTO . '://' . HOST . '/adminEmpresas/'); 
            break;
            case 'crearPlan': 
                
                //Permite crear un nuevo plan a la empresa seleccionada 
                $idSubEmpresa = Utils::getParam('idSubEmpresa', '', $this->data);
                $idSubEmpresa = Utils::desencriptar($idSubEmpresa);
                $subempresas = Modelo_Usuario::obtieneSubempresasYplanes($idUsuario,$page,$idSubEmpresa);
                $planesActivos = Modelo_UsuarioxPlan::planesConCuentas($idUsuario,$subempresas[0]['ids_parents'],1);

                $breadcrumbs['adminEmpresas'] = "Administrar Cuentas";
                $breadcrumbs['asinarRecursos'] = "Asignar Recursos";  

                if (Utils::getParam('asignarRecursos') == 1) {

                    self::asignarRecursos($idSubEmpresa,'asignar');
                    Utils::doRedirect(PUERTO . '://' . HOST . '/adminEmpresas/');
                }              

                $tags = array(
                    'nombreEmp'=>$subempresas[0]['nombres'],
                    'planesActivos'=>$planesActivos,
                    'idSubEmpresa'=>$idSubEmpresa,
                    'breadcrumbs'=>$breadcrumbs
                );
                $tags["template_js"][] = "mic";
                $tags["template_js"][] = "subempresas";
                Vista::render('asignarRecursos', $tags);
                
            break;
            case 'editarPlan': 
                
                //Permite editar un plan a la empresa seleccionada 
                $breadcrumbs['adminEmpresas'] = "Administrar Cuentas";
                $breadcrumbs['asinarRecursos'] = "Editar Plan";       

                if (Utils::getParam('editarPlan') == 1) {
                    self::asignarRecursos($idPlanEmpresa,'editar');
                    Utils::doRedirect(PUERTO . '://' . HOST . '/adminEmpresas/');
                }

                $planHijo = Modelo_UsuarioxPlan::consultarRecursosAretornar($idPlanEmpresa);

                $planPadre = array();
                if(!empty($planHijo)){
                    $planPadre = Modelo_UsuarioxPlan::consultarRecursosAretornar($planHijo['id_empresa_plan_parent']);
                }         

                $tags = array(
                    'breadcrumbs'=>$breadcrumbs,
                    'planHijo'=>$planHijo,
                    'planPadre'=>$planPadre,
                    'idPlanEmpresa'=>$idPlanEmpresa
                );

                $tags["template_js"][] = "mic";
                $tags["template_js"][] = "subempresas";
                Vista::render('editarPlan', $tags);
                
            break;
            case 'crearEmpresas': 
                
                //Permite crear una nueva cuenta hija 
                //buscar los planes activos y con recursos para asignar
                $breadcrumbs['adminEmpresas'] = "Administrar Cuentas";
                $breadcrumbs['crearEmpresas'] = "Crear Cuenta";

                if (Utils::getParam('form_crear_input') == 1) {
                    self::crearEmpresa($idUsuario);
                    $hijos = Modelo_Usuario::obtieneHerenciaEmpresa($idUsuario);
                    if (!empty($hijos)){
                        $_SESSION['mfo_datos']['subempresas'] = $hijos;
                    }      
                    Utils::doRedirect(PUERTO . '://' . HOST . '/adminEmpresas/');
                }

                /*$empresas = Modelo_Usuario::obtieneSubempresasYplanes($idUsuario,$page,false,false);
                $empresas = implode(",",array_unique($_SESSION['mfo_datos']['subempresas']));*/
                $recursos = Modelo_UsuarioxPlan::tieneRecursos(false,$idUsuario);
                $emp_plan = self::cuentasXplan($_SESSION['mfo_datos']['subempresas']);
                $tieneRecursos = self::obtieneRecursos($recursos,$emp_plan);
                
                $empresa_plan = array();
                foreach ($tieneRecursos as $id => $value) {
                    if($value['num_cuentas'] > 0 && ($value['postulaciones'] > 0 || $value['postulaciones'] == 'Ilimitado')){
                        array_push($empresa_plan, $id);
                    }
                }
                
                $planesActivos = Modelo_UsuarioxPlan::planesConCuentas($idUsuario,implode(",",$empresa_plan));
 

                $tags = array(
                    'planesActivos'=>$planesActivos,
                    'breadcrumbs'=>$breadcrumbs
                );

                $tags["template_js"][] = "mic";
                $tags["template_js"][] = "ruc_jquery_validator";
                $tags["template_js"][] = "subempresas";
                Vista::render('crearEmpresas', $tags);
                
            break;
            default:
                self::vistaPrincipal($idUsuario,$page);
            break;
        } 
    }

    public function vistaPrincipal($idUsuario,$page){

        $subempresas = Modelo_Usuario::obtieneSubempresasYplanes($idUsuario,$page,false,false);
        $cantd_empresas = count(Modelo_Usuario::obtieneSubempresasYplanes($idUsuario,$page,false,true));
        $planesActivos = Modelo_UsuarioxPlan::planesActivosPagados(Modelo_Usuario::EMPRESA,$idUsuario);
        $recursos = Modelo_UsuarioxPlan::tieneRecursos(false,$idUsuario);
        $emp_plan = self::cuentasXplan($_SESSION['mfo_datos']['subempresas']);
        $tieneRecursos = self::obtieneRecursos($recursos,$emp_plan);
        $puedeCrearCuenta = self::puedeCrearCuentas($emp_plan,$recursos);

        $breadcrumbs['adminEmpresas'] = 'Administrar Cuentas';
        $url = PUERTO.'://'.HOST.'/adminEmpresas';
        $pagination = new Pagination($cantd_empresas,REGISTRO_PAGINA,$url);
        $pagination->setPage($page);

        $tags = array(
            'breadcrumbs'=>$breadcrumbs,
            'subempresas' => $subempresas,
            'cantd_empresas'=>$cantd_empresas,
            'puedeCrearCuenta'=>$puedeCrearCuenta,
            'planesActivos'=>$planesActivos,
            'tieneRecursos'=>$tieneRecursos,
            'paginas'=>$pagination->showPage()
        );      
        Vista::render('subempresas', $tags);
    }

    public function obtieneRecursos($tieneRecursos,$emp_plan){

        //$num_post = $num_desc = array();
        $valor_post = $valor_desc = 0;
        //$hay_neg_post = $hay_neg_desc = 0;
        $recursos = array();

        foreach ($tieneRecursos as $key => $value) {

            $valor_post = $valor_desc = 0;
            if($value['numero_postulaciones'] > 0){
                $valor_post = $value['numero_postulaciones'];
            }else if($value['numero_postulaciones'] == -1){
                $valor_post = 'Ilimitado';  
            }

            $cantd_emp = 0;
            if(isset($emp_plan[$value['id_empresa_plan']])){

                $cantd_emp = $value['num_cuenta']-$emp_plan[$value['id_empresa_plan']];
                if($cantd_emp < 0){
                    $cantd_emp = 0;
                }

                $recursos[$value['id_empresa_plan']] = array('nombre'=>$value['nombre'].' (Fecha de compra: '.$value['fecha_compra'].')','postulaciones'=>$valor_post,'num_cuentas'=>$cantd_emp); 
            }else{
                
               $recursos[$value['id_empresa_plan']] = array('nombre'=>$value['nombre'].' (Fecha de compra: '.$value['fecha_compra'].')','postulaciones'=>$valor_post,'num_cuentas'=>$value['num_cuenta']); 
            }
        }
        return $recursos;
    }

    public function eliminarPlan($idPlanEmpresa){

        try{

            $GLOBALS['db']->beginTrans();

            $cancelacion = new Proceso_Cancelacion(null,null,'paypal');
            
            //si la empresa tiene asociadas cuentas hijas
            $planes_hijos = Modelo_UsuarioxPlan::obtienePlanesHijos($idPlanEmpresa);

            if (!empty($planes_hijos) && count($planes_hijos) > 0){
              foreach($planes_hijos as $planhijo){

                //reverso de ofertas y postulaciones de candidatos
                $cancelacion->reversoOfertas(false,$planhijo["id_empresa_plan"]);
                //consulta si el usuario tiene mas planes activos y pagados
                $planpago = Modelo_UsuarioxPlan::planesActivosPagados(Modelo_Usuario::EMPRESA,$planes_hijos['id_empresa']);
                //inactivar el usuario
                if (empty($planpago)){

                    $datosHijos = explode(",",$planpago['id_empresa_plan']);

                    foreach ($datosHijos as $key => $value) {

                        if (!Modelo_UsuarioxPlan::desactivarPlan($value,Modelo_Usuario::EMPRESA)){
                          throw new Exception("Error al eliminar el plan");
                        }

                        $recursosHijo = Modelo_UsuarioxPlan::consultarRecursosAretornar($value);
                        if (!Modelo_UsuarioxPlan::devolverRecursos($recursosHijo)){
                          throw new Exception("Error al devolver datos a la empresa hija");
                        } 
                    }   
                }
              }          
            }

            $cancelacion->reversoOfertas(false,$idPlanEmpresa);

            $recursos1 = Modelo_UsuarioxPlan::consultarRecursosAretornar($idPlanEmpresa);

            if (!Modelo_UsuarioxPlan::devolverRecursos($recursos1)){
              throw new Exception("Error al devolver datos a la empresa padre");
            }

            if (!Modelo_UsuarioxPlan::desactivarPlan($idPlanEmpresa,Modelo_Usuario::EMPRESA)){
              throw new Exception("Error al desactivar el plan");
            }

            $GLOBALS['db']->commit();
            $_SESSION['mostrar_exito'] = 'Se han eliminado las ofertas satisfactoriamente';
        }
        catch(Exception $e){
          $GLOBALS['db']->rollback();
          $_SESSION['mostrar_error'] = 'No se pudo eliminar las ofertas, intente de nuevo';  
        }
    }

    public function crearEmpresa($idUsuario){

        try{

            $campos = array('correo'=>1, 'name_user'=>1,'numero_cand'=>1,'dni'=>1,"nombre_contact"=>1, "apellido_contact"=>1, "tel_one_contact"=>1, "tel_two_contact"=>0/*,"postNum"=>1*/,"num_post"=>1,/*"descNum"=>1,*/ "num_desc"=>1, "plan"=>1);  

            $data = $this->camposRequeridos($campos);

            $campo_fecha = date("Y-m-d H:i:s");  
            $mayor_edad = date("Y-m-d H:i:s",strtotime($campo_fecha."- 18 year")); 
            $default_city = 1;     

            $username = str_replace(" ", "",strtolower($data['name_user']));
            $username = Utils::generarUsername(strtolower($username));
            $password = Utils::generarPassword();

            $usuario_login = array("tipo_usuario"=>Modelo_Usuario::EMPRESA, "username"=>$username, "password"=>$password, "correo"=>$data['correo'], "dni"=>$data['dni']);

            $GLOBALS['db']->beginTrans();

            if(!Modelo_UsuarioLogin::crearUsuarioLogin($usuario_login)){
                throw new Exception("Ha ocurrido un error no se pudo crear el usuario, intente nuevamente");
            }

            $id_usuario_login = $GLOBALS['db']->insert_id();

            $dato_registro = array('telefono'=>$data['numero_cand'], 'nombres'=>$data['name_user'], 'fecha_nacimiento'=>$mayor_edad, 'fecha_creacion'=>$campo_fecha, 'term_cond'=>1, 'conf_datos'=>1, 'id_ciudad'=>$default_city, 'ultima_sesion'=>$campo_fecha, 'id_nacionalidad'=>SUCURSAL_PAISID, 'id_usuario_login'=>$id_usuario_login, 'tipo_usuario'=>Modelo_Usuario::EMPRESA, 'estado'=>1, 'padre'=>$idUsuario);

            if(!Modelo_Usuario::crearUsuario($dato_registro)){
                throw new Exception("Ha ocurrido un error al crear la empresa, intente nuevamente");
            }

            $id_empresa = $GLOBALS['db']->insert_id();

            if(!self::correoAvisoCreacion($data['correo'],$data['name_user'],$username,$password)){
                throw new Exception("Ha ocurrido un error al enviar correo de la nueva cuenta o el correo no existe, intente nuevamente");
            }

            if(!Modelo_ContactoEmpresa::crearContactoEmpresa($data, $id_empresa)){
                throw new Exception("Ha ocurrido un error al crear empresa, intente nuevamente");
            }

            $idPlan = Utils::desencriptar($data['plan']);
            $planPadre = Modelo_UsuarioxPlan::consultarRecursosAretornar($idPlan);

            if(isset($data["num_post"]) && $data["num_post"] == -1){
                $var1 = -1;
                $numPublicaciones = $var1;
            }else{
                $var1 = $data["num_post"];
                $numPublicaciones = $planPadre['num_publicaciones_rest']-$var1;
            }

            if(isset($data["num_desc"]) && $data["num_desc"] == -1){
                $var2 = -1;
                $numDescargas = $var2;
            }else{
                $var2 = $data["num_desc"];
                $numDescargas = $planPadre['num_descarga_rest']-$var2;
            }

            if(!Modelo_UsuarioxPlan::actualizarPublicacionesEmpresa($idPlan,$numPublicaciones,$numDescargas)){
                throw new Exception("Error al actualizar las ofertas de la empresa."); 
            }

            if (!Modelo_UsuarioxPlan::guardarPlan($id_empresa,Modelo_Usuario::EMPRESA,$planPadre['id_plan'],$var1,false,$var2,'',$planPadre['fecha_compra'],$planPadre['fecha_caducidad'],$idPlan)){
              throw new Exception("Error al registrar el plan, por favor intente de nuevo.");   
            }

            $GLOBALS['db']->commit();
            $_SESSION['mostrar_exito'] = "La cuenta fue creada exitosamente.";

        }catch( Exception $e ){
            $GLOBALS['db']->rollback();
            $_SESSION['mostrar_error'] = $e->getMessage();  
        }
    }

    public function asignarRecursos($id,$tipoVista){

        try{

            $idPlan = Utils::desencriptar($_POST['plan1']);
            $planPadre = Modelo_UsuarioxPlan::consultarRecursosAretornar($idPlan);

            if(!isset($_POST["num_post"]) || $_POST["num_post"] == -1){
                $var1 = -1;
                $numPublicaciones = -1;
            }else{
                $var1 = $_POST["num_post"];

                if(isset($_POST["post"])){
                    $post = $_POST["post"];
                }else{
                    $post = 0;
                }
                $numPublicaciones = ($planPadre['num_publicaciones_rest']+$post) - $var1;
            }
            
            if(!isset($_POST["num_desc"]) || $_POST["num_desc"] == -1){
                $var2 = -1;
                $numDescargas = -1;
            }else{
                $var2 = $_POST["num_desc"];

                if(isset($_POST["desc"])){
                    $desc = $_POST["desc"];
                }else{
                    $desc = 0;
                }

                $numDescargas = ($planPadre['num_descarga_rest']+$desc) - $var2;
            }

            if($var1 == -1 && $var2 == -1 && $tipoVista != 'asignar'){

                if(isset($_POST['estado'])){
                    $est = $_POST['estado'];
                }else{
                    $est = 0;
                }

                if (!Modelo_UsuarioxPlan::actualizaEstadoPlan($id,$est)){
                    throw new Exception("Error al cambiar el estado del plan, por favor intente de nuevo.");   
                }
            }else{
                if(!Modelo_UsuarioxPlan::actualizarPublicacionesEmpresa($idPlan,$numPublicaciones,$numDescargas)){
                    throw new Exception("Error al actualizar las ofertas de la empresa."); 
                }

                if($tipoVista == 'asignar'){
                    if (!Modelo_UsuarioxPlan::guardarPlan($id,Modelo_Usuario::EMPRESA,$planPadre['id_plan'],$var1,false,$var2,'',$planPadre['fecha_compra'],$planPadre['fecha_caducidad'],$idPlan)){
                      throw new Exception("Error al registrar el plan, por favor intente de nuevo.");   
                    }
                }else{
                    if (!Modelo_UsuarioxPlan::actualizarPublicacionesEmpresa($id,$var1,$var2)){
                      throw new Exception("Error al actualizar las ofertas de la empresa hija.");   
                    }
                }
            }

            $GLOBALS['db']->commit();
            $_SESSION['mostrar_exito'] = "Los cambios se procesaron exitosamente.";

        }catch( Exception $e ){
            $GLOBALS['db']->rollback();
            $_SESSION['mostrar_error'] = $e->getMessage();  
        }
    }

    public function correoAvisoCreacion($correo,$nombres,$username,$password){

        $asunto = "Creación de cuenta";
        $body = "Estimado, ".$nombres."<br>";
        $body .= "<br>Su cuenta fue creada exitosamente, puede ingresar a su cuenta con los siguientes datos: <br><br>Usuario: <b>".$username."</b><br>Correo: <b>".$correo."</b><br> Clave: <b>".$password."</b>";
        if (Utils::envioCorreo($correo,$asunto,$body)){
          return true;
        }
        else{
          return false;
        }
    }

    public function cuentasXplan($subempresas){

        $emp_plan = array();
        foreach ($subempresas as $key => $value) {

            if(isset($emp_plan[$value])){
                $emp_plan[$value] += 1;
            }else{
                $emp_plan[$value] = 1;
            }
        }

        return $emp_plan;
    }

    public function puedeCrearCuentas($emp_plan,$recursos){
        
        $puedeCrear = 0;
        foreach ($recursos as $key => $value) {

            if(isset($emp_plan[$value['id_empresa_plan']]) && $emp_plan[$value['id_empresa_plan']] <= $value['num_cuenta'] && ($value['numero_postulaciones'] > 0 || $value['numero_postulaciones'] == -1)){
                $puedeCrear = 1;
                break;
            }else if(!isset($emp_plan[$value['id_empresa_plan']]) && ($value['numero_postulaciones'] > 0 || $value['numero_postulaciones'] == -1)){
                //echo 'entro'.$value['id_empresa_plan'];
                $puedeCrear = 1;
                break;
            }
        }
        return $puedeCrear;
    }


}
?>
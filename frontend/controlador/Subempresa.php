<?php
class Controlador_Subempresa extends Controlador_Base
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

        if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA || !isset($_SESSION['mfo_datos']['planes'])){
          Utils::doRedirect(PUERTO . '://' . HOST . '/');  
        }

        //Valida los permisos 
        if(isset($_SESSION['mfo_datos']['planes']) && !Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'adminEmpresas')){
           $this->redirectToController('vacantes');
        }

        $mostrar = Utils::getParam('mostrar', '', $this->data); 
        $opcion = Utils::getParam('opcion', '', $this->data);
        $page = Utils::getParam('page', '1', $this->data);
        $idUsuario = $_SESSION['mfo_datos']['usuario']['id_usuario'];
        $idPlanEmpresa = Utils::getParam('idPlanEmpresa', '', $this->data);
        $breadcrumbs = array();

        switch ($opcion) {
            case 'buscaRecursos':
                $resultado = Modelo_UsuarioxPlan::consultarRecursosAretornar($idPlanEmpresa);
                Vista::renderJSON($resultado);
            break;
            case 'eliminar': 
                self::eliminarPlan($idPlanEmpresa);
                self::vistaPrincipal($idUsuario,$page);
            break;
            case 'crearPlan': 
                
                //Permite crear un nuevo plan a la empresa seleccionada 
                $idSubEmpresa = Utils::getParam('idSubEmpresa', '', $this->data);
                $subempresas = Modelo_Usuario::obtieneSubempresasYplanes($idUsuario,$page,$idSubEmpresa);
                $planesActivos = Modelo_UsuarioxPlan::planesConCuentas($idUsuario,$subempresas[0]['ids_Planes']);

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
                $tags["template_js"][] = "subempresas";
                Vista::render('asignarRecursos', $tags);
                
            break;
            case 'editarPlan': 
                
                //Permite editar un plan a la empresa seleccionada 
                $breadcrumbs['adminEmpresas'] = "Administrar Cuentas";
                $breadcrumbs['asinarRecursos'] = "Editar Plan";       

                $idSubEmpresa = Utils::getParam('idSubEmpresa', '', $this->data);
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
                    Utils::doRedirect(PUERTO . '://' . HOST . '/adminEmpresas/');
                }

                $planesActivos = Modelo_UsuarioxPlan::planesConCuentas($idUsuario,false);
 
                $tags = array(
                    'planesActivos'=>$planesActivos,
                    'breadcrumbs'=>$breadcrumbs
                );

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
        $puedeCrearCuenta = Modelo_UsuarioxPlan::puedeCrearCuentas($idUsuario,$cantd_empresas);
        $planesActivos = Modelo_UsuarioxPlan::planesActivosPagados(Modelo_Usuario::EMPRESA,$idUsuario);
        $recursos = Modelo_UsuarioxPlan::tieneRecursos(false,$idUsuario);
        $tieneRecursos = self::obtieneRecursos($recursos);
 
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

    public function obtieneRecursos($tieneRecursos){

        $num_post = $num_desc = array();
        $valor_post = $valor_desc = 0;
        $hay_neg_post = $hay_neg_desc = 0;
        $valor_cuenta = 0;

        foreach ($tieneRecursos as $key => $value) {

            if($value['numero_postulaciones'] > 0){
                $valor_post += $value['numero_postulaciones'];
            }else if($value['numero_postulaciones'] == -1){
                $hay_neg_post++;  
            }

            if($value['numero_descarga'] > 0){
                $valor_desc += $value['numero_descarga'];
            }else if($value['numero_descarga'] == -1){
                $hay_neg_desc++; 
            }

            if($value['num_cuenta'] > 0){
                $valor_cuenta += $value['num_cuenta'];
            }
        }

        if($valor_post > 0){
            array_push($num_post, $valor_post);
        }

        if($hay_neg_post > 0){
            array_push($num_post, 'Ilimitado');
        }

        if($valor_desc > 0){
            array_push($num_desc, $valor_desc);
        }

        if($hay_neg_desc > 0){
            array_push($num_desc, 'Ilimitado');
        }

        $recursos['publicaciones'] = implode("/",$num_post);
        $recursos['descargas'] = implode("/",$num_desc);
        $recursos['cuentas'] = $valor_cuenta;

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

            if (!Modelo_UsuarioxPlan::desactivarPlan($idPlanEmpresa,Modelo_Usuario::EMPRESA)){
              throw new Exception("Error al desactivar el plan");
            }

            $recursos = Modelo_UsuarioxPlan::consultarRecursosAretornar($idPlanEmpresa);
            if (!Modelo_UsuarioxPlan::devolverRecursos($recursos)){
              throw new Exception("Error al devolver datos a la empresa padre");
            }   

            $GLOBALS['db']->commit();
            $_SESSION['mostrar_exito'] = 'Se ha eliminado el plan de la empresa satisfactoriamente';
        }
        catch(Exception $e){
          $GLOBALS['db']->rollback();
          $_SESSION['mostrar_error'] = 'No se pudo eliminar el plan de la empresa intente de nuevo';  
        }
    }

    public function crearEmpresa($idUsuario){

        try{

            $campos = array('correo'=>1, 'name_user'=>1,'numero_cand'=>1,'ruc'=>1,"nombre_contact"=>1, "apellido_contact"=>1, "tel_one_contact"=>1, "tel_two_contact"=>0,"postNum"=>1,"num_post"=>1,"descNum"=>1, "num_desc"=>1, "plan"=>1);  

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

            $dato_contacto = array('nombre_contact'=>$data['nombre_contact'], 'apellido_contact'=>$data['apellido_contact'], 'tel_one_contact'=>$data['tel_one_contact'], 'tel_two_contact'=>$data['tel_two_contact']);

            if(!Modelo_ContactoEmpresa::crearContactoEmpresa($dato_contacto, $id_empresa)){
                throw new Exception("Ha ocurrido un error al crear empresa, intente nuevamente");
            }

            $planPadre = Modelo_UsuarioxPlan::consultarRecursosAretornar($data['plan']);

            if(isset($data["postNum"]) && $data["postNum"] == -1){
                $var1 = -1;
            }else{
                $var1 = $data["num_post"];
                $numPublicaciones = $planPadre['num_publicaciones_rest']-$var1;
            }

            if(isset($data["descNum"]) && $data["descNum"] == -1){
                $var2 = -1;
            }else{
                $var2 = $data["num_desc"];
                $numDescargas = $planPadre['num_descarga_rest']-$var2;
            }

            if($var1 != -1 && $var2 != -1){

                if(!Modelo_UsuarioxPlan::actualizarPublicacionesEmpresa($data['plan'],$numPublicaciones,$numDescargas)){
                    throw new Exception("Error al actualizar los recursos de la empresa."); 
                }
            }

            if (!Modelo_UsuarioxPlan::guardarPlan($id_empresa,Modelo_Usuario::EMPRESA,$planPadre['id_plan'],$var1,false,$var2,'',$planPadre['fecha_compra'],$planPadre['fecha_caducidad'],$data['plan'])){
              throw new Exception("Error al registrar el plan, por favor intente de nuevo.");   
            }

            if (!Modelo_UsuarioxPlan::devolverRecursos($planPadre)){
              throw new Exception("Error al devolver datos a la empresa hija");
            }

            $GLOBALS['db']->commit();
            $_SESSION['mostrar_exito'] = "La cuenta fue creada exitosamente.";

        }catch( Exception $e ){
            $GLOBALS['db']->rollback();
            $_SESSION['mostrar_error'] = $e->getMessage();  
        }
    }

    public function asignarRecursos($id_empresa,$tipoVista){

        try{

            $campos = array("num_post"=>1,"num_desc"=>1, "plan"=>1); 

            $data = $this->camposRequeridos($campos);

            $planPadre = Modelo_UsuarioxPlan::consultarRecursosAretornar($data['plan']);
            if($data["num_post"] == -1){
                $var1 = -1;
            }else{
                $var1 = $data["num_post"];
                $numPublicaciones = $planPadre['num_publicaciones_rest'] - $var1;
            }

            if($data["num_desc"] == -1){
                $var2 = -1;
            }else{
                $var2 = $data["num_desc"];
                $numDescargas = $planPadre['num_descarga_rest'] - $var2;
            }

            if($var1 != -1 && $var2 != -1){

                if(!Modelo_UsuarioxPlan::actualizarPublicacionesEmpresa($data['plan'],$numPublicaciones,$numDescargas)){
                    throw new Exception("Error al actualizar los recursos de la empresa."); 
                }
            }

            if($tipoVista == 'asignar'){
                if (!Modelo_UsuarioxPlan::guardarPlan($id_empresa,Modelo_Usuario::EMPRESA,$planPadre['id_plan'],$var1,false,$var2,'',$planPadre['fecha_compra'],$planPadre['fecha_caducidad'],$data['plan'])){
                  throw new Exception("Error al registrar el plan, por favor intente de nuevo.");   
                }
            }else{
                if (!Modelo_UsuarioxPlan::actualizarPublicacionesEmpresa($id_empresa,$var1,$var2))
                {
                  throw new Exception("Error al actualizar los recursos de la empresa hija.");   
                }
            }

            $GLOBALS['db']->commit();
            $_SESSION['mostrar_exito'] = "Los cambios se procesaron exitosamente.";

        }catch( Exception $e ){
            $GLOBALS['db']->rollback();
            $_SESSION['mostrar_error'] = $e->getMessage();  
        }
    }
}
?>
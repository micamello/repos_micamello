<div class="container">
  <div class="row">
    <div class="text-center">
      <h2 class="titulo">Administraci&oacute;n de la cuenta</h2>
    </div><br>
    <div class="main_business">
      <section>
        <div class="">
          <div class="col-md-12">
            <p class="text-center" style="color: #204478;font-size: 20px;margin-bottom: 20px;">Listado de Cuentas</p>
          </div>

        <?php 
            $cuentas = $ofertas = '';
            $cantd_cuentas = 0;
            $recursos = 0;
            $planes_con_postulaciones = array();

            foreach ($tieneRecursos as $key => $value) {
                
                $cantd_cuentas += $value['num_cuentas'];
                $cuentas .= $value['nombre'].': '.$value['num_cuentas'].'<br>';
                $ofertas .= $value['nombre'].': '.$value['postulaciones'].'<br>';
                $accesos .= $value['nombre'].': '.$value['accesos'].'<br>';

                if($value['postulaciones'] > 0 || $value['postulaciones'] === 'Ilimitado'){
                    array_push($planes_con_postulaciones, $key);
                }
            }

            if(!empty($tieneRecursos)){
        ?>

          <div class="col-md-4 col-sm-12">
            <div class="caja-cuenta">
                <p style="margin-bottom: 0px;"><b>Cuentas restantes</b></p>
                <span><?php echo $cuentas; ?></span>
            </div>
          </div>
          <br>
          <div class="col-md-4 col-sm-12">
            <div class="caja-cuenta">
                <p style="margin-bottom: 0px;"><b>Ofertas restantes</b></p>
                <span><?php echo $ofertas; ?></span>
            </div>
          </div>
          <br>
          <div class="col-md-4 col-sm-12">
            <div class="caja-cuenta">
                <p style="margin-bottom: 0px;"><b>Accesos restantes</b></p>
                <span><?php echo $accesos; ?></span>
            </div>
          </div>
        <?php } ?>
          <div class="clearfix"></div>
            <div class="col-md-12">
                <div class="panel panel-default" style="border-color: #404040;border-radius: 0px">
                    <div class="panel-body">
                      <div class="form-group col-md-12" align="right">
                        <?php  if($cantd_cuentas > 0 && $puedeCrearCuenta == 1){ ?>
                            <div style="margin: 10px 0px;" class="col-md-12 icon_oferta">
                                <a class="btn-blue" href="<?php echo PUERTO."://".HOST;?>/crearEmpresas/">
                                    <span id="boton" name="">
                                        <i class="fa fa-industry hidden-sm hidden-xs" title="Crear nueva empresa"></i> 
                                        CREAR SUBCUENTA
                                    </span>
                                </a>
                            </div> 
                        <?php } ?>
                      </div>
                      <div style="overflow-x:auto; width: 100%">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr class="breadcrumb">
                                    <th class="text-center">Nombre empresa</th> 
                                    <th class="text-center">Plan(es) asociado(s)</th>
                                    <th class="text-center">N° de ofertas restantes</th>
                                    <th class="text-center">N° de accesos restantes</th>
                                    <th class="text-center">Estado</th>
                                    <th colspan="3" class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php  if(!empty($subempresas)){ ?>
                                <?php foreach ($subempresas as $key => $value) { ?>
                                    <style>
                                        #centrar{
                                            text-align: center;
                                        }
                                    </style>
                                    <?php 
                                        $planes = explode(",",$value['planes']);
                                        $fechas_compra = explode(",",$value['fecha_compra']);
                                        $num_post = explode(",",$value['num_publicaciones_rest']);
                                        $num_accesos = explode(",",$value['num_accesos_rest']);
                                        $estados = explode(",",$value['estado']);
                                        $ids_empresasPlans = explode(",",$value['ids_empresasPlans']); 
                                        $ids_parents = explode(",",$value['ids_parents']); 
                                        $fechas_caducidades = explode(",",$value['fechas_caducidades']);

                                        if(!empty($planesActivos)){
                                            
                                            //solo se puede agregar un nuevo plan siempre y cuando el o los planes disponibles sean distintos de los planes ya creados y tengan recursos
                                            $interseccion_planes = array_diff(explode(",",$planesActivos['id_empresa_plan']), $ids_parents);
       
                                            $inter_planes = array_intersect($interseccion_planes, $planes_con_postulaciones);

                                            if(!empty($inter_planes)){
                                                $puedeCrearPlan = '1';
                                            }else{
                                                $puedeCrearPlan = '';
                                            }
                                        }else{
                                            $puedeCrearPlan = '';
                                        }
                                    ?>
                                    <tr align="center">
                                        <td style="vertical-align:middle; text-align: center;" rowspan="<?php echo ((isset($planes)) ? count($planes) : '1'); ?>" style="text-align: center;" data-title="Nombres:"><a href="<?php echo PUERTO.'://'.HOST.'/detalleEmpresa/'.Utils::encriptar($value['id_empresa']).'/'; ?>"><?php echo utf8_encode($value['nombres']); ?></a></td>
                                        
                                        <?php 

                                            if(isset($planes) && is_array($planes)){

                                                $mostrar = 0;

                                                foreach ($planes as $key => $dato) {  ?>

                                                <td style="text-align: center;vertical-align:middle;"><?php echo $dato.'<br><span style="font-size:10px;">Fecha de compra: '.$fechas_compra[$key].'</span>'; ?></td>
                                                <td style="text-align: center;vertical-align:middle;"><?php if($num_post[$key] == ''){ echo '0'; }else{ echo $num_post[$key]; } ?></td>
                                                <td style="text-align: center;vertical-align:middle;"><?php if($num_accesos[$key] == ''){ echo '0'; }else{ echo $num_accesos[$key]; } ?></td>
                                                <td style="text-align: center;vertical-align:middle;"><?php echo $estados[$key]; ?></td>

                                                <?php 

                                                #if($puedeCrearCuenta == 1){

                                                    //verificar al editar que mi plan padre tiene recursos para asignarme (solo puedo editar si mi padre tiene recursos del mismo plan que lo creo) y esta activo
                                                //print_r($tieneRecursos[7]['postulaciones']);
                                                //echo '<br>'.$ids_parents[$key]; exit;
                                                $puedeEditarCuenta = 0;
                                                /*print_r('<br>key: '.$key);
                                               print_r('<br>num_post: '.$num_post[$key]); 
                                                print_r('<br>tieneRecursos: '.$tieneRecursos[$ids_parents[$key]]['postulaciones']); */
                   
                                                if(isset($tieneRecursos[$ids_parents[$key]]) /*&& (    ($num_post[$key] == 0 && $tieneRecursos[$ids_parents[$key]]['postulaciones'] > 0) || ($num_post[$key] > 0 && $tieneRecursos[$ids_parents[$key]]['postulaciones'] == 0) || ($tieneRecursos[$ids_parents[$key]]['postulaciones'] === 'Ilimitado') || ($num_post[$key] > 0 && $tieneRecursos[$ids_parents[$key]]['postulaciones'] > 0)
                                                )*/){
                                                    //echo '<br>entro: '.$tieneRecursos[$ids_parents[$key]]['postulaciones'];
                                                    $puedeEditarCuenta = 1;
                                                }


                                                    /*$puedeEditarCuenta = Modelo_UsuarioxPlan::tieneRecursos($ids_parents[$key],false);

                                                    if(!empty($puedeEditarCuenta[0]['numero_postulaciones'])){
                                                        $numero_postulaciones = $puedeEditarCuenta[0]['numero_postulaciones'];
                                                    }else{
                                                       $numero_postulaciones = '0'; 
                                                    }

                                                    if(!empty($puedeEditarCuenta[0]['numero_descarga']) && $puedeEditarCuenta[0]['numero_descarga'] == -1){
                                                        $numero_descargas = $puedeEditarCuenta[0]['numero_descarga'];
                                                    }else{
                                                       $numero_descargas = '0'; 
                                                    }encriptar($texto)
                                                    desencriptar($texto)
                                                     echo '<br>puedeEditar: '.$puedeEditarCuenta.'<br>';*/
                                                    if(($fechas_caducidades[$key] >= date('Y-m-d H:i:s') || $estados[$key] != 'Inactivo') && $puedeEditarCuenta == 1 && !empty($tieneRecursos)){ ?>
                                                        <td class="icon_oferta" style="vertical-align:middle; text-align: center;"><a href="<?php echo PUERTO.'://'.HOST.'/editarPlanEmpresa/'.Utils::encriptar($ids_empresasPlans[$key]).'/'; ?>">
                                                            <i class="fa fa-pencil-square-o" title="Editar ofertas"></i>
                                                        </a></td>
                                                    <?php }else{ ?>
                                                            <td class="icon_oferta" style="vertical-align:middle;  text-align: center;">
                                                                <i class="fa fa-edit icon_deshabilitados" title="Editar ofertas"></i>
                                                            </td>
                                                    <?php } 

                                                    if($estados[$key] != 'Inactivo' && !empty($tieneRecursos)){ ?>
                                                        <td class="icon_oferta" style="vertical-align:middle; text-align:center;"><a onclick="abrirModal('Está seguro que desea eliminar las ofertas?','alert_descarga','<?php echo PUERTO.'://'.HOST.'/eliminarPlanEmpresa/'.Utils::encriptar($ids_empresasPlans[$key]).'/'; ?>','btn_modal');">
                                                            <i class="fa fa-trash " title="Liberar ofertas"></i>
                                                        </a></td>
                                                <?php }else{ ?>
                                                        <td class="icon_oferta" style="vertical-align:middle;  text-align: center;">
                                                            <i class="fa fa-trash  icon_deshabilitados" title="Liberar ofertas"></i></td>
                                                <?php }

                                                     if($mostrar == 0){
                
                                                        if(!empty($puedeCrearPlan) && !empty($tieneRecursos)){ ?>
                                                            <td class="icon_oferta" style="vertical-align:middle; text-align: center;" align="center" rowspan="<?php echo ((isset($planes)) ? count($planes) : '1'); ?>" style="text-align: center;"><a href="<?php echo PUERTO.'://'.HOST.'/asignarPlanEmpresa/'.Utils::encriptar($value['id_empresa']).'/'; ?>">
                                                                <i class="fa fa-plus " title="Asignar ofertas"></i>
                                                            </a></td>
                                                    <?php } else{ ?>
                                                                <td class="icon_oferta" style="vertical-align:middle; text-align: center;" align="center" rowspan="<?php echo ((isset($planes)) ? count($planes) : '1'); ?>" style="text-align: center;"><i class="fa fa-plus  icon_deshabilitados" title="Asignar ofertas"></i></td>
                                                     <?php }
                                                    }
                                           # }
                                            $mostrar++; ?>
                                    </tr>
                                    <?php  } ?>
                                            
                                    <?php }else{  ?>
                                        <td style="text-align: center;"><?php echo $value['planes']; ?></td>
                                        <td style="text-align: center;"><?php echo $value['num_publicaciones_rest']; ?></td>
                                        <td style="text-align: center;" ><?php echo $value['num_accesos_rest']; ?></td>
                                        <td style="text-align: center;"><?php echo $value['estado']; ?></td></tr>
                                    <?php } ?>
                                    
                                <?php } ?>
                            <?php }else{ ?>
                                <tr><td colspan="8">No tiene ning&uacute;n empresa creada</td></tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <?php echo $paginas; ?>
                    </div>
                    </div>

                    <!-- 
                    <div class="modal fade" id="msg_confirmplan" tabindex="-1" role="dialog" aria-labelledby="msg_confirmplan" aria-hidden="true" style="overflow-y: auto;">
                      <div class="modal-dialog " role="document">
                        <form method="post" action="http://localhost/repos_micamello/compraplan/" id="form_plan" name="form_plan">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLongTitle">Suscripción de plan</h5>        
                              <input type="hidden" name="idplan" id="idplan" value="">
                            </div>
                            <div class="modal-body"><p></p></div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                              <button type="submit" class="btn btn-primary">Comprar</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>-->
                </div>
            </div>
        </div>
      </section>
    </div>
  </div>
</div>


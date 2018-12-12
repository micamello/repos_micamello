<div class="container"><br>
    <div class="row">
        <div class="main_business">
            <section>
                <div class="container">
                    <div class="col-md-12">
                        <div>
                            <p class="text-center" style="font-size: 20px;margin-bottom: 20px;">Listado de Cuentas</p>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-body">

                                <div class="form-group col-md-12" align="right">
                                    <div class="col-md-<?php if(!empty($puedeCrearCuenta) && $cantd_empresas <= $tieneRecursos['cuentas'] && !empty($tieneRecursos['publicaciones'])){ echo '10'; }else{ echo '12'; } ?>" align="right">
                                        <span>
                                            <strong>N° de Cuentas restantes: </strong>
                                            <span style="color:red" class="parpadea"><?php echo $tieneRecursos['cuentas']-$cantd_empresas; ?></span>
                                        </span>
                                        <br>

                                        <?php if(!empty($tieneRecursos['publicaciones'])){ ?>
                                            <span>
                                                <strong>N° de Publicaciones Restantes: </strong>
                                                <span style="color:red" class="parpadea"><?php if($tieneRecursos['publicaciones'] == ''){ echo 'No tiene publicaciones'; }else{ echo $tieneRecursos['publicaciones']; } ?></span>
                                            </span>
                                            <br>
                                            <span>
                                                <strong>N° de Descargas Restantes: </strong>
                                                <span style="color:red" class="parpadea"><?php if($tieneRecursos['descargas'] == ''){ echo 'No tiene descargas'; }else{ echo $tieneRecursos['descargas']; } ?></span>
                                            </span>
                                        <?php }else{ ?>
                                            <span>
                                                <strong>N° de Publicaciones Restantes: </strong>
                                                <span style="color:red" class="parpadea">0</span>
                                            </span>
                                        <?php } ?>
                                    </div>
                                   <?php if(!empty($puedeCrearCuenta) && $cantd_empresas <= $tieneRecursos['cuentas'] && !empty($tieneRecursos['publicaciones'])){ ?>
                                        <div class="col-md-2 icon_oferta" align="right">
                                            <a href="<?php echo PUERTO."://".HOST;?>/crearEmpresas/"><span id="boton" name="" class="btn btn-md btn-success">
                                            <i class="fa fa-industry " title="Crear nueva empresa"></i> CREAR EMPRESA</span></a>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div style="overflow-x:auto; width: 100%">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr class="breadcrumb">
                                                <th class="text-center">Nombre empresa</th> 
                                                <th class="text-center">Plan(es) asociado(s)</th>
                                                <th class="text-center">N° de publicaciones restantes</th>
                                                <th class="text-center">N° de descargas restantes</th>
                                                <th class="text-center">Estado</th>
                                                <?php
                                                
                                                 if(!empty($puedeCrearCuenta) && !empty($tieneRecursos['publicaciones'])){ ?>
                                                    <th colspan="3" class="text-center">Acciones</th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(!empty($subempresas)){ ?>
                                            <?php foreach ($subempresas as $key => $value) { ?>
                                                <style>
                                                    #centrar{
                                                        text-align: center;
                                                    }
                                                </style>
                                                <?php 
                                                    $planes = explode(",",$value['planes']);
                                                    $num_post = explode(",",$value['num_publicaciones_rest']);
                                                    $num_desc = explode(",",$value['num_descarga_rest']);
                                                    $estados = explode(",",$value['estado']);
                                                    $ids_empresasPlans = explode(",",$value['ids_empresasPlans']); 
                                                    $fechas_caducidades = explode(",",$value['fechas_caducidades']);
                                                   
                                                    if(!empty($planesActivos)){
                                                        
                                                        //solo se puede agregar un nuevo plan siempre y cuando el o los planes disponibles sean distintos de los planes ya creados y tengan recursos
                                                        $interseccion_planes = array_diff(explode(",",$planesActivos['planes_activos']), explode(",",$value['ids_Planes']));
                   
                                                        if(!empty($interseccion_planes)){
                                                            $puedeCrearPlan = '1';
                                                        }
                                                    }else{
                                                        $puedeCrearPlan = '';
                                                    }
                                                ?>
                                                <tr align="center">
                                                    <td style="vertical-align:middle; text-align: center;" rowspan="<?php echo ((isset($planes)) ? count($planes) : '1'); ?>" style="text-align: center;" data-title="Nombres:"><?php echo utf8_encode($value['nombres']); ?></td>
                                                    
                                                    <?php 

                                                        if(isset($planes) && is_array($planes)){

                                                            $mostrar = 0;
                                                            foreach ($planes as $key => $dato) { ?>

                                                            <td style="text-align: center;"><?php echo $dato; ?></td>
                                                            <td style="text-align: center;"><?php echo $num_post[$key]; ?></td>
                                                            <td style="text-align: center;"><?php echo $num_desc[$key]; ?></td>
                                                            <td style="text-align: center;"><?php echo $estados[$key]; ?></td>

                                                            <?php 

                                                            if(!empty($puedeCrearCuenta) && !empty($tieneRecursos['publicaciones'])){ 

                                                                //verificar al editar que mi plan padre tiene recursos para asignarme (solo puedo editar si mi padre tiene recursos del mismo plan que lo creo) y esta activo
                                                                $puedeEditarCuenta = Modelo_UsuarioxPlan::tieneRecursos($ids_empresasPlans[$key],false);

                                                                if(!empty($puedeEditarCuenta[0]['numero_postulaciones'])){
                                                                    $numero_postulaciones = $puedeEditarCuenta[0]['numero_postulaciones'];
                                                                }else{
                                                                   $numero_postulaciones = '0'; 
                                                                }

                                                                if(!empty($puedeEditarCuenta[0]['numero_descarga']) && $puedeEditarCuenta[0]['numero_descarga'] == -1){
                                                                    $numero_descargas = $puedeEditarCuenta[0]['numero_descarga'];
                                                                }else{
                                                                   $numero_descargas = '0'; 
                                                                }

                                                                if($fechas_caducidades[$key] >= date('Y-m-d H:i:s') || $estados[$key] != 'Inactivo'/*&& $numero_postulaciones != -1*/){ ?>
                                                                    <td class="icon_oferta" style="text-align: center;"><a href="<?php echo PUERTO.'://'.HOST.'/editarPlanEmpresa/'.$ids_empresasPlans[$key].'/'; ?>">
                                                                        <i class="fa fa-edit" title="Editar plan de la empresa"></i>
                                                                    </a></td>
                                                                <?php }else{ ?>
                                                                        <td class="icon_oferta" style="text-align: center;">
                                                                            <i class="fa fa-edit icon_deshabilitados" title="Editar plan de la empresa"></i>
                                                                        </td>
                                                                <?php } 

                                                                if($estados[$key] != 'Inactivo'){ ?>
                                                                    <td class="icon_oferta" style="text-align: center;"><a href="<?php echo PUERTO.'://'.HOST.'/eliminarPlanEmpresa/'.$ids_empresasPlans[$key].'/'; ?>" onclick="if(!confirm('Está seguro que desea eliminar el plan?')) return false;">
                                                                        <i class="fa fa-trash " title="Eliminar plan de la empresa"></i>
                                                                    </a></td>
                                                            <?php }else{ ?>
                                                                    <td class="icon_oferta" style="text-align: center;">
                                                                        <i class="fa fa-trash  icon_deshabilitados" title="Eliminar plan de la empresa"></i></td>
                                                            <?php }

                                                                 if($mostrar == 0){
                            
                                                                    if(!empty($tieneRecursos['publicaciones']) && !empty($puedeCrearPlan)){ ?>
                                                                        <td class="icon_oferta" style="vertical-align:middle; text-align: center;" align="center" rowspan="<?php echo ((isset($planes)) ? count($planes) : '1'); ?>" style="text-align: center;"><a href="<?php echo PUERTO.'://'.HOST.'/asignarPlanEmpresa/'.$value['id_empresa'].'/'; ?>">
                                                                            <i class="fa fa-plus " title="Asignar recursos"></i>
                                                                        </a></td>
                                                                <?php } else{ ?>
                                                                            <td class="icon_oferta" style="vertical-align:middle; text-align: center;" align="center" rowspan="<?php echo ((isset($planes)) ? count($planes) : '1'); ?>" style="text-align: center;"><i class="fa fa-plus  icon_deshabilitados" title="Asignar recursos"></i></td>
                                                                    <?php }
                                                                }
                                                        }
                                                        $mostrar++; ?>
                                                </tr>
                                                <?php  } ?>
                                                        
                                                <?php }else{  ?>
                                                    <td style="text-align: center;"><?php echo $value['planes']; ?></td>
                                                    <td style="text-align: center;"><?php echo $value['num_publicaciones_rest']; ?></td>
                                                    <td style="text-align: center;" ><?php echo $value['num_descarga_rest']; ?></td>
                                                    <td style="text-align: center;"><?php echo $value['estado']; ?></td></tr>
                                                <?php } ?>
                                                
                                            <?php } ?>
                                        <?php }else{ ?>
                                            <tr><td colspan="10">No tiene ning&uacute;n empresa creada</td></tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <?php echo $paginas; ?>
                                </div>
                                
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="msg_confirmplan" tabindex="-1" role="dialog" aria-labelledby="msg_confirmplan" aria-hidden="true">
                              <div class="modal-dialog " role="document">
                                <form method="post" action="<?php echo PUERTO;?>://<?php echo HOST;?>/compraplan/" id="form_plan" name="form_plan">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLongTitle">Sucripci&oacute;n de plan</h5>        
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
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
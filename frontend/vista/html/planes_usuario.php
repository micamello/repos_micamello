<div class="container"><br><br>
    <div class="row">
        <div class="main_business">
            <section>
                <div class="container">
                    <div class="col-md-12">
                        <div class="breadcrumb">
                            <p class="text-center" style="font-size: 20px;">Planes Contratados</p>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hovered table-hover">
                                        <thead class="breadcrumb">
                                            <tr>
                                                <th class="text-center">Nombre plan</th> 
                                                <th class="text-center">Fecha inscripci&oacute;n</th>
                                                <th class="text-center">Fecha Vencimiento</th>
                                                <th class="text-center">Autopostulaciones Restantes</th>
                                                <th class="text-center">Fecha Pago</th>
                                                <th class="text-center">M&eacute;todo de Pago</th>
                                                <th class="text-center">Estado de Pago</th>
                                                <th class="text-center">Estado del Plan</th>
                                                <th class="text-center">Eliminar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(!empty($planUsuario)){ 


                                                ?>
                                                <?php foreach ($planUsuario as $key => $value) { ?>
                                                <tr align="center">
                                                    <td><?php echo utf8_encode($value['nombre']); ?></td>
                                                    <td><?php echo date("d-m-Y", strtotime($value['fecha_compra'])); ?></td>
                                                    <td><?php if($value['fecha_caducidad'] != 'Infinito'){
                                                        echo date("d-m-Y", strtotime($value['fecha_caducidad'])); 
                                                        }else{ echo $value['fecha_caducidad']; } ?></td>
                                                    <td><?php echo $value['num_post_rest']; ?></td>
                                                    <?php if($value['costo'] == 0){ ?>
                                                        <td colspan="3">Plan Gratuito</td>
                                                    <?php }else{ 
                                                        if($value['id_comprobante'] != ""){
                                                        $datos = Modelo_Comprobante::obtieneComprobante($value['id_comprobante']);
                                                    ?>
                                                        <td><?php echo date("d-m-Y", strtotime($datos[0]['fecha_creacion'])); ?></td>
                                                        <td><?php echo Modelo_Comprobante::METODOS_PAGOS[$datos[0]['tipo_pago']]; ?></td>
                                                        <td><?php echo  Modelo_Comprobante::TIPO_PAGOS[$datos[0]['estado']]; ?></td>
                                                    <?php }else{ ?>
                                                        <td colspan="3"><?php echo Modelo_Comprobante::METODOS_PAGOS['3']; ?></td>
                                                    <?php }
                                                    } ?>
                                                    <td><?php echo ESTADOS[$value['estado']]; ?></td>
                                                    <td>
                                                        <?php if($value['estado'] != 0){ ?>
                                                            <a href="<?php echo PUERTO."://".HOST.'/planesUsuario/'.$value['id_usuario_plan']."/"; ?>">
                                                                <img width="15" src="<?php echo PUERTO.'://'.HOST.'/imagenes/delete.png'; ?>" alt="Eliminar">
                                                            </a>
                                                        <?php }else{ echo '-'; } ?>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            <?php }else{ ?>
                                                <tr><td colspan="7">No tiene ning&uacute;n plan comprado</td></tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="astrodivider">
                                <div class="astrodividermask"></div>
                                <span><i><img src="<?php echo PUERTO."://".HOST."/imagenes/logo.png"; ?>"></i></span>
                            </div>
                           <div class="row">    
                              <?php if (!empty($planes)){ ?>                
                                <div class="col-md-12">        
                                  <h3 align="left">&nbsp;Seleccione un plan:</h3>
                                  <div class="pricingdiv">   
                                    <?php echo $planes;?>  
                                  </div>                                
                                </div>  
                              <?php } ?> 
                              <?php if (!empty($avisos)){ ?>     
                                <div class="col-md-12">        
                                  <h3 align="left">&nbsp;Seleccione un aviso:</h3>
                                  <div class="pricingdiv">
                                    <?php echo $avisos;?>  
                                  </div>                                 
                                </div>
                              <?php } ?> 
                           </div>
                            <br><br>

                            <!-- Modal -->
                            <div class="modal fade" id="msg_confirmplan" tabindex="-1" role="dialog" aria-labelledby="msg_confirmplan" aria-hidden="true">
                              <div class="modal-dialog " role="document">
                                <form method="post" action="<?php echo PUERTO;?>://<?php echo HOST;?>/compraplan/" id="form_plan" name="form_plan">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLongTitle">Sucripci&oacute;n de plan</h5>        
                                      <input type="hidden" name="idplan" id="idplan" value="">
                                    </div>
                                    <div class="modal-body"><p>Procederas a suscribirte en el Plan, ¿Continuar?</p></div>
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

        

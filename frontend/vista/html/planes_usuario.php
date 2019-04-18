<div class="container"><br>
  <div class="row">
    <div class="main_business">
      <section>
        <div class="container">
          <div class="col-md-12">
            <div><p class="text-center" style="font-size: 20px;margin-bottom: 20px;">Planes Contratados</p></div>
            <div class="panel panel-default">
              <div class="panel-body">
                <div id="no-more-tables">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr class="breadcrumb">
                        <th class="text-center">Nombre del Plan</th> 
                        <th class="text-center">Fecha de Inscripci&oacute;n</th>
                        <th class="text-center">Fecha de Vencimiento</th>
                        <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO){ ?>
                        <th class="text-center">Autopostulaciones Restantes</th>
                        <?php }else{ ?>
                        <th class="text-center">Ofertas Restantes</th>
                        <th class="text-center">Accesos Restantes</th>
                        <?php } ?>  
                        <th class="text-center">Fecha Pago</th>
                        <th class="text-center">M&eacute;todo de Pago</th>
                        <th class="text-center">Estado de Pago</th>
                        <th class="text-center">Estado del Plan</th>
                        <th class="text-center">Factura</th>                                                
                      </tr>
                    </thead>
                    <tbody>
                    <?php if(!empty($planUsuario)){ ?>
                      <?php foreach ($planUsuario as $key => $value) { ?>
                        <style>
                            #centrar{
                                text-align: center;
                            }
                        </style>
                        <tr align="center">
                            <td style="text-align: center;" data-title="Nombre:"><?php echo utf8_encode($value['nombre']); ?></td>
                            <td style="text-align: center; " data-title="Inscripci&oacute;n:"><?php echo date("d-m-Y", strtotime($value['fecha_compra'])); ?></td>
                            <td style="text-align: center;" data-title="Vencimiento:">
                                <?php if($value['fecha_caducidad'] != '-'){
                                echo date("d-m-Y", strtotime($value['fecha_caducidad'])); 
                                }else{ echo $value['fecha_caducidad']; } ?></td>
                            <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO){ ?>
                              <td style="text-align:center;" data-title="Autopostulaciones:"><?php echo $value['num_post_rest'];?>
                              </td>
                            <?php }else{ ?>
                              <td style="text-align:center;" data-title="Ofertas:"><?php echo $value['num_post_rest'];?></td>   
                              <td style="text-align:center;" data-title="Accesos:"><?php echo $value['num_accesos_rest'];?></td>   
                            <?php } ?>    
                            
                            <?php if($value['costo'] == 0){ ?>
                                <td style="text-align: center;" data-title="M&eacute;todo" colspan="3">Plan Gratuito</td>
                            <?php }else{ 
                                if($value['id_comprobante'] != ""){                                                            
                                $datos = Modelo_Comprobante::obtieneComprobante($value['id_comprobante']); 
                            ?>
                                <td style="text-align: center;" data-title="Fecha Pago: "><?php echo date("d-m-Y", strtotime($datos['fecha_creacion'])); ?></td>
                                <td style="text-align: center;" data-title="M&eacute;todo"><?php echo Modelo_Comprobante::METODOS_PAGOS[$datos['tipo_pago']]; ?></td>
                                <td style="text-align: center;" data-title="Estado de Pago: "><?php echo  Modelo_Comprobante::TIPO_PAGOS[$datos['estado']]; ?></td>
                            <?php }else{ 

                                if(isset($value['id_empresa_plan_parent']) && $value['id_empresa_plan_parent'] != ""){
                                ?>
                                    <td style="text-align: center;" data-title="M&eacute;todo: " colspan="3">Plan Heredado</td>
                            <?php }else{ ?>
                                    <td style="text-align: center;" data-title="M&eacute;todo: " colspan="3">Plan Gratuito</td>
                            <?php  }
                                }
                            } ?>
                            <td style="text-align: center;" data-title="Estado del Plan: "><?php echo ESTADOS[$value['estado']]; ?></td>
                            <td style="text-align: center;" data-title="Factura: ">
                                <?php if(!empty($value['id_factura'])){ ?>
                                    <a title="Descargar factura" href="#">
                                        <i class="fa fa-money"></i></i>
                                    </a>
                                <?php }else{ echo '-'; } ?>
                            </td>                                                    
                        </tr>
                      <?php } ?>
                    <?php }else{ ?>
                        <tr><td colspan="10">No tiene ning&uacute;n plan comprado</td></tr>
                    <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="astrodivider">
                <div class="astrodividermask"></div>
                <span><i><img width="100%" src="<?php echo PUERTO."://".HOST."/imagenes/logo.png"; ?>"></i></span>
              </div>
              <div class="row">   
                <?php echo $html;?>                               
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
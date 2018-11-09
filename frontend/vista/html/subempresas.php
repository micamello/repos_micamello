<div class="container"><br>
    <div class="row">
        <div class="main_business">
            <section>
                <div class="container">
                    <div class="col-md-12">
                        <div>
                            <p class="text-center" style="font-size: 20px;margin-bottom: 20px;">Listado de Sub Empresas</p>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div id="no-more-tables">
                                    <div class="form-group col-md-12" align="right">
                                        <span>
                                            <strong>N° de Cuentas creadas: </strong>
                                            <span style="color:red" class="parpadea"><?php echo $cantd_empresas; ?></span>
                                        </span>
                                        &nbsp;&nbsp;
                                        <span id="boton" name="" class="btn btn-md btn-success">
                                        <i class="fa fa-industry fa-1x" title="Crear nueva empresa"></i> CREAR EMPRESA</span>
                                    </div>
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr class="breadcrumb">
                                                <th class="text-center">Nombre empresa</th> 
                                                <th class="text-center">Plan(es) asociado(s)</th>
                                                <th class="text-center">N° de publicaciones</th>
                                                <th class="text-center">N° de descargas</th>
                                                <th colspan="2" class="text-center">Acciones</th>
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
                                                <tr align="center">
                                                    <td style="text-align: center;" data-title="Nombres:"><?php echo utf8_encode($value['nombres']); ?></td>
                                                    <td style="text-align: center;" data-title="Planes activos:"><?php echo $value['planes']; ?></td>
                                                    <td style="text-align: center;" data-title="Publicaciones restantes: "><?php echo $value['num_publicaciones_rest']; ?></td>
                                                    <td style="text-align: center;" data-title="Descargas restantes"><?php echo $value['num_descarga_rest']; ?></td>
                                                    <td style="text-align: center;" data-title="Editar"><a href="">
                                                        <i class="fa fa-edit fa-1x" title="Editar la empresa"></i>
                                                    </a></td>
                                                    <td style="text-align: center;" data-title="Eliminar"><a href="">
                                                        <i class="fa fa-trash fa-1x" title="Eliminar empresa"></i>
                                                    </a></td>
                                                </tr>
                                            <?php } ?>
                                        <?php }else{ ?>
                                            <tr><td colspan="10">No tiene ning&uacute;n empresa creada</td></tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                    <div class="col-md-12">
                                        <?php echo $paginas; ?>
                                    </div>
                                </div>
                            </div>
                            <!--<div class="astrodivider">
                                <div class="astrodividermask"></div>
                                <span><i><img width="100%" src="<?php #echo PUERTO."://".HOST."/imagenes/logo.png"; ?>"></i></span>
                            </div>
                            <br><br>
                            -->
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
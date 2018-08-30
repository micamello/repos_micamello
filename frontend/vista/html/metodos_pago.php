<div class="container">
  <div class="row">
    <div class="main_business">                                                                                    
      <div class="container">
        <div class="breadcrumb">
          <h3>M&eacute;todos de pago</h3>
        </div>
        <div align="center">
          <label><input type="radio" name="select_form" id="db" checked="checked" value="D">&nbsp;Dep&oacute;sito Bancario</label>
          <label><input type="radio" name="select_form" id="pp" value="P">&nbsp;Paypal</label>
        </div>
        <br>
      </div>          
      <div class="col-md-6">        
        <div class="panel panel-default" id="panel_D">
          <div class="panel-body">
            <form role="form" name="form_deposito" id="form_deposito" method="post" enctype="multipart/form-data" action="<?php echo PUERTO;?>://<?php echo HOST;?>/compraplan/deposito/">  
              <h4 class="text-center">Dep&oacute;sito bancario</h4>
              <input type="hidden" id="idplan" name="idplan" value="<?php echo $plan["id_plan"];?>">
              <img src="<?php echo PUERTO;?>://<?php echo HOST;?>/imagenes/circulo-morado.png"><br>
              <p class="text-justify">En caso de haber realizado el dep&oacute;sito, proceda a ingresar el número, subir imagen(fotograf&iacute;a) del comprobante y llenar datos que se solicitan en la parte inferior.</p>
              <div align="center" class="breadcrumb">
                <h6><strong>Banco: </strong>Banco xxxxxxxx</h6>
                <h6><strong>N° de cuenta: </strong>00000000000000</h6>
                <h6><strong>Nombre: </strong>Windman Hidrovo</h6>
                <h6><strong>C&eacute;dula: </strong>000000000-0</h6>
              </div><hr>
              <div>                                                
                <h6 class="text-center">Datos del dep&oacute;sito</h6>
                <div class="row">
                  <div class="form-group col-md-6">
                    <label>N&uacute;mero de comprobante:</label><div class="help-block with-errors"></div>
                    <input type="text" name="num_comprobante" id="num_comprobante" class="form-control" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Valor del d&eacute;posito:</label><div class="help-block with-errors"></div>
                    <input type="text" name="valor" id="valor" class="form-control" required>
                  </div>
                  <div class="form-group col-md-12">
                    <label>Imagen comprobante:</label><div class="help-block with-errors"></div>
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="imagen" name="imagen" accept=".png,.jpeg,.jpg" required>  
                      <span class="label label-default">(debe ser menor a 1 MB con formato .jpg o .png)</span>                    
                    </div>                    
                  </div>
                </div>
              </div>
              <hr>
              <h6 class="text-center">Detalles de Facturaci&oacute;n</h6>
              <div class="form-group col-md-12">
                <label>Nombre y apellidos:</label><div class="help-block with-errors"></div>
                <input type="text" name="nombre" id="nombre" class="form-control" pattern="[a-z A-ZñÑáéíóúÁÉÍÓÚ]+" placeholder="Ejemplo: Carlos Crespo" required>
              </div>
              <div class="form-group col-md-12">    
                <label>Correo:</label><div class="help-block with-errors"></div>
                <input type="email" name="correo" id="correo" class="form-control" placeholder="Ejemplo: carloscrespo@gmail.com" required>
              </div>
              <div class="form-group col-md-6">    
                <label>Provincia:</label><div class="help-block with-errors"></div>
                <select class="form-control" name="provincia" id="provincia" required>
                  <option value="">Seleccione una provincia</option>
                  <?php if (!empty($arrprovincia)){
                          foreach($arrprovincia as $key => $pr){ 
                            echo "<option value='".$pr['id_provincia']."'";
                            if ($provincia == $pr['id_provincia']){ 
                              echo " selected='selected'";
                            }
                            echo ">".utf8_encode($pr['nombre'])."</option>";
                          }
                        } 
                  ?>
                </select>                
              </div>
              <div class="form-group col-md-6">    
                <label>Ciudad:</label><div class="help-block with-errors"></div>
                <select id="ciudad" name="ciudad" class="form-control" required>
                <?php if(!empty($arrciudad)){
                        foreach($arrciudad as $key => $ciudad){ 
                          echo "<option value='".$ciudad['id_ciudad'];
                          if ($_SESSION['mfo_datos']['usuario']['id_ciudad'] == $key){  
                              echo " selected='selected'";
                          }
                          echo "'>".utf8_encode($ciudad['ciudad'])."</option>";
                        } 
                      }else{ ?>
                        <option value="">Seleccione una ciudad</option>
                <?php } ?>
                </select>
              </div>
              <div class="form-group col-md-6">    
                <label>Tel&eacute;fono:</label><div class="help-block with-errors"></div>
                <input type="text" name="telefono" id="telefono" class="form-control" minlength="10" maxlength="15" required>
              </div>
              <div class="form-group col-md-6">    
                <label>C&eacute;dula / RUC:</label><div class="help-block with-errors"></div>                
                <input type="text" name="dni" id="dni" class="form-control" minlength="10" maxlength="15" required>
              </div>
              <div align="center">
                <input type="submit" name="btndeposito" value="Aceptar" class="btn btn-success btn-sm">
              </div>
            </form>
          </div>
        </div>        
      </div>
      <div class="col-md-6">
        <div class="panel panel-default" id="panel_P">
          <div class="panel-body">
            <img src="<?php echo PUERTO;?>://<?php echo HOST;?>/imagenes/PayPal.jpg"><br><br>
            <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
              <div class="col-xs-12 col-md-12">                
                <div class="form-group col-md-12">
                  <label>Nombre y apellidos:</label>
                  <input type="text" name="nombre" id="nombre" class="form-control" required>
                </div>
                <div class="form-group col-md-12">    
                  <label>Correo:</label>
                  <input type="email" name="correo" id="correo" class="form-control" required>
                </div>
                <div class="form-group col-md-6">    
                  <label>Provincia:</label><div class="help-block with-errors"></div>
                  <select class="form-control" name="provincia" id="provincia" required>
                    <option value="">Seleccione una provincia</option>
                    <?php if (!empty($arrprovincia)){
                            foreach($arrprovincia as $key => $pr){ 
                              echo "<option value='".$pr['id_provincia']."'";
                              if ($provincia == $pr['id_provincia']){ 
                                echo " selected='selected'";
                              }
                              echo ">".utf8_encode($pr['nombre'])."</option>";
                            }
                          } 
                    ?>
                  </select>                
                </div>
                <div class="form-group col-md-6">    
                  <label>Ciudad:</label><div class="help-block with-errors"></div>
                  <select id="ciudad" name="ciudad" class="form-control" required>
                  <?php if(!empty($arrciudad)){
                          foreach($arrciudad as $key => $ciudad){ 
                            echo "<option value='".$ciudad['id_ciudad'];
                            if ($_SESSION['mfo_datos']['usuario']['id_ciudad'] == $key){  
                                echo " selected='selected'";
                            }
                            echo "'>".utf8_encode($ciudad['ciudad'])."</option>";
                          } 
                        }else{ ?>
                          <option value="">Seleccione una ciudad</option>
                  <?php } ?>
                  </select>
                </div>                
                <div class="form-group col-md-6">    
                  <label>Tel&eacute;fono:</label>
                  <input type="number" name="telefono" id="telefono" class="form-control" required>
                </div>
                <div class="form-group col-md-6">    
                  <label>C&eacute;dula / RUC:</label>
                  <input type="text" name="dni" id="dni" class="form-control" required>
                </div>                 
              </div>
              <div class="col-xs-12 col-md-12">
                <div class="breadcrumb" align="center">                  
                  <label>Plan Seleccionado:</label><br><?php echo $plan["nombre"];?>
                  <hr>
                  <label>Valor:</label><?php echo $_SESSION["mfo_datos"]["sucursal"]["simbolo"].number_format($plan["costo"],2);?><br><br>       
                  <input type="image" src="<?php echo PUERTO;?>://<?php echo HOST;?>/imagenes/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">                       
                </div>                   
              </div>                        
            </form>
          </div>
        </div>    
      </div>     
    </div>
  </div>
</div>
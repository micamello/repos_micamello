<div class="container">
  <div class="row">
    <div class="main_business">                                                                                    
      <div class="container">
        <div class="breadcrumb">
          <h3>M&eacute;todos de pago</h3>
        </div>
        <div align="center">     
          <?php foreach(Modelo_Comprobante::METODOS_PAGOS as $key=>$metodo){ ?>               
            <label>
              <input type="radio" id="db" name="select_form" <?php echo ($key == Modelo_Comprobante::METODO_PAYPAL) ? 'checked="checked"' : '';?> value="<?php echo $key;?>">&nbsp;<?php echo $metodo;?>
            </label>&nbsp;&nbsp;&nbsp;&nbsp;  
          <?php } ?>            
        </div>
        <br>
      </div>           
      <div class="col-md-2"></div>
      <div class="col-md-8">        
        <div class="panel panel-default" id="panel_1" style="display:none;">
          <div class="panel-body">
            <form role="form" name="form_deposito" id="form_deposito" method="post" enctype="multipart/form-data" action="<?php echo PUERTO;?>://<?php echo HOST;?>/compraplan/deposito/">  
              <h4 class="text-center">Dep&oacute;sito bancario</h4>
              <input type="hidden" id="idplan" name="idplan" value="<?php echo $plan["id_plan"];?>">              
              <img src="<?php echo PUERTO;?>://<?php echo HOST;?>/imagenes/circulo-morado.png"><br>
              <p class="text-justify">En caso de haber realizado el dep&oacute;sito, proceda a ingresar el número, subir imagen(fotograf&iacute;a) del comprobante y llenar datos que se solicitan en la parte inferior.</p>
              <?php if (isset($ctabancaria) && !empty($ctabancaria)){ ?>
                <?php foreach($ctabancaria as $banco){?>
                  <div class="breadcrumb col-md-6 text-justify">
                    <h6><strong>Banco: </strong><?php echo $banco["nombre_banco"];?></h6>
                    <h6><strong>N° de cuenta: </strong><?php echo $banco["numero_cta"];?></h6>
                    <h6><strong>Nombre: </strong><?php echo $banco["nombres"]."&nbsp;".$banco["apellidos"];?></h6>
                    <h6><strong>C&eacute;dula: </strong><?php echo $banco["dni"];?></h6>
                    <h6><strong>Tipo de Cuenta: </strong><?php echo ($banco["tipocta"] == Modelo_Ctabancaria::AHORROS) ? "Ahorros" : "Cr&eacute;dito";?></h6>
                  </div>
                <?php }?>
              <?php } ?>              
              <div>                                                
                <h4 class="text-center">Datos del dep&oacute;sito</h4>
                <div class="row">
                  <div class="form-group col-md-6">
                    <label>N&uacute;mero de comprobante:</label><div class="help-block with-errors"></div>
                    <input type="text" name="num_comprobante" id="num_comprobante" class="form-control" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Valor del d&eacute;posito:</label><div class="help-block with-errors"></div>
                    <input type="text" name="valor" id="valor" class="form-control" onkeypress="return validaDecimales(event,this);" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Imagen comprobante:</label><div class="help-block with-errors"></div>
                    <br>
                    <label for="imagen" class="custom_file">
                      <img id="imgupload" class="button-center" src="<?php echo PUERTO."://".HOST."/imagenes/upload-icon.png";?>" width="50px">
                    </label>
                    <input type="file" class="upload-photo" id="imagen" name="imagen" accept=".png,.jpeg,.jpg" required> 
                    <div align="center">
                      <p class="text-center arch_cargado" id="texto_status1">(debe ser menor a 1 MB con formato .jpg o .png)</p>
                    </div> 
                  </div>
                  <div class="form-group col-md-6" id="divimagen">                    
                  </div>
                </div>
              </div>
              <hr>
              <h4 class="text-center">Detalles de Facturaci&oacute;n</h4>
              <div class="form-group col-md-6">
                <label>Nombre y apellidos:</label><div class="help-block with-errors"></div>
                <input type="text" name="nombre" id="nombre" class="form-control" pattern="[a-z A-ZñÑáéíóúÁÉÍÓÚ]+" placeholder="Ejemplo: Carlos Crespo" required>
              </div>
              <div class="form-group col-md-6">    
                <label>Correo:</label><div class="help-block with-errors"></div>
                <input type="email" name="correo" id="correo" class="form-control" placeholder="Ejemplo: carloscrespo@gmail.com" required>
              </div>              
              <div class="form-group col-md-6">    
                <label>Provincia:</label><div class="help-block with-errors"></div>
                <select class="form-control" name="provincia" id="provincia">
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
                <select id="ciudad" name="ciudad" class="form-control">
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
              <div class="form-group col-md-12">    
                <label>Direcci&oacute;n:</label><div class="help-block with-errors"></div>
                <input type="text" name="direccion" id="direccion" class="form-control" placeholder="Ejemplo: Samanes V" required>
              </div>
              <div class="form-group col-md-6">    
                <label>Tel&eacute;fono:</label><div class="help-block with-errors"></div>
                <input type="text" name="telefono" id="telefono" class="form-control" minlength="10" maxlength="15" onkeydown="return validaNumeros(event);" required>
              </div>
              <div class="form-group col-md-6">    
                <label>C&eacute;dula / RUC:</label><div class="help-block with-errors"></div>                
                <input type="text" name="dni" id="dni" class="form-control" minlength="10" maxlength="15" onkeydown="return validaNumeros(event);" required>
              </div>
              <div align="center">
                <input type="submit" name="btndeposito" value="Aceptar" class="btn btn-success btn-sm">
              </div>
            </form>
          </div>
        </div>        
      </div>      
      <div class="col-md-2"></div>
      <?php if (!empty($plan["codigo_paypal"])){ ?>
      <div class="col-md-2"></div>  
      <div class="col-md-8">
        <div class="panel panel-default" id="panel_2">
          <div class="panel-body">
            <img src="<?php echo PUERTO;?>://<?php echo HOST;?>/imagenes/PayPal.jpg"><br><br>            
            <form action="<?php echo RUTA_PAYPAL;?>" method="post" name="form_paypal" id="form_paypal" role="form">
              <div class="col-xs-12 col-md-12">                
                <div class="form-group col-md-6">
                  <label>Nombre y apellidos:</label><div class="help-block with-errors"></div>
                  <input type="text" name="nombreP" id="nombreP" class="form-control" required>
                </div>
                <div class="form-group col-md-6">    
                  <label>Correo:</label><div class="help-block with-errors"></div>
                  <input type="email" name="correoP" id="correoP" class="form-control" required>
                </div>
                <div class="form-group col-md-6">    
                  <label>Provincia:</label><div class="help-block with-errors"></div>
                  <select class="form-control" name="provinciaP" id="provinciaP">
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
                  <select id="ciudadP" name="ciudadP" class="form-control">
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
                <div class="form-group col-md-12">
                  <label>Direcci&oacute;n:</label><div class="help-block with-errors"></div> 
                  <input type="text" name="direccionP" id="direccionP" class="form-control" required>  
                </div>
                <div class="form-group col-md-6">    
                  <label>Tel&eacute;fono:</label><div class="help-block with-errors"></div>
                  <input type="text" name="telefonoP" id="telefonoP" class="form-control" onkeydown="return validaNumeros(event);" required>
                </div>
                <div class="form-group col-md-6">    
                  <label>C&eacute;dula / RUC:</label><div class="help-block with-errors"></div>
                  <input type="text" name="dniP" id="dniP" class="form-control" onkeydown="return validaNumeros(event);" required>
                </div>                 
              </div>
              <div class="col-xs-12 col-md-12">
                <div class="breadcrumb" align="center">                  
                  <label>Plan Seleccionado:</label>&nbsp;<?php echo $plan["nombre"];?>
                  <input type="hidden" name="cmd" value="_s-xclick">
                  <input type="hidden" name="custom" id="custom" value="">
                  <input type="hidden" name="rm" value="2">
                  <input type="hidden" name="return" id="return" value="<?php echo PUERTO;?>://<?php echo HOST;?>/compraplan/paypal/">  
                  <input type="hidden" name="hosted_button_id" value="<?php echo $plan["codigo_paypal"];?>">
                  <input type="hidden" id="idplanP" name="idplanP" value="<?php echo $plan["id_plan"];?>">
                  <input type="hidden" id="usuarioP" name="usuarioP" value="<?php echo $_SESSION["mfo_datos"]["usuario"]["id_usuario"];?>">                  
                  <br>
                  <label>Valor:</label>&nbsp;<?php echo SUCURSAL_MONEDA.number_format($plan["costo"],2);?><br><br>       
                  <input type="image" src="<?php echo PUERTO;?>://<?php echo HOST;?>/imagenes/btn_buynowCC_LG.gif" border="0" name="button" alt="PayPal - The safer, easier way to pay online!" id="btn_submitpaypal">
                </div>                   
              </div>                        
            </form>
          </div>
        </div>    
      </div>  
      <div class="col-md-2"></div>
      <?php } ?>
      <div class="col-md-2"></div>
      <div class="col-md-8">
        <div class="panel panel-default" id="panel_3" style="display:none;">
          <div class="panel-body">
            <img src="<?php echo PUERTO;?>://<?php echo HOST;?>/imagenes/logo-paymentez.jpg"><br><br>            
            <form action="<?php echo RUTA_PAYPAL;?>" method="post" name="form_paypal" id="form_paypal" role="form">
              <div class="col-xs-12 col-md-12">                
                <div class="form-group col-md-12">
                  <label>Nombre y apellidos:</label><div class="help-block with-errors"></div>
                  <input type="text" name="nombreZ" id="nombreZ" class="form-control" required>
                </div>
                <div class="form-group col-md-12">    
                  <label>Correo:</label><div class="help-block with-errors"></div>
                  <input type="email" name="correoZ" id="correoZ" class="form-control" required>
                </div>
                <div class="form-group col-md-6">    
                  <label>Provincia:</label><div class="help-block with-errors"></div>
                  <select class="form-control" name="provinciaZ" id="provinciaZ">
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
                  <select id="ciudadP" name="ciudadZ" class="form-control">
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
                  <input type="text" name="telefonoZ" id="telefonoZ" class="form-control" onkeydown="return validaNumeros(event);" required>
                </div>
                <div class="form-group col-md-6">    
                  <label>C&eacute;dula / RUC:</label><div class="help-block with-errors"></div>
                  <input type="text" name="dniZ" id="dniZ" class="form-control" onkeydown="return validaNumeros(event);" required>
                </div>                 
              </div>
              <div class="col-xs-12 col-md-12">
                <div class="breadcrumb" align="center">                  
                  <label>Plan Seleccionado:</label><br><?php echo $plan["nombre"];?>
                  <input type="hidden" id="idplanZ" name="idplanZ" value="<?php echo $plan["id_plan"];?>">
                  <input type="hidden" id="usuarioZ" name="usuarioZ" value="<?php echo $_SESSION["mfo_datos"]["usuario"]["id_usuario"];?>">
                  <hr>
                  <label>Valor:</label><?php echo SUCURSAL_MONEDA.number_format($plan["costo"],2);?><br><br>                         
                </div>                   
              </div>                        
            </form>
          </div>
        </div>    
      </div>     
      <div class="col-md-2"></div>
    </div>
  </div>
</div>
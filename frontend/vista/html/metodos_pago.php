<div class="container">
  <div class="row">
    <div class="main_business">                                                                                    
      <div class="container">
        <div class="breadcrumb">
          <h3>M&eacute;todos de pago</h3>
          <input type="hidden" name="tipoSeleccionado" id="tipoSeleccionado" value="">
        </div>
        <div align="center">     
          <?php foreach(Modelo_Comprobante::METODOS_PAGOS as $key=>$metodo){ ?>               
            <label>
              <input type="radio" id="db" name="select_form" <?php echo ($key == Modelo_Comprobante::METODO_PAYPAL) ? 'checked="checked"' : '';?> onclick="cambia(<?php echo $key;?>)" value="<?php echo $key;?>">&nbsp;<?php echo $metodo;?>
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
                  <div class="col-md-6">
                    <div id="seccion_comp" class="form-group">
                      <label>N&uacute;mero de comprobante</label><div id="err_comp" class="help-block with-errors"></div>
                      <input type="text" name="num_comprobante" id="num_comprobante" maxlength="50" class="form-control" onkeydown="return validaNumeros(event);" minlength="5">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div id="seccion_val" class="form-group">
                      <label>Valor del d&eacute;posito</label><div id="err_val" class="help-block with-errors"></div>
                      <input type="text" name="valor" id="valor" class="form-control" onkeypress="return validaDecimales(event,this);" maxlength="10" minlength="2">
                    </div>
                  </div>
                  <div id="seccion_img" class="col-md-6">
                    <div class="form-group">
                      <label>Imagen comprobante</label><div id="err_img" class="help-block with-errors" style="padding-top: 5px;"></div>
                      <br>
                      <label for="imagen" class="custom_file">
                        <img id="imgupload" class="button-center" src="<?php echo PUERTO."://".HOST."/imagenes/upload-icon.png";?>" width="50px">
                      </label>
                      <input type="file" class="upload-photo" id="imagen" name="imagen" accept=".png,.jpeg,.jpg" > 
                      <div align="center">
                        <p class="text-center arch_cargado" id="texto_status1">(debe ser menor a 1 MB con formato .jpg o .png)</p>
                      </div> 
                    </div>
                  </div>
                  <div class="form-group col-md-6" id="divimagen">                    
                  </div>
                </div>
              </div>
              <hr>
              <h4 class="text-center">Detalles de Facturaci&oacute;n</h4>
              <div class="col-md-6">
                <div id="seccion_tipo" class="form-group">    
                  <label>Tipo de Documento</label><div id="err_tipo" class="help-block with-errors"></div>
                  <select id="tipo_doc" name="tipo_doc" class="form-control"> 
                  <option disabled selected value="0">Seleccione una opción</option>             
                  <?php
                    foreach(TIPO_DOCUMENTO as $key=>$tipo){
                      echo "<option value='".$key."'>".utf8_encode($tipo)."</option>";
                    }
                  ?>  
                  </select>
                </div>
              </div>

              <div class="col-md-6"> 
                <div id="seccion_dni" class="form-group">    
                  <label>Identificaci&oacute;n</label>
                  <div class="help-block with-errors" id="err_dni"></div>
                  <input type="text" name="dni" id="dni" class="form-control" minlength="10" maxlength="15" >
                </div>
              </div>
              <div class="col-md-6">
                <div id="seccion_nombre" class="form-group">
                  <label>Nombre</label><div id="err_nom" class="help-block with-errors"></div>
                  <input type="text" name="nombre" id="nombre" class="form-control" placeholder="" maxlength="30">
                </div>
              </div>
              <div class="col-md-6">
                <div id="seccion_apellido" class="form-group">
                  <label>Apellido</label><div id="err_apell" class="help-block with-errors"></div>
                  <input type="text" name="apellido" id="apellido" class="form-control" placeholder="" maxlength="50">
                </div>
              </div>
              <div class="col-md-6">
                <div id="seccion_correo" class="form-group">    
                  <label>Correo</label><div id="err_correo" class="help-block with-errors"></div>
                  <input type="email" name="correo" id="correo" class="form-control" placeholder="" minlength="10" maxlength="30">
                </div>  
              </div> 
              <div class="col-md-6">
                <div id="seccion_tlf" class="form-group">    
                  <label>Tel&eacute;fono</label><div id="err_tlf" class="help-block with-errors"></div>
                  <input type="text" name="telefono" id="telefono" class="form-control" minlength="9" maxlength="15" onkeyup="return validaNumeros(event);" >
                </div>
              </div>
              <div class="col-md-12">           
                <div id="seccion_dir" class="form-group">    
                  <label>Direcci&oacute;n</label><div id="err_dir" class="help-block with-errors"></div>
                  <input type="text" name="direccion" id="direccion" class="form-control" placeholder="" maxlength="50">
                </div>
              </div>
              
              <div align="center">
                <input type="button" id="btndeposito" name="btndeposito" value="Aceptar" class="btn btn-success btn-sm disabled" onclick="enviarFormulario('form_deposito');">
              </div>
            </form>
          </div>
        </div>        
      </div>      
      <div class="col-md-2"></div>
      
      <div class="col-md-2"></div>  
      <div class="col-md-8">
        <div class="panel panel-default" id="panel_2">
          <div class="panel-body">
            <img src="<?php echo PUERTO;?>://<?php echo HOST;?>/imagenes/PayPal.jpg"><br><br>            
            <form action="#" method="post" name="form_paypal" id="form_paypal" role="form">
              <div class="col-xs-12 col-md-12"> 
                <div class="col-md-6">
                  <div id="seccion_tipoP" class="form-group">    
                    <label>Tipo de Documento</label><div id="err_tipoP" class="help-block with-errors"></div>
                    <select id="tipo_docP" name="tipo_docP" class="form-control"> 
                    <option disabled selected value="0">Seleccione una opción</option>             
                    <?php
                      foreach(TIPO_DOCUMENTO as $key=>$tipo){
                        echo "<option value='".$key."'>".utf8_encode($tipo)."</option>";
                      }
                    ?>  
                    </select>
                  </div>
                </div>

                <div class="col-md-6"> 
                  <div id="seccion_dniP" class="form-group">    
                    <label>Identificaci&oacute;n</label>
                    <div class="help-block with-errors" id="err_dniP"></div>
                    <input type="text" name="dniP" id="dniP" class="form-control" minlength="10" maxlength="15">
                  </div>
                </div>

                <div class="col-md-6"> 
                  <div id="seccion_nombreP" class="form-group">
                    <label>Nombre y apellidos</label><div id="err_nomP" class="help-block with-errors"></div>
                    <input type="text" name="nombreP" id="nombreP" maxlength="100" class="form-control" minlength="10">
                  </div>
                </div>

                <div class="col-md-6"> 
                  <div id="seccion_correoP" class="form-group">   
                    <label>Correo</label><div id="err_correoP" class="help-block with-errors"></div>
                    <input type="email" name="correoP" id="correoP" maxlength="100" class="form-control" minlength="10" placeholder="Ejemplo: carloscrespo@gmail.com">
                  </div>
                </div>

                <div class="col-md-6"> 
                  <div id="seccion_dirP" class="form-group"> 
                    <label>Direcci&oacute;n</label><div id="err_dirP" class="help-block with-errors"></div> 
                    <input type="text" name="direccionP" id="direccionP" maxlength="100" class="form-control">  
                  </div>
                </div>

                <div class="col-md-6"> 
                  <div id="seccion_tlfP" class="form-group">    
                    <label>Tel&eacute;fono</label><div id="err_tlfP" class="help-block with-errors"></div>
                    <input type="text" name="telefonoP" id="telefonoP" minlength="10" maxlength="15" class="form-control" onkeydown="return validaNumeros(event);">
                  </div>
                </div>

                <!--<div class="form-group col-md-6">    
                  <label>C&eacute;dula / RUC:</label><div class="help-block with-errors"></div>
                  <input type="text" name="dniP" id="dniP" class="form-control" onkeydown="return validaNumeros(event);" >
                </div>-->                 
              </div>
              <div class="col-xs-12 col-md-12">
                <div class="breadcrumb" align="center">                  
                  <label>Plan Seleccionado</label>&nbsp;<?php echo $plan["nombre"];?>
                  <input type="hidden" name="cmd" value="_s-xclick">
                  <input type="hidden" name="custom" id="custom" value="">
                  <input type="hidden" name="rm" value="2">
                  <input type="hidden" name="return" id="return" value="<?php echo PUERTO;?>://<?php echo HOST;?>/compraplan/paypal/">  
                  <input type="hidden" name="hosted_button_id" value="<?php echo $plan["codigo_paypal"];?>">
                  <input type="hidden" id="idplanP" name="idplanP" value="<?php echo $plan["id_plan"];?>">
                  <input type="hidden" id="usuarioP" name="usuarioP" value="<?php echo $_SESSION["mfo_datos"]["usuario"]["id_usuario"];?>">
                  <input type="hidden" id="tipousuP" name="tipousuP" value="<?php echo $_SESSION["mfo_datos"]["usuario"]["tipo_usuario"];?>">
                  <input type="hidden" name="rutaPAYPAL" id="rutaPAYPAL" value="<?php echo RUTA_PAYPAL;?>">                  
                  <br>
                  <label>Valor:</label>&nbsp;<?php echo SUCURSAL_MONEDA.number_format($plan["costo"],2);?><br><br>       
                  <input type="image" src="<?php echo PUERTO;?>://<?php echo HOST;?>/imagenes/btn_buynowCC_LG.gif" border="0" name="button" alt="PayPal - The safer, easier way to pay online!" id="btn_submitpaypal" class="disabled" onclick="enviarFormulario('form_paypal');">
                </div>                   
              </div>                        
            </form>        
          </div>
        </div>    
      </div>  
      <div class="col-md-2"></div>  
      <div class="col-md-2"></div>  

      <div class="col-md-8">
        <div class="panel panel-default" id="panel_3">          
          <div class="panel-body">
            <img src="<?php echo PUERTO;?>://<?php echo HOST;?>/imagenes/logo_payme.png"><br><br>            
            <form name="form_payme" id="form_payme" action="#" method="post" class="alignet-form-vpos2">
              <div class="col-xs-12 col-md-12"> 
                <div class="col-md-6">
                  <div id="seccion_tipoPM" class="form-group">    
                    <label>Tipo de Documento</label><div id="err_tipoPM" class="help-block with-errors"></div>
                    <select id="tipo_docPM" name="tipo_docPM" class="form-control"> 
                    <option disabled selected value="0">Seleccione una opción</option>             
                    <?php
                      foreach(TIPO_DOCUMENTO as $key=>$tipo){
                        echo "<option value='".$key."'>".utf8_encode($tipo)."</option>";
                      }
                    ?>  
                    </select>
                  </div>
                </div>

                <div class="col-md-6"> 
                  <div id="seccion_dniPM" class="form-group">    
                    <label>Identificaci&oacute;n</label>
                    <div class="help-block with-errors" id="err_dniPM"></div>
                    <input type="text" name="reserved2" id="reserved2" class="form-control" minlength="10" maxlength="15">
                  </div>
                </div>

                <div class="col-md-6"> 
                  <div id="seccion_nombrePM" class="form-group">
                    <label>Nombre</label><div id="err_nomPM" class="help-block with-errors"></div>
                    <input type="text" name="shippingFirstName" id="shippingFirstName" class="form-control" value="" maxlength="30" />
                  </div>
                </div>

                <div class="col-md-6"> 
                  <div id="seccion_apellidoPM" class="form-group">
                    <label>Apellido</label><div id="err_apellidoPM" class="help-block with-errors"></div>
                    <input type="text" name="shippingLastName" id="shippingLastName" class="form-control" value="" maxlength="50" />
                  </div>
                </div>

                <div class="col-md-6"> 
                  <div id="seccion_correoPM" class="form-group">   
                    <label>Correo</label><div id="err_correoPM" class="help-block with-errors"></div>
                    <input type="text" name="shippingEmail" id="shippingEmail" class="form-control" value="" maxlength="30" />
                  </div>
                </div>

                <div class="col-md-6"> 
                  <div id="seccion_tlfPM" class="form-group">    
                    <label>Tel&eacute;fono</label><div id="err_tlfPM" class="help-block with-errors"></div>
                    <input type="text" name="shippingPhone" id="shippingPhone" minlength="9" maxlength="15" class="form-control" onkeydown="return validaNumeros(event);">
                  </div>
                </div>   

                <div class="col-md-6"> 
                  <div id="seccion_dirPM" class="form-group"> 
                    <label>Direcci&oacute;n</label><div id="err_dirPM" class="help-block with-errors"></div> 
                    <input type="text" name="shippingAddress" id="shippingAddress" class="form-control" value="" maxlength="50" />
                  </div>
                </div>

                <div class="col-md-6"> 
                  <div id="seccion_zipPM" class="form-group"> 
                    <label>C&oacute;digo Postal</label><div id="err_zipPM" class="help-block with-errors"></div> 
                    <input type="text" name="shippingZIP" id="shippingZIP" class="form-control" value="" maxlength="10"/>
                  </div>
                </div>

                <div class="col-md-6"> 
                  <div id="seccion_provPM" class="form-group"> 
                    <label>Provincia</label><div id="err_provPM" class="help-block with-errors"></div> 
                    <select id="provinciaPM" name="provinciaPM" class="form-control"> 
                    <option disabled selected value="0">Seleccione una opci&oacute;n</option>             
                    <?php
                      foreach($arrprovincia as $key=>$provincia){
                        echo "<option value='".$provincia["id_provincia"]."'>".utf8_encode($provincia["nombre"])."</option>";
                      }
                    ?>  
                    </select>
                  </div>
                </div>

                <div class="col-md-6"> 
                  <div id="seccion_ciuPM" class="form-group"> 
                    <label>Ciudad</label><div id="err_ciuPM" class="help-block with-errors"></div> 
                    <select id="ciudadPM" name="ciudadPM" class="form-control">                     
                    </select>
                  </div>
                </div>
                                      
              </div>

              <div class="col-xs-12 col-md-12">
                <div class="breadcrumb" align="center">                  
                  <label>Plan Seleccionado</label>&nbsp;<?php echo utf8_encode($plan["nombre"]);?>
                  <input type="hidden" name="acquirerId" id="acquirerId" value="<?php echo PAYME_ACQUIRERID;?>" />
                  <input type="hidden" name ="idCommerce" id="idCommerce" value="<?php echo PAYME_IDCOMMERCE; ?>" />
                  <input type="hidden" name="purchaseOperationNumber" id="purchaseOperationNumber" value="<?php echo $transid; ?>" />
                  <input type="hidden" name="purchaseAmount" id="purchaseAmount" value="<?php echo $plan["costo"]; ?>" />
                  <input type="hidden" name="purchaseCurrencyCode" id="purchaseCurrencyCode" value="<?php echo PAYME_CURRENCY_CODE; ?>" />
                  <input type="hidden" name="language" id="language" value="SP" />
                  <input type="hidden" name="shippingState" id="shippingState" value="" />
                  <input type="hidden" name="shippingCity" id="shippingCity" value="" />
                  <input type="hidden" name="shippingCountry" id="shippingCountry" value="EC" />
                  <input type="hidden" name="userCommerce" id="userCommerce" value="<?php echo $_SESSION["mfo_datos"]["usuario"]["id_usuario"];?>" />
                  <input type="hidden" name="userCodePayme" id="userCodePayme" value="8--580--4390" /> 
                  <input type="hidden" name="descriptionProducts" id="descriptionProducts" value="<?php echo $plan["nombre"];?>" />
                  <input type="hidden" name="programmingLanguage" id="programmingLanguage" value="PHP" />
                  <input type="hidden" name="purchaseVerification" id="purchaseVerification" value="<?php echo $purchaseVerification; ?>" />
                  <input type="hidden" name="reserved1" value="SP" />
                  <input type="hidden" name="reserved3" value="<?php echo $plan["id_plan"];?>" />                  
                  <input type="hidden" name="reserved4" value="<?php echo $_SESSION["mfo_datos"]["usuario"]["tipo_usuario"];?>" />
                  <br>
                  <label>Valor:</label>&nbsp;<?php echo SUCURSAL_MONEDA.number_format($plan["costo"],2);?><br><br>       
                  <input type="button" id="btnpayme" name="btnpayme" onclick="enviarFormulario('form_payme');" value="Comprar" class="btn btn-success btn-sm disabled">
                </div>   

                                  
              </div>                        
            </form>
          </div>
        </div>    
      </div>

    </div>
  </div>
</div>
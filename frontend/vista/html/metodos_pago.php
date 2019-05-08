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
              <input type="radio" id="db" name="select_form" <?php echo ($key == Modelo_Comprobante::METODO_PAYME) ? 'checked="checked"' : '';?> onclick="cambia(<?php echo $key;?>)" value="<?php echo $key;?>">&nbsp;<?php echo $metodo;?>
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
        <div class="panel panel-default" id="panel_2" style="display:none;">
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
            <?php
            $purchaseOperationNumber = date('his');
            $purchaseVerification = openssl_digest(PAYME_ACQUIRERID . PAYME_IDCOMMERCE . $purchaseOperationNumber . "1000" . PAYME_CURRENCY_CODE . PAYME_SECRET_KEY, 'sha512'); 
            ?>         
            <form name="f1" id="f1" action="#" method="post" class="alignet-form-vpos2">
            <table>
                <tr><td>acquirerId</td><td><input type="text" name ="acquirerId" value="<?php echo PAYME_ACQUIRERID; ?>" /></td></tr>
                <tr><td>idCommerce</td><td> <input type="text" name ="idCommerce" value="<?php echo PAYME_IDCOMMERCE; ?>" /></td></tr>
                <tr><td>purchaseOperationNumber </td><td><input type="text" name="purchaseOperationNumber" value="<?php echo $purchaseOperationNumber; ?>" /></td></tr>
                <tr><td>purchaseAmount </td><td><input type="text" name="purchaseAmount" value="1000" /></td></tr>
                <tr><td>purchaseCurrencyCode </td><td><input type="text" name="purchaseCurrencyCode" value="<?php echo PAYME_CURRENCY_CODE; ?>" /></td></tr>
                <tr><td>language </td><td><input type="text" name="language" value="SP" /></td></tr>
                <tr><td>shippingFirstName </td><td><input type="text" name="shippingFirstName" value="Juan" /></td></tr>
                <tr><td>shippingLastName </td><td><input type="text" name="shippingLastName" value="Perez" /></td></tr>
                <tr><td>shippingEmail </td><td><input type="text" name="shippingEmail" value="modalprueba1@test.com" /></td></tr>
                <tr><td>shippingAddress </td><td><input type="text" name="shippingAddress" value="Direccion ABC" /></td></tr>
                <tr><td>shippingZIP </td><td><input type="text" name="shippingZIP" value="ZIP 123" /></td></tr>
                <tr><td>shippingCity </td><td><input type="text" name="shippingCity" value="CITY ABC" /></td></tr>
                <tr><td>shippingState </td><td><input type="text" name="shippingState" value="STATE ABC" /></td></tr>
                <tr><td>shippingCountry </td><td><input type="text" name="shippingCountry" value="EC" /></td></tr>
                <!--<tr><td>userCommerce </td><td><input type="text" name="userCommerce" value="modalprueba1" /></td></tr>
                <tr><td>userCodePayme </td><td><input type="text" name="userCodePayme" value="11--1941--4390" /></td></tr>-->
                <tr><td>mcc </td><td><input type="text" name="mcc" value="" /></td></tr>
                <tr><td>commerceAssociated </td><td><input type="text" name="commerceAssociated" value="" /></td></tr>
                <tr><td>descriptionProducts </td><td><input type="text" name="descriptionProducts" value="Producto ABC" /></td></tr>
                <tr><td>reserved1 </td><td><input type="text" name="reserved1" value="" /></td></tr>
                <tr><td>reserved2 (Monto Grava IVA)</td><td><input type="text" name="reserved2" value="890" /></td></tr>
                <tr><td>reserved3 (Monto IVA)</td><td><input type="text" name="reserved3" value="110" /></td></tr>
                <tr><td>reserved4 </td><td><input type="text" name="reserved4" value="000" /></td></tr>
                <tr><td>reserved5 </td><td><input type="text" name="reserved5" value="000" /></td></tr>
                <tr><td>reserved9 </td><td><input type="text" name="reserved9" value="000" /></td></tr>
                <tr><td>reserved10 (Monto Grava Iva)</td><td><input type="text" name="reserved10" value="890" /></td></tr>
                <tr><td>programmingLanguage </td><td><input type="text" name="programmingLanguage" value="PHP" /></td></tr>
                <tr><td>purchaseVerification </td><td><input type="text" name="purchaseVerification" value="<?php echo $purchaseVerification ?>" /></td></tr>

                <tr><td>programmingLanguage </td><td><input type="text" name="programmingLanguage" value="PHP" /></td></tr>

                <tr><td>taxMontoFijo </td><td><input type="text" name="taxMontoFijo" value="10" /></td></tr>
                <tr><td>taxMontoGravaIva </td><td><input type="text" name="taxMontoGravaIva" value="890" /></td></tr>
                <tr><td>taxMontoIVA </td><td><input type="text" name="taxMontoIVA" value="110" /></td></tr>
                <tr><td>taxMontoNoGravaIva </td><td><input type="text" name="taxMontoNoGravaIva" value="000" /></td></tr>
                <tr><td>taxServicio </td><td><input type="text" name="taxServicio" value="000" /></td></tr>
                <tr><td>taxICE </td><td><input type="text" name="taxice" value="0" /></td></tr>

                <td colspan="2" align="center">
                    <input type="button" name="boton01" value="Enviar Redirect" onclick="enviar();" ondblclick="enviar();">
                    <input type="button" onclick="javascript:AlignetVPOS2.openModal('https://integracion.alignetsac.com/')" value="Enviar Modal">
                </td>
            </table>
        </form>
          </div>
        </div>    
      </div>

    </div>
  </div>
</div>

<script language="Javascript">
          function enviar(){
            document.f1.action= 'https://integracion.alignetsac.com/VPOS2/faces/pages/startPayme.xhtml'
            document.f1.submit();
          }
        </script>
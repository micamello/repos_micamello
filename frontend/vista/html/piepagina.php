<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/vendor/jquery-1.11.2.min.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/jquery.multi-select.js"></script>
<script type="text/javascript">
    $(function(){
        $('#intereses').multiSelect();
    });
    $(function(){
        $('#nivel').multiSelect();
    });
    </script>
    <script type="text/javascript">
    $(function(){
        $('#intereses2').multiSelect();
    });
</script>  

<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/vendor/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/jquery.magnific-popup.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/jquery.easing.1.3.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/assets/css/slick/slick.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/assets/css/slick/slick.min.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/jquery.collapse.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/bootsnav.js"></script>

<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/plugins.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/main.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/alertify.min.js"></script>

<script>
    $('.single-checkbox').on('change', function() {
       if($('.single-checkbox:checked').length > 1) {
            var option1 = ((this.id).charAt((this.id).length-1)-1);
            id = 'niveles[]_'+(option1);
            var listunchecked = $(".single-checkbox:not(:checked)").length;

            for (var i = listunchecked-1; i >= 0; i--) {
                var uncheck = $(".single-checkbox:not(:checked)")[i].id;
                var uncheck_array = ((uncheck).charAt((uncheck).length-1)-1);
                document.getElementById('niveles[]_'+uncheck_array).disabled = true;
            }
       }
       else
       {
        for (var i = $('.single-checkbox').length - 1; i >= 0; i--) {
            document.getElementById('niveles[]_'+[i]).disabled = false;
        }
       }
    });

    $('.single-checkbox1').on('change', function() {
       if($('.single-checkbox1:checked').length > 2) {
            var option1 = ((this.id).charAt((this.id).length-1)-1);
            id = 'intereses[]_'+(option1);
            var listunchecked = $(".single-checkbox1:not(:checked)").length;

            for (var i = listunchecked-1; i >= 0; i--) {
                var uncheck = $(".single-checkbox1:not(:checked)")[i].id;
                var uncheck_array = ((uncheck).charAt((uncheck).length-1)-1);
                document.getElementById('intereses[]_'+uncheck_array).disabled = true;
            }
       }
       else
       {
        for (var i = $('.single-checkbox1').length - 1; i >= 0; i--) {
            document.getElementById('intereses[]_'+[i]).disabled = false;
        }
       }
    });
</script>

<script>
$('.count').each(function () {
    $(this).prop('Counter',0).animate({
        Counter: $(this).text()
    }, {
        duration: 4000,
        easing: 'swing',
        step: function (now) {
            $(this).text(Math.ceil(now));
        }
    });
});
</script>

<script>
    var correosuccess = "";
    var dnisuccess = "";
    var usernamesuccess = "";
  $(document).ready(function()
  {
    $('#username').on('keyup', function()
        {
            var value = document.getElementById('username').value;
            if (value != "")
            {
                $.ajax({
                    type: "GET",
                        url: "validacion-campos.php?value=" +value+ "&id_input=1",
                        dataType:'JSON',
                        success:function(response){
                            if (response.condicion == 1) 
                                {
                                    document.getElementById('username').style.borderColor = "red";
                                    document.getElementById('usernameHelp').innerHTML = "El usuario ingresado ya existe";
                                    usernamesuccess = 0;
                                    if (document.getElementById('terminos').checked == false || usernamesuccess == 0 || correosuccess == 0 || dnisuccess == 0) 
                                    {
                                        document.getElementById('button-save').disabled = true;
                                    }
                                }
                                else
                                {
                                    document.getElementById('username').style.borderColor = "";
                                    document.getElementById('usernameHelp').innerHTML = "";
                                    usernamesuccess = 1;
                                    if (document.getElementById('terminos').checked == true && usernamesuccess == 1 && correosuccess == 1 && dnisuccess == 1) 
                                    {
                                        document.getElementById('button-save').disabled = false;
                                    }
                                }
                                
                    }
                })
            }
            else
            {
                document.getElementById('username').style.borderColor = "";
                document.getElementById('usernameHelp').innerHTML = "";
            }
        })

    $('#correo').on('keyup', function()
        {
            var value = document.getElementById('correo').value;
            if (value != "")
            {
                $.ajax({
                    type: "GET",
                        url: "validacion-campos.php?value=" +value+ "&id_input=2",
                        dataType:'JSON',
                        success:function(response){
                            if (response.condicion == 1) 
                                {
                                    document.getElementById('correo').style.borderColor = "red";
                                    document.getElementById('correoHelp').innerHTML = "El correo ingresado ya existe";
                                    correosuccess = 0;
                                    if (document.getElementById('terminos').checked == false || usernamesuccess == 0 || correosuccess == 0 || dnisuccess == 0) 
                                    {
                                        document.getElementById('button-save').disabled = true;
                                    }
                                }
                                else
                                {
                                    document.getElementById('correo').style.borderColor = "";
                                    document.getElementById('correoHelp').innerHTML = "";
                                    correosuccess = 1;
                                    if (document.getElementById('terminos').checked == true && usernamesuccess == 1 && correosuccess == 1 && dnisuccess == 1) 
                                    {
                                        document.getElementById('button-save').disabled = false;
                                    }
                                }
                                
                    }
                })
            }
            else
            {
                document.getElementById('correo').style.borderColor = "";
                document.getElementById('correoHelp').innerHTML = "";
            }
        })

    $('#dni').on('keyup', function()
        {
            var value = document.getElementById('dni').value;
            if (value != "")
            {
                $.ajax({
                    type: "GET",
                        url: "validacion-campos.php?value=" +value+ "&id_input=3",
                        dataType:'JSON',
                        success:function(response){
                            if (response.condicion == 1) 
                                {
                                    document.getElementById('dni').style.borderColor = "red";
                                    document.getElementById('dniHelp').innerHTML = "El dni ingresado ya existe";
                                    dnisuccess = 0;
                                    if (document.getElementById('terminos').checked == false || usernamesuccess == 0 || correosuccess == 0 || dnisuccess == 0) 
                                    {
                                        document.getElementById('button-save').disabled = true;
                                    }
                                }
                                else
                                {
                                    document.getElementById('dni').style.borderColor = "";
                                    document.getElementById('dniHelp').innerHTML = "";
                                    dnisuccess = 1;
                                    if (document.getElementById('terminos').checked == true && usernamesuccess == 1 && correosuccess == 1 && dnisuccess == 1) 
                                    {
                                        document.getElementById('button-save').disabled = false;
                                    }
                                }
                                
                    }
                })
            }
            else
            {
                document.getElementById('dni').style.borderColor = "";
                document.getElementById('dniHelp').innerHTML = "";
            }
        })
    })


</script>

<script>
    var correosuccess_emp = "";
    var dnisuccess_emp = "";
    var usernamesuccess_emp = "";
    var name_emp = "";
  $(document).ready(function()
  {
    $('#emp_username').on('keyup', function()
        {
            var value = document.getElementById('emp_username').value;
            if (value != "")
            {
                $.ajax({
                    type: "GET",
                        url: "validacion-campos.php?value=" +value+ "&id_input=1",
                        dataType:'JSON',
                        success:function(response){
                            if (response.condicion == 1) 
                                {
                                    document.getElementById('emp_username').style.borderColor = "red";
                                    document.getElementById('username_empHelp').innerHTML = "El usuario ingresado está en uso";
                                    usernamesuccess_emp = 0;
                                    if (document.getElementById('terminos_emp').checked == false || name_emp == 0 || usernamesuccess_emp == 0 || correosuccess_emp == 0 || dnisuccess_emp == 0) 
                                    {
                                        document.getElementById('button-save-emp').disabled = true;
                                    }
                                }
                                else
                                {
                                    document.getElementById('emp_username').style.borderColor = "";
                                    document.getElementById('username_empHelp').innerHTML = "";
                                    usernamesuccess_emp = 1;
                                    if (document.getElementById('terminos_emp').checked == true && name_emp == 1 && usernamesuccess_emp == 1 && correosuccess_emp == 1 && dnisuccess_emp == 1) 
                                    {
                                        document.getElementById('button-save-emp').disabled = false;
                                    }
                                }
                                
                    }
                })
            }
            else
            {
                document.getElementById('emp_username').style.borderColor = "";
                document.getElementById('username_empHelp').innerHTML = "";
            }
        })

    $('#emp_correo').on('keyup', function()
        {
            var value = document.getElementById('emp_correo').value;
            if (value != "")
            {
                $.ajax({
                    type: "GET",
                        url: "validacion-campos.php?value=" +value+ "&id_input=2",
                        dataType:'JSON',
                        success:function(response){
                            if (response.condicion == 1) 
                                {
                                    document.getElementById('emp_correo').style.borderColor = "red";
                                    document.getElementById('correo_empHelp').innerHTML = "El correo ingresado ya existe";
                                    correosuccess_emp = 0;
                                    if (document.getElementById('terminos_emp').checked == false || name_emp == 0 || usernamesuccess_emp == 0 || correosuccess_emp == 0 || dnisuccess_emp == 0) 
                                    {
                                        document.getElementById('button-save-emp').disabled = true;
                                    }
                                }
                                else
                                {
                                    document.getElementById('emp_correo').style.borderColor = "";
                                    document.getElementById('correo_empHelp').innerHTML = "";
                                    correosuccess_emp = 1;
                                    if (document.getElementById('terminos_emp').checked == true && name_emp == 1 && usernamesuccess_emp == 1 && correosuccess_emp == 1 && dnisuccess_emp == 1) 
                                    {
                                        document.getElementById('button-save-emp').disabled = false;
                                    }
                                }
                                
                    }
                })
            }
            else
            {
                document.getElementById('emp_correo').style.borderColor = "";
                document.getElementById('correo_empHelp').innerHTML = "";
            }
        })

    $('#emp_cedula').on('keyup', function()
        {
            var value = document.getElementById('emp_cedula').value;
            if (value != "")
            {
                $.ajax({
                    type: "GET",
                        url: "validacion-campos.php?value=" +value+ "&id_input=3",
                        dataType:'JSON',
                        success:function(response){
                            if (response.condicion == 1) 
                                {
                                    document.getElementById('emp_cedula').style.borderColor = "red";
                                    document.getElementById('ruc_empHelp').innerHTML = "El dni ingresado ya existe";
                                    dnisuccess_emp = 0;
                                    if (document.getElementById('terminos_emp').checked == false  || name_emp == 0 || usernamesuccess_emp == 0 || correosuccess_emp == 0 || dnisuccess_emp == 0) 
                                    {
                                        document.getElementById('button-save').disabled = true;
                                    }
                                }
                                else
                                {
                                    document.getElementById('emp_cedula').style.borderColor = "";
                                    document.getElementById('ruc_empHelp').innerHTML = "";
                                    dnisuccess_emp = 1;
                                    if (document.getElementById('terminos_emp').checked == true && name_emp == 1 && usernamesuccess_emp == 1 && correosuccess_emp == 1 && dnisuccess_emp == 1) 
                                    {
                                        document.getElementById('button-save-emp').disabled = false;
                                    }
                                }
                                
                    }
                })
            }
            else
            {
                document.getElementById('emp_cedula').style.borderColor = "";
                document.getElementById('ruc_empHelp').innerHTML = "";
            }
        })

    $('#emp_nempresa').on('keyup', function()
        {
            var value = document.getElementById('emp_nempresa').value;
            if (value != "")
            {
                $.ajax({
                    type: "GET",
                        url: "validacion-campos.php?value=" +value+ "&id_input=4",
                        dataType:'JSON',
                        success:function(response){
                            if (response.condicion == 1) 
                                {
                                    document.getElementById('emp_nempresa').style.borderColor = "red";
                                    document.getElementById('name_empHelp').innerHTML = "El nombre esta en uso";
                                    name_emp = 0;
                                    if (document.getElementById('terminos_emp').checked == false  || name_emp == 0 || usernamesuccess_emp == 0 || correosuccess_emp == 0 || dnisuccess_emp == 0) 
                                    {
                                        document.getElementById('button-save').disabled = true;
                                    }
                                }
                                else
                                {
                                    document.getElementById('emp_nempresa').style.borderColor = "";
                                    document.getElementById('name_empHelp').innerHTML = "";
                                    name_emp = 1;
                                    if (document.getElementById('terminos_emp').checked == true && name_emp == 1 && usernamesuccess_emp == 1 && correosuccess_emp == 1 && dnisuccess_emp == 1) 
                                    {
                                        document.getElementById('button-save-emp').disabled = false;
                                    }
                                }
                                
                    }
                })
            }
            else
            {
                document.getElementById('emp_nempresa').style.borderColor = "";
                document.getElementById('name_empHelp').innerHTML = "";
            }
        })

    $('#terminos').on('change', function()
        {
            if (document.getElementById('terminos').checked == true && usernamesuccess == 1 && correosuccess == 1 && dnisuccess == 1)
            {
                document.getElementById('button-save').disabled = false;
            }
            else
                if (document.getElementById('terminos').checked == false || usernamesuccess == 0 || correosuccess == 0 || dnisuccess == 0)
            {
                 document.getElementById('button-save').disabled = true;
            }
        })
    $('#terminos_emp').on('change', function()
        {
            if (document.getElementById('terminos_emp').checked == true && name_emp == 1 && usernamesuccess_emp == 1 && correosuccess_emp == 1 && dnisuccess_emp == 1)
            {
                document.getElementById('button-save-emp').disabled = false;
            }
            else
                if (document.getElementById('terminos_emp').checked == false || name_emp == 0 || usernamesuccess_emp == 0 || correosuccess_emp == 0 || dnisuccess_emp == 0)
            {
                 document.getElementById('button-save-emp').disabled = true;
            }
        })
    })


</script>

<script>
    $('#myModal').on('hidden.bs.modal', function () {
        $("#form_candidato")[0].reset();
        var text = document.getElementsByTagName('SMALL');
        var input = document.getElementsByTagName('INPUT');
        for (var i = text.length - 1; i >= 0; i--) {
            text[i].innerHTML = "";
        }
        for (var i = input.length - 1; i >= 0; i--) {
            input[i].style.borderColor = "";
        }
        document.getElementById('verify_check').style.display = "none";
    })
</script>

<script>
    $('#myModal2').on('hidden.bs.modal', function () {
        $("#form_empresa")[0].reset();
        var text = document.getElementsByTagName('SMALL');
        var input = document.getElementsByTagName('INPUT');
        for (var i = text.length - 1; i >= 0; i--) {
            text[i].innerHTML = "";
        }
        for (var i = input.length - 1; i >= 0; i--) {
            input[i].style.borderColor = "";
        }
    })
</script>

<script>
    $(document).ready(function()
    {
        var sessionlogin = document.getElementById('sessionvar').value;
      if(sessionlogin == "")
      {
        if(!!window.performance && window.performance.navigation.type === 2)
            {
                $('#myModal').modal('show');
            }
      } 
    })
    //Reload page if page is back
        
</script>
<script src="assets/js/bootstrap-show-password.min.js"></script>


<script type="text/javascript">
    $('#provincia').on('change', function()
    {
        var selected = document.getElementById('provincia');
        var id_ciudad = selected[selected.selectedIndex].id;
        if (id_ciudad)
        {
            $.ajax({
                type: "GET",
                url: "select_ciudades.php?id="+id_ciudad,
                success:function(html){
                    $('#ciudad').html(html);

                    },
                 error: function (request, status, error) {
                    alert(request.responseText);
                }                  
            })
        }
        else
        {
            $('#ciudad').html('<option>Selecciona una provincia primero</option>');
        }
    })

    $('#provincia_emp').on('change', function()
    {
        var selected = document.getElementById('provincia_emp');
        var id_ciudad = selected[selected.selectedIndex].id;
        if (id_ciudad)
        {
            $.ajax({
                type: "GET",
                url: "select_ciudades.php?id="+id_ciudad,
                success:function(html){
                    $('#ciudad_emp').html(html);

                    },
                 error: function (request, status, error) {
                    alert(request.responseText);
                }                  
            })
        }
        else
        {
            $('#ciudad_emp').html('<option>Selecciona una provincia primero</option>');
        }
    })
</script>

<script type="text/javascript">
    $('#estudiante_promo').on('change', function()
    {
        if (this.checked == true)
        {
            $('#university_user').attr('required', true);
            $('#code_asign').attr('required', true);
            $( ".animate_panel" ).fadeIn("slow");
        }
        else
        {
            $('#university_user').attr('required', false);
            $('#code_asign').attr('required', false);
            document.getElementById('form_student').style.display ="none";
        }
    })
</script>

<script type="text/javascript">
    $(document).ready(function()
    {
        $('#modal_registro').modal('show');
    })
</script>

<!--mensajes de error y exito-->
<?php if (isset($sess_err_msg) && !empty($sess_err_msg)){?>
  <div align="center" id="alerta" style="display:" class="alert alert-danger alert-dismissible">
    <?php echo $sess_err_msg;?>
  </div>  
<?php }?>

<?php if (isset($sess_suc_msg) && !empty($sess_suc_msg)){?>
  <div align="center" id="alerta" style="display:" class="alert alert-success alert-dismissible">
    <?php echo $sess_suc_msg;?>
  </div>  
<?php }?>

    </body>
</html>

<br><br>

<section id="action" class="action bg-primary roomy-40" style="background-color: #03a9f4;">
                <div class="container">
                    <div class="row">
                        <div class="maine_action">
                            <div class="col-md-4">
                                <div class="action_item text-center">
                                    
                                </div>
                            </div>
                            <div class="col-md-8" align="right">
                               
                                <div style="margin-top: 13px">
                                     NECESITA AYUDA? ESCRÍBANOS: &nbsp;&nbsp;&nbsp;
                                    <i class="far fa-envelope"></i>
                                    <a style="color: #fff;">info@micamello.com.ec</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <!--<a href="form-sug.php" style="color: white; text-decoration: underline;"><b>Recomendaciones o sugerencias <i class="fa fa-focus"></i></b></a>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <footer id="contact" class="footer action-lage  p-top-80" style="background-color: #fff;">
                <!--<div class="action-lage"></div>-->
                <div class="container">
                    <div class="row" style="    margin-top: -37px;
    padding-bottom: 20px;">
                        <div class="widget_area">
                            <div class="col-md-6">
                                <div class="widget_item widget_about">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="<?php echo PUERTO."://".HOST;?>/docs/terminos_y_condiciones.pdf" target="blanked">Términos y Condiciones </a> | 
                                    <a href="<?php echo PUERTO."://".HOST;?>/docs/politicas_de_privacidad.pdf" target="blanked">Políticas de Privacidad </a> |
                                    <a href="https://www.blog.micamello.com.ec" target="blanked">Blog</a> |
                                    <a href="form-sug.php">Recomendaciones</a>
                                    
                                   
                                </div><!-- End off widget item -->
                            </div><!-- End off col-md-3 -->

                            <div class="col-md-6" >
                                <div class="widget_item widget_latest sm-m-top-50" align="left">
                                    <img src="<?php echo PUERTO."://".HOST;?>/imagenes/paises/ecu.png" style="    width: 7%;"> 
                                    <span style="color: #000;font-size: 16px;">Ecuador</span>
                                    
                                    <img src="<?php echo PUERTO."://".HOST;?>/imagenes/paises/col.png" style="    width: 7%;"> 
                                    <span style="color: #000;font-size: 16px;">Colombia</span>
                                    &nbsp;&nbsp;
                                    <img src="<?php echo PUERTO."://".HOST;?>/imagenes/paises/peru.png" style="    width: 7%;"> 
                                    <span style="color: #000;font-size: 16px;">Perú</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp; Siguenos en:
                                    
                                    <a href="https://es-la.facebook.com/MiCamello.com.ec/" target="blacked"><img src="<?php echo PUERTO."://".HOST;?>/imagenes/redes/face.png" style="    width: 5%;">
                                    <span style="color: #000;font-size: 16px;"></span></a>
                                    
                                    <a href="https://twitter.com/MiCamelloec" target="blacked"><img src="<?php echo PUERTO."://".HOST;?>/imagenes/redes/tw.png" style="    width: 5%;">
                                    <span style="color: #000;font-size: 16px;"></span></a>
                                    
                                    <a href="https://www.instagram.com/micamelloec/" target="blacked"><img src="<?php echo PUERTO."://".HOST;?>/imagenes/redes/ins.png" style="    width: 5%;">
                                    <span style="color: #000;font-size: 16px;"></span></a>

                                </div><!-- End off widget item -->
                            </div><!-- End off col-md-3 -->

                         

                        </div>
                    </div>
                </div>
               
            </footer> 
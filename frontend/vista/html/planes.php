<section id="home" class="home bg-black fix">
  <div class="overlay"></div>
  <div class="container">
    <div class="row">
      <div class="main_home text-center">
        <div class="col-md-12">
          <div class="hello_slid">
            <div class="slid_item">
              <div class="home_text ">
                <h2 class="text-white">Bienvenid@ <strong><?php echo $_SESSION['mfo_datos']['usuario']['nombres'].' '.$_SESSION['mfo_datos']['usuario']['apellidos']; ?></strong></h2>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section id="product" class="product">
  <div class="container">
    <div class="row">
      <div class="main_business">
        <div class="col-md-12">
          <form role="form" name="form1" id="form1" method="post">        
            <div class="container"><h3>Seleccione un plan:</h3></div>
            <div class="container">
              <div class="row">
                
                <a onclick="pay_plan(1);">
                  <div class="col-xs-12 col-md-4">
                    <div class="panel panel-primary">
                      <div class="panel-heading" style="background-color: #262D5D; color: #fff">
                        <h3 class="panel-title">Camellito Simple</h3>
                      </div>
                      <div class="panel-body">
                        <table align="center">
                          <tr class="aut" align="center">
                            <td><img src="images/planes/1.png" style="width: 22%;"></td>
                          </tr>
                          <tr class="aut" style="text-decoration:line-through;"><td><br>• Autopostulación</td></tr>
                          <tr class="aut" style="text-decoration:line-through;"><td>• Tercer formulario</td></tr>
                          <tr class="aut" style="text-decoration:line-through;"><td>• Alertas de Autopostulaciones</td><br></tr>
                          <tr class="aut" style="text-decoration:line-through;"><td>• Informe de personalidad parcial certificado a &nbsp;&nbsp;&nbsp;la empresa</td></tr>
                          <tr class="aut"><td>• Visibilidad ofertas de trabajo</td></tr>
                          <tr class="aut"><td>• Postulación o vacantes</td></tr>
                          <tr class="aut"><td>• Búsqueda ofertas de trabajo</td></tr>
                          <tr class="aut"><td><!--<b>-->• Cargar hoja de vida<!--</b>--></td></tr>
                          <tr align="center">
                            <td><br><br>
                              <h1 style="text-decoration:line-through;">$0<span class="subscript"></span></h1>
                              <a class="btn btn-success">Suscribirse</a>
                            </td>
                          </tr>
                        </table>
                      </div>               
                    </div>
                  </div>
                </a>        
              </div>
            </div>
          </form>
        </div>>
      </div>
    </div>
  </div>
</section>
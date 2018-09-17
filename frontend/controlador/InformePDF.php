<?php 
require_once 'includes/mpdf/mpdf.php';

class Controlador_InformePDF extends Controlador_Base
{
	public function construirPagina(){
    if(!Modelo_Usuario::estaLogueado() ){
      Utils::doRedirect(PUERTO.'://'.HOST.'/login/');
    }

    if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::EMPRESA){
      Utils::doRedirect(PUERTO.'://'.HOST.'/'); 
    }

    $opcion = Utils::getParam('opcion','',$this->data);
    switch($opcion){
      default:
      $username = "ederstyle1994";
        $this->generarPDF($username);
      break;
    } 
  }
  // Salto de página
	// <div style='page-break-after:always;'></div>
  // Salto de página
	public function generarPDF($username){

    $parametro1 = Modelo_InformePDF::obtieneParametro(1);
    $parametro2 = Modelo_InformePDF::obtieneParametro(2);
    $datos_usuario = Modelo_Usuario::existeUsuario($username);
    Utils::log($id_usuario['nombres']);
    $introduccion = str_replace("_saltoLinea_", "<br><br>", $parametro1['descripcion']);
    $caracteristicas_esp = str_replace("_nombreAspirante_", $datos_usuario['nombres'], $parametro2['descripcion']);
    Utils::log($introduccion);
    $cabecera = "imagenes/pdf/header.png";
    $piepagina = "imagenes/pdf/footer.png";
		$formato = "<style>
        header
        {padding: -34px 0px 0px -57px;}
        main{margin: 55px;padding: 10px;}
        footer{padding-bottom: -34px;padding-right: -57px;text-align: right;}
        .titulo_1{text-align: center;}
        .text_justify{text-align: justify;}
        </style>
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet'>
        <body>
	        <main>
          <h3 class='titulo_1'>Introducción</h3><br>
	        <p class='text_justify'>".
            utf8_encode($introduccion)
            ."
          </p>
          <div style='page-break-after:always;'></div>
          <br>
          <h3 class='titulo_1'>Características específicas del candidato</h3>
          <p class='text_justify'>".
            utf8_encode($caracteristicas_esp)
            ."
          </p>
	        </main>
    	</body>";

		$mpdf=new mPDF();
	    $mpdf->setHTMLHeader('<header><img src="'.$cabecera.'" width="17%"></header>');
	    $mpdf->setHTMLFooter('<footer><img src="'.$piepagina.'" width="17%"></footer>');
	    $mpdf->WriteHTML($formato);
	    $mpdf->Output();
      // Descargar parametro del Output
      // 'filename.pdf', 'D'
	    exit;
	}
}

 ?>
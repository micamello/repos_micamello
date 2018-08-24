<?php 

foreach ($data as $letra => $value) { 
 
    echo '<a href="'.PUERTO.'://'.HOST.'/oferta/2';
    if($letra == 'A'){
        echo '/A'.$value['id'];
    }
    if($letra == 'P'){
        echo '/P'.$value['id'];
    }
    if($letra == 'J'){
        echo '/J'.$value['id'];
    }
    if($letra == 'C'){
        echo '/C'.$value['id'];
    }
    echo '/'.$page.'/" class="col-xs-12 col-md-3 btn-filtro">'.utf8_encode(ucfirst(strtolower($value['nombre']))).'<i class="fa fa-times click"></i></a>';

} ?>
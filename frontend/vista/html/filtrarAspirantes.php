<?php 

foreach ($data as $letra => $value) { 
 
    echo '<a href="'.PUERTO.'://'.HOST.'/verAspirantes/'.$id_oferta.'/2';
    if($letra == 'F'){
        echo '/F'.$value['id'];
    }
    if($letra == 'P'){
        echo '/P'.$value['id'];
    }
    if($letra == 'U'){
        echo '/U'.$value['id'];
    }
    if($letra == 'G'){
        echo '/G'.$value['id'];
    }
    if($letra == 'S'){
        echo '/S'.$value['id'];
    }
    echo '/'.$page.'/" class="col-xs-12 col-md-3 btn-filtro">'.utf8_encode(ucfirst(strtolower($value['nombre']))).'<i class="fa fa-times click"></i></a>';

} ?>
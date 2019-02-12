<?php 
//print_r($data);
foreach ($data as $letra => $value) { 

    $f = '';
    $ruta = PUERTO.'://'.HOST.'/filtrarEntrevistados'; 
    if($letra == 'A' && $value != 0){
        $ruta .= '/A'.$value['id'];
        $f = 1;
    }

    if($letra == 'E' && $value != 0){
        $ruta .= '/E'.$value['id'];
        $f = 1;
    }

    if($letra == 'F' && $value != 0){
        $ruta .= '/F'.$value['id'];
        $f = 1;
    }

    if($letra == 'C' && $value != 0){
        $ruta .= '/C'.$value['id'];
        $f = 1;
    }

    if($letra == 'R' && $value != 0){
        $ruta .= '/R'.$value['id'];
        $f = 1;
    }

    if($letra == 'H' && !empty($value)){

        $competencias = $value;

        $r = '';
        foreach ($competencias as $key => $value) {

            $r = '/H'.$value['id'];
            $valores = "'".$ruta.$r."/2/'";
            echo '<div class="col-xs-12 col-md-3 btn-filtro">
                <div class="input-group">
                    <span>'.utf8_encode(ucwords(strtolower($value['nombre']))).'</span>
                    <span class="input-group-addon btn-filtro" style="padding:0px; cursor:pointer;">
                        <p onclick="enviarPclave('.$valores.')"><i style="font-size:20px;" class="fa fa-window-close"></i>
                        </p>
                    </span>
                </div>
            </div>';
        }
    }

    if($letra == 'N' && $value != 0){
        $ruta .= '/N'.$value['id'];
        $f = 1;
    }

    if($letra == 'P' && $value != 0){
        $ruta .= '/P'.$value['id'];
        $f = 1;
    }

    if($letra == 'O' && $value != 0){
        $ruta .= '/O'.$value['id'];
        $f = 1;
    }

    if($letra == 'G' && $value != 0){
        $ruta .= '/G'.$value['id'];
        $f = 1;
    }
    
    if($f != '' && $letra != 'H'){
        $valores = "'".$ruta."/2/'";
        echo '<div class="col-xs-12 col-md-3 btn-filtro">
            <div class="input-group">
                <span>'.utf8_encode(ucwords(strtolower($value['nombre']))).'</span>
                <span class="input-group-addon btn-filtro" style="padding:0px; cursor:pointer;">
                    <p onclick="enviarPclave('.$valores.')"><i style="font-size:20px;" class="fa fa-window-close"></i>
                    </p>
                </span>
            </div>
        </div>';
    }
} ?>

                       
<?php 
$i = 0;
foreach ($data as $letra => $value) { 

    if($letra != 'O'){
        $i++;
        $ruta = PUERTO.'://'.HOST.'/'.$vista.'/2'; 
        if($letra == 'A'){
            $ruta .= '/A'.$value['id'];
        }
        if($letra == 'P'){
            $ruta .= '/P'.$value['id'];
        }
        if($letra == 'J'){
            $ruta .= '/J'.$value['id'];
        }
        if($letra == 'S'){
            $ruta .= '/S'.$value['id'];
        }
        if($letra == 'K'){
            $ruta .= '/K'.$value['id'];
        }
        if($letra == 'Q'){
            $ruta .= '/Q'.$value['id'];
        }

        $valores = "'".$ruta."/',2,".$page;
        echo '<div id="btn-filtro-1" class="col-xs-12 col-md-4 btn-filtro">
            <div class="input-group">
                <span>'.utf8_encode(ucfirst(strtolower($value['nombre']))).'</span>
                <span id="icono-filtro" class="input-group-addon" style="padding:0px; cursor:pointer;">
                    <p onclick="enviarPclave('.$valores.')"><i style="font-size:20px;" class="fa fa-window-close"></i>
                    </p>
                </span>
            </div>
        </div>';

        if($i == 3){
            echo '<div class="clearfix"></div>';
            $i = 0;
        }
    }
} ?>

                       
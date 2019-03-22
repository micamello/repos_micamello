<?php 

foreach ($data as $letra => $value) { 

    if($letra != 'O' /*&& $letra != 'F'*/){
        
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
        echo '<div class="col-xs-12 col-md-3 btn-filtro">
            <div class="input-group">
                <span>'.utf8_encode(ucfirst(strtolower($value['nombre']))).'</span>
                <span class="input-group-addon btn-filtro" style="padding:0px; cursor:pointer;">
                    <p onclick="enviarPclave('.$valores.')"><i style="font-size:20px;" class="fa fa-window-close"></i>
                    </p>
                </span>
            </div>
        </div>';
    }
} ?>

                       
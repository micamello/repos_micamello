<?php 

foreach ($data as $letra => $value) { 

    if($letra != 'O'){

        $ruta = PUERTO.'://'.HOST.'/verAspirantes/'.$id_oferta.'/2';
        if($letra == 'F'){
            $ruta .= '/F'.$value['id'];
        }
        if($letra == 'P'){
            $ruta .= '/P'.$value['id'];
        }
        if($letra == 'U'){
            $ruta .= '/U'.$value['id'];
        }
        if($letra == 'G'){
            $ruta .= '/G'.$value['id'];
        }
        if($letra == 'S'){
            $ruta .= '/S'.$value['id'];
        }
        if($letra == 'N'){
            $ruta .= '/N'.$value['id'];
        }
        if($letra == 'E'){
            $ruta .= '/E'.$value['id'];
        }
        if($letra == 'Q'){
            $ruta .= '/Q'.$value['id'];
        }

        $valores = "'".$ruta."/',".$page;
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
} 

?>
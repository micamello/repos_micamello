<?php 

foreach ($data as $letra => $value) { 

    if($vista == 1){
        $ruta = PUERTO.'://'.HOST.'/verAspirantes/1/'.$id_oferta.'/2';
    }else{
        $ruta = PUERTO.'://'.HOST.'/verAspirantes/2/'.Utils::encriptar(0).'/2';
    }

    if($letra != 'O'){

        if($letra == 'F'){
            $ruta .= '/F'.$value['id'];
        }
        if($letra == 'A'){
            $ruta .= '/A'.$value['id'];
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
        if($letra == 'D'){
            $ruta .= '/D'.$value['id'];
        }
        if($letra == 'L'){
            $ruta .= '/L'.$value['id'];
        }
        if($letra == 'T'){
            $ruta .= '/T'.$value['id'];
        }
        if($letra == 'V'){
            $ruta .= '/V'.$value['id'];
        }
        if($letra == 'R'){
            $ruta .= '/R'.$value['id'];
        }
        if($letra == 'Q'){
            $ruta .= '/Q'.$value['id'];
        }

        $valores = "'".$ruta."/',2,1";

        if($letra == 'R'){
            
            $exp = '/';
            $a = 0; 
            $literales = array();
            foreach ($facetas as $key => $c) {

                $letra = substr($c,0,1);
                if($letra == 'A' && $a > 1){
                    $letra = 'P';
                }
                $pos = strstr($value['id'], $letra);
                if($pos !== false){

                    $exp .= '('.$letra.'[0-9]{1,3})';
                    $literales[$letra] = $c;
                }
                $a++;
            }
            $exp .= '/';

            preg_match_all($exp,$value['id'],$salida, PREG_PATTERN_ORDER);
            unset($salida[0]);
            echo '<div class="col-xs-12 col-md-12';
            echo ' btn-filtro">
            <div class="input-group">
                <span>';
            foreach ($salida as $key => $value) {
                $l = substr($value[0],0,1);
                $i = substr($value[0],1);
                echo $literales[$l].': '.$i.'%&nbsp;&nbsp;';
            }
            echo '</span>
                    <span class="input-group-addon btn-filtro" style="padding:0px; cursor:pointer;">
                        <p onclick="enviarPclave('.$valores.')"><i style="font-size:20px;" class="fa fa-window-close"></i>
                        </p>
                    </span>
                </div>
            </div>';
            
        }else{

            echo '<div class="col-xs-12 col-md-4 btn-filtro">
            <div class="input-group">
                <span>';
            if($letra == 'D'){
                if($value['id'] == 1){
                    echo 'Discapacidad';
                }else{
                    echo 'Sin discapacidad';
                }
            }else if($letra == 'L'){
                if($value['id'] == 1){
                    echo 'Tiene licencia';
                }else{
                    echo 'Sin licencia';
                }
            }else if($letra == 'T'){
                if($value['id'] == 1){
                    echo 'Tiene trabajo';
                }else{
                    echo 'Sin trabajo';
                }
            }else if($letra == 'V'){
                if($value['id'] == 1){
                    echo 'Puede viajar';
                }else{
                    echo 'No puede viajar';
                }
            }else{
                echo utf8_encode(ucfirst(strtolower($value['nombre'])));
            }
            echo '</span>
                    <span class="input-group-addon btn-filtro" style="padding:0px; cursor:pointer;">
                        <p onclick="enviarPclave('.$valores.')"><i style="font-size:20px;" class="fa fa-window-close"></i>
                        </p>
                    </span>
                </div>
            </div>';
        }
    }
} 

?>
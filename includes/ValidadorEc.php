<?php
class ValidadorEc
{
    public static function DniRuc_Validador($numero){
        
        if(!empty($numero)){
            if(strlen($numero) == 10){
                return self::validarCedulaEcuador($numero);
            }

            if(strlen($numero) == 13){
                if(self::validarRucPersonaNatural($numero) ||self::validarRucPersonaJuridica($numero) ||self::validarRucInstitucionPublica($numero)){
                    return true;
                }
                else{
                    return false;
                }
            }
        }
    }

    public static function validarCedulaEcuador($numero){
        $digitos = array();
        $consecutivo = array();
        $provincia = substr($numero, 0, 2);
        $resultado = 0;
        $digitoVer = 0;
        $digitoVerComparar = 0;
        // print_r($provincia);
        if($provincia >=1 && $provincia <= 24 || $provincia == 30){
            $digitos[0] = substr($numero, 0, 1);
            $digitos[1] = substr($numero, 1, 1);
            $digitos[2] = substr($numero, 2, 1);
            $digitos[3] = substr($numero, 3, 1);
            $digitos[4] = substr($numero, 4, 1);
            $digitos[5] = substr($numero, 5, 1);
            $digitos[6] = substr($numero, 6, 1);
            $digitos[7] = substr($numero, 7, 1);
            $digitos[8] = substr($numero, 8, 1);
            $digitos[9] = substr($numero, 9, 1);

                $consecutivo[0] = ($digitos[0]) * 2; if($consecutivo[0] > 9) $consecutivo[0] -= 9;       
                $consecutivo[1] = ($digitos[1]) * 1;         
                $consecutivo[2] = ($digitos[2]) * 2; if($consecutivo[2] > 9) $consecutivo[2] -= 9;         
                $consecutivo[3] = ($digitos[3]) * 1;         
                $consecutivo[4] = ($digitos[4]) * 2; if($consecutivo[4] > 9) $consecutivo[4] -= 9;         
                $consecutivo[5] = ($digitos[5]) * 1;         
                $consecutivo[6] = ($digitos[6]) * 2; if($consecutivo[6] > 9) $consecutivo[6] -= 9;         
                $consecutivo[7] = ($digitos[7]) * 1;        
                $consecutivo[8] = ($digitos[8]) * 2; if($consecutivo[8] > 9) $consecutivo[8] -= 9;
                for ($i=0; $i < count($consecutivo); $i++) { 
                    $resultado += $consecutivo[$i];
                }
        }
        $digitoVer = $resultado%10;
        if($digitoVer == 0){
                $digitoVerComparar = $digitoVer;
        }
        else{
            $digitoVerComparar = 10 - $digitoVer;
        }
        // print_r("<br>. ".$digitoVerComparar ."==". $digitos[9]);
        if($digitoVerComparar == $digitos[9]){
            // print_r("eder");
            return true;
        }
        else{
            return false;
        }
    }

    public static function validarRucPersonaNatural($numero){
        $digitos = array();
        $consecutivo = array();
        $provincia = substr($numero, 0, 2);
        $resultado = 0;
        $digitoVer = 0;
        $digitoVerComparar = 0;
        if($provincia >=1 && $provincia <= 24 || $provincia == 30){
            $digitos[0] = substr($numero, 0, 1);
            $digitos[1] = substr($numero, 1, 1);
            $digitos[2] = substr($numero, 2, 1);
            $digitos[3] = substr($numero, 3, 1);
            $digitos[4] = substr($numero, 4, 1);
            $digitos[5] = substr($numero, 5, 1);
            $digitos[6] = substr($numero, 6, 1);
            $digitos[7] = substr($numero, 7, 1);
            $digitos[8] = substr($numero, 8, 1);
            $digitos[9] = substr($numero, 9, 1);

                $consecutivo[0] = ($digitos[0]) * 2; if($consecutivo[0] > 9) $consecutivo[0] -= 9;       
                $consecutivo[1] = ($digitos[1]) * 1;         
                $consecutivo[2] = ($digitos[2]) * 2; if($consecutivo[2] > 9) $consecutivo[2] -= 9;         
                $consecutivo[3] = ($digitos[3]) * 1;         
                $consecutivo[4] = ($digitos[4]) * 2; if($consecutivo[4] > 9) $consecutivo[4] -= 9;         
                $consecutivo[5] = ($digitos[5]) * 1;         
                $consecutivo[6] = ($digitos[6]) * 2; if($consecutivo[6] > 9) $consecutivo[6] -= 9;         
                $consecutivo[7] = ($digitos[7]) * 1;        
                $consecutivo[8] = ($digitos[8]) * 2; if($consecutivo[8] > 9) $consecutivo[8] -= 9;
                for ($i=0; $i < count($consecutivo); $i++) { 
                    $resultado += $consecutivo[$i];
                }
        }
        $digitoVer = $resultado%10;
        if($digitoVer == 0){
                $digitoVerComparar = $digitoVer;
        }
        else{
            $digitoVerComparar = 10 - $digitoVer;
        }
        if($digitoVerComparar == $digitos[9] && substr($numero, 10, 3) == "001"){
            return true;
        }
        else{
            return false;
        }
    }

    public static function validarRucPersonaJuridica($numero){
        $digitos = array();
        $consecutivo = array();
        $provincia = substr($numero, 0, 2);
        if($provincia >= 1 && $provincia <= 24){
            $digitos[0]  = substr($numero,0,1);         
            $digitos[1]  = substr($numero,1,1);         
            $digitos[2]  = substr($numero,2,1);         
            $digitos[3]  = substr($numero,3,1);         
            $digitos[4]  = substr($numero,4,1);         
            $digitos[5]  = substr($numero,5,1);         
            $digitos[6]  = substr($numero,6,1);         
            $digitos[7]  = substr($numero,7,1);         
            $digitos[8]  = substr($numero,8,1);         
            $digitos[9]  = substr($numero,9,1);
            $digitos[10]  = substr($numero,10,1);
            $digitos[11]  = substr($numero,11,1);
            $digitos[12]  = substr($numero,12,1);

            if($digitos[2] == 9){
                $consecutivo[0] = ($digitos[0]) * 4;       
                $consecutivo[1] = ($digitos[1]) * 3;         
                $consecutivo[2] = ($digitos[2]) * 2;         
                $consecutivo[3] = ($digitos[3]) * 7;         
                $consecutivo[4] = ($digitos[4]) * 6;         
                $consecutivo[5] = ($digitos[5]) * 5;         
                $consecutivo[6] = ($digitos[6]) * 4;         
                $consecutivo[7] = ($digitos[7]) * 3;        
                $consecutivo[8] = ($digitos[8]) * 2;
                $resultado = 0;
                for ($i = 0; $i < count($consecutivo); $i++) {
                    $resultado += $consecutivo[$i];
                }
                $digitoVer = $resultado%11;
                if($digitoVer == 0){
                    $digitoVerComparar = $digitoVer;
                }
                else{
                    $digitoVerComparar = 11 - $digitoVer;
                }
                if($digitoVerComparar == $digitos[9] && substr($numero, 10, 3) == "001"){
                    return true;
                }
                else{
                    return false;
                }
            }
        }
    }

    public static function validarRucInstitucionPublica($numero){
        $digitos = array();
        $consecutivo = array();
        $provincia = substr($numero, 0, 2);
        if($provincia >= 1 && $provincia <= 24){
            $digitos[0]  = substr($numero,0,1);         
            $digitos[1]  = substr($numero,1,1);         
            $digitos[2]  = substr($numero,2,1);         
            $digitos[3]  = substr($numero,3,1);         
            $digitos[4]  = substr($numero,4,1);         
            $digitos[5]  = substr($numero,5,1);         
            $digitos[6]  = substr($numero,6,1);         
            $digitos[7]  = substr($numero,7,1);         
            $digitos[8]  = substr($numero,8,1);         
            $digitos[9]  = substr($numero,9,1);
            $digitos[10]  = substr($numero,10,1);
            $digitos[11]  = substr($numero,11,1);
            $digitos[12]  = substr($numero,12,1);

            if($digitos[2] == 6){
                $consecutivo[0] = ($digitos[0]) * 3;       
                $consecutivo[1] = ($digitos[1]) * 2;         
                $consecutivo[2] = ($digitos[2]) * 7;         
                $consecutivo[3] = ($digitos[3]) * 6;         
                $consecutivo[4] = ($digitos[4]) * 5;         
                $consecutivo[5] = ($digitos[5]) * 4;         
                $consecutivo[6] = ($digitos[6]) * 3;         
                $consecutivo[7] = ($digitos[7]) * 2;
                $resultado = 0;
                for ($i = 0; $i < count($consecutivo); $i++) {
                    $resultado += $consecutivo[$i];
                }
                $digitoVer = $resultado%11;
                if($digitoVer == 0){
                    $digitoVerComparar = $digitoVer;
                }
                else{
                    $digitoVerComparar = 11 - $digitoVer;
                }
                if($digitoVerComparar == $digitos[8] && substr($numero, 10, 3) == "001" && $digitos[9] == 0){
                    return true;
                }
                else{
                    return false;
                }
            }
        }
    }
}
?>
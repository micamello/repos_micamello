<?php
class Modelo_Sucursal{
  
  public static function obtieneListado(){
    $sql = "SELECT * FROM mfo_sucursal s, mfo_pais p WHERE s.id_pais = p.id_pais AND s.estado = 1;";
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }

  public static function obtieneSucursalActual($dominio){
  	if($dominio == 'localhost'){
  		$dominio = 'micamello.com.ec';
  	}
  	$sql = "SELECT s.*, m.simbolo FROM mfo_sucursal s, mfo_moneda m WHERE s.id_moneda = m.id_moneda AND s.dominio = ?";
    return $GLOBALS['db']->auto_array($sql,array($dominio));
  }

  public static function obtieneCiudadDefault(){
    $id_pais = $_SESSION['mfo_datos']['sucursal']['id_pais'];
    $sql = "select ciu.id_ciudad id_ciudad from mfo_provincia pro, mfo_ciudad ciu where ciu.id_provincia = pro.id_provincia and pro.id_pais = ".$id_pais." limit 1;";
    return $GLOBALS['db']->auto_array($sql,array());
  }


  public static function validar_EC($dni){
    if(is_null($dni) || empty($dni)){//compruebo si que el numero enviado es vacio o null
    // echo "Por Favor Ingrese la Cedula";
    }else{//caso contrario sigo el proceso
    if(is_numeric($dni)){
    $total_caracteres=strlen($dni);// se suma el total de caracteres
    if($total_caracteres==10 || $total_caracteres==13){//compruebo que tenga 10 digitos la cedula
    $nro_region=substr($dni, 0,2);//extraigo los dos primeros caracteres de izq a der
    if($nro_region>=1 && $nro_region<=24){// compruebo a que region pertenece esta cedula//
    $ult_digito=substr($dni, 9,1);//extraigo el ultimo digito de la cedula
    //extraigo los valores pares//
    $valor2=substr($dni, 1, 1);
    $valor4=substr($dni, 3, 1);
    $valor6=substr($dni, 5, 1);
    $valor8=substr($dni, 7, 1);
    $suma_pares=($valor2 + $valor4 + $valor6 + $valor8);
    //extraigo los valores impares//
    $valor1=substr($dni, 0, 1);
    $valor1=($valor1 * 2);
    if($valor1>9){ $valor1=($valor1 - 9); }else{ }
    $valor3=substr($dni, 2, 1);
    $valor3=($valor3 * 2);
    if($valor3>9){ $valor3=($valor3 - 9); }else{ }
    $valor5=substr($dni, 4, 1);
    $valor5=($valor5 * 2);
    if($valor5>9){ $valor5=($valor5 - 9); }else{ }
    $valor7=substr($dni, 6, 1);
    $valor7=($valor7 * 2);
    if($valor7>9){ $valor7=($valor7 - 9); }else{ }
    $valor9=substr($dni, 8, 1);
    $valor9=($valor9 * 2);
    if($valor9>9){ $valor9=($valor9 - 9); }else{ }

    $suma_impares=($valor1 + $valor3 + $valor5 + $valor7 + $valor9);
    $suma=($suma_pares + $suma_impares);
    $dis=substr($suma, 0,1);//extraigo el primer numero de la suma
    $dis=(($dis + 1)* 10);//luego ese numero lo multiplico x 10, consiguiendo asi la decena inmediata superior
    $digito=($dis - $suma);
    if($digito==10){ $digito='0'; }else{ }//si la suma nos resulta 10, el decimo digito es cero
    if ($digito==$ult_digito){//comparo los digitos final y ultimo
      $caracteres = "";
    if ($total_caracteres == 13) {
        $caracteres = substr($dni,-3);
        if ($caracteres == "001") {
           return true;
         }
         else
         {
          return false;
         }
      }
        return true;
    }else{
      return false;
    }
    }else{
    return false;
    }
    }else{
    return false;
    }
    }else{
    return false;
    }
    }
    }
}  
?>

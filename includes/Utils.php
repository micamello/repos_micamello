<?php
class Utils{
 
  static public function log($msg,$bypass=false){
    $filename = dirname(__FILE__). "/log.txt";
    $fd = fopen($filename, "a");
    $str = "[" . date("Y/m/d h:i:s") . "] " . $msg;  
    fwrite($fd, $str . "\n");
    fclose($fd);
  }
  
  static public function getParam($paramName, $default=false, $data=false){
    global $_SUBMIT;
    if(!$data){
      $data = $_SUBMIT;
    }
    if (is_array($data)){      
      if(isset($data[$paramName]) ){         
        return $data[$paramName];                       
      }
    }
    return $default;
  }
  
  static public function createSession(){           
    Utils::log(__METHOD__ . " empezo una nueva sesion");
    session_name('mfo_datos');
    session_start();      
  } 
 
  static public function getArrayParam($paramName,$array, $default=false){
    if(is_array($array)){
      if(isset($array[$paramName])){
        return $array[$paramName];
      }
    }
    return $default;
  }
 
  static public function doRedirect( $goto ){
    $GLOBALS['db']->close();
    header("Location: ".$goto);
    exit;
  }
  
  static public function es_correo_valido($email){
    $result = preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix",$email);
    return $result;
  }
  public static function envioCorreo($to, $subject, $body){
    self::log($to.$subject.$body);
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->CharSet = 'UTF-8';
    $mail->Port = MAIL_PORT; 
    $mail->Host = MAIL_HOST; 
    $mail->Username = MAIL_USERNAME; 
    $mail->Password = MAIL_PASSWORD;     
    $mail->From = MAIL_CORREO; 
    $mail->FromName = MAIL_NOMBRE;         
    $mail->SMTPAutoTLS = false;    
    $mail->AddAddress($to); 
    $mail->IsHTML(true); 
    $mail->Subject = $subject; 
    $mail->Body = $body; 
    return $mail->send(); 
  }
  public static function encriptar($texto){    
    $objaes = new Aes(KEY_ENCRIPTAR);
    $encriptado = $objaes->encrypt($texto);
    return bin2hex($encriptado);
  }
  public static function desencriptar($texto){    
    $objaes = new Aes(KEY_ENCRIPTAR);
    $desencriptado = hex2bin($texto);
    return $objaes->decrypt($desencriptado);
  }


  public static function long_minima($str, $val){
    if (preg_match("/[^0-9]/", $val)){
      return false;
    }
    if (function_exists('mb_strlen')){
      return (mb_strlen($str) < $val) ? false : true;    
    }
    return (strlen($str) < $val) ? false : true;
  }

  public static function valida_password( $pass ){
    return (preg_match('/[a-zA-Z]/',$pass) && preg_match('/\d/',$pass) && self::long_minima($pass,8) )?true:false;
  }

  public static function generarToken($id,$accion) {
    $token = md5(TOKEN.$id.$accion);
    return $token;
  }

  public static function obtieneDominio(){
    return Modelo_Sucursal::obtieneSucursalActual($_SERVER["HTTP_HOST"]);
  }

  public static function valida_telefono($numerotelefono){ 
    if (preg_match("/^[ ]*[(]{0,1}[ ]*[0-9]{2,3}[ ]*[)]{0,1}[-]{0,1}[ ]*[0-9]{3,3}[ ]*[-]{0,1}[ ]*[0-9]{4,4}[ ]*$/",$numerotelefono)) return true; 
    else return false; 
  }

  //en formato de YYYY-MM-DD o YYYY-MM-DD HH:MM:SS
  public static function valida_fecha($strdate){
    $long_date = "/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2} [0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2}$/";
    $short_date = "/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$/";
    if (!preg_match($long_date, $strdate) && !preg_match($short_date, $strdate))
      return false;
    else{    
      if(strlen($strdate) == 19){
        $date_time = explode(" ", $strdate);
        $date = $date_time[0];
        $time = $date_time[1];
        
        $date_array = explode("-", $date);
        $time_array = explode(":", $time);
        
        $year = $date_array[0];
        $month = $date_array[1];
        $day = $date_array[2];
        
        $hours = $time_array[0];
        $minutes = $time_array[1];
        $seconds = $time_array[2];  
        
        if((($year<1900)OR($year>2200))OR(($month<=0)OR($month>12))OR(($day<=0)OR($day>31))OR(($hours<0)OR($hours>23))OR(($minutes<0)OR($minutes>60))OR(($seconds<0)OR($seconds>60))){
          return false;
        }
      }elseif(strlen($strdate) == 10){
        $date_time = explode(" ", $strdate);
        $date_array = explode("-", $date_time[0]);
        $year = $date_array[0];
        $month = $date_array[1];
        $day = $date_array[2];
        
        if((($year<1900)OR($year>2200))OR(($month<=0)OR($month>12))OR(($day<=0)OR($day>31)))
          return false;
      }else
        return false;
      
        
      return true;
    }
  }

  public static function valida_fecha_mayor($fecha){
    $result = false;
    if (empty($fecha)) {return $result;}
      $fecha_actual = date("Y-m-d");
      if ($fecha < $fecha_actual) {
        return $result;
      }
        $result = true;
        return $result;
  }

  static public function valida_upload($file,$tipo){ 
    $file_type = $file['type']; 
    $file_size = $file['size'];
    $file_temp = $file['tmp_name'];
    $valida_arch = self::validaExt($file,$tipo);
    if($tipo == 1){
      $peso_valido = PESO_IMAGEN;
    }
    elseif($tipo == 2){
      $peso_valido = PESO_ARCHIVO;
    }
    elseif($tipo == 3){
      $peso_valido = PESO_IMAGEN;
    }    
    if (($valida_arch[0] == true) && (!empty($file_temp)) && ($file_size <= $peso_valido))
      return true;
    else
      return false;
  }

  static public function upload($file,$nombre,$path,$tipo){ 
    $file_type = $file['type']; 
    $file_temp = $file['tmp_name'];
    $valida_arch = self::validaExt($file,$tipo);

    if ($valida_arch[0]){
      if (is_uploaded_file($file_temp)){
        if(isset($_SESSION['mfo_datos']['infohv']) && file_exists($path . $nombre . "." . $_SESSION['mfo_datos']['infohv']['formato'])){
          @unlink($path . $nombre . "." . $_SESSION['mfo_datos']['infohv']['formato']);
        }
        $nombre .= ".".$valida_arch[1];
        return move_uploaded_file($file_temp, ''.$path . $nombre);        
      }
    }
    return false;
  } 

  static public function validaExt($file,$tipo){
    $ext = '';
    $status = false;
    if($tipo == 1){
      if($file['type'] == 'image/jpg' || $file['type'] == 'image/jpeg' || $file['type'] == 'image/pjpeg'){
        $ext = 'jpg';
        $status = true;
      }
    }
    elseif($tipo == 2){
      if($file['type'] == 'application/pdf'){
        $ext = 'pdf';
        $status = true;
      }
      $encontro = strpos($file['type'], 'word');
      if($encontro != false){
        $ext = 'docx';
        $status = true;
      }
    }
    elseif($tipo == 3){
      if($file['type'] == 'image/jpg' || $file['type'] == 'image/jpeg' || $file['type'] == 'image/pjpeg' || $file['type'] == 'image/png'){
        $ext = (!strpos($file['type'],'png')) ? 'jpg' : 'png';
        $status = true;
      }
    }
    return array($status,$ext);
  }


  public static function validarNumeros($campo){
    if(preg_match ("/^[0-9]+$/", $campo)) return true;
    else return false;
  }

  public static function validarEminEmax($campo1, $campo2){
    if($campo1 >= 18 || $campo2 >= 18){
      if($campo1 <= $campo2){
        return true;
      }
      else return false;
    }
    else return false;
  }

  public static function validarLongitudMultiselect($array, $long){
    if(count($array)>$long){ return false;}
    else return true;
  }


  //static public function numerico($str){
  //  return (bool)preg_match( '/^[\-+]?[0-9]*\.?[0-9]+$/', $str);
  //}

  static public function alfabetico($str){
    return ( ! preg_match("/^([a-z ])*$/i", $str)) ? false : true;
  }

  static public function alfanumerico($str){
    return ( ! preg_match("/^([-a-z0-9 -])+$/i", $str)) ? false : true;
  }

  static public function formatoDinero($str){
    return ( ! preg_match("/^[0-9]+(?:\.[0-9]{0,2})?$/", $str)) ? false : true;
  }


  public static function validarPalabras($data){
    $merge_palabras;
    for ($i=0; $i < count($data); $i++) {
      ${"array_".$i} = array();
      array_push(${"array_".$i}, preg_split("/[\s,]+/u", ($data[$i])));
        if ($i>0) {
          ${"merge_palabras_".$i} = array_merge(${"array_0"}[0], ${"array_".($i)}[0]);
          $merge_palabras = ${"merge_palabras_".$i};
        }
      }
      $arrayPalabras = array_unique($merge_palabras);
      $palabras_ordenadas = array_values($arrayPalabras);
      $palabras_bd = (Modelo_PalabrasObscenas::obtienePalabras());      
      for ($i=0; $i < count($palabras_ordenadas); $i++) { 
        for ($j=0; $j < count($palabras_bd); $j++) { 
          if ($palabras_bd[$j]['descripcion'] == $palabras_ordenadas[$i]) {
            return false;
          }
        }
      }
    return true; 

  }

  static public function crearArchivo($ruta,$nombre,$contenido){  
    $fd = fopen($ruta.$nombre, "a");
    $str = $contenido;  
    fwrite($fd, $str . "\n");
    fclose($fd);
  }


  public static function ocultarCaracteres($str, $start, $end){
      $len = strlen($str);
      return substr($str, 0, $start) . str_repeat('*', $len - ($start + $end)) . substr($str, $len - $end, $end);
  }

  public static function ocultarEmail($email){
      $em   = explode("@",$email);
      $name = implode(array_slice($em, 0, count($em)-1), '@');
      $len  = floor(strlen($name));
      return substr($name,0, 0) . str_repeat('*', $len) . "@" . end($em); 
  }


  static public function restarDiasLaborables($fecha,$dias){
    $nrodias = 1; $cont_dias = 1;
    while($nrodias <= $dias){
      $dias_antes = strtotime($fecha." -".$cont_dias." days");
      $dia_semana = date("w",$dias_antes);
      if ($dia_semana != 0 && $dia_semana != 6){
        $nrodias++;
      }      
      $cont_dias++;            
    }
    return date('Y-m-d H:i:s',$dias_antes);
  }

  // public static function generarUsername($email){
  //   $generado = self::generateRandomString();
  //   $emailextract = substr($email, 0, strpos($email, '@'));
  //   $username = $emailextract.$generado;
  //   return strtolower($username);
  // }

  public static function generarPassword() {
      $length = rand(8, 10);
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
  }

  public static function validar_EC($dni){
    if (empty($dni)) {return false;}
    $val = false;
    if(ValidadorEc::validarCedula($dni) == true || ValidadorEc::validarRucPersonaNatural($dni) == true || ValidadorEc::validarRucSociedadPrivada($dni) == true || ValidadorEc::validarRucSociedadPublica($dni) == true) {
      $val = true;
      }
      return $val;
    }

  public static function no_carac($cadena)
  {
    $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ', 'Ά', 'ά', 'Έ', 'έ', 'Ό', 'ό', 'Ώ', 'ώ', 'Ί', 'ί', 'ϊ', 'ΐ', 'Ύ', 'ύ', 'ϋ', 'ΰ', 'Ή', 'ή');
    $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o', 'Α', 'α', 'Ε', 'ε', 'Ο', 'ο', 'Ω', 'ω', 'Ι', 'ι', 'ι', 'ι', 'Υ', 'υ', 'υ', 'υ', 'Η', 'η');
    // print_r(str_replace($a, $b, $cadena[0]));
    // exit();
    return str_replace($a, $b, $cadena);
  }

}
?>
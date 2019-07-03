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
    //Utils::log(__METHOD__ . " empezo una nueva sesion");
    session_name('mfo_datos');
    //ini_set("session.cookie_lifetime","900");
    ini_set("session.gc_maxlifetime","900");
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

  public static function envioCorreo($to, $subject, $body, $attachments=array()){    
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
    if (!empty($attachments) && is_array($attachments)){
      foreach($attachments as $attachment){
        if (file_exists($attachment["ruta"])){
          $mail->AddAttachment($attachment["ruta"], $attachment["archivo"]);
        }
      }
    }      
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

  public static function validaURL($url){ 
    if (preg_match("/^(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,})/",$url)) 
      return true; 
    else return false; 
  }

 // public static function validarTelefono($contenido){
 //   return preg_match("/^[0-9]{10,15}+$/", $contenido);
 // }

public static function validarTelefonoConvencional($contenido){
  if (preg_match("/^[0-9]{9}+$/",$contenido)) 
    return true; 
  else return false; 
}

public static function validarCelularConvencional($contenido){
  if (preg_match("/^[0-9]{9,15}+$/",$contenido)) 
    return true; 
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
        
        if((($year<1919)OR($year>2200))OR(($month<=0)OR($month>12))OR(($day<=0)OR($day>31)))
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

  public static function valida_fecha_mayor_edad($fecha){
    $result = false;
    if (empty($fecha)) {return $result;}
      $fecha_actual = date("Y-m-d");
      if ($fecha < $fecha_actual) {
        $result = true;
        return $result;
      }
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
    if (($valida_arch[0] == true) && (!empty($file_temp)) && ($file_size > 0) && ($file_size <= $peso_valido))
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
        if(isset($_SESSION['mfo_datos']['usuario']['infohv']) && file_exists($path . $nombre . "." . $_SESSION['mfo_datos']['usuario']['infohv']['formato'])){
          @unlink($path . $nombre . "." . $_SESSION['mfo_datos']['usuario']['infohv']['formato']);
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

  public static function alfabetico($str,$tipo_usuario){
    if($tipo_usuario == Modelo_Usuario::CANDIDATO){
      return ( ! preg_match("/^([a-z ÁÉÍÓÚáéíóúñÑ])*$/i", $str)) ? false : true;
    }else{
      return ( ! preg_match("/^([a-z ÁÉÍÓÚáéíóúñÑ 0-9.', &])*$/i", $str)) ? false : true;
    }
  }

  static public function alfanumerico($str){
    return ( ! preg_match("/^([-a-z0-9 -])+$/i", $str)) ? false : true;
  }

  static public function formatoDineroDecimal($str){
    return ( ! preg_match("/^([0-9]{1,5})[.][0-9]{2}?$/", $str)) ? false : true;
  }

  static public function formatoDinero($str){
    return ( ! preg_match("/^[0-9]{2,5}$/", $str)) ? false : true;
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

  public static function numerosRandom($digitos){
    $returnString = mt_rand(1, 9);
    while (strlen($returnString) < $digitos) {
      $returnString .= mt_rand(0, 9);
    }
    return $returnString;
  }

  public static function generarUsername($name){  
    $longitudMin = 4;
    if(strlen($name) > 50){
      $name = substr($name, 1, 49);
    }
    if(strlen($name) < $longitudMin){
      $longitudFal = $longitudMin-(strlen($name));
      $append = self::numerosRandom($longitudFal);
      $name .= $append;
    }
    $count = 0;
    $username = ($name);
    $username_generated = $username;
      do{
        if($count != 0){
          $username_generated = $username.$count;
        }
        $count++;
      }
    while(!empty(Modelo_Usuario::existeUsuario($username_generated)));
    return $username_generated;
  }

  public static function generateRandomNumeric($minimo,$maximo) {
      $length = rand($minimo, $maximo);      
      $characters = '0123456789';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
  }

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

  public static function generarTransId($identificador) {
    if (empty($identificador)){ return false; }    
    $length = rand(7, 7);
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = $identificador.'-';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }

  public static function validar_EC($dni, $accion){
    if (empty($dni)) {return false;}
    $val = false;
    if(ValidadorEc::DniRuc_Validador($dni ,$accion)) {
      $val = true;
    }
      return $val;
    }

  public static function validarPasaporte($pasaporte){
    return (!preg_match("/^[a-zA-Z0-9]+$/", $pasaporte) || strlen($pasaporte) < 6)? false : true;;
  }

  public static function no_carac($cadena){    
    $cadena = str_replace(utf8_decode('À'), 'A', $cadena);
    $cadena = str_replace(utf8_decode('Á'), 'A', $cadena);
    $cadena = str_replace(utf8_decode('Â'), 'A', $cadena);
    $cadena = str_replace(utf8_decode('Ã'), 'A', $cadena);
    $cadena = str_replace(utf8_decode('Ä'), 'A', $cadena);
    $cadena = str_replace(utf8_decode('Å'), 'A', $cadena);
    $cadena = str_replace(utf8_decode('Æ'), 'AE', $cadena);
    $cadena = str_replace(utf8_decode('Ç'), 'C', $cadena);
    $cadena = str_replace(utf8_decode('È'), 'E', $cadena);
    $cadena = str_replace(utf8_decode('Ê'), 'E', $cadena);
    $cadena = str_replace(utf8_decode('Ë'), 'E', $cadena);
    $cadena = str_replace(utf8_decode('Ì'), 'I', $cadena);
    $cadena = str_replace(utf8_decode('Í'), 'I', $cadena);
    $cadena = str_replace(utf8_decode('Î'), 'I', $cadena);
    $cadena = str_replace(utf8_decode('Ï'), 'I', $cadena);
    $cadena = str_replace(utf8_decode('Ð'), 'D', $cadena);
    $cadena = str_replace(utf8_decode('Ñ'), 'N', $cadena);
    $cadena = str_replace(utf8_decode('Ò'), 'O', $cadena);
    $cadena = str_replace(utf8_decode('Ó'), 'O', $cadena);
    $cadena = str_replace(utf8_decode('Ô'), 'O', $cadena);
    $cadena = str_replace(utf8_decode('Õ'), 'O', $cadena);
    $cadena = str_replace(utf8_decode('Ö'), 'O', $cadena);
    $cadena = str_replace(utf8_decode('Ø'), 'O', $cadena);
    $cadena = str_replace(utf8_decode('Ù'), 'U', $cadena);
    $cadena = str_replace(utf8_decode('Ú'), 'U', $cadena);
    $cadena = str_replace(utf8_decode('Û'), 'U', $cadena);
    $cadena = str_replace(utf8_decode('Ü'), 'U', $cadena);
    $cadena = str_replace(utf8_decode('Ý'), 'Y', $cadena);
    $cadena = str_replace(utf8_decode('ß'), 's', $cadena);
    $cadena = str_replace(utf8_decode('à'), 'a', $cadena);
    $cadena = str_replace(utf8_decode('á'), 'a', $cadena);
    $cadena = str_replace(utf8_decode('â'), 'a', $cadena);
    $cadena = str_replace(utf8_decode('ã'), 'a', $cadena);
    $cadena = str_replace(utf8_decode('ä'), 'a', $cadena);
    $cadena = str_replace(utf8_decode('å'), 'a', $cadena);
    $cadena = str_replace(utf8_decode('æ'), 'ae', $cadena);
    $cadena = str_replace(utf8_decode('ç'), 'c', $cadena);
    $cadena = str_replace(utf8_decode('è'), 'e', $cadena);
    $cadena = str_replace(utf8_decode('é'), 'e', $cadena);
    $cadena = str_replace(utf8_decode('ê'), 'e', $cadena);
    $cadena = str_replace(utf8_decode('ë'), 'e', $cadena);
    $cadena = str_replace(utf8_decode('ì'), 'i', $cadena);
    $cadena = str_replace(utf8_decode('í'), 'i', $cadena);
    $cadena = str_replace(utf8_decode('î'), 'i', $cadena);
    $cadena = str_replace(utf8_decode('ï'), 'i', $cadena);
    $cadena = str_replace(utf8_decode('ñ'), 'n', $cadena);
    $cadena = str_replace(utf8_decode('ò'), 'o', $cadena);
    $cadena = str_replace(utf8_decode('ó'), 'o', $cadena);
    $cadena = str_replace(utf8_decode('ô'), 'o', $cadena);
    $cadena = str_replace(utf8_decode('õ'), 'o', $cadena);
    $cadena = str_replace(utf8_decode('ö'), 'o', $cadena);
    $cadena = str_replace(utf8_decode('ø'), 'o', $cadena);
    $cadena = str_replace(utf8_decode('ù'), 'u', $cadena);
    $cadena = str_replace(utf8_decode('ú'), 'u', $cadena);
    $cadena = str_replace(utf8_decode('û'), 'u', $cadena);
    $cadena = str_replace(utf8_decode('ü'), 'u', $cadena);
    $cadena = str_replace(utf8_decode('ý'), 'y', $cadena);
    $cadena = str_replace(utf8_decode('ÿ'), 'y', $cadena);
    $cadena = str_replace(utf8_decode('Ā'), 'A', $cadena);
    $cadena = str_replace(utf8_decode('ā'), 'a', $cadena);
    $cadena = str_replace(utf8_decode('Ă'), 'A', $cadena);
    $cadena = str_replace(utf8_decode('ă'), 'a', $cadena);
    $cadena = str_replace(utf8_decode('Ą'), 'A', $cadena);
    $cadena = str_replace(utf8_decode('ą'), 'a', $cadena);
    $cadena = str_replace(utf8_decode('Ć'), 'C', $cadena);
    $cadena = str_replace(utf8_decode('ć'), 'c', $cadena);
    $cadena = str_replace(utf8_decode('Ĉ'), 'C', $cadena);
    $cadena = str_replace(utf8_decode('ĉ'), 'c', $cadena);
    $cadena = str_replace(utf8_decode('Ċ'), 'C', $cadena);
    $cadena = str_replace(utf8_decode('ċ'), 'c', $cadena);
    $cadena = str_replace(utf8_decode('Č'), 'C', $cadena);
    $cadena = str_replace(utf8_decode('č'), 'c', $cadena);
    $cadena = str_replace(utf8_decode('Ď'), 'D', $cadena);
    $cadena = str_replace(utf8_decode('ď'), 'd', $cadena);
    $cadena = str_replace(utf8_decode('Đ'), 'D', $cadena);
    $cadena = str_replace(utf8_decode('đ'), 'd', $cadena);
    $cadena = str_replace(utf8_decode('Ē'), 'E', $cadena);
    $cadena = str_replace(utf8_decode('Ĕ'), 'E', $cadena);
    $cadena = str_replace(utf8_decode('Ė'), 'E', $cadena);
    $cadena = str_replace(utf8_decode('Ę'), 'E', $cadena);
    $cadena = str_replace(utf8_decode('Ě'), 'E', $cadena);
    $cadena = str_replace(utf8_decode('ē'), 'e', $cadena);    
    $cadena = str_replace(utf8_decode('ĕ'), 'e', $cadena);
    $cadena = str_replace(utf8_decode('ė'), 'e', $cadena);
    $cadena = str_replace(utf8_decode('ę'), 'e', $cadena);
    $cadena = str_replace(utf8_decode('Ĝ'), 'G', $cadena);
    $cadena = str_replace(utf8_decode('Ğ'), 'G', $cadena);
    $cadena = str_replace(utf8_decode('Ġ'), 'G', $cadena);
    $cadena = str_replace(utf8_decode('Ģ'), 'G', $cadena);
    $cadena = str_replace(utf8_decode('ĝ'), 'g', $cadena);
    $cadena = str_replace(utf8_decode('ğ'), 'g', $cadena);
    $cadena = str_replace(utf8_decode('ġ'), 'g', $cadena);
    $cadena = str_replace(utf8_decode('ģ'), 'g', $cadena);
    $cadena = str_replace(utf8_decode('Ĥ'), 'H', $cadena);
    $cadena = str_replace(utf8_decode('ĥ'), 'h', $cadena);
    $cadena = str_replace(utf8_decode('Ħ'), 'H', $cadena);
    $cadena = str_replace(utf8_decode('ħ'), 'h', $cadena);
    $cadena = str_replace(utf8_decode('Ĩ'), 'I', $cadena);
    $cadena = str_replace(utf8_decode('ĩ'), 'i', $cadena);
    $cadena = str_replace(utf8_decode('Ī'), 'I', $cadena);
    $cadena = str_replace(utf8_decode('ī'), 'i', $cadena);
    $cadena = str_replace(utf8_decode('Ĭ'), 'I', $cadena);
    $cadena = str_replace(utf8_decode('ĭ'), 'i', $cadena);
    $cadena = str_replace(utf8_decode('Į'), 'I', $cadena);
    $cadena = str_replace(utf8_decode('į'), 'i', $cadena);
    $cadena = str_replace(utf8_decode('İ'), 'I', $cadena);
    $cadena = str_replace(utf8_decode('ı'), 'i', $cadena);
    $cadena = str_replace(utf8_decode('Ĳ'), 'IJ', $cadena);
    $cadena = str_replace(utf8_decode('ĳ'), 'ij', $cadena);
    $cadena = str_replace(utf8_decode('Ĵ'), 'J', $cadena);
    $cadena = str_replace(utf8_decode('ĵ'), 'j', $cadena);
    $cadena = str_replace(utf8_decode('Ķ'), 'K', $cadena);
    $cadena = str_replace(utf8_decode('ķ'), 'k', $cadena);
    $cadena = str_replace(utf8_decode('Ĺ'), 'L', $cadena);
    $cadena = str_replace(utf8_decode('ĺ'), 'l', $cadena);
    $cadena = str_replace(utf8_decode('Ļ'), 'L', $cadena);
    $cadena = str_replace(utf8_decode('ļ'), 'l', $cadena);
    $cadena = str_replace(utf8_decode('Ľ'), 'L', $cadena);
    $cadena = str_replace(utf8_decode('ľ'), 'l', $cadena);
    $cadena = str_replace(utf8_decode('Ŀ'), 'L', $cadena);
    $cadena = str_replace(utf8_decode('ŀ'), 'l', $cadena);
    $cadena = str_replace(utf8_decode('Ł'), 'l', $cadena);
    $cadena = str_replace(utf8_decode('ł'), 'l', $cadena);
    $cadena = str_replace(utf8_decode('Ń'), 'N', $cadena);
    $cadena = str_replace(utf8_decode('ń'), 'n', $cadena);
    $cadena = str_replace(utf8_decode('Ņ'), 'N', $cadena);
    $cadena = str_replace(utf8_decode('ņ'), 'n', $cadena);
    $cadena = str_replace(utf8_decode('Ň'), 'N', $cadena);
    $cadena = str_replace(utf8_decode('ň'), 'n', $cadena);
    $cadena = str_replace(utf8_decode('ŉ'), 'n', $cadena);
    $cadena = str_replace(utf8_decode('Ō'), 'O', $cadena);
    $cadena = str_replace(utf8_decode('ō'), 'o', $cadena);
    $cadena = str_replace(utf8_decode('Ŏ'), 'O', $cadena);
    $cadena = str_replace(utf8_decode('ŏ'), 'o', $cadena);
    $cadena = str_replace(utf8_decode('Ő'), 'O', $cadena);
    $cadena = str_replace(utf8_decode('ő'), 'o', $cadena);
    $cadena = str_replace(utf8_decode('Œ'), 'OE', $cadena);
    $cadena = str_replace(utf8_decode('œ'), 'oe', $cadena);
    $cadena = str_replace(utf8_decode('Ŕ'), 'R', $cadena);
    $cadena = str_replace(utf8_decode('ŕ'), 'r', $cadena);
    $cadena = str_replace(utf8_decode('Ŗ'), 'R', $cadena);
    $cadena = str_replace(utf8_decode('ŗ'), 'r', $cadena);
    $cadena = str_replace(utf8_decode('Ř'), 'R', $cadena);
    $cadena = str_replace(utf8_decode('ř'), 'r', $cadena);
    $cadena = str_replace(utf8_decode('Ś'), 'S', $cadena);
    $cadena = str_replace(utf8_decode('ś'), 's', $cadena);
    $cadena = str_replace(utf8_decode('Ŝ'), 'S', $cadena);
    $cadena = str_replace(utf8_decode('ŝ'), 's', $cadena);
    $cadena = str_replace(utf8_decode('Ş'), 'S', $cadena);
    $cadena = str_replace(utf8_decode('ş'), 's', $cadena);
    $cadena = str_replace(utf8_decode('Š'), 'S', $cadena);
    $cadena = str_replace(utf8_decode('š'), 's', $cadena);
    $cadena = str_replace(utf8_decode('Ţ'), 'T', $cadena);
    $cadena = str_replace(utf8_decode('ţ'), 't', $cadena);
    $cadena = str_replace(utf8_decode('Ť'), 'T', $cadena);
    $cadena = str_replace(utf8_decode('ť'), 't', $cadena);
    $cadena = str_replace(utf8_decode('Ŧ'), 'T', $cadena);
    $cadena = str_replace(utf8_decode('ŧ'), 't', $cadena);
    $cadena = str_replace(utf8_decode('Ũ'), 'U', $cadena);
    $cadena = str_replace(utf8_decode('ũ'), 'u', $cadena);
    $cadena = str_replace(utf8_decode('Ū'), 'U', $cadena);
    $cadena = str_replace(utf8_decode('ū'), 'u', $cadena);
    $cadena = str_replace(utf8_decode('Ŭ'), 'U', $cadena);
    $cadena = str_replace(utf8_decode('ŭ'), 'u', $cadena);
    $cadena = str_replace(utf8_decode('Ů'), 'U', $cadena);
    $cadena = str_replace(utf8_decode('ů'), 'u', $cadena);
    $cadena = str_replace(utf8_decode('Ű'), 'U', $cadena);
    $cadena = str_replace(utf8_decode('ű'), 'u', $cadena);
    $cadena = str_replace(utf8_decode('Ų'), 'U', $cadena);
    $cadena = str_replace(utf8_decode('ų'), 'u', $cadena);
    $cadena = str_replace(utf8_decode('Ŵ'), 'W', $cadena);
    $cadena = str_replace(utf8_decode('ŵ'), 'w', $cadena);
    $cadena = str_replace(utf8_decode('Ŷ'), 'Y', $cadena);
    $cadena = str_replace(utf8_decode('ŷ'), 'y', $cadena);
    $cadena = str_replace(utf8_decode('Ÿ'), 'Y', $cadena);
    $cadena = str_replace(utf8_decode('Ź'), 'Z', $cadena);
    $cadena = str_replace(utf8_decode('ź'), 'z', $cadena);
    $cadena = str_replace(utf8_decode('Ż'), 'Z', $cadena);
    $cadena = str_replace(utf8_decode('ż'), 'z', $cadena);
    $cadena = str_replace(utf8_decode('Ž'), 'Z', $cadena);
    $cadena = str_replace(utf8_decode('ž'), 'z', $cadena);
    $cadena = str_replace(utf8_decode('ſ'), 's', $cadena);
    $cadena = str_replace(utf8_decode('ƒ'), 'f', $cadena);
    $cadena = str_replace(utf8_decode('Ơ'), 'O', $cadena);
    $cadena = str_replace(utf8_decode('ơ'), 'o', $cadena);
    $cadena = str_replace(utf8_decode('Ư'), 'U', $cadena);
    $cadena = str_replace(utf8_decode('ư'), 'u', $cadena);
    $cadena = str_replace(utf8_decode('Ǎ'), 'A', $cadena);
    $cadena = str_replace(utf8_decode('ǎ'), 'a', $cadena);
    $cadena = str_replace(utf8_decode('Ǐ'), 'I', $cadena);
    $cadena = str_replace(utf8_decode('Ǒ'), 'O', $cadena);
    $cadena = str_replace(utf8_decode('ǒ'), 'o', $cadena);
    $cadena = str_replace(utf8_decode('Ǔ'), 'U', $cadena);
    $cadena = str_replace(utf8_decode('ǔ'), 'u', $cadena);
    $cadena = str_replace(utf8_decode('Ǖ'), 'U', $cadena);
    $cadena = str_replace(utf8_decode('ǖ'), 'u', $cadena);
    $cadena = str_replace(utf8_decode('Ǘ'), 'U', $cadena);
    $cadena = str_replace(utf8_decode('ǘ'), 'u', $cadena);
    $cadena = str_replace(utf8_decode('Ǚ'), 'U', $cadena);
    $cadena = str_replace(utf8_decode('ǚ'), 'u', $cadena);
    $cadena = str_replace(utf8_decode('Ǜ'), 'U', $cadena);
    $cadena = str_replace(utf8_decode('ǜ'), 'u', $cadena);
    $cadena = str_replace(utf8_decode('Ǻ'), 'A', $cadena);
    $cadena = str_replace(utf8_decode('ǻ'), 'a', $cadena);
    $cadena = str_replace(utf8_decode('Ǽ'), 'AE', $cadena);
    $cadena = str_replace(utf8_decode('ǽ'), 'ae', $cadena);
    $cadena = str_replace(utf8_decode('Ǿ'), 'O', $cadena);
    $cadena = str_replace(utf8_decode('Ά'), 'A', $cadena);
    $cadena = str_replace(utf8_decode('ά'), 'a', $cadena);
    $cadena = str_replace(utf8_decode('Έ'), 'E', $cadena);
    $cadena = str_replace(utf8_decode('Ό'), 'O', $cadena);
    $cadena = str_replace(utf8_decode('έ'), 'e', $cadena);
    $cadena = str_replace(utf8_decode('ό'), 'o', $cadena);
    $cadena = str_replace(utf8_decode('Ώ'), '', $cadena);
    $cadena = str_replace(utf8_decode('Ω'), '', $cadena);
    $cadena = str_replace(utf8_decode('ώ'), '', $cadena);
    $cadena = str_replace(utf8_decode('ω'), '', $cadena);
    $cadena = str_replace(utf8_decode('Ί'), 'I', $cadena);
    $cadena = str_replace(utf8_decode('ί'), 'i', $cadena);
    $cadena = str_replace(utf8_decode('ϊ'), 'i', $cadena);
    $cadena = str_replace(utf8_decode('ΐ'), 'i', $cadena);
    $cadena = str_replace(utf8_decode('Ύ'), 'Y', $cadena);
    $cadena = str_replace(utf8_decode('ύ'), 'u', $cadena);
    $cadena = str_replace(utf8_decode('ϋ'), 'u', $cadena);
    $cadena = str_replace(utf8_decode('ΰ'), 'u', $cadena);
    $cadena = str_replace(utf8_decode('Ή'), 'H', $cadena);
    $cadena = str_replace(utf8_decode('ή'), 'n', $cadena);
    $cadena = str_replace(utf8_decode('&'), '', $cadena);
    $cadena = str_replace(utf8_decode('.'), '', $cadena);
    $cadena = str_replace(utf8_decode(','), '', $cadena);
    $cadena = str_replace(utf8_decode("'"), '', $cadena);
    return $cadena;
  }

  public static function validarLongitudCampos($campo, $longitud){
    $contenido = html_entity_decode($campo);
    if(strlen($contenido)<=$longitud){
      return true;
    }
    else{
      return false;
    }
  }

  public static function detectarNavegador(){
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    if(strpos($user_agent, 'MSIE') !== FALSE)
      return 'MSIE';
    elseif(strpos($user_agent, 'Edge') !== FALSE) //Microsoft Edge
      return 'Microsoft Edge';
    elseif(strpos($user_agent, 'Trident') !== FALSE) //IE 11
      return 'Internet explorer 11';
    elseif(strpos($user_agent, 'Opera Mini') !== FALSE)
      return "Opera Mini";
    elseif(strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR') !== FALSE)
      return "Opera";
    elseif(strpos($user_agent, 'Firefox') !== FALSE)
      return 'Mozilla Firefox';
    elseif(strpos($user_agent, 'Chrome') !== FALSE)
      return 'Google Chrome';
    elseif(strpos($user_agent, 'Safari') !== FALSE)
      return "Safari";
    else
      return 'Other';
  }

  public static function validatFormatoFecha($fecha){
    $valores = explode('-', $fecha);
    if(count($valores) == 3 && checkdate($valores[1], $valores[2], $valores[0])){
      return true;
      }
    return false;
  }

// public static function generarTemplateCorreo($parametros){
// $url = "";
// $asunto = "";
// $body = "";
// $tipo = $parametros['tipo'];
// $template = Modelo_TemplateEmail::obtieneTemplate($tipo);
//   switch ($tipo) {
//     case 'REGISTRO_MANUAL':
//         $asunto = "Activación de cuenta";
//         $url = PUERTO."://".HOST."/registro/".$parametros['token']."/";
//         $body = str_replace(array("%NOMBRE%", "%NOMBRE_USUARIO%", "%URL_BOTON%"), array($parametros['nombres_mostrar'], $parametros['usuario_login'], $url), utf8_encode($template['contenido']));
//       break;
//     case 'REGISTRO_RED_SOCIAL':
//         $asunto = "Credenciales de cuenta mi camello";
//     break;
//     default:
        
//       break;
//   }
//   $result = array('asunto'=>$asunto, 'body'=>$body);
//   return $result;
// }


// Validaciones que se utilizan en el registro
  public static function validarNombreApellido($dato){
    return (! preg_match("/^[A-Za-zÁÉÍÓÚñáéíóúÑ ]{4,}$/", $dato)) ? false : true;
  }

  public static function validarTituloOferta($contenido){
    return (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\/\"'&(),. ]{3,}$/", $contenido)) ? false : true;
  }

  public static function validarNombreEmpresa($dato){
    // return (! preg_match("/^[A-Za-zÁÉÍÓÚñáéíóúÑ ]{4,}$/", $dato)) ? false : true;
    if(preg_match("/^[a-zA-ZÁÉÍÓÚñáéíóúÑ0-9&.,' ]{4,}$/", $dato) && preg_match("/(.*[a-zA-ZÁÉÍÓÚñáéíóúÑ]){3}/", $dato)){
      return true;
    }
    else{
      return false;
    }
  }

  public static function validarTelefono($dato){
    return (! preg_match("/^[0-9]{10,15}$/", $dato)) ? false : true;
  }

  public static function validarPassword($dato){
    return (! preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $dato)) ? false : true;
  }

  public static function passCoinciden($dato1, $dato2){
    if($dato1 == $dato2){
      return true;
    }
    else{
      return false;
    }
  }

  public static function str_replace_first($from, $to, $content) { 
    $from = '/'.preg_quote($from, '/').'/'; 
    return preg_replace($from, $to, $content, 1); 
  }

  public static function random($min, $max){
    list($usec, $sec) = explode(' ', microtime());
    $seed = (float) $sec + ((float) $usec * 100000);
    srand($seed);
    return rand($min, $max);
  }

  public static function crearThumbnail($nombreImagen, $nombreThumbnail, $nuevoAncho, $nuevoAlto){
    
    // Obtiene las dimensiones de la imagen.
    list($ancho, $alto) = getimagesize($nombreImagen);

    // Establece el alto para el thumbnail si solo se paso el ancho.
    if ($nuevoAlto == 0 && $nuevoAncho != 0){
        $factorReduccion = $ancho / $nuevoAncho;
        $nuevoAlto = $alto / $factorReduccion;
    }
    
    // Establece el ancho para el thumbnail si solo se paso el alto.
    if ($nuevoAlto != 0 && $nuevoAncho == 0){
        $factorReduccion = $alto / $nuevoAlto;
        $nuevoAncho = $ancho / $factorReduccion;
    }
             
    // Abre la imagen original.
    list($imagen, $tipo) = self::abrirImagen($nombreImagen);
    
    // Crea la nueva imagen (el thumbnail).
    $thumbnail = imagecreatetruecolor($nuevoAncho, $nuevoAlto);  
    imagecopyresampled($thumbnail , $imagen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
    
    // Guarda la imagen.
    self::guardarImagen($thumbnail, $nombreThumbnail, $tipo);
  }

  public static function abrirImagen($nombre){
    $info = getimagesize($nombre);
    switch ($info["mime"]){
        case "image/jpeg":
            $imagen = imagecreatefromjpeg($nombre);
            break;
        case "image/gif":
            $imagen = imagecreatefromgif($nombre);
            break;
        case "image/png":
            $imagen = imagecreatefrompng($nombre);
            break;
        default :
            echo "Error: No es un tipo de imagen permitido.";
    }
    $resultado[0]= $imagen;
    $resultado[1]= $info["mime"];
    return $resultado;
  }

  public static function guardarImagen($imagen, $nombre, $tipo){

    switch ($tipo){
        case "image/jpeg":
            imagejpeg($imagen, $nombre, 100); // El 100 es la calidade de la imagen (entre 1 y 100. Con 100 sin compresion ni perdida de calidad.).
            break;
        case "image/gif":
            imagegif($imagen, $nombre);
            break;
        case "image/png":
            imagepng($imagen, $nombre, 9); // El 9 es grado de compresion de la imagen (entre 0 y 9. Con 9 maxima compresion pero igual calidad.).
            break;
        default :
            echo "Error: Tipo de imagen no permitido.";
    }
  }  

  public static function quitarCaracIzquierda($cadena,$caracter){
    if (empty($cadena)){ return false; }
    while (strpos($cadena, $caracter) === 0) {
      $cadena = substr ($cadena,1);
    }
    return $cadena;
  }

}
?>
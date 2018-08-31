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
      $_SESSION['mfo_datos']['sucursal'] = self::obtieneDominio();
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
    return (preg_match('/[A-Z]/',$pass) && preg_match('/[a-z]/',$pass) && preg_match('/\d/',$pass) && self::long_minima($pass,8) )?true:false;
  }

  public static function generarToken($id,$accion) {
    $token = md5(TOKEN.$id.$accion);
    return $token;
  }

  public static function obtieneDominio(){
    return Modelo_Sucursal::obtieneSucursalActual($_SERVER["HTTP_HOST"]);
  }


  public static function valida_telefono($numerotelefono){ 

    if (preg_match("/^[ ]*[(]{0,1}[ ]*[0-9]{3,3}[ ]*[)]{0,1}[-]{0,1}[ ]*[0-9]{3,3}[ ]*[-]{0,1}[ ]*[0-9]{4,4}[ ]*$/",$numerotelefono)) return true; 
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
    }else{
      $peso_valido = PESO_ARCHIVO;
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
        move_uploaded_file($file_temp, ''.$path . $nombre);
      }
    }
  } 

  static public function validaExt($file,$tipo){

    $ext = '';
    $status = false;
    if($tipo == 1){
      if($file['type'] == 'image/jpg' || $file['type'] == 'image/jpeg' || $file['type'] == 'image/pjpeg'){
        $ext = 'jpg';
        $status = true;
      }
    }else{
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
    return array($status,$ext);
  }

  public static function validarNumeros($campo){
    if(preg_match ("/^[0-9]+$/", $campo)) return true;
    else return false;
  }

  public static function validarLongitudMultiselect($array, $long){
    if(count($array)>$long){ return false;}
    else return true;
  }
  // funcion para validar la cedula de Ecuador//
//Autor: Oliver Veliz
//año:2009

  public static function validarPalabras($data){
    Utils::log("Eder descripción:".print_r((($data[0])), true)) ;
    $merge_palabras;
    for ($i=0; $i < count($data); $i++) { 
      ${"array_".$i} = array();
      array_push(${"array_".$i}, preg_split("/[\s,]+/u", (html_entity_decode($data[$i]))));
      if ($i>0) {
        ${"merge_palabras_".$i} = array_merge(${"array_0"}[0], ${"array_".($i)}[0]);
        $merge_palabras = ${"merge_palabras_".$i};
      }
    }
    $arrayPalabras = array_unique($merge_palabras);
    $palabras_ordenadas = array_values($arrayPalabras);
    $palabras_bd = (Modelo_PalabrasObscenas::obtienePalabras());
    
    // Utils::log(print_r($palabras_ordenadas, true));
    // Utils::log(print_r($palabras_bd, true));
    // pokpoñklmñl
    for ($i=0; $i < count($palabras_ordenadas); $i++) { 
      for ($j=0; $j < count($palabras_bd); $j++) { 
        if ($palabras_bd[$j]['descripcion'] == $palabras_ordenadas[$i]) {
          return false;
        }
      }
    }
    // $result1=array_intersect($arrayPalabras,utf8_encode($palabras_bd['descripcion'][0]));
    // Utils::log("palabras obtenidas: ".print_r($result1, true));
    // Utils::log("palabras obtenidas1: ".print_r($palabras_bd[1]['descripcion'], true));
    return true;
    
  }


}
?>
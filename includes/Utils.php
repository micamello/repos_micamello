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
    $mail->Subject = utf8_encode($subject); 
    $mail->Body = $body; 
    return $mail->Send(); 
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
}
?>
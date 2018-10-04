<?php
require_once 'constantes.php';

if( strstr(dirname(__FILE__), 'C:') ){  
  $_SERVER['HTTP_HOST'] = 'micamello.com.ec'; 
}
//buscar en el archivo de relaciones

if (isset($_SERVER['HTTP_HOST']) /*&& (strpos($_SERVER['HTTP_HOST'], 'www.') !== false)*/){
  if (file_exists(FRONTEND_RUTA.'sucursales/'.$_SERVER['HTTP_HOST'].'.txt')) {
    $fp = fopen(FRONTEND_RUTA.'sucursales/'.$_SERVER['HTTP_HOST'].'.txt', 'r');
    $path = fgets($fp);
    fclose($fp);
    $values = explode(",",$path);
    if( strstr(dirname(__FILE__), 'C:') ){  
      define('HOST', 'localhost/repos_micamello');  
    }
    else{
      define('HOST', $_SERVER['HTTP_HOST'].'/desarrollo');  
    }   
    define('SUCURSAL_ID',trim($values[0]));
    define('SUCURSAL_ICONO',trim($values[1]));
    define('SUCURSAL_LOGO',trim($values[2]));
    define('SUCURSAL_PAISID',trim($values[3]));
    define('SUCURSAL_MONEDA',trim($values[4]));
    define('SUCURSAL_ISO',trim($values[5]));
  }
  else{          
    $sql = "SELECT s.id_sucursal, s.dominio, s.extensionicono, s.extensionlogo, s.id_pais, m.simbolo, s.iso 
            FROM mfo_sucursal s, mfo_moneda m WHERE s.id_moneda = m.id_moneda AND s.estado = 1 AND s.dominio = ?";
    $rs = $GLOBALS['db']->auto_array($sql,array($_SERVER['HTTP_HOST']));
    if (empty($rs)){
      Utils::doRedirect(PUERTO.'://'.$_SERVER['HTTP_HOST'].'/desarrollo/error/paginanoencontrada.php');
      exit;
    }
    $fp = fopen(FRONTEND_RUTA.'sucursales/'.$rs['dominio'].'.txt', "w");
    $lines = $rs['id_sucursal'].",".$rs['extensionicono'].",".$rs['extensionlogo'].",".$rs['id_pais'].",".$rs['simbolo'].",".$rs['iso']."\n";
    fputs($fp, $lines);
    fclose($fp);
    if( strstr(dirname(__FILE__), 'C:') ){  
      define('HOST', 'localhost/repos_micamello');  
    }
    else{
      define('HOST', $rs['dominio'].'/desarrollo');  
    }
    define('SUCURSAL_ID',trim($rs['id_sucursal']));
    define('SUCURSAL_ICONO',trim($rs['extensionicono']));
    define('SUCURSAL_LOGO',trim($rs['extensionlogo']));
    define('SUCURSAL_PAISID',trim($rs['id_pais']));
    define('SUCURSAL_MONEDA',trim($rs['simbolo']));
    define('SUCURSAL_ISO',trim($rs['iso']));
  }
}
else{
  Utils::doRedirect(PUERTO.'://'.$_SERVER['HTTP_HOST'].'/desarrollo/error/paginanoencontrada.php');
  exit;
} 
?>
<?php 
require_once '../constantes.php';
require_once '../init.php';

$dominio = 'https://www.micamello.com.ec';

$file = fopen("correos.txt", "r");
$contador = 0;
$array_correos2 = $array_correos = array();
while(!feof($file)) {
  $lineas = trim(fgets($file));  
  if (!empty($lineas)){  	
	  //if($contador < 40){
    	array_push($array_correos, $lineas);
    	//$contador++;
    //}else{
    	//array_push($array_correos2, $lineas);
    //}
  }  
}
fclose($file);

if(!empty($array_correos)){
  $correos = "'".implode("','", $array_correos)."'";
	$consultar_usuarios = Modelo_Usuario::busquedaPorCorreoMasivo($correos);   
	foreach ($consultar_usuarios as $key => $usuario) {			    
		if (Modelo_Usuario::modificarPassword('User12345',$usuario["id_usuario_login"])){					
	    $enlace = "<a href='https://www.micamello.com.ec/login/'>click aqu&iacute;</a><br>"; 
	    $nombre_mostrar = ucfirst(utf8_encode($usuario['nombres'].' '.$usuario['apellidos']));                    
	    $email_body = Modelo_TemplateEmail::obtieneHTML("ACTIVACION_USUARIO_REPETICION");      
	    $email_body = str_replace("%NOMBRES%", $nombre_mostrar, $email_body);   
	    $email_body = str_replace("%USUARIO%", $usuario['username'], $email_body);   
	    $email_body = str_replace("%CORREO%", $usuario['correo'], $email_body);   
	    $email_body = str_replace("%PASSWORD%", 'User12345', $email_body);   
	    $email_body = str_replace("%ENLACE%", $enlace, $email_body); 	    	    	    
	    if (Utils::envioCorreo($usuario["correo"],"Activación de Usuario",$email_body)){
	    	echo "Correo enviado ".$usuario["correo"]."<br>";
	    }
	    else{
	      echo "Correo no enviado ".$usuario["correo"]."<br>";	
	    }
    }
    else{
    	echo "Error modificacion Clave ".$usuario["correo"]."<br>";
    }
	}

	/*$file = fopen("correos.txt", "w");
	foreach($array_correos2 as $c){
		fwrite($file, $c);
	}
	fclose($file);*/
}
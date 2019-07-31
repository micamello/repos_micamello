<?php 
require_once '../constantes.php';
require_once '../init.php';

$dominio = 'https://www.micamello.com.ec';

$file = fopen("correos.txt", "r");
$contador = 0;
/*$array_correos2 =*/ $array_correos = array();
while(!feof($file)) {
  $lineas = trim(fgets($file));  
  if (!empty($lineas)){  	
	  //if($contador < 250){
    	array_push($array_correos, $lineas);
    //	$contador++;
    //}else{
    //	array_push($array_correos2, $lineas);
    //}
  }  
}
fclose($file);

if(!empty($array_correos)){
  $correos = "'".implode("','", $array_correos)."'";
	$consultar_usuarios = Modelo_Usuario::busquedaPorCorreoMasivo($correos);   
	foreach ($consultar_usuarios as $key => $usuario) {			    
		if (Modelo_Usuario::modificarPassword('User12345',$usuario["id_usuario_login"])){		
		  $token = Utils::generarToken($usuario["id_usuario"],"ACTIVACION");			
		  if (empty($token)){
        continue;
      }
      $token .= "||".$usuario["id_usuario"]."||".Modelo_Usuario::CANDIDATO."||".date("Y-m-d H:i:s");
      $token = Utils::encriptar($token);
      $enlace = "<a style='background-color: #22b573; color: white; padding: 8px 20px; text-decoration: none; border-radius: 5px;' href='https://www.micamello.com.ec/registro/".$token."/'>click aqui</a>";	    
	    $nombre_mostrar = ucfirst(utf8_encode($usuario['nombres'].' '.$usuario['apellidos']));                    
	    $email_body = Modelo_TemplateEmail::obtieneHTML("ACTIVACION_USUARIO_REPETICION");      
	    $email_body = str_replace("%NOMBRES%", $nombre_mostrar, $email_body);   
	    $email_body = str_replace("%USUARIO%", $usuario['username'], $email_body);   
	    $email_body = str_replace("%CORREO%", $usuario['correo'], $email_body);   
	    $email_body = str_replace("%PASSWORD%", 'User12345', $email_body);   
	    $email_body = str_replace("%ENLACE%", $enlace, $email_body); 	    	    	    
	    //if (Utils::envioCorreoSendinBlue($usuario["correo"],"Activación de Usuario",$email_body)){
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
		if ($c != end($array_correos2)) {
			fwrite($file, $c.PHP_EOL);
		}else{
			fwrite($file, $c);
		}
	}
	fclose($file);*/
}
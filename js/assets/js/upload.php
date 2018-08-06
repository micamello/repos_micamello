<?php
if($_SERVER['REQUEST_METHOD'] == "POST")
{
	$error = '';
	$img = '';
	$dir = '../../img/cv/';
	$extensions = array("pdf","doc","docx");
	foreach($_FILES['img_file']['tmp_name'] as $key => $tmp_name )
	{
		$file_name = $_FILES['img_file']['name'][$key];
		$file_size =$_FILES['img_file']['size'][$key];
		$file_tmp =$_FILES['img_file']['tmp_name'][$key];
		$file_type=$_FILES['img_file']['type'][$key];
		$exploded = explode('.',$_FILES['img_file']['name'][$key]);
		 $last_element = end($exploded);
		 $file_ext=strtolower($last_element);
		if(in_array($file_ext,$extensions ) === true)
		{
			if(move_uploaded_file($file_tmp, $dir.$file_name))
			{
				$img .= '<div class="col-sm-12" align="center"><div class="thumbnail">';
				$img .= 'Su hoja de vida fue subida con éxito';
				$img .= '</div></div>';		
			}
			else
				$error = 'Error in uploading few files. Some files couldn\'t be uploaded.';				
		}	
		else
		{
			$error = 'Error al cargar algunos archivos. Tipo de archivo no está permitido.';
		}		
	}
	echo (json_encode(array('error' => $error, 'img' => $img)));	
}
die();
?>
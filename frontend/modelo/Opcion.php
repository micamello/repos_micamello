<?php
class Modelo_Opcion{

	public static function listadoxPregunta($pregunta){
		if (empty($pregunta)){ return false; }
		$sql = "SELECT o.*,r.orden 
						FROM mfo_opcion o INNER JOIN mfo_opcion_respuesta r
						ON o.id_opcion = r.id_opcion
						WHERE r.id_pre = ? 
						ORDER BY r.orden";
		return $GLOBALS['db']->auto_array($sql,array($pregunta),true);
	}
	
	/*******MINISITIO******/
	public static function obtieneOpciones($pregunta){
		if (empty($pregunta)){ return false; }
		$sql = "SELECT id_opcion, descripcion, valor 
		        FROM mfo_opcionm2 WHERE id_pregunta = ? 
		        ORDER BY RAND()";
    	return $GLOBALS['db']->auto_array($sql,array($pregunta),true);
	}

	public static function datosGraficos($id_usuario){

		if (empty($id_usuario)){ return false; }
		$sql = 'SELECT t.id_faceta,sum(b.porcentaje) as prom, sum(id_competencia) as cantd_competencias FROM (SELECT GROUP_CONCAT(r.orden_seleccion ORDER BY o.valor) as puntaje, c.id_faceta, (1) as id_competencia
		FROM mfo_opcionm2 o
		INNER JOIN mfo_respuestam2 r on r.id_opcion = o.id_opcion
		INNER JOIN mfo_preguntam2 p on p.id_pregunta = o.id_pregunta
		INNER JOIN mfo_competenciam2 c on c.id_competencia = p.id_competencia
		WHERE r.id_usuario = ?
		GROUP BY c.id_competencia) t
		INNER JOIN mfo_baremo b ON b.orden1 = (SUBSTR(t.puntaje, 1, 1)) AND 
		 b.orden2 = (SUBSTR(t.puntaje, 3, 1)) AND 
		 b.orden3 = (SUBSTR(t.puntaje, 5, 1)) AND 
		 b.orden4 = (SUBSTR(t.puntaje, 7, 1)) AND 
		 b.orden5 = (SUBSTR(t.puntaje, 9, 1))
		GROUP BY id_faceta
		ORDER BY id_faceta';

		$arrdatos = $GLOBALS['db']->auto_array($sql,array($id_usuario),true);

		$datos = array();
		if (!empty($arrdatos) && is_array($arrdatos)){

			foreach ($arrdatos as $key => $value) {
				$datos[$value['id_faceta']] = array();
			}

			foreach ($arrdatos as $key => $value) {
				$datos[$value['id_faceta']] = array($value['prom'],$value['cantd_competencias']);
			}
		}
		return $datos;
	}

	public static function competenciasXfaceta(){

		$sql = 'SELECT f.id_faceta, GROUP_CONCAT(m.descripcion SEPARATOR "-") AS competencias FROM mfo_facetam2 f
				
				INNER JOIN mfo_competenciam2 m ON m.id_faceta = f.id_faceta
				GROUP BY f.id_faceta';

		$arrdatos = $GLOBALS['db']->auto_array($sql,array(),true);

		$datos = array();
		if (!empty($arrdatos) && is_array($arrdatos)){

			foreach ($arrdatos as $key => $value) {
				$datos[$value['id_faceta']] = array();
			}

			foreach ($arrdatos as $key => $value) {
				$datos[$value['id_faceta']] = $value['competencias'];
			}
		}
		return $datos;
	}
}  
?>
<?php
require_once 'includes/mpdf/mpdf.php';                                
class Controlador_Minisitio extends Controlador_Base
{

    public function construirPagina()
    {
        $nacionalidad  = Modelo_Pais::obtieneListadoNacionalidad(SUCURSAL_PAISID);
        $escolaridad      = Modelo_Escolaridad::obtieneListadoAsociativo();
        $profesion   = Modelo_Ocupacion::obtieneListadoProfesion();
        $ocupacion   = Modelo_Ocupacion::obtieneListadoAsociativo();
        $facetas = Modelo_Faceta::obtenerLiterales();
        $colores_facetas = Modelo_Faceta::obtenerColoresLiterales();
        $residenciaActual = Modelo_Provincia::residenciaActual(SUCURSAL_PAISID);
        $competencias = Modelo_Competencia::obtenerCompetenciasGrados();

        $mostrar = Utils::getParam('mostrar', '', $this->data);
        $opcion = Utils::getParam('opcion', '', $this->data);
        $type = Utils::getParam('type', '', $this->data);
        $param1 = Utils::getParam('param1', '', $this->data);

        switch ($opcion) {
            
            case 'filtrar':
                $letra = substr($param1,0,1);
                $id = substr($param1,1);

                $array_datos = $_SESSION['array_datos'];
                if(isset($_SESSION['filtrar_consultados'][$letra])){
                    if($letra == 'A' && $type == 1){
                        if(isset(SALARIO[$id])){
                            $_SESSION['filtrar_consultados']['A'] = $id;
                            $_SESSION['array_datos']['A'] = array('id'=>$id,'nombre'=>SALARIO[$id]);
                        }
                    }
                    else if($letra == 'P' && $type == 1){
                        if(isset($profesion[$id])){
                          $_SESSION['filtrar_consultados']['P'] = $id;
                          $_SESSION['array_datos']['P'] = array('id'=>$id,'nombre'=>$profesion[$id]);
                        }
                    }
                    else if($letra == 'E' && $type == 1){
                        if(isset($escolaridad[$id])){
                          $_SESSION['filtrar_consultados']['E'] = $id;
                          $_SESSION['array_datos']['E'] = array('id'=>$id,'nombre'=>$escolaridad[$id]);
                        }
                    }else if($letra == 'O' && $type == 1){
                        if(isset($ocupacion[$id])){
                            $_SESSION['filtrar_consultados']['O'] = $id; 
                            $_SESSION['array_datos']['O'] = array('id'=>$id,'nombre'=>$ocupacion[$id]);
                        }
                    }
                    else if($letra == 'F' && $type == 1){
                        if(isset(EDAD[$id])){
                          $_SESSION['filtrar_consultados']['F'] = $id; 
                          $_SESSION['array_datos']['F'] = array('id'=>$id,'nombre'=>EDAD[$id]);
                        }
                    }
                    else if($letra == 'G' && $type == 1){

                        $g = array_search($id,VALOR_GENERO); 
                        if($g != false){

                            if(isset(GENERO[$g])){
                                $_SESSION['filtrar_consultados']['G'] = $id;
                                $array_datos['G'] = array('id'=>$id,'nombre'=>GENERO[$g]);
                            }
                        }
                    }
                    else if($letra == 'H' && $type == 1){

                        if(!in_array($id, $_SESSION['filtrar_consultados']['H'])){

                          $comp = explode('_',$id);

                          if(count($comp) == 1){
                            $nombre = $competencias[$comp[0]]['nombre'];
                          }else{
                            $nombre = $competencias[$comp[0]]['nombre'].' - '.$competencias[$comp[0]]['grados'][$comp[1]];
                          }

                          array_push($_SESSION['filtrar_consultados']['H'],$id);
                          array_push($_SESSION['array_datos']['H'],array('id'=>$id,'nombre'=>$nombre));
                        }
                    }
                    else if($letra == 'R' && $type == 1){

                      $res = explode('_',$id);

                      if(count($res) == 1){
                        $nombre = 'Residencia: '.$residenciaActual[$res[0]]['nombre'];
                      }else if(count($res) == 2){
                        $nombre = 'Residencia: '.$residenciaActual[$res[0]]['nombre'].' - '.$residenciaActual[$res[0]]['cantones'][$res[1]];
                      }else{
                        $nombre = 'Residencia: '.$residenciaActual[$res[0]]['nombre'].' - '.$residenciaActual[$res[0]]['cantones'][$res[1]]['nombre'].' - '.$residenciaActual[$res[0]]['cantones'][$res[1]]['parroquias'][$res[2]];
                      }
                      $_SESSION['filtrar_consultados']['R'] = $id; 
                      $_SESSION['array_datos']['R'] = array('id'=>$id,'nombre'=>$nombre);

                    }
                    else if($letra == 'N' && $type == 1){

                      $nac = explode('_',$id);

                      if(count($nac) == 1){
                        $nombre = 'Nacionalidad: '.$nacionalidad[$nac[0]]['nombre'];
                      }else{
                        $nombre = 'Nacionalidad: '.$nacionalidad[$nac[0]]['nombre'].' - '.$nacionalidad[$nac[0]]['provincias'][$nac[1]];
                      }
                      $_SESSION['filtrar_consultados']['N'] = $id; 
                      $_SESSION['array_datos']['N'] = array('id'=>$id,'nombre'=>$nombre);
                    }
                    else if($letra == 'C' && $type == 1){
                        if(isset(ESTADO_CIVIL[$id])){
                          $_SESSION['filtrar_consultados']['C'] = $id; 
                          $_SESSION['array_datos']['C'] = array('id'=>$id,'nombre'=>ESTADO_CIVIL[$id]);
                        }
                    }
                    else if($type == 2){
                      

                        if($letra == 'H'){

                            if(in_array($id, $_SESSION['filtrar_consultados']['H'])){

                                foreach ($_SESSION['filtrar_consultados']['H'] as $key => $value) {
                                    if($value == $id){

                                        unset($_SESSION['filtrar_consultados']['H'][$key]);
                                        unset($_SESSION['array_datos']['H'][$key]);
                                        break;
                                    }
                                }
                            }

                        }else{
                            $_SESSION['filtrar_consultados'][$letra] = 0;
                            $_SESSION['array_datos'][$letra] = 0;
                        }
                    }
                }

                $registros = $this->preparaConsulta($_SESSION['filtrar_consultados']);
                $table = $this->generarTabla($registros,$facetas,$colores_facetas,1);

                $link = Vista::display('filtrarEntrevistados',array('data'=>$_SESSION['array_datos']));

                $tags = array(
                    'nacionalidad'=>$nacionalidad,
                    'escolaridad'=>$escolaridad,
                    'profesion'=>$profesion,
                    'ocupacion'=>$ocupacion,
                    //'facetas'=>$facetas,
                    //'colores_facetas'=>$colores_facetas,
                    'residenciaActual'=>$residenciaActual,
                    'competencias'=>$competencias,
                    'link'=>$link,
                    'table'=>$table
                    //'registros'=>$registros
                );
                $render = Vista::display('admin/index',$tags); 
                echo $render;
            break;
            case 'generarExcel':
                $registros = $this->preparaConsulta($_SESSION['filtrar_consultados']);
                $table = $this->generarTabla($registros,$facetas,$colores_facetas,2);
                $this->generarExcel($table);
            break;
            case 'generaGrafico':
                $this->generaGrafico();
            break;
            case 'generaInforme':

                if($type == 0){
                    $idusuario = Utils::getParam('id_usuario', '', $this->data);
                    $datosusuario = Modelo_Usuario::obtieneNombres($idusuario);
                    $preguntas = Modelo_Respuesta::resultadoxUsuario($idusuario);
                    $informe = $this->generaInforme(array('datos'=>$datosusuario,'preguntas'=>$preguntas,'facetas'=>$facetas));
                    $_SESSION['datos_informe'] = array('nombre_archivo'=>"informe_".$datosusuario['nombres'].' '.$datosusuario['apellidos'].".pdf",'informe'=>$informe);
                    $this->generaGrafico();
                }else{                                      
                    $mpdf=new mPDF('','A4');
                    foreach ($facetas as $key => $value) {
                        $_SESSION['datos_informe']['informe'] = str_replace('_grafico'.($key), $_POST["hidden_html".($key)], $_SESSION['informe']);
                    }
                    $informe = $_SESSION['datos_informe']['informe'];
                    $nombre_archivo = $_SESSION['datos_informe']['nombre_archivo'];
                    $mpdf->WriteHTML($informe);                    
                    $mpdf->Output($nombre_archivo, 'D');
                }
            break;
            default:

                $_SESSION['filtrar_consultados'] = array('F'=>0,'E'=>0,'G'=>0,'P'=>0,'H'=>array(),'R'=>0,'O'=>0,'N'=>0,'C'=>0,'A'=>0);
                $_SESSION['array_datos'] = array('F'=>0,'E'=>0,'G'=>0,'P'=>0,'H'=>array(),'R'=>0,'O'=>0,'N'=>0,'C'=>0,'A'=>0);
 
                $registros = $this->preparaConsulta($_SESSION['filtrar_consultados']);
                $table = $this->generarTabla($registros,$facetas,$colores_facetas,1);

                $tags = array(
                    'nacionalidad'=>$nacionalidad,
                    'escolaridad'=>$escolaridad,
                    'profesion'=>$profesion,
                    'ocupacion'=>$ocupacion,
                    'residenciaActual'=>$residenciaActual,
                    'competencias'=>$competencias,
                    'link'=>'',
                    'facetas'=>$facetas,
                    'colores_facetas'=>$colores_facetas,
                    'registros'=>$registros,
                    'table'=>$table
                );  
                $render = Vista::display('admin/index',$tags); 
                echo $render;
            break;
        }
    }

    public static function preparaConsulta($filtros){
      $edad = (empty($filtros['F']) || $filtros['F'] > 5) ? '' : $filtros['F']; 
      $genero = (empty($filtros['G'])) ? '' : $filtros['G'];
      $aspiracion = (empty($filtros['A']) || $filtros['A'] > 4) ? '' : $filtros['A'];
      $estadocivil = (empty($filtros['C'])) ? '' : $filtros['C'];
      $profesion = (empty($filtros['P'])) ? '' : $filtros['P'];  
      $ocupacion = (empty($filtros['O'])) ? '' : $filtros['O'];
      $escolaridad = (empty($filtros['E'])) ? '' : $filtros['E'];
      
      $nacionalidad = '';
      $ciudadnac = '';
      if (!empty($filtros['N'])){
        $lugarnac = explode('_',$filtros['N']);
        $nacionalidad = (is_array($lugarnac) && isset($lugarnac[0])) ? $lugarnac[0] : $filtros['N'];
        $ciudadnac = (is_array($lugarnac) && isset($lugarnac[1])) ? $lugarnac[1] : '';
      }    
      
      $parroquia = '';
      $ciudad = '';
      $provincia = '';   
      if (!empty($filtros['R'])){
        $patron = '/(\d+)(\d+)(\d+)/i';
        preg_match($patron,$filtros['R'],$coincidencias);        
        if (empty($coincidencias)){
          $patron = '/(\d+)_(\d+)/i';
          preg_match($patron,$filtros['R'],$coincidencias);  
          if (empty($coincidencias)){
            $parroquia = '';
            $ciudad = '';
            $provincia = $filtros['R'];       
          }
          else{
            $parroquia = '';
            $ciudad = $coincidencias[2];
            $provincia = $coincidencias[1];    
          }
        }
        else{          
          $parroquia = $coincidencias[3];
          $ciudad = $coincidencias[2];
          $provincia = $coincidencias[1];    
        }        
      }
      
      $competencias = array();
      if (!empty($filtros['H'])){
        foreach($filtros['H'] as $competencia){
          $competenciatemp = explode('_',$competencia);
          $comp = (is_array($competenciatemp) && isset($competenciatemp[0])) ? $competenciatemp[0] : $competencia; 
          $puntaje = (is_array($competenciatemp) && isset($competenciatemp[1])) ? $competenciatemp[1] : 0;
          $competencias[$comp] = $puntaje; 
        }
      }            

      return Modelo_Respuesta::verResultados($edad,$nacionalidad,$ciudadnac,$genero,$estadocivil,$profesion,$ocupacion,
                                             $escolaridad,$aspiracion,$parroquia,$ciudad,$provincia,$competencias);  
    }

    public function generarTabla($registros,$facetas,$colores_facetas,$tipo){

        $promedios = $porc_facetas = array();
        $preg_x_faceta = Modelo_Pregunta::totalPregXfaceta()['cantd_preguntas'];
        $col = $preg_x_faceta*count(OPCIONES);
        $cantd = $preg_x_faceta*count($facetas);
        $cantd_op = $col*count($facetas);
        $table = '<table border="1" cellspacing="0" cellpadding="0" id="cuestionarios" class="table table-striped table-bordered table-responsive" style="width:100%;color: black;">
            <thead>
              <tr style="background:#f3e4e4;">
                <td rowspan="2" align="center" style="vertical-align:middle;"><b>Nombre y Apellido</b></td>';

                if($tipo == 2){
                    $table .= '<td rowspan="2" align="center" style="vertical-align:middle;"><b>Correo</b></td>
                    <td rowspan="1" colspan="2" align="center" style="vertical-align:middle;"><b>Nacionalidad</b></td>
                    <td rowspan="2" align="center" style="vertical-align:middle;"><b>G&eacute;nero</b></td>
                    <td rowspan="2" align="center" style="vertical-align:middle;"><b>Edad</b></td>
                    <td rowspan="2" align="center" style="vertical-align:middle;"><b>Estado civil</b></td>
                    <td rowspan="2" align="center" style="vertical-align:middle;"><b>Profesi&oacute;n</b></td>
                    <td rowspan="2" align="center" style="vertical-align:middle;"><b>Ocupaci&oacute;n</b></td>
                    <td rowspan="2" align="center" style="vertical-align:middle;"><b>Nivel de Instrucci&oacute;n</b></td>
                    <td rowspan="2" align="center" style="vertical-align:middle;"><b>Aspiraci&oacute;n Salarial</b></td>
                    <td rowspan="1" colspan="3" align="center" style="vertical-align:middle;"><b>Residencia Actual</b></td>';
                }

                foreach ($facetas as $key => $literales) {

                    $table .= '<td align="center" style="background:'.$colores_facetas[$key].'; vertical-align:middle;" colspan="'.$col.'"><b>'.$literales.'</b></td>';
                } 

                $table .= '<td colspan="'.$cantd.'" align="center" style="vertical-align:middle;"><b>Porcentajes por preguntas</b></td>';

                $table .= '<td colspan="'.$cantd.'" align="center" style=" vertical-align:middle;"><b>Grados por pregunta</b></td>';
                $table .= '<td colspan="'.count($facetas).'" align="center" style=" vertical-align:middle;"><b>Puntajes por faceta</b></td>';

                if($tipo == 1){
                    $table .= '<td rowspan="2" align="center" style="vertical-align:middle;"><b>Descargar Informe</b></td>';
                }
              $table .= '</tr>
              <tr style="background:#f3e4e4;">';

                if($tipo == 2){
                    $table .= '<td rowspan="1" align="center" style="vertical-align:middle;"><b>Pa&iacute;s</b></td>
                    <td rowspan="1" align="center" style="vertical-align:middle;"><b>Ciudad</b></td>
                    <td rowspan="1" align="center" style="vertical-align:middle;"><b>Provincia</b></td>
                    <td rowspan="1" align="center" style="vertical-align:middle;"><b>Cant&oacute;n</b></td>
                    <td rowspan="1" align="center" style="vertical-align:middle;"><b>Parroquia</b></td>';
                }

                $cont = 1;
                foreach ($facetas as $key => $literales) {
                    $i = 1;
                    while($cont <= $col){

                      foreach (OPCIONES as $clave => $op) {
                        $table .= '<td><b>'.$literales.$i.$op.'</b></td>';
                        $cont++;
                      }
                      $i++;
                    }

                    if($cont > $col){
                      $cont = 1;
                    }
                } 

                foreach ($facetas as $key => $literales) {
                    for ($i=1; $i <= $preg_x_faceta; $i++) { 
                        $table .= '<td align="center" style=" background:'.$colores_facetas[$key].'; vertical-align:middle;"><b>'.$literales.$i.'</b></td>';
                    }
                }

                foreach ($facetas as $key => $literales) {
                    for ($i=1; $i <= $preg_x_faceta; $i++) { 
                        $table .= '<td align="center" style=" background:'.$colores_facetas[$key].'; vertical-align:middle;"><b>'.$literales.$i.'</b></td>';
                    }
                }

                foreach ($facetas as $key => $literales) {
                    $table .= '<td align="center" style="background:'.$colores_facetas[$key].'; vertical-align:middle;"><b>'.$literales.'</b></td>';
                } 

              $table .= '</tr>
            </thead>
            <tbody>';

            $id_ant = 0;
            $cont_opciones = 0;
            foreach ($registros as $key => $value) {

                if($id_ant != $value['id_usuario']){

                    foreach ($facetas as $key => $literales) {

                        $promedios[$literales] = array();
                        $porc_facetas[$literales] = array();
                        $porc_por_preguntas[$literales] = array();
                        $grad_por_preguntas[$literales] = array();
                    }

                    $id_ant = $value['id_usuario'];
                    $table .= '<tr>';
                    $table .= '<td align="center" style="vertical-align:middle;">'.$value['nombres'].' '.$value['apellidos'].'</td>';

                    if($tipo == 2){

                        $table .= '<td align="center" style="vertical-align:middle;">'.$value['correo'].'</td>
                        <td align="center" style="vertical-align:middle;">'.$value['id_nacionalidad'].'</td>
                        <td align="center" style="vertical-align:middle;">'.$value['id_ciudad'].'</td>
                        <td align="center" style="vertical-align:middle;">'.$value['genero'].'</td>
                        <td align="center" style="vertical-align:middle;">'.$value['edad'].'</td>
                        <td align="center" style="vertical-align:middle;">'.$value['estado_civil'].'</td>
                        <td align="center" style="vertical-align:middle;">'.$value['id_profesion'].'</td>
                        <td align="center" style="vertical-align:middle;">'.$value['id_ocupacion'].'</td>
                        <td align="center" style="vertical-align:middle;">'.$value['id_escolaridad'].'</td>
                        <td align="center" style="vertical-align:middle;">'.$value['asp_salarial'].'</td>
                        <td align="center" style="vertical-align:middle;">'.$value['id_provincia'].'</td>
                        <td align="center" style="vertical-align:middle;">'.$value['id_ciudadr'].'</td>
                        <td align="center" style="vertical-align:middle;">'.$value['id_parroquia'].'</td>';
                    }
                }

                $table .= '<td align="center" style="vertical-align:middle;">'.$value['orden1'].'</td>
                <td align="center" style="vertical-align:middle;">'.$value['orden2'].'</td>
                <td align="center" style="vertical-align:middle;">'.$value['orden3'].'</td>
                <td align="center" style="vertical-align:middle;">'.$value['orden4'].'</td>
                <td align="center" style="vertical-align:middle;">'.$value['orden5'].'</td>';

                $cont_opciones += count(OPCIONES);

                array_push($porc_por_preguntas[$facetas[$value['id_faceta']]],$value['porcentaje']); 
                array_push($grad_por_preguntas[$facetas[$value['id_faceta']]],$value['id_puntaje']);

                if($cantd_op == $cont_opciones){

                   foreach ($porc_por_preguntas as $a => $porc) {
                        
                        foreach ($porc as $b => $p) {
                            $table .= '<td align="center" style="vertical-align:middle;">'.$p.'</td>';
                        } 
                    }
 
                    foreach ($grad_por_preguntas as $a => $grad) {
                        foreach ($grad as $b => $g) {
                            $table .= '<td align="center" style="vertical-align:middle;">'.$g.'</td>';
                        } 
                    }

                    foreach ($facetas as $key => $literales) {
                        $promedios[$facetas[$value['id_faceta']]] = array_sum($porc_por_preguntas[$literales])/$preg_x_faceta;
                        $table .= '<td align="center" style="vertical-align:middle;">'.$promedios[$facetas[$value['id_faceta']]].'</td>';
                    }

                    if($tipo == 1){
                        $table .= '<td align="center" style="vertical-align:middle;"><a href="'.PUERTO."://".HOST.'/generaInforme/'.$value['id_usuario'].'/0/" title="Descargar informe de '.$value['nombres'].' '.$value['apellidos'].'" target="_blank"><i class="fa fa-download"></i></a></td>';
                    }
                    $table .= '</tr>';
                  $cont_opciones = 0;
                }
            }
            
            $table .= '</tbody>
          </table>';
        return $table;
    }

    public function generarExcel($table){

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=data.xls");
        echo $table;
    }

    public function generaInforme($datos){

      //$mpdf=new mPDF('','A4');
      $facetas = $datos['facetas'];
      $preg_x_faceta = Modelo_Pregunta::totalPregXfaceta()['cantd_preguntas'];
      $datosusuario = $datos['datosusuario'];//Modelo_Usuario::obtieneNombres($idusuario);
      $preguntas = $datos['preguntas'];//Modelo_Respuesta::resultadoxUsuario($idusuario);
      $informe = '<h3 align="center">Informe CANEA '.$datosusuario['nombres'].' '.$datosusuario['apellidos'].'</h3><br>';
      $faceta_ant = 1;
      $cantd_preg = 0;

      foreach($preguntas as $key => $pregunta){
        
        $cantd_preg++;
        $resultado = Modelo_Baremo::obtienePuntaje($pregunta['orden1'],$pregunta['orden2'],$pregunta['orden3'],$pregunta['orden4'],$pregunta['orden5']);
        $descriptor = Modelo_Descriptor::obtieneTextos($pregunta['id_competencia'],$resultado['id_puntaje']);        
        if ($pregunta['id_faceta'] != $faceta){

          $faceta = $pregunta['id_faceta'];
          $datosfaceta = Modelo_Faceta::consultaIndividual($pregunta['id_faceta']);
          $informe .= '<p align="justify"><i><u><b>'.utf8_encode($datosfaceta['descripcion'])."</b></u></i></p>";
          $informe .= '<p align="justify"><b>'.utf8_encode($datosfaceta['introduccion'])."</b></p>";
        }
        $informe .= '<p align="justify">'.utf8_encode($descriptor['descripcion'])."</p>";
        
        if($cantd_preg == $preg_x_faceta){
            
            $cantd_preg = 0;
            $informe .= '<img id="grafico'.$faceta_ant.'" src="_grafico'.$faceta_ant.'" class="img-responsive">';
            $faceta_ant++;
        }
      }

      return $informe;
      //$mpdf->WriteHTML($informe);
      //$mpdf->Output('informe_'.$datosusuario['nombres'].' '.$datosusuario['apellidos'].".pdf", 'D');
    }

    public function generaGrafico(){

        //$result = Modelo_Usuario::prueba();
        $result[] = array('gender'=>'Female','number'=>'100');
        
        $variable = Vista::display('admin/generarGrafico',array('datos'=>array($result,$result,$result)));
        //ob_flush();
        echo $variable;
    }
}
?>
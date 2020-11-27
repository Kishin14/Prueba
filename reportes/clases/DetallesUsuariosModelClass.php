<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetallesUsuariosModel extends Db{

  private $Permisos;
  
 public function getReporte1($condicion_permiso,$condicion_tipo,$condicion_oficina,$condicion_usuario,$usuario_id,$tipo,$oficina_id,$permiso_id,$Conex){ 

	  $select_permisos = " SELECT permiso_id, descripcion FROM permiso";	
	  $result_permisos = $this -> DbFetchAll($select_permisos,$Conex);
	  $cadenasql="";
	  for($i=0;$i<count($result_permisos);$i++){
		$descr_permiso=$result_permisos[$i][descripcion];
		$permiso_id=$result_permisos[$i][permiso_id];		
		$cadenasql.="IF((SELECT permiso_opcion_actividad_id FROM permiso_opcion_actividad WHERE opciones_actividad_id=o.opciones_actividad_id AND permiso_id=$permiso_id LIMIT 1 )>0,'SI','NO') AS $descr_permiso,";
		
	}
	$cadenasql=substr($cadenasql,0,-1);
 	$select="SELECT o.*, 
	(SELECT nombre FROM oficina WHERE oficina_id=o.oficina_id) AS nombre_oficina,
	a.descripcion AS actividad,
	IF(
	   (SELECT descripcion FROM actividad WHERE consecutivo=a.nivel_superior AND modulo=1)!='',
	   	(SELECT descripcion FROM actividad WHERE consecutivo=a.nivel_superior AND modulo=1), 
		IF((SELECT descripcion FROM actividad WHERE consecutivo=(SELECT nivel_superior FROM actividad WHERE consecutivo= a.nivel_superior) AND modulo=1)!='',
			(SELECT descripcion FROM actividad WHERE consecutivo=(SELECT nivel_superior FROM actividad WHERE consecutivo= a.nivel_superior) AND modulo=1),
			(SELECT descripcion FROM actividad WHERE consecutivo=(SELECT nivel_superior FROM actividad WHERE consecutivo=(SELECT nivel_superior FROM actividad WHERE consecutivo= a.nivel_superior)) AND modulo=1)
		)
	)AS nombre_modulo,
	   
	   
	(SELECT descripcion FROM actividad WHERE consecutivo=a.nivel_superior AND modulo=0) AS nivel_superior,	
	(SELECT CONCAT_WS(' ',t.primer_nombre,t.primer_apellido,' - ',t.numero_identificacion) FROM tercero t, usuario u WHERE u.usuario_id=o.usuario_id AND t.tercero_id = u.tercero_id) AS nombre_usuario,
	$cadenasql
	FROM opciones_actividad o, actividad a WHERE $condicion_usuario  $condicion_oficina  o.consecutivo!=1 AND o.consecutivo!=100  AND a.consecutivo=o.consecutivo AND a.modulo=0 
	AND (a.url_destino IS NOT NULL  OR a.url_destino!='')
	ORDER  BY o.usuario_id ASC, o.oficina_id ASC, nombre_modulo ASC";
	  
	 // echo $select;
	  $results = $this -> DbFetchAll($select,$Conex);
	  return $results;
  }    
}

?>
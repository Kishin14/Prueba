<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetallesModel extends Db{

  private $Permisos;
  
  public function getReporteFP1($tablas_id,$desde,$hasta,$usuario_id,$palabra_consul,$Conex){
	   	
		$select = "SELECT CASE  l.sentencia WHEN 'INSERT' THEN 'INGRESO' WHEN 'UPDATE' THEN 'ACTUALIZACION' ELSE 'ELIMINACION' END AS sentencia, l.query, l.registro_json, l.fecha, l.hora, l.tabla,
				(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido, t.segundo_apellido,t.razon_social)  FROM usuario u, tercero t WHERE u.usuario_id=l.usuario_id AND t.tercero_id=u.tercero_id) AS user
				FROM log_transacciones  l
				WHERE l.usuario_id=$usuario_id  AND l.fecha BETWEEN '$desde' AND '$hasta' AND l.tabla IN ($tablas_id) $palabra_consul
				ORDER BY user, l.tabla ASC "; 
    	$result = $this -> DbFetchAll($select,$Conex);

		return $result;
  
  }
  public function getReporteEC1($tablas_id,$desde,$hasta,$usuario_id,$palabra_consul,$Conex){
	   	
		$select = "SELECT CASE  l.sentencia WHEN 'INSERT' THEN 'INGRESO' WHEN 'UPDATE' THEN 'ACTUALIZACION' ELSE 'ELIMINACION' END AS sentencia, l.query, l.registro_json, l.fecha, l.hora, l.tabla,
				(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido, t.segundo_apellido,t.razon_social)  FROM usuario u, tercero t WHERE u.usuario_id=l.usuario_id AND t.tercero_id=u.tercero_id) AS user
				FROM log_transacciones  l
				WHERE l.usuario_id=$usuario_id AND  l.sentencia='INSERT'  AND l.fecha BETWEEN '$desde' AND '$hasta' AND l.tabla IN ($tablas_id) $palabra_consul
				ORDER BY user, l.tabla ASC ";
    	$result = $this -> DbFetchAll($select,$Conex);

		return $result;
  
  }
  public function getReportePE1($tablas_id,$desde,$hasta,$usuario_id,$palabra_consul,$Conex){
	   	
		$select = "SELECT CASE  l.sentencia WHEN 'INSERT' THEN 'INGRESO' WHEN 'UPDATE' THEN 'ACTUALIZACION' ELSE 'ELIMINACION' END AS sentencia, l.query, l.registro_json, l.fecha, l.hora, l.tabla,
				(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido, t.segundo_apellido,t.razon_social)  FROM usuario u, tercero t WHERE u.usuario_id=l.usuario_id AND t.tercero_id=u.tercero_id) AS user
				FROM log_transacciones  l
				WHERE l.usuario_id=$usuario_id AND  l.sentencia='UPDATE'  AND l.fecha BETWEEN '$desde' AND '$hasta' AND l.tabla IN ($tablas_id) $palabra_consul
				ORDER BY user, l.tabla ASC ";
    	$result = $this -> DbFetchAll($select,$Conex);

		return $result;
  
  }
  public function getReporteDL1($tablas_id,$desde,$hasta,$usuario_id,$palabra_consul,$Conex){
	   	
		$select = "SELECT CASE  l.sentencia WHEN 'INSERT' THEN 'INGRESO' WHEN 'UPDATE' THEN 'ACTUALIZACION' ELSE 'ELIMINACION' END AS sentencia, l.query, l.registro_json, l.fecha, l.hora, l.tabla,
				(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido, t.segundo_apellido,t.razon_social)  FROM usuario u, tercero t WHERE u.usuario_id=l.usuario_id AND t.tercero_id=u.tercero_id) AS user
				FROM log_transacciones  l
				WHERE l.usuario_id=$usuario_id AND  l.sentencia='DELETE'  AND l.fecha BETWEEN '$desde' AND '$hasta' AND l.tabla IN ($tablas_id) $palabra_consul
				ORDER BY user, l.tabla ASC ";
    	$result = $this -> DbFetchAll($select,$Conex);

		return $result;
  }
  
  public function getReporteFP_ALL($tablas_id,$desde,$hasta,$palabra_consul,$Conex){
	   	
		$select = "SELECT CASE  l.sentencia WHEN 'INSERT' THEN 'INGRESO' WHEN 'UPDATE' THEN 'ACTUALIZACION' ELSE 'ELIMINACION' END AS sentencia, l.query, l.registro_json, l.fecha, l.hora, l.tabla,
				(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido, t.segundo_apellido,t.razon_social)  FROM usuario u, tercero t WHERE u.usuario_id=l.usuario_id AND t.tercero_id=u.tercero_id) AS user
				FROM log_transacciones  l
				WHERE  l.fecha BETWEEN '$desde' AND '$hasta' AND l.tabla IN ($tablas_id) $palabra_consul
				ORDER BY user, l.tabla ASC ";
    	$result = $this -> DbFetchAll($select,$Conex);

		return $result;
  }
  public function getReporteEC_ALL($tablas_id,$desde,$hasta,$palabra_consul,$Conex){
	   	
		$select = "SELECT CASE  l.sentencia WHEN 'INSERT' THEN 'INGRESO' WHEN 'UPDATE' THEN 'ACTUALIZACION' ELSE 'ELIMINACION' END AS sentencia, l.query, l.registro_json, l.fecha, l.hora, l.tabla,
				(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido, t.segundo_apellido,t.razon_social)  FROM usuario u, tercero t WHERE u.usuario_id=l.usuario_id AND t.tercero_id=u.tercero_id) AS user
				FROM log_transacciones  l
				WHERE  l.sentencia='INSERT'  AND l.fecha BETWEEN '$desde' AND '$hasta' AND l.tabla IN ($tablas_id) $palabra_consul
				ORDER BY user, l.tabla ASC ";
    	$result = $this -> DbFetchAll($select,$Conex);

		return $result;
  
  }
  public function getReportePE_ALL($tablas_id,$desde,$hasta,$palabra_consul,$Conex){
	   	
		$select = "SELECT CASE  l.sentencia WHEN 'INSERT' THEN 'INGRESO' WHEN 'UPDATE' THEN 'ACTUALIZACION' ELSE 'ELIMINACION' END AS sentencia, l.query, l.registro_json, l.fecha, l.hora, l.tabla,
				(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido, t.segundo_apellido,t.razon_social)  FROM usuario u, tercero t WHERE u.usuario_id=l.usuario_id AND t.tercero_id=u.tercero_id) AS user
				FROM log_transacciones  l
				WHERE  l.sentencia='UPDATE'  AND l.fecha BETWEEN '$desde' AND '$hasta' AND l.tabla IN ($tablas_id) $palabra_consul
				ORDER BY user, l.tabla ASC ";
    	$result = $this -> DbFetchAll($select,$Conex);

		return $result;
  
  }
  public function getReporteDL_ALL($tablas_id,$desde,$hasta,$palabra_consul,$Conex){
	   	
		$select = "SELECT CASE  l.sentencia WHEN 'INSERT' THEN 'INGRESO' WHEN 'UPDATE' THEN 'ACTUALIZACION' ELSE 'ELIMINACION' END AS sentencia, l.query, l.registro_json, l.fecha, l.hora, l.tabla,
				(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido, t.segundo_apellido,t.razon_social)  FROM usuario u, tercero t WHERE u.usuario_id=l.usuario_id AND t.tercero_id=u.tercero_id) AS user
				FROM log_transacciones  l
				WHERE  l.sentencia='DELETE'  AND l.fecha BETWEEN '$desde' AND '$hasta' AND l.tabla IN ($tablas_id) $palabra_consul
				ORDER BY user, l.tabla ASC ";
    	$result = $this -> DbFetchAll($select,$Conex);

		return $result;
  
  }
  
}



?>
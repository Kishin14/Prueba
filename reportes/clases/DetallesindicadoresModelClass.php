<?php

require_once("../../../framework/clases/DbClass.php");

require_once("../../../framework/clases/PermisosFormClass.php");

final class DetallesindicadoresModel extends Db{

  private $Permisos;

   public function getReporte($consulta_cliente,$Conex){ 
	   	
	  	$select="SELECT (SELECT logo AS logos FROM empresa WHERE empresa_id = ce.empresa_id) AS logo,(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) AS cliente FROM tercero t, empleado e WHERE t.tercero_id=e.tercero_id AND s.empleado_id=e.empleado_id)AS empleado,(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) AS cliente FROM tercero t, empleado e WHERE t.tercero_id=e.tercero_id AND s.empleado_id=e.empleado_id)AS empleado,s.numero_contrato,CONCAT(s.prefijo,' - ',s.numero_contrato)AS prefijo,(SELECT t.numero_identificacion FROM tercero t, empleado e WHERE t.tercero_id=e.tercero_id AND s.empleado_id=e.empleado_id)AS cedula_empleado,s.fecha_inicio,(CASE WHEN s.fecha_terminacion != '' THEN s.fecha_terminacion WHEN s.fecha_terminacion = '' AND s.fecha_terminacion_real != '' THEN s.fecha_terminacion_real ELSE 'N/A' END)AS fecha_terminacion,s.contrato_id,(SELECT nombre FROM tipo_contrato WHERE s.tipo_contrato_id=tipo_contrato_id)AS tipo_contrato,(SELECT descripcion FROM tipo_contrato WHERE s.tipo_contrato_id=tipo_contrato_id)AS descripcion_contrato,(SELECT nombre_cargo FROM cargo WHERE s.cargo_id=cargo_id)AS cargo,s.lugar_expedicion_doc,s.lugar_trabajo,s.sueldo_base,s.subsidio_transporte,ce.nombre AS centro_costo,(SELECT CONCAT(clase_riesgo,' - %',porcentaje)FROM categoria_arl WHERE categoria_arl_id= s.categoria_arl_id)AS categoria_arl,(CASE WHEN periodicidad ='H' THEN 'HORAS' WHEN periodicidad ='D' THEN 'DIAS' WHEN periodicidad ='S' THEN 'SEMANAL' WHEN periodicidad ='Q' THEN 'QUINCENAL' ELSE 'MENSUAL' END)AS periocidad,(CASE WHEN area_laboral ='O' THEN 'OPERATIVA' WHEN area_laboral ='A' THEN 'ADMINISTRATIVO' ELSE 'COMERCIAL' END)AS area,(SELECT nombre FROM motivo_terminacion WHERE motivo_terminacion_id=s.motivo_terminacion_id)AS motivo_terminacion_id,(SELECT nombre FROM causal_despido WHERE causal_despido_id=s.causal_despido_id)AS causal_despido_id,s.fecha_terminacion_real,
		CASE s.estado WHEN 'A' THEN '<span style=\'color:#008000;\'>
		 ACTIVO</span>' WHEN 'R' THEN 'RETIRADO'  WHEN 'F' THEN 
		'<span style=\'color:#FF0000;\'>
		 FINALIZADO</span>' ELSE 'ANULADO' END AS estado
        FROM contrato s, centro_de_costo ce WHERE $consulta_cliente AND ce.centro_de_costo_id=s.centro_de_costo_id";

	  
	  $results = $this -> DbFetchAll($select,$Conex,true);		  
	  $i=0;
	  return $results;
  }  

  public function get_licencia($contrato_id,$Conex){ 


	$fecha_actual = date('Y-m-d');

	$select="SELECT s.contrato_id,(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) AS cliente FROM tercero t, empleado e WHERE t.tercero_id=e.tercero_id AND s.empleado_id=e.empleado_id)AS empleado,s.fecha_inicio,s.fecha_terminacion_real,DATEDIFF(IF(s.fecha_terminacion_real!='',s.fecha_terminacion_real,'$fecha_actual'),s.fecha_inicio)AS dias_totales,IF((SELECT l.fecha_final FROM licencia l WHERE l.contrato_id=s.contrato_id AND l.estado='A')!='',DATEDIFF((SELECT l.fecha_final FROM licencia l WHERE l.contrato_id=s.contrato_id),(SELECT l.fecha_inicial FROM licencia l WHERE l.contrato_id=s.contrato_id)),'0')AS dias_fallados,IF((SELECT l.fecha_inicial FROM licencia l WHERE l.contrato_id=s.contrato_id AND l.estado='A')!='',((DATEDIFF(IF(s.fecha_terminacion_real!='',s.fecha_terminacion_real,'$fecha_actual'),s.fecha_inicio))-(DATEDIFF((SELECT l.fecha_final FROM licencia l WHERE l.contrato_id=s.contrato_id),(SELECT l.fecha_inicial FROM licencia l WHERE l.contrato_id=s.contrato_id)))),((DATEDIFF(IF(s.fecha_terminacion_real!='',s.fecha_terminacion_real,'$fecha_actual'),s.fecha_inicio))-(0)))AS dias_laborados,s.numero_contrato FROM contrato s WHERE s.contrato_id = $contrato_id";


	  $results = $this -> DbFetchAll($select,$Conex,true);	

	  $i=0;

	  return $results;
  }

  public function get_extras($contrato_id,$Conex){ 

	$select_contrato="SELECT s.fecha_inicio,s.fecha_terminacion_real FROM contrato s WHERE $contrato_id";

	$results_contrato = $this -> DbFetchAll($select_contrato,$Conex,true);	
	$fecha_inicio = $results_contrato[0]['fecha_inicio'];
	$fecha_terminacion_real = $results_contrato[0]['fecha_terminacion_real'];

	$fecha_actual = date('Y-m-d');

	if ($fecha_terminacion_real!='') {
		$consulta_fecha ="AND s.fecha_inicial BETWEEN '".$fecha_inicio."' AND '".$fecha_terminacion_real."'";
	}else {
		$consulta_fecha ="AND s.fecha_inicial BETWEEN '".$fecha_inicio."' AND '".$fecha_actual."'";
	}

	$select="SELECT  s.*,(SUM(s.vr_horas_diurnas)+SUM(s.vr_horas_nocturnas)+SUM(s.vr_horas_diurnas_fes)+SUM(s.vr_horas_nocturnas_fes)+SUM(s.vr_horas_recargo_noc)+SUM(s.vr_horas_recargo_doc))AS total_valor,(SUM(s.horas_diurnas)+SUM(s.horas_nocturnas)+SUM(s.horas_diurnas_fes)+SUM(s.horas_nocturnas_fes)+SUM(s.horas_recargo_noc)+SUM(s.horas_recargo_doc))AS total_cant
	FROM hora_extra s WHERE s.contrato_id = $contrato_id $consulta_fecha";

	  $results = $this -> DbFetchAll($select,$Conex,true);	

	  $i=0;
	  return $results;
  }

  public function get_novedad($contrato_id,$Conex){ 

	$select_contrato="SELECT s.fecha_inicio,s.fecha_terminacion_real FROM contrato s WHERE $contrato_id";

	$results_contrato = $this -> DbFetchAll($select_contrato,$Conex,true);	
	$fecha_inicio = $results_contrato[0]['fecha_inicio'];
	$fecha_terminacion_real = $results_contrato[0]['fecha_terminacion_real'];

	$fecha_actual = date('Y-m-d');

	if ($fecha_terminacion_real!='') {
		$consulta_fecha ="AND s.fecha_inicial BETWEEN '".$fecha_inicio."' AND '".$fecha_terminacion_real."'";
	}else {
		$consulta_fecha ="AND s.fecha_inicial BETWEEN '".$fecha_inicio."' AND '".$fecha_actual."'";
	}

	$select="SELECT s.concepto_area_id,(SELECT c.descripcion FROM concepto_area c WHERE c.concepto_area_id=s.concepto_area_id)AS concepto_area,COUNT(s.concepto_area_id)AS total FROM novedad_fija s WHERE s.contrato_id = $contrato_id $consulta_fecha AND s.estado='A' GROUP BY s.concepto_area_id";

	  $results = $this -> DbFetchAll($select,$Conex,true);	

	  $i=0;
	  return $results;
  } 

}



?>
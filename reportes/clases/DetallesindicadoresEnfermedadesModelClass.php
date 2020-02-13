<?php

require_once("../../../framework/clases/DbClass.php");

require_once("../../../framework/clases/PermisosFormClass.php");

final class DetallesindicadoresEnfermedadesModel extends Db{

  private $Permisos;

   public function getReporte($desde,$hasta,$tipo,$Conex){ 
	   	
	  	$select="SELECT l.licencia_id,
		                COUNT(l.licencia_id)AS numero,
                          l.concepto,
                          l.fecha_licencia,
                          l.fecha_inicial,
                          l.fecha_final,
                          l.dias,
                          l.contrato_id,
                          (CASE l.estado WHEN 'A' THEN 'ACTIVO' ELSE 'INACTIVO' END)AS estado,
                          (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
                           FROM tercero t, empleado e, contrato c 
                           WHERE t.tercero_id=e.tercero_id AND e.empleado_id=c.empleado_id AND c.contrato_id=l.contrato_id)AS contrato,
                          (SELECT CONCAT_WS('-',c.codigo,c.descripcion) FROM cie_enfermedades c WHERE c.cie_enfermedades_id=l.cie_enfermedades_id)AS enfermedad,
                          (CASE l.remunerado WHEN 1 THEN 'SI' ELSE 'NO' END)AS remunerado

		
				   FROM licencia l
				   WHERE l.fecha_inicial BETWEEN '$desde' AND '$hasta' AND (SELECT t.tipo FROM tipo_incapacidad t WHERE t.tipo_incapacidad_id=l.tipo_incapacidad_id) = '$tipo' GROUP BY l.contrato_id";
    
	  $results = $this -> DbFetchAll($select,$Conex,true);
	  		  
	  $i=0;
	  return $results;
  }  

  public function getReporte1($desde,$hasta,$tipo,$Conex){ 
	   	
	  	$select="SELECT l.licencia_id,
		                COUNT(l.licencia_id)AS numero,
                          l.concepto,
                          l.fecha_licencia,
                          l.fecha_inicial,
                          l.fecha_final,
                          l.dias,
                          l.contrato_id,
                          (CASE l.estado WHEN 'A' THEN 'ACTIVO' ELSE 'INACTIVO' END)AS estado,
                          (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
                           FROM tercero t, empleado e, contrato c 
                           WHERE t.tercero_id=e.tercero_id AND e.empleado_id=c.empleado_id AND c.contrato_id=l.contrato_id)AS contrato,
                          (SELECT CONCAT_WS('-',c.codigo,c.descripcion) FROM cie_enfermedades c WHERE c.cie_enfermedades_id=l.cie_enfermedades_id)AS enfermedad,
                          (CASE l.remunerado WHEN 1 THEN 'SI' ELSE 'NO' END)AS remunerado

		
				   FROM licencia l
				   WHERE l.fecha_inicial BETWEEN '$desde' AND '$hasta' AND (SELECT t.tipo FROM tipo_incapacidad t WHERE t.tipo_incapacidad_id=l.tipo_incapacidad_id) = '$tipo' GROUP BY l.contrato_id";

	  
	  $results = $this -> DbFetchAll($select,$Conex,true);		  
	  $i=0;
	  return $results;
  }  

  public function getReporte2($desde,$hasta,$tipo,$empleado_id,$Conex){ 
	   	
	  	$select="SELECT l.licencia_id,
		                COUNT(l.licencia_id)AS numero,
                          l.concepto,
                          l.fecha_licencia,
                          l.fecha_inicial,
                          l.fecha_final,
                          l.dias,
                          l.contrato_id,
                          (CASE l.estado WHEN 'A' THEN 'ACTIVO' ELSE 'INACTIVO' END)AS estado,
                          (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
                           FROM tercero t, empleado e, contrato c 
                           WHERE t.tercero_id=e.tercero_id AND e.empleado_id=c.empleado_id AND c.contrato_id=l.contrato_id)AS contrato,
                          (SELECT CONCAT_WS('-',c.codigo,c.descripcion) FROM cie_enfermedades c WHERE c.cie_enfermedades_id=l.cie_enfermedades_id)AS enfermedad,
                          (CASE l.remunerado WHEN 1 THEN 'SI' ELSE 'NO' END)AS remunerado

		
				   FROM licencia l
				   WHERE l.fecha_inicial BETWEEN '$desde' AND '$hasta' AND (SELECT t.tipo FROM tipo_incapacidad t WHERE t.tipo_incapacidad_id=l.tipo_incapacidad_id) = '$tipo' AND (SELECT e.empleado_id FROM contrato c, empleado e WHERE e.empleado_id=c.empleado_id AND c.contrato_id = l.contrato_id) = $empleado_id GROUP BY l.contrato_id";

	  
	  $results = $this -> DbFetchAll($select,$Conex,true);		  
	  $i=0;
	  return $results;
  }  

  public function getReporte3($desde,$hasta,$tipo,$empleado_id,$Conex){ 
	   	
	  	$select="SELECT l.licencia_id,
		                COUNT(l.licencia_id)AS numero,
                          l.concepto,
                          l.fecha_licencia,
                          l.fecha_inicial,
                          l.fecha_final,
                          l.dias,
                          l.contrato_id,
                          (CASE l.estado WHEN 'A' THEN 'ACTIVO' ELSE 'INACTIVO' END)AS estado,
                          (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
                           FROM tercero t, empleado e, contrato c 
                           WHERE t.tercero_id=e.tercero_id AND e.empleado_id=c.empleado_id AND c.contrato_id=l.contrato_id)AS contrato,
                          (SELECT CONCAT_WS('-',c.codigo,c.descripcion) FROM cie_enfermedades c WHERE c.cie_enfermedades_id=l.cie_enfermedades_id)AS enfermedad,
                          (CASE l.remunerado WHEN 1 THEN 'SI' ELSE 'NO' END)AS remunerado

		
				   FROM licencia l
				   WHERE l.fecha_inicial BETWEEN '$desde' AND '$hasta' AND (SELECT t.tipo FROM tipo_incapacidad t WHERE t.tipo_incapacidad_id=l.tipo_incapacidad_id) = '$tipo' AND (SELECT e.empleado_id FROM contrato c, empleado e WHERE e.empleado_id=c.empleado_id AND c.contrato_id = l.contrato_id) = $empleado_id GROUP BY l.contrato_id";

	  
	  $results = $this -> DbFetchAll($select,$Conex,true);		  
	  $i=0;
	  return $results;
  }  

  public function getReporte4($desde,$hasta,$tipo,$cie_enfermedades_id,$Conex){ 
	   	
	  	$select="SELECT l.licencia_id,
		                  COUNT(l.licencia_id)AS numero,
                          l.concepto,
                          l.fecha_licencia,
                          l.fecha_inicial,
                          l.fecha_final,
                          l.dias,
                          (CASE l.estado WHEN 'A' THEN 'ACTIVO' ELSE 'INACTIVO' END)AS estado,
                          (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
                           FROM tercero t, empleado e, contrato c 
                           WHERE t.tercero_id=e.tercero_id AND e.empleado_id=c.empleado_id AND c.contrato_id=l.contrato_id)AS contrato,
                          IF((SELECT c.descripcion FROM cie_enfermedades c WHERE c.cie_enfermedades_id=l.cie_enfermedades_id) != '', (SELECT CONCAT_WS('-',c.codigo,c.descripcion) FROM cie_enfermedades c WHERE c.cie_enfermedades_id=l.cie_enfermedades_id),'N/A')AS enfermedad,
                          (CASE l.remunerado WHEN 1 THEN 'SI' ELSE 'NO' END)AS remunerado

		
				   FROM licencia l
				   WHERE l.fecha_inicial BETWEEN '$desde' AND '$hasta'AND l.cie_enfermedades_id = $cie_enfermedades_id AND (SELECT t.tipo FROM tipo_incapacidad t WHERE t.tipo_incapacidad_id=l.tipo_incapacidad_id) = '$tipo' GROUP BY l.contrato_id";


	  
	  $results = $this -> DbFetchAll($select,$Conex,true);		  
	  $i=0;
	  return $results;
  }  

  /* public function get_licencia($contrato_id,$Conex){ 


	$fecha_actual = date('Y-m-d');

	$select="SELECT l.licencia_id,
	                COUNT(l.licencia_id)AS numero,
                    l.concepto,
                    l.fecha_licencia,
                    l.fecha_inicial,
                    l.fecha_final,
                    l.dias,
                    l.contrato_id,
                          (CASE l.estado WHEN 'A' THEN 'ACTIVO' ELSE 'INACTIVO' END)AS estado,
                          (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
                           FROM tercero t, empleado e, contrato c 
                           WHERE t.tercero_id=e.tercero_id AND e.empleado_id=c.empleado_id AND c.contrato_id=l.contrato_id)AS contrato,
                          (SELECT CONCAT_WS('-',c.codigo,c.descripcion) FROM cie_enfermedades c WHERE c.cie_enfermedades_id=l.cie_enfermedades_id)AS enfermedad,
                          (CASE l.remunerado WHEN 1 THEN 'SI' ELSE 'NO' END)AS remunerado
            
            FROM licencia l WHERE l.contrato_id = $contrato_id";


	  $results = $this -> DbFetchAll($select,$Conex,true);	

	  $i=0;

	  return $results;
  } */

  /* public function get_extras($contrato_id,$Conex){ 

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
  }  */

}



?>
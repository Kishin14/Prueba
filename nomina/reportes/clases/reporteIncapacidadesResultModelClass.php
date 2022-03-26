<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class reporteIncapacidadesResultModel extends Db{

  private $Permisos;
  
  public function getReporteMC1($desde,$hasta,$tipo,$Conex){ 

	    $select = "SELECT l.licencia_id,
                          l.concepto,
                          l.fecha_licencia,
                          l.fecha_inicial,
                          l.fecha_final,
                          l.dias,
                          (CASE l.estado WHEN 'A' THEN 'ACTIVO' ELSE 'INACTIVO' END)AS estado,
                          (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
                           FROM tercero t, empleado e, contrato c 
                           WHERE t.tercero_id=e.tercero_id AND e.empleado_id=c.empleado_id AND c.contrato_id=l.contrato_id)AS contrato,
                          (SELECT CONCAT_WS('-',c.codigo,c.descripcion) FROM cie_enfermedades c WHERE c.cie_enfermedades_id=l.cie_enfermedades_id)AS enfermedad,
                          (CASE l.remunerado WHEN 1 THEN 'SI' ELSE 'NO' END)AS remunerado

		
				   FROM licencia l
				   WHERE l.fecha_inicial BETWEEN '$desde' AND '$hasta' AND (SELECT t.tipo FROM tipo_incapacidad t WHERE t.tipo_incapacidad_id=l.tipo_incapacidad_id) = '$tipo' ORDER BY l.fecha_licencia";
		
		$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){
		
        $result[$i]=array(licencia_id=>$items[licencia_id],
                          concepto=>$items[concepto],
                          fecha_licencia=>$items[fecha_licencia],
                          fecha_inicial=>$items[fecha_inicial],
                          fecha_final=>$items[fecha_final],
                          dias=>$items[dias],
                          estado=>$items[estado],
                          contrato=>$items[contrato],
                          enfermedad=>$items[enfermedad],
                          remunerado=>$items[remunerado]
						 );
		$i++;
		}
		
		return $result;
  } 
  
      public function getReporteMC2($desde,$hasta,$tipo,$Conex){ 

	    $select = "SELECT l.licencia_id,
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
				   WHERE l.fecha_inicial BETWEEN '$desde' AND '$hasta' AND (SELECT t.tipo FROM tipo_incapacidad t WHERE t.tipo_incapacidad_id=l.tipo_incapacidad_id) = '$tipo' ORDER BY l.fecha_licencia";
		
		$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){
		
        $result[$i]=array(licencia_id=>$items[licencia_id],
                          concepto=>$items[concepto],
                          fecha_licencia=>$items[fecha_licencia],
                          fecha_inicial=>$items[fecha_inicial],
                          fecha_final=>$items[fecha_final],
                          dias=>$items[dias],
                          estado=>$items[estado],
                          contrato=>$items[contrato],
                          enfermedad=>$items[enfermedad],
                          remunerado=>$items[remunerado]
						 );
		$i++;
		}
		
		return $result;
  } 
  
        public function getReporteMC3($empleado_id,$desde,$hasta,$tipo,$Conex){ 

	    $select = "SELECT l.licencia_id,
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
				   WHERE l.fecha_inicial BETWEEN '$desde' AND '$hasta' AND (SELECT e.empleado_id FROM contrato c, empleado e WHERE e.empleado_id=c.empleado_id AND c.contrato_id = l.contrato_id) = $empleado_id AND (SELECT t.tipo FROM tipo_incapacidad t WHERE t.tipo_incapacidad_id=l.tipo_incapacidad_id) = '$tipo' ORDER BY l.fecha_licencia";
		
		$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){
		
        $result[$i]=array(licencia_id=>$items[licencia_id],
                          concepto=>$items[concepto],
                          fecha_licencia=>$items[fecha_licencia],
                          fecha_inicial=>$items[fecha_inicial],
                          fecha_final=>$items[fecha_final],
                          dias=>$items[dias],
                          estado=>$items[estado],
                          contrato=>$items[contrato],
                          enfermedad=>$items[enfermedad],
                          remunerado=>$items[remunerado]
						 );
		$i++;
		}
		
		return $result;
  } 
  
    public function getReporteMC4($empleado_id,$desde,$hasta,$tipo,$Conex){ 

	    $select = "SELECT l.licencia_id,
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
				   WHERE l.fecha_inicial BETWEEN '$desde' AND '$hasta' AND (SELECT e.empleado_id FROM contrato c, empleado e WHERE e.empleado_id=c.empleado_id AND c.contrato_id = l.contrato_id) = $empleado_id AND (SELECT t.tipo FROM tipo_incapacidad t WHERE t.tipo_incapacidad_id=l.tipo_incapacidad_id) = '$tipo' ORDER BY l.fecha_licencia";
		
		$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){
		
        $result[$i]=array(licencia_id=>$items[licencia_id],
                          concepto=>$items[concepto],
                          fecha_licencia=>$items[fecha_licencia],
                          fecha_inicial=>$items[fecha_inicial],
                          fecha_final=>$items[fecha_final],
                          dias=>$items[dias],
                          estado=>$items[estado],
                          contrato=>$items[contrato],
                          enfermedad=>$items[enfermedad],
                          remunerado=>$items[remunerado]
						 );
		$i++;
		}
		
		return $result;
  }

  public function getReporteMC5($desde,$hasta,$tipo,$cie_enfermedades_id,$Conex){ 

	    $select = "SELECT l.licencia_id,
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
				   WHERE l.fecha_inicial BETWEEN '$desde' AND '$hasta'AND l.cie_enfermedades_id = $cie_enfermedades_id AND (SELECT t.tipo FROM tipo_incapacidad t WHERE t.tipo_incapacidad_id=l.tipo_incapacidad_id) = '$tipo' ORDER BY l.fecha_licencia";
		
		$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){
		
        $result[$i]=array(licencia_id=>$items[licencia_id],
                          concepto=>$items[concepto],
                          fecha_licencia=>$items[fecha_licencia],
                          fecha_inicial=>$items[fecha_inicial],
                          fecha_final=>$items[fecha_final],
                          dias=>$items[dias],
                          estado=>$items[estado],
                          contrato=>$items[contrato],
                          enfermedad=>$items[enfermedad],
                          remunerado=>$items[remunerado]
						 );
		$i++;
		}
		
		return $result;
  }


}

?>
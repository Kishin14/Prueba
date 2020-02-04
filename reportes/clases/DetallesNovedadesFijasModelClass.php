<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetallesNovedadesFijasModel extends Db{

  private $Permisos;
  
  public function getReporteMC1($desde,$hasta,$Conex){ 

	    $select = "SELECT n.*,(SELECT CONCAT_WS(' ', t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, empleado e, contrato c
      			 WHERE t.tercero_id=e.tercero_id AND c.empleado_id=e.empleado_id AND c.contrato_id = n.contrato_id)AS contrato_id,
				 
				 (SELECT t.numero_identificacion FROM tercero t WHERE t.tercero_id = n.tercero_id ) as numero_identificacion,
				  
				  CASE n.tipo_novedad WHEN 'v' THEN 'DEVENGADO' WHEN 'D' THEN 'DEDUCIDO'  END AS tipo_novedad,
				 
				 CASE n.periodicidad WHEN 'M' THEN 'MENSUAL' WHEN 'Q' THEN 'QUINCENAL' WHEN 'S' THEN 'SEMANAL' END AS periodicidad,
				     CASE n.estado WHEN 'A' THEN 'ACTIVO' WHEN 'I' THEN 'INACTIVO'  END AS estado,
				  
				  CASE n.concepto_area_id WHEN '3' THEN 'BONIFICACION' WHEN '1' THEN 'DESCUENTO DE PAGO PRONTO' WHEN '4' THEN 'PRESTAMOS A EMPLEADOS' WHEN '2' THEN 'VIATICOS' END AS concepto_area_id
				 
				 From novedad_fija n ";
		//exit($select);
		$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){
		
		$result[$i]=array(novedad_fija_id=>$items[novedad_fija_id],concepto=>$items[concepto],fecha_novedad=>$items[fecha_novedad],fecha_inicial=>$items[fecha_inicial],fecha_final=>$items[fecha_final],cuotas=>$items[cuotas],valor=>$items[valor],valor_cuota=>$items[valor_cuota],periodicidad=>$items[periodicidad],tipo_novedad=>$items[tipo_novedad],estado=>$items[estado],contrato_id=>$items[contrato_id],tercero_id=>$items[tercero_id],concepto_area_id=>$items[concepto_area_id],encabezado_registro_id=>$items[encabezado_registro_id],factura_proveedor_id=>$items[factura_proveedor_id],documento_anexo=>$items[documento_anexo],numero_identificacion=>$items[numero_identificacion]);
		$i++;
		}
		
		return $result;
  } 
  
	public function getReporteMC2($empleado_id,$desde,$hasta,$Conex){ 

	     $select = "SELECT n.*,(SELECT CONCAT_WS(' ', t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, empleado e, contrato c
      			 WHERE t.tercero_id=e.tercero_id AND c.empleado_id=e.empleado_id AND c.contrato_id = n.contrato_id )AS contrato_id, (SELECT t.numero_identificacion FROM tercero t WHERE t.tercero_id = n.tercero_id ) as numero_identificacion,
				 
				  CASE n.tipo_novedad WHEN 'v' THEN 'DEVENGADO' WHEN 'D' THEN 'DEDUCIDO'  END AS tipo_novedad,
				 
				 CASE n.periodicidad WHEN 'M' THEN 'MENSUAL' WHEN 'Q' THEN 'QUINCENAL' WHEN 'S' THEN 'SEMANAL' END AS periodicidad,
				     CASE n.estado WHEN 'A' THEN 'ACTIVO' WHEN 'I' THEN 'INACTIVO'  END AS estado,
				  
				  CASE n.concepto_area_id WHEN '3' THEN 'BONIFICACION' WHEN '1' THEN 'DESCUENTO DE PAGO PRONTO' WHEN '4' THEN 'PRESTAMOS A EMPLEADOS' WHEN '2' THEN 'VIATICOS' END AS concepto_area_id
				 
				  From  novedad_fija n WHERE n.contrato_id = (SELECT contrato_id FROM contrato WHERE empleado_id =$empleado_id AND estado ='A') ";
		
		$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){
		
		$result[$i]=array(novedad_fija_id=>$items[novedad_fija_id],concepto=>$items[concepto],fecha_novedad=>$items[fecha_novedad],fecha_inicial=>$items[fecha_inicial],fecha_final=>$items[fecha_final],cuotas=>$items[cuotas],valor=>$items[valor],valor_cuota=>$items[valor_cuota],periodicidad=>$items[periodicidad],tipo_novedad=>$items[tipo_novedad],estado=>$items[estado],contrato_id=>$items[contrato_id],tercero_id=>$items[tercero_id],concepto_area_id=>$items[concepto_area_id],encabezado_registro_id=>$items[encabezado_registro_id],factura_proveedor_id=>$items[factura_proveedor_id],documento_anexo=>$items[documento_anexo],numero_identificacion=>$items[numero_identificacion]);
		$i++;
		}
		
		return $result;
  } 


	/*public function getReporteMC3($cargo_id,$desde,$hasta,$Conex){ 

	    $select = "SELECT c.*, (SELECT CONCAT_WS(' ', t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, empleado e
      			 WHERE t.tercero_id=e.tercero_id AND c.empleado_id=e.empleado_id)AS empleado_id,
				(SELECT nombre FROM tipo_contrato WHERE tipo_contrato_id=c.tipo_contrato_id)AS tipo_contrato_id,
				(SELECT nombre_cargo FROM cargo WHERE cargo_id=c.cargo_id)AS cargo_id,
				(SELECT nombre FROM motivo_terminacion WHERE motivo_terminacion_id=c.motivo_terminacion_id)AS motivo_terminacion_id, 
				(SELECT nombre FROM centro_de_costo co WHERE co.centro_de_costo_id=c.centro_de_costo_id)AS centro_de_costo_id,
				CASE periodicidad WHEN 'H' THEN 'HORAS' WHEN 'D' THEN 'DIAS' WHEN 'S' THEN 'SEMANAL' WHEN 'Q' THEN 'QUINCENAL' ELSE 'MENSUAL' END AS periodicidad,
				(SELECT nombre FROM causal_despido ca WHERE ca.causal_despido_id=c.causal_despido_id)AS causal_despido_id,
				CASE estado WHEN 'A' THEN 'ACTIVO' WHEN 'R' THEN 'RETIRADO' WHEN 'F' THEN 'FINALIZADO' ELSE 'ANULADA' END AS estado
				FROM contrato c WHERE c.cargo_id IN ($cargo_id) AND c.fecha_inicio BETWEEN '$desde' AND '$hasta' ORDER BY c.numero_contrato";
		
		$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){
		
		$result[$i]=array(numero_contrato=>$items[numero_contrato],fecha_inicio=>$items[fecha_inicio],fecha_terminacion=>$items[fecha_terminacion],fecha_terminacion_real=>$items[fecha_terminacion_real],empleado_id=>$items[empleado_id],tipo_contrato_id=>$items[tipo_contrato_id],cargo_id=>$items[cargo_id],motivo_terminacion_id=>$items[motivo_terminacion_id],sueldo_base=>$items[sueldo_base],subsidio_transporte=>$items[subsidio_transporte],centro_de_costo_id=>$items[centro_de_costo_id],periodicidad=>$items[periodicidad],causal_despido_id=>$items[causal_despido_id],estado=>$items[estado]);
		$i++;
		}
		
		return $result;
  }   

	public function getReporteMC4($empleado_id,$cargo_id,$desde,$hasta,$Conex){ 

	    $select = "SELECT c.*, (SELECT CONCAT_WS(' ', t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, empleado e
      			 WHERE t.tercero_id=e.tercero_id AND c.empleado_id=e.empleado_id)AS empleado_id,
				(SELECT nombre FROM tipo_contrato WHERE tipo_contrato_id=c.tipo_contrato_id)AS tipo_contrato_id,
				(SELECT nombre_cargo FROM cargo WHERE cargo_id=c.cargo_id)AS cargo_id,
				(SELECT nombre FROM motivo_terminacion WHERE motivo_terminacion_id=c.motivo_terminacion_id)AS motivo_terminacion_id, 
				(SELECT nombre FROM centro_de_costo co WHERE co.centro_de_costo_id=c.centro_de_costo_id)AS centro_de_costo_id,
				CASE periodicidad WHEN 'H' THEN 'HORAS' WHEN 'D' THEN 'DIAS' WHEN 'S' THEN 'SEMANAL' WHEN 'Q' THEN 'QUINCENAL' ELSE 'MENSUAL' END AS periodicidad,
				(SELECT nombre FROM causal_despido ca WHERE ca.causal_despido_id=c.causal_despido_id)AS causal_despido_id,
				CASE estado WHEN 'A' THEN 'ACTIVO' WHEN 'R' THEN 'RETIRADO' WHEN 'F' THEN 'FINALIZADO' ELSE 'ANULADA' END AS estado
				FROM contrato c WHERE c.empleado_id IN ($empleado_id) AND c.cargo_id IN ($cargo_id) AND c.fecha_inicio BETWEEN '$desde' AND '$hasta' ORDER BY c.numero_contrato";
		
		$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){
		
		$result[$i]=array(numero_contrato=>$items[numero_contrato],fecha_inicio=>$items[fecha_inicio],fecha_terminacion=>$items[fecha_terminacion],fecha_terminacion_real=>$items[fecha_terminacion_real],empleado_id=>$items[empleado_id],tipo_contrato_id=>$items[tipo_contrato_id],cargo_id=>$items[cargo_id],motivo_terminacion_id=>$items[motivo_terminacion_id],sueldo_base=>$items[sueldo_base],subsidio_transporte=>$items[subsidio_transporte],centro_de_costo_id=>$items[centro_de_costo_id],periodicidad=>$items[periodicidad],causal_despido_id=>$items[causal_despido_id],estado=>$items[estado]);
		$i++;
		}
		
		return $result;
  }  */ 

}

?>
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
				 
				 From novedad_fija n";
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
				 
				  From  novedad_fija n WHERE n.contrato_id = (SELECT contrato_id FROM contrato WHERE empleado_id =$empleado_id AND estado ='A') AND n.fecha_inicial >= DATE('$desde') AND n.fecha_final <= DATE('$hasta') ";
				  
				 
		
		$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){
		
		$result[$i]=array(novedad_fija_id=>$items[novedad_fija_id],concepto=>$items[concepto],fecha_novedad=>$items[fecha_novedad],fecha_inicial=>$items[fecha_inicial],fecha_final=>$items[fecha_final],cuotas=>$items[cuotas],valor=>$items[valor],valor_cuota=>$items[valor_cuota],periodicidad=>$items[periodicidad],tipo_novedad=>$items[tipo_novedad],estado=>$items[estado],contrato_id=>$items[contrato_id],tercero_id=>$items[tercero_id],concepto_area_id=>$items[concepto_area_id],encabezado_registro_id=>$items[encabezado_registro_id],factura_proveedor_id=>$items[factura_proveedor_id],documento_anexo=>$items[documento_anexo],numero_identificacion=>$items[numero_identificacion]);
		$i++;
		}
		
		return $result;
  } 

}

?>
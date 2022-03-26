<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class SolicPeriodosModel extends Db{

  private $Permisos;
  
  public function getSolicPeriodos($empleado_id,$Conex){
	
	if(is_numeric($empleado_id)){	
	
		$select_contrato = "SELECT c.contrato_id,c.sueldo_base,c.fecha_inicio, DATEDIFF(CURDATE(),c.fecha_inicio) as dias_trabajados
	                       FROM contrato c WHERE c.empleado_id=$empleado_id AND estado='A' ";
	//echo $select_contrato;
	$result_contrato = $this -> DbFetchAll($select_contrato,$Conex); 
	
	$fecha_inicio 	 = $result_contrato[0]['fecha_inicio'];
	$dias_trabajados = $result_contrato[0]['dias_trabajados'];
	$contrato_id	 = $result_contrato[0]['contrato_id'];
	
	$anios = intval(intval($dias_trabajados)/365);
	$fecha_aux = $fecha_inicio;
	
	$i=0;
	for($i=0;$i<$anios;$i++){
		
		//$select_periodo = "SELECT DATE_SUB((DATE_ADD('$fecha_aux',INTERVAL 1 YEAR)),INTERVAL 1 DAY) as fecha_fin";
		$select_periodo = "SELECT DATE_ADD('$fecha_aux',INTERVAL 1 YEAR) as fecha_fin";
		$result_periodo = $this -> DbFetchAll($select_periodo,$Conex); 
		//echo $select_periodo;
		$periodo[$i]['fecha_inicial']= $fecha_aux;
		$periodo[$i]['fecha_final']	 = $result_periodo[0]['fecha_fin'];
		$periodo[$i]['dias_ganados'] = 15;
		$fecha_aux = $result_periodo[0]['fecha_fin'];
		//	echo "inicio".$periodo[$i]['fecha_inicial']."fin".$periodo[$i]['fecha_final'];
	}
	
	$periodo[$i]['fecha_inicial']= $fecha_aux;
	$periodo[$i]['fecha_final']	 = date("Y-m-d");
	$sel_dias_hoy="SELECT DATEDIFF(CURDATE(),'$fecha_aux') as dias_hoy";
	$result_dias_hoy = $this -> DbFetchAll($sel_dias_hoy,$Conex); 
	$dias_hoy =	$result_dias_hoy[0]['dias_hoy'];
	$dias_disf = intval(($dias_hoy*15)/365);
	$periodo[$i]['dias_ganados'] = $dias_disf;
		
	for($j=0;$j<count($periodo);$j++){
		
		$k=1+$j;
		$select_dias_otorgados="SELECT dias_disfrutados,dias_pagados
		                        FROM detalle_liquidacion_vacaciones WHERE periodo_inicio='".$periodo[$j]['fecha_inicial']."' 
								AND periodo_fin ='".$periodo[$j]['fecha_final']."' AND  liquidacion_vacaciones_id 
								IN (SELECT liquidacion_vacaciones_id FROM liquidacion_vacaciones WHERE contrato_id=$contrato_id AND estado != 'I')";
	
		$result_dias_otorgados = $this -> DbFetchAll($select_dias_otorgados,$Conex); 
	
		$dias_otorgados 	 = $result_dias_otorgados[0]['dias_disfrutados'];
		$dias_pagados 	     = $result_dias_otorgados[0]['dias_pagados'];
		
		/*if($dias_otorgados > 0 ){
			$dias_a_disfrutar= $periodo[$j]['dias_ganados'] - $dias_otorgados;
		}else{*/
		$dias_a_disfrutar = $periodo[$j]['dias_ganados'];
		
	    $fecha_inicio_hidden = str_replace("-","",$periodo[$j]['fecha_inicial']);
		$fecha_final_hidden = str_replace("-","",$periodo[$j]['fecha_final']);
																																																				
	    $results[$j]=array(fecha_inicio_hidden=>$fecha_inicio_hidden,fecha_final_hidden=>$fecha_final_hidden,numero_periodo=>$k,inicio_periodo=>$periodo[$j]['fecha_inicial'],fin_periodo=>$periodo[$j]['fecha_final'],dias_ganados=>$dias_a_disfrutar,dias_otorgados=>$dias_otorgados,dias_pagados=>$dias_pagados);
		
		
	}
	  	/*foreach($result as $items){
			$saldo=floatval($items[valor_neto])-floatval($items[abonos]); 
			$results[$i]=array(factura_proveedor_id=>$items[factura_proveedor_id],consecutivo_id=>$items[consecutivo_id],tipo=>$items[tipo],orden_no=>$items[orden_no],manifiesto=>$items[manifiesto],codfactura_proveedor=>$items[codfactura_proveedor],fecha_factura_proveedor=>$items[fecha_factura_proveedor],valor_factura_proveedor=>$items[valor_factura_proveedor],valor_neto=>$items[valor_neto],abonos_nc=>$items[abonos_nc],abonos=>$items[abonos],saldo=>$saldo);	
			$i++;
		}*/
	}else{
   	    $results = array();
	 }
	
	return $results;
  }
}


?>
<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class Imp_NovedadModel extends Db{ 
  
  public function getdocumento($empresa_id,$Conex){
 
    $novedad_fija_id = $this -> requestDataForQuery('novedad_fija_id','integer');
	
	if(is_numeric($novedad_fija_id)){

  	    $select = "SELECT n.*,
					(SELECT logo FROM empresa WHERE empresa_id = $empresa_id) AS logo,
					(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido)AS nombre_emp FROM empresa e, tercero t WHERE e.empresa_id = $empresa_id AND e.tercero_id=t.tercero_id) AS nombre_empresa,
					(SELECT CONCAT_WS(' - ',t.numero_identificacion,t.digito_verificacion)AS nit_emp FROM empresa e, tercero t WHERE e.empresa_id = $empresa_id AND e.tercero_id=t.tercero_id) AS nit_empresa,					
					(SELECT t.direccion FROM empresa e, tercero t WHERE e.empresa_id = $empresa_id AND e.tercero_id=t.tercero_id) AS direccion_empresa,					
					(SELECT CONCAT_WS(' - ',t.telefono,t.movil)AS tel_emp FROM empresa e, tercero t WHERE e.empresa_id = $empresa_id AND e.tercero_id=t.tercero_id) AS telefono_empresa,					
					(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido)AS contrato FROM contrato c,  tercero t, empleado e WHERE c.empleado_id=e.empleado_id AND e.tercero_id=t.tercero_id AND c.contrato_id=n.contrato_id)AS contrato,
					(SELECT CONCAT_WS(' ',c.numero_contrato)AS cont FROM contrato c,  tercero t, empleado e WHERE c.empleado_id=e.empleado_id AND e.tercero_id=t.tercero_id AND c.contrato_id=n.contrato_id)AS cont,
					(SELECT CONCAT_WS(' ',t.numero_identificacion)AS contra FROM contrato c,  tercero t, empleado e WHERE c.empleado_id=e.empleado_id AND e.tercero_id=t.tercero_id AND c.contrato_id=n.contrato_id)AS contra,
					(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido)	FROM tercero t WHERE t.tercero_id=n.tercero_id )AS tercero,
					IF(n.tipo_novedad='D','DEDUCIDO','DEVENGADO')AS naturaleza,
					(SELECT descripcion FROM concepto_area WHERE concepto_area_id=n.concepto_area_id) AS tipo_novedad,
					IF(n.periodicidad='H','HORAS',IF(n.periodicidad='D','DIAS',IF(n.periodicidad='S','SEMANAL',IF(n.periodicidad='Q','QUINCENAL','MENSUAL'))))AS periodicidad, 
					IF(n.estado='A','ACTIVO','INACTIVO') AS estado
					FROM novedad_fija n 
					WHERE n.novedad_fija_id=$novedad_fija_id";
	  $result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }
  
  public function getDetallesNovedad($Conex){
  
	$novedad_fija_id = $this -> requestDataForQuery('novedad_fija_id','integer');
	
	if(is_numeric($novedad_fija_id)){
	
		$select  = "SELECT * FROM novedad_fija WHERE novedad_fija_id = $novedad_fija_id";	

		$result  = $this -> DbFetchAll($select,$Conex,true);
		
		$num_cuotas 	= $result[0]['cuotas'];
		$periodicidad 	= $result[0]['periodicidad'];
		$valor_cuota  	= $result[0]['valor_cuota'];
		$fecha_inicial 	= $result[0]['fecha_inicial'];
		$valor			= $result[0]['valor'];
		
		if($periodicidad=='S'){
			$dias_sumar = 'INTERVAL 7 DAY';
		}elseif($periodicidad=='Q'){
			$dias_sumar = 'INTERVAL 15 DAY';
		}elseif($periodicidad=='M'){
			$dias_sumar = 'INTERVAL 1 MONTH';
		}elseif($periodicidad=='D'){
			$dias_sumar = 'INTERVAL 1 DAY';
		}
		
		$fecha_aux = $fecha_inicial;
		$saldo 	   = $valor;
		
		for($i==0;$i<intval($num_cuotas);$i++){
			
			$select_fecha ="SELECT DATE_ADD('$fecha_aux',$dias_sumar)as dias";
			$result_fecha = $this -> DbFetchAll($select_fecha,$Conex,true);
			$fecha_aux = $result_fecha[0]['dias'];
			
			$saldo = $saldo-$valor_cuota;
			
			$resultado[$i]['num_cuota'] = $i+1;
			$resultado[$i]['fecha_cuota'] = $fecha_aux;
			$resultado[$i]['valor_cuota'] = intval($valor_cuota);
			$resultado[$i]['saldo'] = $saldo;
			
					
		}
		
	  
	}else{
   	    $result = array();
	  }
	return $resultado;
  } 
   
}


?>
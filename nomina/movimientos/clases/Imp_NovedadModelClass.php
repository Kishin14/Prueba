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
		
		$num_cuotas   = $result[0]['cuotas'];
		$periodicidad = $result[0]['periodicidad'];
		$valor_cuota  = $result[0]['valor_cuota'];
		$fecha_inicial= $result[0]['fecha_inicial'];
		$valor		  = $result[0]['valor'];

		$fecha_aux    = $fecha_inicial;
		$saldo 	      = $valor;


		$tiempoInicio = strtotime($fecha_inicial); # Fecha como segundos
		$i            = 0;
		$dia 		  = 86400;  #cant. de segundos que contiene un dia



	   /* ====================Orden de quincenas (Primera y segunda quincena) ==================== */

		    $newDate      = date("Y-m-d",strtotime($fecha_inicial."+ 2 week")); 

			$fechaInicio  = strtotime($fecha_inicial);
			$fechaFin     = strtotime($newDate);

		    for($k=$fechaInicio; $k<=$fechaFin; $k+=86400){

				if(date("d", $k) =='30' || date("d", $k) =='15'){

						$firstQuincena =  date("d", $k);#primer quincena despues de la fecha inicial

						if(date("d", $k) =='30'){

							$secondQuincena =  '15';

						}else{

							$secondQuincena =  '30';
						
						}
						
						break;

					}

			  }

		
		if($periodicidad=='S'){ /* ==================== Periodicidad : Semanal ==================== */
			
			for($j = 0; $j < intval($num_cuotas); $j++){

			$fecha_inicial = date("Y-m-d",strtotime($fecha_inicial."+ 1 week"));
			
			$saldo         = $saldo-$valor_cuota;
			
			$resultado[$j]['num_cuota']   = $j+1;
			$resultado[$j]['fecha_cuota'] = $fecha_inicial;
			$resultado[$j]['valor_cuota'] = intval($valor_cuota);
			$resultado[$j]['saldo']       = $saldo;
					
		   }
		
		}else if($periodicidad == 'Q' || $periodicidad == 'M'){ /* ======= Periodicidad : Quincenal ó mensual (dos quincenas). =======*/

			while($i < $num_cuotas) {
			
			$contadorDias = date("d", $tiempoInicio);
			$contadorMes  = date("m", $tiempoInicio);

			if($contadorMes=='02' ){ #valida si es mes FEBRERO

				$month   = date('m', $tiempoInicio);
				$year    = date('Y', $tiempoInicio);
				$lastDay = date("d", mktime(0,0,0, $month+1, 0, $year));#Se captura el ultimo dia de el mes FEBRERO

				if($contadorDias== $lastDay || $contadorDias=='15'){

				$quincena = date("Y-m-d", $tiempoInicio);

				$saldo = $saldo-$valor_cuota;

				$resultado[$i]['num_cuota']   = $i+1;
				$resultado[$i]['fecha_cuota'] = $quincena;
				$resultado[$i]['valor_cuota'] = intval($valor_cuota);
				$resultado[$i]['saldo']       = $saldo;
				
				$i++;

			   }

				
			}else{

				if($contadorDias=='30' || $contadorDias=='15'){

				$quincena = date("Y-m-d", $tiempoInicio);

				$saldo = $saldo-$valor_cuota;

				$resultado[$i]['num_cuota']   = $i+1;
				$resultado[$i]['fecha_cuota'] = $quincena;
				$resultado[$i]['valor_cuota'] = intval($valor_cuota);
				$resultado[$i]['saldo']       = $saldo;
				
				$i++;

			 }
				
			}
			
			$tiempoInicio += $dia;
		} 

		}else if($periodicidad == 'Q1'){  /* ==========  Periodicidad : 1era quincena ========== */

			while($i < $num_cuotas) {
			
			$contadorDias = date("d", $tiempoInicio);

			if($contadorDias==$firstQuincena){

				$quincena = date("Y-m-d", $tiempoInicio);

				$saldo = $saldo-$valor_cuota;

				$resultado[$i]['num_cuota']   = $i+1;
				$resultado[$i]['fecha_cuota'] = $quincena;
				$resultado[$i]['valor_cuota'] = intval($valor_cuota);
				$resultado[$i]['saldo']       = $saldo;
				
				$i++;

			}
			
			$tiempoInicio += $dia;
		}

		}else if($periodicidad =='Q2'){ /* ========== Periodicidad : 2da quincena ========== */

			while($i < $num_cuotas) {
			
			$contadorDias = date("d", $tiempoInicio);

			if(date("m", $tiempoInicio) == '02' && $secondQuincena == '30'){

				$month   = date('m', $tiempoInicio);
				$year    = date('Y', $tiempoInicio);
				$lastDay = date("d", mktime(0,0,0, $month+1, 0, $year));#Se captura el ultimo dia de el mes febrero

				$secondQuincena1 =  $lastDay;

			}else{

				$secondQuincena1 =  $secondQuincena;

			} 

			if($contadorDias==$secondQuincena1){

				$quincena = date("Y-m-d", $tiempoInicio);

				$saldo = $saldo-$valor_cuota;

				$resultado[$i]['num_cuota']   = $i+1;
				$resultado[$i]['fecha_cuota'] = $quincena;
				$resultado[$i]['valor_cuota'] = intval($valor_cuota);
				$resultado[$i]['saldo']       = $saldo;
				
				$i++;

			}
			
			$tiempoInicio += $dia;
		}


		}
		
	  
	}else{

		   $resultado = array();
		   
	  }
	return $resultado;
  } 
   
}


?>
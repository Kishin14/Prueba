<?php

	require_once("../../../framework/clases/DbClass.php");
	require_once("../../../framework/clases/PermisosFormClass.php");

	final class LiqRetencionModel extends Db{

		private $usuario_id;
		private $Permisos;

		public function SetUsuarioId($usuario_id,$oficina_id){
			$this -> Permisos = new PermisosForm();
			$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
		}

		public function getPermiso($ActividadId,$Permiso,$Conex){
			return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
		}


		public function generateReporte($empresa_id,$fecha_inicio,$fecha_final,$consulta_contrato,$Conex){
			


			//Seccion UVT
			
		 	(($fecha_inicio=='' && $fecha_final =='') || ($fecha_inicio=='') || ($fecha_final=='')) ? exit('Debe digitar el rango de fechas para poder visualizar los empleados.') : true ;

			$inicio_a =  substr($fecha_inicio,0,4);
			$final_a = substr($fecha_final,0,4);

			$select_uvt ="SELECT
				t.uvt_nominal FROM uvt t WHERE	t.periodo_contable_id = (SELECT p.periodo_contable_id FROM periodo_contable p WHERE anio = $inicio_a)";
			$result    = $this -> DbFetchAll($select_uvt,$Conex);

			 
				//Seccion Retencion
				
				$select_rete = "SELECT rango_ini FROM retencion_salarial WHERE periodo_contable_id = (SELECT p.periodo_contable_id FROM periodo_contable p WHERE anio = $inicio_a) ORDER BY rango_ini ASC Limit 1";
				$resultado = $this -> DbFetchAll($select_rete,$Conex,true);
			

			if ($resultado>0) {
			

				$rango_ini = $resultado[0]['rango_ini'];
				$uvt_nominal = $result[0]['uvt_nominal'];

				//RANGO RETENCION EN PESOS

				$rango_pesos = ($uvt_nominal*$rango_ini);


					

					$subconsulta_extra = "(SELECT COALESCE((SELECT (h.vr_horas_diurnas+h.vr_horas_nocturnas+h.vr_horas_diurnas_fes+h.vr_horas_nocturnas_fes+h.vr_horas_recargo_noc+h.vr_horas_recargo_doc) FROM hora_extra h WHERE h.contrato_id = s.contrato_id AND h.estado = 'P' AND (h.fecha_inicial >= '$fecha_inicio' AND h.fecha_inicial <= '$fecha_final') AND (h.fecha_final >= '$fecha_inicio' AND h.fecha_final <= '$fecha_final')), 0))";
				
					$subconsulta_vacaciones ="(SELECT COALESCE((SELECT v.valor FROM liquidacion_vacaciones v WHERE v.estado = 'A' AND v.contrato_id = s.contrato_id AND (v.fecha_dis_inicio >= '$fecha_inicio' AND v.fecha_dis_inicio <= '$fecha_final') AND (v.fecha_dis_final >= '$fecha_inicio' AND v.fecha_dis_final <= '$fecha_final')), 0))";
					

					
					$subconsulta_prima ="(SELECT COALESCE((SELECT p.total FROM liquidacion_prima p WHERE p.estado = 'A' AND p.contrato_id = s.contrato_id AND p.fecha_liquidacion BETWEEN '$fecha_inicio' AND '$fecha_final'), 0))";


					$select = "SELECT
								s.contrato_id,
								s.prefijo,
								s.numero_contrato,
								s.fecha_inicio,
								$uvt_nominal AS uvt,
								$subconsulta_extra AS hora_extra,
								$subconsulta_vacaciones AS vacaciones,
								$subconsulta_prima AS primas,
								(SELECT (CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido)) FROM tercero t, empleado c WHERE t.tercero_id=c.tercero_id AND c.empleado_id=s.empleado_id) AS empleado_id, 
								s.sueldo_base,
								s.subsidio_transporte,
								(CASE s.estado WHEN 'A' THEN 'ACTIVO' WHEN 'R' THEN 'RETIRADO' WHEN 'F' THEN 'FINALIZADO' WHEN 'AN' THEN 'ANULADO'  WHEN 'L' THEN 'LICENCIA' ELSE '' END )AS estado
						FROM contrato s
						WHERE s.estado='A' AND (s.sueldo_base+s.subsidio_transporte+$subconsulta_extra+$subconsulta_vacaciones+$subconsulta_prima) >= $rango_pesos $consulta_contrato";
					$data = $this -> DbFetchAll($select,$Conex,true);

					if (!count($data)>0){
						$data['alerta'] = ('<h5 style="color:red;">No existen Contratos Pendientes por Liquidar Retenciones entre las Fechas Seleccionadas.<h5/>');
						return $data;
					}else {
						$data['alerta'] = '';
						
						// exit(print_r($data).'si');
						return $data;
					}

			}else {
				if ($result>0) {
					$data['alerta'] = ('<h5 style="color:red;">No hay parametrizado una retencion salarial para el periodo <h5/>'.$inicio_a) ;
					return $data;
				}else {
					$data['alerta'] = ('<h5 style="color:red;">No hay parametrizado una retencion salarial, ni una UVT para el periodo <h5/>'.$inicio_a) ;
					return $data;
				}
			}
			
		}

	
	public function OnFinalizar($usuario_id,$Conex){
	 
	
	$this -> Begin($Conex);
	
	  $solicitud_id 			= $this -> requestDataForQuery('solicitud_id','integer');
	  $fecha_retiro   			= date('Y-m-d');
	  $observacion_retiro  		= $this -> requestDataForQuery('observacion_retiro','text');
	  $fecha_entrega   			= $this -> requestDataForQuery('fecha_entrega','date');
	 // echo $fecha_retiro;
	  
	  $update = "UPDATE solicitud SET estado='F',
					fecha_entrega=$fecha_entrega,
					fecha_retiro='$fecha_retiro',
					observacion_retiro=$observacion_retiro,
					usuario_finaliza_id=$usuario_id
				WHERE solicitud_id=$solicitud_id";	
				
	  $this -> query($update,$Conex,true);		  
	
	  if(strlen($this -> GetError()) > 0){
		$this -> Rollback($Conex);
	  }else{		
		$this -> Commit($Conex);			
	  }  
	}
	
	public function getDataFinal($fecha_inicio,$Conex){
	
	$solicitud_id 				= $this -> requestDataForQuery('solicitud_id','integer');
	$fecha_inicio   			= $this -> requestDataForQuery('fecha_inicio','date');
	//$numero_meses				= $this -> requestDataForQuery('numero_meses','integer');
	
	$select1 = "SELECT numero_meses FROM solicitud WHERE solicitud_id=$solicitud_id";	
	$resultado1 = $this -> DbFetchAll($select1,$Conex,true);	
	$numero_meses = $resultado1[0]["numero_meses"];
	//echo ($numero_meses.'si'.$solicitud_id);
	
    $select = "SELECT  ADDDATE($fecha_inicio, INTERVAL + $numero_meses MONTH) AS fecha_final_renovacion";
     $result = $this -> DbFetchAll($select,$Conex,true); 
     return $result;
  }

	public function getDataActualiza($solicitud_id,$fecha_inicio,$Conex){
		
	$fecha_inicio   			= $this -> requestDataForQuery('fecha_inicio','date');
	//$numero_meses				= $this -> requestDataForQuery('numero_meses','integer');
	
	$select1 = "SELECT numero_meses FROM solicitud WHERE solicitud_id=$solicitud_id";	
	$resultado1 = $this -> DbFetchAll($select1,$Conex,true);	
	$numero_meses = $resultado1[0]["numero_meses"];
	
    $select = "SELECT  ADDDATE($fecha_inicio, INTERVAL + $numero_meses MONTH) AS fecha_final_actualiza";
     $result = $this -> DbFetchAll($select,$Conex,true); 
     return $result;
  }


	public function Liquidar($usuario_id,$Conex){
	 
	
	$this -> Begin($Conex);
	
	  $contrato_id 				= $this -> requestDataForQuery('contrato_id','integer');
	  $fecha_inicio   			= $this -> requestDataForQuery('fecha_inicio','date');
	  $fecha_final  			= $this -> requestDataForQuery('fecha_final','date');
	  $devengado				= $this -> requestDataForQuery('total_suma','numeric');
	  $uvt						= $this -> requestDataForQuery('uvt','numeric');
	  $aportes_pension			= $this -> requestDataForQuery('aportes_pension','numeric');
	  $aportes_salud			= $this -> requestDataForQuery('aportes_salud','numeric');
	  $aportes_fondop			= $this -> requestDataForQuery('aportes_fondop','numeric');
	  $st_icr					= $this -> requestDataForQuery('st_icr','numeric');
	  $sub1						= $this -> requestDataForQuery('sub1','numeric');
	  $pago_vivienda			= $this -> requestDataForQuery('pago_vivienda','numeric');
	  $deduccion_dependiente	= $this -> requestDataForQuery('deduccion_dependiente','numeric');
	  $salud_prepagada			= $this -> requestDataForQuery('salud_prepagada','numeric');
	  $st_d						= $this -> requestDataForQuery('st_d','numeric');
	  $sub2						= $this -> requestDataForQuery('sub2','numeric');
	  $aportes_vol_empl			= $this -> requestDataForQuery('aportes_vol_empl','numeric');
	  $aportes_afc				= $this -> requestDataForQuery('aportes_afc','numeric');
	  $otras_rentas				= $this -> requestDataForQuery('otras_rentas','numeric');
	  $st_re					= $this -> requestDataForQuery('st_re','numeric');
	  $sub3						= $this -> requestDataForQuery('sub3','numeric');
	  $rte						= $this -> requestDataForQuery('rte','numeric');
	  $sub4						= $this -> requestDataForQuery('sub4','numeric');
	  $cifra_control			= $this -> requestDataForQuery('cifra_control','numeric');
	  $total_deduccion			= $this -> requestDataForQuery('total_deduccion','numeric');
	  $validau					= $this -> requestDataForQuery('validau','numeric');
	  $ingreso_gravado			= $this -> requestDataForQuery('ingreso_gravado','numeric');
	  $ingreso_mensual			= $this -> requestDataForQuery('ingreso_mensual','numeric');
	  $fecha_liquidacion		= date('Y-m-d H:i:s');
	  $estado					= 'L';
	  

		$select = "SELECT * FROM liquidacion_retencion WHERE contrato_id=$contrato_id AND fecha_inicio =$fecha_inicio AND fecha_final=$fecha_final";
		$result = $this -> DbFetchAll($select,$Conex,true);	
		
		if(count($result) > 0){
		
			exit(' Ya hay una Liquidacion de Retención con esas mismas fechas para este contrato. ');
			
		}else{

			$liquidacion_retencion_id    = $this -> DbgetMaxConsecutive("liquidacion_retencion","liquidacion_retencion_id",$Conex,true,1);
			
			$insert= "INSERT INTO liquidacion_retencion(liquidacion_retencion_id, contrato_id, fecha_inicio, fecha_final, devengado, uvt, aportes_pension, aportes_salud, aportes_fondop, st_icr, sub1, pago_vivienda, deduccion_dependiente, salud_prepagada, st_d, sub2, aportes_vol_empl, aportes_afc, otras_rentas, st_re, sub3, rte, sub4, cifra_control, total_deduccion, validau, ingreso_gravado, ingreso_mensual, usuario_id, fecha_liquidacion,estado)
		 VALUES ($liquidacion_retencion_id,$contrato_id,$fecha_inicio,$fecha_final,$devengado,$uvt,$aportes_pension,$aportes_salud,$aportes_fondop,$st_icr,$sub1,$pago_vivienda,$deduccion_dependiente,$salud_prepagada,$st_d,$sub2,$aportes_vol_empl,$aportes_afc,$otras_rentas,$st_re,$sub3,$rte,$sub4,$cifra_control,$total_deduccion,$validau,$ingreso_gravado,$ingreso_mensual,$usuario_id,'$fecha_liquidacion','$estado')";	
		 $this -> query($insert,$Conex,true);
					
		}
		
			  
	  if(strlen($this -> GetError()) > 0){
		$this -> Rollback($Conex);
	  }else{		
		$this -> Commit($Conex);			
	  }  
	}

	public function selectDataContrato($contrato_id,$fecha_inicio,$fecha_final,$Conex){
		

		$select_valida = "SELECT * FROM liquidacion_retencion WHERE contrato_id=$contrato_id AND fecha_inicio ='$fecha_inicio' AND fecha_final='$fecha_final'";
		$result_valida = $this -> DbFetchAll($select_valida,$Conex,true);	
		
		$contabilizar = ($result_valida > 0) ? "SI" : "NO"; 

		$devengado					= $result_valida[0]["devengado"];
		$uvt						= $result_valida[0]["uvt"];
		$aportes_pension			= $result_valida[0]["aportes_pension"];
		$aportes_salud				= $result_valida[0]["aportes_salud"];
		$aportes_fondop				= $result_valida[0]["aportes_fondop"];
		$st_icr						= $result_valida[0]["st_icr"];
		$sub1						= $result_valida[0]["sub1"];
		$pago_vivienda				= $result_valida[0]["pago_vivienda"];
		$deduccion_dependiente		= $result_valida[0]["deduccion_dependiente"];
		$salud_prepagada			= $result_valida[0]["salud_prepagada"];
		$st_d						= $result_valida[0]["st_d"];
		$sub2						= $result_valida[0]["sub2"];
		$aportes_vol_empl			= $result_valida[0]["aportes_vol_empl"];
		$aportes_afc				= $result_valida[0]["aportes_afc"];
		$otras_rentas				= $result_valida[0]["otras_rentas"];
		$st_re						= $result_valida[0]["st_re"];
		$sub3						= $result_valida[0]["sub3"];
		$rte						= $result_valida[0]["rte"];
		$sub4						= $result_valida[0]["sub4"];
		$cifra_control				= $result_valida[0]["cifra_control"];
		$total_deduccion			= $result_valida[0]["total_deduccion"];
		$validau					= $result_valida[0]["validau"];
		$ingreso_gravado			= $result_valida[0]["ingreso_gravado"];
		$ingreso_mensual			= $result_valida[0]["ingreso_mensual"];
  
    $select = "SELECT
							s.contrato_id,CONCAT(s.prefijo,' - ',s.numero_contrato)AS numero_contrato,
							s.fecha_inicio,
							s.fecha_terminacion,
							'$contabilizar' AS contabilizar,
							'$devengado' AS devengado,
							'$uvt' AS uvt,
							'$aportes_pension' AS aportes_pension,
							'$aportes_salud' AS aportes_salud,
							'$aportes_fondop' AS aportes_fondop,
							'$st_icr' AS st_icr,
							'$sub1' AS sub1,
							'$pago_vivienda' AS pago_vivienda,
							'$deduccion_dependiente' AS deduccion_dependiente,
							'$salud_prepagada' AS salud_prepagada,
							'$st_d' AS st_d,
							'$sub2' AS sub2,
							'$aportes_vol_empl' AS aportes_vol_empl,
							'$aportes_afc' AS aportes_afc,
							'$otras_rentas' AS otras_rentas,
							'$st_re' AS st_re,
							'$sub3' AS sub3,
							'$rte' AS rte,
							'$sub4' AS sub4,
							'$cifra_control' AS cifra_control,
							'$total_deduccion' AS total_deduccion,
							'$validau' AS validau,
							'$ingreso_gravado' AS ingreso_gravado,
							'$ingreso_mensual' AS ingreso_mensual,
							(SELECT (CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido)) FROM tercero t, empleado c WHERE t.tercero_id=c.tercero_id AND c.empleado_id=s.empleado_id) AS empleado_id, 
							s.sueldo_base,
							s.subsidio_transporte,
							(CASE s.estado WHEN 'A' THEN 'ACTIVO' WHEN 'R' THEN 'RETIRADO' WHEN 'F' THEN 'FINALIZADO' WHEN 'AN' THEN 'ANULADO'  WHEN 'L' THEN 'LICENCIA' ELSE '' END )AS estado
					FROM contrato s
					WHERE s.contrato_id=$contrato_id";
	
	$result = $this -> DbFetchAll($select,$Conex,true);
	return $result; 
  
  }  
  
  public function selectDataFinaliza($contrato_id,$Conex){
  
    $select = "SELECT
							s.contrato_id,CONCAT(s.prefijo,' - ',s.numero_contrato)AS numero_contrato,
							s.fecha_inicio,
							s.fecha_terminacion,
							(SELECT (CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido)) FROM tercero t, empleado c WHERE t.tercero_id=c.tercero_id AND c.empleado_id=s.empleado_id) AS empleado_id, 
							s.sueldo_base,
							s.subsidio_transporte,
							(CASE s.estado WHEN 'A' THEN 'ACTIVO' WHEN 'R' THEN 'RETIRADO' WHEN 'F' THEN 'FINALIZADO' WHEN 'AN' THEN 'ANULADO'  WHEN 'L' THEN 'LICENCIA' ELSE '' END )AS estado
					FROM contrato s
					WHERE s.contrato_id=$contrato_id"; 
	
	$result = $this -> DbFetchAll($select,$Conex,true);
	
	return $result; 
  
  }  
  
  public function Contabilizar($usuario_id,$Conex){
	 
	
	$this -> Begin($Conex);
	
		  
	  $solicitud_id 			= $this -> requestDataForQuery('solicitud_id','integer');
	  $fecha_inicio_actualiza	= $this -> requestDataForQuery('fecha_inicio','date');
	  $fecha_final_actualiza	= $this -> requestDataForQuery('fecha_final','date');
	  $administracion_actualiza	= $this -> requestDataForQuery('administracion','numeric');
	  $canon_actualiza			= $this -> requestDataForQuery('canon','numeric');
	  $numero_meses_actualiza	= $this -> requestDataForQuery('numero_meses_actualiza','integer');
	  $observacion_actualiza	= $this -> requestDataForQuery('observacion_actualiza','text');
	  $fecha_actualizo			= date('Y-m-d');	  
	  
		$select1 = "SELECT * FROM fianza_canon WHERE solicitud_id=$solicitud_id AND canon = $canon_actualiza AND fecha_inicio=$fecha_inicio_actualiza AND fecha_final=$fecha_final_actualiza";
		
		$result1 = $this -> DbFetchAll($select1,$Conex,true);

		$select_valida = "SELECT fianza_canon_id FROM fianza_canon WHERE solicitud_id=$solicitud_id AND fecha_inicio=$fecha_inicio_actualiza AND fecha_final=$fecha_final_actualiza ORDER BY fianza_canon_id DESC LIMIT 1";
		$result_valida = $this -> DbFetchAll($select_valida,$Conex,true);
		$fianza_canon_id = $result_valida[0]["fianza_canon_id"];
		
		$insert="INSERT INTO encabezado_de_registro (encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,valor,numero_soporte,tercero_id,periodo_contable_id,
								mes_contable_id,consecutivo,fecha,concepto,estado,fecha_registro,modifica,usuario_id,numero_documento_fuente,id_documento_fuente)
								VALUES($encabezado_registro_id,$empresa_id,$oficina_id,$tip_documento,'$valor_total','$numero_soporte',$tercero_id,$periodo_contable_id,
								$mes_contable_id,$consecutivo,'$fecha','$concepto','C','$fecha_registro','$modifica',$usuario_id,'$numero_documento_fuente',$consecutivo)"; 
			$this -> query($insert,$Conex,true);    
	
	  if(strlen($this -> GetError()) > 0){
		$this -> Rollback($Conex);
	  }else{		
		$this -> Commit($Conex);			
	  }  
	  
}
	

	public function selectDataActualizar($contrato_id,$Conex){
  
  /*$select1 = "SELECT (SELECT numero_meses FROM solicitud WHERE solicitud_id=$solicitud_id) AS cuotas_canon,
				 fecha_inicio AS fecha_inicio_actualiza,
				fecha_final AS fecha_final_actualiza
		FROM fianza_canon WHERE solicitud_id=$solicitud_id ORDER BY fecha_inicio DESC LIMIT 1";
	$resultado1 = $this -> DbFetchAll($select1,$Conex,true);
		$numero_meses_actualiza = $resultado1[0]["cuotas_canon"];
		$fecha_final_actualiza = $resultado1[0]["fecha_final_actualiza"];
		$fecha_inicio_actualiza = $resultado1[0]["fecha_inicio_actualiza"];*/
  
  
    $select = "SELECT
							s.contrato_id,CONCAT(s.prefijo,' - ',s.numero_contrato)AS numero_contrato,
							s.fecha_inicio,
							s.fecha_terminacion,
							(SELECT (CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido)) FROM tercero t, empleado c WHERE t.tercero_id=c.tercero_id AND c.empleado_id=s.empleado_id) AS empleado_id, 
							s.sueldo_base,
							s.subsidio_transporte,
							(CASE s.estado WHEN 'A' THEN 'ACTIVO' WHEN 'R' THEN 'RETIRADO' WHEN 'F' THEN 'FINALIZADO' WHEN 'AN' THEN 'ANULADO'  WHEN 'L' THEN 'LICENCIA' ELSE '' END )AS estado
					FROM contrato s
					WHERE s.contrato_id=$contrato_id";
	
	$result = $this -> DbFetchAll($select,$Conex,true);
	
	return $result; 
  
  } 

}
	
?>

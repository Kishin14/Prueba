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


				/* //Seccion HORA EXTRA

				$select_he ="SELECT
					s.* FROM hora_extra s WHERE s.estado = 'P' $consulta_contrato AND (s.fecha_inicial BETWEEN '$fecha_inicio' AND '$fecha_final') AND (s.fecha_final BETWEEN '$fecha_inicio' AND '$fecha_final')";
				$result_he   = $this -> DbFetchAll($select_he,$Conex);

				$vr_horas_diurnas = $result_he[0]['vr_horas_diurnas'];
				$vr_horas_nocturnas = $result_he[0]['vr_horas_nocturnas'];
				$vr_horas_diurnas_fes = $result_he[0]['vr_horas_diurnas_fes'];
				$vr_horas_nocturnas_fes = $result_he[0]['vr_horas_nocturnas_fes'];
				$vr_horas_recargo_noc = $result_he[0]['vr_horas_recargo_noc'];
				$vr_horas_recargo_doc = $result_he[0]['vr_horas_recargo_doc'];
				$contrato_horas = $result_he[0]['contrato_id'];

				($vr_horas_diurnas==null || $vr_horas_diurnas=='') ? 0 : $vr_horas_diurnas ;
				($vr_horas_nocturnas==null || $vr_horas_nocturnas=='') ? 0 : $vr_horas_nocturnas ;
				($vr_horas_diurnas_fes==null || $vr_horas_diurnas_fes=='') ? 0 : $vr_horas_diurnas_fes ;
				($vr_horas_nocturnas_fes==null || $vr_horas_nocturnas_fes=='') ? 0 : $vr_horas_nocturnas_fes ;
				($vr_horas_recargo_noc==null || $vr_horas_recargo_noc=='') ? 0 : $vr_horas_recargo_noc ;
				($vr_horas_recargo_doc==null || $vr_horas_recargo_doc=='') ? 0 : $vr_horas_recargo_doc ;

				
				$total_extras = ($vr_horas_diurnas + $vr_horas_nocturnas + $vr_horas_diurnas_fes + $vr_horas_nocturnas_fes + $vr_horas_recargo_noc + $vr_horas_recargo_doc);


				//Seccion VACACIONES


				$select_vc ="SELECT
					s.valor,s.contrato_id FROM liquidacion_vacaciones s WHERE s.estado = 'A' $consulta_contrato AND (s.fecha_dis_inicio BETWEEN '$fecha_inicio' AND '$fecha_final') AND (s.fecha_dis_final BETWEEN '$fecha_inicio' AND '$fecha_final')";
				$result_vc   = $this -> DbFetchAll($select_vc,$Conex);

				$valor_vacaciones = $result_vc[0]['valor'];
				$contrato_vacaciones = $result_vc[0]['contrato_id'];

				$valor_vacaciones = ($valor_vacaciones==null || $valor_vacaciones=='') ? 0 : $valor_vacaciones ;

				//Seccion PRIMAS


				$select_pri ="SELECT
					s.total,s.contrato_id FROM liquidacion_prima s WHERE s.estado = 'A' $consulta_contrato AND s.fecha_liquidacion BETWEEN '$fecha_inicio' AND '$fecha_final'";
				$result_pri   = $this -> DbFetchAll($select_pri,$Conex); 

				$valor_primas = $result_pri[0]['total'];
				$contrato_primas = $result_pri[0]['contrato_id'];

				$valor_primas = ($valor_primas==null || $valor_primas=='') ? 0 : $valor_primas ; */


				/* //Validacion Contrato
				if ($consulta_contrato =='') {
					if ($contrato_horas == $contrato_primas && $contrato_horas == $contrato_vacaciones) {
						$consulta_contrato = " AND s.contrato_id = $contrato_horas ";
					}elseif ($contrato_primas == $contrato_horas && $contrato_primas == $contrato_vacaciones) {
						$consulta_contrato = " AND s.contrato_id = $contrato_primas ";
					}elseif ($contrato_vacaciones == $contrato_horas && $contrato_vacaciones == $contrato_primas) {
						$consulta_contrato = " AND s.contrato_id = $contrato_vacaciones ";
					}
				} */
				

					$subconsulta_extra = "(SELECT COALESCE((SELECT (h.vr_horas_diurnas+h.vr_horas_nocturnas+h.vr_horas_diurnas_fes+h.vr_horas_nocturnas_fes+h.vr_horas_recargo_noc+h.vr_horas_recargo_doc) FROM hora_extra h WHERE h.contrato_id = s.contrato_id AND h.estado = 'P' AND (h.fecha_inicial BETWEEN '$fecha_inicio' AND '$fecha_final') AND (h.fecha_final BETWEEN '$fecha_inicio' AND '$fecha_final')), 0))";
				
					$subconsulta_vacaciones ="(SELECT COALESCE((SELECT v.valor FROM liquidacion_vacaciones v WHERE v.estado = 'A' AND v.contrato_id = s.contrato_id AND (v.fecha_dis_inicio BETWEEN '$fecha_inicio' AND '$fecha_final') AND (v.fecha_dis_final BETWEEN '$fecha_inicio' AND '$fecha_final')), 0))";

					
					$subconsulta_prima ="(SELECT COALESCE((SELECT p.total FROM liquidacion_prima p WHERE p.estado = 'A' AND p.contrato_id = s.contrato_id AND p.fecha_liquidacion BETWEEN '$fecha_inicio' AND '$fecha_final'), 0))";


					$select = "SELECT
								s.contrato_id,
								s.prefijo,
								s.numero_contrato,
								s.fecha_inicio,
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


	public function OnRenovar($usuario_id,$Conex){
	 
	
	$this -> Begin($Conex);
	
	  $contrato_id 			= $this -> requestDataForQuery('contrato_id','integer');
	  $fecha_inicio   			= $this -> requestDataForQuery('fecha_inicio','date');
	  $fecha_final  			= $this -> requestDataForQuery('fecha_final','date');
	  $administracion			= $this -> requestDataForQuery('administracion','numeric');
	  $canon_renovacion			= $this -> requestDataForQuery('canon_renovacion','numeric');
	  $numero_meses				= $this -> requestDataForQuery('numero_meses','integer');
	  $observacion_renueva		= $this -> requestDataForQuery('observacion_renovacion','text');
	  $fecha_renovacion			= date('Y-m-d');
	  
	  
	 	/*$selection="SELECT  ADDDATE('$fecha_inicio', INTERVAL + $numero_meses MONTH) AS fecha_final FROM solicitud WHERE solicitud_id = $solicitud_id";
		$result_fecha = $this -> DbFetchAll($selection,$Conex,true);
		$fecha_final= $result_fecha[0]["fecha_final"];*/

		$select = "SELECT * FROM fianza_canon WHERE solicitud_id=$solicitud_id AND fecha_inicio =$fecha_inicio AND fecha_final=$fecha_final";
		
		$result = $this -> DbFetchAll($select,$Conex,true);	
		
		if(count($result) > 0){
		
			exit(' Ya hay un periodo previo con esas mismas fechas para este contrato de fianza. ');
			
		}else{
			
			$select1 = "SELECT tarifa_canon,cuotas_canon FROM fianza_canon WHERE solicitud_id=$solicitud_id ORDER BY fecha_inicio DESC";
		
			$resultado = $this -> DbFetchAll($select1,$Conex,true);	
			$ntarifa = $resultado[0]["tarifa_canon"];
			$cuotas_canon = $resultado[0]["cuotas_canon"];
			
			$fecha_ingreso = date("Y-m-d H:i:s");
					
			$insert= "INSERT INTO fianza_canon (canon,fecha_inicio,fecha_final,tarifa_canon,cuotas_canon,solicitud_id,usuario_id,fecha_ingreso) 
		 VALUES ($canon_renovacion,$fecha_inicio,$fecha_final,$ntarifa,$cuotas_canon,$solicitud_id,$usuario_id,'$fecha_ingreso')";	
		 $this -> query($insert,$Conex,true);
					
		}
		
		$select1 = "SELECT * FROM fianza_admin WHERE solicitud_id=$solicitud_id AND fecha_inicio =$fecha_inicio AND fecha_final=$fecha_final";
		
		$result1 = $this -> DbFetchAll($select1,$Conex,true);
				
		if(count($result1) > 0){
		
			exit(' Ya hay un periodo previo con esas mismas fechas para este contrato de fianza. ');
		}
		
		$select2 = "SELECT * FROM fianza_admin WHERE solicitud_id=$solicitud_id";
		
		$result2 = $this -> DbFetchAll($select2,$Conex,true);
		
		if(count($result2) > 0){
		
			$select1 = "SELECT tarifa_admin,cuotas_admin,opciones_admin FROM fianza_admin WHERE solicitud_id=$solicitud_id ORDER BY fianza_admin_id DESC";
		
			$resultado1 = $this -> DbFetchAll($select1,$Conex,true);	
			$atarifa = $resultado1[0]["tarifa_admin"];
			$cuotas_admin = $resultado1[0]["cuotas_admin"];
			$opciones_admin = $resultado1[0]["opciones_admin"];
			
			$fecha_ingreso = date("Y-m-d H:i:s");
					
			$insert1= "INSERT INTO fianza_admin (canon,fecha_inicio,fecha_final,tarifa_admin,cuotas_admin,solicitud_id,opciones_admin,usuario_id,fecha_registro)
		 VALUES ($administracion,$fecha_inicio,$fecha_final,$atarifa,$cuotas_admin,$solicitud_id,'$opciones_admin',$usuario_id,'$fecha_ingreso')";	
		 $this -> query($insert1,$Conex,true);
		
		}
		
		$select_canon = "SELECT fianza_canon_id FROM fianza_canon WHERE solicitud_id=$solicitud_id ORDER BY fianza_canon_id DESC";
		
		$result_fianza_canon = $this -> DbFetchAll($select_canon,$Conex,true);	
		$fianza_canon_id = $result_fianza_canon[0]["fianza_canon_id"];
		
	  $fecha_inicio   			= $this -> requestDataForQuery('fecha_inicio','date');
	  $fecha_final  			= $this -> requestDataForQuery('fecha_final','date');
	  $canon_viejo				= $this -> requestDataForQuery('canon_viejo','numeric');
	  $canon_renovacion			= $this -> requestDataForQuery('canon_renovacion','numeric');

	  
		$insert_cambio= "INSERT INTO cambio_fianza_canon (canon_anterior,canon_nuevo,fecha_inicio,fecha_final,usuario_id,fecha_registro,fianza_canon_id)
		 VALUES ($canon_viejo,$canon_renovacion,$fecha_inicio,$fecha_final,$usuario_id,'$fecha_renovacion',$fianza_canon_id)";
		 $this -> query($insert_cambio,$Conex,true);

		$total_solicitud = ($canon_renovacion + $administracion);
		
		  $update = "UPDATE solicitud SET
					total=$total_solicitud,
					observacion_renovacion=$observacion_renueva,
					administracion=$administracion,
					canon=$canon_renovacion,
					usuario_renueva_id=$usuario_id,
					fecha_renovacion='$fecha_renovacion'
				WHERE solicitud_id=$solicitud_id";
		
		
				
	  $this -> query($update,$Conex,true);		
	  
	  
	  
	  if(strlen($this -> GetError()) > 0){
		$this -> Rollback($Conex);
	  }else{		
		$this -> Commit($Conex);			
	  }  
	}

	public function selectDataContrato($contrato_id,$Conex){
		
		//$fecha_inicio   			= $this -> requestDataForQuery('fecha_inicio','date');
		
		/*$select1 = "SELECT cuotas_canon,fecha_final, fecha_inicio, 
				(SELECT  ADDDATE(fecha_inicio, INTERVAL + (SELECT numero_meses FROM solicitud WHERE solicitud_id=$solicitud_id) MONTH)) AS fecha_inicio_renovacion,
				(SELECT  ADDDATE(fecha_final, INTERVAL + (SELECT numero_meses FROM solicitud WHERE solicitud_id=$solicitud_id) MONTH)) AS fecha_final_renovacion
		FROM fianza_canon WHERE solicitud_id=$solicitud_id ORDER BY fecha_inicio DESC LIMIT 1 ";	
		$resultado1 = $this -> DbFetchAll($select1,$Conex,true);	
		$numero_meses = $resultado1[0]["cuotas_canon"];
		$fecha_final = $resultado1[0]["fecha_final"];
		$fecha_inicio = $resultado1[0]["fecha_inicio"];
		$fecha_inicio_renovacion = $resultado1[0]["fecha_inicio_renovacion"];
		$fecha_final_renovacion = $resultado1[0]["fecha_final_renovacion"];
		if(substr($fecha_final_renovacion,0,4)<date('Y')){
			$fecha_inicio_renovacion = date('Y').substr($fecha_inicio_renovacion,4,7);
			$fecha_final_renovacion = (date('Y')+1).substr($fecha_final_renovacion,4,7);
		}*/
  
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
  
  public function Actualizar($usuario_id,$Conex){
	 
	
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
			
		if(count($result1)==0 && $fianza_canon_id != ''){

			
				$update_canon = "UPDATE fianza_canon SET
					observacion_actualiza=$observacion_actualiza,
					canon=$canon_actualiza,
					usuario_actualizo_id=$usuario_id,
					fecha_actualizo='$fecha_actualizo'
				WHERE solicitud_id=$solicitud_id AND fecha_inicio =$fecha_inicio_actualiza AND fecha_final=$fecha_final_actualiza AND fianza_canon_id=$fianza_canon_id";	
				
	  			$this -> query($update_canon,$Conex,true);	
				
				
				$fecha_inicio   			= $this -> requestDataForQuery('fecha_inicio','date');
				$fecha_final  			= $this -> requestDataForQuery('fecha_final','date');
				$canon_antiguo_actualiza	= $this -> requestDataForQuery('canon_antiguo_actualiza','numeric');
				//$canon_actualiza			= $this -> requestDataForQuery('canon_actualiza','numeric');
				$fecha_registro			= date('Y-m-d H:m:s');
			  
				$insert_cambio= "INSERT INTO cambio_fianza_canon (canon_anterior,canon_nuevo,fecha_inicio,fecha_final,usuario_id,fecha_registro,fianza_canon_id)
				 VALUES ($canon_antiguo_actualiza,$canon_actualiza,$fecha_inicio_actualiza,$fecha_final_actualiza,$usuario_id,'$fecha_registro',$fianza_canon_id)";
				 $this -> query($insert_cambio,$Conex,true); //exit($insert_cambio);
		}

		$select_val_fia = "SELECT * FROM fianza_admin WHERE solicitud_id=$solicitud_id AND canon = $administracion_actualiza AND fecha_inicio=$fecha_inicio_actualiza AND fecha_final=$fecha_final_actualiza";
		$result_val_fia = $this -> DbFetchAll($select_val_fia,$Conex,true);

		$select_valida_fianza = "SELECT fianza_admin_id,canon FROM fianza_admin WHERE solicitud_id=$solicitud_id AND fecha_inicio=$fecha_inicio_actualiza AND fecha_final=$fecha_final_actualiza ORDER BY fianza_admin_id DESC LIMIT 1";
		$result_valida_fianza = $this -> DbFetchAll($select_valida_fianza,$Conex,true);
		$fianza_admin_id = $result_valida_fianza[0]["fianza_admin_id"];
		$admin_viejo = $result_valida_fianza[0]["canon"];
				

		if(count($result_val_fia) == 0 && $fianza_admin_id != ''){
		
			$update_fianza = "UPDATE fianza_admin SET
					observacion_actualiza=$observacion_actualiza,
					canon=$administracion_actualiza,
					usuario_actualizo_id=$usuario_id,
					fecha_actualizo='$fecha_actualizo'
				WHERE solicitud_id=$solicitud_id AND fecha_inicio =$fecha_inicio_actualiza AND fecha_final=$fecha_final_actualiza AND fianza_admin_id=$fianza_admin_id";	
				
	 		 $this -> query($update_fianza,$Conex,true);	
			 
			 $fecha_registro	= date('Y-m-d H:m:s');
			 
			 $insert_cambio= "INSERT INTO cambio_fianza_admin (admin_anterior,admin_nuevo,fecha_inicio,fecha_final,usuario_id,fecha_registro,fianza_admin_id)
							  VALUES ($admin_viejo,$administracion_actualiza,$fecha_inicio_actualiza,$fecha_final_actualiza,$usuario_id,'$fecha_registro',$fianza_admin_id)";
			 $this -> query($insert_cambio,$Conex,true);

	
		}elseif (count($result_val_fia) == 0 && $fianza_admin_id == '' && $administracion_actualiza >0) {

			$selecti = "SELECT tarifa_admin,cuotas_admin,opciones_admin FROM fianza_admin WHERE solicitud_id=$solicitud_id ORDER BY fianza_admin_id DESC";
		
			$resulta1 = $this -> DbFetchAll($selecti,$Conex,true);	
			$atarifa = $resulta1[0]["tarifa_admin"];
			$cuotas_admin = $resulta1[0]["cuotas_admin"];
			$opciones_admin = $resulta1[0]["opciones_admin"];
			$fecha_ingreso	= date('Y-m-d H:m:s');


			$insert_nueva_admin= "INSERT INTO fianza_admin (canon,fecha_inicio,fecha_final,tarifa_admin,cuotas_admin,solicitud_id,opciones_admin,usuario_id,fecha_registro)
			 VALUES ($administracion_actualiza,$fecha_inicio_actualiza,$fecha_final_actualiza,$atarifa,$cuotas_admin,$solicitud_id,'$opciones_admin',$usuario_id,'$fecha_ingreso')";	
			 $this -> query($insert_nueva_admin,$Conex,true);

			$fecha_registro	= date('Y-m-d H:m:s');
			 
			 $insert_cambio= "INSERT INTO cambio_fianza_admin (admin_anterior,admin_nuevo,fecha_inicio,fecha_final,usuario_id,fecha_registro,fianza_admin_id)
							  VALUES ($admin_viejo,$administracion_actualiza,$fecha_inicio_actualiza,$fecha_final_actualiza,$usuario_id,'$fecha_registro',$fianza_admin_id)";
			 $this -> query($insert_cambio,$Conex,true);
		}

		 
		 		 
		 $total_solicitud = ($canon_actualiza + $administracion_actualiza);
		 
	  	$update = "UPDATE solicitud SET
					observacion_actualiza=$observacion_actualiza,
					administracion=$administracion_actualiza,
					canon=$canon_actualiza,
					total=$total_solicitud,
					usuario_actualizo_id=$usuario_id,
					fecha_actualizo='$fecha_actualizo'
				WHERE solicitud_id=$solicitud_id";	
				
	  $this -> query($update,$Conex,true);		  
	
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

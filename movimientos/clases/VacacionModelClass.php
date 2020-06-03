<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class VacacionModel extends Db{
		
  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }

  public function comprobar_estado($liquidacion_vacaciones_id,$Conex){
    				
   $select = "SELECT l.estado, 
                     l.si_empleado,
					 l.encabezado_registro_id,
					 l.liquidacion_vacaciones_id,
					 l.fecha_liquidacion,
   			(SELECT p.estado  FROM encabezado_de_registro e, periodo_contable p 
			 WHERE e.encabezado_registro_id=l.encabezado_registro_id AND p.periodo_contable_id=e.periodo_contable_id) AS estado_periodo,

			(SELECT p.estado  FROM encabezado_de_registro e, mes_contable p 
			 WHERE e.encabezado_registro_id=l.encabezado_registro_id AND p.mes_contable_id=e.mes_contable_id) AS estado_mes			
   			FROM liquidacion_vacaciones l
			WHERE l.liquidacion_vacaciones_id=$liquidacion_vacaciones_id";
				
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	
	return $result;
  }

  	public function getCausalesAnulacion($Conex){
		
		$select = "SELECT causal_anulacion_id AS value,nombre AS text FROM causal_anulacion WHERE documento!='RM' ORDER BY nombre";
		$result = $this -> DbFetchAll($select,$Conex);		
		return $result;				
	} 
    
  public function Save($Campos,$usuario_id,$fecha_registro,$oficina_id,$Conex){	
		
		$empleado_id				= $this -> requestDataForQuery('empleado_id','integer');
		$observaciones   			= $this -> requestDataForQuery('observaciones','text');
		$concepto   	   			= $this -> requestDataForQuery('concepto','text');
		$fecha_liquidacion 	 		= $this -> requestDataForQuery('fecha_liquidacion','date');		
		$fecha_dis_inicio 	 		= $this -> requestDataForQuery('fecha_dis_inicio','date');		
		$fecha_dis_final			= $this -> requestDataForQuery('fecha_dis_final','date');
		$fecha_reintegro			= $this -> requestDataForQuery('fecha_reintegro','date');
		$dias 	 					= $this -> requestDataForQuery('dias','integer');
		$dias_disfrutar 	 		= $this -> requestDataForQuery('dias_disfrutar','integer');
		$dias_disfrutar_real 	 	= $this -> requestDataForQuery('dias_disfrutar_real','integer');
		$valor				        = $this -> requestDataForQuery('valor','numeric');
		$dias_pagados 	 		    = $this -> requestDataForQuery('dias_pagados','integer');
		$valor_pagos				= $this -> requestDataForQuery('valor_pagos','numeric');
		$valor_total				= $this -> requestDataForQuery('valor_total','numeric');
		$si_empleado				= $this -> requestDataForQuery('si_empleado','integer');
		
		if ($si_empleado == 1){
		
		 $this -> Begin($Conex);
		 
		 $liquidacion_vacaciones_id 	= $this -> DbgetMaxConsecutive("liquidacion_vacaciones","liquidacion_vacaciones_id",$Conex,false,1);
		
		$select_contrato = "SELECT c.contrato_id,
		                   (SELECT centro_de_costo_id FROM centro_de_costo WHERE oficina_id = $oficina_id AND estado ='A')AS centro_de_costo_id,
						   (SELECT e.tercero_id FROM empleado e WHERE e.empleado_id=c.empleado_id)AS tercero_id,
						   c.area_laboral,
						   c.sueldo_base,
						   c.fecha_inicio,
						    DATEDIFF(CURDATE(),c.fecha_inicio) AS dias_trabajados 
							
							FROM contrato c WHERE c.empleado_id=$empleado_id AND c.estado='A'";
		$result_contrato = $this -> DbFetchAll($select_contrato,$Conex,true);

		$contrato_id	 = $result_contrato[0]['contrato_id'];
		$tercero_id	 = $result_contrato[0]['tercero_id'];
		$area_laboral	 = $result_contrato[0]['area_laboral'];
		$centro_de_costo_id	 = $result_contrato[0]['centro_de_costo_id'];

		$select="SELECT l.contrato_id FROM liquidacion_vacaciones l 
		         WHERE (l.fecha_dis_inicio BETWEEN $fecha_dis_inicio AND $fecha_dis_final 
				 OR l.fecha_dis_final BETWEEN $fecha_dis_inicio AND $fecha_dis_final)
				 AND l.contrato_id = $contrato_id AND l.estado != 'I'";
				 
		$result = $this -> DbFetchAll($select,$Conex,true); 

		if($result > 0){
            exit("¡Existe una liquidacion de vacaciones con las mismas fechas para este contrato, por favor revise nuevamente.!");
		}
        //guarda la liquidacion de vacaciones
		$insert_vacaciones = "INSERT INTO liquidacion_vacaciones 
		(liquidacion_vacaciones_id,contrato_id,fecha_liquidacion,fecha_dis_inicio,fecha_dis_final,fecha_reintegro,dias,dias_disfrutar,dias_disfrutar_real,valor,dias_pagados,valor_pagos,valor_total,observaciones,concepto,usuario_id,fecha_registro,si_empleado)
		VALUES
		($liquidacion_vacaciones_id,$contrato_id,$fecha_liquidacion,$fecha_dis_inicio,$fecha_dis_final,$fecha_reintegro,$dias,$dias_disfrutar,$dias_disfrutar_real,$valor,$dias_pagados,$valor_pagos,$valor_total,$observaciones,$concepto,$usuario_id,'$fecha_registro',$si_empleado)";
		$this -> query($insert_vacaciones,$Conex,true);
		
		
		$detalle_liquidacion = $_REQUEST['concepto_item'];
		
		 $item				= split(',',$detalle_liquidacion);
		 
		  foreach($item as $item_id){
			if($item_id!=''){
				
				$item_fr	= split('-',$item_id);
				
				$fecha_inicial_periodo = $item_fr[0];
				$fecha_final_periodo = $item_fr[1];
				$dias_ganados	= $item_fr[2];
				
				//guarda el detalle de la liquidacion de las vacaciones
				$insert_detalles = "INSERT INTO detalle_liquidacion_vacaciones (liquidacion_vacaciones_id,periodo_inicio,periodo_fin,dias_ganados,dias_disfrutados,dias_pagados) 						                                    VALUES
								    ($liquidacion_vacaciones_id,$fecha_inicial_periodo,$fecha_final_periodo,$dias_ganados,$dias,$dias_pagados)";
				$this -> query($insert_detalles,$Conex,true); 
			}
		  }
		$select_datos_ter="SELECT numero_identificacion,digito_verificacion FROM tercero WHERE tercero_id=$tercero_id";
		$result_datos_ter = $this -> DbFetchAll($select_datos_ter,$Conex) ;
		
		$numero_identificacion = $result_datos_ter[0]['numero_identificacion'];
		$digito_verificacion   = $result_datos_ter[0]['digito_verificacion']>0 ? $result_datos_ter[0]['digito_verificacion']>0 :'NULL';
		
		$select_parametros="SELECT 
		puc_vac_prov_id,puc_vac_cons_id,puc_vac_contra_id,puc_admon_vac_id,puc_ventas_vac_id,puc_produ_vac_id,puc_salud_vac_id,puc_pension_vac_id,tipo_documento_id
		FROM parametros_liquidacion_nomina WHERE oficina_id=$oficina_id";
		$result_parametros = $this -> DbFetchAll($select_parametros,$Conex); 
		
		$puc_provision_vacaciones = $result_parametros[0]['puc_vac_prov_id'];
		$puc_consolidado_vacaciones = $result_parametros[0]['puc_vac_cons_id'];
		$puc_contrapartida		  = $result_parametros[0]['puc_vac_contra_id'];
		$puc_admin				= $result_parametros[0]['puc_admon_vac_id'];
		$puc_venta				= $result_parametros[0]['puc_ventas_vac_id'];
		$puc_operativo			= $result_parametros[0]['puc_produ_vac_id'];
		$puc_salud				= $result_parametros[0]['puc_salud_vac_id'];
		$puc_pension			= $result_parametros[0]['puc_pension_vac_id'];
		
		$tipo_doc				= $result_parametros[0]['tipo_documento_id'];
		
		
		
		$select_consolidado = "SELECT SUM(credito-debito)as neto,centro_de_costo_id FROM imputacion_contable WHERE puc_id=$puc_consolidado_vacaciones AND tercero_id=$tercero_id AND encabezado_registro_id IN (SELECT encabezado_registro_id FROM encabezado_de_registro WHERE fecha<$fecha_dis_inicio)";
		$result_consolidado = $this -> DbFetchAll($select_consolidado,$Conex); 
		
		$valor_consolidado = $result_consolidado[0]['neto'];
		$centro_costo_consolidado = $result_consolidado[0]['centro_de_costo_id']> 0 ? $result_consolidado[0]['centro_de_costo_id'] : $centro_de_costo_id;
		
		$select_provision = "SELECT SUM(credito-debito)as neto,centro_de_costo_id  FROM imputacion_contable WHERE puc_id=$puc_provision_vacaciones AND tercero_id=$tercero_id AND encabezado_registro_id IN (SELECT encabezado_registro_id FROM encabezado_de_registro WHERE fecha<$fecha_dis_inicio)";
		$result_provision = $this -> DbFetchAll($select_provision,$Conex); 
		
		$valor_provision = $result_provision[0]['neto'];
		$centro_costo_provision = $result_provision[0]['centro_de_costo_id']> 0 ? $result_provision[0]['centro_de_costo_id'] : $centro_de_costo_id;
		
		
		$valor_ingresado=0;
		
		$valor_guardado = intval($valor_consolidado)+intval($valor_provision);
		
		if($valor_consolidado>0){
			
			if($valor_consolidado>$valor){
				$valor_consolidado = $valor;
			}
			
			$valor_ingresado   = intval($valor_consolidado); 
			
			//registro consolidado
			$insert_det_puc_cons ="INSERT INTO detalle_vacaciones_puc (liquidacion_vacaciones_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_vacaciones,porcentaje_vacaciones,formula_vacaciones,desc_vacaciones,deb_item_vacaciones,cre_item_vacaciones,valor_liquida,contrapartida)
		VALUES
		($liquidacion_vacaciones_id,$puc_consolidado_vacaciones,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_consolidado,IF($centro_costo_consolidado>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_consolidado),'NULL'),0,'NULL','NULL',$observaciones,$valor_ingresado,0,$valor_ingresado,0)";
			$this -> query($insert_det_puc_cons,$Conex,true); 
		}
		
		if($valor_provision>0){
			
			//registro provisiones
			
				if(($valor-$valor_ingresado)>$valor_provision){
					$insert_det_puc_prov ="INSERT INTO detalle_vacaciones_puc (liquidacion_vacaciones_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_vacaciones,porcentaje_vacaciones,formula_vacaciones,desc_vacaciones,deb_item_vacaciones,cre_item_vacaciones,valor_liquida,contrapartida)
		VALUES
		($liquidacion_vacaciones_id,$puc_provision_vacaciones,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_provision,IF($centro_costo_provision>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_provision),'NULL'),0,'NULL','NULL',$observaciones,$valor_provision,0,$valor_provision,0)";
					
				}else{
					$valor_provision = $valor-$valor_ingresado;
					$insert_det_puc_prov ="INSERT INTO detalle_vacaciones_puc (liquidacion_vacaciones_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_vacaciones,porcentaje_vacaciones,formula_vacaciones,desc_vacaciones,deb_item_vacaciones,cre_item_vacaciones,valor_liquida,contrapartida)
		VALUES
		($liquidacion_vacaciones_id,$puc_provision_vacaciones,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_provision,IF($centro_costo_provision>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_provision),'NULL'),0,'NULL','NULL',$observaciones,$valor_provision,0,$valor_provision,0)";
		
				}
				
				$this -> query($insert_det_puc_prov,$Conex,true); 
					
		}
		if($valor>$valor_guardado){
			if($area_laboral=='A'){
				$puc_diferencia = $puc_admin;
			}elseif($area_laboral=='O'){
				$puc_diferencia = $puc_operativo;
			}elseif($area_laboral=='C'){
				$puc_diferencia = $puc_venta;
			}
			$diferencia= $valor-$valor_guardado;

			//registro produccion
			$insert_det_puc_dife ="INSERT INTO detalle_vacaciones_puc (liquidacion_vacaciones_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_vacaciones,porcentaje_vacaciones,formula_vacaciones,desc_vacaciones,deb_item_vacaciones,cre_item_vacaciones,valor_liquida,contrapartida)
		VALUES
		($liquidacion_vacaciones_id,$puc_diferencia,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_provision,IF($centro_costo_provision>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_provision),'NULL'),0,'NULL','NULL',$observaciones,$diferencia,0,$diferencia,0)";
		$this -> query($insert_det_puc_dife,$Conex,true); 
		
		}
		
		$select_descuentos="SELECT desc_emple_salud,desc_emple_pension FROM datos_periodo WHERE periodo_contable_id = (SELECT periodo_contable_id FROM periodo_contable WHERE anio=DATE_FORMAT($fecha_liquidacion,'%Y'))";
		$result_descuentos = $this -> DbFetchAll($select_descuentos,$Conex); 
		
		$porcentaje_pension = $result_descuentos[0]['desc_emple_pension'];
		$porcentaje_salud   = $result_descuentos[0]['desc_emple_salud'];
		
		$descuento_pension = ($valor*$porcentaje_pension)/100;
		$descuento_salud = ($valor*$porcentaje_salud)/100;
		
		$valor_pagar = $valor-($descuento_pension+$descuento_salud);

		$observaciones_salud = str_replace("'",'',$observaciones)." -DESC SALUD";
		$observaciones_pension = str_replace("'",'',$observaciones)." -DESC PENSION";
		
		//regristro descuento salud
		$insert_desc_salud ="INSERT INTO detalle_vacaciones_puc (liquidacion_vacaciones_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_vacaciones,porcentaje_vacaciones,formula_vacaciones,desc_vacaciones,deb_item_vacaciones,cre_item_vacaciones,valor_liquida,contrapartida)
		VALUES
		($liquidacion_vacaciones_id,$puc_salud,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_provision,IF($centro_costo_provision>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_provision),'NULL'),0,'NULL','NULL','$observaciones_salud',0,$descuento_salud,$descuento_salud,0)";
		$this -> query($insert_desc_salud,$Conex,true);
		
		//registro descuento pension
		$insert_desc_pension ="INSERT INTO detalle_vacaciones_puc (liquidacion_vacaciones_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_vacaciones,porcentaje_vacaciones,formula_vacaciones,desc_vacaciones,deb_item_vacaciones,cre_item_vacaciones,valor_liquida,contrapartida)
		VALUES
		($liquidacion_vacaciones_id,$puc_pension,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_provision,IF($centro_costo_provision>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_provision),'NULL'),0,'NULL','NULL','$observaciones_pension',0,$descuento_pension,$descuento_pension,0)";
		$this -> query($insert_desc_pension,$Conex,true);
		
		//registro contrapartida
		$insert_det_puc_contra ="INSERT INTO detalle_vacaciones_puc (liquidacion_vacaciones_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_vacaciones,porcentaje_vacaciones,formula_vacaciones,desc_vacaciones,deb_item_vacaciones,cre_item_vacaciones,valor_liquida,contrapartida)
		VALUES
		($liquidacion_vacaciones_id,$puc_contrapartida,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_provision,IF($centro_costo_provision>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_provision),'NULL'),0,'NULL','NULL',$observaciones,0,$valor_pagar,$valor_pagar,1)";
		$this -> query($insert_det_puc_contra,$Conex,true);
		
	$this -> Commit($Conex);  
	print($liquidacion_vacaciones_id);
  }else{
			$select="SELECT c.contrato_id FROM contrato c WHERE c.estado='A'";
				$result = $this -> DbFetchAll($select,$Conex);
				$this -> Begin($Conex);
				foreach($result as $resultado){
					
					$contrato_id = $resultado[contrato_id];
									
									
						$select_contrato = "SELECT c.contrato_id,
						                   (SELECT e.tercero_id FROM empleado e WHERE e.empleado_id=c.empleado_id)as tercero_id,
										   (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, empleado e WHERE t.tercero_id=e.tercero_id AND e.empleado_id = c.empleado_id)AS nombre,
										   c.area_laboral,
										   c.sueldo_base,
										   c.fecha_inicio, 
										   DATEDIFF(CURDATE(),c.fecha_inicio) as dias_trabajados 
										   FROM contrato c WHERE c.contrato_id=$contrato_id AND estado='A' ";
						$result_contrato = $this -> DbFetchAll($select_contrato,$Conex); 

						$contrato_id	 = $result_contrato[0]['contrato_id'];
						$nombre	         = $result_contrato[0]['nombre'];
						$tercero_id	     = $result_contrato[0]['tercero_id'];
						$area_laboral	 = $result_contrato[0]['area_laboral'];
						$dias_trabajados = $result_contrato[0]['dias_trabajados'];
						$fecha_inicio = $result_contrato[0]['fecha_inicio'];
						$sueldo = $result_contrato[0]['sueldo_base'];

						$select="SELECT l.contrato_id FROM liquidacion_vacaciones l 
		                        WHERE (l.fecha_dis_inicio BETWEEN $fecha_dis_inicio AND $fecha_dis_final 
				                OR l.fecha_dis_final BETWEEN $fecha_dis_inicio AND $fecha_dis_final) 
				                AND l.contrato_id = $contrato_id";
				 
		               $result = $this -> DbFetchAll($select,$Conex); 

		               if($result > 0){
                          exit("¡Existe una liquidacion de vacaciones con las mismas fechas para el empleado ".$nombre.", Por favor revise nuevamente.!");
		               }

						$anios = intval(intval($dias_trabajados)/365);
						
						if($anios >= 1){

							$select="SELECT d.periodo_inicio, d.periodo_fin FROM detalle_liquidacion_vacaciones d, liquidacion_vacaciones l WHERE d.liquidacion_vacaciones_id = l.liquidacion_vacaciones_id AND l.contrato_id = $contrato_id ORDER BY l.liquidacion_vacaciones_id DESC LIMIT 1";
							$result_periodo = $this -> DbFetchAll($select,$Conex);
							
							if($result_periodo>0){

								$periodo_inicio = $result_periodo[0]['periodo_fin'];

								$select_periodo = "SELECT DATE_ADD('$periodo_inicio',INTERVAL 1 YEAR) as fecha_fin";
								$result_pe = $this -> DbFetchAll($select_periodo,$Conex); 

								$periodo_fin = $result_pe[0]['fecha_fin'];

							}else{
								$periodo_inicio = $fecha_inicio;

								$select_periodo = "SELECT DATE_ADD('$periodo_inicio',INTERVAL 1 YEAR) as fecha_fin";
								$result_pe = $this -> DbFetchAll($select_periodo,$Conex); 

								$periodo_fin = $result_pe[0]['fecha_fin'];
							}
						
								$sueldo_base = intVal((($sueldo / 30) * ($dias_disfrutar)));

								$concepto = "'LIQ TODOS DESDE: ".str_replace("'","",$fecha_dis_inicio)."HASTA: ".str_replace("'","",$fecha_dis_final)."'";
								
								$liquidacion_vacaciones_id 	= $this -> DbgetMaxConsecutive("liquidacion_vacaciones","liquidacion_vacaciones_id",$Conex,false,1);
								
								//registro liquidacion vacaciones todos
								$insert_vacaciones = "INSERT INTO liquidacion_vacaciones 
								(liquidacion_vacaciones_id,contrato_id,fecha_liquidacion,fecha_dis_inicio,fecha_dis_final,fecha_reintegro,dias,dias_disfrutar,dias_disfrutar_real,valor,dias_pagados,valor_pagos,valor_total,observaciones,concepto,usuario_id,fecha_registro)
								VALUES
								($liquidacion_vacaciones_id,$contrato_id,$fecha_liquidacion,$fecha_dis_inicio,$fecha_dis_final,$fecha_reintegro,$dias,$dias_disfrutar,$dias_disfrutar_real,$sueldo_base,$dias_pagados,$valor_pagos,$sueldo_base,$observaciones,$concepto,$usuario_id,'$fecha_registro')";
								$this -> query($insert_vacaciones,$Conex,true);
								
								
								$detalle_liquidacion = $_REQUEST['concepto_item'];
								
								$item = split(',',$detalle_liquidacion);
								
								foreach($item as $item_id){
									if($item_id!=''){
										
										$item_fr = split('-',$item_id);
										
										//registro detalle liquidacion vacaciones
										$insert_detalles = "INSERT INTO detalle_liquidacion_vacaciones (liquidacion_vacaciones_id,periodo_inicio,periodo_fin,dias_ganados,dias_disfrutados,dias_pagados) 						                                    VALUES
															($liquidacion_vacaciones_id,'$periodo_inicio','$periodo_fin',$dias,$dias,0)";
										
										$this -> query($insert_detalles,$Conex,true); 
									}
								}
								$select_datos_ter="SELECT numero_identificacion,digito_verificacion FROM tercero WHERE tercero_id=$tercero_id";
								$result_datos_ter = $this -> DbFetchAll($select_datos_ter,$Conex) ;
								
								$numero_identificacion = $result_datos_ter[0]['numero_identificacion'];
								$digito_verificacion   = $result_datos_ter[0]['digito_verificacion']>0 ? $result_datos_ter[0]['digito_verificacion']>0 :'NULL';
								
								$select_parametros="SELECT 
								puc_vac_prov_id,puc_vac_cons_id,puc_vac_contra_id,puc_admon_vac_id,puc_ventas_vac_id,puc_produ_vac_id,puc_salud_vac_id,puc_pension_vac_id,tipo_documento_id
								FROM parametros_liquidacion_nomina WHERE oficina_id=$oficina_id";
								$result_parametros = $this -> DbFetchAll($select_parametros,$Conex); 
								
								$puc_provision_vacaciones = $result_parametros[0]['puc_vac_prov_id'];
								$puc_consolidado_vacaciones = $result_parametros[0]['puc_vac_cons_id'];
								$puc_contrapartida		  = $result_parametros[0]['puc_vac_contra_id'];
								$puc_admin				= $result_parametros[0]['puc_admon_vac_id'];
								$puc_venta				= $result_parametros[0]['puc_ventas_vac_id'];
								$puc_operativo			= $result_parametros[0]['puc_produ_vac_id'];
								$puc_salud				= $result_parametros[0]['puc_salud_vac_id'];
								$puc_pension			= $result_parametros[0]['puc_pension_vac_id'];
								
								$tipo_doc				= $result_parametros[0]['tipo_documento_id'];
								
								$select_consolidado = "SELECT SUM(credito-debito)as neto,centro_de_costo_id FROM imputacion_contable WHERE puc_id=$puc_consolidado_vacaciones AND tercero_id=$tercero_id";
								$result_consolidado = $this -> DbFetchAll($select_consolidado,$Conex); 
								
								$valor_consolidado = $result_consolidado[0]['neto'];
								$centro_costo_consolidado = $result_consolidado[0]['centro_de_costo_id'];
								
								$select_provision = "SELECT SUM(credito-debito)as neto,centro_de_costo_id  FROM imputacion_contable WHERE puc_id=$puc_provision_vacaciones AND tercero_id=$tercero_id";
								$result_provision = $this -> DbFetchAll($select_provision,$Conex); 
								
								$valor_provision = $result_provision[0]['neto'];
								$centro_costo_provision = $result_provision[0]['centro_de_costo_id'];
								
								
								$valor_guardado = intval($valor_consolidado)+intval($valor_provision);
								
								//registro consolidado
								$insert_det_puc_cons ="INSERT INTO detalle_vacaciones_puc (liquidacion_vacaciones_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_vacaciones,porcentaje_vacaciones,formula_vacaciones,desc_vacaciones,deb_item_vacaciones,cre_item_vacaciones,valor_liquida,contrapartida)
								VALUES
								($liquidacion_vacaciones_id,$puc_consolidado_vacaciones,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_consolidado,IF($centro_costo_consolidado>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_consolidado),'NULL'),0,'NULL','NULL',$observaciones,$valor_consolidado,0,$valor_consolidado,0)";
								$this -> query($insert_det_puc_cons,$Conex,true); 
								
								//registro provisiones
								$insert_det_puc_prov ="INSERT INTO detalle_vacaciones_puc (liquidacion_vacaciones_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_vacaciones,porcentaje_vacaciones,formula_vacaciones,desc_vacaciones,deb_item_vacaciones,cre_item_vacaciones,valor_liquida,contrapartida)
								VALUES
								($liquidacion_vacaciones_id,$puc_provision_vacaciones,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_provision,IF($centro_costo_provision>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_provision),'NULL'),0,'NULL','NULL',$observaciones,$valor_provision,0,$valor_provision,0)";
								$this -> query($insert_det_puc_prov,$Conex,true); 
								
								if($sueldo_base>$valor_guardado){
									if($area_laboral=='A'){
										$puc_diferencia = $puc_admin;
									}elseif($area_laboral=='O'){
										$puc_diferencia = $puc_operativo;
									}elseif($area_laboral=='C'){
										$puc_diferencia = $puc_venta;
									}
									$diferencia= $sueldo_base-$valor_guardado;
									$insert_det_puc_prov ="INSERT INTO detalle_vacaciones_puc (liquidacion_vacaciones_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_vacaciones,porcentaje_vacaciones,formula_vacaciones,desc_vacaciones,deb_item_vacaciones,cre_item_vacaciones,valor_liquida,contrapartida)
								VALUES
								($liquidacion_vacaciones_id,$puc_diferencia,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_provision,IF($centro_costo_provision>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_provision),'NULL'),0,'NULL','NULL',$observaciones,$diferencia,0,$diferencia,0)";
								$this -> query($insert_det_puc_prov,$Conex,true); 
								
								}
								
								$select_descuentos="SELECT desc_emple_salud,desc_emple_pension FROM datos_periodo WHERE periodo_contable_id = (SELECT periodo_contable_id FROM periodo_contable WHERE anio=DATE_FORMAT($fecha_liquidacion,'%Y'))";
								$result_descuentos = $this -> DbFetchAll($select_descuentos,$Conex); 
								
								$porcentaje_pension = $result_descuentos[0]['desc_emple_pension'];
								$porcentaje_salud   = $result_descuentos[0]['desc_emple_salud'];
								//exit("asdasd".$porcentaje_pension.$porcentaje_salud.$select_descuentos);
								$descuento_pension = ($sueldo_base*$porcentaje_pension)/100;
								$descuento_salud = ($sueldo_base*$porcentaje_salud)/100;
								
								$valor_pagar = $sueldo_base-($descuento_pension+$descuento_salud);

								$observaciones_salud = str_replace("'",'',$observaciones)." -DESC SALUD";
		                        $observaciones_pension = str_replace("'",'',$observaciones)." -DESC PENSION";
								
								//registro descuento salud todos
								$insert_desc_salud ="INSERT INTO detalle_vacaciones_puc (liquidacion_vacaciones_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_vacaciones,porcentaje_vacaciones,formula_vacaciones,desc_vacaciones,deb_item_vacaciones,cre_item_vacaciones,valor_liquida,contrapartida)
								VALUES
								($liquidacion_vacaciones_id,$puc_salud,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_provision,IF($centro_costo_provision>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_provision),'NULL'),0,'NULL','NULL','$observaciones_salud',0,$descuento_salud,$descuento_salud,0)";
								$this -> query($insert_desc_salud,$Conex,true);
								
								//registro descuento pension todos
								$insert_desc_pension ="INSERT INTO detalle_vacaciones_puc (liquidacion_vacaciones_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_vacaciones,porcentaje_vacaciones,formula_vacaciones,desc_vacaciones,deb_item_vacaciones,cre_item_vacaciones,valor_liquida,contrapartida)
								VALUES
								($liquidacion_vacaciones_id,$puc_pension,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_provision,IF($centro_costo_provision>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_provision),'NULL'),0,'NULL','NULL','$observaciones_pension',0,$descuento_pension,$descuento_pension,0)";
								$this -> query($insert_desc_pension,$Conex,true);
								
								//registro contrapartida todos
								$insert_det_puc_contra ="INSERT INTO detalle_vacaciones_puc (liquidacion_vacaciones_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_vacaciones,porcentaje_vacaciones,formula_vacaciones,desc_vacaciones,deb_item_vacaciones,cre_item_vacaciones,valor_liquida,contrapartida)
								VALUES
								($liquidacion_vacaciones_id,$puc_contrapartida,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_provision,IF($centro_costo_provision>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_provision),'NULL'),0,'NULL','NULL',$observaciones,0,$valor_pagar,$valor_pagar,1)";
								$this -> query($insert_det_puc_contra,$Conex,true);
								
								$liquidacion_vacacion .= ','.$liquidacion_vacaciones_id;
						}
					            /* $liquidacion_vacacion = $liquidacion_vacacion==null ?  $liquidacion_vacaciones_id : $liquidacion_vacacion.','.$liquidacion_vacaciones_id; */
					
				}
				$liquidacion_vacaciones_id=substr($liquidacion_vacacion,1);


				$this -> Commit($Conex);
				print($liquidacion_vacaciones_id);
				
		}       
  
		
	
  }
	
  public function Update($Campos,$Conex){	
    $this -> Begin($Conex);
	
	$fecha_liquidacion		= $this -> requestDataForQuery('fecha_liquidacion','date');
	$empleado_id			= $this -> requestDataForQuery('empleado_id','integer');
	$valor_total					= $this -> requestDataForQuery('$valor_total','text');
	$concepto				= $this -> requestDataForQuery('concepto','text');
	$dias					= $this -> requestDataForQuery('dias','text');
	$fecha_dis_inicio			= $this -> requestDataForQuery('fecha_dis_inicio','date');
	$fecha_dis_final			= $this -> requestDataForQuery('fecha_dis_final','date');
	$fecha_reintegro			= $this -> requestDataForQuery('fecha_reintegro','date');
	$observaciones			= $this -> requestDataForQuery('observaciones','text');
	$estado			= $this -> requestDataForQuery('estado','text');
	
	  if($liquidacion_vacaciones_id == 'NULL'){
	    $this -> DbInsertTable("liquidacion_vacaciones",$Campos,$Conex,true,false);			
      }else{
        $select="SELECT contrato_id FROM contrato WHERE empleado_id=$empleado_id";
		$result = $this -> DbFetchAll($select,$Conex,true);
		$contrato_id= $result[0]["contrato_id"];

        
		$update= "UPDATE liquidacion_vacaciones 
		          SET fecha_liquidacion = $fecha_liquidacion,liquidacion_vacaciones_id = $liquidacion_vacaciones_id,contrato_id = $contrato_id ,valor_total = $valor_total, concepto = $concepto,dias = $dias,fecha_dis_inicio = $fecha_dis_inicio ,fecha_dis_final = $fecha_dis_final ,fecha_reintegro = $fecha_reintegro, observaciones = $observaciones,estado = $estado
				  WHERE liquidacion_vacaciones_id=$liquidacion_vacaciones_id";
		
		$this -> query($update,$Conex,true);
		
	  }
	$this -> Commit($Conex);
  }

  public function Delete($Campos,$Conex){
      $this -> DbDeleteTable("novedad_fija",$Campos,$Conex,true,false);
    }
  
   public function ValidateRow($Conex,$Campos){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($Conex,"novedad_fija",$Campos);
	 return $Data -> GetData();
   }
   public function mesContableEstaHabilitado($empresa_id,$oficina_id,$fecha,$Conex){
	  
      $select = "SELECT mes_contable_id,estado FROM mes_contable WHERE empresa_id = $empresa_id AND 
	                  oficina_id = $oficina_id AND '$fecha' BETWEEN fecha_inicio AND fecha_final";
      $result = $this -> DbFetchAll($select,$Conex);
	  
	  $this -> mes_contable_id = $result[0]['mes_contable_id'];
	  
	  return $result[0]['estado'] == 1 ? true : false;
	  
  }
	
  public function PeriodoContableEstaHabilitado($Conex){
	  
	 $mes_contable_id = $this ->  mes_contable_id;
	 
	 if(!is_numeric($mes_contable_id)){
		return false;
     }else{		 
		 $select = "SELECT estado FROM periodo_contable WHERE periodo_contable_id = (SELECT periodo_contable_id FROM 
                         mes_contable WHERE mes_contable_id = $mes_contable_id)";
		 $result = $this -> DbFetchAll($select,$Conex);		 
		 return $result[0]['estado'] == 1? true : false;		 
	   }
	  
  }  

 public function getContabilizarReg($liquidacion_vacaciones_id,$empresa_id,$oficina_id,$usuario_id,$con_fecha,$mesContable,$periodoContable,$valor,$si_empleado,$Conex){

	if($empleado == 1){
	
	$this -> Begin($Conex);
		
		$select 	= "SELECT l.*,
		              (SELECT e.tercero_id FROM empleado e, contrato c WHERE e.empleado_id=c.empleado_id AND c.contrato_id=l.contrato_id)as tercero_id 
					  FROM liquidacion_vacaciones l WHERE l.liquidacion_vacaciones_id = $liquidacion_vacaciones_id";	
		$result 	= $this -> DbFetchAll($select,$Conex,true); 
		
		
		 if($result[0]['encabezado_registro_id']>0 && $result[0]['encabezado_registro_id']!=''){
		  exit('Ya esta en proceso la contabilizaci&oacute;n de la Liquidacion.<br>Por favor Verifique.');
		 }
		 
		$select		="SELECT tipo_documento_id FROM parametros_liquidacion_nomina WHERE oficina_id=$oficina_id";
		$result_doc 	= $this -> DbFetchAll($select,$Conex,true); 
		
		$tip_documento			= $result_doc[0]['tipo_documento_id'];	
		$tipo_documento_id      = $result_doc[0]['tipo_documento_id'];	

		$select_usu = "SELECT CONCAT_WS(' ',t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) AS usuario FROM usuario u, tercero t 
						WHERE u.usuario_id=$usuario_id AND t.tercero_id=u.tercero_id";
		$result_usu	= $this -> DbFetchAll($select_usu,$Conex,true);				

		$encabezado_registro_id	= $this -> DbgetMaxConsecutive("encabezado_de_registro","encabezado_registro_id",$Conex,true,1);	
		
		
		$valor_total            = $result[0]['valor_total'];
		$numero_soporte			= $result[0]['liquidacion_vacaciones_id'];	
		$tercero_id				= $result[0]['tercero_id'];
		$forma_pago_id			= $result_pago[0]['forma_pago_id'];
		
        include_once("UtilidadesContablesModelClass.php");
	  
	    $utilidadesContables = new UtilidadesContablesModel(); 	 		
		
				
		$fecha					   = $result[0]['fecha_liquidacion'];		
	    $fechaMes                  = substr($fecha,0,10);		
		$periodo_contable_id       = $utilidadesContables -> getPeriodoContableId($fechaMes,$Conex);
	    $mes_contable_id           = $utilidadesContables -> getMesContableId($fechaMes,$periodo_contable_id,$Conex);
		
		if($mes_contable_id>0 && $periodo_contable_id>0){
			$consecutivo			= $result[0]['liquidacion_vacaciones_id'];
							
			$concepto				= 'Liquidacion '.$result[0]['concepto'];
			//$puc_id					= $result[0]['puc_contra'];
			$fecha_registro			= date("Y-m-d H:m");
			$modifica				= $result_usu[0]['usuario'];
			//$fuente_facturacion_cod	= $result[0]['fuente_facturacion_cod'];
			$numero_documento_fuente= $numero_soporte;
			$id_documento_fuente	= $result[0]['factura_id'];
			$con_fecha_factura		= $fecha_registro;	
	
			$insert="INSERT INTO encabezado_de_registro (encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,valor,numero_soporte,tercero_id,periodo_contable_id,
								mes_contable_id,consecutivo,fecha,concepto,estado,fecha_registro,modifica,usuario_id,numero_documento_fuente,id_documento_fuente)
								VALUES($encabezado_registro_id,$empresa_id,$oficina_id,$tip_documento,'$valor_total','$numero_soporte',$tercero_id,$periodo_contable_id,
								$mes_contable_id,$consecutivo,'$fecha','$concepto','C','$fecha_registro','$modifica',$usuario_id,'$numero_documento_fuente',$consecutivo)"; 
			$this -> query($insert,$Conex,true);  
	
			
			$select_item      = "SELECT detalle_vacaciones_puc_id  FROM  detalle_vacaciones_puc WHERE liquidacion_vacaciones_id  IN($liquidacion_vacaciones_id)";
			$result_item      = $this -> DbFetchAll($select_item,$Conex);
			foreach($result_item as $result_items){
				$imputacion_contable_id 	= $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,true,1);
				$insert_item ="INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,valor,base,	porcentaje,formula,debito,credito)
								SELECT  
								$imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,desc_vacaciones,$encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,(deb_item_vacaciones+cre_item_vacaciones),base_vacaciones,porcentaje_vacaciones,
								formula_vacaciones,deb_item_vacaciones,cre_item_vacaciones
								FROM detalle_vacaciones_puc WHERE liquidacion_vacaciones_id = $liquidacion_vacaciones_id AND detalle_vacaciones_puc_id=$result_items[detalle_vacaciones_puc_id]"; 
				$this -> query($insert_item,$Conex);
			}

			if(strlen($this -> GetError()) > 0){
				$this -> Rollback($Conex);
			}else{		
			
				$update = "UPDATE liquidacion_vacaciones SET encabezado_registro_id=$encabezado_registro_id,	
							estado= 'C',con_usuario_id=$usuario_id,con_fecha='$con_fecha'
							WHERE liquidacion_vacaciones_id = $liquidacion_vacaciones_id";	
				$this -> query($update,$Conex,true);		  
			
				if(strlen($this -> GetError()) > 0){
					$this -> Rollback($Conex);
					
				}else{		
					$this -> Commit($Conex);
					return true;
				}  
			}  

		}else{
			exit("No es posible contabilizar");
		}
	}else{
				$this -> Begin($Conex);
				$resultado = explode(',',$liquidacion_vacaciones_id);
				/* $numero = count($resultado);
				exit("numero ".$numero); */
				foreach($resultado as $liquidacion_id){
				 
					$select = "SELECT l.*,
		              (SELECT e.tercero_id FROM empleado e, contrato c WHERE e.empleado_id=c.empleado_id AND c.contrato_id=l.contrato_id)as tercero_id 
					  FROM liquidacion_vacaciones l WHERE l.liquidacion_vacaciones_id = $liquidacion_id";	
					  
					$result 	= $this -> DbFetchAll($select,$Conex,true); 
		
		
					if($result[0]['encabezado_registro_id']>0 && $result[0]['encabezado_registro_id']!=''){
					     exit('Ya esta en proceso la contabilizaci&oacute;n de la Liquidacion.<br>Por favor Verifique.');
					}
					
					$select		="SELECT tipo_documento_id FROM parametros_liquidacion_nomina WHERE oficina_id=$oficina_id";
					$result_doc 	= $this -> DbFetchAll($select,$Conex,true); 
					
					$tip_documento			= $result_doc[0]['tipo_documento_id'];	
					$tipo_documento_id      = $result_doc[0]['tipo_documento_id'];	

					$select_usu = "SELECT CONCAT_WS(' ',t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) AS usuario FROM usuario u, tercero t 
									WHERE u.usuario_id=$usuario_id AND t.tercero_id=u.tercero_id";
					$result_usu	= $this -> DbFetchAll($select_usu,$Conex,true);				

					$encabezado_registro_id	= $this -> DbgetMaxConsecutive("encabezado_de_registro","encabezado_registro_id",$Conex,true,1);	
					
		
					$valor_total            = $result[0]['valor_total'];
					$numero_soporte			= $result[0]['liquidacion_vacaciones_id'];	
					$tercero_id				= $result[0]['tercero_id'];
					$forma_pago_id			= $result_pago[0]['forma_pago_id'];
		
       				include_once("UtilidadesContablesModelClass.php");
	  
	    			$utilidadesContables = new UtilidadesContablesModel(); 	 		
		
				
					$fecha					   = $result[0]['fecha_liquidacion'];		
					$fechaMes                  = substr($fecha,0,10);		
					$periodo_contable_id       = $utilidadesContables -> getPeriodoContableId($fechaMes,$Conex);
					$mes_contable_id           = $utilidadesContables -> getMesContableId($fechaMes,$periodo_contable_id,$Conex);
					
					if($mes_contable_id>0 && $periodo_contable_id>0){
						$consecutivo			= $result[0]['liquidacion_vacaciones_id'];
										
						$concepto				= 'Liquidacion '.$result[0]['concepto'];
						//$puc_id					= $result[0]['puc_contra'];
						$fecha_registro			= date("Y-m-d H:m");
						$modifica				= $result_usu[0]['usuario'];
						//$fuente_facturacion_cod	= $result[0]['fuente_facturacion_cod'];
						$numero_documento_fuente= $numero_soporte;
						$id_documento_fuente	= $result[0]['factura_id'];
						$con_fecha_factura		= $fecha_registro;	
	
					$insert="INSERT INTO encabezado_de_registro (encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,valor,numero_soporte,tercero_id,periodo_contable_id,
										mes_contable_id,consecutivo,fecha,concepto,estado,fecha_registro,modifica,usuario_id,numero_documento_fuente,id_documento_fuente)
										VALUES($encabezado_registro_id,$empresa_id,$oficina_id,$tip_documento,'$valor_total','$numero_soporte',$tercero_id,$periodo_contable_id,
										$mes_contable_id,$consecutivo,'$fecha','$concepto','C','$fecha_registro','$modifica',$usuario_id,'$numero_documento_fuente',$consecutivo)"; 
					
					$this -> query($insert,$Conex,true);  
			
			
					$select_item      = "SELECT detalle_vacaciones_puc_id  FROM  detalle_vacaciones_puc WHERE liquidacion_vacaciones_id = $liquidacion_id";
					$result_item      = $this -> DbFetchAll($select_item,$Conex);
					foreach($result_item as $result_items){
						$imputacion_contable_id 	= $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,true,1);
						$insert_item ="INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,valor,base,	porcentaje,formula,debito,credito)
										SELECT  
										$imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,desc_vacaciones,$encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,(deb_item_vacaciones+cre_item_vacaciones),base_vacaciones,porcentaje_vacaciones,
										formula_vacaciones,deb_item_vacaciones,cre_item_vacaciones
										FROM detalle_vacaciones_puc WHERE liquidacion_vacaciones_id = $liquidacion_id AND detalle_vacaciones_puc_id=$result_items[detalle_vacaciones_puc_id]"; 
						$this -> query($insert_item,$Conex);
					}

			        if(strlen($this -> GetError()) > 0){
			            $this -> Rollback($Conex);
					}else{		
					
						$update = "UPDATE liquidacion_vacaciones SET encabezado_registro_id=$encabezado_registro_id,	
									estado= 'C',con_usuario_id=$usuario_id,con_fecha='$con_fecha'
									WHERE liquidacion_vacaciones_id = $liquidacion_id";	
									
						$this -> query($update,$Conex,true);		  
					
						if(strlen($this -> GetError()) > 0){
							$this -> Rollback($Conex);
						}
					}  

					}else{
						exit("No es posible contabilizar");
					}
					
					
				}//cierra for
				
				$this -> Commit($Conex);
                return true;
				

	}
  }

    public function selectDatosLiquidacionId($liquidacion_vacaciones_id,$Conex){
  
 	$select = "SELECT lv.*,(SELECT e.empleado_id FROM empleado e,contrato c WHERE e.empleado_id= c.empleado_id AND c.contrato_id=lv.contrato_id)as empleado_id
	FROM liquidacion_vacaciones lv WHERE lv.liquidacion_vacaciones_id = $liquidacion_vacaciones_id"; 
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	return $result;
	
   }
    public function getTotalDebitoCredito($liquidacion_vacaciones_id,$Conex){
	  
	  $select = "SELECT SUM(deb_item_vacaciones) AS debito,SUM(cre_item_vacaciones) AS credito 
	             FROM detalle_vacaciones_puc WHERE liquidacion_vacaciones_id IN ($liquidacion_vacaciones_id)";
      $result = $this -> DbFetchAll($select,$Conex,true);
	  
	  return $result; 
	  
  }
    public function getDataEmpleado($empleado_id,$Conex){
  
 	$select = "SELECT c.contrato_id,c.sueldo_base,c.fecha_inicio,(SELECT nombre_cargo FROM cargo WHERE cargo_id=c.cargo_id)as cargo, (SELECT t.numero_identificacion FROM tercero t, empleado e WHERE t.tercero_id=e.tercero_id AND e.empleado_id=c.empleado_id)as numero_identificacion,
	(SELECT CONCAT_WS(' ', t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, empleado e WHERE t.tercero_id=e.tercero_id AND e.empleado_id=c.empleado_id) as empleado
	FROM contrato c WHERE c.empleado_id=$empleado_id AND estado='A'  "; 
	//echo $select;
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	if(count($result)>0){
		return $result;
	}else {
		exit("No se encontr&oacute; un contrato activo para el empleado!!");
	}
	
   }

   public function getCalcularLiqTodos($Conex){
  
	 $select="SELECT SUM(c.sueldo_base) AS sueldos FROM contrato c WHERE c.estado='A'";
	 $result = $this -> DbFetchAll($select,$Conex);

	if(count($result)>0){
		return $result;
	}else {
		exit("¡No se encontr&oacute; un contrato activo!");
	}
	
   }
   
 	public function GetTipoConcepto($Conex){
		return $this  -> DbFetchAll("SELECT tipo_concepto_laboral_id AS value,concepto AS text FROM tipo_concepto ORDER BY concepto ASC",$Conex,$ErrDb = false);
	  }   
	  

	public function cancellation($liquidacion_vacaciones_id,$encabezado_registro_id,$causal_anulacion_id,$observacion_anulacion,$usuario_anulo_id,$Conex){
  
   $this -> Begin($Conex);
  
     $update = "UPDATE liquidacion_vacaciones SET estado = 'I',causal_anulacion_id = $causal_anulacion_id,observacion_anulacion = $observacion_anulacion,
	 fecha_anulacion = NOW(),usuario_anulo_id = $usuario_anulo_id WHERE liquidacion_vacaciones_id = $liquidacion_vacaciones_id";
	 $this -> query($update,$Conex,true);
	 
	 
	 if($encabezado_registro_id>0){

		$insert = "INSERT INTO encabezado_de_registro_anulado SELECT $encabezado_registro_id AS 
		encabezado_de_registro_anulado_id,encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,
		forma_pago_id,valor,numero_soporte,tercero_id,periodo_contable_id,mes_contable_id,consecutivo,
		fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,$causal_anulacion_id AS causal_anulacion_id,
		$observacion_anulacion AS observaciones, $usuario_anulo_id, NOW(),usuario_actualiza,fecha_actualiza FROM encabezado_de_registro WHERE encabezado_registro_id = $encabezado_registro_id";
		$this -> query($insert,$Conex,true);
	
		$insert = "INSERT INTO imputacion_contable_anulada SELECT  imputacion_contable_id AS  
		imputacion_contable_anulada_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id AS 
		encabezado_registro_anulado_id,centro_de_costo_id,codigo_centro_costo,numero,valor,amortiza,deprecia,base,porcentaje,formula,debito,credito,area_id,departamento_id,unidad_negocio_id,sucursal_id  FROM 
		imputacion_contable WHERE encabezado_registro_id = $encabezado_registro_id";
		$this -> query($insert,$Conex,true);
			
		$update = "UPDATE encabezado_de_registro SET estado = 'A',anulado = 1, usuario_anula=$usuario_anulo_id, fecha_anulacion=NOW() WHERE encabezado_registro_id = $encabezado_registro_id";	  
		$this -> query($update,$Conex,true);	
			  
		$update = "UPDATE imputacion_contable SET debito = 0,credito = 0 WHERE encabezado_registro_id=$encabezado_registro_id";
		$this -> query($update,$Conex,true);			  
				
	 }
	 
     $this -> Commit($Conex);
  
  }    

  public function cancellation1($liquidacion_vacaciones_id,$encabezado_registro_id,$fecha_liquidacion,$causal_anulacion_id,$observacion_anulacion,$usuario_anulo_id,$Conex){
  
   $this -> Begin($Conex);
  
     $update = "UPDATE liquidacion_cesantias SET estado = 'I',causal_anulacion_id = $causal_anulacion_id,observacion_anulacion = $observacion_anulacion,
	 fecha_anulacion = NOW(),usuario_anulo_id = $usuario_anulo_id WHERE fecha_liquidacion = '$fecha_liquidacion'  AND encabezado_registro_id=$encabezado_registro_id";
	 $this -> query($update,$Conex,true);

	 if($encabezado_registro_id>0){

		$insert = "INSERT INTO encabezado_de_registro_anulado SELECT $encabezado_registro_id AS 
		encabezado_de_registro_anulado_id,encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,
		forma_pago_id,valor,numero_soporte,tercero_id,periodo_contable_id,mes_contable_id,consecutivo,
		fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,$causal_anulacion_id AS causal_anulacion_id,
		$observacion_anulacion AS observaciones,$usuario_anulo_id, NOW(),usuario_actualiza,fecha_actualiza FROM encabezado_de_registro WHERE encabezado_registro_id = $encabezado_registro_id";
		$this -> query($insert,$Conex,true);
	
		$insert = "INSERT INTO imputacion_contable_anulada SELECT  imputacion_contable_id AS  
		imputacion_contable_anulada_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id AS 
		encabezado_registro_anulado_id,centro_de_costo_id,codigo_centro_costo,numero,valor,amortiza,deprecia,base,porcentaje,formula,debito,credito,area_id,departamento_id,unidad_negocio_id,sucursal_id  FROM 
		imputacion_contable WHERE encabezado_registro_id = $encabezado_registro_id";
		$this -> query($insert,$Conex,true);
			
		$update = "UPDATE encabezado_de_registro SET estado = 'A',anulado = 1, usuario_anula=$usuario_anulo_id, fecha_anulacion=NOW() WHERE encabezado_registro_id = $encabezado_registro_id";	  
		$this -> query($update,$Conex,true);	
			  
		$update = "UPDATE imputacion_contable SET debito = 0,credito = 0 WHERE encabezado_registro_id=$encabezado_registro_id";
		$this -> query($update,$Conex,true);			  
				
	 }
	 
     $this -> Commit($Conex);
  
  }    

   public function GetQueryVacacionGrid(){
   	$Query = "SELECT lv.liquidacion_vacaciones_id,(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, empleado e,contrato c WHERE t.tercero_id=e.tercero_id AND e.empleado_id=c.empleado_id AND c.contrato_id=lv.contrato_id)as contrato_id, IF(lv.encabezado_registro_id>0,(SELECT e.consecutivo FROM encabezado_de_registro e WHERE e.encabezado_registro_id=lv.encabezado_registro_id),'N/A')AS encabezado_registro_id, lv.fecha_liquidacion,lv.fecha_dis_inicio,lv.fecha_dis_final,lv.fecha_reintegro,lv.dias, lv.valor, lv.concepto,lv.observaciones, (CASE WHEN lv.estado='A' THEN 'ACTIVO' WHEN lv.estado='I' THEN 'INACTIVO' ELSE 'CONTABILIZADO' END)AS estado
	FROM liquidacion_vacaciones lv";
	
   return $Query;
   }
}

?>
<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");


final class PrimaModel extends Db{
		
  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }

  public function getCausalesAnulacion($Conex){
		
	$select = "SELECT causal_anulacion_id AS value,nombre AS text FROM causal_anulacion ORDER BY nombre";
	$result = $this -> DbFetchAll($select,$Conex,true);
	
	return $result;		
  }


 public function Save($Campos,$oficina_id,$Conex){
        
		$empleado_id				= $this -> requestDataForQuery('empleado_id','integer');
		$observaciones   			= $this -> requestDataForQuery('observaciones','text');
		$periodo   	   				= $this -> requestDataForQuery('periodo','integer');
		$fecha_liquidacion 	 		= $this -> requestDataForQuery('fecha_liquidacion','date');		
		$valor   					= $this -> requestDataForQuery('total','numeric');
		$si_empleado			    = $this -> requestDataForQuery('si_empleado','text');
		$tipo_liquidacion			= $this -> requestDataForQuery('tipo_liquidacion','text');
		$acumulado					= $this -> requestDataForQuery('acumulado','integer');
		$diferencia					= $this -> requestDataForQuery('diferencia','integer');

		if($si_empleado == "'1'"){
			
			$this -> Begin($Conex);

				$select_contrato = "SELECT c.contrato_id,
				                  (SELECT e.tercero_id FROM empleado e WHERE e.empleado_id=c.empleado_id)as tercero_id,
								  c.area_laboral,
								  (c.sueldo_base+c.subsidio_transporte) as sueldo_base,
								  c.fecha_inicio,
								   DATEDIFF($fecha_liquidacion ,c.fecha_inicio) as dias_trabajados,
								   c.centro_de_costo_id,
								   c.fecha_ult_prima,
								   c.valor_prima 
								   
								   FROM contrato c WHERE c.empleado_id=$empleado_id AND estado='A' ";
				
				$result_contrato = $this -> DbFetchAll($select_contrato,$Conex); 

				$contrato_id	 = $result_contrato[0]['contrato_id'];
				$tercero_id	 = $result_contrato[0]['tercero_id'];
				$centro_de_costo_id = $result_contrato[0]['centro_de_costo_id'];
				$area_laboral	 = $result_contrato[0]['area_laboral'];
				$fecha_ult_prima	 = $result_contrato[0]['fecha_ult_prima'];
				$fecha_ini	 = $result_contrato[0]['fecha_inicio'];
				$valor_prima	 = $result_contrato[0]['valor_prima'];

				$fecha_liquidacion_val=str_replace("'","",$fecha_liquidacion);

				if($fecha_ult_prima != $fecha_liquidacion_val){

				$liq_anterior = $this -> Liq_Anterior($empleado_id,$fecha_liquidacion,$periodo,$oficina_id,$Conex);

                $fecha_anterior_valida = $liq_anterior[0]['fecha_liquidacion'];
				$fecha_anterior = substr($liq_anterior[0]['fecha_liquidacion'],0,4);
				$fecha_liquidacion_valida = substr($fecha_liquidacion,0,4);
			
				$periodo_anterior    = $liq_anterior[0]['periodo'];
				$total    = $liq_anterior[0]['total'];

				
				$estado = "'A'";
				$liquidacion_prima_id 		= $this -> DbgetMaxConsecutive("liquidacion_prima","liquidacion_prima_id",$Conex,false,1);
				$consecutivo 		= $this -> DbgetMaxConsecutive("liquidacion_prima","consecutivo",$Conex,false,1);
				
				$insert_prima = "INSERT INTO liquidacion_prima 
				(liquidacion_prima_id,consecutivo,contrato_id,fecha_liquidacion,estado,total,tipo_liquidacion,periodo,observaciones)
				VALUES
				($liquidacion_prima_id,$consecutivo,$contrato_id,$fecha_liquidacion,$estado,$valor,$tipo_liquidacion,$periodo,$observaciones)";
				
				$this -> query($insert_prima,$Conex,true);


				$update = "UPDATE contrato SET fecha_ult_prima=$fecha_liquidacion,valor_prima=$valor
							WHERE contrato_id=$contrato_id";	
				$this -> query($update,$Conex,true);

				  
				$select_datos_ter="SELECT numero_identificacion,digito_verificacion FROM tercero WHERE tercero_id=$tercero_id";
				$result_datos_ter = $this -> DbFetchAll($select_datos_ter,$Conex) ;
				
				$numero_identificacion = $result_datos_ter[0]['numero_identificacion'];
				$digito_verificacion   = $result_datos_ter[0]['digito_verificacion']>0 ? $result_datos_ter[0]['digito_verificacion']>0 :'NULL';
				
				$select_parametros="SELECT 
				puc_prima_prov_id,puc_prima_cons_id,puc_prima_contra_id,puc_admon_prima_id,puc_ventas_prima_id,puc_produ_prima_id,tipo_documento_id,puc_reintegro_prima_id
				FROM parametros_liquidacion_nomina WHERE oficina_id=$oficina_id";
				$result_parametros = $this -> DbFetchAll($select_parametros,$Conex,true); 
				
				
				$puc_consolidado_prima = $result_parametros[0]['puc_prima_cons_id'];
				$puc_reintegro			= $result_parametros[0]['puc_reintegro_prima_id'];
				$puc_contrapartida		  = $result_parametros[0]['puc_prima_contra_id'];

				$puc_admin				= $result_parametros[0]['puc_admon_prima_id'];
				$puc_venta				= $result_parametros[0]['puc_ventas_prima_id'];
				$puc_operativo			= $result_parametros[0]['puc_produ_prima_id'];
				
				$tipo_doc				= $result_parametros[0]['tipo_documento_id'];

				$consulta_periodo = " AND fecha BETWEEN '$fecha_ini' AND $fecha_liquidacion";
				
				$select_consolidado = "SELECT SUM(credito-debito)as neto,
				                             centro_de_costo_id 
									  FROM imputacion_contable WHERE puc_id=$puc_consolidado_prima AND tercero_id=$tercero_id AND encabezado_registro_id IN (SELECT encabezado_registro_id FROM encabezado_de_registro WHERE estado='C' $consulta_periodo)";
		        
				$result_consolidado = $this -> DbFetchAll($select_consolidado,$Conex,true); 
				
				
				$valor_consolidado = $result_consolidado[0]['neto']>0 ? intval($result_consolidado[0]['neto']) : 0 ;
				$centro_costo_consolidado = $result_consolidado[0]['centro_de_costo_id']>0 ? $result_consolidado[0]['centro_de_costo_id'] : 'NULL';
				
				
				$valor_guardado = intval($valor_consolidado);
				
				if($valor_consolidado>0){
					
					$insert_det_puc_cons ="INSERT INTO detalle_prima_puc (liquidacion_prima_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_prima,porcentaje_prima,formula_prima,desc_prima,deb_item_prima,cre_item_prima,valor_liquida,contrapartida)
					VALUES
					($liquidacion_prima_id,$puc_consolidado_prima,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_consolidado,IF($centro_costo_consolidado>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_consolidado),'NULL'),0,'NULL','NULL',$observaciones,$valor_consolidado,0,$valor_consolidado,0)";
					$this -> query($insert_det_puc_cons,$Conex,true); 
					
				}

			if($valor>$valor_guardado){

					if($area_laboral=='A'){
						$puc_diferencia = $puc_admin;
					}elseif($area_laboral=='O'){
						$puc_diferencia = $puc_operativo;
					}elseif($area_laboral=='C'){
						$puc_diferencia = $puc_venta;
					}

				   $diferencia = ($valor-$valor_guardado);

					if($diferencia>0){
						
						$insert_det_puc_gas ="INSERT INTO detalle_prima_puc (liquidacion_prima_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_prima,porcentaje_prima,formula_prima,desc_prima,deb_item_prima,cre_item_prima,valor_liquida,contrapartida)
						VALUES
						($liquidacion_prima_id,$puc_diferencia,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_consolidado,IF(COALESCE($centro_costo_consolidado,0)>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_consolidado),'NULL'),0,'NULL','NULL',$observaciones,$diferencia,0,$diferencia,0)";
						$this -> query($insert_det_puc_gas,$Conex,true);
						
					}else{
					
						$insert_det_puc_gas ="INSERT INTO detalle_prima_puc (liquidacion_prima_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_prima,porcentaje_prima,formula_prima,desc_prima,deb_item_prima,cre_item_prima,valor_liquida,contrapartida)
						VALUES
						($liquidacion_prima_id,$puc_diferencia,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_consolidado,IF(COALESCE($centro_costo_consolidado,0)>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_consolidado),'NULL'),0,'NULL','NULL',$observaciones,0,ABS($diferencia),ABS($diferencia),0)";
						$this -> query($insert_det_puc_gas,$Conex,true);
						
					} 
				
			
			}else if($valor<$valor_guardado){

				   $diferencia = ($valor_guardado-$valor);

				if($diferencia>0){
					
					$insert_det_puc_gas ="INSERT INTO detalle_prima_puc (liquidacion_prima_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_prima,porcentaje_prima,formula_prima,desc_prima,deb_item_prima,cre_item_prima,valor_liquida,contrapartida)
					VALUES
					($liquidacion_prima_id,$puc_reintegro,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_consolidado,IF(COALESCE($centro_costo_consolidado,0)>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_consolidado),'NULL'),0,'NULL','NULL',$observaciones,0,$diferencia,$diferencia,0)";
					$this -> query($insert_det_puc_gas,$Conex,true);
					
				}else{
                   
					$insert_det_puc_gas ="INSERT INTO detalle_prima_puc (liquidacion_prima_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_prima,porcentaje_prima,formula_prima,desc_prima,deb_item_prima,cre_item_prima,valor_liquida,contrapartida)
					VALUES
					($liquidacion_prima_id,$puc_diferencia,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_consolidado,IF(COALESCE($centro_costo_consolidado,0)>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_consolidado),'NULL'),0,'NULL','NULL',$observaciones,ABS($diferencia),0,$diferencia,0)";
					$this -> query($insert_det_puc_gas,$Conex,true);
					
				} 

			}
							
				
				$insert_det_puc_contra ="INSERT INTO detalle_prima_puc (liquidacion_prima_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_prima,porcentaje_prima,formula_prima,desc_prima,deb_item_prima,cre_item_prima,valor_liquida,contrapartida)
				VALUES
				($liquidacion_prima_id,$puc_contrapartida,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_consolidado,IF($centro_costo_consolidado>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_consolidado),'NULL'),0,'NULL','NULL',$observaciones,0,$valor,$valor,1)";
				$this -> query($insert_det_puc_contra,$Conex,true);
				
		    }else{
				exit("No es posible hacer la liquidación ya que previamente le hicieron una liquidacion con las mismas fechas");
			}	
			
			$this -> Commit($Conex);  
			print($liquidacion_prima_id);
		}else{

			if($tipo_liquidacion=='T'){

			$this -> Begin($Conex);
			

			$select="SELECT c.contrato_id,c.sueldo_base FROM contrato c, tipo_contrato t WHERE c.estado='A' AND t.tipo_contrato_id=c.tipo_contrato_id AND t.prestaciones_sociales=1";
			$result = $this -> DbFetchAll($select,$Conex);
			
			$consecutivo 		= $this -> DbgetMaxConsecutive("liquidacion_prima","consecutivo",$Conex,false,1);
			
			foreach($result as $resultado){
				
				$contrato_id = $resultado[contrato_id];
				
				
				$select_contrato = "SELECT c.empleado_id,
					                           (SELECT e.tercero_id FROM empleado e WHERE e.empleado_id=c.empleado_id)as tercero_id,
											   c.area_laboral,
											   (c.sueldo_base+c.subsidio_transporte) as sueldo_base,
											   c.fecha_inicio, 
											   c.fecha_ult_prima

										FROM contrato c WHERE c.contrato_id=$contrato_id AND estado='A' ";
					
					
					$result_contrato = $this -> DbFetchAll($select_contrato,$Conex); 
					$empleado_id	 = $result_contrato[0]['empleado_id'];
					$tercero_id	 = $result_contrato[0]['tercero_id'];
					$area_laboral	 = $result_contrato[0]['area_laboral'];
					$dias_laborados	 = $result_contrato[0]['dias_laborados']>180 ? 180 : $result_contrato[0]['dias_laborados'] -1;
					$sueldo_base	 = $result_contrato[0]['sueldo_base'];
					$centro_de_costo_id = $result_contrato[0]['centro_de_costo_id'];
					$fecha_inicio_cont	 = $result_contrato[0]['fecha_inicio'];
					$fecha_ult_prima	 = $result_contrato[0]['fecha_ult_prima'];
					
					$fecha_liquidacion_val=str_replace("'","",$fecha_liquidacion);
					if($fecha_ult_prima != $fecha_liquidacion_val){//esta validacion aplica para que si al empleaod ya le hicieron una liquidacion individual, no se repita cuando la hagan para todos
					
					$liq_anterior = $this -> Liq_Anterior($empleado_id,$fecha_liquidacion,$periodo,$oficina_id,$Conex);
					
					$fecha_anterior_valida = $liq_anterior[0]['fecha_liquidacion'];
					$fecha_anterior = substr($liq_anterior[0]['fecha_liquidacion'],0,4);
					$fecha_liquidacion_valida = substr($fecha_liquidacion,1,4);
					
					$periodo_anterior    = $liq_anterior[0]['periodo'];
					$total    = $liq_anterior[0]['total'];

				
						//exit("fech_ant ".$fecha_anterior." fecha_liq_valida ".$fecha_liquidacion_valida." periodo_ant ".$periodo_anterior." periodo ".$periodo);
						if($fecha_anterior == $fecha_liquidacion_valida && $periodo_anterior==$periodo) {
							$prima = (($sueldo_base/2)-$total);
							$valor=$prima;
						}else{
							$prima = (($sueldo_base/2));
							$valor=$prima;
						}  
					
				
				$estado = "'A'";
				$liquidacion_prima_id 		= $this -> DbgetMaxConsecutive("liquidacion_prima","liquidacion_prima_id",$Conex,false,1);
				
				$insert_prima = "INSERT INTO liquidacion_prima 
				(liquidacion_prima_id,consecutivo,contrato_id,fecha_liquidacion,estado,total,tipo_liquidacion,periodo,observaciones)
				VALUES
				($liquidacion_prima_id,$consecutivo,$contrato_id,$fecha_liquidacion,$estado,$valor,$tipo_liquidacion,$periodo,$observaciones)";
				//exit($insert_prima);
				$this -> query($insert_prima,$Conex,true);

				$update = "UPDATE contrato SET fecha_ult_prima=$fecha_liquidacion,valor_prima=$valor
							WHERE contrato_id=$contrato_id";	
				$this -> query($update,$Conex,true);				
				
				  
				$select_datos_ter="SELECT numero_identificacion,digito_verificacion, CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) as nombre FROM tercero WHERE tercero_id=$tercero_id";
				$result_datos_ter = $this -> DbFetchAll($select_datos_ter,$Conex) ;
				
				$numero_identificacion = $result_datos_ter[0]['numero_identificacion'];
				$digito_verificacion   = $result_datos_ter[0]['digito_verificacion']>0 ? $result_datos_ter[0]['digito_verificacion']>0 :'NULL';//NULL
				$nombre_tercero = $result_datos_ter[0]['nombre'];
				
				$select_parametros="SELECT 
				puc_prima_prov_id,puc_prima_cons_id,puc_prima_contra_id,puc_admon_prima_id,puc_ventas_prima_id,puc_produ_prima_id,tipo_documento_id,puc_reintegro_prima_id
				FROM parametros_liquidacion_nomina WHERE oficina_id=$oficina_id";
				$result_parametros = $this -> DbFetchAll($select_parametros,$Conex); 
				
				if(!count($result_parametros)>0) exit("No se han configurado los parametros para la oficina!! ");
				
				$puc_consolidado_prima = $result_parametros[0]['puc_prima_cons_id'];
				$puc_reintegro			= $result_parametros[0]['puc_reintegro_prima_id'];
				$puc_contrapartida		  = $result_parametros[0]['puc_prima_contra_id'];

				$puc_admin				= $result_parametros[0]['puc_admon_prima_id'];
				$puc_venta				= $result_parametros[0]['puc_ventas_prima_id'];
				$puc_operativo			= $result_parametros[0]['puc_produ_prima_id'];
				
				$tipo_doc				= $result_parametros[0]['tipo_documento_id'];
				
				$consulta_periodo = " AND fecha BETWEEN '$fecha_inicio_cont' AND $fecha_liquidacion";
				
				$select_consolidado = "SELECT SUM(credito-debito)as neto,centro_de_costo_id FROM imputacion_contable WHERE puc_id=$puc_consolidado_prima AND tercero_id=$tercero_id AND encabezado_registro_id IN (SELECT encabezado_registro_id FROM encabezado_de_registro WHERE estado='C' $consulta_periodo)";
		
				$result_consolidado = $this -> DbFetchAll($select_consolidado,$Conex,true); 
				
				
				$valor_consolidado = $result_consolidado[0]['neto']>0 ? intval($result_consolidado[0]['neto']) : 0 ;
				$centro_costo_consolidado = $result_consolidado[0]['centro_de_costo_id']>0 ? $result_consolidado[0]['centro_de_costo_id'] : 'NULL';
				
				$update = "UPDATE liquidacion_prima SET acumulado=$valor_consolidado
							WHERE liquidacion_prima_id=$liquidacion_prima_id";	
				$this -> query($update,$Conex,true);
				
				$valor_guardado = intval($valor_consolidado);
				
				if($valor_consolidado>0){
					
					$insert_det_puc_cons ="INSERT INTO detalle_prima_puc (liquidacion_prima_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_prima,porcentaje_prima,formula_prima,desc_prima,deb_item_prima,cre_item_prima,valor_liquida,contrapartida)
					VALUES
					($liquidacion_prima_id,$puc_consolidado_prima,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_consolidado,IF($centro_costo_consolidado>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_consolidado),'NULL'),0,'NULL','NULL',$observaciones,$valor_consolidado,0,$valor_consolidado,0)";
					$this -> query($insert_det_puc_cons,$Conex,true); 
					
				}
				
				if($valor>$valor_guardado){
					if($area_laboral=='A'){
						$puc_diferencia = $puc_admin;
					}elseif($area_laboral=='O'){
						$puc_diferencia = $puc_operativo;
					}elseif($area_laboral=='C'){
						$puc_diferencia = $puc_venta;
					}
               
				$diferencia = ($valor-$valor_guardado);

				if($diferencia>0){
					$insert_det_puc_gas ="INSERT INTO detalle_prima_puc (liquidacion_prima_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_prima,porcentaje_prima,formula_prima,desc_prima,deb_item_prima,cre_item_prima,valor_liquida,contrapartida)
					VALUES
					($liquidacion_prima_id,$puc_diferencia,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_consolidado,IF(COALESCE($centro_costo_consolidado,0)>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_consolidado),'NULL'),0,'NULL','NULL',$observaciones,$diferencia,0,$diferencia,0)";
					$this -> query($insert_det_puc_gas,$Conex,true);
					
				}else{

					$insert_det_puc_gas ="INSERT INTO detalle_prima_puc (liquidacion_prima_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_prima,porcentaje_prima,formula_prima,desc_prima,deb_item_prima,cre_item_prima,valor_liquida,contrapartida)
					VALUES
					($liquidacion_prima_id,$puc_diferencia,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_consolidado,IF(COALESCE($centro_costo_consolidado,0)>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_consolidado),'NULL'),0,'NULL','NULL',$observaciones,0,ABS($diferencia),ABS($diferencia),0)";
					$this -> query($insert_det_puc_gas,$Conex,true);
					
				}
				
			}else if($valor<$valor_guardado){

				   $diferencia = ($valor_guardado-$valor);

				if($diferencia>0){
					
					$insert_det_puc_gas ="INSERT INTO detalle_prima_puc (liquidacion_prima_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_prima,porcentaje_prima,formula_prima,desc_prima,deb_item_prima,cre_item_prima,valor_liquida,contrapartida)
					VALUES
					($liquidacion_prima_id,$puc_reintegro,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_consolidado,IF(COALESCE($centro_costo_consolidado,0)>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_consolidado),'NULL'),0,'NULL','NULL',$observaciones,0,$diferencia,$diferencia,0)";
					$this -> query($insert_det_puc_gas,$Conex,true);
					
				}

			}
							
				$insert_det_puc_contra ="INSERT INTO detalle_prima_puc (liquidacion_prima_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_prima,porcentaje_prima,formula_prima,desc_prima,deb_item_prima,cre_item_prima,valor_liquida,contrapartida)
				VALUES
				($liquidacion_prima_id,$puc_contrapartida,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_consolidado,IF($centro_costo_consolidado>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_consolidado),'NULL'),0,'NULL','NULL',$observaciones,0,$valor,$valor,1)";
				$this -> query($insert_det_puc_contra,$Conex,true);
				
				$liquidacion_prima .= ','.$liquidacion_prima_id;
			
			   }
		    } 
			$liquidacion_prima_id=substr($liquidacion_prima,1);
			
			
			$this -> Commit($Conex); 
			print($liquidacion_prima_id);

		   }else{

			   $this -> Begin($Conex);
			

			$select="SELECT c.contrato_id,c.sueldo_base FROM contrato c, tipo_contrato t WHERE c.estado='A' AND t.tipo_contrato_id=c.tipo_contrato_id AND t.prestaciones_sociales=1";
			$result = $this -> DbFetchAll($select,$Conex);
			
			$consecutivo 		= $this -> DbgetMaxConsecutive("liquidacion_prima","consecutivo",$Conex,false,1);
			
			foreach($result as $resultado){
				
				$contrato_id = $resultado[contrato_id];
				
				
				$select_contrato = "SELECT c.empleado_id,
					                           (SELECT e.tercero_id FROM empleado e WHERE e.empleado_id=c.empleado_id)as tercero_id,
											   c.area_laboral,
											   (c.sueldo_base+c.subsidio_transporte) as sueldo_base,
											   c.fecha_inicio, 
											   c.fecha_ult_prima,
											   (SELECT LAST_DAY(c.fecha_ult_prima)) AS ultimo_dia_mes

										FROM contrato c WHERE c.contrato_id=$contrato_id AND estado='A' ";
					
					
					$result_contrato = $this -> DbFetchAll($select_contrato,$Conex,true); 
					$empleado_id	 = $result_contrato[0]['empleado_id'];
					$tercero_id	 = $result_contrato[0]['tercero_id'];
					$area_laboral	 = $result_contrato[0]['area_laboral'];
					$dias_laborados	 = $result_contrato[0]['dias_laborados']>180 ? 180 : $result_contrato[0]['dias_laborados'] -1;
					$sueldo_base	 = $result_contrato[0]['sueldo_base'];
					$centro_de_costo_id = $result_contrato[0]['centro_de_costo_id'];
					$fecha_inicio_cont	 = $result_contrato[0]['fecha_inicio'];
					$fecha_ult_prima	 = $result_contrato[0]['fecha_ult_prima'];
					$ultimo_dia_mes	 = $result_contrato[0]['ultimo_dia_mes'];
					
					$fecha_liquidacion_val=str_replace("'","",$fecha_liquidacion);
					if($fecha_ult_prima != $fecha_liquidacion_val){//esta validacion aplica para que si al empleaod ya le hicieron una liquidacion individual, no se repita cuando la hagan para todos
					
					$liq_anterior = $this -> Liq_Anterior($empleado_id,$fecha_liquidacion,$periodo,$oficina_id,$Conex);
					
					$fecha_anterior_valida = $liq_anterior[0]['fecha_liquidacion'];
					$fecha_anterior = substr($liq_anterior[0]['fecha_liquidacion'],0,4);
					$fecha_liquidacion_valida = substr($fecha_liquidacion,1,4);
					
					$periodo_anterior    = $liq_anterior[0]['periodo'];
					$total    = $liq_anterior[0]['total'];

					

					    if($fecha_ult_prima != ''){

							    if($fecha_anterior == $fecha_liquidacion_valida && $periodo_anterior==$periodo) {
								    $dias_laborados = $this->restaFechasCont($fecha_ult_prima,$fecha_liquidacion_val);
								}else{
									$dias_laborados = $this->restaFechasCont($ultimo_dia_mes,$fecha_liquidacion_val);
								}  
								

						}else if($fecha_anterior_valida != ''){

							if($fecha_anterior == $fecha_liquidacion_valida && $periodo_anterior==$periodo) {
							   $dias_laborados = $this -> restaFechasCont($fecha_anterior_valida,$fecha_liquidacion_val);
						    }else{
								$dias_laborados = $this -> restaFechasCont($ultimo_dia_mes,$fecha_liquidacion_val);
						    }

						}else{

                            if($fecha_anterior == $fecha_liquidacion_valida && $periodo_anterior==$periodo) {
							   $dias_laborados = $this -> restaFechasCont($fecha_inicio_cont,$fecha_liquidacion_val);
						    }else{
								$dias_laborados = $this -> restaFechasCont($ultimo_dia_mes,$fecha_liquidacion_val);
						    }
						} 
						
					$valor = intval((($dias_laborados-1)*($sueldo_base/2))/180);  
					
				
				$estado = "'A'";
				$liquidacion_prima_id 		= $this -> DbgetMaxConsecutive("liquidacion_prima","liquidacion_prima_id",$Conex,false,1);
				
				$insert_prima = "INSERT INTO liquidacion_prima 
				(liquidacion_prima_id,consecutivo,contrato_id,fecha_liquidacion,estado,total,tipo_liquidacion,periodo,observaciones)
				VALUES
				($liquidacion_prima_id,$consecutivo,$contrato_id,$fecha_liquidacion,$estado,$valor,$tipo_liquidacion,$periodo,$observaciones)";
				//exit($insert_prima);
				$this -> query($insert_prima,$Conex,true);

				$update = "UPDATE contrato SET fecha_ult_prima=$fecha_liquidacion,valor_prima=$valor
							WHERE contrato_id=$contrato_id";	
				$this -> query($update,$Conex,true);				
				
				  
				$select_datos_ter="SELECT numero_identificacion,digito_verificacion, CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) as nombre FROM tercero WHERE tercero_id=$tercero_id";
				$result_datos_ter = $this -> DbFetchAll($select_datos_ter,$Conex) ;
				
				$numero_identificacion = $result_datos_ter[0]['numero_identificacion'];
				$digito_verificacion   = $result_datos_ter[0]['digito_verificacion']>0 ? $result_datos_ter[0]['digito_verificacion']>0 :'NULL';//NULL
				$nombre_tercero = $result_datos_ter[0]['nombre'];
				
				$select_parametros="SELECT 
				puc_prima_prov_id,puc_prima_cons_id,puc_prima_contra_id,puc_admon_prima_id,puc_ventas_prima_id,puc_produ_prima_id,tipo_documento_id,puc_reintegro_prima_id
				FROM parametros_liquidacion_nomina WHERE oficina_id=$oficina_id";
				$result_parametros = $this -> DbFetchAll($select_parametros,$Conex); 
				
				if(!count($result_parametros)>0) exit("No se han configurado los parametros para la oficina!! ");
				
				$puc_consolidado_prima = $result_parametros[0]['puc_prima_cons_id'];
				$puc_reintegro			= $result_parametros[0]['puc_reintegro_prima_id'];
				$puc_contrapartida		  = $result_parametros[0]['puc_prima_contra_id'];

				$puc_admin				= $result_parametros[0]['puc_admon_prima_id'];
				$puc_venta				= $result_parametros[0]['puc_ventas_prima_id'];
				$puc_operativo			= $result_parametros[0]['puc_produ_prima_id'];
				
				$tipo_doc				= $result_parametros[0]['tipo_documento_id'];
				
				$consulta_periodo = " AND fecha BETWEEN '$fecha_inicio_cont' AND $fecha_liquidacion";
				
				$select_consolidado = "SELECT SUM(credito-debito)as neto,centro_de_costo_id FROM imputacion_contable WHERE puc_id=$puc_consolidado_prima AND tercero_id=$tercero_id AND encabezado_registro_id IN (SELECT encabezado_registro_id FROM encabezado_de_registro WHERE estado='C' $consulta_periodo)";
		
				$result_consolidado = $this -> DbFetchAll($select_consolidado,$Conex,true); 
				
				
				$valor_consolidado = $result_consolidado[0]['neto']>0 ? intval($result_consolidado[0]['neto']) : 0 ;
				$centro_costo_consolidado = $result_consolidado[0]['centro_de_costo_id']>0 ? $result_consolidado[0]['centro_de_costo_id'] : 'NULL';
				
				$update = "UPDATE liquidacion_prima SET acumulado=$valor_consolidado
							WHERE liquidacion_prima_id=$liquidacion_prima_id";	
				$this -> query($update,$Conex,true);
				
				$valor_guardado = intval($valor_consolidado);
				
				if($valor_consolidado>0){
					
					$insert_det_puc_cons ="INSERT INTO detalle_prima_puc (liquidacion_prima_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_prima,porcentaje_prima,formula_prima,desc_prima,deb_item_prima,cre_item_prima,valor_liquida,contrapartida)
					VALUES
					($liquidacion_prima_id,$puc_consolidado_prima,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_consolidado,IF($centro_costo_consolidado>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_consolidado),'NULL'),0,'NULL','NULL',$observaciones,$valor_consolidado,0,$valor_consolidado,0)";
					$this -> query($insert_det_puc_cons,$Conex,true); 
					
				}
				
				if($valor>$valor_guardado){
					if($area_laboral=='A'){
						$puc_diferencia = $puc_admin;
					}elseif($area_laboral=='O'){
						$puc_diferencia = $puc_operativo;
					}elseif($area_laboral=='C'){
						$puc_diferencia = $puc_venta;
					}
               
				$diferencia = ($valor-$valor_guardado);

				if($diferencia>0){
					$insert_det_puc_gas ="INSERT INTO detalle_prima_puc (liquidacion_prima_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_prima,porcentaje_prima,formula_prima,desc_prima,deb_item_prima,cre_item_prima,valor_liquida,contrapartida)
					VALUES
					($liquidacion_prima_id,$puc_diferencia,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_consolidado,IF(COALESCE($centro_costo_consolidado,0)>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_consolidado),'NULL'),0,'NULL','NULL',$observaciones,$diferencia,0,$diferencia,0)";
					$this -> query($insert_det_puc_gas,$Conex,true);
					
				}else{

					$insert_det_puc_gas ="INSERT INTO detalle_prima_puc (liquidacion_prima_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_prima,porcentaje_prima,formula_prima,desc_prima,deb_item_prima,cre_item_prima,valor_liquida,contrapartida)
					VALUES
					($liquidacion_prima_id,$puc_diferencia,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_consolidado,IF(COALESCE($centro_costo_consolidado,0)>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_consolidado),'NULL'),0,'NULL','NULL',$observaciones,0,ABS($diferencia),ABS($diferencia),0)";
					$this -> query($insert_det_puc_gas,$Conex,true);
					
				}
				
			}else if($valor<$valor_guardado){

				   $diferencia = ($valor_guardado-$valor);

				if($diferencia>0){
					
					$insert_det_puc_gas ="INSERT INTO detalle_prima_puc (liquidacion_prima_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_prima,porcentaje_prima,formula_prima,desc_prima,deb_item_prima,cre_item_prima,valor_liquida,contrapartida)
					VALUES
					($liquidacion_prima_id,$puc_reintegro,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_consolidado,IF(COALESCE($centro_costo_consolidado,0)>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_consolidado),'NULL'),0,'NULL','NULL',$observaciones,0,$diferencia,$diferencia,0)";
					$this -> query($insert_det_puc_gas,$Conex,true);
					
				}

			}
							
				$insert_det_puc_contra ="INSERT INTO detalle_prima_puc (liquidacion_prima_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_prima,porcentaje_prima,formula_prima,desc_prima,deb_item_prima,cre_item_prima,valor_liquida,contrapartida)
				VALUES
				($liquidacion_prima_id,$puc_contrapartida,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_consolidado,IF($centro_costo_consolidado>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_consolidado),'NULL'),0,'NULL','NULL',$observaciones,0,$valor,$valor,1)";
				$this -> query($insert_det_puc_contra,$Conex,true);
				
				$liquidacion_prima .= ','.$liquidacion_prima_id;
			
			   }
		    } 
			$liquidacion_prima_id=substr($liquidacion_prima,1);
			
			$this -> Commit($Conex); 
			print($liquidacion_prima_id);

		   }
		}
	
  }
	
  public function Update($Campos,$Conex){	
    $this -> Begin($Conex);
	  if($_REQUEST['novedad_fija_id'] == 'NULL'){
	    ///$this -> DbInsertTable("novedad_fija",$Campos,$Conex,true,false);			
      }else{
        //$this -> DbUpdateTable("novedad_fija",$Campos,$Conex,true,false);
	  }
	$this -> Commit($Conex);
  }

    public function Delete($liquidacion_prima_id,$Conex){
	   
		$select="SELECT liquidacion_prima_id, encabezado_registro_id, estado, fecha_liquidacion FROM liquidacion_prima WHERE liquidacion_prima_id IN($liquidacion_prima_id)";
		$result = $this -> DbFetchAll($select,$Conex,true);
         
		if($result[0]['liquidacion_prima_id']>0){
			
			for($i=0; $i<count($result); $i++){

				$liquidacion_prima_id = $result[$i]['liquidacion_prima_id'];
				$encabezado_registro_id = $result[$i]['encabezado_registro_id'];
				$estado = $result[$i]['estado'];
				$fecha_liquidacion = $result[$i]['fecha_liquidacion'];

				if($estado != 'C' && $encabezado_registro_id == ''){

                   $delete="DELETE FROM detalle_prima_puc WHERE liquidacion_prima_id = $liquidacion_prima_id";
				   $this -> query($delete,$Conex,true);

					$delete="DELETE FROM liquidacion_prima WHERE liquidacion_prima_id = $liquidacion_prima_id AND estado != 'C'";
					$this -> query($delete,$Conex,true);


		    	}else{
					return 0;
				}
		    }
		    return 1;
	    }else{
			return 0;
		}


	}

	public function selectEstadoEncabezadoRegistro($liquidacion_prima_id,$Conex){
	  
	$select = "SELECT estado FROM liquidacion_prima WHERE liquidacion_prima_id IN ($liquidacion_prima_id)";  
	$result = $this -> DbFetchAll($select,$Conex,true); 
	$estado = $result[0]['estado'];
	
	return $estado;	  
	  
  }

	public function cancellation($empresa_id,$oficina_id,$Conex){
	 
    include_once("UtilidadesContablesModelClass.php");
	$utilidadesContables = new UtilidadesContablesModel(); 	 	 

	$this -> Begin($Conex);

	$liquidacion_prima_id			= $this -> requestDataForQuery('liquidacion_prima_id','integer');
	$causal_anulacion_id  		= $this -> requestDataForQuery('causal_anulacion_id','integer');
	$anul_abono_nomina   		= $this -> requestDataForQuery('anul_abono_nomina','text');
	$desc_anul_abono_nomina  	= $this -> requestDataForQuery('desc_anul_abono_nomina','text');
	$anul_usuario_id          	= $this -> requestDataForQuery('anul_usuario_id','integer');	
	  
	
	$select = "SELECT a.liquidacion_prima_id,a.encabezado_registro_id,
	                  a.fecha_liquidacion
			  FROM liquidacion_prima a WHERE a.liquidacion_prima_id IN($liquidacion_prima_id)";	
	$result = $this -> DbFetchAll($select,$Conex,true); 

	for ($i=0; $i < count($result); $i++) { 
	
		$encabezado_registro_id = $result[$i]['encabezado_registro_id'];
		$fechaMes = $result[$i]['fecha_liquidacion'];
		$prima_id = $result[$i]['liquidacion_prima_id'];
		
		if($encabezado_registro_id>0 && $encabezado_registro_id!='' && $encabezado_registro_id!=NULL){	 

			if(!$utilidadesContables -> periodoContableEstaHabilitado($empresa_id,$fechaMes,$Conex))exit('Periodo Contable Cerrado<br> No es posible Anular');
			if(!$utilidadesContables -> mesContableEstaHabilitado($oficina_id,$fechaMes,$Conex)) exit('Mes Contable Cerrado<br> No es posible Anular');

			$insert = "INSERT INTO encabezado_de_registro_anulado (`encabezado_de_registro_anulado_id`, `encabezado_registro_id`, `empresa_id`, `oficina_id`, `tipo_documento_id`, `forma_pago_id`, `valor`, `numero_soporte`, `tercero_id`, `periodo_contable_id`, `mes_contable_id`, `consecutivo`, `fecha`, `concepto`, `puc_id`, `estado`, `fecha_registro`, `modifica`, `usuario_id`, `causal_anulacion_id`, `observaciones`)
			SELECT $encabezado_registro_id AS 
			encabezado_de_registro_anulado_id,encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,
			forma_pago_id,valor,numero_soporte,tercero_id,periodo_contable_id,mes_contable_id,consecutivo,
			fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,$causal_anulacion_id AS causal_anulacion_id,
			$desc_anul_abono_nomina AS observaciones FROM encabezado_de_registro WHERE encabezado_registro_id = $encabezado_registro_id";
			$this -> query($insert,$Conex,true);

			if(strlen($this -> GetError()) > 0){
				$this -> Rollback($Conex);
			}else{
				$insert = "INSERT INTO imputacion_contable_anulada SELECT  imputacion_contable_id AS  
				imputacion_contable_anulada_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id AS 
				encabezado_registro_anulado_id,centro_de_costo_id,codigo_centro_costo,numero,valor,amortiza,deprecia,base,porcentaje,formula,debito,credito,
				area_id,departamento_id,unidad_negocio_id,sucursal_id
				FROM 
				imputacion_contable WHERE encabezado_registro_id = $encabezado_registro_id";

				
				$this -> query($insert,$Conex,true);

				if(strlen($this -> GetError()) > 0){
					$this -> Rollback($Conex);
				}else{	

					$update = "UPDATE encabezado_de_registro SET estado = 'A',anulado = 1 WHERE encabezado_registro_id = $encabezado_registro_id";	  
					$this -> query($update,$Conex,true);	

					if(strlen($this -> GetError()) > 0){
						$this -> Rollback($Conex);
					}else{	
						$update = "UPDATE imputacion_contable SET debito = 0,credito = 0 WHERE encabezado_registro_id=$encabezado_registro_id";
						$this -> query($update,$Conex,true);			  

						if(strlen($this -> GetError()) > 0){
							$this -> Rollback($Conex);
						}else{	
					
						
							$update = "UPDATE liquidacion_prima  SET estado = 'I',
										causal_anulacion_id = $causal_anulacion_id,
										anul_prima_nomina=$anul_abono_nomina,
										desc_anul_prima_nomina =$desc_anul_abono_nomina,
										anul_usuario_id=$anul_usuario_id
									WHERE liquidacion_prima_id=$prima_id";	
							$this -> query($update,$Conex,true);		
						$this -> Commit($Conex);			
						}

					}

				}

			}
		}else{

			$update = "UPDATE liquidacion_prima  SET estado= 'I',
						causal_anulacion_id = $causal_anulacion_id,
						anul_prima_nomina=$anul_abono_nomina,
						desc_anul_prima_nomina =$desc_anul_abono_nomina,
						anul_usuario_id=$anul_usuario_id
					WHERE liquidacion_prima_id=$prima_id";	
			$this -> query($update,$Conex,true);		
			$this -> Commit($Conex);			
			
		}
	}

  }
	
	public function Liq_Anterior($empleado_id,$fecha_liquidacion,$periodo,$oficina_id,$Conex){

		$fecha_liquidacion = str_replace("'","",$fecha_liquidacion);
		
		if ($fecha_liquidacion !='') {
			$select_contrato = "SELECT c.contrato_id,
			                     (SELECT e.tercero_id FROM empleado e WHERE e.empleado_id=c.empleado_id)as tercero_id,
								 c.area_laboral,
								 (c.sueldo_base+c.subsidio_transporte) as sueldo_base,
								 c.fecha_inicio,
								 IF(c.fecha_ult_prima IS NOT NULL,c.fecha_ult_prima,c.fecha_inicio)AS fecha,
								 DATEDIFF($fecha_liquidacion ,c.fecha_inicio) as dias_trabajados
								 FROM contrato c WHERE c.empleado_id=$empleado_id AND estado='A' ";
				
		$result_contrato = $this -> DbFetchAll($select_contrato,$Conex); 

		$fecha_inicio = $result_contrato[0]['fecha_inicio'];
		$fecha = $result_contrato[0]['fecha'];
		$contrato_id	 = $result_contrato[0]['contrato_id'];
		$tercero_id	 = $result_contrato[0]['tercero_id'];
		$area_laboral	 = $result_contrato[0]['area_laboral'];
		$salario	 = $result_contrato[0]['sueldo_base'];
	
		$select_parametros="SELECT 
		puc_prima_prov_id,puc_prima_cons_id,puc_prima_contra_id,puc_admon_prima_id,puc_ventas_prima_id,puc_produ_prima_id,tipo_documento_id
		FROM parametros_liquidacion_nomina WHERE oficina_id=$oficina_id";
		$result_parametros = $this -> DbFetchAll($select_parametros,$Conex,true); 
		
		$puc_consolidado_prima  = $result_parametros[0]['puc_prima_cons_id'];
		$puc_contrapartida		= $result_parametros[0]['puc_prima_contra_id'];
		$puc_admin				= $result_parametros[0]['puc_admon_prima_id'];
		$puc_venta				= $result_parametros[0]['puc_ventas_prima_id'];
		$puc_operativo			= $result_parametros[0]['puc_produ_prima_id'];
		$tipo_doc				= $result_parametros[0]['tipo_documento_id'];

		
		$select_cont ="SELECT contrato_id,
		                      IF(fecha_ult_prima IS NOT NULL,fecha_ult_prima,fecha_inicio)AS fecha_ult_prima 
					  FROM contrato WHERE empleado_id = $empleado_id";
	
		$result_cont = $this -> DbFetchAll($select_cont,$Conex,true);
		$contrato_id = $result_cont[0]['contrato_id'];
		$fecha_ult_prima = $result_cont[0]['fecha_ult_prima'];
       
		$dias_laborados = $this->restaFechasCont($fecha_ult_prima,$fecha_liquidacion);
		$valor_liquidacion = $salario*($dias_laborados-1)/360;
	    
		$select = "SELECT *	FROM liquidacion_prima WHERE contrato_id=$contrato_id AND estado!='I' ORDER BY fecha_liquidacion DESC"; 
		
		$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);

		if($result[0]['liquidacion_prima_id']>0){
			
			$result['periodo'] = $result[0]['periodo'];
			$result['acumulado'] = $result[0]['acumulado'];
			$result['estado'] = $result[0]['estado'];
			
			$select = "SELECT SUM(total)AS total FROM liquidacion_prima WHERE contrato_id=$contrato_id AND periodo=$periodo";
		    $result_total = $this -> DbFetchAll($select,$Conex,true);
	
		    if($result_total[0]['total']>0){
			  $total = $result_total[0]['total'];
			  $result['total'] = $total;
		    }
		}else{
			
			 $result[0]['fecha_liquidacion']=$fecha;
			 $result['total'] = 0;
			 $result['periodo'] = 0;
			 $result['acumulado'] = 0;
			 $result['estado'] = '';
			 $valor_real = $salario/2;
			 $valor_liquidacion = $salario*($dias_laborados)/360;

			 if($valor_liquidacion>$valor_real){
				 $valor_liquidacion = $valor_real;
			 }
		}
		
		    $consulta_periodo = " AND fecha BETWEEN '$fecha_inicio' AND '$fecha_liquidacion'"; 
		
		    $select_consolidado = "SELECT SUM(credito-debito)as neto,
		                           centro_de_costo_id 
							       FROM imputacion_contable WHERE puc_id=$puc_consolidado_prima AND tercero_id=$tercero_id AND encabezado_registro_id IN (SELECT encabezado_registro_id FROM encabezado_de_registro WHERE estado='C' $consulta_periodo)";
			
			$result_consolidado = $this -> DbFetchAll($select_consolidado,$Conex,true);
			
			$valor_consolidado = $result_consolidado[0]['neto']>0 ? intval($result_consolidado[0]['neto']) : 0 ;
		    $centro_costo_consolidado = $result_consolidado[0]['centro_de_costo_id']>0 ? $result_consolidado[0]['centro_de_costo_id'] : 'NULL';
		
			$valor_guardado = intval($valor_consolidado);
			
			
		    $result['valor_guardado'] = $valor_guardado;
			$result['salario'] = $salario;
			$result['valor_liquidacion'] = $valor_liquidacion;
			
			if(count($result)>0){
				return $result;
			}else {
				exit("No se encontr&oacute; un contrato activo para el empleado!!");
			}
		  
		}
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

 public function getContabilizarReg($liquidacion_prima_id,$empresa_id,$oficina_id,$usuario_id,$mesContable,$periodoContable,$si_empleado,$acumulado,$Conex){
	 //exit("liquidacion_prima ".$liquidacion_prima_id." si_emple".$si_empleado."--".$acumulado);
	$this -> Begin($Conex);

	if($si_empleado == 1){
		
		$select 	= "SELECT l.*,
		              (SELECT e.tercero_id FROM empleado e,contrato c WHERE e.empleado_id=c.empleado_id AND c.contrato_id=l.contrato_id)as tercero_id
					   FROM liquidacion_prima l WHERE l.liquidacion_prima_id=$liquidacion_prima_id";	
		$result 	= $this -> DbFetchAll($select,$Conex,true); 
		
		
		 if($result[0]['encabezado_registro_id']>0 && $result[0]['encabezado_registro_id']!=''){
		  exit('Ya esta en proceso la contabilizaci&oacute;n de la Liquidacion.<br>Por favor Verifique.');
		 }
		 
		$select1		="SELECT tipo_documento_id FROM parametros_liquidacion_nomina WHERE oficina_id=$oficina_id";
		$result1 	= $this -> DbFetchAll($select1,$Conex,true); 
		
		$tip_documento			= $result1[0]['tipo_documento_id'];	
		$tipo_documento_id      = $result1[0]['tipo_documento_id'];	

		$select_usu = "SELECT CONCAT_WS(' ',t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) AS usuario FROM usuario u, tercero t 
						WHERE u.usuario_id=$usuario_id AND t.tercero_id=u.tercero_id";
		$result_usu	= $this -> DbFetchAll($select_usu,$Conex);				

		$encabezado_registro_id	= $this -> DbgetMaxConsecutive("encabezado_de_registro","encabezado_registro_id",$Conex,true,1);	
		
		$valor					= $result[0]['total'];
		$numero_soporte			= $result[0]['liquidacion_prima_id'];	
		$tercero_id				= $result[0]['tercero_id'];
		$forma_pago_id			= $result_pago[0]['forma_pago_id'];
		$liquidacion_id			= $result_pago[0]['liquidacion_prima_id'];
		
        include_once("UtilidadesContablesModelClass.php");
	  
	    $utilidadesContables = new UtilidadesContablesModel(); 	 		
		
				
		$fecha					   = $result[0]['fecha_liquidacion'];		
	    $fechaMes                  = substr($fecha,0,10);		
	    $periodo_contable_id       = $utilidadesContables -> getPeriodoContableId($fechaMes,$Conex);
	    $mes_contable_id           = $utilidadesContables -> getMesContableId($fechaMes,$periodo_contable_id,$Conex);
		
		if($mes_contable_id>0 && $periodo_contable_id>0){
			$consecutivo			= $result[0]['liquidacion_prima_id'];
							
			$concepto				= 'Liquidacion '.$result[0]['concepto'];
			//$puc_id					= $result[0]['puc_contra'];
			$fecha_registro			= date("Y-m-d H:m");
			$modifica				= $result_usu[0]['usuario'];
			//$fuente_facturacion_cod	= $result[0]['fuente_facturacion_cod'];
			$numero_documento_fuente= $numero_soporte;
			$id_documento_fuente	= $result[0]['factura_id'];
			$con_fecha_factura		= $fecha_registro;	
	
			$insert="INSERT INTO encabezado_de_registro (encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,valor,numero_soporte,tercero_id,periodo_contable_id,
								mes_contable_id,consecutivo,fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,numero_documento_fuente,id_documento_fuente)
								VALUES($encabezado_registro_id,$empresa_id,$oficina_id,$tip_documento,'$valor','$numero_soporte',$tercero_id,$periodo_contable_id,
								$mes_contable_id,$consecutivo,'$fecha','$concepto',NULL,'C','$fecha_registro','$modifica',$usuario_id,'$numero_documento_fuente','$liquidacion_id')"; 
			
			$this -> query($insert,$Conex,true);  
	
			
			$select_item      = "SELECT detalle_prima_puc_id  FROM  detalle_prima_puc WHERE liquidacion_prima_id=$liquidacion_prima_id";
			$result_item      = $this -> DbFetchAll($select_item,$Conex);
			foreach($result_item as $result_items){
				$imputacion_contable_id 	= $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,true,1);
				$insert_item ="INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,valor,base,	porcentaje,formula,debito,credito)
								SELECT  
								$imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,desc_prima,$encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,(deb_item_prima+cre_item_prima),base_prima,porcentaje_prima,
								formula_prima,deb_item_prima,cre_item_prima
								FROM detalle_prima_puc WHERE liquidacion_prima_id=$liquidacion_prima_id AND detalle_prima_puc_id=$result_items[detalle_prima_puc_id]"; 
				$this -> query($insert_item,$Conex);
			}

			if(strlen($this -> GetError()) > 0){
				$this -> Rollback($Conex);
			}else{		
			
				$update = "UPDATE liquidacion_prima SET encabezado_registro_id=$encabezado_registro_id,	
							estado= 'C', acumulado = $acumulado
							WHERE liquidacion_prima_id=$liquidacion_prima_id";	
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
				$resultado = explode(',',$liquidacion_prima_id);
				/* $numero = count($resultado);
				exit("numero ".$numero);  */
		foreach($resultado as $liquidacion_prima){

					$select 	= "SELECT l.*,
		              (SELECT e.tercero_id FROM empleado e,contrato c WHERE e.empleado_id=c.empleado_id AND c.contrato_id=l.contrato_id)as tercero_id
					   FROM liquidacion_prima l WHERE l.liquidacion_prima_id=$liquidacion_prima";	
		            $result 	= $this -> DbFetchAll($select,$Conex,true); 
		
		
		 if($result[0]['encabezado_registro_id']>0 && $result[0]['encabezado_registro_id']!=''){
		  exit('Ya esta en proceso la contabilizaci&oacute;n de la Liquidacion.<br>Por favor Verifique.');
		 }
		 
		$select1		="SELECT tipo_documento_id FROM parametros_liquidacion_nomina WHERE oficina_id=$oficina_id";
		$result1 	= $this -> DbFetchAll($select1,$Conex,true); 
		
		$tip_documento			= $result1[0]['tipo_documento_id'];	
		$tipo_documento_id      = $result1[0]['tipo_documento_id'];	

		$select_usu = "SELECT CONCAT_WS(' ',t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) AS usuario FROM usuario u, tercero t 
						WHERE u.usuario_id=$usuario_id AND t.tercero_id=u.tercero_id";
		$result_usu	= $this -> DbFetchAll($select_usu,$Conex);				

		$encabezado_registro_id	= $this -> DbgetMaxConsecutive("encabezado_de_registro","encabezado_registro_id",$Conex,true,1);	
		
		$valor					= $result[0]['total'];
		$numero_soporte			= $result[0]['liquidacion_prima_id'];	
		$tercero_id				= $result[0]['tercero_id'];
		$forma_pago_id			= $result_pago[0]['forma_pago_id'];
		$liquidacion_id			= $result_pago[0]['liquidacion_prima_id'];
		
        include_once("UtilidadesContablesModelClass.php");
	  
	    $utilidadesContables = new UtilidadesContablesModel(); 	 		
		
				
		$fecha					   = $result[0]['fecha_liquidacion'];		
	    $fechaMes                  = substr($fecha,0,10);		
	    $periodo_contable_id       = $utilidadesContables -> getPeriodoContableId($fechaMes,$Conex);
	    $mes_contable_id           = $utilidadesContables -> getMesContableId($fechaMes,$periodo_contable_id,$Conex);
		
		if($mes_contable_id>0 && $periodo_contable_id>0){
			$consecutivo			= $result[0]['liquidacion_prima_id'];
							
			$concepto				= 'Liquidacion '.$result[0]['concepto'];
			//$puc_id					= $result[0]['puc_contra'];
			$fecha_registro			= date("Y-m-d H:m");
			$modifica				= $result_usu[0]['usuario'];
			//$fuente_facturacion_cod	= $result[0]['fuente_facturacion_cod'];
			$numero_documento_fuente= $numero_soporte;
			$id_documento_fuente	= $result[0]['factura_id'];
			$con_fecha_factura		= $fecha_registro;	
	
			$insert="INSERT INTO encabezado_de_registro (encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,valor,numero_soporte,tercero_id,periodo_contable_id,
								mes_contable_id,consecutivo,fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,numero_documento_fuente,id_documento_fuente)
								VALUES($encabezado_registro_id,$empresa_id,$oficina_id,$tip_documento,'$valor','$numero_soporte',$tercero_id,$periodo_contable_id,
								$mes_contable_id,$consecutivo,'$fecha','$concepto',NULL,'C','$fecha_registro','$modifica',$usuario_id,'$numero_documento_fuente','$liquidacion_id')"; 
			
			$this -> query($insert,$Conex,true);  
	
			
			$select_item      = "SELECT detalle_prima_puc_id  FROM  detalle_prima_puc WHERE liquidacion_prima_id = $liquidacion_prima";
			$result_item      = $this -> DbFetchAll($select_item,$Conex);
			foreach($result_item as $result_items){
				$imputacion_contable_id 	= $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,true,1);
				$insert_item ="INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,valor,base,porcentaje,formula,debito,credito)
								SELECT  
								$imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,desc_prima,$encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,(deb_item_prima+cre_item_prima),base_prima,porcentaje_prima,
								formula_prima,deb_item_prima,cre_item_prima
								FROM detalle_prima_puc WHERE liquidacion_prima_id = $liquidacion_prima AND detalle_prima_puc_id=$result_items[detalle_prima_puc_id]"; 
				$this -> query($insert_item,$Conex,true);
			}

			if(strlen($this -> GetError()) > 0){
				$this -> Rollback($Conex);
			}else{		
			
				$update = "UPDATE liquidacion_prima SET encabezado_registro_id=$encabezado_registro_id,	
							estado= 'C'
							WHERE liquidacion_prima_id = $liquidacion_prima";	
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

    public function selectDatosLiquidacionId($liquidacion_prima_id,$consecutivo,$Conex){
	 
		if($liquidacion_prima_id>0){

           $select = "SELECT lv.*,(SELECT e.empleado_id FROM empleado e,contrato c WHERE e.empleado_id= c.empleado_id AND c.contrato_id=lv.contrato_id)as empleado_id
			FROM liquidacion_prima lv WHERE lv.liquidacion_prima_id = $liquidacion_prima_id"; 
			$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);

			return $result;
			
		}else if($consecutivo>0){

            $select = "SELECT lv.* FROM liquidacion_prima lv WHERE lv.consecutivo = $consecutivo"; 
			$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
         
			return $result;

		}
 	
	
   }
    public function getTotalDebitoCredito($liquidacion_prima_id,$rango,$Conex){
	  if($rango=='T'){
	  		$select = "SELECT SUM(deb_item_prima) AS debito,SUM(cre_item_prima) AS credito FROM detalle_prima_puc   WHERE liquidacion_prima_id IN(SELECT liquidacion_prima_id FROM liquidacion_prima WHERE consecutivo IN (SELECT consecutivo FROM liquidacion_prima WHERE liquidacion_prima_id IN ($liquidacion_prima_id)))";
	  }else{
		  $select = "SELECT SUM(deb_item_prima) AS debito,SUM(cre_item_prima) AS credito FROM detalle_prima_puc   WHERE liquidacion_prima_id IN($liquidacion_prima_id)";
	  }
      $result = $this -> DbFetchAll($select,$Conex,true);
	  
	  return $result; 
	  
  }
    public function getDataEmpleado($empleado_id,$fecha_liquidacion,$Conex){
		
	$fecha_liquidacion = $fecha_liquidacion >0 ? "'".$fecha_liquidacion."'" : 'CURDATE()';	
  
 	$select = "SELECT c.contrato_id,(c.sueldo_base+c.subsidio_transporte) as sueldo_base,
	  IF(c.fecha_ult_prima IS NOT NULL,c.fecha_ult_prima,c.fecha_inicio)AS fecha_inicio,
	 (SELECT nombre_cargo FROM cargo WHERE cargo_id=c.cargo_id)as cargo, (SELECT t.numero_identificacion FROM tercero t, empleado e WHERE t.tercero_id=e.tercero_id AND e.empleado_id=c.empleado_id)as numero_identificacion,
	(SELECT CONCAT_WS(' ', t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, empleado e WHERE t.tercero_id=e.tercero_id AND e.empleado_id=c.empleado_id) as empleado,
	(SELECT DATEDIFF($fecha_liquidacion,c.fecha_inicio))as dias_laborados
	FROM contrato c WHERE c.empleado_id=$empleado_id AND estado='A'  "; 
	
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	if(count($result)>0){
		return $result;
	}else {
		exit("No se encontr&oacute; un contrato activo para el empleado!!");
	}
	
   }
   
 	public function GetTipoConcepto($Conex){
		return $this  -> DbFetchAll("SELECT tipo_concepto_laboral_id AS value,concepto AS text FROM tipo_concepto ORDER BY concepto ASC",$Conex,$ErrDb = false);
  	}   

   public function GetQueryPrimaGrid(){
   	$Query = "SELECT lv.liquidacion_prima_id,(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, empleado e,contrato c WHERE t.tercero_id=e.tercero_id AND e.empleado_id=c.empleado_id AND c.contrato_id=lv.contrato_id)as contrato_id, IF(lv.encabezado_registro_id>0,(SELECT e.consecutivo FROM encabezado_de_registro e WHERE e.encabezado_registro_id=lv.encabezado_registro_id),'N/A')AS encabezado_registro_id, lv.fecha_liquidacion,(SELECT anio FROM periodo_contable WHERE periodo_contable_id=lv.periodo)AS periodo, lv.total, IF(lv.tipo_liquidacion = 'T','TOTAL','PARCIAL')AS tipo_liquidacion,lv.observaciones, (CASE WHEN lv.estado='A' THEN 'ACTIVO' WHEN lv.estado='I' THEN 'INACTIVO' ELSE 'CONTABILIZADO' END)AS estado
	FROM liquidacion_prima lv";
   return $Query;
   }
}

?>
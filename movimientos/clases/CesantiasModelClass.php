<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class CesantiasModel extends Db{
	
	private $UserId;
	private $Permisos;
	
	public function SetUsuarioId($UserId,$CodCId){	  
		$this -> Permisos = new PermisosForm();
		$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
	}
	
	public function getPermiso($ActividadId,$Permiso,$Conex){
		return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
	}

	public function contratos_activos($fecha_corte,$Conex){
		$select = "SELECT c.*,e.*,t.*, (c.sueldo_base+c.subsidio_transporte) AS base_liquidacion,

					( SELECT ep.tercero_id  FROM empresa_prestaciones ep WHERE ep.empresa_id=c.empresa_cesan_id) AS tercero_id_cesan,
					( SELECT t.numero_identificacion  FROM empresa_prestaciones ep,tercero t WHERE ep.empresa_id=c.empresa_cesan_id AND t.tercero_id=ep.tercero_id) AS numero_identificacion_cesan,
					( SELECT t.digito_verificacion  FROM empresa_prestaciones ep,tercero t WHERE ep.empresa_id=c.empresa_cesan_id AND t.tercero_id=ep.tercero_id) AS digito_verificacion_cesan
					
					FROM contrato c, empleado e, tercero t 
					WHERE  c.estado='A' AND c.fecha_inicio<='$fecha_corte' AND e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id";

		$result = $this -> DbFetchAll($select,$Conex,true);
		
		return $result;
		
	}

  public function comprobar_estado($liquidacion_cesantias_id,$Conex){
    				
   $select = "SELECT l.estado, l.si_empleado,l.encabezado_registro_id,l.liquidacion_cesantias_id, l.encabezado_registro_id,l.fecha_liquidacion,
   			(SELECT p.estado  FROM encabezado_de_registro e,	periodo_contable p 
			 WHERE e.encabezado_registro_id=l.encabezado_registro_id AND p.periodo_contable_id=e.periodo_contable_id) AS estado_periodo,
			(SELECT p.estado  FROM encabezado_de_registro e,	mes_contable p 
			 WHERE e.encabezado_registro_id=l.encabezado_registro_id AND p.mes_contable_id=e.mes_contable_id) AS estado_mes			
   			FROM liquidacion_cesantias l
			WHERE l.liquidacion_cesantias_id=$liquidacion_cesantias_id";
				
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	
	return $result;
  }

	public function comprobar_liquidaciones($contrato_id,$fecha_corte,$Conex){
	
		$select = "SELECT MIN(l.fecha_inicial) AS fecha_inicio, MAX(l.fecha_final) AS fecha_fin, 
					IF('$fecha_corte' BETWEEN MIN(l.fecha_inicial) AND  MAX(l.fecha_final), 'SI','NO')  AS validacion
					FROM liquidacion_novedad l 
					WHERE l.contrato_id =$contrato_id AND l.estado='C'";
		$result = $this -> DbFetchAll($select,$Conex,true);
		
		return $result[0];
	
	}

	public function comprobar_liquidaciones_pro($contrato_id,$fecha_corte,$Conex){
	
		$select = "SELECT MIN(lp.fecha_inicial) AS fecha_inicio, MAX(lp.fecha_final) AS fecha_fin, 
					IF('$fecha_corte' BETWEEN MIN(lp.fecha_inicial) AND  MAX(lp.fecha_final), 'SI','NO')  AS validacion
					FROM liquidacion_novedad l, liquidacion_provision lp, detalle_liquidacion_provision dp 
					WHERE l.contrato_id =$contrato_id AND l.estado='C' AND dp.liquidacion_novedad_id=l.liquidacion_novedad_id 
					AND lp.liquidacion_provision_id=dp.liquidacion_provision_id AND lp.estado='C' ";
		$result = $this -> DbFetchAll($select,$Conex,true);
		
		return $result[0];
	
	}

	public function comprobar_liquidaciones_cesan($contrato_id,$fecha_corte,$Conex){
	
		$select = "SELECT l.fecha_corte, l.liquidacion_cesantias_id,
					IF(l.fecha_corte>= '$fecha_corte','SI','NO') AS validacion_posterior
					FROM liquidacion_cesantias l
					WHERE l.contrato_id =$contrato_id AND l.estado='C' ORDER BY l.fecha_corte DESC   ";
		$result = $this -> DbFetchAll($select,$Conex,true);
		
		return $result;
	
	}



	public function Save($Campos,$oficina_id,$Conex){	
		
		$empleado_id				= $this -> requestDataForQuery('empleado_id','integer');
		$observaciones   			= $this -> requestDataForQuery('observaciones','text');
		$periodo   	   				= $this -> requestDataForQuery('periodo','integer');
		$fecha_liquidacion 	 		= $this -> requestDataForQuery('fecha_liquidacion','date');		
		$fecha_corte	 	 		= $this -> requestDataForQuery('fecha_corte','date');
		$fecha_ultimo_corte	 	 	= $this -> requestDataForQuery('fecha_ultimo_corte','date');
		$si_empleado			    = $this -> requestDataForQuery('si_empleado','text');
		$tipo_liquidacion			= $this -> requestDataForQuery('tipo_liquidacion','text');
		$beneficiario				= $this -> requestDataForQuery('beneficiario','integer');
		$valor_liquidacion			= $this -> requestDataForQuery('valor_liquidacion','numeric');
		
		$this -> Begin($Conex);
		$select_contrato = "SELECT c.contrato_id,
							( SELECT ep.tercero_id  FROM empresa_prestaciones ep WHERE ep.empresa_id=c.empresa_cesan_id) AS tercero_id_cesan,
							( SELECT t.numero_identificacion  FROM empresa_prestaciones ep,tercero t WHERE ep.empresa_id=c.empresa_cesan_id AND t.tercero_id=ep.tercero_id) AS numero_identificacion_cesan,
							( SELECT t.digito_verificacion  FROM empresa_prestaciones ep,tercero t WHERE ep.empresa_id=c.empresa_cesan_id AND t.tercero_id=ep.tercero_id) AS digito_verificacion_cesan,
							
							(SELECT e.tercero_id FROM empleado e WHERE e.empleado_id=c.empleado_id) AS tercero_id,
							(SELECT t.numero_identificacion FROM empleado e, tercero t WHERE e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id) AS numero_identificacion,
							(SELECT t.digito_verificacion FROM empleado e, tercero t WHERE e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id) AS digito_verificacion,
							
							c.area_laboral,c.sueldo_base,c.fecha_inicio, DATEDIFF(CURDATE(),c.fecha_inicio) as dias_trabajados 
							FROM contrato c WHERE c.empleado_id=$empleado_id AND estado='A' ";
		
		$result_contrato = $this -> DbFetchAll($select_contrato,$Conex,true); 
		$contrato_id	 = $result_contrato[0]['contrato_id'];
		$tercero_id	 = $result_contrato[0]['tercero_id'];
		$numero_identificacion = $result_contrato[0]['numero_identificacion'];
		$digito_verificacion   = $result_contrato[0]['digito_verificacion']>0 ? $result_contrato[0]['digito_verificacion']:'NULL';

		$tercero_id_cesan	 = $beneficiario=1 ? $result_contrato[0]['tercero_id_cesan'] : $result_contrato[0]['tercero_id'];
		$numero_identificacion_cesan = $beneficiario=1 ?  $result_contrato[0]['numero_identificacion_cesan'] :  $result_contrato[0]['numero_identificacion'];
		$digito_verificacion_cesan   = $result_contrato[0]['digito_verificacion_cesan']>0 ? $result_contrato[0]['digito_verificacion_cesan'] :'NULL';		
		$digito_verificacion_cesan   = $beneficiario=1 ?  $digito_verificacion_cesan : 'NULL';

		$area_laboral	 = $result_contrato[0]['area_laboral'];
		
		$estado = "A";
		$liquidacion_cesantias_id 		= $this -> DbgetMaxConsecutive("liquidacion_cesantias","liquidacion_cesantias_id",$Conex,false,1);
		$this -> assignValRequest('liquidacion_cesantias_id',$liquidacion_cesantias_id);
		$this -> assignValRequest('contrato_id',$contrato_id);
		$this -> assignValRequest('estado',$estado);
		$this -> DbInsertTable("liquidacion_cesantias",$Campos,$Conex,true,false);  
		
		
		
		$select_parametros="SELECT 
		puc_cesantias_prov_id,(SELECT naturaleza FROM puc WHERE puc_id = puc_cesantias_prov_id) as natu_puc_cesantias_prov,
		puc_cesantias_cons_id,(SELECT naturaleza FROM puc WHERE puc_id = puc_cesantias_cons_id) as natu_puc_cesantias_cons,
		puc_cesantias_contra_id,
		puc_admon_cesantias_id,(SELECT naturaleza FROM puc WHERE puc_id = puc_admon_cesantias_id) as natu_puc_admon_cesantias,
		puc_ventas_cesantias_id,(SELECT naturaleza FROM puc WHERE puc_id = puc_cesantias_prov_id) as natu_puc_ventas_cesantias,
		puc_produ_cesantias_id,(SELECT naturaleza FROM puc WHERE puc_id = puc_cesantias_prov_id) as natu_puc_produ_cesantias,
		tipo_documento_id
		FROM parametros_liquidacion_nomina WHERE oficina_id=$oficina_id";
		$result_parametros = $this -> DbFetchAll($select_parametros,$Conex); 
		
		$puc_provision_cesantias = $result_parametros[0]['puc_cesantias_prov_id'];	$natu_puc_provision_cesantias = $result_parametros[0]['natu_puc_cesantias_prov'];
		$puc_consolidado_cesantias = $result_parametros[0]['puc_cesantias_cons_id'];$natu_puc_consolidado_cesantias = $result_parametros[0]['natu_puc_cesantias_cons'];
		$puc_contrapartida		  = $result_parametros[0]['puc_cesantias_contra_id'];
		$puc_admin				= $result_parametros[0]['puc_admon_cesantias_id'];	$natu_puc_admin				= $result_parametros[0]['natu_puc_admon_cesantias'];
		$puc_venta				= $result_parametros[0]['puc_ventas_cesantias_id'];	$natu_puc_venta				= $result_parametros[0]['natu_puc_ventas_cesantias'];
		$puc_operativo			= $result_parametros[0]['puc_produ_cesantias_id'];	$natu_puc_operativo			= $result_parametros[0]['natu_puc_produ_cesantias'];
		
		$tipo_doc				= $result_parametros[0]['tipo_documento_id'];

		$select_consolidado = "SELECT SUM(i.credito-i.debito) AS neto, centro_de_costo_id FROM imputacion_contable i, encabezado_de_registro e 
		WHERE i.puc_id=$puc_consolidado_cesantias AND i.tercero_id=(SELECT e.tercero_id FROM empleado e WHERE  e.empleado_id=$empleado_id)
		AND e.encabezado_registro_id=i.encabezado_registro_id AND e.estado!='A' AND e.fecha BETWEEN $fecha_ultimo_corte AND $fecha_corte ";
		$result_consolidado = $this -> DbFetchAll($select_consolidado,$Conex,true); 

		
		if(!count($result_consolidado)>0){exit("No se encontraron valores en la cuenta consolidados para este tercero!!");}
		
		
		$valor_consolidado = intval($result_consolidado[0]['neto']);
		$centro_costo_consolidado = $result_consolidado[0]['centro_de_costo_id'];
		
		$select_provision = "SELECT SUM(credito-debito)as neto,centro_de_costo_id  FROM imputacion_contable WHERE puc_id=$puc_provision_cesantias AND tercero_id=$tercero_id";
		
		$result_provision = $this -> DbFetchAll($select_provision,$Conex,true); 
		
		if(!count($result_provision)>0){exit("No se encontraron valores en la cuenta provisionados para este tercero!!");}
		
		
		$valor_provision = intval($result_provision[0]['neto']);
		$centro_costo_provision = $result_provision[0]['centro_de_costo_id'];
		
		
		$valor_guardado = intval($valor_consolidado);
		
		//sacamos el consolidado				
		if($natu_puc_consolidado_cesantias=='C'){
			$debito  = intval($valor_consolidado);
			$credito = 0;
		}else{
			$debito = 0;
			$credito  = intval($valor_consolidado);
		}
		
		
		
		$insert_det_puc_cons ="INSERT INTO detalle_cesantias_puc (liquidacion_cesantias_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_cesantias,porcentaje_cesantias,formula_cesantias,desc_cesantias,deb_item_cesantias,cre_item_cesantias,valor_liquida,contrapartida)
		VALUES
		($liquidacion_cesantias_id,$puc_consolidado_cesantias,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_consolidado,IF($centro_costo_consolidado>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_consolidado),'NULL'),0,'NULL','NULL',$observaciones,$debito,$credito,$valor_consolidado,0)";
		$this -> query($insert_det_puc_cons,$Conex,true); 
		
		
		// insertamos el gasto o el reintegro segun corresponda (si existe)


		
		if($valor_liquidacion != $valor_guardado){
			if($area_laboral=='A'){
				$puc_diferencia = $puc_admin;
				$natu_diferencia = $natu_puc_admin;
			}elseif($area_laboral=='O'){
				$puc_diferencia = $puc_operativo;
				$natu_diferencia = $natu_puc_operativo;
			}elseif($area_laboral=='C'){
				$puc_diferencia = $puc_venta;
				$natu_diferencia = $natu_puc_venta;
			}
			
			if($valor_guardado > $valor_liquidacion){
				//cuando se provisiona mas hacemos reintegro a la naturaleza contraria de la cuenta
				$diferencia	= $valor_guardado-$valor_liquidacion;
				if($natu_diferencia=='D' ){
					$debito  = $diferencia;
					$credito =	0;
				}else{
					$debito   = 0;
					$credito  = $diferencia;
				}
				
			
			}else{
				$diferencia	= $valor_liquidacion-$valor_guardado;
				if($natu_diferencia=='D' ){
					$credito  = $diferencia;
					$debito	  =	0;
				}else{
					$credito = 0;
					$debito  = $diferencia;
				}
				
			}
			
			
			
			$insert_det_puc_prov ="INSERT INTO detalle_cesantias_puc (liquidacion_cesantias_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_cesantias,porcentaje_cesantias,formula_cesantias,desc_cesantias,deb_item_cesantias,cre_item_cesantias,valor_liquida,contrapartida)
			VALUES
			($liquidacion_cesantias_id,$puc_diferencia,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_provision,IF($centro_costo_provision>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_provision),'NULL'),0,'NULL','NULL',$observaciones,$debito,$credito,$diferencia,0)";
			$this -> query($insert_det_puc_prov,$Conex,true); 
			
		}
		
		// contrapartida
		$insert_det_puc_contra ="INSERT INTO detalle_cesantias_puc (liquidacion_cesantias_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_cesantias,porcentaje_cesantias,formula_cesantias,desc_cesantias,deb_item_cesantias,cre_item_cesantias,valor_liquida,contrapartida)
		VALUES
		($liquidacion_cesantias_id,$puc_contrapartida,$tercero_id_cesan,$numero_identificacion_cesan,$digito_verificacion_cesan,$centro_costo_provision,IF($centro_costo_provision>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_provision),'NULL'),0,'NULL','NULL',$observaciones,0,$valor_liquidacion,0,1)";
		$this -> query($insert_det_puc_contra,$Conex,true);
		
		$this -> Commit($Conex);  
		
		
		print($liquidacion_cesantias_id);
		
	}
	
	
	public function saveTodos($si_empleado,$area_laboral,$centro_de_costo_id,$tercero_id,$numero_identificacion,$tercero_id_cesan,$numero_identificacion_cesan,$fecha_liquidacion,$fecha_corte,$fecha_ultimo_corte,$beneficiario,$contrato_id,$empleado_id,$salario,$dias_corte,$valor_liquidacion,$dias_no_remu,$dias_liquidacion,$valor_consolidado,$valor_diferencia,$fecha_inicio,$tipo_liquidacion,$observaciones,$oficina_id,$Conex){
		// Para todos los empleados!!
		
		$this -> Begin($Conex);
		
		$liquidacion_cesantias_id 		= $this -> DbgetMaxConsecutive("liquidacion_cesantias","liquidacion_cesantias_id",$Conex,false,1);
		
		$insert_cesantias = "INSERT INTO liquidacion_cesantias 
		(liquidacion_cesantias_id,fecha_liquidacion,fecha_corte,fecha_ultimo_corte,beneficiario,contrato_id,empleado_id,salario,fecha_inicio_contrato,estado,dias_periodo,dias_no_remu,dias_liquidados,valor_consolidado,valor_liquidacion,valor_diferencia,tipo_liquidacion,observaciones,si_empleado)	VALUES
		($liquidacion_cesantias_id,'$fecha_liquidacion','$fecha_corte','$fecha_ultimo_corte','$beneficiario',$contrato_id,$empleado_id,$salario,'$fecha_inicio','A',$dias_corte,$dias_no_remu,$dias_liquidacion,$valor_consolidado,$valor_liquidacion,$valor_diferencia,'$tipo_liquidacion','$observaciones','$si_empleado')";

		$this -> query($insert_cesantias,$Conex,true);
		
		
		$select_parametros="SELECT 
		puc_cesantias_prov_id,puc_cesantias_cons_id,puc_cesantias_contra_id,puc_admon_cesantias_id,puc_ventas_cesantias_id,puc_produ_cesantias_id,tipo_documento_id
		FROM parametros_liquidacion_nomina WHERE oficina_id=$oficina_id";
		$result_parametros = $this -> DbFetchAll($select_parametros,$Conex); 
		
		if(!count($result_parametros)>0) exit("No se han configurado los parametros para la oficina!! ");
		
		$puc_provision_cesantias = $result_parametros[0]['puc_cesantias_prov_id'];
		$puc_consolidado_cesantias = $result_parametros[0]['puc_cesantias_cons_id'];
		$puc_contrapartida		  = $result_parametros[0]['puc_cesantias_contra_id'];
		$puc_admin				= $result_parametros[0]['puc_admon_cesantias_id'];
		$puc_venta				= $result_parametros[0]['puc_ventas_cesantias_id'];
		$puc_operativo			= $result_parametros[0]['puc_produ_cesantias_id'];
		$tipo_doc				= $result_parametros[0]['tipo_documento_id'];
		
		
		
		$valor_guardado = intval($valor_consolidado)+intval($valor_provision);
		
		$insert_det_puc_cons ="INSERT INTO detalle_cesantias_puc (liquidacion_cesantias_id,puc_id,tercero_id,numero_identificacion,centro_de_costo_id,codigo_centro_costo,base_cesantias,porcentaje_cesantias,formula_cesantias,desc_cesantias,deb_item_cesantias,cre_item_cesantias,valor_liquida,contrapartida)	VALUES
		($liquidacion_cesantias_id,$puc_consolidado_cesantias,$tercero_id,$numero_identificacion,$centro_de_costo_id,IF($centro_de_costo_id>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_de_costo_id),'NULL'),0,'NULL','NULL','$observaciones',$valor_consolidado,0,0,0)";
		$this -> query($insert_det_puc_cons,$Conex,true); 
		
		
		if($valor_diferencia!=0){
			if($area_laboral=='A'){
				$puc_diferencia = $puc_admin;
			}elseif($area_laboral=='O'){
				$puc_diferencia = $puc_operativo;
			}elseif($area_laboral=='C'){
				$puc_diferencia = $puc_venta;
			}
			$diferencia= $valor-$valor_guardado;
			if($valor_diferencia>0){
				$insert_det_puc_prov ="INSERT INTO detalle_cesantias_puc (liquidacion_cesantias_id,puc_id,tercero_id,numero_identificacion,centro_de_costo_id,codigo_centro_costo,base_cesantias,porcentaje_cesantias,formula_cesantias,desc_cesantias,deb_item_cesantias,cre_item_cesantias,valor_liquida,contrapartida)
				VALUES
				($liquidacion_cesantias_id,$puc_diferencia,$tercero_id,$numero_identificacion,$centro_de_costo_id,IF($centro_de_costo_id>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_de_costo_id),'NULL'),0,'NULL','NULL','$observaciones',$valor_diferencia,0,0,0)";
				$this -> query($insert_det_puc_prov,$Conex,true); 
				
			}else{
				
				$insert_det_puc_prov ="INSERT INTO detalle_cesantias_puc (liquidacion_cesantias_id,puc_id,tercero_id,numero_identificacion,centro_de_costo_id,codigo_centro_costo,base_cesantias,porcentaje_cesantias,formula_cesantias,desc_cesantias,deb_item_cesantias,cre_item_cesantias,valor_liquida,contrapartida)
				VALUES
				($liquidacion_cesantias_id,$puc_diferencia,$tercero_id,$numero_identificacion,$centro_de_costo_id,IF($centro_de_costo_id>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_de_costo_id),'NULL'),0,'NULL','NULL','$observaciones',0,ABS($valor_diferencia),0,0)";
				$this -> query($insert_det_puc_prov,$Conex,true); 
				
			}
		
		}
		
		$insert_det_puc_contra ="INSERT INTO detalle_cesantias_puc (liquidacion_cesantias_id,puc_id,tercero_id,numero_identificacion,centro_de_costo_id,codigo_centro_costo,base_cesantias,porcentaje_cesantias,formula_cesantias,desc_cesantias,deb_item_cesantias,cre_item_cesantias,valor_liquida,contrapartida)
		VALUES	($liquidacion_cesantias_id,$puc_contrapartida,$tercero_id_cesan,$numero_identificacion_cesan,$centro_de_costo_id,IF($centro_de_costo_id>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_de_costo_id),NULL),0,NULL,NULL,'$observaciones',0,$valor_liquidacion,0,1)";
		$this -> query($insert_det_puc_contra,$Conex,true);
		
		$this -> Commit($Conex); 
	
	}
	
	
	
	public function ValidateRow($Conex,$Campos){
		require_once("../../../framework/clases/ValidateRowClass.php");
		$Data = new ValidateRow($Conex,"liquidacion_cesantias",$Campos);
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
	
	public function getContabilizarReg($liquidacion_cesantias_id,$empresa_id,$oficina_id,$usuario_id,$mesContable,$periodoContable,$Conex){
	
		$this -> Begin($Conex);
		
		$select 	= "SELECT l.*,(SELECT e.tercero_id FROM empleado e,contrato c 
					   WHERE e.empleado_id=c.empleado_id AND c.contrato_id=l.contrato_id) AS tercero_id 
		FROM liquidacion_cesantias l WHERE l.liquidacion_cesantias_id=$liquidacion_cesantias_id";	
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
		
		$valor					= $result[0]['valor_liquidacion'];
		$numero_soporte			= $result[0]['liquidacion_cesantias_id'];	
		$tercero_id				= $result[0]['tercero_id'];
		$forma_pago_id			= $result_pago[0]['forma_pago_id'];
		
		include_once("UtilidadesContablesModelClass.php");
		
		$utilidadesContables = new UtilidadesContablesModel(); 	 		
		
		
		$fecha					   = $result[0]['fecha_liquidacion'];		
		$fechaMes                  = substr($fecha,0,10);		
		$periodo_contable_id       = $utilidadesContables -> getPeriodoContableId($fechaMes,$Conex);
		$mes_contable_id           = $utilidadesContables -> getMesContableId($fechaMes,$periodo_contable_id,$Conex);
		
		if($mes_contable_id>0 && $periodo_contable_id>0){
			$consecutivo			= $result[0]['liquidacion_cesantias_id'];
			
			$concepto				= ''.$result[0]['observaciones'];
			$puc_id					= 'NULL';
			$fecha_registro			= date("Y-m-d H:m");
			$modifica				= $result_usu[0]['usuario'];
			//$fuente_facturacion_cod	= $result[0]['fuente_facturacion_cod'];
			$numero_documento_fuente= $numero_soporte;
			$id_documento_fuente	= $result[0]['factura_id'];
			$con_fecha_factura		= $fecha_registro;	
			
			$insert="INSERT INTO encabezado_de_registro (encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,valor,numero_soporte,tercero_id,periodo_contable_id,
			mes_contable_id,consecutivo,fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,numero_documento_fuente,id_documento_fuente)
			VALUES($encabezado_registro_id,$empresa_id,$oficina_id,$tip_documento,'$valor','$numero_soporte',$tercero_id,$periodo_contable_id,
			$mes_contable_id,$consecutivo,'$fecha','$concepto',$puc_id,'C','$fecha_registro','$modifica',$usuario_id,'$numero_documento_fuente',$consecutivo)"; 
			$this -> query($insert,$Conex,true);  
			
			
			$select_item      = "SELECT detalle_cesantias_puc_id  FROM  detalle_cesantias_puc WHERE liquidacion_cesantias_id=$liquidacion_cesantias_id";
			$result_item      = $this -> DbFetchAll($select_item,$Conex);
			foreach($result_item as $result_items){
				$imputacion_contable_id 	= $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,true,1);
				$insert_item ="INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,valor,base,	porcentaje,formula,debito,credito)
				SELECT  
				$imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,desc_cesantias,$encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,(deb_item_cesantias+cre_item_cesantias),base_cesantias,porcentaje_cesantias,
				formula_cesantias,deb_item_cesantias,cre_item_cesantias
				FROM detalle_cesantias_puc WHERE liquidacion_cesantias_id=$liquidacion_cesantias_id AND detalle_cesantias_puc_id=$result_items[detalle_cesantias_puc_id]"; 
				$this -> query($insert_item,$Conex);
			}
			
			if(strlen($this -> GetError()) > 0){
				$this -> Rollback($Conex);
			}else{		
			
				$update = "UPDATE liquidacion_cesantias SET encabezado_registro_id=$encabezado_registro_id,	
				estado= 'C'
				WHERE liquidacion_cesantias_id=$liquidacion_cesantias_id";	
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
	}

  public function getContabilizarRegT($liquidacion_cesantias_id,$fecha_liquidacion,$empresa_id,$oficina_id,$usuario_id,$mesContable,$periodoContable,$Conex){//contabilizar varios aca
	 
    include_once("UtilidadesContablesModelClass.php");
	  
	$utilidadesContables = new UtilidadesContablesModel(); 	 
	 
	$this -> Begin($Conex);

		$select_emp = "SELECT tercero_id FROM empresa	WHERE empresa_id=$empresa_id";
		$result_emp	= $this -> DbFetchAll($select_emp,$Conex);				

		$select_cc = "SELECT 	centro_de_costo_id, codigo FROM centro_de_costo	WHERE oficina_id=$oficina_id";
		$result_cc	= $this -> DbFetchAll($select_cc,$Conex);				

		$select_usu = "SELECT CONCAT_WS(' ',t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) AS usuario FROM usuario u, tercero t 
						WHERE u.usuario_id=$usuario_id AND t.tercero_id=u.tercero_id";
		$result_usu	= $this -> DbFetchAll($select_usu,$Conex);				

		$modifica				= $result_usu[0]['usuario'];
		$tercero_id				= $result_emp[0]['tercero_id'];

		if($result_cc[0]['centro_de_costo_id']>0){
			$centro_de_costo_id=$result_cc[0]['centro_de_costo_id'];
			$codigo=$result_cc[0]['codigo'];
		}else{
			exit('No existe Centro de Costo para la oficina Actual');			
		}

		$select 	= "SELECT f.*,
					(SELECT tipo_documento_id FROM datos_periodo WHERE periodo_contable_id =(SELECT periodo_contable_id FROM periodo_contable WHERE anio=YEAR(DATE(f.fecha_inicial)) ) ) AS tipo_documento_id,
					(SELECT SUM(debito) FROM detalle_liquidacion_novedad WHERE liquidacion_cesantias_id=f.liquidacion_cesantias_id) AS valor,
					
					(SELECT t.numero_identificacion FROM contrato c, empleado e, tercero t WHERE c.contrato_id=f.contrato_id AND e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id) AS numero_identificacion,
					(SELECT t.digito_verificacion FROM contrato c, empleado e, tercero t WHERE c.contrato_id=f.contrato_id AND e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id) AS digito_verificacion,					
					(SELECT e.tercero_id FROM contrato c, empleado e WHERE c.contrato_id=f.contrato_id AND e.empleado_id=c.empleado_id ) AS tercero_id,
					(SELECT c.centro_de_costo_id FROM contrato c WHERE c.contrato_id=f.contrato_id  ) AS centro_de_costo_id,
					(SELECT cc.codigo FROM contrato c, centro_de_costo cc WHERE c.contrato_id=f.contrato_id AND cc.centro_de_costo_id=c.centro_de_costo_id ) AS codigo_centro					
					
					FROM liquidacion_cesantias f 
					WHERE fecha_liquidacion='$fecha_liquidacion' AND estado='A'";	
					
		$result 	= $this -> DbFetchAll($select,$Conex,true);  
		


		$encabezado_registro_id	= $this -> DbgetMaxConsecutive("encabezado_de_registro","encabezado_registro_id",$Conex,true,1);	
		$tipo_documento_id		= $result[0]['tipo_documento_id'];	
		$valor					= $result[0]['valor'];
		$numero_soporte			= $result[0]['consecutivo'];	
		
		
	    $fechaMes               = substr($result[0]['fecha_final'],0,10);		
	    $periodo_contable_id    = $utilidadesContables -> getPeriodoContableId($fechaMes,$Conex);
	    $mes_contable_id        = $utilidadesContables -> getMesContableId($fechaMes,$periodo_contable_id,$Conex);
	    $consecutivo1           = $utilidadesContables -> getConsecutivo($oficina_id,$tipo_documento_id,$periodo_contable_id,$Conex);		
		
		$fecha					= $result[0]['fecha_final'];
		$concepto				= 'CESANTIAS '.$result[0]['observaciones'];
		$puc_id					= 'NULL';
		$fecha_registro			= date("Y-m-d H:i:s");
		
		$fuente_servicio_cod	= 'NO';
		$numero_documento_fuente= $consecutivo;
		$id_documento_fuente	= $result[0]['liquidacion_cesantias_id'];


		$insert="INSERT INTO encabezado_de_registro (encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,valor,numero_soporte,tercero_id,periodo_contable_id,
							mes_contable_id,consecutivo,fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,fuente_servicio_cod,numero_documento_fuente,id_documento_fuente)
							VALUES($encabezado_registro_id,$empresa_id,$oficina_id,$tipo_documento_id,'$valor','$numero_soporte',$tercero_id,$periodo_contable_id,
							$mes_contable_id,$consecutivo1,'$fecha','$concepto',$puc_id,'C','$fecha_registro','$modifica',$usuario_id,'$fuente_servicio_cod','$numero_documento_fuente',$id_documento_fuente)"; 
		$this -> query($insert,$Conex,true);
		
		
		for($i=0;$i<count($result);$i++){ 

			$terceroid				= $result[$i]['tercero_id'];
			$numero_identificacion	= $result[$i]['numero_identificacion'];
			$digito_verificacion	= $result[$i]['digito_verificacion']!='' ? $result[$i]['digito_verificacion'] : 'NULL';		

			$centro_de_costo_id1	= $result[$i]['centro_de_costo_id'];
			$codigo_centro1			= $result[$i]['codigo_centro'];		

			

			$liquidacion_cesantias_id1 = $result[$i]['liquidacion_cesantias_id'];
			$select_item      = "SELECT detalle_liquidacion_cesantias_id, sueldo_pagar  
			FROM   detalle_cesantias_puc WHERE liquidacion_cesantias_id=$liquidacion_cesantias_id1";
			$result_item      = $this -> DbFetchAll($select_item,$Conex,true);
			foreach($result_item as $result_items){  
			
				$imputacion_contable_id 	= $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,true,1);

				if($result_items['sueldo_pagar']==0){

					$insert_item ="INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,valor,base,	porcentaje,formula,debito,credito)
									SELECT  $imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,concepto,$encabezado_registro_id,$centro_de_costo_id1,'$codigo_centro1',(debito+credito),base,porcentaje,
									formula,debito,credito
									FROM detalle_cesantias_puc WHERE liquidacion_cesantias_id=$liquidacion_cesantias_id1 AND detalle_liquidacion_cesantias_id=$result_items[detalle_liquidacion_cesantias_id]"; 
									
				}elseif($result_items['sueldo_pagar']==1){

					$insert_item ="INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,valor,base,	porcentaje,formula,debito,credito)
									SELECT  $imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,concepto,$encabezado_registro_id,$centro_de_costo_id,'$codigo',(debito+credito),base,porcentaje,
									formula,debito,credito
									FROM detalle_cesantias_puc WHERE liquidacion_cesantias_id=$liquidacion_cesantias_id1 AND detalle_liquidacion_cesantias_id=$result_items[detalle_liquidacion_cesantias_id]"; 

				}
				$this -> query($insert_item,$Conex,true);
			}
			$update = "UPDATE liquidacion_cesantias SET encabezado_registro_id=$encabezado_registro_id,	
						estado= 'C',
						con_usuario_id = $usuario_id,
						con_fecha='$fecha_registro'
					WHERE liquidacion_cesantias_id='$liquidacion_cesantias_id1'  AND estado='A'";	
	
			$this -> query($update,$Conex,true);		  
			
		}
		
			
		$this -> Commit($Conex);
		return true;
  }

	public function selectDatosLiquidacionId($liquidacion_cesantias_id,$Conex){
	
		$select = "SELECT lv.*,lv.valor_liquidacion as valor_liquidacion1,
		(SELECT e.empleado_id FROM empleado e,contrato c WHERE e.empleado_id= c.empleado_id AND c.contrato_id=lv.contrato_id) AS empleado_id,
		CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) AS empleado,
		(SELECT nombre_cargo FROM cargo ca,contrato c   WHERE c.contrato_id=lv.contrato_id AND  c.cargo_id=ca.cargo_id) AS cargo,
		t.numero_identificacion AS num_identificacion
		FROM liquidacion_cesantias lv, empleado em, tercero t 
		WHERE lv.liquidacion_cesantias_id = $liquidacion_cesantias_id AND em.empleado_id=lv.empleado_id AND t.tercero_id=em.tercero_id"; 
		$result = $this -> DbFetchAll($select,$Conex,$ErrDb = true);
		return $result;
	
	}
	public function getTotalDebitoCredito($liquidacion_cesantias_id,$Conex){
	
		$select = "SELECT SUM(deb_item_cesantias) AS debito,SUM(cre_item_cesantias) AS credito FROM detalle_cesantias_puc   WHERE liquidacion_cesantias_id=$liquidacion_cesantias_id";
		$result = $this -> DbFetchAll($select,$Conex,true);
		
		return $result; 
	
	}
	
	public function getValor($empleado_id,$fecha_ultimo_corte,$fecha_corte,$dias_periodo,$oficina_id,$Conex){
	
		
		$select = "SELECT fecha_inicio,contrato_id,SUM(sueldo_base+subsidio_transporte)as base_liquidacion FROM contrato WHERE empleado_id=$empleado_id AND estado='A' ";
		$result = $this -> DbFetchAll($select,$Conex,true);
		
		$fecha_inicio = $result[0]['fecha_inicio'];
		$contrato_id = $result[0]['contrato_id'];
		$base_liquidacion = $result[0]['base_liquidacion'];
		

		//Buscamos las licencias no remuneradas cuyo rango este dentro del periodo de liquidaci�n:
		$select_dias_lic = "SELECT SUM(dias)as dias FROM licencia WHERE estado='A' AND contrato_id=$contrato_id AND remunerado=0 AND fecha_inicial>'$fecha_ultimo_corte' AND fecha_final<'$fecha_corte'";
		$result_dias_lic = $this -> DbFetchAll($select_dias_lic,$Conex,true);
		$dias_in_periodo = $result_dias_lic[0]['dias'];
		
		//Bucamos las licencias que comenzaron antes pero terminaron dentro del periodo
		$select_dias_lic = "SELECT (dias-DATEDIFF('$fecha_ultimo_corte',fecha_inicial)) as dias FROM licencia WHERE estado='A' AND contrato_id=$contrato_id AND remunerado=0 AND fecha_inicial<'$fecha_ultimo_corte' AND fecha_final<'$fecha_corte'";
		$result_dias_lic = $this -> DbFetchAll($select_dias_lic,$Conex,true);
		$dias_bef_periodo = $result_dias_lic[0]['dias'];
		
		//Buscamos las licencias que comenzaron dentro del periodo pero terminan fuera 
		$select_dias_lic = "SELECT (dias-DATEDIFF(fecha_final,'$fecha_corte')) as dias FROM licencia WHERE estado='A' AND contrato_id=$contrato_id AND remunerado=0 AND fecha_inicial>'$fecha_ultimo_corte' AND fecha_final>'$fecha_corte'";
		$result_dias_lic = $this -> DbFetchAll($select_dias_lic,$Conex,true);
		$dias_aft_periodo = $result_dias_lic[0]['dias'];
		
		$dias_no_remu = $dias_in_periodo+$dias_bef_periodo+$dias_aft_periodo;
		
		//hacemos la operacion entre dias periodo menos los dias no remunerados
		$dias_liquidacion = $dias_periodo - $dias_no_remu;
		
		//validar parametros y consolidado	
		$select_parametros="SELECT 
		puc_cesantias_prov_id,puc_cesantias_cons_id,puc_cesantias_contra_id,puc_admon_cesantias_id,puc_ventas_cesantias_id,puc_produ_cesantias_id,tipo_documento_id
		FROM parametros_liquidacion_nomina WHERE oficina_id=$oficina_id";
		$result_parametros = $this -> DbFetchAll($select_parametros,$Conex,true); 
		
		$puc_provision_cesantias 	= $result_parametros[0]['puc_cesantias_prov_id'];
		$puc_consolidado_cesantias 	= $result_parametros[0]['puc_cesantias_cons_id'];
		$puc_contrapartida		  	= $result_parametros[0]['puc_cesantias_contra_id'];
		$tipo_doc					= $result_parametros[0]['tipo_documento_id'];
		
		$select_consolidado = "SELECT SUM(i.credito-i.debito) AS neto FROM imputacion_contable i, encabezado_de_registro e 
		WHERE i.puc_id=$puc_consolidado_cesantias AND i.tercero_id=(SELECT e.tercero_id FROM empleado e WHERE  e.empleado_id=$empleado_id)
		AND e.encabezado_registro_id=i.encabezado_registro_id AND e.estado!='A' AND e.fecha BETWEEN '$fecha_ultimo_corte' AND '$fecha_corte' ";
		$result_consolidado = $this -> DbFetchAll($select_consolidado,$Conex,true); 
		
		$valor_consolidado = $result_consolidado[0]['neto']> 0 ? intval($result_consolidado[0]['neto']) : 0;

		
		$valor_liquidacion = intval(($base_liquidacion*$dias_liquidacion)/360);
		
		$result[0]=array(valor_liquidacion=>$valor_liquidacion,dias_periodo=>$dias_periodo,dias_no_remu=>$dias_no_remu,dias_liquidacion=>$dias_liquidacion,valor_consolidado=>$valor_consolidado);
		
		return $result;
	
	}
	
	public function getDataEmpleado($empleado_id,$oficina_id,$Conex){
	
		
		$select = "SELECT c.contrato_id,
		SUM(c.sueldo_base+subsidio_transporte) AS sueldo_base,
		(SELECT MAX(fecha_corte) FROM liquidacion_cesantias WHERE contrato_id=c.contrato_id AND estado='C' ) AS fecha_ultimo_corte,
		c.fecha_inicio,
		(SELECT nombre_cargo FROM cargo WHERE cargo_id=c.cargo_id) AS cargo,
		(SELECT t.numero_identificacion FROM tercero t, empleado e WHERE t.tercero_id=e.tercero_id AND e.empleado_id=c.empleado_id) AS numero_identificacion,
		(SELECT CONCAT_WS(' ', t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, empleado e WHERE t.tercero_id=e.tercero_id AND e.empleado_id=c.empleado_id) AS empleado
		
		FROM contrato c WHERE c.empleado_id=$empleado_id AND estado='A'  "; 

		$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
		if(count($result)>0){
			return $result;
		}else {
			exit("No se encontr&oacute; un contrato activo para el empleado!!");
		}
	
	}

	/*
		$select_provision = "SELECT SUM(credito-debito)as neto,centro_de_costo_id  FROM imputacion_contable WHERE puc_id=$puc_provision_cesantias AND tercero_id=(SELECT t.tercero_id FROM tercero t,empleado e WHERE t.tercero_id=e.tercero_id AND e.empleado_id=$empleado_id)";
		$result_provision = $this -> DbFetchAll($select_provision,$Conex,true); 
		
		//if(!count($result_provision)>0){exit("No se encontraron valores en la cuenta provisionados para este tercero!!");}
		
		
		$valor_provision = $result_provision[0]['neto'] > 0 ? intval($result_provision[0]['neto']) :0;
		$valor_guardado = intval($valor_consolidado)+intval($valor_provision);
	*/
	public function GetTipoConcepto($Conex){
		return $this  -> DbFetchAll("SELECT tipo_concepto_laboral_id AS value,concepto AS text FROM tipo_concepto ORDER BY concepto ASC",$Conex,$ErrDb = false);
	}   
	
	public function GetQueryCesantiasGrid(){
		$Query = "SELECT l.liquidacion_cesantias_id,
		(SELECT CONCAT_WS(' ', t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, empleado e,contrato c WHERE t.tercero_id=e.tercero_id AND e.empleado_id=c.empleado_id AND c.contrato_id=l.contrato_id) as empleado,
		(SELECT t.numero_identificacion FROM tercero t, empleado e,contrato c WHERE t.tercero_id=e.tercero_id AND e.empleado_id=c.empleado_id AND c.contrato_id=l.contrato_id) as numero_identificacion,
		l.observaciones,
		l.fecha_liquidacion,
		l.dias_periodo AS dias,
		l.valor_liquidacion AS valor,
		CASE l.estado WHEN 'A' THEN 'ACTIVO' WHEN 'I' THEN 'INACTIVO' WHEN 'C' THEN 'CONTABILIZADA' END AS estado FROM liquidacion_cesantias l";
		return $Query;
	}
}

?>
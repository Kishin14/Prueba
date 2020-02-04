<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class IntCesantiasModel extends Db{
		
  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
    
  public function Save($Campos,$oficina_id,$Conex){	

		$empleado_id				= $this -> requestDataForQuery('empleado_id','integer');
		$observaciones   			= $this -> requestDataForQuery('observaciones','text');
		$periodo   	   				= $this -> requestDataForQuery('periodo','integer');
		$fecha_liquidacion 	 		= $this -> requestDataForQuery('fecha_liquidacion','date');		
		$fecha_corte	 	 		= $this -> requestDataForQuery('fecha_corte','date');		
		$si_empleado			    = $this -> requestDataForQuery('si_empleado','text');
		$tipo_liquidacion			= $this -> requestDataForQuery('tipo_liquidacion','text');
		$beneficiario				= $this -> requestDataForQuery('beneficiario','text');
		$valor_liquidacion			= $this -> requestDataForQuery('valor_liquidacion','numeric');
		if($si_empleado == "'1'"){
			
			$this -> Begin($Conex);
				$select_contrato = "SELECT c.contrato_id,(SELECT e.tercero_id FROM empleado e WHERE e.empleado_id=c.empleado_id)as tercero_id,c.area_laboral,c.sueldo_base,c.fecha_inicio, DATEDIFF(CURDATE(),c.fecha_inicio) as dias_trabajados FROM contrato c WHERE c.empleado_id=$empleado_id AND estado='A' ";
				
				$result_contrato = $this -> DbFetchAll($select_contrato,$Conex); 
				$contrato_id	 = $result_contrato[0]['contrato_id'];
				$tercero_id	 = $result_contrato[0]['tercero_id'];
				$area_laboral	 = $result_contrato[0]['area_laboral'];
				
				$estado = "'A'";
				$liquidacion_int_cesantias_id 		= $this -> DbgetMaxConsecutive("liquidacion_int_cesantias","liquidacion_int_cesantias_id",$Conex,false,1);
				$this -> assignValRequest('liquidacion_int_cesantias_id',$liquidacion_int_cesantias_id);
				$this -> assignValRequest('contrato_id',$contrato_id);
				$this -> DbInsertTable("liquidacion_int_cesantias",$Campos,$Conex,true,false);  
				
				
				$select_datos_ter="SELECT numero_identificacion,digito_verificacion FROM tercero WHERE tercero_id=$tercero_id";
				$result_datos_ter = $this -> DbFetchAll($select_datos_ter,$Conex) ;
				
				$numero_identificacion = $result_datos_ter[0]['numero_identificacion'];
				$digito_verificacion   = $result_datos_ter[0]['digito_verificacion']>0 ? $result_datos_ter[0]['digito_verificacion']>0 :'NULL';
				
				$select_parametros="SELECT 
					puc_int_cesantias_prov_id,(SELECT naturaleza FROM puc WHERE puc_id = puc_int_cesantias_prov_id) as natu_puc_int_cesantias_prov,
					puc_int_cesantias_cons_id,(SELECT naturaleza FROM puc WHERE puc_id = puc_int_cesantias_cons_id) as natu_puc_int_cesantias_cons,
					puc_int_cesantias_contra_id,
					puc_admon_int_cesantias_id,(SELECT naturaleza FROM puc WHERE puc_id = puc_admon_int_cesantias_id) as natu_puc_admon_int_cesantias,
					puc_ventas_int_cesantias_id,(SELECT naturaleza FROM puc WHERE puc_id = puc_int_cesantias_prov_id) as natu_puc_ventas_int_cesantias,
					puc_produ_int_cesantias_id,(SELECT naturaleza FROM puc WHERE puc_id = puc_int_cesantias_prov_id) as natu_puc_produ_int_cesantias,
					tipo_documento_id
				FROM parametros_liquidacion_nomina WHERE oficina_id=$oficina_id";
				$result_parametros = $this -> DbFetchAll($select_parametros,$Conex); 
				
				$puc_provision_int_cesantias = $result_parametros[0]['puc_int_cesantias_prov_id'];	$natu_puc_provision_int_cesantias = $result_parametros[0]['natu_puc_int_cesantias_prov'];
				$puc_consolidado_int_cesantias = $result_parametros[0]['puc_int_cesantias_cons_id'];$natu_puc_consolidado_int_cesantias = $result_parametros[0]['natu_puc_int_cesantias_cons'];
				$puc_contrapartida		  = $result_parametros[0]['puc_int_cesantias_contra_id'];
				$puc_admin				= $result_parametros[0]['puc_admon_int_cesantias_id'];	$natu_puc_admin				= $result_parametros[0]['natu_puc_admon_int_cesantias'];
				$puc_venta				= $result_parametros[0]['puc_ventas_int_cesantias_id'];	$natu_puc_venta				= $result_parametros[0]['natu_puc_ventas_int_cesantias'];
				$puc_operativo			= $result_parametros[0]['puc_produ_int_cesantias_id'];	$natu_puc_operativo			= $result_parametros[0]['natu_puc_produ_int_cesantias'];
				
				$tipo_doc				= $result_parametros[0]['tipo_documento_id'];
				
				$select_consolidado = "SELECT SUM(credito-debito)as neto,centro_de_costo_id FROM imputacion_contable WHERE puc_id=$puc_consolidado_int_cesantias AND tercero_id=$tercero_id";
				
				$result_consolidado = $this -> DbFetchAll($select_consolidado,$Conex,true); 
				
				 if(!count($result_consolidado)>0){exit("No se encontraron valores en la cuenta consolidados para este tercero!!");}
				
				
				$valor_consolidado = intval($result_consolidado[0]['neto']);
				$centro_costo_consolidado = $result_consolidado[0]['centro_de_costo_id'];
				
				$select_provision = "SELECT SUM(credito-debito)as neto,centro_de_costo_id  FROM imputacion_contable WHERE puc_id=$puc_provision_int_cesantias AND tercero_id=$tercero_id";
				
				$result_provision = $this -> DbFetchAll($select_provision,$Conex,true); 
				
				 if(!count($result_provision)>0){exit("No se encontraron valores en la cuenta provisionados para este tercero!!");}
				
				
				$valor_provision = intval($result_provision[0]['neto']);
				$centro_costo_provision = $result_provision[0]['centro_de_costo_id'];
				
				
				$valor_guardado = intval($valor_consolidado)+intval($valor_provision);
				
				//sacamos el consolidado	
				if($valor_consolidado >0 ){
					if($natu_puc_consolidado_int_cesantias=='C'){
						$debito  = intval($valor_consolidado);
						$credito = 0;
					}else{
						$debito = 0;
						$credito  = intval($valor_consolidado);
					}
					
					
					
					$insert_det_puc_cons ="INSERT INTO detalle_int_cesantias_puc (liquidacion_int_cesantias_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_int_cesantias,porcentaje_int_cesantias,formula_int_cesantias,desc_int_cesantias,deb_item_int_cesantias,cre_item_int_cesantias,valor_liquida,contrapartida)
					VALUES
					($liquidacion_int_cesantias_id,$puc_consolidado_int_cesantias,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_consolidado,IF($centro_costo_consolidado>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_consolidado),'NULL'),0,'NULL','NULL',$observaciones,$debito,$credito,$valor_consolidado,0)";
					$this -> query($insert_det_puc_cons,$Conex,true); 
				}
				//sacamos la provision
				if($valor_provision >0 ){
					if($natu_puc_provision_int_cesantias=='C'){
						$debito  = intval($valor_provision);
						$credito = 0;
					}else{
						$debito = 0;
						$credito  = intval($valor_provision);
					}
					
					
					$insert_det_puc_prov ="INSERT INTO detalle_int_cesantias_puc (liquidacion_int_cesantias_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_int_cesantias,porcentaje_int_cesantias,formula_int_cesantias,desc_int_cesantias,deb_item_int_cesantias,cre_item_int_cesantias,valor_liquida,contrapartida)
					VALUES
					($liquidacion_int_cesantias_id,$puc_provision_int_cesantias,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_provision,IF($centro_costo_provision>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_provision),'NULL'),0,'NULL','NULL',$observaciones,$debito,$credito,$valor_provision,0)";
					$this -> query($insert_det_puc_prov,$Conex,true); 
				}
				// insertamos el gasto o el reintegro seg�n corresponda (si existe)
				
				
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
						    $credito  = abs($diferencia);
							$debito	  =	0;
						}else{
							$credito = 0;
							$debito  = abs($diferencia);
						}
					
					}else{
						//cuando se provisiona menos hacemos el registro del gasto
						$diferencia	= $valor_liquidacion-$valor_guardado;
						if($natu_diferencia=='D' ){
						    $debito  = abs($diferencia);
							$credito =	0;
						}else{
							$debito   = 0;
							$credito  = abs($diferencia);
						}
					}
					
					
					
					$insert_det_puc_prov ="INSERT INTO detalle_int_cesantias_puc (liquidacion_int_cesantias_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_int_cesantias,porcentaje_int_cesantias,formula_int_cesantias,desc_int_cesantias,deb_item_int_cesantias,cre_item_int_cesantias,valor_liquida,contrapartida)
				VALUES
				($liquidacion_int_cesantias_id,$puc_diferencia,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_provision,IF($centro_costo_provision>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_provision),'NULL'),0,'NULL','NULL',$observaciones,$debito,$credito,$diferencia,0)";
				$this -> query($insert_det_puc_prov,$Conex,true); 
				
				}
				
				// contrapartida
				$insert_det_puc_contra ="INSERT INTO detalle_int_cesantias_puc (liquidacion_int_cesantias_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_int_cesantias,porcentaje_int_cesantias,formula_int_cesantias,desc_int_cesantias,deb_item_int_cesantias,cre_item_int_cesantias,valor_liquida,contrapartida)
				VALUES
				($liquidacion_int_cesantias_id,$puc_contrapartida,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_provision,IF($centro_costo_provision>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_provision),'NULL'),0,'NULL','NULL',$observaciones,0,$valor_liquidacion,0,1)";
				$this -> query($insert_det_puc_contra,$Conex,true);
				
			$this -> Commit($Conex);  
			
		}else
		{ // Para todos los empleados!!
		
			
			$select="SELECT c.contrato_id,c.sueldo_base FROM contrato c, tipo_contrato t WHERE c.estado='A' AND t.tipo_contrato_id=c.tipo_contrato_id AND t.prestaciones_sociales=1";
			
			$result = $this -> DbFetchAll($select,$Conex);
			$this -> Begin($Conex);
			foreach($result as $resultado){
					$contrato_id = $resultado[contrato_id];
					$valor =$resultado[sueldo_base]/2;
					$select_contrato = "SELECT c.empleado_id,(SELECT e.tercero_id FROM empleado e WHERE e.empleado_id=c.empleado_id)as tercero_id,c.area_laboral,c.sueldo_base,c.fecha_inicio, DATEDIFF(CURDATE(),c.fecha_inicio) as dias_trabajados FROM contrato c WHERE c.contrato_id=$contrato_id AND estado='A' ";
				
				$result_contrato = $this -> DbFetchAll($select_contrato,$Conex); 
				$empleado_id	 = $result_contrato[0]['empleado_id'];
				$tercero_id	 = $result_contrato[0]['tercero_id'];
				$area_laboral	 = $result_contrato[0]['area_laboral'];
			
				
				$estado = "'A'";
				$liquidacion_int_cesantias_id 		= $this -> DbgetMaxConsecutive("liquidacion_int_cesantias","liquidacion_int_cesantias_id",$Conex,false,1);
				
				$insert_int_cesantias = "INSERT INTO liquidacion_int_cesantias 
				(liquidacion_int_cesantias_id,contrato_id,fecha_liquidacion,estado,total,tipo_liquidacion,periodo,observaciones)
				VALUES
				($liquidacion_int_cesantias_id,$contrato_id,$fecha_liquidacion,$estado,$valor,$tipo_liquidacion,$periodo,$observaciones)";
				//exit($insert_int_cesantias);
				$this -> query($insert_int_cesantias,$Conex,true);
				
				
				  
				$select_datos_ter="SELECT numero_identificacion,digito_verificacion, CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) as nombre FROM tercero WHERE tercero_id=$tercero_id";
				$result_datos_ter = $this -> DbFetchAll($select_datos_ter,$Conex) ;
				
				$numero_identificacion = $result_datos_ter[0]['numero_identificacion'];
				$digito_verificacion   = $result_datos_ter[0]['digito_verificacion']>0 ? $result_datos_ter[0]['digito_verificacion']>0 :'NULL';
				$nombre_tercero = $result_datos_ter[0]['nombre'];
				
				$select_parametros="SELECT 
				puc_int_cesantias_prov_id,puc_int_cesantias_cons_id,puc_int_cesantias_contra_id,puc_admon_int_cesantias_id,puc_ventas_int_cesantias_id,puc_produ_int_cesantias_id,tipo_documento_id
				FROM parametros_liquidacion_nomina WHERE oficina_id=$oficina_id";
				$result_parametros = $this -> DbFetchAll($select_parametros,$Conex); 
				
				if(!count($result_parametros)>0) exit("No se han configurado los parametros para la oficina!! ");
				
				$puc_provision_int_cesantias = $result_parametros[0]['puc_int_cesantias_prov_id'];
				$puc_consolidado_int_cesantias = $result_parametros[0]['puc_int_cesantias_cons_id'];
				$puc_contrapartida		  = $result_parametros[0]['puc_int_cesantias_contra_id'];
				$puc_admin				= $result_parametros[0]['puc_admon_int_cesantias_id'];
				$puc_venta				= $result_parametros[0]['puc_ventas_int_cesantias_id'];
				$puc_operativo			= $result_parametros[0]['puc_produ_int_cesantias_id'];
				
				$tipo_doc				= $result_parametros[0]['tipo_documento_id'];
				
				$select_consolidado = "SELECT SUM(credito-debito)as neto,centro_de_costo_id FROM imputacion_contable WHERE puc_id=$puc_consolidado_int_cesantias AND tercero_id=$tercero_id";
				// echo $select_consolidado;
				 $result_consolidado = $this -> DbFetchAll($select_consolidado,$Conex,true); 
				 
				 if(!$result_consolidado[0]['neto']>0){exit("No se encontraron valores en la cuenta consolidados para el tercero $nombre_tercero");}
				
				
				$valor_consolidado = $result_consolidado[0]['neto'];
				$centro_costo_consolidado = $result_consolidado[0]['centro_de_costo_id'];
				
				$select_provision = "SELECT SUM(credito-debito)as neto,centro_de_costo_id  FROM imputacion_contable WHERE puc_id=$puc_provision_int_cesantias AND tercero_id=$tercero_id";
				
				$result_provision = $this -> DbFetchAll($select_provision,$Conex,true); 
				
				if(!$result_provision[0]['neto']>0){exit("No se encontraron valores en la cuenta provisionados para el tercero $nombre_tercero");}				
				$valor_provision = $result_provision[0]['neto'];
				$centro_costo_provision = $result_provision[0]['centro_de_costo_id'];
				
				
				$valor_guardado = intval($valor_consolidado)+intval($valor_provision);
				
				$insert_det_puc_cons ="INSERT INTO detalle_int_cesantias_puc (liquidacion_int_cesantias_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_int_cesantias,porcentaje_int_cesantias,formula_int_cesantias,desc_int_cesantias,deb_item_int_cesantias,cre_item_int_cesantias,valor_liquida,contrapartida)
				VALUES
				($liquidacion_int_cesantias_id,$puc_consolidado_int_cesantias,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_consolidado,IF($centro_costo_consolidado>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_consolidado),'NULL'),0,'NULL','NULL',$observaciones,$valor_consolidado,0,0,0)";
				$this -> query($insert_det_puc_cons,$Conex,true); 
				
				$insert_det_puc_prov ="INSERT INTO detalle_int_cesantias_puc (liquidacion_int_cesantias_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_int_cesantias,porcentaje_int_cesantias,formula_int_cesantias,desc_int_cesantias,deb_item_int_cesantias,cre_item_int_cesantias,valor_liquida,contrapartida)
				VALUES
				($liquidacion_int_cesantias_id,$puc_provision_int_cesantias,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_provision,IF($centro_costo_provision>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_provision),'NULL'),0,'NULL','NULL',$observaciones,$valor_provision,0,0,0)";
				$this -> query($insert_det_puc_prov,$Conex,true); 
				
				if($valor>$valor_guardado){
					if($area_laboral=='A'){
						$puc_diferencia = $puc_admin;
					}elseif($area_laboral=='O'){
						$puc_diferencia = $puc_operativo;
					}elseif($area_laboral=='C'){
						$puc_diferencia = $puc_venta;
					}
					$diferencia= $valor-$valor_guardado;
					$insert_det_puc_prov ="INSERT INTO detalle_int_cesantias_puc (liquidacion_int_cesantias_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_int_cesantias,porcentaje_int_cesantias,formula_int_cesantias,desc_int_cesantias,deb_item_int_cesantias,cre_item_int_cesantias,valor_liquida,contrapartida)
				VALUES
				($liquidacion_int_cesantias_id,$puc_diferencia,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_provision,IF($centro_costo_provision>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_provision),'NULL'),0,'NULL','NULL',$observaciones,$diferencia,0,0,0)";
				$this -> query($insert_det_puc_prov,$Conex,true); 
				
				}
				
				$insert_det_puc_contra ="INSERT INTO detalle_int_cesantias_puc (liquidacion_int_cesantias_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_int_cesantias,porcentaje_int_cesantias,formula_int_cesantias,desc_int_cesantias,deb_item_int_cesantias,cre_item_int_cesantias,valor_liquida,contrapartida)
				VALUES
				($liquidacion_int_cesantias_id,$puc_contrapartida,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_provision,IF($centro_costo_provision>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_provision),'NULL'),0,'NULL','NULL',$observaciones,0,$valor,0,0)";
				$this -> query($insert_det_puc_contra,$Conex,true);
				
			
			}
			$this -> Commit($Conex); 
		}
		
	print($liquidacion_int_cesantias_id);
	
  }
	
  public function Update($Campos,$Conex){	
    $this -> Begin($Conex);
	  if($_REQUEST['novedad_fija_id'] == 'NULL'){
	    $this -> DbInsertTable("novedad_fija",$Campos,$Conex,true,false);			
      }else{
        $this -> DbUpdateTable("novedad_fija",$Campos,$Conex,true,false);
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

 public function getContabilizarReg($liquidacion_int_cesantias_id,$empresa_id,$oficina_id,$usuario_id,$mesContable,$periodoContable,$Conex){
	 
	$this -> Begin($Conex);
		
		$select 	= "SELECT l.*,(SELECT e.tercero_id FROM empleado e,contrato c WHERE e.empleado_id=c.empleado_id AND c.contrato_id=l.contrato_id)as tercero_id FROM liquidacion_int_cesantias l WHERE l.liquidacion_int_cesantias_id=$liquidacion_int_cesantias_id";	
		$result 	= $this -> DbFetchAll($select,$Conex,true); 
		
		
		 if($result[0]['encabezado_registro_id']>0 && $result[0]['encabezado_registro_id']!=''){
		  exit('Ya esta en proceso la contabilizaci&oacute;n de la Liquidacion.<br>Por favor Verifique.');
		 }
		 
		$select		="SELECT tipo_documento_id FROM parametros_liquidacion_nomina WHERE oficina_id=$oficina_id";
		$result 	= $this -> DbFetchAll($select,$Conex,true); 
		
		$tip_documento			= $result[0]['tipo_documento_id'];	
		$tipo_documento_id      = $result[0]['tipo_documento_id'];	

		$select_usu = "SELECT CONCAT_WS(' ',t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) AS usuario FROM usuario u, tercero t 
						WHERE u.usuario_id=$usuario_id AND t.tercero_id=u.tercero_id";
		$result_usu	= $this -> DbFetchAll($select_usu,$Conex);				

		$encabezado_registro_id	= $this -> DbgetMaxConsecutive("encabezado_de_registro","encabezado_registro_id",$Conex,true,1);	
		
		$valor					= $result[0]['valor'];
		$numero_soporte			= $result[0]['liquidacion_int_cesantias_id'];	
		$tercero_id				= $result[0]['tercero_id'];
		$forma_pago_id			= $result_pago[0]['forma_pago_id'];
		
        include_once("UtilidadesContablesModelClass.php");
	  
	    $utilidadesContables = new UtilidadesContablesModel(); 	 		
		
				
		$fecha					   = $result[0]['fecha_liquidacion'];		
	    $fechaMes                  = substr($fecha,0,10);		
	    $periodo_contable_id       = $utilidadesContables -> getPeriodoContableId($fechaMes,$Conex);
	    $mes_contable_id           = $utilidadesContables -> getMesContableId($fechaMes,$periodo_contable_id,$Conex);
		
		if($mes_contable_id>0 && $periodo_contable_id>0){
			$consecutivo			= $result[0]['liquidacion_int_cesantias_id'];
							
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
								$mes_contable_id,$consecutivo,'$fecha','$concepto',$puc_id,'C','$fecha_registro','$modifica',$usuario_id,'$numero_documento_fuente',$id_documento_fuente)"; 
			$this -> query($insert,$Conex,true);  
	
			
			$select_item      = "SELECT detalle_int_cesantias_puc_id  FROM  detalle_int_cesantias_puc WHERE liquidacion_int_cesantias_id=$liquidacion_int_cesantias_id";
			$result_item      = $this -> DbFetchAll($select_item,$Conex);
			foreach($result_item as $result_items){
				$imputacion_contable_id 	= $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,true,1);
				$insert_item ="INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,valor,base,	porcentaje,formula,debito,credito)
								SELECT  
								$imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,desc_int_cesantias,$encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,(deb_item_int_cesantias+cre_item_int_cesantias),base_int_cesantias,porcentaje_int_cesantias,
								formula_int_cesantias,deb_item_int_cesantias,cre_item_int_cesantias
								FROM detalle_int_cesantias_puc WHERE liquidacion_int_cesantias_id=$liquidacion_int_cesantias_id AND detalle_int_cesantias_puc_id=$result_items[detalle_int_cesantias_puc_id]"; 
				$this -> query($insert_item,$Conex);
			}

			if(strlen($this -> GetError()) > 0){
				$this -> Rollback($Conex);
			}else{		
			
				$update = "UPDATE liquidacion_int_cesantias SET encabezado_registro_id=$encabezado_registro_id,	
							estado= 'C'
							WHERE liquidacion_int_cesantias_id=$liquidacion_int_cesantias_id";	
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

    public function selectDatosLiquidacionId($liquidacion_int_cesantias_id,$Conex){
  
 	$select = "SELECT lv.*,lv.valor_liquidacion as valor_liquidacion1,1 as si_empleado,(SELECT e.empleado_id FROM empleado e,contrato c WHERE e.empleado_id= c.empleado_id AND c.contrato_id=lv.contrato_id)as empleado_id
	FROM liquidacion_int_cesantias lv WHERE lv.liquidacion_int_cesantias_id = $liquidacion_int_cesantias_id"; 
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	return $result;
	
   }
    public function getTotalDebitoCredito($liquidacion_int_cesantias_id,$Conex){
	  
	  $select = "SELECT SUM(deb_item_int_cesantias) AS debito,SUM(cre_item_int_cesantias) AS credito FROM detalle_int_cesantias_puc   WHERE liquidacion_int_cesantias_id=$liquidacion_int_cesantias_id";
      $result = $this -> DbFetchAll($select,$Conex,true);
	  
	  return $result; 
	  
  }
  
  	public function getValor($empleado_id,$fecha_corte,$Conex){
		
		
		//Buscamos La fecha de la ultima liquidaci�n, o en su defecto la fecha de inicio del contrato:
		$select = "SELECT MAX(fecha_corte)as ultimo_corte FROM liquidacion_int_cesantias WHERE contrato_id=(SELECT contrato_id FROM contrato c WHERE c.empleado_id=$empleado_id AND estado='A' )";
		$result = $this -> DbFetchAll($select,$Conex,true);
		
		$ultima_liqui = $result[0]['ultimo_corte'];
		
		$select = "SELECT fecha_inicio,contrato_id,SUM(sueldo_base+subsidio_transporte)as base_liquidacion FROM contrato WHERE empleado_id=$empleado_id AND estado='A' ";
		$result = $this -> DbFetchAll($select,$Conex,true);
		
		$fecha_inicio = $result[0]['fecha_inicio'];
		$contrato_id = $result[0]['contrato_id'];
		$base_liquidacion = $result[0]['base_liquidacion'];
		
		//comparamos para sacar la fecha mas reciente:
		$fecha_anterior = $ultima_liqui>$fecha_inicio ? $ultima_liqui : $fecha_inicio;
		
		//sacamos el total de dias del periodo
		$select_dif = "SELECT DATEDIFF('$fecha_corte','$fecha_anterior') as dias ";
		$result_dif = $this -> DbFetchAll($select_dif,$Conex,true);
		
		$dias_periodo = $result_dif[0]['dias'];
		
		//Buscamos las licencias no remuneradas cuyo rango este dentro del periodo de liquidaci�n:
		$select_dias_lic = "SELECT SUM(dias)as dias FROM licencia WHERE estado='A' AND contrato_id=$contrato_id AND remunerado=0 AND fecha_inicial>'$fecha_anterior' AND fecha_final<'$fecha_corte'";
		
		$result_dias_lic = $this -> DbFetchAll($select_dias_lic,$Conex,true);
		
		$dias_in_periodo = $result_dias_lic[0]['dias'];
		
		//Bucamos las licencias que comenzaron antes pero terminaron dentro del periodo
		$select_dias_lic = "SELECT (dias-DATEDIFF('$fecha_anterior',fecha_inicial)) as dias FROM licencia WHERE estado='A' AND contrato_id=$contrato_id AND remunerado=0 AND fecha_inicial<'$fecha_anterior' AND fecha_final<'$fecha_corte'";
		$result_dias_lic = $this -> DbFetchAll($select_dias_lic,$Conex,true);
		
		$dias_bef_periodo = $result_dias_lic[0]['dias'];
		
		//Buscamos las licencias que comenzaron dentro del periodo pero terminan fuera 
		$select_dias_lic = "SELECT (dias-DATEDIFF(fecha_final,'$fecha_corte')) as dias FROM licencia WHERE estado='A' AND contrato_id=$contrato_id AND remunerado=0 AND fecha_inicial>'$fecha_anterior' AND fecha_final>'$fecha_corte'";
		$result_dias_lic = $this -> DbFetchAll($select_dias_lic,$Conex,true);
		
		$dias_aft_periodo = $result_dias_lic[0]['dias'];
		
		$dias_no_remu = $dias_in_periodo+$dias_bef_periodo+$dias_aft_periodo;
		
		//hacemos la operacion entre dias periodo menos los dias no remunerados
		$dias_liquidacion = $dias_periodo - $dias_no_remu;
		
		
		$valor_liquidacion = intval((($base_liquidacion*$dias_liquidacion)/360)*0.12);
		
		$result[0]=array(valor_liquidacion=>$valor_liquidacion,dias_periodo=>$dias_periodo,dias_no_remu=>$dias_no_remu,dias_liquidacion=>$dias_liquidacion);
		
		return $result;
		
		
		
		
		
  	}
    public function getDataEmpleado($empleado_id,$oficina_id,$Conex){
		
	$select_parametros="SELECT 
	puc_int_cesantias_prov_id,puc_int_cesantias_cons_id,puc_int_cesantias_contra_id,puc_admon_int_cesantias_id,puc_ventas_int_cesantias_id,puc_produ_int_cesantias_id,tipo_documento_id
	FROM parametros_liquidacion_nomina WHERE oficina_id=$oficina_id";
	$result_parametros = $this -> DbFetchAll($select_parametros,$Conex,true); 
	
	$puc_provision_int_cesantias = $result_parametros[0]['puc_int_cesantias_prov_id'];
	$puc_consolidado_int_cesantias = $result_parametros[0]['puc_int_cesantias_cons_id'];
	$puc_contrapartida		  = $result_parametros[0]['puc_int_cesantias_contra_id'];
	
	$tipo_doc				= $result_parametros[0]['tipo_documento_id'];
	
	$select_consolidado = "SELECT SUM(credito-debito)as neto FROM imputacion_contable WHERE puc_id=$puc_consolidado_int_cesantias AND tercero_id=(SELECT t.tercero_id FROM tercero t,empleado e WHERE t.tercero_id=e.tercero_id AND e.empleado_id=$empleado_id)";
	
	$result_consolidado = $this -> DbFetchAll($select_consolidado,$Conex,true); 
	
	// if(!count($result_consolidado)>0){exit("No se encontraron valores en la cuenta consolidados para este tercero!!");}
	
	
	$valor_consolidado = $result_consolidado[0]['neto']> 0 ? intval($result_consolidado[0]['neto']) : 0;
	
	
	
	$select_provision = "SELECT SUM(credito-debito)as neto,centro_de_costo_id  FROM imputacion_contable WHERE puc_id=$puc_provision_int_cesantias AND tercero_id=(SELECT t.tercero_id FROM tercero t,empleado e WHERE t.tercero_id=e.tercero_id AND e.empleado_id=$empleado_id)";
	
	$result_provision = $this -> DbFetchAll($select_provision,$Conex,true); 
	
	 //if(!count($result_provision)>0){exit("No se encontraron valores en la cuenta provisionados para este tercero!!");}
	
	
	$valor_provision = $result_provision[0]['neto'] > 0 ? intval($result_provision[0]['neto']) :0;
	
	
	$valor_guardado = intval($valor_consolidado)+intval($valor_provision);
	
			 
 	$select = "SELECT c.contrato_id,
				SUM(c.sueldo_base+subsidio_transporte)as sueldo_base,
				IF((SELECT MAX(fecha_corte) FROM liquidacion_int_cesantias WHERE contrato_id=c.contrato_id )>c.fecha_inicio,(SELECT MAX(fecha_corte) FROM liquidacion_int_cesantias WHERE contrato_id=c.contrato_id ),c.fecha_inicio)as fecha_ultimo_corte,
				$valor_provision as valor_provision,
				$valor_consolidado as valor_consolidado,
				c.fecha_inicio,
				(SELECT nombre_cargo FROM cargo WHERE cargo_id=c.cargo_id)as cargo,
				(SELECT t.numero_identificacion FROM tercero t, empleado e WHERE t.tercero_id=e.tercero_id AND e.empleado_id=c.empleado_id)as numero_identificacion,
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
   
 	public function GetTipoConcepto($Conex){
		return $this  -> DbFetchAll("SELECT tipo_concepto_laboral_id AS value,concepto AS text FROM tipo_concepto ORDER BY concepto ASC",$Conex,$ErrDb = false);
  	}   

      public function GetQueryIntCesantiasGrid(){
		$Query = "SELECT l.liquidacion_int_cesantias_id,
		(SELECT CONCAT_WS(' ', t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, empleado e,contrato c WHERE t.tercero_id=e.tercero_id AND e.empleado_id=c.empleado_id AND c.contrato_id=l.contrato_id) as empleado,
		(SELECT t.numero_identificacion FROM tercero t, empleado e,contrato c WHERE t.tercero_id=e.tercero_id AND e.empleado_id=c.empleado_id AND c.contrato_id=l.contrato_id) as numero_identificacion,
		l.observaciones,
		l.fecha_liquidacion,
		l.dias_periodo AS dias,
		l.valor_liquidacion AS valor,
		CASE l.estado WHEN 'A' THEN 'ACTIVO' WHEN 'I' THEN 'INACTIVO' WHEN 'C' THEN 'CONTABILIZADA' END AS estado FROM liquidacion_int_cesantias l";
	return $Query;
	}
}

?>
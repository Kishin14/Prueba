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
    
  public function Save($Campos,$oficina_id,$Conex){	

		$empleado_id				= $this -> requestDataForQuery('empleado_id','integer');
		$observaciones   			= $this -> requestDataForQuery('observaciones','text');
		$periodo   	   				= $this -> requestDataForQuery('periodo','integer');
		$fecha_liquidacion 	 		= $this -> requestDataForQuery('fecha_liquidacion','date');		
		$valor   					= $this -> requestDataForQuery('valor','numeric');
		$si_empleado			    = $this -> requestDataForQuery('si_empleado','text');
		$tipo_liquidacion			= $this -> requestDataForQuery('tipo_liquidacion','text');
		
		if($si_empleado == "'1'"){
			
			$this -> Begin($Conex);
				$select_contrato = "SELECT c.contrato_id,(SELECT e.tercero_id FROM empleado e WHERE e.empleado_id=c.empleado_id)as tercero_id,c.area_laboral,c.sueldo_base,c.fecha_inicio, DATEDIFF(CURDATE(),c.fecha_inicio) as dias_trabajados FROM contrato c WHERE c.empleado_id=$empleado_id AND estado='A' ";
				
				$result_contrato = $this -> DbFetchAll($select_contrato,$Conex); 
				$contrato_id	 = $result_contrato[0]['contrato_id'];
				$tercero_id	 = $result_contrato[0]['tercero_id'];
				$area_laboral	 = $result_contrato[0]['area_laboral'];
				
				$estado = "'A'";
				$liquidacion_prima_id 		= $this -> DbgetMaxConsecutive("liquidacion_prima","liquidacion_prima_id",$Conex,false,1);
				
				$insert_prima = "INSERT INTO liquidacion_prima 
				(liquidacion_prima_id,contrato_id,fecha_liquidacion,estado,total,tipo_liquidacion,periodo,observaciones)
				VALUES
				($liquidacion_prima_id,$contrato_id,$fecha_liquidacion,$estado,$valor,$tipo_liquidacion,$periodo,$observaciones)";
				//exit($insert_prima);
				$this -> query($insert_prima,$Conex,true);
				
				/*
				$detalle_liquidacion = $_REQUEST['concepto_item'];
				
				 $item				= split(',',$detalle_liquidacion);
				 
				  foreach($item as $item_id){
					if($item_id!=''){
						
						$item_fr	= split('-',$item_id);
						
						$fecha_inicial_periodo = $item_fr[0];
						$fecha_final_periodo = $item_fr[1];
						$dias_ganados	= $item_fr[2];
						$dias_disfrutados = $item_fr[3];
						
						$insert_detalles = "INSERT INTO detalle_liquidacion_prima (liquidacion_prima_id,periodo_inicio,periodo_fin,dias_ganados,dias_disfrutados) 						                                    VALUES
											($liquidacion_prima_id,$fecha_inicial_periodo,$fecha_final_periodo,$dias_ganados,$dias_disfrutados)";
						$this -> query($insert_detalles,$Conex,true); 
					}
				  }*/
				  
				$select_datos_ter="SELECT numero_identificacion,digito_verificacion FROM tercero WHERE tercero_id=$tercero_id";
				$result_datos_ter = $this -> DbFetchAll($select_datos_ter,$Conex) ;
				
				$numero_identificacion = $result_datos_ter[0]['numero_identificacion'];
				$digito_verificacion   = $result_datos_ter[0]['digito_verificacion']>0 ? $result_datos_ter[0]['digito_verificacion']>0 :'NULL';
				
				$select_parametros="SELECT 
				puc_prima_prov_id,puc_prima_cons_id,puc_prima_contra_id,puc_admon_prima_id,puc_ventas_prima_id,puc_produ_prima_id,tipo_documento_id
				FROM parametros_liquidacion_nomina WHERE oficina_id=$oficina_id";
				$result_parametros = $this -> DbFetchAll($select_parametros,$Conex); 
				
				$puc_provision_prima = $result_parametros[0]['puc_prima_prov_id'];
				$puc_consolidado_prima = $result_parametros[0]['puc_prima_cons_id'];
				$puc_contrapartida		  = $result_parametros[0]['puc_prima_contra_id'];
				$puc_admin				= $result_parametros[0]['puc_admon_prima_id'];
				$puc_venta				= $result_parametros[0]['puc_ventas_prima_id'];
				$puc_operativo			= $result_parametros[0]['puc_produ_prima_id'];
				
				$tipo_doc				= $result_parametros[0]['tipo_documento_id'];
				
				$select_consolidado = "SELECT SUM(credito-debito)as neto,centro_de_costo_id FROM imputacion_contable WHERE puc_id=$puc_consolidado_prima AND tercero_id=$tercero_id";
				
				$result_consolidado = $this -> DbFetchAll($select_consolidado,$Conex,true); 
				
				 //if(!count($result_consolidado)>0){exit("No se encontraron valores en la cuenta consolidados para este tercero!!");}
				
				
				$valor_consolidado = $result_consolidado[0]['neto']>0 ? intval($result_consolidado[0]['neto']) : 0 ;
				$centro_costo_consolidado = $result_consolidado[0]['centro_de_costo_id']>0 ? $result_consolidado[0]['centro_de_costo_id'] : 'NULL';
				
				$select_provision = "SELECT SUM(credito-debito)as neto,centro_de_costo_id  FROM imputacion_contable WHERE puc_id=$puc_provision_prima AND tercero_id=$tercero_id";
				
				$result_provision = $this -> DbFetchAll($select_provision,$Conex,true); 
				
				 //if(!count($result_provision)>0){exit("No se encontraron valores en la cuenta provisionados para este tercero!!");}
				
				
				$valor_provision = $result_provision[0]['neto'] >0 ?  intval($result_provision[0]['neto']) : 0;
				$centro_costo_provision = $result_provision[0]['centro_de_costo_id']>0 ? $result_provision[0]['centro_de_costo_id'] : 'NULL';
				
				
				$valor_guardado = intval($valor_consolidado)+intval($valor_provision);
				
				if($valor_consolidado>0){
					
					$insert_det_puc_cons ="INSERT INTO detalle_prima_puc (liquidacion_prima_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_prima,porcentaje_prima,formula_prima,desc_prima,deb_item_prima,cre_item_prima,valor_liquida,contrapartida)
					VALUES
					($liquidacion_prima_id,$puc_consolidado_prima,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_consolidado,IF($centro_costo_consolidado>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_consolidado),'NULL'),0,'NULL','NULL',$observaciones,$valor_consolidado,0,0,0)";
					$this -> query($insert_det_puc_cons,$Conex,true); 
					
				}
				if($valor_provision>0){
					
					$insert_det_puc_prov ="INSERT INTO detalle_prima_puc (liquidacion_prima_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_prima,porcentaje_prima,formula_prima,desc_prima,deb_item_prima,cre_item_prima,valor_liquida,contrapartida)
					VALUES
					($liquidacion_prima_id,$puc_provision_prima,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_provision,IF($centro_costo_provision>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_provision),'NULL'),0,'NULL','NULL',$observaciones,$valor_provision,0,0,0)";
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
					
					$insert_det_puc_gas ="INSERT INTO detalle_prima_puc (liquidacion_prima_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_prima,porcentaje_prima,formula_prima,desc_prima,deb_item_prima,cre_item_prima,valor_liquida,contrapartida)
				VALUES
				($liquidacion_prima_id,$puc_diferencia,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_provision,IF(COALESCE($centro_costo_provision,0)>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_provision),'NULL'),0,'NULL','NULL',$observaciones,$diferencia,0,0,0)";
				$this -> query($insert_det_puc_gas,$Conex,true); 
				
				}
				
				$insert_det_puc_contra ="INSERT INTO detalle_prima_puc (liquidacion_prima_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_prima,porcentaje_prima,formula_prima,desc_prima,deb_item_prima,cre_item_prima,valor_liquida,contrapartida)
				VALUES
				($liquidacion_prima_id,$puc_contrapartida,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_provision,IF($centro_costo_provision>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_provision),'NULL'),0,'NULL','NULL',$observaciones,0,$valor,0,0)";
				$this -> query($insert_det_puc_contra,$Conex,true);
				
			$this -> Commit($Conex);  
		}else
		{
			$this -> Begin($Conex);
			
			$select="SELECT c.contrato_id,c.sueldo_base FROM contrato c, tipo_contrato t WHERE c.estado='A' AND t.tipo_contrato_id=c.tipo_contrato_id AND t.prestaciones_sociales=1";
			
			$result = $this -> DbFetchAll($select,$Conex);
			$consecutivo 		= $this -> DbgetMaxConsecutive("liquidacion_prima","consecutivo",$Conex,false,1);
			
			foreach($result as $resultado){
				
					$contrato_id = $resultado[contrato_id];
					
					$select_contrato = "SELECT c.empleado_id,(SELECT e.tercero_id FROM empleado e WHERE e.empleado_id=c.empleado_id)as tercero_id,c.area_laboral,c.sueldo_base,c.fecha_inicio, (SELECT DATEDIFF($fecha_liquidacion,c.fecha_inicio))as dias_laborados FROM contrato c WHERE c.contrato_id=$contrato_id AND estado='A' ";
				
				
				
				$result_contrato = $this -> DbFetchAll($select_contrato,$Conex); 
				$empleado_id	 = $result_contrato[0]['empleado_id'];
				$tercero_id	 = $result_contrato[0]['tercero_id'];
				$area_laboral	 = $result_contrato[0]['area_laboral'];
				$dias_laborados	 = $result_contrato[0]['dias_laborados']>180 ? 180 : $result_contrato[0]['dias_laborados'] ;
				$sueldo_base	 = $result_contrato[0]['sueldo_base'];
			 	$valor = intval(($dias_laborados*($sueldo_base/2))/180);
				
				$estado = "'A'";
				$liquidacion_prima_id 		= $this -> DbgetMaxConsecutive("liquidacion_prima","liquidacion_prima_id",$Conex,false,1);
				
				$insert_prima = "INSERT INTO liquidacion_prima 
				(liquidacion_prima_id,consecutivo,contrato_id,fecha_liquidacion,estado,total,tipo_liquidacion,periodo,observaciones)
				VALUES
				($liquidacion_prima_id,$consecutivo,$contrato_id,$fecha_liquidacion,$estado,$valor,$tipo_liquidacion,$periodo,$observaciones)";
				//exit($insert_prima);
				$this -> query($insert_prima,$Conex,true);
				
				
				  
				$select_datos_ter="SELECT numero_identificacion,digito_verificacion, CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) as nombre FROM tercero WHERE tercero_id=$tercero_id";
				$result_datos_ter = $this -> DbFetchAll($select_datos_ter,$Conex) ;
				
				$numero_identificacion = $result_datos_ter[0]['numero_identificacion'];
				$digito_verificacion   = $result_datos_ter[0]['digito_verificacion']>0 ? $result_datos_ter[0]['digito_verificacion']>0 :'NULL';
				$nombre_tercero = $result_datos_ter[0]['nombre'];
				
				$select_parametros="SELECT 
				puc_prima_prov_id,puc_prima_cons_id,puc_prima_contra_id,puc_admon_prima_id,puc_ventas_prima_id,puc_produ_prima_id,tipo_documento_id
				FROM parametros_liquidacion_nomina WHERE oficina_id=$oficina_id";
				$result_parametros = $this -> DbFetchAll($select_parametros,$Conex); 
				
				if(!count($result_parametros)>0) exit("No se han configurado los parametros para la oficina!! ");
				
				$puc_provision_prima = $result_parametros[0]['puc_prima_prov_id'];
				$puc_consolidado_prima = $result_parametros[0]['puc_prima_cons_id'];
				$puc_contrapartida		  = $result_parametros[0]['puc_prima_contra_id'];
				$puc_admin				= $result_parametros[0]['puc_admon_prima_id'];
				$puc_venta				= $result_parametros[0]['puc_ventas_prima_id'];
				$puc_operativo			= $result_parametros[0]['puc_produ_prima_id'];
				
				$tipo_doc				= $result_parametros[0]['tipo_documento_id'];
				
				$select_consolidado = "SELECT SUM(credito-debito)as neto,centro_de_costo_id FROM imputacion_contable WHERE puc_id=$puc_consolidado_prima AND tercero_id=$tercero_id";
				// echo $select_consolidado;
				 $result_consolidado = $this -> DbFetchAll($select_consolidado,$Conex,true); 
				 
				 //if(!$result_consolidado[0]['neto']>0){exit("No se encontraron valores en la cuenta consolidados para el tercero $nombre_tercero");}
				
				
				$valor_consolidado = $result_consolidado[0]['neto']>0 ? intval($result_consolidado[0]['neto']) : 0 ;
				$centro_costo_consolidado = $result_consolidado[0]['centro_de_costo_id']>0 ? $result_consolidado[0]['centro_de_costo_id'] : 'NULL';
				
				$select_provision = "SELECT SUM(credito-debito)as neto,centro_de_costo_id  FROM imputacion_contable WHERE puc_id=$puc_provision_prima AND tercero_id=$tercero_id";
				
				$result_provision = $this -> DbFetchAll($select_provision,$Conex,true); 
				
				//if(!$result_provision[0]['neto']>0){exit("No se encontraron valores en la cuenta provisionados para el tercero $nombre_tercero");}				
				$valor_provision = $result_provision[0]['neto']>0 ? intval($result_provision[0]['neto']) : 0 ;
				$centro_costo_provision = $result_provision[0]['centro_de_costo_id']>0 ? $result_provision[0]['centro_de_costo_id'] : 'NULL';
				
				
				$valor_guardado = intval($valor_consolidado)+intval($valor_provision);
				
				if($valor_consolidado>0){
					
					$insert_det_puc_cons ="INSERT INTO detalle_prima_puc (liquidacion_prima_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_prima,porcentaje_prima,formula_prima,desc_prima,deb_item_prima,cre_item_prima,valor_liquida,contrapartida)
				VALUES
				($liquidacion_prima_id,$puc_consolidado_prima,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_consolidado,IF($centro_costo_consolidado>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_consolidado),'NULL'),0,'NULL','NULL',$observaciones,$valor_consolidado,0,0,0)";
					$this -> query($insert_det_puc_cons,$Conex,true); 
					
				}
				if($valor_provision>0){
					
					$insert_det_puc_prov ="INSERT INTO detalle_prima_puc (liquidacion_prima_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_prima,porcentaje_prima,formula_prima,desc_prima,deb_item_prima,cre_item_prima,valor_liquida,contrapartida)
				VALUES
				($liquidacion_prima_id,$puc_provision_prima,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_provision,IF($centro_costo_provision>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_provision),'NULL'),0,'NULL','NULL',$observaciones,$valor_provision,0,0,0)";
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
					
					$diferencia= intval($valor-$valor_guardado);
					
					$insert_det_puc_gas ="INSERT INTO detalle_prima_puc (liquidacion_prima_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_prima,porcentaje_prima,formula_prima,desc_prima,deb_item_prima,cre_item_prima,valor_liquida,contrapartida)
				VALUES
				($liquidacion_prima_id,$puc_diferencia,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_provision,IF(COALESCE($centro_costo_provision,0)>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_provision),'NULL'),0,'NULL','NULL',$observaciones,$diferencia,0,0,0)";
				$this -> query($insert_det_puc_gas,$Conex,true); 
				
				}
				
				$insert_det_puc_contra ="INSERT INTO detalle_prima_puc (liquidacion_prima_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_prima,porcentaje_prima,formula_prima,desc_prima,deb_item_prima,cre_item_prima,valor_liquida,contrapartida)
				VALUES
				($liquidacion_prima_id,$puc_contrapartida,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_costo_provision,IF($centro_costo_provision>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = $centro_costo_provision),'NULL'),0,'NULL','NULL',$observaciones,0,$valor,0,1)";
				$this -> query($insert_det_puc_contra,$Conex,true);
				
			
			}
			
			$this -> Commit($Conex); 
		}
		
	print($liquidacion_prima_id);
	
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

 public function getContabilizarReg($liquidacion_prima_id,$empresa_id,$oficina_id,$usuario_id,$mesContable,$periodoContable,$Conex){
	 
	$this -> Begin($Conex);
		
		$select 	= "SELECT l.*,(SELECT e.tercero_id FROM empleado e,contrato c WHERE e.empleado_id=c.empleado_id AND c.contrato_id=l.contrato_id)as tercero_id FROM liquidacion_prima l WHERE l.liquidacion_prima_id=$liquidacion_prima_id";	
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
		$numero_soporte			= $result[0]['liquidacion_prima_id'];	
		$tercero_id				= $result[0]['tercero_id'];
		$forma_pago_id			= $result_pago[0]['forma_pago_id'];
		
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
								$mes_contable_id,$consecutivo,'$fecha','$concepto',$puc_id,'C','$fecha_registro','$modifica',$usuario_id,'$numero_documento_fuente',$id_documento_fuente)"; 
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
							estado= 'C'
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
  }

    public function selectDatosLiquidacionId($liquidacion_prima_id,$Conex){
  
 	$select = "SELECT lv.*,(SELECT e.empleado_id FROM empleado e,contrato c WHERE e.empleado_id= c.empleado_id AND c.contrato_id=lv.contrato_id)as empleado_id
	FROM liquidacion_prima lv WHERE lv.liquidacion_prima_id = $liquidacion_prima_id"; 
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	return $result;
	
   }
    public function getTotalDebitoCredito($liquidacion_prima_id,$rango,$Conex){
	  if($rango=='T'){
	  		$select = "SELECT SUM(deb_item_prima) AS debito,SUM(cre_item_prima) AS credito FROM detalle_prima_puc   WHERE liquidacion_prima_id IN(SELECT liquidacion_prima_id FROM liquidacion_prima WHERE consecutivo = (SELECT consecutivo FROM liquidacion_prima WHERE liquidacion_prima_id = $liquidacion_prima_id))";
	  }else{
		  $select = "SELECT SUM(deb_item_prima) AS debito,SUM(cre_item_prima) AS credito FROM detalle_prima_puc   WHERE liquidacion_prima_id=$liquidacion_prima_id";
	  }
      $result = $this -> DbFetchAll($select,$Conex,true);
	  
	  return $result; 
	  
  }
    public function getDataEmpleado($empleado_id,$fecha_liquidacion,$Conex){
		
	$fecha_liquidacion = $fecha_liquidacion >0 ? "'".$fecha_liquidacion."'" : 'CURDATE()';	
  
 	$select = "SELECT c.contrato_id,c.sueldo_base,c.fecha_inicio,(SELECT nombre_cargo FROM cargo WHERE cargo_id=c.cargo_id)as cargo, (SELECT t.numero_identificacion FROM tercero t, empleado e WHERE t.tercero_id=e.tercero_id AND e.empleado_id=c.empleado_id)as numero_identificacion,
	(SELECT CONCAT_WS(' ', t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, empleado e WHERE t.tercero_id=e.tercero_id AND e.empleado_id=c.empleado_id) as empleado,
	(SELECT DATEDIFF($fecha_liquidacion,c.fecha_inicio))as dias_laborados
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

   public function GetQueryPrimaGrid(){
   	$Query = "SELECT novedad_fija_id, concepto, fecha_inicial, fecha_final, valor, periodicidad, estado
    FROM novedad_fija";
   return $Query;
   }
}

?>
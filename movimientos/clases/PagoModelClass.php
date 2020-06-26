<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class PagoModel extends Db{
		
  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function selectDatosPagoId($abono_nomina_id,$Conex){
     $select    = "SELECT a.*,
	 					(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id=a.encabezado_registro_id) AS numero_soporte
					FROM abono_nomina  a 
	                WHERE a.abono_nomina_id = $abono_nomina_id";
     $result    = $this -> DbFetchAll($select,$Conex,true);
     return $result;					  			
	  
  }

   public function GetTipoPago($Conex){
	return $this -> DbFetchAll("SELECT c.cuenta_tipo_pago_id AS value, CONCAT_WS(' - ',(SELECT nombre FROM forma_pago WHERE forma_pago_id=c.forma_pago_id ),(SELECT CONCAT_WS(' ',codigo_puc,nombre) AS nombre FROM puc WHERE puc_id=c.puc_id )) AS text FROM cuenta_tipo_pago c",$Conex,
	$ErrDb = false);
   }
   
   public function GetDocumento($Conex){
	return $this -> DbFetchAll("SELECT tipo_documento_id  AS value,nombre AS text FROM tipo_de_documento  WHERE de_cierre=0 AND de_traslado=0",$Conex,
	$ErrDb = false);
   }


  public function getCausalesAnulacion($Conex){
		
	$select = "SELECT causal_anulacion_id AS value,nombre AS text FROM causal_anulacion ORDER BY nombre";
	$result = $this -> DbFetchAll($select,$Conex,true);
	
	return $result;		
  }


  public function getDataEmpleado($empleado_id,$Conex){

     $select = "SELECT tr.numero_identificacion AS empleado_nit
	 			FROM empleado p, tercero tr 
				WHERE p.empleado_id=$empleado_id AND tr.tercero_id = p.tercero_id";
     $result = $this -> DbFetchAll($select,$Conex,false);

     return $result;

  }  
  public function SelectSolicitud($factura_proveedor_id,$Conex){
  
    $select = "SELECT
				(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id=f.encabezado_registro_id) AS consecutivo_id,
				CASE f.fuente_servicio_cod WHEN 'OC' THEN 'Orden de Compra' WHEN 'DU' THEN 'Despacho Urbano' WHEN 'MC' THEN 'Manifiesto de Carga' ELSE CONCAT_WS(' ',(SELECT nombre_bien_servicio FROM tipo_bien_servicio WHERE tipo_bien_servicio_id=f.tipo_bien_servicio_id),f.fecha_factura_proveedor)  END AS tipo,
				(SELECT consecutivo FROM orden_compra WHERE orden_compra_id=f.orden_compra_id) AS orden_no,
				f.codfactura_proveedor,
				(SELECT numero_despacho FROM liquidacion_despacho WHERE liquidacion_despacho_id=f.liquidacion_despacho_id) AS manifiesto
				FROM factura_proveedor f
				WHERE f.factura_proveedor_id=$factura_proveedor_id";

	$result = $this -> DbFetchAll($select,$Conex,false);

	return $result;  
  
  }
  
  public function getDataFactura($abono_nomina_id,$Conex){

     $select = "SELECT 
						(SELECT t.numero_identificacion FROM  empleado p, tercero t WHERE p.empleado_id=a.empleado_id AND  t.tercero_id=p.tercero_id ) AS empleado_nit,
						(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS nombre FROM  empleado p, tercero t WHERE p.empleado_id=a.empleado_id AND  t.tercero_id=p.tercero_id ) AS empleado_nit						
	 			FROM abono_nomina a
				WHERE a.abono_nomina_id = $abono_nomina_id ";

     $result = $this -> DbFetchAll($select,$Conex,false);

     return $result;

  }  

  public function Save($empresa_id,$oficina_id,$Campos,$Conex){	

    $this -> Begin($Conex);
					
	$abono_nomina_id             = $this -> DbgetMaxConsecutive("abono_nomina","abono_nomina_id",$Conex,true,1);
	$this -> assignValRequest('abono_nomina_id',$abono_nomina_id);
	$cuenta_tipo_pago_id         = $this -> requestDataForQuery('cuenta_tipo_pago_id','integer');
	
	$causaciones_abono_nomina    = $this -> requestDataForQuery('causaciones_abono_nomina','integer');
	//
	$causaciones_abono_primas    = $this -> requestDataForQuery('causaciones_abono_primas','integer');
	$causaciones_abono_cesantias = $this -> requestDataForQuery('causaciones_abono_cesantias','integer');
	$causaciones_abono_int_cesantias = $this -> requestDataForQuery('causaciones_abono_int_cesantias','integer');
	$causaciones_abono_vacaciones= $this -> requestDataForQuery('causaciones_abono_vacaciones','integer');
	
	$valores_abono_nomina        = $this -> requestDataForQuery('valores_abono_nomina','integer');
	//
	$valores_abono_primas        = $this -> requestDataForQuery('valores_abono_primas','integer');
	$valores_abono_cesantias     = $this -> requestDataForQuery('valores_abono_cesantias','integer');
	$valores_abono_int_cesantias = $this -> requestDataForQuery('valores_abono_int_cesantias','integer');
	$valores_abono_vacaciones    = $this -> requestDataForQuery('valores_abono_vacaciones','integer');
	
	
	$valor_abono_nomina        = $this -> requestDataForQuery('valor_abono_nomina','integer');
	$valor_abono_primas        = $this -> requestDataForQuery('valor_abono_primas','integer');
	$valor_abono_cesantias     = $this -> requestDataForQuery('valor_abono_cesantias','integer');
	$valor_abono_int_cesantias = $this -> requestDataForQuery('valor_abono_int_cesantias','integer');
	$valor_abono_vacaciones    = $this -> requestDataForQuery('valor_abono_vacaciones','integer');
	
	
	$empleado_id 		       = $this -> requestDataForQuery('empleado_id','integer');
	
	$valor_abono_total         = $valor_abono_nomina + $valor_abono_primas + $valor_abono_cesantias + $valor_abono_vacaciones +$valor_abono_int_cesantias;
	
	$this -> assignValRequest('valor_abono_total',$valor_abono_total);
	
	$this -> DbInsertTable("abono_nomina",$Campos,$Conex,true,false);

	$fact_comp='';

	$causacion_id				= str_replace("'","",$causaciones_abono_nomina);
	//
	$causacion_primas_id		= str_replace("'","",$causaciones_abono_primas);
	$causacion_cesantias_id		= str_replace("'","",$causaciones_abono_cesantias);
	$causacion_int_cesantias_id	= str_replace("'","",$causaciones_abono_int_cesantias);
	$causacion_vacaciones_id    = str_replace("'","",$causaciones_abono_vacaciones);
	
	$causacion_id				= explode(',',$causacion_id);
	//
	$causacion_primas_id		= explode(',',$causacion_primas_id);
	$causacion_cesantias_id		= explode(',',$causacion_cesantias_id);
	$causacion_int_cesantias_id = explode(',',$causacion_int_cesantias_id);
	$causacion_vacaciones_id	= explode(',',$causacion_vacaciones_id);
	

	$final_credito_pago=0;
	$final_debito_pago=0;

	if($empleado_id>0){
		$select_prov = "SELECT 
						CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS empleado
						FROM empleado p, tercero t WHERE p.empleado_id=$empleado_id AND t.tercero_id=p.tercero_id"; 
		$result_prov = $this -> DbFetchAll($select_prov,$Conex,true);	
	}
	
	$select_tipo = "SELECT c.puc_id,
					p.requiere_centro_costo,
					p.requiere_tercero,
					c.cuenta_tipo_pago_natu, 
					TRIM(p.nombre) AS nombre,
					(SELECT  ipc.porcentaje FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc 
					WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
					AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS por_emp,					  
					(SELECT  ipc.formula FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc 
					WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
					AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS for_emp,

					(SELECT tercero_id FROM empresa WHERE empresa_id=$empresa_id) AS tercero_id,
					(SELECT t.numero_identificacion FROM empresa e, tercero t WHERE e.empresa_id=$empresa_id AND t.tercero_id=e.tercero_id) AS numero_identificacion,
					(SELECT t.digito_verificacion FROM empresa e, tercero t WHERE e.empresa_id=$empresa_id AND t.tercero_id=e.tercero_id) AS digito_verificacion,

					(SELECT centro_de_costo_id FROM centro_de_costo WHERE oficina_id=$oficina_id LIMIT 1) AS centro_de_costo_id,
					(SELECT codigo FROM centro_de_costo WHERE oficina_id=$oficina_id LIMIT 1) AS codigo_centro_costo

					FROM cuenta_tipo_pago c, puc p WHERE c.cuenta_tipo_pago_id=$cuenta_tipo_pago_id AND p.puc_id=c.puc_id"; 
					
	$result_tipo = $this -> DbFetchAll($select_tipo,$Conex,true);		
	
	#foreach  para nomina.	
	
	$valores_id		= str_replace("'","",$valores_abono_nomina);
	$valores_id		= explode('=',$valores_id);
	$valor_tot_pago	= 0;
	$j              = 0;	

	foreach($causacion_id as $causaciones){
		
		 if($causaciones>0){
			 

			$valor_pago_ind = str_replace(".","",$valores_id[$j]);
			$valor_pago_ind = str_replace(",",".",$valor_pago_ind);		
			$valor_tot_pago = $valor_tot_pago+$valor_pago_ind;

			$j++;
			
			$debito_pago   ='';
			$credito_pago  ='';
			$debito_contra ='';
			$credito_contra='';

			$select_contra 	= "SELECT c.puc_id,
									IF(i.credito>0,'C','D') AS natu_bien_servicio,
									c.requiere_centro_costo,
									c.requiere_tercero,
									l.fecha_final,
									(SELECT e.tercero_id FROM contrato co, empleado e WHERE co.contrato_id=l.contrato_id AND e.empleado_id=co.empleado_id) AS tercero_id,
									(SELECT t.numero_identificacion FROM contrato co, empleado e, tercero t WHERE co.contrato_id=l.contrato_id AND e.empleado_id=co.empleado_id AND t.tercero_id=e.tercero_id) AS numero_identificacion,
									(SELECT t.digito_verificacion FROM contrato co, empleado e, tercero t WHERE co.contrato_id=l.contrato_id AND e.empleado_id=co.empleado_id AND t.tercero_id=e.tercero_id) AS digito_verificacion,
									(SELECT co.centro_de_costo_id FROM contrato co WHERE co.contrato_id=l.contrato_id ) AS centro_de_costo_id,
									(SELECT cc.codigo FROM contrato co, centro_de_costo cc WHERE co.contrato_id=l.contrato_id AND cc.centro_de_costo_id=co.centro_de_costo_id ) AS codigo_centro_costo,

									(SELECT centro_de_costo_id FROM centro_de_costo WHERE oficina_id=$oficina_id LIMIT 1 ) AS centro_de_costo_id1,
									(SELECT codigo FROM centro_de_costo WHERE oficina_id=$oficina_id LIMIT 1  ) AS codigo_centro_costo1,
									i.concepto,
									(SELECT TRIM(nombre) FROM puc WHERE puc_id=c.puc_id) AS nombre_puc
									FROM liquidacion_novedad l,   puc c, detalle_liquidacion_novedad i  
									WHERE l.liquidacion_novedad_id=$causaciones AND i.liquidacion_novedad_id=l.liquidacion_novedad_id  AND i.sueldo_pagar=1  AND c.puc_id=i.puc_id "; 

			$result_contra 	= $this -> DbFetchAll($select_contra,$Conex,true);		
			
			$puc_contra 	= $result_contra[0]['puc_id'];
			$natu_contra 	= $result_contra[0]['natu_bien_servicio'];
			$nombre_contra 	= 'CANC.: '.$result_contra[0]['concepto'].' '.$result_contra[0]['fecha_final'];
			$fact_comp.= $result_contra[0]['concepto'].',';			
			$tercero_id		= $result_contra[0]['requiere_tercero']==1 ? $result_contra[0]['tercero_id']:'NULL';
			$tercero_id		= $tercero_id>0 ? $tercero_id : 'NULL';			
			$numero_identificacion		= $result_contra[0]['requiere_tercero']==1 ? $result_contra[0]['numero_identificacion']:'NULL';
			$digito_verificacion		= $result_contra[0]['requiere_tercero']==1 ? $result_contra[0]['digito_verificacion']:'NULL';			
					
			if(!strlen(trim($numero_identificacion)) > 0 && $result_contra[0]['requiere_tercero']==1){
			   exit('No posee Numero de Identificacion el tercero Empleado');
			}							
									
			if(!strlen(trim($digito_verificacion)) > 0){
			  $digito_verificacion = 'NULL';
			}
			
			$centro_costo	= $result_contra[0]['requiere_centro_costo']==1 ? $result_contra[0]['centro_de_costo_id1']:'NULL';
			$codigo_centro_costo 		= $result_contra[0]['requiere_centro_costo']==1 ? "'".$result_contra[0]['codigo_centro_costo1']."'":'NULL';



			if($natu_contra=='D'){
				$debito_contra=0;
				$credito_contra=$valor_pago_ind;
			}else{
				$debito_contra=$valor_pago_ind;
				$credito_contra=0;
			}

			if($natu_tipo=='D'){
				$debito_pago=$valor_pago_ind;
				$final_debito_pago=$final_debito_pago+$debito_pago;
				$credito_pago=0;
			}else{
				$debito_pago=0;
				$credito_pago=$valor_pago_ind;
				$final_credito_pago=$final_credito_pago+$credito_pago;
			}


			$relacion_abono_nomina_id 	= $this -> DbgetMaxConsecutive("relacion_abono_nomina","relacion_abono_nomina_id",$Conex,true,1);	
			
			$insert_item = "INSERT INTO relacion_abono_nomina (relacion_abono_nomina_id,liquidacion_novedad_id,abono_nomina_id,rel_valor_abono_nomina) 
						VALUES ($relacion_abono_nomina_id,$causaciones,$abono_nomina_id,'$valor_pago_ind')"; 
			$this -> query($insert_item,$Conex,true);	
	
			$item_abono_nomina_id 	= $this -> DbgetMaxConsecutive("item_abono_nomina","item_abono_nomina_id",$Conex,true,1);
			
			$debito_contra  = intVal($debito_contra);
	        $credito_contra = intVal($credito_contra);
		   	
			$insert_contra = "INSERT INTO 	item_abono_nomina (
									item_abono_nomina_id,						  
									abono_nomina_id,
									relacion_abono_nomina_id,
									puc_id,
									tercero_id,
								 	numero_identificacion,
									digito_verificacion,
									centro_de_costo_id,
									codigo_centro_costo,
									descripcion,
									debito,
									credito) 
							VALUES (
									$item_abono_nomina_id,
									$abono_nomina_id,
									$relacion_abono_nomina_id,
									$puc_contra,
									$tercero_id,
									$numero_identificacion,
									$digito_verificacion,
									$centro_costo,
									$codigo_centro_costo,
									'$nombre_contra',
									'$debito_contra',
									'$credito_contra'
							)"; 
			$this -> query($insert_contra,$Conex,true);		

		 }
	 }
	
	#foreach para primas
	
	$valores_id		= str_replace("'","",$valores_abono_primas);
	$valores_id		= explode('=',$valores_id);
	$valor_tot_pago	= 0;
	$j              = 0;
	
	foreach($causacion_primas_id as $causaciones){
		
		if($causaciones>0){
			

		   $valor_pago_ind = str_replace(".","",$valores_id[$j]);
		   $valor_pago_ind = str_replace(",",".",$valor_pago_ind);		
		   $valor_tot_pago = $valor_tot_pago+$valor_pago_ind;

		   $j++;
		   
		   $debito_pago='';
		   $credito_pago='';
		   $debito_contra='';
		   $credito_contra='';

		   $select_contra 	= "SELECT c.puc_id,
								   IF(i.cre_item_prima>0,'C','D') AS natu_bien_servicio,
								   c.requiere_centro_costo,
								   c.requiere_tercero,
								   l.fecha_liquidacion,
								   (SELECT e.tercero_id FROM contrato co, empleado e WHERE co.contrato_id=l.contrato_id AND e.empleado_id=co.empleado_id) AS tercero_id,
								   (SELECT t.numero_identificacion FROM contrato co, empleado e, tercero t WHERE co.contrato_id=l.contrato_id AND e.empleado_id=co.empleado_id AND t.tercero_id=e.tercero_id) AS numero_identificacion,
								   (SELECT t.digito_verificacion FROM contrato co, empleado e, tercero t WHERE co.contrato_id=l.contrato_id AND e.empleado_id=co.empleado_id AND t.tercero_id=e.tercero_id) AS digito_verificacion,
								   (SELECT co.centro_de_costo_id FROM contrato co WHERE co.contrato_id=l.contrato_id ) AS centro_de_costo_id,
								   (SELECT cc.codigo FROM contrato co, centro_de_costo cc WHERE co.contrato_id=l.contrato_id AND cc.centro_de_costo_id=co.centro_de_costo_id ) AS codigo_centro_costo,

								   (SELECT centro_de_costo_id FROM centro_de_costo WHERE oficina_id=$oficina_id LIMIT 1 ) AS centro_de_costo_id1,
								   (SELECT codigo FROM centro_de_costo WHERE oficina_id=$oficina_id LIMIT 1  ) AS codigo_centro_costo1,
								   i.desc_prima,
								   (SELECT TRIM(nombre) FROM puc WHERE puc_id=c.puc_id) AS nombre_puc
								   FROM liquidacion_prima l,   puc c, detalle_prima_puc i  
								   WHERE l.liquidacion_prima_id=$causaciones AND i.liquidacion_prima_id=l.liquidacion_prima_id  AND i.contrapartida = 1  AND c.puc_id=i.puc_id "; 

		   $result_contra 	= $this -> DbFetchAll($select_contra,$Conex,true);		
		   
		   $puc_contra 	            = $result_contra[0]['puc_id'];
		   $natu_contra 	        = $result_contra[0]['natu_bien_servicio'];
		   $nombre_contra 	        = 'CANC.: '.$result_contra[0]['desc_prima'].' '.$result_contra[0]['fecha_liquidacion'];
		   $fact_comp              .= $result_contra[0]['desc_prima'].',';			
		   $tercero_id		        = $result_contra[0]['requiere_tercero']==1 ? $result_contra[0]['tercero_id']:'NULL';
		   $tercero_id		        = $tercero_id>0 ? $tercero_id : 'NULL';			
		   $numero_identificacion   = $result_contra[0]['requiere_tercero']==1 ? $result_contra[0]['numero_identificacion']:'NULL';
		   $digito_verificacion		= $result_contra[0]['requiere_tercero']==1 ? $result_contra[0]['digito_verificacion']:'NULL';			
				   
		   if(!strlen(trim($numero_identificacion)) > 0 && $result_contra[0]['requiere_tercero']==1){
			  exit('No posee Numero de Identificacion el tercero Empleado');
		   }							
								   
		   if(!strlen(trim($digito_verificacion)) > 0){
			 $digito_verificacion = 'NULL';
		   }
		   
		   $centro_costo	     = $result_contra[0]['requiere_centro_costo']==1 ? $result_contra[0]['centro_de_costo_id1']:'NULL';
		   $codigo_centro_costo  = $result_contra[0]['requiere_centro_costo']==1 ? "'".$result_contra[0]['codigo_centro_costo1']."'":'NULL';



		   if($natu_contra=='D'){
			   $debito_contra=0;
			   $credito_contra=$valor_pago_ind;
		   }else{
			   $debito_contra=$valor_pago_ind;
			   $credito_contra=0;
		   }

		   if($natu_tipo=='D'){
			   $debito_pago=$valor_pago_ind;
			   $final_debito_pago=$final_debito_pago+$debito_pago;
			   $credito_pago=0;
		   }else{
			   $debito_pago=0;
			   $credito_pago=$valor_pago_ind;
			   $final_credito_pago=$final_credito_pago+$credito_pago;
		   }


		   $relacion_abono_nomina_id = $this -> DbgetMaxConsecutive("relacion_abono_nomina","relacion_abono_nomina_id",$Conex,true,1);	
		   
		   $insert_item = "INSERT INTO relacion_abono_nomina (relacion_abono_nomina_id,liquidacion_prima_id,abono_nomina_id,rel_valor_abono_nomina) 
					   VALUES ($relacion_abono_nomina_id,$causaciones,$abono_nomina_id,'$valor_pago_ind')"; 
		   $this -> query($insert_item,$Conex,true);	
   
		   $item_abono_nomina_id 	= $this -> DbgetMaxConsecutive("item_abono_nomina","item_abono_nomina_id",$Conex,true,1);	
		   
		   $debito_contra  = intVal($debito_contra);
	       $credito_contra = intVal($credito_contra);
		   
		   $insert_contra = "INSERT INTO 	item_abono_nomina (
								   item_abono_nomina_id,						  
								   abono_nomina_id,
								   relacion_abono_nomina_id,
								   puc_id,
								   tercero_id,
									numero_identificacion,
								   digito_verificacion,
								   centro_de_costo_id,
								   codigo_centro_costo,
								   descripcion,
								   debito,
								   credito) 
						   VALUES (
								   $item_abono_nomina_id,
								   $abono_nomina_id,
								   $relacion_abono_nomina_id,
								   $puc_contra,
								   $tercero_id,
								   $numero_identificacion,
								   $digito_verificacion,
								   $centro_costo,
								   $codigo_centro_costo,
								   '$nombre_contra',
								   '$debito_contra',
								   '$credito_contra'
						   )"; 
		   $this -> query($insert_contra,$Conex,true);		

		}
	
	}
	
	#foreach para vacaciones
	
	$valores_id		= str_replace("'","",$valores_abono_vacaciones);
	$valores_id		= explode('=',$valores_id);
	$valor_tot_pago	= 0;
	$j              = 0;
	
	foreach($causacion_vacaciones_id as $causaciones){
		
		if($causaciones>0){
			

		   $valor_pago_ind = str_replace(".","",$valores_id[$j]);
		   $valor_pago_ind = str_replace(",",".",$valor_pago_ind);		
		   $valor_tot_pago = $valor_tot_pago+$valor_pago_ind;

		   $j++;
		   
		   $debito_pago='';
		   $credito_pago='';
		   $debito_contra='';
		   $credito_contra='';

		   $select_contra 	= "SELECT c.puc_id,
								   IF(i.cre_item_vacaciones>0,'C','D') AS natu_bien_servicio,
								   c.requiere_centro_costo,
								   c.requiere_tercero,
								   l.fecha_liquidacion,
								   (SELECT e.tercero_id FROM contrato co, empleado e WHERE co.contrato_id=l.contrato_id AND e.empleado_id=co.empleado_id) AS tercero_id,
								   (SELECT t.numero_identificacion FROM contrato co, empleado e, tercero t WHERE co.contrato_id=l.contrato_id AND e.empleado_id=co.empleado_id AND t.tercero_id=e.tercero_id) AS numero_identificacion,
								   (SELECT t.digito_verificacion FROM contrato co, empleado e, tercero t WHERE co.contrato_id=l.contrato_id AND e.empleado_id=co.empleado_id AND t.tercero_id=e.tercero_id) AS digito_verificacion,
								   (SELECT co.centro_de_costo_id FROM contrato co WHERE co.contrato_id=l.contrato_id ) AS centro_de_costo_id,
								   (SELECT cc.codigo FROM contrato co, centro_de_costo cc WHERE co.contrato_id=l.contrato_id AND cc.centro_de_costo_id=co.centro_de_costo_id ) AS codigo_centro_costo,

								   (SELECT centro_de_costo_id FROM centro_de_costo WHERE oficina_id=$oficina_id LIMIT 1 ) AS centro_de_costo_id1,
								   (SELECT codigo FROM centro_de_costo WHERE oficina_id=$oficina_id LIMIT 1  ) AS codigo_centro_costo1,
								   i.desc_vacaciones,
								   (SELECT TRIM(nombre) FROM puc WHERE puc_id=c.puc_id) AS nombre_puc
								   FROM liquidacion_vacaciones l,   puc c, detalle_vacaciones_puc i  
								   WHERE l.liquidacion_vacaciones_id=$causaciones AND i.liquidacion_vacaciones_id=l.liquidacion_vacaciones_id  AND i.contrapartida=1  AND c.puc_id=i.puc_id "; 

		   $result_contra 	= $this -> DbFetchAll($select_contra,$Conex,true);		
		   
		   $puc_contra 	            = $result_contra[0]['puc_id'];
		   $natu_contra 	        = $result_contra[0]['natu_bien_servicio'];
		   $nombre_contra 	        = 'CANC.: '.$result_contra[0]['desc_vacaciones'].' '.$result_contra[0]['fecha_liquidacion'];
		   $fact_comp              .= $result_contra[0]['desc_vacaciones'].',';			
		   $tercero_id		        = $result_contra[0]['requiere_tercero']==1 ? $result_contra[0]['tercero_id']:'NULL';
		   $tercero_id		        = $tercero_id>0 ? $tercero_id : 'NULL';			
		   $numero_identificacion   = $result_contra[0]['requiere_tercero']==1 ? $result_contra[0]['numero_identificacion']:'NULL';
		   $digito_verificacion		= $result_contra[0]['requiere_tercero']==1 ? $result_contra[0]['digito_verificacion']:'NULL';			
				   
		   if(!strlen(trim($numero_identificacion)) > 0 && $result_contra[0]['requiere_tercero']==1){
			  exit('No posee Numero de Identificacion el tercero Empleado');
		   }							
								   
		   if(!strlen(trim($digito_verificacion)) > 0){
			 $digito_verificacion = 'NULL';
		   }
		   
		   $centro_costo	     = $result_contra[0]['requiere_centro_costo']==1 ? $result_contra[0]['centro_de_costo_id1']:'NULL';
		   $codigo_centro_costo  = $result_contra[0]['requiere_centro_costo']==1 ? "'".$result_contra[0]['codigo_centro_costo1']."'":'NULL';



		   if($natu_contra=='D'){
			   $debito_contra=0;
			   $credito_contra=$valor_pago_ind;
		   }else{
			   $debito_contra=$valor_pago_ind;
			   $credito_contra=0;
		   }

		   if($natu_tipo=='D'){
			   $debito_pago=$valor_pago_ind;
			   $final_debito_pago=$final_debito_pago+$debito_pago;
			   $credito_pago=0;
		   }else{
			   $debito_pago=0;
			   $credito_pago=$valor_pago_ind;
			   $final_credito_pago=$final_credito_pago+$credito_pago;
		   }


		   $relacion_abono_nomina_id = $this -> DbgetMaxConsecutive("relacion_abono_nomina","relacion_abono_nomina_id",$Conex,true,1);	
		   
		   $insert_item = "INSERT INTO relacion_abono_nomina (relacion_abono_nomina_id,liquidacion_vacaciones_id,abono_nomina_id,rel_valor_abono_nomina) 
					   VALUES ($relacion_abono_nomina_id,$causaciones,$abono_nomina_id,'$valor_pago_ind')"; 
		   $this -> query($insert_item,$Conex,true);	
   
		   $item_abono_nomina_id 	= $this -> DbgetMaxConsecutive("item_abono_nomina","item_abono_nomina_id",$Conex,true,1);	
		   
		   $debito_contra  = intVal($debito_contra);
	       $credito_contra = intVal($credito_contra);
		   
		   $insert_contra = "INSERT INTO 	item_abono_nomina (
								   item_abono_nomina_id,						  
								   abono_nomina_id,
								   relacion_abono_nomina_id,
								   puc_id,
								   tercero_id,
									numero_identificacion,
								   digito_verificacion,
								   centro_de_costo_id,
								   codigo_centro_costo,
								   descripcion,
								   debito,
								   credito) 
						   VALUES (
								   $item_abono_nomina_id,
								   $abono_nomina_id,
								   $relacion_abono_nomina_id,
								   $puc_contra,
								   $tercero_id,
								   $numero_identificacion,
								   $digito_verificacion,
								   $centro_costo,
								   $codigo_centro_costo,
								   '$nombre_contra',
								   '$debito_contra',
								   '$credito_contra'
						   )"; 
		   $this -> query($insert_contra,$Conex,true);		

		}
	}
	
	#foreach cesantias
	
	$valores_id		= str_replace("'","",$valores_abono_cesantias);
	$valores_id		= explode('=',$valores_id);
	$valor_tot_pago	= 0;
	$j              = 0;
	
	foreach($causacion_cesantias_id as $causaciones){
		
		if($causaciones>0){
			

		   $valor_pago_ind = str_replace(".","",$valores_id[$j]);
		   $valor_pago_ind = str_replace(",",".",$valor_pago_ind);		
		   $valor_tot_pago = $valor_tot_pago+$valor_pago_ind;

		   $j++;
		   
		   $debito_pago='';
		   $credito_pago='';
		   $debito_contra='';
		   $credito_contra='';

		   $select_contra 	= "SELECT c.puc_id,
								   IF(i.cre_item_cesantias>0,'C','D') AS natu_bien_servicio,
								   c.requiere_centro_costo,
								   c.requiere_tercero,
								   l.fecha_liquidacion,
								   (SELECT e.tercero_id FROM contrato co, empleado e WHERE co.contrato_id=l.contrato_id AND e.empleado_id=co.empleado_id) AS tercero_id,
								   (SELECT t.numero_identificacion FROM contrato co, empleado e, tercero t WHERE co.contrato_id=l.contrato_id AND e.empleado_id=co.empleado_id AND t.tercero_id=e.tercero_id) AS numero_identificacion,
								   (SELECT t.digito_verificacion FROM contrato co, empleado e, tercero t WHERE co.contrato_id=l.contrato_id AND e.empleado_id=co.empleado_id AND t.tercero_id=e.tercero_id) AS digito_verificacion,
								   (SELECT co.centro_de_costo_id FROM contrato co WHERE co.contrato_id=l.contrato_id ) AS centro_de_costo_id,
								   (SELECT cc.codigo FROM contrato co, centro_de_costo cc WHERE co.contrato_id=l.contrato_id AND cc.centro_de_costo_id=co.centro_de_costo_id ) AS codigo_centro_costo,

								   (SELECT centro_de_costo_id FROM centro_de_costo WHERE oficina_id=$oficina_id LIMIT 1 ) AS centro_de_costo_id1,
								   (SELECT codigo FROM centro_de_costo WHERE oficina_id=$oficina_id LIMIT 1  ) AS codigo_centro_costo1,
								   i.desc_cesantias,
								   (SELECT TRIM(nombre) FROM puc WHERE puc_id=c.puc_id) AS nombre_puc
								   FROM liquidacion_cesantias l,   puc c, detalle_cesantias_puc i  
								   WHERE l.liquidacion_cesantias_id=$causaciones AND i.liquidacion_cesantias_id=l.liquidacion_cesantias_id  AND i.contrapartida=1  AND c.puc_id=i.puc_id "; 

		   $result_contra 	= $this -> DbFetchAll($select_contra,$Conex,true);		
		   
		   $puc_contra 	            = $result_contra[0]['puc_id'];
		   $natu_contra 	        = $result_contra[0]['natu_bien_servicio'];
		   $nombre_contra 	        = 'CANC.: '.$result_contra[0]['desc_cesantias'].' '.$result_contra[0]['fecha_liquidacion'];
		   $fact_comp              .= $result_contra[0]['desc_cesantias'].',';			
		   $tercero_id		        = $result_contra[0]['requiere_tercero']==1 ? $result_contra[0]['tercero_id']:'NULL';
		   $tercero_id		        = $tercero_id>0 ? $tercero_id : 'NULL';			
		   $numero_identificacion   = $result_contra[0]['requiere_tercero']==1 ? $result_contra[0]['numero_identificacion']:'NULL';
		   $digito_verificacion		= $result_contra[0]['requiere_tercero']==1 ? $result_contra[0]['digito_verificacion']:'NULL';			
				   
		   if(!strlen(trim($numero_identificacion)) > 0 && $result_contra[0]['requiere_tercero']==1){
			  exit('No posee Numero de Identificacion el tercero Empleado');
		   }							
								   
		   if(!strlen(trim($digito_verificacion)) > 0){
			 $digito_verificacion = 'NULL';
		   }
		   
		   $centro_costo	     = $result_contra[0]['requiere_centro_costo']==1 ? $result_contra[0]['centro_de_costo_id1']:'NULL';
		   $codigo_centro_costo  = $result_contra[0]['requiere_centro_costo']==1 ? "'".$result_contra[0]['codigo_centro_costo1']."'":'NULL';



		   if($natu_contra=='D'){
			   $debito_contra=0;
			   $credito_contra=$valor_pago_ind;
		   }else{
			   $debito_contra=$valor_pago_ind;
			   $credito_contra=0;
		   }

		   if($natu_tipo=='D'){
			   $debito_pago=$valor_pago_ind;
			   $final_debito_pago=$final_debito_pago+$debito_pago;
			   $credito_pago=0;
		   }else{
			   $debito_pago=0;
			   $credito_pago=$valor_pago_ind;
			   $final_credito_pago=$final_credito_pago+$credito_pago;
		   }


		   $relacion_abono_nomina_id = $this -> DbgetMaxConsecutive("relacion_abono_nomina","relacion_abono_nomina_id",$Conex,true,1);	
		   
		   $insert_item = "INSERT INTO relacion_abono_nomina (relacion_abono_nomina_id,liquidacion_cesantias_id,abono_nomina_id,rel_valor_abono_nomina) 
					   VALUES ($relacion_abono_nomina_id,$causaciones,$abono_nomina_id,'$valor_pago_ind')"; 
		   $this -> query($insert_item,$Conex,true);	
		   
		   $debito_contra  = intVal($debito_contra);
	       $credito_contra = intVal($credito_contra);
   
		   $item_abono_nomina_id 	= $this -> DbgetMaxConsecutive("item_abono_nomina","item_abono_nomina_id",$Conex,true,1);	
		   $insert_contra = "INSERT INTO 	item_abono_nomina (
								   item_abono_nomina_id,						  
								   abono_nomina_id,
								   relacion_abono_nomina_id,
								   puc_id,
								   tercero_id,
									numero_identificacion,
								   digito_verificacion,
								   centro_de_costo_id,
								   codigo_centro_costo,
								   descripcion,
								   debito,
								   credito) 
						   VALUES (
								   $item_abono_nomina_id,
								   $abono_nomina_id,
								   $relacion_abono_nomina_id,
								   $puc_contra,
								   $tercero_id,
								   $numero_identificacion,
								   $digito_verificacion,
								   $centro_costo,
								   $codigo_centro_costo,
								   '$nombre_contra',
								   '$debito_contra',
								   '$credito_contra'
						   )"; 
		   $this -> query($insert_contra,$Conex,true);		

		}
	}
	
	#foreach intereses cesantias
	
	$valores_id		= str_replace("'","",$valores_abono_int_cesantias);
	$valores_id		= explode('=',$valores_id);
	$valor_tot_pago	= 0;
	$j              = 0;
	
	foreach($causacion_int_cesantias_id as $causaciones){
		
		if($causaciones>0){
			

		   $valor_pago_ind = str_replace(".","",$valores_id[$j]);
		   $valor_pago_ind = str_replace(",",".",$valor_pago_ind);		
		   $valor_tot_pago = $valor_tot_pago+$valor_pago_ind;

		   $j++;
		   
		   $debito_pago='';
		   $credito_pago='';
		   $debito_contra='';
		   $credito_contra='';

		   $select_contra 	= "SELECT c.puc_id,
								   IF(i.cre_item_int_cesantias>0,'C','D') AS natu_bien_servicio,
								   c.requiere_centro_costo,
								   c.requiere_tercero,
								   l.fecha_liquidacion,
								   (SELECT e.tercero_id FROM contrato co, empleado e WHERE co.contrato_id=l.contrato_id AND e.empleado_id=co.empleado_id) AS tercero_id,
								   (SELECT t.numero_identificacion FROM contrato co, empleado e, tercero t WHERE co.contrato_id=l.contrato_id AND e.empleado_id=co.empleado_id AND t.tercero_id=e.tercero_id) AS numero_identificacion,
								   (SELECT t.digito_verificacion FROM contrato co, empleado e, tercero t WHERE co.contrato_id=l.contrato_id AND e.empleado_id=co.empleado_id AND t.tercero_id=e.tercero_id) AS digito_verificacion,
								   (SELECT co.centro_de_costo_id FROM contrato co WHERE co.contrato_id=l.contrato_id ) AS centro_de_costo_id,
								   (SELECT cc.codigo FROM contrato co, centro_de_costo cc WHERE co.contrato_id=l.contrato_id AND cc.centro_de_costo_id=co.centro_de_costo_id ) AS codigo_centro_costo,

								   (SELECT centro_de_costo_id FROM centro_de_costo WHERE oficina_id=$oficina_id LIMIT 1 ) AS centro_de_costo_id1,
								   (SELECT codigo FROM centro_de_costo WHERE oficina_id=$oficina_id LIMIT 1  ) AS codigo_centro_costo1,
								   i.desc_int_cesantias,
								   (SELECT TRIM(nombre) FROM puc WHERE puc_id=c.puc_id) AS nombre_puc
								   FROM liquidacion_int_cesantias l,   puc c, detalle_int_cesantias_puc i  
								   WHERE l.liquidacion_int_cesantias_id=$causaciones AND i.liquidacion_int_cesantias_id=l.liquidacion_int_cesantias_id  AND i.contrapartida=1  AND c.puc_id=i.puc_id "; 

		   $result_contra 	= $this -> DbFetchAll($select_contra,$Conex,true);		
		   
		   $puc_contra 	            = $result_contra[0]['puc_id'];
		   $natu_contra 	        = $result_contra[0]['natu_bien_servicio'];
		   $nombre_contra 	        = 'CANC.: '.$result_contra[0]['desc_int_cesantias'].' '.$result_contra[0]['fecha_liquidacion'];
		   $fact_comp              .= $result_contra[0]['desc_int_cesantias'].',';			
		   $tercero_id		        = $result_contra[0]['requiere_tercero']==1 ? $result_contra[0]['tercero_id']:'NULL';
		   $tercero_id		        = $tercero_id>0 ? $tercero_id : 'NULL';			
		   $numero_identificacion   = $result_contra[0]['requiere_tercero']==1 ? $result_contra[0]['numero_identificacion']:'NULL';
		   $digito_verificacion		= $result_contra[0]['requiere_tercero']==1 ? $result_contra[0]['digito_verificacion']:'NULL';			
				   
		   if(!strlen(trim($numero_identificacion)) > 0 && $result_contra[0]['requiere_tercero']==1){
			  exit('No posee Numero de Identificacion el tercero Empleado');
		   }							
								   
		   if(!strlen(trim($digito_verificacion)) > 0){
			 $digito_verificacion = 'NULL';
		   }
		   
		   $centro_costo	     = $result_contra[0]['requiere_centro_costo']==1 ? $result_contra[0]['centro_de_costo_id1']:'NULL';
		   $codigo_centro_costo  = $result_contra[0]['requiere_centro_costo']==1 ? "'".$result_contra[0]['codigo_centro_costo1']."'":'NULL';



		   if($natu_contra=='D'){
			   $debito_contra=0;
			   $credito_contra=$valor_pago_ind;
		   }else{
			   $debito_contra=$valor_pago_ind;
			   $credito_contra=0;
		   }

		   if($natu_tipo=='D'){
			   $debito_pago=$valor_pago_ind;
			   $final_debito_pago=$final_debito_pago+$debito_pago;
			   $credito_pago=0;
		   }else{
			   $debito_pago=0;
			   $credito_pago=$valor_pago_ind;
			   $final_credito_pago=$final_credito_pago+$credito_pago;
		   }


		   $relacion_abono_nomina_id = $this -> DbgetMaxConsecutive("relacion_abono_nomina","relacion_abono_nomina_id",$Conex,true,1);	
		   
		   $insert_item = "INSERT INTO relacion_abono_nomina (relacion_abono_nomina_id,liquidacion_int_cesantias_id,abono_nomina_id,rel_valor_abono_nomina) 
					   VALUES ($relacion_abono_nomina_id,$causaciones,$abono_nomina_id,'$valor_pago_ind')"; 
		   $this -> query($insert_item,$Conex,true);	
   
		   $item_abono_nomina_id 	= $this -> DbgetMaxConsecutive("item_abono_nomina","item_abono_nomina_id",$Conex,true,1);	
		   
		   $debito_contra  = intVal($debito_contra);
	       $credito_contra = intVal($credito_contra);
	
		   $insert_contra = "INSERT INTO 	item_abono_nomina (
								   item_abono_nomina_id,						  
								   abono_nomina_id,
								   relacion_abono_nomina_id,
								   puc_id,
								   tercero_id,
									numero_identificacion,
								   digito_verificacion,
								   centro_de_costo_id,
								   codigo_centro_costo,
								   descripcion,
								   debito,
								   credito) 
						   VALUES (
								   $item_abono_nomina_id,
								   $abono_nomina_id,
								   $relacion_abono_nomina_id,
								   $puc_contra,
								   $tercero_id,
								   $numero_identificacion,
								   $digito_verificacion,
								   $centro_costo,
								   $codigo_centro_costo,
								   '$nombre_contra',
								   '$debito_contra',
								   '$credito_contra'
						   )"; 
		   $this -> query($insert_contra,$Conex,true);		

		}
	}


	$puc_tipo 	 = $result_tipo[0][puc_id];
	$pucnom_tipo = 'CANCELA NOMINA.: '.$result_prov[0]['empleado'];
	$natu_tipo 	 = $result_tipo[0][cuenta_tipo_pago_natu];

	$tercero_id1				= $result_tipo[0]['requiere_tercero']==1 ? $result_tipo[0]['tercero_id']:'NULL';
	$tercero_id1				= $tercero_id1>0 ? $tercero_id1 : 'NULL';
	$numero_identificacion1		= $result_tipo[0]['requiere_tercero']==1 ? $result_tipo[0]['numero_identificacion']:'NULL';
	$digito_verificacion1		= $result_tipo[0]['requiere_tercero']==1 ? $result_tipo[0]['digito_verificacion']:'NULL';			


	if(!strlen(trim($numero_identificacion1)) > 0 && $result_tipo[0]['requiere_tercero']==1){
	  exit('No posee Numero de Identificaci&oacute;n el tercero de la Empresa');
	}					
	
	if(!strlen(trim($digito_verificacion1)) > 0){
	  $digito_verificacion1 = 'NULL';
	}						
	
	$centro_costo1				= $result_tipo[0]['requiere_centro_costo']==1 ? $result_tipo[0]['centro_de_costo_id']:'NULL';
	$codigo_centro_costo1 		= $result_tipo[0]['requiere_centro_costo']==1 ? "'".$result_tipo[0]['codigo_centro_costo']."'":'NULL';

	if(!strlen(trim($centro_costo1)) > 0 && $result_tipo[0]['requiere_centro_costo']==1){
	  exit('No posee Centro de Costo esta Oficina');
	}					


	$item_abono_nomina_id 	= $this -> DbgetMaxConsecutive("item_abono_nomina","item_abono_nomina_id",$Conex,true,1);	
	
	$final_debito_pago  = intVal($final_debito_pago);
	$final_credito_pago = intVal($final_credito_pago);
	
	$insert_pago = "INSERT INTO item_abono_nomina (
							item_abono_nomina_id,						
							abono_nomina_id,
							puc_id,
							tercero_id,
							numero_identificacion,
							digito_verificacion,
							centro_de_costo_id,
							codigo_centro_costo,
							descripcion,
							debito,
							credito) 
					VALUES (
							$item_abono_nomina_id,
							$abono_nomina_id,
							$puc_tipo,
							$tercero_id1,
							$numero_identificacion1,
							$digito_verificacion1,
							$centro_costo1,
							$codigo_centro_costo1,
							'$pucnom_tipo',
							'$final_debito_pago',
							'$final_credito_pago'
					)"; 
					
	$this -> query($insert_pago,$Conex,true);		

	 if(!strlen(trim($this -> GetError())) > 0){
		$this -> Commit($Conex);		 
		return $abono_nomina_id;
	 }
	

  }
	
  public function Update($Campos,$Conex){	
    $this -> Begin($Conex);

	  if($_REQUEST['abono_nomina_id'] != 'NULL'){
		$abono_nomina_id	= $this -> requestDataForQuery('abono_nomina_id','integer');	
		$tipo_documento_id 			= $this -> requestDataForQuery('tipo_documento_id','integer');
		$fecha 						= $this -> requestDataForQuery('fecha','date');	
		$num_cheque 				= $this -> requestDataForQuery('num_cheque','text');
		
	  
	    $update = "UPDATE abono_nomina SET tipo_documento_id=$tipo_documento_id, fecha=$fecha, num_cheque=$num_cheque
					WHERE abono_nomina_id=$abono_nomina_id"; 
		$this -> query($update,$Conex,true);
	  	if(!strlen(trim($this -> GetError())) > 0){
			$this -> Commit($Conex);
		}		
	  }
  }
  
		
   public function ValidateRow($Conex,$Campos){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($Conex,"abono_nomina",$Campos);
	 return $Data -> GetData();
   }
	 	
  public function cancellation($Conex){
	 
    include_once("UtilidadesContablesModelClass.php");
	$utilidadesContables = new UtilidadesContablesModel(); 	 	 

	$this -> Begin($Conex);

	$abono_nomina_id			= $this -> requestDataForQuery('abono_nomina_id','integer');
	$causal_anulacion_id  		= $this -> requestDataForQuery('causal_anulacion_id','integer');
	$anul_abono_nomina   		= $this -> requestDataForQuery('anul_abono_nomina','text');
	$desc_anul_abono_nomina  	= $this -> requestDataForQuery('desc_anul_abono_nomina','text');
	$anul_usuario_id          	= $this -> requestDataForQuery('anul_usuario_id','integer');	
	  
	
	$select = "SELECT a.encabezado_registro_id,a.fecha,(SELECT empresa_id FROM oficina WHERE oficina_id=a.oficina_id)AS empresa_id,a.oficina_id FROM abono_nomina a WHERE a.abono_nomina_id=$abono_nomina_id";	
	$result = $this -> DbFetchAll($select,$Conex,true); 
	$encabezado_registro_id = $result[0]['encabezado_registro_id'];
	$fechaMes = $result[0]['fecha'];
	$empresa_id = $result[0]['empresa_id'];
	$oficina_id = $result[0]['oficina_id'];
	

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
				
					
						$update = "UPDATE abono_nomina  SET estado_abono_nomina= 'I',
									causal_anulacion_id = $causal_anulacion_id,
									anul_abono_nomina=$anul_abono_nomina,
									desc_anul_abono_nomina =$desc_anul_abono_nomina,
									anul_usuario_id=$anul_usuario_id
								WHERE abono_nomina_id=$abono_nomina_id";	
						$this -> query($update,$Conex,true);		
					   $this -> Commit($Conex);			
					}

				}

			}

		}
	}else{

		$update = "UPDATE abono_nomina  SET estado_abono_nomina= 'I',
					causal_anulacion_id = $causal_anulacion_id,
					anul_abono_nomina=$anul_abono_nomina,
					desc_anul_abono_nomina =$desc_anul_abono_nomina,
					anul_usuario_id=$anul_usuario_id
				WHERE abono_nomina_id=$abono_nomina_id";	
		$this -> query($update,$Conex,true);		
	    $this -> Commit($Conex);			
		
	}

  }



  public function getTotalDebitoCredito($abono_nomina_id,$Conex){
	  
	  $select = "SELECT SUM(debito) AS debito,SUM(credito) AS credito FROM item_abono_nomina   WHERE abono_nomina_id=$abono_nomina_id 	";
      $result = $this -> DbFetchAll($select,$Conex,true);


	  return $result; 
	  
  }

  public function getContabilizarReg($abono_nomina_id,$empresa_id,$oficina_id,$usuario_id,$Conex){
	 
    include_once("UtilidadesContablesModelClass.php");
	$utilidadesContables = new UtilidadesContablesModel(); 	 	 
	 
	$this -> Begin($Conex);
		
		$select 	= "SELECT a.abono_nomina_id,
						  a.valor_abono_nomina,
						  a.ingreso_abono_nomina,
						  a.fecha,
						  a.num_cheque,
						  a.encabezado_registro_id,
						  a.cuenta_tipo_pago_id,
						  a.concepto_abono_nomina,
						  IF(a.empleado_id>0,(SELECT tercero_id  FROM  empleado WHERE empleado_id=a.empleado_id),(SELECT tercero_id  FROM  empresa WHERE empresa_id=$empresa_id)) AS tercero,
						  (SELECT puc_id  FROM cuenta_tipo_pago  WHERE cuenta_tipo_pago_id=a.cuenta_tipo_pago_id) AS puc_contra,
						  a.tipo_documento_id 					  
					FROM abono_nomina a WHERE a.abono_nomina_id=$abono_nomina_id";	
		$result 	= $this -> DbFetchAll($select,$Conex,true); 

		if($result[0]['encabezado_registro_id']>0) exit('Ya esta en Proceso de Contabilizacion.<br> Por favor espere!');//validacion
		
		$encabezado_registro_id	= $this -> DbgetMaxConsecutive("encabezado_de_registro","encabezado_registro_id",$Conex,true,1);	
		
		$tipo_documento_id		= $result[0]['tipo_documento_id'];	
		
		
		$valor					= $result[0]['valor_abono_nomina'];
		$numero_soporte			= $result[0]['concepto_abono_nomina'];	
		$tercero_id				= $result[0]['tercero'];
		
		$fecha					= $result[0]['fecha'];
		$num_cheque				= $result[0]['num_cheque']!='' ? "'".$result[0]['num_cheque']."'":'NULL';
		
		
	    $fechaMes                  = substr($fecha,0,10);		
	    $periodo_contable_id       = $utilidadesContables -> getPeriodoContableId($fechaMes,$Conex);
	    $mes_contable_id           = $utilidadesContables -> getMesContableId($fechaMes,$periodo_contable_id,$Conex);

	    if(!$utilidadesContables -> periodoContableEstaHabilitado($empresa_id,$fechaMes,$Conex)) exit('Periodo Contable Cerrado');
		if(!$utilidadesContables -> mesContableEstaHabilitado($oficina_id,$fechaMes,$Conex)) exit('Mes Contable Cerrado');
		
	    $consecutivo               = $utilidadesContables -> getConsecutivo($oficina_id,$tipo_documento_id,$periodo_contable_id,$Conex);			
				
		$concepto				= $result[0]['concepto_abono_nomina'];
		$puc_id					= $result[0]['puc_contra'];
		$fecha_registro			= date("Y-m-d H:m");
		$numero_documento_fuente= $result[0]['abono_nomina_id'];
		$id_documento_fuente	= $result[0]['abono_nomina_id'];
		$con_fecha_abono_nomina= $fecha_registro;	
		$cuenta_tipo_pago_id	= $result[0][cuenta_tipo_pago_id];


		$select_usu = "SELECT CONCAT_WS(' ',t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) AS usuario FROM usuario u, tercero t 
						WHERE u.usuario_id=$usuario_id AND t.tercero_id=u.tercero_id";
		$result_usu	= $this -> DbFetchAll($select_usu,$Conex,true);		
		$modifica	= $result_usu[0]['usuario'];

		$select_pago = "SELECT forma_pago_id FROM cuenta_tipo_pago WHERE cuenta_tipo_pago_id=$cuenta_tipo_pago_id";
		$result_pago = $this -> DbFetchAll($select_pago,$Conex);		
		$forma_pago_id	= $result_pago[0]['forma_pago_id'];


		$insert="INSERT INTO encabezado_de_registro (encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,forma_pago_id,valor,numero_soporte,tercero_id,periodo_contable_id,
							mes_contable_id,consecutivo,fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,numero_documento_fuente,id_documento_fuente)
							VALUES($encabezado_registro_id,$empresa_id,$oficina_id,$tipo_documento_id,$forma_pago_id,'$valor',$num_cheque,$tercero_id,$periodo_contable_id,
							$mes_contable_id,$consecutivo,'$fecha','$concepto',$puc_id,'C','$fecha_registro','$modifica',$usuario_id,'$numero_documento_fuente',$id_documento_fuente)"; 
							
		$this -> query($insert,$Conex,true);

		$select_item = "SELECT item_abono_nomina_id FROM item_abono_nomina WHERE abono_nomina_id=$abono_nomina_id";
		$result_item = $this -> DbFetchAll($select_item,$Conex);	
		
		foreach($result_item as $result_items){

			$imputacion_contable_id	= $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,true,1);
			$insert_item ="INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,valor,base,porcentaje,formula,debito,credito)
							SELECT  $imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,$encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,(debito+credito),base,porcentaje,formula,debito,credito
							FROM item_abono_nomina WHERE abono_nomina_id=$abono_nomina_id AND item_abono_nomina_id=$result_items[item_abono_nomina_id]"; 
			$this -> query($insert_item,$Conex,true);
		}
		if(strlen($this -> GetError()) > 0){
			$this -> Rollback($Conex);
		}else{		
		
			$update = "UPDATE abono_nomina SET encabezado_registro_id=$encabezado_registro_id,	
						estado_abono_nomina= 'C',
						con_usuario_id = $usuario_id,
						con_fecha_abono_nomina='$con_fecha_abono_nomina'
					WHERE abono_nomina_id =$abono_nomina_id";	
			$this -> query($update,$Conex,true);		  




			if(strlen($this -> GetError()) > 0){
				$this -> Rollback($Conex);
				
			}else{		
				$this -> Commit($Conex);
				return true;
			}  
		}  
  }

  public function mesContableEstaHabilitado($empresa_id,$oficina_id,$ingreso_abono_factura,$Conex){
	  
      $select = "SELECT mes_contable_id,estado FROM mes_contable WHERE empresa_id = $empresa_id AND 
	                  oficina_id = $oficina_id AND '$ingreso_abono_factura' BETWEEN fecha_inicio AND fecha_final";
      $result = $this -> DbFetchAll($select,$Conex,true);
	  
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
		 $result = $this -> DbFetchAll($select,$Conex,true);		 
		 return $result[0]['estado'] == 1? true : false;		 
	   }
	  
  }  

  public function selectEstadoEncabezadoRegistro($abono_nomina_id,$Conex){
	  
    $select = "SELECT estado_abono_nomina FROM abono_nomina  WHERE abono_nomina_id = $abono_nomina_id";	  
	$result = $this -> DbFetchAll($select,$Conex,true); 
	$estado = $result[0]['estado_abono_nomina'];
	
	return $estado;	  
	  
  }
		


   public function GetQueryPagoGrid(){
	   	   
   $Query = "SELECT a.fecha, a.ingreso_abono_nomina, 
					(SELECT nombre  FROM tipo_de_documento  WHERE tipo_documento_id=a.tipo_documento_id) AS tipo_doc,	   
					(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id=a.encabezado_registro_id) AS num_ref,
					CASE a.empleados WHEN 'T' THEN 'TODOS' WHEN 'U' THEN 'UNO' ELSE '' END AS aplica,
					(SELECT CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) AS empleado FROM tercero t, empleado e WHERE e.empleado_id=a.empleado_id AND  t.tercero_id=e.tercero_id) AS empleado,
					(SELECT CONCAT_WS(' - ',(SELECT nombre FROM forma_pago WHERE forma_pago_id=c.forma_pago_id ),(SELECT CONCAT_WS(' ',codigo_puc,nombre) AS nombre FROM puc WHERE puc_id=c.puc_id )) AS text FROM cuenta_tipo_pago c WHERE c.cuenta_tipo_pago_id=a.cuenta_tipo_pago_id) AS forma_pago,
					a.concepto_abono_nomina,
					a.valor_abono_nomina,
					CASE a.estado_abono_nomina  WHEN 'A' THEN 'ACTIVA' WHEN 'I' THEN 'ANULADA' ELSE 'CONTABILIZADA' END AS	estado_abono_nomina
			FROM abono_nomina a
		 ORDER BY a.fecha DESC LIMIT 0,1000";
		
   return $Query;
   }
}

?>
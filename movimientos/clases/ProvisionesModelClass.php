<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ProvisionesModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
    


  public function SaveTodos($oficina_id,$usuario_id,$Campos,$dias1,$Conex){
	
	$this -> assignValRequest('usuario_id',$usuario_id);
	$this -> assignValRequest('fecha_registro',date('Y-m-d H:i'));
	$fecha_inicial = $_REQUEST['fecha_inicial'];
	$fecha_final = $_REQUEST['fecha_final'];
	$anio = substr($_REQUEST['fecha_final'],0,4);
	$consecutivo = $this -> DbgetMaxConsecutive("liquidacion_provision","consecutivo",$Conex,false,1);
	$this -> assignValRequest('consecutivo',$consecutivo);

	$deb_total=0;
	$cre_total=0;
	$dias_total = $dias1;

	$select_per = "SELECT * FROM datos_periodo
			WHERE periodo_contable_id = (SELECT periodo_contable_id FROM periodo_contable WHERE anio=$anio)";
	$result_per = $this -> DbFetchAll($select_per,$Conex,true);
	
	$puc_contra_cesan_id   = $result_per[0]['puc_contra_cesan_id'];
	$puc_contra_incesan_id = $result_per[0]['puc_contra_incesan_id'];
	$puc_contra_vaca_id    = $result_per[0]['puc_contra_vaca_id'];
	$puc_contra_prima_id   = $result_per[0]['puc_contra_prima_id'];

	$limite_subsidio=$result_per[0]['limite_subsidio'];
	$limite_fondo=$result_per[0]['limite_fondo'];
	$salrio=$result_per[0]['salrio'];
	$salrio_diario=intval($result_per[0]['salrio']/30);	
	$limite_sal = $salrio*$limite_subsidio;
	$limite_fondopen = $salrio*$limite_fondo;
	$horas_dia=$result_per[0]['horas_dia'];
	$val_hr_ext_diurna=$result_per[0]['val_hr_ext_diurna'];	
	$val_hr_ext_nocturna=$result_per[0]['val_hr_ext_nocturna'];	
	$val_hr_ext_festiva_diurna=$result_per[0]['val_hr_ext_festiva_diurna'];	
	$val_hr_ext_festiva_nocturna=$result_per[0]['val_hr_ext_festiva_nocturna'];	
	$val_recargo_nocturna=$result_per[0]['val_recargo_nocturna'];


	$this -> Begin($Conex);
	$liquidacion_provision_id = $this -> DbgetMaxConsecutive("liquidacion_provision","liquidacion_provision_id",$Conex,false,1);
	$this -> assignValRequest('liquidacion_provision_id',$liquidacion_provision_id);
	$this -> DbInsertTable("liquidacion_provision",$Campos,$Conex,true,false);

	$select = "SELECT  l.*, c.*, 
			(SELECT SUM((DATEDIFF(IF(l.fecha_final>'$fecha_final','$fecha_final',l.fecha_final),IF(l.fecha_inicial>'$fecha_inicial',l.fecha_inicial,'$fecha_inicial')))) 
			FROM licencia l WHERE l.remunerado=0 AND  l.contrato_id=c.contrato_id AND ('$fecha_inicial' BETWEEN  l.fecha_inicial AND l.fecha_final OR '$fecha_final'  BETWEEN  l.fecha_inicial AND l.fecha_final OR l.fecha_inicial BETWEEN '$fecha_inicial' AND '$fecha_final') )  AS dias_lice_nore,
			
			((SELECT DATEDIFF(IF(l.fecha_final>'$fecha_final','$fecha_final',l.fecha_final),
			IF(l.fecha_inicial < c.fecha_inicio,c.fecha_inicio,l.fecha_inicial))))as dias_real,
			
			(SELECT dias FROM detalle_liquidacion_novedad WHERE liquidacion_novedad_id=l.liquidacion_novedad_id AND sueldo_pagar=1) AS dias,
			(SELECT CONCAT_WS(' ',t.primer_nombre,t.primer_apellido) FROM empleado e, tercero t WHERE e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id) AS empleado,
			c.centro_de_costo_id,(SELECT cc.codigo FROM  centro_de_costo cc WHERE  cc.centro_de_costo_id=c.centro_de_costo_id ) AS codigo_centro					
   			FROM liquidacion_novedad l, contrato c, tipo_contrato t
			WHERE l.estado='C' AND l.fecha_inicial='$fecha_inicial' AND l.fecha_final='$fecha_final' AND c.contrato_id=l.contrato_id AND t.tipo_contrato_id=c.tipo_contrato_id AND t.prestaciones_sociales=1";
	$result = $this -> DbFetchAll($select,$Conex,true);
	 

	
	

	$select_cc = "SELECT 	centro_de_costo_id, codigo FROM centro_de_costo	WHERE oficina_id=$oficina_id";
	$result_cc	= $this -> DbFetchAll($select_cc,$Conex);				

	if($result_cc[0]['centro_de_costo_id']>0){
		$centro_de_costo_id=$result_cc[0]['centro_de_costo_id'];
		$codigo_centro=$result_cc[0]['codigo'];
	}else{
		exit('No existe Centro de Costo para la oficina Actual');			
	}

	for($i=0;$i<count($result);$i++){	
	
		if($result[$i]['area_laboral']=='A'){
			$puc_cesan=$result_per[0]['puc_admon_cesan_id'];
			$puc_incesan=$result_per[0]['puc_admon_incesan_id'];
			$puc_vaca=$result_per[0]['puc_admon_vaca_id'];
			$puc_prima=$result_per[0]['puc_admon_prima_id'];
			
			
		}elseif($result[$i]['area_laboral']=='O'){
			
			$puc_cesan=$result_per[0]['puc_produ_cesan_id'];
			$puc_incesan=$result_per[0]['puc_produ_incesan_id'];
			$puc_vaca=$result_per[0]['puc_produ_vaca_id'];
			$puc_prima=$result_per[0]['puc_produ_prima_id'];

			
		}elseif($result[$i]['area_laboral']=='C'){

			$puc_cesan=$result_per[0]['puc_ventas_cesan_id'];
			$puc_incesan=$result_per[0]['puc_ventas_incesan_id'];
			$puc_vaca=$result_per[0]['puc_ventas_vaca_id'];
			$puc_prima=$result_per[0]['puc_ventas_prima_id'];


		}else{
			
			$puc_cesan='';
			$puc_incesan='';
			$puc_vaca='';
			$puc_prima='';
			exit('No Ha parametrizado Area para el contrato No '.$result[$i]['numero_contrato']);
		}
		

		$contrato_id =  $result[$i]['contrato_id'];
		$sueldo_base =$result[$i]['sueldo_base'];
		$subsidio_transporte = $result[$i]['subsidio_transporte'];
		//$dias =  $result[$i]['dias'];

		
		
		$dias_real = $result[$i]['dias'] > $result[$i]['dias_real'] ? $result[$i]['dias']: $result[$i]['dias_real'] ;

		$dias = $dias_real-$result[$i]['dias_lice_nore'];
		//$dias = $result[$i]['dias_real']-$result[$i]['dias_lice_nore'];
		//$dias = $dias_total-$result[$i]['dias_lice_nore'];
		$liquidacion_novedad_id=$result[$i]['liquidacion_novedad_id'];
		$empleado=$result[$i]['empleado'];
		
		$centro_de_costo_idg =  $result[$i]['centro_de_costo_id'];
		$codigo_centrog =  $result[$i]['codigo_centro'];

		//revisar dias incapacidad
		$select_inca = "SELECT (DATEDIFF(IF(l.fecha_final>'$fecha_final','$fecha_final',l.fecha_final),IF(l.fecha_inicial>'$fecha_inicial',l.fecha_inicial,'$fecha_inicial'))+1) AS dias_inca, ti.dia, ti.porcentaje,ti.descuento  
					FROM licencia l, tipo_incapacidad ti WHERE  l.contrato_id=$contrato_id AND ti.tipo_incapacidad_id=l.tipo_incapacidad_id AND ti.tipo='I'  AND ('$fecha_inicial' BETWEEN  l.fecha_inicial AND l.fecha_final OR '$fecha_final'  BETWEEN  l.fecha_inicial AND l.fecha_final OR l.fecha_inicial BETWEEN '$fecha_inicial' AND '$fecha_final') ";
		$result_inca = $this -> DbFetchAll($select_inca,$Conex,true);
		$dias_inca=0;
		$dia_difinc=0;
		$sal_dia_cont=intval($sueldo_base/30);
		$des_val_inc=0;
		for($l=0;$l<count($result_inca);$l++){
			if($result_inca[$l]['dias_inca']>=$result_inca[$l]['dia'] && $result_inca[$l]['descuento']=='S' ){
				$dia_difinc = (($result_inca[$l]['dias_inca']-$result_inca[$l]['dia'])+1);
				$pago_desc=intval(($sal_dia_cont*$result_inca[$l]['porcentaje'])/100);
				$por_desc=(100-$result_inca[$l]['porcentaje']);
				if($pago_desc>$salrio_diario){
					
					$des_val_inc = ($des_val_inc + intval((($sal_dia_cont*$dia_difinc)*$por_desc)/100));
					
				}else{
					
					$des_val_inc = ($des_val_inc + intval(($sal_dia_cont-$salrio_diario)*$dia_difinc));
				} 
			}
			$dias_inca_sub=$dias_inca_sub+$result_inca[$l]['dias_inca'];			
		}
		
		
		//sumatoria devengados
		$selectdeve = "SELECT  SUM(n.valor_cuota) AS valor_deven
				FROM novedad_fija n, concepto_area c
				WHERE n.contrato_id=$contrato_id AND n.tipo_novedad='V'  AND n.estado='A' AND '$fecha_final' BETWEEN  n.fecha_inicial AND n.fecha_final AND c.concepto_area_id=n.concepto_area_id AND c.base_salarial='SI'";
		$resultdeve = $this -> DbFetchAll($selectdeve,$Conex,true);
		$valor_deven = $resultdeve[0]['valor_deven']>0 ? $resultdeve[0]['valor_deven'] : 0;
		//sumatoria  extras
		/*$selectext = "SELECT  
				((((($sueldo_base/$horas_dia)*$val_hr_ext_diurna)/100)*SUM(horas_diurnas))) AS valor_diurnas,
				((((($sueldo_base/$horas_dia)*$val_hr_ext_nocturna)/100)*SUM(horas_nocturnas))) AS valor_nocturnas,				
				((((($sueldo_base/$horas_dia)*$val_hr_ext_festiva_diurna)/100)*SUM(horas_diurnas_fes))) AS valor_diurnas_fes,								
				((((($sueldo_base/$horas_dia)*$val_hr_ext_festiva_nocturna)/100)*SUM(horas_nocturnas_fes))) AS valor_nocturnas_fes,		
				((((($sueldo_base/$horas_dia)*$val_recargo_nocturna)/100)*SUM(horas_recargo_noc))) AS valor_recargo_noc																
				FROM 	hora_extra h
				WHERE h.contrato_id=$contrato_id AND h.estado='P' AND h.fecha_inicial>='$fecha_inicial' AND h.fecha_final<='$fecha_final' ";*/
				
				$selectext = "SELECT  
					SUM(h.vr_horas_diurnas) AS valor_diurnas,
					SUM(h.vr_horas_nocturnas) AS valor_nocturnas,
					SUM(h.vr_horas_diurnas_fes) AS valor_diurnas_fes,
					SUM(h.vr_horas_nocturnas_fes) AS valor_nocturnas_fes,
					SUM(h.vr_horas_recargo_noc) AS valor_recargo_noc,
					SUM(h.vr_horas_recargo_doc) AS valor_recargo_doc
					
					FROM 	hora_extra h
					WHERE h.contrato_id=$contrato_id AND h.estado='L' AND h.fecha_inicial>='$fecha_inicial' AND h.fecha_final<='$fecha_final' ";			
					
			$resultext = $this -> DbFetchAll($selectext,$Conex,true); 
		
		
		$valor_diurnas = $resultext[0]['valor_diurnas']>0 ? $resultext[0]['valor_diurnas'] : 0;
		$valor_nocturnas = $resultext[0]['valor_nocturnas']>0 ? $resultext[0]['valor_nocturnas'] : 0;			
		$valor_diurnas_fes = $resultext[0]['valor_diurnas_fes']>0 ? $resultext[0]['valor_diurnas_fes'] : 0;
		$valor_nocturnas_fes = $resultext[0]['valor_nocturnas_fes']>0 ? $resultext[0]['valor_nocturnas_fes'] : 0;			
		$valor_recargo_noc = $resultext[0]['valor_recargo_noc']>0 ? $resultext[0]['valor_recargo_noc'] : 0;		
		$valor_recargo_doc = $resultext[0]['valor_recargo_doc']>0 ? $resultext[0]['valor_recargo_doc'] : 0;		

		$subsidio_base = ($subsidio_transporte/30)*($dias-$dias_inca_sub);
		
		$total_base=($subsidio_base+$valor_deven+$valor_diurnas+$valor_nocturnas+$valor_diurnas_fes+$valor_nocturnas_fes+$valor_recargo_noc+$valor_recargo_doc)-$des_val_inc;

		//cesantias
		$por_cesan = $result_per[0]['desc_empre_cesantias'];
		$valor_cesan=intval(intval(((($sueldo_base)/30)*$dias)+$total_base)*($por_cesan/100));
		
		
		
		$debito=$valor_cesan;
		$credito=0;

		$detalle_liquidacion_provision_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_provision","detalle_liquidacion_provision_id",$Conex,false,1);
		$insert = "INSERT INTO 	detalle_liquidacion_provision (detalle_liquidacion_provision_id,puc_id,liquidacion_provision_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,concepto,centro_de_costo_id,codigo_centro_costo) 
		VALUES ($detalle_liquidacion_provision_id,$puc_cesan,$liquidacion_provision_id,$liquidacion_novedad_id, $debito,$credito,'$fecha_inicial','$fecha_final',$dias,'CAUS. CESANTIAS $empleado',$centro_de_costo_idg,'$codigo_centrog')";
		$this -> query($insert,$Conex,true);

		$debito=0;
		$credito=$valor_cesan;

		$detalle_liquidacion_provision_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_provision","detalle_liquidacion_provision_id",$Conex,false,1);
		$insert = "INSERT INTO 	detalle_liquidacion_provision (detalle_liquidacion_provision_id,puc_id,liquidacion_provision_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,concepto,centro_de_costo_id,codigo_centro_costo) 
		VALUES ($detalle_liquidacion_provision_id,$puc_contra_cesan_id,$liquidacion_provision_id,$liquidacion_novedad_id, $debito,$credito,'$fecha_inicial','$fecha_final',$dias,'CAUS. CESANTIAS $empleado',$centro_de_costo_id,'$codigo_centro')";
		$this -> query($insert,$Conex,true);


		//interes cesantias
		$por_intcesan = $result_per[0]['desc_empre_int_cesantias'];
		///$valor_intcesan=intval($valor_cesan*($por_intcesan/100));
		$valor_intcesan=intval((((($sueldo_base)*$dias)+$total_base)*($por_intcesan/100))/360);
		$debito=$valor_intcesan;
		$credito=0;

		$detalle_liquidacion_provision_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_provision","detalle_liquidacion_provision_id",$Conex,false,1);
		$insert = "INSERT INTO 	detalle_liquidacion_provision (detalle_liquidacion_provision_id,puc_id,liquidacion_provision_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,concepto,centro_de_costo_id,codigo_centro_costo) 
		VALUES ($detalle_liquidacion_provision_id,$puc_incesan,$liquidacion_provision_id,$liquidacion_novedad_id, $debito,$credito,'$fecha_inicial','$fecha_final',$dias,'INTERES CESANTIAS $empleado',$centro_de_costo_idg,'$codigo_centrog')";
		$this -> query($insert,$Conex,true);

		$debito=0;
		$credito=$valor_intcesan;

		$detalle_liquidacion_provision_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_provision","detalle_liquidacion_provision_id",$Conex,false,1);
		$insert = "INSERT INTO 	detalle_liquidacion_provision (detalle_liquidacion_provision_id,puc_id,liquidacion_provision_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,concepto,centro_de_costo_id,codigo_centro_costo) 
		VALUES ($detalle_liquidacion_provision_id,$puc_contra_incesan_id,$liquidacion_provision_id,$liquidacion_novedad_id, $debito,$credito,'$fecha_inicial','$fecha_final',$dias,'INTERES CESANTIAS $empleado',$centro_de_costo_id,'$codigo_centro')";
		$this -> query($insert,$Conex,true);


		//prima servicios  
		$por_prima = $result_per[0]['desc_empre_prima_serv'];
		$valor_prima=intval(intval(((($sueldo_base)/30)*$dias)+$total_base)*($por_prima/100));
		$debito=$valor_prima;
		$credito=0;

		$detalle_liquidacion_provision_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_provision","detalle_liquidacion_provision_id",$Conex,false,1);
		$insert = "INSERT INTO 	detalle_liquidacion_provision (detalle_liquidacion_provision_id,puc_id,liquidacion_provision_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,concepto,centro_de_costo_id,codigo_centro_costo) 
		VALUES ($detalle_liquidacion_provision_id,$puc_prima,$liquidacion_provision_id,$liquidacion_novedad_id, $debito,$credito,'$fecha_inicial','$fecha_final',$dias,'CAUS. PRIMA $empleado',$centro_de_costo_idg,'$codigo_centrog')";
		$this -> query($insert,$Conex,true);

		$debito=0;
		$credito=$valor_prima;

		$detalle_liquidacion_provision_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_provision","detalle_liquidacion_provision_id",$Conex,false,1);
		$insert = "INSERT INTO 	detalle_liquidacion_provision (detalle_liquidacion_provision_id,puc_id,liquidacion_provision_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,concepto,centro_de_costo_id,codigo_centro_costo) 
		VALUES ($detalle_liquidacion_provision_id,$puc_contra_prima_id,$liquidacion_provision_id,$liquidacion_novedad_id, $debito,$credito,'$fecha_inicial','$fecha_final',$dias,'CAUS. PRIMA $empleado',$centro_de_costo_id,'$codigo_centro')";
		$this -> query($insert,$Conex,true);


		//vacaciones  
		
		$total_base_vac =($valor_deven+$valor_diurnas+$valor_nocturnas+$valor_diurnas_fes+$valor_nocturnas_fes+$valor_recargo_noc)-$des_val_inc;


		$por_vaca = $result_per[0]['desc_empre_vacaciones'];
		$valor_vaca=intval(intval(((($sueldo_base)/30)*$dias)+($total_base_vac))*($por_vaca/100));

		
		$debito=$valor_vaca;
		$credito=0;

		$detalle_liquidacion_provision_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_provision","detalle_liquidacion_provision_id",$Conex,false,1);
		$insert = "INSERT INTO 	detalle_liquidacion_provision (detalle_liquidacion_provision_id,puc_id,liquidacion_provision_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,concepto,centro_de_costo_id,codigo_centro_costo) 
		VALUES ($detalle_liquidacion_provision_id,$puc_vaca,$liquidacion_provision_id,$liquidacion_novedad_id, $debito,$credito,'$fecha_inicial','$fecha_final',$dias,'CAUS. VACACIONES $empleado',$centro_de_costo_idg,'$codigo_centrog')";
		$this -> query($insert,$Conex,true);

		$debito=0;
		$credito=$valor_vaca;

		$detalle_liquidacion_provision_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_provision","detalle_liquidacion_provision_id",$Conex,false,1);
		$insert = "INSERT INTO 	detalle_liquidacion_provision (detalle_liquidacion_provision_id,puc_id,liquidacion_provision_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,concepto,centro_de_costo_id,codigo_centro_costo) 
		VALUES ($detalle_liquidacion_provision_id,$puc_contra_vaca_id,$liquidacion_provision_id,$liquidacion_novedad_id, $debito,$credito,'$fecha_inicial','$fecha_final',$dias,'CAUS. VACACIONES $empleado',$centro_de_costo_id,'$codigo_centro')";
		$this -> query($insert,$Conex,true);

		
	}
			
	$this -> Commit($Conex);
	
	return array(array(liquidacion_provision_id=>$liquidacion_provision_id));
  }

  

  //BUSQUEDA

  public function selectLiquidacion($liquidacion_provision_id,$Conex){
    				
   $select = "SELECT l.fecha_inicial,l.fecha_final,l.liquidacion_provision_id,l.estado,l.consecutivo, l.*
   			FROM liquidacion_provision l
			WHERE l.liquidacion_provision_id=$liquidacion_provision_id";
				
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	
	return $result;
  }


  public function comprobar_estado($liquidacion_provision_id,$Conex){
    				
   $select = "SELECT l.estado,l.encabezado_registro_id,l.consecutivo, l.encabezado_registro_id,l.fecha_inicial,l.fecha_final,
   			(SELECT p.estado  FROM encabezado_de_registro e,	periodo_contable p 
			 WHERE e.encabezado_registro_id=l.encabezado_registro_id AND p.periodo_contable_id=e.periodo_contable_id) AS estado_periodo,
			(SELECT p.estado  FROM encabezado_de_registro e,	mes_contable p 
			 WHERE e.encabezado_registro_id=l.encabezado_registro_id AND p.mes_contable_id=e.mes_contable_id) AS estado_mes			
   			FROM liquidacion_provision l
			WHERE l.liquidacion_provision_id=$liquidacion_provision_id";
				
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	
	return $result;
  }


  public function ComprobarLiquidacionNovedad($fecha_inicial,$fecha_final,$Conex){
    				
   $select = "SELECT  l.liquidacion_novedad_id
   			FROM liquidacion_novedad l
			WHERE l.estado='C' AND l.fecha_inicial='$fecha_inicial' AND l.fecha_final='$fecha_final' ";
				
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	
	return $result;
  }

  public function ComprobarLiquidacionT($fecha_inicial,$fecha_final,$Conex){
    				
   $select = "SELECT  liquidacion_provision_id, consecutivo
   			FROM liquidacion_provision 
			WHERE  estado!='A' AND fecha_inicial='$fecha_inicial' AND fecha_final='$fecha_final' ";//(fecha_inicial BETWEEN '$fecha_inicial' AND '$fecha_final' OR fecha_final BETWEEN '$fecha_inicial' AND '$fecha_final') 
				
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	
	return $result;
  }

  public function cancellation($liquidacion_provision_id,$encabezado_registro_id,$causal_anulacion_id,$observacion_anulacion,$usuario_anulo_id,$Conex){
  
   $this -> Begin($Conex);
  
     $update = "UPDATE liquidacion_provision SET estado = 'A',causal_anulacion_id = $causal_anulacion_id,observacion_anulacion = $observacion_anulacion,
	 fecha_anulacion = NOW(),usuario_anulo_id = $usuario_anulo_id WHERE liquidacion_provision_id = $liquidacion_provision_id";
	 $this -> query($update,$Conex,true);
	 
	 if($encabezado_registro_id>0){

		$insert = "INSERT INTO encabezado_de_registro_anulado SELECT $encabezado_registro_id AS 
		encabezado_de_registro_anulado_id,encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,
		forma_pago_id,valor,numero_soporte,tercero_id,periodo_contable_id,mes_contable_id,consecutivo,
		fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,$causal_anulacion_id AS causal_anulacion_id,
		$observacion_anulacion AS observaciones FROM encabezado_de_registro WHERE encabezado_registro_id = $encabezado_registro_id";
		$this -> query($insert,$Conex,true);
	
		$insert = "INSERT INTO imputacion_contable_anulada SELECT  imputacion_contable_id AS  
		imputacion_contable_anulada_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id AS 
		encabezado_registro_anulado_id,centro_de_costo_id,codigo_centro_costo,numero,valor,amortiza,deprecia,base,porcentaje,formula,debito,credito FROM 
		imputacion_contable WHERE encabezado_registro_id = $encabezado_registro_id";
		
		$update = "UPDATE encabezado_de_registro SET estado = 'A',anulado = 1 WHERE encabezado_registro_id = $encabezado_registro_id";	  
		$this -> query($update,$Conex,true);	
			  
		$update = "UPDATE imputacion_contable SET debito = 0,credito = 0 WHERE encabezado_registro_id=$encabezado_registro_id";
		$this -> query($update,$Conex,true);			  
				
	 }
	 
     $this -> Commit($Conex);
  
  }    


	public function getCausalesAnulacion($Conex){
		
		$select = "SELECT causal_anulacion_id AS value,nombre AS text FROM causal_anulacion WHERE documento!='RM' ORDER BY nombre";
		$result = $this -> DbFetchAll($select,$Conex);		
		return $result;				
	}  


  public function getTotalDebitoCredito($liquidacion_provision_id,$Conex){
	  
	  $select = "SELECT SUM(debito) AS debito,SUM(credito) AS credito
	  FROM detalle_liquidacion_provision  WHERE liquidacion_provision_id=$liquidacion_provision_id";

      $result = $this -> DbFetchAll($select,$Conex);
	  
	  return $result; 
	  
  }


  public function getContabilizarReg($liquidacion_provision_id,$empresa_id,$oficina_id,$usuario_id,$mesContable,$periodoContable,$Conex){//contabilizar uno
	 
    include_once("UtilidadesContablesModelClass.php");
	  
	$utilidadesContables = new UtilidadesContablesModel(); 	 
	 
	$this -> Begin($Conex);
		
		$select 	= "SELECT f.*, d.*,
					(SELECT tipo_documento_id FROM datos_periodo WHERE periodo_contable_id =(SELECT periodo_contable_id FROM periodo_contable WHERE anio=YEAR(DATE(f.fecha_inicial)) ) ) AS tipo_documento_id,
					(SELECT SUM(debito) FROM detalle_liquidacion_provision WHERE liquidacion_provision_id=f.liquidacion_provision_id) AS valor,
					
					(SELECT t.numero_identificacion FROM contrato c, empleado e, tercero t WHERE c.contrato_id=l.contrato_id AND e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id) AS numero_identificacion,
					(SELECT t.digito_verificacion FROM contrato c, empleado e, tercero t WHERE c.contrato_id=l.contrato_id AND e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id) AS digito_verificacion,					
					(SELECT e.tercero_id FROM contrato c, empleado e WHERE c.contrato_id=l.contrato_id AND e.empleado_id=c.empleado_id ) AS tercero_id,

					(SELECT c.centro_de_costo_id FROM contrato c WHERE c.contrato_id=l.contrato_id  ) AS centro_de_costo_id,
					(SELECT cc.codigo FROM contrato c, centro_de_costo cc WHERE c.contrato_id=l.contrato_id AND cc.centro_de_costo_id=c.centro_de_costo_id ) AS codigo_centro					
					FROM liquidacion_provision f, detalle_liquidacion_provision d, liquidacion_novedad l	 
					WHERE f.liquidacion_provision_id=$liquidacion_provision_id AND d.liquidacion_provision_id=f.liquidacion_provision_id AND l.liquidacion_novedad_id=d.liquidacion_novedad_id";	
					
		$result 	= $this -> DbFetchAll($select,$Conex); 
		

		$select_emp = "SELECT tercero_id FROM empresa	WHERE empresa_id=$empresa_id";
		$result_emp	= $this -> DbFetchAll($select_emp,$Conex);				

		$select_cc = "SELECT 	centro_de_costo_id, codigo FROM centro_de_costo	WHERE oficina_id=$oficina_id";
		$result_cc	= $this -> DbFetchAll($select_cc,$Conex);				

		$select_usu = "SELECT CONCAT_WS(' ',t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) AS usuario FROM usuario u, tercero t 
						WHERE u.usuario_id=$usuario_id AND t.tercero_id=u.tercero_id";
		$result_usu	= $this -> DbFetchAll($select_usu,$Conex);				

		$encabezado_registro_id	= $this -> DbgetMaxConsecutive("encabezado_de_registro","encabezado_registro_id",$Conex,true,1);	
		$tipo_documento_id		= $result[0]['tipo_documento_id'];	
		$valor					= $result[0]['valor'];
		$numero_soporte			= $result[0]['consecutivo'];	
		$tercero_id				= $result_emp[0]['tercero_id'];

		$centro_de_costo_id1	= $result[0]['centro_de_costo_id'];
		$codigo_centro1			= $result[0]['codigo_centro'];		

		
		if($result_cc[0]['centro_de_costo_id']>0){
			$centro_de_costo_id=$result_cc[0]['centro_de_costo_id'];
			$codigo=$result_cc[0]['codigo'];
		}else{
			exit('No existe Centro de Costo para la oficina Actual');			
		}
		
	    $fechaMes                  = substr($result[0]['fecha_final'],0,10);		
	    $periodo_contable_id       = $utilidadesContables -> getPeriodoContableId($fechaMes,$Conex);
	    $mes_contable_id           = $utilidadesContables -> getMesContableId($fechaMes,$periodo_contable_id,$Conex);
	    $consecutivo               = $utilidadesContables -> getConsecutivo($oficina_id,$tipo_documento_id,$periodo_contable_id,$Conex);		
		
		$fecha					= $result[0]['fecha_final'];
		$concepto				= 'PROVISIONES '.$result[0]['fecha_inicial'].' AL '.$result[0]['fecha_final'];
		$puc_id					= 'NULL';
		$fecha_registro			= date("Y-m-d H:m");
		$modifica				= $result_usu[0]['usuario'];
		$fuente_servicio_cod	= 'NO';
		$numero_documento_fuente= $consecutivo;
		$id_documento_fuente	= $result[0]['liquidacion_provision_id'];


		$insert="INSERT INTO encabezado_de_registro (encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,valor,numero_soporte,tercero_id,periodo_contable_id,
							mes_contable_id,consecutivo,fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,fuente_servicio_cod,numero_documento_fuente,id_documento_fuente)
							VALUES($encabezado_registro_id,$empresa_id,$oficina_id,$tipo_documento_id,'$valor','$numero_soporte',$tercero_id,$periodo_contable_id,
							$mes_contable_id,$consecutivo,'$fecha','$concepto',$puc_id,'C','$fecha_registro','$modifica',$usuario_id,'$fuente_servicio_cod','$numero_documento_fuente',$id_documento_fuente)"; 
		$this -> query($insert,$Conex,true);
		
		for($i=0;$i<count($result); $i++){

			$terceroid				= $result[$i]['tercero_id'];
			$numero_identificacion	= $result[$i]['numero_identificacion'];
			$digito_verificacion	= $result[$i]['digito_verificacion']!='' ? $result[$i]['digito_verificacion'] : 'NULL';	
			$detalle_liquidacion_provision_id = $result[$i]['detalle_liquidacion_provision_id'];

			$imputacion_contable_id 	= $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,true,1);
			$insert_item ="INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,valor,debito,credito)
							SELECT  $imputacion_contable_id,$terceroid,$numero_identificacion,$digito_verificacion,puc_id,concepto,$encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,(debito+credito),debito,credito
							FROM detalle_liquidacion_provision WHERE liquidacion_provision_id=$liquidacion_provision_id AND detalle_liquidacion_provision_id=$detalle_liquidacion_provision_id"; 
			
			$this -> query($insert_item,$Conex,true);			
		}
		
		$update = "UPDATE liquidacion_provision SET encabezado_registro_id=$encabezado_registro_id,	
					estado= 'C',
					con_usuario_id = $usuario_id,
					con_fecha='$fecha_registro'
				WHERE liquidacion_provision_id=$liquidacion_provision_id";	
		$this -> query($update,$Conex,true);		  
			
		if(strlen($this -> GetError()) > 0){
			$this -> Rollback($Conex);
			
		}else{		
			$this -> Commit($Conex);
			return $encabezado_registro_id;
		}  
  }




  public function mesContableEstaHabilitado($empresa_id,$oficina_id,$fecha_factura_proveedor,$Conex){
	  
      $select = "SELECT mes_contable_id,estado FROM mes_contable WHERE empresa_id = $empresa_id AND 
	                  oficina_id = $oficina_id AND '$fecha_factura_proveedor' BETWEEN fecha_inicio AND fecha_final";
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

  //// GRID ////   
  public function getQueryProvisionesGrid(){
	 
	 $Query = "SELECT
	 				l.consecutivo,
					l.fecha_inicial,
					l.fecha_final,
					(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id=l.encabezado_registro_id)	AS doc_contable,
					CASE l.estado WHEN 'A' THEN 'ANULADO' WHEN 'C' THEN 'CONTABILIZADO' WHEN 'E' THEN 'EDICION' ELSE '' END AS estado
	 			FROM liquidacion_provision l ORDER BY l.fecha_inicial DESC LIMIT 0,1000";
	 
     return $Query;
   }
      
   
}


?>
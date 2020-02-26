<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class RegistrarModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }

  public function validarContratos($fecha_inicial,$fecha_final,$Conex){
	
	$contrato_id = $_REQUEST['contrato_id'];

	if($contrato_id > 0){
		$consulta = 'AND c.contrato_id ='.$contrato_id;
	}else{
		$consulta ='';
	}

	$select="SELECT c.numero_contrato,
	         (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM tercero t,empleado e WHERE t.tercero_id=e.tercero_id AND e.empleado_id=c.empleado_id) AS empleado
	         FROM contrato c WHERE c.estado = 'A' AND c.fecha_terminacion BETWEEN '$fecha_inicial' AND '$fecha_final' $consulta";
	$result = $this -> DbFetchAll($select,$Conex,true);

	return $result;

  }
  


  public function Save($usuario_id,$Campos,$dias,$dias_real,$previsual,$Conex){

    $liquidacion_novedad_id = $this -> DbgetMaxConsecutive("liquidacion_novedad","liquidacion_novedad_id",$Conex,false,1);
	$consecutivo            = $this -> DbgetMaxConsecutive("liquidacion_novedad","consecutivo",$Conex,false,1);
	$this -> assignValRequest('consecutivo',$consecutivo);
	$this -> assignValRequest('liquidacion_novedad_id',$liquidacion_novedad_id);
	$this -> assignValRequest('usuario_id',$usuario_id);
	$this -> assignValRequest('fecha_registro',date('Y-m-d H:i'));

	$fecha_inicial   = $_REQUEST['fecha_inicial'];
	$fecha_final     = $_REQUEST['fecha_final'];
	$anio            = substr($_REQUEST['fecha_final'],0,4);
	$contrato_id     = $_REQUEST['contrato_id'];

	
	$deb_total=0;
	$cre_total=0;
	$dias_total = $dias;

	$select_per = "SELECT * FROM datos_periodo
			WHERE periodo_contable_id = (SELECT periodo_contable_id FROM periodo_contable WHERE anio=$anio)";
	$result_per = $this -> DbFetchAll($select_per,$Conex,true);
	
	$limite_subsidio            = $result_per[0]['limite_subsidio'];
	$limite_fondo	            = $result_per[0]['limite_fondo'];
	$salrio			            = $result_per[0]['salrio'];
	$salrio_diario	            = intval($result_per[0]['salrio']/30);
	$limite_sal 	            = $salrio*$limite_subsidio;
	$limite_fondopen            = $salrio*$limite_fondo;
	$horas_dia		            = $result_per[0]['horas_dia'];
	$val_hr_ext_diurna          = $result_per[0]['val_hr_ext_diurna'];	
	$val_hr_ext_nocturna        = $result_per[0]['val_hr_ext_nocturna'];	
	$val_hr_ext_festiva_diurna  = $result_per[0]['val_hr_ext_festiva_diurna'];	
	$val_hr_ext_festiva_nocturna= $result_per[0]['val_hr_ext_festiva_nocturna'];	
	$val_recargo_nocturna       = $result_per[0]['val_recargo_nocturna'];

	$select = "SELECT  c.*, t.prestaciones_sociales, t.salud,
			IF(c.fecha_inicio BETWEEN '$fecha_inicial'  AND '$fecha_final',DATEDIFF(CONCAT_WS(' ',c.fecha_inicio,'23:59:59'),'$fecha_inicial'),0) AS dias_desc,
			(SELECT SUM((DATEDIFF(IF(l.fecha_final>'$fecha_final','$fecha_final',l.fecha_final),IF(l.fecha_inicial>'$fecha_inicial',l.fecha_inicial,'$fecha_inicial'))+1)) 
			FROM licencia l, tipo_incapacidad ti WHERE l.remunerado=1 AND l.estado!='I' AND  l.contrato_id=c.contrato_id AND ti.tipo_incapacidad_id=l.tipo_incapacidad_id AND ti.tipo='L' AND ('$fecha_inicial' BETWEEN  l.fecha_inicial AND l.fecha_final OR '$fecha_final'  BETWEEN  l.fecha_inicial AND l.fecha_final OR l.fecha_inicial BETWEEN '$fecha_inicial' AND '$fecha_final') )  AS dias_lice_re,
			(SELECT SUM((DATEDIFF(IF(l.fecha_final>'$fecha_final','$fecha_final',l.fecha_final),IF(l.fecha_inicial>'$fecha_inicial',l.fecha_inicial,'$fecha_inicial'))+1)) 
			FROM licencia l, tipo_incapacidad ti WHERE l.remunerado=0 AND l.estado!='I' AND  l.contrato_id=c.contrato_id AND ti.tipo_incapacidad_id=l.tipo_incapacidad_id AND ti.tipo='L' AND ('$fecha_inicial' BETWEEN  l.fecha_inicial AND l.fecha_final OR '$fecha_final'  BETWEEN  l.fecha_inicial AND l.fecha_final OR l.fecha_inicial BETWEEN '$fecha_inicial' AND '$fecha_final') )  AS dias_lice_nore,

			(SELECT e.tercero_id  FROM empresa_prestaciones e WHERE e.empresa_id=c.empresa_eps_id ) AS tercero_eps_id,	
			(SELECT t.numero_identificacion  FROM empresa_prestaciones e, tercero t WHERE e.empresa_id=c.empresa_eps_id AND t.tercero_id=e.tercero_id) AS numero_identificacion_eps,
			(SELECT t.digito_verificacion  FROM empresa_prestaciones e, tercero t WHERE e.empresa_id=c.empresa_eps_id AND t.tercero_id=e.tercero_id) AS digito_verificacion_eps,			
			(SELECT e.tercero_id  FROM empresa_prestaciones e WHERE e.empresa_id=c.empresa_pension_id ) AS tercero_pension_id,	
			(SELECT t.numero_identificacion  FROM empresa_prestaciones e, tercero t WHERE e.empresa_id=c.empresa_pension_id AND t.tercero_id=e.tercero_id) AS numero_identificacion_pension,
			(SELECT t.digito_verificacion  FROM empresa_prestaciones e, tercero t WHERE e.empresa_id=c.empresa_pension_id AND t.tercero_id=e.tercero_id) AS digito_verificacion_pension,			
			(SELECT te.numero_identificacion FROM  empleado e, tercero te WHERE  e.empleado_id=c.empleado_id AND te.tercero_id=e.tercero_id) AS numero_identificacion,
			(SELECT te.digito_verificacion FROM  empleado e, tercero te WHERE  e.empleado_id=c.empleado_id AND te.tercero_id=e.tercero_id) AS digito_verificacion,					
			(SELECT e.tercero_id FROM  empleado e WHERE  e.empleado_id=c.empleado_id ) AS tercero_id

   			FROM contrato c, tipo_contrato t 
			WHERE c.estado='A' AND t.tipo_contrato_id=c.tipo_contrato_id AND (t.prestaciones_sociales=1 OR (t.salud=1 AND t.prestaciones_sociales=0)) AND c.fecha_inicio <= '$fecha_final'
			AND c.contrato_id =$contrato_id";

	$result = $this -> DbFetchAll($select,$Conex,true);

	$this -> Begin($Conex);
		
	$this -> DbInsertTable("liquidacion_novedad",$Campos,$Conex,true,false);
	//inicio detalles
	for($i=0;$i<count($result);$i++){	
	
		if($result[$i]['area_laboral']=='A'){
			$puc_sal   = $result_per[0]['puc_admon_sal_id'];
			$puc_sub   = $result_per[0]['puc_admon_trans_id'];
			$puc_nos   = $result_per[0]['puc_admon_nos_id'];
			$puc_salud = $result_per[0]['puc_contra_salud_id'];
			$puc_pens  = $result_per[0]['puc_contra_pension_id'];
			$puc_penfon= $result_per[0]['puc_contra_fonpension_id'];
			
			$puc_extradiu= $result_per[0]['puc_admon_extradiu_id'];
			$puc_extranoc= $result_per[0]['puc_admon_extranoc_id'];			
			$puc_fesdiu  = $result_per[0]['puc_admon_fesdiu_id'];			
			$puc_fesnoc  = $result_per[0]['puc_admon_fesnoc_id'];
			$puc_recnoc  = $result_per[0]['puc_admon_recnoc_id'];			
			
		}elseif($result[$i]['area_laboral']=='O'){
			
			$puc_sal    = $result_per[0]['puc_produ_sal_id'];
			$puc_sub    = $result_per[0]['puc_produ_trans_id'];
			$puc_nos    = $result_per[0]['puc_produ_nos_id'];
			$puc_salud  = $result_per[0]['puc_contra_salud_id'];
			$puc_pens   = $result_per[0]['puc_contra_pension_id'];
			$puc_penfon = $result_per[0]['puc_contra_fonpension_id'];			

			$puc_extradiu= $result_per[0]['puc_produ_extradiu_id'];
			$puc_extranoc= $result_per[0]['puc_produ_extranoc_id'];			
			$puc_fesdiu  = $result_per[0]['puc_produ_fesdiu_id'];			
			$puc_fesnoc  = $result_per[0]['puc_produ_fesnoc_id'];						
			$puc_recnoc  = $result_per[0]['puc_produ_recnoc_id'];			
			
		}elseif($result[$i]['area_laboral']=='C'){

			$puc_sal   = $result_per[0]['puc_ventas_sal_id'];
			$puc_sub   = $result_per[0]['puc_ventas_trans_id'];
			$puc_nos   = $result_per[0]['puc_ventas_nos_id'];
			$puc_salud = $result_per[0]['puc_contra_salud_id'];
			$puc_pens  = $result_per[0]['puc_contra_pension_id'];
			$puc_penfon= $result_per[0]['puc_contra_fonpension_id'];			

			$puc_extradiu= $result_per[0]['puc_ventas_extradiu_id'];
			$puc_extranoc= $result_per[0]['puc_ventas_extranoc_id'];			
			$puc_fesdiu  = $result_per[0]['puc_ventas_fesdiu_id'];			
			$puc_fesnoc  = $result_per[0]['puc_ventas_fesnoc_id'];						
			$puc_recnoc  = $result_per[0]['puc_ventas_recnoc_id'];			
			

		}else{
			
			$puc_sal     ='';
			$puc_sub     ='';
			$puc_nos     ='';
			$puc_salud   ='';
			$puc_pens    ='';
			$puc_penfon  ='';
			$puc_extradiu='';
			$puc_extranoc='';			
			$puc_fesdiu  ='';			
			$puc_fesnoc  ='';						
			$puc_recnoc  ='';		

			exit('No Ha parametrizado Area para el contrato No '.$result[$i]['numero_contrato']);
		}
		
		$puc_sueldo_pagar = $result_per[0]['puc_contra_sal_id'];
		$puc_nosalarial   = $result_per[0]['puc_contra_nos_id'];
	
		$contrato_id        =  $result[$i]['contrato_id'];
		$sueldo_base        =$result[$i]['sueldo_base'];
		$subsidio_transporte= $result[$i]['subsidio_transporte'];
		$ingreso_nosalarial =$result[$i]['ingreso_nosalarial'];
		
		$tercero_id            =  $result[$i]['tercero_id'];
		$numero_identificacion =  $result[$i]['numero_identificacion'];
		$digito_verificacion   =  $result[$i]['digito_verificacion']!='' ? $result[$i]['digito_verificacion'] : 'NULL';		

		$tercero_eps_id            =  $result[$i]['tercero_eps_id'];
		$numero_identificacion_eps =  $result[$i]['numero_identificacion_eps'];
		$digito_verificacion_eps   =  $result[$i]['digito_verificacion_eps']!='' ? $result[$i]['digito_verificacion_eps'] : 'NULL';		

		$tercero_pension_id            =  $result[$i]['tercero_pension_id'];
		$numero_identificacion_pension =  $result[$i]['numero_identificacion_pension'];
		$digito_verificacion_pension   =  $result[$i]['digito_verificacion_pension']!='' ? $result[$i]['digito_verificacion_pension'] : 'NULL';		

		$select_vac = "SELECT  c.*, DATEDIFF(IF(fecha_dis_final>'$fecha_final','$fecha_final',fecha_dis_final),IF(fecha_dis_inicio>'$fecha_inicial',fecha_dis_inicio,'$fecha_inicial')) AS diferencia
				FROM 	liquidacion_vacaciones c
				WHERE c.estado!='A' AND c.contrato_id=$contrato_id AND ('$fecha_inicial' BETWEEN  fecha_dis_inicio AND fecha_dis_final OR '$fecha_final'  BETWEEN  fecha_dis_inicio AND fecha_dis_final)";
		$result_vac = $this -> DbFetchAll($select_vac,$Conex,true);
		$dife_vacas= $result_vac[0]['diferencia']>0 ? ($result_vac[0]['diferencia']+1) : 0;

		if($dias_real<=$result[$i]['dias_lice_nore']){
			$dias     = 0;
			$dias_sub = 0;
		}elseif($dias_real<=$result[$i]['dias_lice_re']){
			$dias     = $dias_total-$dife_vacas-$result[$i]['dias_desc']-$result[$i]['dias_lice_nore'];
			$dias_sub = 0;
			
		}else{
			$dias = $dias_total-$dife_vacas-$result[$i]['dias_desc']-$result[$i]['dias_lice_nore'];
			$dias_sub = $dias_total-$dife_vacas-$result[$i]['dias_desc']-$result[$i]['dias_lice_nore']-$result[$i]['dias_lice_re'];

			$select_comp = "SELECT l.fecha_final
			FROM licencia l, tipo_incapacidad ti WHERE l.remunerado=0 AND l.estado!='I' AND  l.contrato_id=$contrato_id AND ti.tipo_incapacidad_id=l.tipo_incapacidad_id AND ti.tipo='L' AND  l.fecha_final = '$fecha_final'   ORDER BY  l.fecha_final DESC LIMIT 1";
			$result_comp = $this -> DbFetchAll($select_comp,$Conex,true);

			if($mes_final=='02' && $dia_final==29 &&  $result[$i]['dias_lice_nore']>11 && count($result_comp)==1 ){
				$dias    = $dias-1;
				$dias_sub= $dias_sub-1;
				
			}
			if($mes_final=='02' && $dia_final==28 &&  $result[$i]['dias_lice_nore']>11 && count($result_comp)==1){
				$dias    = $dias-2;
				$dias_sub= $dias_sub-2;
			}
			
		}
		//revisar dias incapacidad
		$select_inca = "SELECT (DATEDIFF(IF(l.fecha_final>'$fecha_final','$fecha_final',l.fecha_final),IF(l.fecha_inicial>'$fecha_inicial',l.fecha_inicial,'$fecha_inicial'))+1) AS dias_inca, ti.dia, ti.porcentaje,ti.descuento  
					FROM licencia l, tipo_incapacidad ti WHERE  l.contrato_id=$contrato_id AND l.estado!='I' AND ti.tipo_incapacidad_id=l.tipo_incapacidad_id AND ti.tipo='I'  AND ('$fecha_inicial' BETWEEN  l.fecha_inicial AND l.fecha_final OR '$fecha_final'  BETWEEN  l.fecha_inicial AND l.fecha_final OR l.fecha_inicial BETWEEN '$fecha_inicial' AND '$fecha_final') ";
					
		$result_inca  = $this -> DbFetchAll($select_inca,$Conex,true); 
		$dias_inca    = 0;
		$dias_inca_sub= 0;
		$dia_difinc   = 0;
		$sal_dia_cont = intval($sueldo_base/30);
		$des_val_inc  = 0;

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
		
		$dias_sub=$dias_sub-$dias_inca_sub;//resta los dias incapacidad
		
		//salario
		$debito=intval((($sueldo_base/30)*$dias)-$des_val_inc);		
		//$debito=intval((($sueldo_base/30)*$dias_sub));		
		$credito=0;
		$deb_total=$deb_total+$debito;
		$cre_total=$cre_total+$credito;
		$dias_sal = $dias - $dias_inca_sub;
		$detalle_liquidacion_novedad_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_novedad","detalle_liquidacion_novedad_id",$Conex,false,1);
		$insert = "INSERT INTO 	detalle_liquidacion_novedad (detalle_liquidacion_novedad_id,puc_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,observacion,concepto,tercero_id,numero_identificacion,digito_verificacion) 
		VALUES ($detalle_liquidacion_novedad_id,$puc_sal,$liquidacion_novedad_id, $debito,$credito,'$fecha_inicial','$fecha_final',$dias_sal,'$observacion','SALARIO',$tercero_id,$numero_identificacion,$digito_verificacion)";
		$this -> query($insert,$Conex,true);
		
		//incapacidades
		$debito   = intval(($dias_inca_sub*$sal_dia_cont)-$des_val_inc);	
		$credito  = 0;
		$deb_total= $deb_total+$debito;
		$cre_total= $cre_total+$credito;
		
		
		if($dias_inca_sub>0){
			
			$detalle_liquidacion_novedad_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_novedad","detalle_liquidacion_novedad_id",$Conex,false,1);
			$insert = "INSERT INTO 	detalle_liquidacion_novedad (detalle_liquidacion_novedad_id,puc_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,observacion,concepto,tercero_id,numero_identificacion,digito_verificacion) 
			VALUES ($detalle_liquidacion_novedad_id,$puc_sal,$liquidacion_novedad_id, $debito,$credito,'$fecha_inicial','$fecha_final',$dias_inca_sub,'$observacion','INCAPACIDADES',$tercero_id,$numero_identificacion,$digito_verificacion)";
			$this -> query($insert,$Conex,true);
		}
		
		
		
		if($sueldo_base<=$limite_sal){
			//subsidio transporte
			$debito    = intval(($subsidio_transporte/30)*$dias_sub);
			$credito   = 0;
			$deb_total = $deb_total+$debito;
			$cre_total = $cre_total+$credito;
			
			$detalle_liquidacion_novedad_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_novedad","detalle_liquidacion_novedad_id",$Conex,false,1);
			$insert = "INSERT INTO 	detalle_liquidacion_novedad (detalle_liquidacion_novedad_id,puc_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,observacion,concepto,tercero_id,numero_identificacion,digito_verificacion) 
			VALUES ($detalle_liquidacion_novedad_id,$puc_sub,$liquidacion_novedad_id,$debito,$credito,'$fecha_inicial','$fecha_final',$dias_sub,'$observacion','AUX TRANSPORTE',$tercero_id,$numero_identificacion,$digito_verificacion)";
			$this -> query($insert,$Conex,true);
		}

		if($ingreso_nosalarial>0){
			//ingreso no salarial
			$debito    = intval(($ingreso_nosalarial/30)*$dias);
			$credito   = 0;
			$deb_total = $deb_total+$debito;
			$cre_total = $cre_total+$credito;
			
			$detalle_liquidacion_novedad_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_novedad","detalle_liquidacion_novedad_id",$Conex,false,1);
			$insert = "INSERT INTO 	detalle_liquidacion_novedad (detalle_liquidacion_novedad_id,puc_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,observacion,concepto,tercero_id,numero_identificacion,digito_verificacion) 
			VALUES ($detalle_liquidacion_novedad_id,$puc_nos,$liquidacion_novedad_id,$debito,$credito,'$fecha_inicial','$fecha_final',$dias_sub,'$observacion','INGRESO NO SALARIAL',$tercero_id,$numero_identificacion,$digito_verificacion)";
			$this -> query($insert,$Conex,true);
		}

		if($result[$i]['prestaciones_sociales']==1){
			//sumatoria devengados
			$selectdeve = "SELECT  SUM(n.valor_cuota) AS valor_deven
					FROM novedad_fija n, concepto_area c
					WHERE n.contrato_id=$contrato_id AND n.tipo_novedad='V'  AND n.estado='A' AND '$fecha_final' BETWEEN  n.fecha_inicial AND n.fecha_final AND c.concepto_area_id=n.concepto_area_id AND c.base_salarial='SI'";
			$resultdeve = $this -> DbFetchAll($selectdeve,$Conex,true);
			$valor_deven = $resultdeve[0]['valor_deven']>0 ? $resultdeve[0]['valor_deven'] : 0;

			$selectext = "SELECT  
					h.vr_horas_diurnas AS valor_diurnas,
					h.vr_horas_nocturnas AS valor_nocturnas,
					h.vr_horas_diurnas_fes AS valor_diurnas_fes,
					h.vr_horas_nocturnas_fes AS valor_nocturnas_fes,
					h.vr_horas_recargo_noc AS valor_recargo_noc
					
					FROM 	hora_extra h
					WHERE h.contrato_id=$contrato_id AND h.estado='E' AND h.fecha_inicial>='$fecha_inicial' AND h.fecha_final<='$fecha_final' ";			
					
			$resultext           = $this -> DbFetchAll($selectext,$Conex,true); 
			$valor_diurnas       = $resultext[0]['valor_diurnas']>0 ? $resultext[0]['valor_diurnas'] : 0;
			$valor_nocturnas     = $resultext[0]['valor_nocturnas']>0 ? $resultext[0]['valor_nocturnas'] : 0;			
			$valor_diurnas_fes   = $resultext[0]['valor_diurnas_fes']>0 ? $resultext[0]['valor_diurnas_fes'] : 0;
			$valor_nocturnas_fes = $resultext[0]['valor_nocturnas_fes']>0 ? $resultext[0]['valor_nocturnas_fes'] : 0;			
			$valor_recargo_noc   = $resultext[0]['valor_recargo_noc']>0 ? $resultext[0]['valor_recargo_noc'] : 0;			
			
			$total_base=$valor_deven+$valor_diurnas+$valor_nocturnas+$valor_diurnas_fes+$valor_nocturnas_fes+$valor_recargo_noc-$des_val_inc;
			//salud

			$debito    = 0;
			$credito   = intval((intval(((($sueldo_base)/30)*$dias)+$total_base)*$result_per[0]['desc_emple_salud'])/100);
			$deb_total = $deb_total+$debito;
			$cre_total = $cre_total+$credito;
			
			$detalle_liquidacion_novedad_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_novedad","detalle_liquidacion_novedad_id",$Conex,false,1);
			$insert = "INSERT INTO 	detalle_liquidacion_novedad (detalle_liquidacion_novedad_id,puc_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,observacion,concepto,tercero_id,numero_identificacion,digito_verificacion) 
			VALUES ($detalle_liquidacion_novedad_id,$puc_salud,$liquidacion_novedad_id,$debito,$credito,'$fecha_inicial','$fecha_final',$dias,'$observacion','SALUD',$tercero_eps_id,$numero_identificacion_eps,$digito_verificacion_eps)";
			$this -> query($insert,$Conex,true);
	
			//pension
			$debito=0;
			$credito=intval((intval(((($sueldo_base)/30)*$dias)+$total_base)*$result_per[0]['desc_emple_pension'])/100);
			$deb_total=$deb_total+$debito;
			$cre_total=$cre_total+$credito;
			
			$detalle_liquidacion_novedad_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_novedad","detalle_liquidacion_novedad_id",$Conex,false,1);
			$insert = "INSERT INTO 	detalle_liquidacion_novedad (detalle_liquidacion_novedad_id,puc_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,observacion,concepto,tercero_id,numero_identificacion,digito_verificacion) 
			VALUES ($detalle_liquidacion_novedad_id,$puc_pens,$liquidacion_novedad_id,$debito,$credito,'$fecha_inicial','$fecha_final',$dias,'$observacion','PENSION',$tercero_pension_id,$numero_identificacion_pension,$digito_verificacion_pension)";
			$this -> query($insert,$Conex,true);
			
			
			//fondo pensional
			$rango_salario=intval($sueldo_base/$salrio);
			$selectfondo = "SELECT  f.porcentaje,f.rango_ini,f.rango_fin
					FROM 	fondo_pensional f
					WHERE f.periodo_contable_id = (SELECT p.periodo_contable_id FROM periodo_contable p WHERE anio=$anio) AND '$rango_salario' BETWEEN rango_ini AND rango_fin  ";
			$resultfondo = $this -> DbFetchAll($selectfondo,$Conex,true); 
			$porcen_fondo=$resultfondo[0]['porcentaje'];
			if($porcen_fondo>0){

				$debito    = 0;
				$credito   = intval((intval((($sueldo_base/30)*$dias)+$total_base)*$porcen_fondo)/100);
				$deb_total = $deb_total+$debito;
				$cre_total = $cre_total+$credito;
				
				$detalle_liquidacion_novedad_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_novedad","detalle_liquidacion_novedad_id",$Conex,false,1);
				$insert = "INSERT INTO 	detalle_liquidacion_novedad (detalle_liquidacion_novedad_id,puc_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,observacion,concepto,tercero_id,numero_identificacion,digito_verificacion) 
				VALUES ($detalle_liquidacion_novedad_id,$puc_penfon,$liquidacion_novedad_id,$debito,$credito,'$fecha_inicial','$fecha_final',$dias,'$observacion','FONDO PENSIONAL',$tercero_pension_id,$numero_identificacion_pension,$digito_verificacion_pension)";
				$this -> query($insert,$Conex,true);

			}
		}
		//Ingreso de horas extras
		
		$select3 = "SELECT  h.*
				FROM 	hora_extra h
				WHERE h.contrato_id=$contrato_id AND h.estado='P' AND h.fecha_inicial>='$fecha_inicial' AND h.fecha_final<='$fecha_final' ";
					
		$result3 = $this -> DbFetchAll($select3,$Conex,true); 

		for($j=0;$j<count($result3);$j++){
			
			$hora_extra_id       = $result3[$j]['hora_extra_id'];
			$horas_diurnas       = $result3[$j]['horas_diurnas'];
			$horas_nocturnas     = $result3[$j]['horas_nocturnas'];
			$horas_diurnas_fes   = $result3[$j]['horas_diurnas_fes'];
			$horas_nocturnas_fes = $result3[$j]['horas_nocturnas_fes'];
			$horas_recargo_noc   = $result3[$j]['horas_recargo_noc'];
			$horas_recargo_doc   = $result3[$j]['horas_recargo_doc'];

			if($horas_diurnas > 0){

				$debito    = $result3[$j]['vr_horas_diurnas'];
				$credito   = 0;
				$deb_total = $deb_total+$debito;
				$cre_total = $cre_total+$credito;
				
				$detalle_liquidacion_novedad_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_novedad","detalle_liquidacion_novedad_id",$Conex,false,1);
				$insert = "INSERT INTO 	detalle_liquidacion_novedad (detalle_liquidacion_novedad_id,puc_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,cant_horas_extras,concepto,tercero_id,numero_identificacion,digito_verificacion) 
				VALUES ($detalle_liquidacion_novedad_id,$puc_extradiu,$liquidacion_novedad_id,$debito,$credito,'$fecha_inicial','$fecha_final',$dias,$horas_diurnas,'HORAS EXTRAS DIURNAS',$tercero_id,$numero_identificacion,$digito_verificacion)";
			 
				$this -> query($insert,$Conex,true);

				
			}

			if($horas_nocturnas > 0){

				$debito    = $result3[$j]['vr_horas_nocturnas'];
				$credito   =0;
				$deb_total = $deb_total+$debito;
				$cre_total = $cre_total+$credito;
				
				$detalle_liquidacion_novedad_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_novedad","detalle_liquidacion_novedad_id",$Conex,false,1);
				$insert = "INSERT INTO 	detalle_liquidacion_novedad (detalle_liquidacion_novedad_id,puc_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,cant_horas_extras,concepto,tercero_id,numero_identificacion,digito_verificacion) 
				VALUES ($detalle_liquidacion_novedad_id,$puc_extranoc,$liquidacion_novedad_id,$debito,$credito,'$fecha_inicial','$fecha_final',$dias,$horas_nocturnas,'HORAS EXTRAS NOCTURNAS',$tercero_id,$numero_identificacion,$digito_verificacion)";
			 
				$this -> query($insert,$Conex,true);

				
			}
			if($horas_diurnas_fes > 0){

				$debito    = $result3[$j]['vr_horas_diurnas_fes'];
				$credito   = 0;
				$deb_total = $deb_total+$debito;
				$cre_total = $cre_total+$credito;
				
				$detalle_liquidacion_novedad_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_novedad","detalle_liquidacion_novedad_id",$Conex,false,1);
				$insert = "INSERT INTO 	detalle_liquidacion_novedad (detalle_liquidacion_novedad_id,puc_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,cant_horas_extras,concepto,tercero_id,numero_identificacion,digito_verificacion) 
				VALUES ($detalle_liquidacion_novedad_id,$puc_fesdiu,$liquidacion_novedad_id,$debito,$credito,'$fecha_inicial','$fecha_final',$dias,$horas_diurnas_fes,'HORAS EXTRAS FEST DIURNAS',$tercero_id,$numero_identificacion,$digito_verificacion)";
			 
				$this -> query($insert,$Conex,true);
				
			}
			if($horas_nocturnas_fes > 0){

				$debito    = $result3[$j]['vr_horas_nocturnas_fes'];
				$credito   = 0;
				$deb_total = $deb_total+$debito;
				$cre_total = $cre_total+$credito;
				
				$detalle_liquidacion_novedad_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_novedad","detalle_liquidacion_novedad_id",$Conex,false,1);
				$insert = "INSERT INTO 	detalle_liquidacion_novedad (detalle_liquidacion_novedad_id,puc_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,cant_horas_extras,concepto,tercero_id,numero_identificacion,digito_verificacion) 
				VALUES ($detalle_liquidacion_novedad_id,$puc_fesnoc,$liquidacion_novedad_id,$debito,$credito,'$fecha_inicial','$fecha_final',$dias,$horas_nocturnas_fes,'HORAS EXTRAS FEST NOCTURNAS',$tercero_id,$numero_identificacion,$digito_verificacion)";
			 
				$this -> query($insert,$Conex,true);

				
			}

			if($horas_recargo_noc > 0){

				$debito    = $result3[$j]['vr_horas_recargo_noc'];
				$credito   = 0;
				$deb_total = $deb_total+$debito;
				$cre_total = $cre_total+$credito;
				
				$detalle_liquidacion_novedad_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_novedad","detalle_liquidacion_novedad_id",$Conex,false,1);
				$insert = "INSERT INTO 	detalle_liquidacion_novedad (detalle_liquidacion_novedad_id,puc_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,cant_horas_extras,concepto,tercero_id,numero_identificacion,digito_verificacion) 
				VALUES ($detalle_liquidacion_novedad_id,$puc_recnoc,$liquidacion_novedad_id,$debito,$credito,'$fecha_inicial','$fecha_final',$dias,$horas_recargo_noc,'RECARGO NOCTURNO',$tercero_id,$numero_identificacion,$digito_verificacion)";
			 
				$this -> query($insert,$Conex,true);
			}

			if($horas_recargo_doc > 0){

				$debito    = $result3[$j]['vr_horas_recargo_doc'];
				$credito   = 0;
				$deb_total = $deb_total+$debito;
				$cre_total = $cre_total+$credito;
				
				$detalle_liquidacion_novedad_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_novedad","detalle_liquidacion_novedad_id",$Conex,false,1);
				$insert = "INSERT INTO 	detalle_liquidacion_novedad (detalle_liquidacion_novedad_id,puc_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,cant_horas_extras,concepto,tercero_id,numero_identificacion,digito_verificacion) 
				VALUES ($detalle_liquidacion_novedad_id,$puc_recnoc,$liquidacion_novedad_id,$debito,$credito,'$fecha_inicial','$fecha_final',$dias,$horas_recargo_doc,'DOMINICALES FESTIVO',$tercero_id,$numero_identificacion,$digito_verificacion)";
			 
				$this -> query($insert,$Conex,true);
			}

			$update = "UPDATE hora_extra SET estado='L' WHERE hora_extra_id=$hora_extra_id";
			
			$this -> query($update,$Conex,true);
			
		}

		//novedades
		$select2 = "SELECT  n.*, c.*, 
				(SELECT t.numero_identificacion FROM tercero t WHERE t.tercero_id=n.tercero_id  ) AS numero_identificacion,
				(SELECT t.digito_verificacion FROM tercero t WHERE t.tercero_id=n.tercero_id  ) AS digito_verificacion
				FROM novedad_fija n, concepto_area c
				WHERE n.contrato_id=$contrato_id AND n.estado='A' AND '$fecha_final' BETWEEN  n.fecha_inicial AND n.fecha_final AND c.concepto_area_id=n.concepto_area_id";
					
		$result2 = $this -> DbFetchAll($select2,$Conex,true);

		for($j=0;$j<count($result2);$j++){

			if($result2[$j]['tipo_novedad']=='V'){
				$debito =$result2[$j]['valor_cuota'];
				$credito=0;
			}else{
				$debito =0;
				$credito=$result2[$j]['valor_cuota'];
				
			}

			$tercero_nov_id            =  $result2[$j]['tercero_id'];
			$numero_identificacion_nov =  $result2[$j]['numero_identificacion'];
			$digito_verificacion_nov   =  $result2[$j]['digito_verificacion']!='' ? $result2[$j]['digito_verificacion']: 'NULL' ;		

			$deb_total=$deb_total+$debito;
			$cre_total=$cre_total+$credito;
			$concepto_area_id=$result2[$j]['concepto_area_id'];
			$concepto=$result2[$j]['concepto'];

			if($result[$i]['area_laboral']=='A'){
				$puc_nov=$result2[$j]['puc_admon_id'];				
			}elseif($result[$i]['area_laboral']=='O'){
				$puc_nov=$result2[$j]['puc_prod_id'];				
			}elseif($result[$i]['area_laboral']=='C'){
				$puc_nov=$result2[$j]['puc_ventas_id'];	
			}
			
			$detalle_liquidacion_novedad_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_novedad","detalle_liquidacion_novedad_id",$Conex,false,1);
			$insert = "INSERT INTO 	detalle_liquidacion_novedad (detalle_liquidacion_novedad_id,puc_id,liquidacion_novedad_id,concepto_area_id,debito,credito,fecha_inicial,fecha_final,dias,observacion,concepto,tercero_id,numero_identificacion,digito_verificacion) 
			VALUES ($detalle_liquidacion_novedad_id,$puc_nov,$liquidacion_novedad_id,$concepto_area_id,$debito,$credito,'$fecha_inicial','$fecha_final',$dias,'$observacion','$concepto',$tercero_nov_id,$numero_identificacion_nov,$digito_verificacion_nov)";
		 
			$this -> query($insert,$Conex,true);

		}
		
		//sueldo a pagar
		$debito  = 0;
		$credito = ($deb_total-$cre_total);
		
		$detalle_liquidacion_novedad_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_novedad","detalle_liquidacion_novedad_id",$Conex,false,1);
		$insert = "INSERT INTO 	detalle_liquidacion_novedad (detalle_liquidacion_novedad_id,puc_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,observacion,concepto,sueldo_pagar,tercero_id,numero_identificacion,digito_verificacion) 
		VALUES ($detalle_liquidacion_novedad_id,$puc_sueldo_pagar,$liquidacion_novedad_id,$debito,$credito,'$fecha_inicial','$fecha_final',$dias,'$observacion','SUELDO PAGAR',1,$tercero_id,$numero_identificacion,$digito_verificacion)";
		$this -> query($insert,$Conex,true);
		$deb_total=0;
		$cre_total=0;
		
	}
	//fin detalles

	if($previsual == 'true'){
		
	
	 # Muestro la ultima liquidacion creada	
	 $selectLiquidacion      = "SELECT l.liquidacion_novedad_id, l.consecutivo, l.empleados, l.fecha_inicial, l.fecha_final, 		                              l.periodicidad, l.area_laboral, l.estado, l.contrato_id, l.encabezado_registro_id, l.usuario_id,                                  l.fecha_registro, l.con_usuario_id, l.con_fecha, 
	                            (SELECT c.nombre FROM centro_de_costo c WHERE c.centro_de_costo_id=l.centro_de_costo_id) AS centro_de_costo
	                            FROM liquidacion_novedad l
                                ORDER BY l.liquidacion_novedad_id DESC LIMIT 1"; 
	 
	 $resultLiquidacion      = $this -> DbFetchAll($selectLiquidacion,$Conex,true);

	 $liquidacion_novedad_id = $resultLiquidacion[0]['liquidacion_novedad_id'];


	 $selectDetalle = " SELECT (p.nombre) AS nombre_puc, d.liquidacion_novedad_id, CONCAT_WS(' ',t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) AS tercero, d.numero_identificacion, d.digito_verificacion, 

					   (SELECT c.descripcion FROM concepto_area c WHERE c.concepto_area_id=d.concepto_area_id) AS descripcion_concepto, 

                       d.formula, d.base, d.porcentaje, d.debito, d.credito, d.fecha_inicial, d.fecha_final, d.dias, d.concepto, d.observacion, d.sueldo_pagar 

                       FROM detalle_liquidacion_novedad d, puc p, tercero t

					   WHERE d.puc_id=p.puc_id AND d.tercero_id=t.tercero_id AND d.liquidacion_novedad_id = $liquidacion_novedad_id"; 
					   
	 
	 $resultDetalle  = $this -> DbFetchAll($selectDetalle,$Conex,true);


	 return  $resultDetalle;
	 
	 $this -> Rollback($Conex);

	}else{

	 $this -> Commit($Conex);

	 return $liquidacion_novedad_id;

	} 
  }

  public function SaveTodos($usuario_id,$Campos,$dias,$dias_real,$periodicidad,$area_laboral,$centro_de_costo_id,$previsual,$Conex){
	
	$this -> assignValRequest('usuario_id',$usuario_id);
	$this -> assignValRequest('fecha_registro',date('Y-m-d H:i'));
	$fecha_inicial = $_REQUEST['fecha_inicial'];
	$fecha_final = $_REQUEST['fecha_final'];
	$anio = substr($_REQUEST['fecha_final'],0,4);
	$consecutivo = $this -> DbgetMaxConsecutive("liquidacion_novedad","consecutivo",$Conex,false,1);
	$this -> assignValRequest('consecutivo',$consecutivo);

	$deb_total=0;
	$cre_total=0;
	$dias_total = $dias;
	
	if($periodicidad == 'T'){
		$consulta_period = "";
	}else{
		$consulta_period = " AND c.periodicidad = '$periodicidad' ";
	}
	
	if($area_laboral == 'T'){
		$consulta_area = "";
	}else{
		$consulta_area = " AND c.area_laboral = '$area_laboral' ";
	}

	if($centro_de_costo_id >0){
		$consulta_centro = " AND c.centro_de_costo_id = $centro_de_costo_id ";
	}else{
		$consulta_centro = "";
	}

	

	$select_per = "SELECT * FROM datos_periodo
			WHERE periodo_contable_id = (SELECT periodo_contable_id FROM periodo_contable WHERE anio=$anio)";
	$result_per = $this -> DbFetchAll($select_per,$Conex,true);
	//echo($select_per);

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
	
	$select = "SELECT  c.*, t.prestaciones_sociales, t.salud,
			IF(c.fecha_inicio BETWEEN '$fecha_inicial'  AND '$fecha_final',DATEDIFF(CONCAT_WS(' ',c.fecha_inicio,'23:59:59'),'$fecha_inicial'),0) AS dias_desc,
			(SELECT SUM((DATEDIFF(IF(l.fecha_final>'$fecha_final','$fecha_final',l.fecha_final),IF(l.fecha_inicial>'$fecha_inicial',l.fecha_inicial,'$fecha_inicial'))+1)) 
			FROM licencia l, tipo_incapacidad ti WHERE l.remunerado=1  AND l.estado!='I' AND l.contrato_id=c.contrato_id AND ti.tipo_incapacidad_id=l.tipo_incapacidad_id AND ti.tipo='L' AND ('$fecha_inicial' BETWEEN  l.fecha_inicial AND l.fecha_final OR '$fecha_final'  BETWEEN  l.fecha_inicial AND l.fecha_final OR l.fecha_inicial BETWEEN '$fecha_inicial' AND '$fecha_final') )  AS dias_lice_re,
			
			(SELECT SUM((DATEDIFF(IF(l.fecha_final>'$fecha_final','$fecha_final',l.fecha_final),IF(l.fecha_inicial>'$fecha_inicial',l.fecha_inicial,'$fecha_inicial'))+1)) 
			FROM licencia l, tipo_incapacidad ti WHERE l.remunerado=0 AND l.estado!='I' AND  l.contrato_id=c.contrato_id AND ti.tipo_incapacidad_id=l.tipo_incapacidad_id AND ti.tipo='L' AND ('$fecha_inicial' BETWEEN  l.fecha_inicial AND l.fecha_final OR '$fecha_final'  BETWEEN  l.fecha_inicial AND l.fecha_final OR l.fecha_inicial BETWEEN '$fecha_inicial' AND '$fecha_final') )  AS dias_lice_nore,
			
			
			(SELECT e.tercero_id  FROM empresa_prestaciones e WHERE e.empresa_id=c.empresa_eps_id ) AS tercero_eps_id,	
			(SELECT t.numero_identificacion  FROM empresa_prestaciones e, tercero t WHERE e.empresa_id=c.empresa_eps_id AND t.tercero_id=e.tercero_id) AS numero_identificacion_eps,
			(SELECT t.digito_verificacion  FROM empresa_prestaciones e, tercero t WHERE e.empresa_id=c.empresa_eps_id AND t.tercero_id=e.tercero_id) AS digito_verificacion_eps,			
			(SELECT e.tercero_id  FROM empresa_prestaciones e WHERE e.empresa_id=c.empresa_pension_id ) AS tercero_pension_id,	
			(SELECT t.numero_identificacion  FROM empresa_prestaciones e, tercero t WHERE e.empresa_id=c.empresa_pension_id AND t.tercero_id=e.tercero_id) AS numero_identificacion_pension,
			(SELECT t.digito_verificacion  FROM empresa_prestaciones e, tercero t WHERE e.empresa_id=c.empresa_pension_id AND t.tercero_id=e.tercero_id) AS digito_verificacion_pension,			
			(SELECT te.numero_identificacion FROM  empleado e, tercero te WHERE  e.empleado_id=c.empleado_id AND te.tercero_id=e.tercero_id) AS numero_identificacion,
			(SELECT te.digito_verificacion FROM  empleado e, tercero te WHERE  e.empleado_id=c.empleado_id AND te.tercero_id=e.tercero_id) AS digito_verificacion,					
			(SELECT e.tercero_id FROM  empleado e WHERE  e.empleado_id=c.empleado_id ) AS tercero_id

   			FROM contrato c, tipo_contrato t 
			WHERE c.estado='A' AND t.tipo_contrato_id=c.tipo_contrato_id AND (t.prestaciones_sociales=1 OR (t.salud=1 AND t.prestaciones_sociales=0)) AND c.fecha_inicio <= '$fecha_final' $consulta_period $consulta_area $consulta_centro
			AND c.contrato_id NOT IN (SELECT contrato_id FROM liquidacion_novedad WHERE fecha_inicial='$fecha_inicial' AND fecha_final='$fecha_final' AND estado!='A')";
		
	$result = $this -> DbFetchAll($select,$Conex,true); 
	
	$this -> Begin($Conex);

	for($i=0;$i<count($result);$i++){	
	
		if($result[$i]['area_laboral']=='A'){
			
			$puc_sal=$result_per[0]['puc_admon_sal_id'];
			$puc_sub=$result_per[0]['puc_admon_trans_id'];
			$puc_nos=$result_per[0]['puc_admon_nos_id'];			
			$puc_salud=$result_per[0]['puc_contra_salud_id'];
			$puc_pens=$result_per[0]['puc_contra_pension_id'];
			$puc_penfon=$result_per[0]['puc_contra_fonpension_id'];		
			
			$puc_extradiu=$result_per[0]['puc_admon_extradiu_id'];
			$puc_extranoc=$result_per[0]['puc_admon_extranoc_id'];			
			$puc_fesdiu=$result_per[0]['puc_admon_fesdiu_id'];			
			$puc_fesnoc=$result_per[0]['puc_admon_fesnoc_id'];
			$puc_recnoc=$result_per[0]['puc_admon_recnoc_id'];			
			
		}elseif($result[$i]['area_laboral']=='O'){
			$puc_sal=$result_per[0]['puc_produ_sal_id'];
			$puc_nos=$result_per[0]['puc_produ_nos_id'];			
			$puc_sub=$result_per[0]['puc_produ_trans_id'];
			$puc_salud=$result_per[0]['puc_contra_salud_id'];
			$puc_pens=$result_per[0]['puc_contra_pension_id'];
			$puc_penfon=$result_per[0]['puc_contra_fonpension_id'];		

			$puc_extradiu=$result_per[0]['puc_produ_extradiu_id'];
			$puc_extranoc=$result_per[0]['puc_produ_extranoc_id'];			
			$puc_fesdiu=$result_per[0]['puc_produ_fesdiu_id'];			
			$puc_fesnoc=$result_per[0]['puc_produ_fesnoc_id'];						
			$puc_recnoc=$result_per[0]['puc_produ_recnoc_id'];			
			
		}elseif($result[$i]['area_laboral']=='C'){
			$puc_sal=$result_per[0]['puc_ventas_sal_id'];
			$puc_nos=$result_per[0]['puc_ventas_nos_id'];			
			$puc_sub=$result_per[0]['puc_ventas_trans_id'];
			$puc_salud=$result_per[0]['puc_contra_salud_id'];
			$puc_pens=$result_per[0]['puc_contra_pension_id'];
			$puc_penfon=$result_per[0]['puc_contra_fonpension_id'];		

			$puc_extradiu=$result_per[0]['puc_ventas_extradiu_id'];
			$puc_extranoc=$result_per[0]['puc_ventas_extranoc_id'];			
			$puc_fesdiu=$result_per[0]['puc_ventas_fesdiu_id'];			
			$puc_fesnoc=$result_per[0]['puc_ventas_fesnoc_id'];						
			$puc_recnoc=$result_per[0]['puc_ventas_recnoc_id'];			
			

		}else{
			$puc_sal='';
			$puc_sub='';
			$puc_nos='';
			$puc_salud='';
			$puc_pens='';
			$puc_penfon='';		
			$puc_extradiu='';
			$puc_extranoc='';			
			$puc_fesdiu='';			
			$puc_fesnoc='';						
			$puc_recnoc='';			
			exit('No Ha parametrizado Area para el contrato No '.$result[$i]['numero_contrato']);
		}
		
		$puc_sueldo_pagar = $result_per[0]['puc_contra_sal_id'];
		$puc_nosalarial   = $result_per[0]['puc_contra_nos_id'];
		
		$liquidacion_novedad_id = $this -> DbgetMaxConsecutive("liquidacion_novedad","liquidacion_novedad_id",$Conex,false,1);
		$this -> assignValRequest('liquidacion_novedad_id',$liquidacion_novedad_id);
		
		$this -> assignValRequest('contrato_id',$result[$i]['contrato_id']);

	
	
		$this -> DbInsertTable("liquidacion_novedad",$Campos,$Conex,true,false);
		$contrato_id =  $result[$i]['contrato_id'];
		$sueldo_base=$result[$i]['sueldo_base'];
		$subsidio_transporte= $result[$i]['subsidio_transporte'];
		$ingreso_nosalarial=$result[$i]['ingreso_nosalarial'];

		$tercero_id =  $result[$i]['tercero_id'];
		$numero_identificacion =  $result[$i]['numero_identificacion'];
		$digito_verificacion =  $result[$i]['digito_verificacion']!='' ? $result[$i]['digito_verificacion'] : 'NULL';		

		$tercero_eps_id =  $result[$i]['tercero_eps_id'];
		$numero_identificacion_eps =  $result[$i]['numero_identificacion_eps'];
		$digito_verificacion_eps = $result[$i]['digito_verificacion_eps']!='' ? $result[$i]['digito_verificacion_eps'] : 'NULL';		

		$tercero_pension_id =  $result[$i]['tercero_pension_id'];
		$numero_identificacion_pension =  $result[$i]['numero_identificacion_pension'];
		$digito_verificacion_pension =  $result[$i]['digito_verificacion_pension']!='' ? $result[$i]['digito_verificacion_pension'] : 'NULL';

		$select_vac = "SELECT  c.*, DATEDIFF(IF(fecha_dis_final>'$fecha_final','$fecha_final',fecha_dis_final),IF(fecha_dis_inicio>'$fecha_inicial',fecha_dis_inicio,'$fecha_inicial')) AS diferencia
				FROM 	liquidacion_vacaciones c
				WHERE c.estado!='A' AND c.contrato_id=$contrato_id AND (('$fecha_inicial' BETWEEN  fecha_dis_inicio AND fecha_dis_final OR '$fecha_final' BETWEEN  fecha_dis_inicio AND fecha_dis_final) OR ('$fecha_inicial' < fecha_dis_inicio AND fecha_dis_final < '$fecha_final'))";
		$result_vac = $this -> DbFetchAll($select_vac,$Conex,true);
		$dife_vacas= $result_vac[0]['diferencia']>0 ? ($result_vac[0]['diferencia']+1) : 0;

		if($dias_real<=$result[$i]['dias_lice_nore']){
			$dias = 0;
			$dias_sub = 0;

		}elseif($dias_real<=$result[$i]['dias_lice_re']){
			$dias = $dias_total-$dife_vacas-$result[$i]['dias_desc']-$result[$i]['dias_lice_nore'];
			$dias_sub = 0;

		}else{
			$dias = $dias_total-$dife_vacas-$result[$i]['dias_desc']-$result[$i]['dias_lice_nore'];
			$dias_sub = $dias_total-$dife_vacas-$result[$i]['dias_desc']-$result[$i]['dias_lice_nore']-$result[$i]['dias_lice_re'];

			$select_comp = "SELECT l.fecha_final
			FROM licencia l, tipo_incapacidad ti WHERE l.remunerado=0 AND l.estado!='I' AND  l.contrato_id=$contrato_id AND ti.tipo_incapacidad_id=l.tipo_incapacidad_id AND ti.tipo='L' AND  l.fecha_final = '$fecha_final'   ORDER BY  l.fecha_final DESC LIMIT 1";
			$result_comp = $this -> DbFetchAll($select_comp,$Conex,true);

			if($mes_final=='02' && $dia_final==29 &&  $result[$i]['dias_lice_nore']>11 && count($result_comp)==1 ){
				$dias=$dias-1;
				$dias_sub=$dias_sub-1;
				
			}
			if($mes_final=='02' && $dia_final==28 &&  $result[$i]['dias_lice_nore']>11 && count($result_comp)==1){
				$dias=$dias-2;
				$dias_sub=$dias_sub-2;
			}

		}
				
		//revisar dias incapacidad
		
		
		$select_inca = "SELECT (DATEDIFF(IF(l.fecha_final>'$fecha_final','$fecha_final',l.fecha_final),IF(l.fecha_inicial>'$fecha_inicial',l.fecha_inicial,'$fecha_inicial'))+1) AS dias_inca, ti.dia, ti.porcentaje,ti.descuento  
					FROM licencia l, tipo_incapacidad ti WHERE  l.contrato_id=$contrato_id AND l.estado!='I' AND ti.tipo_incapacidad_id=l.tipo_incapacidad_id AND ti.tipo='I'  AND ('$fecha_inicial' BETWEEN  l.fecha_inicial AND l.fecha_final OR '$fecha_final'  BETWEEN  l.fecha_inicial AND l.fecha_final OR l.fecha_inicial BETWEEN '$fecha_inicial' AND '$fecha_final') ";

		
		$result_inca = $this -> DbFetchAll($select_inca,$Conex,true);
		
		
		$dias_inca=0;
		$dias_inca_sub=0;
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

		

		
		$dias_sub=$dias_sub-$dias_inca_sub;//resta los dias incapacidad

		
		//salario
		$debito=intval((($sueldo_base/30)*$dias_sub)-$des_val_inc);		
		//$debito=intval((($sueldo_base/30)*$dias_sub));		
		$credito=0;
		$deb_total=$deb_total+$debito;
		$cre_total=$cre_total+$credito;
		$dias_sal = $dias - $dias_inca_sub;

		
		$detalle_liquidacion_novedad_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_novedad","detalle_liquidacion_novedad_id",$Conex,false,1);
		//exit("***".$puc_sal."***"."JDFC26");
		$insert = "INSERT INTO 	detalle_liquidacion_novedad (detalle_liquidacion_novedad_id,puc_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,observacion,concepto,tercero_id,numero_identificacion,digito_verificacion) 
		VALUES ($detalle_liquidacion_novedad_id,$puc_sal,$liquidacion_novedad_id, $debito,$credito,'$fecha_inicial','$fecha_final',$dias_sal,'$observacion','SALARIO',$tercero_id,$numero_identificacion,$digito_verificacion)";
		$this -> query($insert,$Conex,true);
		
		
		//incapacidades
		$debito=intval(($dias_inca_sub*$sal_dia_cont)-$des_val_inc);
		$deb_total=$deb_total+$debito;	
		$credito=0;
		// $dias_sub=$dias_sub-$dias_inca_sub;//resta los dias incapacidad

		
		
		if($dias_inca_sub>0){
		
			$detalle_liquidacion_novedad_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_novedad","detalle_liquidacion_novedad_id",$Conex,false,1);
			$insert = "INSERT INTO 	detalle_liquidacion_novedad (detalle_liquidacion_novedad_id,puc_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,observacion,concepto,tercero_id,numero_identificacion,digito_verificacion) 
			VALUES ($detalle_liquidacion_novedad_id,$puc_sal,$liquidacion_novedad_id, $debito,$credito,'$fecha_inicial','$fecha_final',$dias_inca_sub,'$observacion','INCAPACIDADES',$tercero_id,$numero_identificacion,$digito_verificacion)";
			$this -> query($insert,$Conex,true);
		}
		

		if($sueldo_base<=$limite_sal){
			//subsidio transporte
			//exit("JDFC11");
			$debito=intval(($subsidio_transporte/30)*$dias_sub);
			$credito=0;
			$deb_total=$deb_total+$debito;
			$cre_total=$cre_total+$credito;

			
			
			$detalle_liquidacion_novedad_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_novedad","detalle_liquidacion_novedad_id",$Conex,false,1);
			$insert = "INSERT INTO 	detalle_liquidacion_novedad (detalle_liquidacion_novedad_id,puc_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,observacion,concepto,tercero_id,numero_identificacion,digito_verificacion) 
			VALUES ($detalle_liquidacion_novedad_id,$puc_sub,$liquidacion_novedad_id,$debito,$credito,'$fecha_inicial','$fecha_final',$dias_sub,'$observacion','AUX TRANSPORTE',$tercero_id,$numero_identificacion,$digito_verificacion)";
			$this -> query($insert,$Conex,true);
		}
		if($ingreso_nosalarial>0){
			//ingreso no salarial
			$debito=intval(($ingreso_nosalarial/30)*$dias_sub);
			$credito=0;
			$deb_total=$deb_total+$debito;
			$cre_total=$cre_total+$credito;
			
			$detalle_liquidacion_novedad_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_novedad","detalle_liquidacion_novedad_id",$Conex,false,1);
			$insert = "INSERT INTO 	detalle_liquidacion_novedad (detalle_liquidacion_novedad_id,puc_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,observacion,concepto,tercero_id,numero_identificacion,digito_verificacion) 
			VALUES ($detalle_liquidacion_novedad_id,$puc_nos,$liquidacion_novedad_id,$debito,$credito,'$fecha_inicial','$fecha_final',$dias_sub,'$observacion','INGRESO NO SALARIAL',$tercero_id,$numero_identificacion,$digito_verificacion)";
			$this -> query($insert,$Conex,true);
		}
		
		if($result[$i]['prestaciones_sociales']==1){
			//sumatoria devengados
			
			$selectdeve = "SELECT  SUM(n.valor_cuota) AS valor_deven
					FROM novedad_fija n, concepto_area c
					WHERE n.contrato_id=$contrato_id AND n.tipo_novedad='V'  AND n.estado='A' AND '$fecha_final' BETWEEN  n.fecha_inicial AND n.fecha_final AND c.concepto_area_id=n.concepto_area_id AND c.base_salarial='SI'";
			$resultdeve = $this -> DbFetchAll($selectdeve,$Conex,true); 
			$valor_deven = $resultdeve[0]['valor_deven']>0 ? $resultdeve[0]['valor_deven'] : 0;
			//sumatoria  extras 
			
			$selectext = "SELECT  
					h.vr_horas_diurnas AS valor_diurnas,
					h.vr_horas_nocturnas AS valor_nocturnas,
					h.vr_horas_diurnas_fes AS valor_diurnas_fes,
					h.vr_horas_nocturnas_fes AS valor_nocturnas_fes,
					h.vr_horas_recargo_noc AS valor_recargo_noc
					
					FROM 	hora_extra h
					WHERE h.contrato_id=$contrato_id AND h.estado='P' AND h.fecha_inicial>='$fecha_inicial' AND h.fecha_final<='$fecha_final' ";		
					
			$resultext = $this -> DbFetchAll($selectext,$Conex,true); 
			$valor_diurnas = $resultext[0]['valor_diurnas']>0 ? $resultext[0]['valor_diurnas'] : 0;
			$valor_nocturnas = $resultext[0]['valor_nocturnas']>0 ? $resultext[0]['valor_nocturnas'] : 0;			
			$valor_diurnas_fes = $resultext[0]['valor_diurnas_fes']>0 ? $resultext[0]['valor_diurnas_fes'] : 0;
			$valor_nocturnas_fes = $resultext[0]['valor_nocturnas_fes']>0 ? $resultext[0]['valor_nocturnas_fes'] : 0;			
			$valor_recargo_noc = $resultext[0]['valor_recargo_noc']>0 ? $resultext[0]['valor_recargo_noc'] : 0;			
			
			$total_base=$valor_deven+$valor_diurnas+$valor_nocturnas+$valor_diurnas_fes+$valor_nocturnas_fes+$valor_recargo_noc-$des_val_inc;
			//salud
			$debito=0;
			$credito=intval((intval(((($sueldo_base)/30)*$dias)+$total_base)*$result_per[0]['desc_emple_salud'])/100);
			$deb_total=$deb_total+$debito;
			$cre_total=$cre_total+$credito;
			//exit("JDFC23");
			$detalle_liquidacion_novedad_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_novedad","detalle_liquidacion_novedad_id",$Conex,false,1);
			$insert = "INSERT INTO 	detalle_liquidacion_novedad (detalle_liquidacion_novedad_id,puc_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,observacion,concepto,tercero_id,numero_identificacion,digito_verificacion) 
			VALUES ($detalle_liquidacion_novedad_id,$puc_salud,$liquidacion_novedad_id,$debito,$credito,'$fecha_inicial','$fecha_final',$dias,'$observacion','SALUD',$tercero_eps_id,$numero_identificacion_eps,$digito_verificacion_eps)";
			$this -> query($insert,$Conex,true);
	
			//pension
			$debito=0;
			$credito=intval((intval(((($sueldo_base)/30)*$dias)+$total_base)*$result_per[0]['desc_emple_pension'])/100);
			$deb_total=$deb_total+$debito;
			$cre_total=$cre_total+$credito;
			//exit("JDFC22");
			$detalle_liquidacion_novedad_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_novedad","detalle_liquidacion_novedad_id",$Conex,false,1);
			$insert = "INSERT INTO 	detalle_liquidacion_novedad (detalle_liquidacion_novedad_id,puc_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,observacion,concepto,tercero_id,numero_identificacion,digito_verificacion) 
			VALUES ($detalle_liquidacion_novedad_id,$puc_pens,$liquidacion_novedad_id,$debito,$credito,'$fecha_inicial','$fecha_final',$dias,'$observacion','PENSION',$tercero_pension_id,$numero_identificacion_pension,$digito_verificacion_pension)";
			$this -> query($insert,$Conex,true);

			//fondo pensional
			$rango_salario=intval($sueldo_base/$salrio);
			$selectfondo = "SELECT  f.porcentaje,f.rango_ini,f.rango_fin
					FROM 	fondo_pensional f
					WHERE f.periodo_contable_id = (SELECT p.periodo_contable_id FROM periodo_contable p WHERE anio=$anio) AND '$rango_salario' BETWEEN rango_ini AND rango_fin  ";
			$resultfondo = $this -> DbFetchAll($selectfondo,$Conex,true); 
			$porcen_fondo=$resultfondo[0]['porcentaje'];
			if($porcen_fondo>0){

				$debito=0;
				$credito=intval((intval((($sueldo_base/30)*$dias)+$total_base)*$porcen_fondo)/100);
				$deb_total=$deb_total+$debito;
				$cre_total=$cre_total+$credito;
				//exit("JDFC21");
				$detalle_liquidacion_novedad_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_novedad","detalle_liquidacion_novedad_id",$Conex,false,1);
				$insert = "INSERT INTO 	detalle_liquidacion_novedad (detalle_liquidacion_novedad_id,puc_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,observacion,concepto,tercero_id,numero_identificacion,digito_verificacion) 
				VALUES ($detalle_liquidacion_novedad_id,$puc_penfon,$liquidacion_novedad_id,$debito,$credito,'$fecha_inicial','$fecha_final',$dias,'$observacion','FONDO PENSIONAL',$tercero_pension_id,$numero_identificacion_pension,$digito_verificacion_pension)";
				$this -> query($insert,$Conex,true);

			}

		}

		//ingreso de horas extras
		$select3 = "SELECT  h.*
				FROM 	hora_extra h
				WHERE h.contrato_id=$contrato_id AND h.estado='P' AND h.fecha_inicial>='$fecha_inicial' AND h.fecha_final<='$fecha_final' ";
					
		$result3 = $this -> DbFetchAll($select3,$Conex,true); 

		for($j=0;$j<count($result3);$j++){

			$hora_extra_id       = $result3[$j]['hora_extra_id'];
			$horas_diurnas       = $result3[$j]['horas_diurnas'];
			$horas_nocturnas     = $result3[$j]['horas_nocturnas'];
			$horas_diurnas_fes   = $result3[$j]['horas_diurnas_fes'];
			$horas_nocturnas_fes = $result3[$j]['horas_nocturnas_fes'];
			$horas_recargo_noc   = $result3[$j]['horas_recargo_noc'];
			$horas_recargo_doc   = $result3[$j]['horas_recargo_doc'];


			if($horas_diurnas > 0){

				$debito        = $result3[$j]['vr_horas_diurnas'];
				$credito=0;
				$deb_total=$deb_total+$debito;
				$cre_total=$cre_total+$credito;
			
				$detalle_liquidacion_novedad_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_novedad","detalle_liquidacion_novedad_id",$Conex,false,1);
				$insert = "INSERT INTO 	detalle_liquidacion_novedad (detalle_liquidacion_novedad_id,puc_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,cant_horas_extras,concepto,tercero_id,numero_identificacion,digito_verificacion) 
                VALUES ($detalle_liquidacion_novedad_id,$puc_extradiu,$liquidacion_novedad_id,$debito,$credito,'$fecha_inicial','$fecha_final',$dias,$horas_diurnas,'HORAS EXTRAS DIURNAS',$tercero_id,$numero_identificacion,$digito_verificacion)";
			 
				$this -> query($insert,$Conex,true);

				
			}

			if($horas_nocturnas > 0){

				$debito          = $result3[$j]['vr_horas_nocturnas'];
			
				$credito=0;
				$deb_total=$deb_total+$debito;
				$cre_total=$cre_total+$credito;
				
				$detalle_liquidacion_novedad_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_novedad","detalle_liquidacion_novedad_id",$Conex,false,1);
				$insert = "INSERT INTO 	detalle_liquidacion_novedad (detalle_liquidacion_novedad_id,puc_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,cant_horas_extras,concepto,tercero_id,numero_identificacion,digito_verificacion) 
				VALUES ($detalle_liquidacion_novedad_id,$puc_extranoc,$liquidacion_novedad_id,$debito,$credito,'$fecha_inicial','$fecha_final',$dias,$horas_nocturnas,'HORAS EXTRAS NOCTURNAS',$tercero_id,$numero_identificacion,$digito_verificacion)";
			 
				$this -> query($insert,$Conex,true);

				
			}
			if($horas_diurnas_fes > 0){

				$debito = $result3[$j]['vr_horas_diurnas_fes'];
				$credito=0;
				$deb_total=$deb_total+$debito;
				$cre_total=$cre_total+$credito;
				
				$detalle_liquidacion_novedad_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_novedad","detalle_liquidacion_novedad_id",$Conex,false,1);
				$insert = "INSERT INTO 	detalle_liquidacion_novedad (detalle_liquidacion_novedad_id,puc_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,cant_horas_extras,concepto,tercero_id,numero_identificacion,digito_verificacion) 
				VALUES ($detalle_liquidacion_novedad_id,$puc_fesdiu,$liquidacion_novedad_id,$debito,$credito,'$fecha_inicial','$fecha_final',$dias,$horas_diurnas_fes,'HORAS EXTRAS FEST DIURNAS',$tercero_id,$numero_identificacion,$digito_verificacion)";
			 
				$this -> query($insert,$Conex,true);
				
			}
			if($horas_nocturnas_fes > 0){

				$debito = $result3[$j]['vr_horas_nocturnas_fes'];
				$credito=0;
				$deb_total=$deb_total+$debito;
				$cre_total=$cre_total+$credito;

				$detalle_liquidacion_novedad_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_novedad","detalle_liquidacion_novedad_id",$Conex,false,1);
				$insert = "INSERT INTO 	detalle_liquidacion_novedad (detalle_liquidacion_novedad_id,puc_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,cant_horas_extras,concepto,tercero_id,numero_identificacion,digito_verificacion) 
				VALUES ($detalle_liquidacion_novedad_id,$puc_fesnoc,$liquidacion_novedad_id,$debito,$credito,'$fecha_inicial','$fecha_final',$dias,$horas_nocturnas_fes,'HORAS EXTRAS FEST NOCTURNAS',$tercero_id,$numero_identificacion,$digito_verificacion)";
			 
				$this -> query($insert,$Conex,true);

				
			}

			if($horas_recargo_noc > 0){

				$debito = $result3[$j]['vr_horas_recargo_noc'];
				$credito=0;
				$deb_total=$deb_total+$debito;
				$cre_total=$cre_total+$credito;
				
				$detalle_liquidacion_novedad_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_novedad","detalle_liquidacion_novedad_id",$Conex,false,1);
				$insert = "INSERT INTO 	detalle_liquidacion_novedad (detalle_liquidacion_novedad_id,puc_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,cant_horas_extras,concepto,tercero_id,numero_identificacion,digito_verificacion) 
				VALUES ($detalle_liquidacion_novedad_id,$puc_recnoc,$liquidacion_novedad_id,$debito,$credito,'$fecha_inicial','$fecha_final',$dias,$horas_recargo_noc,'RECARGO NOCTURNO',$tercero_id,$numero_identificacion,$digito_verificacion)";
			 
				$this -> query($insert,$Conex,true);
			}

			if($horas_recargo_doc > 0){

				$debito    = $result3[$j]['vr_horas_recargo_doc'];
				$credito   = 0;
				$deb_total = $deb_total+$debito;
				$cre_total = $cre_total+$credito;
				
				$detalle_liquidacion_novedad_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_novedad","detalle_liquidacion_novedad_id",$Conex,false,1);
				$insert = "INSERT INTO 	detalle_liquidacion_novedad (detalle_liquidacion_novedad_id,puc_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,cant_horas_extras,concepto,tercero_id,numero_identificacion,digito_verificacion) 
				VALUES ($detalle_liquidacion_novedad_id,$puc_recnoc,$liquidacion_novedad_id,$debito,$credito,'$fecha_inicial','$fecha_final',$dias,$horas_recargo_doc,'DOMINICALES FESTIVO',$tercero_id,$numero_identificacion,$digito_verificacion)";
			 
				$this -> query($insert,$Conex,true);
			}

			$update = "UPDATE hora_extra SET estado='L' WHERE hora_extra_id=$hora_extra_id";
			$this -> query($update,$Conex,true);
			
		}

		//novedades
		$select2 = "SELECT  n.*, c.*,
				(SELECT t.numero_identificacion FROM tercero t WHERE t.tercero_id=n.tercero_id  ) AS numero_identificacion,
				(SELECT t.digito_verificacion FROM tercero t WHERE t.tercero_id=n.tercero_id  ) AS digito_verificacion
				FROM novedad_fija n, concepto_area c
				WHERE n.contrato_id=$contrato_id AND n.estado='A' AND '$fecha_final' BETWEEN  n.fecha_inicial AND n.fecha_final AND c.concepto_area_id=n.concepto_area_id";

			
		$result2 = $this -> DbFetchAll($select2,$Conex,true);

		for($j=0;$j<count($result2);$j++){

			if($result2[$j]['tipo_novedad']=='V'){
				$debito=$result2[$j]['valor_cuota'];
				$credito=0;
			}else{
				$debito=0;
				$credito=$result2[$j]['valor_cuota'];
				
			}
			$deb_total=$deb_total+$debito;
			$cre_total=$cre_total+$credito;
			$concepto_area_id=$result2[$j]['concepto_area_id'];
			$concepto=$result2[$j]['concepto'];

			$tercero_nov_id =  $result2[$j]['tercero_id'];
			$numero_identificacion_nov =  $result2[$j]['numero_identificacion'];
			$digito_verificacion_nov =  $result2[$j]['digito_verificacion']!='' ? $result2[$j]['digito_verificacion']: 'NULL' ;		

			if($result[$i]['area_laboral']=='A'){
				$puc_nov=$result2[$j]['puc_admon_id'];				
			}elseif($result[$i]['area_laboral']=='O'){
				$puc_nov=$result2[$j]['puc_prod_id'];				
			}elseif($result[$i]['area_laboral']=='C'){
				$puc_nov=$result2[$j]['puc_ventas_id'];	
			}
			//exit("JDFC17");
			$detalle_liquidacion_novedad_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_novedad","detalle_liquidacion_novedad_id",$Conex,false,1);
			$insert = "INSERT INTO 	detalle_liquidacion_novedad (detalle_liquidacion_novedad_id,puc_id,liquidacion_novedad_id,concepto_area_id,debito,credito,fecha_inicial,fecha_final,dias,observacion,concepto,tercero_id,numero_identificacion,digito_verificacion) 
			VALUES ($detalle_liquidacion_novedad_id,$puc_nov,$liquidacion_novedad_id,$concepto_area_id,$debito,$credito,'$fecha_inicial','$fecha_final',$dias,'$observacion','$concepto',$tercero_nov_id,$numero_identificacion_nov,$digito_verificacion_nov)";
		 
			$this -> query($insert,$Conex,true);

		}
		
		//sueldo a pagar
		$debito=0;
		$credito=($deb_total-$cre_total);
		//exit("JDFC18");
		$detalle_liquidacion_novedad_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_novedad","detalle_liquidacion_novedad_id",$Conex,false,1);
		$insert = "INSERT INTO 	detalle_liquidacion_novedad (detalle_liquidacion_novedad_id,puc_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,observacion,concepto,sueldo_pagar,tercero_id,numero_identificacion,digito_verificacion) 
		VALUES ($detalle_liquidacion_novedad_id,$puc_sueldo_pagar,$liquidacion_novedad_id,$debito,$credito,'$fecha_inicial','$fecha_final',$dias,'$observacion','SUELDO PAGAR',1,$tercero_id,$numero_identificacion,$digito_verificacion)";
		$this -> query($insert,$Conex,true);
		$deb_total=0;
		$cre_total=0;
		
	}
			
			
	if($previsual == 'true'){
		
	
	 # Muestro la ultima liquidacion creada	
	 $selectLiquidacion      = "SELECT l.liquidacion_novedad_id, l.consecutivo, l.empleados, l.fecha_inicial, l.fecha_final, 		                              l.periodicidad, l.area_laboral, l.estado, l.contrato_id, l.encabezado_registro_id, l.usuario_id,                                  l.fecha_registro, l.con_usuario_id, l.con_fecha, 
	                            (SELECT c.nombre FROM centro_de_costo c WHERE c.centro_de_costo_id=l.centro_de_costo_id) AS centro_de_costo
	                            FROM liquidacion_novedad l
                                ORDER BY l.liquidacion_novedad_id DESC LIMIT 1"; 
	 
	 $resultLiquidacion      = $this -> DbFetchAll($selectLiquidacion,$Conex,true);

	 $liquidacion_novedad_id = $resultLiquidacion[0]['liquidacion_novedad_id'];


	 $selectDetalle = "SELECT (p.nombre) AS nombre_puc, d.liquidacion_novedad_id, CONCAT_WS(' ',t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) AS tercero, d.numero_identificacion, d.digito_verificacion, 

					   (SELECT c.descripcion FROM concepto_area c WHERE c.concepto_area_id=d.concepto_area_id) AS descripcion_concepto, 

                       d.formula, d.base, d.porcentaje, d.debito, d.credito, d.fecha_inicial, d.fecha_final, d.dias, d.concepto, d.observacion, d.sueldo_pagar 

                       FROM detalle_liquidacion_novedad d, puc p, tercero t

					   WHERE d.puc_id=p.puc_id AND d.tercero_id=t.tercero_id AND d.liquidacion_novedad_id = $liquidacion_novedad_id";
					   
					   $resultDetalle  = $this -> DbFetchAll($selectDetalle,$Conex,true);


	//
	
		 $liquidacion_novedad_id = $resultLiquidacion[0]['liquidacion_novedad_id'];
	
	
		 $selectDetalle = " SELECT (p.nombre) AS nombre_puc, d.liquidacion_novedad_id, CONCAT_WS(' ',t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) AS tercero, d.numero_identificacion, d.digito_verificacion, 
						   (SELECT c.descripcion FROM concepto_area c WHERE c.concepto_area_id=d.concepto_area_id) AS descripcion_concepto, 
						   d.formula, d.base, d.porcentaje, d.debito, d.credito, d.fecha_inicial, d.fecha_final, d.dias, d.concepto, d.observacion, d.sueldo_pagar 
						   FROM detalle_liquidacion_novedad d, puc p, tercero t
						   WHERE d.puc_id=p.puc_id AND d.tercero_id=t.tercero_id AND d.liquidacion_novedad_id = $liquidacion_novedad_id"; 
						   
		 
		 $resultDetalle  = $this -> DbFetchAll($selectDetalle,$Conex,true);
	
		 return  $resultLiquidacion;
		 $this -> Rollback($Conex);

	}else{

	 	$this -> Commit($Conex);
	 	return $liquidacion_novedad_id;

	} 
 }

  

  //BUSQUEDA
 public function selectLiquidacion($liquidacion_novedad_id,$Conex){
    				
   $select = "SELECT l.*,
				(SELECT CONCAT_WS(' ',c.numero_contrato,'-',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
					FROM empleado e, tercero t, contrato c  WHERE c.contrato_id=l.contrato_id AND e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id)	AS contrato 
   			FROM liquidacion_novedad l
			WHERE l.liquidacion_novedad_id=$liquidacion_novedad_id";
				
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	
	return $result;
  }
  

  public function selectLiquidacion1($liquidacion_novedad_id,$Conex){
    				
   $select = "SELECT l.fecha_inicial,l.fecha_final,l.liquidacion_novedad_id,l.empleados,l.estado,l.consecutivo,l.periodicidad,l.area_laboral
   			FROM liquidacion_novedad l
			WHERE l.liquidacion_novedad_id=$liquidacion_novedad_id";
				
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	
	return $result;
  }

  public function comprobar_estado($liquidacion_novedad_id,$Conex){
    				
   $select = "SELECT l.estado, l.empleados,l.encabezado_registro_id,l.consecutivo, l.encabezado_registro_id,l.fecha_inicial,l.fecha_final,
   			(SELECT p.estado  FROM encabezado_de_registro e,	periodo_contable p 
			 WHERE e.encabezado_registro_id=l.encabezado_registro_id AND p.periodo_contable_id=e.periodo_contable_id) AS estado_periodo,
			(SELECT p.estado  FROM encabezado_de_registro e,	mes_contable p 
			 WHERE e.encabezado_registro_id=l.encabezado_registro_id AND p.mes_contable_id=e.mes_contable_id) AS estado_mes			
   			FROM liquidacion_novedad l
			WHERE l.liquidacion_novedad_id=$liquidacion_novedad_id";
				
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	
	return $result;
  }

  public function ComprobarLiquidacion($contrato_id,$fecha_inicial,$fecha_final,$periodicidad,$area,$Conex){
    				
   $select = "SELECT  liquidacion_novedad_id, consecutivo
   			FROM liquidacion_novedad 
			WHERE contrato_id=$contrato_id AND estado!='A'  AND (fecha_inicial BETWEEN '$fecha_inicial' AND '$fecha_final' OR fecha_final BETWEEN '$fecha_inicial' AND '$fecha_final') ";
				
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	
	return $result;
  }

  public function ComprobarLiquidacionT($fecha_inicial,$fecha_final,$periodicidad,$area,$centro_de_costo_id,$Conex){
    				
   $select = "SELECT  liquidacion_novedad_id, consecutivo
   			FROM liquidacion_novedad 
			WHERE  estado!='A' AND periodicidad = '$periodicidad' AND area_laboral='$area' AND centro_de_costo_id=$centro_de_costo_id  AND (fecha_inicial BETWEEN '$fecha_inicial' AND '$fecha_final' OR fecha_final BETWEEN '$fecha_inicial' AND '$fecha_final') ";
				
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	
	return $result;
  }

  public function cancellation($liquidacion_novedad_id,$encabezado_registro_id,$causal_anulacion_id,$observacion_anulacion,$usuario_anulo_id,$Conex){
  
   $this -> Begin($Conex);
  
     $update = "UPDATE liquidacion_novedad SET estado = 'A',causal_anulacion_id = $causal_anulacion_id,observacion_anulacion = $observacion_anulacion,
	 fecha_anulacion = NOW(),usuario_anulo_id = $usuario_anulo_id WHERE liquidacion_novedad_id = $liquidacion_novedad_id";
	 $this -> query($update,$Conex,true);
	 
	 
	$update_extras ="UPDATE hora_extra SET estado='E' WHERE h.contrato_id IN (SELECT contrato_id FROM detalle_liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id) AND h.estado='P' AND h.fecha_inicial>=(SELECT fecha_inicial FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id) AND h.fecha_final<=(SELECT fecha_final FROM liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id) ";
	
	$this -> query($update,$Conex,true);
	
	
	 
	 if($encabezado_registro_id>0){

		$insert = "INSERT INTO encabezado_de_registro_anulado SELECT $encabezado_registro_id AS 
		encabezado_de_registro_anulado_id,encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,
		forma_pago_id,valor,numero_soporte,tercero_id,periodo_contable_id,mes_contable_id,consecutivo,
		fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,$causal_anulacion_id AS causal_anulacion_id,
		$observacion_anulacion AS observaciones, $usuario_anulo_id AS usuario_anula, NOW() AS fecha_anulacion, usuario_actualiza, fecha_actualiza FROM encabezado_de_registro WHERE encabezado_registro_id = $encabezado_registro_id";
		$this -> query($insert,$Conex,true);
	
		$insert = "INSERT INTO imputacion_contable_anulada SELECT  imputacion_contable_id AS  
		imputacion_contable_anulada_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id AS 
		encabezado_registro_anulado_id,centro_de_costo_id,codigo_centro_costo,numero,valor,amortiza,deprecia,base,porcentaje,formula,debito,credito,area_id,departamento_id,unidad_negocio_id,sucursal_id  FROM 
		imputacion_contable WHERE encabezado_registro_id = $encabezado_registro_id";
		$this -> query($insert,$Conex,true);
			
		$update = "UPDATE encabezado_de_registro SET estado = 'A',anulado = 1 WHERE encabezado_registro_id = $encabezado_registro_id";	  
		$this -> query($update,$Conex,true);	
			  
		$update = "UPDATE imputacion_contable SET debito = 0,credito = 0 WHERE encabezado_registro_id=$encabezado_registro_id";
		$this -> query($update,$Conex,true);			  
				
	 }
	 
     $this -> Commit($Conex);
  
  }    

  public function cancellation1($liquidacion_novedad_id,$encabezado_registro_id,$fecha_inicial,$fecha_final,$consecutivo,$causal_anulacion_id,$observacion_anulacion,$usuario_anulo_id,$Conex){
  
   $this -> Begin($Conex);
  
     $update = "UPDATE liquidacion_novedad SET estado = 'A',causal_anulacion_id = $causal_anulacion_id,observacion_anulacion = $observacion_anulacion,
	 fecha_anulacion = NOW(),usuario_anulo_id = $usuario_anulo_id WHERE fecha_inicial = '$fecha_inicial' AND fecha_final='$fecha_final' AND consecutivo=$consecutivo";
	 $this -> query($update,$Conex,true);
	 
	 if($encabezado_registro_id>0){

		$insert = "INSERT INTO encabezado_de_registro_anulado SELECT $encabezado_registro_id AS 
		encabezado_de_registro_anulado_id,encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,
		forma_pago_id,valor,numero_soporte,tercero_id,periodo_contable_id,mes_contable_id,consecutivo,
		fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,$causal_anulacion_id AS causal_anulacion_id,
		$observacion_anulacion AS observaciones, $usuario_anulo_id AS usuario_anula, NOW() AS fecha_anulacion, usuario_actualiza, fecha_actualiza FROM encabezado_de_registro WHERE encabezado_registro_id = $encabezado_registro_id";
		$this -> query($insert,$Conex,true);
	
		$insert = "INSERT INTO imputacion_contable_anulada SELECT  imputacion_contable_id AS  
		imputacion_contable_anulada_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id AS 
		encabezado_registro_anulado_id,centro_de_costo_id,codigo_centro_costo,numero,valor,amortiza,deprecia,base,porcentaje,formula,debito,credito,area_id,departamento_id,unidad_negocio_id,sucursal_id  FROM 
		imputacion_contable WHERE encabezado_registro_id = $encabezado_registro_id";
		$this -> query($insert,$Conex,true);
			
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


  public function getTotalDebitoCredito($liquidacion_novedad_id,$Conex){
	  
	  $select = "SELECT SUM(debito) AS debito,SUM(credito) AS credito,
	  (SELECT COUNT(*) FROM detalle_liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id AND  sueldo_pagar=1) AS contrapartidas
	  FROM detalle_liquidacion_novedad  WHERE liquidacion_novedad_id=$liquidacion_novedad_id";

      $result = $this -> DbFetchAll($select,$Conex);
	  
	  return $result; 
	  
  }

 public function getTotalDebitoCredito1($liquidacion_novedad_id,$fecha_inicial,$fecha_final,$consecutivo,$Conex){
	  
	  $select = "SELECT SUM(debito) AS debito,SUM(credito) AS credito
	  FROM detalle_liquidacion_novedad  WHERE liquidacion_novedad_id IN 
	  (SELECT liquidacion_novedad_id FROM liquidacion_novedad WHERE fecha_inicial='$fecha_inicial' AND fecha_final='$fecha_final' AND consecutivo=$consecutivo AND estado='E') ";

      $result = $this -> DbFetchAll($select,$Conex);
	  
	  return $result; 
	  
  }

  public function getContabilizarReg($liquidacion_novedad_id,$empresa_id,$oficina_id,$usuario_id,$mesContable,$periodoContable,$Conex){//contabilizar uno
	 
    include_once("UtilidadesContablesModelClass.php");
	  
	$utilidadesContables = new UtilidadesContablesModel(); 	 
	 
	$this -> Begin($Conex);
		
		$select 	= "SELECT f.*,
					(SELECT tipo_documento_id FROM datos_periodo WHERE periodo_contable_id =(SELECT periodo_contable_id FROM periodo_contable WHERE anio=YEAR(DATE(f.fecha_inicial)) ) ) AS tipo_documento_id,
					(SELECT SUM(debito) FROM detalle_liquidacion_novedad WHERE liquidacion_novedad_id=f.liquidacion_novedad_id) AS valor,
					
					(SELECT t.numero_identificacion FROM contrato c, empleado e, tercero t WHERE c.contrato_id=f.contrato_id AND e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id) AS numero_identificacion,
					(SELECT t.digito_verificacion FROM contrato c, empleado e, tercero t WHERE c.contrato_id=f.contrato_id AND e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id) AS digito_verificacion,					
					(SELECT e.tercero_id FROM contrato c, empleado e WHERE c.contrato_id=f.contrato_id AND e.empleado_id=c.empleado_id ) AS tercero_id,

					(SELECT c.centro_de_costo_id FROM contrato c WHERE c.contrato_id=f.contrato_id  ) AS centro_de_costo_id,
					(SELECT cc.codigo FROM contrato c, centro_de_costo cc WHERE c.contrato_id=f.contrato_id AND cc.centro_de_costo_id=c.centro_de_costo_id ) AS codigo_centro					

					FROM liquidacion_novedad f WHERE f.liquidacion_novedad_id=$liquidacion_novedad_id";	
					
		$result 	= $this -> DbFetchAll($select,$Conex,true); 
		

		$select_emp = "SELECT tercero_id FROM empresa	WHERE empresa_id=$empresa_id";
		$result_emp	= $this -> DbFetchAll($select_emp,$Conex,true);				

		$select_cc = "SELECT 	centro_de_costo_id, codigo FROM centro_de_costo	WHERE oficina_id=$oficina_id";
		$result_cc	= $this -> DbFetchAll($select_cc,$Conex,true);				

		$select_usu = "SELECT CONCAT_WS(' ',t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) AS usuario FROM usuario u, tercero t 
						WHERE u.usuario_id=$usuario_id AND t.tercero_id=u.tercero_id";
		$result_usu	= $this -> DbFetchAll($select_usu,$Conex,true);				

		$encabezado_registro_id	= $this -> DbgetMaxConsecutive("encabezado_de_registro","encabezado_registro_id",$Conex,true,1);	
		$tipo_documento_id		= $result[0]['tipo_documento_id'];	
		$valor					= $result[0]['valor'];
		$numero_soporte			= $result[0]['consecutivo'];	
		$tercero_id				= $result_emp[0]['tercero_id'];
		$terceroid				= $result[0]['tercero_id'];
		$numero_identificacion	= $result[0]['numero_identificacion'];
		$digito_verificacion	= $result[0]['digito_verificacion']!='' ? $result[0]['digito_verificacion'] : 'NULL';	

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
		$concepto				= 'NOMINA '.$result[0]['fecha_inicial'].' AL '.$result[0]['fecha_final'];
		$puc_id					= 'NULL';
		$fecha_registro			= date("Y-m-d H:m");
		$modifica				= $result_usu[0]['usuario'];
		$fuente_servicio_cod	= 'NO';
		$numero_documento_fuente= $consecutivo;
		$id_documento_fuente	= $result[0]['liquidacion_novedad_id'];


		$insert="INSERT INTO encabezado_de_registro (encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,valor,numero_soporte,tercero_id,periodo_contable_id,
							mes_contable_id,consecutivo,fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,fuente_servicio_cod,numero_documento_fuente,id_documento_fuente)
							VALUES($encabezado_registro_id,$empresa_id,$oficina_id,$tipo_documento_id,'$valor','$numero_soporte',$tercero_id,$periodo_contable_id,
							$mes_contable_id,$consecutivo,'$fecha','$concepto',$puc_id,'C','$fecha_registro','$modifica',$usuario_id,'$fuente_servicio_cod','$numero_documento_fuente',$id_documento_fuente)"; 
		$this -> query($insert,$Conex,true);
		
		$select_item      = "SELECT detalle_liquidacion_novedad_id, sueldo_pagar    
		FROM  detalle_liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id";
		$result_item      = $this -> DbFetchAll($select_item,$Conex,true);
		foreach($result_item as $result_items){
			$imputacion_contable_id 	= $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,true,1);
			if($result_items['sueldo_pagar']==0){
				
				$insert_item ="INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,valor,base,porcentaje,formula,debito,credito)
								SELECT  $imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,concepto,$encabezado_registro_id,$centro_de_costo_id1,'$codigo_centro1',(debito+credito),base,porcentaje,
								formula,debito,credito
								FROM detalle_liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id AND detalle_liquidacion_novedad_id=$result_items[detalle_liquidacion_novedad_id]"; 

			}elseif($result_items['sueldo_pagar']==1){

				$insert_item ="INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,valor,base,	porcentaje,formula,debito,credito)
								SELECT  $imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,concepto,$encabezado_registro_id,$centro_de_costo_id,'$codigo',(debito+credito),base,porcentaje,
								formula,debito,credito
								FROM detalle_liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id AND detalle_liquidacion_novedad_id=$result_items[detalle_liquidacion_novedad_id]"; 
			}
			
			$this -> query($insert_item,$Conex,true);			
		}
		
		$update = "UPDATE liquidacion_novedad SET encabezado_registro_id=$encabezado_registro_id,	
					estado= 'C',
					con_usuario_id = $usuario_id,
					con_fecha='$fecha_registro'
				WHERE liquidacion_novedad_id=$liquidacion_novedad_id";	
		$this -> query($update,$Conex,true);		  
			
		if(strlen($this -> GetError()) > 0){
			$this -> Rollback($Conex);
			
		}else{		
			$this -> Commit($Conex);
			return true;
		}  
  }


  public function getContabilizarRegT($liquidacion_novedad_id,$fecha_inicial,$fecha_final,$consecutivo,$empresa_id,$oficina_id,$usuario_id,$mesContable,$periodoContable,$Conex){//contabilizar varios aca
	 
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
					(SELECT SUM(debito) FROM detalle_liquidacion_novedad WHERE liquidacion_novedad_id=f.liquidacion_novedad_id) AS valor,
					
					(SELECT t.numero_identificacion FROM contrato c, empleado e, tercero t WHERE c.contrato_id=f.contrato_id AND e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id) AS numero_identificacion,
					(SELECT t.digito_verificacion FROM contrato c, empleado e, tercero t WHERE c.contrato_id=f.contrato_id AND e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id) AS digito_verificacion,					
					(SELECT e.tercero_id FROM contrato c, empleado e WHERE c.contrato_id=f.contrato_id AND e.empleado_id=c.empleado_id ) AS tercero_id,
					(SELECT c.centro_de_costo_id FROM contrato c WHERE c.contrato_id=f.contrato_id  ) AS centro_de_costo_id,
					(SELECT cc.codigo FROM contrato c, centro_de_costo cc WHERE c.contrato_id=f.contrato_id AND cc.centro_de_costo_id=c.centro_de_costo_id ) AS codigo_centro					
					
					FROM liquidacion_novedad f 
					WHERE fecha_inicial='$fecha_inicial' AND fecha_final='$fecha_final' AND consecutivo=$consecutivo AND estado='E'";	
					
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
		$concepto				= 'NOMINA '.$result[0]['fecha_inicial'].' AL '.$result[0]['fecha_final'];
		$puc_id					= 'NULL';
		$fecha_registro			= date("Y-m-d H:m");
		
		$fuente_servicio_cod	= 'NO';
		$numero_documento_fuente= $consecutivo;
		$id_documento_fuente	= $result[0]['liquidacion_novedad_id'];


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

			

			$liquidacion_novedad_id1 = $result[$i]['liquidacion_novedad_id'];
			$select_item      = "SELECT detalle_liquidacion_novedad_id, sueldo_pagar  
			FROM  detalle_liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id1";
			$result_item      = $this -> DbFetchAll($select_item,$Conex,true);
			foreach($result_item as $result_items){  
			
				$imputacion_contable_id 	= $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,true,1);

				if($result_items['sueldo_pagar']==0){

					$insert_item ="INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,valor,base,	porcentaje,formula,debito,credito)
									SELECT  $imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,concepto,$encabezado_registro_id,$centro_de_costo_id1,'$codigo_centro1',(debito+credito),base,porcentaje,
									formula,debito,credito
									FROM detalle_liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id1 AND detalle_liquidacion_novedad_id=$result_items[detalle_liquidacion_novedad_id]"; 
									
				}elseif($result_items['sueldo_pagar']==1){

					$insert_item ="INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,valor,base,	porcentaje,formula,debito,credito)
									SELECT  $imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,concepto,$encabezado_registro_id,$centro_de_costo_id,'$codigo',(debito+credito),base,porcentaje,
									formula,debito,credito
									FROM detalle_liquidacion_novedad WHERE liquidacion_novedad_id=$liquidacion_novedad_id1 AND detalle_liquidacion_novedad_id=$result_items[detalle_liquidacion_novedad_id]"; 

				}
				$this -> query($insert_item,$Conex,true);
			}
		}
		
		$update = "UPDATE liquidacion_novedad SET encabezado_registro_id=$encabezado_registro_id,	
					estado= 'C',
					con_usuario_id = $usuario_id,
					con_fecha='$fecha_registro'
				WHERE fecha_inicial='$fecha_inicial' AND fecha_final='$fecha_final' AND consecutivo=$consecutivo AND estado='E'";	

		$this -> query($update,$Conex,true);		  
			
		$this -> Commit($Conex);
		return true;
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
  
  	public function GetCosto($Conex){
		return $this -> DbFetchAll("SELECT centro_de_costo_id  AS value, nombre AS text FROM centro_de_costo ORDER BY nombre ASC",$Conex,
		$ErrDb = false);
	}

  //// GRID ////   
  public function getQueryRegistrarGrid(){
	 
	 $Query = "SELECT
	 				l.consecutivo,
					l.fecha_inicial,
					l.fecha_final,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
					FROM empleado e, tercero t, contrato c  WHERE c.contrato_id=l.contrato_id AND e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id)	AS empleado,
					(SELECT numero_contrato FROM contrato WHERE contrato_id=l.contrato_id)	AS contrato,
					(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id=l.encabezado_registro_id)	AS doc_contable,
					CASE l.estado WHEN 'A' THEN 'ANULADO' WHEN 'C' THEN 'CONTABILIZADO' WHEN 'E' THEN 'EDICION' ELSE '' END AS estado
	 			FROM liquidacion_novedad l ORDER BY l.fecha_inicial DESC LIMIT 0,1000";
	 
     return $Query;
   }
      
   
}


?>
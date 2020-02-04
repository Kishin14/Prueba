<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ParametrosLiquidacionModel extends Db{

	private $UserId;
	private $Permisos;

	public function SetUsuarioId($UserId,$CodCId){
		$this -> Permisos = new PermisosForm();
		$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
	}

	public function getPermiso($ActividadId,$Permiso,$Conex){
		return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
	}
	
	public function getEmpresas($usuario_id,$Conex){
   
     $select = "SELECT e.empresa_id AS value,
	 CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS text FROM empresa e,tercero t 
	 WHERE t.tercero_id = e.tercero_id AND e.empresa_id IN (SELECT empresa_id FROM empresa WHERE empresa_id IN (SELECT empresa_id FROM 
	 opciones_actividad WHERE usuario_id = $usuario_id))";
	 
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);    
	 
	 return $result;
   
   }			
   public function selectOficinasEmpresa($empresa_id,$oficina_id,$Conex){
   
     $select = "SELECT oficina_id AS value,nombre AS text,'$oficina_id' AS selected FROM oficina WHERE empresa_id = $empresa_id ORDER BY nombre ASC";
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);	
   
     return $result;
   
   }
				
  public function getTiposDocumentoContable($Conex){
	  
	$select = "SELECT tipo_documento_id AS value,nombre AS text FROM tipo_de_documento ORDER BY nombre 	ASC";
	$result = $this  -> DbFetchAll($select,$Conex);
	
	return $result;
  }

	public function selectDatosParametrosLiquidacionId($parametros_liquidacion_id,$Conex){

		$select = "
		SELECT d.*,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_vac_cons_id) AS puc_vac_cons,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_vac_prov_id) AS puc_vac_prov,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_vac_contra_id) AS puc_vac_contra,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_vac_id) AS puc_admon_vac,			
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_vac_id) AS puc_ventas_vac,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_vac_id) AS puc_produ_vac,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_salud_vac_id) AS puc_salud_vac,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_pension_vac_id) AS puc_pension_vac,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_reintegro_vac_id) AS puc_reintegro_vac,
		
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_prima_cons_id) AS puc_prima_cons,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_prima_prov_id) AS puc_prima_prov,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_prima_contra_id) AS puc_prima_contra,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_prima_id) AS puc_admon_prima,			
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_prima_id) AS puc_ventas_prima,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_prima_id) AS puc_produ_prima,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_reintegro_prima_id) AS puc_reintegro_prima,
		
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_cesantias_cons_id) AS puc_cesantias_cons,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_cesantias_prov_id) AS puc_cesantias_prov,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_cesantias_contra_id) AS puc_cesantias_contra,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_cesantias_id) AS puc_admon_cesantias,			
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_cesantias_id) AS puc_ventas_cesantias,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_cesantias_id) AS puc_produ_cesantias,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_reintegro_cesantias_id) AS puc_reintegro_cesantias,
		
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_int_cesantias_cons_id) AS puc_int_cesantias_cons,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_int_cesantias_prov_id) AS puc_int_cesantias_prov,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_int_cesantias_contra_id) AS puc_int_cesantias_contra,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_int_cesantias_id) AS puc_admon_int_cesantias,			
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_int_cesantias_id) AS puc_ventas_int_cesantias,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_int_cesantias_id) AS puc_produ_int_cesantias,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_reintegro_int_cesantias_id) AS puc_reintegro_int_cesantias
		
		FROM parametros_liquidacion_nomina d 
		WHERE d.parametros_liquidacion_id = $parametros_liquidacion_id";

		$result    = $this -> DbFetchAll($select,$Conex,true);
		return $result;
	}

	public function Save($Campos,$Conex){

		$this -> Begin($Conex);
			$parametros_liquidacion_id   = $this -> DbgetMaxConsecutive("parametros_liquidacion_nomina","parametros_liquidacion_id",$Conex,true,1);
			$this -> assignValRequest('parametros_liquidacion_id',$parametros_liquidacion_id);
			$this -> DbInsertTable("parametros_liquidacion_nomina",$Campos,$Conex,true,false);
		$this -> Commit($Conex);
	}

	public function Update($Campos,$Conex){
		$this -> Begin($Conex);
			if($_REQUEST['parametros_liquidacion_id'] == 'NULL'){
				$this -> DbInsertTable("parametros_liquidacion_nomina",$Campos,$Conex,true,false);
			}else{
				$this -> DbUpdateTable("parametros_liquidacion_nomina",$Campos,$Conex,true,false);
			}
		$this -> Commit($Conex);
	}

	public function Delete($Campos,$Conex){
		$this -> DbDeleteTable("parametros_liquidacion_nomina",$Campos,$Conex,true,false);
	}

	public function ValidateRow($Conex,$Campos){
		require_once("../../../framework/clases/ValidateRowClass.php");
		$Data = new ValidateRow($Conex,"parametros_liquidacion_nomina",$Campos);
		return $Data -> GetData();
	}

	public function GetPeriodoContable($Conex){
		return $this -> DbFetchAll("SELECT periodo_contable_id AS value, anio AS text FROM periodo_contable",$Conex,
		$ErrDb = false);
	}


	public function GetQueryParametrosLiquidacionGrid(){

	$Query = "
	SELECT 
	(SELECT anio FROM periodo_contable WHERE  periodo_contable_id=d.periodo_contable_id) AS periodo,
	d.dias_lab,
	d.dias_lab_mes,
	d.horas_dia,
	d.horas_lab_dia,
	d.val_hr_corriente,
	 d.salrio,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_sal_id) AS puc_admon_sal,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_sal_id) AS puc_ventas_sal,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_sal_id) AS puc_produ_sal,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_sal_id) AS puc_contra_sal_id,
	d.sub_transporte,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_trans_id) AS puc_admon_trans,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_trans_id) AS puc_ventas_trans,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_trans_id) AS puc_produ_trans,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_trans_id) AS puc_contra_trans,
	d.desc_emple_salud,
	d.desc_empre_salud,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_salud_id) AS puc_admon_salud,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_salud_id) AS puc_ventas_salud,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_salud_id) AS puc_produ_salud,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_salud_id) AS puc_contra_salud,
	d.desc_emple_pension,
	d.desc_empre_pens,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_pension_id) AS puc_admon_pension,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_pension_id) AS puc_ventas_pension,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_pension_id) AS puc_produ_pension,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_pension_id) AS puc_contra_pension,
	d.desc_empre_cesantias,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_cesan_id) AS puc_admon_cesan,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_cesan_id) AS puc_ventas_cesan,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_cesan_id) AS puc_produ_cesan,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_cesan_id) AS puc_contra_cesan,
	d.desc_empre_int_cesantias,		
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_incesan_id) AS puc_admon_incesan,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_incesan_id) AS puc_ventas_incesan,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_incesan_id) AS puc_produ_incesan,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_incesan_id) AS puc_contra_incesan,	
	 d.desc_empre_vacaciones,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_vaca_id) AS puc_admon_vaca,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_vaca_id) AS puc_ventas_vaca,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_vaca_id) AS 	puc_produ_vaca,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_vaca_id) AS puc_contra_vaca,	
	 d.desc_empre_prima_serv,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_prima_id) AS puc_admon_prima,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_prima_id) AS puc_ventas_prima,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_prima_id) AS 	puc_produ_prima,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_prima_id) AS puc_contra_prima,	
	d.desc_empre_caja_comp,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_caja_id) AS puc_admon_caja,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_caja_id) AS puc_ventas_caja,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_caja_id) AS 	puc_produ_caja,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_caja_id) AS puc_contra_caja,	
	d.desc_empre_icbf,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_icbf_id) AS puc_admon_icbf,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_icbf_id) AS puc_ventas_icbf,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_icbf_id) AS 	puc_produ_icbf,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_icbf_id) AS puc_contra_icbf,	
	 d.desc_empre_sena,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_sena_id) AS puc_admon_sena,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_sena_id) AS puc_ventas_sena,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_sena_id) AS 	puc_produ_sena,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_sena_id) AS puc_contra_sena,			
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_arl_id) AS puc_admon_arl,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_arl_id) AS puc_ventas_arl,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_arl_id) AS puc_produ_arl,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_arl_id) AS puc_contra_arl,	
	d.val_hr_ext_diurna,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_extradiu_id) AS puc_admon_extradiu,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_extradiu_id) AS puc_ventas_extradiu,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_extradiu_id) AS puc_produ_extradiu,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_extradiu_id) AS puc_contra_extradiu,	
	 d.val_hr_ext_nocturna,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_extranoc_id) AS puc_admon_extranoc,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_extranoc_id) AS puc_ventas_extranoc,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_extranoc_id) AS puc_produ_extranoc,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_extranoc_id) AS puc_contra_extranoc,		
	d.val_hr_ext_festiva_diurna,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_fesdiu_id) AS puc_admon_fesdiu,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_fesdiu_id) AS puc_ventas_fesdiu,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_fesdiu_id) AS puc_produ_fesdiu,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_fesdiu_id) AS puc_contra_fesdiu,	
	d.val_hr_ext_festiva_nocturna,		
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_fesnoc_id) AS puc_admon_fesnoc,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_fesnoc_id) AS puc_ventas_fesnoc,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_fesnoc_id) AS puc_produ_fesnoc,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_fesnoc_id) AS puc_contra_fesnoc,	
	d.val_recargo_nocturna,	
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_recnoc_id) AS puc_admon_recnoc,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_recnoc_id) AS puc_ventas_recnoc,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_recnoc_id) AS puc_produ_recnoc,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_recnoc_id) AS puc_contra_recnoc			
	
	FROM parametros_liquidacion_nomina  d";
		return $Query;
	}
}
?>
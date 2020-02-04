<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class BasesModel extends Db{

	private $UserId;
	private $Permisos;

	public function SetUsuarioId($UserId,$CodCId){
		$this -> Permisos = new PermisosForm();
		$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
	}

	public function getPermiso($ActividadId,$Permiso,$Conex){
		return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
	}

	public function selectDatosBasesId($id_datos,$Conex){

		$select = "
		SELECT d.*,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_sal_id) AS puc_admon_sal,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_sal_id) AS puc_ventas_sal,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_sal_id) AS puc_produ_sal,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_sal_id) AS puc_contra_sal,			
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_trans_id) AS puc_admon_trans,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_trans_id) AS puc_ventas_trans,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_trans_id) AS puc_produ_trans,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_trans_id) AS puc_contra_trans,			
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_nos_id) AS puc_admon_nos,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_nos_id) AS puc_ventas_nos,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_nos_id) AS puc_produ_nos,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_nos_id) AS puc_contra_nos,			
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_salud_id) AS puc_admon_salud,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_salud_id) AS puc_ventas_salud,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_salud_id) AS puc_produ_salud,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_salud_id) AS puc_contra_salud,			
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_pension_id) AS puc_admon_pension,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_pension_id) AS puc_ventas_pension,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_pension_id) AS puc_produ_pension,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_pension_id) AS puc_contra_pension,			
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_cesan_id) AS puc_admon_cesan,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_cesan_id) AS puc_ventas_cesan,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_cesan_id) AS puc_produ_cesan,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_cesan_id) AS puc_contra_cesan,			
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_incesan_id) AS puc_admon_incesan,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_incesan_id) AS puc_ventas_incesan,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_incesan_id) AS puc_produ_incesan,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_incesan_id) AS puc_contra_incesan,			
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_vaca_id) AS puc_admon_vaca,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_vaca_id) AS puc_ventas_vaca,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_vaca_id) AS 	puc_produ_vaca,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_vaca_id) AS puc_contra_vaca,			
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_prima_id) AS puc_admon_prima,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_prima_id) AS puc_ventas_prima,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_prima_id) AS 	puc_produ_prima,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_prima_id) AS puc_contra_prima,			
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_caja_id) AS puc_admon_caja,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_caja_id) AS puc_ventas_caja,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_caja_id) AS 	puc_produ_caja,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_caja_id) AS puc_contra_caja,			
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_icbf_id) AS puc_admon_icbf,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_icbf_id) AS puc_ventas_icbf,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_icbf_id) AS 	puc_produ_icbf,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_icbf_id) AS puc_contra_icbf,			
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_sena_id) AS puc_admon_sena,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_sena_id) AS puc_ventas_sena,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_sena_id) AS 	puc_produ_sena,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_sena_id) AS puc_contra_sena,			
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_arl_id) AS puc_admon_arl,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_arl_id) AS puc_ventas_arl,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_arl_id) AS puc_produ_arl,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_arl_id) AS puc_contra_arl,			
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_extradiu_id) AS puc_admon_extradiu,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_extradiu_id) AS puc_ventas_extradiu,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_extradiu_id) AS puc_produ_extradiu,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_extradiu_id) AS puc_contra_extradiu,			
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_extranoc_id) AS puc_admon_extranoc,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_extranoc_id) AS puc_ventas_extranoc,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_extranoc_id) AS puc_produ_extranoc,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_extranoc_id) AS puc_contra_extranoc,			
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_fesdiu_id) AS puc_admon_fesdiu,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_fesdiu_id) AS puc_ventas_fesdiu,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_fesdiu_id) AS puc_produ_fesdiu,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_fesdiu_id) AS puc_contra_fesdiu,			
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_fesnoc_id) AS puc_admon_fesnoc,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_fesnoc_id) AS puc_ventas_fesnoc,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_fesnoc_id) AS puc_produ_fesnoc,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_fesnoc_id) AS puc_contra_fesnoc,			
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_recnoc_id) AS puc_admon_recnoc,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_recnoc_id) AS puc_ventas_recnoc,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_recnoc_id) AS puc_produ_recnoc,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_recnoc_id) AS puc_contra_recnoc,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_recdoc_id) AS puc_admon_recdoc,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_recdoc_id) AS puc_ventas_recdoc,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_recdoc_id) AS puc_produ_recdoc,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_recdoc_id) AS puc_contra_recdoc,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_indem_id) AS puc_admon_indem,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_indem_id) AS puc_ventas_indem,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_indem_id) AS puc_produ_indem,
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_indem_id) AS puc_contra_indem,
		
		(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_fonpension_id) AS puc_contra_fonpension,
		
		(SELECT razon_social FROM tercero WHERE tercero_id=d.tercero_icbf_id) AS tercero_icbf,
		(SELECT razon_social FROM tercero WHERE tercero_id=d.tercero_sena_id) AS tercero_sena,		
		
		REPLACE(REPLACE(REPLACE(FORMAT(d.desc_emple_salud, 2), '.', '@'), ',', '.'), '@', ',') AS desc_emple_salud,
		REPLACE(REPLACE(REPLACE(FORMAT(d.desc_empre_salud, 2), '.', '@'), ',', '.'), '@', ',') AS desc_empre_salud,		
		REPLACE(REPLACE(REPLACE(FORMAT(d.desc_emple_pension, 2), '.', '@'), ',', '.'), '@', ',') AS desc_emple_pension,
		REPLACE(REPLACE(REPLACE(FORMAT(d.desc_empre_pens, 2), '.', '@'), ',', '.'), '@', ',') AS desc_empre_pens,		
		REPLACE(REPLACE(REPLACE(FORMAT(d.desc_empre_cesantias, 2), '.', '@'), ',', '.'), '@', ',') AS desc_empre_cesantias,
		REPLACE(REPLACE(REPLACE(FORMAT(d.desc_empre_int_cesantias, 2), '.', '@'), ',', '.'), '@', ',') AS desc_empre_int_cesantias,
		REPLACE(REPLACE(REPLACE(FORMAT(d.desc_empre_vacaciones, 2), '.', '@'), ',', '.'), '@', ',') AS desc_empre_vacaciones,		
		REPLACE(REPLACE(REPLACE(FORMAT(d.desc_empre_prima_serv, 2), '.', '@'), ',', '.'), '@', ',') AS desc_empre_prima_serv,
		REPLACE(REPLACE(REPLACE(FORMAT(d.desc_empre_caja_comp, 2), '.', '@'), ',', '.'), '@', ',') AS desc_empre_caja_comp,
		REPLACE(REPLACE(REPLACE(FORMAT(d.desc_empre_icbf, 2), '.', '@'), ',', '.'), '@', ',') AS desc_empre_icbf,		
		REPLACE(REPLACE(REPLACE(FORMAT(d.desc_empre_sena, 2), '.', '@'), ',', '.'), '@', ',') AS desc_empre_sena		
		
		FROM datos_periodo d 
		WHERE d.id_datos = $id_datos"; 

		$result    = $this -> DbFetchAll($select,$Conex);
		return $result;
	}

	public function Save($Campos,$Conex){
		
		$periodo_contable_id = $_REQUEST['periodo_contable_id'];
		$select = "
		SELECT d.id_datos
		FROM datos_periodo d 
		WHERE d.periodo_contable_id = $periodo_contable_id";
		$result    = $this -> DbFetchAll($select,$Conex);

		if($result[0]['id_datos']>0){ exit('El periodo seleccionado Tiene una Configuracion Previa'); }		
		
		$this -> Begin($Conex);
			$id_datos   = $this -> DbgetMaxConsecutive("datos_periodo","id_datos",$Conex,true,1);
			$this -> assignValRequest('id_datos',$id_datos);
			$this -> DbInsertTable("datos_periodo",$Campos,$Conex,true,false);
		$this -> Commit($Conex);
	}

	public function Update($Campos,$Conex){
		$this -> Begin($Conex);
			if($_REQUEST['id_datos'] == 'NULL'){
				$this -> DbInsertTable("datos_periodo",$Campos,$Conex,true,false);
			}else{
				$this -> DbUpdateTable("datos_periodo",$Campos,$Conex,true,false);
			}
		$this -> Commit($Conex);
	}

	public function Delete($Campos,$Conex){
		$this -> DbDeleteTable("datos_periodo",$Campos,$Conex,true,false);
	}

	public function ValidateRow($Conex,$Campos){
		require_once("../../../framework/clases/ValidateRowClass.php");
		$Data = new ValidateRow($Conex,"datos_periodo",$Campos);
		return $Data -> GetData();
	}

	public function GetPeriodoContable($Conex){
		return $this -> DbFetchAll("SELECT periodo_contable_id AS value, anio AS text FROM periodo_contable",$Conex,
		$ErrDb = false);
	}

  public function getTiposDocumentoContable($Conex){
	  
	$select = "SELECT tipo_documento_id AS value,nombre AS text FROM tipo_de_documento WHERE de_niif=0 ORDER BY nombre 	ASC";
	$result = $this  -> DbFetchAll($select,$Conex);
	
	return $result;
  }

	public function GetQueryBasesGrid(){

	$Query = "
	SELECT 
	(SELECT anio FROM periodo_contable WHERE  periodo_contable_id=d.periodo_contable_id) AS periodo,
	d.dias_lab,
	d.dias_lab_mes,
	d.horas_dia,
	d.horas_lab_dia,
	d.val_hr_corriente,
	d.limite_subsidio,
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
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_recnoc_id) AS puc_contra_recnoc,
	d.dias_anio_indem,
	d.dias_2anio_indem,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_admon_indem_id) AS puc_admon_indem,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_ventas_indem_id) AS puc_ventas_indem,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_produ_indem_id) AS puc_produ_indem,
	(SELECT CONCAT_WS('',codigo_puc,'-',nombre) FROM puc WHERE puc_id=d.puc_contra_indem_id) AS puc_contra_indem

	FROM datos_periodo  d";
		return $Query;
	}
}
?>
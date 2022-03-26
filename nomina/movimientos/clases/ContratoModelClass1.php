<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ContratoModel extends Db{

	private $UserId;
	private $Permisos;

	public function SetUsuarioId($UserId,$CodCId){
		$this -> Permisos = new PermisosForm();
		$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
	}

	public function getPermiso($ActividadId,$Permiso,$Conex){
		return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
	}

	public function selectDatosContratoId($contrato_id,$Conex){
		$select ="SELECT	c.*,
			(SELECT CONCAT_WS(' ', t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, empleado e
			 WHERE t.tercero_id=e.tercero_id AND c.empleado_id=e.empleado_id)AS empleado,
			(SELECT nombre_cargo FROM cargo WHERE cargo_id=c.cargo_id) AS cargo,
			(SELECT CONCAT_WS(' ', t.numero_identificacion, ' - ' ,t.razon_social) FROM empresa_prestaciones e, tercero t WHERE e.empresa_id=c.empresa_eps_id AND t.tercero_id=e.tercero_id ) AS empresa_eps,
			(SELECT CONCAT_WS(' ', t.numero_identificacion, ' - ' ,t.razon_social) FROM empresa_prestaciones e, tercero t WHERE e.empresa_id=c.empresa_pension_id AND t.tercero_id=e.tercero_id ) AS empresa_pension,			
			(SELECT CONCAT_WS(' ', t.numero_identificacion, ' - ' ,t.razon_social) FROM empresa_prestaciones e, tercero t WHERE e.empresa_id=c.empresa_arl_id AND t.tercero_id=e.tercero_id ) AS empresa_arl,
			(SELECT CONCAT_WS(' ', t.numero_identificacion, ' - ' ,t.razon_social) FROM empresa_prestaciones e, tercero t WHERE e.empresa_id=c.empresa_caja_id AND t.tercero_id=e.tercero_id ) AS empresa_caja,
			(SELECT CONCAT_WS(' ', t.numero_identificacion, ' - ' ,t.razon_social) FROM empresa_prestaciones e, tercero t WHERE e.empresa_id=c.empresa_cesan_id AND t.tercero_id=e.tercero_id ) AS empresa_cesan,
			(SELECT tipo FROM tipo_contrato WHERE tipo_contrato_id=c.tipo_contrato_id) AS tipo,
			(SELECT prestaciones_sociales FROM tipo_contrato WHERE tipo_contrato_id=c.tipo_contrato_id) AS prestaciones_sociales
			
		FROM contrato c	WHERE	c.contrato_id = $contrato_id "; 
		$result    = $this -> DbFetchAll($select,$Conex);
		return $result;
	}

	public function selectTipoContratoId($tipo_contrato_id,$Conex){
		$select ="SELECT *	FROM tipo_contrato	WHERE	tipo_contrato_id = $tipo_contrato_id"; 
		$result    = $this -> DbFetchAll($select,$Conex,true);
		return $result[0];
	}


	public function Save($Campos,$Conex){
		$this -> Begin($Conex);
			$contrato_id    = $this -> DbgetMaxConsecutive("contrato","contrato_id",$Conex,true,1);
			$this -> assignValRequest('contrato_id',$contrato_id);
			$this -> DbInsertTable("contrato",$Campos,$Conex,true,false);
			
	  	   	$empresa_eps_id = $this -> requestDataForQuery('empresa_eps_id','integer');
	  	   	$empresa_pension_id = $this -> requestDataForQuery('empresa_pension_id','integer');
			$empresa_arl_id = $this -> requestDataForQuery('empresa_arl_id','integer');
			$empresa_caja_id = $this -> requestDataForQuery('empresa_caja_id','integer');			
			$empresa_cesan_id = $this -> requestDataForQuery('empresa_cesan_id','integer');
			$fecha_inicio = $this -> requestDataForQuery('fecha_inicio','date');			
			
			if($empresa_eps_id>0){
				$contrato_afiliacion_id    = $this -> DbgetMaxConsecutive("contrato_afiliacion","contrato_afiliacion_id",$Conex,true,1);
				$insert = "INSERT INTO contrato_afiliacion (contrato_afiliacion_id,empresa_id,salud,fecha_inicio,contrato_id) 
								VALUES ($contrato_afiliacion_id,$empresa_eps_id,1,$fecha_inicio,$contrato_id)"; 
				$this -> query($insert,$Conex,true);			
			}
			if($empresa_pension_id>0){
				$contrato_afiliacion_id    = $this -> DbgetMaxConsecutive("contrato_afiliacion","contrato_afiliacion_id",$Conex,true,1);
				$insert = "INSERT INTO contrato_afiliacion (contrato_afiliacion_id,empresa_id,pension,fecha_inicio,contrato_id) 
								VALUES ($contrato_afiliacion_id,$empresa_pension_id,1,$fecha_inicio,$contrato_id)"; 
				$this -> query($insert,$Conex,true);			
			}
			if($empresa_arl_id>0){
				$contrato_afiliacion_id    = $this -> DbgetMaxConsecutive("contrato_afiliacion","contrato_afiliacion_id",$Conex,true,1);
				$insert = "INSERT INTO contrato_afiliacion (contrato_afiliacion_id,empresa_id,arl,fecha_inicio,contrato_id) 
								VALUES ($contrato_afiliacion_id,$empresa_arl_id,1,$fecha_inicio,$contrato_id)"; 
				$this -> query($insert,$Conex,true);			
			}
			if($empresa_caja_id>0){
				$contrato_afiliacion_id    = $this -> DbgetMaxConsecutive("contrato_afiliacion","contrato_afiliacion_id",$Conex,true,1);
				$insert = "INSERT INTO contrato_afiliacion (contrato_afiliacion_id,empresa_id,caja_compensacion,fecha_inicio,contrato_id) 
								VALUES ($contrato_afiliacion_id,$empresa_caja_id,1,$fecha_inicio,$contrato_id)"; 
				$this -> query($insert,$Conex,true);			
			}

			if($empresa_cesan_id>0){
				$contrato_afiliacion_id    = $this -> DbgetMaxConsecutive("contrato_afiliacion","contrato_afiliacion_id",$Conex,true,1);
				$insert = "INSERT INTO contrato_afiliacion (contrato_afiliacion_id,empresa_id,cesantias,fecha_inicio,contrato_id) 
								VALUES ($contrato_afiliacion_id,$empresa_cesan_id,1,$fecha_inicio,$contrato_id)"; 
				$this -> query($insert,$Conex,true);			
			}
			if($empresa_cesan_id>0){
				$contrato_afiliacion_id    = $this -> DbgetMaxConsecutive("contrato_afiliacion","contrato_afiliacion_id",$Conex,true,1);
				$insert = "INSERT INTO contrato_afiliacion (contrato_afiliacion_id,empresa_id,cesantias,fecha_inicio,contrato_id) 
								VALUES ($contrato_afiliacion_id,$empresa_cesan_id,1,$fecha_inicio,$contrato_id)"; 
				$this -> query($insert,$Conex,true);			
			}

		$this -> Commit($Conex);
	}

	public function Update($Campos,$Conex){
		$this -> Begin($Conex);
			if($_REQUEST['contrato_id'] == 'NULL'){
				$this -> DbInsertTable("contrato",$Campos,$Conex,true,false);
			}else{
				$this -> DbUpdateTable("contrato",$Campos,$Conex,true,false);
			}
		$this -> Commit($Conex);
	}

	public function Delete($Campos,$Conex){
		$this -> DbDeleteTable("contrato",$Campos,$Conex,true,false);
	}

	public function ValidateRow($Conex,$Campos){
		require_once("../../../framework/clases/ValidateRowClass.php");
		$Data = new ValidateRow($Conex,"contrato",$Campos);
		return $Data -> GetData();
	}

	public function GetCosto($Conex){
		return $this -> DbFetchAll("SELECT centro_de_costo_id  AS value, nombre AS text FROM centro_de_costo ORDER BY nombre ASC",$Conex,
		$ErrDb = false);
	}

	public function GetCausal($Conex){
		return $this -> DbFetchAll("SELECT causal_despido_id  AS value, nombre AS text FROM causal_despido WHERE estado='A' ORDER BY nombre ASC",$Conex,
		$ErrDb = false);
	}
	
	public function GetTip($Conex){
		return $this -> DbFetchAll("SELECT tipo_contrato_id  AS value, nombre AS text FROM tipo_contrato ORDER BY nombre ASC",$Conex,
		$ErrDb = false);
	}
	
	public function GetMot($Conex){
		return $this -> DbFetchAll("SELECT motivo_terminacion_id  AS value, nombre AS text FROM motivo_terminacion ORDER BY nombre ASC",$Conex,
		$ErrDb = false);
	}

	public function GetQueryContratoGrid(){

		$Query = "SELECT
			c.contrato_id,
			c.numero_contrato,
			c.fecha_inicio,
			c.fecha_terminacion,
			c.fecha_terminacion_real,
			(SELECT CONCAT_WS(' ', t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, empleado e
			 WHERE t.tercero_id=e.tercero_id AND c.empleado_id=e.empleado_id)AS empleado_id,
			(SELECT nombre FROM tipo_contrato WHERE tipo_contrato_id=c.tipo_contrato_id)AS tipo_contrato_id,
			(SELECT nombre_cargo FROM cargo WHERE cargo_id=c.cargo_id)AS cargo_id,
			(SELECT nombre FROM motivo_terminacion WHERE motivo_terminacion_id=c.motivo_terminacion_id)AS motivo_terminacion_id,
			c.sueldo_base,
			c.subsidio_transporte,
			(SELECT nombre FROM centro_de_costo co WHERE co.centro_de_costo_id=c.centro_de_costo_id)AS centro_de_costo_id,
			CASE periodicidad WHEN 'H' THEN 'HORAS' WHEN 'D' THEN 'DIAS' WHEN 'S' THEN 'SEMANAL' WHEN 'Q' THEN 'QUINCENAL' ELSE 'MENSUAL' END AS periodicidad,
			(SELECT nombre FROM causal_despido ca WHERE ca.causal_despido_id=c.causal_despido_id)AS causal_despido_id,
			CASE estado WHEN 'A' THEN 'ACTIVO' WHEN 'R' THEN 'RETIRADO' WHEN 'F' THEN 'FINALIZADO'  WHEN 'AN' THEN 'ANULADO' WHEN 'L' THEN 'LICENCIA' ELSE '' END AS estado

		FROM
			contrato c
		";
		return $Query;
	}
}
?>
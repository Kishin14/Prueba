<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class CargoModel extends Db{

	private $UserId;
	private $Permisos;

	public function SetUsuarioId($UserId,$CodCId){
		$this -> Permisos = new PermisosForm();
		$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
	}

	public function getPermiso($ActividadId,$Permiso,$Conex){
		return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
	}

	public function selectDatosCargoId($cargo_id,$Conex){
		$select ="SELECT
			cargo_id,
			nombre_cargo,
			categoria_arl_id,
			base
		FROM
			cargo t
		WHERE
			t.cargo_id = $cargo_id
		";
		// echo "$select";
		$result    = $this -> DbFetchAll($select,$Conex);
		return $result;
	}

	public function Save($Campos,$Conex){
		$this -> Begin($Conex);
			$cargo_id    = $this -> DbgetMaxConsecutive("cargo","cargo_id",$Conex,true,1);
			$this -> assignValRequest('cargo_id',$cargo_id);
			$this -> DbInsertTable("cargo",$Campos,$Conex,true,false);
		$this -> Commit($Conex);
	}

	public function Update($Campos,$Conex){
		$this -> Begin($Conex);
			if($_REQUEST['cargo_id'] == 'NULL'){
				$this -> DbInsertTable("cargo",$Campos,$Conex,true,false);
			}else{
				$this -> DbUpdateTable("cargo",$Campos,$Conex,true,false);
			}
		$this -> Commit($Conex);
	}

	public function Delete($Campos,$Conex){
		$this -> DbDeleteTable("cargo",$Campos,$Conex,true,false);
	}

	public function ValidateRow($Conex,$Campos){
		require_once("../../../framework/clases/ValidateRowClass.php");
		$Data = new ValidateRow($Conex,"cargo",$Campos);
		return $Data -> GetData();
	}

	public function GetARL($Conex){
		return $this -> DbFetchAll("SELECT categoria_arl_id  AS value,CONCAT_WS('',clase_riesgo,'-  % ',porcentaje) AS text FROM categoria_arl WHERE estado = 'A'",$Conex,
		$ErrDb = false);
	}

	public function GetQueryCargoGrid(){

		$Query = "SELECT
			cargo_id,
			nombre_cargo,
			base,
			(SELECT clase_riesgo FROM categoria_arl WHERE categoria_arl_id=t.categoria_arl_id) AS categoria_arl_id
		FROM
			cargo t
		";
		return $Query;
	}
}
?>
<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ConvocatoriaModel extends Db{

	private $UserId;
	private $Permisos;

	public function SetUsuarioId($UserId,$CodCId){
		$this -> Permisos = new PermisosForm();
		$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
	}

	public function getPermiso($ActividadId,$Permiso,$Conex){
		return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
	}

	public function selectDatosConvocatoriaId($convocatoria_id,$Conex){
		$select ="SELECT
			convocatoria_id,
			fecha_apertura,
			fecha_cierre,
			estado,
			cargo_id
		FROM
			convocatoria
		WHERE
			convocatoria_id = $convocatoria_id
		";
		$result    = $this -> DbFetchAll($select,$Conex);
		return $result;
	}

	public function Save($Campos,$Conex){
		$this -> Begin($Conex);
			$convocatoria_id    = $this -> DbgetMaxConsecutive("convocatoria","convocatoria_id",$Conex,true,1);
			$this -> assignValRequest('convocatoria_id',$convocatoria_id);
			$this -> DbInsertTable("convocatoria",$Campos,$Conex,true,false);
		$this -> Commit($Conex); 
	}

	public function Update($Campos,$Conex){
		$this -> Begin($Conex);
			if($_REQUEST['convocatoria_id'] == 'NULL'){
				$this -> DbInsertTable("convocatoria",$Campos,$Conex,true,false);
			}else{
				$this -> DbUpdateTable("convocatoria",$Campos,$Conex,true,false);
			}
		$this -> Commit($Conex);
	}

	public function Delete($Campos,$Conex){
		$this -> DbDeleteTable("convocatoria",$Campos,$Conex,true,false);
	}

	public function ValidateRow($Conex,$Campos){
		require_once("../../../framework/clases/ValidateRowClass.php");
		$Data = new ValidateRow($Conex,"convocatoria",$Campos);
		return $Data -> GetData();
	}

	public function Getcargo($Conex){
		return $this -> DbFetchAll("SELECT cargo_id  AS value, nombre_cargo AS text FROM cargo",$Conex,
		$ErrDb = false);
	}

	

	public function GetQueryConvocatoriaGrid(){

		$Query = "SELECT
			 fecha_apertura,
			 fecha_cierre,
			 (select nombre_cargo FROM cargo WHERE cargo_id = c.cargo_id) AS cargo,
			
			
			IF(estado='1','ACTIVO','INACTIVO') AS estado 

		FROM
			convocatoria c
		";
		return $Query;
	}
}
?>
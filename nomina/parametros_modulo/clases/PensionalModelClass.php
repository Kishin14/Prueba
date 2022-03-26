<?php
	require_once("../../../framework/clases/DbClass.php");
	require_once("../../../framework/clases/PermisosFormClass.php");
	final class PensionalModel extends Db{
		private $UserId;
		private $Permisos;
		public function SetUsuarioId($UserId,$CodCId){
			$this -> Permisos = new PermisosForm();
			$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
		}
		public function getPermiso($ActividadId,$Permiso,$Conex){
			return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
		}
		public function selectDatosPensionalId($fondo_pensional_id,$Conex){
			$select ="SELECT
				fondo_pensional_id,
				porcentaje,
				rango_ini,
				rango_fin,
				periodo_contable_id
			FROM
				fondo_pensional t
			WHERE
				t.fondo_pensional_id = $fondo_pensional_id
			";
			$result    = $this -> DbFetchAll($select,$Conex);
			return $result;
		}
		public function Save($Campos,$Conex){
			$this -> Begin($Conex);
				$fondo_pensional_id    = $this -> DbgetMaxConsecutive("fondo_pensional","fondo_pensional_id",$Conex,true,1);
				$this -> assignValRequest('fondo_pensional_id',$fondo_pensional_id);
				$this -> DbInsertTable("fondo_pensional",$Campos,$Conex,true,false);
			$this -> Commit($Conex);
		}
		public function Update($Campos,$Conex){
			$this -> Begin($Conex);
				if($_REQUEST['fondo_pensional_id'] == 'NULL'){
					$this -> DbInsertTable("fondo_pensional",$Campos,$Conex,true,false);
				}else{
					$this -> DbUpdateTable("fondo_pensional",$Campos,$Conex,true,false);
				}
			$this -> Commit($Conex);
		}
		public function Delete($Campos,$Conex){
			$this -> DbDeleteTable("fondo_pensional",$Campos,$Conex,true,false);
		}
		public function ValidateRow($Conex,$Campos){
			require_once("../../../framework/clases/ValidateRowClass.php");
			$Data = new ValidateRow($Conex,"fondo_pensional",$Campos);
			return $Data -> GetData();
		}
		public function GetPeriodo($Conex){
			return $this -> DbFetchAll("SELECT periodo_contable_id  AS value,anio AS text FROM periodo_contable WHERE estado = '1'",$Conex,
			$ErrDb = false);
		}
		public function GetQueryPensionalGrid(){
			$Query = "SELECT
				fondo_pensional_id,
				porcentaje,
				rango_ini,
				rango_fin,
				(SELECT anio FROM periodo_contable WHERE periodo_contable_id=t.periodo_contable_id) AS periodo_contable_id
			FROM
				fondo_pensional t
			";
			return $Query;
		}
	}
?>
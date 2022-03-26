<?php

	require_once("../../../framework/clases/DbClass.php");
	require_once("../../../framework/clases/PermisosFormClass.php");

	final class LiquidacionModel extends Db{

		private $UserId;
		private $Permisos;

		public function SetUsuarioId($UserId,$CodCId){
			$this -> Permisos = new PermisosForm();
			$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
		}

		public function getPermiso($ActividadId,$Permiso,$Conex){
			return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
		}

		public function selectDatosLiquidacionId($id_liquidacion,$Conex){

			$select ="SELECT tipo_concepto_laboral_id,
			(SELECT CONCAT(p.codigo_puc,' - ',p.nombre) FROM puc p WHERE p.puc_id=contrapartida_puc_id) AS contrapartida FROM parametro_liquidacion WHERE parametro_liquidacion_id = ".$id_liquidacion;

			$result    = $this -> DbFetchAll($select,$Conex);
			return $result;
		}

		public function Save($Campos,$Conex){

			$this -> Begin($Conex);
				$id   = $this -> DbgetMaxConsecutive("parametro_liquidacion","parametro_liquidacion_id",$Conex,true,1);
				$this -> assignValRequest('parametro_liquidacion_id',$id);
				$this -> DbInsertTable("parametro_liquidacion",$Campos,$Conex,true,false);
			$this -> Commit($Conex);
		}

		public function Update($Campos,$Conex){
			$this -> Begin($Conex);
				if($_REQUEST['id_liquidacion'] == 'NULL'){
					$this -> DbInsertTable("parametro_liquidacion",$Campos,$Conex,true,false);
				}else{
					$this -> DbUpdateTable("parametro_liquidacion",$Campos,$Conex,true,false);
				}
			$this -> Commit($Conex);
		}

		public function Delete($Campos,$Conex){
			$this -> DbDeleteTable("parametro_liquidacion",$Campos,$Conex,true,false);
		}

		public function ValidateRow($Conex,$Campos){
			require_once("../../../framework/clases/ValidateRowClass.php");
			$Data = new ValidateRow($Conex,"parametro_liquidacion",$Campos);
			return $Data -> GetData();
		}

		/*public function GetPuc($Conex){
			return $this -> DbFetchAll("SELECT puc_id AS value, nombre AS text FROM puc",$Conex,
			$ErrDb = false);
		}*/

		public function GetTipo($Conex){
			return $this -> DbFetchAll("SELECT tipo_concepto_laboral_id  AS value, concepto AS text FROM tipo_concepto",$Conex,
			$ErrDb = false);
		}

		public function GetQueryLiquidacionGrid(){

			$Query = "SELECT par.parametro_liquidacion_id, puc.nombre AS nombre_concepto, conc.concepto AS tipo FROM parametro_liquidacion par INNER JOIN tipo_concepto conc ON par.tipo_concepto_laboral_id = conc.tipo_concepto_laboral_id INNER JOIN puc ON par.contrapartida_puc_id = puc_id";
			return $Query;
		}
	}
?>
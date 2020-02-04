<?php

	require_once("../../../framework/clases/DbClass.php");
	require_once("../../../framework/clases/PermisosFormClass.php");

	final class UVTModel extends Db{

		private $UserId;
		private $Permisos;

		public function SetUsuarioId($UserId,$CodCId){
			$this -> Permisos = new PermisosForm();
			$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
		}

		public function getPermiso($ActividadId,$Permiso,$Conex){
			return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
		}

		public function selectDatosUVTId($id_uvt,$Conex){
			$select ="SELECT
				id_uvt,
				periodo_contable_id,
				uvt_nominal,
				utv_minimo,
				impuesto_id
			FROM
				uvt t
			WHERE
				t.id_uvt = $id_uvt
			";
			$result    = $this -> DbFetchAll($select,$Conex);
			return $result;
		}

		public function Save($Campos,$Conex){
			$this -> Begin($Conex);
				$id_uvt    = $this -> DbgetMaxConsecutive("uvt","id_uvt",$Conex,true,1);
				$this -> assignValRequest('id_uvt',$id_uvt);
				$this -> DbInsertTable("uvt",$Campos,$Conex,true,false);
			$this -> Commit($Conex);
		}

		public function Update($Campos,$Conex){
			$this -> Begin($Conex);
				if($_REQUEST['id_uvt'] == 'NULL'){
					$this -> DbInsertTable("uvt",$Campos,$Conex,true,false);
				}else{
					$this -> DbUpdateTable("uvt",$Campos,$Conex,true,false);
				}
			$this -> Commit($Conex);
		}

		public function Delete($Campos,$Conex){
			$this -> DbDeleteTable("uvt",$Campos,$Conex,true,false);
		}

		public function ValidateRow($Conex,$Campos){
			require_once("../../../framework/clases/ValidateRowClass.php");
			$Data = new ValidateRow($Conex,"uvt",$Campos);
			return $Data -> GetData();
		}

		public function GetPeriodo($Conex){
			return $this -> DbFetchAll("SELECT periodo_contable_id  AS value,anio AS text FROM periodo_contable WHERE estado = '1'",$Conex,
			$ErrDb = false);
		}

		public function GetImpuesto($Conex){
			return $this -> DbFetchAll("SELECT impuesto_id  AS value,nombre AS text FROM impuesto WHERE estado = 'A'",$Conex,
			$ErrDb = false);
		}

		public function GetQueryUVTGrid(){

			$Query = "SELECT
				id_uvt,
				(SELECT anio FROM periodo_contable WHERE periodo_contable_id=t.periodo_contable_id) AS periodo_contable_id,
				uvt_nominal,
				utv_minimo,
				(SELECT nombre FROM impuesto WHERE impuesto_id=t.impuesto_id) AS impuesto_id
			FROM
				uvt t
			";
			return $Query;
		}
	}
?>
<?php

	require_once("../../../framework/clases/DbClass.php");
	require_once("../../../framework/clases/PermisosFormClass.php");

	final class ContableModel extends Db{

		private $UserId;
		private $Permisos;

		public function SetUsuarioId($UserId,$CodCId){
			$this -> Permisos = new PermisosForm();
			$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
		}

		public function getPermiso($ActividadId,$Permiso,$Conex){
			return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
		}

		public function selectDatosContableId($concepto_area_id,$Conex){
			$select ="SELECT c.*,
				(SELECT CONCAT(p.codigo_puc,' - ',p.nombre) FROM puc p WHERE p.puc_id=c.puc_admon_id) AS puc_admon,
				(SELECT CONCAT(p.codigo_puc,' - ',p.nombre) FROM puc p WHERE p.puc_id=c.puc_ventas_id) AS puc_ventas,				
				(SELECT CONCAT(p.codigo_puc,' - ',p.nombre) FROM puc p WHERE p.puc_id=c.puc_prod_id) AS puc_prod,
				(SELECT CONCAT(p.codigo_puc,' - ',p.nombre) FROM puc p WHERE p.puc_id=c.contrapartida_puc_id) AS contrapartida,
				(SELECT CONCAT(p.codigo_puc,' - ',p.nombre) FROM puc p WHERE p.puc_id=c.puc_partida_id) AS puc_partida,
				(SELECT CONCAT(p.codigo_puc,' - ',p.nombre) FROM puc p WHERE p.puc_id=c.puc_contra_id) AS puc_contra				
			FROM concepto_area c
			WHERE c.concepto_area_id = $concepto_area_id
			";
			$result    = $this -> DbFetchAll($select,$Conex,true);
			return $result;
		}

		public function Save($Campos,$Conex){
			$this -> Begin($Conex);
				$concepto_area_id    = $this -> DbgetMaxConsecutive("concepto_area","concepto_area_id",$Conex,true,1);
				$this -> assignValRequest('concepto_area_id',$concepto_area_id);
				$this -> DbInsertTable("concepto_area",$Campos,$Conex,true,false);
			$this -> Commit($Conex);
		}

		public function Update($Campos,$Conex){
			$this -> Begin($Conex);
				if($_REQUEST['concepto_area_id'] == 'NULL'){
					$this -> DbInsertTable("concepto_area",$Campos,$Conex,true,false);
				}else{
					$this -> DbUpdateTable("concepto_area",$Campos,$Conex,true,false);
				}
			$this -> Commit($Conex);
		}

		public function Delete($Campos,$Conex){
			$this -> DbDeleteTable("concepto_area",$Campos,$Conex,true,false);
		}

		public function ValidateRow($Conex,$Campos){
			require_once("../../../framework/clases/ValidateRowClass.php");
			$Data = new ValidateRow($Conex,"concepto_area",$Campos);
			return $Data -> GetData();
		}


		public function GetQueryContableGrid(){

			$Query = "SELECT c.descripcion,
				(SELECT CONCAT(p.codigo_puc,' - ',p.nombre) FROM puc p WHERE p.puc_id=c.puc_admon_id) AS puc_admon,
				c.naturaleza_admon,
				(SELECT CONCAT(p.codigo_puc,' - ',p.nombre) FROM puc p WHERE p.puc_id=c.puc_ventas_id) AS puc_ventas,				
				c.naturaleza_ventas,
				(SELECT CONCAT(p.codigo_puc,' - ',p.nombre) FROM puc p WHERE p.puc_id=c.puc_prod_id) AS puc_prod,
				c.naturaleza_prod,
				(SELECT CONCAT(p.codigo_puc,' - ',p.nombre) FROM puc p WHERE p.puc_id=c.contrapartida_puc_id) AS contrapartida,
				c.naturaleza_contrapartida,
				c.base_salarial,
				IF(tipo_calculo='P','PORCENTAJE','ABSOLUTO') AS tipo_calculo,
				IF(estado='A','ACTIVO','INACTIVO') AS estado

			FROM	concepto_area c
			";
			return $Query;
		}
	}
?>
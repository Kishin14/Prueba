<?php

	require_once("../../../framework/clases/DbClass.php");
	require_once("../../../framework/clases/PermisosFormClass.php");

	final class PruebaModel extends Db{

		private $UserId;
		private $Permisos;

		public function SetUsuarioId($UserId,$CodCId){
			$this -> Permisos = new PermisosForm();
			$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
		}

		public function getPermiso($ActividadId,$Permiso,$Conex){
			return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
		}

		public function selectDatosPruebaId($prueba_id,$Conex){
			$select ="SELECT p.*,
				p.prueba_id,
				p.nombre,
				p.observacion,
				p.resultado,
				p.base,
				p.convocado_id,
				(SELECT CONCAT_WS(' ', c.primer_nombre,c.segundo_nombre,c.primer_apellido,c.segundo_apellido ) FROM convocado c)AS convocado, 
				p.fecha	
				FROM
				prueba p  
				WHERE
				p.prueba_id = $prueba_id
			";
			$result    = $this -> DbFetchAll($select,$Conex);
			return $result;
		}

		public function Save($Campos,$Conex){
			$this -> Begin($Conex);
				$prueba_id    = $this -> DbgetMaxConsecutive("prueba","prueba_id",$Conex,true,1);
				$this -> assignValRequest('prueba_id',$prueba_id);
				$this -> DbInsertTable("prueba",$Campos,$Conex,true,false);
			$this -> Commit($Conex);
		}

		public function Update($Campos,$Conex){
			$this -> Begin($Conex);
				if($_REQUEST['prueba_id'] == 'NULL'){
					$this -> DbInsertTable("prueba",$Campos,$Conex,true,false);
				}else{
					$this -> DbUpdateTable("prueba",$Campos,$Conex,true,false);
				}
			$this -> Commit($Conex);
		}

		public function Delete($Campos,$Conex){
			$this -> DbDeleteTable("prueba",$Campos,$Conex,true,false);
		}

		public function ValidateRow($Conex,$Campos){
			require_once("../../../framework/clases/ValidateRowClass.php");
			$Data = new ValidateRow($Conex,"prueba",$Campos);
			return $Data -> GetData();
		}

	

		public function GetQueryPruebaGrid(){

			$Query = "SELECT
				p.prueba_id,
				p.nombre,
				p.observacion,
				p.resultado,
				IF( p.aprobado > 0,'SI','NO')AS aprobado, 
				p.base,
				(SELECT CONCAT_WS(' ',c.primer_nombre, c.segundo_nombre, c.primer_apellido, c.segundo_apellido) FROM convocado c WHERE p.convocado_id=c.convocado_id) AS convocado_id,
				p.fecha
			FROM
				prueba p WHERE prueba_id IS NOT NULL";
			return $Query;
		}
	}
?>
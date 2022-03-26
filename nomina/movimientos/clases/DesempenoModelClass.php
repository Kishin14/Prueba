<?php

	require_once("../../../framework/clases/DbClass.php");
	require_once("../../../framework/clases/PermisosFormClass.php");

	final class DesempenoModel extends Db{

		private $UserId;
		private $Permisos;

		public function SetUsuarioId($UserId,$CodCId){
			$this -> Permisos = new PermisosForm();
			$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
		}

		public function getPermiso($ActividadId,$Permiso,$Conex){
			return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
		}

		public function selectDatosDesempenoId($causal_desempeno_empleado_id,$Conex){
			$select ="SELECT
				c.*, 	
				(SELECT CONCAT_WS(' ', t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido ) FROM tercero t, empleado em
				WHERE em.empleado_id = c.empleado_id AND t.tercero_id = em.tercero_id) AS empleado
			FROM
				causal_desempeno_empleado c
			WHERE
				c.causal_desempeno_empleado_id=$causal_desempeno_empleado_id";
			
			$result    = $this -> DbFetchAll($select,$Conex);
			return $result;
		}
		
		public function GetCausal($Conex){
  			return $this  -> DbFetchAll("SELECT causal_desempeno_id AS value,nombre AS text FROM causal_desempeno WHERE estado='A' ORDER BY nombre ASC",$Conex,$ErrDb = false);
   }

		public function Save($Campos,$Conex){
			$this -> Begin($Conex);
				$causal_desempeno_empleado_id    = $this -> DbgetMaxConsecutive("causal_desempeno_empleado","causal_desempeno_empleado_id",$Conex,true,1);
				$this -> assignValRequest('causal_desempeno_empleado_id',$causal_desempeno_empleado_id);
				$this -> DbInsertTable("causal_desempeno_empleado",$Campos,$Conex,true,false);
			$this -> Commit($Conex);
		}

		public function Update($Campos,$Conex){
			$this -> Begin($Conex);
				if($_REQUEST['causal_desempeno_empleado_id'] == 'NULL'){
					$this -> DbInsertTable("causal_desempeno_empleado",$Campos,$Conex,true,false);
				}else{
					$this -> DbUpdateTable("causal_desempeno_empleado",$Campos,$Conex,true,false);
				}
			$this -> Commit($Conex);
		}

		public function Delete($Campos,$Conex){
			$this -> DbDeleteTable("causal_desempeno_empleado",$Campos,$Conex,true,false);
		}

		public function ValidateRow($Conex,$Campos){
			require_once("../../../framework/clases/ValidateRowClass.php");
			$Data = new ValidateRow($Conex,"causal_desempeno_empleado",$Campos);
			return $Data -> GetData();
		}


		public function GetQueryDesempenoGrid(){

			$Query = "SELECT
				c.causal_desempeno_empleado_id,
				(SELECT CONCAT_WS(' ', t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido ) FROM tercero t, empleado em
				WHERE em.empleado_id = c.empleado_id AND t.tercero_id = em.tercero_id) AS empleado_id, 
				(SELECT nombre FROM causal_desempeno WHERE causal_desempeno_id= c.causal_desempeno_empleado_id) AS causal_desempeno_id,
				CASE c.resultado WHEN 'A' THEN 'APROBADO' ELSE 'NO APROBADO' END AS resultado,
				c.fecha
	
			FROM
				causal_desempeno_empleado c 
			";
			return $Query;
		}
	}
?>
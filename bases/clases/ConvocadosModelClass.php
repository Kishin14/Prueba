<?php

	require_once("../../../framework/clases/DbClass.php");
	require_once("../../../framework/clases/PermisosFormClass.php");

	final class ConvocadosModel extends Db{

		private $UserId;
		private $Permisos;

		public function SetUsuarioId($UserId,$CodCId){
			$this -> Permisos = new PermisosForm();
			$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
		}

		public function getPermiso($ActividadId,$Permiso,$Conex){
			return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
		}

		public function selectDatosConvocadosId($convocado_id,$Conex){
			$select ="SELECT
				c.convocado_id,
				c.tipo_identificacion_id,
				c.numero_identificacion,
				c.primer_nombre,
				c.segundo_nombre,
				c.primer_apellido,
				c.segundo_apellido,
				c.direccion,
				c.telefono,
				c.movil,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=c.ubicacion_id)AS ubicacion,
				c.estado,
				c.ubicacion_id
			FROM
				convocado c
			WHERE
				c.convocado_id = $convocado_id 
			";
			$result    = $this -> DbFetchAll($select,$Conex);
			return $result;
		}

		public function selectDatosConvocadosId1($numero_identificacion,$Conex){
			$select ="SELECT
				c.convocado_id,
				c.tipo_identificacion_id,
				c.numero_identificacion,
				c.primer_nombre,
				c.segundo_nombre,
				c.primer_apellido,
				c.segundo_apellido,
				c.direccion,
				c.telefono,
				c.movil,
				(SELECT u.nombre FROM ubicacion u WHERE u.ubicacion_id=c.ubicacion_id)AS ubicacion,
				c.estado,
				c.ubicacion_id
			FROM
				convocado c
			WHERE
				c.numero_identificacion=$numero_identificacion
			";
			$result    = $this -> DbFetchAll($select,$Conex);
			return $result;
		}

		public function Save($Campos,$Conex){
			$this -> Begin($Conex);
				$convocado_id    = $this -> DbgetMaxConsecutive("convocado","convocado_id",$Conex,true,1);
				$this -> assignValRequest('convocado_id',$convocado_id);
				$this -> DbInsertTable("convocado",$Campos,$Conex,true,false);
			$this -> Commit($Conex);
		}

		public function Update($Campos,$Conex){
			$this -> Begin($Conex);
				if($_REQUEST['convocado_id'] == 'NULL'){
					$this -> DbInsertTable("convocado",$Campos,$Conex,true,false);
				}else{
					$this -> DbUpdateTable("convocado",$Campos,$Conex,true,false);
				}
			$this -> Commit($Conex);
		}

		public function Delete($Campos,$Conex){
			$this -> DbDeleteTable("convocado",$Campos,$Conex,true,false);
		}

		public function ValidateRow($Conex,$Campos){
			require_once("../../../framework/clases/ValidateRowClass.php");
			$Data = new ValidateRow($Conex,"convocado",$Campos);
			return $Data -> GetData();
		}

		public function GetTip($Conex){
			return $this -> DbFetchAll("SELECT tipo_identificacion_id  AS value, nombre AS text FROM tipo_identificacion WHERE tipo_identificacion_id NOT IN (2,3) ORDER BY nombre ASC",$Conex,
			$ErrDb = false);
		}

		/*public function GetUbi($Conex){
			return $this -> DbFetchAll("SELECT ubicacion_id  AS value, nombre AS text FROM ubicacion",$Conex,
			$ErrDb = false);
		}*/

		public function GetQueryConvocadosGrid(){

			$Query = "SELECT
				convocado_id,
				(SELECT nombre FROM tipo_identificacion WHERE tipo_identificacion_id=cv.tipo_identificacion_id) AS tipo_identificacion_id,
				numero_identificacion,
				primer_nombre,
				segundo_nombre,
				primer_apellido,
				segundo_apellido,
				direccion,
				telefono,
				movil,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=cv.ubicacion_id) AS ubicacion_id,
				IF(estado='A','ACTIVO','INACTIVO') AS estado 

			FROM
				convocado cv
			";
			return $Query;
		}
	}
?>
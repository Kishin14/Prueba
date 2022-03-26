<?php

	require_once("../../../framework/clases/DbClass.php");
	require_once("../../../framework/clases/PermisosFormClass.php");

	final class DocumentoModel extends Db{

		private $UserId;
		private $Permisos;

		public function SetUsuarioId($UserId,$CodCId){
			$this -> Permisos = new PermisosForm();
			$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
		}

		public function getPermiso($ActividadId,$Permiso,$Conex){
			return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
		}

		public function selectDatosDocumentoId($documento_laboral_id,$Conex){
			$select ="SELECT d.fecha,d.documento_laboral_id,d.tipo_documento_laboral_id,d.contrato_id,
			(SELECT CONCAT_WS('',c.numero_contrato,'-',t.primer_nombre,' ',t.segundo_nombre,' ',t.primer_apellido,' ',t.segundo_apellido,
			' ',t.razon_social,'-',t.numero_identificacion) 
			FROM contrato c,  tercero t, empleado e WHERE c.empleado_id=e.empleado_id AND e.tercero_id=t.tercero_id AND c.contrato_id=d.contrato_id) AS contrato 
			FROM documento_laboral d WHERE d.documento_laboral_id=$documento_laboral_id"; 
			$result    = $this -> DbFetchAll($select,$Conex);
			return $result;
		}


		public function Save($Campos,$Conex){
			$this -> Begin($Conex);
				$documento_laboral_id    = $this -> DbgetMaxConsecutive("documento_laboral","documento_laboral_id",$Conex,true,1);
				$this -> assignValRequest('documento_laboral_id',$documento_laboral_id);
				$this -> DbInsertTable("documento_laboral",$Campos,$Conex,true,false);
			$this -> Commit($Conex);
		}

		public function Update($Campos,$Conex){
			$this -> Begin($Conex);
				if($_REQUEST['documento_laboral_id'] == 'NULL'){
					$this -> DbInsertTable("documento_laboral",$Campos,$Conex,true,false);
				}else{
					$this -> DbUpdateTable("documento_laboral",$Campos,$Conex,true,false);
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
		
			public function GetDoc($Conex){
			return $this -> DbFetchAll("SELECT tipo_documento_laboral_id  AS value, nombre_documento AS text FROM tipo_documento_laboral ORDER BY nombre_documento ASC",$Conex,
			$ErrDb = false);
		}

		public function GetQueryContratoGrid(){

			$Query = "SELECT
				c.contrato_id,
				c.numero_contrato,
				d.documento_laboral_id,	
				d.fecha,
				(SELECT td.nombre_documento FROM tipo_documento_laboral td WHERE td.tipo_documento_laboral_id=d.tipo_documento_laboral_id)AS tipo_documento_laboral_id,
				(SELECT CONCAT_WS(' ', t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, empleado e
      			 WHERE t.tercero_id=e.tercero_id AND c.empleado_id=e.empleado_id)AS empleado_id,
				(SELECT nombre FROM tipo_contrato WHERE tipo_contrato_id=c.tipo_contrato_id)AS tipo_contrato_id
				FROM
				contrato c, documento_laboral d 
				
			WHERE c.contrato_id=d.contrato_id
			";
			return $Query;
		}
	}
?>
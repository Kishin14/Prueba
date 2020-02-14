<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class LicenciaModel extends Db{
	
	public function SetUsuarioId($usuario_id,$oficina_id){	  
		$this -> Permisos = new PermisosForm();
		$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
	}
	
	public function getPermiso($ActividadId,$Permiso,$Conex){
		return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
	}
	
	public function Save($Campos,$Conex){	
		$this -> Begin($Conex);
		$licencia_id = $this -> DbgetMaxConsecutive("licencia","licencia_id",$Conex,false,1);
		
		$this -> assignValRequest('licencia_id',$licencia_id);
		
		$this -> DbInsertTable("licencia",$Campos,$Conex,true,false);
		
		$this -> Commit($Conex)	;
	}

	
	public function Update($Campos,$Conex){	
		$this -> DbUpdateTable("licencia",$Campos,$Conex,true,false);
	}
	
	public function Delete($Campos,$Conex){
		$this -> DbDeleteTable("licencia",$Campos,$Conex,true,false);
	}	
	
	public function ValidateRow($Conex,$Campos){
	
		require_once("../../../framework/clases/ValidateRowClass.php");
		$Data = new ValidateRow($Conex,"licencia",$Campos);
		return $Data -> GetData();
	}

	public function comprobar_licencia($fecha_inicial,$fecha_final,$contrato_id,$Conex){
		return $this  -> DbFetchAll("SELECT  * FROM licencia WHERE estado='A' AND contrato_id=$contrato_id 
									AND ('$fecha_inicial' BETWEEN  fecha_inicial AND fecha_final OR '$fecha_final' BETWEEN  fecha_inicial AND fecha_final)  ",$Conex,$ErrDb = true);
	}   

	public function comprobar_licencia_val($fecha_inicial,$fecha_final,$contrato_id,$licencia_id,$Conex){
		return $this  -> DbFetchAll("SELECT  * FROM licencia WHERE estado='A' AND contrato_id=$contrato_id AND licencia_id!=$licencia_id
									AND ('$fecha_inicial' BETWEEN  fecha_inicial AND fecha_final OR '$fecha_final' BETWEEN  fecha_inicial AND fecha_final)  ",$Conex,$ErrDb = true);
	}   

	public function GetTipoConcepto($Conex){
		return $this  -> DbFetchAll("SELECT tipo_incapacidad_id AS value,nombre AS text FROM tipo_incapacidad WHERE estado='A' ORDER BY nombre ASC",$Conex,$ErrDb = false);
	}   

	public function getDiagnostico($tipo_incapacidad_id,$Conex){
		$select = "SELECT tipo,diagnostico FROM tipo_incapacidad WHERE tipo_incapacidad_id=$tipo_incapacidad_id";
		$result = $this -> DbFetchAll($select,$Conex);
		return $result;
	}
	
	public function selectLicenciaId($licencia_id,$Conex){
		$select = "SELECT n.*,
		           (SELECT c.descripcion FROM cie_enfermedades c WHERE c.cie_enfermedades_id = n.cie_enfermedades_id)AS descripcion,
		(SELECT CONCAT_WS(' ',c.numero_contrato,'-',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,'-',t.numero_identificacion) 
		AS contrato 
		
		FROM contrato c,  tercero t, empleado e WHERE c.empleado_id=e.empleado_id AND e.tercero_id=t.tercero_id AND c.contrato_id=n.contrato_id)AS contrato
		FROM licencia n WHERE n.licencia_id = $licencia_id";
		$result = $this -> DbFetchAll($select,$Conex);
		return $result;
	}
	
	public function GetQueryLicenciaGrid(){
	
		$Query = "SELECT n.licencia_id,
		                 n.fecha_licencia,
		(SELECT CONCAT_WS(' ',c.numero_contrato,'-',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,'-',t.numero_identificacion) 
		AS contrato FROM contrato c,  tercero t, empleado e WHERE c.empleado_id=e.empleado_id AND e.tercero_id=t.tercero_id AND c.contrato_id=n.contrato_id)AS contrato,
		 n.concepto,
		 (SELECT descripcion FROM cie_enfermedades WHERE cie_enfermedades_id=n.cie_enfermedades_id)AS enfermedad,
		 n.diagnostico,n.fecha_inicial,n.fecha_final, 
		 IF(n.estado='A','ACTIVO','INACTIVO') AS estado
		 FROM licencia n";
		
		return $Query;
	}



}
?>
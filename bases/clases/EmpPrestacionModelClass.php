<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
final class EmpPrestacionModel extends Db{
	private $UserId;
	private $Permisos;
	public function SetUsuarioId($UserId,$CodCId){
		$this -> Permisos = new PermisosForm();
		$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
	}
	
	public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
	}
	public function selectDatosEmpPrestacionId($empresa_id,$Conex){
		$select ="SELECT	empresa_id
		FROM empresa_prestaciones t
		WHERE	t.empresa_id = $empresa_id
		";
		$result    = $this -> DbFetchAll($select,$Conex);
		return $result;
	}
	public function selectDatosEmpresa($tercero_id,$Conex){
		$select ="SELECT e.*, t.*,(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.ubicacion_id) AS ubicacion  
		FROM empresa_prestaciones e INNER JOIN tercero t ON e.tercero_id=t.tercero_id
		WHERE t.tercero_id = $tercero_id"; 
		$result    = $this -> DbFetchAll($select,$Conex);
		return $result;
	}

  public function selectDatosEmpresaNumeroId($numero_identificacion,$Conex){
	  
  
     $select    = "SELECT 
	 					e.*,
						t.*, 
				   			(SELECT nombre 
							 FROM ubicacion 
							 WHERE ubicacion_id=t.ubicacion_id) 
						AS ubicacion
				   	FROM tercero t 
						LEFT JOIN empresa_prestaciones e ON t.tercero_id = e.tercero_id 
	                WHERE t.numero_identificacion = $numero_identificacion";
	  
     $result    = $this -> DbFetchAll($select,$Conex);
     return $result;					  			
	  
  }  

	public function Save($Campos,$Conex){
		$this -> Begin($Conex);
			$empresa_id    = $this -> DbgetMaxConsecutive("empresa_prestaciones","empresa_id",$Conex,true,1);
			$tercero_id    = $this -> DbgetMaxConsecutive("tercero","tercero_id",$Conex,true,1);
			$this -> assignValRequest('empresa_id',$empresa_id);
			$this -> assignValRequest('tercero_id',$tercero_id);
			$this -> DbInsertTable("tercero",$Campos,$Conex,true,false);
			$this -> DbInsertTable("empresa_prestaciones",$Campos,$Conex,true,false);
			
		$this -> Commit($Conex);
	}
	public function Update($Campos,$Conex){
		$this -> Begin($Conex);
			$this -> DbUpdateTable("tercero",$Campos,$Conex,true,false);
			if($_REQUEST['empresa_id'] == 'NULL'){
				$this -> DbInsertTable("empresa_prestaciones",$Campos,$Conex,true,false);
				
			}else{
				$this -> DbUpdateTable("empresa_prestaciones",$Campos,$Conex,true,false);
				
			}
		$this -> Commit($Conex);
	}
	public function Delete($Campos,$Conex){
		$this -> DbDeleteTable("empresa_prestaciones",$Campos,$Conex,true,false);
		$this -> DbDeleteTable("tercero",$Campos,$Conex,true,false);
	}
	public function ValidateRow($Conex,$Campos){
		require_once("../../../framework/clases/ValidateRowClass.php");
		$Data = new ValidateRow($Conex,"tercero",$Campos);
		return $Data -> GetData();
	}
	public function GetTipoPersonas($Conex){
		return $this -> DbFetchAll("SELECT tipo_persona_id  AS value,nombre AS text FROM tipo_persona WHERE tipo_persona_id!=1",$Conex,
		$ErrDb = false);
	}
	public function GetUbicacion($Conex){
		return $this -> DbFetchAll("SELECT ubicacion_id  AS value,nombre AS text FROM ubicacion",$Conex,
		$ErrDb = false);
	}
	public function GetIdentificacion($Conex){
		return $this -> DbFetchAll("SELECT tipo_identificacion_id  AS value,nombre AS text FROM tipo_identificacion WHERE tipo_identificacion_id NOT IN (1,3,4,6,8,9,10)",$Conex,
		$ErrDb = false);
	}
	public function GetRegimen($Conex){
		return $this -> DbFetchAll("SELECT regimen_id  AS value,nombre AS text FROM regimen WHERE regimen_id!=1",$Conex,
		$ErrDb = false);
	}
	public function GetQueryEmpPrestacionGrid(){
		$Query = "SELECT 
		(SELECT nombre FROM tipo_persona WHERE tipo_persona_id=t.tipo_persona_id) AS tipo_persona_id, 
		numero_identificacion, 
		digito_verificacion, 
		razon_social, 
		sigla, 
		email, 
		telefax, 
		telefono, 
		movil, 
		e.codigo, 
		IF(e.salud=1,'SI','NO') AS salud, 
		IF(e.pension=1,'SI','NO') AS pension, 
		IF(e.arl=1,'SI','NO') AS arl, 
		IF(e.caja_compensacion=1,'SI','NO') AS caja_compensacion, 
		IF(e.cesantias=1,'SI','NO') AS cesantias, 
		IF(e.parafiscales=1,'SI','NO') AS parafiscales,
		IF(estado='D','DISPONIBLE','BLOQUEADO') AS estado, 
		IF(retei_proveedor='N','NO','SI') AS retei_proveedor, 
		IF(autoret_proveedor='N','NO','SI') AS autoret_proveedor, 
		(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.ubicacion_id) AS ubicacion_id, 
		(SELECT nombre FROM tipo_identificacion WHERE tipo_identificacion_id=t.tipo_identificacion_id) AS tipo_identificacion_id, 
		(SELECT nombre FROM regimen WHERE regimen_id=t.regimen_id) AS regimen_id 
		FROM
			empresa_prestaciones e INNER JOIN tercero t ON e.tercero_id=t.tercero_id";
		return $Query;
	}
}
?>
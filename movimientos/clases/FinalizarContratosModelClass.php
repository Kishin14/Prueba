<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class FinalizarContratosModel extends Db{
		
  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
	
  public function Update($Campos,$Conex,$usuario_id){	
	$this -> Begin($Conex);

	$this -> assignValRequest('fecha_finaliza',date('Y-m-d H:i:s'));

	$this -> assignValRequest('usuario_finaliza_id',$usuario_id);
	
	$this -> assignValRequest('estado','F');

    $this -> DbUpdateTable("contrato",$Campos,$Conex,true,false);
	$this -> Commit($Conex);
  }


 	public function GetMotivoTer($Conex){
		return $this  -> DbFetchAll("SELECT motivo_terminacion_id AS value,nombre AS text FROM motivo_terminacion ORDER BY nombre ASC",$Conex,$ErrDb = false);
  	}   

 	public function GetCausalDes($Conex){
		return $this  -> DbFetchAll("SELECT causal_despido_id AS value,nombre AS text FROM causal_despido ORDER BY nombre ASC",$Conex,$ErrDb = false);
  	}   

	public function getCausalesAnulacion($Conex){
		
		$select = "SELECT causal_anulacion_id AS value,nombre AS text FROM causal_anulacion WHERE documento!='RM' ORDER BY nombre";
		$result = $this -> DbFetchAll($select,$Conex);		
		return $result;				
	}  

   public function ValidateRow($Conex,$Campos){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($Conex,"liquidacion_definitiva",$Campos);
	 return $Data -> GetData();
   }

   public function selectDatosFinalizarContratosId($contrato_id,$Conex){
  
	 $select = "SELECT * FROM contrato  WHERE contrato_id = $contrato_id"; 
	 
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);

	return $result;
	
   }

   public function selectContrato($contrato_id,$Conex){
  
 	$select = "SELECT * FROM contrato  WHERE contrato_id = $contrato_id"; 
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	return $result;
	
   }


   public function GetQueryFinalizarContratosGrid(){

   	$Query = "SELECT 
		    c.numero_contrato,
			c.fecha_inicio,
			c.fecha_terminacion,
			c.fecha_terminacion_real,
			(SELECT CONCAT_WS(' ', t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, empleado e
			 WHERE t.tercero_id=e.tercero_id AND c.empleado_id=e.empleado_id)AS empleado,
			 (SELECT t.numero_identificacion FROM tercero t, empleado e
			 WHERE t.tercero_id=e.tercero_id AND c.empleado_id=e.empleado_id)AS cedula,
			(SELECT nombre FROM tipo_contrato WHERE tipo_contrato_id=c.tipo_contrato_id)AS tipo_contrato_id,
			(SELECT nombre_cargo FROM cargo WHERE cargo_id=c.cargo_id)AS cargo_id,
			(SELECT nombre FROM motivo_terminacion WHERE motivo_terminacion_id=c.motivo_terminacion_id)AS motivo_terminacion_id,
			
			CASE estado WHEN 'A' THEN 'ACTIVO' WHEN 'R' THEN 'RETIRADO' WHEN 'F' THEN 'FINALIZADO'  WHEN 'AN' THEN 'ANULADO' WHEN 'L' THEN 'LICENCIA' ELSE '' END AS estado

		    FROM
			contrato c WHERE (SELECT tc.prestaciones_sociales FROM tipo_contrato tc WHERE tc.tipo_contrato_id = c.tipo_contrato_id)=0 AND c.estado = 'F'";
			
			return $Query;

   }

}

?>
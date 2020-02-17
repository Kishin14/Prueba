<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class mandoContratosModel extends Db{
  private $Permisos;

//// GRID ////
  public function getQueryMandoContratosGrid(){

	$Query = "SELECT c.numero_contrato,
                   (SELECT t.nombre FROM tipo_contrato t WHERE t.tipo_contrato_id=c.tipo_contrato_id) AS tipo_contrato,
                   (SELECT CONCAT_WS('',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
                   FROM tercero t, empleado e WHERE t.tercero_id=e.tercero_id AND e.empleado_id=c.empleado_id)AS empleado,
                   DATE_FORMAT(c.fecha_inicio,'%m-%d-%Y') AS fecha_inicio,
                   DATE_FORMAT(c.fecha_terminacion,'%m-%d-%Y') AS fecha_terminacion,
                   (SELECT nombre_cargo FROM cargo WHERE cargo_id = c.cargo_id)AS cargo,
                   (CASE c.estado WHEN 'A' THEN 'ACTIVO' WHEN 'F' THEN 'FINALIZADO' ELSE 'ANULADO' END)AS estado,
	                 (SELECT TIMESTAMPDIFF(DAY,(c.fecha_inicio),NOW())) AS dias
            
             FROM contrato c WHERE c.estado = 'A' ORDER BY c.fecha_inicio ASC";
  
     return $Query;
     
   }

   public function SelectVencimientos($Conex){

    $select = "SELECT c.numero_contrato, 
                      c.fecha_inicio,
                      c.fecha_terminacion,
                      (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
                      FROM tercero t, empleado e WHERE t.tercero_id=e.tercero_id AND e.empleado_id=c.empleado_id)AS empleado,
                      (SELECT TIMESTAMPDIFF(DAY,NOW(),c.fecha_terminacion))AS dias_dif
                                  
             FROM contrato c WHERE c.estado = 'A' AND ((SELECT TIMESTAMPDIFF(DAY,NOW(),c.fecha_terminacion)) BETWEEN 0 AND 15) ORDER BY c.fecha_inicio DESC";
  
    $result = $this -> DbFetchAll($select,$Conex);

      if($result>0){
          return $result;
      } 
     
   }

   public function SelectVencidos($Conex){

    $select = "SELECT c.numero_contrato, 
                      c.fecha_inicio,
                      c.fecha_terminacion,
                      (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
                      FROM tercero t, empleado e WHERE t.tercero_id=e.tercero_id AND e.empleado_id=c.empleado_id)AS empleado,
                      (SELECT TIMESTAMPDIFF(DAY,NOW(),c.fecha_terminacion))AS dias_dif
                                  
             FROM contrato c WHERE c.estado = 'A' AND ((SELECT TIMESTAMPDIFF(DAY,NOW(),c.fecha_terminacion)) < 0) ORDER BY c.fecha_inicio DESC";
  
    $result = $this -> DbFetchAll($select,$Conex);

      if($result>0){
          return $result;
      } 
     
   }

}
?>
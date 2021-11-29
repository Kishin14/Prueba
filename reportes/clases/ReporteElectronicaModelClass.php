<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ReporteElectronicaModel extends Db {

    private $UserId;
    private $Permisos;

    public function SetUsuarioId($UserId, $CodCId) {
        $this->Permisos = new PermisosForm();
        $this->Permisos->SetUsuarioId($UserId, $CodCId);
    }

    public function getPermiso($ActividadId, $Permiso, $Conex) {
        return $this->Permisos->getPermiso($ActividadId, $Permiso, $Conex);
    }

    public function GetSi_Pro($Conex) {
        $opciones = array(0 => array('value' => '1', 'text' => 'UNO'), 1 => array('value' => 'ALL', 'text' => 'TODOS'));
        return $opciones;
    }

    public function GetSi_Pro2($Conex) {
        $opciones = array(0 => array('value' => '1', 'text' => 'UNO'), 1 => array('value' => 'ALL', 'text' => 'TODOS'));
        return $opciones;
    }
	  

    public function getReporte($desde, $hasta,$empresa_id,$empleado_id='', $Conex) {
        $select = "SELECT ln.*,
            (SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido)AS nombre_emp FROM empresa e, tercero t WHERE e.empresa_id = $empresa_id AND e.tercero_id=t.tercero_id) AS nombre_empresa,
            (SELECT CONCAT_WS(' - ',t.numero_identificacion,t.digito_verificacion)AS nit_emp FROM empresa e, tercero t WHERE e.empresa_id = $empresa_id AND e.tercero_id=t.tercero_id) AS nit_empresa,					
            (SELECT ti.codigo FROM  tipo_identificacion ti  WHERE  ti.tipo_identificacion_id=t.tipo_identificacion_id) AS tipoidentificacion, 
            t.numero_identificacion AS identificacion,  t.primer_nombre,t.segundo_nombre AS otros_nombres,t.primer_apellido,t.segundo_apellido,
            IF(u.divipola=11001,11,(SELECT ub.divipola FROM ubicacion ub WHERE ub.ubicacion_id=u.ubi_ubicacion_id )) AS departamento,
            u.divipola AS municipio,
            '' AS codtrabajador,
            of.direccion  AS lugar_trabajo,
            t.email AS email_trabajador,
            tc.codigo_electronica AS tipocontrato,
            tc.integral AS salariointegral,
            '0' AS altoRiesgopension,
            '00'  AS subtipoTrabajador,
            '01' AS tipoTrabajador,
            IF(u.divipola=11001,11,(SELECT ub.divipola FROM ubicacion ub WHERE ub.ubicacion_id=u.ubi_ubicacion_id )) AS depar_generacion,
            'es' AS idioma,
            u.divipola AS municipioGen,
            c.fecha_inicio AS fechaingreso,
            c.fecha_terminacion_real AS fecharetiro,
            DATE(ln.fecha_registro) AS fechaEmision,
            CASE ln.periodicidad WHEN 'Q' THEN '4' WHEN 'M' THEN '5' WHEN 'S' THEN '1' WHEN 'T' THEN IF(DATEDIFF(ln.fecha_final, ln.fecha_inicial) BETWEEN 13 AND 16,'Q','M') END AS periodoNomina,
            (SELECT CONCAT_WS('-',pn.prefijo,ln.consecutivo_nom) FROM param_nomina_electronica pn WHERE pn.param_nom_electronica_id=ln.param_nom_electronica_id) AS rangoNum,
            'COP' AS tipoMoneda,
            '' AS trm,
            
            (SELECT ca.nombre_cargo	FROM cargo ca  WHERE  c.cargo_id=ca.cargo_id) AS cargo, c.sueldo_base,
            SUM(IF(dl.concepto='SALARIO',dl.debito,0)) AS sueldo_trabajado,
            SUM(IF(dl.concepto='SALARIO',dl.dias,0)) AS dias,
            '' AS dias_incapacidad,
            '' AS dias_licencia

            FROM liquidacion_novedad ln, contrato c, empleado e, tercero t, detalle_liquidacion_novedad dl, centro_de_costo cc, oficina of, ubicacion u, tipo_contrato tc
            WHERE ln.fecha_inicial BETWEEN '$desde' AND '$hasta' AND ln.fecha_final BETWEEN '$desde' AND '$hasta'
            AND dl.liquidacion_novedad_id=ln.liquidacion_novedad_id AND c.contrato_id=ln.contrato_id AND e.empleado_id=c.empleado_id 
            AND t.tercero_id=e.tercero_id AND cc.centro_de_costo_id=c.centro_de_costo_id AND of.oficina_id=cc.oficina_id AND tc.tipo_contrato_id=c.tipo_contrato_id
            AND u.ubicacion_id=of.ubicacion_id
            GROUP BY ln.contrato_id
            ORDER BY CONCAT_WS(' ',t.primer_nombre, t.segundo_nombre,t.primer_apellido,t.segundo_apellido)   ASC, ln.fecha_final DESC";

		$result = $this -> DbFetchAll($select,$Conex,true);
		
		return $result;
    } 
    


}

?>
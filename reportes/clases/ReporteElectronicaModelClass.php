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
            '0.00' AS redondeo,
            IFNULL((SELECT IF(fp.codigo_electronica IS NOT NULL, fp.codigo_electronica, '1') FROM  abono_nomina an, relacion_abono_nomina ra, cuenta_tipo_pago ct, forma_pago fp 
            WHERE ra.liquidacion_novedad_id=ln.liquidacion_novedad_id AND an.abono_nomina_id=ra.abono_nomina_id 
            AND an.estado_abono_nomina='C' AND ct.cuenta_tipo_pago_id=an.cuenta_tipo_pago_id AND fp.forma_pago_id=ct.forma_pago_id),1) AS metododePago,
            '1' AS medioPago,
            (SELECT b.nombre_banco FROM banco b WHERE b.banco_id=c.banco_id) AS nombreBanco,
            (SELECT tc.nombre_tipo_cuenta FROM  tipo_cuenta tc WHERE tc.tipo_cta_id=c.tipo_cta_id) AS tipoCuenta,
            c.numcuenta_proveedor AS numeroCuenta,
            

            (SELECT GROUP_CONCAT(dl.fecha_final SEPARATOR '&') fecha_final 
		    FROM detalle_liquidacion_novedad dl,liquidacion_novedad liqn 
			WHERE liqn.liquidacion_novedad_id = dl.liquidacion_novedad_id AND dl.tercero_id = t.tercero_id 
			AND concepto like 'SALARIO%' AND dl.fecha_final >= '$desde' AND dl.fecha_final <= '$hasta' and liqn.estado = 'C') pagos_nomina,

			SUM(IF(dl.concepto='SUELDO PAGAR',dl.credito,0)) AS total_comprobante,	
			SUM(IF(dl.concepto IN('SALUD','PENSION'),dl.credito,0)) AS total_deduccion,	
			SUM(IF(dl.concepto NOT IN('SALUD','PENSION'),dl.debito,0)) AS total_devengado,

			'102' AS tipo_documento, '0' AS  novedad, '' AS novedad_cune, '' AS tipo_nota, '' AS fecha_gen_pred, 
            '' AS cune_pred, '' AS numero_pred,
            SUM(IF(dl.concepto='SALARIO',dl.dias,0)) AS dias,
            SUM(IF(dl.concepto='SALARIO',dl.debito,0)) AS sueldo_trabajado,
						
			SUM(IF(dl.concepto LIKE '%TRANSPORTE%' OR dl.concepto LIKE '%MOVILIDAD%',dl.debito,0)) AS auxilio_transporte,
			'' AS viatico_manu_alo_s,

			SUM(IF(dl.concepto LIKE '%ALOJAMIENTO%',dl.debito,0)) viatico_manu_alo_ns,

			SUM(IF(dl.concepto IN('SALUD'),dl.credito,0)) AS deduccion_salud,'4' porcentaje_salud,

			SUM(IF(dl.concepto IN('PENSION'),dl.credito,0)) AS deduccion_pension,'4' porcentaje_pension,

			IF(SUM(IF(dl.concepto IN('SALARIO'),dl.debito,0)) >= 908526*4,SUM(IF(dl.concepto IN('SALARIO'),dl.debito,0)) * 0.01,0) deduccion_solidaridad_pensional,
			IF(SUM(IF(dl.concepto IN('SALARIO'),dl.debito,0)) >= 908526*4,SUM(IF(dl.concepto IN('SALARIO'),dl.debito,0)) * 0.01,0) deduccion_subsistencia,

			IF(SUM(IF(dl.concepto IN('SALARIO'),dl.debito,0)) >= 908526*4,1,0) porcentaje_solidaridad_pensional,
			IF(SUM(IF(dl.concepto IN('SALARIO'),dl.debito,0)) >= 908526*4,1,0) porcentaje_subsistencia,

            (SELECT f_getDays360(IF(c.fecha_inicio>'$desde',c.fecha_inicio,'$desde'),'$hasta')) dias_prima,
						
			ROUND((SUM(IF(dl.concepto NOT IN('SALUD','PENSION'),dl.debito,0))/360)*(SELECT f_getDays360(IF(c.fecha_inicio>'$desde',c.fecha_inicio,'$desde'),'$hasta')),2) pago_prima,
			'0' prima_no_salarial,

			ROUND((SUM(IF(dl.concepto NOT IN('SALUD','PENSION'),dl.debito,0))/360)*(SELECT f_getDays360(IF(c.fecha_inicio>'$desde',c.fecha_inicio,'$desde'),'$hasta')),2) pago_cesantias,

			ROUND(((SUM(IF(dl.concepto NOT IN('SALUD','PENSION'),dl.debito,0))*POW((SELECT f_getDays360(IF(c.fecha_inicio>'$desde',c.fecha_inicio,'$desde'),'$hasta')),2)*0.12)/129600),2) valor_intereses_cesantias,

			'12' porcentaje_intereses_cesantias, '0' monto_comision, 
            
            '' horaInicio_extra_diurno, '' horaFin_extra_diurno,

            IFNULL((SELECT he.horas_diurnas FROM hora_extra he 
            WHERE he.contrato_id = c.contrato_id AND (he.fecha_inicial>='$desde' AND he.fecha_final <= '$hasta')),0) cantidad_horasE_diurnas,
            IFNULL((SELECT he.vr_horas_diurnas FROM hora_extra he 
                        WHERE he.contrato_id = c.contrato_id AND (he.fecha_inicial>='$desde' AND he.fecha_final <= '$hasta')),0) valor_horasE_diurnas,
                '25' porcentaje_extra_diurno,

            '' horaInicio_extra_nocturno, '' horaFin_extra_nocturno,
            IFNULL((SELECT he.horas_nocturnas FROM hora_extra he 
                    WHERE he.contrato_id = c.contrato_id AND (he.fecha_inicial>='$desde' AND he.fecha_final <= '$hasta')),0) cantidad_horasE_nocturno,
            IFNULL((SELECT he.vr_horas_nocturnas FROM hora_extra he 
                    WHERE he.contrato_id = c.contrato_id AND (he.fecha_inicial>='$desde' AND he.fecha_final <= '$hasta')),0) valor_horasE_nocturno,
            '75' porcentaje_extra_nocturno,
            
            '' horaInicio_recargo_nocturno, '' horaFin_recargo_nocturno,
            IFNULL((SELECT he.horas_recargo_noc FROM hora_extra he 
                    WHERE he.contrato_id = c.contrato_id AND (he.fecha_inicial>='$desde' AND he.fecha_final <= '$hasta')),0) cantidad_horasR_nocturno,
            IFNULL((SELECT he.vr_horas_recargo_noc FROM hora_extra he 
                    WHERE he.contrato_id = c.contrato_id AND (he.fecha_inicial>='$desde' AND he.fecha_final <= '$hasta')),0) valor_horasR_nocturno,
            '35' porcentaje_recargo_nocturno,
            
            '' horaInicio_Extra_diurnofes, '' horaFin_extra_diurnofes,
            IFNULL((SELECT he.horas_diurnas_fes FROM hora_extra he 
                    WHERE he.contrato_id = c.contrato_id AND (he.fecha_inicial>='$desde' AND he.fecha_final <= '$hasta')),0) cantidad_horasE_diurnofes,
            IFNULL((SELECT he.vr_horas_recargo_noc FROM hora_extra he 
                    WHERE he.contrato_id = c.contrato_id AND (he.fecha_inicial>='$desde' AND he.fecha_final <= '$hasta')),0) valor_horasE_diurnofes,
            '100' porcentaje_extra_diurnofes,

            '' horaInicio_recargo_diurnofes, '' horaFin_recargo_diurnofes,'0' cantidad_horasR_diurnofes, '0' valor_horasR_diurnofes,
            '75' porcentaje_extra_diurnofes,

            '' horaInicio_Extra_nocturnofes, '' horaFin_extra_nocturnofes,
            IFNULL((SELECT he.horas_nocturnas_fes FROM hora_extra he 
                    WHERE he.contrato_id = c.contrato_id AND (he.fecha_inicial>='$desde' AND he.fecha_final <= '$hasta')),0) cantidad_horasE_nocturnofes,
            IFNULL((SELECT he.vr_horas_nocturnas_fes FROM hora_extra he 
                    WHERE he.contrato_id = c.contrato_id AND (he.fecha_inicial>='$desde' AND he.fecha_final <= '$hasta')),0) valor_horasE_nocturnofes,
            '150' porcentaje_extra_nocturnofes,

            '' horaInicio_recargo_nocturnofes, '' horaFin_recargo_nocturnofes,'0' cantidad_horasR_nocturnofes, '0' valor_horasR_nocturnofes,
            '110' porcentaje_extra_nocturnofes,

            IFNULL((SELECT lq.fecha_dis_inicio FROM liquidacion_vacaciones lq 
                WHERE lq.contrato_id = c.contrato_id AND lq.fecha_dis_inicio>='$desde' AND lq.fecha_dis_inicio>='$hasta'),'') fecha_inicio_vacaciones,

            IFNULL((SELECT lq.fecha_reintegro FROM liquidacion_vacaciones lq 
                WHERE lq.contrato_id = c.contrato_id AND lq.fecha_reintegro>='$desde' AND lq.fecha_reintegro>='$hasta'),'') fecha_final_vacaciones,

            IFNULL((SELECT lq.dias FROM liquidacion_vacaciones lq 
                WHERE lq.contrato_id = c.contrato_id AND lq.fecha_dis_final>='$desde' AND lq.fecha_dis_final>='$hasta'),'') dias_vacaciones,

            IFNULL((SELECT lq.valor FROM liquidacion_vacaciones lq 
                WHERE lq.contrato_id = c.contrato_id AND lq.fecha_dis_final>='$desde' AND lq.fecha_dis_final>='$hasta'),'') valor_liquidacion_vacaciones,
            
            IF((SELECT lq.dias FROM liquidacion_vacaciones lq 
                WHERE lq.contrato_id = c.contrato_id AND lq.fecha_dis_final>='$desde' AND lq.fecha_dis_final>='$hasta')>1,'1','')  tipo_vacaciones,

            IFNULL((SELECT lq.dias_pagados FROM liquidacion_vacaciones lq 
                WHERE lq.contrato_id = c.contrato_id AND lq.fecha_dis_final>='$desde' AND lq.fecha_dis_final>='$hasta'),'') dias_compensados_vacaciones,

            IFNULL((SELECT lq.valor_pagos FROM liquidacion_vacaciones lq 
                WHERE lq.contrato_id = c.contrato_id AND lq.fecha_dis_final>='$desde' AND lq.fecha_dis_final>='$hasta'),'') valor_vacaciones_compensadas,

            IF((SELECT lq.dias_pagados FROM liquidacion_vacaciones lq 
                WHERE lq.contrato_id = c.contrato_id AND lq.fecha_dis_final>='$desde' AND lq.fecha_dis_final>='$hasta')>1,'2','')  tipo_vacaciones_compensadas,

            IFNULL((SELECT li.fecha_inicial FROM licencia li
                WHERE tipo_incapacidad_id = 1 AND li.contrato_id = c.contrato_id AND li.fecha_inicial>='$desde' AND li.fecha_inicial>='$hasta'),'') fecha_inicio_licenciaM,

            IFNULL((SELECT li.fecha_final FROM licencia li
                WHERE tipo_incapacidad_id = 1 AND li.contrato_id = c.contrato_id AND li.fecha_final>='$desde' AND li.fecha_final>='$hasta'),'') fecha_final_licenciaM,
            
            IFNULL((SELECT li.dias FROM licencia li
                WHERE tipo_incapacidad_id = 1 AND li.contrato_id = c.contrato_id AND li.fecha_final>='$desde' AND li.fecha_final>='$hasta'),'') dias_licenciaM,

            IFNULL((SELECT (select SUM(IF(dl.concepto='SALARIO',dl.debito,0))/30)*li.dias FROM licencia li
                WHERE tipo_incapacidad_id = 1 AND li.contrato_id = c.contrato_id AND li.fecha_final>='$desde' AND li.fecha_final>='$hasta'),'') valor_licenciaM,

            IF((SELECT li.dias FROM licencia li
                WHERE tipo_incapacidad_id = 1 AND li.contrato_id = c.contrato_id AND li.fecha_final>='$desde' AND li.fecha_final>='$hasta')>1,'1','') tipo_licenciaM,

            '' fecha_inicio_licenciaR,'' fecha_final_licenciaR,'' dias_licenciaR,'' valor_licenciaR,'' tipo_licenciaR,

            IFNULL((SELECT li.fecha_inicial FROM licencia li
                WHERE tipo_incapacidad_id = 5 AND li.contrato_id = c.contrato_id AND li.fecha_inicial>='$desde' AND li.fecha_inicial>='$hasta'),'') fecha_inicio_licenciaNR,
            
            IFNULL((SELECT li.fecha_final FROM licencia li
                WHERE tipo_incapacidad_id = 5 AND li.contrato_id = c.contrato_id AND li.fecha_final>='$desde' AND li.fecha_final>='$hasta'),'') fecha_final_licenciaNR,

            IFNULL((SELECT li.dias FROM licencia li
                WHERE tipo_incapacidad_id = 5 AND li.contrato_id = c.contrato_id AND li.fecha_final>='$desde' AND li.fecha_final>='$hasta'),'') dias_licenciaNR,

            IFNULL((SELECT (select SUM(IF(dl.concepto='SALARIO',dl.debito,0))/30)*li.dias FROM licencia li
                WHERE tipo_incapacidad_id = 5 AND li.contrato_id = c.contrato_id AND li.fecha_final>='$desde' AND li.fecha_final>='$hasta'),'') valor_licenciaNR,

            IF((SELECT li.dias FROM licencia li
                WHERE tipo_incapacidad_id = 5 AND li.contrato_id = c.contrato_id AND li.fecha_final>='$desde' AND li.fecha_final>='$hasta')>1,'3','') tipo_licenciaNR,

            '' inicio_huelga,'' fin_huelga,'' cantidad_huelga,

            IFNULL((SELECT li.fecha_inicial FROM licencia li
                WHERE tipo_incapacidad_id = 4 AND li.contrato_id = c.contrato_id AND li.fecha_inicial>='$desde' AND li.fecha_inicial>='$hasta'),'') fecha_inicio_IncapacidadGen,

            IFNULL((SELECT li.fecha_final FROM licencia li
                WHERE tipo_incapacidad_id = 4 AND li.contrato_id = c.contrato_id AND li.fecha_final>='$desde' AND li.fecha_final>='$hasta'),'') fecha_final_incapacidadGen,

            IFNULL((SELECT li.dias FROM licencia li
                WHERE tipo_incapacidad_id = 4 AND li.contrato_id = c.contrato_id AND li.fecha_final>='$desde' AND li.fecha_final>='$hasta'),'') dias_incapacidadGen,

            IFNULL((SELECT (select SUM(IF(dl.concepto='SALARIO',dl.debito,0))/30)*li.dias FROM licencia li
                WHERE tipo_incapacidad_id = 4 AND li.contrato_id = c.contrato_id AND li.fecha_final>='$desde' AND li.fecha_final>='$hasta'),'') valor_incapacidadGen,
            
            IF((SELECT li.dias FROM licencia li
                WHERE tipo_incapacidad_id = 4 AND li.contrato_id = c.contrato_id AND li.fecha_final>='$desde' AND li.fecha_final>='$hasta')>1,'1','') tipo_incapacidadGen,

            IFNULL((SELECT li.fecha_inicial FROM licencia li
                WHERE tipo_incapacidad_id = 2 AND li.contrato_id = c.contrato_id AND li.fecha_inicial>='$desde' AND li.fecha_inicial>='$hasta'),'') fecha_inicio_IncapacidadProf,

            IFNULL((SELECT li.fecha_final FROM licencia li
                WHERE tipo_incapacidad_id = 2 AND li.contrato_id = c.contrato_id AND li.fecha_final>='$desde' AND li.fecha_final>='$hasta'),'') fecha_final_incapacidadProf,

            IFNULL((SELECT li.dias FROM licencia li
                WHERE tipo_incapacidad_id = 2 AND li.contrato_id = c.contrato_id AND li.fecha_final>='$desde' AND li.fecha_final>='$hasta'),'') dias_incapacidadProf,

            IFNULL((SELECT (select SUM(IF(dl.concepto='SALARIO',dl.debito,0))/30)*li.dias FROM licencia li
                WHERE tipo_incapacidad_id = 2 AND li.contrato_id = c.contrato_id AND li.fecha_final>='$desde' AND li.fecha_final>='$hasta'),'') valor_incapacidadProf,
            
            IF((SELECT li.dias FROM licencia li
                WHERE tipo_incapacidad_id = 2 AND li.contrato_id = c.contrato_id AND li.fecha_final>='$desde' AND li.fecha_final>='$hasta')>1,'2','') tipo_incapacidadProf,

            IFNULL((SELECT li.fecha_inicial FROM licencia li
                WHERE tipo_incapacidad_id = 6 AND li.contrato_id = c.contrato_id AND li.fecha_inicial>='$desde' AND li.fecha_inicial>='$hasta'),'') fecha_inicio_IncapacidadLab,

            IFNULL((SELECT li.fecha_final FROM licencia li
                WHERE tipo_incapacidad_id = 6 AND li.contrato_id = c.contrato_id AND li.fecha_final>='$desde' AND li.fecha_final>='$hasta'),'') fecha_final_incapacidadLab,

            IFNULL((SELECT li.dias FROM licencia li
                WHERE tipo_incapacidad_id = 6 AND li.contrato_id = c.contrato_id AND li.fecha_final>='$desde' AND li.fecha_final>='$hasta'),'') dias_incapacidadLab,

            IFNULL((SELECT (select SUM(IF(dl.concepto='SALARIO',dl.debito,0))/30)*li.dias FROM licencia li
                WHERE tipo_incapacidad_id = 6 AND li.contrato_id = c.contrato_id AND li.fecha_final>='$desde' AND li.fecha_final>='$hasta'),'') valor_incapacidadLab,
            
            IF((SELECT li.dias FROM licencia li
                WHERE tipo_incapacidad_id = 6 AND li.contrato_id = c.contrato_id AND li.fecha_final>='$desde' AND li.fecha_final>='$hasta')>1,'3','') tipo_incapacidadLab,

            '' montoAnticipo, '' valor_pago_tercero,

            IF(c.tipo_contrato_id = 5,SUM(IF(dl.concepto='SALARIO',dl.debito,0)),'') apoyo_sostenimiento,

            '' bonificacion_retiro, '' dotacion,

            (SELECT ldi.valor FROM liquidacion_definitiva ld 
            INNER JOIN liq_def_indemnizacion ldi ON ld.liquidacion_definitiva_id = ldi.liquidacion_definitiva_id
            WHERE ld.contrato_id = c.contrato_id) valor_indemnizacion,

            (SELECT SUM(CASE WHEN ca.tipo_novedad = 'V' THEN dln.debito ELSE 0 END)
									FROM detalle_liquidacion_novedad dln
									 INNER JOIN liquidacion_novedad liqn ON liqn.liquidacion_novedad_id = dln.liquidacion_novedad_id
									 INNER JOIN concepto_area ca ON dln.concepto_area_id = ca.concepto_area_id
									 WHERE ca.descripcion LIKE '%REINTEGRO%'  AND dln.liquidacion_novedad_id=liqn.liquidacion_novedad_id
												AND liqn.fecha_inicial BETWEEN '2021-09-01' AND '2021-09-30' AND liqn.fecha_final BETWEEN '2021-09-01' AND '2021-09-30'
												AND dln.tercero_id = t.tercero_id AND liqn.contrato_id =c.contrato_id) reintegro_de_empresa,

						(SELECT SUM(CASE WHEN ca.tipo_novedad = 'V' THEN dln.debito ELSE 0 END)-SUM(CASE WHEN ca.tipo_novedad = 'D' THEN dln.credito ELSE 0 END)
									FROM detalle_liquidacion_novedad dln
									 INNER JOIN liquidacion_novedad liqn ON liqn.liquidacion_novedad_id = dln.liquidacion_novedad_id
									 INNER JOIN concepto_area ca ON dln.concepto_area_id = ca.concepto_area_id
									 WHERE ca.descripcion LIKE '%TELETRABAJO%'  AND dln.liquidacion_novedad_id=liqn.liquidacion_novedad_id
												AND liqn.fecha_inicial BETWEEN '2021-09-01' AND '2021-09-30' AND liqn.fecha_final BETWEEN '2021-09-01' AND '2021-09-30'
												AND dln.tercero_id = t.tercero_id AND liqn.contrato_id =c.contrato_id) valor_teletrabajo, 

						(SELECT SUM(CASE WHEN ca.tipo_novedad = 'V' THEN dln.debito ELSE 0 END)-SUM(CASE WHEN ca.tipo_novedad = 'D' THEN dln.credito ELSE 0 END)
									FROM detalle_liquidacion_novedad dln
									 INNER JOIN liquidacion_novedad liqn ON liqn.liquidacion_novedad_id = dln.liquidacion_novedad_id
									 INNER JOIN concepto_area ca ON dln.concepto_area_id = ca.concepto_area_id
									 WHERE ca.descripcion LIKE '%AUXILIO SALARIAL%'  AND dln.liquidacion_novedad_id=liqn.liquidacion_novedad_id
												AND liqn.fecha_inicial BETWEEN '2021-09-01' AND '2021-09-30' AND liqn.fecha_final BETWEEN '2021-09-01' AND '2021-09-30'
												AND dln.tercero_id = t.tercero_id AND liqn.contrato_id =c.contrato_id) auxilioS,

						(SELECT SUM(CASE WHEN ca.tipo_novedad = 'V' THEN dln.debito ELSE 0 END)-SUM(CASE WHEN ca.tipo_novedad = 'D' THEN dln.credito ELSE 0 END)
									FROM detalle_liquidacion_novedad dln
									 INNER JOIN liquidacion_novedad liqn ON liqn.liquidacion_novedad_id = dln.liquidacion_novedad_id
									 INNER JOIN concepto_area ca ON dln.concepto_area_id = ca.concepto_area_id
									 WHERE ca.descripcion LIKE '%AUXILIO NO SALARIAL%'  AND dln.liquidacion_novedad_id=liqn.liquidacion_novedad_id
												AND liqn.fecha_inicial BETWEEN '2021-09-01' AND '2021-09-30' AND liqn.fecha_final BETWEEN '2021-09-01' AND '2021-09-30'
												AND dln.tercero_id = t.tercero_id AND liqn.contrato_id =c.contrato_id) auxilioNS,

						SUM(IF(dl.concepto='INGRESO NO SALARIAL',dl.credito,0)) AS bonificacion_no_salarial,

						(SELECT SUM(CASE WHEN ca.tipo_novedad = 'V' THEN dln.debito ELSE 0 END)-SUM(CASE WHEN ca.tipo_novedad = 'D' THEN dln.credito ELSE 0 END)
									FROM detalle_liquidacion_novedad dln
									 INNER JOIN liquidacion_novedad liqn ON liqn.liquidacion_novedad_id = dln.liquidacion_novedad_id
									 INNER JOIN concepto_area ca ON dln.concepto_area_id = ca.concepto_area_id
									 WHERE ca.descripcion LIKE '%BONIFICACION SALARIAL%'  AND dln.liquidacion_novedad_id=liqn.liquidacion_novedad_id
												AND liqn.fecha_inicial BETWEEN '2021-09-01' AND '2021-09-30' AND liqn.fecha_final BETWEEN '2021-09-01' AND '2021-09-30'
												AND dln.tercero_id = t.tercero_id AND liqn.contrato_id =c.contrato_id) bonificacionS,

						(SELECT SUM(CASE WHEN ca.tipo_novedad = 'V' THEN dln.debito ELSE 0 END)-SUM(CASE WHEN ca.tipo_novedad = 'D' THEN dln.credito ELSE 0 END)
									FROM detalle_liquidacion_novedad dln
									 INNER JOIN liquidacion_novedad liqn ON liqn.liquidacion_novedad_id = dln.liquidacion_novedad_id
									 INNER JOIN concepto_area ca ON dln.concepto_area_id = ca.concepto_area_id
									 WHERE ca.descripcion LIKE '%ALIMENTACION NO SALARIAL%'  AND dln.liquidacion_novedad_id=liqn.liquidacion_novedad_id
												AND liqn.fecha_inicial BETWEEN '2021-09-01' AND '2021-09-30' AND liqn.fecha_final BETWEEN '2021-09-01' AND '2021-09-30'
												AND dln.tercero_id = t.tercero_id AND liqn.contrato_id =c.contrato_id) pAlimentacionNs,

						(SELECT SUM(CASE WHEN ca.tipo_novedad = 'V' THEN dln.debito ELSE 0 END)-SUM(CASE WHEN ca.tipo_novedad = 'D' THEN dln.credito ELSE 0 END)
									FROM detalle_liquidacion_novedad dln
									 INNER JOIN liquidacion_novedad liqn ON liqn.liquidacion_novedad_id = dln.liquidacion_novedad_id
									 INNER JOIN concepto_area ca ON dln.concepto_area_id = ca.concepto_area_id
									 WHERE ca.descripcion LIKE '%ALIMENTACION SALARIAL%'  AND dln.liquidacion_novedad_id=liqn.liquidacion_novedad_id
												AND liqn.fecha_inicial BETWEEN '2021-09-01' AND '2021-09-30' AND liqn.fecha_final BETWEEN '2021-09-01' AND '2021-09-30'
												AND dln.tercero_id = t.tercero_id AND liqn.contrato_id =c.contrato_id) pAlimentacionS,

						'' pagosS,'' pagosNs,

						(SELECT SUM(CASE WHEN ca.tipo_novedad = 'V' THEN dln.debito ELSE 0 END)-SUM(CASE WHEN ca.tipo_novedad = 'D' THEN dln.credito ELSE 0 END)
									FROM detalle_liquidacion_novedad dln
									 INNER JOIN liquidacion_novedad liqn ON liqn.liquidacion_novedad_id = dln.liquidacion_novedad_id
									 INNER JOIN concepto_area ca ON dln.concepto_area_id = ca.concepto_area_id
									 WHERE ca.descripcion LIKE '%COMPENSACION E%'  AND dln.liquidacion_novedad_id=liqn.liquidacion_novedad_id
												AND liqn.fecha_inicial BETWEEN '2021-09-01' AND '2021-09-30' AND liqn.fecha_final BETWEEN '2021-09-01' AND '2021-09-30'
												AND dln.tercero_id = t.tercero_id AND liqn.contrato_id =c.contrato_id) compensacion_ordinaria,
						
						(SELECT SUM(CASE WHEN ca.tipo_novedad = 'V' THEN dln.debito ELSE 0 END)-SUM(CASE WHEN ca.tipo_novedad = 'D' THEN dln.credito ELSE 0 END)
									FROM detalle_liquidacion_novedad dln
									 INNER JOIN liquidacion_novedad liqn ON liqn.liquidacion_novedad_id = dln.liquidacion_novedad_id
									 INNER JOIN concepto_area ca ON dln.concepto_area_id = ca.concepto_area_id
									 WHERE ca.descripcion LIKE '%COMPENSACION O%'  AND dln.liquidacion_novedad_id=liqn.liquidacion_novedad_id
												AND liqn.fecha_inicial BETWEEN '2021-09-01' AND '2021-09-30' AND liqn.fecha_final BETWEEN '2021-09-01' AND '2021-09-30'
												AND dln.tercero_id = t.tercero_id AND liqn.contrato_id =c.contrato_id) compensacion_extraordinaria,

						'' descripcion_concepto,'' concepto_no_salarial,'' concepto_salarial,

						(SELECT SUM(CASE WHEN ca.tipo_novedad = 'V' THEN dln.debito ELSE 0 END)-SUM(CASE WHEN ca.tipo_novedad = 'D' THEN dln.credito ELSE 0 END)
									FROM detalle_liquidacion_novedad dln
									 INNER JOIN liquidacion_novedad liqn ON liqn.liquidacion_novedad_id = dln.liquidacion_novedad_id
									 INNER JOIN concepto_area ca ON dln.concepto_area_id = ca.concepto_area_id
									 WHERE ca.descripcion LIKE '%AHORRO%'  AND dln.liquidacion_novedad_id=liqn.liquidacion_novedad_id
												AND liqn.fecha_inicial BETWEEN '2021-09-01' AND '2021-09-30' AND liqn.fecha_final BETWEEN '2021-09-01' AND '2021-09-30'
												AND dln.tercero_id = t.tercero_id AND liqn.contrato_id =c.contrato_id) afc,
						
						(SELECT SUM(CASE WHEN ca.tipo_novedad = 'V' THEN dln.debito ELSE 0 END)-SUM(CASE WHEN ca.tipo_novedad = 'D' THEN dln.credito ELSE 0 END)
									FROM detalle_liquidacion_novedad dln
									 INNER JOIN liquidacion_novedad liqn ON liqn.liquidacion_novedad_id = dln.liquidacion_novedad_id
									 INNER JOIN concepto_area ca ON dln.concepto_area_id = ca.concepto_area_id
									 WHERE ca.descripcion LIKE '%COOPERATIVA%'  AND dln.liquidacion_novedad_id=liqn.liquidacion_novedad_id
												AND liqn.fecha_inicial BETWEEN '2021-09-01' AND '2021-09-30' AND liqn.fecha_final BETWEEN '2021-09-01' AND '2021-09-30'
												AND dln.tercero_id = t.tercero_id AND liqn.contrato_id =c.contrato_id) cooperativa,
			
						(SELECT SUM(CASE WHEN ca.tipo_novedad = 'V' THEN dln.debito ELSE 0 END)-SUM(CASE WHEN ca.tipo_novedad = 'D' THEN dln.credito ELSE 0 END)
									FROM detalle_liquidacion_novedad dln
									 INNER JOIN liquidacion_novedad liqn ON liqn.liquidacion_novedad_id = dln.liquidacion_novedad_id
									 INNER JOIN concepto_area ca ON dln.concepto_area_id = ca.concepto_area_id
									 WHERE ca.descripcion LIKE '%DEUDA%'  AND dln.liquidacion_novedad_id=liqn.liquidacion_novedad_id
												AND liqn.fecha_inicial BETWEEN '2021-09-01' AND '2021-09-30' AND liqn.fecha_final BETWEEN '2021-09-01' AND '2021-09-30'
												AND dln.tercero_id = t.tercero_id AND liqn.contrato_id =c.contrato_id) deuda,
						
						(SELECT SUM(CASE WHEN ca.tipo_novedad = 'V' THEN dln.debito ELSE 0 END)-SUM(CASE WHEN ca.tipo_novedad = 'D' THEN dln.credito ELSE 0 END)
									FROM detalle_liquidacion_novedad dln
									 INNER JOIN liquidacion_novedad liqn ON liqn.liquidacion_novedad_id = dln.liquidacion_novedad_id
									 INNER JOIN concepto_area ca ON dln.concepto_area_id = ca.concepto_area_id
									 WHERE ca.descripcion LIKE '%EDUCACION%'  AND dln.liquidacion_novedad_id=liqn.liquidacion_novedad_id
												AND liqn.fecha_inicial BETWEEN '2021-09-01' AND '2021-09-30' AND liqn.fecha_final BETWEEN '2021-09-01' AND '2021-09-30'
												AND dln.tercero_id = t.tercero_id AND liqn.contrato_id =c.contrato_id) educacion,
			
						(SELECT SUM(CASE WHEN ca.tipo_novedad = 'V' THEN dln.debito ELSE 0 END)-SUM(CASE WHEN ca.tipo_novedad = 'D' THEN dln.credito ELSE 0 END)
									FROM detalle_liquidacion_novedad dln
									 INNER JOIN liquidacion_novedad liqn ON liqn.liquidacion_novedad_id = dln.liquidacion_novedad_id
									 INNER JOIN concepto_area ca ON dln.concepto_area_id = ca.concepto_area_id
									 WHERE ca.descripcion LIKE '%EMBARGO%'  AND dln.liquidacion_novedad_id=liqn.liquidacion_novedad_id
												AND liqn.fecha_inicial BETWEEN '2021-09-01' AND '2021-09-30' AND liqn.fecha_final BETWEEN '2021-09-01' AND '2021-09-30'
												AND dln.tercero_id = t.tercero_id AND liqn.contrato_id =c.contrato_id) embargo,	

						(SELECT SUM(CASE WHEN ca.tipo_novedad = 'V' THEN dln.debito ELSE 0 END)-SUM(CASE WHEN ca.tipo_novedad = 'D' THEN dln.credito ELSE 0 END)
									FROM detalle_liquidacion_novedad dln
									 INNER JOIN liquidacion_novedad liqn ON liqn.liquidacion_novedad_id = dln.liquidacion_novedad_id
									 INNER JOIN concepto_area ca ON dln.concepto_area_id = ca.concepto_area_id
									 WHERE ca.descripcion LIKE '%COMPLEMENTARIO SALUD%'  AND dln.liquidacion_novedad_id=liqn.liquidacion_novedad_id
												AND liqn.fecha_inicial BETWEEN '2021-09-01' AND '2021-09-30' AND liqn.fecha_final BETWEEN '2021-09-01' AND '2021-09-30'
												AND dln.tercero_id = t.tercero_id AND liqn.contrato_id =c.contrato_id) plan_complementario_salud,
		
						(SELECT SUM(CASE WHEN ca.tipo_novedad = 'D' THEN dln.credito ELSE 0 END)
									FROM detalle_liquidacion_novedad dln
									 INNER JOIN liquidacion_novedad liqn ON liqn.liquidacion_novedad_id = dln.liquidacion_novedad_id
									 INNER JOIN concepto_area ca ON dln.concepto_area_id = ca.concepto_area_id
									 WHERE ca.descripcion LIKE '%REINTEGRO%'  AND dln.liquidacion_novedad_id=liqn.liquidacion_novedad_id
												AND liqn.fecha_inicial BETWEEN '2021-09-01' AND '2021-09-30' AND liqn.fecha_final BETWEEN '2021-09-01' AND '2021-09-30'
												AND dln.tercero_id = t.tercero_id AND liqn.contrato_id =c.contrato_id) reintegro_de_trabajador,

						'' retencion_fuente,

						(SELECT SUM(CASE WHEN ca.tipo_novedad = 'D' THEN dln.credito ELSE 0 END)
									FROM detalle_liquidacion_novedad dln
									 INNER JOIN liquidacion_novedad liqn ON liqn.liquidacion_novedad_id = dln.liquidacion_novedad_id
									 INNER JOIN concepto_area ca ON dln.concepto_area_id = ca.concepto_area_id
									 WHERE ca.descripcion LIKE '%ANTICIPO%'  AND dln.liquidacion_novedad_id=liqn.liquidacion_novedad_id
												AND liqn.fecha_inicial BETWEEN '2021-09-01' AND '2021-09-30' AND liqn.fecha_final BETWEEN '2021-09-01' AND '2021-09-30'
												AND dln.tercero_id = t.tercero_id AND liqn.contrato_id =c.contrato_id) anticipo_nomina,

						(SELECT SUM(CASE WHEN ca.tipo_novedad = 'D' THEN dln.credito ELSE 0 END)
									FROM detalle_liquidacion_novedad dln
									 INNER JOIN liquidacion_novedad liqn ON liqn.liquidacion_novedad_id = dln.liquidacion_novedad_id
									 INNER JOIN concepto_area ca ON dln.concepto_area_id = ca.concepto_area_id
									 WHERE ca.descripcion LIKE '%LIBRANZA%'  AND dln.liquidacion_novedad_id=liqn.liquidacion_novedad_id
												AND liqn.fecha_inicial BETWEEN '2021-09-01' AND '2021-09-30' AND liqn.fecha_final BETWEEN '2021-09-01' AND '2021-09-30'
												AND dln.tercero_id = t.tercero_id AND liqn.contrato_id =c.contrato_id) deduccion_libranza,'' descripcion_libranza,

						(SELECT SUM(CASE WHEN ca.tipo_novedad = 'D' THEN dln.credito ELSE 0 END)
									FROM detalle_liquidacion_novedad dln
									 INNER JOIN liquidacion_novedad liqn ON liqn.liquidacion_novedad_id = dln.liquidacion_novedad_id
									 INNER JOIN concepto_area ca ON dln.concepto_area_id = ca.concepto_area_id
									 WHERE ca.descripcion LIKE '%PAGO TERCERO%'  AND dln.liquidacion_novedad_id=liqn.liquidacion_novedad_id
												AND liqn.fecha_inicial BETWEEN '2021-09-01' AND '2021-09-30' AND liqn.fecha_final BETWEEN '2021-09-01' AND '2021-09-30'
												AND dln.tercero_id = t.tercero_id AND liqn.contrato_id =c.contrato_id) pago_a_tercero,
						
						(SELECT SUM(CASE WHEN ca.tipo_novedad = 'D' THEN dln.credito ELSE 0 END)
									FROM detalle_liquidacion_novedad dln
									 INNER JOIN liquidacion_novedad liqn ON liqn.liquidacion_novedad_id = dln.liquidacion_novedad_id
									 INNER JOIN concepto_area ca ON dln.concepto_area_id = ca.concepto_area_id
									 WHERE ca.descripcion LIKE '%SANCION PUBLICA%'  AND dln.liquidacion_novedad_id=liqn.liquidacion_novedad_id
												AND liqn.fecha_inicial BETWEEN '2021-09-01' AND '2021-09-30' AND liqn.fecha_final BETWEEN '2021-09-01' AND '2021-09-30'
												AND dln.tercero_id = t.tercero_id AND liqn.contrato_id =c.contrato_id) sancion_publica,


						(SELECT SUM(CASE WHEN ca.tipo_novedad = 'D' THEN dln.credito ELSE 0 END)
									FROM detalle_liquidacion_novedad dln
									 INNER JOIN liquidacion_novedad liqn ON liqn.liquidacion_novedad_id = dln.liquidacion_novedad_id
									 INNER JOIN concepto_area ca ON dln.concepto_area_id = ca.concepto_area_id
									 WHERE ca.descripcion LIKE '%SANCION PRIVADA%'  AND dln.liquidacion_novedad_id=liqn.liquidacion_novedad_id
												AND liqn.fecha_inicial BETWEEN '2021-09-01' AND '2021-09-30' AND liqn.fecha_final BETWEEN '2021-09-01' AND '2021-09-30'
												AND dln.tercero_id = t.tercero_id AND liqn.contrato_id =c.contrato_id) sancion_privada,

						(SELECT SUM(CASE WHEN ca.tipo_novedad = 'D' THEN dln.credito ELSE 0 END)
									FROM detalle_liquidacion_novedad dln
									 INNER JOIN liquidacion_novedad liqn ON liqn.liquidacion_novedad_id = dln.liquidacion_novedad_id
									 INNER JOIN concepto_area ca ON dln.concepto_area_id = ca.concepto_area_id
									 WHERE ca.descripcion LIKE '%PAGO SINDICATO%'  AND dln.liquidacion_novedad_id=liqn.liquidacion_novedad_id
												AND liqn.fecha_inicial BETWEEN '2021-09-01' AND '2021-09-30' AND liqn.fecha_final BETWEEN '2021-09-01' AND '2021-09-30'
												AND dln.tercero_id = t.tercero_id AND liqn.contrato_id =c.contrato_id) pago_sindicato,

						'' porcentaje_sindicato,

						(SELECT SUM(CASE WHEN ca.tipo_novedad = 'D' THEN dln.credito ELSE 0 END)
									FROM detalle_liquidacion_novedad dln
									 INNER JOIN liquidacion_novedad liqn ON liqn.liquidacion_novedad_id = dln.liquidacion_novedad_id
									 INNER JOIN concepto_area ca ON dln.concepto_area_id = ca.concepto_area_id
									 WHERE ca.descripcion LIKE '%OTRO DEDUCCION%'  AND dln.liquidacion_novedad_id=liqn.liquidacion_novedad_id
												AND liqn.fecha_inicial BETWEEN '2021-09-01' AND '2021-09-30' AND liqn.fecha_final BETWEEN '2021-09-01' AND '2021-09-30'
												AND dln.tercero_id = t.tercero_id AND liqn.contrato_id =c.contrato_id) otra_deduccion,


            
            '' AS dias_incapacidad,
            '' AS dias_licencia,
            (SELECT ca.nombre_cargo	FROM cargo ca  WHERE  c.cargo_id=ca.cargo_id) AS cargo, c.sueldo_base
            
            


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
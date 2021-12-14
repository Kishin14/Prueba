<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
{$JAVASCRIPT}
    {$CSSSYSTEM}
</head>
<body>
{assign var="cols_deb"         value="0"}
{assign var="cols_cre"         value="0"}
{assign var="cols_total"       value="6"}
{assign var="sueldobasesum"    value="0"}
{assign var="total_debitosum"  value="0"}
{assign var="total_creditosum" value="0"}
{assign var="total_apagar"     value="0"}
{math assign="cols_deb"     equation="x + y + z"   x=$CONCDEBITO|@count  y=1          z=$CONCDEBITOEXT|@count}
{math assign="cols_cre"     equation="x + y + z"   x=$CONCCREDITO|@count y=1          z=$CONCCREDITOEXT|@count}
{math assign="cols_total"   equation="x + y"       x=$cols_total         y=$cols_deb}
{math assign="cols_total"   equation="x + y"       x=$cols_total         y=$cols_cre}
<table class="total" border="1" cellspacing="0" width="99%">
  <thead>
    <tr>
      <th colspan="{$cols_total}" align="center">&nbsp;NOMINA DEL {$DESDE} AL {$HASTA} </th>
    </tr>
    <tr>
        <th  >TIPO IDENTIFICACION</th>
        <th  >IDENTIFICACION</th>
        <th  >PRIMER NOMBRE</th>
        <th  >OTROS NOMBRES</th>
        <th  >PRIMER APELLIDO</th>
        <th  >SEGUNDO APELLIDO</th>
        <th  >PAIS</th>        
        <th  >DEPARTAMENTO</th>    
        <th  >MUNICIPIO</th>    
        <th  >COD TRABAJADOR</th>
        <th  >LUGAR TRABAJO</th>
        <th  >EMAIL</th>
        <th  >TIPO CONTRATO</th>
        <th  >SALARIO INTEGRAL</th>
        <th  >SUELDO BASE</th>
        <th  >ALTO RIESGO PENSION</th>
        <th  >SUBTIPO TRABAJADOR</th>
        <th  >TIPO TRABAJADOR</th>
        <th  >DEPARTAMENTO GENERACION</th>
        <th  >IDIOMA</th>
        <th  >MUNICIPIO GENERACION</th>        
        <th  >PAIS GENERACION</th>        
        <th  >FECHA LIQ INICIO</th> 
        <th  >FECHA LIQ FINAL</th> 
        <th  >FECHA INGRESO</th>
        <th  >FECHA RETIRO</th>
        <th  >FECHA EMISION</th>
        <th  >PERIODO</th>
        <th  >RANGO NUMERACION</th>
        <th  >TIPO MONEDA</th>
        <th  >TRM</th>
        <th  >REDONDEO</th>
        <th  >METODO DE PAGO</th>
        <th  >MEDIO DE PAGO</th>
        <th  >NOMBRE DE BANCO</th>
        <th  >TIPO CUENTA</th>
        <th  >NUMERO CUENTA</th>
        <th  >PAGOS NOMINA</th>
        <th  >TOTAL COMPROBANTE</th>
        <th  >TOTAL DEDUCCION</th>
        <th  >TOTAL DEVENGADOS</th>
        <th  >TIPO DOCUMENTO</th>
        <th  >NOVEDAD</th>
        <th  >NOVEDAD CUNE</th>
        <th  >TIPO NOTA</th>
        <th  >FECHA EMISION PRED</th>
        <th  >CUNE SOPORTE DE PAGO REEMPLAZAR</th>
        <th  >NUMERO SOPORTE DE PAGO REEMPLAZAR</th>
        <th  >DIAS TRABAJADOS</th>
        <th  >SUELDO TRABAJADO</th>
        <th  >AUXILIO TRANSPORTE</th>
        <th  >VIATICOS SALARIALES</th>
        <th  >VIATICOS NO SALARIALES</th>
        <th  >PORCENTAJE SALUD</th>
        <th  >PORCENTAJE PENSION</th>
        <th  >DEDUCCION SOLIDARIDAD PENSIONAL</th>
        <th  >PORCENTAJE SOLIDARIDAD PENSIONAL</th>
        <th  >DEDUCCION SUBSISTENCIA</th>
        <th  >PORCENTAJE SUBSISTENCIA</th>
        <th  >CANTIDAD DIAS PRIMA</th>
        <th  >VALOR PRIMA</th>
        <th  >PRIMA NO SALARIAL</th>
        <th  >PAGO CESANTIAS</th>
        <th  >VALOR INTERESES CESANTIAS</th>
        <th  >PORCENTAJE CESANTIAS</th>
        <th  >MONTO COMISION</th>
        <th  >INICIO HORAS EXTRA DIURNO</th>
        <th  >FIN HORAS EXTRA DIURNO</th>
        <th  >CANTIDAD HORAS EXTRA DIURNO</th>
        <th  >VALOR HORAS EXTRA DIURNO</th>
        <th  >PORCENTAJE HORAS EXTRA DIURNO</th>
        <th  >INICIO HORAS EXTRA NOCTURNO</th>
        <th  >FIN HORAS EXTRA NOCTURNO</th>
        <th  >CANTIDAD HORAS EXTRA NOCTURNO</th>
        <th  >VALOR HORAS EXTRA NOCTURNO</th>
        <th  >PORCENTAJE HORAS EXTRA NOCTURNO</th>
        <th  >HORA INICIO RECARGO NOCTURNO</th>
        <th  >HORA FIN RECARGO NOCTURNO</th>
        <th  >CANTIDAD HORAS RECARGO NOCTURNO</th>
        <th  >VALOR RECARGO NOCTURNO</th>
        <th  >PORCENTAJE RECARGO NOCTURNO</th>
        <th  >HORA INICIO EXTRA DIURNO FESTIVO</th>
        <th  >HORA FIN EXTRA DIURNO FESTIVO</th>
        <th  >CANTIDAD HORAS EXTRA DIURNO FESTIVO</th>
        <th  >VALOR HORA EXTRA DIURNO FESTIVO</th>
        <th  >PORCENTAJE HORA EXTRA DIURNO FESTIVO</th>
        <th  >HORA INICIO EXTRA NOCTURNO FESTIVO</th>
        <th  >HORA FIN EXTRA NOCTURNO FESTIVO</th>
        <th  >CANTIDAD HORAS EXTRA NOCTURNO</th>
        <th  >VALOR HORAS EXTRA RECARGO NOCTURNO</th>
        <th  >PORCENTAJE HORAS EXTRA NOCTURNO FESTIVO</th>
        <th  >HORA INICIO RECARGO NOCTURNO FESTIVO</th>
        <th  >HORA FIN RECARGO NOCTURNO FESTIVO</th>
        <th  >CANTIDAD HORAS RECARGO NOCTURNO FESTIVO</th>
        <th  >VALOR RECARGO NOCTURNO FEESTIVO</th>
        <th  >PORCENTAJE RECARGO NOCTURNO FESTIVO</th>
        <th  >FECHA INICIO VACACIONES</th>
        <th  >FECHA FINAL VACACIONES</th>
        <th  >CANTIDAD DIAS VACACIONES</th>
        <th  >VALOR VACACIONES</th>
        <th  >TIPO VACACIONES</th>
        <th  >CANTIDAD DIAS COMPENSADOS VACACIONES</th>
        <th  >VALOR DIAS COMPENSADOS VACACIONES</th>
        <th  >TIPO VACACIONES COMPENSADAS</th>
        <th  >FECHA INICIO LICENCIA MATERNIDAD</th>
        <th  >FECHA FINAL LICENCIA MATERNIDAD</th>
        <th  >CANTIDAD DIAS LICENCIA MATERNIDAD</th>
        <th  >VALOR LICENCIA MATERNIDAD</th>
        <th  >TIPO LICENCIA MATERNIDAD</th>
        <th  >FECHA INICIO LICENCIA REMUNERADA</th>
        <th  >FECHA FINAL LICENCIA REMUNERADA</th>
        <th  >CANTIDAD DIAS LICENCIA REMUNERADA</th>
        <th  >VALOR LICENCIA REMUNERADA</th>
        <th  >TIPO LICENCIA REMUNERADA</th>
        <th  >FECHA INICIO LICENCIA NO REMUNERADA</th>
        <th  >FECHA FINAL LICENCIA NO REMUNERADA</th>
        <th  >CANTIDAD DIAS LICENCIA NO REMUNERADA</th>
        <th  >VALOR LICENCIA NO REMUNERADA</th>
        <th  >TIPO LICENCIA NO REMUNERADA</th>
        <th  >INICIO HUELGA</th>
        <th  >FIN HUELGA</th>
        <th  >CANTIDAD DIAS HUELGA</th>
        <th  >FECHA INICIO INCAPACIDAD GENERAL</th>
        <th  >FECHA FIN INCAPACIDAD GENERAL</th>
        <th  >CANTIDAD DIAS INCAPACIDAD GENERAL</th>
        <th  >VALOR INCAPACIDAD GENERAL</th>
        <th  >TIPO INCAPACIDAD GENERAL</th>
        <th  >FECHA INICIO INCAPACIDAD PROFESIONAL</th>
        <th  >FECHA FIN INCAPACIDAD PROFESIONAL</th>
        <th  >CANTIDAD DIAS INCAPACIDAD PROFESIONAL</th>
        <th  >VALOR INCAPACIDAD PROFESIONAL</th>
        <th  >TIPO INCAPACIDAD PROFESIONAL</th>
        <th  >FECHA INICIO INCAPACIDAD LABORAL</th>
        <th  >FECHA FIN INCAPACIDAD LABORAL</th>
        <th  >CANTIDAD DIAS INCAPACIDAD LABORAL</th>
        <th  >VALOR INCAPACIDAD LABORAL</th>
        <th  >TIPO INCAPACIDAD LABORAL</th>
        <th  >MONTO ANTICICPO</th>
        <th  >VALOR PAGO TERCERO</th>
        <th  >APOYO SOSTENIMIENTO</th>
        <th  >BONIFICACION RETIRO</th>
        <th  >DOTACION</th>
        <th  >VALOR INDEMNIZACION</th>
        <th  >VALOR REINTEGRO</th>
        <th  >VALOR TELETRABAJO</th>
        <th  >AUXILIO NO SALARIAL</th>
        <th  >AUXILIO SALARIAL</th>
        <th  >BONIFICACION NO SALARIAL</th>
        <th  >BONIFICACION SLARIAL</th>
        <th  >PAGO ALIMENTACION NO SALARIAL</th>
        <th  >PAGO ALIMENTACION SALARIAL</th>
        <th  >PAGOS NO SALARIALES</th>
        <th  >PAGOS SALARIALES</th>
        <th  >COMPENSACION ORDINARIA</th>
        <th  >COMPENSACION EXTRAORDINARIA</th>
        <th  >DESCRIPCION CONCEPTO</th>
        <th  >CONCEPTO NO SALARIAL</th>
        <th  >CONCEPTO SALARIAL</th>
        <th  >AFC</th>
        <th  >COOPERATIVA</th>
        <th  >DEUDA</th>
        <th  >EDUCACION</th>
        <th  >EMBARGO</th>
        <th  >PLAN COMPLEMENTARIO SALUD</th>
        <th  >REINTEGRO DEL TRABAJADOR</th>
        <th  >RETENCION EN LA FUENTE</th>
        <th  >ANTICIPO NOMINA</th>
        <th  >DEDUCCION LIBRANZA</th>
        <th  >DESCRIPCION LIBRANZA</th>
        <th  >PAGO A TERCERO</th>
        <th  >SANCION PUBLICA</th>
        <th  >SANCION PRIVADA</th>
        <th  >PAGO SINDICATO</th>
        <th  >PORCENTAJE SINDICATO</th>
        <th  >OTRA DEDUCCION</th>

    
    </tr>
  </thead>
  <tbody>
  
    {foreach name=detalle_liquidacion_novedad from=$DETALLES item=d}
        {math assign="sueldobasesum"    equation="x + y" x=$sueldobasesum     y=$d.sueldo_base}
        {math assign="total_debitosum"  equation="x + y" x=$total_debitosum   y=$d.total_debito}
        {math assign="total_creditosum" equation="x + y" x=$total_creditosum  y=$d.total_credito}
        <tr>
            <td align="center" >{$d.tipoidentificacion}</td>
            <td >{$d.identificacion}</td>
            <td >{$d.primer_nombre}</td>
            <td >{$d.otros_nombres}</td>
            <td >{$d.primer_apellido}</td>
            <td >{$d.segundo_apellido}</td>
            <td align="center" >CO</td>
            <td align="center" >{$d.departamento}</td> 
            <td align="center" >{$d.municipio}</td>   
            <td >{$d.codtrabajador}</td>   
            <td >{$d.lugar_trabajo}</td> 
            <td >{$d.email_trabajador}</td> 
            <td align="center" >{$d.tipocontrato}</td>
            <td align="center" >{$d.salariointegral}</td>
            <td align="right">${$d.sueldo_base|number_format:0:',':'.'}</td>
            <td align="center" >{$d.altoRiesgopension}</td>
            <td align="center" >{$d.subtipoTrabajador}</td>
            <td align="center" >{$d.tipoTrabajador}</td>
            <td align="center" >{$d.depar_generacion}</td>
            <td align="center" >{$d.idioma}</td>
            <td align="center" >{$d.municipioGen}</td>
            <td align="center" >CO</td>
            <td align="center" >{$DESDE}</td>
            <td align="center" >{$HASTA}</td>
            <td align="center" >{$d.fechaingreso}</td>
            <td align="center" >{$d.fecharetiro}</td>
            <td align="center" >{$d.fechaEmision}</td>
            <td align="center" >{$d.periodoNomina}</td>
            <td align="center" >{$d.rangoNum}</td>
            <td align="center" >{$d.tipoMoneda}</td>
            <td align="center" >{$d.trm}</td>
            <td align="center" >{$d.redondeo}</td>
            <td align="center" >{$d.metododePago}</td>
            <td align="center" >{$d.medioPago}</td>
            <td align="center" >{$d.nombreBanco}</td>
            <td align="center" >{$d.tipoCuenta}</td>
            <td align="center" >{$d.numeroCuenta}</td>
            <td align="center" >{$d.pagos_nomina}</td>
            <td align="center" >{$d.total_comprobante}</td>
            <td align="center" >{$d.total_deduccion}</td>
            <td align="center" >{$d.total_devengado}</td>
            <td align="center" >{$d.tipo_documento}</td>
            <td align="center" >{$d.novedad}</td>
            <td align="center" >{$d.novedad_cune}</td>
            <td align="center" >{$d.tipo_nota}</td>
            <td align="center" >{$d.fecha_gen_pred}</td>
            <td align="center" >{$d.cune_pred}</td>
            <td align="center" >{$d.numero_pred}</td>
            <td align="center">{$d.dias}</td>
            <td align="right">${$d.sueldo_trabajado|number_format:0:',':'.'}</td>
            <td align="center" >{$d.auxilio_transporte}</td>
            <td align="center" >{$d.viatico_manu_alo_s}</td>
            <td align="center" >{$d.viatico_manu_alo_ns}</td>
            <td align="center" >{$d.porcentaje_salud}</td>
            <td align="center" >{$d.porcentaje_pension}</td>
            <td align="center" >{$d.deduccion_solidaridad_pensional}</td>
            <td align="center" >{$d.porcentaje_solidaridad_pensional}</td>
            <td align="center" >{$d.deduccion_subsistencia}</td>
            <td align="center" >{$d.porcentaje_subsistencia}</td>
            <td align="center" >{$d.dias_prima}</td>
            <td align="center" >{$d.pago_prima}</td>
            <td align="center" >{$d.prima_no_salarial}</td>
            <td align="center" >{$d.pago_cesantias}</td>
            <td align="center" >{$d.valor_intereses_cesantias}</td>
            <td align="center" >{$d.porcentaje_intereses_cesantias}</td>
            <td align="center" >{$d.monto_comision}</td>
            <td align="center" >{$d.horaInicio_extra_diurno}</td>
            <td align="center" >{$d.horaFin_extra_diurno}</td>
            <td align="center" >{$d.cantidad_horasE_diurnas}</td>
            <td align="center" >{$d.valor_horasE_diurnas}</td>
            <td align="center" >{$d.porcentaje_extra_diurno}</td>
            <td align="center" >{$d.horaInicio_extra_nocturno}</td>
            <td align="center" >{$d.horaFin_extra_nocturno}</td>
            <td align="center" >{$d.cantidad_horasE_nocturno}</td>
            <td align="center" >{$d.valor_horasE_nocturno}</td>
            <td align="center" >{$d.porcentaje_extra_nocturno}</td>
            <td align="center" >{$d.horaInicio_recargo_nocturno}</td>
            <td align="center" >{$d.horaFin_recargo_nocturno}</td>
            <td align="center" >{$d.cantidad_horasR_nocturno}</td>
            <td align="center" >{$d.valor_horasR_nocturno}</td>
            <td align="center" >{$d.porcentaje_recargo_nocturno}</td>
            <td align="center" >{$d.horaInicio_Extra_diurnofes}</td>
            <td align="center" >{$d.horaFin_extra_diurnofes}</td>
            <td align="center" >{$d.cantidad_horasE_diurnofes}</td>
            <td align="center" >{$d.valor_horasE_diurnofes}</td>
            <td align="center" >{$d.porcentaje_extra_diurnofes}</td>
            <td align="center" >{$d.horaInicio_Extra_nocturnofes}</td>
            <td align="center" >{$d.horaFin_extra_nocturnofes}</td>
            <td align="center" >{$d.cantidad_horasE_nocturnofes}</td>
            <td align="center" >{$d.valor_horasE_nocturnofes}</td>
            <td align="center" >{$d.porcentaje_extra_nocturnofes}</td>
            <td align="center" >{$d.horaInicio_recargo_nocturnofes}</td>
            <td align="center" >{$d.horaFin_recargo_nocturnofes}</td>
            <td align="center" >{$d.cantidad_horasR_nocturnofes}</td>
            <td align="center" >{$d.valor_horasR_nocturnofes}</td>
            <td align="center" >{$d.porcentaje_extra_nocturnofes}</td>
            <td align="center" >{$d.fecha_inicio_vacaciones}</td>
            <td align="center" >{$d.fecha_final_vacaciones}</td>
            <td align="center" >{$d.dias_vacaciones}</td>
            <td align="center" >{$d.valor_liquidacion_vacaciones}</td>
            <td align="center" >{$d.tipo_vacaciones}</td>
            <td align="center" >{$d.dias_compensados_vacaciones}</td>
            <td align="center" >{$d.valor_vacaciones_compensadas}</td>
            <td align="center" >{$d.tipo_vacaciones_compensadas}</td>
            <td align="center" >{$d.fecha_inicio_licenciaM}</td>
            <td align="center" >{$d.fecha_final_licenciaM}</td>
            <td align="center" >{$d.dias_licenciaM}</td>
            <td align="center" >{$d.valor_licenciaM}</td>
            <td align="center" >{$d.tipo_licenciaM}</td>
            <td align="center" >{$d.fecha_inicio_licenciaR}</td>
            <td align="center" >{$d.fecha_final_licenciaR}</td>
            <td align="center" >{$d.dias_licenciaR}</td>
            <td align="center" >{$d.valor_licenciaR}</td>
            <td align="center" >{$d.tipo_licenciaR}</td>
            <td align="center" >{$d.fecha_inicio_licenciaNR}</td>
            <td align="center" >{$d.fecha_final_licenciaNR}</td>
            <td align="center" >{$d.dias_licenciaNR}</td>
            <td align="center" >{$d.valor_licenciaNR}</td>
            <td align="center" >{$d.tipo_licenciaNR}</td>
            <td align="center" >{$d.inicio_huelga}</td>
            <td align="center" >{$d.fin_huelga}</td>
            <td align="center" >{$d.cantidad_huelga}</td>
            <td align="center" >{$d.fecha_inicio_IncapacidadGen}</td>
            <td align="center" >{$d.fecha_final_incapacidadGen}</td>
            <td align="center" >{$d.dias_incapacidadGen}</td>
            <td align="center" >{$d.valor_incapacidadGen}</td>
            <td align="center" >{$d.tipo_incapacidadGen}</td>
            <td align="center" >{$d.fecha_inicio_IncapacidadProf}</td>
            <td align="center" >{$d.fecha_final_incapacidadProf}</td>
            <td align="center" >{$d.dias_incapacidadProf}</td>
            <td align="center" >{$d.valor_incapacidadProf}</td>
            <td align="center" >{$d.tipo_incapacidadProf}</td>
            <td align="center" >{$d.fecha_inicio_IncapacidadLab}</td>
            <td align="center" >{$d.fecha_final_incapacidadLab}</td>
            <td align="center" >{$d.dias_incapacidadLab}</td>
            <td align="center" >{$d.valor_incapacidadLab}</td>
            <td align="center" >{$d.tipo_incapacidadLab}</td>
            <td align="center" >{$d.montoAnticipo}</td>
            <td align="center" >{$d.valor_pago_tercero}</td>
            <td align="center" >{$d.apoyo_sostenimiento}</td>
            <td align="center" >{$d.bonificacion_retiro}</td>
            <td align="center" >{$d.dotacion}</td>
            <td align="center" >{$d.valor_indemnizacion}</td>
            <td align="center" >{$d.reintegro_de_empresa}</td>
            <td align="center" >{$d.valor_teletrabajo}</td>
            <td align="center" >{$d.auxilioNS}</td>
            <td align="center" >{$d.auxilioS}</td>
            <td align="center" >{$d.bonificacion_no_salarial}</td>
            <td align="center" >{$d.bonificacionS}</td>
            <td align="center" >{$d.pAlimentacionNs}</td>
            <td align="center" >{$d.pAlimentacionS}</td>
            <td align="center" >{$d.pagosS}</td>
            <td align="center" >{$d.pagosNs}</td>
            <td align="center" >{$d.compensacion_ordinaria}</td>
            <td align="center" >{$d.compensacion_extraordinaria}</td>
            <td align="center" >{$d.descripcion_concepto}</td>
            <td align="center" >{$d.concepto_no_salarial}</td>
            <td align="center" >{$d.concepto_salarial}</td>
            <td align="center" >{$d.afc}</td>
            <td align="center" >{$d.cooperativa}</td>
            <td align="center" >{$d.deuda}</td>
            <td align="center" >{$d.educacion}</td>
            <td align="center" >{$d.embargo}</td>
            <td align="center" >{$d.plan_complementario_salud}</td>
            <td align="center" >{$d.reintegro_de_trabajador}</td>
            <td align="center" >{$d.retencion_fuente}</td>
            <td align="center" >{$d.anticipo_nomina}</td>
            <td align="center" >{$d.deduccion_libranza}</td>
            <td align="center" >{$d.descripcion_libranza}</td>
            <td align="center" >{$d.pago_a_tercero}</td>
            <td align="center" >{$d.sancion_publica}</td>
            <td align="center" >{$d.sancion_privada}</td>
            <td align="center" >{$d.pago_sindicato}</td>
            <td align="center" >{$d.porcentaje_sindicato}</td>
            <td align="center" >{$d.otra_deduccion}</td>

        </tr>
    {/foreach}
  </tbody>
  <!--
  <tbody style="display: none;">
    <tr>
      <td colspan="3">&nbsp;TOTALES</td>
      <td align="right">$ {$sueldobasesum|number_format:0:',':'.'}</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;${$total_debitosum|number_format:0:',':'.'}</td>
      <td align="right">&nbsp;${$total_creditosum|number_format:0:',':'.'}</td>
      <td align="right">&nbsp;${$total_apagar|number_format:0:',':'.'}</td>
    </tr>
  </tbody>
    -->
</table>
</body>
</html>
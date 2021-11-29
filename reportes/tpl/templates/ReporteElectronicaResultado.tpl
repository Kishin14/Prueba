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
        <th rowspan="2">TIPO IDENTIFICACION</th>
        <th rowspan="2">IDENTIFICACION</th>
        <th rowspan="2">PRIMER NOMBRE</th>
        <th rowspan="2">OTROS NOMBRES</th>
        <th rowspan="2">PRIMER APELLIDO</th>
        <th rowspan="2">SEGUNDO APELLIDO</th>
        <th rowspan="2">PAIS</th>        
        <th rowspan="2">DEPARTAMENTO</th>    
        <th rowspan="2">MUNICIPIO</th>    
        <th rowspan="2">COD TRABAJADOR</th>
        <th rowspan="2">LUGAR TRABAJO</th>
        <th rowspan="2">EMAIL</th>
        <th rowspan="2">TIPO CONTRATO</th>
        <th rowspan="2">SALARIO INTEGRAL</th>
        <th rowspan="2">SUELDO BASE</th>
        <th rowspan="2">ALTO RIESGO PENSION</th>
        <th rowspan="2">SUBTIPO TRABAJADOR</th>
        <th rowspan="2">TIPO TRABAJADOR</th>
        <th rowspan="2">DEPARTAMENTO GENERACION</th>
        <th rowspan="2">IDIOMA</th>
        <th rowspan="2">MUNICIPIO GENERACION</th>        
        <th rowspan="2">PAIS GENERACION</th>        
        <th rowspan="2">FECHA LIQ INICIO</th> 
        <th rowspan="2">FECHA LIQ FINAL</th> 
        <th rowspan="2">FECHA INGRESO</th>
        <th rowspan="2">FECHA RETIRO</th>
        <th rowspan="2">FECHA EMISION</th>
        <th rowspan="2">PERIODO</th>
        <th rowspan="2">RANGO NUMERACION</th>
        <th rowspan="2">TIPO MONEDA</th>
        <th rowspan="2">TRM</th>
        <th rowspan="2"><p>DIAS TRABAJADOS</p></th>
        <th rowspan="2"><p>DIAS INCAPACIDADES</p></th>
        <th rowspan="2"><p>DIAS LICENCIAS</p></th>
        <th rowspan="2">SUELDO TRABAJADO</th>
       
        
        <th colspan="{$cols_deb}" align="center">DEVENGADO</th>
        <th colspan="{$cols_cre}" align="center">DEDUCCIONES</th>
        <th rowspan="2">VALOR A PAGAR</th>
    </tr>
    <tr> {foreach name=debito from=$CONCDEBITO item=i}
      <th>{$i.concepto}&nbsp;</th>
      {/foreach}
      {foreach name=debito from=$CONCDEBITOEXT item=h}
      <th>{$h.concepto}&nbsp;</th>
      {/foreach}
      <th  align="center">TOTAL DEVEN</th>
      {foreach name=credito from=$CONCCREDITO item=j}
      <th>{$j.concepto}&nbsp;</th>
      {/foreach}
      {foreach name=credito from=$CONCCREDITOEXT item=l}
      <th>{$l.concepto}&nbsp;</th>
      {/foreach}
      <th  align="center">TOTAL DEDUC</th>
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
            <td align="right">&nbsp;${$d.sueldo_base|number_format:0:',':'.'}</td>
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
            <td align="center">{$d.dias}</td>
            <td align="center">{$d.dias_incapacidad}</td>
            <td align="center">{$d.dias_licencia}</td>
            <td align="right">&nbsp;${$d.sueldo_trabajado|number_format:0:',':'.'}</td>
            {foreach name=debito from=$CONCDEBITO1 item=i}
            <td align="right">${$d[$i.concepto]|number_format:0:',':'.'}</td>
            {/foreach}
            {foreach name=debito from=$CONCDEBITOEXT1 item=h}
            <td align="right">${$d[$h.concepto]|number_format:0:',':'.'}</td>
            {/foreach}
            <td align="right">&nbsp;${$d.total_debito|number_format:0:',':'.'}</td>
            {foreach name=credito from=$CONCCREDITO1 item=j}
            <td align="right">${$d[$j.concepto]|number_format:0:',':'.'}</td>
            {/foreach}

            {foreach name=credito from=$CONCCREDITOEXT1 item=l}
            <td align="right">${$d[$l.concepto]|number_format:0:',':'.'}</td>
            {/foreach}
            <td align="right">&nbsp;${$d.total_credito|number_format:0:',':'.'}</td>
            {foreach name=saldo from=$CONCSALDO1 item=j}
            <td align="right">${$d[$j.concepto]|number_format:0:',':'.'}</td>
            {math assign="total_apagar" equation="x + y" x=$total_apagar y=$d[$j.concepto]} 
            {/foreach} 
        </tr>
    {/foreach}
  </tbody>
  
  <tbody>
    <tr>
      <td colspan="3">&nbsp;TOTALES</td>
      <td align="right">$ {$sueldobasesum|number_format:0:',':'.'}</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      {foreach name=debito from=$CONCDEBITO1 item=i}
      <td align="right">{$TOTALES[0][$i.concepto]|number_format:0:',':'.'}</td>
      {/foreach}
      {foreach name=debito from=$CONCDEBITOEXT1 item=i}
      <td align="right">{$TOTALES[0][$i.concepto]|number_format:0:',':'.'}</td>
      {/foreach}
      <td align="right">&nbsp;${$total_debitosum|number_format:0:',':'.'}</td>
      {foreach name=credito from=$CONCCREDITO1 item=j}
      <td align="right">{$TOTALES[0][$j.concepto]|number_format:0:',':'.'}</td>
      {/foreach}
      {foreach name=credito from=$CONCCREDITOEXT1 item=j}
      <td align="right">{$TOTALES[0][$j.concepto]|number_format:0:',':'.'}</td>
      {/foreach}
      <td align="right">&nbsp;${$total_creditosum|number_format:0:',':'.'}</td>
      <td align="right">&nbsp;${$total_apagar|number_format:0:',':'.'}</td>
    </tr>
  </tbody>
</table>
</body>
</html>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
{$JAVASCRIPT}
  {$CSSSYSTEM}
</head>

<body>
<input type="hidden" id="tipo" value="{$tipo}" />
<table width="90%" align="center" id="encabezado" border="0">
  <tr>
    <td width="30%">&nbsp;</td>
    <td align="center" class="titulo" width="40%">REPORTES NOVEDADES FIJAS</td>
    <td width="30%" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" colspan="3">Rango Inicial : {$desde}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbspRango Final: {$hasta}</td>
  </tr>
</table>
<table align="center" id="encabezado"  width="90%">
  <tr>
    <th class="borderLeft borderTop borderRight">NOVEDAD FIJAS</th>
    <th class="borderTop borderRight">CONCEPTO</th>
    <th class="borderTop borderRight">FECHA NOVEDAD</th>
    <th class="borderTop borderRight">FECHA INICIAL</th>
    <th class="borderTop borderRight">FECHA FINAL</th>
    <th class="borderTop borderRight">COUTAS</th>
    <th class="borderTop borderRight">VALOR</th>
    <th class="borderTop borderRight">VALOR COUTA</th>
    <th class="borderTop borderRight">PERIODICIDAD</th>
    <th class="borderTop borderRight">TIPO NOVEDAD</th>
    <th class="borderTop borderRight">ESTADO</th>
    <th class="borderTop borderRight">NOMBRE EMPLEADO</th>
    <th class="borderTop borderRight">NUMERO IDENTIFICACION</th>
    <th class="borderTop borderRight">CONCEPTO AREA</th>
  </tr>
  {foreach name=detalles from=$DetallesNovedadesFijas item=r}
  <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
    <td class="borderLeft borderTop borderRight" align="center">{$r.novedad_fija_id}</td>
    <td class="borderTop borderRight" align="center">{$r.concepto}</td>
    <td class="borderTop borderRight" align="center">{$r.fecha_novedad}</td>
    <td class="borderTop borderRight" align="center">{$r.fecha_inicial}</td>
    <td class="borderTop borderRight" align="center">{$r.fecha_final}</td>
    <td class="borderTop borderRight" align="center">{$r.cuotas}</td>
    <td class="borderTop borderRight" align="center">{$r.valor|number_format:0:',':'.'}</td>
    <td class="borderTop borderRight">{$r.valor_cuota|number_format:0:',':'.'}</td>
    <td class="borderTop borderRight">{$r.periodicidad}</td>
    <td class="borderTop borderRight" align="center">{$r.tipo_novedad}</td>
    <td class="borderTop borderRight" align="center">{$r.estado}</td>
    <td class="borderTop borderRight" align="center">{$r.contrato_id}</td>
    <td class="borderTop borderRight" align="center">{$r.numero_identificacion}</td>
    <td class="borderTop borderRight" align="center">{$r.concepto_area_id}</td>
  </tr>
  {/foreach}
  <tr>
    <th colspan="7" align="left">&nbsp;</th>
  </tr>
</table>
</body>
</html>
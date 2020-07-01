<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
</head>

<body>
  {if $contrato_id >0}
  <table id="tableRegistrar" width="99%">
    <thead>
      <tr>
        <th style="display:none;">CODIGO PUC</th>
        <th>CONCEPTO</th>
        <th style="display:none;">BASE</th>
        <th style="display:none;">PORCENTAJE</th>
        <th style="display:none;">DEBITO</th>
        <th style="display:none;">CREDITO</th>
        <th>PERIODO</th>
        <th>DIAS</th>
        <th>VALOR</th>
      </tr>
    </thead>



    {foreach name=detalle_liquidacion_novedad from=$DETALLES item=d}
    {if $d.titulo neq ''}
    <thead>
      <tr>
        <th colspan="3" align="left">{$d.titulo}</th>
        <th align="right"><input type="text" autocomplete="off" name="{$d.campo}" id="{$d.campo}"
            style="text-align:right; background:#DAEAF6;" value="{$d.valor}" class="required numeric" /></th>
      </tr>
    </thead>
    {else}
    <tbody>
      <tr>
        <td style="display:none;"> <input type="text" autocomplete="off" name="puc" id="puc" value="{$d.puc}"
            class="required" size="10" />
          <input type="hidden" autocomplete="off" name="puc_id" id="puc_id" value="{$d.puc_id}" class="required" /></td>
        <input type="hidden" name="detalle_liquidacion_novedad_id" id="detalle_liquidacion_novedad_id"
          value="{$d.detalle_liquidacion_novedad_id}">

        <td><input type="text" autocomplete="off" name="concepto" id="concepto" value="{$d.concepto}" size="30"
            class="required" /></td>
        <td style="display:none;"><input type="text" autocomplete="off" name="base" id="base" value="{$d.base}"
            class="required" /> </td>
        <td style="display:none;"><input type="text" autocomplete="off" name="porcentaje" id="porcentaje"
            value="{$d.porcentaje}" class="required" /></td>
        <td style="display:none;"><input type="text" autocomplete="off" name="debito" id="debito" value="{$d.debito}"
            class="required numeric" /></td>

        <td style="display:none;"> <input type="text" autocomplete="off" name="valor_base_salarial" id="valor_base_salarial" value="{$d.valor_base_salarial}"
          class="required" size="10" /></td>
        
        <td><input type="text" autocomplete="off" name="periodo" id="periodo" value="{$d.periodo}" size="30"
            class="required" /></td>
        <td style="display:none;"><input type="text" autocomplete="off" name="credito" id="credito" value="{$d.credito}"
            class="required numeric" /> </td>
        <td><input type="text" autocomplete="off" name="dias" id="dias" value="{$d.dias}" class="required" /></td>
        <td align="right" name="detalleValor"><input type="text" autocomplete="off" name="valor" id="valor" style="text-align:right;"
            value="{$d.valor}" class="required numeric" /> </td>
      </tr>
    </tbody>
    {/if}
    {/foreach}
  </table>
  {elseif $liquidacion_definitiva_id >0}

  <table id="tableRegistrar" width="99%">
    <thead>
      <tr>
        <th style="display:none;">CODIGO PUC</th>
        <th>CONCEPTO</th>
        <th style="display:none;">BASE</th>
        <th style="display:none;">PORCENTAJE</th>
        <th style="display:none;">DEBITO</th>
        <th style="display:none;">CREDITO</th>
        <th>PERIODO</th>
        <th>DIAS</th>
        <th>VALOR</th>
      </tr>
    </thead>



    {foreach name=detalle_liquidacion_novedad from=$DETALLES item=d}
    {if $d.titulo neq ''}
    <thead>
      <tr>
        <th colspan="3" align="left">{$d.titulo}</th>
        <th align="right"><input type="text" autocomplete="off" name="{$d.campo}" id="{$d.campo}"
            style="text-align:right; background:#DAEAF6;" value="{$d.valor}" class="required numeric" /></th>
      </tr>
    </thead>
    {else}
    <tbody>
      <tr>
        <td style="display:none;"> <input type="text" autocomplete="off" name="puc" id="puc" value="{$d.puc}"
            class="required" size="10" />
          <input type="hidden" autocomplete="off" name="puc_id" id="puc_id" value="{$d.puc_id}" class="required" /></td>
        <input type="hidden" name="detalle_liquidacion_novedad_id" id="detalle_liquidacion_novedad_id"
          value="{$d.detalle_liquidacion_novedad_id}">

        <td><input type="text" autocomplete="off" name="concepto" id="concepto" value="{$d.concepto}" size="30"
            class="required" /></td>
        <td style="display:none;"><input type="text" autocomplete="off" name="base" id="base" value="{$d.base}"
            class="required" /> </td>
        <td style="display:none;"><input type="text" autocomplete="off" name="porcentaje" id="porcentaje"
            value="{$d.porcentaje}" class="required" /></td>
        <td style="display:none;"><input type="text" autocomplete="off" name="debito" id="debito" value="{$d.debito}"
            class="required numeric" /></td>
        <td><input type="text" autocomplete="off" name="periodo" id="periodo" value="{$d.periodo}" size="30"
            class="required" /></td>
        <td style="display:none;"><input type="text" autocomplete="off" name="credito" id="credito" value="{$d.credito}"
            class="required numeric" /> </td>
        <td><input type="text" autocomplete="off" name="dias" id="dias" value="{$d.dias}" class="required" /></td>
        <td align="right"><input type="text" autocomplete="off" name="valor" id="valor" style="text-align:right;"
            value="{$d.valor}" class="required numeric" /> </td>
      </tr>
    </tbody>
    {/if}
    {/foreach}
  </table>

  {/if}
</body>

</html>
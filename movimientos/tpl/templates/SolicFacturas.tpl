<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  {$TABLEGRIDJS}
  {$TABLEGRIDCSS}
  </head>

  <body>
   
      <input type="hidden" id="empleado_id" value="{$empleado_id}" />
      <input type="hidden" id="empleados" value="{$empleados}" />
      <table align="center" id="tableDetalles" width="99%">
        <thead>
          <tr>
            <th colspan="10">SALDOS NOMINA</th>
          </tr>
          <tr>
            <th>&nbsp;</th>
            <th>LIQ_#</th>
            <th>CONTRATO</th>
            <th>EMPLEADO</th>
            <th>FECHA INICIAL</th> 
            <th>FECHA FINAL</th>             
            <th>VALOR NETO</th> 
            <th>SALDO</th>        
            <th>ABONOS</th>
            <th>VALOR A PAGAR</th>        
          </tr>
        </thead>
        <tbody>
          {foreach name=detalles from=$DETALLES item=i}
          <tr>
            <td>       
                <input type="checkbox" name="chequear" onClick="checkRow(this);"  value="{$i.liquidacion_novedad_id}" />
                <input type="hidden" name="liquidacion_novedad_id" value="{$i.liquidacion_novedad_id}" class="required" /> 
                <input type="hidden" name="abonos_nc" value="{$i.abonos_nc}"  /> 

            </td>
            <td>{$i.consecutivo_id}</td>
            <td>{$i.contrato}</td>
            <td>{$i.empleado}&nbsp;</td>
            <td>{$i.fecha_inicial}</td>
            <td>{$i.fecha_final}</td>
            <td class="no_requerido"><input type="text" name="valor_neto" class="numeric no_requerido" value="{$i.valor_neto}" size="13" readonly /></td>
            <td class="no_requerido"><input type="text" name="saldo" class="numeric no_requerido" value="{$i.saldo}" size="13" readonly /></td>            
            <td class="no_requerido"><input type="text" name="abonos" class="numeric no_requerido" value="{if $i.abonos eq ''}0{else}{$i.abonos}{/if}" size="13" readonly /></td>            
            <td><input type="text" name="pagar" class="numeric required" value="{$i.saldo}" size="13" /></td>            
          </tr> 
          {/foreach}	
        </tbody>
      </table>
      
      
     <center>{$ADICIONAR}</center>
  </body>
</html>
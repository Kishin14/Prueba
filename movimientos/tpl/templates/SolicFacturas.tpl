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
      
      <!------------------------------------------------     NOMINA   -------------------------------------------------------->
      
      <table align="center" id="tableNomina" width="99%">
        <thead>
          <tr>
            <th colspan="10">SALDOS NOMINA</th>
          </tr>
          <tr>
            <th><input type="checkbox" id="checkedAll"></th>
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
          {foreach name=detalles from=$DETALLESFACTURAS item=i}
          <tr>
            <td>       
                <input type="checkbox" name="nomina" onClick="checkRow(this);"  value="{$i.liquidacion_novedad_id}" />
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
      
      <br><br>
      <!------------------------------------------------      VACACIONES   -------------------------------------------------------->
      <table align="center" id="tableVacaciones" width="99%">
        <thead>
          <tr>
            <th colspan="10">SALDOS VACACIONES</th>
          </tr>
          <tr>
            <th><input type="checkbox" id="checkedAllVac"></th>
            <th>LIQ_#</th>
            <th>CONTRATO</th>
            <th>EMPLEADO</th>
            <th>FECHA LIQUIDACION</th>           
            <th>VALOR NETO</th> 
            <th>SALDO</th>        
            <th>ABONOS</th>
            <th>VALOR A PAGAR</th>        
          </tr>
        </thead>
        <tbody>
          {foreach name=detalles from=$DETALLESVACACIONES item=i}
          <tr>
            <td>       
                <input type="checkbox" name="vacaciones" onClick="checkRow(this);"  value="{$i.liquidacion_vacaciones_id}" />
                <input type="hidden" name="liquidacion_vacaciones_id" value="{$i.liquidacion_vacaciones_id}" class="required" /> 
                <input type="hidden" name="abonos_nc" value="{$i.abonos_nc}"  /> 

            </td>
            <td>{$i.consecutivo_id}</td>
            <td>{$i.contrato}</td>
            <td>{$i.empleado}&nbsp;</td>
            <td>{$i.fecha_liquidacion}</td>
            <td class="no_requerido"><input type="text" name="valor_neto" class="numeric no_requerido" value="{$i.valor_neto}" size="13" readonly /></td>
            <td class="no_requerido"><input type="text" name="saldo" class="numeric no_requerido" value="{$i.saldo}" size="13" readonly /></td>            
            <td class="no_requerido"><input type="text" name="abonos" class="numeric no_requerido" value="{if $i.abonos eq ''}0{else}{$i.abonos}{/if}" size="13" readonly /></td>            
            <td><input type="text" name="pagar" class="numeric required" value="{$i.saldo}" size="13" /></td>            
          </tr> 
          {/foreach}	
        </tbody>
      </table>
      
       <br><br>
      <!------------------------------------------------      PRIMAS   -------------------------------------------------------->
      <table align="center" id="tablePrimas" width="99%">
        <thead>
          <tr>
            <th colspan="10">SALDOS PRIMAS</th>
          </tr>
          <tr>
            <th><input type="checkbox" id="checkedAllPri"></th>
            <th>LIQ_#</th>
            <th>CONTRATO</th>
            <th>EMPLEADO</th>
            <th>FECHA LIQUIDACION</th>           
            <th>VALOR NETO</th> 
            <th>SALDO</th>        
            <th>ABONOS</th>
            <th>VALOR A PAGAR</th>        
          </tr>
        </thead>
        <tbody>
          {foreach name=detalles from=$DETALLESPRIMAS item=i}
          <tr>
            <td>       
                <input type="checkbox" name="primas" onClick="checkRow(this);"  value="{$i.liquidacion_prima_id}" />
                <input type="hidden" name="liquidacion_prima_id" value="{$i.liquidacion_prima_id}" class="required" /> 
                <input type="hidden" name="abonos_nc" value="{$i.abonos_nc}"  /> 

            </td>
            <td>{$i.consecutivo_id}</td>
            <td>{$i.contrato}</td>
            <td>{$i.empleado}&nbsp;</td>
            <td>{$i.fecha_liquidacion}</td>
            <td class="no_requerido"><input type="text" name="valor_neto" class="numeric no_requerido" value="{$i.valor_neto}" size="13" readonly /></td>
            <td class="no_requerido"><input type="text" name="saldo" class="numeric no_requerido" value="{$i.saldo}" size="13" readonly /></td>            
            <td class="no_requerido"><input type="text" name="abonos" class="numeric no_requerido" value="{if $i.abonos eq ''}0{else}{$i.abonos}{/if}" size="13" readonly /></td>            
            <td><input type="text" name="pagar" class="numeric required" value="{$i.saldo}" size="13" /></td>            
          </tr> 
          {/foreach}	
        </tbody>
      </table>
      
      <br><br>
      <!------------------------------------------------      CESANTIAS   -------------------------------------------------------->
      <table align="center" id="tableCesantias" width="99%">
        <thead>
          <tr>
            <th colspan="10">SALDOS CESANTIAS</th>
          </tr>
          <tr>
            <th><input type="checkbox" id="checkedAllCes"></th>
            <th>LIQ_#</th>
            <th>CONTRATO</th>
            <th>EMPLEADO</th>
            <th>FECHA LIQUIDACION</th>           
            <th>VALOR NETO</th> 
            <th>SALDO</th>        
            <th>ABONOS</th>
            <th>VALOR A PAGAR</th>        
          </tr>
        </thead>
        <tbody>
          {foreach name=detalles from=$DETALLESCESANTIAS item=i}
          <tr>
            <td>       
                <input type="checkbox" name="cesantias" onClick="checkRow(this);"  value="{$i.liquidacion_cesantias_id}" />
                <input type="hidden" name="liquidacion_cesantias_id" value="{$i.liquidacion_cesantias_id}" class="required" /> 
                <input type="hidden" name="abonos_nc" value="{$i.abonos_nc}"  /> 

            </td>
            <td>{$i.consecutivo_id}</td>
            <td>{$i.contrato}</td>
            <td>{$i.empleado}&nbsp;</td>
            <td>{$i.fecha_liquidacion}</td>
            <td class="no_requerido"><input type="text" name="valor_neto" class="numeric no_requerido" value="{$i.valor_neto}" size="13" readonly /></td>
            <td class="no_requerido"><input type="text" name="saldo" class="numeric no_requerido" value="{$i.saldo}" size="13" readonly /></td>            
            <td class="no_requerido"><input type="text" name="abonos" class="numeric no_requerido" value="{if $i.abonos eq ''}0{else}{$i.abonos}{/if}" size="13" readonly /></td>            
            <td><input type="text" name="pagar" class="numeric required" value="{$i.saldo}" size="13" /></td>            
          </tr> 
          {/foreach}	
        </tbody>
      </table>
      
      <!------------------------------------------------   INTERESES  CESANTIAS   -------------------------------------------------------->
       <br><br>
      <table align="center" id="tableIntCesantias" width="99%">
        <thead>
          <tr>
            <th colspan="10">SALDOS INTERESES CESANTIAS</th>
          </tr>
          <tr>
            <th><input type="checkbox" id="checkedAllInt"></th>
            <th>LIQ_#</th>
            <th>CONTRATO</th>
            <th>EMPLEADO</th>
            <th>FECHA LIQUIDACION</th>           
            <th>VALOR NETO</th> 
            <th>SALDO</th>        
            <th>ABONOS</th>
            <th>VALOR A PAGAR</th>        
          </tr>
        </thead>
        <tbody>
          {foreach name=detalles from=$DETALLESINTCESANTIAS item=i}
          <tr>
            <td>       
                <input type="checkbox" name="int_cesantias" onClick="checkRow(this);"  value="{$i.liquidacion_int_cesantias_id}" />
                <input type="hidden" name="liquidacion_int_cesantias_id" value="{$i.liquidacion_int_cesantias_id}" class="required" /> 
                <input type="hidden" name="abonos_nc" value="{$i.abonos_nc}"  /> 

            </td>
            <td>{$i.consecutivo_id}</td>
            <td>{$i.contrato}</td>
            <td>{$i.empleado}&nbsp;</td>
            <td>{$i.fecha_liquidacion}</td>
            <td class="no_requerido"><input type="text" name="valor_neto" class="numeric no_requerido" value="{$i.valor_neto}" size="13" readonly /></td>
            <td class="no_requerido"><input type="text" name="saldo" class="numeric no_requerido" value="{$i.saldo}" size="13" readonly /></td>            
            <td class="no_requerido"><input type="text" name="abonos" class="numeric no_requerido" value="{if $i.abonos eq ''}0{else}{$i.abonos}{/if}" size="13" readonly /></td>            
            <td><input type="text" name="pagar" class="numeric required" value="{$i.saldo}" size="13" /></td>            
          </tr> 
          {/foreach}	
        </tbody>
      </table>
      
  </body>
</html>
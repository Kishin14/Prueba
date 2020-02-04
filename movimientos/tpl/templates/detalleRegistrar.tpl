<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body>
  {if $RANGO neq 'T'}
  <table id="tableRegistrar" width="99%">
   <thead>
    <tr>
     <th style="display:none;">CODIGO PUC</th>
     <th >CONCEPTO</th>          
     <th style="display:none;">BASE</th>               	 
     <th style="display:none;">PORCENTAJE</th>               
     <th>DEBITO</th>               
     <th>CREDITO</th>          
     <!--<th>FECHA INICIAL</th>                    
     <th>FECHA FINAL</th>-->         
     <th>DIAS</th>         	 
     <th>OBSERVACION</th>                                         
	 <th>&nbsp;</th>                              
     <th><input type="checkbox" id="checkedAll"></th>     
    </tr>
    </thead>
    
    <tbody>

    {foreach name=detalle_liquidacion_novedad from=$DETALLES item=d}
    <tr>
	 <td style="display:none;"> <input type="text" autocomplete="off" name="puc" id="puc" value="{$d.puc}" class="required" size="10" />
	   <input type="hidden" autocomplete="off" name="puc_id" id="puc_id" value="{$d.puc_id}" class="required" /></td>
       <input type="hidden" name="detalle_liquidacion_novedad_id" id="detalle_liquidacion_novedad_id" value="{$d.detalle_liquidacion_novedad_id}">            
       
     <td><input type="text" autocomplete="off" name="concepto" id="concepto" value="{$d.concepto}" size="30" class="required" /></td>
     <td style="display:none;"><input type="text" autocomplete="off" name="base" id="base"  value="{$d.base}" class="required" /> </td>          
     <td style="display:none;"><input type="text" autocomplete="off" name="porcentaje" id="porcentaje" value="{$d.porcentaje}" class="required" /></td> 
     <td><input type="text" autocomplete="off" name="debito" id="debito" value="{$d.debito}" class="required numeric" /></td>          
     <td><input type="text" autocomplete="off" name="credito" id="credito" value="{$d.credito}" class="required numeric" /> </td>
     <!--<td><input type="text" autocomplete="off" name="fecha_inicial" id="fecha_inicial" value="{$d.fecha_inicial}" class="date" readonly /></td>
     <td><input type="text" autocomplete="off" name="fecha_final" id="fecha_final" value="{$d.fecha_final}" class="date" readonly /> </td>-->              
	 <td><input type="text" autocomplete="off" name="dias" id="dias" value="{$d.dias}" class="required" /></td>
     <td><input type="text" autocomplete="off" name="observacion" id="observacion" value="{$d.observacion}" class="required" /></td>
     <td><a name="saveDetalleSoliServi"><img src="/application/framework/media/images/grid/save.png" /></a></td>
     <td><input type="checkbox" name="procesar" /></td>     
    </tr>   
    {/foreach}
   </tbody>
  </table>
  {else}

  <table id="tableRegistrar" width="99%">
   <thead>
    <tr>
     <th style="display:none;">CODIGO PUC</th>
     <th>EMPLEADO</th>
     <th>CONCEPTO</th>          
     <th style="display:none;">BASE</th>               	 
     <th style="display:none;">PORCENTAJE</th>               
     <th>DEBITO</th>               
     <th>CREDITO</th>          
     <!--<th>FECHA INICIAL</th>                    
     <th>FECHA FINAL</th>-->         
     <th>DIAS</th>         	 
     <th>OBSERVACION</th>                                         
	 <th>&nbsp;</th>                              
     <th><input type="checkbox" id="checkedAll"></th>     
    </tr>
    </thead>
    
    <tbody>

    {foreach name=detalle_liquidacion_novedad from=$DETALLES item=d}
    <tr>
	 <td style="display:none;"> <input type="text" autocomplete="off" name="puc" id="puc" value="{$d.puc}" class="required" size="10" />
	   <input type="hidden" autocomplete="off" name="puc_id" id="puc_id" value="{$d.puc_id}" class="required" /></td>
       <input type="hidden" name="detalle_liquidacion_novedad_id" id="detalle_liquidacion_novedad_id" value="{$d.detalle_liquidacion_novedad_id}">            
     <td><input type="text" autocomplete="off" name="empleado" id="empleado" value="{$d.empleado}" size="30" class="required" /></td>  
     <td><input type="text" autocomplete="off" name="concepto" id="concepto" value="{$d.concepto}" size="30" class="required" /></td>
     <td style="display:none;"><input type="text" autocomplete="off" name="base" id="base"  value="{$d.base}" class="required" /> </td>          
     <td style="display:none;"><input type="text" autocomplete="off" name="porcentaje" id="porcentaje" value="{$d.porcentaje}" class="required" /></td> 
     <td><input type="text" autocomplete="off" name="debito" id="debito" value="{$d.debito}" class="required numeric" /></td>          
     <td><input type="text" autocomplete="off" name="credito" id="credito" value="{$d.credito}" class="required numeric" /> </td>
     <!--<td><input type="text" autocomplete="off" name="fecha_inicial" id="fecha_inicial" value="{$d.fecha_inicial}" class="date" readonly /></td>
     <td><input type="text" autocomplete="off" name="fecha_final" id="fecha_final" value="{$d.fecha_final}" class="date" readonly /> </td>-->              
	 <td><input type="text" autocomplete="off" name="dias" id="dias" value="{$d.dias}" class="required" /></td>
     <td><input type="text" autocomplete="off" name="observacion" id="observacion" value="{$d.observacion}" class="required" /></td>
     <td><a name="saveDetalleSoliServi"><img src="/application/framework/media/images/grid/save.png" /></a></td>
     <td><input type="checkbox" name="procesar" /></td>     
    </tr>   
    {/foreach}
   </tbody>
  </table>
  
  
  {/if}
  </body>
</html>
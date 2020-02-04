<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body>
  <input type="hidden" id="liquidacion_nomina_id" value="{$LIQUIDACIONID}" />
  <table id="tableSolicitudServicios">
   <thead>
    <tr>
     <th>CODIGO</th>	
     <th>FORMULA</th>
     <th>BASE</th>          
     <th>PORCENTAJE</th>               	 
     <th>DEBITO</th>               
     <th>CREDITO</th>
     <!--<th>&nbsp;</th>               
     <th><input type="checkbox" id="checkedAll"></th>    -->
    </tr>
    </thead>
    
    <tbody>

    {foreach name=detalle_solicitud from=$DETALLES item=d}
    <tr>
	 <td>
     	<input type="text" name="codigo" id="codigo" value="{$d.codigo}" />
		<input type="hidden" name="detalle_liquidacion_nomina_id" id="detalle_liquidacion_nomina_id" value="{$d.detalle_liquidacion_nomina_id}">        
     </td>
     <td><input type="text" autocomplete="off" name="formula" id="formula" value="{$d.formula}" /></td>
     <td><input type="text" autocomplete="off" name="base" id="base" value="{$d.base}" /></td>
     <td><input type="text" autocomplete="off" name="porcentaje" id="porcentaje" value="{$d.porcentaje}" class="numeric" /></td>
     <td><input type="text" autocomplete="off" name="debito" id="debito" value="{$d.debito}" class="required numeric" /></td>     
     <td><input type="text" autocomplete="off" name="credito" id="credito" value="{$d.credito}" class="required numeric" /></td>     
     
     <!--<td><a name="saveDetalleSoliServi"><img src="/application/framework/media/images/grid/save.png" /></a></td>
     <td><input type="checkbox" name="procesar" /></td>   -->  
    </tr>   
    {/foreach}
	<!--
    <tr>
	 <td>
     	<input type="text" name="codigo" id="codigo" value="" />
		<input type="hidden" name="detalle_liquidacion_nomina_id" id="detalle_liquidacion_nomina_id" value="">        
     </td>
     <td><input type="text" autocomplete="off" name="formula" id="formula" value="" /></td>
     <td><input type="text" autocomplete="off" name="base" id="base" value="" /></td>
     <td><input type="text" autocomplete="off" name="porcentaje" id="porcentaje" value="" class="numeric" /></td>
     <td><input type="text" autocomplete="off" name="debito" id="debito" value="" class="required numeric" /></td>     
     <td><input type="text" autocomplete="off" name="credito" id="credito" value="" class="required numeric" /></td>     
     <td><a name="saveDetalleSoliServi"><img src="/application/framework/media/images/grid/save.png" /></a></td>
     <td><input type="checkbox" name="procesar" /></td>     
    </tr>
    -->
   </tbody>
  </table>
  <!--
  <table>
     <tr id="clon">
	 <td>
     	<input type="text" name="codigo" id="codigo" value="" />
		<input type="hidden" name="detalle_liquidacion_nomina_id" id="detalle_liquidacion_nomina_id" value="">        
     </td>
     <td><input type="text" autocomplete="off" name="formula" id="formula" value="" /></td>
     <td><input type="text" autocomplete="off" name="base" id="base" value="" /></td>
     <td><input type="text" autocomplete="off" name="porcentaje" id="porcentaje" value="" class="numeric" /></td>
     <td><input type="text" autocomplete="off" name="debito" id="debito" value="" class="required numeric" /></td>     
     <td><input type="text" autocomplete="off" name="credito" id="credito" value="" class="required numeric" /></td>     
     
     <td><a name="saveDetalleSoliServi"><img src="/application/framework/media/images/grid/save.png" /></a></td>
     <td><input type="checkbox" name="procesar" /></td>     
    </tr>
  </table>
  -->
  </body>
</html>
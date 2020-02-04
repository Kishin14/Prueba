<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
   <link rel="stylesheet" href="/application/framework/css/bootstrap1.css">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>
  <body>
  <div align="center">
  <input type="hidden" id="perfil_id" value="{$PERFILID}" />
  <table id="tableDetalle" align="center">
   <thead>
    <tr>
     <th>VEHICULO</th>            	 
     <th>&nbsp;</th>
     <th><input type="checkbox" id="checkedAll"></th>     
    </tr>
    </thead>
    
    <tbody>
    {foreach name=detalle_solicitud from=$DETALLES item=d}
    <tr>
	 <td>
	   <input type="hidden" name="vehiculo_perfil" id="vehiculo_perfil" value="{$d.vehiculo_perfil}" />	 
	   <select name="vehiculo_nomina_id" class="required">
	     <option value="NULL">(... Seleccione ...)</option>
		 
		 {foreach name=vehiculos from=$VEHICULOS item=b}
		 <option value="{$b.value}" {if $b.value eq $d.vehiculo_nomina_id}selected{/if}>{$b.text}</option>
		 {/foreach}
	   </select>
	 </td>
     <td><a name="saveDetalle"><img src="/application/framework/media/images/grid/save.png" /></a></td>
     <td><input type="checkbox" name="procesar" /></td>     
    </tr>   
    {/foreach}
    <tr>
	 <td>
	<input type="hidden" name="vehiculo_perfil" id="vehiculo_perfil" value="" />	 
	   <select name="vehiculo_nomina_id" class="required">
	     <option value="NULL">(... Seleccione ...)</option>
		 
		 {foreach name=vehiculos from=$VEHICULOS item=b}
		 <option value="{$b.value}" >{$b.text}</option>
		 {/foreach}
	   </select>
	 </td>
     <td><a name="saveDetalle"><img src="/application/framework/media/images/grid/save.png" /></a></td>
     <td><input type="checkbox" name="procesar" /></td>    
    </tr>       
	</tbody>
  </table>
  <table>
  
    <tr id="clon">
	 <td>
	<input type="hidden" name="vehiculo_perfil" id="vehiculo_perfil" value="" />	 
	   <select name="vehiculo_nomina_id">
	     <option value="NULL">(... Seleccione ...)</option>
		 
		 {foreach name=vehiculos from=$VEHICULOS item=b}
		 <option value="{$b.value}" >{$b.text}</option>
		 {/foreach}
	   </select>
	 </td>
     <td><a name="saveDetalle"><img src="/application/framework/media/images/grid/save.png" /></a></td>
     <td><input type="checkbox" name="procesar" /></td>      
    </tr>      
  </table>
  </div>
  </body>
</html>
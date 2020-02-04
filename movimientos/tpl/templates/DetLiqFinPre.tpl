<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body>
  <input type="hidden" id="solicitud_id" value="{$SOLICITUDID}" />
  <table id="tableSolicitudServicios">
   <thead>
    <tr>
     <th>SHIPMENT</th>	
     <th>ORDEN CLIENTE</th>
     <th>NOMBRE REMITENTE</th>          
     <th>TIPO ID REMITENTE</th>               	 
     <th>ID REMITENTE</th>               
     <th>DIR REMITENTE</th>               
     <th>CIUDAD ORIGEN MERCANCIA</th>          
     <th>TEL REMITENTE</th>                    
     <th>NOMBRE DESTINATARIO</th>         
     <th>TIPO ID DESTINATARIO</th>         	 
     <th>ID DESTINATARIO</th>                                         
     <th>DIR DESTINO MERCANCIA</th>                                   
     <th>CIUDAD DESTINO MERCANCIA</th>                              
     <th>TEL DESTINATARIO</th>                                        
     <th>REFERENCIA PRODUCTO</th>                                             
     <th>DESCRIPCION PRODUCTO</th>                                                  
     <th>CANTIDAD</th>                                                       
     <th>PESO</th>                                                            
     <th>UNIDAD</th>                                                                 
     <th>PESO VOLUMEN</th>
     <th>UNIDAD</th>     
     <th>VALOR</th>
     <th>FECHA ENTREGA</th>
     <th>HORA ENTREGA</th>
     <th>&nbsp;</th>
     <th><input type="checkbox" id="checkedAll"></th>     
    </tr>
    </thead>
    
    <tbody>

    {foreach name=detalle_solicitud from=$DETALLES item=d}
    <tr>
	 <td><input type="text" name="shipment" id="shipment" value="{$d.shipment}" /></td>
     <td>
       <input type="hidden" name="detalle_ss_id" id="detalle_ss_id" value="{$d.detalle_ss_id}">            
       <input type="text" autocomplete="off" name="orden_despacho" id="orden_despacho" value="{$d.orden_despacho}" class="required" />
     </td>
     <td>
	   <input type="text" autocomplete="off" name="remitente" id="remitente" value="{$d.remitente}" class="required" />
	   <input type="hidden" autocomplete="off" name="remitente_id" id="remitente_id" value="{$d.remitente_id}" class="required" />	   
	 </td>          
	 <td>
	   <select name="tipo_identificacion_remitente_id" id="tipo_identificacion_remitente_id">
	     <option value="NULL">(... Seleccione ...)</option>
		 {foreach name=tipos_identificacion from=$TIPOSID item=t}
		   <option value="{$t.value}" {if $d.tipo_identificacion_remitente_id eq $t.value}selected{/if}>{$t.text}</option>
		 {/foreach}
	   </select>
	 </td>
     <td>
	   <input type="text" autocomplete="off" name="doc_remitente" id="doc_remitente" value="{$d.doc_remitente}" class="required integer" />
	 </td>               
     <td>
       <input type="text" autocomplete="off" name="direccion_remitente" id="direccion_remitente" value="{$d.direccion_remitente}" class="required" />
     </td>  
     <td>
       <input type="text" autocomplete="off" name="origen" id="origen" value="{$d.origen}" class="required" />     
       <input type="hidden" name="origen_id" id="origen_id" value="{$d.origen_id}" class="required integer" />            
     </td>          
     <td>
      <input type="text" autocomplete="off" name="telefono_remitente" id="telefono_remitente" value="{$d.telefono_remitente}" class="required integer saltoscrolldetalle"/>
     </td>          
     <td>
	   <input type="text" autocomplete="off" name="destinatario" id="destinatario" value="{$d.destinatario}" class="required saltoscrolldetalle" />
	   <input type="hidden" autocomplete="off" name="destinatario_id" id="destinatario" value="{$d.destinatario_id}" class="required saltoscrolldetalle" />	   
	 </td>     
	 <td>
	   <select name="tipo_identificacion_destinatario_id" id="tipo_identificacion_destinatario_id">
	     <option value="NULL">(... Seleccione ...)</option>
		 {foreach name=tipos_identificacion from=$TIPOSID item=t}
		   <option value="{$t.value}" {if $d.tipo_identificacion_destinatario_id eq $t.value}selected{/if}>{$t.text}</option>
		 {/foreach}
	   </select>	 	 
	 </td>
     <td>
       <input type="text" autocomplete="off" name="doc_destinatario" id="doc_destinatario" value="{$d.doc_destinatario}" class="required integer saltoscrolldetalle" />
     </td>          
     <td>
      <input type="text" autocomplete="off" name="direccion_destinatario" id="direccion_destinatario" value="{$d.direccion_destinatario}" class="required saltoscrolldetalle"/>
     </td> 
     <td>
       <input type="text" autocomplete="off" name="destino" id="destino" value="{$d.destino}" class="required saltoscrolldetalle" />     
       <input type="hidden" name="destino_id" id="destino_id" value="{$d.destino_id}" class="required integer" />            
     </td>      
     <td>
      <input type="text" autocomplete="off" name="telefono_destinatario" id="telefono_destinatario" value="{$d.telefono_destinatario}" class="required integer saltoscrolldetalle" />
     </td>     
     <td>
       <input type="text" autocomplete="off" name="referencia_producto" id="referencia_producto" value="{$d.referencia_producto}" class="required saltoscrolldetalle" />
     </td>     
     <td>
      <input type="text" autocomplete="off" name="descripcion_producto" id="descripcion_producto" value="{$d.descripcion_producto}" class="saltoscrolldetalle" />
      </td>     
     <td><input type="text" autocomplete="off" name="cantidad" id="cantidad" value="{$d.cantidad}" class="required integer saltoscrolldetalle" /></td>          
     <td><input type="text" autocomplete="off" name="peso" id="peso" value="{$d.peso}" class="required integer saltoscrolldetalle" /></td>               
     <td>
       <select name="unidad_peso_id" class="required saltoscrolldetalle">
         <option value="NULL">(....)</option>
         {foreach name=unidades from=$UNIDADES item=u}
         <option value="{$u.value}" {if $u.value eq $d.unidad_peso_id }selected{/if}>{$u.text}</option>
         {/foreach}
       </select>
     </td>                    
     <td><input type="text" autocomplete="off" name="peso_volumen" id="peso_volumen" value="{$d.peso_volumen}" class="required numeric" /></td>               
     <td>
       <select name="unidad_volumen_id" id="unidad_volumen_id" class="required saltoscrolldetalle">
         <option value="NULL">(....)</option>
         {foreach name=unidades from=$UNIDADESVOLUMEN item=u}
         <option value="{$u.value}" {if $u.value eq $d.unidad_volumen_id }selected{/if}>{$u.text}</option>
         {/foreach}
       </select>
     </td>                                                     
     <td><input type="text" autocomplete="off" name="valor_unidad" id="valor_unidad" value="{$d.valor_unidad}" class="required numeric saltoscrolldetalle" /></td>               
     <td><input type="text" autocomplete="off" name="fecha_entrega" id="fecha_entrega" value="{$d.fecha_entrega}" class="numeric" readonly /></td>               
     <td><input type="text" autocomplete="off" name="hora_entrega" id="hora_entrega" value="{$d.hora_entrega}" class="numeric" readonly /></td>                    
     
     <td><a name="saveDetalleSoliServi"><img src="/application/framework/media/images/grid/save.png" /></a></td>
     <td><input type="checkbox" name="procesar" /></td>     
    </tr>   
    {/foreach}

    <tr>
	 <td><input type="text" name="shipment" id="shipment" value="" /></td>	
     <td>
       <input type="hidden" name="detalle_ss_id" id="detalle_ss_id" vaue="" >            
       <input type="text" autocomplete="off" name="orden_despacho" id="orden_despacho" value="" class="required" />
     </td>
     <td>
	   <input type="text" autocomplete="off" name="remitente" id="remitente" value="" class="required" />
	   <input type="hidden" autocomplete="off" name="remitente_id" id="remitente_id" value="" class="required" />	   
	 </td>   
	<td>
	   <select name="tipo_identificacion_remitente_id" id="tipo_identificacion_remitente_id">
	     <option value="NULL">(... Seleccione ...)</option>
		 {foreach name=tipos_identificacion from=$TIPOSID item=t}
		   <option value="{$t.value}">{$t.text}</option>
		 {/foreach}
	   </select>
	 </td>	
     <td>
	   <input type="text" autocomplete="off" name="doc_remitente" id="doc_remitente" value="" class="required integer" />
	 </td>  
	 <td><input type="text" autocomplete="off" name="direccion_remitente" id="direccion_remitente" value="" class="required" /></td>   
     <td>
       <input type="text" autocomplete="off" name="origen" id="origen" value="" class="required">     
       <input type="hidden" name="origen_id" id="origen_id" value="" class="required integer">            
     </td>     
	 
     <td><input type="text" autocomplete="off" name="telefono_remitente" id="telefono_remitente" value="" class="required integer saltoscrolldetalle" /></td>          
     <td>
	   <input type="text" autocomplete="off" name="destinatario" id="destinatario" value="" class="required saltoscrolldetalle" />
	   <input type="hidden" autocomplete="off" name="destinatario_id" id="destinatario" value="" class="required saltoscrolldetalle" />	   
	 </td>     
	 <td>
	   <select name="tipo_identificacion_destinatario_id" id="tipo_identificacion_destinatario_id">
	     <option value="NULL">(... Seleccione ...)</option>
		 {foreach name=tipos_identificacion from=$TIPOSID item=t}
		   <option value="{$t.value}">{$t.text}</option>
		 {/foreach}
	   </select>	 	 
	 </td>	 
     <td>
       <input type="text" autocomplete="off" name="doc_destinatario" id="doc_destinatario" value="" class="required integer saltoscrolldetalle" />
     </td>           
     <td><input type="text" autocomplete="off" name="direccion_destinatario" id="direccion_destinatario" value="" class="required saltoscrolldetalle" /></td>     
     <td>
       <input type="text" autocomplete="off" name="destino" id="destino" value="" class="required saltoscrolldetalle">     
       <input type="hidden" name="destino_id" id="destino_id" value="" class="required integer">            
     </td>      
     <td><input type="text" autocomplete="off" name="telefono_destinatario" id="telefono_destinatario" value="" class="required integer saltoscrolldetalle" /></td>     
     <td><input type="text" autocomplete="off" name="referencia_producto" id="referencia_producto" value="" class="required saltoscrolldetalle" /></td>     
     <td><input type="text" autocomplete="off" name="descripcion_producto" id="descripcion_producto" value="" class="saltoscrolldetalle" /></td>     
     <td><input type="text" autocomplete="off" name="cantidad" id="cantidad" value="" class="required integer saltoscrolldetalle" /></td>          
     <td><input type="text" autocomplete="off" name="peso" id="peso" value="" class="required integer saltoscrolldetalle" /></td>               
     <td>
       <select name="unidad_peso_id" class="required saltoscrolldetalle">
         <option value="NULL">(....)</option>
         {foreach name=unidades from=$UNIDADES item=u}
         <option value="{$u.value}" {if $u.selected }selected{/if}>{$u.text}</option>
         {/foreach}
       </select>
     </td>                    
     <td><input type="text" autocomplete="off" name="peso_volumen" id="peso_volumen" value="" class="required integer saltoscrolldetalle" /></td>               
     <td>
       <select name="unidad_volumen_id" id="unidad_volumen_id" class="required saltoscrolldetalle">
         <option value="NULL">(....)</option>
         {foreach name=unidades from=$UNIDADESVOLUMEN item=u}
         <option value="{$u.value}" {if $u.selected }selected{/if}>{$u.text}</option>
         {/foreach}
       </select>
     </td>                                                     
     <td><input type="text" autocomplete="off" name="valor_unidad" id="valor_unidad" value="" class="required integer saltoscrolldetalle" /></td>  
     <td><input type="text" autocomplete="off" name="fecha_entrega" id="fecha_entrega" value="" class="numeric" readonly /></td>               
     <td><input type="text" autocomplete="off" name="hora_entrega" id="hora_entrega" value="" class="numeric" readonly /></td>                    
     <td><a name="saveDetalleSoliServi"><img src="/application/framework/media/images/grid/save.png" /></a></td>
     <td><input type="checkbox" name="procesar" /></td>     
    </tr>
   </tbody>
  </table>
  <table>
     <tr id="clon">
	 <td><input type="text" name="shipment" id="shipment" value="" /></td>		 
     <td>
       <input type="hidden" name="detalle_ss_id" id="detalle_ss_id" vaue="" >            
       <input type="text" autocomplete="off" name="orden_despacho" id="orden_despacho" value="" class="required" />
     </td>
     <td>
	   <input type="text" autocomplete="off" name="remitente" id="remitente" value="" class="required" />
	   <input type="hidden" autocomplete="off" name="remitente_id" id="remitente_id" value="" class="required" />	   
	 </td>          
	 <td>
	   <select name="tipo_identificacion_remitente_id" id="tipo_identificacion_remitente_id">
	     <option value="NULL">(... Seleccione ...)</option>
		 {foreach name=tipos_identificacion from=$TIPOSID item=t}
		   <option value="{$t.value}">{$t.text}</option>
		 {/foreach}
	   </select>
	 </td>	 
     <td>
	   <input type="text" autocomplete="off" name="doc_remitente" id="doc_remitente" value="" class="required integer" />
	 </td>  
	 <td><input type="text" autocomplete="off" name="direccion_remitente" id="direccion_remitente" value="" class="required" /></td>   
     <td>
       <input type="text" autocomplete="off" name="origen" id="origen" value="" class="required">     
       <input type="hidden" name="origen_id" id="origen_id" value="" class="required integer">            
     </td>     
	 
     <td><input type="text" autocomplete="off" name="telefono_remitente" id="telefono_remitente" value="" class="required integer saltoscrolldetalle" /></td>          
     <td>
	   <input type="text" autocomplete="off" name="destinatario" id="destinatario" value="" class="required saltoscrolldetalle" />
	   <input type="hidden" autocomplete="off" name="destinatario_id" id="destinatario" value="" class="required saltoscrolldetalle" />	   
	 </td>     
	 <td>
	   <select name="tipo_identificacion_destinatario_id" id="tipo_identificacion_destinatario_id">
	     <option value="NULL">(... Seleccione ...)</option>
		 {foreach name=tipos_identificacion from=$TIPOSID item=t}
		   <option value="{$t.value}">{$t.text}</option>
		 {/foreach}
	   </select>	 	 
	 </td>	 
     <td>
       <input type="text" autocomplete="off" name="doc_destinatario" id="doc_destinatario" value="" class="required integer saltoscrolldetalle" />
     </td>           
     <td><input type="text" autocomplete="off" name="direccion_destinatario" id="direccion_destinatario" value="" class="required saltoscrolldetalle" /></td>     
     <td>
       <input type="text" autocomplete="off" name="destino" id="destino" value="" class="required saltoscrolldetalle">     
       <input type="hidden" name="destino_id" id="destino_id" value="" class="required integer">            
     </td>      
     <td><input type="text" autocomplete="off" name="telefono_destinatario" id="telefono_destinatario" value="" class="required integer saltoscrolldetalle" /></td>     
     <td><input type="text" autocomplete="off" name="referencia_producto" id="referencia_producto" value="" class="required saltoscrolldetalle" /></td>     
     <td><input type="text" autocomplete="off" name="descripcion_producto" id="descripcion_producto" value="" class="saltoscrolldetalle" /></td>     
     <td><input type="text" autocomplete="off" name="cantidad" id="cantidad" value="" class="required integer saltoscrolldetalle" /></td>          
     <td><input type="text" autocomplete="off" name="peso" id="peso" value="" class="required integer saltoscrolldetalle" /></td>               
     <td>
       <select name="unidad_peso_id" class="required saltoscrolldetalle">
         <option value="NULL">(....)</option>
         {foreach name=unidades from=$UNIDADES item=u}
         <option value="{$u.value}" {if $u.selected }selected{/if}>{$u.text}</option>
         {/foreach}
       </select>
     </td>                    
     <td><input type="text" autocomplete="off" name="peso_volumen" id="peso_volumen" value="" class="required numeric saltoscrolldetalle" /></td>               
     <td>
       <select name="unidad_volumen_id" id="unidad_volumen_id" class="required saltoscrolldetalle">
         <option value="NULL">(....)</option>
         {foreach name=unidades from=$UNIDADESVOLUMEN item=u}
         <option value="{$u.value}" {if $u.selected }selected{/if}>{$u.text}</option>
         {/foreach}
       </select>
     </td>                                                     
     <td><input type="text" autocomplete="off" name="valor_unidad" id="valor_unidad" value="" class="required numeric saltoscrolldetalle" /></td>               
     <td><input type="text" autocomplete="off" name="fecha_entrega" id="fecha_entrega" value="" class="numeric" readonly /></td>               
     <td><input type="text" autocomplete="off" name="hora_entrega" id="hora_entrega" value="" class="numeric" readonly /></td>                    
     <td><a name="saveDetalleSoliServi"><img src="/application/framework/media/images/grid/save.png" /></a></td>
     <td><input type="checkbox" name="procesar" /></td>     
    </tr>
  </table>
  
  </body>
</html>
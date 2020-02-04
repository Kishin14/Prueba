<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
{$JAVASCRIPT}
{$CSSSYSTEM}
</head>

<body>
    <input type="hidden" id="liquidacion_definitiva_id" value="{$LIQDEFINITIVAID}" />
    <table id="tableSolicitudServicios">
        <thead>
            <tr>
                <th>CONCEPTO</th>	
                <th>DIAS</th>
                <th>VALOR</th>          
                <th>CONCEPTO AREA</th>               	 
                <th>PUC</th>               
                <th>DEBITO</th>               
                <th>CREDITO</th>          
                <th>&nbsp;</th>
                <th><input type="checkbox" id="checkedAll"></th>     
            </tr>
        </thead>
        <tbody>
            {foreach name=detalle_solicitud from=$DETALLES item=d}
            <tr>
                <td><input type="text" name="concepto" id="concepto" value="{$d.concepto}" /></td>
                <td>
                    <input type="hidden" name="liq_def_deduccion_id" id="liq_def_deduccion_id" value="{$d.liq_def_deduccion_id}">            
                    <input type="text" autocomplete="off" name="dias" id="dias" value="{$d.dias}" class="required" />
                </td>
                <td>
                    <input type="text" autocomplete="off" name="valor" id="valor" value="{$d.valor}" class="required" />	   
                </td>          
                <td>
                    <select name="concepto_area_id" id="concepto_area_id">
                    <option value="NULL">(... Seleccione ...)</option>
                    {foreach name=concepto_area from=$CONCEPTOS item=t}
                    <option value="{$t.value}" {if $d.concepto_area_id eq $t.value}selected{/if}>{$t.text}</option>
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
                	<a name="saveDetalleSoliServi"><img src="/application/framework/media/images/grid/save.png" /></a>
				</td>
                <td>
                	<input type="checkbox" name="procesar" />
				</td>     
            </tr>   
            {/foreach}
            <tr>
                <td><input type="text" name="concepto" id="concepto" value="{$d.concepto}" /></td>
                <td>
                    <input type="hidden" name="liq_def_deduccion_id" id="liq_def_deduccion_id" value="{$d.liq_def_deduccion_id}">            
                    <input type="text" autocomplete="off" name="dias" id="dias" value="{$d.dias}" class="required" />
                </td>
                <td>
                    <input type="text" autocomplete="off" name="valor" id="valor" value="{$d.valor}" class="required" />	   
                </td>          
                <td>
                    <select name="concepto_area_id" id="concepto_area_id">
                    <option value="NULL">(... Seleccione ...)</option>
                    {foreach name=concepto_area from=$CONCEPTOS item=t}
                    <option value="{$t.value}" {if $d.concepto_area_id eq $t.value}selected{/if}>{$t.text}</option>
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
                	<a name="saveDetalleSoliServi"><img src="/application/framework/media/images/grid/save.png" /></a>
				</td>
                <td>
                	<input type="checkbox" name="procesar" />
				</td>     
            </tr>
		</tbody>
	</table>
    <table>
		<tr id="clon">
            <td><input type="text" name="concepto" id="concepto" value="{$d.concepto}" /></td>
            <td>
                <input type="hidden" name="liq_def_deduccion_id" id="liq_def_deduccion_id" value="{$d.liq_def_deduccion_id}">            
                <input type="text" autocomplete="off" name="dias" id="dias" value="{$d.dias}" class="required" />
            </td>
            <td>
                <input type="text" autocomplete="off" name="valor" id="valor" value="{$d.valor}" class="required" />	   
            </td>          
            <td>
                <select name="concepto_area_id" id="concepto_area_id">
                <option value="NULL">(... Seleccione ...)</option>
                {foreach name=concepto_area from=$CONCEPTOS item=t}
                <option value="{$t.value}" {if $d.concepto_area_id eq $t.value}selected{/if}>{$t.text}</option>
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
                <a name="saveDetalleSoliServi"><img src="/application/framework/media/images/grid/save.png" /></a>
            </td>
            <td>
                <input type="checkbox" name="procesar" />
            </td>
		</tr>
    </table>

</body>
</html>
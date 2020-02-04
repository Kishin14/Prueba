<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body>
    <div align="center">
      <input type="hidden" id="empleado_id" value="{$CONYID}" />
      <table id="tableDetalle" align="center">
         <thead>
            <tr>          	 
               <th>Tipo de Identificacion</th>
               <th>Numero de Identificacion</th>
               <th>Primer Nombre</th>
               <th>Segundo Nombre</th>
               <th>Primer Apellido</th>
               <th>Segundo Apellido</th>
               <th>Fecha de Nacimiento</th>
               <th>Fecha Inicio</th>
               <th>Fecha Final</th>
               <th>Estado</th>
               <th>&nbsp;</th>   
               <th><input type="checkbox" id="checkedAll"></th> 
            </tr>
          </thead>
          <tbody>
            {foreach name=detalle_solicitud from=$CONYUGEEM item=d}
            <tr>
              	<td>
                  <input type="hidden" name="empleado_id" id="empleado_id" value="{$d.empleado_id}" /> 
                  <input type="hidden" name="conyuge_id" id="conyuge_id" value="{$d.conyuge_id}" />   
                 
                    
                  <select name="tipo_identificacion_id" class="required">
                    
                {foreach name=tipo_identificacion from=$TIP item=c}
                  
                    <option value="{$c.value}" {if $c.value == $d.tipo_identificacion_id}selected{/if}>{$c.text}</option>
                    
                {/foreach}
                
              </select></td>
             
                <td><input name="numero_identificacion" type="text" value="{$d.numero_identificacion}"></td>
                <td><input name="primer_nombre" type="text" value="{$d.primer_nombre}" class="required"></td>
                <td><input name="segundo_nombre" type="text" value="{$d.segundo_nombre}"></td>
                <td><input name="primer_apellido" type="text" value="{$d.primer_apellido}" class="required"></td>
                <td><input name="segundo_apellido" type="text" value="{$d.segundo_apellido}"></td>
                <td><input name="fecha_nacimiento" type="text" class="dtp" value="{$d.fecha_nacimiento}"></td>
                <td><input name="fecha_inicio" type="text" class="dtp" value="{$d.fecha_inicio}"></td>
                <td><input name="fecha_final" type="text" class="dtp" value="{$d.fecha_final}"></td>
                <td><select name="estado2">
                  
                      {if $d.estado == "1"}
                          
                  <option value="1" selected> ACTIVO </option>
                  <option value="0" > INACTIVO </option>
                   
                      {/if}
                      {if $d.estado == "0"}
                          
                  <option value="1" > ACTIVO </option>
                <option value="0" selected> INACTIVO </option>
                   
                      {/if}
                  
                </select></td>
                <td><a name="saveDetalle"><img src="../../../framework/media/images/grid/save.png" /></a></td>
                <td><input type="checkbox" name="procesar" /></td>
                <td>&nbsp;</td>     
            </tr>   
            {/foreach}
            <tr>
             
                <td>
                  <input type="hidden" name="conyuge_id" id="conyuge_id" value="" /> 
                  <select name="tipo_identificacion_id" class="required" required>
                      <option value="null" selected disabled>SELECCIONE..</option>
                  {foreach name=tipo_identificacion from=$TIP item=d}
                      <option value="{$d.value}">{$d.text}</option>
                  {/foreach}
                </select>
                </td>
                <td> <input name="numero_identificacion" type="text"> </td>
                <td> <input name="primer_nombre" type="text" class="required"> </td>
                <td> <input name="segundo_nombre" type="text"> </td>
                <td> <input name="primer_apellido" type="text" class="required"> </td>
                <td> <input name="segundo_apellido" type="text"> </td>
                <td> <input name="fecha_nacimiento" class="dtp" type="text"> </td>
                <td> <input name="fecha_inicio" class="dtp" type="text"> </td>
                <td> <input name="fecha_final" class="dtp" type="text"> </td>
                <td> 
                  <select name="estado">
                    <option value="1" > ACTIVO </option> 
                    <option value="0" > INACTIVO </option>
                  </select>
                </td>
                <td><a name="saveDetalle"><img src="../../../framework/media/images/grid/save.png" /></a></td>
                <td><input type="checkbox" name="procesar" /></td>    
            </tr> 
            <tr id="clon">
              
                <td>
                <input type="hidden" name="conyuge_id" id="conyuge_id" value="" /> 
                <select name="tipo_identificacion_id2" class="required" required>
                  <option value="null" selected disabled>SELECCIONE..</option>
                  
                  {foreach name=tipo_identificacion from=$TIP item=d}
                      
                  <option value="{$d.value}">{$d.text}</option>
                  
                  {/foreach}
                
              </select></td>
                <td> <input name="numero_identificacion" type="text"> </td>
                <td> <input name="primer_nombre" type="text" class="required"> </td>
                <td> <input name="segundo_nombre" type="text"> </td>
                <td> <input name="primer_apellido" type="text" class="required"> </td>
                <td> <input name="segundo_apellido" type="text"> </td>
                <td> <input name="fecha_nacimiento" class="dtp" type="text"> </td>
                <td> <input name="fecha_inicio" class="dtp" type="text"> </td>
                <td> <input name="fecha_final" class="dtp" type="text"> </td>
                <td> 
                  <select name="estado">
                    <option value="1" > ACTIVO </option> 
                    <option value="0" > INACTIVO </option>
                  </select>
                </td>
                <td><a name="saveDetalle"><img src="../../../framework/media/images/grid/save.png" /></a></td>
                <td><input type="checkbox" name="procesar" /></td>    
            </tr>       
  	       </tbody>
      </table>
    </div>
  </body>
</html>
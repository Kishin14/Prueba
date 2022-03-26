<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
   <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body>
    <div align="center">
      <input type="hidden" id="empleado_id" value="{$EMPID}" />
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
               <th>Edad</th>
               <th>Estado</th>
               <th>CIUDAD RESIDENCIA </th>
               <th>&nbsp;</th>
               <th><input type="checkbox" id="checkedAll"></th> 
            </tr>
          </thead>
          <tbody>
            {foreach name=detalle_solicitud from=$HIJOSEM item=d}
            <tr>
             
                <td>
                  <input type="hidden" name="empleado_id" id="empleado_id" value="{$d.empleado_id}" />   
                  <input type="hidden" name="hijos_id"    id="hijos_id"    value="{$d.hijos_id}" />                     
                
                <select name="tipo_identificacion_id" class="required">

                {foreach name=tipo_identificacion from=$TIP item=c}
                  <option value="{$c.value}" {if $c.value == $d.tipo_identificacion_id}selected{/if}>{$c.text}</option>
                {/foreach}
                </select></td>
                <td> <input name="numero_identificacion" type="text" value="{$d.numero_identificacion}">        </td>
                <td> <input name="primer_nombre"         type="text" value="{$d.primer_nombre}">                </td>
                <td> <input name="segundo_nombre"        type="text" value="{$d.segundo_nombre}">               </td>
                <td> <input name="primer_apellido"       type="text" value="{$d.primer_apellido}">              </td>
                <td> <input name="segundo_apellido"      type="text" value="{$d.segundo_apellido}">             </td>
                <td> <input name="fecha_nacimiento"      type="date" value="{$d.fecha_nacimiento}" class="dtp"> </td>
                <td> <input name="edad"                  type="text" value="{$d.edad}"             class="required numeric"> </td>
                <td> 
                  <select name="estado">
                      {if $d.estado == "1"}
                          <option value="1" selected> ACTIVO </option> 
                          <option value="0" > INACTIVO </option> 
                      {/if}
                      {if $d.estado == "0"}
                          <option value="1" > ACTIVO </option> 
                          <option value="0" selected> INACTIVO </option> 
                      {/if}
                  </select>
                </td>
                <td>

       <input type="text" autocomplete="off" name="ubicacion" id="ubicacion" value="{$d.ubicacion}" class="required saltoscrolldetalle" />     
       <input type="hidden" name="ubicacion_id" id="ubicacion_id" value="{$d.ubicacion_id}" class="required integer" />            
               </td> 
                <td><a name="saveDetalle"><img src="../../../framework/media/images/grid/save.png" /></a></td>
                <td><input type="checkbox" name="procesar" /></td>     
            </tr>   
            {/foreach}
            <tr>
              
                <td>
                 <input type="hidden" name="hijos_id" id="hijos_id" value="" />      
                  <select name="tipo_identificacion_id" class="required" required>
                      <option value="null" selected disabled>SELECCIONE..</option>
                  {foreach name=tipo_identificacion from=$TIP item=d}
                      <option value="{$d.value}">{$d.text}</option>
                  {/foreach}
                </select>
                </td>
                <td> <input name="numero_identificacion" type="text"> </td>
                <td> <input name="primer_nombre"         type="text"> </td>
                <td> <input name="segundo_nombre"        type="text"> </td>
                <td> <input name="primer_apellido"       type="text"> </td>
                <td> <input name="segundo_apellido"      type="text"> </td>
                <td> <input name="fecha_nacimiento"      type="date" class="dtp"> </td>
                <td> <input name="edad"                  type="text" class="required numeric"> </td>
                <td> 
                  <select name="estado">
                    <option value="1" > ACTIVO </option> 
                    <option value="0" > INACTIVO </option>
                  </select>
                </td>
                  <td>

            <input type="text" autocomplete="off" name="ubicacion" id="ubicacion" value="" class="required saltoscrolldetalle">     
            <input type="hidden" name="ubicacion_id" id="ubicacion_id" value="" class="required integer">    

                  </td>     
                <td><a name="saveDetalle"><img src="../../../framework/media/images/grid/save.png" /></a></td>
                <td><input type="checkbox" name="procesar" /></td>    
            </tr> 
            <tr id="clon">
              
                <td>
                 
                 <input type="hidden" name="hijos_id" id="hijos_id" value="" />      
                  <select name="tipo_identificacion_id2" class="required" required>
                  <option value="null" selected disabled>SELECCIONE..</option>
                  
                  {foreach name=tipo_identificacion from=$TIP item=d}
                      
                  <option value="{$d.value}">{$d.text}</option>
                  
                  {/foreach}
                
              </select></td>
                <td> <input name="numero_identificacion" type="text"> </td>
                <td> <input name="primer_nombre"         type="text"> </td>
                <td> <input name="segundo_nombre"        type="text"> </td>
                <td> <input name="primer_apellido"       type="text"> </td>
                <td> <input name="segundo_apellido"      type="text"> </td>
                <td> <input name="fecha_nacimiento"      type="date" class="dtp"> </td>
                <td> <input name="edad"                  type="text" class="required numeric" > </td>
                <td> 
                  <select name="estado">
                    <option value="1" > ACTIVO </option> 
                    <option value="0" > INACTIVO </option>
                  </select>
                </td>
                <td>
       <input type="text" autocomplete="off" name="ubicacion" id="ubicacion" value="" class="required saltoscrolldetalle">     
       <input type="hidden" name="ubicacion_id" id="ubicacion_id" value="" class="required integer">            
              </td> 
                <td><a name="saveDetalle"><img src="../../../framework/media/images/grid/save.png" /></a></td>
                <td><input type="checkbox" name="procesar" /></td>    
            </tr>      
  	       </tbody>
      </table>
    </div>
  </body>
</html>
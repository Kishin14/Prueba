<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body>
<div align="center">
      <input type="hidden" id="empleado_id" value="{$ESTID}" />
  <table id="tableDetalle" align="center">
     <thead>
        <tr>            	 
           <th>Nivel Escolaridad</th>
           <th>Titulo</th>
           <th>Fecha Terminacion</th>
           <th>Institucion</th>
           <th>Acta De Grado</th>
           <th>&nbsp;</th>
           <th><input type="checkbox" id="checkedAll"></th> 
        </tr>
      </thead>
      <tbody>
        {foreach name=detalle_solicitud from=$ESTUDIOSEM item=d}
        <tr>
            <td>
                <input type="hidden" name="empleado_id" id="empleado_id" value="{$d.empleado_id}" />   
                <input type="hidden" name="estudio_id" id="estudio_id" value="{$d.estudio_id}" />
            
            	<select name="nivel_escolaridad_id" class="required">
                {foreach name=tipo_identificacion from=$NIV item=c}
                  <option value="{$c.value}" {if $c.value == $d.nivel_escolaridad_id}selected{/if}>{$c.text}</option>
                {/foreach}
                </select></td>
            <td> <input name="titulo" type="text" value="{$d.titulo}"> </td>
            <td> <input name="fecha_terminacion" type="text" class="dtp" value="{$d.fecha_terminacion}"> </td>
            <td> <input name="institucion" type="text" value="{$d.institucion}"> </td>
            <td> <input name="acta_de_grado" type="text" value="{$d.acta_de_grado}"> </td>
            <td><a name="saveDetalle3"><img src="../../../framework/media/images/grid/save.png" /></a></td>
            <td><input type="checkbox" name="procesar" /></td>     
        </tr>   
        {/foreach}
        <tr>
              
            <td>
              <input type="hidden" name="estudio_id" id="estudio_id" value="" />
              <select name="nivel_escolaridad_id" class="required">
                <option value="null" selected disabled>SELECCIONE..</option>
                
                  {foreach name=tipo_identificacion from=$NIV item=d}
                      
                <option value="{$d.value}">{$d.text}</option>
                
                  {/foreach}
                
              </select></td>
            <td> <input name="titulo" type="text"> </td>
            <td> <input name="fecha_terminacion" class="dtp" type="text"> </td>
            <td> <input name="institucion"  type="text"> </td>
            <td> <input name="acta_de_grado"  type="text"> </td>
            <td><a name="saveDetalle3"><img src="../../../framework/media/images/grid/save.png" /></a></td>
            <td><input type="checkbox" name="procesar" /></td>    
        </tr> 
        <tr id="clon">
             
          <td>
                <input type="hidden" name="estudio_id" id="estudio_id" value=""/>
                <select name="nivel_escolaridad_id" class="required" required>
                  <option value="null" selected disabled>SELECCIONE..</option>
                  
                  {foreach name=tipo_identificacion from=$NIV item=d}
                      
                  <option value="{$d.value}">{$d.text}</option>
                  
                  {/foreach}
                
              </select></td>
            <td> <input name="titulo" type="text"> </td>
            <td> <input name="fecha_terminacion" class="dtp" type="text"> </td>
             <td> <input name="institucion" type="text"> </td>
             <td> <input name="acta_de_grado" type="text"> </td>
              
            <td><a name="saveDetalle3"><img src="../../../framework/media/images/grid/save.png" /></a></td>
            <td><input type="checkbox" name="procesar" /></td>    
        </tr>       
       </tbody>
  </table>
  </div>
  </body>
</html>
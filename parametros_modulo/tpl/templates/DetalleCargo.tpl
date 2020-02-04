<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">



  <head>



   <meta http-equiv="content-type" content="text/html; charset=utf-8">



  {$JAVASCRIPT}



  {$CSSSYSTEM}



  </head>







  <body>



  <div align="center">



  <input type="hidden" id="cargo_id" value="{$CARGOID}" />



  <table id="tableDetalle" align="center">



   <thead>



    <tr>



     <th>LICENCIA</th>          



     <th>ESTADO</th>               	 



     <th>&nbsp;</th>



     <th><input type="checkbox" id="checkedAll"></th>     



    </tr>



    </thead>



    



    <tbody>







    {foreach name=detalle_solicitud from=$DETALLES item=d}



    <tr>



	 <td>



	   <input type="hidden" name="categoria_cargo_id" id="categoria_cargo_id" value="{$d.categoria_cargo_id}" />	 



	   <select name="categoria_id" class="required">



	     <option value="NULL">(... Seleccione ...)</option>



		 



		 {foreach name=oficinas from=$OFICINAS item=b}



		 <option value="{$b.value}" {if $b.value eq $d.categoria_id}selected{/if}>{$b.text}</option>



		 {/foreach}



	   </select>



	 </td>



	 <td>

    <!-- <input type="text" name="estado" id="estado" value="{$d.estado}" class="required" /> -->

    <select name="estado" id="estado" value="" class="required" style="width: 100%">

      <option value="A" {if $d.estado eq "A"}selected{/if}>ACTIVO</option>

      <option value="I" {if $d.estado eq "I"}selected{/if}>INACTIVO</option>

    </select>



   </td>



     <td><a name="saveDetalle"><img src="../../../framework/media/images/grid/save.png" /></a></td>



     <td><input type="checkbox" name="procesar" /></td>     



    </tr>   



    {/foreach}







    <tr>



	 <td>



	<input type="hidden" name="categoria_cargo_id" id="categoria_cargo_id" value="" />	 



	   <select name="categoria_id" class="required">



	     <option value="NULL">(... Seleccione ...)</option>



		 



		 {foreach name=oficinas from=$OFICINAS item=b}



		 <option value="{$b.value}" >{$b.text}</option>



		 {/foreach}



	   </select>



	 </td>



	 <td>

    <select name="estado" id="estado" value="" class="required" style="width: 100%">

      <option value="A">ACTIVO</option>

      <option value="I">INACTIVO</option>

    </select>

   </td>



     <td><a name="saveDetalle"><img src="../../../framework/media/images/grid/save.png" /></a></td>



     <td><input type="checkbox" name="procesar" /></td>    



    </tr>       



	</tbody>



  </table>



  <table>



  



    <tr id="clon">



	 <td>



	<input type="hidden" name="categoria_cargo_id" id="categoria_cargo_id" value="" />	 



	   <select name="categoria_id">



	     <option value="NULL">(... Seleccione ...)</option>



		 



		 {foreach name=oficinas from=$OFICINAS item=b}



		 <option value="{$b.value}" >{$b.text}</option>



		 {/foreach}



	   </select>



	 </td>



	 <td>

    <!-- <input type="text" name="estado" id="estado" value="" /> -->

    <select name="estado" id="estado" value="" class="required" style="width: 100%">

      <option value="A">ACTIVO</option>

      <option value="I">INACTIVO</option>

    </select>

   </td>



     <td><a name="saveDetalle"><img src="../../../framework/media/images/grid/save.png" /></a></td>



     <td><input type="checkbox" name="procesar" /></td>      



    </tr>      



  </table>



  </div>



  </body>



</html>
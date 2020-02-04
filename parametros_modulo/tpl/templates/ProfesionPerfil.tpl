<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">



  <head>



   <meta http-equiv="content-type" content="text/html; charset=utf-8">



  {$JAVASCRIPT}



  {$CSSSYSTEM}



  </head>







  <body>



  <div align="center">



  <input type="hidden" id="perfil_id" value="{$PERFILID}" />



  <table id="tableDetalle" align="center">



   <thead>



    <tr>



     <th>PROFESION</th>            	 



     <th>&nbsp;</th>



     <th><input type="checkbox" id="checkedAll"></th>     



    </tr>



    </thead>



    



    <tbody>







    {foreach name=detalle_solicitud from=$DETALLES item=d}



    <tr>



	 <td>



	   <input type="hidden" name="profesion_perfil_id" id="profesion_perfil_id" value="{$d.profesion_perfil_id}" />	 



	   <select name="profesion_id" class="required">



	     <option value="NULL">(... Seleccione ...)</option>



		 



		 {foreach name=profesiones from=$PROFESIONES item=b}



		 <option value="{$b.value}" {if $b.value eq $d.profesion_id}selected{/if}>{$b.text}</option>



		 {/foreach}



	   </select>



	 </td>



     <td><a name="saveDetalle"><img src="../../../framework/media/images/grid/save.png" /></a></td>



     <td><input type="checkbox" name="procesar" /></td>     



    </tr>   



    {/foreach}







    <tr>



	 <td>



	<input type="hidden" name="profesion_perfil_id" id="profesion_perfil_id" value="" />	 



	   <select name="profesion_id" class="required">



	     <option value="NULL">(... Seleccione ...)</option>



		 



		 {foreach name=profesiones from=$PROFESIONES item=b}



		 <option value="{$b.value}" >{$b.text}</option>



		 {/foreach}



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



	<input type="hidden" name="profesion_perfil_id" id="profesion_perfil_id" value="" />	 



	   <select name="profesion_id">



	     <option value="NULL">(... Seleccione ...)</option>



		 



		 {foreach name=profesiones from=$PROFESIONES item=b}



		 <option value="{$b.value}" >{$b.text}</option>



		 {/foreach}



	   </select>



	 </td>



     <td><a name="saveDetalle"><img src="../../../framework/media/images/grid/save.png" /></a></td>



     <td><input type="checkbox" name="procesar" /></td>      



    </tr>      



  </table>



  </div>



  </body>



</html>
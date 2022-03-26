{if $sectionOficinasTree neq 1}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">

  {$JAVASCRIPT}
  {$TABLEGRIDJS}
  {$CSSSYSTEM} 
  {$TABLEGRIDCSS} 
  {$TITLETAB}
  </head>

  <body>
  
	<fieldset>
        <legend>{$TITLEFORM}</legend>

        
        {$FORM1}
 <fieldset class="section">       
        <table>
          <tr>
            <td><label>Usuario :</label></td>
            <td>{$USUARIO}{$USUARIOID}</td>
          </tr>
          <tr>
            <td><label>Oficinas :</label></td>
            <td>{$OFICINAID}</td>
          </tr>
          <tr>
            <td colspan="2" align="center">{$GUARDAR}{$LIMPIAR}</td>
          </tr>
         </table>
 </fieldset>        
        {$FORM1END}
    </fieldset>

  </body>
</html>
	
{/if}    

{if $sectionOficinasTree eq 1}



<div id="convenciones">
    <div style="float:right; margin-right:-8px;">
{foreach name=permisos_opcion from=$permisos item=p}
		<div style="width:80px; float:left">
        	
            	<input  type="checkbox" name="permiso" id="permiso_{$p.permiso_id}" value="{$p.permiso_id}" disabled>
        	
        	<label style="text-align:left; background:{$p.color};" for="permiso_{$p.permiso_id}">{$p.descripcion}</label>
    	</div>
{/foreach}
	</div>
</div>

{if $encabezadoTree eq 1}
<fieldset class="section" id="oficinasTree">
 <div align="center">
 <table  width="90%" id="tablePermisos">
  <tr><td align="left" style="padding-top:5px">{$OFICINASASIGNADASID}</td><td align="right">{$OTORGARDENEGAR}</td></tr>
 <tr>
 <tr><td colspan="2">&nbsp;</td></tr>
 </table>

 
</div>
<table id="tree" class="treeTable" width="80%">
<tbody>
{/if}
{if $nivelEmpresa eq 1}
<tr id="ex2-node-{$node}" style="font-size:12px; background-color:{$color};">
  <td  style="border-bottom:1px solid;border-color:#999;" >
    <input type="checkbox" name="consecutivo" value="{$consecutivo}" id="input_ex2-node-{$node}" class="superior">
    <img src="{$path_imagen}" width="25" height="25" />{$descripcion}
  </td>
</tr>
{/if}
{if $nivelOficina eq 1}
<tr id="ex2-node-{$node}" class="child-of-ex2-node-{$child}" style="font-size:12px;">
  <td valign="top">
    <table style="border-right:1px solid; border-bottom:1px solid;border-color:#999; padding:0px; margin:0px;background-color:{$color}">
      <tr>
        <td width="90%"><input type="checkbox" name="consecutivo" id="input_ex2-node-{$node}" value="{$consecutivo}"><img src="{$path_imagen}" width="20" height="20" />{$descripcion}</td>
        <td align="right">
          <table>
           <tr>
            {foreach name=permisos_opcion from=$permisos item=p}
              <td><span style=" background-color:{$p.color}"><input type="checkbox" name="permiso" value="{$p.permiso_id}"/></span></td>
            {/foreach}
           </tr>
         </table>
       </td>
     </tr>
   </table>
</td>
</tr>{/if}
{if $pieTree eq 1}
</tbody>			
</table>		 
</fieldset>
{/if}
{/if}
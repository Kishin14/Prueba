<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body> 
  <input type="hidden" id="tipo" value="{$tipo}" />
  
  <table width="90%" align="center" id="encabezado" border="0">
  	<tr><td width="30%">&nbsp;</td><td align="center" class="titulo" width="40%">{if $tipo eq 'ALL'}Todos las Sentencias{elseif  $tipo eq 'EC'}Solo Ingresos{elseif  $tipo eq 'PE'}Solo Actualizaciones{elseif  $tipo eq 'DL'}Solo Eliminaciones{/if}</td><td width="30%" align="right">&nbsp;</td></tr>	
  	<tr><td colspan="3">&nbsp;</td></tr>
  	<tr><td align="center" colspan="3">Rango Inicial : {$desde}&nbsp;&nbsp;&nbsp;&nbsp;Rango Final: {$hasta} {if $palabra neq ''  and $palabra neq 'NULL'}REFERENCIA: {$palabra}{/if}</td></tr>	 	   
  </table>	


      {assign var="users" value=""}
      {foreach name=detalles from=$DETALLES item=i}
  
      {if $users eq '' or $users neq $i.user}
          
      {assign var="users" value=$i.user}
      {if $users neq '' or $users neq $i.user}</table><br><br>{/if}
	  <table align="center" id="encabezado"  width="90%">

      <tr>
        <th colspan="5" align="left">{$i.user}<br /></th>
      
      </tr>	
      <tr>
        <th colspan="5" align="left">&nbsp;</th>
      </tr>	

      <tr>
        <th class="borderLeft borderTop borderRight">FECHA</th>
        <th class="borderTop borderRight">HORA</th>
        <th class="borderTop borderRight">TABLA</th>
        <th class="borderTop borderRight">SENTENCIA</th>
        <th class="borderTop borderRight">CONSULTA</th>		
        <th class="borderTop borderRight">CAMPOS</th>		
      </tr>
      {/if}
      <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
        <td class="borderLeft borderTop borderRight" width="80" style="font-size:10px;" valign="top">&nbsp;{$i.fecha}&nbsp;</td> 
        <td class="borderTop borderRight" width="80" style="font-size:10px;" valign="top">&nbsp;{$i.hora}&nbsp;</td>  
        <td class="borderTop borderRight" width="150" style="font-size:10px;" valign="top">&nbsp;{$i.tabla}&nbsp;</td>  
        <td class="borderTop borderRight" width="100" style="font-size:10px;" valign="top">&nbsp;{$i.sentencia}&nbsp;</td>  
        <td class="borderTop borderRight" width="350" style="font-size:8px;">&nbsp;{$i.query|replace:",":", "}</td>  
        <td class="borderTop borderRight" width="350" style="font-size:8px;">&nbsp;{$i.registro_json|replace:",":", "}</td>  
      </tr> 
      {/foreach}	
  </table>
  </body>
</html>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body> 
  <table width="90%" align="center" id="encabezado" border="0">
  	<tr><td width="30%">&nbsp;</td><td align="center" class="titulo" width="40%">Reporte de Permisos</td><td width="30%" align="right">&nbsp;</td></tr>	
  	<tr><td colspan="3">&nbsp;</td></tr>
  	<tr><td align="center" colspan="3">&nbsp;</td></tr>	 	   
  </table>	
	  <table align="center" id="encabezado"  width="90%">
      <tr>
        <th colspan="10" align="left"><br /></th>
      </tr>	
      {assign var="usuario" value=""}
      {assign var="oficina" value=""}

      {foreach name=detalles from=$data item=i}
      {if $usuario eq '' or $usuario neq $i.nombre_usuario}
          <tr>
            <th colspan="10" align="left" style="font-size:10px;">&nbsp;{$i.nombre_usuario}&nbsp;</th>
          </tr>	
          <tr>
            <th class="borderLeft borderTop borderRight" colspan="10" align="left" style="font-size:10px;">&nbsp;OFICINA&nbsp;-&nbsp;{$i.nombre_oficina}</th>
          </tr>
          
          <tr>
            <th rowspan="2" class="borderLeft borderTop borderRight">MODULO</th>
            <th rowspan="2" class="borderTop borderRight">ACTIVIDAD</th>
            <th colspan="8"class="borderTop borderRight">PERMISOS</th>
          </tr>
          <tr>
            <th class="borderTop borderRight" width="5%">ANULAR</th>
            <th class="borderTop borderRight" width="5%">INSERTAR</th>
            <th class="borderTop borderRight" width="5%">ACTUALIZAR</th>
            <th class="borderTop borderRight" width="5%">BORRAR</th>
            <th class="borderTop borderRight" width="5%">LIMPIAR</th>
            <th class="borderTop borderRight" width="5%">IMPRIMIR</th>
            <th class="borderTop borderRight" width="5%">LIQUIDAR</th>
            <th class="borderTop borderRight" width="5%">ESTADO</th>
          </tr>
      		{assign var="usuario" value=$i.nombre_usuario}
            {assign var="oficina" value=$i.nombre_oficina}
      {/if}
       {if $oficina eq '' or $oficina neq $i.nombre_oficina}
          <tr>
            <th colspan="10" align="left" style="font-size:10px;"><br>&nbsp;{$i.nombre_usuario}&nbsp;</th>
          </tr>	
          <tr>
            <th class="borderLeft borderTop borderRight" colspan="10" align="left" style="font-size:10px;">&nbsp;OFICINA&nbsp;-&nbsp;{$i.nombre_oficina}</th>
          </tr>
          
          <tr>
            <th rowspan="2" class="borderLeft borderTop borderRight">MODULO</th>
            <th rowspan="2" class="borderTop borderRight">ACTIVIDAD</th>
            <th colspan="8"class="borderTop borderRight">PERMISOS</th>
          </tr>
          <tr>
            <th class="borderTop borderRight" width="5%">ANULAR</th>
            <th class="borderTop borderRight" width="5%">INSERTAR</th>
            <th class="borderTop borderRight" width="5%">ACTUALIZAR</th>
            <th class="borderTop borderRight" width="5%">BORRAR</th>
            <th class="borderTop borderRight" width="5%">LIMPIAR</th>
            <th class="borderTop borderRight" width="5%">IMPRIMIR</th>
            <th class="borderTop borderRight" width="5%">LIQUIDAR</th>
            <th class="borderTop borderRight" width="5%">ESTADO</th>
          </tr>
      		{assign var="oficina" value=$i.nombre_oficina}
      {/if}
      <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
        <td class="borderLeft borderTop borderRight borderBottom" width="80" style="font-size:10px;" valign="top">{$i.nombre_modulo}</td> 
        <td class="borderTop borderRight borderBottom" width="80" style="font-size:10px;" valign="top">{$i.actividad}</td>  
        <td class="borderTop borderRight borderBottom" width="80" style="font-size:10px;" valign="top">{$i.ANULAR}</td>  
        <td class="borderTop borderRight borderBottom" width="80" style="font-size:10px;" valign="top">{$i.INSERTAR}</td>  
        <td class="borderTop borderRight borderBottom" width="80" style="font-size:10px;" valign="top">{$i.ACTUALIZAR}</td>  
        <td class="borderTop borderRight borderBottom" width="80" style="font-size:10px;" valign="top">{$i.BORRAR}</td>  
        <td class="borderTop borderRight borderBottom" width="80" style="font-size:10px;" valign="top">{$i.LIMPIAR}</td>  
        <td class="borderTop borderRight borderBottom" width="80" style="font-size:10px;" valign="top">{$i.IMPRIMIR}</td> 
        <td class="borderTop borderRight borderBottom" width="80" style="font-size:10px;" valign="top">{$i.LIQUIDAR}</td>  
        <td class="borderTop borderRight borderBottom" width="80" style="font-size:10px;" valign="top">{$i.ESTADO}</td>  
      </tr> 
      {/foreach}
  </table>
  </body>
</html>
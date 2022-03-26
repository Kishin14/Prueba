<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body> 
  <input type="hidden" id="tipo" value="{$tipo}" />
  
  <table width="90%" align="center" id="encabezado" border="0">
  	<tr><td width="30%">&nbsp;</td>
  	<td align="center" class="titulo" width="40%">REPORTES HORAS EXTRAS</td><td width="30%" align="right">&nbsp;</td></tr>	
  	<tr><td colspan="3">&nbsp;</td></tr>
  	<tr><td align="center" colspan="3">Rango Inicial : {$desde}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbspRango Final: {$hasta}</td></tr>	
  </table>
	 
     
       
  		<table align="center" id="encabezado"  width="90%"> 
        
          <tr>
            <th class="borderLeft borderTop borderRight">HORA EXTRAS</th>
            <th class="borderTop borderRight">FECHA INICIAL</th>
            <th class="borderTop borderRight">FECHA FINAL</th>
            <th class="borderTop borderRight">HORAS DIURNAS</th>            
            <th class="borderTop borderRight">HORAS NORTURNAS</th>
            <th class="borderTop borderRight">HORAS DIURNAS Y FESTIVOS</th>
            <th class="borderTop borderRight">HORAS NOCTURNAS Y FESTIVOS</th>                        
            <th class="borderTop borderRight">HORAS RECARGO NOCTURNAS</th>
            <th class="borderTop borderRight">EMPLEADO</th>            		
            <th class="borderTop borderRight">ESTADO</th>
          </tr>  
                 
         {foreach name=detalles from=$DetallesHorasExtras item=r}
          		
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">          
		    <td class="borderLeft borderTop borderRight" align="center">{$r.hora_extra_id}</td>             
            <td class="borderTop borderRight" align="center">{$r.fecha_inicial}</td>  
            <td class="borderTop borderRight" align="center">{$r.fecha_final}</td>
            <td class="borderTop borderRight" align="center">{$r.horas_diurnas}</td>              
            <td class="borderTop borderRight" align="center">{$r.horas_nocturnas}</td>  
            <td class="borderTop borderRight" align="center">{$r.horas_diurnas_fes}</td>
            <td class="borderTop borderRight" align="center">{$r.horas_nocturnas_fes}</td>                        
            <td class="borderTop borderRight">{$r.horas_recargo_noc}</td>  
            <td class="borderTop borderRight">{$r.contrato_id}</td>              
            <td class="borderTop borderRight" align="center">{$r.estado}</td>  
          </tr> 
          {/foreach}
          <tr> <th colspan="7" align="left">&nbsp;</th> </tr>
                        
  </table>
  </body>
</html>
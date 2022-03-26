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
  	<td align="center" class="titulo" width="40%">REPORTES CONTRATOS</td><td width="30%" align="right">&nbsp;</td></tr>	
  	<tr><td colspan="3">&nbsp;</td></tr>
  	<tr><td align="center" colspan="3">Rango Inicial : {$desde}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbspRango Final: {$hasta}</td></tr>	
  </table>
	 
     
       
  		<table align="center" id="encabezado"  width="90%"> 
        
          <tr>
            <th class="borderLeft borderTop borderRight">NUMERO CONTRATO</th>
            <th class="borderTop borderRight">FECHA INICIO</th>
            <th class="borderTop borderRight">FECHA TERMINACION</th>
            <th class="borderTop borderRight">FECHA TERMINACION REAL</th>            
            <th class="borderTop borderRight">EMPLEADO</th>
            <th class="borderTop borderRight">TIPO CONTRATO</th>
            <th class="borderTop borderRight">CARGO</th>                        
            <th class="borderTop borderRight">MOTIVO TERMINACION</th>
            <th class="borderTop borderRight">SUELDO BASE</th>            		
            <th class="borderTop borderRight">SUBSIDIO TRANSPORTE</th>
            <th class="borderTop borderRight">CENTRO DE COSTO</th>
			<th class="borderTop borderRight">PERIODICIDAD</th>
            <th class="borderTop borderRight">CAUSAL DESPIDO</th>
            <th class="borderTop borderRight">ESTADO</th>
          </tr>  
                 
         {foreach name=detalles from=$DetallesContratos item=r}
          		
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">          
		    <td class="borderLeft borderTop borderRight" align="center">{$r.numero_contrato}</td>             
            <td class="borderTop borderRight" align="center">{$r.fecha_inicio}</td>  
            <td class="borderTop borderRight" align="center">{$r.fecha_terminacion}</td>
            <td class="borderTop borderRight" align="center">{$r.fecha_terminacion_real}</td>              
            <td class="borderTop borderRight" align="center">{$r.empleado_id}</td>  
            <td class="borderTop borderRight" align="center">{$r.tipo_contrato_id}</td>
            <td class="borderTop borderRight" align="center">{$r.cargo_id}</td>                        
            <td class="borderTop borderRight">{$r.motivo_terminacion_id}</td>  
            <td class="borderTop borderRight">{$r.sueldo_base}</td>              
            <td class="borderTop borderRight" align="center">{$r.subsidio_transporte}</td>  
            <td class="borderTop borderRight" align="center">{$r.centro_de_costo_id}</td>   
            <td class="borderTop borderRight" align="center">{$r.periodicidad}</td>   
            <td class="borderTop borderRight" align="center">{$r.causal_despido_id}</td>   
            <td class="borderTop borderRight" align="center">{$r.estado}</td>    
          </tr> 
          {/foreach}
          <tr> <th colspan="7" align="left">&nbsp;</th> </tr>
                        
  </table>
  </body>
</html>
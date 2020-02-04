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
  	<td align="center" class="titulo" width="40%">REPORTES EMPLEADO</td><td width="30%" align="right">&nbsp;</td></tr>	
  	<tr><td colspan="3">&nbsp;</td></tr>
  	<tr><td align="center" colspan="3">Rango Inicial : {$desde}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbspRango Final: {$hasta}</td></tr>	
  </table>
	 
     
       
  		<table align="center" id="encabezado"  width="90%"> 
        
          <tr>
            <th class="borderLeft borderTop borderRight">NUMERO IDENTIFICACION</th>
            <th class="borderLeft borderTop borderRight">NOMBRE EMPLEADO</th>
            <th class="borderLeft borderTop borderRight">DIRECCION</th> 
            <th class="borderLeft borderTop borderRight">TELEFONO</th>
            <th class="borderLeft borderTop borderRight">MOVIL</th>
            <th class="borderLeft borderTop borderRight">CIUDAD</th>           
            
            <th class="borderLeft borderTop borderRight">NOMBRE CARGO</th>                        

          </tr>  
                 
         {foreach name=detalles from=$detallesEmpleado item=r}
          		
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">  
          <td class="borderLeft borderTop borderRight" align="center">{$r.numero_identificacion}</td>  
          <td class="borderLeft borderTop borderRight" align="center">{$r.empleado_id}</td> 
                  
		              
			                        
            <td class="borderLeft borderTop borderRight" align="center">{$r.direccion}</td>                         
            <td class="borderLeft borderTop borderRight" align="center">{$r.telefono}</td>
            <td class="borderLeft borderTop borderRight" align="center">{$r.movil}</td>
            <td class="borderLeft borderTop borderRight" align="center">{$r.ubicacion_id}</td>
           
            <td class="borderLeft borderTop borderRight" align="center">{$r.nombre_cargo}</td>                      

  
          </tr> 
          {/foreach}
          <tr> <th colspan="7" align="left">&nbsp;</th> </tr>
                        
  </table>
  </body>
</html>
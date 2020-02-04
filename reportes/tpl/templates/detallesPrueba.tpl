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
  	<td align="center" class="titulo" width="40%">REPORTES PRUEBA</td><td width="30%" align="right">&nbsp;</td></tr>	
  	<tr><td colspan="3">&nbsp;</td></tr>
  	<tr><td align="center" colspan="3">Rango Inicial : {$desde}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbspRango Final: {$hasta}</td></tr>	
  </table>
	 
     
       
  		<table align="center" id="encabezado"  width="90%"> 
        
          <tr>
            <th class="borderLeft borderTop borderRight">NUMERO PRUEBA</th>
            <th class="borderTop borderRight">NOMBRE PRUEBA</th>
            <th class="borderTop borderRight">NOMBRE POSTULADO</th>
            <th class="borderTop borderRight">FECHA</th> 
            <th class="borderTop borderRight">BASE</th>
            <th class="borderTop borderRight">RESULTADO</th>
            <th class="borderTop borderRight">OBSERVACION</th>
            <th class="borderTop borderRight">CARGO</th>
                                  
    
          </tr>  
                 
         {foreach name=detalles from=$DetallesPrueba item=r}
          		
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">          
		    <td class="borderLeft borderTop borderRight" align="center">{$r.prueba_id}</td>             
            <td class="borderTop borderRight" align="center">{$r.nombre}</td>  
            <td class="borderTop borderRight" align="center">{$r.postulacion_id}</td>
            <td class="borderTop borderRight" align="center">{$r.fecha}</td>
            <td class="borderTop borderRight" align="center">{$r.base}</td>   
            <td class="borderTop borderRight" align="center">{$r.resultado}</td> 
            <td class="borderTop borderRight" align="center">{$r.observacion}</td>  
            <td class="borderTop borderRight" align="center">{$r.nombre_cargo}</td>  
            
                                  
         
          </tr> 
          {/foreach}
          <tr> <th colspan="7" align="left">&nbsp;</th> </tr>
                        
  </table>
  </body>
</html>
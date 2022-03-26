<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
   <link rel="stylesheet" href="../../../framework/css/bootstrap1.css">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body> 

  <div class="container">
  <input type="hidden" id="tipo" value="{$tipo}" />
  
  <table width="90%" align="center" id="encabezado" border="0">
  	<tr><td width="30%">&nbsp;</td>
  	<td align="center" class="titulo" width="40%">REPORTE INCAPACIDADES Y LICENCIAS</td><td width="30%" align="right">&nbsp;</td></tr>	
  	<tr><td colspan="3">&nbsp;</td></tr>
  	<tr><td align="center" colspan="3">Rango Inicial : {$desde}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbspRango Final: {$hasta}</td></tr>	
  </table>
	 
     
       
  		<table class="table table-striped"   width="100%"> 
         <thead class="thead-dark">
          <tr>
            <th scope="col">NUMERO INCAPACIDAD</th>
            <th scope="col">CONCEPTO</th>
            <th scope="col">FECHA REGISTRO</th> 
            <th scope="col">FECHA INICIO</th>
            <th scope="col">FECHA FIN</th>
            <th scope="col">DIAS</th>
            <th scope="col">ESTADO</th>
            <th scope="col">EMPLEADO</th>
            <th scope="col">ENFERMEDAD</th>
            <th scope="col">REMUNERADO</th>                      
          </tr>  
          </thead>
          <tbody>      
         {foreach name=detalles from=$reporteIncapacidadesResult item=r}
          		
          <tr>  
          <td align="center">{$r.licencia_id}</td>  
          <td align="center">{$r.concepto}</td>                 
          <td align="center">{$r.fecha_licencia}</td>                         
          <td align="center">{$r.fecha_inicial}</td>
          <td align="center">{$r.fecha_final}</td>
          <td align="center">{$r.dias}</td>
          <td align="center">{$r.estado}</td>
          <td align="center">{$r.contrato}</td>
          <td align="center">{$r.enfermedad}</td>
          <td align="center">{$r.remunerado}</td>                      
          </tr> 
          {/foreach}

          </tbody>              
  </table>
  <div class="container">
  </body>
</html>
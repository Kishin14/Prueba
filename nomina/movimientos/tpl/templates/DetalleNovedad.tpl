<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

<body>
    <div align="center">
    <input type="hidden" id="novedad_fija_id" value="{$NOVEDADID}" />
    <table id="tableDetalle" align="center">
        <thead>
            <tr>
                <th>NO. CUOTA</th>          
                <th>FECHA CUOTA</th>               	 
                <th>VALOR CUOTA</th>               	 
                <th>SALDO</th>               	           
            </tr>
        </thead>
    	<tbody>
    	{foreach name=detalle_solicitud from=$DETALLES item=d}
            <tr>
                <td><input type="text" name="no_cuota" id="no_cuota" value="{$d.num_cuota}" readonly/></td>
                <td><input type="text" name="fecha_cuota" id="fecha_cuota" align="center" value="{$d.fecha_cuota}" readonly/></td>
                <td><input type="text" name="vr_cuota" id="vr_cuota" align="right" value="{$d.valor_cuota|number_format:0:',':'.'}" readonly/></td>
                <td><input type="text" name="saldo" id="saldo" align="right" value="{$d.saldo|number_format:0:',':'.'}" readonly/></td>               
        	</tr>   
        {/foreach}
        </tbody>
    </table>
    </div>
</body>
</html>
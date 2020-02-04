<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		{$JAVASCRIPT}
		{$CSSSYSTEM}
		{$TABLEGRIDCSS}
		{$TITLETAB}
	</head>
	<body {if $PRINTERS eq 'si'} onLoad="javascript:window.print()" {/if}>
		<div align="center">
        	
			<table width="100%" style="font-size:13px;" class="table table-hover">
				<thead>
					<tr class="thead-light" style="text-align: center;">
						<th colspan="12"><strong>CONTRATOS PROXIMOS A VENCER</strong></td>
					</tr>
					<tr style="font-weight:bold;" class="thead-light"  style="text-align: center;">
						<th>CODIGO</th>
						<th>PREFIJO</th>
						<th>CONTRATO NO.</th>
						<th>FECHA INICIO</th>
						<th>FECHA TERMINACION</th>
						<th>EMPLEADO</th>
						<th>SUELDO BASE</th>
						<th>SUBSIDIO TRANSPORTE</th>
						<th>ESTADO</th> 
						<th colspan="3">&nbsp;</th>    
					</tr>
				</thead>
				<tbody>
	                {if count($DATA)>0}
                
						{foreach name=reporte from=$DATA item=k}

                            <tr>
                                <td style="vertical-align: middle;">&nbsp;{$k.contrato_id}</td>
                                <td style="vertical-align: middle;">{$k.prefijo}</td>
                                <td style="vertical-align: middle;">&nbsp;{$k.numero_contrato}</td>
                                <td style="vertical-align: middle;">&nbsp;{$k.fecha_inicio}</td>
                                <td style="vertical-align: middle;">&nbsp;{$k.fecha_terminacion}</td>
                                <td style="vertical-align: middle;">&nbsp;{$k.empleado_id}</td>
                                <td style="vertical-align: middle;">&nbsp;${$k.sueldo_base|number_format:0:',':'.'}</td>
                                <td style="vertical-align: middle;">&nbsp;${$k.subsidio_transporte|number_format:0:',':'.'}</td>
                                <td style="vertical-align: middle;">&nbsp;{$k.estado}</td>
                                <td style="vertical-align: middle;"><input type="button" name="renovarcontrato" style="padding:0.175rem 0.75rem;" class="btn btn-primary" onClick="renovar({$k.contrato_id});" value="Renovar Contrato"></input></td>
                                <td style="vertical-align: middle;"><input type="button" name="finalizarcontrato" style="padding:0.175rem 0.75rem;" class="btn btn-primary" onClick="finalizar({$k.contrato_id});" value="Finalizar Contrato"></input></td>
                                <td style="vertical-align: middle;"><input type="button" name="actualizarcontrato" style="padding:0.175rem 0.75rem;" class="btn btn-primary" onClick="actualizar({$k.contrato_id});" value="Actualizar Contrato"></input></td>

                            </tr>
                        {/foreach}
                    {else}
                    	<tr><td colspan="11">No existen Contratos Pendientes por Renovar entre las Fechas Seleccionadas O No existe esa solicitud.</td></tr>   
                    {/if}
				</tbody>
				
			</table>
		</div>
	</body>
</html>
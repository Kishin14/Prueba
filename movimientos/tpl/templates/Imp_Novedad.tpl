<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />   
    <link type="text/css" rel="stylesheet" href="../../../framework/css/printer.css" /> 
    <script language="javascript" type="text/javascript" src="../../../framework/js/printer.js"></script>
    <title>Impresi&oacute;n Novedad</title>
    {literal}&nbsp;
    <style>
    /* CSS Document */
    .table_condi{
		border:#000 2px solid;
		font-size:9px;
		width:600px;
		font-family:Arial, Helvetica, sans-serif;
    }
    .table_condi td{
		padding:2px 1px 2px 1px;
    }
    .bottom_condi{
		border-bottom:#000 2px solid;
    }
    .celda_bordes{
		border:#000 1px solid;
    }
    .table_detalles{
		border:#000 2px solid;
		font-size:12px;
		width:600px;
		font-family:Arial, Helvetica, sans-serif;
    }
    .celda_nombre{
		height:30px;
		width:270px;
		text-align:center;
    }
    .celda_control{
		height:80px;
		width:290px;
    }
    .celda_firmas{
		height:70px;
		width:170px;
    }
    #contenedor{
		width:1200px;
		height:572px;
		/*background:#000000;*/
    }
    .saltopagina {
		page-break-after: always;
    }	
    table tr td{
		font-size:8px;
    }
    .borderRight{
		border-right:1px solid;
    }
    .borderLeft{
		border-left:1px solid;
    }
    .borderBottom{
		border-bottom:1px solid;
    }
    .borderTop{
		border-top:1px solid;
    }
    .title{
		/*background-color:#999999;*/
		font-weight:bold;
		text-align:center;
		border:1px solid;
    }
    .fontBig{
		font-size:10px;
    }
    .fontBig1{
		font-size:10.3px;
    }
    .fontBig2{
		font-size:11px;
    }
    .infogeneral{
		border-left:1px solid;   
		border-right:1px solid;   	 
		border-bottom:1px solid;   	 	 
		text-align:center;
    }
    .cellTitle{
		/*background-color:#999999;*/
		font-weight:bold;
		text-align:center;
		border-top:1px solid;   	 
		border-left:1px solid;   
		border-right:1px solid;   	 
		border-bottom:1px solid;   	 	 
    }
    .cellRight{
		border-right:1px solid;
		border-bottom:1px solid;
    }
    .cellLeft{
		border-left:1px solid;
		border-right:1px solid;
		border-bottom:1px solid;	 
    }
    
    .cellTitleLeft{
		border-left:1px solid;
		border-right:1px solid;
		border-bottom:1px solid; 
		border-top:1px solid;
		/*background-color:#999999;*/
		font-weight:bold;
		text-align:center;	   
    } 
    
    .cellTotal{
		border-left:1px solid;
		border-right:1px solid;
		border-bottom:1px solid; 
		border-top:1px solid;
    }
    .cellTitleRight{
		border-right:1px solid;
		border-bottom:1px solid;   
		/*border-top:1px solid;	 */
		/*background-color:#999999;*/
		/*font-weight:bold;*/
		text-align:left;	 
    }
    body{
		padding:0px 0px 0px 0px;
    }
    .content{
		font-weight:bold;
		font-size:8px;
		text-align:center;
		text-transform:uppercase;
    }
    .cellTitleProd{
		font-size:6px;
		font-weight:bold;
		vertical-align:middle;
    }
    .anulado{
		color:#003366;
		font-size:70px;
    }
    </style>
    {/literal}  
    {$JAVASCRIPT}
    {$CSSSYSTEM}  
</head>
  
<body>
    <input type="hidden" id="novedad_fija_id" value="{$NOVEDADID}" />
    <table width="100%">	
        <tr>
        	<td>
				<table width="100%">                
					<tr>
                    	<td align="left" width="35%"><img src="{$DATOS.logo}?123" width="280" height="100" /></td>
                        <td align="center"><font size="4">{$DATOS.nombre_empresa}<br>{$DATOS.nit_empresa}<br>{$DATOS.direccion_empresa}<br>
                        {$DATOS.telefono_empresa}
                        </font></td>
					</tr>
                </table>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td align="center"><font size="2"><b>INFORMACI&Oacute;N BASE</b></font></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <table align="center" width="90%" class="cellTotal" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="45%" class="cellTotal" style="padding:5px;"><font size="2"><b>Novedad No :</b> {$DATOS.novedad_fija_id}</font></td>
                        <td width="45%" class="cellTotal" style="padding:5px;"><font size="2"><b>Fecha Novedad :</b> {$DATOS.fecha_novedad}</font></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="cellTotal" style="padding:5px;"><font size="2"><b>Empleado :</b> &nbsp;{$DATOS.contrato}</font></td>
                    </tr>
                    <tr>
                        <td class="cellTotal" style="padding:5px;"><font size="2"><b>N&uacute;mero Contrato :</b> {$DATOS.cont}</font></td>
                        <td class="cellTotal" style="padding:5px;"><font size="2"><b>Identificaci&oacute;n Empleado :</b> {$DATOS.contra}</font></td>
                    </tr>
                    <tr>
                        <td class="cellTotal" style="padding:5px;"><font size="2"><b>Tipo Novedad :</b> {$DATOS.tipo_novedad}</font></td>
                        <td class="cellTotal" style="padding:5px;"><font size="2"><b>Naturaleza :</b> {$DATOS.naturaleza}</font></td>
                    </tr>
                    <tr>
                        <td class="cellTotal" style="padding:5px;"><font size="2"><b>Concepto :</b> {$DATOS.concepto}</font></td>
                        <td class="cellTotal" style="padding:5px;"><font size="2"><b>Beneficiario :</b> {$DATOS.tercero}</font></td>
                    </tr>
                    <tr>
                        <td class="cellTotal" style="padding:5px;"><font size="2"><b>Fecha Inicial :</b> {$DATOS.fecha_inicial}</font></td>
                        <td class="cellTotal" style="padding:5px;"><font size="2"><b>Fecha Final :</b> {$DATOS.fecha_final}</font></td>
                    </tr>
                    <tr>
                        <td class="cellTotal" style="padding:5px;"><font size="2"><b>Periodicidad :</b> {$DATOS.periodicidad}</font></td>
                        <td class="cellTotal" style="padding:5px;"><font size="2"><b>Estado :</b> {$DATOS.estado}</font></td>
                    </tr>
                </table>
			</td>
		</tr>
        <tr>
        	<td>&nbsp;</td>
        </tr>
		<tr>
        	<td>&nbsp;</td>
        </tr>
        <tr>
			<td width="90%" align="center"><font size="2"><b>INFORMACI&Oacute;N DETALLADA</b></font></td>
		</tr>
        <tr>
        	<td>&nbsp;</td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
        </tr>                
        <tr>
         	<td>
            	<table align="center" width="90%" class="cellTotal" cellpadding="0" cellspacing="0"> 
                    <tr>
                        <td width="22%" align="center" class="cellTotal" style="padding:5px;"><font size="2">NO. CUOTA</font></td>          
                        <td width="22%" align="center" class="cellTotal" style="padding:5px;"><font size="2">FECHA CUOTA</font></td>               	 
                        <td width="22%" align="center" class="cellTotal" style="padding:5px;"><font size="2">VALOR CUOTA</font></td>               	 
                        <td width="22%" align="center" class="cellTotal" style="padding:5px;"><font size="2">SALDO</font></td>               	           
                    </tr>
                    {foreach name=detalle_solicitud from=$DETALLES item=d}
                    <tr>
                        <td class="cellTotal" style="padding:5px;"><font size="2">{$d.num_cuota}</font></td>
                        <td class="cellTotal" style="padding:5px;" align="center"><font size="2">{$d.fecha_cuota}</font></td>
                        <td class="cellTotal" style="padding:5px;" align="right"><font size="2">{$d.valor_cuota|number_format:0:',':'.'}</font></td>
                        <td class="cellTotal" style="padding:5px;" align="right"><font size="2">{$d.saldo|number_format:0:',':'.'}</font></td>               
                    </tr>  
					{/foreach}
				</table>
			</td>
    	</tr>
        <tr>
        	<td>&nbsp;</td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
        </tr>        
    </table>
</body>
</html>
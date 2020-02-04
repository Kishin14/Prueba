<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />   
    <link type="text/css" rel="stylesheet" href="/application/framework/css/printer.css" /> 
    <script language="javascript" type="text/javascript" src="/application/framework/js/printer.js"></script>
    <title>Hoja de Horas Extras</title>
</head>
<body>
    <table width="90%" align="center" cellspacing="0">
        <tr>
            <td align="center" style="border-top:1px solid; border-left:1px solid; border-bottom:1px solid;  border-right:1px solid">
                <table width="100%" border="0" cellspacing="0">
                    <tr>
                        <td align="center" width="35%"><img src="{$LOGO}" width="160" height="42" /></td>
                        <td align="center"><strong>{$NOMBRE_EMP}</strong><br>{$NUMEROID}<br>{$DIRECCION}<br>{$CIUDAD}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
        	<td style="border-left:1px solid; border-right:1px solid">&nbsp;</td>
		</tr>
        <tr>
        	<td style="border-left:1px solid; border-right:1px solid" align="center"><strong>LIQUIDACI&Oacute;N HORAS EXTRAS NO. {$EXTRAID}</strong></td>
		</tr>
        <tr>
            <td style="border-left:1px solid; border-right:1px solid">&nbsp;</td>
        </tr>
        <tr>
        	<td style="border-left:1px solid; border-right:1px solid">
            	<table align="center" width="90%" cellspacing="0">
                <tr>
		            <td width="15%" style="border-left:1px solid; border-right:1px solid; border-top:1px solid; border-bottom:1px solid"><strong>Empleado :</strong></td>
                    <td width="75%" style="border-right:1px solid; border-top:1px solid; border-bottom:1px solid">&nbsp;{$EMPLEADO}</td>
        		</tr>
                <tr>
                    <td style="border-left:1px solid; border-right:1px solid"><strong>Identificaci&oacute;n :</strong></td>
                    <td style="border-right:1px solid">&nbsp;{$IDENTIFICACION}</td>
                </tr>
                <tr>
                    <td style="border-left:1px solid; border-right:1px solid; border-bottom:1px solid; border-top:1px solid"><strong>Fecha Inicial :</strong></td>
                    <td style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid">&nbsp;{$FECHA_INI}</td>
                </tr>
                <tr>
                    <td style="border-left:1px solid; border-right:1px solid; border-bottom:1px solid"><strong>Fecha Final :</strong></td>
                    <td style="border-bottom:1px solid; border-right:1px solid">&nbsp;{$FECHA_FIN}</td>
                </tr>
                </table>
			</td>
		</tr>            
        <tr>
            <td style="border-left:1px solid; border-right:1px solid">&nbsp;</td>
        </tr>
        <tr>
            <td style="border-left:1px solid; border-right:1px solid">
                <table align="center" width="90%" style="border-top:1px solid; border-left:1px solid; border-bottom:1px solid;  border-right:1px solid"  cellspacing="0">
                	<tr>
                    	<td style="border-bottom:1px solid">&nbsp;</td>
                        <td style="border-left:1px solid; border-right:1px solid; border-bottom:1px solid" align="center"><strong>NO. HORAS</strong></td>
                        <td align="center" style="border-bottom:1px solid"><strong>VALOR HORAS</strong></td>
                    </tr>
                    <tr>
                        <td><strong>HORA EXTRAS DIURNAS</strong></td>
                        <td style="border-left:1px solid; border-right:1px solid" align="center">{$EXTRASD}</td>
                        <td align="right">{$VREXTRASD|number_format:0:",":"."}</td>
                    </tr>
                    <tr>
                        <td style="border-top:1px solid; border-bottom:1px solid"><strong>HORA EXTRAS NOCTURNAS</strong></td>
                        <td style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid; border-right:1px solid" align="center">{$EXTRASN}</td>
                        <td style="border-top:1px solid; border-bottom:1px solid" align="right">{$VREXTRASN|number_format:0:",":"."}</td>
                    </tr>
                    <tr>
                        <td><strong>HORA EXTRAS DIURNAS FESTIVAS</strong></td>
                        <td style="border-left:1px solid; border-right:1px solid" align="center">{$EXTRASDF}</td>
                        <td align="right">{$VREXTRASDF|number_format:0:",":"."}</td>                        
                    </tr>
                    <tr>
                        <td style="border-top:1px solid; border-bottom:1px solid"><strong>HORA EXTRAS NOCTURNAS FESTIVAS</strong></td>
                        <td style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid; border-right:1px solid" align="center">{$EXTRASNF}</td>
                        <td style="border-top:1px solid; border-bottom:1px solid" align="right">{$VREXTRASNF|number_format:0:",":"."}</td>                        
                    </tr>
                    <tr>
                        <td style="border-bottom:1px solid"><strong>HORA RECARGO NOCTURNO</strong></td>
                        <td style="border-bottom:1px solid; border-left:1px solid; border-right:1px solid" align="center">{$HORARECARGO}</td>
                        <td style="border-bottom:1px solid" align="right">{$VRHORARECARGO|number_format:0:",":"."}</td>                        
                    </tr>
                    <tr>
                        <td><strong>HORA DOMINICAL FESTIVO</strong></td>
                        <td style="border-left:1px solid; border-right:1px solid" align="center">{$HORADOCFEST}</td>
                        <td style="border-bottom:1px solid" align="right">{$VRHORADOCFEST|number_format:0:",":"."}</td>                        
                    </tr>
                    <tr>
                    
                        <td style="border-top:1px solid; border-right:1px solid" align="right" colspan="2"><strong>TOTAL :</strong></td>
                        <td align="right"><strong>{$TOTAL.total|number_format:0:",":"."}</strong></td>                        
                    </tr>
                </table>
			</td>
		</tr>
        <tr>
            <td style="border-left:1px solid; border-right:1px solid" align="center">&nbsp;</td>
        </tr>
		<tr>
            <td style="border-left:1px solid; border-right:1px solid" align="center">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2" style="border-bottom:1px solid; border-left:1px solid; border-right:1px solid; padding:5px">
                <table width="90%" border="0" align="center">
                    <tr>
                        <td width="50%">
							<table width="200" border="0" align="center">
                                <tr>
                                    <td><br />_______________________________________________</td>
                                </tr>
                                <tr>
                                    <td align="center">ELABOR&Oacute;</td>
                                </tr>
                            </table>
                        </td>
                        <td width="50%">
                            <table width="200" border="0" align="center">
                                <tr>
                                    <td><br />____________________________________________</td>
                                </tr>
                                <tr>
                                    <td align="center">RECIBE</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
				</table>
			</td>
		</tr>                            
        <tr>
            <td align="center">&nbsp;</td>
        </tr>
    </table>
</body>
</html>
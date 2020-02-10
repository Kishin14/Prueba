<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8"> 
   <link rel="stylesheet" href="../../../framework/css/bootstrap1.css">
  {$JAVASCRIPT}
  {$TABLEGRIDJS}
  {$CSSSYSTEM} 
  {$TABLEGRIDCSS}
  {$TITLETAB}
</head>

<body>
    <fieldset>
        <legend>{$TITLEFORM}</legend>
        {$FORM1}
         <fieldset class="section">
        <table align="center" width="95%"> 
            <tr>
                <td width="25%" align="center"><label>PERIODO</label></td>
                <td width="30%" align="center"><label>EMPLEADO</label></td>
                <td width="30%" align="center"><label>ENFERMEDAD</label></td>
                <td width="25%" align="center"><label>TIPO</label></td>
                <td width="25%" align="center"><label>INDICADORES</label></td>
                
            </tr>
            <tr>
                <td valign="top">
                	<label>Desde:&nbsp;</label> {$DESDE}<br><br>
					<label>Hasta:&nbsp;&nbsp;</label> {$HASTA}
                </td>
                <td valign="top">{$SI_EMPLEADO}<br />{$EMPLEADO}{$EMPLEADOID}</td>
                <td valign="top">{$ENFERMEDAD}{$ENFERMEDADID}</td>
                <td valign="top">{$TIPO}</td>
                <td valign="top"><label>{$INDICADORES}</label></td>
            </tr>


			<tr>
            	<td>&nbsp;</td>
            </tr>

        </table>
        <table align="center">
        <tr>
                <td align="center">
                    <table align="center" width="100%">
                        <tr>
                            <td id="loading"></td>
                            <td width="100%" align="center">{$GRAFICOS}{$GENERAR}&nbsp;{$IMPRIMIR}&nbsp;{$LIMPIAR}&nbsp; <input type="button" name="generar_excel" id="generar_excel" class="btn btn-primary" value="Generar Archivo Excel>>" /></td>
                            <td width="100%"></td>
                        </tr>
                    </table>
                </td>
        </tr>
        </table>
        </fieldset>

		<table width="100%">
			<tr>
            <td><iframe id="frameReporte" frameborder="0" marginheight="0" marginwidth="0"></iframe></td>
            </tr>
		</table>        
		{$FORM1END}
	</fieldset>
    
</body>
</html>

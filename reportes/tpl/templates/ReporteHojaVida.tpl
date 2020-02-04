<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8"> 
   <link rel="stylesheet" href="/application/framework/css/bootstrap1.css">
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
        <table align="center" width="90%">
            <tr>
                <td width="20%" ></td>
                <td width="25%" align="right"><label>TIPO REPORTE</label></td>
                <td width="25%" align="left"><span id="titulo_contrato">CONTRATO</span><span id="titulo_arrendatario">TERCERO</span></td>
                <td width="20%" >INDICADORES</td>
            </tr>
            <tr>
                <td width="20%"></td>
                <td width="25%" valign="top" align="right">
                	<label>{$SI_TIP}</label>
                </td>
                <td width="25%" align="left"><span id="campos_contrato">{$CONTRATO}{$CONTRATOID}</span><span id="campos_arrendatario">{$ARRENDATARIO}{$ARRENDATARIOID}</span></td>
                <td width="20%" valign="top" align="right">
                	<label>{$INDICADORES}</label>
                </td>
   			<tr>
            	<td colspan="5">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="5" align="center">
                    <table width="100%">
                        <tr>
                            <td id="loading" width="20%"></td>
                            <td width="60%" align="center">{$GRAFICOS}{$GENERAR}&nbsp;&nbsp;{$GENERAREXCEL}&nbsp;&nbsp;<!--{$IMPRIMIR}--></td>
                            <td width="20%"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        </fieldset>
		<table width="100%">
			<tr><td colspan="7"><iframe id="frameReporte" frameborder="0" marginheight="0" marginwidth="0" style="height: 400px;"></iframe></td></tr>
		</table>        
		{$FORM1END}
	</fieldset>
    
</body>
</html>

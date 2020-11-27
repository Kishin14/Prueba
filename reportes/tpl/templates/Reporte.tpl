<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8"> 
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
                <td width="25%" align="center"><label>PERIODO</label></td>
                <td width="35%" align="center"><label>USUARIO</label></td>
                <td width="35%" align="center"><label>TABLA</label></td>
                <td width="20%" align="center"><label>TIPO DE REPORTE</label></td>
            </tr>
            <tr>
                <td valign="top">
                	<label>Desde:&nbsp;</label> {$DESDE}<br>
					<label>Hasta:&nbsp;&nbsp;</label> {$HASTA}<br><br>
                    <label>PALABRA CLAVE</label><br>
                    {$PALABRA} <img src="../../../framework/media/images/alerts/info.gif" title="Puede Ingresar una referencia como  placa, cliente, conductor, tenedor" width="22" height="22" />
                </td>
                <td valign="top">{$SI_USUARIO}<br />{$USUARIO}{$USUARIOID}</td>
                <td valign="top">{$ALLTABLAS}<br />{$TABLASID}</td>
                <td valign="top">{$TIPO}</td>
            </tr>

			<tr>
            	<td colspan="4">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="4" align="center">
                    <table width="100%">
                        <tr>
                            <td id="loading" width="15%">&nbsp;</td>
                            <td width="60%" align="center">{$GENERAR}&nbsp;{$GENERAREXCEL}&nbsp;{$IMPRIMIR}&nbsp;{$LIMPIAR}</td>
                            <td width="15%" align="right" ></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        </fieldset>
		<table width="100%">
			<tr><td colspan="7"><iframe id="frameReporte" frameborder="0" marginheight="0" marginwidth="0"></iframe></td></tr>
		</table>        
		{$FORM1END}
	</fieldset>
    
</body>
</html>

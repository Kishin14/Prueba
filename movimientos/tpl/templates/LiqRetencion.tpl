<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="../../../framework/css/bootstrap1.css">
    <!--<link rel="stylesheet" href="../../../framework/css/bootstrap.css">-->
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
        <table width="100%">
            <tr>
                <td width="10%">&nbsp;</td>
                <td valign="top" width="30%" colspan="2"><label>Contrato : &nbsp;&nbsp;</label><br>{$SI_CONTRATO}</td>   
                <td valign="top" colspan="3" width="20%"><label>Desde:&nbsp;&nbsp;</label><br>{$DESDE}</td>
                <td valign="top" colspan="4" width="40%"><label>Hasta:&nbsp;&nbsp;</label><br>{$HASTA}</td>       
            </tr>
            <tr>
                <td width="10%">&nbsp;</td>
                <td valign="top" width="30%" colspan="2">{$CONTRATO}{$CONTRATOID}</td> 
            </tr>
        </table>
    </fieldset>
	{$SOLICITUDID}
    <fieldset class="section">
        <div align="center">{$GENERAR}&nbsp;{$GENERAREXCEL}&nbsp;{$IMPRIMIR}&nbsp;{$LIMPIAR}</div>
        <div>&nbsp;</div>
        <iframe src="" id="frameRetencion" name="frameRetencion" height="700px"></iframe>
    </fieldset>
    </fieldset>
    {$FORM1END}
     <div id="Renovarmarco" style="display:none">
      <div align="center">
	    <p align="center">
        <form onSubmit="return false">
	      <fieldset class="section">
		  <table id="tableGuia" width="100%">
          	<th colspan="5">Información Contrato</th>
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td><label>Contrato No :</label></td>
                <td>{$CLIENTERENUEVA}{$CONSECUTIVORENUEVA}{$CANONVIEJO}</td>
                <td colspan="2"><label>Fecha Contrato :</label></td>
                <td>{$FECHAINICIO2}</td>
            </tr>
            <tr>
                <td><label>Empleado :</label></td>
                <td colspan="4">{$NUMESES}</td>
            </tr>
            <tr>
            	<td><label>Sueldo Base :</label></td>
                <td>${$CANONRENUEVA}</td>
                <td colspan="2"><label>Subsidio Transporte :</label></td>
                <td>${$ADMINISTRACION}</td>
            </tr>
            <tr>
                <td><label>Fecha Terminacion :</label></td>
                <td colspan="4">{$FECHAFINAL2}</td>
            </tr>
            <tr>
                <td><label>Estado :</label></td>
                <td colspan="4">{$PROPIETARIORENUEVA}</td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <th colspan="5">Información Renovar</th>
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td><label>Fecha Inicio :</label></td>
                <td colspan="2">{$FECHAINIRENOVACION}</td>
                <td><label>Fecha Final :</label></td>
                <td>{$FECHAFINRENOVACION}</td>              
            </tr>    
            <tr>
                <td><label>Observación Renueva :</label></td>
                <td colspan="2">{$OBSERVACIONRENUEVA}</td>
            </tr>       
			 <tr> <td>&nbsp;</td> </tr>
			 <tr> <td colspan="5" align="center">{$RENOVAR}</td>
            </tr>
		  </table>
          </fieldset>
          </form>
		</p>
	  </div>
	</div><!--Fin del div renovar marco-->
    
</body>
</html>
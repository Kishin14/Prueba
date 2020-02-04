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
    <legend> {$TITLEFORM}</legend>
        <div id="table_find">
            <table>
                <tr>
                    <td><label>Busqueda : </label></td>
                    <td>{$BUSQUEDA}</td>
                </tr>
	        </table>
        </div>
    </fieldset>
    {$FORM1}
    {$CONVOCADO_ID}
    <fieldset class="section">
        <table align="center" width="70%">
            <tr>
                <td width="20%"><label>Tipo de Identificaci&oacute;n : </label></td>
                <td width="7">{$TIPO_IDENTIFICACION}</td>
                <td width="20%"><label>Número de Identificaci&oacute;n : </label></td>
                <td width="7">{$NUMERO_IDENTIFICACION}</td>
            </tr>
            <tr>
                <td width="20%"><label>Primer Nombre : </label></td>
                <td width="7">{$PRIMER_NOMBRE}</td>
                <td width="20%"><label>Segundo Nombre : </label></td>
                <td width="7">{$SEGUNDO_NOMBRE}</td>
            </tr>
            <tr>
                <td width="20%"><label>Primer Apellido : </label></td>
                <td width="7">{$PRIMER_APELLIDO}</td>
                <td width="20%"><label>Segundo Apellido : </label></td>
                <td w>{$SEGUNDO_APELLIDO}</td>
            </tr>
            <tr>
                <td width="20%"><label>Direcci&oacute;n : </label></td>
                <td width="7">{$DIRECCION}</td>
                <td width="20%"><label>Tel&eacute;fono : </label></td>
                <td width="7">{$TELEFONO}</td>
            </tr>
            <tr>
                <td width="20%"><label>Movil : </label></td>
                <td width="7">{$MOVIL}</td>
                <td width="20%"><label>Ubicaci&oacute;n : </label></td>
                <td width="7">{$UBICACION}{$UBICACION_ID}</td>
            </tr>
            <tr>
                <td><label>Estado : </label></td>
                <td>{$ESTADO}</td>
            </tr>
            <tr>
                <td colspan="4">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
            </tr>
        </table>
    {$FORM1END}
    </fieldset>
    <fieldset>{$GRIDPARAMETROS}</fieldset>
</body>
</html>

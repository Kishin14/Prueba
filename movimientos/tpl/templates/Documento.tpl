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
    <fieldset class="section">
        <table align="center" width="50%">
            <tr>
                <td width="50%"><label>Documento Laboral : </label></td>
                <td width="50%">{$DOCUMENTO_LABORAL}</td>
            </tr>
            <tr>
            <tr>
                <td width="50%"><label>Fecha : </label></td>
                <td width="50%">{$FECHA}</td>
            </tr>
            <tr>
                <td width="50%"><label>Nombre Documento : </label></td>
                <td width="50%">{$TIPODOCUMENTO}</td>
            </tr>
            <tr>
                <td width="50%"><label>Contrato : </label></td>
                <td width="50%">{$CONTRATO}{$CONTRATO_ID}</td>
            </tr>          
            <tr>
                <td colspan="2" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$IMPRIMIR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
            </tr>
        </table>
    {$FORM1END}
    </fieldset>
    <fieldset>{$GRIDPARAMETROS}</fieldset>
</body>
</html>

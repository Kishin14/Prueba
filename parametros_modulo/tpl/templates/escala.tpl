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
    {$ESCALAID}
    <fieldset class="section">
        <table align="center">
            <tr>
                <td><label>Periodo Contable  : </label></td>
                <td colspan="3">{$PERIODO}{$UVTNOMINAL}</td>
            </tr>
            <tr>
                <td><label>Mínimo UVT  : </label></td>
                <td>{$MINIMO}</td>
                <td><label>Mínimo en Pesos : </label></td>
                <td>{$PESOSMIN}</td>
            </tr>
            <tr>
                <td><label>M&aacute;ximo  UVT : </label></td>
                <td>{$MAXIMO}</td>
                <td><label>M&aacute;ximo en Pesos  : </label></td>
                <td>{$PESOSMAX}</td>
            </tr>
            <tr>
                <td align="center">&nbsp;</td>
                <td align="center" colspan="3">&nbsp;</td>
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

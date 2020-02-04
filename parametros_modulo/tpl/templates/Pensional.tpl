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
    {$PENSIONALID}
    <fieldset class="section">
        <table align="center">
            <tr>
                <td><label>Porcentaje : </label></td>
                <td>{$PORCENTAJE}</td>
            </tr>
            <tr>
                <td><label>Rango Inicio : </label></td>
                <td>{$RANGOINI}</td>
            </tr>
            <tr>
                <td><label>Rango Fin : </label></td>
                <td>{$RANGOFIN}</td>
            </tr>
            <tr>
                <td><label>Período Contable : </label></td>
                <td>{$PERIODOID}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
          </tr>
            <tr>
                <td colspan="2" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
            </tr>
        </table>
    {$FORM1END}
    </fieldset>
    <fieldset>{$GRIDPARAMETROS}</fieldset>
</body>
</html>

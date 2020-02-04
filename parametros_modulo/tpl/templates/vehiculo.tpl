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
    {$TIPOVEHICULOID}
    <fieldset class="section">
        <table align="center">
            <tr>
                <td><label>Nombre  : </label></td>
                <td>{$NOMBRE}</td>
            </tr>
            <tr>
                <td><label>Codigo  : </label></td>
                <td>{$CODIGO}</td>
            </tr>
            <tr>
                <td><label>Servicio : </label></td>
                <td>{$SERVICIO}</td>
            </tr>
            <tr>
                <td><label>Tipo : </label></td>
                <td>{$TIPO}</td>
            </tr>
            <tr>
                <td align="center">&nbsp;</td>
                <td align="center">&nbsp;</td>
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

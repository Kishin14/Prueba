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
    {$NIVEL_ID}
    <fieldset class="section">
        <table align="center">
            <tr>
                <td><label>Nombre : </label></td>
                <td>{$NOMBRE}</td>
            </tr>
            <tr>
                <td><label>Descripci&oacute;n : </label></td>
                <td>{$DESCRIPCION}</td>
            </tr>
            <tr>
                <td><label>Estado : </label></td>
                <td>{$ESTADO}</td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
            </tr>
        </table>
    {$FORM1END}
    </fieldset>
    <fieldset>{$GRIDESTUDIOS}</fieldset>
</body>
</html>

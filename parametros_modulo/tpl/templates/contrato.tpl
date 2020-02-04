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
    {$TIPOCONTRATOID}
    <fieldset class="section">
        <table align="center">
            <tr>
                <td><label>Prefijo  : </label></td>
                <td>{$PREFIJO}</td>
                <td><label>Nombre  : </label></td>
                <td>{$NOMBRE}</td>
                
            </tr>
            <tr>
                <td><label>Descripci&oacute;n  : </label></td>
                <td>{$DESCRIPCION}</td>
                <td><label>Periodo de Prueba (Dias): </label></td>
                <td>{$PERIODO_PRUEBA}</td>
                
            </tr>
            <tr>
                <td><label>Tiempo Contrato (meses) : </label></td>
                <td>{$TIEMPOCONTRATO}</td>
                
                
            </tr>
            <tr>
                <td><label>Tipo : </label></td>
                <td>{$TIPO}</td>
                <td><label>Indemnizaci&oacute;n  : </label></td>
                <td>{$INDEMNIZACION}</td>
            </tr>
            <tr>
                <td><label>Liquidaci&oacute;n: </label></td>
                <td>{$LIQUIDACION}</td>
                <td><label>Prestaciones Sociales : </label></td>
                <td>{$PRESTACIONES}</td>
            </tr>
            <tr>
                <td><label>Salud: </label></td>
                <td>{$SALUD}</td>
                <td><label>ARL : </label></td>
                <td>{$ARL}</td>
            </tr>
            <tr>
                <td colspan="4" align="center">&nbsp;</td>
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

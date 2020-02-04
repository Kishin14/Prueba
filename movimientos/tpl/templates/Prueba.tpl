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
    <legend> {$TITLEFORM} </legend>
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
    {$PRUEBA}
    <fieldset class="section"> 
        <table align="center">
            <tr>
                <td><label>Nombre Prueba : </label></td>
                <td>{$NOMBRE}</td>
                <td><label>Observaci&oacute;n : </label></td>
                <td>{$OBSERVACIONES}</td>
            </tr>
            <tr>
                <td><label>Resultado : </label></td>
                <td>{$RESULTADO}</td>
                <td><label>Base : </label></td>
                <td>{$BASE}</td>
            </tr>
            <tr>
                <td><label>Nombre Convocado : </label></td>
                <td>{$CONVOCADO}{$CONVOCADOID}</td>
                <td><label>Fecha : </label></td>
                <td>{$FECHA}</td>
            </tr>
            <tr>
                <td><label>Aprobado: </label></td>
                <td>{$APROBADO}</td>
                <td><label>Prueba Convocatoria: </label></td>
                <td>{$EVIPRUEBA}</td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
            </tr>
        </table>
    
    </fieldset>
    <fieldset>{$GRIDPARAMETROS}</fieldset>
    {$FORM1END}

</body>
</html>

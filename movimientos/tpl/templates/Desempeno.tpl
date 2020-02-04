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
    {$CAUSALDES}
    <fieldset class="section"> 
        <table align="center">
            <tr>
                <td><label>Empleado : </label></td>
                <td>{$EMPLEADO}{$EMPLEADOID}</td>
            </tr> 
            <tr>
                <td><label>Causal Desempe&ntilde;o : </label></td>
                <td>{$CAUSDESID}</td>
            </tr>
            <tr>
                <td><label>Fecha : </label></td>
                <td>{$FECHA}</td>
            </tr>
            <tr>
                <td><label>Resultado : </label></td>
                <td>{$RESUL}</td>
            </tr>
            <tr>
                <td><label>Evidencia Prueba : </label></td>
                <td>{$EVIPRUEBA}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
            </tr>
        </table>
    
    </fieldset>
    <fieldset>{$GRIDPARAMETROS}</fieldset>
    {$FORM1END}

</body>
</html>

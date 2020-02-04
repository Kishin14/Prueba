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
    {$RETENCIONID}
    <fieldset class="section">
        <table align="center">
            <tr>
                <td><label>Periodo Contable : </label></td>
                <td><label>Porcentaje : </label></td>
                <td><label>Concepto : </label></td>
                
            </tr>
            <tr>
                <td>{$PERIODOID}</td>  
                <td>{$PORCENTAJE}%</td>
                <td>{$CONCEPTO}</td>
                
            </tr>
            <tr>
                <th style="color: red; text-align: center;" colspan="4">Rangos</th>
            </tr>
            <tr>
                <td><label>Rango Inicio UVT: </label></td>
                <td><label>Rango Fin UVT: </label></td>
                <td><label>Rango Inicio Pesos : </label></td>
                <td><label>Rango Fin Pesos : </label></td>
            </tr>
            <tr>
                <td>{$RANGOINI}</td>
                <td>{$RANGOFIN}</td>
                <td>{$RANGOINIPESOS}</td>
                <td>{$RANGOFINPESOS}</td>
          </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
          </tr>
            <tr>
                <td colspan="7" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
            </tr>
        </table>
    {$FORM1END}
    </fieldset>
    <fieldset>{$GRIDPARAMETROS}</fieldset>

</body>
</html>

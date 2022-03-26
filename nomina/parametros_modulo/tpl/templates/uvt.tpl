<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="../../../framework/css/bootstrap1.css">
    {$JAVASCRIPT}
   
    {$CSSSYSTEM}
   
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
    {$UVTID}
    <fieldset class="section">
        <table align="center">
            <tr>
                <td><label>Período Contable : </label></td>
                <td>{$PERIODOID}</td>
            </tr>
            <tr>
                <td><label>UVT Nominal  : </label></td>
                <td>{$UVTNOMINAL}</td>
            </tr>
            <tr>
                <td><label>UVT Mínimo  : </label></td>
                <td>{$UTVMINIMO}</td>
            </tr>
            <tr>
                <td><label>Impuesto  : </label></td>
                <td>{$IMPUESTOID}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
            </tr>
        </table>
        <button type="button" class="btn btn-warning btn-sm" id="mostrar_grid"  onclick="showTable()" style="float:right;">Mostrar tabla</button>
    {$FORM1END}
    </fieldset>
  

</body>
</html>

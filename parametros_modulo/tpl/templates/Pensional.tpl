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
    <a href="javascript:void(0);"   title="Presiona aqui para saber acerca de las clases de riesgo."  name="myBtn"><img src="../../../framework/media/images/modulos/manual.png" width="16" height="18" onclick="alert_unico(this,'Informaci&oacute;n','En este formulario parametrizaremos el porcentaje correspondiente al Fondo de Solidaridad Pensional, para quienes devenguen cuatro o más salarios mínimos mensuales vigentes.')"/></a>
        <table align="center">
            <tr>
                <td><label>Porcentaje : </label></td>
                <td>{$PORCENTAJE}</td>
                <td><label>Período Contable : </label></td>
                <td>{$PERIODOID}</td>
            </tr>
            <tr>
                <td><label>Rango Inicio : </label></td>
                <td>{$RANGOINI}</td>
                <td><label>Rango Fin : </label></td>
                <td>{$RANGOFIN}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
          </tr>
          <br>
            <tr>
                <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
            </tr>
        </table>
           <!--INICIO Cuadro de informacion-->
    <div id="MyModal" class="modal">
    
        <!-- Modal content -->
        <div class="modal-content" style="width:70%;">
            <span class="close">&times;</span>
            <h5 id="h5"> </h5>
            <h4 align="center"><img src="../../../framework/media/images/alerts/info.png" /></h4>
            <p id="p"></p>
        </div>
    
    </div>
    <!--FIN Cuadro de informacion-->
    <fieldset>{$GRIDPARAMETROS}</fieldset>
    {$FORM1END}
    </fieldset>
</body>
</html>

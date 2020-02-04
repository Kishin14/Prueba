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
    {$ARLID}
    <fieldset class="section">
        <table align="center">
            <tr>
                <td><label>Clase de Riesgo  : </label></td>
                <td>{$CLASE}</td>
                <td><a href="javascript:void(0);"   title="Presiona aqui para saber acerca de las clases de riesgo."  name="myBtn"><img src="../../../framework/media/images/modulos/manual.png" width="16" height="18" onclick="alert_unico(this,'Informaci&oacute;n','El artículo 26 del Decreto 1295 de 1994 establece las siguientes clases de riesgo, las cuales se reglamentan en el artículo 2.2.4.3.5 del Derecho 1072 de 2015')"/></a></td>
            </tr>
            <tr>
                <td><label>Porcentaje  : </label></td>
                <td>{$PORCENTAJE}</td>
            </tr>
            <tr>
                <td><label>Descripcion  : </label></td>
                <td>{$DESCRIPCION}</td>
            </tr>
            <tr>
                <td><label>Estado : </label></td>
                <td>{$ESTADO}</td>
            </tr>
            <tr>
                <td align="center">&nbsp;</td>
                <td align="center">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
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
        
    {$FORM1END}
    </fieldset>
   <fieldset>{$GRIDPARAMETROS}</fieldset>

</body>
</html>

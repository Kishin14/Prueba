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
    {$RETENCIONID}
    <fieldset class="section">
    <a href="javascript:void(0);"   title="Presiona aqui para saber acerca de las clases de riesgo."  name="myBtn"><img src="../../../framework/media/images/modulos/manual.png" width="16" height="18" onclick="alert_unico(this,'Informaci&oacute;n','Definicion Retencion Salarial: Deducción del salario bruto que efectúan las empresas e ingresan en Hacienda como pago a cuenta del trabajador por su impuesto sobre la renta. Permite controlar el fraude, además de financiar por anticipado a la Administración. Este formulario funciona de la siguiente forma: Ingresaremos un porcentaje el cual se le descontara al empleado segun los UVT Que este gane, al ingresar los UVT el sistema calculará el rango inicio y fin en pesos indicandonos que los que esten ganando el dinero que se presenta entre estos dos rangos se le hara el descuento del porcentaje anteriormente estipulado.')"/></a>
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
    <button type="button" class="btn btn-warning btn-sm" id="mostrar_grid"  onclick="showTable()" style="float:right;">Mostrar tabla</button>
    {$FORM1END}
    </fieldset>
   

</body>
</html>

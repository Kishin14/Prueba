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
    {$CONTABLEID}
    <fieldset class="section">
        <table align="center">
            <tr>
                <td><label>Nombre : </label></td>
                <td colspan="3">{$DESCRIPCION}</td>
            </tr>
            <tr>
                <td><label>Puc Adm&oacute;n : </label></td>
                <td>{$PUC_ADMON}{$PUC_ADMON_ID}</td>
                <td><label>Naturaleza : </label></td>
                <td>{$NATURALEZA_ADMON}</td>
            </tr>
            <tr>
                <td><label>Puc Ventas : </label></td>
                <td>{$PUC_VENTAS}{$PUC_VENTAS_ID}</td>
                <td><label>Naturaleza : </label></td>
                <td>{$NATURALEZA_VENTAS}</td>
            </tr>
            <tr>
                <td><label>Puc Producci&oacute;n : </label></td>
                <td>{$PUC_PROD}{$PUC_PROD_ID}</td>
                <td><label>Naturaleza : </label></td>
                <td>{$NATURALEZA_PROD}</td>
            </tr>
            <tr>
                <td><label>Puc Contrapartida : </label></td>
                <td>{$CONTRAPARTIDA}{$CONTRAPARTIDA_PUC_ID}</td>
                <td><label>Naturaleza : </label></td>
                <td>{$NATURALEZA_CONTRA}</td>
            </tr>
            <tr>
                <td><label>Base Salarial  : </label></td>
                <td>{$BASE}</td>
                <td><label>Tipo de Calculo : </label></td>
                <td>{$TCALCULO}</td>
            </tr>          
            <tr>
                <td><label>Genera Documento Contable? </label></td>
                <td>{$CONTABILIZA}</td>
                <td><label>Estado: </label></td>
                <td>{$ESTADO}</td>
            </tr>
            <tr>
                <td><label>Puc Partida: </label></td>
                <td>{$PUCPARTIDA}{$PUCPARTIDAID}</td>
                <td><label>Naturaleza Partida: </label></td>
                <td>{$NATPARTIDA}</td>
            </tr>
            <tr>
                <td><label>Puc Contrapartida: </label></td>
                <td>{$PUCCONTRA}{$PUCCONTRAID}</td>
                <td><label>Naturaleza Contrapartida:</label></td>
                <td>{$NATCONTRA}</td>
            </tr>
             <tr>
                <td><label>Tipo novedad: </label></td>
                <td>{$TIPONOVEDAD}</td>
            </tr>
            <tr>
                <td colspan="4">&nbsp;</td>
            </tr>
            <tr>
	            <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
            </tr>
        </table>
        <button type="button" class="btn btn-warning btn-sm" id="mostrar_grid"  onclick="showTable()" style="float:right;">Mostrar tabla</button>
    {$FORM1END}
    </fieldset>
   

</body>
</html>

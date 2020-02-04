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
    {$PARAMETROLIQUIDACIONID}
    <fieldset class="section">
    <fieldset class="section">
    <legend> Liquidaci&oacute;n Vacaciones</legend>
        <table width="99%">
            <tr>
                <td><label>Empresa : </label></td>
                <td colspan="5">{$EMPRESAID}</td>
            </tr>
            <tr>
                <td><label>Oficina : </label></td>
                <td colspan="3">{$OFICINAID}</td>
                <td><label>Documento Contable :</label></td>
                <td>{$DOCUMENTOCONTABLE}</td>
            </tr>

            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <td><label>PUC Vacaciones Consolidadas</label></td>
                <td>{$PUCVACCONS}{$PUCVACCONSID}</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><label>PUC Contrapartida</label></td>
                <td>{$PUCVACCONTRA}{$PUCVACCONTRAID}</td>
            </tr>
            <tr>
                <td><label>PUC Adm&oacute;n</label></td>
                <td>{$PUCADMONVAC}{$PUCADMONVACID}</td>
                <td><label>PUC Ventas</label></td>
                <td>{$PUCVENTASVAC}{$PUCVENTASVACID}</td>
                <td><label>PUC Producci&oacute;n</label></td>
                <td>{$PUCPRODUCCVAC}{$PUCPRODUCCVACID}</td>
            </tr>  
            <tr>
                <td><label>PUC Deducci&oacute;n Salud</label></td>
                <td>{$PUCSALUDVAC}{$PUCSALUDVACID}</td>
                <td><label>PUC Deducci&oacute;n Pension</label></td>
                <td>{$PUCPENSIONVAC}{$PUCPENSIONVACID}</td>
            </tr>
            <tr>
                <td><label>PUC Reintegro</label></td>
                <td>{$PUCREINTEVAC}{$PUCREINTEVACID}</td>
                
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
        </table>
    </fieldset>
    <fieldset class="section">
    <legend> Liquidaci&oacute;n Prima</legend>
        <table width="99%">
            <tr>
                <td><label>PUC Prima Consolidada</label></td>
                <td>{$PUCPRIMACONS}{$PUCPRIMACONSID}</td>
                <td >&nbsp;</td>
                <td>&nbsp;</td>
                <td><label>PUC Contrapartida</label></td>
                <td>{$PUCPRIMACONTRA}{$PUCPRIMACONTRAID}</td>
            </tr>
            <tr>
                <td><label>PUC Adm&oacute;n</label></td>
                <td>{$PUCADMONPRIMA}{$PUCADMONPRIMAID}</td>
                <td><label>PUC Ventas</label></td>
                <td>{$PUCVENTASPRIMA}{$PUCVENTASPRIMAID}</td>
                <td><label>PUC Producci&oacute;n</label></td>
                <td>{$PUCPRODUCCPRIMA}{$PUCPRODUCCPRIMAID}</td>
            </tr>  
            <tr>
                <td><label>PUC Reintegro</label></td>
                <td>{$PUCREINTEPRIMA}{$PUCREINTEPRIMAID}</td>
                
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
        </table>
    </fieldset>
    <fieldset class="section">
    <legend> Liquidaci&oacute;n Cesantias </legend>
        <table width="99%">
            <tr>
                <td><label>PUC Cesantias Consolidadas</label></td>
                <td>{$PUCCESANTIASCONS}{$PUCCESANTIASCONSID}</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><label>PUC Contrapartida</label></td>
                <td>{$PUCCESANTIASCONTRA}{$PUCCESANTIASCONTRAID}</td>
            </tr>
            <tr>
                <td><label>PUC Admon</label></td>
                <td>{$PUCADMONCESANTIAS}{$PUCADMONCESANTIASID}</td>
                <td><label>PUC Ventas</label></td>
                <td>{$PUCVENTASCESANTIAS}{$PUCVENTASCESANTIASID}</td>
                <td><label>PUC Producci&oacute;n</label></td>
                <td>{$PUCPRODUCCCESANTIAS}{$PUCPRODUCCCESANTIASID}</td>
            </tr>  
           <tr>
                <td><label>PUC Reintegro</label></td>
                <td>{$PUCREINTECESANTIAS}{$PUCREINTECESANTIASID}</td>
                
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
        </table>
    </fieldset>
    <fieldset class="section">
    <legend> Liquidaci&oacute;n Intereses Cesantias </legend>
        <table width="99%">
            <tr>
                <td><label>PUC Intereses Cesantias Consolidados</label></td>
                <td>{$PUCINTCESANTIASCONS}{$PUCINTCESANTIASCONSID}</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><label>PUC Contrapartida</label></td>
                <td>{$PUCINTCESANTIASCONTRA}{$PUCINTCESANTIASCONTRAID}</td>
            </tr>
            <tr>
                <td><label>PUC Admon</label></td>
                <td>{$PUCADMONINTCESANTIAS}{$PUCADMONINTCESANTIASID}</td>
                <td><label>PUC Ventas</label></td>
                <td>{$PUCVENTASINTCESANTIAS}{$PUCVENTASINTCESANTIASID}</td>
                <td><label>PUC Producci&oacute;n</label></td>
                <td>{$PUCPRODUCCINTCESANTIAS}{$PUCPRODUCCINTCESANTIASID}</td>
            </tr>  
            <tr>
                <td><label>PUC Reintegro</label></td>
                <td>{$PUCREINTEINTCESANTIAS}{$PUCREINTEINTCESANTIASID}</td>
                
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
        </table>
    </fieldset>
        <table width="99%">     
            <tr>
                <td align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
            </tr>
        </table>
    {$FORM1END}
    </fieldset>
    <fieldset><!--{$GRIDPARAMETROS}--></fieldset>
        
</body>
</html>

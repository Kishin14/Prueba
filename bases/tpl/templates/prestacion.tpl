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
    {$EMPID}
    {$TERID}
    <fieldset class="section">
        <table	align="center" width="90%">
            <tr>
                <td><label>Tipo Identificaci&oacute;n :</label></td>
                <td>{$IDENTIFICACIONID}</td>
                <td><label>Tipo Persona :</label></td>
                <td>{$PERSONAID}</td>
            </tr>
            <tr>
                <td><label>Numero Identificaci&oacute;n :</label></td>
                <td colspan="1">{$NUMID}{$DIGITO}</td>
            </tr>
            <tr>
                <td><label>Raz&oacute;n Social :</label></td>
                <td>{$RAZON}</td>
                <td><label>Sigla :</label></td>
                <td>{$SIGLA}</td>
            </tr>
            <tr>
                <td><label>E-mail : </label></td>
                <td>{$EMAIL}</td>
                <td><label>Movil : </label></td>
                <td>{$MOVIL}</td>
            </tr>
            <tr>
            <td>
                <label>Tel&eacute;fono :</label></td>
                <td>{$TELEFONO}</td>
                <td><label>Telefax :</label></td>
                <td>{$TELEFAX}</td>
            </tr>
            <tr>
                <td><label>Direcci&oacute;n :</label></td>
                <td>{$DIRECCION}</td>
                <td><label>Ubicaci&oacute;n : </label></td>
                <td>{$UBICACION}{$UBICACIONID}</td>
            </tr>
            <tr>
                <td><label>Codigo : </label></td>
                <td>{$CODIGO}</td>
                <td><label>Salud : </label></td>
                <td>{$SALUD}</td>
            </tr>
            <tr>
                <td><label>Pensi&oacute;n : </label></td>
                <td>{$PENSION}</td>
                <td><label>ARL : </label></td>
                <td>{$ARL}</td>
            </tr>
            <tr>
                <td><label>Caja : </label></td>
                <td>{$CAJA}</td>
                <td><label>Cesantias : </label></td>
                <td>{$CESANTIAS}</td>
            </tr>
            <tr>
                <td><label>Parafiscales : </label></td>
                <td colspan="1">{$PARAFISCALES}</td>
            </tr>
            <tr>
                <td><label>Agente ICA :</label></td>
                <td>{$RETEI}</td>
                <td><label>Autoretenedor Renta :</label></td>
                <td>{$AUTORET}</td>
            </tr>
            <tr>
                <td><label>R&eacute;gimen : </label></td>
                <td>{$REGIMENID}</td>
                <td><label>Estado : </label></td>
                <td>{$ESTADO}</td>
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

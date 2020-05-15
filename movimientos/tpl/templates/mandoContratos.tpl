<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="../../../framework/css/bootstrap1.css">
    {$JAVASCRIPT}
    {$TABLEGRIDJS}
    {$CSSSYSTEM} 
    {$TABLEGRIDCSS} 
    {$TITLETAB} 
</head>

<body>

    <fieldset class="section">
        <fieldset>{$GRIDmandoContratos}</fieldset>
    </fieldset>

    <div id="Renovarcontrato" style="display:none">
        <div align="center">
            <p align="center">
            <form onSubmit="return false">
                <fieldset class="section">
                    <table id="tableGuia" width="100%">
                        <th colspan="5">Información Contrato</th>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td><label>Contrato No :</label></td>
                            <td>{$CONTRATO}{$CONTRATOID}</td>
                            <td><label>Empleado :</label></td>
                            <td colspan="5°">{$EMPLEADO}</td>

                        </tr>
                        <tr>
                            <td><label>Fecha Inicio :</label></td>
                            <td>{$FECHAINICIO}</td>
                            <td><label>Fecha Terminacion :</label></td>
                            <td>{$FECHAFIN}</td>
                        </tr>
                        <tr>
                            <td><label>Sueldo Base :</label></td>
                            <td>{$SUELDO}</td>
                            <td><label>Subsidio Transporte :</label></td>
                            <td>{$SUBSIDIO}</td>
                        </tr>
                        <tr>

                        </tr>
                        <tr>
                            <td><label>Estado :</label></td>
                            <td colspan="4">{$ESTADO}</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <th colspan="5">Información Renovar</th>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td><label>Nueva Fecha Terminacion:</label></td>
                            <td>{$FECHAFINREN}</td> 
                            <td><label>Observación Renueva :</label></td>
                            <td colspan="2">{$OBSERVACION}</td>
                        </tr>
                        <tr>
                            <td>{$RENOVAR}</td>
                        </tr>

                    </table>
                </fieldset>
            </form>
            </p>
        </div>
    </div>
    <!--Fin del div renovar marco-->
</body>

</html>
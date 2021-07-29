<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="../../../framework/css/bootstrap1.css">
    <script src="../../../framework/clases/tinymce_4.4.1_dev/tinymce/js/tinymce/tinymce.min.js"></script> 
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
    {$CAUSALEVALID}
    <fieldset class="section">
        <table align="center" width="100%">
            <tr>
                <td>
                    <table width="50%" align="center">
                        <tr>
                            <td colspan="2"><label>Tipo Documento : </label></td>
                            <td colspan="2">{$TIPO_DOCUMENTO_LABORAL}</td>
                        </tr>
                        <tr>
                            <td colspan="2"><label>Nombre Documento  : </label></td>
                            <td colspan="2">{$NOMBRE_DOCUMENTO}</td>
                        </tr>
                        <tr>
                            <td colspan="2"><label>Tipo de Contrato : </label></td>
                            <td colspan="2">{$TIPO_CONTRATO_ID}</td>
                        </tr>
                        <tr>
                            <td  colspan="2"><label>Variables :</label></td>
                            <td  colspan="2">{$VARIABLES}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <table width="100%">
                        <tr>
                            <td colspan="4"><label>Cuerpo Mensaje  : </label></td>
                        </tr>
                        <tr>
                            <td  colspan="4" align="100%">{$CUERPO_MENSAJE}</td>
                        </tr>
                    </table>
                </td>
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

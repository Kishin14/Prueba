<html>
<head>
    {$JAVASCRIPT}
    {$CSSSYSTEM} 
    {$TITLETAB}
</head>

<body>
    <fieldset>
    <legend>{$TITLEFORM}</legend>
    </fieldset>
    {$FORM1}
    <fieldset class="section">
    <table>
        <tr>
            <td ><label>Usuario : </label></td>
            <td colspan="3" ><span style="text-transform:uppercase; color:#00C; font-weight:bold">{$USUARIONOMBRES}{$USUARIOID}</span></td>
        </tr>       
        <tr>
            <td width="229" ><label>Nombre de  Usuario    :</label></td>
            <td width="154" align="left">{$USUARIO}</td>
            <td width="103" ><label>Clave :</label></td>
            <td width="416" align="left">{$CLAVE}</td>
        </tr>        
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4" align="center">{$ACTUALIZAR}</td>
        </tr>
    </table>
    {$FORM1END}
    </fieldset>


</body>
</html>
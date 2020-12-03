<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    {$TITLETAB}  
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    {$JAVASCRIPT} 
   
    {$CSSSYSTEM} 
   

</head>
<body>
    <fieldset> 
    <legend>{$TITLEFORM}</legend>
    <div id="table_find">
    <table>
        <tbody>
            <tr>
                <td><label>Busqueda : </label></td>
                <td>{$BUSQUEDA}</td>
            </tr>
        </tbody>
    </table>
    </div>
    </fieldset>
    {$FORM1}
    <fieldset class="section">
    <table align="center">
        <tbody>
            <tr>
                <td><label>Tipo Identificaci&oacute;n :</label></td>
                <td>{$TIPOIDENTIFICACION}{$TERCEROID}{$TIPOPERSONA}</td>
                <td><label>Numero Id :</label></td>
                <td>{$NUMEROIDENTIFICACION}{$DIGITOVERIFICACION}</td>
            </tr>
            <tr>
                <td><label>Primer Apellido :</label></td>
                <td align="left">{$PRIMERAPELLIDO}</td>
                <td><label>Segundo Apellido :</label></td>
                <td align="left">{$SEGUNDOAPELLIDO}</td>
            </tr>
            <tr>
                <td><label>Primer Nombre :</label></td>
                <td align="left">{$PRIMERNOMBRE}</td>
                <td><label>Otros Nombres :</label></td>
                <td>{$OTROSNOMBRES}</td>
            </tr>
            <tr>
                <td><label>Cargo :</label></td>
                <td>{$CARGO}</td>
                <td><label>Email :</label></td>
                <td>{$EMAIL}</td>
            </tr>
            <tr>
                <td><label>Usuario :</label></td>
                <td>{$USUARIOID}{$USUARIO}</td>
                <td><label>Empresas : </label></td>
                <td rowspan="2">{$EMPRESAS}</td>
            </tr>
             <tr>
                <td><label>Cliente :</label></td>
                <td>{$CLIENTEID}{$CLIENTE} </td>
                <td align="center">&nbsp;</td>
            </tr>
            <tr>
                <td><label>Estado :</label></td>
                <td>A{$ACTIVO}I{$INACTIVO} </td>
                <td align="center">&nbsp;</td>
            </tr>
            
             <tr>
             <td> </td>
             </tr>
            <tr>
                <td align="center">&nbsp;</td>                                                                                                                                                
                <td colspan="2" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
                <td align="center" title="">&nbsp;<a href="javascript:void(0);"  onclick="window.open('https://www.youtube.com/watch?v=0GCucA0jNGw&t=',  'popup', 'top=250, left=480, width=400, height=300, toolbar=NO, resizable=NO, Location=NO, Menubar=NO,  Titlebar=No, Status=NO')"><img src="../../../framework/media/images/modulos/manual.png" width="16" height="18"/></a></td>                                                                                                                                                                                      
            </tr>
        </tbody>
    </table>
    
    <button type="button" class="btn btn-warning btn-sm" id="mostrar_grid"  onclick="showTable()" style="float:right;">Mostrar tabla</button>
    
    {$FORM1END} </fieldset>

</body>
</html>
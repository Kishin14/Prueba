<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
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
    <fieldset class="section">
        <table width="70%" align="center"> 
            <tr>
                <td><label>Licencia No. </label></td>
                <td>{$LICENCIAID}</td>
                <td><label>Fecha Licencia : </label></td>
                <td>{$FECHALIC}</td>                
            </tr>
            <tr>
                <td><label>Empleado : </label></td>
                <td>{$CONTRATO}{$CONTRATOID}</td>
                <td><label>Tipo Licencia o Incapacidad : </label></td>
                <td>{$CONCEPTOAREA}</td>                
            </tr>
            <tr>
                <td><label>Concepto : </label></td>
                <td colspan="3">{$CONCEPTO}</td>
            </tr>   
            <tr>
                <td><label>Diagnostico : </label></td>
                <td colspan="3">{$DIAGNOSTICO}</td>
            </tr>            
            <tr>
                <td><label>Fecha Inicial : </label></td>
                <td>{$FECHAINI}</td>
                <td><label>Fecha Final : </label></td>
                <td>{$FECHAFIN}</td>                            
            </tr>
            <tr>
                <td><label>Dias : </label></td>
                <td>{$DIAS}</td>
                <td><label>Remunerado : </label></td>
                <td>{$REMUNERADO}</td>                            
            </tr>            
            <tr>
                <td><label>Estado : </label></td>
                <td colspan="3">{$ESTADO}</td>              
        	</tr>                                                                           
        	<tr>
            	<td colspan="4">&nbsp;</td>
            </tr>
        	<tr>
       			<td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$IMPRIMIR}&nbsp;{$LIMPIAR}</td>
        	</tr>
        </table>		 
    </fieldset>
    {$FORM1END}
    <fieldset>{$GRIDNOVEDAD}</fieldset>

</body>
</html>
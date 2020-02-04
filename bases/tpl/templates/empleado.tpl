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
        <div id="divSolicitudConvocado">
        	<iframe id="iframeSolicitudConvocado"></iframe>
        </div>
        <div id="table_find">
            <table>
                <tr>
                	<td><label>Busqueda : </label></td><td>{$BUSQUEDA}</td>
                	<td align="right">{$IMPORTARCONVOCADO}&nbsp;&nbsp;&nbsp;</td>
				</tr>
            </table>
        </div>
    </fieldset>
    {$FORM1}
    {$EMPLEADOID}
    <fieldset class="section"> 
        <table align="center" width="70%">
            <tr style="display:none" id="trnombrecomp">
                <td width="10%"><label>Nombre : </label></td>
                <td width="43%">
                <input id="nombrecomp" disabled>
                </td>
                <td width="7%"></td>
                <td width="10%"></td>
            </tr>
            <tr>
                <td><label>Tipo Identificaci&oacute;n : </label></td>
                <td>{$TIPOIDENTIFICACION}</td>
                <td><label>Tipo Contribuyente : </label></td>
                <td>{$TIPOPERSONA}</td>
            </tr>
            <tr>
                <td><label>N&uacute;mero Identificaci&oacute;n : </label></td>
                <td>{$NUMEROIDENTIFICACION} {$TERCEROID}</td>
                <td><label>Sexo : </label></td>
                <td>{$SEXO}</td>
            </tr>
            <tr>
                <td><label>Primer Nombre : </label></td>
                <td>{$PRIMERNOMBRE}</td>
                <td><label>Segundo Nombre : </label></td>
                <td>{$OTROSNOMBRES}</td>
            </tr>
            <tr>
                <td><label>Primer Apellido : </label></td>
                <td>{$PRIMERAPELLIDO}</td>
                <td><label>Segundo Apellido : </label></td>
                <td>{$SEGUNDOAPELLIDO}</td>
            </tr>
            <tr>
                <td><label>Fecha de Nacimiento : </label></td>
                <td>{$FECHN}</td>
                <td><label>Estado Civil : </label></td>
                <td>{$ESTADOCIV}</td>
            </tr>
            <tr>
                <td><label>Direcci&oacute;n : </label></td>
                <td>{$DIRECCION}</td>
                <td><label>Tel&eacute;fono : </label></td>
                <td>{$TELEFONO}</td>
            </tr>
            <tr>
                <td><label>Movil : </label></td>
                <td>{$MOVIL} </td>
                <td><label>Profesi&oacute;n : </label></td>
                <td>{$PROFESION}{$PROFESIONID}</td>
            </tr>          
                <td><label>Tipo de Vivienda : </label></td>
                <td>{$VIVIENDA}</td>
                <td><label>N&uacute;mero de Hijos : </label></td>
                <td>{$NHIJOS}</td>
                
            </tr>
           <!-- <tr>
                <td><label>Foto :</label></td>
                <td>{$FOTO}</td>
                <td><label>Certificados :</label></td>
                <td>{$CERTIFICADO}</td>
            </tr>-->
            <tr>
                <td>{*<label>Estado:</label>*}</td>
                <td style="display:none">{$CONVOCADOID}</td>
            </tr>
            <tr>
                <td><label>Estado :</label></td>
                <td>{$ESTADO}</td>
                <td><label>Documentos Selección:</label></td>
                <td>{$DOCUMENTO}</td>
            </tr>
            <tr>
                <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
            </tr>
        </table>
	</fieldset>
		<table id="toolbar">
            <tbody>
            	<tr>
                    <td id="messages"><div>&nbsp;</div></td>
                    <td id="detailToolbar">
                    <img src="../../../framework/media/images/grid/save.png" id="saveDetalles" title="Guardar Seleccionados">
                    <img src="../../../framework/media/images/grid/no.gif" id="deleteDetalles" title="Borrar Seleccionados">
                    </td>
                    <td id="fileUpload" align="right">{$ARCHIVOSOLICITUD}</td>
	            </tr>               
            </tbody>
		</table>  
	<fieldset class="section">
    <legend>INFORMACI&Oacute;N HIJO(s)</legend>   
    	<div>
        	<iframe name="HijosEmpleado" id="HijosEmpleado" src="about:blank"></iframe>
		</div>
	</fieldset>
    	<table id="toolbar">
            <tbody>
            	<tr>
                    <td id="messages"><div>&nbsp;</div></td>
                    <td id="detailToolbar" >
                    <img src="../../../framework/media/images/grid/save.png" id="saveDetalles2" title="Guardar Seleccionados">
                    <img src="../../../framework/media/images/grid/no.gif" id="deleteDetalles2" title="Borrar Seleccionados">
                    </td>
                    <td id="fileUpload2">{$ARCHIVOSOLICITUD}</td>
            	</tr>               
            </tbody>
		</table> 
	<fieldset class="section"> 
    <legend>INFORMACI&Oacute;N CONYUGE</legend>   
    	<div>
        	<iframe name="ConyugeEmpleado" id="ConyugeEmpleado" src="about:blank"></iframe>
		</div>
	</fieldset>
    	<table id="toolbar">
            <tbody>
            	<tr>
                    <td id="messages"><div>&nbsp;</div></td>
                    <td id="detailToolbar">
                    <img src="../../../framework/media/images/grid/save.png" id="saveDetalles3" title="Guardar Seleccionados">
                    <img src="../../../framework/media/images/grid/no.gif" id="deleteDetalles3" title="Borrar Seleccionados">
                    </td>
                    <td id="fileUpload3">{$ARCHIVOSOLICITUD}</td>
	            </tr>               
            </tbody>
        </table> 
    <fieldset class="section"> 
    <legend>INFORMACI&Oacute;N ESTUDIO</legend>   
    	<div>
        	<iframe name="EstudioEmpleado" id="EstudiosEmpleado" src="about:blank"></iframe>
		</div>
    </fieldset>
    {$FORM1END}
    <fieldset>{$GRIDPARAMETROS}</fieldset>

</body>
</html>

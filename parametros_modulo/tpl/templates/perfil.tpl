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
    {$PERFILID}
    <fieldset class="section">
        <table align="center">
            <tr>
                <td><label>Cargo  : </label></td>
                <td>{$NOMBRE}{$CARGOID}</td>
                <td><label>Experiencia (Meses) : </label></td>
                <td>{$EXPERIENCIA}</td>
            </tr>
            <tr>
                <td><label>Categoria ARL : </label></td>
                <td>{$ARLID}</td>
                <td><label>Base  : </label></td>
                <td>{$BASE}</td>
            </tr>
            <tr>
                <td><label>Nivel de Escolaridad  : </label></td>
                <td>{$ESCOLARIDADID}</td>
                <td><label>Estado Civil  : </label></td>
                <td>{$CIVILID}</td>
            </tr>
            <tr>
                <td><label>Genero : </label></td>
                <td>{$SEXO}</td>
                <td><label>Area  Laboral :</label></td>
                <td>{$AREALAB}</td>
                <td><a href="javascript:void(0);"   title="Presiona aqui para saber acerca de este campo."  name="myBtn"><img src="../../../framework/media/images/modulos/manual.png" width="16" height="18" onclick="alert_unico(this,'Informaci&oacute;n','Dependiendo del area que seleccionemos en este campo, al momento de hacer una novedad este afectara las cuentas contables ya sean administrativas, ventas o produccion. Estas cuentas podemos ubicarlas en el formulario Parametros Novedades')"/></a></td>
            </tr>
            <tr>
                <td><label>Edad Mínima : </label></td>
                <td>{$MINIMOEDAD}</td>
                <td><label>Edad M&aacute;xima : </label></td>
                <td>{$MAXIMOEDAD}</td>
            
            </tr>
            <tr>
                <td><label>Rango Salarial Mínimo</label></td>
                <td>{$RANGOSALMIN}</td>
                <td><label>Rango Salarial M&aacute;ximo : </label></td>
                <td>{$RANGOSALMAX}</td>
            
            </tr>
            <tr>
                <td><label>Ocupaci&oacute;n DANE :</label></td>
                <td>{$OCUPACION}{$OCUPACIONID}</td>
                <td><label>Escala Salarial  : </label></td>
                <td>{$ESCALAID}</td>
            </tr>
            <tr>
                <td colspan="4">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
            </tr>
		</table>    
        <table id="toolbar">
            <tbody>
                <tr>
                    <td id="messages"><div>&nbsp;</div></td>
                    <td id="detailToolbar">
                    <img src="../../../framework/media/images/grid/save.png" id="saveDetalles" title="Guardar Seleccionados">
                    <img src="../../../framework/media/images/grid/no.gif" id="deleteDetalles" title="Borrar Seleccionados">
                    </td>
                    <td id="fileUpload">{$ARCHIVOSOLICITUD}</td>
                </tr>               
            </tbody>
		</table>    
		<div>
        	<iframe name="VehiculoPerfil" id="VehiculoPerfil" src="about:blank"></iframe>
		</div>
        <table id="toolbar">
        	<tbody>
            	<tr>
                    <td id="messages"><div>&nbsp;</div></td>
                    <td id="detailToolbar">
                    <img src="../../../framework/media/images/grid/save.png" id="saveDetalles2" title="Guardar Seleccionados">
                    <img src="../../../framework/media/images/grid/no.gif" id="deleteDetalles2" title="Borrar Seleccionados">
                    </td>
                    <td id="fileUpload2">{$ARCHIVOSOLICITUD}</td>
                </tr>               
            </tbody>
        </table> 
    	<div>
        	<iframe name="ProfesionPerfil" id="ProfesionPerfil" src="about:blank"></iframe>
		</div>
    {$FORM1END}
    </fieldset>

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
    <!--FIN Cuadro de informacion-->
    
    <fieldset>{$GRIDPARAMETROS}</fieldset>

</body>
</html>

{if $sectionOficinasTree neq 1}
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
                    <td><label>Busqueda :</label></td>
                    <td>{$BUSQUEDA}</td>
                </tr>
            </table>
        </div>
    </fieldset>
    {$FORM1}
    <fieldset class="section">
        <table align="center">
            <tr>
                <td><label>Empresa :</label></td>
                <td>{$EMPRESAS}{$OFICINAID}</td>
                <td><label>Superior :</label></td>
                <td>{$SUPERIOR}</td>
            </tr>
            <tr>
                <td><label>Nombre : </label></td>
                <td>{$NOMBRE}</td>
                <td><label>Codigo :</label></td>
                <td>{$CODIGOCENTRO}</td>
            </tr>
            <tr>
                <td><label>Ubicaci&oacute;n :</label></td>
                <td>{$UBICACION}{$UBICACIONID}</td>
                <td><label>Direcci&oacute;n :</label></td>
                <td>{$DIRECCION}</td>
            </tr>
            <tr>
                <td><label>Telefono :</label></td>
                <td>{$TELEFONO}</td>
                <td><label>Movil :</label></td>
                <td>{$MOVIL}</td>
            </tr>		 
            <tr>
                <td><label>Email :</label></td>
                <td>{$EMAIL}</td>
                <td><label>Sucursal :</label></td>
                <td><label>SI {$SUCURSALSI}NO {$SUCURSALNO}</label></td>
            </tr>		   
            <tr>
                <td><label>Responsable :</label></td>
                <td>{$RESPONSABLE}{$RESPONSABLEID}</td>
                <td><label>Plantilla :</label></td>
                <td>{$PLANTILLA}</td>
            </tr>		   
            <tr>
                <td colspan="4">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
            </tr>
        </table>
    {$FORM1END}
    </fieldset>

</body>
</html>
	
{/if}    

    {if $sectionOficinasTree eq 1}
    {if $encabezadoTree eq 1}
    <fieldset id="oficinasTree">
    <table id="tree" class="treeTable" width="80%">
        <thead>
        	<tr>
            	<th align="center" >NOMBRE</th>
                <td>UBICACION</td>
                <td>SUCURSAL ?</td>
			</tr>
		</thead>
        <tbody>
        {/if}
        {if $nivelEmpresa eq 1}
            <tr id="ex2-node-{$node}">
            	<td colspan="3"><span class="folder">{$empresa_nombre}</span></td>
			</tr>{/if}
        {if $nivelOficina eq 1}
        	<tr id="ex2-node-{$node}" class="child-of-ex2-node-{$child}">
            	<td><span class="file">{$oficina_nombre}</span></td>
                <td>{$ubicacion}</td>
                <td>{if $sucursal eq 1}SI{else}NO{/if}</td>
			</tr>{/if}
        {if $pieTree eq 1}
        </tbody>			
    </table>		 
    </fieldset>
    {/if}
    {/if}
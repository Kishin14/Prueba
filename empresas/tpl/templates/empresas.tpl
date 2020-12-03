<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
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
    <fieldset class="section">
    <table align="center">
        <tr>
            <td><label>Tipo Identificaci&oacute;n :</label></td>
            <td>{$TIPOIDENTIFICACION}{$TERCEROID}</td>
            <td><label>Tipo Contribuyente :</label></td>
            <td>{$TIPOPERSONA}</td>
        </tr>
        <tr>
            <td><label>N&uacute;mero Identificaci&oacute;n :</label></td>
            <td colspan="3">{$NUMEROIDENTIFICACION}{$DIGITOVERIFICACION}</td>
        </tr>
        <tr id="filaApellidos">
            <td><label>Primer Apellido :</label></td>
            <td>{$PRIMERAPELLIDO}</td>
            <td><label>Segundo Apellido :</label></td>
            <td>{$SEGUNDOAPELLIDO}</td>
        </tr>
        <tr id="filaNombres">
            <td><label>Primer Nombre :</label></td>
            <td>{$PRIMERNOMBRE}</td>
            <td><label>Otros Nombres :</label></td>
            <td>{$OTROSNOMBRES}</td>
        </tr>
        <tr id="filaRazonSocial">
            <td><label>Raz&oacute;n Social :</label></td>
            <td>{$RAZON_SOCIAL}</td>
            <td><label>Sigla :</label></td>
            <td>{$SIGLA}</td>
        </tr>
        <tr>
            <td><label>Ciudad :</label></td>
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
            <td><label>Telefono Fax :</label></td>
            <td>{$TELEFAX}</td>
            <td><label>Apartado Aereo :</label></td>
            <td>{$APARTADO}</td>
        </tr>
        <tr>
            <td><label>Email :</label></td>
            <td>{$EMAIL}</td>
            <td><label>Pagina Web : </label></td>
            <td>{$PAGINAWEB}</td>
        </tr>
        <tr>
            <td><label>Logo :</label></td>
            <td colspan="3">{$LOGO}</td>
        </tr>
        <tr>
            <td colspan="4">{$EMPRESASID}</td>
        </tr>
        <tr>
            <td><label>Registro Mercantil :</label></td>
            <td>{$REGMERCANTIL}</td>
            <td><label>Camara Comercio :</label></td>
            <td>{$CAMCOMERCIO}</td>
        </tr>
        <tr>
            <td><label>Escritura No. :</label></td>
            <td>{$ESCRITURA}</td>
            <td><label>Fecha : </label></td>
            <td>{$FECHA}</td>
        </tr>
        <tr>
            <td><label>Notaria :</label></td>
            <td colspan="3">{$NOTARIA}</td>
        </tr>
        {*
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4" align="center"><div style="width:130px"><label>RANGO RESOLUCI&Oacute;N</label></div></td>
        </tr>
        <tr>
            <td><label>Resoluci&oacute;n No. :</label></td>
            <td>{$RESOLUCION}</td>
            <td><label>Fecha :</label></td>
            <td>{$FECHARES}</td>
        </tr>
        <tr>
            <td><label>Inicio Rango :</label></td>
            <td>{$INICIO}</td>
            <td><label>Final Rango :</label></td>
            <td>{$FINAL}</td>
        </tr>
        <tr>
            <td><label>Inicio Disponible :</label></td>
            <td>{$DISPONIBLE}</td>
            <td><label>Saldo Disponible :</label></td>
            <td>{$SALDO}</td>
        </tr>
        *}
        <tr>
            <td><label>Estado : </label></td>
            <td>{$ESTADO}</td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
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
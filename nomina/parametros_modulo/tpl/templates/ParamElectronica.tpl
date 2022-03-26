<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
   <link rel="stylesheet" href="../../../framework/css/bootstrap1.css">
  {$JAVASCRIPT}
  
  {$CSSSYSTEM}
  
  {$TITLETAB}  
  </head>

  <body>
	<fieldset>
        <legend>{$TITLEFORM}</legend>

        <div id="table_find"><table><tr><td><label>Busqueda : </label></td><td>{$BUSQUEDA}</td></tr></table></div>
        
        {$FORM1}
        <fieldset class="section">
        <table align="center">
          <tr>
            <td><label>No.: </label></td><td>{$PARAMEID}</td>
            <td><label>Prefijo : </label></td><td>{$PREFIJO}</td>
          </tr>
          <tr>
            <td><label>URL o WSDL: </label></td><td>{$URL}</td>
            <td><label>URL2 o WSANEXO: </label></td><td>{$URLANEXO}</td>
          </tr>
          <tr>
            <td><label>URL Prueba o WSDL Prueba: </label></td><td>{$URLPRUEBA}</td>
            <td><label>URL2 Prueba o WSANEXO Prueba: </label></td><td>{$URLPRUEBAANEXO}</td>
          </tr>
          
          <tr>
            <td><label>Token Empresa: </label></td><td>{$TOKENEMPRESA}</td>
            <td><label>Token Autorizacion: </label></td><td>{$TOKENAUTORIZACION}</td>
          </tr>
          
          <tr>
            <td><label>Correo Empresarial: </label></td><td colspan="4">{$CORREO}</td>
          </tr>
          <tr>
            <td><label>Ambiente  : </label></td><td>{$AMBIENTE}</td>
            <td><label>Estado  : </label></td><td>{$ESTADO}</td>
          </tr>
          <tr>
            <td><label>Rango Comienza  : </label></td><td>{$RANGO_COMIENZA}</td>
          </tr>
          <tr>
            <td><label>Rango Inicial  : </label></td><td>{$RANGO_INICIAL}</td>
            <td><label>Rango Final  : </label></td><td>{$RANGO_FINAL}</td>
          </tr>
          <tr>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}{* &nbsp;{$BORRAR} *}&nbsp;{$LIMPIAR}</td>
          </tr>
         </table>
         </fieldset>
        {$FORM1END}
    </fieldset>
    
    <fieldset><button type="button" class="btn btn-warning btn-sm" id="mostrar_grid"  onclick="showTable()" style="float:right;">Mostrar tabla</button></fieldset>
    
  </body>
</html>

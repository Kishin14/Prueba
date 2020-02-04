<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
   <link rel="stylesheet" href="/application/framework/css/bootstrap1.css">
  {$JAVASCRIPT}
  {$TABLEGRIDJS}
  {$CSSSYSTEM}
  {$TABLEGRIDCSS}
  {$TITLETAB}  
  </head>

  <body>
	<fieldset>
        <legend>{$TITLEFORM}</legend>

        <div id="table_find"><table><tr><td><label>Busqueda : </label></td><td>{$BUSQUEDA}</td></tr></table></div>
        
        {$FORM1}
        {$CARGOID}
        <fieldset class="section">
        <table align="center">
          <tr>
            <td><label>Nombre : </label></td>
            <td>{$NOMBRE}</td>
          </tr>
          <tr>
            <td><label>Categoria ARL  : </label></td>
            <td>{$ARLID}</td>
          </tr>
          <tr>
            <td><label>Base  : </label></td>
            <td>{$BASE}</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
          </tr>
         </table>
        
          <table id="toolbar">
          <tbody><tr>
            <td id="messages"><div>&nbsp;</div></td>
            <td id="detailToolbar">
        <img src="../../../framework/media/images/grid/save.png" id="saveDetalles" title="Guardar Seleccionados">
        <img src="../../../framework/media/images/grid/no.gif" id="deleteDetalles" title="Borrar Seleccionados">
            </td>
            <td id="fileUpload">{$ARCHIVOSOLICITUD}</td>
          </tr>               
         </tbody>
     </table>    
     <div><iframe name="detalleCargo" id="detalleCargo" src="about:blank"></iframe></div>
     
        {$FORM1END}
    </fieldset>
    
    <fieldset>{$GRIDPARAMETROS}</fieldset>
    
  </body>
</html>

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
      
        <div class="container">
          <div class="row">
              <div class="col-sm-6">
                  <tr>
                    <td><label>Busqueda liquidacion por documento: </label></td>
                  </tr>
                  <tr>
                    <td>{$BUSQUEDA}</td>
                  </tr>
              </div>
              <div class="col-sm-6">
                  <tr>
                    <td><label>Busqueda liquidacion por fecha: </label></td>
                  </tr>
                  <tr>
                    <td>{$BUSQUEDA1}</td>
                  </tr>
              </div>
          </div>
        </div>
    
        </div>
        
        {$FORM1}
        {$NOVEDADID}
        <fieldset class="section">
        <table align="center">
          <tr>
            
             <td><label>Empleados ?  : </label></td>
            <td>{$SIEMPLEADO}</td>
            <td><label>Fecha  : </label></td>
            <td>{$FECHALIQ}<a href="javascript:void(0);" title="Presiona aqui para saber acerca de este campo."  name="myBtn"><img src="../../../framework/media/images/modulos/manual.png" width="16" height="18" onclick="alert_unico(this,'Informaci&oacute;n','En este campos indicaremos al sistema la fecha en que se pagará la prima teniendo en cuenta que si la prima tiene un tipo de liquidación TOTAL SEMESTRE, segun el articulo 306 del codigo sustantivo del trabajo la prima se debe pagar para el primer semestre el 30 de junio, y para el segundo semestre se debe pagar en los primeros 20 dias del mes de diciembre.')"/></a></td>
          	 <td ><label>Liquidacion N°  : </label></td>
            <td >{$CONSECUTIVO}{$LIQUIDACIONPRIMAID}</td>
          </tr>
          <tr>
            <td><label>Empleado  : </label></td>
            <td>{$EMPLEADO}{$EMPLEADOID}</td>
            <td><label>Num Identificacion  : </label></td>
            <td>{$IDENTIFICACION}</td>
            <td><label>Cargo  : </label></td>
            <td>{$CARGO}</td>
          </tr>
          
          <tr>
            <td><label>Salario Base  : </label></td>
            <td>{$SALARIO}</td>
            <td><label>Fecha Inicio Contrato  : </label></td>
            <td>{$FECHAINICONT}</td>
            <td><label>Estado  : </label></td>
            <td>{$ESTADO}</td>
          </tr>

          <tr>
          <td colspan="6">
           	<fieldset class="section">
            <legend>LIQUIDACION</legend>
            	<table align="center">
            <tr>
            <td ><label>Tipo Liquidacion :</label></td>
            <td >{$TIPOLIQUIDACION}&nbsp;<a href="javascript:void(0);" title="Presiona aqui para saber acerca de este campo."  name="myBtn"><img src="../../../framework/media/images/modulos/manual.png" width="16" height="18" onclick="alert_unico(this,'Informaci&oacute;n','TOTAL SEMESTRE: cuando seleccionamos este tipo de liquidación, estamos indicandole al sistema que debe liquidar la prima por los 6 meses que le corresponden al empleado.  PARCIAL SEMESTRE: Cuando seleccionamos este tipo de liquidación le estamos indicando al sistema que debe liquidar la prima con un rango de tiempo menor a los 6 meses, segun se necesite.')"/></a></td>
            
            
          </tr>
         <!-- <tr>
            <td><label>Fecha inicio : </label></td>
            <td>{$FECHAINI}</td>
            <td><label>Fecha final : </label></td>
            <td>{$FECHAFIN}</td>
            <td><label>Fecha reintegro : </label></td>
            <td>{$FECHAREINTEGRO}</td>
          </tr>-->
          <tr>
           
            <td><label>Observacion  : </label></td>
            <td>{$OBSERVACION}</td>
            
            <td><label>Periodo  : </label></td>
            <td>{$PERIODO}</td>
            
          </table> 
          </fieldset> 
          </tr>       
          <tr id="divConta">
          <td colspan="6">
           	<fieldset class="section">
            <legend>CONTABILIZACIÓN</legend>
            	<table align="center">  
              <tr>
              
                <td><label>Valor Liquidacion : </label></td>
                <td>{$VALORLIQUIDACION}{$VALORLIQUIDACIONPARCIAL}</td>
                
                <td><label>Valor Acumulado  : </label></td>
                <td>{$VALORACUMULADO}<a href="javascript:void(0);" title="Presiona aqui para saber acerca de este campo."  name="myBtn"><img src="../../../framework/media/images/modulos/manual.png" width="16" height="18" onclick="alert_unico(this,'Informaci&oacute;n','Este campo es informativo, indicandonos el valor de la prima que ya le han pagado en el respectivo periodo al empleado.')"/></a></td>

                <td><label>Valor Diferencia :</label></td>
                <td>{$VALORDIFERENCIA}<a href="javascript:void(0);" title="Presiona aqui para saber acerca de este campo."  name="myBtn"><img src="../../../framework/media/images/modulos/manual.png" width="16" height="18" onclick="alert_unico(this,'Informaci&oacute;n','Este campo es informativo, indicandonos el valor de la prima que hace falta para completar el pago completo de la prima en el respetivo periodo.')"/></a></td>
                
                
              </tr>
              </table>
            </fieldset>
          </td>
          </tr>
      <table width="100%">
          <tr>
             <td colspan="8" align="center">{$GUARDAR}&nbsp;{$IMPRIMIR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}&nbsp;{$CONTABILIZAR}</td></tr>
     
         <tr><td colspan="8"><iframe id="detallePrima" frameborder="0" marginheight="0" marginwidth="0"></iframe></td></tr>
         <tr>

           

            <td align="center"><b>Ctrl+t = Tercero Ctrl+c=Concepto</b></td>

            <td align="right" width="60%">

            <table>

              <tr>

                <td><label>DEBITO :</label></td>

                <td><span id="totalDebito">0</span></td>

                <td><label>CREDITO:</label></td>

                <td><span id="totalCredito">0</span></td>

                <td><label>DIFERENCIA:</label></td>

                <td><span id="totalDiferencia">0</span></td>                

              </tr>

            </table></td>

          </tr>

     </table>
        {$FORM1END}
        <div id="rangoImp" style="display:none;">
      <div align="center">
	    <p align="center">
		  <table>
		    <tr>
			  <td><b>Tipo:&nbsp;</b></td><td>{$TIPOIMPRE}</td>
             </tr>
             <tr>
               <td><b># Desprendibles:&nbsp;</b></td><td>{$DESPRENDIBLES}&nbsp;&nbsp;&nbsp;</td>
			 </tr>
			 <tr><td colspan="2">&nbsp;</td></tr>
			 <tr>
			   <td align="center" colspan="2">{$PRINTCANCEL}{$PRINTOUT}</td>
			 </tr>
		  </table>
		</p>
	  </div>
	</div>    
    <!--INICIO Cuadro de informacion-->
    <div id="MyModal" class="modal">
    
        <!-- Modal content -->
        <div class="modal-content" style="width:70%;">
            <span class="close">&times;</span>
            <h3 id="h5" align="center"> </h3>
            <h4 align="center"><img src="../../../framework/media/images/alerts/info.png" /></h4>
            <p id="p" align="center"></p>
        </div>
    
    </div>
    <!--FIN Cuadro de informacion-->
</fieldset>
    
    <fieldset>{$GRIDPARAMETROS}</fieldset>
    
  </body>
</html>

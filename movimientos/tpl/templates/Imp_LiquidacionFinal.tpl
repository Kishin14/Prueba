<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />   
        <link type="text/css" rel="stylesheet" href="/application/framework/css/printer.css" /> 
        <link type="text/css" rel="stylesheet" href="/application/framework/css/printer.css" /> 
        <script language="javascript" type="text/javascript" src="/application/framework/js/printer.js"></script>
        <title>Impresion Liquidaci&oacute;n</title>
    </head>

    <body leftmargin="auto">
      <div align="center">
      {if $TIPOIMPRE neq 'C'} <!-- consolidado y desprendibles -->
      	  {assign var="totaldebito" value="0"}
          {assign var="totalcredito" value="0"}
	      {foreach name=liquidacion_novedad from=$DETALLES item=d}
          	  <div style="page-break-after:always; margin-top:50px;">
              <table class="cellTotal" border="0" cellspacing="0" width="95%" >
              	<tr >
                	<td colspan="4" style="border-bottom:#000 1px solid;">
                      <table  border="0" cellspacing="0" width="100%"> 
                        <tr>
                            <th align="left" valign="top"><img src="{$LOGO}?123" width="280" height="100" /></th><th align="center">&nbsp;{$NOMBREEMPRESA}<br>{$NITEMPRESA}<br><br> LIQUIDACION FINAL PRESTACIONES SOCIALES</th><th width="10%">&nbsp;</th>
                        </tr>
                      </table><br />
                    </td>
                </tr>
                <tr><td><strong>TIPO DE CONTRATO:</strong> </td><td>{$d.tipo_contrato}</td><td colspan="2">&nbsp;</td></tr>
			  	<tr><td><strong>EMPLEADO:</strong> </td><td>{$d.empleado}</td><td><strong>DOCUMENTO No:</strong></td><td>{$d.identificacion}</td></tr>
                <tr><td><strong>CARGO:</strong></td><td>{$d.cargo}</td><td><strong>CAUSA DE TERMINACION:</strong></td><td>{$d.motivo_terminacion}</td></tr>  
                <tr><td><strong>FECHA INGRESO:</strong></td><td>{$d.fecha_inicio}</td><td><strong>FECHA TERMINACION:</strong></td><td>{$d.fecha_final}</td></tr>     
                <tr><td><strong>DIAS LABORADOS:</strong></td><td>{$d.dias}</td><td>&nbsp;</td><td>&nbsp;</td></tr>      
                <tr><td><strong>SUELDO BASICO:</strong></td><td align="left">${$d.sueldo_base|number_format:0:',':'.'}</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                <tr><td><strong>AUXILIO TRANSPORTE:</strong></td><td align="left">${$d.subsidio_transporte|number_format:0:',':'.'}</td><td>&nbsp;</td><td>&nbsp;</td></tr>                                
				<tr><td><strong>BASE LIQUIDACION:</strong></td><td align="left">${$d.salario_base|number_format:0:',':'.'}</td><td>&nbsp;</td><td>&nbsp;</td></tr>                                                
              	<tr>
                	<td colspan="4"><br />
                          <table  width="100%" border="1" cellpadding="0" cellspacing="0">
                           <thead>
                            <tr>
                             <th >CONCEPTO</th>          
                             <th>PERIODO</th>               
                             <th>DIAS</th>       
                             <th>VALOR</th>               
                             <th>OBSERVACION</th>                                         
                            </tr>
                            </thead>
                            
                            {foreach name=detalle_liquidacion_novedad from=$DETALLESLIQ item=i}
                                {if $i.titulo neq ''}
                                     <thead>
                                        <tr>
                                            <th colspan="3" align="left">{$i.titulo}</th>
                                            <th align="right">${$i.valor|number_format:0:',':'.'}</th>
                                            <th colspan="3" align="right">&nbsp;</th>
                                        </tr>
                                    </thead>
                                {else}
                                    <tbody>
                                        <tr>
                                         <td>{$i.concepto}</td>
                                         <td>{$i.periodo}</td>
                                         <td>{$i.dias}</td>
                                         <td align="right">${$i.valor|number_format:0:',':'.'}</td>    
                                         <td>{$i.observacion}</td>
                                        </tr>
                                    </tbody>
                                {/if}   
                            {/foreach}
                          </table>
                    </td>
                </tr>
                <tr>
                	<td colspan="5"><br /><br /><br /><br /><br /><br />
                    	<table width="99%" border="0" cellpadding="0" cellspacing="0">
                        	<tr>
                            	<td> _____________________________<br>ELABORO<br></td>
                                <td> _____________________________<br>APROBO<br></td>
                                <td> _____________________________<br>RECIBIO  C.C.<br></td>
                            </tr>
                        
                        </table><br /><br />
                    </td>
                </tr>
                
              </table><br>    
              </div>      
          {/foreach}
          
      
      {/if}
      </div>
    </body>                            
</html>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

  <html>
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
    {$JAVASCRIPT}
    {$CSSSYSTEM}
  </head>

  <body> 
  <input type="hidden" id="estado_id" value="{$estado_id}" />
  
  <table width="90%" align="center" id="encabezado" border="0">
  	<tr><td width="30%">&nbsp;</td>
  	<tr><td align="center" colspan="3"> Rango Inicial : {$desde}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rango Final: {$hasta}</td></tr>	
  </table>
       
     {assign var="saldo" value=0} {assign var="descuentos" value=0} {assign var="descuentos1" value=0} {assign var="descuentos2" value=0}
     {assign var="descuentos3" value=0} {assign var="descuentos4" value=0} {assign var="saldo_a_pagar" value=0} {assign var="saldo_pagar" value=0}
     {assign var="papeleria" value=0} {assign var="averias" value=0} {assign var="noreportes" value=0} {assign var="mora" value=0}
     {assign var="utilidad" value=0} {assign var="porcutilidad" value=0}    
        
          <table align="center" id="encabezado" width="90%"> 
          {* <tr>
          	<th class="borderLeft borderTop borderRight" colspan="7" align="centre">DATOS DESPACHO</th>
            <th class="borderLeft borderTop borderRight" colspan="8" align="centre">DATOS FLETE</th>  
            <th class="borderLeft borderTop borderRight" colspan="11" align="centre">LIQUIDACION FLETE</th>   
            <th class="borderLeft borderTop borderRight" colspan="2" align="centre">PAGO FLETE</th>  
            <th class="borderLeft borderTop borderRight" colspan="7" align="centre">FACTURA FLETE</th> 
            <th class="borderLeft borderTop borderRight" colspan="2" align="centre">RENTABILIDAD FLETE</th>                                                  
            <tr>
            	<th class="borderLeft borderRight borderBottom" colspan="7" align="centre">&nbsp;</th>
            	<th class="borderLeft borderTop borderRight borderBottom" colspan="1" align="centre">&nbsp;</th>            
              <th class="borderLeft borderTop borderRight borderBottom" colspan="2" align="centre">ANTICIPO 1</th> 
              <th class="borderLeft borderTop borderRight borderBottom" colspan="2" align="centre">ANTICIPO 2</th>  
            	<th class="borderLeft borderTop borderRight borderBottom" colspan="3" align="centre">&nbsp;</th> 
            	<th class="borderLeft borderRight borderBottom" colspan="11" align="centre">&nbsp;</th> 
            	<th class="borderLeft borderRight borderBottom" colspan="2" align="centre">&nbsp;</th>
            	<th class="borderLeft borderRight borderBottom" colspan="7" align="centre">&nbsp;</th> 
            	<th class="borderLeft borderRight borderBottom" colspan="2" align="centre">&nbsp;</th>
            </tr>          
          </tr>  *}          
          <tr>
            <th class="borderLeft borderTop borderRight borderBottom" align="center"> Nro. DESPACHO </th>
            <th class="borderTop borderRight borderBottom" align="center"> FECHA </th>
            <th class="borderTop borderRight borderBottom" align="center"> Nro. REMESA </th>
            <th class="borderTop borderRight borderBottom" align="center"> ORIGEN </th>
            <th class="borderTop borderRight borderBottom" align="center"> DESTINO </th>
            <th class="borderTop borderRight borderBottom" align="center"> PLACA VEHICULO </th>
            <th class="borderTop borderRight borderBottom" align="center"> TENEDOR </th>
            
            <th class="borderTop borderRight borderBottom" align="center">FLETE PACTADO</th>
            <th class="borderTop borderRight borderBottom" align="center">VALOR</th>
            <th class="borderTop borderRight borderBottom" align="center">Nro. EGRESO</th>
            <th class="borderTop borderRight borderBottom" align="center">VALOR</th>		           
            <th class="borderTop borderRight borderBottom" align="center">Nro. EGRESO</th>
            <th class="borderTop borderRight borderBottom" align="center">VALOR. RETEFUENTE</th>
            <th class="borderTop borderRight borderBottom" align="center">VALOR. ICA</th>
            <th class="borderTop borderRight borderBottom" align="center">SALDO POR PAGAR</th>                                                        
          </tr> 
        
     {counter start=0 skip=1 direction=up assign=i}  
                         
         {foreach name=detalles from=$DETALLESTRAZABILIDAD item=r}  
         
           {if $sobreflete eq NULL} {assign var="sobreflete" value=0} {/if} 
           {if $sobreflete ne NULL} {assign var="sobreflete" value=$r.sobreflete} {/if}         
           {if $r.dto_papeleria eq NULL} {assign var="papeleria" value=0} {/if}
           {if $r.dto_papeleria ne NULL} {assign var="papeleria" value=$r.dto_papeleria} {/if}  
           {if $r.dto_seguro eq NULL} {assign var="seguro" value=0} {/if}
           {if $r.dto_seguro ne NULL} {assign var="seguro" value=$r.dto_seguro} {/if}   
           {if $r.dto_averias eq NULL} {assign var="averias" value=0} {/if}
           {if $r.dto_averias ne NULL} {assign var="averias" value=$r.dto_averias} {/if}     
           {if $r.dto_noreportes eq NULL} {assign var="noreportes" value=0}  {/if}
           {if $r.dto_noreportes ne NULL} {assign var="noreportes" value=$r.dto_noreportes} {/if} 
           {if $r.dto_mora eq NULL} {assign var="mora" value=0} {/if}
           {if $r.dto_mora ne NULL} {assign var="mora" value=$r.dto_mora} {/if} 
           
           
           {if $r.numeroegreso eq NULL} {assign var="nroegreso" value="N/A"} {/if} 
           {if $r.numeroegreso ne NULL} {assign var="nroegreso" value=$r.numeroegreso} {/if} 

           {assign var="saldo_pagar" value=$r.saldo_pagar}           
           
    		 {math assign="descuentos1" equation="(C+D)" C=$papeleria D=$seguro} 
    		 {math assign="descuentos2" equation="(E+F)" E=$averias F=$noreportes} 
             {math assign="descuentos3" equation="(M+N)" M=$descuentos1 N=$descuentos2}
             {math assign="descuentos4" equation="(O+G)" O=$descuentos3 G=$mora}                   
    		 {math assign="saldo" equation="(A+B)"  A=$sobreflete B=$saldo_pagar}
    		 {math assign="saldo_a_pagar" equation="(X-Y)" X=$saldo Y=$descuentos4}
             {math assign="utilidad" equation="(X-Y)" X=$r.valfactura Y=$r.valor_flete} 
             {math assign="porcutilidad" equation="(X/Y)*100" X=$utilidad Y=$r.valfactura}
                 		
          <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">                    
            <td class="borderLeft borderTop borderRight borderBottom" align="center"> {$r.orden_despacho} </td>  
            <td class="borderTop borderRight borderBottom" align="center"> {$r.fecha} </td>  
            <td class="borderTop borderRight borderBottom" align="center"> {$r.numero_remesa} </td> 
            <td class="borderTop borderRight borderBottom" align="center"> {$r.origen} </td>  
            <td class="borderTop borderRight borderBottom" align="center"> {$r.destino} </td> 
            <td class="borderTop borderRight borderBottom" align="center"> {$r.placa} </td> 
            <td class="borderTop borderRight borderBottom"> {$r.tenedor} </td>                   
            
            <td class="borderLeft borderTop borderRight borderBottom" align="center"> ${$r.valor_flete|number_format:0:',':'.'} </td>  
            <td class="borderTop borderRight borderBottom" align="center"> ${$r.anticipo|number_format:0:',':'.'} </td>  
            <td class="borderTop borderRight borderBottom" align="center"> {$r.numegreso} </td>  
            <td class="borderTop borderRight borderBottom" align="center"> $ 0 </td>   
            <td class="borderTop borderRight borderBottom" align="center"> - </td>  
            <td class="borderTop borderRight borderBottom" align="center"> ${$r.retefuente|number_format:0:',':'.'} </td> 
            <td class="borderTop borderRight borderBottom" align="center"> $ 0 </td> 
            <td class="borderTop borderRight borderBottom" align="center"> ${$r.saldo_pagar|number_format:0:',':'.'} </td>             
            
            <td class="borderTop borderRight borderBottom" align="center"> ${$sobreflete|number_format:0:',':'.'} </td> 
            <td class="borderTop borderRight borderBottom" align="center"> ${$r.dto_papeleria|number_format:0:',':'.'} </td> 
            <td class="borderTop borderRight borderBottom" align="center"> ${$r.dto_seguro|number_format:0:',':'.'} </td>  
            <td class="borderTop borderRight borderBottom" align="center"> $ 0 </td>   
            <td class="borderTop borderRight borderBottom" align="center"> ${$r.dto_averias|number_format:0:',':'.'} </td> 
            <td class="borderTop borderRight borderBottom" align="center"> ${$r.dto_noreportes|number_format:0:',':'.'} </td> 
            <td class="borderTop borderRight borderBottom" align="center"> ${$r.dto_mora|number_format:0:',':'.'} </td>  
            <td class="borderTop borderRight borderBottom" align="center"> $ - </td>   
            <td class="borderTop borderRight borderBottom" align="center"> $ - </td> 
            <td class="borderTop borderRight borderBottom" align="center">{$ordenes_compra} </td>   
            <td class="borderTop borderRight borderBottom" align="center"> ${$valor_ordenes_compra|number_format:0:',':'.'} </td> 
            
            
            <td class="borderTop borderRight borderBottom" align="center"> ${$saldo_a_pagar|number_format:0:',':'.'} </td>   
            <td class="borderTop borderRight borderBottom" align="center"> {$nroegreso} </td> 
            
            <td class="borderTop borderRight borderBottom" align="center"> {$r.numfactura} </td>   
            <td class="borderTop borderRight borderBottom" align="center"> {$r.fecfactura} </td>  
            <td class="borderTop borderRight borderBottom" align="center"> ${$r.valfactura|number_format:0:',':'.'} </td> 
            <td class="borderTop borderRight borderBottom" align="center"> {$r.cliente} </td>   
            <td class="borderTop borderRight borderBottom" align="center"> {$r.numabonofac} </td>  
            <td class="borderTop borderRight borderBottom" align="center"> {$r.fecabonofac} </td>   
            <td class="borderTop borderRight borderBottom" align="center"> ${$r.valabonofac|number_format:0:',':'.'} </td>  
            
            <td class="borderTop borderRight borderBottom" align="center"> ${$utilidad|number_format:0:',':'.'} </td>   
            <td class="borderTop borderRight borderBottom" align="center"> %{$porcutilidad|number_format:2:',':'.'} </td>                                                                                                
          </tr>  
          
          {counter}{/foreach}
                                                
  </table>
  </body>
</html>
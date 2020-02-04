<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  {$CSSSYSTEM}
  </head>

  <body>
  <table id="tableRegistrar" width="99%">
   <thead>
    <tr>
     <th>CODIGO PUC</th>
     <th>CONCEPTO</th>          
     <th>DEBITO</th>               
     <th>CREDITO</th>          
     <th>DIAS</th>         	 
     <th>OBSERVACION</th>                                         
	 <th>&nbsp;</th>                              
     <th><input type="checkbox" id="checkedAll"></th>     
    </tr>
    </thead>
    
    <tbody>

    {foreach name=detalle_liquidacion_novedad from=$DETALLES item=d}
    <tr>
	 <td > <input type="text" autocomplete="off" name="puc" id="puc" value="{$d.puc}" class="required" size="10" />
	   <input type="hidden" autocomplete="off" name="puc_id" id="puc_id" value="{$d.puc_id}" class="required" /></td>
       <input type="hidden" name="detalle_liquidacion_provision_id" id="detalle_liquidacion_provision_id" value="{$d.detalle_liquidacion_provision_id}">            
       
     <td><input type="text" autocomplete="off" name="concepto" id="concepto" value="{$d.concepto}" size="30" class="required" readonly /></td>
     <td><input type="text" autocomplete="off" name="debito" id="debito" value="{$d.debito}" class="required numeric" readonly /></td>          
     <td><input type="text" autocomplete="off" name="credito" id="credito" value="{$d.credito}" class="required numeric" readonly /> </td>
	 <td><input type="text" autocomplete="off" name="dias" id="dias" value="{$d.dias}" class="required" readonly /></td>
     <td><input type="text" autocomplete="off" name="observacion" id="observacion" value="{$d.observacion}"  /></td>
     <td>{if $d.estado eq 'E'}<a name="saveDetalleSoliServi"><img src="../../../framework/media/images/grid/save.png" /></a>{else}&nbsp; {/if}</td>
     <td>{if $d.estado eq 'E'}<input type="checkbox" name="procesar" />{else}&nbsp; {/if}</td>     
    </tr>   
    {/foreach}
   </tbody>
  </table>
  </body>
</html>
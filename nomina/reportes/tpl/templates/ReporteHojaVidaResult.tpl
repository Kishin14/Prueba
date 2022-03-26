{literal}
<style>
/* CSS Document */

   .tipoDocumento{
    font-family:Arial, Helvetica, sans-serif;
	font-size:10px;
	font-weight:bold;
	text-align:center
   }
   
   .numeroDocumento{
     font-family:Arial, Helvetica, sans-serif;
	 font-size:18px;
	 font-weight:bold;
	 text-align:center;
   }
   
   .subtitulos{
     font-family:Arial, Helvetica, sans-serif;
	 font-size:12px;
	 font-weight:bold;
   }
   
   .contenido{
     font-family:Arial, Helvetica, sans-serif;
	 font-size:12px;
   }

   .borderTop{
     border-top:1px solid;
   }

   table tr td{
      font-size:12px;
   }
     
   .title{
     background-color:#EAEAEA;
	 font-weight:bold;
	 text-align:center;
   }
   
   .fontBig{
     font-size:10px;
   }
   
   .infoGeneral{
	 border-left:1px solid;   
	 border-right:1px solid;   	 
	 border-bottom:1px solid;   	 	 
	 text-align:center;
   }
   
   .cellTitle{
     background-color:#E6E6E6;
	 font-weight:bold;
	 border-left:1px solid;   
	 border-right:1px solid;   	 
	 border-bottom:1px solid;   	 	 
   }

   .cellTitles{
     background-color:#E6E6E6;
   font-weight:bold;
   border-left:1px solid;   
   border-right:1px solid;     
   border-bottom:1px solid; 
   border-top:1px solid;        
   }
   
   .cellRight{
     border-right:1px solid;
	 border-bottom:1px solid;
 	 padding: 3px;
	 
   }
   .cellRightRed{
   	 border-left:1px solid;
     border-right:1px solid;
	 border-bottom:1px solid;	
 	 padding: 3px;
	 color:#F00;
	 
   }
   
   .cellLeft{
     border-left:1px solid;
     border-right:1px solid;
	 border-bottom:1px solid;
	 padding: 3px;
   }

   .cellCenter{
     border-left:1px solid;
     border-right:1px solid;
	 border-bottom:1px solid;
   }

   .cellTitleLeft{
     border-left:1px solid;
     border-right:1px solid;
	 border-bottom:1px solid; 
	 border-top:1px solid;
     background-color:#E6E6E6;
	 font-weight:bold;
   }   
   
   .cellTitleRight{
     border-right:1px solid;
	 border-bottom:1px solid;   
	 border-top:1px solid;	 
     background-color:#E6E6E6;
	 font-weight:bold;
   }
   
   body{
    padding:0px;
   }
   
   .content{
    font-weight:bold;
	font-size:12px;
	text-transform:uppercase;
   }

   .table_firmas{
    font-weight:bold;
	font-size:14px;
	margin-top:1px;
   }

   .anulado{
	   width:500px;
	   margin-top:180px;
	   margin-left:230px;
	   position:absolute;
	   font-weight:bold;
	   color:#FBCDBF;
	   font-size:60px;
	   opacity:0.1;
	   filter:alpha(opacity=40);
   }

   .anulado1{
	   width:500px;
	   margin-top:400px;
	   margin-left:230px;
	   position:absolute;
	   font-weight:bold;
	   color:#FBCDBF;
	   font-size:60px;
	   opacity:0.1;
	   filter:alpha(opacity=40);
   }
   .realizado{
	   width:500px;
	   margin-top:180px;
	   margin-left:230px;
	   position:absolute;
	   font-weight:bold;
	   color:#A0F5AB;
	   font-size:60px;
	   opacity:0.1;
	   filter:alpha(opacity=40);
   }

   .realizado1{
	   width:500px;
	   margin-top:400px;
	   margin-left:230px;
	   position:absolute;
	   font-weight:bold;
	   color:#A0F5AB;
	   font-size:60px;
	   opacity:0.1;
	   filter:alpha(opacity=40);
   }
   .normal{
	   height:30px;
   }



</style>
{/literal}
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  {$JAVASCRIPT}
  <link rel="stylesheet" href="../../../framework/css/bootstrap.css">
  <link rel="stylesheet" href="../../../framework/css/animate.css">
</head>

	
<page orientation="portrait" >
    <!--{foreach name=remesas from=$REMESAS item=i}
      {/foreach}-->
  {assign var="contador" value="1"}
  {if $REMESAS eq ''}
  <div class="container-fluid">
    <div class="row animated zoomIn">
      <div class="col-sm"></div>
      <div class="col-sm-10">
        <div style="margin: 10% auto;width: 80%; border: #ebccd1 solid;border-radius: 0.5em;">
          <div class="panel-heading" style="color:#b94a48;background-color:#f2dede;border-radius: 0.5em;">
            <h3 class="panel-title">¡ATENCI&Oacute;N!</h3>
          </div>
          <div class="panel-body">
            <h6 style="font-weight: bold; color: black; text-align: center;">ESTA PERSONA NO CUENTA CON UN CONTRATO REALIZADO, POR FAVOR VERIFIQUE CON OTRO TERCERO.</h6>
          </div>
        </div>
      </div>
      <div class="col-sm"></div>
    </div>
  </div>
  {else}
  {foreach name=remesas from=$REMESAS item=i} 

  <div class="container-fluid">
    <div class="row animated zoomIn">
      <div class="col-sm"></div>
      <div class="col-sm-10">
        <!--Tabla de datos de contrato inicio-->
        <table class="table table-sm">
        <br>
        <thead class="thead">
          <th  style="border: none;"><div class="animated flash"><img src="{$i.logo}" width="140" height="50" /></div></th>
          <th style="border: none;"><b>CONTRATO DE NOMINA</b><br><b>DATOS CONTRATO # {$i.numero_contrato}</b></th>
          <th style="border: none;">
            <table class="table table-bordered">
              <tr>
                <td align="center" style="background-color: #f5f5f5;" valign="top">C&Oacute;DIGO: FC - FI01</td>
              </tr>
              <tr>
                <td align="center" style="background-color: #f5f5f5;" valign="top">VERSI&Oacute;N: 01</td>
              </tr>
              <tr>
                <td align="center" style="background-color: #f5f5f5;" valign="top">P&Aacute;GINA: 1 de 1</td>
              </tr>
            </table>
          </th>
        </thead>
        <tbody style="width: 100%;">
          <tr>
            <table align="center" width="100%" cellpadding="0" cellspacing="0" 
              class="table table-striped table-hover table-sm table-bordered">
              <tr>
                <td width="30%"><b>Contrato No. </b></td>
                <td colspan="2"  width="70%">{$i.prefijo}</td>
              </tr>
              <tr>
                <td width="30%"><b>Colaborador</b></td>
                <td width="40%">{$i.empleado}</td>
                <td width="30%"><b>CC/NIT: </b>&nbsp;{$i.cedula_empleado|number_format:0:',':'.'}</td>
              </tr>
              <tr>
                <td width="30%"><b>Lugar Expedic&oacute;n Doc. </b></td>
                <td width="40%">{$i.lugar_expedicion_doc}</td>
                <td width="30%"><b>Lugar de Trabajo: </b>&nbsp;{$i.lugar_trabajo}</td>
              </tr>
              <tr>
                <td width="30%"><b>Inicio de Contrato </b></td>
                <td colspan="2" width="70%">{$i.fecha_inicio}</td>
              </tr>
              <tr>
                <td width="30%"><b>Fecha Terminaci&oacute;n Contrato </b></td>
                <td colspan="2" width="70%">{$i.fecha_terminacion}</td>
              </tr>
              <tr>
                <td width="30%"><b>Tipo Contrato</b></td>
                <td width="40%">{$i.tipo_contrato}</td>
                <td width="30%"><b>Descripci&oacute;n: </b>&nbsp;{$i.descripcion_contrato}</td>
              </tr>
              <tr>
                <td width="30%"><b>Cargo</b></td>
                <td colspan="2" width="70%">{$i.cargo}</td>
              </tr>
              <tr>
                <td width="30%"><b>Sueldo Base</b></td>
                <td width="40%">${$i.sueldo_base|number_format:0:',':'.'}</td>
                <td width="30%"><b>Subsidio Transporte: </b>&nbsp;${$i.subsidio_transporte|number_format:0:',':'.'}</td>
              </tr>
              <tr>
                <td width="30%"><b>Ingreso no Salarial</b></td>
                <td colspan="2" width="70%">$ {$i.total|number_format:0:',':'.'}</td>
              </tr>
              <tr>
                <td width="30%"><b>Centro de Costo</b></td>
                <td width="40%">{$i.centro_costo}</td>
                <td width="30%"><b>Categoria ARL: </b>&nbsp;{$i.categoria_arl}</td>
              </tr>
              <tr>
                <td width="30%"><b>Periodicidad</b></td>
                <td width="40%">{$i.periocidad}</td>
                <td width="30%"><b>Area: </b>&nbsp;{$i.area}</td>
              </tr>
              <tr>
                <td width="30%"><b>ESTADO CONTRATO</b></td>
                <td colspan="2" width="70%">{$i.estado}</td>
              </tr>
            </table>
          </tr>
        </tbody>
        </table>
        <!--Tabla de datos de contrato fin-->
        <!-- Tabla de Documentos Anexados Inicio -->
        <table class="table table-striped table-hover table-sm table-bordered" style="width: 100%;">
          <thead class="thead">
            <th style="text-align: center;" colspan="5"><b>DOCUMENTOS ANEXOS</b></th>
          </thead>
          <!-- EPS -->
          <thead>
            <th style="text-align: center;" colspan="5">Documentos Prestaciones</th>
          </thead>
          <tbody>
            <tr>
              <td width="20%"><b>Eps </b>&nbsp;{$i.escaner_eps}</td>
              <td width="20%"><b>Pensi&oacute;n </b>&nbsp;{$i.escaner_pension}</td>
              <td width="20%"><b>Arl </b>&nbsp;{$i.escaner_arl}</td>
              <td width="20%"><b>Caja Compensaci&oacute;n </b>&nbsp;{$i.escaner_caja}</td>
              <td width="20%"><b>Cesant&iacute;as </b>&nbsp;{$i.escaner_cesan}</td>
            </tr>
            <thead>
              <th style="text-align: center;" colspan="5">Documentos Contrato</th>
            </thead>
            <tr>
              <td width="20%"><b>Ex&aacute;men M&eacute;dico </b>&nbsp;{$i.examen_medico}</td>
              <td width="20%"><b>Salud Ocupacional </b>&nbsp;{$i.salud_ocupacional}</td>
              <td width="20%"><b>Ex&aacute;men Peri&oacute;dico </b>&nbsp;{$i.examen_periodico}</td>
              <td width="20%"><b>Ex&aacute;men Egreso </b>&nbsp;{$i.examen_egreso}</td>
              <td width="20%"><b>Cartas CyC </b>&nbsp;{$i.cartas_cyc}</td>
            </tr>
            <tr>
              <td width="20%"><b>Entrega Dotaci&oacute;n </b>&nbsp;{$i.entrega_dotacion}</td>
              <td width="20%"><b>Contrato Firmado </b>&nbsp;{$i.contrato_firmado}</td>
              <td width="20%"><b>Foto </b>&nbsp;{$i.foto}</td>
              <td width="20%"><b>Incapacidades </b>&nbsp;{$i.incapacidades}</td>
              <td width="20%"><b>Paz y Salvo </b>&nbsp;{$i.paz_salvo}</td>
            </tr>
            <tr>
              <td width="20%"><b>Certificado de Procuradur&iacute;a </b>&nbsp;{$i.certi_procu}</td>
              <td width="20%"><b>Certificado de Antecedentes </b>&nbsp;{$i.certi_antece}</td>
              <td width="20%"><b>Certificado de Contralor&iacute;a </b>&nbsp;{$i.certi_contralo}</td>
              <td width="20%"><b>Liquidaci&oacute;n </b>&nbsp;{$i.certi_liquidacion}</td>
              <td width="20%"><b>Certificado Laboral </b>&nbsp;{$i.certi_laboral}</td>
            </tr>
          </tbody>
        </table>
        <!-- Tabla de Documentos Anexados Fin -->
        <!--Tabla de terminacion de contrato inicio-->
        <table class="table table-sm table-bordered">
          <thead class="thead">
            <th style="text-align: center;" colspan="3"><b>TERMINACION DE CONTRATO</b></th>
          </thead>
          <tbody>
            {if $i.motivo_terminacion_id neq NULL}
                <tr>
                  <td width="30%"><b>Fecha Terminaci&oacute;n Real </b></td>
                  <td width="40%">{$i.fecha_terminacion_real}</td>
                  <td width="30%"><b>Motivo Terminaci&oacute;n </b>&nbsp;{$i.motivo_terminacion_id}</td>
                </tr>
                <tr>
                  <td width="30%"><b>Causal Despido </b></td>
                  <td colspan="2" width="70%">{$i.causal_despido_id}</td>
                </tr>
              
              {else}
                <tr>
                  <td colspan="3"><div class="animated bounceIn" style="text-align: center; font-size: 1.0rem;">¡No se ha finalizado este contrato a&uacute;n!</div></td>
                </tr>
              {/if}
              </tbody>
              </table>
        <!--Tabla de terminacion de contrato fin-->
        <!--Tabla de cambio prestaciones inicio-->
        <table class="table table-striped table-hover table-sm table-bordered" style="width: 100%;">
          <thead class="thead">
            <th style="text-align: center;" colspan="3"><b>ACTUALIZACION EMPRESAS PRESTACIONES</b></th>
          </thead>
          <!-- EPS -->
          <thead>
            <th style="text-align: center;" colspan="3">Entidades Prestadoras de Salud</th>
          </thead>
          {if $i.empresa_eps eq ''}
          <tr>
            <td colspan="3"><div class="animated bounceIn" style="text-align: center; font-size: 1.0rem;">¡No se han registrado cambios de eps a&uacute;n!</div></td>
          </tr>
          {else}
          <tbody>
          {assign var="eps_count" value="0"}
          {foreach name=detalle from=$i.empresa_eps item=j}

                <tr>
                  <td width="30%"><b>Empresa</b></td>
                  <td width="40%">{$j.empresa_prestacion_nueva}</td>
                  <td width="30%"><b>Fecha Inicio </b>&nbsp;{$j.fecha_inicio}</td>
                </tr>
           {math assign="eps_count" equation="x + y" x=$eps_count y=1}
          {/foreach}
          {/if}
          <!-- PENSION -->
          <thead>
            <th style="text-align: center;" colspan="3">Administradora de Fondo de Pensiones</th>
          </thead>
          {if $i.empresa_pension eq ''}
          <tr>
            <td colspan="3">
              <div class="animated bounceIn" style="text-align: center; font-size: 1.0rem;">¡No se han registrado cambios de pensi&oacute;n a&uacute;n!</div>
            </td>
          </tr>
          {else}
          <tbody>
            {assign var="pension_count" value="0"}
            {foreach name=detalle from=$i.empresa_pension item=p}
          
            <tr>
              <td width="30%"><b>Empresa</b></td>
              <td width="40%">{$p.empresa_prestacion_nueva}</td>
              <td width="30%"><b>Fecha Inicio </b>&nbsp;{$p.fecha_inicio}</td>
            </tr>
            {math assign="pension_count" equation="x + y" x=$pension_count y=1}
            {/foreach}
            {/if}
            <!-- CESANTIAS -->
            <thead>
              <th style="text-align: center;" colspan="3">Administradora de Fondo de Cesant&iacute;as</th>
            </thead>
            {if $i.empresa_cesantias eq ''}
            <tr>
              <td colspan="3">
                <div class="animated bounceIn" style="text-align: center; font-size: 1.0rem;">¡No se han registrado cambios de cesant&iacute;as a&uacute;n!</div>
              </td>
            </tr>
            {else}
            <tbody>
              {assign var="cesantias_count" value="0"}
              {foreach name=detalle from=$i.empresa_cesantias item=c}
            
              <tr>
                <td width="30%"><b>Empresa</b></td>
                <td width="40%">{$c.empresa_prestacion_nueva}</td>
                <td width="30%"><b>Fecha Inicio </b>&nbsp;{$c.fecha_inicio}</td>
              </tr>
              {math assign="cesantias_count" equation="x + y" x=$cesantias_count y=1}
              {/foreach}
              {/if}
            <!-- ARL -->
            <thead>
              <th style="text-align: center;" colspan="3">Administradora de Riesgos Laborales</th>
            </thead>
            {if $i.empresa_arl eq ''}
            <tr>
              <td colspan="3">
                <div class="animated bounceIn" style="text-align: center; font-size: 1.0rem;">¡No se han registrado cambios de arl a&uacute;n!</div>
              </td>
            </tr>
            {else}
            <tbody>
              {assign var="arl_count" value="0"}
              {foreach name=detalle from=$i.empresa_arl item=a}
            
              <tr>
                <td width="30%"><b>Empresa</b></td>
                <td width="40%">{$a.empresa_prestacion_nueva}</td>
                <td width="30%"><b>Fecha Inicio </b>&nbsp;{$a.fecha_inicio}</td>
              </tr>
              {math assign="arl_count" equation="x + y" x=$arl_count y=1}
              {/foreach}
              {/if}
            <!-- CAJA COMPENSACION -->
            <thead>
              <th style="text-align: center;" colspan="3">Caja de Compensaci&oacute;n Familiar</th>
            </thead>
            {if $i.empresa_caja eq ''}
            <tr>
              <td colspan="3">
                <div class="animated bounceIn" style="text-align: center; font-size: 1.0rem;">¡No se han registrado cambios de caja de compensaci&oacute;n a&uacute;n!</div>
              </td>
            </tr>
            {else}
            <tbody>
              {assign var="caja_count" value="0"}
              {foreach name=detalle from=$i.empresa_caja item=ca}
            
              <tr>
                <td width="30%"><b>Empresa</b></td>
                <td width="40%">{$ca.empresa_prestacion_nueva}</td>
                <td width="30%"><b>Fecha Inicio </b>&nbsp;{$ca.fecha_inicio}</td>
              </tr>
              {math assign="caja_count" equation="x + y" x=$caja_count y=1}
              {/foreach}
              {/if}
          </tbody>
        </table>
        <!--Tabla de cambio prestaciones fin-->
        <!--Tabla de horas extra inicio-->
        <table class="table table-striped table-hover table-sm table-bordered" style="width: 100%;">
          <thead class="thead">
            <th style="text-align: center;" colspan="4"><b> REGISTRO DE HORAS EXTRAS</b></th>
          </thead>
          {if $i.extras eq ''}
          <tr>
            <td colspan="4">
              <div class="animated bounceIn" style="text-align: center; font-size: 1.0rem;">¡No se han realizado horas extras para este contrato!</div>
            </td>
          </tr>
          {else}
          <tbody>
            {assign var="extras_count" value="0"}
            {foreach name=detalle from=$i.extras item=e}
            <tr>
              <td width="25%" colspan="2"><b>Fecha Inicio </b>&nbsp;{$e.fecha_inicial}</td>
              <td width="25%" colspan="2"><b>Fecha Final </b>&nbsp;{$e.fecha_final}</td>
            </tr>
            <tr>
              <td width="25%"><b>Cant. Horas Diurnas </b>&nbsp;{$e.horas_diurnas}</td>
              <td width="25%"><b>Vlr. Horas Diurnas </b>&nbsp;$ {$e.vr_horas_diurnas|number_format:0:',':'.'}</td>
              <td width="25%"><b>Cant. Horas Nocturnas </b>&nbsp;{$e.horas_nocturnas}</td>
              <td width="25%"><b>Vlr. Horas Nocturnas </b>&nbsp;$ {$e.vr_horas_nocturnas|number_format:0:',':'.'}</td>
            </tr>
            <tr>
              <td width="25%"><b>Cant. Horas Diurnas Festivo </b>&nbsp;{$e.horas_diurnas_fes}</td>
              <td width="25%"><b>Vlr. Horas Diurnas Festivo </b>&nbsp;$ {$e.vr_horas_diurnas_fes|number_format:0:',':'.'}</td>
              <td width="25%"><b>Cant. Horas Nocturnas Festivo </b>&nbsp;{$e.horas_nocturnas_fes}</td>
              <td width="25%"><b>Vlr. Horas Nocturnas Festivo </b>&nbsp;$ {$e.vr_horas_nocturnas_fes|number_format:0:',':'.'}</td>
            </tr>
            <tr>
              <td width="25%"><b>Cant. Horas Recargo Nocturno </b>&nbsp;{$e.horas_recargo_noc}</td>
              <td width="25%"><b>Vlr. Horas Recargo Nocturno </b>&nbsp;$ {$e.vr_horas_recargo_noc|number_format:0:',':'.'}</td>
              <td width="25%"><b>Cant. Horas Dominicales Festivo </b>&nbsp;{$e.horas_recargo_doc}</td>
              <td width="25%"><b>Vlr. Horas Dominicales Festivo </b>&nbsp;$ {$e.vr_horas_recargo_doc|number_format:0:',':'.'}</td>
            </tr>
            <tr style="background-color: #dff0d8;">
              <td width="25%">Estado </b>&nbsp;{$e.estado}</td>
              <td width="25%"><b>Total Cant. Horas Extras </b>&nbsp;{$e.total_cant}</td>
              <td width="25%"><b>Total Vlr. Horas Extras </b></td>
              <td width="25%">$ {$e.total_valor|number_format:0:',':'.'}</td>
            </tr>
            <tr>
              <td colspan="4" style="text-align: center;">{$e.ver}</td>
            </tr>
            {math assign="extras_count" equation="x + y" x=$extras_count y=1}
            {/foreach}
            {/if}
          </tbody>
        </table>
        <!--Tabla de horas extra fin-->
        <!--Tabla de Licencias inicio-->
        <table class="table table-striped table-hover table-sm table-bordered" style="width: 100%;">
          <thead class="thead">
            <th style="text-align: center;" colspan="3"><b> REGISTRO DE LICENCIAS O INCAPACIDADES</b></th>
          </thead>
          {if $i.licencia eq ''}
          <tr>
            <td colspan="3">
              <div class="animated bounceIn" style="text-align: center; font-size: 1.0rem;">¡No se han realizado licencias o incapacidades para este contrato!</div>
            </td>
          </tr>
          {else}
          <tbody>
            {assign var="licencia_count" value="0"}
            {foreach name=detalle from=$i.licencia item=l}
            <tr>
              <td width="30%"><b>Concepto </b>&nbsp;{$l.concepto}</td>
              <td width="40%"><b>Fecha Licencia </b>&nbsp;{$l.fecha_licencia}</td>
              <td width="30%"><b>Tipo Lic./Inc. </b>&nbsp;{$l.tipo_incapacidad}</td>
            </tr>
            <tr>
              <td width="30%"><b>Fecha Inicio </b>&nbsp;{$l.fecha_inicial}</td>
              <td width="40%"><b>Fecha Final </b>&nbsp;{$l.fecha_final}</td>
              <td width="30%"><b>D&iacute;as </b>&nbsp;{$l.dias}</td>
            </tr>
            <tr>
              <td width="30%"><b>Estado </b>&nbsp;{$l.estado}</td>
              <td width="40%"><b>Remunerado </b>&nbsp;{$l.remunerado}</td>
              {if $l.diagnostico neq ''}
              <td width="30%"><b>Diagn&oacute;stico </b>&nbsp;{$l.diagnostico}</td>
              {else}
              <td width="30%">&nbsp;</td>
              {/if}
            </tr>
            <tr>
              <td colspan="3" style="text-align: center;">{$l.ver}</td>
            </tr>
            {math assign="licencia_count" equation="x + y" x=$licencia_count y=1}
            {/foreach}
            {/if}
          </tbody>
        </table>
        <!--Tabla de Licencias fin-->
        <!--Tabla de Novedades inicio-->
        <table class="table table-striped table-hover table-sm table-bordered" style="width: 100%;">
          <thead class="thead">
            <th style="text-align: center;" colspan="3"><b>REGISTRO DE NOVEDADES</b></th>
          </thead>
          {if $i.novedad eq ''}
          <tr>
            <td colspan="3">
              <div class="animated bounceIn" style="text-align: center; font-size: 1.0rem;">¡No se han realizado novedades para este contrato!</div>
            </td>
          </tr>
          {else}
          <tbody>
            {assign var="novedad_count" value="0"}
            {foreach name=detalle from=$i.novedad item=n}
            <tr>
              <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
              <td width="30%"><b>Concepto </b>&nbsp;{$n.concepto}</td>
              <td width="40%"><b>Fecha Novedad </b>&nbsp;{$n.fecha_novedad}</td>
              <td width="30%"><b>Naturaleza </b>&nbsp;{$n.tipo_novedad}</td>
            </tr>
            <tr>
              <td width="30%"><b>Fecha Inicio </b>&nbsp;{$n.fecha_inicial}</td>
              <td width="40%"><b>Fecha Final </b>&nbsp;{$n.fecha_final}</td>
              <td width="30%"><b>Cuotas </b>&nbsp;{$n.cuotas}</td>
            </tr>
            <tr>
              <td width="30%"><b>Periodicidad </b>&nbsp;{$n.periodicidad}</td>
              <td width="40%"><b>Tipo Novedad </b>&nbsp;{$n.concepto_area}</td>
              <td width="30%"><b>Valor Total </b>&nbsp;{$n.valor}</td>
            </tr>
            <tr>
              <td><b>Estado </b>&nbsp;{$n.estado}</td>
              <td colspan="2"><b>Doc. Soporte </b>&nbsp;{$n.soporte}</td>
            </tr>
            <tr>
              <td colspan="3" style="text-align: center;">{$n.ver}</td>
            </tr>
            {math assign="novedad_count" equation="x + y" x=$novedad_count y=1}
            {/foreach}
            {/if}
          </tbody>
        </table>
        <!--Tabla de Novedades fin-->
        <!--Tabla de Liquidacion Cesantias inicio-->
        <table class="table table-striped table-hover table-sm table-bordered" style="width: 100%;">
          <thead class="thead">
            <th style="text-align: center;" colspan="4"><b>LIQUIDACION CESANTIAS</b></th>
          </thead>
          {if $i.liq_cesantias eq ''}
          <tr>
            <td colspan="4">
              <div class="animated bounceIn" style="text-align: center; font-size: 1.0rem;">¡No se han realizado liquidaciones de cesant&iacute;as para este contrato!</div>
            </td>
          </tr>
          {else}
          <tbody>
            {assign var="liq_cesan_count" value="0"}
            {foreach name=detalle from=$i.liq_cesantias item=lc}
            <tr>
              <td colspan="4">&nbsp;</td>
            </tr>
            <tr>
              <td width="25%"><b>No. Liquidaci&oacute;n </b>&nbsp; # {$lc.liquidacion_cesantias_id}</td>
              <td width="25%"><b>Fecha Liquidaci&oacute;n </b>&nbsp;{$lc.fecha_liquidacion}</td>
              <td width="25%"><b>Fecha Corte </b>&nbsp;{$lc.fecha_corte}</td>
              <td width="25%"><b>Fecha Ultimo Corte </b>&nbsp;{$lc.fecha_ultimo_corte}</td>
            </tr>
            <tr>
              <td width="25%"><b>Tipo Liquidaci&oacute;n </b>&nbsp;{$lc.tipo_liquidacion}</td>
              <td width="25%"><b>D&iacute;as Totales </b>&nbsp;{$lc.dias_periodo}</td>
              <td width="25%"><b>D&iacute;as no Remunerados </b>&nbsp;{$lc.dias_no_remu}</td>
              <td width="25%"><b>D&iacute;as a Liquidar </b>&nbsp;{$lc.dias_liquidados}</td>
            </tr>
            <tr>
              <td width="25%"><b>Base Liquidaci&oacute;n </b>&nbsp; $ {$lc.salario}</td>
              <td width="25%"><b>Vlr. Consolidado </b>&nbsp; ${$lc.valor_consolidado}</td>
              <td width="25%"><b>Vlr. Provisionado </b>&nbsp; $ {$lc.valor_provision}</td>
              <td width="25%"><b>Vlr. Diferencia </b>&nbsp; $ {$lc.valor_diferencia}</td>
            </tr>
            <tr style="background-color: #e6eee3;">
                <td width="25%"><b>Estado </b>&nbsp;{$lc.estado}</td>
                <td width="25%"><b>Periodo </b>&nbsp;{$lc.periodo}</td>
              <td width="25%"><b>Observaciones </b>&nbsp;{$lc.observaciones}</td>
              <td width="25%"><b>Vlr. Liquidaci&oacute;n </b>&nbsp; $ {$lc.valor_liquidacion}</td>
            </tr>
            {if $lc.encabezado_registro_id neq ''}
            <tr>
              <td colspan="2" style="text-align: center;">{$lc.ir}</td>
              <td colspan="2" style="text-align: center;">{$lc.ver}</td>
            </tr>
            {else}
            <tr>
              <td colspan="4" style="text-align: center;">{$lc.ir}</td>
            </tr>
            {/if}
            {math assign="liq_cesan_count" equation="x + y" x=$liq_cesan_count y=1}
            {/foreach}
            {/if}
          </tbody>
        </table>
        <!--Tabla de Liquidacion Cesantias fin-->
        <!--Tabla de Liquidacion Primas inicio-->
        <table class="table table-striped table-hover table-sm table-bordered" style="width: 100%;">
          <thead class="thead">
            <th style="text-align: center;" colspan="4"><b>LIQUIDACION PRIMAS</b></th>
          </thead>
          {if $i.liq_primas eq ''}
          <tr>
            <td colspan="4">
              <div class="animated bounceIn" style="text-align: center; font-size: 1.0rem;">¡No se han realizado liquidaciones de primas para este contrato!</div>
            </td>
          </tr>
          {else}
          <tbody>
            {assign var="liq_primas_count" value="0"}
            {foreach name=detalle from=$i.liq_primas item=lp}
            <tr>
              <td colspan="4">&nbsp;</td>
            </tr>
            <tr>
              <td width="25%"><b>No. Liquidaci&oacute;n </b>&nbsp; # {$lp.liquidacion_prima_id}</td>
              <td width="25%"><b>Fecha Liquidaci&oacute;n </b>&nbsp;{$lp.fecha_liquidacion}</td>
              <td width="25%"><b>Tipo Liquidaci&oacute;n </b>&nbsp;{$lp.tipo_liquidacion}</td>
              <td width="25%"><b>Periodo </b>&nbsp;{$lp.periodo}</td>
            </tr>
            <tr style="background-color: #e6eee3;">
              <td width="25%"><b>Estado </b>&nbsp;{$lp.estado}</td>
              <td width="50%" colspan="2"><b>Observaciones </b>&nbsp;{$lp.observaciones}</td>
              <td width="25%"><b>Vlr. Liquidaci&oacute;n </b>&nbsp; $ {$lp.total|number_format:0:',':'.'}</td>
            </tr>
            {if $lp.encabezado_registro_id neq ''}
            <tr>
              <td colspan="2" style="text-align: center;">{$lp.ir}</td>
              <td colspan="2" style="text-align: center;">{$lp.ver}</td>
            </tr>
            {else}
            <tr>
              <td colspan="4" style="text-align: center;">{$lp.ir}</td>
            </tr>
            {/if}
            {math assign="liq_primas_count" equation="x + y" x=$liq_primas_count y=1}
            {/foreach}
            {/if}
          </tbody>
        </table>
        <!--Tabla de Liquidacion Primas fin-->
        <!--Tabla de Liquidacion Vacaciones inicio-->
        <table class="table table-striped table-hover table-sm table-bordered" style="width: 100%;">
          <thead class="thead">
            <th style="text-align: center;" colspan="4"><b>LIQUIDACION VACACIONES</b></th>
          </thead>
          {if $i.liq_vacacion eq ''}
          <tr>
            <td colspan="4">
              <div class="animated bounceIn" style="text-align: center; font-size: 1.0rem;">¡No se han realizado liquidaciones de vacaciones para este contrato!</div>
            </td>
          </tr>
          {else}
          <tbody>
            {assign var="liq_vacacion_count" value="0"}
            {foreach name=detalle from=$i.liq_vacacion item=lv}
            <tr>
              <td colspan="4">&nbsp;</td>
            </tr>
            <tr>
              <td width="25%"><b>No. Liquidaci&oacute;n </b>&nbsp; # {$lv.liquidacion_vacaciones_id}</td>
              <td width="25%"><b>Fecha Liquidaci&oacute;n </b>&nbsp;{$lv.fecha_liquidacion}</td>
              <td width="25%"><b>Fecha Inicio </b>&nbsp;{$lv.fecha_dis_inicio}</td>
              <td width="25%"><b>Fecha Final </b>&nbsp;{$lv.fecha_dis_final}</td>
            </tr>
            <tr>
              <td width="25%"><b>Fecha Reintegro </b>&nbsp;{$lv.fecha_reintegro}</td>
              <td width="25%"><b>D&iacute;as a Disfrutar </b>&nbsp;{$lv.dias}</td>
              <td width="25%"><b>Cargo </b>&nbsp;{$lv.cargo}</td>
              <td width="25%"><b>Concepto </b>&nbsp;{$lv.concepto}</td>
            </tr>
            <tr style="background-color: #e6eee3;">
              <td width="25%"><b>Estado </b>&nbsp;{$lv.estado}</td>
              <td width="25%"><b>Base Liquidaci&oacute;n </b>&nbsp; $ {$lv.salario|number_format:0:',':'.'}</td>
              <td width="25%"><b>Observaciones </b>&nbsp;{$lv.observaciones}</td>
              <td width="25%"><b>Vlr. Liquidaci&oacute;n </b>&nbsp; $ {$lv.valor|number_format:0:',':'.'}</td>
            </tr>
            {if $lv.encabezado_registro_id neq ''}
            <tr>
              <td colspan="2" style="text-align: center;">{$lv.ir}</td>
              <td colspan="2" style="text-align: center;">{$lv.ver}</td>
            </tr>
            {else}
            <tr>
              <td colspan="4" style="text-align: center;">{$lv.ir}</td>
            </tr>
            {/if}
            {math assign="liq_vacacion_count" equation="x + y" x=$liq_vacacion_count y=1}
            {/foreach}
            {/if}
          </tbody>
        </table>
        <!--Tabla de Liquidacion Vacaciones fin-->
        <!--Tabla de Historial Contrato inicio-->
        <table class="table table-striped table-hover table-sm table-bordered" style="width: 100%;">
          <thead class="thead">
            <th style="text-align: center;" colspan="4"><b>HISTORIAL ACTUALIZACIONES CONTRATO</b></th>
          </thead>
          {if $i.historia eq ''}
          <tr>
            <td colspan="4">
              <div class="animated bounceIn" style="text-align: center; font-size: 1.0rem;">¡No se han realizado actualizaciones para este contrato!</div>
            </td>
          </tr>
          {else}
          <tbody>
            {assign var="historial_count" value="0"}
            {foreach name=detalle from=$i.historia item=hc}
            {* <tr>
              <td colspan="4">&nbsp;</td>
            </tr> *}
            <tr style="background-color: #e6eee3;">
              <td width="25%"><b>Fecha Inicio </b>&nbsp;{$hc.fecha_inicio}</td>
              <td width="25%"><b>Fecha Final </b>&nbsp;{$hc.fecha_terminacion}</td>
              <td width="25%"><b>Sueldo Base </b>&nbsp; ${$hc.sueldo_base|number_format:0:',':'.'}</td>
              <td width="25%"><b>Subsidio Transporte </b>&nbsp; ${$hc.subsidio_transporte|number_format:0:',':'.'}</td>
            </tr>
            <tr>
              <td width="25%"><b>Estado </b>&nbsp;{$hc.estado}</td>
              <td width="25%"><b>Observaci&oacute;n Actualizaci&oacute;n </b><br>{$hc.observacion_ren}</td>
              <td width="25%"><b>Fecha Actualizaci&oacute;n </b><br>{$hc.fecha_actualizacion}</td>
              <td width="25%"><b>Usuario Actualiza </b><br>{$hc.usuario_actualizo}</td>
            </tr>
            {math assign="historial_count" equation="x + y" x=$historial_count y=1}
            {/foreach}
            {/if}
          </tbody>
        </table>
        <!--Tabla de Historial Contrato fin-->
      </div>
      <div class="col-sm"></div>
    </div>
  </div>
  
  {/foreach}   
  {/if}
</page>

<!--  -->

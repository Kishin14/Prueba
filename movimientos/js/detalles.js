// JavaScript Document

$(document).ready(function(){
				
    linkDetalles();				
    checkedAll();
	checkRow();
    autocompleteTercero();	
	autocompleteCentroCosto();
	getvalorCalculadoBase();
	
    autocompleteCodigoContable();
	
    $(document).bind('keyup', 'Ctrl+c',function (evt){ 

      var txtConcepto = $(document).find(":focus");
      var concepto    = parent.document.getElementById("concepto").value;
	  
	  if(txtConcepto.attr("name") == "descripcion"){
          var varTmp = txtConcepto.val();
		  txtConcepto.val(varTmp+' '+concepto);
      }
	  
      return false;

    });	
	
    $(document).bind('keydown', 'Ctrl+t',function (evt){ 
						
      var txtConcepto = $(document).find(":focus");
      var tercero     = parent.document.getElementById("tercero").value;
	  
	  if(txtConcepto.attr("name") == "descripcion"){
          var varTmp = txtConcepto.val();
		  txtConcepto.val(varTmp+' '+tercero);
      }						
						
       return false; 
	   
    });	
	
});

function checkedAll(){
	
   $("#checkedAll").click(function(){
								   
							   								   
      if($(this).is(":checked")){
		$("input[name=procesar]").attr("checked","true");
      }else{
  		  $("input[name=procesar]").attr("checked","");
		}
								   
   });

}
    
/***************************************************************
	  lista inteligente para la ubicacion con jquery
**************************************************************/

function autocompleteCodigoContable(){
	
	var encabezado_registro_id = $("#encabezado_registro_id").val();
	
	$("input[name=puc]").autocomplete("/application/framework/clases/ListaInteligente.php?consulta=cuentas_movimiento&encabezado_registro_id="+encabezado_registro_id, {
		width: 260,
		selectFirst: true,
		minChars: 4,
		scrollHeight: 220
	});
	
	$("input[name=puc]").result(function(event, data, formatted) {				   
										 										 
		if (data){
			
			var codigo_puc = data[0].split("-");
			
			$(this).val($.trim(codigo_puc[0]));
			$(this).attr("title",data[0]);			
			
			$(this).next().val(data[1]);
            getRequieresCuenta(data[1],this);
			
			$(this.parentNode.parentNode).find("input[name=descripcion]").val($.trim(codigo_puc[1]));

		}
		
	});
	
}

function autocompleteTercero(){
	
	$("input[name=tercero]").autocomplete("/application/framework/clases/ListaInteligente.php?consulta=tercero", {
		width: 260,
		selectFirst: true
	});
	
	$("input[name=tercero]").result(function(event, data, formatted) {				   
		if (data){
			var numero_identificacion = data[0].split("-");
			$(this).val($.trim(numero_identificacion[0]));
			$(this).attr("title",data[0]);
			$(this).next().val(data[1]);
			
   		    var txtNext = false;			
			
            $(this.parentNode.parentNode).find("input[name!=puc]&&input[name!=tercero]&&input[type=text]").each(function(){
               if(this.readOnly == false && txtNext == false){
				   this.focus();
				   txtNext = true;
			   }
			   
            });			
		}
	});
	
}

function autocompleteCentroCosto(){
	
	$("input[name=centro_de_costo]").autocomplete("/application/framework/clases/ListaInteligente.php?consulta=centro_costo", {
		width: 260,
		selectFirst: true
	});
	
	$("input[name=centro_de_costo]").result(function(event, data, formatted) {				   
		if (data){
			var centro_costo = data[0].split("-");
			$(this).val($.trim(centro_costo[0]));
			$(this).attr("title",data[0]);			
			$(this).next().val(data[1]);
			
			var txtNext = false;
			
            $(this.parentNode.parentNode).find("input[name!=puc]&&input[name!=tercero]&&input[name!=centro_de_costo]&&input[type=text]").each(function(){
               if(this.readOnly == false && txtNext == false){
				   this.focus();
				   txtNext = true;
			   }
			   
            });					
		}
	});
	
}



/***************************************************************
	  Funciones para el objeto de guardado en las imputaciones
***************************************************************/

function getRequieresCuenta(puc_id,objTxt){
	
  var fila                   	=$(objTxt).parent().parent();
  var abono_nomina_id=$("#abono_nomina_id").val();
  var QueryString            	="ACTIONCONTROLER=getRequieresCuenta&puc_id="+puc_id+'&abono_nomina_id='+abono_nomina_id;
	
  $.ajax({
	url        : "DetallesClass.php",
	data       : QueryString,
	beforeSend : function (){
	  showDivLoading();	
    },
	success    : function(response){

      try{
		  
  	    var requiere              = $.parseJSON(response);
	    var requiere_tercero      = requiere['requiere_tercero'];
	    var requiere_centro_costo = requiere['requiere_centro_costo'];		
	    var require_base          = requiere['require_base'];
		
        fila.find("input[name=tercero]").val("");			
        fila.find("input[name=tercero_id]").val("");											  		
        fila.find("input[name=centro_de_costo]").val("");			
        fila.find("input[name=centro_de_costo_id]").val("");											  		
        fila.find("input[name=base_abono_factura]").val("");											  				
	
		if($.trim(requiere_tercero) == "true"){
          fila.find("input[name=tercero]").removeClass("no_requerido");
          fila.find("input[name=tercero]").attr("readonly","");		  
          fila.find("input[name=tercero]").parent().removeClass("no_requerido");			
          fila.find("input[name=tercero_id]").addClass("required");									
        }else{
            fila.find("input[name=tercero]").addClass("no_requerido");
            fila.find("input[name=tercero]").attr("readonly","true");		  			
            fila.find("input[name=tercero]").parent().addClass("no_requerido");			
            fila.find("input[name=tercero_id]").removeClass("required");												
		  }


		if($.trim(requiere_centro_costo) == "true"){
          fila.find("input[name=centro_de_costo]").removeClass("no_requerido");
          fila.find("input[name=centro_de_costo]").attr("readonly","");		  
          fila.find("input[name=centro_de_costo]").parent().removeClass("no_requerido");			
          fila.find("input[name=centro_de_costo_id]").addClass("required");									
        }else{
            fila.find("input[name=centro_de_costo]").addClass("no_requerido");
            fila.find("input[name=centro_de_costo]").attr("readonly","true");		  			
            fila.find("input[name=centro_de_costo]").parent().addClass("no_requerido");			
            fila.find("input[name=centro_de_costo_id]").removeClass("required");												
		  }
		  
		if($.trim(require_base) == "true"){
          fila.find("input[name=base_abono_factura]").removeClass("no_requerido");
          fila.find("input[name=base_abono_factura]").attr("readonly","");		  
          fila.find("input[name=base_abono_factura]").parent().removeClass("no_requerido");			
          fila.find("input[name=base_abono_factura]").addClass("required");					  
          fila.find("input[name=debito]").attr("readonly","true");					  
          fila.find("input[name=credito]").attr("readonly","true");					  		  	  
        }else{
            fila.find("input[name=base_abono_factura]").addClass("no_requerido");
            fila.find("input[name=base_abono_factura]").attr("readonly","true");		  			
            fila.find("input[name=base_abono_factura]").parent().addClass("no_requerido");			
            fila.find("input[name=base_abono_factura]").removeClass("required");						
            fila.find("input[name=debito]").attr("readonly","");					  
            fila.find("input[name=credito]").attr("readonly","");			
		  }		  

		 removeDivLoading();		  
		
           var txtNext = false;
			
            $(fila).find("input[name!=puc]&&input[type=text]").each(function(){
               if(this.readOnly == false && txtNext == false){
				   this.focus();
				   txtNext = true;
			   }
			   
            });	
		
		
	  }catch(e){

		  }
	  		  
    }
	
  });
	
}

function getvalorCalculadoBase(){

  $("input[name=base_abono_factura]").blur(function(){

    if($(this).is(".required")){

      var objBase                	 = this;
      var puc_id                 	 = $(this).parent().parent().find("input[name=puc_id]").val();
      var base_abono_factura 	 	 = $(this).parent().parent().find("input[name=base_abono_factura]").val();	  
	  var abono_nomina_id = $("#abono_nomina_id").val();
	  
      var QueryString            ="ACTIONCONTROLER=getvalorCalculadoBase&puc_id="+puc_id+'&abono_nomina_id='+
	                               abono_nomina_id+"&base_abono_factura="+base_abono_factura;
	  
	  
      $.ajax({
     	url     : "DetallesClass.php",
		data    : QueryString,
		success : function(response){
			
          try{
			  
           var datosCalculo = $.parseJSON(response);
		   
		   if($.trim(datosCalculo['naturaleza']) == 'D'){
			  $(objBase).parent().parent().find("input[name=debito]").val(datosCalculo['valor']);
		      $(objBase).parent().parent().find("input[name=credito]").val("");			   			  
           }else{
			    $(objBase).parent().parent().find("input[name=debito]").val("");			   
			    $(objBase).parent().parent().find("input[name=credito]").val(datosCalculo['valor']);			   
			  }
		   
		  }catch(e){
			 }

        }
	  });

    }

  });
  
}

function saveDetalle(obj){
	
	var row = obj.parentNode.parentNode;
	
    if(validaRequeridosDetalle(obj,row)){

    var Celda                  		= obj.parentNode;
    var Fila                   	  	= obj.parentNode.parentNode;	
    var item_abono_factura_id 		= $(Fila).find("input[name=item_abono_factura_id]").val();	
	var abono_nomina_id  = $("#abono_nomina_id").val();
	var puc_id                 		= $(Fila).find("input[name=puc_id]").val();		
	var tercero_id             		= $(Fila).find("input[name=tercero_id]").val();	
	var centro_de_costo_id     		= $(Fila).find("input[name=centro_de_costo_id]").val();	
	var descripcion      	= $(Fila).find("input[name=descripcion]").val();			
	var base_abono_factura      	= $(Fila).find("input[name=base_abono_factura]").val();	
	var debito  	= $(Fila).find("input[name=debito]").val();	
	var credito 	 	= $(Fila).find("input[name=credito]").val();	
	var valor_total  				= $(Fila).find("input[name=valor_total]").val();	
	var abonos 	 					= $(Fila).find("input[name=abonos]").val();	
	var checkProcesar          		= $(Fila).find("input[name=procesar]");		
	var saldo						= valor_total-abonos;
	
	tercero_id             		= tercero_id.length         	> 0 ? tercero_id         	: 'NULL';
	centro_de_costo_id     		= centro_de_costo_id.length 	> 0 ? centro_de_costo_id 	: 'NULL';
	base_abono_factura			= base_abono_factura.length 	> 0 ? base_abono_factura 	: 'NULL';
	debito 		= debito.length > 0 ? debito: 'NULL';
	credito 		= credito.length > 0 ? credito: 'NULL';
	
	/*if((parseInt(debito) > 0 || parseInt(credito))&& saldo>=debito &&  saldo>=credito){*/
				

	  var QueryString = "ACTIONCONTROLER=onclickUpdate&abono_nomina_id="+abono_nomina_id+"&item_abono_factura_id="+
	  item_abono_factura_id+"&puc_id="+puc_id+"&tercero_id="+tercero_id+"&centro_de_costo_id="+centro_de_costo_id+"&descripcion="+descripcion+
	  "&base_abono_factura="+base_abono_factura+"&debito="+debito+"&credito="+credito;	
	  		
	  $.ajax({
		   
	    url        : "DetallesClass.php",
	    data       : QueryString,
	    beforeSend : function(){
	      showDivLoading();				
	    },
	    success    : function(response){
			
          if( $.trim(response) == 'true'){
			checkProcesar.attr("checked","");					
			if(parent.getTotalDebitoCredito) 
			  parent.getTotalDebitoCredito(parent.document.getElementById("abono_nomina_id").value);
		    }else{
			  alertJquery(response);
		    }
			
 	    removeDivLoading();	
	    }
		  
	  });

	/*}else if(saldo<debito ||  saldo<credito){
		alertJquery("Los valores sobrepasan el saldo de la Factura","Validacion Debito / Credito");
	}else{
		alertJquery("Debe Ingresar un valor","Validacion Debito / Credito");
	}*/
	 
  }
 		
}


function saveDetalles(){

  $("input[name=procesar]:checked").each(function(){
 
     saveDetalle(this);

  });

}


function checkRow(){
	
	$("input[type=text]").keyup(function(event){
       var Tecla = event.keyCode;
	   var Fila  = this.parentNode.parentNode;
	   
       $(Fila).find("input[name=procesar]").attr("checked","true");
	   
    });
	
}

function saveDetalleNuevo(obj){
	
	var row = obj.parentNode.parentNode;

    if(validaRequeridosDetalle(obj,row)){
	


    var Celda                  		= obj.parentNode;
    var Fila                   	  	= obj.parentNode.parentNode;	
	var relacion_abono_factura_id   = $(Fila).find("input[name=relacion_abono_factura_id]").val();	
    var item_abono_factura_id 		= $(Fila).find("input[name=item_abono_factura_id]").val();	
	var abono_nomina_id  = $("#abono_nomina_id").val();
	var puc_id                 		= $(Fila).find("input[name=puc_id]").val();		
	var tercero_id             		= $(Fila).find("input[name=tercero_id]").val();	
	var centro_de_costo_id     		= $(Fila).find("input[name=centro_de_costo_id]").val();	
	var descripcion      	= $(Fila).find("input[name=descripcion]").val();			
	var base_abono_factura      	= $(Fila).find("input[name=base_abono_factura]").val();	
	var debito  	= $(Fila).find("input[name=debito]").val();	
	var credito 	 	= $(Fila).find("input[name=credito]").val();	
	var valor_total  				= $(Fila).find("input[name=valor_total]").val();	
	var abonos 	 					= $(Fila).find("input[name=abonos]").val();	
	var checkProcesar          		= $(Fila).find("input[name=procesar]");		
	var saldo						= valor_total-abonos;
	
	tercero_id             		= tercero_id.length         	> 0 ? tercero_id         	: 'NULL';
	centro_de_costo_id     		= centro_de_costo_id.length 	> 0 ? centro_de_costo_id 	: 'NULL';
	base_abono_factura			= base_abono_factura.length 	> 0 ? base_abono_factura 	: 'NULL';
	debito 		= debito.length > 0 ? debito: 'NULL';
	credito 		= credito.length > 0 ? credito: 'NULL';
	
			

	  var QueryString = "ACTIONCONTROLER=onclickSave&abono_nomina_id="+abono_nomina_id+"&item_abono_factura_id="+
	  item_abono_factura_id+"&puc_id="+puc_id+"&tercero_id="+tercero_id+"&centro_de_costo_id="+centro_de_costo_id+"&descripcion="+descripcion+
	  "&base_abono_factura="+base_abono_factura+"&debito="+debito+"&credito="+credito+"&relacion_abono_factura_id="+relacion_abono_factura_id+"&abono_nomina_id="+abono_nomina_id;	
	  		
	  $.ajax({
		   
	    url        : "DetallesClass.php",
	    data       : QueryString,
	    beforeSend : function(){
	      showDivLoading();				
	    },
	    success    : function(response){
						
          if( $.trim(response) == 'true'){
			  
			  $(Celda).html('<input type="checkbox" name="procesar" />');
			  
              alertJquery("Se guardo Exitosamente");
		    }else{
			  alertJquery(response);
		    }
			
 	    removeDivLoading();	
	    }
		  
	  });	 
  	
	
    }//fin de validaRequeridosDetalle	
  
}

function linkDetalles(){

	$("a[name=saveDetalle]").attr("href","javascript:void(0)");
	
	$("a[name=saveDetalle]").focus(function(){
		var celda = this.parentNode;
		$(celda).addClass("focusSaveRow");
    });
	
	$("a[name=saveDetalle]").blur(function(){
		var celda = this.parentNode;
		$(celda).removeClass("focusSaveRow");
    });
	
	$("a[name=saveDetalle]").click(function(){
		saveDetalleNuevo(this);
    });
	
}
// JavaScript Document
var detalle_ss_id;

$(document).ready(function(){
	
	$("#convocado").click(function(){
		setSolicitud();
		
	});
  
});

function checkRow(obj){
  
  var numChecks = 0;
	
  $(document).find("input[type=checkbox]:checked").each(function(){
    numChecks += 1;
  });
	
  var numMaxRemesas = 1;
  
  if(numChecks > numMaxRemesas){
   alertJquery('Solo puede Seleccionar un Maximo de <span style="color:#red">'+numMaxRemesas+'</span> Convocado !!!','Validacion Convocado')
   obj.checked = false;
  }
  
  
}

function setSolicitud(){
  
    var convocado_id        = '';
	var cont =0;	
	
    $(document).find("input[type=checkbox]:checked").each(function(){
                 
	
	    convocado_id = this.value;
		cont++;
	
	  if(cont==1){
		
		parent.setcargaDatos(convocado_id);
		
	  }else if(cont==0){
		alertJquery("Esta solicitud no tiene productos asignados aun!!!","Convocado");
	  }else{
		 alertJquery('Solo puede Seleccionar un Maximo de <span style="color:#red">'+numMaxRemesas+'</span> Convocado !!!','Validacion Convocado')
	  }
            
    });
        
		  
		  		  

		  
}
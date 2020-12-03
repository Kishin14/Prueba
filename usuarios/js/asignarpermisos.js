// JavaScript Document

$(document).ready(function(){

  $("#tree").treeTable(/*{ expandable: false} */);
  
  $("input[name=consecutivo]").click(function(){
											
      var checked  = this.checked;											
      var idLength = this.id.length;
	  var Id       = this.id;

      $("input[name=consecutivo]").each(function(){
																		 
		var idObj = this.id;
		
		if(idObj.substring(0,idLength) == Id){
			this.checked = checked;
			
          
            $(this.parentNode.parentNode).find("input[name=permiso]").each(function(){
																									  
                this.checked = 	checked;																							  

            });
		  
        }
																		 
      });
	  
  });
  
  $("#oficinas_asignadas_id").change(function(){
     getOpcionesAplicacion(this.value);
  });
  
  $("#otorgar_denegar").click(function(){

    setPermisosAplicacion();

  });
  
  
  $("#guardar").click(function(){
    setOficinasUsuarioAplicacion();
  });

	var offset = $("#convenciones").offset();
	var topPadding = 15;
	$(window).scroll(function() {
		if ($(window).scrollTop() > offset.top) {
			//$("#convenciones").css('position','fixed');
			$("#convenciones").stop().animate({
				marginTop: $(window).scrollTop() - offset.top,
				marginLeft : 35
			});
			
		} else {
			//$("#convenciones").css('position','');
			$("#convenciones").stop().animate({
				marginTop: 0
			});
			
		}
	});
});


function setOficinasUsuarioAplicacion(){
		
  var empresa_usuario_id = $("#empresa_usuario_id_hidden").val();
  var oficina_id         = '';
  
  $("#oficina_id option:selected").each(function(){
    oficina_id += this.value+',';
  });
   
  oficina_id = oficina_id.length == 0 ? 0 : oficina_id.substring(0,oficina_id.length - 1);
    
  var QueryString        = "ACTIONCONTROLER=setOficinasUsuarioAplicacion&empresa_usuario_id="+empresa_usuario_id+'&oficina_id='+oficina_id;  
   
  if(empresa_usuario_id.length > 0 && oficina_id != null){
	   
    $.ajax({
  	  url        : "AsignarPermisosClass.php",
	  data       : QueryString,
 	  beforeSend : function() {showDivLoading() },
	  success    : function(response){
		           
		 if($.trim(response) == 'true' || response == true){
			 
		  $("#oficinas_asignadas_id option").each(function(){
            if(this.value != 'NULL'){
				$(this).remove();
            }
          });
		  
          $("#oficina_id option:selected").each(function(){
			  $(this).clone().appendTo("#oficinas_asignadas_id");
          });
		  
		  $("#oficinas_asignadas_id").attr("disabled","");
		  
         }else{
			 alertJquery('No se asigno la oficina');
		   }
		   
      $("input[type=checkbox]").attr("checked","");		   
		   
      removeDivLoading();			  		   
		 
      }
    });
	  
  }else{
	  
	    if(!empresa_usuario_id.length > 0){
			alertJquery('Debe seleccionar un usuario');
			return false;
        }
		
	    if(oficina_id == null){
			alertJquery('Debe seleccionar una oficina');
			return false;			
        }		
	  
	 }
  
}

function getOficinasAplicacion(){
	
  clearOpcionesAplicacion();
  
  var empresa_usuario_id = $("#empresa_usuario_id_hidden").val();
  var QueryString        = "ACTIONCONTROLER=getOficinasAplicacion&empresa_usuario_id="+empresa_usuario_id;
  
  $.ajax({
	url     : "AsignarPermisosClass.php",
	data    : QueryString,
	beforeSend : function() {showDivLoading() },
	success    : function (response){
				
      $("#oficina_id").replaceWith(response);
      $("#oficinas_asignadas_id option").each(function(){ if(this.value != 'NULL'){ $(this).remove(); }});
	  
      QueryString = "ACTIONCONTROLER=getOficinasAplicacionSelected&empresa_usuario_id="+empresa_usuario_id;
	  
	  $.ajax({
	    url     : "AsignarPermisosClass.php",
		data    : QueryString,
		success : function(response){

            var oficinas  = $.parseJSON(response);

            if(oficinas != null){
				
			  for(var i = 0; i < oficinas.length; i++){

                $("#oficina_id option").each(function(){
																									
                  if(this.value == oficinas[i]['oficina_id']){
					  this.selected = true;				
					  $(this).clone().appendTo("#oficinas_asignadas_id");
                  }
													
                });

		      }
			  
            $("#oficinas_asignadas_id,#otorgar_denegar").attr("disabled","");			
			  
			}else{
               $("#oficinas_asignadas_id,#otorgar_denegar").attr("disabled","true");							
              }

	    removeDivLoading();			  
        }
		
      });
	  
    }
  });
}

function getOpcionesAplicacion(oficinas_asignadas_id){
	
  var empresa_usuario_id    = $("#empresa_usuario_id_hidden").val();
  var QueryString           = "ACTIONCONTROLER=getOpcionesAplicacion&empresa_usuario_id="+empresa_usuario_id+
                              "&oficinas_asignadas_id="+oficinas_asignadas_id;  
  if(oficinas_asignadas_id != 'NULL'){
	  
    $.ajax({
      url        : "AsignarPermisosClass.php",
	  data       : QueryString,
      beforeSend : function() {showDivLoading() },
  	  success    : function(response){
		  
		  //alertJquery(response);return false;
		  
		var matrizPermisos = $.parseJSON(response);
		
		if(matrizPermisos != 'NULL'){
			
			for(var i = 0; i < matrizPermisos.length; i++){
							
				$("input[name=consecutivo]").each(function(){
 
                   if(this.value == matrizPermisos[i]['consecutivo']){
					  this.checked = true;
					  				  
					  if(matrizPermisos[i]['permisos'] != null){
						  
					    for(var j = 0; j < matrizPermisos[i]['permisos'].length; j++){
						  					  
						  $(this.parentNode.parentNode).find("input[name=permiso]").each(function(){
																						
                             if(this.value == matrizPermisos[i]['permisos'][j]['permiso_id']){
							    this.checked = true;
                             }
						   
                          });
						
                        }
						
					  }
					  
                  }
 
                });
				
            }
			
        $("#otorgar_denegar").attr("disabled","");											
        }
		
      removeDivLoading();			  
	  
      }
	  
    });
	
  }
	
} 

function clearOpcionesAplicacion(){
	
	$("input[name=consecutivo],input[name=permiso]").attr("checked","");
	
}

function setPermisosAplicacion(){
	
	var empresa_usuario_id = $("#empresa_usuario_id_hidden").val();
	var oficina_id         = $("#oficinas_asignadas_id").val();
	var matrizPermisos_tmp = '';
	var matrizPermisos     = '[';
    var QueryString        = "ACTIONCONTROLER=setPermisosAplicacion&oficina_id="+oficina_id+"&empresa_usuario_id="+
	                          empresa_usuario_id;
	
	$("input[name=consecutivo]:checked").each(function(){

        var permisos = '';
		
        $(this.parentNode.parentNode).find("input[name=permiso]:checked").each(function(){
																			   
            permisos += '{"permiso_id":"'+this.value+'"},';																			   

        });			
		
		
		if($.trim(permisos).length > 0){
		  permisos        = permisos.substring(0,permisos.length - 1);
          matrizPermisos += '{"consecutivo" : "'+this.value+'","permisos" : ['+permisos+']},';
        }else{
             matrizPermisos += '{"consecutivo" : "'+this.value+'"},';		   			
          }
   
	   
    });

    matrizPermisos = matrizPermisos.length > 1 ? matrizPermisos.substring(0,matrizPermisos.length - 1) : matrizPermisos;
    matrizPermisos += ']';	   	   
							   
    $.ajax({
      url  : "AsignarPermisosClass.php",
	  data : QueryString+'&matrizPermisos='+encodeURIComponent(matrizPermisos),
	  type : "POST",
	  beforeSend : function() {showDivLoading() },
	  success    : function (response){    
	    alertJquery(response);
	    removeDivLoading();			  
	  }
	  
	});	
	
}

function onResetPermisosUsuario(){
}
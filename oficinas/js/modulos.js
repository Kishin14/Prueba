// JavaScript Document

$(document).ready(function () {

    var coll = document.getElementsByClassName("collapsible");
    var i;

    for (i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function () {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            if (content.style.display === "block") {
                content.style.display = "none";
            } else {
                content.style.display = "block";
            }
        });
    }

    var forma = document.forms[0];

    $(forma).find("input").each(function(){

        if(this.value == 1 && this.type == 'checkbox'){
            this.checked = true;
        }

    });
    
});

function moduleOnOff(consecutivo){

    var QueryString = "ACTIONCONTROLER=moduleOnOff&consecutivo=" + consecutivo;

    $.ajax({
        url: "ModulosClass.php",
        data: QueryString,
        beforeSend: function () { showDivLoading() },
        success: function (response) {

            if (response == 0) {
                alertJquery('Modulo inactivado con Exito!.', 'Atencion!');
            } else {
                alertJquery('Modulo activado con Exito!.', 'Atencion!');
            }
            removeDivLoading();

        }
    });

}

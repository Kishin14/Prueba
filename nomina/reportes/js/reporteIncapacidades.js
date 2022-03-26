$(document).ready(function () {

    $("#graficos,#generar").css("display", "none");

    ///INICIO VALIDACION FECHAS DE REPORTE

    $('#desde').change(function () {

        var fechah = $('#hasta').val();
        var fechad = $('#desde').val();
        var today = new Date();

        if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechad) > today)) {
            alertJquery('Esta fecha no puede ser mayor a la fecha final o mayor a hoy.');
            return this.value = $('#hasta').val();
        };
    });

    $('#hasta').change(function () {

        var fechah = $('#hasta').val();
        var fechad = $('#desde').val();
        var today = new Date();

        if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechah) > today)) {
            alertJquery('Esta fecha no puede ser menor a la fecha de inicio o mayor a hoy.');
            return this.value = $('#desde').val();
        };
    });

    ///FIN VALIDACION FECHAS DE REPORTE
    $("#generar_excel").click(function () {

        var formulario = this.form;

        if (ValidaRequeridos(formulario)) {

            var desde = $("#desde").val();
            var hasta = $("#hasta").val();
            /* var si_cargo = $("#si_cargo").val();
            var cargo_id = $("#cargo_id").val(); */
            var si_empleado = $("#si_empleado").val();
            var empleado_id = $("#empleado_id").val();

            var QueryString = "reporteIncapacidadesClass.php?ACTIONCONTROLER=generateFileexcel&desde=" + desde + "&hasta=" + hasta +
                "&si_empleado=" + si_empleado + "&empleado_id=" + empleado_id + "&rand=" + Math.random();

            document.location.href = QueryString;
        }
    });

    $("#si_empleado").change(function () {

        if (this.value == 1) {

            $("#Incapacidades").addClass("obligatorio");
            $("#Incapacidades").addClass("requerido");

        } else {


            $("#Incapacidades").removeClass("obligatorio");
            $("#Incapacidades").removeClass("requerido");

        }
    });

/*     $("#si_cargo").change(function () {

        if (this.value == 1) {

            $("#cargo").addClass("obligatorio");
            $("#cargo").addClass("requerido");

        } else {


            $("#cargo").removeClass("obligatorio");
            $("#cargo").removeClass("requerido");

        }
    }); */


});

function empleado_si() {
    if ($('#si_empleado').val() == 1) {

        if ($('#empleado')) $('#empleado').attr("disabled", "");

    } else if ($('#si_empleado').val() == 'ALL') {

        if ($('#empleado')) $('#empleado').attr("disabled", "true");
        $('#empleado').val('');
        $('#empleado_id').val('');
    }
}

/* function cargo_si() {
    if ($('#si_cargo').val() == 1) {

        if ($('#cargo')) $('#cargo').attr("disabled", "");

    } else if ($('#si_cargo').val() == 'ALL') {

        if ($('#cargo')) $('#cargo').attr("disabled", "true");
        $('#cargo').val('');
        $('#cargo_id').val('');
    }
} */



function OnclickGenerar(formulario) {

    if (ValidaRequeridos(formulario)) {
        var QueryString = "reporteIncapacidadesResultClass.php?" + FormSerialize(formulario);
        $("#frameReporte").attr("src", QueryString);
        showDivLoading();
        $("#frameReporte").load(function (response) { removeDivLoading(); });
    }
}
function IncapacidadesOnReset(formulario) {
    $("#frameReporte").attr("src", "../../../framework/tpl/blank.html");
    Reset(formulario);
    clearFind();
    /*$("#estado").val('A');
    $('#cargo_id').attr("disabled", "");
    $('#cargo').attr("disabled", ""); */
    if ($('#guardar')) $('#guardar').attr("disabled", "");
    if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
    if ($('#borrar')) $('#borrar').attr("disabled", "true");
    if ($('#limpiar')) $('#limpiar').attr("disabled", "");
}

function setIndicadores() {

    $("#indicadores").change(function () {

        if (this.value == 'S') {
            $("#graficos").css("display", "");
            $("#generar").css("display", "none");
        } else if (this.value == 'N') {
            $("#graficos").css("display", "none");
            $("#generar").css("display", "");
        } else {
            $("#graficos,#generar").css("display", "none");
        }

    });

}

function mostrarGraficos(formulario) {

    var formulario = this.form;

    if (ValidaRequeridos(formulario)) {

        var hasta     = $('#hasta').val();
        var desde      = $('#desde').val();
        var indicadores = $("#indicadores").val();
        var tipo        = $("#tipo").val();
        var si_empleado =    $("#si_empleado").val();
        var empleado_id = $("#empleado_id").val();
        var cie_enfermedades_id = $("#cie_enfermedades_id").val();

        var QueryString = "DetallesindicadoresEnfermedadesClass.php?grafico=SI&indicadores=" + indicadores + "&hasta=" + hasta + "&desde=" + desde + "&empleado_id=" + empleado_id +

            "&si_empleado="+si_empleado+"&cie_enfermedades_id=" + cie_enfermedades_id + "&tipo=" + tipo + "&rand=" + Math.random();

        $("#frameReporte").attr("src", QueryString);
    }

}	



function beforePrint(formulario) {

    if (ValidaRequeridos(formulario)) {
        var QueryString = "reporteIncapacidadesResultClass.php?" + FormSerialize(formulario);
        popPup(QueryString, 'Impresion Reporte', 800, 600);

    }
}




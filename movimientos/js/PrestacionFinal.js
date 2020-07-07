$(document).ready(function(){
	obtenerDetalles();
});

function obtenerDetalles(){
	console.log('test');
	var contador = 0;
	var valor_base_salarial = [];
	$("#tableRegistrar").find("td[name=detalleValor]").each(function(){
		var fila = this.parentNode;
		$(fila).find("input[name=valor_base_salarial]").each(function(){
			var detalle = [];
			detalle.valores = this.value;
			detalle.concepto = $(fila).find("input[name=concepto]").val();
			valor_base_salarial[contador] = detalle;
			//fechas[contador]['concepto'] = $(fila).find("input[name=concepto]").val();
		});
		contador++;
	});
	parent.getPromedioPrest(valor_base_salarial[0].valores, "prom_ces");
	parent.getPromedioPrest(valor_base_salarial[2].valores, "prom_pri");
	console.log(valor_base_salarial);
}
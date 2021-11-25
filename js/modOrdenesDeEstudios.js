$(function(){
	$("#btnBorrarOrdenDeEstudio").button({
		icons : { primary: "ui-icon-trash" }
	}).css({
		float : "right"
	});
	
	$("#btnFiltroFechas").button({
		icons: { primary: "ui-icon-calendar" }
	}).click(function(){
		var fechaInicial = $("#fechaInicial").val();
		if (fechaInicial == "") {
			alert ("Debes ingresar al mennos la fecha inicial.");
			return false;
		}
		if ($("#fechaFinal").val() == "") {
			var fechaFinal = fechaInicial;
		} else { 
			var fechaFinal = $("#fechaFinal").val();
		}
		var url = window.location.protocol + "//" + window.location.hostname + window.location.pathname + "?mod=ordenesDeEstudios&fechaInicial=" + fechaInicial + "&fechaFinal=" + fechaFinal;
		window.location = url;
	});
	
	$("#fechaInicial,#fechaFinal").datepicker({
		changeMonth	: true,
		changeYear	: true,
		dateFormat	: "yy-mm-dd",
		yearRange: ((new Date).getFullYear()-20) + ":" + (new Date).getFullYear()
	});
	
	$("#dlgBorrarOrdenDeEstudio").dialog({
		height: "auto",
		width: "auto",
		modal: true,
		autoOpen: false,
		position: {
			my: "center",
			at: "top"
		}
	});
});

var modOrdenesDeEstudios = angular.module('modOrdenesDeEstudios', []);
modOrdenesDeEstudios.controller('ordenesDeEstudios',function($scope, $http){
	
	var gets = location.search.split("&");
	
	if (gets.length > 1) {
		var fechaInicial = gets[1].split("=");
		var fechaFinal = gets[2].split("=");
		$http.get("php/lib/fnGenerales.php?proceso=ordenesDeEstudios&fechaInicial=" + fechaInicial[1] + "&fechaFinal=" + fechaFinal[1])
		.then(function(response){$scope.ordenesDeEstudios = response.data;});
	} else {
		var fechaActual = new Date();
		var dia = fechaActual.getDate().toString().length == 1 ? "0" + fechaActual.getDate().toString() : fechaActual.getDate().toString();
		var mes= (fechaActual.getMonth()+1).toString().length == 1 ? "0" + (fechaActual.getMonth()+1).toString() : (fechaActual.getMonth()+1).toString();
		var fechaInicial = fechaActual.getFullYear().toString() + "-" + mes + "-" + dia;
		$http.get("php/lib/fnGenerales.php?proceso=ordenesDeEstudios&fechaInicial=" + fechaInicial + "&fechaFinal=" + fechaInicial)
		.then(function(response){$scope.ordenesDeEstudios = response.data;});
	}
	
	$http.get("php/lib/fnGenerales.php?proceso=listaClientes")
	.then(function(response){$scope.clientes = response.data;});
	
	$scope.mostrarBorrarOrden = function(info){
		$scope.borrarOrden = info;
		$("#dlgBorrarOrdenDeEstudio").dialog("open");
	}
	
	$scope.borrarFolioDocto = function (info) {
		info.proceso = "borrarFolioDocto";
		$.ajax({
			data		: info,
			url			: "php/lib/fnGenerales.php",
			type		: "post",
			beforeSend	: function (){
				$("#msjOrdenesDeEstudios").html("Cargando, espere un momento por favor...");
			},
			success		: function (response){
				$("#msjOrdenesDeEstudios").html(response);
			}
		});
	}
	
	$scope.editarOrdenDeEstudio = function(info){
		// var url = window.location.protocol + "//" + window.location.hostname + window.location.pathname + "?mod=ordenDeEstudio&cte=" + info.idCliente + "&folio=" + info.folioCte;
		var url = window.location.protocol + "//" + window.location.hostname + window.location.pathname + "?mod=ordenDeEstudio&folio=" + info.folioDocto;
		window.location = url;
	}
	
	$scope.capturarResultadosDelEstudio = function(info){
		// var url = window.location.protocol + "//" + window.location.hostname + window.location.pathname + "?mod=resultados&cte=" + info.idCliente + "&folio=" + info.folioCte;
		var url = window.location.protocol + "//" + window.location.hostname + window.location.pathname + "?mod=resultados&folio=" + info.folioDocto;
		window.location = url;
	}
});
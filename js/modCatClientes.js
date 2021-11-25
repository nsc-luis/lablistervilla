$(function(){	
	$("#btnNvoCte").button({
		icons: { primary: "ui-icon-plus" }
	});
	
	$("#btnGuardarNvoCte,#btnGuardarCte,#btnGuardarPrecio").button({
		icons: { primary: "ui-icon-disk" }
	}).css({
		float: "right"
	});
		
	$("#btnBorrarCte").button({
		icons: { primary: "ui-icon-trash" }
	}).css({
		float: "right"
	});
	
	$(".btnAgregarExamen").button({
		icons: { primary: "ui-icon-plus" }
	}).css({
		float: "right"
	});
		
	$("#dlgBorrarCte,#dlgEstudiosPaquetesPrecios,#dlgEditarPrecio").dialog({
		height: "auto",
		width: "auto",
		modal: true,
		autoOpen: false,
		position: {
			my: "center",
			at: "top"
		}
	});
	
	$("#dlgFrmCte").dialog({
		height: "auto",
		width: "1100px",
		modal: true,
		autoOpen: false,
		position: {
			my: "center",
			at: "top"
		}
	});
	
	$("#accordionEstudiosPaquetes").accordion({
		collapsible: true,
		heightStyle: "content",
		active: false
	});
});

var modCatClientes = angular.module('catClientes', []);
modCatClientes.controller('listaClientes',function($scope, $http){
	$http.get("php/lib/fnGenerales.php?proceso=listaClientes")
	.then(function(response){$scope.clientes = response.data;});
	
	$scope.nuevoCte = function () {
		$( ".ui-dialog-title" ).html("Nuevo cliente");
		$scope.currentData = {};
		$( "#btnGuardarCte" ).hide();
		$( "#btnGuardarNvoCte" ).show();
		$("#dlgFrmCte").dialog( "open" );
	}
	$scope.editarCte = function (info) {
		$( ".ui-dialog-title" ).html("Editar cliente");
		$scope.currentData = {};
		$scope.currentData = info;
		$( "#btnGuardarNvoCte" ).hide();
		$( "#btnGuardarCte" ).show();
		$("#dlgFrmCte").dialog( "open" );
	};
	$scope.borrarCte = function (info) {
		$scope.currentData = {};
		$scope.currentData = info;
		$("#dlgBorrarCte").dialog( "open" );
	}
	$scope.guardarNvoCte = function(info){
	
		if ( $('#logoCte')[0].files[0] && $('#logoCte')[0].files[0].type != "image/png") {
			return false;
		}
		var parametros = new FormData();
		
		parametros.append('proceso', "nuevoCliente");
		parametros.append('idCliente', info.idCliente);
		parametros.append('nombreCte', info.nombreCte);
		parametros.append('rfcCte', info.rfcCte);
		parametros.append('tel1Cte', info.tel1Cte);
		parametros.append('direccionCte', info.direccionCte);
		parametros.append('folioCte', info.folioCte);
		parametros.append('emailCte', info.emailCte);
		parametros.append('tel1Cte', info.tel1Cte);
		parametros.append('publicarResultados', info.publicarResultados);
		parametros.append('logoCte', $('#logoCte')[0].files[0]);
		parametros.append('logoEnOrden', info.logoEnOrden);
		parametros.append('logoEnResultado', info.logoEnResultado);
		parametros.append('logoEnReporte', info.logoEnReporte);
		parametros.append('cveWebcte', info.cveWebCte);
		parametros.append('passWebCte', info.passWebCte);
		
		$.ajax({
			data	: parametros,
			url		: "php/lib/fnGenerales.php",
			type	: "post",
			cache: false,
			processData: false,		// tell jQuery not to process the data
			contentType: false,		// tell jQuery not to set contentType
			success:  function (response) {
				$("#msjModClientes").html(response);
			}
		});
	}
	$scope.guardarCliente = function(info){
		
		if ( $('#logoCte')[0].files[0] && $('#logoCte')[0].files[0].type != "image/png") {
			return false;
		}
		var parametros = new FormData();
		
		parametros.append('proceso', "guardarCliente");
		parametros.append('idCliente', info.idCliente);
		parametros.append('nombreCte', info.nombreCte);
		parametros.append('rfcCte', info.rfcCte);
		parametros.append('tel1Cte', info.tel1Cte);
		parametros.append('direccionCte', info.direccionCte);
		parametros.append('folioCte', info.folioCte);
		parametros.append('emailCte', info.emailCte);
		parametros.append('tel1Cte', info.tel1Cte);
		parametros.append('publicarResultados', info.publicarResultados);
		parametros.append('logoCte', $('#logoCte')[0].files[0]);
		parametros.append('logoEnOrden', info.logoEnOrden);
		parametros.append('logoEnResultado', info.logoEnResultado);
		parametros.append('logoEnReporte', info.logoEnReporte);
		parametros.append('cveWebCte', info.cveWebCte);
		parametros.append('passWebCte', info.passWebCte);
		
		$.ajax({
			data	: parametros,
			url		: "php/lib/fnGenerales.php",
			type	: "post",
			cache: false,
			processData: false,		// tell jQuery not to process the data
			contentType: false,		// tell jQuery not to set contentType
			success:  function (response) {
				$("#msjModClientes").html(response);
			}
		});
	}
	$scope.borrarCliente = function(info){
		info.proceso = "borrarCliente";
		$.ajax({
			data	: info,
			url		: "php/lib/fnGenerales.php",
			type	: "post",
			beforeSend: function() {
				$("#msjModClientes").html("Cargando, por favor espere . . .");
			},
			success: function (response) {
				$("#msjModClientes").html(response);
			}
		});
	};
	
	$scope.mostrarDlgEstudiosPaquetesPrecios = function(info){
		$scope.idCliente = info.idCliente;
		$scope.nombreCte = info.nombreCte;
		
		$http.get("php/lib/fnGenerales.php?proceso=relacionCteEstudioPaquetePrecio&idCliente="+info.idCliente)
		.then(function(response){$scope.relacionCteEstudioPaquetePrecio = response.data;});
		
		$http.get("php/lib/fnGenerales.php?proceso=estudiosPorAgregarAlCte&idCliente="+info.idCliente)
		.then(function(response){$scope.estudios = response.data;});
		
		$http.get("php/lib/fnGenerales.php?proceso=paquetesPorAgregarAlCte&idCliente="+info.idCliente)
		.then(function(response){$scope.paquetes = response.data;});
		
		$("#dlgEstudiosPaquetesPrecios").dialog("open");
	}
	
	$scope.agregarEstudioAlCliente = function(info){
		info.proceso = "agregarEstudioAlCliente";
		info.idCliente = $scope.idCliente;
		info.precio = $("input[class="+info.idEstudio+"]").val();
		info.tipoExamen = "Estudio";
		info.agregarEstudioIndividual = "agregarEstudioIndividual";
		$.ajax({
			data	: info,
			url		: "php/lib/fnGenerales.php",
			type	: "post",
			success : function (response) {
				$("#msjModClientes").html(response);
			}
		});
	}
	
	$scope.agregarPaqueteAlCliente = function(info){
		info.proceso = "agregarPaqueteAlCliente";
		info.idCliente = $scope.idCliente;
		info.idPaquete = info.idPaquete;
		info.tipoExamen = "Paquete";
		info.agregarPaqueteIndividual = "agregarPaqueteIndividual";
		info.precio = $("input[class="+info.idPaquete+"]").val();
		$.ajax({
			data	: info,
			url		: "php/lib/fnGenerales.php",
			type	: "post",
			success : function (response) {
				$("#msjModClientes").html(response);
			}
		});
	}
	
	function agregarEstudiosAlCliente(info){
		info = $.parseJSON(info);
		info.proceso = "agregarEstudioAlCliente";
		info.idCliente = $scope.idCliente;
		info.precio = $("input[class="+info.idEstudio+"]").val();
		info.tipoExamen = "Estudio";
		$.ajax({
			data	: info,
			url		: "php/lib/fnGenerales.php",
			type	: "post",
			success : function (response) {
				$("#msjModClientes").html(response);
			}
		});
	}
	
	function agregarPaquetesAlCliente(info){
		info = $.parseJSON(info);
		info.proceso = "agregarPaqueteAlCliente";
		info.idCliente = $scope.idCliente;
		info.idPaquete = info.idPaquete;
		info.tipoExamen = "Paquete";
		info.precio = $("input[class="+info.idPaquete+"]").val();
		$.ajax({
			data	: info,
			url		: "php/lib/fnGenerales.php",
			type	: "post",
			success : function (response) {
				$("#msjModClientes").html(response);
			}
		});
	}
	
	$scope.agregarEstudiosAlCliente = function (){
		$('#dlgAgregarEstudiosAlCte input[type=checkbox]').each(function() {
			if ($(this).is(":checked")) {
				agregarEstudiosAlCliente( $(this).val() );
			}
		});
		alert ("Estudios agregados satisfactoriamente!");
		location.reload(true);
	}
	
	$scope.agregarPaquetesAlCliente = function (){
		$('#dlgAgregarPaquetesAlCte input[type=checkbox]').each(function() {
			if ($(this).is(":checked")) {
				agregarPaquetesAlCliente( $(this).val() );
			}
		});
		alert ("Paquetes agregados satisfactoriamente!");
		location.reload(true);
	}
	
	$scope.borrarEstudioPaqueteDelCte = function(info){
		info.proceso = "borrarEstudioPaqueteDelCte";
		$.ajax({
			data	: info,
			url		: "php/lib/fnGenerales.php",
			type	: "post",
			success : function (response) {
				$("#msjModClientes").html(response);
			}
		});
	}
	
	$scope.mostrarEditarPrecio = function(info){
		$scope.precioEstudioPaquete = {};
		$scope.precioEstudioPaquete = info;
		$("#dlgEditarPrecio").dialog("open");
	}
	
	$scope.guardarPrecio = function(info) {
		info.proceso = "guardarPrecio";
		$.ajax({
			data	: info,
			url		: "php/lib/fnGenerales.php",
			type	: "post",
			success : function (response) {
				$("#msjModClientes").html(response);
			}
		});
	}
	
});

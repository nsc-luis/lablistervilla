$(function(){
	$("#btnNvoPaciente").button({
		icons: { primary: "ui-icon-plus" }
	});
	
	$("#btnGuardarPaciente,#btnGuardarNvoPaciente").button({
		icons: { primary: "ui-icon-disk" }
	}).css({
		float: "right"
	});
		
	$("#btnBorrarPaciente").button({
		icons: { primary: "ui-icon-trash" },
	});
		
	$(".btnEditarPaciente").button({
		icons: { primary: "ui-icon-clipboard" },
		text: false
	}).click(function(){
		$("#dlgEditarPaciente").dialog( "open" );
	});
	
	$(".calFechaDeNacimiento").datepicker({
		changeMonth	: true,
		changeYear	: true,
		yearRange: ((new Date).getFullYear()-100) + ":" + (new Date).getFullYear(),
		dateFormat	: "yy-mm-dd"
	});
	
	$(".btnImprimirPaciente").button({
		icons: { primary: "ui-icon-print" },
		text: false
	}).click(function(){
		alert ("Impresion satisfactoria!");
	});
		
	$("#dlgFrmPaciente").dialog({
		height: "auto",
		width: "1100px",
		modal: true,
		autoOpen: false,
		position: {
			my: "center",
			at: "top"
		}
	});
	
	$("#dlgBorrarPaciente,#dlgHistorialDelPaciente").dialog({
		height: "auto",
		width: "auto",
		modal: true,
		autoOpen: false,
		position: {
			my: "center",
			at: "top"
		}
	});
	
	$("#dlgResultadoBuscarPaciente").dialog({
		height: "auto",
		width: "1024px",
		modal: true,
		autoOpen: false,
		position: {
			my: "center",
			at: "top"
		}
	});
});

var modCatPacientes = angular.module('catPacientes', []);
modCatPacientes.controller('listaPacientes',function($scope, $http){
	$http.get("php/lib/fnGenerales.php?proceso=listaPacientes")
	.then(function(response){$scope.pacientes = response.data;});
	
	$scope.nuevoPaciente = function(){
		$( ".ui-dialog-title" ).html("Nuevo paciente");
		$scope.currentData = {};
		$( "#btnGuardarPaciente" ).hide();
		$( "#btnGuardarNvoPaciente" ).show();
		$("#dlgFrmPaciente").dialog( "open" );
	};
	
	$scope.editarPte = function(info) {
		$( ".ui-dialog-title" ).html("Editar paciente");
		$scope.currentData = info;
		$( "#btnGuardarPaciente" ).show();
		$( "#btnGuardarNvoPaciente" ).hide();
		$("#dlgFrmPaciente").dialog( "open" );
	}
	
	$scope.guardarNvoPaciente = function(info){
		info.proceso = "nuevoPaciente";
		$.ajax({
			data	: info,
			url		: "php/lib/fnGenerales.php",
			type	: "post",
			beforeSend: function() {
				$("#msjModPacientes").html("Cargando, por favor espere . . .");
			},
			success:  function (response) {
				$("#msjModPacientes").html(response);
			}
		});
	};
	
	$scope.guardarPaciente = function(info){
		info.proceso = "guardarPaciente";
		$.ajax({
			data	: info,
			url		: "php/lib/fnGenerales.php",
			type	: "post",
			beforeSend: function() {
				$("#msjModPacientes").html("Cargando, por favor espere . . .");
			},
			success:  function (response) {
				$("#msjModPacientes").html(response);
			}
		});
	};
	
	$scope.borrarPte = function(info) {
		$scope.currentData = {};
		$scope.currentData = info;
		$("#dlgBorrarPaciente").dialog( "open" );
	}
	
	$scope.borrarPaciente = function(info) {
		info.proceso = "borrarPaciente";
		$.ajax({
			data	: info,
			url		: "php/lib/fnGenerales.php",
			type	: "post",
			beforeSend: function() {
				$("#msjModPacientes").html("Cargando, por favor espere . . .");
			},
			success:  function (response) {
				$("#msjModPacientes").html(response);
			}
		});
	}
	
	$scope.buscarPaciente = function() {
		var info = {
			proceso					: "buscarPaciente",
			strBuscarPaciente		: $scope.strBuscarPaciente,
			filtroBuscarPaciente	: $scope.filtroBuscarPaciente
		};
		var parametros = "proceso="+info.proceso+"&strBuscarPaciente="+info.strBuscarPaciente+"&filtroBuscarPaciente="+info.filtroBuscarPaciente;
		$http.get("php/lib/fnGenerales.php?"+parametros)
		.then(function(response){$scope.resultadoDeBusqueda = response.data;});
		$( "#dlgResultadoBuscarPaciente" ).dialog( "open" );
	}
	
	$scope.nvaOrdenDeEstudio = function(info){
		info.proceso = "nvaOrdenDeEstudio";
		$.ajax({
			data	: info,
			url		: "php/lib/fnGenerales.php",
			type	: "post",
			beforeSend: function() {
				$("#msjModPacientes").html("Cargando, por favor espere . . .");
			},
			success:  function (response) {
				$("#msjModPacientes").html(response);
			}
		});
	}
	
	$scope.verHistorialDelPaciente = function (info) {
		$http.get("php/lib/fnGenerales.php?proceso=historialDeEstudiosDelPaciente&idPaciente=" + info.idPaciente)
		.then(function(response){$scope.historialDelPaciente = response.data;});
		$("#dlgHistorialDelPaciente").dialog("open");
	}
	
	$scope.resultadoDeOrdenPDF = function (info) {
		var url = window.location.protocol + "//" + window.location.hostname + "/resultadosEnPDF.php?cveWeb=" + info.claveWebDocto;
		window.location = url;
	}
});

modCatPacientes.controller('listaClientes',function($scope, $http){
	$http.get("php/lib/fnGenerales.php?proceso=listaClientes")
	.then(function(response){$scope.clientes = response.data;});
});

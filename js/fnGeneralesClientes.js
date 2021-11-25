$(function() {
	
	/* SECCION DE CLIENTES */
	
	$("#btnIniciarSesionCliente")
	.button({ icons: { primary : "ui-icon ui-icon-person" } })
	.click(function(){
		var parametros = {
			"proceso"		: "iniciarSesionCliente",
			"cveWebCte" 	: $("#cveWebCte").val(),
			"passWebCte" 	: $("#passWebCte").val()
		}
		$.ajax({
			data	: parametros,
			url		: "php/lib/fnGenerales.php",
			type	: "post",
			success : function (response) {
				$("#msjCliente").html(response);
			}
		});
	});
	
	$(".cerrarSesionCliente")
	.click(function(){
		var parametros = {"proceso" : "cerrarSesionCliente"};
		$.ajax({
			data	: parametros,
			url		: "php/lib/fnGenerales.php",
			type	: "post",
			success : function (response) {
				$("#resultado").html(response);
			}
		});
	});
	
	$("#fechaInicial, #fechaFinal").datepicker({
		changeMonth	: true,
		changeYear	: true,
		dateFormat	: "yy-mm-dd"
	});
	
	$("#dlgHistorialPorFecha,#dlgHistorialPorNoIMSS,#dlgHistorialPorNombre,#dlgOpciones,#dlgInfoCliente").dialog({
		height: "auto",
		width: "auto",
		modal: true,
		autoOpen: false,
		position: {
			my: "center",
			at: "top"
		}
	});
	
	$(".muestraDlgHistorialPorFecha").click(function (){
		$("#dlgHistorialPorFecha").dialog("open");
	});
	
	$(".muestraDlgHistorialPorNoIMSS").click(function (){
		$("#dlgHistorialPorNoIMSS").dialog("open");
	});
	
	$(".muestraDlgHistorialPorNombre").click(function (){
		$("#dlgHistorialPorNombre").dialog("open");
	});
	
	$(".muestraDlgOpciones").click(function (){
		$("#dlgOpciones").dialog("open");
	});
	
	$(".muestraDlgInfoCliente").click(function (){
		$("#dlgInfoCliente").dialog("open");
	});
	
	$("#btnCmdHistorialPacientesPorFecha, #btnCmdHistorialPacientesPorNoIMSS, #btnCmdHistorialPorNombrePaciente")
		.button({
			icons: { primary : "ui-icon ui-icon-search" }
		})
		.css({
			float: "right"
	});
	
	$("#btnCmdHistorialPacientesPorFecha").click(function() {
		if ($("#fechaInicial").val() == "") {
			alert ("Debe ingresar al menos la fecha inicial.");
			return false;
		} else {
			var fechaInicial = $("#fechaInicial").val();
			var fechaFinal = $("#fechaFinal").val() == "" ? $("#fechaInicial").val() : $("#fechaFinal").val();
		}
		var url = window.location.protocol + "//" + window.location.hostname + window.location.pathname + "?mod=historial&filtro=fechas&fechaInicial=" + fechaInicial + "&fechaFinal=" + fechaFinal;
		window.location = url;
	});
	
	$("#btnCmdHistorialPacientesPorNoIMSS").click(function() {
		if ($("#noIMSS").val() == "") {
			alert ("Debe ingresar un número de afiliación (IMSS).");
			return false;
		}
		var url = window.location.protocol + "//" + window.location.hostname + window.location.pathname + "?mod=historial&filtro=noIMSS&noIMSS=" + $("#noIMSS").val();
		window.location = url;
	});
	
	$("#btnCmdHistorialPorNombrePaciente").click(function() {
		if ($("#nombreDelPaciente").val() == "") {
			alert ("Debe ingresar algún nombre para buscar.");
			return false;
		}
		var url = window.location.protocol + "//" + window.location.hostname + window.location.pathname + "?mod=historial&filtro=nombreDelPaciente&nombreDelPaciente=" + $("#nombreDelPaciente").val();
		window.location = url;
	});
	
	
	/* $("#btnCmdCambiarPassWebCte")
	.button({ icons: { primary : "ui-icon ui-icon-disk" } })
	.css({ float: "right" })
	.click(function(){
		if ($("#passWebCte_nva").val() == ""
			|| $("#passWebCte_nva").val() != $("#passWebCte_confirmacion").val()) {
			alert ("Error: \nNo se pueden ingresar contraseñas en blanco o las contraseñas no son iguales.");
			return false;
		}
		var parametros = {
			"proceso" : "cambiarPassWebCte",
			"nvoPassWebCte" : $("#passWebCte_nva").val()
		};
		$.ajax({
			data	: parametros,
			url		: "php/lib/fnGenerales.php",
			type	: "post",
			success : function (response) {
				$("#resultado").html(response);
			}
		});
	}); */
		
	
	$("#btnCmdInfoCliente")
		.button({
			icons: { primary : "ui-icon ui-icon-close" }
		})
		.css({
			float: "right"
		})
		.click (function () {
			$("#dlgInfoCliente").dialog("close");
	});
});

var appPortalClientes = angular.module('portalClientes', []);

appPortalClientes.controller('getInfoCte',function($scope, $http){
	$http.get("php/lib/fnGenerales.php?proceso=getInfoCte")
	.then(function(response){$scope.currentCliente = response.data;});
	
	$scope.cambiarPasswordCte = function (info) {
		alert ("hi");
		
	}
});

appPortalClientes.controller('historialPaciente',function($scope, $http){
	var gets = location.search.split("&");
	var filtro = gets[1].split("=");
	
	switch (filtro[1]) {
		case "fechas":
			var fechaInicial = gets[2].split("=");
			var fechaFinal = gets[3].split("=");
			$scope.infoDelFiltro = "Busqueda filtrada por fechas entre " + decodeURIComponent(fechaInicial[1]) + " y " + decodeURIComponent(fechaFinal[1]);
			$http.get("php/lib/fnGenerales.php?proceso=historialPacientePorFechaPortalCliente&fechaInicial=" + fechaInicial[1] + "&fechaFinal=" + fechaFinal[1])
			.then(function(response){$scope.historialPaciente = response.data;});
		break;
		case "noIMSS":
			var noIMSS = gets[2].split("=");
			$scope.infoDelFiltro = "Busqueda filtrada por número de afiliación (IMSS): " + decodeURIComponent(noIMSS[1]);
			$http.get("php/lib/fnGenerales.php?proceso=historialPacientePorNoIMSSPortalCliente&noIMSS=" + noIMSS[1])
			.then(function(response){$scope.historialPaciente = response.data;});
		break;
		case "nombreDelPaciente":
			var nombreDelPaciente = gets[2].split("=");
			$scope.infoDelFiltro = "Busqueda filtrada por nombre del paciente: " + decodeURIComponent(nombreDelPaciente[1]);
			$http.get("php/lib/fnGenerales.php?proceso=historialPorNombrePacientePortalCliente&nombreDelPaciente=" + nombreDelPaciente[1])
			.then(function(response){$scope.historialPaciente = response.data;});
		break;
	}
	
	$scope.resultadoEnPDF = function (info) {
		var url = window.location.protocol + "//" + window.location.hostname + "/resultadosEnPDF.php?cveWeb=" + info.claveWebDocto;
		window.location = url;
	}
});

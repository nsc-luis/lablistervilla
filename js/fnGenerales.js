$(function() {
	$( "#ingresoBtn" ).button({
		icons : {primary : "ui-icon-key"}
	}).click(function(){
		if ( $( "#txtUser" ).val() == "" 
			|| $( "#txtPass" ).val() == "" )
		{
				alert ("Debe proporcionar un usuario y/o contraseña.")
		} else {
			parametros = {
				"proceso"	: "login",
				"txtUser"	: $( "#txtUser" ).val(),
				"txtPass"	: $( "#txtPass" ).val()
			};
			$.ajax({
				data	: parametros,
				url		: "php/lib/fnGenerales.php",
				type	: "post",
				success:  function (response) {
					$("#resultado").html(response);
				}
			});
		}
	}).css({
		"font-size": "14px",
		"font-weight": "bold"
	});
	
	$(".cerrarSesion").click(function(){
		parametros = {
		"proceso"	: "cerrarSesion"
		};
		$.ajax({
			data	: parametros,
			url		: "php/lib/fnGenerales.php",
			type	: "post",
			beforeSend: function() {
				$("#resultado").html("Cargando, por favor espere . . .");
			},
			success:  function (response) {
				$("#resultado").html(response);
			}
		});
	});
	
	$("#perfilDeUsuario, #gestionDeUsuarios, #ventasPorCliente").click(function(){
		alert ("Esta opcion aun no esta disponible! :-)");
	});
	
	/* SECCION DEL PORTAL DEL PACIENTE */
	
	$("#btnInfoDelPaciente").button().css({
		float: "right"
	});
	
	$("#dlgInfoDelPaciente,#dlgOpcionesDelPaciente,#dlgFiltroHistorialDeEstudios,#imgInfoClaveWeb,#dlgHistorialDeEstudios").dialog({
		height: "auto",
		width: "auto",
		modal: true,
		autoOpen: false,
		position: {
			my: "center",
			at: "top"
		}
	});
	
	$("#btnBuscarClaveWeb").button({
		icons: { primary : "ui-icon ui-icon-arrowthick-1-s" }
	}).css({
		float: "right",
		marginRight: "80px"
	});
	
	$("#btnIniciarSesionPaciente").button({
		icons: { primary : "ui-icon-person" }
	}).css({
		float: "right",
		marginRight: "80px"
	}).click(function(){
		parametros = {
			"proceso"	: "loginPaciente",
			"txtCvePaciente"	: $( "#txtCvePaciente" ).val(),
			"txtPassPaciente"	: $( "#txtPassPaciente" ).val()
		};
		$.ajax({
			data	: parametros,
			url		: "php/lib/fnGenerales.php",
			type	: "post",
			beforeSend: function() {
				$("#msjLoginPaciente").html("Cargando, por favor espere . . .");
			},
			success:  function (response) {
				$("#msjPaciente").html(response);
			}
		});
	});
	
	$("#btnInfoClaveweb").click(function(){
		$("#imgInfoClaveWeb").dialog("open");
	});
	
	$("#btnBuscarClaveWeb").click(function(){
		if ($("#txtCveWeb").val() == "") { 
			alert ("Debe propurcionar la ClaveWeb del estudio.");
		} else {
			var params = {
				proceso:	"buscarResultadoPorClaveWeb",
				cveWeb:		$("#txtCveWeb").val()
			}
			$.ajax({
				data:	params,
				url		: "php/lib/fnGenerales.php",
				type	: "post",
				success:  function (response) {
					$("#msjPaciente").html(response);
				}
			});
		}
	});
	
	$(".cerrarSesionPaciente").click(function(){
		var params = { proceso : "cerrarSesionPaciente" }
		$.ajax({
			data	: params,
			url		: "php/lib/fnGenerales.php",
			type	: "post",
			beforeSend: function() {
				$("#resultado").html("Cargando, por favor espere . . .");
			},
			success:  function (response) {
				$("#resultado").html(response);
			}
		});
	});
	
	$(".muestraDlgFiltroDelHistorial").click(function(){
		$("#dlgFiltroHistorialDeEstudios").dialog("open");
	});
	
	$(".muestraDlgOpciones").click(function(){
		$("#dlgOpcionesDelPaciente").dialog("open");
	});
	
	$(".muestraDlgInfoPaciente").click(function(){
		$("#dlgInfoDelPaciente").dialog("open");
	});
	
});

/* var appPortalDelPaciente = angular.module('portalDelPaciente', []);
appPortalDelPaciente.controller('infoDelPaciente',function($scope, $http){
	
	$http.get("php/lib/fnGenerales.php?proceso=infoPaciente")
	.then(function(response){$scope.currentPaciente = response.data;});
	
	$scope.btnOpcionesDelPaciente = function (info) {
		if ( $("#passwordPaciente").val() != $("#confirmacionPasswordPaciente").val() ) {
			alert ("Las contraseñas no coinciden. Favor de verificarlas.");
			return false;
		}
		info.proceso = "opcionesDelPaciente";
			$.ajax({
			data	: info,
			url		: "php/lib/fnGenerales.php",
			type	: "post",
			success:  function (response) {
				$("#msjPaciente").html(response);
			}
		});
	}
	
	$scope.mostrarDlgHistorialDeEstudios = function () {
	$("#dlgFiltroHistorialDeEstudios").dialog("close");
		
	var	fHistorialDeEstudiosMes = $("#fHistorialDeEstudiosMes").val();
	var	fHistorialDeEstudiosYear = $("#fHistorialDeEstudiosYear").val();
	
	var mesEnLetra = "";
	
	switch ($("#fHistorialDeEstudiosMes").val()) {
		case "01":
			mesEnLetra = "enero";
		break;
		case "02":
			mesEnLetra = "febrero";
		break;
		case "03":
			mesEnLetra = "marzo";
		break;
		case "04":
			mesEnLetra = "abril";
		break;
		case "05":
			mesEnLetra = "mayo";
		break;
		case "06":
			mesEnLetra = "junio";
		break;
		case "07":
			mesEnLetra = "julio";
		break;
		case "08":
			mesEnLetra = "agosto";
		break;
		case "09":
			mesEnLetra = "septiembre";
		break;
		case "10":
			mesEnLetra = "octubre";
		break;
		case "11":
			mesEnLetra = "noviembre";
		break;
		case "12":
			mesEnLetra = "diciembre";
		break;
	}
	$(".fHistorialDeEstudiosMes").html(mesEnLetra);
	$(".fHistorialDeEstudiosYear").html($("#fHistorialDeEstudiosYear").val());
		
	$http.get("php/lib/fnGenerales.php?proceso=historialDeEstudiosDelPaciente&mes=" + fHistorialDeEstudiosMes + "&year=" + fHistorialDeEstudiosYear)
		.then(function(response){$scope.listaEstudiosHistorico = response.data;});
		
		$("#dlgHistorialDeEstudios").dialog("open");
	}
	
	$scope.btnVerResultadosDelEstudio = function (info) {
		var url = window.location.protocol + "//" + window.location.hostname + "/laboratorio-lister/resultadosEnPDF.php?cveWeb=" + info.claveWebDocto;
		window.location = url;
	}
}); */

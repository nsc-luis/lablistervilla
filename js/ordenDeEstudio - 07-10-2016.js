$(function(){
	$("#btnBorrarOrdenDeEstudio").button({
		icons: { primary: "ui-icon-trash" }
	}).css({
		float: "right"
	});
	
	$("#guardarOrdenEstudio, #btnGuardarPrecioPartida, #btnGuardarResultadoEnTextoLibre").button({
		icons: { primary: "ui-icon-disk" }
	}).css({
		float: "right"
	});
	
	$("#dlgEstudios,#dlgPaquetes,#dlgBorrarEstudioPaquete,#dlgPrecioPartida, #dlgObservacionesDocto,#dlgBorrarOrdenDeEstudio, #dlgResultadoDeTextoLibre").dialog({
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

var modOrdenDeEstudio = angular.module('ordenDeEstudio', []);

modOrdenDeEstudio.filter('edadDelPaciente', function(){
	return function(edadConFraccion) {
		var edad = edadConFraccion.split(".");
		return edad[0];
	}
});

modOrdenDeEstudio.controller('orden',function($scope, $http){
	var gets = location.search.split("&");
	var folioDocto = gets[1].split("=");
	
	$scope.folioDocto = folioDocto[1];
	
	$http.get("php/lib/fnGenerales.php?proceso=orden&folio=" + $scope.folioDocto)
	.then(function(response){$scope.currentOrden = response.data;});
	
	$http.get("php/lib/fnGenerales.php?proceso=partidasDeLaOrden&folio=" + $scope.folioDocto)
	.then(function(response){$scope.partidasDeLaOrden = response.data;});
	
	$scope.mostrarEstudios = function (info){
		$http.get("php/lib/fnGenerales.php?proceso=ods_estudios&idCliente="+info.idCliente)
		.then(function(response){$scope.ods_estudios = response.data;});
		$scope.folioDocto = info.folioDocto;
		$("#dlgEstudios").dialog("open");
	}
	
	$scope.mostrarPaquetes = function (info){
		$http.get("php/lib/fnGenerales.php?proceso=ods_paquetes&idCliente="+info.idCliente)
		.then(function(response){$scope.ods_paquetes = response.data;});
		$scope.folioDocto = info.folioDocto;
		$("#dlgPaquetes").dialog("open");
	}
	
	$scope.agregarEstudioAOrden = function (info){
		info.proceso = "agregarEstudioAOrden";
		info.agregarEstudioIndividual = "si";
		info.folioDocto = $scope.folioDocto;
		$.ajax({
			data		: info,
			url			: "php/lib/fnGenerales.php",
			type		: "post",
			/*beforeSend	: function(){
				$("#msjOrdenDeEstudio").html("Cargando, espere un momento por favor...");
			},*/
			success		: function (response) {
				$("#msjOrdenDeEstudio").html(response);
			}
		});
	}
	
	function agregarEstudioAOrden(info){
		info = $.parseJSON(info);
		info.proceso = "agregarEstudioAOrden";
		info.folioDocto = $scope.folioDocto;
		$.ajax({
			data		: info,
			url			: "php/lib/fnGenerales.php",
			type		: "post",
			/*beforeSend	: function(){
				$("#msjOrdenDeEstudio").html("Cargando, espere un momento por favor...");
			},*/
			success		: function (response) {
				$("#msjOrdenDeEstudio").html(response);
			}
		});
	}
	
	$scope.agregarEstudiosAOrden = function (){
		$('#dlgEstudios input[type=checkbox]').each(function() {
			if ($(this).is(":checked")) {
				agregarEstudioAOrden( $(this).val() );
			}
		});
		location.reload(true);
	}
	
	$scope.agregarPaquetesAOrden = function (){
		$('div#dlgPaquetes input[type=checkbox]').each(function() {
			if ($(this).is(":checked")) {
				agregarEstudioAOrden($(this).val());
			}
		});
		location.reload(true);
	}
	
	$scope.borrarPartidaOrdenDeEstudio = function(info){
		info.proceso = "borrarPartidaOrdenDeEstudio";
		$.ajax({
			data		: info,
			url			: "php/lib/fnGenerales.php",
			type		: "post",
			success		: function (response) {
				$("#msjOrdenDeEstudio").html(response);
			}
		});
	}
	
	
	$scope.mostrarPrecioPartida = function (info){
		$scope.currentPartida = info;
		$("#dlgPrecioPartida").dialog("open")
	}
	
	$scope.guardarPrecioPartida = function(info) {
		info.proceso = "guardarPrecioPartida";
		$.ajax({
			data		: info,
			url			: "php/lib/fnGenerales.php",
			type		: "post",
			beforeSend	: function (){
				$("#msjOrdenDeEstudio").html("Cargando, espere un momento por favor...");
			},
			success		: function (response) {
				$("#msjOrdenDeEstudio").html(response);
			}
		});
	}
	
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
				$("#msjOrdenDeEstudio").html("Cargando, espere un momento por favor...");
			},
			success		: function (response){
				$("#msjOrdenDeEstudio").html(response);
			}
		});
	}
	
	$scope.capturarResultadosDelEstudio = function(info){
		var url = window.location.protocol + "//" + window.location.hostname + window.location.pathname + "?mod=resultados&folio=" + info.folioDocto;
		window.location = url;
	}
	$scope.imprimirOrdenEnPDF = function (info) {
		var url = window.location.protocol + "//" + window.location.hostname + "/laboratorio-lister/ordenEnPDF.php?cveWeb=" + info.claveWebDocto;
		window.location = url;
	}
});
	
modOrdenDeEstudio.controller('resultadosDelEstudio',function($scope, $http){
	var gets = location.search.split("&");
	var folioDocto = gets[1].split("=");
	
	$scope.folioDocto = folioDocto[1];
	
	$http.get("php/lib/fnGenerales.php?proceso=orden&folio=" + $scope.folioDocto)
	.then(function(response){$scope.currentOrden = response.data;});
	
	$http.get("php/lib/fnGenerales.php?proceso=paquetesParaCapturaDeResultados&folio=" + $scope.folioDocto)
	.then(function(response){$scope.paquetesParaCapturaDeResultados = response.data;});
	
	$scope.mostrarObservacionesDocto = function (info){
		$scope.currentObservacion = info;
		$("#dlgObservacionesDocto").dialog("open");
	}
	
	$scope.publicarResultado = function(info) {
		info.proceso = "publicarResultado";
		$.ajax({
			data		: info,
			url			: "php/lib/fnGenerales.php",
			type		: "post",
			success		: function (response) {
				$("#msjResultadoDelEstudio").html(response);
			}
		});
	}
	
	$scope.guardarObservacionDocto = function(info) {
		info.proceso = "guardarObservacionDocto";
		$.ajax({
			data		: info,
			url			: "php/lib/fnGenerales.php",
			type		: "post",
			beforeSend	: function (){
				$("#msjResultadoDelEstudio").html("Cargando, espere un momento por favor...");
			},
			success		: function (response) {
				$("#msjResultadoDelEstudio").html(response);
			}
		});
		$("#dlgObservacionesDocto").dialog("close");
	}
	
	$scope.compararResultadoConLimites = function(estudio) {
		function guardarResultadoValorDeReferencia(){
			estudio.proceso = "guardarResultadoValorDeReferencia";
			$.ajax ({
				data		: estudio,
				url			: "php/lib/fnGenerales.php",
				type		: "post",
				success		: function (response) {
					$("#msjResultadoDelEstudio").html(response);
				}
			});
		}
		
		/* function guardarResultado(referencia){
			estudio.proceso = "guardarResultado";
			estudio.referencia = referencia;
			$.ajax ({
				data		: estudio,
				url			: "php/lib/fnGenerales.php",
				type		: "post",
				success		: function (response) {
					$("#msjResultadoDelEstudio").html(response);
				}
			});
		} */
		
		if (estudio.tipoDeParametro == "limites") {
			if (isNaN(estudio.resultadoValorDeReferencia)) {
				alert ("El resultado de este estudio esta basado en limites, \npor lo tanto solo se aceptan valores numericos.");
				estudio.resultadoValorDeReferencia = "";
				return false;
			}
			
			var resultadoCapturado = parseInt(estudio.resultadoValorDeReferencia);
			var limiteInferior = parseInt(estudio.limiteInferiorEstudio);
			var limiteSuperior = parseInt(estudio.limiteSuperiorEstudio);
			
			/* var referencia = "";
			
			if (resultadoCapturado < limiteInferior) {
				referencia = "resultadoBajoLimites";
				guardarResultado(referencia);
			} else if (resultadoCapturado > limiteSuperior) {
				referencia = "resultadoSobreLimites";
				guardarResultado(referencia);
			} else {
				referencia = "resultadoValorDeReferencia";
				guardarResultado(referencia);
			}*/ 
			
			$("#" + estudio.idOds_EyP + "-limiteInferior").html(resultadoCapturado < limiteInferior ? estudio.resultadoValorDeReferencia : "");
			$("#" + estudio.idOds_EyP + "-resultadoCorrecto").html(resultadoCapturado >= limiteInferior && resultadoCapturado <= limiteSuperior ? estudio.resultadoValorDeReferencia : "");
			$("#" + estudio.idOds_EyP + "-limiteSuperior").html(resultadoCapturado > limiteSuperior ? estudio.resultadoValorDeReferencia : "");
			
			guardarResultadoValorDeReferencia();
			
		} else if (estudio.tipoDeParametro == "textoLibre" && estudio.resultadoValorDeReferencia != "") {
		alert ("El resultado de este estudio debe capturarse como texto libre.\nHaga click en el boton contiguo para iniciar la captura");
			estudio.resultadoValorDeReferencia = "";
			return false;
		} else {
			$("#" + estudio.idOds_EyP + "-resultadoCorrecto").html(estudio.resultadoValorDeReferencia);
			guardarResultadoValorDeReferencia();
			/* referencia = "resultadoValorDeReferencia";
			guardarResultado(referencia); */
		}
	}
	
	$scope.mostrarDlgResultadoEnTextoLibre = function (info) {
		if (info.tipoDeParametro != "textoLibre") {
			alert ("El tipo de resultado de este estudio es basado en: 'limites/valorDeReferencia'.\nNo puede ser capturado como resultado en 'textoLibre'");
			return false;
		}
		$scope.resultadoEnTextoLibre = info;
		$("#dlgResultadoDeTextoLibre").dialog("open");
	}
	$scope.guardarResultadoEnTextoLibre = function (info) {
		info.proceso = "guardarResultadoEnTextoLibre";
		$.ajax ({
			data		: info,
			url			: "php/lib/fnGenerales.php",
			type		: "post",
			beforeSend	: function (){
				$("#msjResultadoDelEstudio").html("Cargando informacion, por favor espere. . .");
			},
			success		: function (response) {
				$("#msjResultadoDelEstudio").html(response);
			}
		});
		$("#dlgResultadoDeTextoLibre").dialog("close");
	}
	$scope.imprimirResultadoPDF = function (info) {
		var url = window.location.protocol + "//" + window.location.hostname + "/laboratorio-lister/resultadosEnPDF.php?cveWeb=" + info.claveWebDocto;
		window.location = url;
	}
});


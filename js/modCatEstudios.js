$(function(){	
	$("#btnNvoEstudio").button({
		icons: { primary: "ui-icon-plus" }
	}).click(function(){
		$("#dlgFrmEstudios").dialog("open");
	});
	
	$("#btnGuardarEstudio, #btnGuardarNvoEstudio").button({
		icons: { primary: "ui-icon-disk" }
	}).css({
		float: "right"
	});
	
	$("#btnNvoParametro,#btnNvaEtiquetaTextoLibre,#btnNvaEtiqueta").button({
		icons: { primary: "ui-icon-plus" }
	});
	
	$("#btnBorrarEstudio").button({
		icons: { primary: "ui-icon-trash" }
	}).css({
		float: "right"
	});
	
	$( "#opcionesDelEstudio" ).accordion({
		collapsible: true,
		heightStyle: "content",
		active: false
    }).css({
		fontFamily: "Asenine !important",
		fontSize: "22px !important",
		margin: "10px"
	});
	
	$("#dlgFrmEstudios,#dlgBorrarEstudio").dialog({
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

var modCatEstudios = angular.module('catEstudios', []);
modCatEstudios.controller('listaEstudios',function($scope, $http){
	$http.get("php/lib/fnGenerales.php?proceso=listaEstudios")
	.then(function(response){$scope.estudios = response.data;});
	
	/* FUNCIONES PARA ESTUDIOS */
	
	$scope.mostrarEditarEstudio = function(info){
		var currentData = {};
		$scope.currentData = info;
		
		$http.get("php/lib/fnGenerales.php?proceso=textoLibreDeEstudio&idEstudio="+info.idEstudio)
		.then(function(response){$scope.etiquetasTextoLibre = response.data;});
		
		$(".ui-dialog-title").html("Editar estudio");
		$("#btnGuardarEstudio").show();
		$("#btnGuardarNvoEstudio").hide();
		$("#dlgFrmEstudios").dialog("open");
	}
	
	$scope.mostrarFrmNvoEstudio = function(){
		var info = {};
		$scope.currentData = info;
		$scope.parametros = {};
		$scope.etiquetasTextoLibre = {};
		$(".ui-dialog-title").html("Nuevo estudio");
		$("#btnGuardarEstudio").hide();
		$("#btnGuardarNvoEstudio").show();
		$("#dlgFrmEstudios").dialog("open");
	}
	
	$scope.mostrarBorrarEstudio = function(info){
		var currentData = {}
		$scope.currentData = info;
		$("#dlgBorrarEstudio").dialog("open");
	}
	
	$scope.guardarNvoEstudio = function(info){
		var currentData = {};
		info.proceso = "guardarNvoEstudio";
		$scope.currentData = info;
		$.ajax({
			data	: $scope.currentData,
			url		: "php/lib/fnGenerales.php",
			type	: "post",
			beforeSend: function(){
				$("#msjModEstudios").html("Cargando, por favor esperar.");
			},
			success: function(response){
				$("#msjModEstudios").html(response);
			}
		});
	}
	
	$scope.guardarEstudio = function(info){
		var currentData = {};
		info.proceso = "guardarEstudio";
		$scope.currentData = info;
		$.ajax({
			data	: $scope.currentData,
			url		: "php/lib/fnGenerales.php",
			type	: "post",
			beforeSend: function(){
				$("#msjModEstudios").html("Cargando, por favor esperar.");
			},
			success: function(response){
				$("#msjModEstudios").html(response);
			}
		});
	}
	
	$scope.eliminarEstudio = function(info){
		var currentData = {};
		info.proceso = "borrarEstudio";
		$scope.currentData = info;
		$.ajax({
			data	: $scope.currentData,
			url		: "php/lib/fnGenerales.php",
			type	: "post",
			beforeSend: function(){
				$("#msjModEstudios").html("Cargando, por favor esperar.");
			},
			success: function(response){
				$("#msjModEstudios").html(response);
			}
		});
	}
});
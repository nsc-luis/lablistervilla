$(function(){	
	$("#btnNvoPaquete").button({
		icons: { primary: "ui-icon-plus" }
	});
	
	$("#btnGuardarNvoPaquete, #btnGuardarPaquete").button({
		icons: { primary: "ui-icon-disk" }
	}).css({
		float: "right"
	});
	
	$("#btnAgregarEstudios").button({
		icons: { primary: "ui-icon-plus" }
	}).css({
		float: "right"
	});
	
	$("#btnBorrarPaquete").button({
		icons: { primary: "ui-icon-trash" }
	}).css({
		float: "right"
	});
		
	$("#dlgFrmPaquete, #dlgBorrarPaquete, #dlgAgregarEstudiosAlPaquete").dialog({
		height: "auto",
		width: "auto",
		modal: true,
		autoOpen: false,
		position: {
			my: "center",
			at: "top"
		}
	});
	$( "#acordionEstudios" ).accordion({
		collapsible: true,
		heightStyle: "content",
		active: 0
    }).css({
		fontFamily: "Asenine !important",
		fontSize: "22px !important",
		margin: "10px"
	});
});
var modCatPaquetes = angular.module('catPaquetes', []);
modCatPaquetes.controller('listaPaquetes',function($scope, $http){
	$http.get("php/lib/fnGenerales.php?proceso=listaPaquetes")
	.then(function(response){$scope.paquetes = response.data;});
	
	$scope.mostrarFrmPaquete = function(info){
		$scope.currentData = {};
		$scope.currentData = info;
		$("#btnGuardarNvoPaquete").hide();
		$("#btnGuardarPaquete").show();
		$(".ui-dialog-title").html("Editar paquete");
		$("#dlgFrmPaquete").dialog("open");
	}
	
	$scope.guardarPaquete = function(info){
		info.proceso = "guardarPaquete";
		$.ajax({
			data	: info,
			url		: "php/lib/fnGenerales.php",
			type	: "post",
			beforeSend : function(){
				$("#msjPaquetes").html("Cargando, por favor espere . . .")
			},
			success	: function(response){
				$("#msjPaquetes").html(response);
			}
		});
	}
	
	$scope.mostrarFrmNvoPaquete = function(info){
		$scope.currentData = {};
		$scope.currentData = info;
		$("#btnGuardarNvoPaquete").show();
		$("#btnGuardarPaquete").hide();
		$(".ui-dialog-title").html("Nuevo paquete");
		$("#dlgFrmPaquete").dialog("open");
	}
	
	$scope.guardarNvoPaquete = function(info){
		info.proceso = "guardarNvoPaquete";
		$.ajax({
			data	: info,
			url		: "php/lib/fnGenerales.php",
			type	: "post",
			beforeSend : function(){
				$("#msjPaquetes").html("Cargando, por favor espere . . .")
			},
			success	: function(response){
				$("#msjPaquetes").html(response);
			}
		});
	}
	
	$scope.mostrarBorrarPaquete = function(info){
		$scope.currentData = {};
		$scope.currentData = info;
		$("#dlgBorrarPaquete").dialog("open");
	}
	
	$scope.borrarPaquete = function(info){
		info.proceso = "borrarPaquete";
		$.ajax({
			data	: info,
			url		: "php/lib/fnGenerales.php",
			type	: "post",
			beforeSend : function(){
				$("#msjPaquetes").html("Cargando, por favor espere . . .")
			},
			success	: function(response){
				$("#msjPaquetes").html(response);
			}
		});
	}
	
	$scope.mostrarAgregarEstudios = function(info){
		$http.get("php/lib/fnGenerales.php?proceso=estudiosAgregadosAlPaquete&idPaquete=" + info.idPaquete)
		.then(function(response){$scope.estudiosAgregadosAlPaquete = response.data;});
		
		$scope.currentIdPaquete = info.idPaquete;
		$scope.currentNombrePaquete = info.nombrePaquete;
		
		$http.get("php/lib/fnGenerales.php?proceso=estudiosPorAgregarAlPaquete&idPaquete=" + info.idPaquete)
		.then(function(response){$scope.estudiosPorAgregarAlPaquete = response.data;});
		
		$("#dlgAgregarEstudiosAlPaquete").dialog("open");
	}
	
	$scope.borrarEstudioDelPaquete = function(info) {
		info.idPaquete = $scope.currentIdPaquete;
		info.proceso = "borrarEstudioDelPaquete";
		$.ajax({
			data	: info,
			url		: "php/lib/fnGenerales.php",
			type	: "post",
			success	: function (response){
				$("#msjEstudiosDelPaquete").html(response);
			}
		});
	}
	
	$scope.agregarEstudioAlPaquete = function(info) {
		info.idPaquete = $scope.currentIdPaquete;
		info.proceso = "agregarEstudioAlPaquete";
		info.agregarEstudioIndividual = "agregarEstudioIndividual";
		$.ajax({
			data	: info,
			url		: "php/lib/fnGenerales.php",
			type	: "post",
			success	: function (response){
				$("#msjEstudiosDelPaquete").html(response);
			}
		});
	}
	
	function agregarEstudiosAlPaquete(info) {
		info = $.parseJSON(info);
		info.idPaquete = $scope.currentIdPaquete;
		info.proceso = "agregarEstudioAlPaquete";
		$.ajax({
			data	: info,
			url		: "php/lib/fnGenerales.php",
			type	: "post",
			success	: function (response){
				$("#msjEstudiosDelPaquete").html(response);
			}
		});
	}
	
	$scope.agregarEstudiosAlPaquete = function (){
		$('#dlgAgregarEstudiosAlPaquete input[type=checkbox]').each(function() {
			if ($(this).is(":checked")) {
				agregarEstudiosAlPaquete( $(this).val() );
			}
		});
		alert ("Estudios agregados satisfactoriamente!");
		location.reload(true);
	}
});
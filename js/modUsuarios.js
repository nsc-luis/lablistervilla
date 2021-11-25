$(function() {
	$("#btnNvoUsuario").button({
		icons : {primary : "ui-icon-plus"}
	});
	
	$("#btnGuardarUsr, #btnGuardarNvoUsr").button({
		icons : {primary : "ui-icon-disk"}
	}).css({
		float: "right"
	});
	
	$("#btnBorrarUsuario").button({
		icons : {primary : "ui-icon-trash"}
	}).css({
		float: "right"
	});
	
	$("#dlgBorrarUsuario, #dlgFrmUsuario").dialog({
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

var appUsuarios = angular.module('usuarios', []);
appUsuarios.controller('listaUsuarios',function($scope, $http){
	$http.get("php/lib/fnGenerales.php?proceso=listaUsuarios")
	.then(function(response){$scope.listaUsuarios = response.data;});
	
	$scope.mostrarFrmNvoUsuario = function (){
		var info = {};
		$scope.currentUsr = info;
		$("#btnGuardarNvoUsr").show();
		$("#btnGuardarUsr").hide();
		$("#dlgFrmUsuario").dialog( "open" );
	}
	
	$scope.guardarNvoUsr = function(info){
		info.proceso = "guardarNvoUsr";
		$.ajax({
			data	: info,
			url		: "php/lib/fnGenerales.php",
			type	: "post",
			success	: function (response) {
				$("#msjModUsuarios").html(response);
			}
		});
		$("#dlgFrmUsuario").dialog( "close" );
	}
	
	$scope.mostrarEditarUsuario = function (info){
		$scope.currentUsr = info;
		$("#btnGuardarNvoUsr").hide();
		$("#btnGuardarUsr").show();
		$("#dlgFrmUsuario").dialog( "open" );
	}
	
	$scope.guardarUsr = function(info){
		info.proceso = "guardarUsr";
		$.ajax({
			data	: info,
			url		: "php/lib/fnGenerales.php",
			type	: "post",
			success	: function (response) {
				$("#msjModUsuarios").html(response);
			}
		});
		$("#dlgFrmUsuario").dialog( "close" );
	}
	
	$scope.mostrarBorrarUsuario = function (info){
		$scope.currentUsr = info;
		$("#dlgBorrarUsuario").dialog( "open" );
	}
	
	$scope.borrarUsr = function(info){
		info.proceso = "borrarUsr";
		$.ajax({
			data	: info,
			url		: "php/lib/fnGenerales.php",
			type	: "post",
			success	: function (response) {
				$("#msjModUsuarios").html(response);
			}
		});
	}
	
	$scope.getInfoUsr = function(info){
		info.proceso = "getInfoUsr";
		$.ajax({
			data	: info,
			url		: "php/lib/fnGenerales.php",
			type	: "post",
			success	: function (response) {
				$("#msjModUsuarios").html(response);
			}
		});
	}
});
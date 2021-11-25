$(function() {
	$("#btnRptEstudiosDiariosxCte").button({
		icons: { primary: "ui-icon-search" }
	});
	
	$("#fechaInicial").datepicker({
		changeMonth	: true,
		dateFormat	: "yy-mm-dd"
	});
});

var appReportes = angular.module('reportes', []);
appReportes.controller('rptEstudiosDiariosxCliente',function($scope, $http){
	$http.get("php/lib/fnGenerales.php?proceso=listaClientes")
	.then(function(response){$scope.clientes = response.data;});
	
	$scope.cmdRptEstudiosDiariosxCte = function() {
		var url = window.location.protocol + "//" + window.location.hostname + "/rptEstDiariosxCte.php?idCliente=" + $scope.cliente + "&fechaInicial=" + $scope.fechaInicial;
		window.location = url;
	}
});
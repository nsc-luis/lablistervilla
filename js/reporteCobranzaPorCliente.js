$(function() {
	$("#btnRptCobranzaPorCliente").button({
		icons: { primary: "ui-icon-search" }
	});
	
	$("#fechaInicial, #fechaFinal").datepicker({
		changeMonth	: true,
		dateFormat	: "yy-mm-dd"
	});
});	

var appReportes = angular.module('reportes', []);
appReportes.controller('reporteCobranzaPorCliente',function($scope, $http){
	$http.get("php/lib/fnGenerales.php?proceso=listaClientes")
	.then(function(response){$scope.clientes = response.data;});
	
	$http.get("php/lib/fnGenerales.php?proceso=listaUsuarios")
	.then(function(response){$scope.usuarios = response.data;});
	
	$scope.cmdRptCobranzaPorCliente = function() {
		// alert ($scope.cliente + "\n" + $scope.usuario + "\n" + $scope.fechaInicial + "\n" + $scope.fechaFinal);
		// var url = window.location.protocol + "//" + window.location.hostname + "/rptCobPorCte.php?idCliente=" + $scope.cliente + "&idUsuario=" + $scope.usuario + "&fechaInicial=" + $scope.fechaInicial + "&fechaFinal=" + $scope.fechaFinal;
		// window.location = url;
		
		window.open("rptCobPorCte.php?idCliente=" + $scope.cliente + "&idUsuario=" + $scope.usuario + "&fechaInicial=" + $scope.fechaInicial + "&fechaFinal=" + $scope.fechaFinal, ":: Reporte de cobranza por cliente ::", "directories=no, location=no, menubar=no, scrollbars=yes, statusbar=no, tittlebar=no, width=1024, height=800");
	}
	
	$scope.cmdRptEstudiosPorDia = function() {
		var url = window.location.protocol + "//" + window.location.hostname + "/rptEstudiosPorDia.php?idUsuario=" + $scope.usuario + "&fechaInicial=" + $scope.fechaInicial;
		window.location = url;
	}
	
});
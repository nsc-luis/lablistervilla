$(function() {
	$("#guardarDatosDeLaClinica").button({
		icons : {primary : "ui-icon-disk"}
	});
});	
var datosDeLaClinica = angular.module('clinicas', []);
datosDeLaClinica.controller('infoClinica',function($scope, $http){
	$http.get("php/lib/fnGenerales.php?proceso=infoClinica&idClinica=1")
	.then(function(response){$scope.currentClinica = response.data;});
	
	$scope.guardarDatosDeLaClinica = function(info){
		info.proceso = "guardarDatosDeLaClinica";
		$.ajax({
			data	: info,
			url		: "php/lib/fnGenerales.php",
			type	: "post",
			success	: function (response) {
				$("#msjInfoClinica").html(response);
			}
		});
	}
});
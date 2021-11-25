$(function() {
	
});	
var datosSrvSMTP = angular.module('smtp', []);
datosSrvSMTP.controller('infoSMTP',function($scope, $http){
	$http.get("php/lib/fnGenerales.php?proceso=infoSMTP")
	.then(function(response){$scope.currentSMTP = response.data;});
	
	$scope.guardarDatosSMTP = function(info){
		info.proceso = "guardarDatosSMTP";
		$.ajax({
			data	: info,
			url		: "php/lib/fnGenerales.php",
			type	: "post",
			success	: function (response) {
				$("#msjInfoSMTP").html(response);
			}
		});
	}
});
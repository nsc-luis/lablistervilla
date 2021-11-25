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
	
		if ( $('#logoClinica')[0].files[0] && $('#logoClinica')[0].files[0].type != "image/png"
			|| $('#firmaDelResponsable')[0].files[0] && $('#firmaDelResponsable')[0].files[0].type != "image/png"
			|| $('#imgCedulaDelResponsable')[0].files[0] && $('#imgCedulaDelResponsable')[0].files[0].type != "image/png" ) {
			alert ("Las imagenes para logo/firma/cedula deben estar en formato .png (image/png)");
			return false;
		}
	
		var parametros = new FormData();
		
		parametros.append('proceso', "guardarDatosDeLaClinica");
		parametros.append('idClinica', info.idClinica);
		parametros.append('nombreClinica', info.nombreClinica);
		parametros.append('rfcClinica', info.rfcClinica);
		parametros.append('direccionClinica', info.direccionClinica);
		parametros.append('coloniaClinica', info.coloniaClinica);
		parametros.append('mupioClinica', info.mupioClinica);
		parametros.append('estadoClinica', info.estadoClinica);
		parametros.append('paisClinica', info.paisClinica);
		parametros.append('cpClinica', info.cpClinica);
		parametros.append('emailClinica', info.emailClinica);
		parametros.append('tel1Clinica', info.tel1Clinica);
		parametros.append('responsableClinica', info.responsableClinica);
		parametros.append('cedulaDelResponsable', info.cedulaDelResponsable);
		parametros.append('logoClinica', $('#logoClinica')[0].files[0]);
		parametros.append('firmaDelResponsable', $('#firmaDelResponsable')[0].files[0]);
		parametros.append('imgCedulaDelResponsable', $('#imgCedulaDelResponsable')[0].files[0]);
		
		$.ajax({
			data	: parametros,
			url		: "php/lib/fnGenerales.php",
			type	: "post",
			cache: false,
			processData: false,		// tell jQuery not to process the data
			contentType: false,		// tell jQuery not to set contentType
			success	: function (response) {
				$("#msjInfoClinica").html(response);
			}
		});
	}
});
	<script src="js/infoClinica.js" language="javascript"></script>
	<div id="contenido" ng-app="clinicas" ng-controller="infoClinica">
		<p class="tituloDeSeccion">Datos de la clinica.</p>
		<hr />
		<div id="msjInfoClinica"></div>
		<span ng-repeat="clinica in currentClinica">
			<label>Nombre: </label>
			<input type="text" ng-model="clinica.nombreClinica" value="{{clinica.nombreClinica}}" />
			<label>RFC: </label>
			<input type="text" ng-model="clinica.rfcClinica" value="{{clinica.rfcClinica}}" /><br />
			<label>Telefono: </label>
			<input type="text" ng-model="clinica.tel1Clinica" value="{{clinica.tel1Clinica}}" />
			<label>Direccion: </label>
			<input type="text" ng-model="clinica.direccionClinica" value="{{clinica.direccionClinica}}" /><br />
			<label>Colonia: </label>
			<input type="text" ng-model="clinica.coloniaClinica" value="{{clinica.coloniaClinica}}" />
			<label>Municipio: </label>
			<input type="text" ng-model="clinica.mupioClinica" value="{{clinica.mupioClinica}}" /><br />
			<label>Estado: </label>
			<input type="text" ng-model="clinica.estadoClinica" value="{{clinica.estadoClinica}}" />
			<label>Pais: </label>
			<input type="text" ng-model="clinica.paisClinica" value="{{clinica.paisClinica}}" /><br />
			<label>CodigoPostal: </label>
			<input type="text" ng-model="clinica.cpClinica" value="{{clinica.cpClinica}}" />
			<label>e-mail: </label>
			<input type="text" ng-model="clinica.emailClinica" value="{{clinica.emailClinica}}" /><br />
			<label>Responsable: </label>
			<input type="text" ng-model="clinica.responsableClinica" value="{{clinica.responsableClinica}}" />
			<label>Celula: </label>
			<input type="text" ng-model="clinica.cedulaDelResponsable" value="{{clinica.cedulaDelResponsable}}" />
			<hr />
			<p style="width: 100%; text-align: center;">
				<button ng-click="guardarDatosDeLaClinica(clinica)" class="ui-button ui-corner-all ui-widget">
					<span class="ui-button-icon ui-icon ui-icon-disk"></span>
					<span class="ui-button-icon-space"> </span>
					Guardar
				</button>
			</p>
		</span>
	</div>
	

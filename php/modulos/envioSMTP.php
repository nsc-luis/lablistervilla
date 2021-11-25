	<script src="js/envioSMTP.js" language="javascript"></script>
	<div id="contenido" ng-app="smtp" ng-controller="infoSMTP">
		<p class="tituloDeSeccion">Datos del servidor SMTP (para envio de documentos).</p>
		<hr />
		<div id="msjInfoSMTP"></div>
		<span ng-repeat="srvSMTP in currentSMTP">
			<label>Nom. remitente: </label>
			<input type="text" ng-model="srvSMTP.nombreUsrMail" value="{{srvSMTP.nombreUsrMail}}" /><br />
			<label>E-Mail: </label>
			<input type="text" ng-model="srvSMTP.userEmail" value="{{srvSMTP.userEmail}}" />
			<label>Contraseña: </label>
			<input type="password" ng-model="srvSMTP.passEmail" value="{{srvSMTP.passEmail}}" /><br />
			<label>Servidor SMTP: </label>
			<input type="text" ng-model="srvSMTP.hostSMTP" value="{{srvSMTP.hostSMTP}}" />
			<label>Puerto: </label>
			<input type="text" ng-model="srvSMTP.portSMTP" value="{{srvSMTP.portSMTP}}" /><br />
			<label>¿Autenticacion?: </label>
			<input type="checkbox" ng-model="srvSMTP.authSMTP" ng-checked="srvSMTP.authSMTP" ng-true-value="'1'" ng-false-value="'0'" style="width:185px; text-align: left" />
			<label>Encriptacion: </label>
			<select ng-model="srvSMTP.encriptacionSMTP">
				<option value="0">Ninguno</option>
				<option value="ssl">SSL</option>
				<option value="tls">TLS</option>
			</select>
			<hr />
			<p style="width: 100%; text-align: center;">
				<button ng-click="guardarDatosSMTP(srvSMTP)" class="ui-button ui-corner-all ui-widget">
					<span class="ui-button-icon ui-icon ui-icon-disk"></span>
					<span class="ui-button-icon-space"> </span>
					Guardar
				</button>
			</p>
		</span>
	</div>
	

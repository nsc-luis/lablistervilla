	<script src="js/modUsuarios.js" language="javascript"></script>
	<div id="contenido">
		<p class="tituloDeSeccion">Catálogo de usuarios.</p>
		<hr />
		
		<div ng-app="usuarios" ng-controller="listaUsuarios">
			<button ng-click="mostrarFrmNvoUsuario()" id="btnNvoUsuario">Agregar usuario</button><br />
			<input type="text" placeholder="Filtrar usuarios" ng-model="filtrarUsuarios" style="width: 40%" />
			<div id="msjModUsuarios" class="msjModulo"></div>
			
			<!-- LISTA DE USUARIOS -->
			<table width="100%">
				<tr>
					<th width="20%">Clave</th>
					<th width="50%">Nombre</th>
					<th width="20%">Tipo de usuario</th>
					<th width="10%"></th>
				</tr>
				<tr class="trBD" ng-repeat="usuario in listaUsuarios | filter: filtrarUsuarios">
					<td style="text-align: center">{{usuario.cveUsr}}</td>
					<td>{{usuario.nombreUsr}}</td>
					<td style="text-align: center">{{usuario.nombrePerfil}}</td>
					<td style="text-align: center">
						<button ng-click="mostrarEditarUsuario(usuario)" title="Editar usuario"><span class="ui-icon ui-icon-pencil"></span></button>
						<button ng-click="mostrarBorrarUsuario(usuario)" title="Borrar usuario"><span class="ui-icon ui-icon-trash"></span></button>
					</td>
				</tr>
			</table>
			<div id="dlgFrmUsuario" title="Formulario de usuarios">
				<label>Nombre de usuario: </label>
				<input type="text" ng-model="currentUsr.nombreUsr" placeholder="Nombre Apeidos" value="{{currentUsr.nombreUsr}}"/><br />
				<label>Clave de usuario: </label>
				<input type="text" ng-model="currentUsr.cveUsr" placeholder="Ej: jpalacios" value="{{currentUsr.cveUsr}}"/><br />
				<label>Contraseña: </label>
				<input type="password" ng-model="currentUsr.passUsr" placeholder="Ej: Abc123$" value="{{currentUsr.passUsr}}"/><br />
				<label>Direccion: </label>
				<input type="text" ng-model="currentUsr.direccionUsr" placeholder="Ej: Calle No, Col, Edo, etc" value="{{currentUsr.direccionUsr}}"/><br />
				<label>Telefono1: </label>
				<input type="text" ng-model="currentUsr.tel1Usr" placeholder="83556677" value="{{currentUsr.tel1Usr}}"/><br />
				<label>Telefono1: </label>
				<input type="text" ng-model="currentUsr.tel2Usr" placeholder="8110112233" value="{{currentUsr.tel2Usr}}"/><br />
				<label>e-mail: </label>
				<input type="text" ng-model="currentUsr.emailUsr" placeholder="buzon@dominio.com" value="{{currentUsr.emailUsr}}"/><br />
				<label>Perfil del usuario</label>
				<select ng-model="currentUsr.idPerfil" value="{{currentUsr.idPerfil}}"/>
					<option value="1">Administrador</option>
					<option value="2">Usuario estandar</option>
				</select>
				<hr />
				<button id="btnGuardarNvoUsr" ng-click="guardarNvoUsr(currentUsr)">Guardar</button>
				<button id="btnGuardarUsr" ng-click="guardarUsr(currentUsr)">Guardar</button>
			</div>
			<div id="dlgBorrarUsuario" title="Borrar usuario">
				Esta apunto de borrar el usuario: <strong> {{currentUsr.nombreUsr}} </strong><br />
				¿Deseas continuar?
				<hr />
				<button ng-click="borrarUsr(currentUsr)" id="btnBorrarUsuario">Borrar</button>
			</div>
		</div>
	</div>
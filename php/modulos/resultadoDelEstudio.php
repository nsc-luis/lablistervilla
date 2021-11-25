	<style>
		label { width: 120px; }
	</style>
	<script src="js/ordenDeEstudio.js" language="javascript"></script>
	<div id="contenido" ng-app="ordenDeEstudio">
		<div ng-controller="resultadosDelEstudio">
			<p class="tituloDeSeccion">Resultados del estudio.</p>
			<hr />
			<div ng-repeat="data in currentOrden">
				<label>FOLIO: </label>
				<!-- <input type="text" readonly value="{{data.folioCte}}" /> -->
				<input type="text" readonly value="{{data.folioDocto}}" />
				<label>Clave web: </label>
				<input type="text" readonly value="{{data.claveWebDocto}}" />
				<label>Fecha: </label>
				<input type="text" readonly value="{{data.fechaDocto}}" /> <br />
				<label>Paciente: </label>
				<input type="text" readonly value="{{data.nombreCompletoPaciente}}" />
				<label>No. IMSS: </label>
				<input type="text" readonly value="{{data.noIMSS}}" />
				<label>Edad: </label>
				<input type="text" readonly value="{{data.edadDelPaciente}}" /><br />
				<label>Genero: </label>
				<input type="text" readonly value="{{data.genero}}" />
				<label>e-mail: </label>
				<input type="text" readonly value="{{data.emailPaciente}}" /><br />
				<label>Cliente: </label>
				<input type="text" readonly value="{{data.nombreCte}}" /><br />
				
				<button ng-click="mostrarObservacionesDocto(data)" >Comentarios/observaciones</button>
				<button ng-click="imprimirResultadoPDF(data)">Imprimir resultados</button>
				<!-- <button >Enviar resultados</button> -->
				<button ng-click="regresarALaOrden(data)" >Ir a la orden</button>
				<span style="background-color:#D8D8D8; border: 1px solid gray;" >
					<input type="checkbox" ng-model="data.publicarResultado" ng-checked="data.publicarResultado" ng-true-value="'1'" ng-false-value="'0'" ng-change="publicarResultado(data)" >
					<span style="color:red;">Publicar resultado</span>
				</span>
			</div>
			
			<div id="msjResultadoDelEstudio" class="msjModulo"></div>
			
			<hr />
			
			<div style="width: 100%; border: 1px solid black; background-color: #BDBDBD; text-align: center">
				<strong>R E S U L T A D O S.</strong>
			</div>
			<table width="100%">
				<tr>
					<th width="10%">Clave</th>
					<th width="20%">Nombre</th>
					<th width="15%">Resultado</th>
					<th width="12%">Bajo</th>
					<th width="16%">Resultado / Dentro</th>
					<th width="12%">Sobre</th>
					<th width="15%">Valor de referencia</th>
				</tr>
			</table>
			<div ng-repeat="paquete in paquetesParaCapturaDeResultados" style="border-top: 1px solid black; border-bottom: 1px solid black">
				<span style="font-weigth: bold; font-size: 1.5em;">{{ paquete.nombrePaquete }}</span>
				
				<table width="100%">
					<tr class="trBD" ng-repeat="estudio in paquete.estudios">
						<td style="width: 10%; text-align: center">{{ estudio.cveEstudio }}</td>
						<td width="20%">{{ estudio.nombreEstudio }}</td>
						<td style="width: 15%; text-align: center">
							<input style="width: 80px;" type="text" ng-model="estudio.resultadoValorDeReferencia" value="{{estudio.resultadoValorDeReferencia}}" ng-blur="compararResultadoConLimites(estudio)" />
							<button ng-click="mostrarDlgResultadoEnTextoLibre(estudio)"><span class="ui-icon ui-icon-pencil"></span></button>
						</td>
						
						<!-- <td width="12%">{{estudio.resultadoBajoLimites}}</td>
						<td width="16%">{{estudio.resultadoValorDeReferencia}}{{estudio.textoLibre}}</td>
						<td width="12%">{{estudio.resultadoSobreLimites}}</td> -->
						
						<td width="12%"><span id="{{estudio.idOds_EyP}}-limiteInferior"></span></td>
						<td width="16%"><span id="{{estudio.idOds_EyP}}-resultadoCorrecto"></span>{{estudio.textoLibre}}</td>
						<td width="12%"><span id="{{estudio.idOds_EyP}}-limiteSuperior"></span></td>
						
						<td width="15%">{{ estudio.valorDeReferencia }}</td>
					</tr>
				</table>
			</div>
			<div id="dlgObservacionesDocto" title="Observaciones/comentarios">
				<label>Observaciones: </label> <br />
				<textarea cols="60" rows="15" ng-model="currentObservacion.observacionDocto" >{{currentObservacion.observacionDocto}}</textarea>
				<hr />
				<button ng-click="guardarObservacionDocto(currentObservacion)" id="btnGuardarPrecioPartida">Guardar</button>
			</div>
			<div id="dlgResultadoDeTextoLibre" title="Resultado de libre captura">
				<label>Estudio: </label>{{resultadoEnTextoLibre.nombreEstudio}} <br />
				<textarea cols="60" rows="15" ng-model="resultadoEnTextoLibre.textoLibre" >{{resultadoEnTextoLibre.textoLibre}}</textarea>
				<hr />
				<button ng-click="guardarResultadoEnTextoLibre(resultadoEnTextoLibre)" id="btnGuardarResultadoEnTextoLibre">Guardar</button>
			</div>
		</div>
	</div>
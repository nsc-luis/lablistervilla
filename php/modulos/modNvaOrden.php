	<script src="js/modNvaOrden.js" language="javascript"></script>
	<div id="contenido">
		<p class="tituloDeSeccion">Captura los datos para una nueva orden de servicio.</p>
		<hr />
		<button class="btnBuscarPaciente">Buscar paciente</button> <br />
		<div id="dlgBuscarPaciente" title="Buscar paciente">
			<label>Cadena: </label>
			<input type="text" /> <br />
			<label>Buscar como: </label>
			<select id="condicionBuscarPaciente">
				<option value="nombre">Nombre del paciente</option>
				<option value="cvePaciente">Clave del paciente</option>
				<option value="noIMSS">No. IMSS</option>
			</select>
		</div>
		<label>Nombre: </label>
		<input type="text" value="texto" />
		<label>Apellido paterno*: </label>
		<input type="text" value="texto" />
		<label>Apellido Materno: </label>
		<input type="text" value="texto" /> <br />
		<label>Direccion: </label>
		<input type="text" value="texto" style="width: 50%" /> <br />
		<label>No. IMSS: </label>
		<input type="text" value="texto" /> 
		<label>e-mail: </label>
		<input type="text" value="texto" />
		<label>Telefono1: </label>
		<input type="text" value="texto" /> <br />
		<label>Tipo de cliente: </label>
		<input type="text" value="texto" />
		<hr>
		<button id="btnAddEstudio">Agregar estudio</button>
		<button id="btnAddPaquete">Agregar paquete</button>
		
		<table width="80%">
			<tr>
				<th width="10%">Clave</th>
				<th width="70%">Estudio</th>
				<th width="15%">Importe</th>
				<th width="5%"></th>
			</tr>
			<tr>
				<td style="text-align: center">TRI</td>
				<td>Trigliseridos sericos</td>
				<td style="text-align: right">$ 35.00</td>
				<td style="text-align: center"><button class="btnBorrarPartida">Borrar</button></td>
			</tr>
		</table>
		
		<button id="btnBorrarCaptura">Borrar</button>
		<button id="btnGuardarCaptura">Guardar</button>
		
		<div id="dlgAddEstudio" title="Selecciona el examen">
			<label>Examen: </label>
			<select id="idEstudio">
				<option value="GLU">Glucosa en la sangre</option>
				<option value="TRI">Trigliseridos sericos</option>
			</select>
		</div>
		<div id="dlgAddPaquete" title="Selecciona el paquete">
			<label>Paquete: </label>
			<select id="idPaquete">
				<option value="GLU|TRI">Glucosa|Trigliseridos</option>
			</select>
		</div>
	</div>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>:: Laboratorios Lister ::</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link type="text/css" href="css/jquery-ui.css" rel="stylesheet">
	<link type="text/css" href="css/default2.css" rel="stylesheet">
	<script src="js/jquery.js" language="javascript"></script>
	<script src="js/jquery-ui.min.js" language="javascript"></script>
	<script src="js/angular.min.js" language="javascript"></script>
	<script src="js/fnGenerales.js" language="javascript"></script>
	<script src="js/jquery.cookie.js" language="javascript"></script>
	<style type="text/css">
		main { margin: 30px auto; width: 1024px; }
		main #foo { text-align: center; }
		.claveWebLoginPaciente { 
			width: 500px; 
			height: 150px; 
			display: table-cell; 
			vertical-align: middle; 
		}
		main .bordeIzquierdo { border-left: 2px solid black; }
		#msjClaveWeb { display: none; }
	</style>
	<script type="text/javascript">
		$(function(){
			$("#btnBuscarClaveWeb").button({
				icons: { primary : "ui-icon ui-icon-arrowthick-1-s" }
			}).css({
				float: "right",
				marginRight: "80px"
			});
			$("#btnIniciarSesionPaciente").button({
				icons: { primary : "ui-icon-person" }
			}).css({
				float: "right",
				marginRight: "80px"
			});
			$("#imgInfoClaveWeb").dialog({
				height: "auto",
				width: "auto",
				modal: true,
				autoOpen: false,
				position: {
					my: "center",
					at: "top"
				}
			});
			$("#btnInfoClaveweb").click(function(){
				$("#imgInfoClaveWeb").dialog("open");
			});
			$("#btnBuscarClaveWeb").click(function(){
				if ($("#txtCveWeb").val() == "") { 
					alert ("Debe propurcionar la ClaveWeb del estudio.");
				} else {
					var params = {
						proceso:	"buscarResultadoPorClaveWeb",
						cveWeb:		$("#txtCveWeb").val()
					}
					$.ajax({
						data:	params,
						url		: "php/lib/fnGenerales.php",
						type	: "post",
						/* beforeSend: function() {
							$("#resultado").html("Cargando, por favor espere . . .");
						}, */
						success:  function (response) {
							$("#msjClaveWeb").html(response);
						}
					});
				}
			});
		});
	</script>
</head>
<body>
	<div id="encabezado">
		<div id="encabezadoAreaPrincipal">
			<div class="titulo-logo">
				<img class="imgLogo" src="images/logo_tmp.png" />
				<p class="titulo">Laboratorio de análisis clínicos "Lister".</p>
			</div>
		</div>
	</div>
	<main>
		<div id="foo">
			<div class="claveWebLoginPaciente">
				<label>Ingresa tu clave web: </label>
				<input type="text" placeholder="Ej: 20161015-M3xbgFOkz" id="txtCveWeb" />
				<button id="btnInfoClaveweb"><span class="ui-icon ui-icon-info"></span></button>
				<div id="imgInfoClaveWeb" title="ClaveWeb -> impreso en orden de estudio." >
					<img src="images/infoClaveWeb.png" />
				</div>
				<br /><br />
				<button id="btnBuscarClaveWeb">Descargar</button><br /><br />
				<div id="msjClaveWeb" class="ui-state-error"></div>
			</div>
			<div class="claveWebLoginPaciente bordeIzquierdo">
				<label>Usuario: </label>
				<input type="text" /> <br />
				<label>Contraseña: </label>
				<input type="password" /> <br /> <br />
				<button id="btnIniciarSesionPaciente">Iniciar sesion</button>
			</div>
		</div>
	</main>	
	
	<div id="pieDePagina">
		<div id="pieDePaginaAreaPrincipal">
		</div>
	
	</div>
	</div>
</body>
</html>
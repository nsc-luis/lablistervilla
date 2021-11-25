<?php
	$folioDocto = $_GET['folioDocto'];
	$nombreCompletoPaciente = $_GET['nombreCompletoPaciente'];
	$fechaDocto = $_GET['fechaDocto'];
	$noIMSS = $_GET['noIMSS'] == "undefined" ? "NO CAPTURADO" : $_GET['noIMSS'];
	$clavesEstudiosPaquetes = $_GET['clavesEstudiosPaquetes'];
	
	$html = "
		<html>
			<head>
				<title>Etiqueta folio: {$folioDocto}</title>
				<link href='css/default.css' rel='stylesheet' type='text/css'>
			</head>
			<body>
				<div id='imprimeEtiqueta'>
					{$folioDocto} {$nombreCompletoPaciente} <br />
					Fecha: {$fechaDocto}  <br />
					No. de afiliacion: {$noIMSS}  <br />
					{$clavesEstudiosPaquetes} <br />
					<div id='codigoDeBarras'>
						<img alt='Folio' src='/php/lib/barcode.php?text={$folioDocto}' />
					</div>
				</div>
			</body>
		</html>
	";
	echo $html;
?>
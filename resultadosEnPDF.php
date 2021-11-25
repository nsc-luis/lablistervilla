<?php
	# Incluir librerias de clases
	session_start();
	error_reporting(E_ALL);
	ini_set("display_errors", 1); 
	chdir ("php/lib");
	require_once("dompdf/dompdf_config.inc.php");
	include_once ("cOrdenDeEstudio.php");
	include_once ("cClinicas.php");
	include_once ("cClientes.php");
	
	# Parametros del documento
	$claveWebDocto = $_GET['cveWeb'];
	$idClinica = "1";
	$bd = "labliste_1";
	
	# Obteniendo datos de la clinica
	$clinica = new Clinicas();
	$clinica->bd->setNombreBD($bd);
	
	$datosDeLaClinica = $clinica->getInfoClinica($idClinica);
	foreach ($datosDeLaClinica as $currentClinica) {
		$nombreClinica = $currentClinica['nombreClinica'];
		$rfcClinica = $currentClinica['rfcClinica'];
		$direccionClinica = $currentClinica['direccionClinica'];
		$coloniaClinica = $currentClinica['coloniaClinica'];
		$mupioClinica = $currentClinica['mupioClinica'];
		$estadoClinica = $currentClinica['estadoClinica'];
		$paisClinica = $currentClinica['paisClinica'];
		$cpClinica = $currentClinica['cpClinica'];
		$tel1Clinica = $currentClinica['tel1Clinica'];
		$emailClinica = $currentClinica['emailClinica'];
		$responsableClinica = $currentClinica['responsableClinica'];
		$cedulaDelResponsable = $currentClinica['cedulaDelResponsable'];
	}
	$clinica->bd->cerrarBD();
	
	# Obteniendo datos de la orden/paciente
	$ods = new OrdenDeEstudio();
	$ods->bd->setNombreBD($bd);
	
	$datosDeLaOrden = $ods->ordenEnPDF($claveWebDocto);
	while ($row = mysqli_fetch_assoc($datosDeLaOrden)) {
		$folioDocto = $row['folioDocto'];
		// $folioCte = $row['folioCte'];
		$claveWebDocto = $row['claveWebDocto'];
		$fechaDocto = $row['fechaDocto'];
		$observacionDocto = $row['observacionDocto'];
		$publicarResultado = $row['publicarResultado'];
		$nombreCompletoPaciente = $row['nombreCompletoPaciente'];
		$noIMSS = $row['noIMSS'];
		$genero = $row['genero'];
		$emailPaciente = $row['emailPaciente'];
		$edadDelPaciente = $row['edadDelPaciente'];
		$idCliente = $row['idCliente'];
		// $nombreCte = $row['nombreCte'];
	}
	
	# Obteniendo datos del cliente
	$cte = new Clientes();
	$cte->bd->setNombreBD($bd);
	
	$datosDelCliente = $cte->getInfoCte($idCliente);
	while ($row = mysqli_fetch_assoc($datosDelCliente)) {
		$rfcCte = $row['rfcCte'];
		$direccionCte = $row['direccionCte'];
		$nombreCte = $row['nombreCte'];
		$tel1Cte = $row['tel1Cte'];
		$emailCte = $row['emailCte'];
		$logoEnResultado = $row['logoEnResultado'];
	}
	$cte->bd->cerrarBD();
	
	# Estudio y paquetes incluidos en la orden
	// $ods->setFolioDocto($folioDocto);
	// $ods->setFolioCte($folioCte);
	$ods->setFolioDocto($folioDocto);
	$ods->setIdCliente($idCliente);
	$paquetesParaCapturaDeResultados= $ods->paquetesParaCapturaDeResultados();
	$paquetes = array();
	if (mysqli_num_rows($paquetesParaCapturaDeResultados) !=0) {
		while ($row = mysqli_fetch_assoc($paquetesParaCapturaDeResultados)) {
			$paquetes[] = $row;
		}
	}
	
	$estudios = array();
	for ($i = 0; $i < count($paquetes); $i++) {
	
		$ods->setCvePaquete($paquetes[$i]['cvePaquete']);
		$estudiosParaCapturaDeResultados = $ods->estudiosParaCapturaDeResultados();
		
		if (mysqli_num_rows($estudiosParaCapturaDeResultados) !=0) {
			while ($row = mysqli_fetch_assoc($estudiosParaCapturaDeResultados)) {
				$estudios[] = $row;
			}
		}
		$paquetes[$i] = $paquetes[$i] + array("estudios"=>$estudios);
		$estudios = "";
	}
	
	$logo = $logoEnResultado == "1" ? "/php/lib/blobLogoCte.php?idCliente=" . $idCliente : "/php/lib/blobLogoClinica.php";
	$firmaDelResponsable = "/php/lib/blobFirmaDelResponsable.php";
	$imgCedulaDelResponsable = "/php/lib/blobImgCedulaDelResponsable.php";
	
	# Armando el documento
	$htmlEncabezado = '
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<title>:: Laboratorios Lister ::</title>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<style type="text/css">
				@page { margin-top: 290px; margin-bottom: 80px; }
				body { font-family: arial; font-size: 12px; }
				p { margin: 0px; padding: 0px; }
				table { font-family: arial; font-size: 12px; margin: 0px; padding: 0px; width: 100%; }
				table td { vertical-align: top; }
				.titulo1 { text-decoration: underline; font-style: italic; font-weight: bold; }
				.titulo2 { margin-top: 0px; padding: 0px; letter-spacing: 20px; width: 100%; background-color: black; color: white; clear: both; text-align: center}
				.titulo3 { font-style: italic; font-weight: bold; font-size: 14px; font-family: monospace; }
				.tblEncabezado td { text-align: center; }
				.tblEncabezado .tdEstudio { border-bottom: 1px solid black; font-family: monospace; }
				#datosDeLaOrden { width: 49%; }
				#datosDelCliente { width: 49%; }
				#observacionDocto { width: 100%; margin: 20px 0 20px 0; }
				#encabezado { position: fixed; left: 0px; top: -280px; right: 0px; width: 100%; height: 280px; padding-top: 40px;}
				#pieDePagina { position: fixed; left: 0px; bottom: -60px; right: 0px; width: 100%; height: 60px; text-align: center; }
				#pieDePagina .pagina:after { content: counter(page) }
				#responsable { border: 1px solid black; width: 100%; margin: auto; padding: 15px; /* page-break-before: always; */ margin-top: 20px; }
			</style>
		</head>
		<body>
			<div id="encabezado">
				<table>
					<tr>
						<td width="20%">. 
							<img src="http://' . $_SERVER['SERVER_NAME'] . $logo . '" height="95" width="95" />
						</td>
						<td width="80%">
							<strong>' . $nombreClinica . '</strong><br />
							' . $direccionClinica . ', ' . $coloniaClinica . ' C.P.: ' . $cpClinica . '<br />
							' . $mupioClinica . ', ' . $estadoClinica . ', ' . $paisClinica . '<br />
							Tel: ' . $tel1Clinica . ' e-mail: ' . $emailClinica . '<br />
							R.F.C: ' . $rfcClinica . '
						</td>
					</tr>
				</table>
				<table>
					<tr>
						<td id="datosDeLaOrden">
							<span class="titulo1">Datos de la orden / paciente </span><br />
							<strong>Folio: </strong>' . $folioDocto . '   <strong>Clave web: </strong>' . $claveWebDocto . '<br />
							<strong>Paciente: </strong> ' . $nombreCompletoPaciente . '<br />
							<strong>Numero de seguro social (IMSS): </strong> ' . $noIMSS . '<br />
							<strong>Edad del paciente: </strong> ' . $edadDelPaciente . ' <strong>Genero: </strong> ' . $genero . '<br />
							<strong>e-mail del paciente: </strong> ' . $emailPaciente . '<br />
							<strong>Fecha de la orden: </strong> ' . $fechaDocto . '
						</td>
						<td id="datosDelCliente">
							<span class="titulo1">Datos del cliente </span><br />
							<strong>Nombre del cliente: </strong> ' . $nombreCte . '<br />
							<strong>Direccion cliente: </strong> ' . $direccionCte . '<br />
							<strong>e-mail: </strong> ' . $emailCte . '<br />
							<strong>Tel: </strong> ' . $tel1Cte . '<br />
							<strong>R.F.C.: </strong> ' . $rfcCte . '
						</td>
					<tr>
				</table>
				
				<p class="titulo2">RESULTADOS</p>
				<table class="tblEncabezado">
					<tr>
						<td width="25%" style="text-align: left;">PRUEBA</td>
						<td width="15%">BAJO (VR)</td>
						<td width="25%">RESULTADO / DENTRO (VR)</td>
						<td width="15%">SOBRE (VR)</td>
						<td width="20%">Valor de Referencia</td>
					</tr>
				</table>
			</div>
			<div id="pieDePagina">
				<p class="pagina">Página </p>
			</div>
	';
	
	$html = "";
	for ($i=0; $i < count($paquetes); $i++) {
		$html .= '
			
			<span class="titulo3">' . $paquetes[$i]['nombrePaquete'] . '</span>
			<table width="100%" class="tblEncabezado">
		';
		for ($j=0; $j < count($paquetes[$i]['estudios']); $j++) {
			$aliniacion = "center";
			if ($paquetes[$i]['estudios'][$j]['tipoDeParametro'] == "limites") {
				
				if ($paquetes[$i]['estudios'][$j]['resultadoValorDeReferencia'] < $paquetes[$i]['estudios'][$j]['limiteInferiorEstudio']) {
					$resultadoBajoLimite = $paquetes[$i]['estudios'][$j]['resultadoValorDeReferencia'];
					$resultadoNormal = "";
					$resultadoSobreLimite = "";
				}
				if ($paquetes[$i]['estudios'][$j]['resultadoValorDeReferencia'] >= $paquetes[$i]['estudios'][$j]['limiteInferiorEstudio'] 
					&& $paquetes[$i]['estudios'][$j]['resultadoValorDeReferencia'] <= $paquetes[$i]['estudios'][$j]['limiteSuperiorEstudio']) { 
					$resultadoBajoLimite = "";
					$resultadoNormal = $paquetes[$i]['estudios'][$j]['resultadoValorDeReferencia'];
					$resultadoSobreLimite = "";
				}
				if ($paquetes[$i]['estudios'][$j]['resultadoValorDeReferencia'] > $paquetes[$i]['estudios'][$j]['limiteSuperiorEstudio']) {
					$resultadoBajoLimite = "";
					$resultadoNormal = "";
					$resultadoSobreLimite = $paquetes[$i]['estudios'][$j]['resultadoValorDeReferencia'];
				}
			} else if ($paquetes[$i]['estudios'][$j]['tipoDeParametro'] == "textoLibre") {
				$resultadoBajoLimite = "";
				$resultadoNormal = nl2br($paquetes[$i]['estudios'][$j]['textoLibre']);
				$resultadoSobreLimite = "";
				$aliniacion = "left";
			} else {
				$resultadoBajoLimite = "";
				$resultadoNormal = $paquetes[$i]['estudios'][$j]['resultadoValorDeReferencia'];
				$resultadoSobreLimite = "";
			}
			$html .= '
				<tr>
					<td class="tdEstudio" width="25%" style="text-align: left;">' . $paquetes[$i]['estudios'][$j]['nombreEstudio'] . '</td>
					<td class="tdEstudio" width="15%">' . $resultadoBajoLimite . '</td>
					<td class="tdEstudio" width="25%" style="text-align: ' . $aliniacion . ';">' . $resultadoNormal . '</td>
					<td class="tdEstudio" width="15%">' . $resultadoSobreLimite . '</td>
					<td class="tdEstudio" width="20%">' . nl2br($paquetes[$i]['estudios'][$j]['valorDeReferencia']) . '</td>
				</tr>
			';
		}
		$html .= '</table>';
	}
	
	$html .= '		
			<div id="observacionDocto">
				<span class="titulo1">OBSERVACIONES: </span><br />
				' . nl2br($observacionDocto) . '
			</div>
			<div id="responsable">
				<table>
					<tr>
						<td rowspan="2"><img src="http://' . $_SERVER['SERVER_NAME'] . $imgCedulaDelResponsable . '"></td>
						<td>
							Gracias por permitirnos servirle <br />
							Responsable del laboratorio de análisis clínicos <br />
							<strong>' . $responsableClinica . '</strong> / <strong>Cédula profesional: </strong> ' . $cedulaDelResponsable . '
						</td>
					</tr>
					<tr>
						<td><img src="http://' . $_SERVER['SERVER_NAME'] . $firmaDelResponsable . '"></td>
					</tr>
				</table>
			</div>
		</body>
		</html>
	';
	
	if ( !isset($_SESSION['idUsuario']) && !isset($_SESSION['idCliente'])
		&& $publicarResultado == "0" && !isset($_SESSION['idPaciente']) ) {
		$html = 
			'<H3>EL RESULTADO DE LA ClaveWeb: <span class="noDisponibleParaDescarga">'. $claveWebDocto .'
			</span> NO ESTA DISPONIBLE PARA DESCARGA. FAVOR DE COMUNICARSE CON EL LABORATORIO PARA MAYOR INFORMACION.
			</body>
			</html>
		';
	}
	
	$ods->bd->cerrarBD();
	$doctoHTML = $htmlEncabezado . $html;
	// echo $doctoHTML;
	libxml_use_internal_errors(TRUE);
	$dompdf=new DOMPDF();
	$dompdf->load_html($doctoHTML);
	ini_set("memory_limit","128M");
	$dompdf->render();
	$dompdf->stream($claveWebDocto . ".pdf");
?>	
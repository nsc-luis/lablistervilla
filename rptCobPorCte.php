<?php
	# Incluir librerias de clases
	session_start();
	if (!$_SESSION['idUsuario']) {
		header("location:http://" . $_SERVER['SERVER_NAME'] . "/index.php");
	}
	error_reporting(E_ALL);
	ini_set("display_errors", 1); 
	chdir ("php/lib");
	// require_once("dompdf/dompdf_config.inc.php");
	include_once ("cOrdenDeEstudio.php");
	include_once ("cClinicas.php");
	include_once ("cClientes.php");
	include_once ("cUsuarios.php");
	
	# Parametros del documento
	$idCliente = $_GET['idCliente'];
	$idUsuario = $_GET['idUsuario'];
	$fechaInicial = $_GET['fechaInicial'];
	$fechaFinal = $_GET['fechaFinal'];
	$idClinica = $_SESSION['idClinica'];
	$bd = $_SESSION['bd'];
	
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
		$logoEnReporte = $row['logoEnReporte'];
	}
	$cte->bd->cerrarBD();
	
	
	# Obteniendo datos del usuario
	$usr = new Usuarios();
	$usr->bd->setNombreBD($bd);
	
	$datosUsuario = $usr->getInfoUsr($idUsuario);
	while ($row = mysqli_fetch_assoc($datosUsuario)) {
		$cveUsr = $row['cveUsr'];
		$nombreUsr = $row['nombreUsr'];
	}
	$usr->bd->cerrarBD();
	
	$ods = new OrdenDeEstudio();
	$ods->bd->setNombreBD($bd);
	
	$logo = $logoEnReporte == "1" ? "/php/lib/blobLogoCte.php?idCliente=" . $idCliente : "/php/lib/blobLogoClinica.php";
	
	# Armando el documento (ENCABEZADO)
	$html = '
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<title>:: Laboratorios Lister ::</title>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<style>
				@page {  }
				@media screen {
					div.pieDePagina {
						display: none;
					}
				}
				@media print {
					div.pieDePagina {
						display: none;
					}
					div.btnCtrlNavegacion {
						display: none;
					}
				}
				body { font-family: arial; font-size: 12px; }
				p { margin: 0px; padding: 0px; }
				table { font-family: arial; font-size: 12px; margin: 0px; padding: 0px; width: 100%; }
				table th { color: white; background-color: black }
				table .row { vertical-align: top; border-bottom: 1px solid black; }
				table .importeTotal { font-weigth: bold; color: white; background-color: black; text-align: right; }
				
				#pieDePagina .pagina:after { content: counter(page) }
				hr { page-break-after: always; border: 0; }
				div.btnCtrlNavegacion { position: fixed; right: 0px; }
			</style>
		</head>
		<body>
			<div class="btnCtrlNavegacion">
				<a href="#inicio"><button>Inicio</button></a>
				<a href="#resumen"><button>Resumen</button></a>
				<button class="btnImprimir" onclick="window.print();">Imprimir</button>
			</div>
			<a name="inicio" />
			<div class="encabezado">
				<table>
					<tr>
						<td width="20%" style="text-align: center;">
							<img src="http://' . $_SERVER['SERVER_NAME'] . $logo . '" height="95" width="95" />
						</td>
						<td width="80%">
							<strong>' . $nombreClinica . '</strong><br /><br />
							<strong style="text-decoration: underline; ">REPORTE DE COBRANZA POR CLIENTE. </strong><br />
							<strong>Cliente: </strong>' . $nombreCte . ' <br />
							<strong>Usuario: </strong>' . $nombreUsr . ' <br />
							<strong>Fechas del: </strong>' . $fechaInicial . ' <strong>AL</strong> ' . $fechaFinal . ' <br />
						</td>
					</tr>
				</table>
			</div>
			<div class="pieDePagina">
				<p class="pagina">Página </p>
			</div>
			<table>
				<tr>
					<th width="8%">FOLIO</th>
					<th width="21%">PACIENTE</th>
					<th width="21%">EXAMEN</th>
					<th width="12%">No. AFILIACION</th>
					<th width="9%">FECHA</th>
					<th width="9%">IMPORTE</th>
				</tr>
			</table>
			<table>
	';
	
	# Obteniendo lista de ordenes de estudio
	$listaDeOrdenes = $ods->rptCobPorCte($idUsuario, $idCliente, $fechaInicial, $fechaFinal);
	$ordenes = array();
	while ($row = mysqli_fetch_assoc($listaDeOrdenes)) {
		$ordenes[] = $row;
		// echo $row['idDocumento'];
	}
	
	# Obteniendo partidas de cada orden
	$todosLosExamenes = array();
	$examenes = array();
	for ($i=0; $i<count($ordenes); $i++) {
		// $listaExamenes = $ods->partidasDeLaOrden($idCliente, $ordenes[$i]['folioCte']);
		$listaExamenes = $ods->partidasDeLaOrden($ordenes[$i]['folioDocto']);
		while ($row = mysqli_fetch_assoc($listaExamenes)) {
			$examenes[] = $row;
		}
		$ordenes[$i] = $ordenes[$i] + array("examenes"=>$examenes);
		array_push($todosLosExamenes, $examenes);	// Acumula todos los examenes en un solo arreglo para proceso de suma de totales.
		$examenes = "";
	}
	
	# Armando el documento (IMPRIMIENDO DATOS DE LA ORDEN)
	foreach ($ordenes as $orden) {
		$html .= '
			<tr>
				<td width="8%" class="row">' . $orden['folioDocto'] . '</td>
				<td width="21%" class="row">' . $orden['nombreCompletoPaciente'] . '</td>
				<td width="21%" class="row">
		';
		
		# Armando el documento (IMPRIMIENDO PARTIDAS DE CADA ORDEN)
		foreach ($orden['examenes'] as $examen) {
			$nombreExamen = $examen['nombreEstudio'] == "" ? $examen['nombrePaquete'] : $examen['nombreEstudio'];
			$html .= $nombreExamen . '<br />';
		}
		$html .= '
				</td>
				<td width="12%" style="text-align: right" class="row">' . $orden['noIMSS'] . '</td>
				<td width="9%" style="text-align: center" class="row">' . $orden['fechaDocto'] . '</td>
				<td width="9%" style="text-align: right" class="row">
		';
		foreach ($orden['examenes'] as $examen) {
			$html .= $examen['precio'] . '<br />';
		}
		$html .= '
				</td>
			</tr>
		';
	}
	
	$sumaTotales = $ods->totalRptCobPorCte($idUsuario, $idCliente, $fechaInicial, $fechaFinal);
	$total = mysqli_fetch_assoc($sumaTotales);
	
	$html .= '
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td class="importeTotal">SUB-TOTAL</td>
					<td style="text-align: right; font-weight: bold">'. $total['total'] .'</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td class="importeTotal">I.V.A.</td>
					<td style="text-align: right; font-weight: bold">'. sprintf("%01.2f", ($total['total']*0.16)) .'</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td class="importeTotal">TOTAL</td>
					<td style="text-align: right; font-weight: bold">'. sprintf("%01.2f", ($total['total']*1.16)) .'</td>
				</tr>
			</table>
	';
	
	# Procesando los totales de estudios, paquetes y ordenes del reporte.
	$arrEstudios = array();
	$arrPaquetes = array();
	$totalDeEstudios = "";
	$totalDePaquetes = "";
	foreach ($todosLosExamenes as $foo) {
		foreach ($foo as $bar) {
			if ($bar['tipoExamen'] == "Estudio") { 
				$totalDeEstudios = $totalDeEstudios + 1;
				array_push($arrEstudios, $bar['nombreEstudio']);
			} else {
				$totalDePaquetes = $totalDePaquetes + 1;
				array_push($arrPaquetes, $bar['nombrePaquete']);
			}
		}
	}
	
	$arrEstudios = array_unique($arrEstudios);
	$arrPaquetes = array_unique($arrPaquetes);
	
	$arrTotalDeEstudios = array();
	foreach ($arrEstudios as $estudio) {
		array_push($arrTotalDeEstudios, array("nombreEstudio" => $estudio, "cantidad" => 0, "importe" => 0, "tipoExamen" => "", "precio" => 0));
	}
	
	$arrTotalDePaquetes = array();
	foreach ($arrPaquetes as $paquetes) {
		array_push($arrTotalDePaquetes, array("nombrePaquete" => $paquetes, "cantidad" => 0, "importe" => 0, "tipoExamen" => "", "precio" => 0));
	}
	
	for ($i=0; $i < count($arrTotalDeEstudios); $i++) {
		foreach ($todosLosExamenes as $foo) {
			foreach ($foo as $bar) {
				if ($bar['nombreEstudio'] == $arrTotalDeEstudios[$i]['nombreEstudio']) { 
					$arrTotalDeEstudios[$i]['cantidad'] = $arrTotalDeEstudios[$i]['cantidad'] + 1;
					// $arrTotalDeEstudios[$i]['importe'] = $arrTotalDeEstudios[$i]['importe'] + $bar['precio'];
					$arrTotalDeEstudios[$i]['precio'] = $bar['precio'];
					$arrTotalDeEstudios[$i]['tipoExamen'] = "Estudio";
					
				}
			}
		}
	}
	
	for ($i=0; $i < count($arrTotalDePaquetes); $i++) {
		foreach ($todosLosExamenes as $foo) {
			foreach ($foo as $bar) {
				if ($bar['nombrePaquete'] == $arrTotalDePaquetes[$i]['nombrePaquete']) { 
					$arrTotalDePaquetes[$i]['cantidad'] = $arrTotalDePaquetes[$i]['cantidad'] + 1;
					// $arrTotalDePaquetes[$i]['importe'] = $arrTotalDePaquetes[$i]['importe'] + $bar['precio'];
					$arrTotalDePaquetes[$i]['precio'] = $bar['precio'];
					$arrTotalDePaquetes[$i]['tipoExamen'] = "Paquete";
				}
			}
		}
	}
	
	$html .= '
		<hr />
		<a name="resumen" />
		<div class="encabezado">
				<table>
					<tr>
						<td width="20%" style="text-align: center;">
							<img src="http://' . $_SERVER['SERVER_NAME'] . $logo . '" height="95" width="95" />
						</td>
						<td width="80%">
							<strong>' . $nombreClinica . '</strong><br /><br />
							<strong style="text-decoration: underline; ">REPORTE DE COBRANZA POR CLIENTE. </strong><br />
							<strong>Cliente: </strong>' . $nombreCte . ' <br />
							<strong>Usuario: </strong>' . $nombreUsr . ' <br />
							<strong>Fechas del: </strong>' . $fechaInicial . ' <strong>AL</strong> ' . $fechaFinal . ' <br />
						</td>
					</tr>
				</table>
		</div>
		<strong style="text-decoration: underline;">RESUMEN DE ESTUDIOS y PAQUETES.</strong><br /><br /><br />
		<table>
			<tr>
				<th width="15%">CANTIDAD</th>
				<th width="57%">NOMBRE</th>
				<!-- <th width="20%">TIPO DE EXAMEN</th>
				<th width="20%">IMPORTE</th> -->
				<th width="14%">P. UNITARIO</th>
				<th width="14%">IMPORTE</th>
			</th>
	';
	
	foreach ($arrTotalDeEstudios as $arrEstudio) {
		$html .= '
			<tr>
				<td style="text-align: center" class="row">' . $arrEstudio['cantidad'] . '</td>
				<td class="row">' . $arrEstudio['nombreEstudio'] . '</td>
				<!-- <td style="text-align: center">' . $arrEstudio['tipoExamen'] . '</td>
				<td style="text-align: right">' . sprintf("%01.2f", $arrEstudio['importe']) . '</td> -->
				<td style="text-align: right" class="row">' . $arrEstudio['precio'] . '</td>
				<td style="text-align: right" class="row">' . sprintf("%01.2f", ($arrEstudio['precio']*$arrEstudio['cantidad'])) . '</td>
			</tr>
		';
	}
	
	foreach ($arrTotalDePaquetes as $arrPaquete) {
		$html .= '
			<tr>
				<td style="text-align: center" class="row">' . $arrPaquete['cantidad'] . '</td>
				<td class="row">' . $arrPaquete['nombrePaquete'] . '</td>
				<!-- <td style="text-align: center">' . $arrPaquete['tipoExamen'] . '</td>
				<td style="text-align: right">' . sprintf("%01.2f", $arrPaquete['importe']) . '</td> -->
				<td style="text-align: right" class="row">' . $arrPaquete['precio'] . '</td>
				<td style="text-align: right" class="row">' . sprintf("%01.2f", ($arrPaquete['precio']*$arrPaquete['cantidad'])) . '</td>
			</tr>
		';
	}
	
	$html .= '
			<tr>
				<td></td>
				<td></td>
				<td class="importeTotal">SUB-TOTAL:</td>
				<td style="text-align: right; font-weight: bold;">' . $total['total'] . '</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td class="importeTotal">I.V.A.:</td>
				<td style="text-align: right; font-weight: bold;">' . sprintf("%01.2f", ($total['total']*0.16)) . '</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td class="importeTotal">TOTAL:</td>
				<td style="text-align: right; font-weight: bold;">' . sprintf("%01.2f", ($total['total']*1.16)) . '</td>
			</tr>
		</table><br /><br /><br />
		Total de ordenes de estudio: '. count($ordenes) . '<br />
		<!-- Total de estudios: ' . ($totalDeEstudios + $totalDePaquetes) . '<br />
		Total de paquetes: ' . $totalDePaquetes . '<br /> -->
		Total de estudios: ' . ($totalDeEstudios + $totalDePaquetes) . '<br />
		</body>
		</html>
	';
	
	echo $html;
	/* ini_set("memory_limit","256M");
	libxml_use_internal_errors(TRUE);
	$dompdf=new DOMPDF();
	$dompdf->load_html($html);
	set_time_limit(120);
	$dompdf->render();
	$dompdf->stream("rptCobPorCte.pdf"); */
?>
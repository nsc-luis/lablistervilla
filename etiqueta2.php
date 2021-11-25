<?php
	ini_set ( 'display_errors', 1 );
	error_reporting ( E_ALL );
	// require('php/lib/fpdf.php');
	require('php/lib/code128.php');
	$noIMSS = $_GET['noIMSS'] == "undefined" ? "NO CAPTURADO" : $_GET['noIMSS'];
	  
	// New object created and constructor invoked
	$pdf=new PDF_Code128('L','mm',array('51','26'));
	  
	// Add new pages. By default no pages available.
	$pdf->AddPage();
	 
	// Set font format and font-size
	$pdf->SetFont('Arial');
	$pdf->SetFontSize('6');
	$pdf->SetAutoPageBreak(true,2);
	  
	// Framed rectangular area
	$pdf->SetXY(2,3);
	$pdf->Cell(46,3,$_GET['folioDocto'].' '.$_GET['nombreCompletoPaciente']);
	
	$pdf->SetXY(2,6);
	$pdf->Cell(46, 3, 'Fecha: '.$_GET['fechaDocto']);
	
	// $pdf->Ln();
	$pdf->SetXY(2,9);
	$pdf->Cell(46, 3, 'No. de afiliacion: '.$noIMSS);
	
	// $pdf->Ln();
	$pdf->SetXY(2,12);
	$pdf->Cell(46, 6, $_GET['clavesEstudiosPaquetes']);
	
	// Inserta un logo en la esquina superior izquierda a 300 ppp
	// $pdf->Image("http://lablistervilla.mx/php/lib/barcode.php?text=".$_GET['folioDocto'],10,10,-300,'PNG');
	// $pdf->SetXY(2,15);
	$pdf->Code128(2,18,$_GET['folioDocto'],30,3);
	  
	// Close document and sent to the browser
	$pdf->Output();
	// echo "hi!";
?>
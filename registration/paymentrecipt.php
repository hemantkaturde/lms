<?php
//require('fpdf/fpdf.php');
// $pdf = new FPDF();
// $pdf->AddPage();
// $row=file('toys.txt');
// $pdf->SetFont('Arial','B',12);	
// foreach($row as $rowValue) {
// 	$data=explode(';',$rowValue);
// 	foreach($data as $columnValue)
// 		$pdf->Cell(90,12,$columnValue,1);
// 		$pdf->SetFont('Arial','',12);		
// 		$pdf->Ln();
// }
// $pdf->Output();


  
require('fpdf/fpdf.php');
  
// New object created and constructor invoked
$pdf = new FPDF();
  
// Add new pages. By default no pages available.
$pdf->AddPage();
  
// Set font format and font-size
$pdf->SetFont('Times', 'B', 20);
  
// Framed rectangular area
$pdf->Cell(176, 5, 'Welcome to GeeksforGeeks!', 0, 0, 'C');
  
// Set it new line
$pdf->Ln();
  
// Set font format and font-size
$pdf->SetFont('Times', 'B', 12);
  
// Framed rectangular area
$pdf->Cell(176, 10, 'A Computer Science Portal for geek!', 0, 0, 'C');
  
// Close document and sent to the browser
$pdf->Output();
?>
<?php

// include composer packages
include "vendor/autoload.php";

// Create new Landscape PDF
// $pdf = new FPDI('l');

$pdf = new \setasign\Fpdi\Fpdi('l');

// Reference the PDF you want to use (use relative path)
$pagecount = $pdf->setSourceFile( 'certificate.pdf' );

// Import the first page from the PDF and add to dynamic PDF
$tpl = $pdf->importPage(1);
$pdf->AddPage();

// Use the imported page as the template
$pdf->useTemplate($tpl);

// Set the default font to use
$pdf->SetFont('Helvetica');

// adding a Cell using:
// $pdf->Cell( $width, $height, $text, $border, $fill, $align);

// First box - the user's Name
$pdf->SetFontSize('30'); // set font size
$pdf->SetXY(10, 89); // set the position of the box
$pdf->Cell(0, 10, 'Niraj Shah', 0, 0, 'C'); // add the text, align to Center of cell

// add the reason for certificate
// note the reduction in font and different box position
$pdf->SetFontSize('20');
$pdf->SetXY(80, 105);
$pdf->Cell(150, 10, 'creating an awesome tutorial', 0, 0, 'C');

// the day
$pdf->SetFontSize('20');
$pdf->SetXY(118,122);
$pdf->Cell(20, 10, date('d'), 0, 0, 'C');

// the month
$pdf->SetXY(160,122);
$pdf->Cell(30, 10, date('M'), 0, 0, 'C');

// the year, aligned to Left
$pdf->SetXY(200,122);
$pdf->Cell(20, 10, date('y'), 0, 0, 'L');

// render PDF to browser
$pdf->Output();
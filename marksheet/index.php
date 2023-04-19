<?php

// include composer packages
include "vendor/autoload.php";
include "../db/config.php";
include "phpqrcode/qrlib.php" ;

$student_id = $_GET['student_id'];

$pdf = new \setasign\Fpdi\Fpdi();

$pagecount = $pdf->setSourceFile('marksheet.pdf');

$tpl = $pdf->importPage(1);
$pdf->AddPage();

$pdf->useTemplate($tpl);

$pdf->SetFont('Helvetica');


$pdf->SetFontSize('25','B'); // set font size
$pdf->SetXY(10, 162); // set the position of the box
$pdf->Cell(0, 10,  'daf', 0, 0, 'C'); // add the text, align to Center of cell


$pdf->SetFontSize('10'); // set font size
$pdf->SetXY(110, 205); // set the position of the box
$pdf->Cell(0, 1,  'df', 0, 0, 'C'); // add the text, align to Center of cell

$pdf->SetFontSize('30');
$pdf->SetXY(10, 125);
$pdf->MultiCell(190,11,'sds', '0', 'C', 0);


$pdf->SetFontSize('20');
$pdf->SetXY(165.50,232);

$pdf->Output('marksheet.pdf','I');


?>
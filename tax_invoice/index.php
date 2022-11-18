<?php

// include composer packages
include "vendor/autoload.php";
include "../db/config.php";

$enq_id = $_GET['enq_id'];
$result = $conn->query("SELECT * FROM tbl_payment_transaction  
                        join tbl_enquiry on tbl_payment_transaction.enquiry_id =tbl_enquiry.enq_id 
                        where tbl_payment_transaction.enquiry_id=$enq_id");
$result_arry = $result->fetch_assoc();

// get courses here

// print_r($result_arry['enq_course_id']);
// exit;



// Create new Landscape PDF
// $pdf = new FPDI('l');
$pdf = new \setasign\Fpdi\Fpdi();

// Reference the PDF you want to use (use relative path)
$pagecount = $pdf->setSourceFile( 'tax_invoice.pdf' );

    for ($pageNo = 1; $pageNo <= $pagecount; $pageNo++) {
    // Import the first page from the PDF and add to dynamic PDF
    //$tpl = $pdf->importPage(1);
    $tpl = $pdf->importPage($pageNo);
    $pdf->AddPage();

    $pdf->useTemplate($tpl);
    // Use the imported page as the template
   
     if($pageNo==1){

        // Set the default font to use
        $pdf->SetFont('Helvetica');


        // First box - the user's Name
        $pdf->SetFontSize('8'); // set font size
        $pdf->SetXY(30, 46); // set the position of the box
        $pdf->Cell(100, 1, $result_arry['datetime'], 0, 0, 'L'); // add the text, align to Center of cell


            
        // First box - the user's Name
        $pdf->SetFontSize('8'); // set font size
        $pdf->SetXY(55, 52); // set the position of the box
        $pdf->Cell(160, 10, $result_arry['enq_fullname'], 0, 0, 'L'); // add the text, align to Center of cell


        // Secand box - the user's Name
        $pdf->SetFontSize('8'); // set font size
        $pdf->SetXY(55, 52); // set the position of the box
        $pdf->Cell(160, 21, $result_arry['enq_fullname'], 0, 0, 'L'); // add the text, align to Center of cell
  

         // Secand box - the user's Name
        $pdf->SetFontSize('8'); // set font size
        $pdf->SetXY(55, 52); // set the position of the box
        $pdf->Cell(160, 32, $result_arry['enq_email'], 0, 0, 'L'); // add the text, align to Center of cell


        // Secand box - the user's Name
        $pdf->SetFontSize('8'); // set font size
        $pdf->SetXY(55, 52); // set the position of the box
        $pdf->Cell(160, 43, $result_arry['enq_mobile'], 0, 0, 'L'); // add the text, align to Center of cell


         // Secand box - the user's Name
         $pdf->SetFontSize('8'); // set font size
         $pdf->SetXY(55, 52); // set the position of the box
         $pdf->Cell(160, 54, $result_arry['enq_mobile'], 0, 0, 'L'); // add the text, align to Center of cell
     
         
         // Secand box - the user's Name
         $pdf->SetFontSize('8'); // set font size
         $pdf->SetXY(55, 52); // set the position of the box
         $pdf->Cell(160, 66, $result_arry['payment_mode'], 0, 0, 'L'); // add the text, align to Center of cell

        // adding a Cell using:
        // $pdf->Cell( $width, $height, $text, $border, $fill, $align);

        // add the reason for certificate
        // note the reduction in font and different box position
        // $pdf->SetFontSize('20');
        // $pdf->SetXY(80, 105);
        // $pdf->Cell(150, 10, 'creating an awesome tutorial', 0, 0, 'C');

        // // the day
        // $pdf->SetFontSize('20');
        // $pdf->SetXY(118,122);
        // $pdf->Cell(20, 10, date('d'), 0, 0, 'C');

        // // the month
        // $pdf->SetXY(160,122);
        // $pdf->Cell(30, 10, date('M'), 0, 0, 'C');

        // // the year, aligned to Left
        // $pdf->SetXY(200,122);
        // $pdf->Cell(20, 10, date('y'), 0, 0, 'L');

     }

}

// render PDF to browser
$pdf->Output();
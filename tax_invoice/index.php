<?php

   // include composer packages
   include "vendor/autoload.php";
   include "../db/config.php";

   $enq_id = $_GET['enq_id'];
   $paymentid = $_GET['paymentid'];
   $result = $conn->query("SELECT *,tbl_users.name as counsellor_name  FROM tbl_payment_transaction  
                           join tbl_enquiry on tbl_payment_transaction.enquiry_id =tbl_enquiry.enq_id
                           left join tbl_admission on tbl_admission.enq_id = tbl_enquiry.enq_id 
                           left join tbl_users on tbl_admission.counsellor_name = tbl_users.userId 
                           where tbl_payment_transaction.enquiry_id=$enq_id and tbl_payment_transaction.id=$paymentid");

   $result_arry = $result->fetch_assoc();
   $enquiry_course_ids = $result_arry['enq_course_id'];

   $course_ids    =   explode(',', $enquiry_course_ids);
   $total_fees = 0;
   $course_name = '';
   $i = 1;
   foreach($course_ids as $id)
      {

         $result = $conn->query("SELECT * FROM tbl_course where courseId=$id");
         $get_course_fees = $result->fetch_assoc();
         if($get_course_fees){
                           
            $total_fees += $get_course_fees['course_total_fees'];
            $course_name .= $i.') '.$get_course_fees['course_name'].' ( Rs '.$get_course_fees['course_total_fees']. ')  ';  
            $i++;   

         }else{

            $total_fees = '';
            $course_name = '';  
            $i++;  
         }
                        
       }
      $all_course_name = trim($course_name, ', '); 

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
        $pdf->SetXY(173, 46); // set the position of the box
        $pdf->Cell(160, 1, $result_arry['id'], 0, 0, 'L'); // add the text, align to Center of cell

        // First box - the user's Name
        $pdf->SetFontSize('8'); // set font size
        $pdf->SetXY(55, 52); // set the position of the box
        $pdf->Cell(160, 10, $result_arry['enq_fullname'], 0, 0, 'L'); // add the text, align to Center of cell

        // Secand box - the user's Name
        $pdf->SetFontSize('8'); // set font size
        $pdf->SetXY(55, 52); // set the position of the box
        $pdf->Cell(160, 21, $result_arry['description'], 0, 0, 'L'); // add the text, align to Center of cell
  

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
        $pdf->Cell(160, 54, $result_arry['counsellor_name'], 0, 0, 'L'); // add the text, align to Center of cell
     
         
         // Secand box - the user's Name
        $pdf->SetFontSize('8'); // set font size
        $pdf->SetXY(55, 52); // set the position of the box
        $pdf->Cell(160, 66, $result_arry['payment_mode'], 0, 0, 'L'); // add the text, align to Center of cell

         // Secand box - the user's Name
        $pdf->SetFontSize('8'); // set font size
        $pdf->SetXY(55, 52); // set the position of the box
        $pdf->Cell(10, 78, $all_course_name, 0, 0, 'L'); // add the text, align to Center of cell

        $excluding_GST = $result_arry['totalAmount'] * (18) / 100;
        $cgst_amount = $excluding_GST/2;
        $sgst_amount = $excluding_GST/2;
        $paid_amount = $result_arry['totalAmount']-$excluding_GST;

          // Secand box - the user's Name
        $pdf->SetFontSize('8'); // set font size
        $pdf->SetXY(162, 52); // set the position of the box
        $pdf->Cell(10, 118, $paid_amount, 0, 0, 'L'); // add the text, align to Center of cell
   
         // Secand box - the user's Name
        $pdf->SetFontSize('8'); // set font size
        $pdf->SetXY(162, 52); // set the position of the box
        $pdf->Cell(10, 130, $cgst_amount, 0, 0, 'L'); // add the text, align to Center of cell

         // Secand box - the user's Name
        $pdf->SetFontSize('8'); // set font size
        $pdf->SetXY(162, 52); // set the position of the box
        $pdf->Cell(10, 140, $sgst_amount, 0, 0, 'L'); // add the text, align to Center of cell

         // Secand box - the user's Name
        $pdf->SetFontSize('8'); // set font size
        $pdf->SetXY(162, 52); // set the position of the box
        $pdf->Cell(10, 151, $result_arry['totalAmount'], 0, 0, 'L'); // add the text, align to Center of cell

        /*check paid before amount here*/

        $result_previous_amount = $conn->query("SELECT sum(totalAmount) as totalAmount FROM tbl_payment_transaction where tbl_payment_transaction.enquiry_id=$enq_id and tbl_payment_transaction.id!=$paymentid and tbl_payment_transaction.id < $paymentid ");
        $result_arry_result_previous_amount = $result_previous_amount->fetch_assoc();
       

        if($result_arry_result_previous_amount['totalAmount']){
         $abv = $result_arry_result_previous_amount['totalAmount'];
        }else{
         $abv = 0;
        }

        $pdf->SetFontSize('8'); // set font size
        $pdf->SetXY(162, 52); // set the position of the box
        $pdf->Cell(10, 162, $abv, 0, 0, 'L'); // add the text, align to Center of cell

        $current_value = $conn->query("SELECT sum(totalAmount) as totalAmountcureent FROM tbl_payment_transaction where tbl_payment_transaction.enquiry_id=$enq_id and tbl_payment_transaction.id=$paymentid");
        $current_value_amount = $current_value->fetch_assoc();

        

        $currentbal = $result_arry['final_amount']-($current_value_amount['totalAmountcureent']+$abv);
     


        $pdf->SetFontSize('8'); // set font size
        $pdf->SetXY(162, 52); // set the position of the box
        $pdf->Cell(10, 173,$currentbal , 0, 0, 'L'); // add the text, align to Center of cell


        $pdf->SetFontSize('8'); // set font size
        $pdf->SetXY(162, 52); // set the position of the box
        $pdf->Cell(10, 184, $result_arry['final_amount'], 0, 0, 'L'); // add the text, align to Center of cell
        
        $pdf->SetFontSize('8'); // set font size
        $pdf->SetXY(162, 52); // set the position of the box
        $pdf->Cell(10, 196, $result_arry['prepared_by'], 0, 0, 'L'); // add the text, align to Center of cell


     }

}

// render PDF to browser
$pdf->Output();
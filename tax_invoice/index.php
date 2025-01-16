<?php

   // include composer packages
   include "vendor/autoload.php";
   include "../db/config.php";
   

   $enq_id = $_GET['enq_id'];
   $paymentid = $_GET['paymentid'];
   $result = $conn->query("SELECT *,tbl_users.name as counsellor_name,ab.name as conser_name,tbl_payment_transaction.id as invoice_number  FROM tbl_payment_transaction  
                           join tbl_enquiry on tbl_payment_transaction.enquiry_id =tbl_enquiry.enq_id
                           left join tbl_users ab on tbl_enquiry.counsellor_id = ab.userId 
                           left join tbl_admission on tbl_admission.enq_id = tbl_enquiry.enq_id 
                           left join tbl_users on tbl_admission.counsellor_name = tbl_users.userId
                           where tbl_payment_transaction.enquiry_id=$enq_id and tbl_payment_transaction.id=$paymentid");

   $result_arry = $result->fetch_assoc();
   $enquiry_course_ids = $result_arry['enq_course_id'];

   $paymant_type = $result_arry['paymant_type'];
   $add_on_course_id = $result_arry['add_on_course_id'];
   $enquiry_id = $result_arry['enquiry_id'];
   $gst_number = $result_arry['gst_number'];
   $gst_holder_name = $result_arry['gst_holder_name'];

   if($paymant_type=='regular_invoice'){

        $course_ids    =   explode(',', $enquiry_course_ids);
        $total_fees = 0;
        $course_name = '';
        $i = 1;
        foreach($course_ids as $id)
            {

          
                        $get_course_id_from_add_course = $conn->query("SELECT * from tbl_add_on_courses where enquiry_id=$enquiry_id");
                        $get_add_on_course_id = $get_course_id_from_add_course->fetch_assoc();
 
                        // print_r($get_add_on_course_id['course_id']);


                        // print_r($id);
                        // exit;
                       
                        if($get_add_on_course_id['course_id']==$id){
                          // echo $id.'.55555555';

                        }else{
                     
                              
                        $result = $conn->query("SELECT * FROM tbl_course where courseId=$id");
             
                        $get_course_fees = $result->fetch_assoc();
                        if($get_course_fees){      
                            $total_fees += $get_course_fees['course_total_fees'];
                            $course_name .= $i.') '.$get_course_fees['course_name'].' ( Rs '.$get_course_fees['course_total_fees']. ' )  ';  
                            $i++;   
                        }else{

                            $total_fees = '';
                            $course_name = '';  
                            $i++;  
                        }


                        if($get_course_fees['course_mode_online']==1){
                            $course_mode_online ='Online';
                        }else{
                            $course_mode_online ='';
                        }


                        if($get_course_fees['course_mode_offline']==1){
                            $course_mode_offline = 'Offline';
                        }else{
                            $course_mode_offline = '';
                        }

                        }
                                
                  }
                  $all_course_name = trim($course_name, ', '); 
                  $total_amount_payment_transection =  $result_arry['totalAmount'];
              

      }else{

        $result_add_on_course = $conn->query("SELECT * from tbl_add_on_courses  join tbl_course on tbl_add_on_courses.course_id = tbl_course.courseId  where tbl_add_on_courses.id=$add_on_course_id and tbl_add_on_courses.enquiry_id=$enquiry_id");
         $result_arry_add_on_course = $result_add_on_course->fetch_assoc();
          if($result_arry_add_on_course['course_mode_online']==1){
              $course_mode_online ='Online';
          }else{
              $course_mode_online ='';
          }

          if($result_arry_add_on_course['course_mode_offline']==1){
              $course_mode_offline = 'Offline';
          }else{
              $course_mode_offline = '';
          }

        $all_course_name = $result_arry_add_on_course['course_name'];
        //$total_amount_payment_transection = $result_arry_add_on_course['course_total_fees']-$result_arry_add_on_course['discount'];
        $final_amount = $result_arry_add_on_course['course_total_fees']-$result_arry_add_on_course['discount'];
        $total_amount_payment_transection =  $result_arry['totalAmount'];
      }

       
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
        $pdf->SetXY(20, 54.1); // set the position of the box
        $pdf->Cell(100, 1, $result_arry['datetime'], 0, 0, 'L'); // add the text, align to Center of cell

         // First box - the user's Name
        $pdf->SetFontSize('8'); // set font size
        $pdf->SetXY(174, 54); // set the position of the box
        $pdf->Cell(160, 1, $result_arry['invoice_number'], 0, 0, 'L'); // add the text, align to Center of cell

        // First box - the user's Name
        $pdf->SetFontSize('8'); // set font size
        $pdf->SetXY(50, 60); // set the position of the box
        $pdf->Cell(160, 10, $result_arry['enq_fullname'], 0, 0, 'L'); // add the text, align to Center of cell

        // Secand box - the user's Name
        // $pdf->SetFontSize('8'); // set font size
        // $pdf->SetXY(50, 70); // set the position of the box
        // $pdf->Cell(160, 21, $result_arry['description'], 0, 0, 'L'); // add the text, align to Center of cell
  

         // Secand box - the user's Name
        $pdf->SetFontSize('8'); // set font size
        $pdf->SetXY(50, 54); // set the position of the box
        $pdf->Cell(160, 32, $result_arry['enq_email'], 0, 0, 'L'); // add the text, align to Center of cell


        // Secand box - the user's Name
        $pdf->SetFontSize('8'); // set font size
        $pdf->SetXY(50, 54.5); // set the position of the box
        $pdf->Cell(160, 43, $result_arry['enq_mobile'], 0, 0, 'L'); // add the text, align to Center of cell

        if($result_arry['conser_name']){
          $couns_name= $result_arry['conser_name'];
        }else{
          $couns_name= $result_arry['counsellor_name'];
        }

         // Secand box - the user's Name
        $pdf->SetFontSize('8'); // set font size
        $pdf->SetXY(50, 55); // set the position of the box
        $pdf->Cell(160, 54, $couns_name, 0, 0, 'L'); // add the text, align to Center of cell
     
         
         // Secand box - the user's Name
        $pdf->SetFontSize('8'); // set font size
        $pdf->SetXY(50, 55); // set the position of the box
        $pdf->Cell(160, 66, $result_arry['payment_mode'], 0, 0, 'L'); // add the text, align to Center of cell

         // Secand box - the user's Name
        $pdf->SetFontSize('8'); // set font size
        $pdf->SetXY(50, 91); // set the position of the box
       // $pdf->Cell(0, 80, $all_course_name. ' - ('.$course_mode_online.','.$course_mode_offline.')', 0, 0, 'L'); // add the text, align to Center of cell
       
        $pdf->MultiCell(120,5,$all_course_name. ' - ('.$course_mode_online.','.$course_mode_offline.')',0);       
      

        // Secand box - the user's Name
        $pdf->SetFontSize('8'); // set font size
        $pdf->SetXY(40, 70.5); // set the position of the box
        $pdf->Cell(160, 66, $gst_holder_name, 0, 0, 'L'); // add the text, align to Center of cell


            // Secand box - the user's Name
        $pdf->SetFontSize('8'); // set font size
        $pdf->SetXY(155, 70.5); // set the position of the box
        $pdf->Cell(150, 66,  $gst_number, 0, 0, 'L'); // add the text, align to Center of cell

               
        // $excluding_GST = $result_arry['totalAmount'] * 100 / 118;
      
        // $cgst_amount = $excluding_GST * 9 /100;
        // $sgst_amount = $excluding_GST * 9 /100;

        // $paid_amount = $result_arry['totalAmount']-$excluding_GST;


        $excluding_GST = $total_amount_payment_transection * 100 / 118;
      
        $cgst_amount = $excluding_GST * 9 /100;
        $sgst_amount = $excluding_GST * 9 /100;

        $paid_amount = $total_amount_payment_transection-$excluding_GST;

          // Secand box - the user's Name
        $pdf->SetFontSize('8'); // set font size
        $pdf->SetXY(162, 51); // set the position of the box
        $pdf->Cell(10, 118, 'Rs.'.$total_amount_payment_transection , 0, 0, 'L'); // add the text, align to Center of cell
   
         // Secand box - the user's Name
        $pdf->SetFontSize('8'); // set font size
        $pdf->SetXY(162, 51.5); // set the position of the box
        $pdf->Cell(10, 130, round($cgst_amount,2), 0, 0, 'L'); // add the text, align to Center of cell

         // Secand box - the user's Name
        $pdf->SetFontSize('8'); // set font size
        $pdf->SetXY(162, 52.5); // set the position of the box
        $pdf->Cell(10, 140, round($sgst_amount,2), 0, 0, 'L'); // add the text, align to Center of cell

         // Secand box - the user's Name
        $pdf->SetFontSize('8'); // set font size
        $pdf->SetXY(162, 52.5); // set the position of the box
        // $pdf->Cell(10, 151, 'Rs.'.$result_arry['totalAmount'], 0, 0, 'L'); // add the text, align to Center of cell
        $pdf->Cell(10, 151, round($excluding_GST,2), 0, 0, 'L'); // add the text, align to Center of cell

        /*check paid before amount here*/


        if($paymant_type=='regular_invoice'){

            $result_previous_amount = $conn->query("SELECT sum(totalAmount) as totalAmount FROM tbl_payment_transaction where tbl_payment_transaction.enquiry_id=$enq_id and tbl_payment_transaction.id!=$paymentid and tbl_payment_transaction.id < $paymentid  and paymant_type='regular_invoice'");
            $result_arry_result_previous_amount = $result_previous_amount->fetch_assoc();
          

            if($result_arry_result_previous_amount['totalAmount']){
            $abv = $result_arry_result_previous_amount['totalAmount'];
            }else{
            $abv = 0;
            }
        }else{
            $result_previous_amount = $conn->query("SELECT sum(totalAmount) as totalAmount FROM tbl_payment_transaction where tbl_payment_transaction.enquiry_id=$enq_id and tbl_payment_transaction.id!=$paymentid and tbl_payment_transaction.id < $paymentid and add_on_course_id=$add_on_course_id and paymant_type='add_on_course_invoice'");
            $result_arry_result_previous_amount = $result_previous_amount->fetch_assoc();
          

            if($result_arry_result_previous_amount['totalAmount']){
            $abv = $result_arry_result_previous_amount['totalAmount'];
            }else{
            $abv = 0;
            }
        }

        $pdf->SetFontSize('8'); // set font size
        $pdf->SetXY(162, 52.5); // set the position of the box
        $pdf->Cell(10, 162, $abv, 0, 0, 'L'); // add the text, align to Center of cell



        if($paymant_type=='regular_invoice'){
          $current_value = $conn->query("SELECT sum(totalAmount) as totalAmountcureent FROM tbl_payment_transaction where tbl_payment_transaction.enquiry_id=$enq_id and tbl_payment_transaction.id=$paymentid and paymant_type='regular_invoice'");
          $current_value_amount = $current_value->fetch_assoc();
          $currentbal = $result_arry['final_amount']-($current_value_amount['totalAmountcureent']+$abv);
          //$currentbal =  $total_amount_payment_transection-($current_value_amount['totalAmountcureent']+$abv);
         
        }else{

          

          $current_value = $conn->query("SELECT sum(totalAmount) as totalAmountcureent FROM tbl_payment_transaction where tbl_payment_transaction.enquiry_id=$enq_id and tbl_payment_transaction.id=$paymentid and add_on_course_id=$add_on_course_id and paymant_type='add_on_course_invoice'");
          $current_value_amount = $current_value->fetch_assoc();
          $currentbal =  $final_amount-($current_value_amount['totalAmountcureent']+$abv);
        }
     

        $pdf->SetFontSize('8'); // set font size
        $pdf->SetXY(162, 52.5); // set the position of the box
        $pdf->Cell(10, 173,$currentbal , 0, 0, 'L'); // add the text, align to Center of cell

        if($paymant_type=='regular_invoice'){
          $pdf->SetFontSize('8'); // set font size
          $pdf->SetXY(162, 53); // set the position of the box
          $pdf->Cell(10, 184, $result_arry['final_amount'], 0, 0, 'L'); // add the text, align to Center of cell

        }else{

          $pdf->SetFontSize('8'); // set font size
          $pdf->SetXY(162, 53); // set the position of the box
          $pdf->Cell(10, 184, $final_amount, 0, 0, 'L'); // add the text, align to Center of cell

        }

        if($result_arry['prepared_by']){
          $prepared_by= $result_arry['prepared_by'];
        }else{
          $prepared_by = 'Auto Generated';
        }
        
        $pdf->SetFontSize('8'); // set font size
        $pdf->SetXY(162, 53); // set the position of the box
        $pdf->Cell(10, 196, $prepared_by, 0, 0, 'L'); // add the text, align to Center of cell

        if($paymant_type=='regular_invoice'){
          $number = $result_arry['final_amount'];
        }else{
          $number = $final_amount;
        }

      
      
        $no = floor($number);
        $point = round($number - $no, 2) * 100;
        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $str = array();
        $words = array('0' => '', '1' => 'One', '2' => 'Two',
         '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
         '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
         '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
         '13' => 'Thirteen', '14' => 'Fourteen',
         '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
         '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
         '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
         '60' => 'Sixty', '70' => 'Seventy',
         '80' => 'Eighty', '90' => 'Ninety');
        $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
        while ($i < $digits_1) {
          $divider = ($i == 2) ? 10 : 100;
          $number = floor($no % $divider);
          $no = floor($no / $divider);
          $i += ($divider == 10) ? 1 : 2;
          if ($number) {
             $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
             $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
             $str [] = ($number < 21) ? $words[$number] .
                 " " . $digits[$counter] . $plural . " " . $hundred
                 :
                 $words[floor($number / 10) * 10]
                 . " " . $words[$number % 10] . " "
                 . $digits[$counter] . $plural . " " . $hundred;
          } else $str[] = null;
       }
       $str = array_reverse($str);
       $result = implode('', $str);
       $points = ($point) ?
         "." . $words[$point / 10] . " " . 
               $words[$point = $point % 10] : '';
       $words = $result . "Rupees Only";

       //$words = $result . "Rupees  " . $points . " Paise";

       $pdf->SetFontSize('8'); // set font size
       $pdf->SetXY(43, 59); // set the position of the box
       $pdf->Cell(10, 196, $words, 0, 0, 'L'); // add the text, align to Center of cell


     }

}

// render PDF to browser
$pdf->Output();
<?php
require('fpdf/fpdf.php');
include_once('../db/config.php'); 

// //Select the Products you want to show in your PDF file
$result = "SELECT enq_id,enq_course_id from tbl_enquiry where enq_id =31 ";

$data = $conn->query($result);

if($data->num_rows > 0){ 

    $row = $data->fetch_assoc(); 

    $course_ids =  explode(',',$row['enq_course_id']);

    $total_fees = 0;
    $course_name = '';
    $i = 1;
      foreach($course_ids as $id)
      {
          $get_course_fees = "SELECT * FROM tbl_course where courseId='".$id."' and isDeleted =0" ;
          $course_result = $conn->query($get_course_fees);
          $row_course = $course_result->fetch_assoc(); 
          $total_fees += $row_course['course_total_fees'];
          $course_name .= $i++.'-'.$row_course['course_name'].' (Rs-'.$row_course['course_total_fees'].'),';    
      }

    $all_course_name = trim($course_name, ', ');

    // print_r( $all_course_name );
    // exit;




    class PDF extends FPDF
    {
    // Page header
    function Header()
    {
        // Logo
        $this->Image('../invoices/logo.png',5,10,200);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Move to the right
        $this->Cell(80);
        // Title
        //$this->Cell(30,10,'Title',1,0,'C');
        // Line break
        $this->Ln(20);
    }
    
    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
    }
    
    //Instanciation of inherited class
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',12);

    $pdf->SetXY(15,60);

    $pdf->Cell(20,10,'Transaction Id : ',0,1,'C');

    $pdf->SetXY(150,60);

    $pdf->Cell(20,10,'Date : ',0,1,'C');

    $pdf->SetY(75);
    $width_cell=array(50,50,50,30);
    $pdf->SetFillColor(193,229,252); // Background color of header 
    // Header starts /// 
    $pdf->Cell($width_cell[0],10,'ID',1,0,'C',true); // First header column 
    $pdf->Cell($width_cell[1],10,'NAME',1,0,'C',true); // Second header column
    $pdf->Cell($width_cell[2],10,'CLASS',1,0,'C',true); // Third header column 
    $pdf->Cell($width_cell[3],10,'MARK',1,1,'C',true); // Fourth header column
    //// header is over ///////
    
    $pdf->SetFont('Arial','',10);
    // First row of data 
    $pdf->Cell($width_cell[0],10,'1',1,0,'C',false); // First column of row 1 
    $pdf->Cell($width_cell[1],10,'John Deo',1,0,'C',false); // Second column of row 1 
    $pdf->Cell($width_cell[2],10,'Four',1,0,'C',false); // Third column of row 1 
    $pdf->Cell($width_cell[3],10,'75',1,1,'C',false); // Fourth column of row 1 
    //  First row of data is over 
   

    $pdf->SetXY(90,120);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(20,10,'    JOINING INSTRUCTIONS, TERMS & CONDITIONS',0,1,'C');




    $pdf->Output();

    $pdf->Output();

}else{


}

exit;



// //For each row, add the field to the corresponding column
// while($row = mysql_fetch_array($result))
// {
//     $code = $row["Code"];
//     $name = substr($row["Name"],0,20);
//     $real_price = $row["Price"];
//     $price_to_show = number_format($row["Price"],',','.','.');

//     $column_code = $column_code.$code."\n";
//     $column_name = $column_name.$name."\n";
//     $column_price = $column_price.$price_to_show."\n";

//     //Sum all the Prices (TOTAL)
//     $total = $total+$real_price;
// }
// mysql_close();

// //Convert the Total Price to a number with (.) for thousands, and (,) for decimals.
// $total = number_format($total,',','.','.');

// //Create a new PDF file
// $pdf=new FPDF();
// $pdf->AddPage();

// //Fields Name position
// $Y_Fields_Name_position = 20;
// //Table position, under Fields Name
// $Y_Table_Position = 26;

// //First create each Field Name
// //Gray color filling each Field Name box
// $pdf->SetFillColor(232,232,232);
// //Bold Font for Field Name
// $pdf->SetFont('Arial','B',12);
// $pdf->SetY($Y_Fields_Name_position);
// $pdf->SetX(45);
// $pdf->Cell(20,6,'CODE',1,0,'L',1);
// $pdf->SetX(65);
// $pdf->Cell(100,6,'NAME',1,0,'L',1);
// $pdf->SetX(135);
// $pdf->Cell(30,6,'PRICE',1,0,'R',1);
// $pdf->Ln();

// //Now show the 3 columns
// $pdf->SetFont('Arial','',12);
// $pdf->SetY($Y_Table_Position);
// $pdf->SetX(45);
// $pdf->MultiCell(20,6,$column_code,1);
// $pdf->SetY($Y_Table_Position);
// $pdf->SetX(65);
// $pdf->MultiCell(100,6,$column_name,1);
// $pdf->SetY($Y_Table_Position);
// $pdf->SetX(135);
// $pdf->MultiCell(30,6,$columna_price,1,'R');
// $pdf->SetX(135);
// $pdf->MultiCell(30,6,'$ '.$total,1,'R');

// //Create lines (boxes) for each ROW (Product)
// //If you don't use the following code, you don't create the lines separating each row
// $i = 0;
// $pdf->SetY($Y_Table_Position);
// while ($i < $number_of_products)
// {
//     $pdf->SetX(45);
//     $pdf->MultiCell(120,6,'',1);
//     $i = $i +1;
// }

// $pdf->Output();

// require('fpdf/fpdf.php');
// $pdf = new FPDF();
// $pdf->AddPage();

// $pdf->SetFont('Arial','B',12);	

// $pdf->Cell(90,12,'ddddd',1);
// $pdf->SetFont('Arial','',12);		
// $pdf->Ln();

$pdf->Output();


?>
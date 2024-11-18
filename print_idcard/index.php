<?php

  // include composer packages
  include "vendor/autoload.php";
  include "../db/config.php";
  

  $user_id = $_GET['user_id'];
  $topic_id = $_GET['topic_id'];
  $course_id = $_GET['course_id'];
  $meeting_id = $_GET['meeting_id'];
  $meeting_link = $_GET['meeting_link'];
 
  // Fetch All Records from Table to show id card 


  /* get Student Details */
  $result = $conn->query("select *,tbl_enquiry.enq_course_id from tbl_users_enquires join tbl_enquiry on tbl_users_enquires.enq_id=tbl_enquiry.enq_id join tbl_users on tbl_users.userId = tbl_users_enquires.user_id where tbl_users.userId=$user_id");
  $result_arry = $result->fetch_assoc();
  $enquiry_course_ids = $result_arry['enq_course_id'];
  $course_ids    =   explode(',', $enquiry_course_ids);
  
  $data = array();
  $counter = 0;
  foreach($course_ids as $id)
      {

        $result1 = $conn->query("SELECT 
                                    *,
                                    `tbl_topic_meeting_link`.`id` AS `meeting_id`,
                                    `tbl_timetable_transection`.`id` AS `topicid`,
                                    `tbl_timetable_transection`.`timings` AS `classtime`
                                FROM 
                                    `tbl_course`
                                JOIN 
                                    `tbl_course_type` 
                                    ON `tbl_course_type`.`ct_id` = `tbl_course`.`course_type_id`
                                JOIN 
                                    `tbl_timetable_transection` 
                                    ON `tbl_timetable_transection`.`course_id` = `tbl_course`.`courseId`
                                JOIN 
                                    `tbl_timetable` 
                                    ON `tbl_timetable_transection`.`time_table_id` = `tbl_timetable`.`id`
                                LEFT JOIN 
                                    `tbl_topic_meeting_link` 
                                    ON `tbl_topic_meeting_link`.`time_table_transection_id` = `tbl_timetable_transection`.`id`
                                WHERE 
                                    `tbl_course`.`isDeleted` = 0
                                    AND `tbl_timetable_transection`.`id` = $topic_id
                                    AND `tbl_timetable_transection`.`course_id` = $course_id
                                    AND `tbl_course`.`courseId` = $id
                                ORDER BY 
                                    `tbl_course`.`courseId` DESC");

        $result_arry_1 = $result1->fetch_assoc();

       
        $data[$counter]['name'] = $result_arry['name'].' '.$result_arry['lastname'];
        $data[$counter]['lastname'] = $result_arry['lastname'];
        $data[$counter]['profile_pic'] = $result_arry['profile_pic'];
        $data[$counter]['mobile'] = $result_arry['mobile'];

        $data[$counter]['course_name'] = $result_arry_1['course_name'];
        $data[$counter]['title'] = $result_arry_1['topic'];
        $data[$counter]['classtime'] =$result_arry_1['classtime'];
        $data[$counter]['link_url'] = $result_arry_1['link_url'];
        $data[$counter]['createdDtm'] = $result_arry_1['createdDtm'];
        $data[$counter]['date'] =$result_arry_1['date'];
        $data[$counter]['meeting_id'] = $result_arry_1['meeting_id'];
        $data[$counter]['topicid'] =$result_arry_1['topicid'];
        $data[$counter]['userid'] =  $user_id;
        $data[$counter]['courseId'] = $result_arry_1['courseId'];

      }

      $name =$data[0]['name'];
      $course_name_1 = $data[0]['course_name'];
      $title= $data[0]['title'];
      $classtime = $data[0]['classtime'];
      $date = $data[0]['date'];
      $profile_pic = $data[0]['profile_pic'];
      if($profile_pic){
        $photo =  'https://iictn.in/uploads/profile_pic/'.$profile_pic;

      }else{
        $photo =  'student_photo.png';

      }

  // Create new Landscape PDF
  // $pdf = new FPDI('l');
  $pdf = new \setasign\Fpdi\Fpdi();

  class PDF extends FPDF {
      // Header of the ID card
      function Header() {
          // Add background color for header
          $this->SetFillColor(210, 174, 109); // Dodger Blue color
          $this->Rect(10, 10, 90, 25, 'F'); // (X, Y, Width, Height) for header background
  
          // Add logo (optional)
          $this->Image('logo.png', 12, 12, 20); // Adjust the path and size
  
          // Set font and add title
          $this->SetFont('Arial', 'B', 16);
          $this->SetTextColor(0, 0, 0); // White text color
          $this->Cell(30); // Move to the right
          $this->Cell(50, 30, 'IICTN - ID CARD', 0, 1, 'C'); // ID card title
          $this->Ln(5);
      }
  
      // ID card content layout
      function IDCard($name, $course_name_1, $title, $classtime,$date,$photo) {
          // Outer border for ID card
          //$this->SetLineWidth(1.5);
          $this->SetLineWidth(0);
          $this->Rect(10, 10, 90, 130); // X, Y, Width, Height for ID card border
  
          // Name Section
          $this->SetY(40);
          $this->SetFont('Arial', 'B', 12);
          $this->SetTextColor(0, 0, 0); // Black text color
          $this->Cell(40, 10, 'Student Name:', 0, 0, 'L');
          $this->SetFont('Arial', '', 12);
          $this->Cell(50, 10, $name, 0, 1, 'L');
  
          // ID Section
          $this->SetFont('Arial', 'B', 12);
          $this->Cell(40, 10, 'Course Name:', 0, 0, 'L');
          $this->SetFont('Arial', '', 12);
          $this->Cell(50, 10, $course_name_1, 0, 1, 'L');
  
          // Position Section
          $this->SetFont('Arial', 'B', 12);
          $this->Cell(40, 10, 'Topic Name:', 0, 0, 'L');
          $this->SetFont('Arial', '', 12);
          $this->Cell(50, 10, $title, 0, 1, 'L');

          // Position Section
          $this->SetFont('Arial', 'B', 12);
          $this->Cell(40, 10, 'Class Time:', 0, 0, 'L');
          $this->SetFont('Arial', '', 12);
          $this->Cell(50, 10, $classtime, 0, 1, 'L');

           // Position Section
          $this->SetFont('Arial', 'B', 12);
          $this->Cell(40, 10, 'Class Date:', 0, 0, 'L');
          $this->SetFont('Arial', '', 12);
          $this->Cell(50, 10, $date, 0, 1, 'L');

          // Add Photo (optional)
          if($photo) {
              // Add photo border
              $this->SetLineWidth(0.5);
              $this->Rect(60, 93, 30, 32); // Photo border
              
              // Insert photo
              $this->Image($photo, 61, 94, 28, 30); // X, Y, Width, Height inside the border
          }
  
          // Footer Section with Branding
          $this->SetY(120); // Position footer
          $this->SetFillColor(210, 174, 109); // Dodger Blue
          $this->Rect(10, 132, 90, 12, 'F'); // Footer background
          $this->SetFont('Arial', 'B', 10);
          $this->SetTextColor(0, 0, 0); // White text color
          $this->SetY(138);
          $this->Cell(80, 1, 'Powered by IICTN - www.iictn.in', 0, 0, 'C'); // Footer text
      }
  }
  
  // Create PDF instance
  $pdf = new PDF('P', 'mm', array(110, 160)); // Custom size for single ID card
  $pdf->AddPage();
  
//   // Add ID Card details
//   $name = 'John Doe';
//   $id = 'EMP12345';
//   $position = 'Software Engineer';
 // $photo = 'student_photo.png'; // Path to the photo (optional)
  
  // Generate ID card
  $pdf->IDCard($name, $course_name_1, $title, $classtime ,$date,$photo);
  
  // Output the PDF
  $pdf->Output();
 
  
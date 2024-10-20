<?php

  // include composer packages
  include "vendor/autoload.php";
  include "../db/config.php";
  
  $student_id = $_GET['student_id'];

  // Create new Landscape PDF
  // $pdf = new FPDI('l');
  $pdf = new \setasign\Fpdi\Fpdi();

  class PDF extends FPDF {
      // Header of the ID card
      function Header() {
          // Add background color for header
          $this->SetFillColor(30, 144, 255); // Dodger Blue color
          $this->Rect(10, 10, 90, 30, 'F'); // (X, Y, Width, Height) for header background
  
          // Add logo (optional)
          $this->Image('logo.png', 12, 12, 20); // Adjust the path and size
  
          // Set font and add title
          $this->SetFont('Arial', 'B', 16);
          $this->SetTextColor(255, 255, 255); // White text color
          $this->Cell(30); // Move to the right
          $this->Cell(50, 30, 'ID CARD', 0, 1, 'C'); // ID card title
          $this->Ln(5);
      }
  
      // ID card content layout
      function IDCard($name, $id, $position, $photo) {
          // Outer border for ID card
          $this->SetLineWidth(1.5);
          $this->Rect(10, 10, 90, 130); // X, Y, Width, Height for ID card border
  
          // Name Section
          $this->SetFont('Arial', 'B', 12);
          $this->SetTextColor(0, 0, 0); // Black text color
          $this->Cell(40, 10, 'Name:', 0, 0, 'L');
          $this->SetFont('Arial', '', 12);
          $this->Cell(50, 10, $name, 0, 1, 'L');
  
          // ID Section
          $this->SetFont('Arial', 'B', 12);
          $this->Cell(40, 10, 'ID:', 0, 0, 'L');
          $this->SetFont('Arial', '', 12);
          $this->Cell(50, 10, $id, 0, 1, 'L');
  
          // Position Section
          $this->SetFont('Arial', 'B', 12);
          $this->Cell(40, 10, 'Position:', 0, 0, 'L');
          $this->SetFont('Arial', '', 12);
          $this->Cell(50, 10, $position, 0, 1, 'L');
  
          // Add Photo (optional)
          if($photo) {
              // Add photo border
              $this->SetLineWidth(0.5);
              $this->Rect(60, 60, 35, 45); // Photo border
              
              // Insert photo
              $this->Image($photo, 61, 61, 33, 43); // X, Y, Width, Height inside the border
          }
  
          // Footer Section with Branding
          $this->SetY(120); // Position footer
          $this->SetFillColor(30, 144, 255); // Dodger Blue
          $this->Rect(10, 120, 90, 20, 'F'); // Footer background
          $this->SetFont('Arial', 'I', 10);
          $this->SetTextColor(255, 255, 255); // White text color
          $this->Cell(90, 10, 'Powered by Infinity Software Solutions', 0, 1, 'C'); // Footer text
      }
  }
  
  // Create PDF instance
  $pdf = new PDF('P', 'mm', array(110, 160)); // Custom size for single ID card
  $pdf->AddPage();
  
  // Add ID Card details
  $name = 'John Doe';
  $id = 'EMP12345';
  $position = 'Software Engineer';
  $photo = 'student_photo.png'; // Path to the photo (optional)
  
  // Generate ID card
  $pdf->IDCard($name, $id, $position, $photo);
  
  // Output the PDF
  $pdf->Output();
 
  
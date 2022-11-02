<?php

 $name        = "IICTN";
  $email       = "hemantkaturde123@gmail.com";
  $to          = "hemantkaturde123@gmail.com";;
  $from        = "hemantkaturde123@gmail.com";
  $subject     = "IICTN - Admission Payment Recipt";


  $fileatt     = "../invoices/PAYMENT_RECEIPT_1.pdf"; //file location
  $fileatttype = "application/pdf";
  $fileattname = "PAYMENT_RECEIPT_1.pdf"; //name that you want to use to send or you can use the same name
  // $headers = "From: $from";

  $header = "From: IICTN-Payment Receipt <enquiry@iictn.in> \r\n";

  
  // File
  $file = fopen($fileatt, 'rb');
  $data = fread($file, filesize($fileatt));
  fclose($file);
  
  // This attaches the file
  $semi_rand     = md5(time());
  $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
  
  
  $headers .= "\nMIME-Version: 1.0\n" ."Content-Type: multipart/mixed;\n" ." boundary=\"{$mime_boundary}\"";

  // $message = "This is a multi-part message in MIME format.\n\n" .
    // "--{$mime_boundary}\n" .
    // "Content-Type: text/plain; charset=\"iso-8859-1\n" .
    // "Content-Transfer-Encoding: 7bit\n\n" .
    // $mainMessage  . "\n\n";

    // Multipart boundary  
 $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" ."Content-Transfer-Encoding: 7bit\n\n" . $mainMessage . "\n\n";  
  
  $data = chunk_split(base64_encode($data));
  $message .= "--{$mime_boundary}\n" ."Content-Type: {$fileatttype};\n" ." name=\"{$fileattname}\"\n" ."Content-Disposition: attachment;\n" ." filename=\"{$fileattname}\"\n" .
  "Content-Transfer-Encoding: base64\n\n" .$data . "\n\n" ."--{$mime_boundary}--\n";

  // Send the email
  if(mail($to, $subject, $message, $headers)) {
  
    //echo "The email was sent.";
  }
  else {
    //echo "There was an error sending the mail.";
  }

?>
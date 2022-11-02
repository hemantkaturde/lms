<?php

// array with filenames to be sent as attachment
    //$files = array("download (2).jpg","file2.pdf","file3.txt");
    $files = array("download (2).jpg");

    $files = array("http://localhost/lms_2/markating_material/Doctors_Brochure.pdf");
    // email fields: to, from, subject, and so on
    $to = "hemantkaturde123@gmail.com";
    $from = "hemantkaturde123@mail.com"; 
    $subject ="My subject"; 
    $message = "My message";
    $headers = "From: $from";
    // boundary 
    $semi_rand = md5(time()); 
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
    // headers for attachment 
    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" .   "
                 boundary=\"{$mime_boundary}\""; 
    // multipart boundary 
    $message = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n"
               . "Content-Type: text/plain; charset=\"iso-8859-1\"\n" . 
                 "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n"; 
    $message .= "--{$mime_boundary}\n";
    // preparing attachments
    for($x=0;$x< count($files);$x++){
            $file = fopen($files[$x],"rb");
            $data = fread($file,filesize($files[$x]));
            fclose($file);
            $data = chunk_split(base64_encode($data));
            $message .= "Content-Type: {\"application/octet-stream\"};\n" .  
                        " name=\"$files[$x]\"\n" . 
            "Content-Disposition: attachment;\n" . " filename=\"$files[$x]\"\n" . 
            "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
            $message .= "--{$mime_boundary}\n";
    }
    // send
    $success = @mail($to, $subject, $message, $headers); 
    if ($success) { 
            echo "
 mail sent to $to ! 

"; 
    } else { 
            echo "
 mail could not be sent! 

"; 
    } 


?>
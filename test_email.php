<?php

$to = "hemantkaturde123@gmail.com";
$subject = "My subject";
$txt = "Hello world!";
$headers = "From: hemantkaturde123@gmail.com" . "\r\n" .
"CC: hemantkaturde123@gmail.com";

mail($to,$subject,$txt,$headers);

?>
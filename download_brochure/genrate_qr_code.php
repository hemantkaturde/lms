<?php
    include "phpqrcode/qrlib.php";
    $content = 'https://iictn.in/download_brochure';
    QRcode::png($content,'QR_CODE.png') ;
?>
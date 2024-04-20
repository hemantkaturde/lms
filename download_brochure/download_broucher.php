<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Brochure</title>
</head>
<?php
    include "../db/config.php";
    if (isset($_POST)) {
        // Get data from POST request
        $name = $_POST['name'];
        $mobile = $_POST['mobile'];
        $city = $_POST['city'];
        if($name && $mobile && $city){
                // Insert data into database
                $sql = "INSERT INTO tbl_downloaded_users (name, mobile_number, city) VALUES ('$name', '$mobile', '$city')";
                if ($conn->query($sql) === TRUE) {
                    $pdf_url = 'Non-Doctors-Broucher.pdf';
                    // Fetch the PDF file contents
                    // $pdf_content = file_get_contents($pdf_url);
                    // Set the appropriate headers for the download
                    // header('Content-Type: application/pdf');
                    // header('Content-Disposition: attachment; filename="Non-Doctors-Broucher.pdf"');
                    // // Output the PDF content
                    // echo $pdf_content;

                    header("Content-type: application/pdf");
                    header("Content-Disposition: inline; filename=file.pdf");
                    // Open the PDF file
                    readfile($pdf_url);

                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
                $conn->close();
        }else{
            header("Location: index.php");
        }
    } else  {
        header("Location: index.php");
    }
?>
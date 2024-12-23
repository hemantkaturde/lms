<?php
include "../db/config.php";
?>

<!DOCTYPE html>
<html lang="en">

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Brochure</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            /* background-color: #f0f0f0; */
            background: radial-gradient(#FF9800, transparent);
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            display: grid;
            grid-gap: 20px;
        }
        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .responsive-image {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto; /* Optional: Center the image horizontally */
        }
    </style>
</head>

<body>
    <div class="container">
        <div>
           <img src="iictn_logo.jpg" alt="Responsive Image" class="responsive-image">
        </div>
    
        <h2>Download Brochure</h2>
        <form method="post" action="download_broucher.php">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Please Enter Full Name" required>

            <!-- <label for="email">Email:</label>
            <input type="email" id="email" name="email" required> -->

            <label for="mobile">Mobile:</label>
            <input type="text" id="mobile" name="mobile" placeholder="Please Enter Mobile Number" required>

            <label for="city">City:</label>
            <input type="text" id="city" name="city" placeholder="Please Enter city" required>

            <input type="submit"  onclick="startDownload()" value="Submit">

        </form>
    </div>
</body>
</html>
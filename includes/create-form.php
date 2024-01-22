<?php

session_start();

if (empty($_SESSION['user'])) {
    header("Location: /guest/login.php");
}

require "../db/db.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>

</head>

<body class="h-100 d-flex flex-column justify-content-between">
    <header class="w-100 bg-dark p-4 text-white d-flex justify-content-center">
        <h3>Inserted Successfully</h3>
    </header>


    <?php
    // define variables and set to empty values
    $name = $email = $gender = $comment = $website = "";
    $nameErr = $emailErr = $genderErr = $websiteErr = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {


        if (empty($_POST["name"])) {
            $nameErr = "Name is required.";
        } else {
            $name = test_input($_POST["name"]);

            if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
                $nameErr = "Only letters and white space allowed.";
            }
        }

        if (empty($_POST["email"])) {
            $emailErr = "Email is required.";
        } else {
            $email = test_input($_POST["email"]);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format.";
            }
        }

        if (empty($_POST["website"])) {
            $website = "";
        } else {
            $website = test_input($_POST["website"]);
            if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $website)) {
                $websiteErr = "Invalid URL.";
            }
        }

        if (empty($_POST["comment"])) {
            $comment = "";
        } else {
            $comment = test_input($_POST["comment"]);
        }

        if (empty($_POST["gender"])) {
            $genderErr = "Gender is required.";
        } else {
            $gender = test_input($_POST["gender"]);
        }

        $filename = $_FILES["uploadfile"]["name"];
        $tempname = $_FILES["uploadfile"]["tmp_name"];
        $allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
        $detectedType = exif_imagetype($_FILES['uploadfile']['tmp_name']);
        $error = in_array($detectedType, $allowedTypes);



        $folder = $_SERVER['DOCUMENT_ROOT'] . "/guest/image/" . $filename;
        // echo $folder;


        if (!$nameErr && !$emailErr && !$genderErr && !$websiteErr && $error) {

            try {

                $sql = "SELECT * FROM users where username = '{$_SESSION["user"]}'";

                if (move_uploaded_file($tempname, $folder)) {
                    $userId = $conn->query($sql)->fetch();
                    if (count($userId) > 0) {

                        $sqlTable = "INSERT INTO MyGuests (name, email, website, comment, gender, created_by, image) VALUES('$name','$email','$website','$comment', '$gender','{$userId['id']}', '$filename')";
                        $conn->exec($sqlTable);

                        $last_id = $conn->lastInsertId(); ?>
                        <div class="container d-flex flex-column justify-content-center my-5">
                            <div class="alert alert-success">
                                <p>Data inserted successfully. Last inserted id: <?php echo $last_id ?></p>
                            </div>
                            <a href='/guest/index.php' class="btn btn-dark">Go back to Homepage</a>

                        </div>
    <?php
                    } else {
                        header("Locaton: /guest/login.php?message=NotAuthorized");
                    }
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        } else {
            // $_SESSION['name'] = $name;
            // $_SESSION['email'] = $email;
            // $_SESSION['comment'] = $comment;
            // $_SESSION['gender'] = $gender;
            // $_SESSION['website'] = $website;
            // $_SESSION['nameErr'] = $nameErr;
            // $_SESSION['emailErr'] = $emailErr;
            // $_SESSION['genderErr'] = $genderErr;
            // $_SESSION['websiteErr'] = $websiteErr;

            $message = array("nameError" => $nameErr, "emailError" => $emailErr, "genderError" => $genderErr, "websiteError" => $websiteErr, "imgError" => "image file doesnt support. Only .jpg .png and .jpeg supported");
            $data = array("name" => $name, "email" => $email, "comment" => $comment, "gender" => $gender, "website" => $website);
            // $message = implode($message);
            header('Location: http://localhost/guest/registration.php?message=' . urlencode(serialize($message)) . '&&data=' . urlencode(serialize($data)));
        }
    }

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }




    include "footer.php";
    ?>
<?php

session_start();


include "./db/db.php";

$name = $password = $cpassword = "";
$nameErr = $passwordErr = $cpasswordErr = "";

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["username"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["username"]);


        try {
            $sql = "SELECT * from users where username = '$name' ";


            // $data = $conn->query($sql)->fetch();
            $data = $conn->query($sql)->fetchAll();


            if (count($data) > 0 || $data) {
                $nameErr = "This username is already taken";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        if (!preg_match('/^[a-z0-9]{6,15}$/', $name)) {
            $nameErr = "The username should be <br>&rarr;alphanumeric <br>&rarr;minimum 6 character long <br>&rarr;lowercase <br>&rarr;no whitespaces <br>&rarr;Maximum character allowed 15";
        }
    }


    if (empty($_POST["password"])) {

        $passwordErr = "Password is required";
        // preg match error of 6 length
    } else {
        $password = test_input($_POST["password"]);
    }

    if ($_POST["password"] !== $_POST["cpassword"]) {
        $cpasswordErr = "Password didn't match";
    } else {
        $cpassword = test_input($_POST["cpassword"]);
    }



    if ($nameErr === "" && $passwordErr === "" && $cpasswordErr === "" && ($password === $cpassword)) {
        try {
            //hashing
            $hashedPass  = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users(username,password) VALUES('$name','$hashedPass')";
            $conn->exec($sql);
            $last_id = $conn->lastInsertId();
            echo "Data inserted";
            $_SESSION["user"] = $name;

            header("Location: /guest/login.php");
        } catch (PDOException $e) {
            echo $sql . "<br>";
            echo $e->getMessage();
        }
    }
}





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
        <h3>Signup</h3>
    </header>

    <body>

        <div class="container d-flex justify-content-center align-items-center my-4">

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="card p-4">
                <?php
                if (!empty($nameErr) || !isset($nameErr)) { ?>
                    <div class="alert alert-danger">
                        <?php echo $nameErr; ?>
                    </div>
                    <?php

                } else {
                    if (!empty($passwordErr) || !isset($passwordErr) || !empty($cpasswordErr)) { ?>
                        <div class="alert alert-danger">
                            <?php echo $passwordErr . " " . $cpasswordErr; ?>
                        </div>
                <?php

                    }
                }
                ?>
                <div class="mb-2">
                    <label for="username" name="username" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required /> <br>
                </div>

                <div class="mb-2">

                    <label for="password" name="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required minlength="6" /> <br>
                </div>

                <div class="mb-2">

                    <label for="cpassword" name="cpassword" class="form-label">Confirm Password</label>
                    <input type="password" name="cpassword" class="form-control" required minlength="6" /> <br>
                </div>



                <button type="submit" class="btn btn-dark py-2 px-4">Submit</button>
                <div class="form-text">Alreadt have account? <a href="/guest/login.php">Sign in here.</a></div>

            </form>
        </div>

        <?php

        include "./includes/footer.php";

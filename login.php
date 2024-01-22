<?php

session_start();

include "./db/db.php";

$name = $password  = "";
$nameErr = $passwordErr  = "";
$message = "";

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (!isset($_SESSION["user"])) {
    if ($_SERVER["REQUEST_METHOD"] = "POST") {
        if (empty($_POST["username"])) {
            $nameErr = "Name is required";
        } else {
            $name = test_input($_POST["username"]);

            try {
                $sql = "SELECT * FROM users where username = '$name'";
                $data = $conn->query($sql)->fetch();

                if (count($data) > 0 || $data) {
                    $password = test_input($_POST["password"]);


                    $pass = password_verify($password, $data["password"]);
                    if ($pass) {
                        $_SESSION["user"] = $name;
                        echo "Login successfully";
                        header("Location: /guest/index.php");
                    } else {
                        $message = "credentials wrong";
                    }
                } else {

                    echo "No such data in database. Sign up now.";
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
} else {
    header("Location: /guest/index.php");
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
        <h3>Login</h3>
    </header>

    <body>



        <div class="container d-flex justify-content-center align-items-center my-4">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" class="card p-4">

                <?php
                if (!empty($message) || !isset($message)) { ?>
                    <div class="alert alert-danger">
                        <?php echo $message; ?>
                    </div>
                <?php

                }
                ?>

                <div class="mb-2">
                    <label for="username" name="username" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required /> <br>
                </div>
                <div class="mb-2">
                    <label for="password" name="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required /> <br>
                </div>


                <button type="submit" class="btn btn-dark py-2 px-4">Login</button>

                <div class="form-text">Dont have account? <a href="/guest/signup.php">Sign up here.</a></div>
            </form>
        </div>

        <?php

        include "./includes/footer.php";

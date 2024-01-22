<?php
session_start();
require "./db/db.php";

if (empty($_SESSION['user'])) {
    header("Location: /guest/login.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body class="h-100 d-flex flex-column justify-content-between">
    <header class="w-100 bg-dark p-4 text-white d-flex justify-content-center">
        <h3>Update Record</h3>
    </header>



    <?php



    try {
        $sql = "SELECT * FROM users where username = '{$_SESSION["user"]}'";
        $userId = $conn->query($sql)->fetch();

        if (count($userId) > 0) {

            $sql = "SELECT * FROM MyGuests where id = " . $_GET["id"];
            $data = $conn->query($sql)->fetch();

            if ($userId["id"] !== $data["created_by"]) {
                echo "You are not authorized to delete this<br>";
                echo " <a href='/guest/index.php'>Go back to Homepage</a>";
            } else {
                if (count($data) > 0) {
                    $name = $data["name"];
                    $email = $data["email"];
                    $comment = $data["comment"];
                    $website = $data["website"];
                    $gender = $data["gender"];
                    $invite = $data["is_Invited"];
    ?>
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $name = $_POST["name"];
                        $email = $_POST["email"];
                        $comment = $_POST["comment"];
                        $website = $_POST["website"];
                        $gender = $_POST["gender"];
                        // $invite = $_POST["invite"];

                        if (strlen($name) < 1 || strlen($email) < 1 || strlen($gender) < 1) {
                            $errMessage = "Fill out all the form";
                        } else {


                            try {

                                if (isset($_POST["invite"]) && $_POST["invite"] == "invited" && !empty($_POST["invite"])) {
                                    // echo $_POST["invite"];
                                    $is_invite = 1;
                                    $invite = 1;
                                } else {
                                    $is_invite = 0;
                                    $invite = 0;
                                }
                                $sql = "Update MyGuests SET name='{$_POST["name"]}', email='{$_POST["email"]}', website='{$_POST["website"]}', comment='{$_POST["comment"]}', gender='{$_POST["gender"]}', is_Invited='{$is_invite}' WHERE id={$_GET['id']}";
                                $conn->exec($sql);

                                $message = "Data updated successfully";
                            } catch (PDOException $e) {
                                echo $sql . "<br>" . $e->getMessage();
                            }
                        }
                    }
                    ?>


                    <div class="container d-flex justify-content-center align-items-center my-4">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?" . $_SERVER['QUERY_STRING']) ?>" class="card p-4">
                            <?php
                            if (isset($message)) {
                                if (!empty($message)  && !is_null($message)) {
                            ?>
                                    <div class="alert alert-success">
                                        <?php echo $message; ?>
                                    </div>
                                <?php

                                }
                            }

                            if (!isset($errMessage)) {
                                if (!empty($errMessage)  && !is_null($errMessage)) { ?>
                                    <div class="alert alert-danger">
                                        <?php echo $errMessage; ?>
                                    </div>
                            <?php

                                }
                            }
                            ?>
                            <div class="mb-3">
                                <label for="name" name="name" class="form-label">Name</label>
                                <input type="text" name="name" value="<?php echo $name ?>" class="form-control">
                                <span class="form-text text-danger"><?php if (isset($nameErr)) echo $nameErr ?></span>
                            </div>
                            <div class="mb-3">
                                <label name="email" for="email" class="form-label">Email</label>
                                <input type="email" name="email" value="<?php echo $email ?>" required class="form-control">
                                <span class="form-text text-danger"><?php if (isset($emailErr)) echo $emailErr ?></span>
                            </div>

                            <div class="mb-3">
                                <label name="website" for="website" class="form-label">Website</label>
                                <input type="text" name="website" value="<?php echo $website ?>" class="form-control">
                                <span class="form-text text-danger"><?php if (isset($websiteErr)) echo $websiteErr ?></span>

                            </div>

                            <div class="mb-3">
                                <label for="comment" name="comment" class="form-label">
                                    Comment
                                </label>
                                <textarea name="comment" rows="5" cols="40" class="form-control"><?php echo $comment ?></textarea><br>

                            </div>


                            <div class="mb-3">
                                <label for="gender" name="gender" class="form-label">
                                    Gender
                                </label>
                                <br>
                                <input type="radio" name="gender" value="female" <?php if (isset($gender) && $gender == "female") echo "checked" ?>>
                                <label for="gender" class="form-check-label">Female</label>
                                <input type="radio" name="gender" value="male" <?php if (isset($gender) && $gender == "male") echo "checked" ?>> <label for="gender" class="form-check-label">Male</label>
                                <input type="radio" name="gender" value="other" <?php if (isset($gender) && $gender == "other") echo "checked" ?>> <label for="gender" class="form-check-label">Other</label>
                            </div>
                            <div class="mb-3">
                                <label for="invite" name="invite" class="form-label">
                                    Invited?
                                </label>
                                <br>
                                <input type="checkbox" name="invite" value="invited" <?php if (isset($invite) && $invite == 1) echo "checked" ?>>
                                <?php echo $invite ?>
                            </div>

                            <button type="submit" class="btn btn-dark">Update</button><br><br>

                        </form>
                    </div>

    <?php    } else {
                    echo "No result found. Go back to <a href='/learn/form/index.php'>Homepage</a>";
                }
            }
        }
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }




    ?>





    <?php
    include "./includes/footer.php";
    ?>
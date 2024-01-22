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
    <title>Document</title>
</head>

<body>




    <?php

    try {

        $sql = "SELECT * FROM users where username = '{$_SESSION["user"]}'";

        $userId = $conn->query($sql)->fetch();
        if (count($userId) > 0) {

            $checkData = "SELECT * FROM MyGuests Where id = " . $_GET["id"];
            $data = $conn->query($checkData)->fetch();

            if ($userId['id'] !== $data['created_by']) {
                echo "You are not authorized to delete this<br>";
                echo "Go back to <a href='/guest/index.php'>Homepage</a>";
            } else {
                if (count($data) > 0) {
                    try {

                        $sql = "UPDATE MyGuests SET is_Deleted=1 where id = " . $_GET["id"];
                        $conn->exec($sql);
    ?>

                        <h3>Deleted successfully</h3>
                        <a href="/guest/index.php">Go back to homepage</a>
    <?php
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                } else {
                    echo "No such data in database <br>";
                    echo "<a href='/guest/index.php'>Go back to homepage</a>";
                }
            }
        } else {
            // header("Locaton: /guest/login.php?message=NotAuthorized");
            echo "You are not authorized";
        }

        // var_dump($data);
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }







    ?>
</body>

</html>
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


</head>

<body class="h-100 d-flex flex-column justify-content-between">
    <header class="w-100 bg-dark p-4 text-white d-flex justify-content-center">
        <h3>Guest Information</h3>
    </header>
    <main>


        <div class="container my-3">
            <div class="card">
                <?php


                try {
                    $sql = "SELECT * FROM users where username = '{$_SESSION["user"]}'";

                    $userId = $conn->query($sql)->fetch();
                    if (count($userId) > 0) {

                        $sql = "SELECT * from MyGuests where is_Deleted=0 and created_by={$userId['id']}";
                        $data = $conn->query($sql)->fetchAll();
                    } else {
                        header("Locaton: /guest/login.php?message=NotAuthorized");
                    }
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }

                if (count($data)  > 0) { ?>
                    <table class="table table-striped">
                        <thead>
                            <!-- <th>S.N</th> -->
                            <th>Profile</th>
                            <th>Name</th>
                            <th>Email</th>
                            <!-- <th>Website</th> -->
                            <th>Actions</th>
                        </thead>
                        <tbody>
                            <?php

                            foreach ($data as $row) { ?>

                                <tr class="<?php if ($row["is_Invited"]) echo "text-decoration-line-through text-secondary fw-lighter"; ?>">

                                    <td><img src="./image/<?php if (empty($row["image"])) echo "fake.jpg";
                                                            else echo $row["image"] ?>" alt="" style="height:100px; width:100px" /></td>
                                    <td><?php echo $row["name"] ?></td>
                                    <td><?php echo $row["email"] ?></td>

                                    <td>
                                        <a href="<?php echo "/guest/edit.php?id=" . $row["id"] ?>" class="btn btn-primary">Edit</a>
                                        <a href="<?php echo "/guest/delete.php?id=" . $row["id"] ?>" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>

                            <?php
                            } ?>
                        </tbody>
                    </table>
                <?php
                } else {
                    echo "0 results";
                }

                ?>
            </div>
            <div class="d-flex justify-content-center">

                <a href="/guest/registration.php" class="my-3 btn btn-secondary">Add Record</a>
            </div>

        </div>


    </main>


    <?php
    include "./includes/footer.php";
    ?>
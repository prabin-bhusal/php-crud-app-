<?php
session_start();

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
        <h3>Add Record</h3>
    </header>

    <?php
    if (!empty($_GET['message'])) { ?>

    <?php
        $message = unserialize(urldecode($_GET['message']));

        $data = unserialize(urldecode($_GET['data']));

        $nameError = $message["nameError"];
        $emailError = $message["emailError"];
        $genderError = $message["genderError"];
        $websiteError = $message["websiteError"];
        $imgError = $message["imgError"];
    }
    ?>

    <main class="py-4 container">

        <div class="container d-flex justify-content-center align-items-center my-4">
            <form method="post" action="/guest/includes/create-form.php" class="card p-4" enctype="multipart/form-data">

                <div class="mb-3">
                    <label name="uploadfile" for="uploadfile">Profile Photo</label>
                    <input class="form-control" type="file" name="uploadfile" value="" required />
                    <span class="form-text text-danger"><?php if (isset($_GET["message"])) echo $imgError ?></span><br>
                </div>

                <div class="mb-3">
                    <label for="name" name="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="<?php if (isset($_GET["message"])) echo $data["name"] ?>">
                    <span class="form-text text-danger"><?php if (isset($_GET["message"])) echo $nameError ?></span><br>
                </div>

                <div class="mb-3">
                    <label name="email" for="email" class="form-label">Email</label>
                    <input type="text" name="email" class="form-control" value="<?php if (isset($_GET["message"])) echo $data["email"] ?>" required>
                    <span class="form-text text-danger"><?php if (isset($_GET["message"])) echo $emailError ?></span>

                </div>


                <div class="mb-3">
                    <label name="website" for="website" class="form-label">Website</label>
                    <input type="text" name="website" class="form-control" value="<?php if (isset($_GET["message"])) echo $data["website"] ?>">
                    <span class="error"><?php if (isset($_GET["message"])) echo $websiteError ?></span>
                </div>

                <div class="mb-3">
                    <label for="comment" name="comment" class="form-label">
                        Comment
                    </label>
                    <textarea name="comment" rows="5" cols="40" class="form-control"><?php if (isset($_GET["message"])) echo $data["comment"] ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="gender" name="gender" class="form-label">
                        Gender
                    </label>
                    <br>

                    <input type="radio" name="gender" value="female" <?php if (isset($_GET["data"]) && $data["gender"] == "female") echo "checked" ?>> <label for="gender" class="form-check-label">Female</label>
                    <input type="radio" name="gender" value="male" <?php if (isset($_GET["data"]) && $data["gender"] == "male") echo "checked" ?>> <label for="gender" class="form-check-label">Male</label>
                    <input type="radio" name="gender" value="other" <?php if (isset($_GET["data"]) && $data["gender"] == "other") echo "checked" ?>> <label for="gender" class="form-check-label">Other</label>
                    <span class="form-text text-danger"><?php if (isset($_GET["message"])) echo $genderError ?></span><br>

                </div>


                <button type="submit" class="btn btn-dark">Submit</button><br><br>

            </form>
        </div>



    </main>









    <?php
    include "./includes/footer.php";
    ?>
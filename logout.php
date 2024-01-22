<?php

session_start();


if (!isset($_SESSION["user"])) {
    echo "You are not logged in";
} else {
    session_unset();
    session_destroy();
    header("Location: /guest/login.php");
}

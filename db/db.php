<?php

$server = "localhost";
$user = "root";
$password = "";
$database = "myDB";



// using mysqli object based

// try {
//     $conn =  new mysqli($server, $user, $password, $database);
//     // echo "Connected Successfully";
// } catch (Exception $e) {
//     echo $e->getMessage();
// }




// using pdo based 

try {
    $conn = new PDO("mysql:host=$server;dbname=$database", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}





// CREATE TABLE users (
//     id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
//     username VARCHAR(50) NOT NULL UNIQUE,
//     password VARCHAR(255) NOT NULL,
//     created_at DATETIME DEFAULT CURRENT_TIMESTAMP
// );

// try {
//     $sql = "CREATE TABLE users(
//         id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
//         username VARCHAR(50) NOT NULL UNIQUE,
//         password VARCHAR(255) NOT NULL,
//         created_at DATETIME DEFAULT CURRENT_TIMESTAMP
//     )";

//     $conn->exec($sql);
// } catch (PDOException $e) {
//     echo $e->getMessage();
// }


// creating database
/*
$sql = "CREATE DATABASE myDB";
if (mysqli_query($conn, $sql)) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . mysqli_error($conn);
}
*/

// creating table
// $sql = "CREATE TABLE MyGuests (
//     id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
//     name VARCHAR(30) NOT NULL,
//     email VARCHAR(50) NOT NULL,
//     website VARCHAR(50),
//     comment VARCHAR(100),
//     gender VARCHAR(10),
//     reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP


// )";

// $sqlTable = "INSERT INTO MYGuests (name, email, website, comment, gender) VALUES('prabin','p@gmail.com','p.com','hello i am prabin', 'male')";

// if (mysqli_query($conn, $sqlTable)) {
//     echo "Data inserted successfully";
// } else {
//     echo "Error inserting to table: " . mysqli_error($conn);
// }


// echo "hello";
// if (mysqli_query($conn, $sql)) {
//     echo "Table created successfully";
// } else {
//     echo "Error creating table: " . mysqli_error($conn);
// }

// $selectData = "SELECT * FROM MyGuests";

// $result = mysqli_query($conn, $selectData);

// $row = mysqli_fetch_assoc($result);

// echo $row["id"] . "<br>";


// if (mysqli_num_rows($result) > 0 || ($result)) {
//     echo "Table already created";
// } else {
//     // echo "hello";
//     if (mysqli_query($conn, $sql)) {
//         echo "Table created successfully";
//     } else {
//         echo "Error creating table: " . mysqli_error($conn);
//     }
// }



// closing connection
// mysqli_close($conn);

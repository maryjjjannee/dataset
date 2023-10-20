<?php
session_start();
include('server.php');

mysqli_set_charset($conn, "utf8");


$dataname = $_POST['dataname'];
$description = $_POST['description'];
$class = $_POST['class'];
$implementdate = $_POST['implementdate'];
$imagedataset = $_POST['imagedataset'];


if ($_POST['status'] == 'ไม่ใช้งาน') {
    $status = 2;
} else {
    $status = 1;
}

if (isset($_POST["class"])) {
    $inputCount = (int)$_POST["class"];
} else {
    $inputCount = 0;
}

// Create an SQL query for inserting data
$sql = "INSERT INTO dataset (dataname, description, class, status, id_users, implementdate) VALUES ('$dataname', '$description', '$class', '$status','$users','$implementdate','$imagedataset')";

// Execute the SQL query
if ($conn->query($sql) === TRUE) {
    header('location: class.php');
    exit(0);
} else {
    // Handle errors in data insertion
    echo "Error in data insertion: " . $conn->error;
}

// Close the database connection
$conn->close();
?>

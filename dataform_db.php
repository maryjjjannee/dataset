<?php
session_start();
include('server.php');

mysqli_set_charset($conn, "utf8");

$dataname = $_POST['dataname'];
$description = $_POST['description'];
$dataname = $_POST['dataname'];
$description = $_POST['description'];
$class = $_POST['class'];
$id_users = $_SESSION['id_users'];

if ($_POST['status'] == 'ไม่ใช้งาน') {
    $status = 2;
} else {
    $status = 1;
}


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


// สร้างคำสั่ง SQL สำหรับการเพิ่มข้อมูล
$sql = "INSERT INTO dataset (dataname, description, class, status,id_users) VALUES ('$dataname', '$description','$class', '$status','$id_users')";

// ทำคำสั่ง SQL
if ($conn->query($sql) === TRUE) {

    header('location: class.php'); // 
    exit(0);
} else {
    // เกิดข้อผิดพลาดในการบันทึกข้อมูล
    echo "ข้อผิดพลาดในการบันทึกข้อมูล: " . $conn->error;
}



// ปิดการเชื่อมต่อกับฐานข้อมูล
$conn->close();
?>

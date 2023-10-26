<?php
session_start();
include('server.php');
include('admin_navbar.php'); 

$id=$_GET["id"];
$sql_delete_class = "DELETE FROM class WHERE dataset_id = $id";
if (mysqli_query($conn, $sql_delete_class)) {
    // ลบข้อมูลจากตาราง dataset
    $sql_delete_dataset = "DELETE FROM dataset WHERE id = $id";
    if (mysqli_query($conn, $sql_delete_dataset)) {
        header('Location: index.php'); // ลิงก์ไปยังหน้า class.php
        echo "ลบข้อมูลจากตาราง dataset และ class เรียบร้อยแล้ว";
    } else {
        echo "เกิดข้อผิดพลาดในการลบข้อมูลจากตาราง dataset: " . mysqli_error($conn);
    }
} else {
    echo "เกิดข้อผิดพลาดในการลบข้อมูลจากตาราง class: " . mysqli_error($conn);
}


?>
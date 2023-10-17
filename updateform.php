<?php
session_start();
include('server.php');

mysqli_set_charset($conn, "utf8");


if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $category = $_POST['category'];
    if (isset($_POST["class"])) {
        $inputCount = (int)$_POST["class"];
    } else {
        $inputCount = 0;
    }
    $images = $_FILES['image']['name'][$i]; 
    $imagePath = 'uploads/' . $images[$i]; // แทนด้วยเส้นทางของโฟลเดอร์ที่ท่านต้องการ

    $datasetSql = "UPDATE dataset SET class = $class WHERE id = $id";
    $datasetResult = mysqli_query($conn, $datasetSql);

    if ($datasetResult) {
        // อัปเดตข้อมูลในตาราง dataset สำเร็จ
    } else {
        echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูลในตาราง dataset: " . mysqli_error($conn);
    }

    // ลูปผ่านคลาสแต่ละคลาส
    for ($i = 1; $i <= $class; $i++) {
        $category = mysqli_real_escape_string($conn, $categories[$i]);

        // อัปเดตตาราง class
        $classSql = "UPDATE class SET category = '$category', image = '$images[$i]' WHERE dataset_id = $id AND class = $i";
        $classResult = mysqli_query($conn, $classSql);

        if ($classResult) {
            // อัปเดตข้อมูลในตาราง class สำเร็จ
        } else {
            echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูลในตาราง class: " . mysqli_error($conn);
        }

        // อัปเดตตาราง category
        $categorySql = "UPDATE category SET category_name = '$category' WHERE dataset_id = $id AND class = $i";
        $categoryResult = mysqli_query($conn, $categorySql);

        if ($categoryResult) {
            // อัปเดตข้อมูลในตาราง category สำเร็จ
        } else {
            echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูลในตาราง category: " . mysqli_error($conn);
        }

        // อัปเดตตาราง image
        $imageSql = "UPDATE image SET image_name = '$images[$i]' WHERE dataset_id = $id AND class = $i";
        $imageResult = mysqli_query($conn, $imageSql);

        if ($imageResult) {
            // อัปเดตข้อมูลในตาราง image สำเร็จ
        } else {
            echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูลในตาราง image: " . mysqli_error($conn);
        }
    }
}

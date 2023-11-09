<?php
session_start();
include('server.php');
include('user_navbar.php');

mysqli_set_charset($conn, "utf8");


if (isset($_GET["id_class"])) {
    $id_class = $_GET["id_class"];
    // ครอบโค้ดด้านนอกที่ใช้ $id_class ด้วย
} else {
    echo "ID ที่ระบุไม่ถูกต้องหรือไม่มีอยู่ใน URL";
}
$sql = "SELECT class.id_class, class.category, class.classdesc, COUNT(images.id_image) AS image_count
        FROM class
        LEFT JOIN images ON class.id_class = images.imageRef
        WHERE class.id_class = '$id_class'"; // Change "class.dataset_id" to "class.id_class"
$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $category = $row["category"];
        $classdesc = $row["classdesc"];
        $id_class = $row["id_class"];


    } else {
        echo "ไม่พบข้อมูลสำหรับ ID ที่ระบุ";
    }
} else {
    echo "เกิดข้อผิดพลาดในการดึงข้อมูลชุดข้อมูล: " . mysqli_error($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="your-icon-url.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <title>showdata</title>
    <style>
        .equal-size {
            max-width: 200px; /* ปรับขนาดความกว้างตามที่คุณต้องการ */
            max-height: 200px; /* ปรับขนาดความสูงตามที่คุณต้องการ */
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center mt-3">Class detail</h1>

        <table class="table table-striped">
            <div class="form-group col-6">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 15%">คลาส :</th>
                            <td>
                                <?php echo $id_class; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>หมวดหมู่ :</th>
                            <td>
                                <?php echo $category; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>คำอธิบาย :</th>
                            <td>
                                <?php echo $classdesc; ?>
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
        </table>
    </div>

    <div class="container">
    <?php
    
    $sqlimages = "SELECT id_image, imagePath, imageName FROM images WHERE imageRef = '$id_class'";
    $result_images = mysqli_query($conn, $sqlimages);

    if ($result_images && mysqli_num_rows($result_images) > 0) {
        echo '<br>';
        echo '<table class="table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th scope="col">ลำดับ</th>';
        echo '<th scope="col">ชื่อรูป</th>';
        echo '<th scope="col">รูปภาพ</th>';
        echo '<th scope="col">แก้ไข</th>';
        echo '<th scope="col">ลบ</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $imageNumber = 1;
        while ($image_row = mysqli_fetch_assoc($result_images)) {
            $image_id = $image_row["id_image"];
            $image_name = $image_row["imageName"];
            $image_path = $image_row["imagePath"];

            echo '<tr>';
            echo '<th scope="row">' . $imageNumber . '</th>';
            echo '<td>' . $image_name . '</td>';
            echo '<td><img src="' . $image_path . '" class="img-fluid equal-size" alt="รูปภาพคลาส"></td>';

            echo '<td><a href="user_editimage.php?id=' . $image_id . '"><button type="button" class="btn btn-warning">แก้ไขรูปภาพ</button></a></td>';
            echo '<td><a href="?id=' . $image_id . '<button type="button" class="btn btn-danger">ลบรูปภาพ</button></a></td>';
            echo '</tr>';

            $imageNumber++;
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo 'ไม่มีรูปภาพสำหรับคลาสนี้';
    }
    
    ?>
   <button type="button" class="btn btn-primary" onclick="history.back()">  👈🏼 กลับ </button>
    


                 
</div>



</body>


</html>
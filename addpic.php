<?php
session_start();
include('server.php');

// ตั้งค่าการใช้ภาษา utf8
mysqli_set_charset($conn, "utf8");

$id = $_GET["id"];

$sql = "SELECT id, dataname, description , class FROM dataset WHERE id = $id";
$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $dataname = $row["dataname"];
        $description = $row["description"];
        $class = $row["class"];
    } else {
        echo "ไม่พบข้อมูลสำหรับ ID ที่ระบุ";
    }
} else {
    echo "เกิดข้อผิดพลาดในการดึงข้อมูล" . $conn->error;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <title>Edit data</title>
</head>

<body>
    <div class="container">
        <h1 class="text-center mt-5"></h1>
        <form method="post" action="class_db.php" enctype="multipart/form-data">
            <input type="hidden" name="dataset_id" value="<?php echo $id; ?>">
            <input type="hidden" name="class" value="<?php echo $class; ?>">

            <table class="table table-striped">
                <div class="form-group col-6">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 15%;">ชื่อ :</th>
                                <td>
                                    <?php echo $dataname; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>คำอธิบาย :</th>
                                <td>
                                    <?php echo $description; ?>
                                </td>
                            </tr>
                        </thead>
                        </table>
                        <tbody>
                            <tr>
                                <td>
                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th>คลาส</th>
                                                <th>หมวดหมู่</th>
                                                <th>เพิ่มรูปภาพ</th>
                                                <!-- <th>ไฟล์</th> -->

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            for ($i = 1; $i <= $class; $i++) {
                                                echo '<tr>';
                                                echo '<td>' . $i . '</td>';
                                                echo '<td><input type="text" name="category[' . $i . '][]" ></td>';
                                                echo '<td><input type="file" name="image[' . $i . '][]" accept=".jpg, .jpeg, .png, .gif" multiple></td>';
                                               
                                                // $query = "SELECT COUNT(*) AS image_count FROM images WHERE dataset_id = $id AND class = $i";
                                                // $result = mysqli_query($conn, $query);
                                                // if ($result) {
                                                //     $row = mysqli_fetch_assoc($result);
                                                //     $imageCount = $row['image_count'];
                                                // } else {
                                                //     $imageCount = 0;
                                                // }
                                                // echo '<td>' . $imageCount . ' images</td>'; 
                                                // echo '</tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <div class="my-3">
                                        <button type="submit" name="submit"
                                            class="btn btn-success">บันทึกข้อมูล</button>
                                        <input type="reset" value="ล้างข้อมูล" class="btn btn-danger">
                                        <a href="class.php" class="btn btn-primary">ย้อนกลับ</a>
                                    </div>
                    </table>
                </div>
        </form>

    </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->
    <!-- Your JavaScript libraries go here -->
</body>

</html>
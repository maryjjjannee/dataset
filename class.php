<?php
session_start();
include('server.php');

// ตั้งค่าการใช้ภาษา utf8
mysqli_set_charset($conn, "utf8");

$sql = "SELECT id, dataname, class, description, status FROM dataset WHERE class IS NOT NULL;";
$result = mysqli_query($conn, $sql);
$count = mysqli_num_rows($result);
$order = 1;
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <title>แสดงชุดข้อมูล</title>
</head>

<body>
    <div class="container">
        <h1 class="text-center mt-3">ชุดข้อมูล</h1>
        <a href="dataform.php"><button type="button" class="btn btn-primary">สร้างคลาส</button></a>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>ชื่อ</th>
                    <th>คลาส</th>
                    <th>คำอธิบาย</th>
                    <th>สถานะ</th>
                    <th>ดูรายละเอียด</th>
                    <th>เพิ่มรูปภาพ</th>
                    <th>แก้ไขข้อมูล</th>
                    <th>ลบข้อมูล</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $order++; ?></td>
                    <td><?php echo $row["dataname"]; ?></td>
                    <td><?php echo $row["class"]; ?></td>
                    <td><?php echo $row["description"]; ?></td>
                    <td><?php echo $row["status"]; ?></td>
                    <td>
                        <a href="viewform.php?id=<?php echo $row["id"]; ?>"><button type="button" class="btn btn-secondary">ดูรายละเอียด</button></a>
                    </td>
                    <td>
                        <a href="addpic.php?id=<?php echo $row["id"]; ?>"><button type="button" class="btn btn-primary">เพิ่มรูปภาพ</button></a>
                    </td>
                    <td>
                        <a href="editform.php?id=<?php echo $row["id"]; ?>"><button type="button" class="btn btn-warning">แก้ไขข้อมูล</button></a>
                    </td>
                    <td>
                        <a href="deleteform.php?id=<?php echo $row["id"]; ?>"><button type="button" class="btn btn-danger" onclick="return confirm('ยืนยันการลบข้อมูล')">ลบข้อมูล</button></a>
                    </td>
                        
                </tr>
                <?php } ?>

            </tbody>
        </table>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>

    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4WB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
-->
</body>

</html>
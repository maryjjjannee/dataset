<?php
session_start();
include('server.php');


// ตั้งค่าการใช้ภาษา utf8
mysqli_set_charset($conn, "utf8");


$sql = "SELECT id, dataname, class, description, status,implementdate FROM dataset WHERE class IS NOT NULL;";
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
    <link rel="icon"
        href="https://static.vecteezy.com/system/resources/previews/009/665/134/original/seo-research-concept-with-a-magnifying-glass-researching-seo-from-a-website-inside-a-computer-vector-computer-website-showing-an-image-icon-and-a-magnifying-glass-searching-for-seo-keywords-concept-free-png.png">
    <!-- Bootstrap CSS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<title>รายการชุดข้อมูล</title>
       
</head>

<body>
<?php  include('navbar.php');?>

  <h3 class="text-center mt-3"><b>รายการชุดข้อมูล</b></h3>

    <div class="container">
        <!-- <h1 class="text-center mt-3">ชุดข้อมูล</h1> -->
        <a href="dataform.php"><button type="button" class="btn btn-primary">✍️ สร้างคลาส</button></a>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>ชื่อ</th>
                    <th>คลาส</th>
                    <th>คำอธิบาย</th>
                    <th>สถานะ</th>
                    <th>วันที่</th>
                    <th>ดูรายละเอียด</th>
                    <th>เพิ่มข้อมูลคลาส</th>
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
                    <td><?php echo $row["implementdate"]; ?></td>


                    <td>
                        <a href="viewform.php?id=<?php echo $row["id"]; ?>"><button type="button" class="btn btn-secondary"><i class="fa-solid fa-magnifying-glass"></i> ดูรายละเอียด</button></a>
                    </td>
                    <td>
                        <a href="addpic.php?id=<?php echo $row["id"]; ?>"><button type="button" class="btn btn-primary">➕ เพิ่มข้อมูลคลาส</button></a>
                    </td>
                    <td>
                        <a href="editform.php?id=<?php echo $row["id"]; ?>"><button type="button" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i>แก้ไขข้อมูล</button></a>
                    </td>
                    <td>
                        <a href="deleteform.php?id=<?php echo $row["id"]; ?>"><button type="button" class="btn btn-danger" onclick="return confirm('ยืนยันการลบข้อมูล')">🗑️ ลบข้อมูล</button></a>
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
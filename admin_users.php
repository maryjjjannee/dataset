<?php
session_start();
include('server.php');
mysqli_set_charset($conn, "utf8");


$sql = "SELECT users.*, type.type
        FROM users
        INNER JOIN type ON users.role = type.id_type
        WHERE type.type IN ('admin', 'user')";

$result = mysqli_query($conn, $sql); //รันคำสั่งที่ถูกเก็บไว้ในตัวแปร $sql

$count = mysqli_num_rows($result); //เก็บผลที่ได้จากคำสั่ง $result เก็บไว้ในตัวแปร $count
$order = 1; //ให้เริ่มนับแถวจากเลข 1

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon"
        href="https://static.vecteezy.com/system/resources/previews/009/665/134/original/seo-research-concept-with-a-magnifying-glass-researching-seo-from-a-website-inside-a-computer-vector-computer-website-showing-an-image-icon-and-a-magnifying-glass-searching-for-seo-keywords-concept-free-png.png">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
        </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <title>all users</title>
</head>

<body>
    <?php include('admin_navbar.php'); ?>
    <div class="container">
        <h2 class="text-center mt-3">All users</h2>

        <div class="form-group my-3">
            <form action="search.php" method="POST">
                <div class="row">
                    <div class="col-6">
                        <input type="text" placeholder="กรอกชื่อ username ที่ต้องการค้นหา" class="form-control" name="search_users" required>
                    </div>
                    <div class="col-6">
                        <input type="submit" value="search" class="btn btn-info">
                    </div>
                </div>
            </form>
        </div>

        <table class="table  mt-5">
            <thead class="table-success">
                <tr>
                    <th scope="col">ลำดับ</th>
                    <th scope="col">ชื่อ</th>
                    <th scope="col">อีเมล</th>
                    <th scope="col">ประเภท</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td>
                            <?php echo $order++; ?>
                        </td>
                        <td>
                            <?php echo $row["username"]; ?>
                        </td>
                        <td>
                            <?php echo $row["email"]; ?>
                        </td>
                        <td>
                            <?php echo $row["type"]; ?>
                        </td>
                        
                    </tr>
                <?php } ?>

              
            </tbody>
            
        </table>
       
    </div>
</body>

</html>
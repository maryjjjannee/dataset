<?php
session_start();
include('server.php');
mysqli_set_charset($conn, "utf8");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["search_users"])) {
    $search = $_POST["search_users"];
    $sql = "SELECT users.*, type.type
            FROM users
            INNER JOIN type ON users.role = type.id_type
            WHERE (type.type IN ('admin', 'user')) AND (users.username LIKE '%$search%' OR users.email LIKE '%$search%')";
} else {
    $sql = "SELECT users.*, type.type
            FROM users
            INNER JOIN type ON users.role = type.id_type
            WHERE type.type IN ('admin', 'user')";
}

$result = mysqli_query($conn, $sql);
$count = mysqli_num_rows($result);
$order = 1;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="your_icon_url_here.png">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <title>รายชื่อผู้ใช้งานทั้งหมด</title>
</head>

<body>
    <?php include('admin_navbar.php'); ?>
    <div class="container">
        <h2 class="text-center mt-3">รายชื่อผู้ใช้งานทั้งหมด</h2>

        <div class="form-group my-3">
            <form action="" method="POST">
                <div class="row">
                    <div class="col-6">
                        <input type="text" placeholder="กรอกชื่อ username ที่ต้องการค้นหา" class="form-control"
                            name="search_users">
                    </div>
                    <div class="col-6">
                        <input type="submit" value="ค้นหาข้อมูลผู้ใช้งาน" class="btn btn-info">
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
                <?php
                if ($result) {
                    $counter = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<th scope='row'>$counter</th>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['type'] . "</td>";
                        echo "</tr>";
                        $counter++;
                    }
                } else {
                    echo "<tr><td colspan='4'>ไม่พบผู้ใช้งาน</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>

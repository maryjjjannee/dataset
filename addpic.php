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


// echo $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Add image</title>
</head>

<body>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon"
            href="https://static.vecteezy.com/system/resources/previews/009/665/134/original/seo-research-concept-with-a-magnifying-glass-researching-seo-from-a-website-inside-a-computer-vector-computer-website-showing-an-image-icon-and-a-magnifying-glass-searching-for-seo-keywords-concept-free-png.png">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

        <title>Add image</title>
    </head>

    <body>
        <?php include('user_navbar.php'); ?>
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
                                    <th style="width: 15%; text-align:right;" class="">ชื่อ :</th>
                                    <td>
                                        <?php echo $dataname; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="" style="text-align:right;">คำอธิบาย :</th>
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
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            for ($i = 1; $i <= $class; $i++) {

                                                echo '<tr>';
                                                echo '<td>' . $i . '</td>';
                                                echo '<td><input class="form-control" type="text" name="category[' . $i . ']" ></td>';
                                                echo '<td><input class="form-control"  type="file" name="image[' . $i . '][]" accept=".jpg, .jpeg, .png, .gif" multiple></td>';
                                                echo '</tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <div class="my-3">
                                    <a href="user.php" class="btn btn-primary">👈🏼 กลับ</a>
                                        <button type="submit" name="submit" class="btn btn-success">📂
                                            บันทึกข้อมูล</button>
                                        <input type="reset" value="🗑️ ลบข้อมูล" class="btn btn-danger">
                                        
                                    </div>
                </table>
        </div>
        </form>

        </div>
        </div>

    </body>

    </html>
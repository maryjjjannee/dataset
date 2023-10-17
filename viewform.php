<?php
session_start();
include('server.php');


// if (isset($_SESSION['id_users'])) {
//     $user_id = $_SESSION['id_users'];
//     echo "User ID: " . $user_id;
// } else {
//     echo "User is not logged in.";
// }

mysqli_set_charset($conn, "utf8");

$id = $_GET["id"];

$sql = "SELECT dataset.id, dataset.dataname, dataset.class, dataset.description, dataset.status
FROM dataset
WHERE dataset.id = $id";
$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $dataname = $row["dataname"];
        $description = $row["description"];
        $class = $row["class"];
        $status = $row["status"];

        // Fetch class-specific data grouped by category
        $classSql = "SELECT category, GROUP_CONCAT(image) AS images, COUNT(*) AS imageCount FROM class WHERE dataset_id = $id GROUP BY category";
        $classResult = mysqli_query($conn, $classSql);
        if (!$classResult) {
            echo "เกิดข้อผิดพลาดในการดึงข้อมูลคลาส: " . mysqli_error($conn);
        }
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <title>showdata</title>
</head>

<body>
    <div class="container">
        <h1 class="text-center mt-3">ชุดข้อมูล</h1>
        <input type="hidden" value="<?php echo $id; ?>" name="id">

        <table class="table table-striped">
            <div class="form-group col-6">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width : 15%">ชื่อ :</th>
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
                        <tr>
                            <th>จำนวนคลาส :</th>
                            <td>
                                <?php echo $class; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>สถานะ :</th>
                            <td>
                                <?php echo $status; ?>
                            </td>
                        </tr>
                    </thead>

                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th>คลาส</th>
                                <th>หมวดหมู่</th>
                                <th>จำนวนรูปภาพ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1; // Initialize class number
                            while ($classRow = mysqli_fetch_assoc($classResult)) {
                                $category = $classRow["category"];
                                $imageCount = $classRow["imageCount"];

                                echo '<tr>';
                                echo '<td>' . $i . '</td>';
                                echo '<td>' . $category . '</td>';
                                echo '<td>' . $imageCount . ' ไฟล์</td>';

                                echo '</td>';
                                $i++; // Increment class number
                            }
                            ?>
                        </tbody>
                    </table>

                    <a href="class.php" class="btn btn-primary">ย้อนกลับ</a>
            </div>
            </thead>

        </table>
    </div>
    </table>
    </form>
    </div>
</body>

</html>
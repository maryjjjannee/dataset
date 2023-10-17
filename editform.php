<?php
session_start();
include('server.php');

// ตั้งค่าการใช้ภาษา utf8
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
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <title>แก้ไขข้อมูล</title>
</head>

<body>
    <div class="container my-3">
        <h2 class="text-left">แก้ไขข้อมูล</h2>
        <hr>
        <form action="updateform.php" method="POST">
            <input type="hidden" value="<?php echo $row["id"]; ?>" name="id">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>คลาส</th>
                        <th>หมวดหมู่</th>
                        <th>ไฟล์</th>
                        <th></th>
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
                        echo '<td><input type="text" name="category[]" value="' . $category . '"></td>'; // Include an input field for category
                        echo '<td><input type="file" name="image[]" accept=".jpg, .jpeg, .png, .gif ' . $imageCount . '" multiple></td>';
                        echo '<td><button type="button" class="btn btn-danger" onclick="removeClassRow(this)">ลบ</button></td>';
                         $query = "SELECT COUNT(*) AS image_count FROM images WHERE dataset_id = $id AND class = $i";
                                                $result = mysqli_query($conn, $query);
                                                if ($result) {
                                                    $row = mysqli_fetch_assoc($result);
                                                    $imageCount = $row['image_count'];
                                                } else {
                                                    $imageCount = 0;
                                                }
                                                echo '<td>' . $imageCount . ' images</td>'; 
                                                echo '</tr>';
                        echo '</tr>';
                        $i++; // Increment class number
                    }
                    ?>

                </tbody>
            </table>
            <div class="my-3">
                <a href="class.php" class="btn btn-primary">ย้อนกลับ</a>
                <input type="submit" name="submit" value="บันทึกข้อมูล" class="btn btn-success">
                <input type="reset" value="ล้างข้อมูล" class="btn btn-danger">
                <button type="button" class="btn btn-secondary" onclick="addClassRow()">เพิ่มคลาส</button>
            </div>
        </form>
    </div>
    <script>
        function addClassRow() {
            const table = document.querySelector("table tbody");
            const rows = table.querySelectorAll("tr");
            const lastRow = rows[rows.length - 1];

            if (lastRow) {
                const lastClassNumber = parseInt(lastRow.querySelector("td:first-child").innerText);
                const newClassNumber = lastClassNumber + 1;
                const newRow = document.createElement("tr");
                newRow.innerHTML = `
            <td>${newClassNumber}</td>
            <td><input type="text" name="category[]"></td>
            <td><input type="file" name="image[]" accept=".jpg, .jpeg, .png, .gif" multiple></td>
            <td><button type="button" class="btn btn-danger" onclick="removeClassRow(this)">ลบ</button></td>
        `;
                table.appendChild(newRow);
            } else {
                // If no rows exist, add the first row
                const newRow = document.createElement("tr");
                newRow.innerHTML = `
            <td>1</td>
            <td><input type="text" name="category[]"></td>
            <td><input type="file" name="image[]" accept=".jpg, .jpeg, .png, .gif" multiple></td>
            <td><button type="button" class="btn btn-danger" onclick="removeClassRow(this)">ลบ</button></td>
        `;
                table.appendChild(newRow);
            }
        }


        function removeClassRow(button) {
            const row = button.parentNode.parentNode;
            row.parentNode.removeChild(row);
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
        crossorigin="anonymous"></script>
</body>

</html>
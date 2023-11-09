<?php
session_start();
include('server.php'); // Include your database connection code
mysqli_set_charset($conn, "utf8");
// Check database connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    $user_id = $_SESSION['id']; // รับค่า 'id' จากเซสชัน
    $username = $_SESSION['username']; // รับค่า 'username' จากเซสชัน

    // ทำสิ่งที่คุณต้องการกับ 'id' และ 'username' ในหน้านี้
} 
// Define the dataset ID
$id = $_GET["id"];

// Fetch dataset and class information
$sql = "SELECT dataset.id AS dataset_id, status, dataset.dataname, dataset.description, COUNT(class.id_class) AS class_count
        FROM dataset
        LEFT JOIN class ON dataset.id = class.dataset_id
        WHERE dataset.id = $id
        GROUP BY dataset.id, dataset.dataname, dataset.description";
$result = mysqli_query($conn, $sql);

// Check if the dataset exists
if ($result) {
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $dataname = $row["dataname"];
        $description = $row["description"];
        $class = $row["class_count"];
        $status = $row["status"];

        // Fetch class-specific data grouped by category
        $classSql = "SELECT id_class,class.category, COUNT(images.id_image) AS imageCount, class.classdesc
                    FROM class
                    INNER JOIN images ON class.id_class = images.imageRef
                    WHERE class.dataset_id = $id
                    GROUP BY class.category,id_class";
        $classResult = mysqli_query($conn, $classSql);

        if (!$classResult) {
            echo "Error fetching class data: " . mysqli_error($conn);
        }
    } else {
        echo "No data found for the specified ID.";
    }
} else {
    echo "Error fetching dataset information: " . mysqli_error($conn);
}
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
    <title>Edit Data</title>
</head>

<body>
    <?php include('user_navbar.php'); ?>
    <div class="container my-3">
        <h3 class="text-center">📑 Edit Data <?php echo $dataname; ?> 📑</h3>
        <hr>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" style="width:20%" class="table-warning">รายละเอียด</th>
                    <td> <?php echo $description; ?></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="col" class="table-warning">จำนวนคลาส</th>
                    <td> <?php echo $class; ?></td>
                </tr>
                <tr>
                    <th scope="col" class="table-warning">สถานะ</th>
                    <td> <?php echo $status; ?></td>
                </tr>
            </tbody>
        </table>
        <form action="updateform.php" method="POST" enctype="multipart/form-data" id="classForm">
    <h3 class="text-left">ข้อมูลคลาสทั้งหมด 
        <button type="button" class="btn btn-warning" data-bs-toggle="modal"data-bs-target="#formInsertClass">➕คลาส</button></h3>
        <table class="table table-success table-striped mt-3" style="border:white;" id="addClass">
    <thead>
        <tr>
            <th>คลาส</th>
            <th>หมวดหมู่</th>
            <th>คำอธิบาย</th>
            <th>จำนวนไฟล์รูปภาพ</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $i = 1; // Initialize class number
            while ($classRow = mysqli_fetch_assoc($classResult)) {
                $categoryId = $classRow["id_class"];
                $category = $classRow["category"];
                $classdescId = $classRow["id_class"];
                $classdesc = $classRow["classdesc"]; // ตรวจสอบว่าคอลัมน์ "classdesc" ถูกต้อง
                $imageCount = $classRow["imageCount"];
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td>
                <input class="form-control" type="text" name="category[<?php echo $categoryId; ?>]" value="<?php echo $category; ?>">
                <input type="hidden" name="category_id[]" value="<?php echo $categoryId; ?>">
            </td>
            <td>
                <input class="form-control" type="text" name="classdesc[<?php echo $classdescId; ?>]" value="<?php echo $classdesc; ?>">
                <input type="hidden" name="classdesc_id[]" value="<?php echo $classdescId; ?>">
            </td>
            <td><?php echo $imageCount; ?> files</td>
        </tr>
        <?php
            $i++;
        }
        ?>
    </tbody>
</table>

    <div class="my-3 float-end">
        <a href="class.php" class="btn btn-primary">👈🏼 กลับ</a>
        <input type="submit" name="submit" id="updateButton" value="📂 บันทึกข้อมูล" class="btn btn-success">
        <input type="reset" value="🗑️ ลบข้อมูล" class="btn btn-danger disabled">
        </div>
</form>

    </div>
</body>


<div class="modal fade" id="formInsertClass" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">📌 Add Class</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <form id="addClassForm" method="POST" action="insertModal.php" enctype="multipart/form-data">
                    <div class="form-floating mb-3">
                        <!-- Input for class name -->
                        <input type="text" name="category" class="form-control" id="category" placeholder="Please enter category" required>
                        <label for="floatingInput">Class</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="classdesc" class="form-control" id="classdesc" placeholder="Please enter description" required>
                        <label for="floatingInput">Description</label>
                    </div>
                    <div class="mb-3">
                        <!-- Input for multiple images -->
                        <label for="formFile" class="form-label">Upload Images</label>
                        <input class="form-control" type="file" name="images[]" accept=".jpg, .jpeg, .png, .gif" multiple>
                    </div>
                    <!-- Hidden input for the dataset ID (from the original page) -->
                    <input type="hidden" name="dataset_id" value="<?php echo $id; ?>">
                    <input type="hidden" name="username" value="<?php echo $user; ?>">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="JavaScript/function.js"></script>
</html>
<script>
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("updateButton").addEventListener("click", function(event) {
        event.preventDefault(); // หยุดการส่งแบบปกติของฟอร์ม

        // รับข้อมูลจากฟอร์ม
        var formData = new FormData(document.getElementById("classForm"));

        // ส่งข้อมูลไปยังไฟล์ PHP สำหรับอัพเดท
        fetch("updateform.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json()) // สามารถแก้ไขตามความต้องการ
        .then(data => {
               console.log(data)
            if (data.success) {
             
                alert("บันทึกข้อมูลเรียบร้อยแล้ว");
                // ทำสิ่งที่คุณต้องการหลังจากบันทึกเช่น รีโหลดหรือรายการอื่น ๆ
            } else {
                alert("เกิดข้อผิดพลาดในการบันทึกข้อมูล");
            }
        });
    });
});
</script>



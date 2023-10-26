<?php
session_start();
include('server.php');

mysqli_set_charset($conn, "utf8");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$id_user = $_SESSION['id'];
$dataname = $_POST['dataname'];
$description = $_POST['description'];
$class = $_POST['class'];
// $implementdate = $_POST['implementdate'];
// $imagedataset = $_POST['imagedataset'];
$typeImg = $_POST['typeImg'];

$status = $_POST['status'] === 'ไม่ใช้งาน' ? 2 : 1;
$PDPA = $_POST['PDPA'] === 'ยินยอม' ? 1 : 2;

$IRBstatus = $_POST['IRBstatus'] === 'ขอ' ? 1 : 2;
$IRBstatus = $_POST['IRBstatus'];

// เช็คค่า $IRBstatus
if ($IRBstatus === 'ไม่ขอ') {
    $IRBtypeValue = 0; // หรือค่าใดๆ ที่คุณต้องการเพื่อบ่งชี้ว่าไม่มีค่า (เช่น null, หรือ 0)
} else {
    // ผู้ใช้เลือกอื่น ๆ ที่ไม่ใช่ "ไม่ขอ"
    $IRBtype = $_POST['IRBtype']; // รับค่าที่ผู้ใช้เลือก

    // ตรวจสอบค่าและกำหนดค่าตามที่คุณต้องการ
    if ($IRBtype === 'จริยธรรมการวิจัยในมนุษย์') {
        $IRBtypeValue = 1;
    } elseif ($IRBtype === 'จริยธรรมการวิจัยในสัตว์') {
        $IRBtypeValue = 2;
    } elseif ($IRBtype === 'จริยธรรมการวิจัยในชีวภาพ') {
        $IRBtypeValue = 3;
    } else {
        // กรณีอื่น ๆ ที่คุณต้องการจัดการ (อาจจะเป็นค่าเริ่มต้นหรือการแจ้งเตือน)
        $IRBtypeValue = 0;
    }
}

// ต่อไปให้ใช้ $IRBtypeValue ในการบันทึกลงในฐานข้อมูล


$inputCount = isset($_POST["class"]) ? (int)$_POST["class"] : 0;

$imgName = 'Null.PNG';

if (isset($_FILES["imagedataset1"])) {
    $file_name = $_FILES['imagedataset1']['name'];
    $file_tmp = $_FILES['imagedataset1']['tmp_name'];
    $file_type = $_FILES['imagedataset1']['type'];
    $file_size = $_FILES['imagedataset1']['size'];
    $tmp = explode('.', $_FILES['imagedataset1']['name']);
    $file_ext = strtolower(end($tmp));
    $file_name = date('Y-m-d_His', time()) . "." . $file_ext;
    $file = "./uploads/datasetImage/" . $file_name;
    if (move_uploaded_file($file_tmp, $file)) {
        $imgName = $file_name;
    }
}

// Handle IRBdocument file upload
$IRBdocumentName = '';

if ($_FILES['IRBdocument']['error'] === UPLOAD_ERR_OK) {
    // ไม่มีข้อผิดพลาดในการอัปโหลด
    $uploadedFile = $_FILES['IRBdocument']['tmp_name']; // ไฟล์ที่อัปโหลดชั่วคราว

    // ตรวจสอบประเภทของไฟล์ ในกรณีนี้คือ PDF
    $fileType = $_FILES['IRBdocument']['type'];
    if ($fileType === 'application/pdf') {
        // ชนิดของไฟล์ถูกต้อง

        // ตรวจสอบขนาดไฟล์ (ถ้าต้องการ)
        $fileSize = $_FILES['IRBdocument']['size']; // ขนาดไฟล์ (ไบต์)

        // ตรวจสอบขนาดไฟล์ ในกรณีนี้ไม่เกิน 2 MB (แต่คุณสามารถปรับขนาดตามต้องการ)
        if ($fileSize <= 2097152) {
            // ขนาดไฟล์ถูกต้อง

            // สร้างชื่อไฟล์ใหม่ (ตามความจำเป็น)
            $newFileName = uniqid() . '.pdf'; // สร้างชื่อไฟล์ใหม่ โดยใช้ค่าที่ไม่ซ้ำกัน
            $destination = 'uploads/' . $newFileName; // เส้นทางไปยังไฟล์ที่บันทึก

            // ย้ายไฟล์ที่อัปโหลดไปยังโฟลเดอร์ปลายทาง
            if (move_uploaded_file($uploadedFile, $destination)) {
                $IRBdocumentName = $newFileName;
            } else {
                // เกิดข้อผิดพลาดในการย้ายไฟล์
                echo 'Error moving the uploaded file.';
            }
        } else {
            // ขนาดไฟล์เกินขีดจำกัดที่กำหนด
            echo 'File size is too large.';
        }
    } else {
        // ชนิดของไฟล์ไม่ถูกต้อง (ไม่ใช่ PDF)
        echo 'Invalid file type. Please upload a PDF file.';
    }
}

// Create an SQL query for inserting data
$sql = "INSERT INTO dataset (dataname, description, class, status, id_users, imagedataset, imagetype, IRBstatus, IRBdocument, IRBtype, PDPA) VALUES ('$dataname', '$description', '$class', '$status', '$id_user', '$imgName', '$typeImg', '$IRBstatus', '$IRBdocumentName', '$IRBtype', '$PDPA')";

// Execute the SQL query
if ($conn->query($sql) === TRUE) {
    if ($id_user === 1) {
        // Go to index page
        header('location: index.php');
        exit(0);
    } else {
        // Go to user page
        header('location: user.php');
        exit(0);
    }
} else {
    // Handle errors in data insertion
    echo "Error in data insertion: " . $conn->error;
}

// Close the database connection
$conn->close();
}
?>

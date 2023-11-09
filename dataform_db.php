<?php
session_start();
include('server.php');

mysqli_set_charset($conn, "utf8");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user = $_SESSION['id'];
    $dataname = $_POST['dataname'];
    $description = $_POST['description'];
    $class = $_POST['class'];
    $imagetype = $_POST['imagetype'];
    $statuspost = $_POST['statuspost'] ?? 'รออนุมัติ';

// เริ่มต้นด้วยค่า $id_imagetype เป็น null
$id_imagetype = null;

// กำหนดค่า $id_imagetype โดยใช้คำสั่ง switch
switch ($imagetype) {
    case 'ภาพขาว-ดำ':
        $id_imagetype = 1;
        break;
    case 'ภาพเทา':
        $id_imagetype = 2;
        break;
    case 'ภาพสี':
        $id_imagetype = 3;
        break;
    default:
        // กรณีอื่น ๆ ที่คุณต้องการจัดการ (อาจจะเป็นค่าเริ่มต้นหรือการแจ้งเตือน)
        $id_imagetype = 0;
        break;
}
 // รับค่า imagetype จากผู้ใช้

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
    

    $inputCount = isset($_POST["class"]) ? (int) $_POST["class"] : 0;

    $imgName = 'Null.PNG';

    if (isset($_FILES["imagedataset1"])) {
        $file_name = $_FILES['imagedataset1']['name'];
        $file_tmp = $_FILES['imagedataset1']['tmp_name'];
        $file_type = $_FILES['imagedataset1']['type'];
        $file_size = $_FILES['imagedataset1']['size'];
        // $file_name = date('Y-m-d_His', time()) . "." . $file_ext; // Remove this line
        $file = "./uploads/datasetImage/" . $file_name; // Use the original file name
        if (move_uploaded_file($file_tmp, $file)) {
            $imgName = $file_name; // Update $imgName with the original file name
        }
    }


    // Handle IRBdocument file upload
    $IRBdocumentName = '';

    if ($_FILES['IRBdocument']['error'] === UPLOAD_ERR_OK) {
        // No upload errors
    
        $uploadedFile = $_FILES['IRBdocument']['tmp_name'];
    
        // Check the file type (in this case, PDF)
        $fileType = $_FILES['IRBdocument']['type'];
        if ($fileType === 'application/pdf') {
            // File type is correct
    
            // Set the destination path to "uploads/PDPA" and keep the original file name
            $destination = "./uploads/PDPA/" . $_FILES['IRBdocument']['name'];
    
            // Move the uploaded file to the destination folder
            if (move_uploaded_file($uploadedFile, $destination)) {
                $IRBdocumentName = $_FILES['IRBdocument']['name']; // Set $IRBdocumentName to the original file name
            } else {
                // Error moving the uploaded file
                echo 'Error moving the uploaded file.';
            }
        } else {
            // Invalid file type (not a PDF)
            echo 'Invalid file type. Please upload a PDF file.';
        }
    }

  

    // Create an SQL query for inserting data
    $sql = "INSERT INTO dataset (dataname, description, class, status, id_users, imagedataset, imagetype, IRBstatus, IRBdocument, IRBtype, PDPA, statuspost) VALUES ('$dataname', '$description', '$class', '$status', '$id_user', '$imgName', '$imagetype', '$IRBstatus', '$IRBdocumentName', '$IRBtype', '$PDPA' ,'$statuspost')";

    // Execute the SQL query
    if ($conn->query($sql) === TRUE) {
        if ($id_user === 1) {
            // Go to index page
            header('location: index.php');
            exit(0);
        } else {
            // Go to user page
            header('location: class.php');
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
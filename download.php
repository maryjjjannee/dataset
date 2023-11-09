<?php
session_start();
include('server.php');

$id = $_GET["id"];

// Fetch the dataset dataname from the database (use prepared statement)
$sql = "SELECT dataname FROM dataset WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $dataname = $row["dataname"];

    // Define the directory where the dataset files are stored (Update this with the actual path)
    $dataDirectory = "/path/to/dataset/files/";

    // Construct the full path to the dataset file
    $fullFilePath = $dataDirectory . $dataname;

    // Check if the file exists
    if (file_exists($fullFilePath)) {
        // Set the appropriate headers for downloading the file
        header("Content-Disposition: attachment; filename=" . $dataname);
        header("Content-Type: application/octet-stream");
        header("Content-Length: " . filesize($fullFilePath));

        // Read and output the file content
        readfile($fullFilePath);

        // Insert download transaction data into the database
        $userId = $_SESSION['user_id']; // Assuming you have a session variable for user ID
        $downloadDate = date("Y-m-d H:i:s"); // Current date and time

        // Insert the download transaction data into the 'download_transaction' table (use prepared statement)
        $insertTransactionSql = "INSERT INTO download_transaction (download_date, id_users, dataset_id) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insertTransactionSql);
        mysqli_stmt_bind_param($stmt, "sii", $downloadDate, $userId, $id);
        mysqli_stmt_execute($stmt);

        exit();
    } else {
        echo "ขออภัย, ไม่พบไฟล์ข้อมูลสำหรับดาวน์โหลด";
    }
} else {
    echo "ขออภัย, ไม่พบข้อมูลสำหรับดาวน์โหลด";
}
?>

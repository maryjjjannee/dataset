<?php
session_start();
include('server.php'); // Include your database connection code
mysqli_set_charset($conn, "utf8");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $dataset_id = $_POST["dataset_id"];
    $category_data = $_POST["category"];
    $classdesc_data = $_POST["classdesc"];
    $classdesc_id_data = $_POST["classdesc_id"];
    $category_id_data = $_POST["category_id"];
    $return = [];
    // เริ่มกระบวนการอัพเดท
    $success = true;

    // วนลูปผ่านข้อมูลหมวดหมู่และ category_id
    for ($i = 0; $i < count($category_id_data); $i++) {
        $category_id = $category_id_data[$i];
        array_push($return, $category_id);
        $category = mysqli_real_escape_string($conn, $category_data[$category_id]);
        $classdesc_id = $classdesc_id_data[$i];
        $classdesc = mysqli_real_escape_string($conn, $classdesc_data[$classdesc_id]);

        // สร้างคำสั่ง SQL สำหรับอัพเดท
        $sql = "UPDATE class SET category = '$category', classdesc = '$classdesc' WHERE id_class = $category_id";

        if (!mysqli_query($conn, $sql)) {
            $success = false;
            break;
        }
    }

    if ($success) {
        echo json_encode(["success" => true, "return" =>  $return]);
    } else {
        echo json_encode(["success" => false, "return" =>  $return]);
    }
} else {
    echo json_encode(["success" => false, "return" =>  $return]);
}

// ปิดการเชื่อมต่อกับฐานข้อมูล
mysqli_close($conn);
?>
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
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("บันทึกข้อมูลเรียบร้อยแล้ว"); // แสดงข้อความเมื่ออัพเดทสำเร็จ
                // ทำสิ่งที่คุณต้องการหลังจากบันทึกเช่น รีโหลดหรือรายการอื่น ๆ
            } else {
                alert("เกิดข้อผิดพลาดในการบันทึกข้อมูล");
            }
        });
    });
});

</script>



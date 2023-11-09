<?php
session_start();
include('server.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST["id"];
    $statuspost = $_POST["statuspost"];
    $return = [];
    // เริ่มกระบวนการอัพเดท
    $success = false;

    // สร้างคำสั่ง SQL สำหรับอัพเดท
    $sql = "UPDATE dataset SET statuspost = '$statuspost' WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        $success = true;
    }

    // อาจต้องเพิ่มตรวจสอบสถานะ $success และปรับปรุง $return ตามความเหมาะสม

    // ตรวจสอบว่าอนุมัติสำเร็จหรือไม่แล้วนำผู้ใช้ไปยังหน้า index.php
    if ($success) {
        header('Location: index.php');
        exit;
    } else {
        echo json_encode(["success" => false, "return" => $return]);
    }
} else {
    echo json_encode(["success" => false, "return" => $return]);
}

// ปิดการเชื่อมต่อกับฐานข้อมูล
mysqli_close($conn);
?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("approveButton").addEventListener("click", function (event) {
            event.preventDefault(); // หยุดการส่งแบบปกติของฟอร์ม

            // รับข้อมูลจากฟอร์ม
            var formData = new FormData(document.getElementById("statusForm"));

            fetch("updatestatus.php", {
                method: "POST",
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("อนุมัติสำเร็จ"); // แสดงข้อความเมื่ออนุมัติสำเร็จ
                        // ทำสิ่งที่คุณต้องการหลังจากอนุมัติเช่น รีโหลดหน้าหลัก
                        window.location.href = 'index.php'; // เปลี่ยนเส้นทางไปยังหน้า index
                    } else {
                        alert("เกิดข้อผิดพลาดในการบันทึกข้อมูล");
                    }
                });


        });
    });
    document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("disapproveButton").addEventListener("click", function (event) {
        event.preventDefault(); // หยุดการส่งแบบปกติของฟอร์ม

        // ตรวจสอบว่าเหตุผลที่ไม่อนุมัติถูกป้อนหรือไม่
        var disapproveReason = document.getElementById("disapproveReason").value;
        if (!disapproveReason) {
            alert("โปรดระบุเหตุผลที่ไม่อนุมัติ");
            return;
        }

        // รับข้อมูลจากฟอร์ม
        var formData = new FormData(document.getElementById("statusForm"));
        fetch("updatestatus.php", {
            method: "POST",
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("อนุมัติสำเร็จ"); // แสดงข้อความเมื่ออนุมัติสำเร็จ
                    // ทำสิ่งที่คุณต้องการหลังจากอนุมัติเช่น รีโหลดหน้าหลัก
                    window.location.href = 'index.php'; // เปลี่ยนเส้นทางไปยังหน้า index
                } else {
                    alert("เกิดข้อผิดพลาดในการบันทึกข้อมูล");
                }
            });
    });
});


</script>
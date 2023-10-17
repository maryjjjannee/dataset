<?php
session_start();
include('server.php'); ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dataform</title>
    <link rel="stylesheet" href="styleforms.css">

</head>

<body>

    <form action="dataform_db.php" method="post" entype="mutipart/form-data">
        <div class="input-group">
            <label for="dataname">ชื่อ</label>
            <input type="text" name="dataname" id="dataname">
        </div>
        <br>
        <div class="input-group">
            <label for="description" style="font-size: 16px; ">คำอธิบาย</label>
            <input type="text" name="description" id="description" rows="3"
                style="width: 500px; height: 80px; font-size: 14px;">
        </div>
        <br>
        <br>
        <div class="input-group">
            <span for="class">จำนวนคลาส <input type="number" name="class" id="class" placeholder="ป้อนจำนวนคลาส"
                    style="width: 350px; font-size: 14px; margin-left: 20px; margin-right: 20px; margin-top:10px"> คลาส
            </span>
        </div>
        <?php
        if (isset($class) && $class > 0) {
            echo '<div id="inputContainer">';
            for ($i = 1; $i <= $class; $i++) {
                echo '<input type="text" name="inputName[]" placeholder="Input ' . $i . '"><br>';
            }
            echo '</div>';
        }
        ?>

        </div>
        <br>
        <div>
            <label for="status">สถานะ <label class="status-button">
                    <label>
                        <input type="radio" name="status" value="ใช้งาน" checked> ใช้งาน
                    </label>
                </label>
                <label>
                    <input type="radio" name="status" value="ไม่ใช้งาน"> ไม่ใช้งาน
                </label>
            </label>
        </div>
        <div class="input-group-btn">
            <button type="submit" name="dataform_db" class="btn-form">บันทึก</button>
            <button type="reset" name="cancel" class="btn-form">ยกเลิก</button>
        </div>
    </form>

</body>

</html>
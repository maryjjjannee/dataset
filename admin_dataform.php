<?php
session_start();
include('server.php');


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon"
        href="https://static.vecteezy.com/system/resources/previews/009/665/134/original/seo-research-concept-with-a-magnifying-glass-researching-seo-from-a-website-inside-a-computer-vector-computer-website-showing-an-image-icon-and-a-magnifying-glass-searching-for-seo-keywords-concept-free-png.png">
    <title>Dataform</title>
    <link rel="stylesheet" href="styleforms.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <?php

    include('server.php');
    include('admin_navbar.php'); ?>
    <div class="" role="">
        <a href="index.php" class="btn btn-primary mt-2 ms-2">👈🏼 กลับ</a>
        <h3 style="text-align:center;">Add Dataset</h1>
    </div>
   
    <form class="mt-2 mb-5 " action="dataform_db.php" method="post" enctype="multipart/form-data" style="display: grid;
            width: fit-content;
            align-items: center;
            text-align: left;">
        <div class="form-group">
            <label for="dataname">ชื่อ</label>
            <input class="form-control" type="text" name="dataname" id="dataname">
        </div>

        <div class="form-group mt-3">
            <label for="description">คำอธิบาย</label>
            <textarea class="form-control" type="text" name="description" id="description" rows="3"
                style="width: 500px; height: 80px; font-size: 14px;"></textarea>
        </div>

        <div class="form-group mt-3">
            <label for="class">จำนวนคลาส <input class="form-control" type="number" name="class" id="class"
                    placeholder="ระบุจำนวนคลาส" style=" font-size: 14px;">
            </label>
        </div>
        <?php
        if (isset($class) && $class > 0) {
            echo '<div id="inputContainer">';
            for ($i = 1; $i <= $class; $i++) {
                echo '<input class="form-control" type="text" name="inputName[]" placeholder="Input ' . $i . '"><br>';
            }
            echo '</div>';
        }
        ?>
        <div class="form-group mt-3">
            <label for="imagedataset1">รูป</label>
            <input class="form-control" type="file" name="imagedataset1" id="imagedataset">
        </div>

        <label for="" class="mt-3 ">ประเภทของภาพ</label>
        <div class="d-flex">
            <div class="row">
                <div class="form-check ms-3">
                    <input class="form-check-input" type="radio" name="typeImg" id="typeImg1" value="1">
                    <label class="form-check-label" for="typeImg1">
                        ภาพขาว
                    </label>
                </div>
                <div class="form-check ms-3">
                    <input class="form-check-input" type="radio" name="typeImg" id="typeImg2" value="2">
                    <label class="form-check-label" for="typeImg2">
                        ภาพสี
                    </label>
                </div>
            </div>
        </div>


        <label for="status" class="mt-3 ">สถานะ </label>
        <div class="d-flex">
            <div class="row">
                <div class="form-check ms-3">
                    <input class="form-check-input" type="radio" name="status" id="status1" value="ใช้งาน" checked>
                    <label class="form-check-label" for="status1">
                        ใช้งาน
                    </label>
                </div>
                <div class="form-check ms-3">
                    <input class="form-check-input" type="radio" name="status" id="status2" value="ไม่ใช้งาน">
                    <label class="form-check-label" for="status2">
                        ไม่ใช้งาน
                    </label>
                </div>
            </div>
        </div>


        <div class="input-group-btn gap-2 mt-3">
            <button type="submit" name="dataform_db" class="btn btn-success">📂 บันทึก</button>
            <button type="reset" name="cancel" class="btn btn-danger">🗑️ ยกเลิก</button>
        </div>
    </form>


</body>

</html>
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>

<body>
    <?php

    include('user_navbar.php'); ?>
    <div>
        <a href="class.php" class="btn btn-primary mt-2 ms-2">👈🏼 กลับ</a>
        <h3 style="text-align:center;">Add Dataset</h1>
    </div>

    <form class="mt-2 mb-5" action="dataform_db.php" method="post" enctype="multipart/form-data" style="display: grid;">

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
            <label for="imagedataset1">รูปประกอบ dataset</label>
            <input class="form-control" type="file" name="imagedataset1" id="imagedataset" accept=".jpg, .png, .">
        </div>

        <label for="" class="mt-3 ">ประเภทของภาพ</label>
        <div class="d-flex">
            <div class="row">
                <div class="form-check ms-3">
                    <input class="form-check-input" type="radio" name="typeImg" id="typeImg1" value="1">
                    <label class="form-check-label" for="typeImg1">
                        ภาพขาว-ดำ (ฺBinary)
                    </label>
                </div>
                <div class="form-check ms-3">
                    <input class="form-check-input" type="radio" name="typeImg" id="typeImg2" value="2">
                    <label class="form-check-label" for="typeImg2">
                        ภาพเทา (GrayScale)
                    </label>
                </div>
                <div class="form-check ms-3">
                    <input class="form-check-input" type="radio" name="typeImg" id="typeImg3" value="3">
                    <label class="form-check-label" for="typeImg3">
                        ภาพสี (RGB)
                    </label>
                </div>
            </div>
        </div>


        <label for="status" class="mt-3 ">สถานะการใช้ข้อมูล </label>
        <div class="d-flex">
            <div class="row">
                <div class="form-check ms-3">
                    <input class="form-check-input" type="radio" name="status" id="status1" value="ใช้งาน" >
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

        <label for="status" class="mt-3">สถานะการขอจริยธรรม</label>
        <div class="d-flex">
            <div class="row">
                <div class="form-check ms-3">
                    <input class="form-check-input" type="radio" name="IRBstatus" id="IRBstatus1" value="ขอ" >
                    <label class="form-check-label" for="IRBstatus1">
                        ขอ
                    </label>
                </div>
                <div class="form-check ms-3">
                    <input class="form-check-input" type="radio" name="IRBstatus" id="IRBstatus2" value="ไม่ขอ">
                    <label class="form-check-label" for="IRBstatus2">
                        ไม่ขอ
                    </label>
                </div>
            </div>
        </div>

        <div id="dropdown-section" style="display: none; " class="mt-3">
            <label for="IRBtype">ประเภทจริยธรรม</label>
            <select class="form-select" name="IRBtype" id="IRBtype">
                <option id="IRBtype1" value="จริยธรรมการวิจัยในมนุษย์">จริยธรรมการวิจัยในมนุษย์</option>
                <option id="IRBtype2" value="จริยธรรมการวิจัยในสัตว์">จริยธรรมการวิจัยในสัตว์</option>
                <option id="IRBtype3" value="จริยธรรมการวิจัยในชีวภาพ">จริยธรรมการวิจัยในชีวภาพ</option>
            </select>
            <br>
            <label for="IRBdocument" class="mt-3">ไฟล์หลักฐาน</label>
            <input class="form-control" type="file" id="IRBdocument" name="IRBdocument" accept=".pdf">
        </div>


        <div class="input-group-btn gap-2 mt-5">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmationModal">📂
                บันทึก</button>

            <button type="reset" name="cancel" class="btn btn-danger">🗑️ ยกเลิก</button>
        </div>
    
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-lg" role="document" for="status">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-center" id="exampleModalLabel">ขอความยินยอมในการเผยแพร่ข้อมูลส่วนบุคคล
                    </h3>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>เพื่อเป็นการปฏิบัติให้เป็นไปตามข้อกำหนดของพระราชบัญญัติคุ้มครองข้อมูลส่วนบุคคล พ.ศ. 2562
                        ทางเว็บไซต์ได้มีการดำเนินการควบคุม
                        และจัดให้มีระบบงานที่เหมาะสมเพื่อให้มั่นใจได้ว่าข้อมูลส่วนบุคคลของท่านได้รับการรวบรวมจัดเก็บ
                        ประมวลผล และเผยแพร่ โดยเป็นไปตามข้อกำหนดและได้รับความปลอดภัย</p>

                    <div class="d-flex">
                        <div class="row">
                            <div class="form-check ms-3">
                                <input class="form-check-input" type="radio" name="PDPA" id="PDPA1"
                                    value="ยินยอม" >
                                <label class="form-check-label" for="PDPA1">
                                    <strong>
                                        ฉันยินยอมรับเงื่อนไข PDPA ให้เผยแพร่ข้อมูลส่วนบุคคล
                                    </strong>
                                </label>
                            </div>
                            <div class="form-check ms-3">
                                <input class="form-check-input" type="radio" name="PDPA" id="PDPA2"
                                    value="ไม่ยินยอม">
                                <label class="form-check-label" for="PDPA2">
                                    <strong>
                                        ฉันไม่ยินยอม
                                    </strong>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" name="dataform_db"
                        onclick="submitForm()">ยืนยัน</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>

    </form>





</body>

</html>

<script>
    function submitForm() {

        document.querySelector("form").submit();
  
        alert("บันทึกข้อมูลเรียบร้อยแล้ว");

        window.location.href = 'class.php';
    }


</script>

<script>
    document.getElementById("IRBstatus1").addEventListener("click", function () {
        document.getElementById("dropdown-section").style.display = "block";
    });

    document.getElementById("IRBstatus2").addEventListener("click", function () {
        document.getElementById("dropdown-section").style.display = "none";
    });

</script>
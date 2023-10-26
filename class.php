<?php
session_start();
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must login first";
    header('location: login.php');
}

include('server.php');

// Check the user's role (assuming you have a 'role' field in your user data)
if (isset($_SESSION['role'])) {
    $userRole = $_SESSION['role'];
} else {
    $userRole = 0; // Default role for users without a role
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon"
        href="https://static.vecteezy.com/system/resources/previews/009/665/134/original/seo-research-concept-with-a-magnifying-glass-researching-seo-from-a-website-inside-a-computer-vector-computer-website-showing-an-image-icon-and-a-magnifying-glass-searching-for-seo-keywords-concept-free-png.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <title>Home Page</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

<?php include('user_navbar.php'); ?>

<div class="homecontent">
    <h2 class="text-center">ระบบจัดเก็บชุดข้อมูล</h2>
    <!-- notification message-->
    <?php if (isset($_SESSION['success'])) { ?>
            <div class="success">
                <h3>
                    <?php
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                    ?>
                </h3>
            </div>
        <?php } ?>

    <div class="container">
            <!-- Check the user's role and display content accordingly -->
            <?php if ($userRole == 1) { // Admin Role ?>
                <a href="dataform.php"><button type="button" class="btn btn-primary">✍️ สร้างคลาส</button></a>
            <?php } elseif ($userRole == 2) { // User Role ?>
                <!-- Additional user-specific content can be added here -->
            <?php } ?>

            <a href="dataform.php" class="btn" >
        <button type="button" class="btn btn-dark">➕ New dataset</button>
        </a>
                
        <div class="row mt-2">
            
            <?php

           if ($userRole == 2) { // User Role
               $userId = $_SESSION['id']; // Assuming you have the user's ID in the session
               $sql = "SELECT imagedataset, id, dataname, class, description, status, implementdate FROM dataset WHERE class IS NOT NULL AND id_users = $userId;";
               $result = mysqli_query($conn, $sql);
               if (!$result) {
                   die("Query failed: " . mysqli_error($conn));
               }
            }

            while ($row = mysqli_fetch_assoc($result)) { ?>
                    <div class="col-md-3 mb-3">
                        <div class="card ">
                            <div class="divImgCover">
                                <img src="./uploads/datasetImage/<?= $row['imagedataset'] ?>" width="100%"
                                    class="card-img-top" alt="...">
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">
                                    <?= $row["dataname"]; ?>
                                </h5>
                                <p class="card-text">
                                    <?= $row["description"]; ?>
                                    <br> <strong>สถานะ :</strong>
                                    <?php
                                    if ($row["status"] == "ใช้งาน") {
                                        echo '🟢 ใช้งาน ';
                                    } elseif ($row["status"] == "ไม่ใช้งาน") {
                                        echo '🔴 ไม่ใช้งาน ';
                                    } else {
                                        echo $row["status"];
                                    }
                                    ?>
                                    <br> <strong>สร้างเมื่อ :</strong>
                                    <?= $row["implementdate"]; ?>
                                </p>

                                <div class="d-flex gap-2">
                                    <a href="user_viewdata.php?id=<?php echo $row["id"]; ?>" class="w-25"><button type="button"
                                            class="btn btn-secondary w-100"><i class="bi bi-search"></i></button></a>
                                    <a href="addpic.php?id=<?php echo $row["id"]; ?>" class="w-25"><button type="button"
                                            class="btn btn-primary w-100" class="w-25"><i
                                                class="bi bi-plus-square"></i></button></a>
                                    <a href="editform.php?id=<?php echo $row["id"]; ?>" class="w-25"><button type="button"
                                            class="btn btn-warning w-100"><i class="bi bi-pencil-square"></i></button></a>
                                    <a href="user_delete.php?id=<?php echo $row["id"]; ?>" class="w-25"><button type="button"
                                            class="btn btn-danger w-100" onclick="return confirm('ยืนยันการลบข้อมูล')"><i
                                                class="bi bi-trash3-fill"></i></button></a>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </div>
    </div>


</body>

</html>
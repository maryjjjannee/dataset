<?php
session_start();
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}

include('server.php');

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

    <?php include('admin_navbar.php'); ?>

    <div class="homecontent">
        <h2 class="text-center">ระบบจัดเก็บชุดข้อมูล</h2>

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
            <a href="admin_dataform.php"><button type="button" class="btn btn-primary">✍️ สร้างคลาส</button></a>

            <div class="row mt-2">
                <?php
                // Query to fetch all datasets
                $sql = "SELECT d.imagedataset, d.id, d.dataname, d.class, d.description, d.status, d.implementdate, u.username
            FROM dataset d
            INNER JOIN users u ON d.id_users = u.id_users
            WHERE d.class IS NOT NULL";


                $result = mysqli_query($conn, $sql);

                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                <div class="divImgCover">
                                    <img src="./uploads/datasetImage/<?= $row['imagedataset'] ?>" width="100%"
                                        class="card-img-top" alt="...">
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title">
                                        <?= $row["class"]; ?>.
                                        <?= $row["dataname"]; ?>
                                    </h5>
                                    <p class="card-text cardText">
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
                                        <br> <strong>username : </strong>
                                        <?= $row["username"]; ?>
                                    </p>

                                    <div class="d-flex gap-2">
                                        <a href="admin_viewdata.php?id=<?php echo $row["id"]; ?>" class="w-25"><button
                                                type="button" class="btn btn-secondary w-100"><i
                                                    class="bi bi-search"></i></button></a>
                                        <a href="admin_delete.php?id=<?php echo $row["id"]; ?>" class="w-25"><button type="button"
                                                class="btn btn-danger w-100" onclick="return confirm('ยืนยันการลบข้อมูล')"><i
                                                    class="bi bi-trash3-fill"></i></button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
                ?>
            </div>
        </div>
    </div>

</body>

</html>
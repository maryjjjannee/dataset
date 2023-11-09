<?php
session_start();
include('server.php'); // Make sure this file contains the database connection code
include('admin_navbar.php');

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
    exit; // Ensure that the script stops execution after the redirect
}

// Establish a UTF-8 connection with the database
mysqli_set_charset($conn, "utf8");

// Get the dataset ID from the URL
$id = isset($_GET["id"]) ? $_GET["id"] : 0; // Use a default value or handle this case as needed

// Query to retrieve dataset information
$sql = "SELECT d.id AS dataset_id, d.status, d.dataname, d.description, 
               COUNT(c.id_class) AS class_count, d.implementdate, d.imagetype, 
               d.IRBstatus, d.IRBtype, d.PDPA, d.statuspost, d.views
        FROM dataset AS d
        LEFT JOIN class AS c ON d.id = c.dataset_id
        WHERE d.id = $id
        GROUP BY d.id, d.dataname, d.description";

$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $dataname = $row["dataname"];
        $description = $row["description"];
        $class = $row["class_count"];
        $status = $row["status"];
        $statuspost = $row["statuspost"];
        $implementdate = $row["implementdate"];
        $imagetype = $row["imagetype"];
        $IRBstatus = $row["IRBstatus"];
        $IRBtype = $row["IRBtype"];
        $views = $row["views"];
        $PDPA = $row["PDPA"];

        // Retrieve the username from the users table based on the session
        if (isset($_SESSION['username'])) {
            $loggedInUsername = $_SESSION['username'];
            $userQuery = "SELECT username FROM users WHERE username = '$loggedInUsername'";
            $userResult = mysqli_query($conn, $userQuery);
            if ($userRow = mysqli_fetch_assoc($userResult)) {
                $username = $userRow['username'];
            }
        }

        // Fetch class-specific data grouped by category
        $classSql = "SELECT c.id_class, c.category, COUNT(i.id_image) AS imageCount, c.classdesc, c.username
                     FROM class AS c
                     INNER JOIN images AS i ON c.id_class = i.imageRef
                     WHERE c.dataset_id = $id
                     GROUP BY c.category";

        $classResult = mysqli_query($conn, $classSql);

        // Update the view count for the dataset
        $updateViewCountSql = "UPDATE dataset SET views = views + 1 WHERE id = $id";
        if (mysqli_query($conn, $updateViewCountSql)) {
            // View count updated successfully
        } else {
            echo "Error updating view count: " . mysqli_error($conn);
        }

        if (!$classResult) {
            echo "Error fetching class data: " . mysqli_error($conn);
        }
    } else {
        echo "No data found for the specified ID";
    }
} else {
    echo "Error fetching dataset information: " . mysqli_error($conn);
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon"
        href="https://static.vecteezy.com/system/resources/previews/009/665/134/original/seo-research-concept-with-a-magnifying-glass-researching-seo-from-a-website-inside-a-computer-vector-computer-website-showing-an-image-icon-and-a-magnifying-glass-searching-for-seo-keywords-concept-free-png.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <title>showdata</title>
</head>

<body>
    <div class="container">
        <form action="updatestatus.php" method="POST" enctype="multipart/form-data" id="statusForm">
            <h1 class="text-center mt-3">Dataset detail</h1>
            <input type="hidden" value="<?php echo $id; ?>" name="id">
            <table class="table table-striped">
                <div class="form-group col-6">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="width : 15%">ชื่อผู้ใช้ :</th>
                                <td>
                                    <?php echo $username; ?>
                                </td>
                            </tr>
                            <tr>
                                <th style="width : 15%">ชื่อ :</th>
                                <td>
                                    <?php echo $dataname; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>คำอธิบาย :</th>
                                <td>
                                    <?php echo $description; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>จำนวนคลาส :</th>
                                <td>
                                    <?php echo $class; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>สถานะ :</th>
                                <td>
                                    <?php echo $status; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>สถานะโพสต์ :</th>
                                <td>
                                    <?php echo $statuspost; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>วันที่ :</th>
                                <td>
                                    <?php echo $implementdate; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>ประเภทรูป :</th>
                                <td>
                                    <?php echo $imagetype; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>สถานะการขอจริยธรรม :</th>
                                <td>
                                    <?php echo $IRBstatus; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>ประเภทจริยธรรม :</th>
                                <td>
                                    <?php echo $IRBtype; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>ยินยอมเผยแพร่ข้อมูล :</th>
                                <td>
                                    <?php echo $PDPA; ?>
                                </td>
                            </tr>
                        </thead>

                        <table class="table">
                            <thead class="table-dark">
                                <tr>
                                    <th>คลาส</th>
                                    <th>หมวดหมู่</th>
                                    <th>คำอธิบาย</th>
                                    <th>จำนวนรูปภาพ</th>
                                    <th>ดูรายละเอียด</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1; // Initialize class number
                            while ($classRow = mysqli_fetch_assoc($classResult)) {
                                $category = $classRow["category"];
                                $id_class = $classRow["id_class"];
                                $classdesc = $classRow["classdesc"];
                                $imageCount = $classRow["imageCount"];
                                ?>

                                <tr>
                                    <td>
                                        <?php echo $i; ?>
                                    </td>
                                    <td>
                                        <?php echo $category; ?>
                                    </td>
                                    <td>
                                        <?php echo $classdesc; ?>
                                    </td>
                                    <td>
                                        <?php echo $imageCount; ?> ไฟล์
                                    </td>
                                    <td><a href="admin_viewdetail.php?id_class=<?php echo $id_class; ?>"
                                            class="btn btn-secondary">ดูรายละเอียด</a></td>
                                </tr>

                                <?php
                                $i++; // Increment class number
                            }
                            ?>
                        </tbody>
                        </table>

                        <a href="index.php" class="btn btn-primary">👈🏼 กลับ</a>


                        <input type="submit" name="statuspost" id="approveButton" value="อนุมัติ"
                            class="btn btn-success">
                        <input type="submit" name="statuspost" id="disapproveButton" value="ไม่อนุมัติ"
                            class="btn btn-danger">
                      

        </form>

    </div>
    </thead>

    </table>
    </div>
    </table>
    </form>
    </div>
</body>

</html>
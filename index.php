<?php
    session_start();
    if (!isset($_SESSION['username'])){
        $_SESSION['msg'] = "You must login first";
        header('location: login.php');
    }
    if (isset($_GET['logout'])){
        session_destroy();
        unset($_SESSION['username']);
        header('location: login.php');
    }
   

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="homeheader">
        <h2>ระบบจัดเก็บชุดข้อมูล</h2>

    </div>
    
    <?php  include('navbar.php');?>

    <div class="homecontent">

        <!-- notification message-->
        <?php if (isset($_SESSION['success'])): ?>
        <div class="success">
            <h3>
                <?php
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                        ?>
            </h3>
        </div>
        <?php endif ?>

        <!-- logged user information-->
        <?php if (isset($_SESSION['username'])): ?>
        <p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
        <p><a href="login.php?logout = '1'" style="color: red;">Logout</a></p>
        <?php endif ?>
    </div>


</body>

</html>
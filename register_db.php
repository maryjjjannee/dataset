<?php
session_start();
include('server.php');
$errors = array();
if (isset($_POST['reg_user'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password_1 = mysqli_real_escape_string($conn, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($conn, $_POST['password_2']);

    // ตรวจสอบว่าอีเมลเป็น 'jenzaza14@gmail.com' หรือไม่
    if ($email === 'jenzaza14@gmail.com') {
        $id_type = 1; // ถ้าเป็นอีเมล 'jenzaza14@gmail.com' กำหนดให้เป็นแอดมิน (0)
    } else {
        $id_type = 2; // ถ้าไม่ใช่ 'jenzaza14@gmail.com' กำหนดให้เป็นผู้ใช้ทั่วไป (1)
    }
    if ($email != 'jenzaza14@gmail.com') {
        $id_type = 2; // ถ้าเป็นอีเมล 'jenzaza14@gmail.com' กำหนดให้เป็นแอดมิน (0)
    } else {
        $id_type = 1; // ถ้าไม่ใช่ 'jenzaza14@gmail.com' กำหนดให้เป็นผู้ใช้ทั่วไป (1)
    }

    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }

    $user_check_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $query = mysqli_query($conn, $user_check_query);
    $result = mysqli_fetch_assoc($query);

    if ($result) { //if user exists
        if ($result['username'] === $username) {
            array_push($errors, "Username already exists");
        }

        if ($result['email'] === $email) {
            array_push($errors, "Email already exists");
        }
    }

    if (count($errors) == 0) {
        $password = md5($password_1);

        $sql = "INSERT INTO users (username, email, password, id_type) VALUES ('$username', '$email', '$password', '$id_type')";
        mysqli_query($conn, $sql);

        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        header('location: index.php');
    } else {
        array_push($errors, "Username or Email already exists");
        $_SESSION['error'] = "Username or Email already exists";
        header("location: register.php");
    }
}
?>
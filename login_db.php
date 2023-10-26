<?php
session_start();
include('server.php');

mysqli_set_charset($conn, "utf8");

$errors = array();

// Login user and set 'id_users' in the session
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
//   $id_users = mysqli_real_escape_string($conn, $_POST['id_users']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  if (empty($username)) {
    array_push($errors, "Username is required");
  }
  if (empty($password)) {
    array_push($errors, "Password is required");
  }
  if (count($errors) == 0) {
    $password = md5($password);
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
      $row = mysqli_fetch_assoc($result);
      // Set the `id` session variable to the value of the `id_users` column in the `users` table.
      $_SESSION['id'] = $row['id_users'];
      $_SESSION['role'] = $row['role'];
      // Set the `username` session variable to the value of the `username` column in the `users` table.
      $_SESSION['username'] = $username;
      // If you 
      $_SESSION['success'] = "You are now logged in";
      if ($_SESSION['role'] == 1 ){
        header("location: index.php");
      }else if ($_SESSION['role'] == 2 ){
        header("location: user.php");
      }else{
        array_push($errors, "You dont have any role here");
      }
    } else {
      array_push($errors, "Wrong username/password combination");
      $_SESSION['error'] = "Wrong username or password, try again";
      header("location: login.php");
    }
  }
}

?>

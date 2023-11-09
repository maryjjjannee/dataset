<?php
session_start();
include('server.php');

// ตั้งค่าชุดตัวอักษรเป็น UTF-8
mysqli_set_charset($conn, "utf8");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    $user_id = $_SESSION['id']; // รับค่า 'id' จากเซสชัน
    $username = $_SESSION['username']; // รับค่า 'username' จากเซสชัน


}

if (isset($_GET["id_image"])) {
    $image_id = $_GET["id_image"];
    $sql = "SELECT * FROM images WHERE id = $image_id"; // แก้เป็น $image_id
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $image_id = $row["id"];
            $image_name = $row["imageName"];
            $image_path = $row["imagePath"];
        } else {
            echo "Error fetching image information: " . mysqli_error($conn);
        }
    } else {
        echo "Error querying the database: " . mysqli_error($conn);
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Edit Images</title>
</head>

<body>
    <?php include('user_navbar.php'); ?>
    <div class="container">
        <h1 class="text-center mt-5">Edit Image</h1>
        <form action="updateimage.php" method="POST" enctype="multipart/form-data" id="imageForm">

            <input type="hidden" name="id_image" value="<?php echo $image_id; ?>">
            <div class="form-group col-6">
                <label for="images">Images</label>
                <input class="form-control" type="file" name="images[]" accept=".jpg, .jpeg, .png, .gif" multiple>
            </div>

            <div class="my-3">
                 <button type="button" class="btn btn-primary" onclick="history.back()">  👈🏼 กลับ </button>
                <input type="submit" name="submit" id="updateButton" value="📂 บันทึกข้อมูล" class="btn btn-success">
                <input type="reset" value="🗑️ Clear" class="btn btn-danger">
            </div>
        </form>
    </div>
</body>

</html>

<script>
  document.getElementById('imageForm').addEventListener('submit', submitFormData);

function removeClassRow(button) {
    const row = button.parentNode.parentNode;
    row.parentNode.removeChild(row);}

function submitFormData(event) {
    event.preventDefault(); // Prevent the default form submission

    const formData = new FormData(event.target);

    fetch('updateimage.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Data inserted successfully');
            window.location.reload();

            // Optionally, you can redirect or refresh the page here
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        alert('An error occurred: ' + error.message);
    });
}

</script>
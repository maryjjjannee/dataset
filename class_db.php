<?php
session_start();
include('server.php');

mysqli_set_charset($conn, "utf8");

if (isset($_POST['submit'])) {
    $dataset_id = $_POST['dataset_id'];
    $class = $_POST['class'];

    if ($conn) {
        for ($i = 1; $i <= $class; $i++) {
            $category = $_POST['category'][$i];
            $images = $_FILES['image']['name'][$i];
            $imageTempNames = $_FILES['image']['tmp_name'][$i];

            if (is_array($category) && is_array($images) && is_array($imageTempNames)) {
                foreach ($images as $key => $image) {
                    $imageTempName = $imageTempNames[$key];
                    $imagePath = 'uploads/' . $image;

                    if (move_uploaded_file($imageTempName, $imagePath)) {
                        $imageName = mysqli_real_escape_string($conn, $image);
                        // $imageOwner = $_SESSION['username'];  // Change this to the appropriate owner ID
                        $imageStatus = 1; // Change this to the appropriate status

                        // Insert the image data into the 'image' table
                        $sql = "INSERT INTO image (imageRef, imageName, imagePath, imageStatus) VALUES ('$dataset_id', '$imageName', '$imagePath',  '$imageStatus')";
                        $result = mysqli_query($conn, $sql);

                        if ($result) {
                            echo "Image file and category are saved successfully.<br>";
                        } else {
                            echo "Error in inserting data: " . mysqli_error($conn) . "<br>";
                        }
                    } else {
                        echo "Error uploading the image file.<br>";
                    }
                }
            } else {
                echo "Invalid array structure.<br>";
            }
        }
    } else {
        echo "Error connecting to the database.<br>";
    }
}
?>
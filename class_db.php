<?php
session_start();
include('server.php');

mysqli_set_charset($conn, "utf8");



if (isset($_POST['submit'])) {
    $dataset_id = $_POST['dataset_id'];
    $user = $_SESSION['username'];
    $class = $_POST['class'];
    $classdesc = $_POST['classdesc'];

    if ($conn) {
        for ($i = 1; $i <= $class; $i++) {
            $category = $_POST['category'][$i]; 
            $classdesc = $_POST['classdesc'][$i]; 
            // Correctly access the category for the current class

            // Insert the class/category
            $sql = "INSERT INTO class (category, dataset_id, username, classdesc) VALUES ('$category', '$dataset_id', '$user', '$classdesc')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                $id_class = mysqli_insert_id($conn);
                $images = $_FILES['image']['name'][$i];
                $imageTempNames = $_FILES['image']['tmp_name'][$i];

                if (is_array($images) && is_array($imageTempNames)) {
                    for ($j = 0; $j < count($images); $j++) {
                        $image = $images[$j];
                        $imageTempName = $imageTempNames[$j];
                        $imagePath = 'uploads/' . $image;

                        // Insert the image information
                        $sql = "INSERT INTO images (imageRef, imageName, imagePath, imageOwner) VALUES ('$id_class', '$image', '$imagePath', '$user')";
                        $result = mysqli_query($conn, $sql);

                        if (!$result) {
                            echo "Error in saving image data: " . mysqli_error($conn) . "<br>";
                        } elseif (move_uploaded_file($imageTempName, $imagePath)) {
                            // Image successfully uploaded and associated with the category
                        } else {
                            echo "Error uploading image file.<br>";
                        }
                    }
                } else {
                    echo "Invalid array structure for images.<br>";
                }
            } else {
                echo "Error in saving category data: " . mysqli_error($conn) . "<br>";
            }
        }

        // Redirect after processing all classes
        echo "<script>
            alert('Image and category data have been successfully saved.');
            window.location.href = 'class.php'; 
        </script>";
    } else {
        echo "Error connecting to the database.<br>";
    }
}
?>

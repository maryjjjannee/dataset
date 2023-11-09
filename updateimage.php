<?php
session_start();
include('server.php');
mysqli_set_charset($conn, "utf8");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $return = [];

    if (!empty($_FILES['images']['name'][0]) && isset($_POST['id_image'])) {
        $success = true;

        $image_ids = $_POST['id_image']; // Use an array for multiple images

        foreach ($_FILES['images']['name'] as $key => $image) {
            $imageTempName = $_FILES['images']['tmp_name'][$key];
            $imageName = basename($image);

            $uniqueName = time() . '_' . $imageName;
            $targetPath = 'uploads/' . $uniqueName;

            // Update the image data in the database
            $image_id = $image_ids[$key];
            $sql = "SELECT * FROM images WHERE id = $image_id";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                $row = mysqli_fetch_assoc($result);

                if ($row) {
                    $oldImageName = $row["imageName"];
                    $oldImagePath = $row["imagePath"];

                    // Delete the old image file
                    if (!empty($oldImageName) && file_exists($oldImageName)) {
                        unlink($oldImageName);
                    }

                    // Update the image data
                    $sql = "UPDATE images SET imageName = '$uniqueName', imagePath = '$targetPath' WHERE id = $image_id";

                    if (mysqli_query($conn, $sql)) {
                        if (move_uploaded_file($imageTempName, $targetPath)) {
                            // File uploaded successfully
                        } else {
                            $success = false;
                            echo "Error: Failed to move uploaded file for image ID $image_id<br>";
                        }
                    } else {
                        $success = false;
                        echo "Error: Failed to update image data for image ID $image_id: " . mysqli_error($conn) . "<br>";
                    }
                } else {
                    echo "Error: Image not found for ID $image_id<br>";
                }
            } else {
                echo "Error: Failed to fetch image data for ID $image_id: " . mysqli_error($conn) . "<br>";
                $success = false;
            }
        }

        if ($success) {
            $return['success'] = true;
            $return['message'] = "Data updated successfully";
        } else {
            $return['success'] = false;
            $return['message'] = "Error updating data";
        }
    }
}

echo json_encode($return);
?>

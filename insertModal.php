<?php
session_start();
include('server.php'); // Include your database connection code


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dataset_id = $_POST['dataset_id'];
    $user = $_SESSION['username'];
    $category = mysqli_real_escape_string($conn, $_POST['category']); // Ensure to sanitize user input

    if ($conn) {
        // Insert the category
        $insertCategorySql = "INSERT INTO class (category, dataset_id, username) VALUES ('$category', '$dataset_id', '$user')";
        $result = mysqli_query($conn, $insertCategorySql);

        if ($result) {
            $id_class = mysqli_insert_id($conn); // Get the auto-generated ID of the inserted category

            // Handle uploaded images
            if (!empty($_FILES['images']['name'][0])) {
                $imagePath = 'uploads/'; // Define the folder where images will be saved

                foreach ($_FILES['images']['name'] as $key => $image) {
                    $imageTempName = $_FILES['images']['tmp_name'][$key];
                    $imageName = basename($image);

                    // Generate a unique name for the image (e.g., using a timestamp)
                    $uniqueName = time() . '_' . $imageName;
                    $targetPath = $imagePath . $uniqueName;

                    // Insert the image information into the database
                    $insertImageSql = "INSERT INTO images (imageRef, imageName, imagePath, imageOwner) VALUES ('$id_class', '$uniqueName', '$targetPath', '$user')";
                    $result = mysqli_query($conn, $insertImageSql);

                    if ($result) {
                        move_uploaded_file($imageTempName, $targetPath); // Move the uploaded image to the server
                    } else {
                        echo "Error in saving image data: " . mysqli_error($conn);
                    }
                }
            }
            // Respond with success
            $response = array('success' => true, 'message' => 'Data inserted successfully.');
            echo json_encode($response);
        } else {
            $response = array('success' => false, 'message' => 'Failed to insert category data.');
            echo json_encode($response);
        }
    } else {
        echo "Error connecting to the database.";
    }
} else {
    echo "Invalid request method.";
}
?>

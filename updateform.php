<?php
session_start();
include('server.php'); 
// Include your database connection code
mysqli_set_charset($conn, "utf8");



// Check if the form was submitted
if (isset($_POST['submit'])) {
    $categories = $_POST['category'];
    $datasetId = $_POST['dataset_id'];

    // Loop through the submitted categories and update the data
    for ($i = 0; $i < count($categories); $i++) {
        $category = mysqli_real_escape_string($conn, $categories[$i]);
        $categoryId = $i + 1; // Adjust this based on your data

        $sql = "UPDATE class SET category = '$category' WHERE id_class = $categoryId AND dataset_id = $datasetId";

        if (mysqli_query($conn, $sql)) {
            // Update successful
        } else {
            echo "Error updating data: " . mysqli_error($conn);
        }
    }

    // Redirect to the class.php page after updating
    header("Location: class.php");
    exit(); // Make sure to exit to prevent further script execution
}

// Close the database connection if not already done
mysqli_close($conn);
?>

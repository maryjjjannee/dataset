<?php
  session_start();
  include('server.php');
  
  mysqli_set_charset($conn, "utf8");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About us</title>
    <link rel="stylesheet" href="styles.css"> 
    <link rel="icon"
        href="https://static.vecteezy.com/system/resources/previews/009/665/134/original/seo-research-concept-with-a-magnifying-glass-researching-seo-from-a-website-inside-a-computer-vector-computer-website-showing-an-image-icon-and-a-magnifying-glass-searching-for-seo-keywords-concept-free-png.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <?php  include('admin_navbar.php');?>
    <div class="container">
    <h1 class="text-center">About Us</h1>
    <p>Welcome to the Dataset Team! We are a dedicated group of individuals passionate about collecting, organizing, and sharing valuable datasets with the world.</p>

    <h2>Our Mission</h2>
    <p>Our mission is to provide high-quality datasets to researchers, data scientists, and anyone interested in working with data. We aim to facilitate data-driven innovation by curating and maintaining a diverse collection of datasets.</p>

    <h2>Our Team</h2>
    <p>We are a diverse team with expertise in various fields, including data analysis, machine learning, and data engineering. Our team members are committed to ensuring that the datasets we offer are accurate, up-to-date, and relevant.</p>

    <h2>Contact Us</h2>
    <p>If you have any questions, suggestions, or would like to collaborate with us, please feel free to reach out. You can contact us at <a href="mailto:contact@datasetteam.com">contact@datasetteam.com</a>.</p>
</div>

</body>

</html>


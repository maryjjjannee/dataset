<nav class="navbar navbar-expand-lg  bg-dark" style="color:white;">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03"
                aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo03" style="color:white;">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php" style="color:white;">Home</a>
                    </li>
                        <a class="nav-link" href="datasets.php" style="color:white;" >Datasets</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="aboutus.php" style="color:white;">About us</a>
                    </li>
                </ul>
                <searchform class="d-flex" role="search">
                    <b class="me-2 mt-1"><?php echo $_SESSION['username']; ?></b>
                    <img src="https://www.pngkit.com/png/full/115-1150342_user-avatar-icon-iconos-de-mujeres-a-color.png" width="35px" height="35" style="border-radius:50%">
                </searchform>
            </div>
        </div>
    </nav>
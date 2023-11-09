<nav class="navbar navbar-expand-lg  bg-dark" style="color:white;">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03"
            aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo03" style="color:white;">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
               
                <a class="nav-link" href="index.php" style="color:white;">Home</a></li>
                <li class="nav-item">
                    <a class="nav-link" href="admin_users.php" style="color:white;">Users</a>
                </li>
                <a class="nav-link" href="report.php" style="color:white;">Report</a>
                <a class="nav-link" href="admin_about.php" style="color:white;">About us</a>
            </ul>
            <searchform class="d-flex" role="search">
                <b class="me-2 mt-1"><?php echo $_SESSION['username']; ?></b>
                <img src="https://cdn1.iconfinder.com/data/icons/shopping-e-commerce-10/33/support_3-512.png"
                    width="35px" height="35" style="border-radius:50%">
            </searchform>
            <?php if (isset($_SESSION['username'])){ ?>
            <a href="login.php?logout = '1'" style="color: red;"><button class="btn btn-danger ms-2">Logout</button></a>
            <?php } ?>
        </div>
    </div>
</nav>
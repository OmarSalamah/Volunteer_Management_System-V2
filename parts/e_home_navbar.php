<?php
    if (isset($_POST['submit_account'])) {
        header("Location: e_account.php");
        exit();
    }
    if (isset($_POST['submit_logout'])) {
        log_out();
        header('location: ./login_e.php');
        exit();
    }
    if(isset($_POST['search'])){
        $volunteering=$employee->search_volunteering($_POST['search'],$conn);
    }
  
?>
<!-- start navbar -->
<nav class="navbar navbar-expand-lg bg-body-secondary mb-3">
        <div class="container-fluid">
            <a class="navbar-brand" href="./../Landing_page.php">VOLUNTEERING</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <!-- اختيار الهوم المفعل شوف صفحته ايش المفعل والغي التفعيل حق هذي وفعل الثانية -->
                        <a class="nav-link active" aria-current="page" href="e_homepage.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="create_volunteering_opportunity.php">Create volunteer opportunity</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="ranking_e.php">Ranking</a>
                    </li>
                </ul>
                <!-- لو صفحتك مافيها بحث احذف قسم البحث -->
                <form class="d-flex" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" role="search">
                    <input class="form-control " type="search" name="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success me-4 ms-1" type="submit">Search</button>
                </form>
                <!-- الانتقال لصفحة الحساب -->
                <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                    <button class="btn btn-primary my-1" name="submit_account" type="submit">
                        <!-- اسم المستخدم لو لسة ماسويته اكتب اي شيء بس لازم صفحتك تستدعيه من قاعدة البيانات -->
                        <?php echo htmlspecialchars($employee->name); ?>
                    </button>
                </form>
                <!-- <div class="vr mx-3"></div> -->
                <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                    <button class="btn btn-outline-secondary " type="submit" name="submit_logout">log out</button>
                </form>

            </div>
        </div>
    </nav>
    <!-- end navbar -->
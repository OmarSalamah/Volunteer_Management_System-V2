<?php
if (isset($_POST['submit_logout'])) {
    log_out();
    header('location: login_v.php');
    exit();
}
if (isset($_POST['submit_account'])) {
    $_SESSION['email'] = $user->email;
    header("Location: v_account.php");
    exit();
}


?>
<!-- start navbar -->
<nav class="navbar navbar-expand-lg bg-body-secondary mb-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="./../Landing_page.php">VOLUNTEERING</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <!-- اختيار الهوم المفعل شوف صفحته ايش المفعل والغي التفعيل حق هذي وفعل الثانية -->
                    <a class="nav-link" aria-current="page" href="v_homepage.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="ranking_v.php">Ranking</a>
                </li>
            </ul>
            <!-- لو صفحتك مافيها بحث احذف قسم البحث -->
            <!-- الانتقال لصفحة الحساب -->
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                <button class="btn btn-primary my-1" name="submit_account" type="submit">
                    <!-- اسم المستخدم لو لسة ماسويته اكتب اي شيء بس لازم صفحتك تستدعيه من قاعدة البيانات -->
                    <?php echo htmlspecialchars($user->name); ?>
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
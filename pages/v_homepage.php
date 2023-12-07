<?php
include "./../inc/config_db.php";
include "./../parts/functons.php";

include "./../parts/class_user.php";
session_start();

// if (!(isset($_SESSION['loggedin']))) {
//     header('location:./login_v.php');
// }

redirectToLoginIfNotLoggedIn();


// استقبال الاوبجكت 
$user = unserialize($_SESSION['user']);



// بتاكد هل تحملت كل بيانات المسخدم
// echo print_r($user);
// echo $user->academic_id;

// بتأكد هل التوصيل صح مع قاعدة البيانات
// echo $_SESSION["email"] . " welcom";



$volunteering = $user->getAllVolunteerings($conn);

// طباعة عشان اتاكد غير آمنة
// echo "<pre>";
// print_r($volunteering);
// echo "</pre>"; 


// Handle the fucking submit
// بقالي اربع ساعات فيكي يابنت الكلب عشان اعمل لامك هاندل
handleVolunteeringRegistration($volunteering, $user, $conn);

if (isset($_POST['submit_logout'])) {
    log_out();
    header("Location: ./login_v.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Home Page</title>
</head>

<body class="bg-light">
    <!-- start navbar -->
    <?php include './../parts/v_home_navbar.php'; ?>
    <!-- end navbar -->

    <!-- start container -->
    <div class="container"> <!-- d-flex justify-content-between -->
        <h1 class="mb-3">volunteering opportunity</h1>
        <?php include "./../parts/Volunteering_cards.php"; ?>
    </div>

    <!-- End container -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>
<?php include './../inc/close_db.php'; ?>
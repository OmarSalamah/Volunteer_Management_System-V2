<?php
include "./../parts/class_user.php";
include "./../inc/config_db.php";
include "./../parts/functons.php";
session_start();
// if (!(isset($_SESSION['employee']))) {
//     header('location: ./login_v.php');
// }
if (!(isset($_SESSION["email"]))) {
    header('location: ./login_v.php');
    exit();
}


// include "./parts/class_user.php";
// $user = new user($_SESSION["email"], $conn);

// echo $_SESSION['email'];
// print_r($_SESSION["user"]);
$user = unserialize($_SESSION["user"]);
// print_r($user);
if($user->available>0){
    $available="available";
}else{
    $available="Not available";
}

$active_volunteer = $user->count_active_volunteer_opportunities($conn);



$volunteering = $user->get_all_registered_volunteer_opportunities($conn);

handleVolunteeringDeleting($volunteering, $user, $conn);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <!-- Bootstrap CSS -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="./css/style_account_v.css"> -->
</head>

<body class="text-dark bg-light">
    <?php include "./../parts/v_account_navbar.php" ?>
    <section class="section" id="about">
        <div class="container">
            <h1 class="dark-color">Account</h1>
            <div class="row align-items-center flex-row-reverse ">
                <div class="col-lg-6">
                    <div class="about-text go-to">
                        <h4 class="theme-color"><?php echo htmlspecialchars($user->name) ?></h4>
                        <div class="row about-list">
                            <div class="col-md-6">
                                <div class="media">
                                    <label>Academic ID</label>
                                    <p><?php echo htmlspecialchars($user->academic_id); ?></p>
                                </div>
                                <div class="media">
                                    <label>Skiils</label>
                                    <p><?php echo htmlspecialchars($user->skills); ?></p>
                                </div>
                                <div class="media">
                                    <label>Address</label>
                                    <p><?php echo htmlspecialchars($user->address); ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="media">
                                    <label>E-mail</label>
                                    <p><?php echo htmlspecialchars($user->email); ?></p>
                                </div>
                                <div class="media">
                                    <label>Phone</label>
                                    <p><?php echo "0".htmlspecialchars($user->phone); ?></p>
                                </div>
                                <div class="media">
                                    <label>Availability</label>
                                    <p><?php echo $available; ?></p>
                                </div>
                                <div class="media">
                                    <label>Rate</label>
                                    <p><?php echo htmlspecialchars($user->rate); ?></p>
                                </div>
                                <button type="button" class="btn btn-outline-primary m-2 px-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    Edit profile</button>
                                <?php include "./../parts/v_edit_profile.php" ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-avatar">
                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" title="" alt="">
                    </div>
                </div>
            </div>
            <div class="counter bg-white shadow p-3">
                <div class="row">
                    <div class="col-6 col-lg-4">
                        <div class="count-data text-center">
                            <h6 class="count h2" ><?php echo htmlspecialchars($user->volunteering_hours); ?></h6>
                            <p class="m-0px font-w-600">Volunteer Hours</p>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4">
                        <div class="count-data text-center">
                            <h6 class="count h2" ><?php echo htmlspecialchars($user->number_v); ?></h6>
                            <p class="m-0px font-w-600">Volunteering opportunities</p>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4">
                        <div class="count-data text-center">
                            <h6 class="count h2" ><?php echo $active_volunteer; ?></h6>
                            <p class="m-0px font-w-600">Active Volunteering opportunities</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <h2 class="dark-color mb-3">Active Volunteering opportunities</h2>
                <?php include "./../parts/Volunteering_a_cards.php"; ?>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>
<?php include './../inc/close_db.php'; ?>
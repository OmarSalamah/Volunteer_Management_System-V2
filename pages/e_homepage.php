<?php
include "./../inc/config_db.php";
include "./../parts/class_employee.php";
session_start();
include "./../parts/functons.php";
if (!(isset($_SESSION['employee']))) {
    header('location: ./login_e.php');
}
$employee = unserialize($_SESSION['employee']);



$volunteering = $employee->getAllVolunteerings($conn);

function handleVolunteeringCompleted($employee, $volunteering, $conn)
{
    foreach ($volunteering as $vo) {
        $volunteering_id = $vo["id"];

        if (isset($_POST['completed_' . $volunteering_id])) {
            // echo "submit_".$volunteering_id;]
            // echo 'completed_' . $volunteering_id;
            // Add volunteer hours for every volunteer
            $employee->RateIfNotRated($volunteering_id, $conn);
            $employee->updateVolunteerHours($volunteering_id, $conn);
            $employee->completed_volunteering($volunteering_id, $conn);
        }
    }
}
// Handle the Volunteering complete
handleVolunteeringCompleted($employee, $volunteering, $conn);

// Handle the volunteering view and rate
function handleVolunteeringView($employee, $volunteering, $conn)
{
    foreach ($volunteering as $vo) {
        $volunteering_id = $vo["id"];
        if (isset($_POST['view_' . $volunteering_id])) {
            $_SESSION['volunteering_id'] = $volunteering_id;
            header("Location: ./view_rate.php");
            exit();
        }
    }
}

handleVolunteeringView($employee, $volunteering, $conn);

function handleVolunteeringDelete($employee, $volunteering, $conn)
{
    foreach ($volunteering as $vo) {
        $volunteering_id = $vo["id"];

        if (isset($_POST['delete_' . $volunteering_id])) {
            // echo "delete".$volunteering_id;
            $employee->delete_volunteering($volunteering_id, $conn);
        }
    }
}
handleVolunteeringDelete($employee, $volunteering, $conn);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body class="bg-light">
    <?php include "./../parts/e_home_navbar.php" ?>
    <div class="container">
        <h1 class="mb-3">Active volunteering opportunity</h1>
        <?php include "./../parts/Volunteering_e_cards.php"; ?>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>
<?php include "./../inc/close_db.php"; ?>
<?php
include "./../inc/config_db.php";
include "./../parts/class_employee.php";
session_start();
include "./../parts/functons.php";
if (!(isset($_SESSION['employee']))) {
    header('location: ./login_e.php');
}
$employee = unserialize($_SESSION['employee']);
// echo $employee->email;

if (isset($_POST['submit'])){
    $title = $_POST['title'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $start_date= $_POST['start_date'];
    $end_date= $_POST['end_date'];
    $hours = $_POST['hours'];
    $required_skills = $_POST['required_skills'];
    $max_size = $_POST['max_size'];
    $employee->Create_volunteer_opportunity($title,$description,$location,$start_date,$end_date,$hours,$required_skills,$max_size,$conn);
    echo '<script type=text/javascript> alert("You have successfully Created a Volunteering opportunity!");window.location.href=window.location.href;</script>';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create volunteer opportunity</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body class="bg-light">
    <?php include "./../parts/create_volunteering_navbar.php" ?>
    <div class="container mt-5 col-md-8 mb-4">
        <h1>Volunteering opportunity form</h1>
        <form class="" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
            <!-- Title -->
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>

            <!-- Location -->
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control" id="location" name="location" required>
            </div>

            <!-- Start Date -->
            <div class="mb-3">
                <label for="start-date" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="start-date" name="start_date" required>
            </div>

            <!-- End Date -->
            <div class="mb-3">
                <label for="end-date" class="form-label">End Date</label>
                <input type="date" class="form-control" id="end-date" name="end_date" required>
            </div>

            <!-- Hours -->
            <div class="mb-3">
                <label for="hours" class="form-label">Hours</label>
                <input type="number" class="form-control" id="hours" name="hours" required>
            </div>

            <!-- Required Skills -->
            <div class="mb-3">
                <label for="required-skills" class="form-label">Required Skills</label>
                <input type="text" class="form-control" id="required-skills" name="required_skills" required>
            </div>

            <!-- Max Size -->
            <div class="mb-3">
                <label for="max-size" class="form-label">Max Size</label>
                <input type="number" class="form-control" id="max-size" name="max_size" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>

<?php include "./../inc/close_db.php"; ?>
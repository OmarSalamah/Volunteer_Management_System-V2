<?php
    include "./../inc/config_db.php";
    include "./../parts/class_employee.php";
    session_start();
    include "./../parts/functons.php";
    if (!(isset($_SESSION['employee']))) {
        header('location: ./login_e.php');
    }
    $employee = unserialize($_SESSION['employee']);
    
    $volunteers = $employee->getRanking($conn);

    
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body class="bg-light">
    <?php include "./../parts/ranking_e_navbar.php"; ?>
    <div class="container">
        <?php include "./../parts/ranking.php"; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
<?php include "./../inc/close_db.php"; ?>
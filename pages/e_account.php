<?php
include "./../parts/class_employee.php";
include "./../inc/config_db.php";
include "./../parts/functons.php";

session_start();
 

if (!(isset($_SESSION['employee']))) {
    header('location: ./login_e.php');
}

 
$employee = unserialize($_SESSION['employee']);
 
 
// Another method
$active_volunteer = $employee->count_active_volunteer_opportunities($conn);
$compeleted = $employee -> comopleted_volunteering($conn);
 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
   
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
</head>

<body class="text-dark bg-light">
    <?php include "./../parts/e_account_navbar.php" ?>
    <section class="section" id="about">
        <div class="container">
            <h1 class="dark-color">Account</h1>
            <div class="row align-items-center flex-row-reverse ">
                <div class="col-lg-6">
                    <div class="about-text go-to">
                        <h4 class="theme-color"><?php echo htmlspecialchars($employee->name) ?></h4>
                        <div class="row about-list">
                            <div class="col-md-6">
                                <div class="media">
                                    <label>Username : </label>
                                    <p><?php echo htmlspecialchars($employee->username); ?></p>
                                </div>
                               
                                <div class="media">
                                    <label>Phone</label>
                                    <p><?php echo "0".htmlspecialchars($employee->phone); ?></p>
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="media">
                                    <label>E-mail :</label>
                                    <p><?php echo htmlspecialchars($employee->email); ?></p>
                                </div>
                                
                                
                                <div class="media">
                                    <label>Rate</label>
                                    <p><?php echo htmlspecialchars($employee->rate); ?></p>
                                </div>
                              
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
                     
                    <div class="col-6 col-lg-6">
                        <div class="count-data text-center">
                            <h6 class="count h2" ><?php echo $compeleted; ?></h6>
                            <p class="m-0px font-w-600">Compeleted opportunities</p>
                        </div>
                    </div>
                    <div class="col-6 col-lg-6">
                        <div class="count-data text-center">
                            <h6 class="count h2" ><?php echo $active_volunteer; ?></h6>
                            <p class="m-0px font-w-600">Active Volunteering opportunities</p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>
<?php include './../inc/close_db.php'; ?>
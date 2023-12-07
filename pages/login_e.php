<?php

session_start();
// Config
// اتصل بالداتا بيس
include "./../inc/config_db.php";
include "./../parts/class_employee.php";

if (isset($_POST['submit'])) {

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   // has
   $pass = MD5($_POST['password']);

   $select = " SELECT * FROM employee WHERE email = '$email' && password = '$pass' ";

   $result = mysqli_query($conn, $select);

   if (mysqli_num_rows($result) > 0) {
      $_SESSION['employee'] = true;
      $_SESSION['email'] = $email;
      $employee = new Employee($_SESSION['email'], $conn);
      $_SESSION['employee'] = serialize($employee);
      header('location: ./e_homepage.php');
      exit;


   } else {
      $error[] = 'incorrect email or password!';
   }

}
;
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login | Employee</title>

   <!-- custom css file link  -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
   <!-- <link rel="stylesheet" href="../css/style.css"> -->

</head>

<body class="bg-dark-subtle bg-opacity-50">

   <div class="container align-items-center">
      <div class="row justify-content-center">
         <div class="col-md-6">
            <div class="card mt-5 p-2 shadow bg-body-tertiary rounded">

               <!-- Centered Image -->
               <a href="./../Landing_page.php">
                  <img src="../img/logo.png" class="card-img-top mx-auto d-block" style="width: 100px;" alt="logo">
               </a>
               <div class="card-body">
                  <form action="" method="post" class="p-4">

                     <h3 class="text-center">Employee login</h3>
                     <?php
                     if (isset($error)) {
                        foreach ($error as $error) {
                           echo '<div class="alert alert-danger">' . $error . '</div>';
                        }
                        ;
                     }
                     ;
                     ?>
                     <div class="form-group mb-2">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required
                           placeholder="Enter your email">
                     </div>
                     <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required
                           placeholder="Enter your password">
                     </div>
                     <div class="form-group d-grid gap-2 col-12 mx-auto mt-3 my-4">
                        <input type="submit" name="submit" value="Login Now" class="btn btn-primary">
                     </div>
                     <p class="text-center">Don't have an account? <a href="#">Register now</a></p>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>




   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"></script>
</body>

</html>
<?php include "./../inc/close_db.php"; ?>
<?php
function redirectToLoginIfNotLoggedIn()
{
    if (!(isset($_SESSION['loggedin']))) {
        header('location: ./login_v.php');
    }
}
function getAllVolunteeringOpportunities($conn)
{
    // استيراد القيم بتاعة العمليات التطوعية
    $sql = "SELECT * FROM Volunteering WHERE availability>0";
    // تخزين القيم 
    $result = mysqli_query($conn, $sql);
    // استجلاب للقيم
    // ويخزنها على شكل مصفوفة
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
// function register_to_volunteering($userID, $volunteering_id, $conn)
// {
//     // لو مسجل قبل كده 
//     $sql2 = "SELECT *  FROM Volunteering_details WHERE volunteer_id =$userID AND volunteering_id=$volunteering_id";
//     $result1 = mysqli_query($conn, $sql2);
//     $aresult1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);
//     // print_r($aresult1);

//     if (!empty($aresult1)) {
//         echo '<script type=text/javascript> alert("You have been registered for this Volunteering opportunity before!");window.location.href=window.location.href;</script>';
//     } else {
//         $sql3 = "INSERT INTO Volunteering_details(id, volunteer_id, volunteering_id)
//         VALUES (NULL, '$userID', '$volunteering_id');";
//         if (mysqli_query($conn, $sql3)) {
//             echo '<script type=text/javascript> alert("You have successfully registered for this Volunteering opportunity!");window.location.href=window.location.href;</script>';
//         } else {
//             echo "Error" . mysqli_connect_error();
//         }
//     }
// }
function handleVolunteeringRegistration($volunteering, $user, $conn){
    foreach ($volunteering as $vo) {
        $volunteering_id = $vo["id"];
        // لو اتنيل بروح امه المستخدم وضغط على ام  التسجيل
        if (isset($_POST['submit_' . $volunteering_id])) {
            // echo "submit_".$volunteering_id;]
            // echo 'submit_' . $volunteering_id;
            $user->register_to_volunteering($volunteering_id, $conn);
        }
    }
}
function log_out()
{
    session_start();
    session_unset();
    session_destroy();
    // header('location: ./login_v.php');
    // exit();
}
function isValidName($name) {
    // Check if name only contains letters and whitespace
    return preg_match("/^[a-zA-Z-' ]*$/", $name);
}

function isValidEmail($email) {
    // Check if email is valid
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function isValidPhone($phone) {
    // Check if phone number is valid (simple format validation)
    return preg_match("/^[0-9]{10}$/", $phone);
}

function count_active_volunteer_operations($id,$conn){
    $sql = "SELECT COUNT(Volunteering.id) AS available_volunteering_count 
    FROM Volunteering 
    INNER JOIN Volunteering_details 
    ON Volunteering.id = Volunteering_details.volunteering_id 
    WHERE Volunteering_details.volunteer_id = $id
    AND volunteering.availability > 0";
    $result = mysqli_query($conn, $sql);
    $count=mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $count[0]["available_volunteering_count"];
}
function handleVolunteeringDeleting($volunteering, $user, $conn) {
    foreach ($volunteering as $vo) {
        $volunteering_id = $vo["id"];
        if (isset($_POST['submit_' . $volunteering_id])) {
            // echo "submit_".$volunteering_id;]
            // echo 'submit_' . $volunteering_id;
            $user->delete_volunteering($volunteering_id, $conn);
        }
    }
}
function delete_volunteering($userID, $volunteering_id, $conn){
    $sql = "DELETE FROM Volunteering_details 
    WHERE volunteer_id = $userID 
    AND volunteering_id=$volunteering_id";
    mysqli_query($conn, $sql);
    echo '<script type=text/javascript> alert("You have been successfully Unregistered for this Volunteering opportunity ");window.location.href=window.location.href;</script>';
}
function ordinal($number) {
    $ends = ['th','st','nd','rd','th','th','th','th','th','th'];
    if ((($number % 100) >= 11) && (($number % 100) <= 13))
        return $number. 'th';
    else
        return $number. $ends[$number % 10];
}
?>
<?php
class User
{
    public $id;
    public $name;
    public $email;
    public $phone;
    public $volunteering_hours;
    public $academic_id;
    public $address;
    public $skills;
    public $number_v;
    public $available;
    public $rate;

    protected $db;

    public function __construct($userEmail, $mysqli)
    {
        $this->db = $mysqli;
        $this->loadUserData($userEmail);
    }
    // تحميل بيانات المستخدم كاملة
    private function loadUserData($userEmail)
    {
        // Escape the user ID to prevent SQL injection
        $userEmail = $this->db->real_escape_string($userEmail);

        // Prepare the SQL statement
        $sql = "SELECT * FROM volunteer WHERE email = '$userEmail'";

        // Execute the SQL statement
        $result = $this->db->query($sql);

        if ($result) {
            // Fetch the user data from the database
            $userData = $result->fetch_assoc();

            if ($userData) {
                // Assign the data to the object properties
                $this->id = $userData['id'];
                $this->name = $userData['name'];
                $this->email = $userData['email'];
                $this->phone = $userData['phone'];
                $this->volunteering_hours = $userData['volunteering_hours'];
                $this->academic_id = $userData['academic_id'];
                $this->address = $userData['address'];
                $this->skills = $userData['skills'];
                $this->number_v = $userData['number_v'];
                $this->rate = $userData['rate'];
                $this->available = $userData['availability'];
                // $this->db = $userData[''];

            }

            // Free the result set
            $result->close();
        }
    }
    public function getRanking($conn)
    {
        $sql = "SELECT name, volunteering_hours, skills, number_v, rate
                FROM volunteer
                WHERE volunteering_hours>0
                ORDER BY `volunteer`.`volunteering_hours`
                DESC LIMIT 10";
        $result = mysqli_query($conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    public function getAllVolunteerings($conn)
    {
        // استيراد القيم بتاعة العمليات التطوعية
        $sql = "SELECT * FROM volunteering WHERE availability>0";
        // تخزين القيم 
        $result = mysqli_query($conn, $sql);
        // استجلاب للقيم
        // ويخزنها على شكل مصفوفة
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    public function register_to_volunteering($volunteering_id, $conn)
    {
        $userID = $this->id;
        // لو مسجل قبل كده 
        $sql2 = "SELECT *  FROM Volunteering_details WHERE volunteer_id =$userID AND volunteering_id=$volunteering_id";
        $result1 = mysqli_query($conn, $sql2);
        $aresult1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);
        // print_r($aresult1);

        if (!empty($aresult1)) {
            echo '<script type=text/javascript> alert("You have been registered for this Volunteering opportunity before!");window.location.href=window.location.href;</script>';
        } else {
            $sql3 = "INSERT INTO Volunteering_details(id, volunteer_id, volunteering_id)
            VALUES (NULL, '$userID', '$volunteering_id');";
            if (mysqli_query($conn, $sql3)) {
                echo '<script type=text/javascript> alert("You have successfully registered for this Volunteering opportunity!");window.location.href=window.location.href;</script>';
            } else {
                echo "Error" . mysqli_connect_error();
            }
        }
    }
    public function count_active_volunteer_opportunities($conn)
    {
        $userID = $this->id;
        $sql = "SELECT COUNT(Volunteering.id) AS available_volunteering_count 
        FROM Volunteering 
        INNER JOIN Volunteering_details 
        ON Volunteering.id = Volunteering_details.volunteering_id 
        WHERE Volunteering_details.volunteer_id = $userID
        AND volunteering.availability > 0";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $count[0]["available_volunteering_count"];
    }
    public function get_all_registered_volunteer_opportunities($conn)
    {
        $userID = $this->id;
        $sql = "SELECT Volunteering.*
        FROM Volunteering INNER JOIN Volunteering_details
        ON Volunteering.id = Volunteering_details.volunteering_id
        WHERE Volunteering.availability>0 AND Volunteering_details.volunteer_id = $userID ";

        $result = mysqli_query($conn, $sql);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    function delete_volunteering($volunteering_id, $conn){
        $userID = $this->id;
        $sql = "DELETE FROM Volunteering_details 
        WHERE volunteer_id = $userID 
        AND volunteering_id=$volunteering_id";
        mysqli_query($conn, $sql);
        echo '<script type=text/javascript> alert("You have been successfully Unregistered for this Volunteering opportunity ");window.location.href=window.location.href;</script>';
    }
    function search_volunteering($text,$conn){
        $text = mysqli_real_escape_string($conn,$text);
        $sql ="  SELECT * FROM Volunteering
        WHERE Volunteering.availability > 0
        AND (title LIKE '%$text%'
        OR required_skills LIKE '%$text%'
        OR description LIKE '%$text%')";
        $result = mysqli_query($conn,$sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}
?>
<?php
class Employee
{
    public $id;
    public $name;
    public $email;
    public $phone;
    public $username;
    public $rate;
    protected $db;

    public function __construct($email, $mysqli)
    {
        $this->db = $mysqli;
        $this->loadUserData($email);
    }
    // تحميل بيانات المستخدم كاملة
    private function loadUserData($e_email)
    {
        // Escape the user ID to prevent SQL injection
        $e_email = $this->db->real_escape_string($e_email);

        // Prepare the SQL statement
        $sql = "SELECT * FROM employee WHERE email = '$e_email'";

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
                $this->username = $userData['username'];
                $this->rate = $userData['rate'];

            }

            // Free the result set
            $result->close();
        }
    }
    public function getAllVolunteerings($conn)
    {
        $sql = "SELECT * 
            FROM Volunteering 
            WHERE employee_id = $this->id 
            AND availability > 0;";
        $result = mysqli_query($conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    public function updateVolunteerHours($volunteering_id, $conn)
    {
        // 1: Get the hours for the specific volunteering_id
        $hoursSql = "SELECT hours FROM Volunteering WHERE id = $volunteering_id";
        $hoursResult = mysqli_query($conn, $hoursSql);

        if (!$hoursResult || mysqli_num_rows($hoursResult) == 0) {
            echo "Error or no data for the specified volunteering ID: " . mysqli_error($conn);
            return;
        }
        $hoursRow = mysqli_fetch_assoc($hoursResult);
        $volunteeringHours = $hoursRow['hours'];

        // 2: Get all volunteer_ids for the specific volunteering_id
        $volunteerIdsSql = "SELECT volunteer_id FROM Volunteering_details WHERE volunteering_id = $volunteering_id";
        $volunteerIdsResult = mysqli_query($conn, $volunteerIdsSql);

        if (!$volunteerIdsResult) {
            echo "Error retrieving volunteer ids: " . mysqli_error($conn);
            return;
        }

        // 3: Update volunteering_hours for each volunteer
        while ($row = mysqli_fetch_assoc($volunteerIdsResult)) {
            $volunteer_id = $row['volunteer_id'];

            // Update the volunteer table
            $updateSql = "UPDATE volunteer SET 	volunteering_hours = volunteering_hours + $volunteeringHours , number_v= number_v + 1 WHERE id = $volunteer_id";
            if (!mysqli_query($conn, $updateSql)) {
                echo "Error updating volunteer (ID: $volunteer_id): " . mysqli_error($conn);
            }
        }
    }
    public function RateIfNotRated($volunteering_id, $conn)
    {
        // Check if already rated
        $volunteering_id_escaped = mysqli_real_escape_string($conn, $volunteering_id);
        $sql = "SELECT is_rated FROM Volunteering WHERE id = $volunteering_id_escaped AND is_rated > 0";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            return;
        } else {
            // Retrieve all volunteers for the specific volunteering_id
            $volunteerIdsSql = "SELECT volunteer_id FROM Volunteering_details WHERE volunteering_id = $volunteering_id_escaped";
            $volunteerIdsResult = mysqli_query($conn, $volunteerIdsSql);
            $volunteers = mysqli_fetch_all($volunteerIdsResult, MYSQLI_ASSOC);

            // Update rate for each volunteer
            foreach ($volunteers as $volunteer) {
                $rate = 10;
                $id = mysqli_real_escape_string($conn, $volunteer["volunteer_id"]);
                $updateSql = "UPDATE volunteer SET rates = rates + $rate WHERE id = $id";
                if (!mysqli_query($conn, $updateSql)) {
                    echo "Error in updating rate: " . mysqli_error($conn);
                }
            }

            // Update Volunteering is_rated
            $updateVolunteeringSql = "UPDATE Volunteering SET is_rated = 1 WHERE id = $volunteering_id_escaped";
            if (!mysqli_query($conn, $updateVolunteeringSql)) {
                echo "Error in updating rateIfNotRated: " . mysqli_error($conn);
            }
        }
    }
    public function completed_volunteering($volunteering_id, $conn)
    {
        $sql = "UPDATE Volunteering SET availability = 0 WHERE id = $volunteering_id";
        if (mysqli_query($conn, $sql)) {
            echo '<script type=text/javascript> alert("You have successfully Completed this Volunteering opportunity!");window.location.href=window.location.href;</script>';
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
    public function getVolunteeringName($volunteering_id, $conn)
    {
        $sql = "SELECT title FROM Volunteering WHERE id = $volunteering_id";
        $result = mysqli_query($conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC)[0]["title"];
    }
    public function getAllVolunteers($volunteering_id, $conn)
    {

        $sql = "SELECT volunteer.id, volunteer.name, volunteer.phone,volunteer.academic_id, volunteer.skills, volunteer.rates
                FROM volunteer
                INNER JOIN Volunteering_details ON volunteer.id = Volunteering_details.volunteer_id
                WHERE Volunteering_details.volunteering_id = $volunteering_id; ";
        $result = mysqli_query($conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    public function saveRates($volunteers, $volunteering_id, $conn)
    {
        // لو كان مقيهم قبل كدا
        $sql2 = "SELECT is_rated FROM Volunteering WHERE id=$volunteering_id AND is_rated>0 ;";
        $result = mysqli_query($conn, $sql2);
        if (mysqli_num_rows($result) > 0) {
            echo '<script type=text/javascript> alert("You have Rated this Volunteering opportunity before!");window.location.href=window.location.href;</script>';
        } else {
            foreach ($volunteers as $volunteer) {
                $rate = $_POST['rate_' . htmlspecialchars($volunteer['id'])];
                // echo $volunteer['name'].$rate;
                $id = $volunteer["id"];
                $sql = "UPDATE volunteer
                SET rates = rates + $rate
                WHERE `volunteer`.`id` = $id ;";
                if (!mysqli_query($conn, $sql)) {
                    echo "error in updating rate" . mysqli_error($conn);
                }
            }
            $sql3 = "UPDATE Volunteering SET is_rated=1 WHERE id=$volunteering_id";
            if (!mysqli_query($conn, $sql3)) {
                echo "error and updating is_rated" . mysqli_error($conn);
            }
            echo '<script type=text/javascript> alert("You have Successfully Rated this Volunteering opportunity!");window.location.href=window.location.href;</script>';
        }
    }
    public function delete_volunteering($volunteering_id, $conn)
    {
        $volunteering_id_escaped = mysqli_real_escape_string($conn, $volunteering_id);

        // SQL to delete the volunteering entry
        $sql = "DELETE FROM Volunteering WHERE id = $volunteering_id_escaped";

        // Execute the query
        if (mysqli_query($conn, $sql)) {
            echo '<script type=text/javascript> alert("You have successfully Deleted this Volunteering opportunity!");window.location.href=window.location.href;</script>';
        } else {
            echo "Error deleting volunteering entry: " . mysqli_error($conn);
        }
    }

    public function Create_volunteer_opportunity($title, $description, $location, $start_date, $end_date, $hours, $required_skills, $max_size, $conn)
    {
        $employee_id = (int) $this->id;
        $title = mysqli_real_escape_string($conn, $title);
        $description = mysqli_real_escape_string($conn, $description);
        $location = mysqli_real_escape_string($conn, $location);
        $start_date = mysqli_real_escape_string($conn, $start_date);
        $end_date = mysqli_real_escape_string($conn, $end_date);
        $hours = mysqli_real_escape_string($conn, $hours);
        $required_skills = mysqli_real_escape_string($conn, $required_skills);
        $max_size = mysqli_real_escape_string($conn, $max_size);

        $sql = "INSERT INTO `Volunteering` (`title`, `description`, `employee_id`, `location`, `start_date`, `end_date`, `hours`, `required_skills`, `availability`, `max_size`, `rate`, `is_rated`) 
            VALUES ('$title', '$description', $employee_id, '$location', '$start_date', '$end_date', '$hours', '$required_skills', 1, '$max_size', 0, 0);";

        if (!mysqli_query($conn, $sql)) {
            echo "Error in Create_volunteer_opportunity: " . mysqli_error($conn);
        }
    }
    public function getRanking($conn){
        $sql = "SELECT name, volunteering_hours, skills, number_v, rate
        FROM volunteer
        WHERE volunteering_hours>0
        ORDER BY `volunteer`.`volunteering_hours`
        DESC LIMIT 10";
        $result = mysqli_query($conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    public function search_volunteering($text, $conn)
    {
        $text = mysqli_real_escape_string($conn,$text);
        $sql = "SELECT * 
            FROM Volunteering 
            WHERE ( employee_id = $this->id 
            AND availability > 0 ) AND (title LIKE '%$text%'
            OR required_skills LIKE '%$text%'
            OR description LIKE '%$text%') ";
        $result = mysqli_query($conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function count_active_volunteer_opportunities($conn)
    {
        
        $sql = " SELECT COUNT(volunteering.id) AS active_volunteering
        FROM volunteering 
        WHERE volunteering.employee_id = $this->id
        AND   volunteering.availability > 0;";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $count[0]["active_volunteering"];
    }


    public function comopleted_volunteering($conn)
    {
        
         
      $sql= " SELECT COUNT(volunteering.id) AS compeleted
        FROM volunteering 
        WHERE volunteering.employee_id = $this->id
        AND   volunteering.availability = 0
        AND   volunteering.is_rated >0";

        $result = mysqli_query($conn, $sql);
        $count = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $count[0]["compeleted"];
    }



}




?>
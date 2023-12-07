<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
// $sql = "SELECT* FROM `volunteer`";
// $result = mysqli_query($conn, $sql);
// $values =  mysqli_fetch_all($result, MYSQLI_ASSOC);
    // print_r($values);
    if (isset($_POST['save_changes'])) {
        if(!isValidName($_POST['name'])){
            echo "<script>alert('Invalid Name')</script>";
        }else if(!isValidEmail($_POST['email'])){
            echo "<script>alert('Invalid email')</script>";
        }else if (!isValidPhone($_POST['phone'])){
            echo "<script>alert('Invalid phone')</script>";
        } else {
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $phone = mysqli_real_escape_string($conn, $_POST['phone']);
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $address = mysqli_real_escape_string($conn, $_POST['address']);
            $skills = mysqli_real_escape_string($conn, $_POST['skills']);
            $available = $_POST['option'] == "available" ? 1 : 0;

            $sql = "UPDATE `volunteer`
                    SET `name`='$name', email='$email', phone='$phone', 
                    `address`='$address', skills='$skills', `availability`='$available' 
                    WHERE `volunteer`.`id` = '$user->id'";
            mysqli_query($conn, $sql);
            echo "saved, please log out";
        }
     }
}

?>
<!-- Form -->
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit profile</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    if (isset($errors)) {
                        foreach ($errors as $error) {
                            echo '<span class="error-msg">' . $error . '</span>';
                        };
                    };
                    ?>

                    <!-- name -->
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter name"
                            value="<?php echo htmlspecialchars($user->name) ?>">
                    </div>
                    <!-- email -->
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" name="email" placeholder="Enter email"
                            value="<?php echo htmlspecialchars($user->email) ?>">
                    </div>
                    <!-- phone -->
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" class="form-control" name="phone" placeholder="Enter phone"
                            value="0<?php echo htmlspecialchars($user->phone) ?>">
                    </div>
                    <!-- address -->
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" name="address" placeholder="Enter address"
                            value="<?php echo htmlspecialchars($user->address) ?>">
                    </div>
                    <!-- skills -->
                    <div class="form-group">
                        <label>Skills</label>
                        <input type="text" class="form-control" name="skills" placeholder="Enter skills"
                            value="<?php echo htmlspecialchars($user->skills) ?>">
                    </div>
                    <!-- Availability -->
                    <div class="form-group">
                        <label>Availability</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="option" id="Radio_Available"
                                value="available" <?php echo ($user->available > 0) ? 'checked' : ''; ?>>
                            <label class="form-check-label">
                                Available
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="option" id="Radio_Not_available"
                                value="Not available" <?php echo ($user->available <= 0) ? 'checked' : ''; ?>>
                            <label class="form-check-label">
                                Not available
                            </label>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" name="save_changes" class="btn btn-primary" value="Save changes">
                </div>
            </div>
        </div>
    </div>
</form>

<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: /Babysafe/auth/login.php");
    exit;

}
$errors = [];
require_once '../../../config/connection.php';
if($_SERVER['REQUEST_METHOD']=='POST'){
    $name = trim($_POST['name'] ?? '');
    $dob = trim($_POST['dob'] ?? '');
    $qualification = trim($_POST['qualification'] ?? '');
    $experiences = trim($_POST['experiences'] ?? '');
    $spouse = $_POST['spouse'] ?? '';
    $age = trim($_POST['age'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $gender = $_POST['gender'] ?? '';


    // Validation
    if(empty($name)){ 
        $errors['name'] = "Full Name is required";
    }

    if(empty($dob)){
        $errors['dob'] = "Date of Birth is required";
    } 

    if(!empty($dob) && !preg_match('/^\d{4}-\d{1,2}-\d{1,2}$/', $dob)) {
        $errors['dob'] = "Date of Birth must be in YYYY-MM-DD format";
    }

    if(empty($occupation)){

        $errors['occupation'] = "Occupation is required";
    }
    if(empty($age)){
        $errors['age'] = "Age is required";
    }

    if(!empty($age) && !is_numeric($age)){
        $errors['age'] = "Age must be a number";
    }

    if(empty($phone)){
        $errors['phone'] = "Phone number is required";
    }
    if(!empty($phone) && !preg_match('/^\d{10}$/', $phone)){
        $errors['phone'] = "Phone must be 10 digits";
    }
    if(empty($gender)){
        $errors['gender'] = "Gender is required";
    }

    // If no errors, insert into database
    if(empty($errors)) {
        $id = $_SESSION['id'];

        // Escape values for SQL
        $name = mysqli_real_escape_string($conn, $name);
        $dob = mysqli_real_escape_string($conn, $dob);
        $occupation = mysqli_real_escape_string($conn, $occupation);
        $age = mysqli_real_escape_string($conn, $age);
        $phone = mysqli_real_escape_string($conn, $phone);
        $gender = mysqli_real_escape_string($conn, $gender);

        if(empty($errors)) {
            $_SESSION['parents'] = [
                'name' => $name,
                'dob' => $dob,
                'qualification' => $qualification,
                'experiences' => $experiences,
                'spouse' => $spouse,
                'age' => $age,
                'phone' => $phone,
                'gender' => $gender
                
            ];
            header("Location: address.php");
            exit;
        } else {
            $errors['database'] = "Failed to save data: " . mysqli_error($conn);
        }
    }


}
?>

    <!-- Step 1 of Verification -->
    <h2 class="ah2">Personal Information verification</h2>
    <form  method="post" id="verificationPersonal">
        <div class="input-field">
            <label for="name">Full Name
                <span class="required">*</span>
            </label><br>
            <input type="text" name="name" value="<?= htmlspecialchars($name ?? '') ?>" placeholder="Full Name"><br>
            <!-- This is for JS errors -->
            <p class="errors" id="nameError"></p>

            <!-- This is for PHP server-side errors -->
            <?php if (isset($errors['name'])): ?>
            <p class="errors"><?php echo $errors['name'] ; ?></p>
            <?php endif; ?>
        </div>

        <div class="input-field">
            <label for="dob">Date of Birth
                <span class="required">*</span>
            </label><br>
            <input type="text" name="dob" value="<?= htmlspecialchars($dob ?? '') ?>" placeholder="2050-5-8"><br>
            <!-- This is for JS errors -->
            <p class="errors" id="dobError"></p>

            <!-- This is for PHP server-side errors -->
            <?php if (isset($errors['dob'])): ?>
            <p class="errors"><?php echo $errors['dob'] ; ?></p>
            <?php endif; ?>
        </div>

        <div class="input-field">
            <label for="qualification">Qualification(if any)
            </label><br>
            <input type="text" name="qualification" ><br>
            
        </div>

        <div class="input-field">
            <label for="experiences">Experiences(if any)
            </label><br>
            <input type="text" name="experiences"><br>
        </div>

        <div class="input-field">
            <label for="spouse">Spouse(optional)</label><br>
            <input type="text" name="spouse" id="spouse">
        </div>

        <div class="input-field">
            <label for="age">Age
                <span class="required">*</span>
            </label><br>
            <input type="text" name="age" value="<?= htmlspecialchars($age ?? '') ?>" placeholder="35"><br>
            <!-- This is for JS errors -->
            <p class="errors" id="ageError"></p>

            <!-- This is for PHP server-side errors -->
            <?php if (isset($errors['age'])): ?>
            <p class="errors"><?php echo $errors['age'] ; ?></p>
            <?php endif; ?>
        </div>

        <div class="input-field">
            <label for="phone">Phone
                <span class="required">*</span>
            </label><br>
            <input type="number" name="phone" value="<?= htmlspecialchars($phone ?? '') ?>" placeholder="9800000000" >
            <!-- This is for JS errors -->
            <p class="errors" id="phoneError"></p>

            <!-- This is for PHP server-side errors -->
            <?php if (isset($errors['phone'])): ?>
            <p class="errors"><?php echo $errors['phone'] ; ?></p>
            <?php endif; ?>
        </div>

        <div class="input-field">
            <label>Gender</label><br>

            <input type="radio" id="male" name="gender" value="male">
            <label for="male">Male</label>

            <input type="radio" id="female" name="gender" value="female">
            <label for="female">Female</label>

            <input type="radio" id="other" name="gender" value="other">
            <label for="other">Other</label>
            <!-- This is for JS errors -->
            <p class="errors" id="genderError"></p>

            <!-- This is for PHP server-side errors -->
            <?php if (isset($errors['gender'])): ?>
            <p class="errors"><?php echo $errors['gender'] ; ?></p>
            <?php endif; ?>
        </div>

        <!-- Back button -->
         <div>
            <button type="button" onclick="history.back()">Back</button>
        </div>

        <!-- Next button --> 
        <div>
            <button type="submit">Next</button>
        </div>
        
    </form>

    <script>
        document.getElementById("verificationPersonal").onsubmit = function () {

    // get input values
    var name = document.getElementById("name").value;
    var dob = document.getElementById("dob").value;
    var occupation = document.getElementById("occupation").value;
    var age = document.getElementById("age").value;
    var phone = document.getElementById("phone").value;

    // gender (radio button)
    var male = document.getElementById("male").checked;
    var female = document.getElementById("female").checked;
    var other = document.getElementById("other").checked;

    // clear old error messages
    document.getElementById("nameError").innerHTML = "";
    document.getElementById("dobError").innerHTML = "";
    document.getElementById("occupationError").innerHTML = "";
    document.getElementById("ageError").innerHTML = "";
    document.getElementById("phoneError").innerHTML = "";
    document.getElementById("genderError").innerHTML = "";

    var hasError = false;

    // name check
    if (name == "") {
        document.getElementById("nameError").innerHTML = "Full Name is required";
        hasError = true;
    }

    // dob check
    if (dob == "") {
        document.getElementById("dobError").innerHTML = "Date of Birth is required";
        hasError = true;
    }

    // age check
    if (age == "") {
        document.getElementById("ageError").innerHTML = "Age is required";
        hasError = true;
    }

    // phone check
    if (phone == "") {
        document.getElementById("phoneError").innerHTML = "Phone number is required";
        hasError = true;
    }

    // phone length
    if (phone != "" && phone.length != 10) {
        document.getElementById("phoneError").innerHTML = "Phone must be 10 digits";
        hasError = true;
    }

    // gender check
    if (male == false && female == false && other == false) {
        document.getElementById("genderError").innerHTML = "Gender is required";
        hasError = true;
    }

    // if error exists, stop form submit
    if (hasError == true) {
        return false;
    }

    // no error → form submits
    return true;
};


    </script>
    
</body>
</html>
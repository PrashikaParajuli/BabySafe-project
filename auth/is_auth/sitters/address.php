<?php
session_start();
// if(!isset($_SESSION['id'])){
//     header("Location: /Babysafe/auth/login.php");
//     exit;

// }
$errors = [];
require_once ('../../../config/connection.php');
if($_SERVER['REQUEST_METHOD']=='POST'){
    $p_province =  mysqli_real_escape_string($conn, $_POST['p_province'] ?? '');
    $p_district =  mysqli_real_escape_string($conn, $_POST['p_district'] ?? '');
    $p_city =  mysqli_real_escape_string($conn, $_POST['p_city' ?? '']);
    $p_ward =  mysqli_real_escape_string($conn, $_POST['p_ward' ?? '']);
    $p_tole =  mysqli_real_escape_string($conn, $_POST['p_tole' ?? '']);
    $t_province =  mysqli_real_escape_string($conn, $_POST['t_province'] ?? '');
    $t_district =  mysqli_real_escape_string($conn, $_POST['t_district'] ?? '');
    $t_city =  mysqli_real_escape_string($conn, $_POST['t_city' ?? '']);
    $t_ward =  mysqli_real_escape_string($conn, $_POST['t_ward' ?? '']);
    $t_tole =  mysqli_real_escape_string($conn, $_POST['t_tole' ?? '']);


    if (empty($p_province)) {
    $errors['p_province'] = "Province is required";
    }

    if (empty($p_district)) {
    $errors['p_district'] = "District is required";
    }

    if (empty($p_city)) {
    $errors['p_city'] = "City is required";
    }

    if (empty($p_ward)) {
    $errors['p_ward'] = "Ward is required";
    }

    if (empty($p_tole)) {
    $errors['p_tole'] = "Tole is required";
    }

    if (empty($t_province)) {
    $errors['t_province'] = "Province is required";
    }

    if (empty($t_district)) {
    $errors['t_district'] = "District is required";
    }

    if (empty($t_city)) {
    $errors['t_city'] = "City is required";
    }

    if (empty($t_ward)) {
    $errors['t_ward'] = "Ward is required";
    }

    if (empty($t_tole)) {
    $errors['t_tole'] = "Tole is required";
    }

    if(empty($errors)){
        $id = $_SESSION['id'];

        $p_address = "Ward " . $p_ward . ", " . $p_tole;
        $t_address = "Ward " . $t_ward . ", " . $t_tole;

        if(empty($errors)){

            $_SESSION['address'] = [
                'p_province' => $p_province,
                'p_district' => $p_district,
                'p_city'     => $p_city,
                'p_ward'     => $p_ward,
                'p_tole'     => $p_tole,
                't_province' => $t_province,
                't_district' => $t_district,
                't_city'     => $t_city,
                't_ward'     => $t_ward,
                't_tole'     => $t_tole
            ];
                
        }
    }    
      
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Address | BabySafe</title>
    <link rel="stylesheet" href="/Babysafe/css/form.css">
</head>
<body>
    <h2>Address Information verification</h2>
    <form method="POST">
        <h3>Permanant Address</h3>

        <div class="input-field">
            <label for="p_province">Province
                <span class="required">*</span>
            </label><br>
            <select name="p_province" required>
                <option value="">Select Province</option>
                <option value="Koshi">Koshi Province</option>
                <option value="Madhesh">Madhesh Province</option>
                <option value="Bagmati">Bagmati Province</option>
                <option value="Gandaki">Gandaki Province</option>
                <option value="Lumbini">Lumbini Province</option>
                <option value="Karnali">Karnali Province</option>
                <option value="Sudurpashchim">Sudurpashchim Province</option>
            </select>
            
            <?php if (isset($errors['p_province'])): ?>
            <p class="errors"><?php echo $errors['p_province'] ; ?></p>
            <?php endif; ?>
        </div>

        <div class="input-field">
            <label for="p_district">District</label><br>
            <select name="p_district" required>
                <option value="">Select District</option>

                <!-- Koshi Province -->
                <option value="Bhojpur">Bhojpur</option>
                <option value="Dhankuta">Dhankuta</option>
                <option value="Ilam">Ilam</option>
                <option value="Jhapa">Jhapa</option>
                <option value="Khotang">Khotang</option>
                <option value="Morang">Morang</option>
                <option value="Okhaldhunga">Okhaldhunga</option>
                <option value="Panchthar">Panchthar</option>
                <option value="Sankhuwasabha">Sankhuwasabha</option>
                <option value="Solukhumbu">Solukhumbu</option>
                <option value="Sunsari">Sunsari</option>
                <option value="Taplejung">Taplejung</option>
                <option value="Terhathum">Terhathum</option>
                <option value="Udayapur">Udayapur</option>

                <!-- Madhesh Province -->
                <option value="Bara">Bara</option>
                <option value="Dhanusha">Dhanusha</option>
                <option value="Mahottari">Mahottari</option>
                <option value="Parsa">Parsa</option>
                <option value="Rautahat">Rautahat</option>
                <option value="Saptari">Saptari</option>
                <option value="Sarlahi">Sarlahi</option>
                <option value="Siraha">Siraha</option>

                <!-- Bagmati Province -->
                <option value="Bhaktapur">Bhaktapur</option>
                <option value="Chitwan">Chitwan</option>
                <option value="Dhading">Dhading</option>
                <option value="Dolakha">Dolakha</option>
                <option value="Kathmandu">Kathmandu</option>
                <option value="Kavrepalanchok">Kavrepalanchok</option>
                <option value="Lalitpur">Lalitpur</option>
                <option value="Makwanpur">Makwanpur</option>
                <option value="Nuwakot">Nuwakot</option>
                <option value="Ramechhap">Ramechhap</option>
                <option value="Rasuwa">Rasuwa</option>
                <option value="Sindhuli">Sindhuli</option>
                <option value="Sindhupalchok">Sindhupalchok</option>

                <!-- Gandaki Province -->
                <option value="Baglung">Baglung</option>
                <option value="Gorkha">Gorkha</option>
                <option value="Kaski">Kaski</option>
                <option value="Lamjung">Lamjung</option>
                <option value="Manang">Manang</option>
                <option value="Mustang">Mustang</option>
                <option value="Myagdi">Myagdi</option>
                <option value="Nawalpur">Nawalpur</option>
                <option value="Parbat">Parbat</option>
                <option value="Syangja">Syangja</option>
                <option value="Tanahun">Tanahun</option>

                <!-- Lumbini Province -->
                <option value="Arghakhanchi">Arghakhanchi</option>
                <option value="Banke">Banke</option>
                <option value="Bardiya">Bardiya</option>
                <option value="Dang">Dang</option>
                <option value="Eastern Rukum">Eastern Rukum</option>
                <option value="Gulmi">Gulmi</option>
                <option value="Kapilvastu">Kapilvastu</option>
                <option value="Parasi">Parasi</option>
                <option value="Palpa">Palpa</option>
                <option value="Pyuthan">Pyuthan</option>
                <option value="Rolpa">Rolpa</option>
                <option value="Rupandehi">Rupandehi</option>

                <!-- Karnali Province -->
                <option value="Dailekh">Dailekh</option>
                <option value="Dolpa">Dolpa</option>
                <option value="Humla">Humla</option>
                <option value="Jajarkot">Jajarkot</option>
                <option value="Jumla">Jumla</option>
                <option value="Kalikot">Kalikot</option>
                <option value="Mugu">Mugu</option>
                <option value="Salyan">Salyan</option>
                <option value="Surkhet">Surkhet</option>
                <option value="Western Rukum">Western Rukum</option>

                <!-- Sudurpashchim Province -->
                <option value="Achham">Achham</option>
                <option value="Baitadi">Baitadi</option>
                <option value="Bajhang">Bajhang</option>
                <option value="Bajura">Bajura</option>
                <option value="Dadeldhura">Dadeldhura</option>
                <option value="Darchula">Darchula</option>
                <option value="Doti">Doti</option>
                <option value="Kailali">Kailali</option>
                <option value="Kanchanpur">Kanchanpur</option>

            </select>
            
            <?php if (isset($errors['p_district'])): ?>
            <p class="errors"><?php echo $errors['p_district'] ; ?></p>
            <?php endif; ?>
        </div>

        <div class="input-field">
            <label for="p_city">City*</label><br>
            <input type="text" id="p_city" name="p_city" value="<?= htmlspecialchars($p_city ?? '') ?>">
            <?php if (isset($errors['p_city'])): ?>
            <p class="errors"><?php echo $errors['p_city'] ; ?></p>
            <?php endif; ?>
        </div>

        <div class="input-field">
            <label for="p_ward">Ward No.
                <span class="required">*</span>
            </label><br>
            <input type="number" id="p_ward" name="p_ward" value="<?= htmlspecialchars($p_ward ?? '') ?>">
            <?php if (isset($errors['p_ward'])): ?>
            <p class="errors"><?php echo $errors['p_ward'] ; ?></p>
            <?php endif; ?>
        </div>

        <div class="input-field">
            <label for="p_tole">Tole
                <span class="required">*</span>
            </label><br>
            <input type="text" id="t_tole" name="t_tole" value="<?= htmlspecialchars($t_tole ?? '') ?>">
            <?php if (isset($errors['p_tole'])): ?>
            <p class="errors"><?php echo $errors['p_tole'] ; ?></p>
            <?php endif; ?>
        </div>

        <h3>Temporary Address</h3>
        <div class="input-field">
            <label for="t_province">Province
                <span class="required">*</span>
            </label><br>
            <select name="p_province" required>
                <option value="">Select Province</option>
                <option value="Koshi">Koshi Province</option>
                <option value="Madhesh">Madhesh Province</option>
                <option value="Bagmati">Bagmati Province</option>
                <option value="Gandaki">Gandaki Province</option>
                <option value="Lumbini">Lumbini Province</option>
                <option value="Karnali">Karnali Province</option>
                <option value="Sudurpashchim">Sudurpashchim Province</option>
            </select>
            
            <?php if (isset($errors['t_province'])): ?>
            <p class="errors"><?php echo $errors['t_province'] ; ?></p>
            <?php endif; ?>
        </div>

        <div class="input-field">
            <label for="t_district">District*</label><br>

            <select name="p_district" required>
                <option value="">Select District</option>

                <!-- Koshi Province -->
                <option value="Bhojpur">Bhojpur</option>
                <option value="Dhankuta">Dhankuta</option>
                <option value="Ilam">Ilam</option>
                <option value="Jhapa">Jhapa</option>
                <option value="Khotang">Khotang</option>
                <option value="Morang">Morang</option>
                <option value="Okhaldhunga">Okhaldhunga</option>
                <option value="Panchthar">Panchthar</option>
                <option value="Sankhuwasabha">Sankhuwasabha</option>
                <option value="Solukhumbu">Solukhumbu</option>
                <option value="Sunsari">Sunsari</option>
                <option value="Taplejung">Taplejung</option>
                <option value="Terhathum">Terhathum</option>
                <option value="Udayapur">Udayapur</option>

                <!-- Madhesh Province -->
                <option value="Bara">Bara</option>
                <option value="Dhanusha">Dhanusha</option>
                <option value="Mahottari">Mahottari</option>
                <option value="Parsa">Parsa</option>
                <option value="Rautahat">Rautahat</option>
                <option value="Saptari">Saptari</option>
                <option value="Sarlahi">Sarlahi</option>
                <option value="Siraha">Siraha</option>

                <!-- Bagmati Province -->
                <option value="Bhaktapur">Bhaktapur</option>
                <option value="Chitwan">Chitwan</option>
                <option value="Dhading">Dhading</option>
                <option value="Dolakha">Dolakha</option>
                <option value="Kathmandu">Kathmandu</option>
                <option value="Kavrepalanchok">Kavrepalanchok</option>
                <option value="Lalitpur">Lalitpur</option>
                <option value="Makwanpur">Makwanpur</option>
                <option value="Nuwakot">Nuwakot</option>
                <option value="Ramechhap">Ramechhap</option>
                <option value="Rasuwa">Rasuwa</option>
                <option value="Sindhuli">Sindhuli</option>
                <option value="Sindhupalchok">Sindhupalchok</option>

                <!-- Gandaki Province -->
                <option value="Baglung">Baglung</option>
                <option value="Gorkha">Gorkha</option>
                <option value="Kaski">Kaski</option>
                <option value="Lamjung">Lamjung</option>
                <option value="Manang">Manang</option>
                <option value="Mustang">Mustang</option>
                <option value="Myagdi">Myagdi</option>
                <option value="Nawalpur">Nawalpur</option>
                <option value="Parbat">Parbat</option>
                <option value="Syangja">Syangja</option>
                <option value="Tanahun">Tanahun</option>

                <!-- Lumbini Province -->
                <option value="Arghakhanchi">Arghakhanchi</option>
                <option value="Banke">Banke</option>
                <option value="Bardiya">Bardiya</option>
                <option value="Dang">Dang</option>
                <option value="Eastern Rukum">Eastern Rukum</option>
                <option value="Gulmi">Gulmi</option>
                <option value="Kapilvastu">Kapilvastu</option>
                <option value="Parasi">Parasi</option>
                <option value="Palpa">Palpa</option>
                <option value="Pyuthan">Pyuthan</option>
                <option value="Rolpa">Rolpa</option>
                <option value="Rupandehi">Rupandehi</option>

                <!-- Karnali Province -->
                <option value="Dailekh">Dailekh</option>
                <option value="Dolpa">Dolpa</option>
                <option value="Humla">Humla</option>
                <option value="Jajarkot">Jajarkot</option>
                <option value="Jumla">Jumla</option>
                <option value="Kalikot">Kalikot</option>
                <option value="Mugu">Mugu</option>
                <option value="Salyan">Salyan</option>
                <option value="Surkhet">Surkhet</option>
                <option value="Western Rukum">Western Rukum</option>

                <!-- Sudurpashchim Province -->
                <option value="Achham">Achham</option>
                <option value="Baitadi">Baitadi</option>
                <option value="Bajhang">Bajhang</option>
                <option value="Bajura">Bajura</option>
                <option value="Dadeldhura">Dadeldhura</option>
                <option value="Darchula">Darchula</option>
                <option value="Doti">Doti</option>
                <option value="Kailali">Kailali</option>
                <option value="Kanchanpur">Kanchanpur</option>

            </select>
            
            <?php if (isset($errors['t_district'])): ?>
            <p class="errors"><?php echo $errors['t_district'] ; ?></p>
            <?php endif; ?>
        </div>

        <div class="input-field">
            <label for="t_city">City
                <span class="required">*</span>
            </label><br>
            <input type="text"  id="t_city" name="t_city" value="<?= htmlspecialchars($t_city ?? '') ?>">
            <?php if (isset($errors['t_city'])): ?>
            <p class="errors"><?php echo $errors['t_city'] ; ?></p>
            <?php endif; ?>
        </div>

        <div class="input-field">
            <label for="t_ward">Ward No.
                <span class="required">*</span>
            </label><br>
            <input type="number" id="t_ward"  name="t_ward" value="<?= htmlspecialchars($t_ward ?? '') ?>">
            <?php if (isset($errors['t_ward'])): ?>
            <p class="errors"><?php echo $errors['t_ward'] ; ?></p>
            <?php endif; ?>
        </div>

        <div class="input-field">
            <label for="t_tole">Tole
                <span class="required">*</span>
            </label><br>
            <input type="text" id="t_tole" name="t_tole" value="<?= htmlspecialchars($t_tole ?? '') ?>">
            <?php if (isset($errors['t_tole'])): ?>
            <p class="errors"><?php echo $errors['t_tole'] ; ?></p>
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
</body>
</html>
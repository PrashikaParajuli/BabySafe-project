<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: /Babysafe/auth/login.php");
    exit;

}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    $doc = $_POST['doc'] ?? '';

    if ($doc == '') {
        $errors['doc'] = "Choose a document";
    }

    if ($doc == 'citizenship' || $doc == 'license') {
        if ($_FILES['front']['name'] == '') {
            $errors['front'] = "Front file required";
        }
        if ($_FILES['back']['name'] == '') {
            $errors['back'] = "Back file required";
        }
    }

    if ($doc == 'passport') {
        if ($_FILES['passport']['name'] == '') {
            $errors['passport'] = "Passport file required";
        }
    }

    if ($_FILES['photo']['name'] == '') {
        $errors['photo'] = "Photo required";
    }

    if (empty($errors)) {

        if ($doc == 'citizenship' || $doc == 'license') {
            move_uploaded_file($_FILES['front']['tmp_name'], "upload/front_".$_FILES['front']['name']);
            move_uploaded_file($_FILES['back']['tmp_name'], "upload/back_".$_FILES['back']['name']);
        }

        if ($doc == 'passport') {
            move_uploaded_file($_FILES['passport']['tmp_name'], "upload/passport_".$_FILES['passport']['name']);
        }

        move_uploaded_file($_FILES['photo']['tmp_name'], "upload/photo_".$_FILES['photo']['name']);
    }

    if(
    !isset($_SESSION['parents']) ||
    !isset($_SESSION['address']) ||
    !isset($_SESSION['documents'])
    ){
        header("Location: personal.php");
        exit;
    }

    $p = $_SESSION['parents'];
    $a = $_SESSION['address'];
    $d = $_SESSION['documents'];
print_r($_SESSION['parents']);
return 0;
    $sql = "INSERT INTO parents
    (name,dob,qualification,experiences,spouse,age,phone,gender,
    province,district,city,ward,tole,
    doc_type,photo,front_doc,back_doc)
    VALUES (
    '{$p['name']}','{$p['dob']}','{$p['qualification']}','{$p['experiences']}','{$p['spouse']}',
    '{$p['age']}','{$p['phone']}','{$p['gender']}',
    '{$a['province']}','{$a['district']}','{$a['city']}','{$a['ward']}','{$a['tole']}',
    '{$d['type']}','{$d['photo']}','{$d['front']}','{$d['back']}'
    )";

    mysqli_query($conn, $sql);

    /* CLEAR SESSION */
    unset($_SESSION['parents'], $_SESSION['address'], $_SESSION['documents']);

    echo "Verification completed successfully";

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Information verification</title>
</head>
<body>
    <h2>Upload Document</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <label>Select Document Type *</label><br>
        <select name="doc_type" onchange="showFields(this.value)">
            <option value="">-- Select --</option>
            <option value="citizenship">Citizenship</option>
            <option value="driving license">Driving License</option>
            <option value="passport">Passport</option>
        </select><br>

        <div id="fb" style="display:none;">
            <label>Front *</label><br>
            <input type="file" name="front"><br>
            

            <label>Back *</label><br>
            <input type="file" name="back">
   
        </div>

        <div id="pass" style="display:none;">
            <label>Passport *</label><br>
            <input type="file" name="passport">
            <div class="error"><?= $errors['passport'] ?? '' ?></div>
        </div>

        <label>Upload Profile Photo *</label><br>
        <input type="file" name="photo">

        <!-- Back button -->
         <div>
            <button type="button" onclick="history.back()">Back</button>
        </div>

        <!-- Next button --> 
        <div>
            <button type="submit">Submit</button>
        </div>
        
     </form> 

     <script>
        function showFields(value) {
            document.getElementById('fb').style.display =
                (value === 'citizenship' || value === 'license') ? 'block' : 'none';

            document.getElementById('pass').style.display =
                (value === 'passport') ? 'block' : 'none';
        }
</script>      
    </body>
</html>
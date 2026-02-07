<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
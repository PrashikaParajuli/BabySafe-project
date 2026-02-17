<?php
require_once 'config/connection.php';

$sql = "SELECT * FROM sitters";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find A Sitters</title>
    <link rel="stylesheet" href="/Babysafe/css/front_end/style.css">
    <link rel="stylesheet" href="css/sitter.css">
</head>
<body>

<div class="slider">

    <button class="arrow">&#10094;</button>

    <?php while($row = mysqli_fetch_assoc($result)) { ?>
        
        <div class="card">
            <img src="/Babysafe/uploads/<?php echo $row['image']; ?>" alt="<?php echo $row['name'];?>">

            <div class="card-content">

                <div class="top-row">
                    <div class="name">
                        <?php echo $row['name']; ?>
                    </div>
                </div>

                <div class="age">
                    <?php echo $row['age']; ?> years old
                </div>

                <div class="bio">
                    <?php echo $row['bio']; ?>
                </div>

                <div class="qualification">
                    Show More Details...
                </div>

            </div>
        </div>

    <?php } ?>

    <button class="arrow">&#10095;</button>

</div>

</body>
</html>

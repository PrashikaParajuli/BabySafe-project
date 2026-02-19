<?php
require_once 'config/connection.php';
require('includes/header.php');

$sql = "SELECT * FROM sitters";
$result = mysqli_query($conn, $sql);
?>

<div class="search">
    <input type="text" name="search" placeholder="search">
</div>
<div class="slider">

    <button class="arrow">&#10094;</button>

    <?php while($row = mysqli_fetch_assoc($result)) { ?>
        
        <div class="sitter-card">
            <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name'];?>">

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

<?php
    require('includes/footer.php');
?>

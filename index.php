<?php
require('includes/header.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home | BabySafe</title>
        <link rel="stylesheet" href="/Babysafe/css/front_end/style.css">
    </head>
    <body>
        <div class="search">
            <input type="text" name="search" placeholder="search">
        </div>
        <section class="hero">
            <div class="hero-content">
                <h3>Trusted Babysitter</h3>
                <p>You child's comes first.</p>
            </div>
            <div class="hero-btn">
                <a href="about.php"><button>Learn More</button></a>
                <a href="find_sitters.php"><button>Book Now</button></a>
            </div>
        </section>
        <?php
            require('includes/footer.php');
        ?>
    </body>
</html>
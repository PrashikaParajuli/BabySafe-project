<?php
require_once('database.php');
//connecting to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "babysafe";

// try {
//     $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (PDOException $e) {
//     die("Connection failed: " . $e->getMessage());
// }

//create a connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

//Check Connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}



//  //admin start
// //creating table for Admin 
// $sql = "CREATE TABLE IF NOT EXISTS admin(
//     id INT PRIMARY KEY AUTO_INCREMENT,
//     name VARCHAR(30) DEFAULT NULL,
//     email VARCHAR(30) DEFAULT NULL,
//     phone BIGINT(10) DEFAULT NULL,
//     role VARCHAR(30) DEFAULT NULL,
//     password VARCHAR(255) DEFAULT NULL,
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//     updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
// )";

// if(mysqli_query($conn, $sql)) {
//     // Table created successfully, no need to echo anything
// } else {
//     //error
// }

// // Inserting default admin data
// // Hash the password
// $hashed_password = password_hash('password', PASSWORD_BCRYPT);

// // SQL Query
// $sql = "INSERT IGNORE INTO admin (id, name,role, email, phone, password) 
//         VALUES ('101', 'Admin','admin', 'admin@gmail.com', '9804000857', '$hashed_password')";

// if (mysqli_query($conn, $sql)) {
//     // Data inserted successfully
// } else {
//     echo "Error Inserting data: " . mysqli_error($conn);
// }
// // Admin End

// //creating table for parents
// $sql = "CREATE TABLE IF NOT EXISTS parents(
//     id INT PRIMARY KEY AUTO_INCREMENT UNIQUE,
//     name VARCHAR(255)DEFAULT NULL,
//     email VARCHAR(255) NOT NULL,
//     password VARCHAR(255) NOT NULL,
//     phone BIGINT(10) NOT NULL,
//     dob DATE DEFAULT NULL,
//     image VARCHAR(255),
//     p_province VARCHAR(255),
//     p_district VARCHAR(255),
//     p_city VARCHAR(255),
//     p_address VARCHAR(255),
//     t_province VARCHAR(255),
//     t_district VARCHAR(255),
//     t_city VARCHAR(255),
//     t_address VARCHAR(255),
//     spouse VARCHAR(255),
//     occupation VARCHAR(255)DEFAULT NULL,
//     gender TINYINT(1)DEFAULT NULL,
//     document_type ENUM('citizenship', 'passport', 'driver_license')DEFAULT NULL,
//     document_path VARCHAR(255)DEFAULT NULL,
//     document_number VARCHAR(50)DEFAULT NULL UNIQUE,
//     otp VARCHAR(10),
//     otp_expiry DATETIME,
//     is_verified BOOLEAN DEFAULT 0,
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//     updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
// )";

// if (mysqli_query($conn, $sql)) {
//     // Table created successfully, no need to echo anything
// } else {
//     //error
// }

// // Inserting default parents data
// // Hash the password
// $hashed_password = password_hash('password', PASSWORD_DEFAULT);

// // SQL Query
// $sql = "INSERT IGNORE INTO parents(
//     id,name,email,password,phone,dob,image,
//     p_province,p_district,p_city,p_address,
//     spouse,occupation,gender,document_type,
//     document_path,document_number,otp,otp_expiry,
//     is_verified,created_at
// ) 
// VALUES (
//     '1','sita','sita@gmail.com','$hashed_password',
//     '9804000857','2004-07-23',
//     'Babysafe/uploads/images/parents/sitap.jpg',
//     'Koshi','Morang','Biratnagar','Ward 1, Biratnagar',
//     'ram','doctor','1','citizenship',
//     'Babysafe/uploads/documents/parents/citizenship.jpg',
//     '06099866572','5555',
//     DATE_ADD(NOW(), INTERVAL 5 MINUTE),
//     0,NOW()
// )";

// if (mysqli_query($conn, $sql)) {
//     //"Data inserted successfully";
// } else {
//     echo "Error Inserting data: " . mysqli_error($conn);
// }


// //creating table for babysitter
// $sql = "CREATE TABLE IF NOT EXISTS sitters(
//     id INT PRIMARY KEY AUTO_INCREMENT UNIQUE,
//     name VARCHAR(255) DEFAULT NULL,
//     email VARCHAR(255) NOT NULL,
//     password VARCHAR(255) NOT NULL,
//     phone BIGINT(10) NOT NULL,
//     dob DATE DEFAULT NULL,
//     image VARCHAR(255),
//     p_province VARCHAR(255),
//     p_district VARCHAR(255),
//     p_city VARCHAR(255),
//     p_address VARCHAR(255),
//     t_province VARCHAR(255),
//     t_district VARCHAR(255),
//     t_city VARCHAR(255),
//     t_address VARCHAR(255),
//     spouse VARCHAR(255),
//     bio TEXT,
//     experiences TEXT,
//     qualification VARCHAR(255),
//     gender TINYINT(1) DEFAULT NULL,
//     document_type ENUM('citizenship', 'passport', 'driver_license') DEFAULT NULL,
//     document_path VARCHAR(255) DEFAULT NULL,
//     document_number VARCHAR(50) DEFAULT NULL UNIQUE,
//     otp VARCHAR(10),
//     otp_expiry DATETIME,
//     is_available TINYINT(1) DEFAULT NULL,
//     background_status TINYINT(1) DEFAULT NULL,
//     is_verified BOOLEAN DEFAULT 0,
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//     updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
// )";

// if (mysqli_query($conn, $sql)) {
//     //success
// } else {
//     //error
// }

// $hashed_password = password_hash('bpassword', PASSWORD_DEFAULT);

// // SQL Query
// $sql = "INSERT IGNORE INTO sitters(
//     id,name,email,password,phone,dob,image,
//     p_province,p_district,p_city,p_address,
//     spouse,bio,gender,document_type,
//     document_path,document_number,otp,otp_expiry,
//     is_available,background_status,is_verified,created_at
// ) 
// VALUES (
//     '1','ivy','ivy@gmail.com','$hashed_password',
//     '9804000857','2004-07-23',
//     'Babysafe/uploads/images/sitters/ivyp.jpg',
//     'Koshi','Morang','Biratnagar','Ward 2, Biratnagar',
//     'shyam',
//     'Hi, I am Ivy, a reliable and fun-loving babysitter with 1+ years of experience caring for kids from infants to 10-year-olds.',
//     '1','citizenship',
//     'Babysafe/uploads/documents/sitters/ivy.jpg',
//     '06099866872','5555',
//     DATE_ADD(NOW(), INTERVAL 5 MINUTE),
//     '2','0',0,NOW()
// )";

// if (mysqli_query($conn, $sql)) {
//     echo "Data inserted successfully";
// } else {
//     echo "Error Inserting data: " . mysqli_error($conn);
// }

// //creating table for children
// $sql ="CREATE TABLE IF NOT EXISTS children(
//     id INT PRIMARY KEY AUTO_INCREMENT UNIQUE,
//     name VARCHAR(255) NOT NULL,
//     dob DATE NOT NULL,
//     image VARCHAR(255),
//     gender TINYINT(1) NOT NULL,
//     allergies VARCHAR(255),
//     special_needs VARCHAR(255),
//     interests VARCHAR(255),
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//     updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
//     parent_id INT NOT NULL,
//     FOREIGN KEY(parent_id) REFERENCES parents(id)
//     )";

//     if (mysqli_query($conn, $sql)) {
//     //success
// } else {
//     //error
// }

//     $sql = "INSERT IGNORE INTO children(id,name,dob,image,gender,allergies,special_needs,interests,created_at,parent_id)
//     VALUES('1','boby','2023-01-01','Babysafe/uploads/images/children/bobyp.jpg','0','peanut','homework','loves to draw',NOW(),'1')";

//     if (mysqli_query($conn, $sql)) {
//     echo "Data inserted successfully";
// } else {
//     echo "Error Inserting data: " . mysqli_error($conn);
// }

// //creating table for booking
$sql ="CREATE TABLE IF NOT EXISTS books(
    id INT PRIMARY KEY AUTO_INCREMENT UNIQUE,
    start_date DATETIME NOT NULL,
    start_time DATETIME NOT NULL,
    end_date DATETIME DEFAULT NULL,
    end_time DATETIME DEFAULT NULL,
    status INT DEFAULT 2,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    sitter_id INT NOT NULL,
    child_id INT NOT NULL,
    FOREIGN KEY(sitter_id) REFERENCES sitters(id),
    FOREIGN KEY(child_id) REFERENCES children(id),
    CHECK (end_time > start_time)

 )";
  if (mysqli_query($conn, $sql)) {
    //success
} else {
    //error
}

// //creating table for review
// $sql ="CREATE TABLE IF NOT EXISTS reviews(
//     id INT PRIMARY KEY AUTO_INCREMENT UNIQUE,
//     comment LONGTEXT NOT NULL,
//     rating DECIMAL(3,1),
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//     updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
//     booked_id INT NOT NULL,
//     FOREIGN KEY(booked_id) REFERENCES books(id)

// )";   

//  if (mysqli_query($conn, $sql)) {
//     //success
// } else {
//     //error
// }
   

// //creating table for skills
// $sql ="CREATE TABLE IF NOT EXISTS skills(
//     id INT PRIMARY KEY AUTO_INCREMENT UNIQUE,
//     name VARCHAR(255) NOT NULL,
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//     updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
//     sitter_id INT NOT NULL,
//     FOREIGN KEY(sitter_id) REFERENCES sitters(id)

// )";

//  if (mysqli_query($conn, $sql)) {
//     //success
// } else {
//     //error
// }



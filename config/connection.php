<?php

require_once('database.php');
//connecting to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "babysafe";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

//create a connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

//Check Connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// admin start
//creating table for Admin 
$sql = "CREATE TABLE IF NOT EXISTS admin(
    a_id INT PRIMARY KEY AUTO_INCREMENT,
    a_name VARCHAR(30) NOT NULL,
    a_role VARCHAR(30) NOT NULL,
    a_email VARCHAR(30) NOT NULL,
    a_phone BIGINT(10) NOT NULL,
    a_password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sql)) {
    // Table created successfully, no need to echo anything
} else {
    echo "Error Creating table: " . mysqli_error($conn);
}

// Inserting default admin data
// Hash the password
$hashed_password = password_hash('password', PASSWORD_BCRYPT);

// SQL Query
$sql = "INSERT IGNORE INTO admin (a_id, a_name,a_role, a_email, a_phone, a_password) 
        VALUES ('101', 'Admin','admin', 'admin@gmail.com', '9804000857', '$hashed_password')";

if (mysqli_query($conn, $sql)) {
    // Data inserted successfully
} else {
    echo "Error Inserting data: " . mysqli_error($conn);
}
// Admin End

//creating table for parents
$sql = "CREATE TABLE IF NOT EXISTS parents(
    id INT PRIMARY KEY AUTO_INCREMENT UNIQUE,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone BIGINT(10) NOT NULL,
    dob DATE NOT NULL,
    image VARCHAR(255),
    address TEXT,
    spouse VARCHAR(255),
    occupation VARCHAR(255) NOT NULL,
    gender TINYINT(1) NOT NULL,
    otp VARCHAR(10) NOT NULL,
    opt_expiry DATETIME NOT NULL,
    is_verified BOOLEAN DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

)";

//creating table for babysitter
$sql = "CREATE TABLE IF NOT EXISTS sitters(
    id INT PRIMARY KEY AUTO_INCREMENT UNIQUE,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone BIGINT(10) NOT NULL,
    dob DATE NOT NULL,
    image VARCHAR(255),
    address TEXT,
    spouse VARCHAR(255),
    bio TEXT,
    experiences TEXT,
    qualification VARCHAR(255),
    gender TINYINT(1) NOT NULL,
    otp VARCHAR(10) NOT NULL,
    opt_expiry DATETIME NOT NULL,
    is_available TINYINT(1) NOT NULL,--booked, available, unavailable
    background_status TINYINT(1) NOT NULL,
    is_verified BOOLEAN DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

//creating table for children
$sql ="CREATE TABLE IF NOT EXISTS children(
    id INT PRIMARY KEY AUTO_INCREMENT UNIQUE,
    name VARCHAR(255) NOT NULL,
    dob DATE NOT NULL,
    image VARCHAR(255),
    gender TINYINT(1) NOT NULL,
    allergies VARCHAR(255),
    special_needs VARCHAR(255),
    interests VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    FOREIGN KEY(parent_id) REFERENCES parents(id)
    )";

//creating table for booking
$sql ="CREATE TABLE IF NOT EXISTS books(
    id INT PRIMARY KEY AUTO_INCREMENT UNIQUE,
    start_date DATETIME NOT NULL,
    start_time DATETIME NOT NULL,
    end_date DATETIME NOT NULL,
    end_time DATETIME NOT NULL,
    status INT DEFAULT 2,--cancle, pending, success, rejected
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(sitter_id) REFERENCES sitters(id),
    FOREIGN KEY(child_id) REFERENCES children(id)

)";

//creating table for review
$sql ="CREATE TABLE IF NOT EXISTS reviews(
    id INT PRIMARY KEY AUTO_INCREMENT UNIQUE,
    comment LONGTEXT,
    rating DECIMAL(3,1),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(booked_id) REFERENCES books(id)

)";   

//creating table for skills
$sql ="CREATE TABLE IF NOT EXISTS reviews(
    id INT PRIMARY KEY AUTO_INCREMENT UNIQUE,
    name VARCHAR(255),created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(sitter_id) REFERENCES sitters(id)

)";
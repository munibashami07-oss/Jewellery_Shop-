<?php
$host="localhost";
$user="root";
$pass="";
$db="muniba_orders_db";

// Connect to MySQL
$conn = new mysqli($host, $user, $pass);
if ($conn->connect_error) {
    die("Connection failed: ".$conn->connect_error);
}

// Create DB if not exists
if (!$conn->query("CREATE DATABASE IF NOT EXISTS `$db`")) {
    die("Database creation failed: " . $conn->error);
}

$conn->select_db($db);

// Create table (avoid reserved word 'order')
$tableSql = "
CREATE TABLE IF NOT EXISTS muniba_orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    number BIGINT NOT NULL,
    city VARCHAR(50) NOT NULL,
    address VARCHAR(100) NOT NULL,
    instructions TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if (!$conn->query($tableSql)) {
    die("Table creation failed: " . $conn->error);
}

// Get POST data
$name  = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$number = $_POST['number'] ?? '';
$city = $_POST['city'] ?? '';
$address = $_POST['address'] ?? '';
$instructions = $_POST['instructions'] ?? '';

// Simple validation
if(!$name || !$email || !$number || !$city || !$address){
    echo "error: missing fields";
    exit;
}

// Prepare statement
$stmt = $conn->prepare(
    "INSERT INTO muniba_orders (name, email, number, city, address, instructions)
     VALUES (?, ?, ?, ?, ?, ?)"
);
if(!$stmt){
    die("Prepare failed: " . $conn->error);
}

// Bind params
$stmt->bind_param("ssisss", $name, $email, $number, $city, $address, $instructions);

// Execute
if ($stmt->execute()) {
    echo "success";
} else {
    echo "Error: " . $stmt->error;
}

// $stmt->close();
$conn->close();
?>

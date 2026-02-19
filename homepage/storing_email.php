<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "email_for_updates";

$conn = new mysqli($host, $user, $pass);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/* create DB */
$conn->query("CREATE DATABASE IF NOT EXISTS $db");
$conn->select_db($db);

/* create table */
$conn->query("
    CREATE TABLE IF NOT EXISTS USER_EMAIL (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(100) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
");

/* get email */
$email = $_POST['email'] ?? '';

if (!$email) {
    echo "error";
    exit;
}

/* insert */
$stmt = $conn->prepare("INSERT INTO USER_EMAIL (email) VALUES (?)");
$stmt->bind_param("s", $email);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "error";
}

$stmt->close();
$conn->close();
?>

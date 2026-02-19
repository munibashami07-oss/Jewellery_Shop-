<?php
// Database configuration
$servername = "localhost";
$username = "root";  // Default phpMyAdmin username
$password = "";      // Default phpMyAdmin password (usually empty)
$dbname = "online_submit_feedback_db";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    // Select the database
    $conn->select_db($dbname);
    
    // Create table if it doesn't exist
    $table_sql = "CREATE TABLE IF NOT EXISTS feedback (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        category VARCHAR(50) NOT NULL,
        rating INT(1) NOT NULL,
        comments TEXT NOT NULL,
        file_name VARCHAR(255),
        file_path VARCHAR(255),
        submission_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($table_sql) === TRUE) {
        // Table created or already exists
    } else {
        echo "Error creating table: " . $conn->error;
    }
} else {
    echo "Error creating database: " . $conn->error;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $category = $conn->real_escape_string($_POST['category']);
    $rating = intval($_POST['rating']);
    $comments = $conn->real_escape_string($_POST['comments']);
    
    $file_name = NULL;
    $file_path = NULL;
    
    // Handle file upload
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == 0) {
        $allowed_types = array('jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'txt');
        $max_size = 10 * 1024 * 1024; // 10MB
        
        $file_name = $_FILES['attachment']['name'];
        $file_size = $_FILES['attachment']['size'];
        $file_tmp = $_FILES['attachment']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        if (in_array($file_ext, $allowed_types) && $file_size <= $max_size) {
            // Create uploads directory if it doesn't exist
            $upload_dir = 'uploads/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            // Generate unique filename
            $new_filename = uniqid() . '_' . $file_name;
            $file_path = $upload_dir . $new_filename;
            
            // Move uploaded file
            if (move_uploaded_file($file_tmp, $file_path)) {
                // File uploaded successfully
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to upload file']);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid file type or size']);
            exit;
        }
    }
    
    // Insert data into database
    $sql = "INSERT INTO feedback (name, email, category, rating, comments, file_name, file_path) 
            VALUES ('$name', '$email', '$category', $rating, '$comments', " . 
            ($file_name ? "'$file_name'" : "NULL") . ", " . 
            ($file_path ? "'$file_path'" : "NULL") . ")";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Feedback submitted successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
    }
    
    $conn->close();
    exit;
}

$conn->close();
?>
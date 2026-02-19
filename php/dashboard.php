<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Welcome</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 600px;
            text-align: center;
        }
        
        .success-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 20px;
        }
        
        .success-icon svg {
            width: 50px;
            height: 50px;
            fill: white;
        }
        
        h2 {
            color: #333;
            margin-bottom: 10px;
            font-size: 32px;
        }
        
        .welcome-text {
            color: #667eea;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 30px;
        }
        
        .info-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            text-align: left;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-label {
            color: #666;
            font-weight: 500;
        }
        
        .info-value {
            color: #333;
            font-weight: 600;
        }
        
        .btn {
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
            </svg>
        </div>
        
        <h2>You are now logged in!</h2>
        <p class="welcome-text">Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</p>
        
        <div class="info-box">
            <div class="info-row">
                <span class="info-label">Name:</span>
                <span class="info-value"><?php echo htmlspecialchars($_SESSION['full_name']); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Login ID:</span>
                <span class="info-value"><?php echo htmlspecialchars($_SESSION['login_id']); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Roll Number:</span>
                <span class="info-value">Roll No. <?php echo htmlspecialchars($_SESSION['roll_number']); ?></span>
            </div>
        </div>
        
        <a href="logout.php" class="btn">Logout</a>
    </div>
</body>
</html>

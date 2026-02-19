<?php
session_start();
require_once 'config.php';

$error = '';
$success = '';
$step = 1;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['verify'])) {
        // Step 1: Verify user details
        $login_id = trim($_POST['login_id']);
        $roll_number = intval($_POST['roll_number']);
        $phone_number = trim($_POST['phone_number']);
        $email = trim($_POST['email']);
        $cnic = trim($_POST['cnic']);
        
        if (empty($login_id) || empty($phone_number) || empty($email) || empty($cnic)) {
            $error = "All fields are required!";
        } else {
            // Verify all details match
            $stmt = $pdo->prepare("SELECT * FROM students WHERE login_id = ? AND roll_number = ? AND phone_number = ? AND email = ? AND cnic = ?");
            $stmt->execute([$login_id, $roll_number, $phone_number, $email, $cnic]);
            $user = $stmt->fetch();
            
            if ($user) {
                $_SESSION['reset_user_id'] = $user['id'];
                $step = 2;
            } else {
                $error = "The information provided does not match our records. Please check and try again.";
            }
        }
    } elseif (isset($_POST['reset'])) {
        // Step 2: Reset password
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        
        if (empty($new_password) || empty($confirm_password)) {
            $error = "Please enter and confirm your new password!";
            $step = 2;
        } elseif ($new_password !== $confirm_password) {
            $error = "Passwords do not match!";
            $step = 2;
        } elseif (strlen($new_password) < 6) {
            $error = "Password must be at least 6 characters long!";
            $step = 2;
        } else {
            if (isset($_SESSION['reset_user_id'])) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE students SET password = ? WHERE id = ?");
                $stmt->execute([$hashed_password, $_SESSION['reset_user_id']]);
                
                unset($_SESSION['reset_user_id']);
                $success = "Password reset successful! You can now login with your new password.";
                $step = 1;
            } else {
                $error = "Session expired. Please start over.";
                $step = 1;
            }
        }
    }
}

// Check if session exists for step 2
if (isset($_SESSION['reset_user_id']) && $step == 1) {
    $step = 2;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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
            max-width: 500px;
        }
        
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 10px;
            font-size: 28px;
        }
        
        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: 500;
        }
        
        input, select {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        
        input:focus, select:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }
        
        .alert {
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .alert-error {
            background-color: #fee;
            color: #c33;
            border: 1px solid #fcc;
        }
        
        .alert-success {
            background-color: #efe;
            color: #3c3;
            border: 1px solid #cfc;
        }
        
        .links {
            text-align: center;
            margin-top: 20px;
        }
        
        .links a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }
        
        .links a:hover {
            text-decoration: underline;
        }
        
        .step-indicator {
            text-align: center;
            margin-bottom: 20px;
            color: #667eea;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        
        <?php if ($step == 1): ?>
            <div class="step-indicator">Step 1: Verify Your Identity</div>
            <p class="subtitle">Enter all your details to verify your identity</p>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="login_id">Login ID *</label>
                    <input type="text" id="login_id" name="login_id" required autofocus>
                </div>
                
                <div class="form-group">
                    <label for="roll_number">Roll Number *</label>
                    <select id="roll_number" name="roll_number" required>
                        <option value="">Select Roll Number</option>
                        <?php for ($i = 1; $i <= 150; $i++): ?>
                            <option value="<?php echo $i; ?>">Roll No. <?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="phone_number">Phone Number *</label>
                    <input type="text" id="phone_number" name="phone_number" placeholder="03001234567" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input type="email" id="email" name="email" placeholder="student@example.com" required>
                </div>
                
                <div class="form-group">
                    <label for="cnic">CNIC *</label>
                    <input type="text" id="cnic" name="cnic" placeholder="12345-1234567-1" required>
                </div>
                
                <button type="submit" name="verify" class="btn">Verify & Continue</button>
            </form>
        <?php else: ?>
            <div class="step-indicator">Step 2: Set New Password</div>
            <p class="subtitle">Create a strong new password</p>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="new_password">New Password *</label>
                    <input type="password" id="new_password" name="new_password" placeholder="Minimum 6 characters" required autofocus>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirm New Password *</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                
                <button type="submit" name="reset" class="btn">Reset Password</button>
            </form>
        <?php endif; ?>
        
        <div class="links">
            <p><a href="login.php">Back to Login</a></p>
        </div>
    </div>
</body>
</html>

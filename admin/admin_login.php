<?php
session_start();
include '../db.php'; // Include database connection

$message = "";

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password']; 
    
    // Check credentials
    $stmt = $conn->prepare("SELECT * FROM staff WHERE email = ? AND password = ?");
    $stmt->bindParam(1, $email, PDO::PARAM_STR);
    $stmt->bindParam(2, $password, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set session variables
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_email'] = $email;
        $_SESSION['staff_id'] = $user['staff_id'];

        // Always redirect to admin.php
        header("Location: admin.php");
        exit();
    } else {
        $message = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background: white;
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: var(--primaryC3);
        }
        .login-container form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .login-container form input {
            width: 350px;
            padding: 10px;
            margin: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .login-container form button {
            width: 350px;
            margin: 30px;
            padding: 10px;
            background: #003366;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .login-container form button:hover {
            background: #00509e;
        }
        .message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if (!empty($message)) { echo "<p class='message'>$message</p>"; } ?>
        <form action="admin_login.php" method="POST">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
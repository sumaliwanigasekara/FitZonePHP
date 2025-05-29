<?php
session_start();
include 'db.php'; // Database connection

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Please log in to access settings.");
}

$user_id = $_SESSION['user_id'];
$message = "";

// Handle password change
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current-password'];
    $new_password = $_POST['new-password'];
    $confirm_password = $_POST['confirm-password'];

    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $message = "Error: All fields are required.";
    } elseif ($new_password !== $confirm_password) {
        $message = "Error: New password and confirm password do not match.";
    } else {
        // Verify current password
        $stmt = $conn->prepare("SELECT password FROM customer WHERE customer_id = ?");
        $stmt->bindParam(1, $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $password_value = $result['password'];

        if ($password_value == $current_password) {
            // Update password
            $stmt = $conn->prepare("UPDATE customer SET password = ? WHERE customer_id = ?");
            $stmt->bindParam(1, $new_password, PDO::PARAM_STR);
            $stmt->bindParam(2, $user_id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $message = "Password changed successfully!";
            } else {
                $message = "Error: Could not update password.";
            }
        } else {
            $message = "Error: Current password is incorrect.";
        }
    }
}

// Fetch the customer's name
$customer_name = null;
$stmt = $conn->prepare("SELECT customerName FROM customer WHERE customer_id = ?");
$stmt->bindParam(1, $user_id, PDO::PARAM_INT);
$stmt->execute();
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

if ($customer) {
    $customer_name = $customer['customerName'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Settings</title>
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<style>
    :root {
        --primaryC1: #ff914d;
        --primaryC2: #FFA630;
        --primaryC3: #003366;
        --primaryC4: #0474BA;
        --primaryC5: #00A7E1;
        --background-color1: #524f4f;
        --background-color2: #0c0c0c;
        --background-color3: #EBEBEB;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Nunito", sans-serif;
    }

    body {
        display: flex;
        background: var(--background-color3);
        color: var(--background-color2);
        min-height: 100vh;
    }

    .sidebar {
        width: 250px;
        background: var(--primaryC3);
        padding: 20px;
        position: fixed;
        height: 100vh;
        transition: all 0.3s ease;
    }

    .logo-container {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        padding-bottom: 10px;
        border-bottom: 1px solid var(--primaryC1);
    }

    .logo-container img {
        width: 100px;
        height: 25px
        margin-right: 10px;
    }

    .logo-text {
        font-size: 20px;
        font-weight: 700;
        color: var(--primaryC1);
    }

    .nav-menu {
        margin-top: 30px;
    }

    .nav-item {
        margin-bottom: 10px;
        list-style: none;
    }

    .nav-link {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        color: var(--background-color3);
        text-decoration: none;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .nav-link:hover, 
    .nav-link.active {
        background: var(--primaryC1);
        color: var(--background-color2);
    }

    .nav-link i {
        margin-right: 10px;
        font-size: 20px;
    }

    .header h1{
        color: var(--primaryC1);
        border-bottom: 2px solid var(--primaryC1);
        padding-bottom: 30px;
    }

    .main-content {
        margin-left: 250px;
        padding: 30px;
        width: calc(100% - 250px);
    }

    .main-content h2{
        padding-top: 20px;
        padding-bottom: 20px;
    }

    .member{
        padding-left: 55px;
        color: var(--background-color3);
        align-items: center;
    }

    .member-img {
        width: 100px;
        height: 100px;
        border-radius: 10px;
        object-fit: cover;
        margin-bottom: 20px;
        border: 2px solid var(--primaryC1);
    }

    .logout-btn {
        margin-top: 40px;
        padding: 8px 15px;
        background: var(--primaryC1);
        color: var(--background-color3);
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        margin-left: 20px;
    }

    .dashboard-container {
        display: flex;
        justify-content: space-between;
        align-items: flex-start; 
        gap: 40px; 
        max-width: 900px;
        margin: auto;
        padding: 20px;
    }

    .booking-section, .schedule-section {
        width: 45%;
        background: var(--background-color3);
        padding: 20px;
        border-radius: 10px;
        min-height: 250px;
    }

    .section-title {
        margin: 0;
        color: var(--primaryC1);
        text-align: center;
        font-size: 22px;
        padding-bottom: 10px;
    }

    .booking-form {
        width: 100%;
        max-width: 400px;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    .booking-form label {
        font-weight: bold;
        display: block;
        margin-bottom: 8px;
        color: var(--background-color2)
    }

    .booking-form select, 
    .booking-form input[type="date"] {
        width: 100%;
        padding: 12px;
        margin-bottom: 15px;
        margin-top: 5px;
        border: 1px solid var(--primaryC3);
        border-radius: 5px;
        font-size: 16px;
        background: white;
        transition: 0.3s;
    }

    .booking-form input[type="date"]:focus,
    .booking-form select:focus {
        outline: none;
    }

    table{
        margin-top: 20px;
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    th, td{
        border: 1px solid var(--primaryC1);
        padding: 10px;
        text-align: left;
    }

    th{
        background: var(--primaryC3);
        color: white;
    }

    tr:nth-child(even){
        background: #f9f9f9;
    }

    .btn-submit {
        background: var(--primaryC1);
        color:var(--background-color3);
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 10px;
    }

    .btn-submit:hover {
        background: var(--primaryC3);
    }

    .horizontal-form {
        display: flex;
        flex-direction: column; 
        gap: 20px; 
        align-items: flex-start; 
        width: 100%;
    }

    .form-row {
        display: flex;
        flex-direction: column;
        width: 500px;
    }

    .form-row label {
        font-weight: bold;
        margin-bottom: 5px;
        color: var(--background-color2);
    }

    .form-row input {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid var(--primaryC3);
        border-radius: 5px;
    }

    button[type="submit"] {
        margin-top: 20px;
        padding: 10px 20px;
        background: var(--primaryC1);
        color: var(--background-color3);
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    button[type="submit"]:hover {
        background: var(--primaryC3);
    }
    
</style>
</head>
<body>

<aside class="sidebar">
        <div class="logo-container">
            <img src="assets/LOGO.png" alt="FitZone Logo">
            <span class="logo-text">FitZone Fitness</span>
        </div>

        <div class="member">
            <h3><?php echo htmlspecialchars($customer_name); ?></h3>
        </div>
        
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="customer.php" class="nav-link">
                    <i class='bx bx-home'></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="query.php" class="nav-link">
                    <i class='bx bx-question-mark'></i>
                    <span class="nav-text">Ask a Question</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="settings.php" class="nav-link active">
                    <i class='bx bx-cog'></i>
                    <span class="nav-text">Settings</span>
                </a>
            </li>
            <li>
            </div>
            <button class="logout-btn" onclick="window.location.href='logout.php'">Logout</button>
            </div>
            </li>
        </ul>
    </aside>


<div class="main-content">
    <div class="settings-container">
        <h2>Change Password</h2>
        <?php if (!empty($message)) { echo "<p class='message'>$message</p>"; } ?>
        <form action="settings.php" method="POST" class="horizontal-form">
            <div class="form-row">
                <label for="current-password">Current Password:</label>
                <input type="password" id="current-password" name="current-password" required>
            </div>
            <div class="form-row">
                <label for="new-password">New Password:</label>
                <input type="password" id="new-password" name="new-password" required>
            </div>
            <div class="form-row">
                <label for="confirm-password">Confirm New Password:</label>
                <input type="password" id="confirm-password" name="confirm-password" required>
            </div>
            <button type="submit">Change Password</button>
        </form>
    </div>
</div>
</body>
</html>

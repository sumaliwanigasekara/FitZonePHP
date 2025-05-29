<?php
// http://localhost/FitZonePHP/admin
session_start();

// Check if the admin is already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    // Redirect to the admin dashboard
    header("Location: admin.php");
    exit();
} else {
    // Redirect to the admin login page
    header("Location: admin_login.php");
    exit();
}
?>
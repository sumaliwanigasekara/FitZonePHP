<?php
session_start();
require_once 'db.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['book_class'])) {
        // Book a class
        $stmt = $conn->prepare("INSERT INTO bookings 
                              (customer_id, program_id, day, time) 
                              VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $_SESSION['user_id'],
            $_POST['program_id'],
            $_POST['day'],
            $_POST['time']
        ]);
        header("Location: customer.php?success=booked");
        exit();
    }
    elseif (isset($_POST['cancel_booking'])) {
        // Cancel a booking
        $stmt = $conn->prepare("DELETE FROM bookings WHERE id = ? AND customer_id = ?");
        $stmt->execute([$_POST['booking_id'], $_SESSION['user_id']]);
        header("Location: customer.php?success=cancelled");
        exit();
    }
}

// Get available classes
$classes = $conn->query("SELECT * FROM programs")->fetchAll();

// Get user's bookings
$bookings = $conn->prepare("SELECT b.*, p.name as program_name 
                           FROM bookings b
                           JOIN programs p ON b.program_id = p.id
                           WHERE b.customer_id = ?");
$bookings->execute([$_SESSION['user_id']]);
$userBookings = $bookings->fetchAll();
?>
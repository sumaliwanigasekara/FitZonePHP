<?php
header('Content-Type: application/json'); // Ensure the response is JSON
require_once 'db.php';

// Disable error reporting to prevent unwanted output
error_reporting(0);
ini_set('display_errors', 0);

// Check if $conn is null (failed connection)
if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

try {
    // Get POST data
    $data = json_decode(file_get_contents('php://input'), true);

    // Validate data
    if (empty($data['name']) || empty($data['email']) || empty($data['password']) || empty($data['phone']) || empty($data['dob'])) {
        throw new Exception("All fields are required.");
    }

    // Check if the email already exists
    $checkStmt = $conn->prepare("SELECT COUNT(*) FROM customer WHERE email = :email");
    $checkStmt->bindParam(':email', $data['email']);
    $checkStmt->execute();
    $emailExists = $checkStmt->fetchColumn();

    if ($emailExists > 0) {
        throw new Exception("Email already exists. Please use a different email.");
    }

    // Prepare the SQL statement for insertion
    $stmt = $conn->prepare("INSERT INTO customer (customerName, email, password, phoneNumber, dateOfBirth, isMember)
                            VALUES (:name, :email, :password, :phone, :dob, 'Yes')");
    
    if (!$stmt) {
        throw new Exception("Failed to prepare the SQL statement: " . implode(":", $conn->errorInfo()));
    }

    // Bind the parameters to the prepared statement
    $stmt->bindParam(':name', $data['name']);
    $stmt->bindParam(':email', $data['email']);
    $stmt->bindParam(':password', $data['password']);
    $stmt->bindParam(':phone', $data['phone']);
    $stmt->bindParam(':dob', $data['dob']);
    
    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Registration successful']);
    } else {
        throw new Exception("Registration failed. Please try again.");
    }
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
} catch(Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>


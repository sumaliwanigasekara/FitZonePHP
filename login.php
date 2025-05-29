<?php
session_start();
header('Content-Type: application/json');

require_once 'db.php';

if (!$conn) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed']));
}

try {
    $data = json_decode(file_get_contents('php://input'), true);

    
    if (empty($data['email']) || empty($data['password'])) {
        throw new Exception("Email and password are required.");
    }

    // Find the user
    $stmt = $conn->prepare("SELECT * FROM customer WHERE email = :email");
    
    if (!$stmt) {
        throw new Exception("Failed to prepare the SQL statement: " . implode(":", $conn->errorInfo()));
    }

    $stmt->bindParam(':email', $data['email']);
    $stmt->execute();
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if user exists
    if (!$user) {
        throw new Exception("User not found.");
    }

    // Verify the password
    if ($data['password'] !== $user['password']) {
        throw new Exception("Incorrect password.");
    }

    session_regenerate_id(true);

    // Store user data
    $_SESSION['user_id'] = $user['customer_id'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_name'] = $user['customerName'];
    $_SESSION['logged_in'] = true;

    // Return success response with redirect URL
    echo json_encode([
        'success' => true, 
        'message' => 'Login successful',
        'redirect' => 'customer.php'
    ]);

} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
} catch(Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
<?php
session_start();
include 'db.php'; // Database connection

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Please log in to submit a query.");
}

$user_id = $_SESSION['user_id'];
$message = "";

// Handle query submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_query'])) {
    $subject = $_POST['subject'];
    $description = $_POST['description'];

    if (empty($subject) || empty($description)) {
        $message = "Error: All fields are required.";
    } else {
        // Insert query into the database
        $stmt = $conn->prepare("INSERT INTO query (customer_id, subject, description, status) VALUES (?, ?, ?, 'Open')");
        $stmt->bindParam(1, $user_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $subject, PDO::PARAM_STR);
        $stmt->bindParam(3, $description, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $message = "Query submitted successfully!";
        } else {
            $message = "Error: Could not submit query.";
        }
    }
}

// Fetch user's queries
$stmt = $conn->prepare("SELECT subject, description, status, response FROM query WHERE customer_id = ?");
$stmt->bindParam(1, $user_id, PDO::PARAM_INT);
$stmt->execute();
$queries = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
<title>Customer Queries</title>
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

    .query-container {
        display: flex;
        justify-content: space-between;
        gap: 20px;
    }

    .query-form, .query-table {
        margin-top: 30px;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        width: 48%;
    }

    .query-form h2, .query-table h2 {
        text-align: center;
        color: var(--primaryC3);
        margin-bottom: 20px;
    }

    .query-form form label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: var(--primaryC3);
    }

    .query-form form input, .query-form form textarea {
        width: 100%;
        padding: 12px;
        margin-bottom: 15px;
        border: 1px solid var(--primaryC3);
        border-radius: 5px;
        font-size: 16px;
    }

    .query-form form textarea {
        resize: none;
        height: 100px;
    }

    .query-form form input:focus, .query-form form textarea:focus {
        outline: none;
        border-color: var(--primaryC1);
        box-shadow: 0 0 5px var(--primaryC1);
    }

    .query-form form button {
        width: 100%;
        padding: 12px;
        background: var(--primaryC1);
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .query-form form button:hover {
        background: var(--primaryC3);
    }

    .query-table table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .query-table th, .query-table td {
        border: 1px solid var(--primaryC3);
        padding: 10px;
        text-align: left;
    }

    .query-table th {
        background: var(--primaryC3);
        color: white;
    }

    .query-table tr:nth-child(even) {
        background: #f9f9f9;
    }

    .message {
        text-align: center;
        margin-bottom: 15px;
        color: red;
        font-weight: bold;
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
                <a href="query.php" class="nav-link active">
                    <i class='bx bx-question-mark'></i>
                    <span class="nav-text">Ask a Question</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="settings.php" class="nav-link">
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

    <main class="main-content">
        <header class="header">
            <h1>Customer Queries</h1>
        </header>

    <div class="query-container">
        <
        <div class="query-form">
            <h2>Submit a Query</h2>
            <?php if (!empty($message)) { echo "<p class='message'>$message</p>"; } ?>
            <form action="query.php" method="POST">
                <label for="subject">Subject:</label>
                <input type="text" id="subject" name="subject" required>
                
                <label for="description">Description:</label>
                <textarea id="description" name="description" required></textarea>
                
                <button type="submit" name="submit_query">Submit</button>
            </form>
        </div>

        
        <div class="query-table">
            <h2>My Queries</h2>
            <table>
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Response</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($queries)) { ?>
                        <tr>
                            <td colspan="4">No queries found.</td>
                        </tr>
                    <?php } else {
                        foreach ($queries as $query) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($query['subject']); ?></td>
                                <td><?php echo htmlspecialchars($query['description']); ?></td>
                                <td><?php echo htmlspecialchars($query['status']); ?></td>
                                <td>
                                    <?php 
                                    if ($query['status'] === 'Replied') {
                                        echo htmlspecialchars($query['response']);
                                    } else {
                                        echo 'N/A';
                                    }
                                    ?>
                                </td>
                            </tr>
                    <?php } } ?>
                </tbody>
            </table>
        </div>
    </div>

</section>

</body>
</html>

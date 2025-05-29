<?php
session_start();
include '../db.php'; // Database connection

// Ensure staff is logged in
if (!isset($_SESSION['staff_id'])) {
    die("Please log in to access the management dashboard.");
}

// Handle reply submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['query_id'])) {
    $query_id = $_POST['query_id'];
    $response = $_POST['response'];
    $staff_id = $_SESSION['staff_id'];

    // Update the query with the response
    $stmt = $conn->prepare("
        UPDATE query 
        SET response = ?, response_date = NOW(), staff_id = ?, status = 'Replied' 
        WHERE query_id = ?
    ");
    $stmt->bindParam(1, $response, PDO::PARAM_STR);
    $stmt->bindParam(2, $staff_id, PDO::PARAM_INT);
    $stmt->bindParam(3, $query_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $message = "Response submitted successfully!";
    } else {
        $message = "Failed to submit the response.";
    }
}

// Fetch open queries
$stmt = $conn->prepare("
    SELECT q.query_id, q.subject, q.description, c.customerName 
    FROM query q 
    INNER JOIN customer c ON q.customer_id = c.customer_id 
    WHERE q.status = 'Open'
");
$stmt->execute();
$queries = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch replied queries
$repliedStmt = $conn->prepare("
    SELECT q.subject, q.description, q.response, q.response_date, c.customerName 
    FROM query q 
    INNER JOIN customer c ON q.customer_id = c.customer_id 
    WHERE q.status = 'Replied'
");
$repliedStmt->execute();
$repliedQueries = $repliedStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Queries</title>
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
        border-bottom: 1px solid var(--background-color3);
    }

    .logo-container img {
        width: 100px;
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

    .main-content {
        margin-left: 250px;
        padding: 30px;
        width: calc(100% - 250px);
    }

    .main-content h1 {
        color: var(--primaryC3);
        margin-bottom: 20px;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid var(--primaryC1);
    }

    .header h1 {
        color: var(--primaryC1);
    }

    .logout-btn {
        padding: 8px 15px;
        background: var(--primaryC1);
        color: var(--background-color3);
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    .queries-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .queries-table th, 
    .queries-table td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #f0f0f0;
    }

    .queries-table th {
        background: var(--primaryC3);
        color: white;
        font-weight: 600;
    }

    .queries-table tr:nth-child(even) {
        background: #f9f9f9;
    }

    .queries-table tr:hover {
        background: #f1f1f1;
        cursor: pointer;
    }

    .form-container {
        margin-top: 30px;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .form-container h2 {
        text-align: center;
        margin-bottom: 20px;
        color: var(--primaryC3);
    }

    .form-container form label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: var(--primaryC3);
    }

    .form-container form textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        resize: none;
        height: 150px;
    }

    .replybtn {
        padding: 8px 15px;
        background: var(--primaryC1);
        color: var(--background-color3);
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }
    .replybtn:hover {
        background: var(--primaryC2);
    }

    .form-container form button {
        width: 100%;
        padding: 10px;
        background: var(--primaryC3);
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .form-container form button:hover {
        background:var(--primaryC4);
    }

    .message {
        color: green;
        text-align: center;
        margin-bottom: 15px;
    }

    .querysubmit{
        padding: 8px 15px;
        background: var(--primaryC1);
        color: var(--background-color3);
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        }

    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="logo-container">
            <img src="..\assets\LOGO.png" alt="FitZone Logo">
            <span class="logo-text">FitZone Staff</span>
        </div>
        
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="admin.php" class="nav-link">
                    <i class='bx bx-home'></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <button class="logout-btn" onclick="window.location.href='admin_logout.php'">Logout</button>
            </li>
        </ul>
    </aside>

    <main class="main-content">
        <h1>Pending Queries</h1>
        <?php if (!empty($message)) { echo "<p class='message'>$message</p>"; } ?>
        <table class="queries-table">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Description</th>
                    <th>Customer Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($queries)) { ?>
                    <tr>
                        <td colspan="4">No open queries found.</td>
                    </tr>
                <?php } else {
                    foreach ($queries as $query) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($query['subject']); ?></td>
                            <td><?php echo htmlspecialchars($query['description']); ?></td>
                            <td><?php echo htmlspecialchars($query['customerName']); ?></td>
                            <td>
                                <button class="replybtn" onclick="showReplyForm(<?php echo $query['query_id']; ?>, '<?php echo htmlspecialchars($query['subject']); ?>', '<?php echo htmlspecialchars($query['description']); ?>')">Reply</button>
                            </td>
                        </tr>
                <?php } } ?>
            </tbody>
        </table>

        <div class="form-container" id="replyForm" style="display: none;">
            <h2>Reply to Query</h2>
            <form action="pending_queries.php" method="POST">
                <input type="hidden" id="query_id" name="query_id">
                <label for="subject">Subject:</label>
                <p id="query_subject"></p>

                <label for="description">Description:</label>
                <p id="query_description"></p>

                <label for="response">Your Response:</label>
                <textarea id="response" name="response" required></textarea>

                <button type="submit" class="querysubmit">Submit Response</button>
            </form>
        </div>

        <h1>Replied Queries</h1>
        <table class="queries-table">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Subject</th>
                    <th>Description</th>
                    <th>Response</th>
                    <th>Response Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($repliedQueries)) { ?>
                    <tr>
                        <td colspan="5">No replied queries found.</td>
                    </tr>
                <?php } else {
                    foreach ($repliedQueries as $query) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($query['customerName']); ?></td>
                            <td><?php echo htmlspecialchars($query['subject']); ?></td>
                            <td><?php echo htmlspecialchars($query['description']); ?></td>
                            <td><?php echo htmlspecialchars($query['response']); ?></td>
                            <td><?php echo htmlspecialchars($query['response_date']); ?></td>
                        </tr>
                <?php } } ?>
            </tbody>
        </table>
    </main>

    <script>
        function showReplyForm(queryId, subject, description) {
            document.getElementById('replyForm').style.display = 'block';
            document.getElementById('query_id').value = queryId;
            document.getElementById('query_subject').innerText = subject;
            document.getElementById('query_description').innerText = description;
        }
    </script>
</body>
</html>
<?php
session_start();
include '../db.php'; // Database connection

// Ensure staff is logged in
if (!isset($_SESSION['staff_id'])) {
    die("Please log in to access the management dashboard.");
}

// Fetch members from the customer table along with their package name
$stmt = $conn->prepare("
    SELECT c.customerName, c.email, c.phoneNumber, c.isMember, p.package_name 
    FROM customer c 
    LEFT JOIN package p ON c.package_id = p.package_id
");
$stmt->execute();
$members = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch total members where isMember = 1
$totalMembersStmt = $conn->prepare("SELECT COUNT(*) AS totalMembers FROM customer WHERE isMember = 1");
$totalMembersStmt->execute();
$totalMembers = $totalMembersStmt->fetch(PDO::FETCH_ASSOC)['totalMembers'];

// Fetch total open queries
$openQueriesStmt = $conn->prepare("SELECT COUNT(*) AS openQueries FROM query WHERE status = 'Open'");
$openQueriesStmt->execute();
$openQueries = $openQueriesStmt->fetch(PDO::FETCH_ASSOC)['openQueries'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitZone - Staff Dashboard</title>
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

    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-card h3 {
        color: var(--primaryC3);
        font-size: 16px;
        margin-bottom: 10px;
    }

    .stat-card p {
        font-size: 24px;
        font-weight: bold;
        color: var(--primaryC1);
    }

    .members-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .members-table th, 
    .members-table td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #f0f0f0;
    }

    .members-table th {
        background: var(--primaryC3);
        color: white;
        font-weight: 600;
    }

    .member-img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--primaryC1);
    }

    .status-active {
        color: #4CAF50;
        font-weight: bold;
    }

    .status-inactive {
        color: #f44336;
        font-weight: bold;
    }

    .action-btn {
        padding: 5px 10px;
        background: var(--primaryC1);
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        margin-right: 5px;
    }

    .schedule-container {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .weekly-schedule {
        width: 100%;
        border-collapse: collapse;
    }

    .weekly-schedule th {
        background: var(--primaryC3);
        color: white;
        padding: 12px;
        text-align: center;
    }

    .weekly-schedule td {
        padding: 12px;
        border: 1px solid #f0f0f0;
        vertical-align: top;
    }

    .class-slot {
        background: #f9f9f9;
        border-left: 4px solid var(--primaryC1);
        padding: 8px;
        margin-bottom: 8px;
        border-radius: 4px;
    }

    .class-time {
        font-weight: bold;
        color: var(--primaryC3);
    }

    .class-name {
        color: var(--primaryC1);
    }

    .class-trainer {
        font-size: 0.9em;
        color: var(--background-color1);
    }

    .dashboard-section {
        display: none;
    }

    .dashboard-section.active {
        display: block;
    }

    @media (max-width: 768px) {
        .stats-container {
            grid-template-columns: 1fr 1fr;
        }

        .sidebar {
            width: 70px;
        }

        .logo-text, .nav-text {
            display: none;
        }

        .nav-link {
            justify-content: center;
        }

        .nav-link i {
            margin-right: 0;
            font-size: 24px;
        }

        .main-content {
            margin-left: 70px;
            width: calc(100% - 70px);
        }
    }

    @media (max-width: 480px) {
        .stats-container {
            grid-template-columns: 1fr;
        }
    }

    .members-table tr:nth-child(even) {
        background: #f9f9f9;
    }

    .status-yes {
        color: #4CAF50;
        font-weight: bold;
    }

    .status-no {
        color: #f44336;
        font-weight: bold;
    }

    .search-container {
        margin-bottom: 20px;
        text-align: right;
    }

    #searchInput {
        padding: 10px;
        width: 300px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .logout-btn {
        margin-top: 50px;
        padding: 8px 15px;
        background: var(--primaryC1);
        color: var(--background-color3);
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }
    </style>
    <script>
    function filterTable() {
        const searchInput = document.getElementById('searchInput').value.toLowerCase();
        const tableBody = document.getElementById('membersTableBody');
        const rows = tableBody.getElementsByTagName('tr');

        for (let i = 0; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            let rowMatches = false;

            for (let j = 0; j < cells.length; j++) {
                if (cells[j].textContent.toLowerCase().includes(searchInput)) {
                    rowMatches = true;
                    break;
                }
            }

            rows[i].style.display = rowMatches ? '' : 'none';
        }
    }
    </script>
</head>
<body>
    <aside class="sidebar">
        <div class="logo-container">
            <img src="..\assets\LOGO.png" alt="FitZone Logo">
            <span class="logo-text">FitZone Staff</span>
        </div>
        
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="#dashboard" class="nav-link active" data-section="dashboard">
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
        <section id="dashboard" class="dashboard-section active">
            <div class="header">
                <h1>Staff Dashboard</h1>
            </div>

            <div class="stats-container">
                <div class="stat-card">
                    <h3>Total Members</h3>
                    <p><?php echo $totalMembers; ?></p>
                </div>
                <div class="stat-card" onclick="window.location.href='pending_queries.php'">
                    <h3>Pending Queries</h3>
                    <p><?php echo $openQueries; ?></p>
                </div>
            </div>

            <h2 class="section-title">User List</h2>
            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Search..." onkeyup="filterTable()" />
            </div>
            <table class="members-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Member Status</th>
                        <th>Package</th> 
                    </tr>
                </thead>
                <tbody id="membersTableBody">
                    <?php if (empty($members)) { ?>
                        <tr>
                            <td colspan="5">No members found.</td>
                        </tr>
                    <?php } else {
                        foreach ($members as $member) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($member['customerName']); ?></td>
                                <td><?php echo htmlspecialchars($member['email']); ?></td>
                                <td><?php echo htmlspecialchars($member['phoneNumber']); ?></td>
                                <td class="<?php echo $member['isMember'] ? 'status-yes' : 'status-no'; ?>">
                                    <?php echo $member['isMember'] ? 'Yes' : 'No'; ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($member['package_name'] ?? 'None'); ?> <!-- Display package name or 'None' -->
                                </td>
                            </tr>
                    <?php } } ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
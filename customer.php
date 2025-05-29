<?php
session_start();
include 'db.php'; // Database connection

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Please log in to book a class.");
}

$user_id = $_SESSION['user_id'];
$bookings = [];

// Fetch the customer's package
$package_name = null;
$stmt = $conn->prepare("
    SELECT p.package_name 
    FROM package p 
    INNER JOIN customer c ON p.package_id = c.package_id 
    WHERE c.customer_id = ?
");
$stmt->bindParam(1, $user_id, PDO::PARAM_INT);
$stmt->execute();
$package = $stmt->fetch(PDO::FETCH_ASSOC);

if ($package) {
    $package_name = $package['package_name'];
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

// Handle package purchase
if (isset($_POST['purchase_package'])) {
    $package_id = $_POST['package_id'];

    
    $stmt = $conn->prepare("UPDATE customer SET package_id = ?, isMember = 1 WHERE customer_id = ?");
    $stmt->bindParam(1, $package_id, PDO::PARAM_INT);
    $stmt->bindParam(2, $user_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Redirect to refresh the page and show the updated package
        header("Location: customer.php");
        exit();
    } else {
        $error_message = "Error purchasing package!";
    }
}

// Handle form submission and insert booking
if (isset($_POST["submit"]) && $_POST["submit"] == "1") {
    $program_id = $_POST['class'];
    $date = $_POST['date'];

    $sql = "INSERT INTO schedule (customer_id, program_id, date) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $user_id, PDO::PARAM_INT);
    $stmt->bindParam(2, $program_id, PDO::PARAM_INT);
    $stmt->bindParam(3, $date, PDO::PARAM_STR);

    if ($stmt->execute()) {
        $success_message = "Booked successfully!";
    } else {
        $error_message = "Error booking!";
    }
}

// Fetch booked classes for the user
$sql = "SELECT p.program_name, s.date FROM program p INNER JOIN schedule s ON p.program_id = s.program_id WHERE s.customer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bindParam(1, $user_id);
$stmt->execute();

$bookings = array(); // initialize an empty array
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $bookings[] = $row; // add each row to the array
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Weekly Class Schedule</title>
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

   .schedule-container {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 20px;
    }
    
    .schedule-form, .booking-table {
        background: var(--background-color3);
        margin-top: 30px;
        background: white;
        padding: 20px;
        border-radius: 10px;
        width: 48%;
    }

    .schedule-form h2, .booking-table h2 {
        margin-bottom: 20px;
        color: var(--primaryC3);
        text-align: center;
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
        padding: 20px;
    }
    
    th, td{
        border: 1px solid var(--background-color2);
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

    .package-section {
        width: 100%;
        background: var(--background-color3);
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 30px;
    }

    .package-section h2 {
        text-align: left;
        color: var(--primaryC3);
        margin-bottom: 20px;
    }

    .package-options {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        gap: 20px;
    }

    .package-card {
        background: white;
        border: 1px solid var(--primaryC1);
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        width: 200px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    .package-card h3 {
        color: var (--primaryC3);
        margin-bottom: 10px;
    }

    .package-card p {
        font-size: 16px;
        margin-bottom: 15px;
    }

    .package-card button {
        padding: 10px 15px;
        background: var(--primaryC1);
        color: var(--background-color3);
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .package-card button:hover {
        background: var(--primaryC3);
    }

    .popup {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        text-align: center;
    }

    .popup h3 {
        margin-bottom: 20px;
    }

    .popup button {
        padding: 10px 15px;
        margin: 5px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .popup .confirm {
        background: var(--primaryC1);
        color: var(--background-color3);
    }

    .popup .cancel {
        background: #ccc;
        color: #333;
    }

    .popup .confirm:hover {
        background: var(--primaryC3);
    }

    .popup .cancel:hover {
        background: #bbb;
    }

    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
    }

    .package-form {
        display: flex;
        align-items: center;
        gap: 20px;
        justify-content: flex-start;
    }

    .package-label {
        font-size: 18px;
        font-weight: bold;
        color: var(--primaryC3);
        margin-right: 10px;
    }

    .package-form select {
        width: 300px; 
        padding: 10px;
        font-size: 16px;
        border: 1px solid var (--primaryC3);
        border-radius: 5px;
        background: white;
    }

    .package-form button {
        padding: 10px 20px;
        font-size: 16px;
        background: var(--primaryC1);
        color: var(--background-color3);
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .package-form button:hover {
        background: var(--primaryC3);
    }

    .current-package {
        margin-left: 20px;
        font-size: 16px;
        font-weight: bold;
        color: var(--primaryC3);
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
                <a href="customer.php" class="nav-link active">
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
            <h1>Customer Dashboard</h1>
        </header>

      
        <div class="package-section">
            <h2>Select a Package</h2>
            <form action="customer.php" method="POST" class="package-form">
                <label for="package" class="package-label">Choose a Package:</label>
                <select name="package_id" id="package" required>
                    <option value="">-- Select Package --</option>
                    <option value="3">Basic - Rs. 1500 (Monthly)</option>
                    <option value="4">PRO - Rs. 6000 (Monthly)</option>
                    <option value="5">Couple - Rs. 10000 (Monthly)</option>
                    <option value="6">Premium - Rs. 70000 (Annual)</option>
                </select>
                <button type="button" class="btn-submit" onclick="showPackagePopup()">Buy Now</button>
                <?php if ($package_name): ?>
                    <span class="current-package">Current Package: <?php echo htmlspecialchars($package_name); ?></span>
                <?php endif; ?>
            </form>
        </div>
    
        <div class="schedule-container">
       
            <div class="schedule-form">
                <h2>Shedule Your Class</h2>
                <?php if (isset($success_message)) { echo "<p class='success'>$success_message</p>"; } ?>
                <?php if (isset($error_message)) { echo "<p class='error'>$error_message</p>"; } ?>
                <form action="customer.php" method="POST" class="booking-form">
                <label for="class" class="schedule">Select Your Program:</label><br><br>
                <select name="class" id="class" required>
                    <option value="">-- Choose Class --</option>
                    <option value="1" data-class-name="Zumba">Zumba (5 PM - 6 PM)</option>
                    <option value="2" data-class-name="Yoga">Yoga (7 AM - 8 AM)</option>
                    <option value="3" data-class-name="Nutrition Counseling">Nutrition Counseling (6 PM - 6:30 PM)</option>
                    <option value="4" data-class-name="Strength Training">Strength Training (6 AM - 8 PM)</option>
                </select><br><br>

                <label for="date">Select Date:</label><br><br>
                <input type="date" name="date" id="date" required>

                <input type="hidden" name="submit" value="1">
                <button type="submit" class="btn-submit">Book Class</button>
            </form>
        </div>
        

        <div class="booking-table">
            <h2>My Booked Classes</h2>
            <table>
                <thead>
                    <tr>
                        <th>Class</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody id="booked-classes">
                    <?php if (empty($bookings)) { ?>
                        <tr>
                            <td colspan="2">You haven't booked any classes yet</td>
                        </tr>
                    <?php } else {
                        foreach ($bookings as $booking) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($booking['program_name']); ?></td>
                                <td><?php echo htmlspecialchars($booking['date']); ?></td>
                            </tr>
                    <?php } } ?>
                </tbody>
            </table>
        </div>
</div>


</section>

<div class="overlay" id="overlay"></div>
<div class="popup" id="popup">
    <h3 id="popup-title"></h3>
    <p id="popup-description"></p>
    <form action="customer.php" method="POST">
        <input type="hidden" name="package_id" id="popup-package-id">
        <button type="submit" name="purchase_package" class="confirm">Pay</button>
        <button type="button" class="cancel" onclick="closePopup()">Cancel</button>
    </form>
</div>

<script>
    var bookings = <?php echo json_encode($bookings); ?>;
    console.log(bookings);

    // Show the dashboard section by default
    showSection("dashboard");

    function showPopup(packageId, packageName, packagePrice) {
        document.getElementById('popup-title').innerText = `Confirm Purchase: ${packageName}`;
        document.getElementById('popup-description').innerText = `You are about to purchase the ${packageName} package for ${packagePrice}.`;
        document.getElementById('popup-package-id').value = packageId;
        document.getElementById('popup').style.display = 'block';
        document.getElementById('overlay').style.display = 'block';
    }

    function closePopup() {
        document.getElementById('popup').style.display = 'none';
        document.getElementById('overlay').style.display = 'none';
    }

    function showPackagePopup() {
        const packageDropdown = document.getElementById('package');
        const selectedOption = packageDropdown.options[packageDropdown.selectedIndex];

        if (!selectedOption.value) {
            alert('Please select a package.');
            return;
        }

        const packageId = selectedOption.value;
        const packageText = selectedOption.text;

        document.getElementById('popup-title').innerText = `Confirm Purchase: ${packageText}`;
        document.getElementById('popup-description').innerText = `You are about to purchase the ${packageText}.`;
        document.getElementById('popup-package-id').value = packageId;

        document.getElementById('popup').style.display = 'block';
        document.getElementById('overlay').style.display = 'block';
    }

    function closePopup() {
        document.getElementById('popup').style.display = 'none';
        document.getElementById('overlay').style.display = 'none';
    }

</script>

</body>
</html>

<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Include the database connection file
include('../dbconnection.php'); // This includes the MySQLi connection file
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | DreamWed</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            height: 100vh;
            background-color: #f4f4f9;
        }

        /* Sidebar styling */
        .sidebar {
            width: 180px;
            height: 100%;
            background-color: #2c3e50;
            color: white;
            padding: 15px 10px;
            position: fixed;
            top: 0;
            left: 0;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .sidebar h2 {
            text-align: center;
            font-size: 20px;
            color: #fff;
            margin-bottom: 20px;
        }

        .sidebar ul {
            padding: 0;
            list-style: none;
        }

        .sidebar ul li {
            padding: 8px;
            margin-bottom: 5px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: block;
            font-size: 14px;
        }

        .sidebar ul li:hover {
            background-color: #34495e;
        }

        /* Main content styling */
        .content {
            margin-left: 180px;
            padding: 20px;
            width: calc(100% - 180px);
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        .header {
            background-color: #ff7f50;
            color: white;
            padding: 12px;
            text-align: center;
            font-size: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        /* Content and paragraph styling */
        .content p {
            font-size: 14px;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .dashboard-cards {
            display: flex;
            gap: 15px;
            justify-content: center;  
            margin-top: 15px;
            width: 60rem;  
            margin: 0 auto;  
        }

        .card {
            background-color: #fff;
            border-radius: 8px;
            padding: 15px;
            flex: 1;
            min-width: 160px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        .card h4 {
            font-size: 16px;
            margin-bottom: 10px;
            color: #333;
        }

        .card p {
            font-size: 14px;
            color: #555;
        }

        .footer {
            text-align: center;
            background-color: #f8f8f8;
            padding: 10px;
            font-size: 12px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="#">Dashboard</a></li>
            <li><a href="manage_portfolio.php">Manage Portfolio</a></li>
            <li><a href="manage_pricing.php">Manage Pricing</a></li>
            <li><a href="view_contacts.php">View Contacts</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="header">Welcome to DreamWed Admin Panel</div>
        <p>Manage your wedding planner website content here. Below are the details you can manage from this admin panel.</p>

        <!-- Dashboard Cards -->
        <div class="dashboard-cards">
        <?php
// SQL queries to count records in each table
$portfolioQuery = "SELECT COUNT(*) FROM portfolio"; // Table name is portfolio
$pricingQuery = "SELECT COUNT(*) FROM pricing_plans"; // Table name is pricing_plans
$contactsQuery = "SELECT COUNT(*) FROM contact_form"; // Table name is contact_form

// Execute the queries
$portfolioResult = $conn->query($portfolioQuery);
$pricingResult = $conn->query($pricingQuery);
$contactsResult = $conn->query($contactsQuery);

// Check if queries are successful and fetch data
if ($portfolioResult && $pricingResult && $contactsResult) {
    // Fetch and store the counts for each
    $portfolioCount = $portfolioResult->fetch_row()[0];
    $pricingCount = $pricingResult->fetch_row()[0];
    $contactsCount = $contactsResult->fetch_row()[0];
} else {
    // Display error if any query fails
    echo "<p>Error fetching data: " . $conn->error . "</p>";
    $portfolioCount = $pricingCount = $contactsCount = 0;
}
?>

            <div class="card">
                <h4>Manage Portfolio</h4>
                <p><?php echo $portfolioCount; ?> Items</p>
            </div>
            <div class="card">
                <h4>Manage Pricing</h4>
                <p><?php echo $pricingCount; ?> Plans</p>
            </div>
            <div class="card">
                <h4>View Contacts</h4>
                <p><?php echo $contactsCount; ?> Messages</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        &copy; 2025 DreamWed. All rights reserved.
    </div>

</body>
</html>

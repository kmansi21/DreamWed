<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Include the database connection file
include '../dbconnection.php'; // Adjust the path if necessary

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch contacts from the contact_form table
$query = "SELECT * FROM contact_form";  // Using the correct table name 'contact_form'
$result = mysqli_query($conn, $query);

if (!$result) {
    // Query failed, output the error
    die("Query failed: " . mysqli_error($conn));
}

// Approve contact (when Approve button is clicked)
if (isset($_GET['approve_id'])) {
    $approve_id = $_GET['approve_id'];
    $update_query = "UPDATE contact_form SET status = 'Approved' WHERE id = $approve_id";
    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Customer approved!'); window.location.href='view_contacts.php';</script>";
    } else {
        echo "Error updating status: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Contacts | DreamWed</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Your existing styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            display: flex;
            height: 100vh;
        }

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
            padding: 15px;
            text-align: center;
            font-size: 20px;
            margin-bottom: 30px;
            border-radius: 5px;
        }

        .footer {
            text-align: center;
            background-color: #f8f8f8;
            padding: 10px;
            font-size: 14px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        table {
            width: 80%;
            margin-left: 10rem;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #f1f1f1;
            font-weight: bold;
        }

        table tr:hover {
            background-color: #f9f9f9;
        }

        .btn-approve,
        .btn-delete {
            background-color: #ff7f50;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .btn-approve:hover,
        .btn-delete:hover {
            background-color: #e67e22;
        }

        .approved {
            background-color: #27ae60;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
        }

        .btn-delete {
            background-color: #e74c3c;
            margin-left: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Admin Panel</h2>
            <ul>
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="manage_portfolio.php">Manage Portfolio</a></li>
                <li><a href="manage_pricing.php">Manage Pricing</a></li>
                <li><a href="view_contacts.php">View Contacts</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="content">
            <div class="header">View Contacts</div>
           

            <!-- Contact Records -->
            <div class="contact-container">
                <table class="contact-table">
                    <thead>
                        <tr>
                            <th>Email</th>
                            
                            <th>Number</th> <!-- Added the number column -->
                            <th>Address</th>
                            <th>Plan</th>
                            <th>Message</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo isset($row['number']) ? htmlspecialchars($row['number']) : 'N/A'; ?></td> <!-- Display number -->
                                <td><?php echo isset($row['address']) ? htmlspecialchars($row['address']) : 'N/A'; ?></td> <!-- Display address -->
                                <td><?php echo isset($row['plan']) ? htmlspecialchars($row['plan']) : 'N/A'; ?></td> <!-- Display plan -->
                                <td><?php echo htmlspecialchars($row['message']); ?></td>
                                <td>
                                    <?php if ($row['status'] !== 'Approved') { ?>
                                        <a href="view_contacts.php?approve_id=<?php echo $row['id']; ?>" class="btn-approve">Approve</a>
                                    <?php } else { ?>
                                        <span class="approved">Approved</span>
                                    <?php } ?>
                                    <a href="delete_contact.php?id=<?php echo $row['id']; ?>" class="btn-delete">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        &copy; 2025 DreamWed. All rights reserved.
    </div>
</body>

</html>

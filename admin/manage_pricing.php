<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

@include '../dbconnection.php';

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update pricing plan
    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $price = $_POST['price'];
        $features = mysqli_real_escape_string($conn, $_POST['features']);

        $updateQuery = "UPDATE pricing_plans SET name='$name', price='$price', features='$features' WHERE id='$id'";

        if (mysqli_query($conn, $updateQuery)) {
            echo "<script>alert('Pricing Plan Updated Successfully');</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
    }

    // Delete pricing plan
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];

        $deleteQuery = "DELETE FROM pricing_plans WHERE id='$id'";

        if (mysqli_query($conn, $deleteQuery)) {
            echo "<script>alert('Pricing Plan Deleted Successfully');</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
    }
}

$query = "SELECT * FROM pricing_plans";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Pricing Plans | Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
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

        /* Table styling */
        .pricing-table {
            width: 80%;
            margin-left: 10rem;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .pricing-table th,
        .pricing-table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .pricing-table th {
            background-color: #f1f1f1;
        }

        .pricing-table tr:hover {
            background-color: #f9f9f9;
        }

        .btn-update,
        .btn-delete,
        .btn-add {
            background-color: #ff7f50;
            color: white;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .btn-update:hover,
        .btn-delete:hover,
        .btn-add:hover {
            background-color: #e67e22;
        }

        /* Add Pricing Plan Button */
        .btn-add {
            margin: 20px 0;
            width: 200px;
            margin-left: 2rem;
            text-align: center;
        }

        /* Modal content styling */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            transition: opacity 0.3s ease;
        }

        .modal-content {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            width: 450px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
            animation: fadeIn 0.5s ease;
            position: relative;
        }

        .close {
            color: #aaa;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
            position: absolute;
            top: 10px;
            right: 15px;
        }

        .close:hover,
        .close:focus {
            color: #333;
        }

        h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        button[type="submit"] {
            background-color: #ff7f50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #e67e22;
        }

        /* Modal animation */
        @keyframes fadeIn {
            0% {
                transform: scale(0.8);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
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
        <div class="header">Manage Pricing Plans</div>

        <button class="btn-add" onclick="showAddForm()">Add New Pricing Plan</button>

        <table class="pricing-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Features</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['name']); ?></td>
                        <td>$<?= number_format($row['price'], 2); ?>/-</td>
                        <td><?= htmlspecialchars($row['features']); ?></td>
                        <td>
                            <button class="btn-update" onclick="showUpdateForm(<?= $row['id']; ?>, '<?= htmlspecialchars($row['name']); ?>', <?= $row['price']; ?>, '<?= htmlspecialchars($row['features']); ?>')">Edit</button>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                <button type="submit" name="delete" class="btn-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Add Pricing Plan Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeAddModal()">&times;</span>
            <h2>Add New Pricing Plan</h2>
            <form method="POST">
                <label for="add-name">Name:</label>
                <input type="text" id="add-name" name="name" required>

                <label for="add-price">Price ($):</label>
                <input type="number" id="add-price" name="price" required>

                <label for="add-features">Features:</label>
                <textarea id="add-features" name="features" required></textarea>

                <button type="submit" name="add" class="btn-update">Add Pricing Plan</button>
            </form>
        </div>
    </div>

    <!-- Update Pricing Plan Modal -->
    <div id="updateModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeUpdateModal()">&times;</span>
            <h2>Update Pricing Plan</h2>
            <form method="POST">
                <input type="hidden" id="update-id" name="id">

                <label for="update-name">Name:</label>
                <input type="text" id="update-name" name="name" required>

                <label for="update-price">Price ($):</label>
                <input type="number" id="update-price" name="price" required>

                <label for="update-features">Features:</label>
                <textarea id="update-features" name="features" required></textarea>

                <button type="submit" name="update" class="btn-update">Update Pricing Plan</button>
            </form>
        </div>
    </div>

    <script>
        // Show add modal
        function showAddForm() {
            document.getElementById("addModal").style.display = "flex";
        }

        // Close add modal
        function closeAddModal() {
            document.getElementById("addModal").style.display = "none";
        }

        // Show update modal
        function showUpdateForm(id, name, price, features) {
            document.getElementById("update-id").value = id;
            document.getElementById("update-name").value = name;
            document.getElementById("update-price").value = price;
            document.getElementById("update-features").value = features;
            document.getElementById("updateModal").style.display = "flex";
        }

        // Close update modal
        function closeUpdateModal() {
            document.getElementById("updateModal").style.display = "none";
        }
    </script>

</body>

</html>

<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

include '../dbconnection.php'; // Include the database connection file

// Fetch portfolio items from the database
$query = "SELECT * FROM portfolio";
$result = mysqli_query($conn, $query);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Delete portfolio item
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];

        $deleteQuery = "DELETE FROM portfolio WHERE id='$id'";
        if (mysqli_query($conn, $deleteQuery)) {
            echo "<script>alert('Portfolio Item Deleted Successfully'); window.location.href='manage_portfolio.php';</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
    }

    // Add new portfolio item
    if (isset($_POST['add'])) {
        $title = mysqli_real_escape_string($conn, $_POST['title']);

        // File upload handling
        $image = $_FILES['image']['name'];
        $targetDir = "../images/"; // Make sure 'images' folder exists in admin directory
        $imagePath = $targetDir . basename($image);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            // Save the relative path for database
            $relativeImagePath = "images/" . basename($image);

            $addQuery = "INSERT INTO portfolio (title, image_url) VALUES ('$title', '$relativeImagePath')";
            if (mysqli_query($conn, $addQuery)) {
                echo "<script>alert('Portfolio Item Added Successfully'); window.location.href='manage_portfolio.php';</script>";
            } else {
                echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
            }
        } else {
            echo "<script>alert('Error uploading image');</script>";
        }
    }

    // Update portfolio item
    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $oldImage = $_POST['old_image'];

        // Handle new image upload if provided
        if (!empty($_FILES['image']['name'])) {
            $image = $_FILES['image']['name'];
            $targetDir = "../images/";
            $imagePath = $targetDir . basename($image);
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
            $relativeImagePath = "images/" . basename($image);
        } else {
            $relativeImagePath = $oldImage; // Keep old image if no new one is uploaded
        }

        $updateQuery = "UPDATE portfolio SET title='$title', image_url='$relativeImagePath' WHERE id='$id'";
        if (mysqli_query($conn, $updateQuery)) {
            echo "<script>alert('Portfolio Item Updated Successfully'); window.location.href='manage_portfolio.php';</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Portfolio | DreamWed</title>
    <style>
        /* Body Styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            height: 100vh;
            background-color: #f4f4f9;
        }

        /* Sidebar Styling */
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
            margin-left: 160px;
            padding: 20px;
            width: calc(100% - 200px);
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

        .portfolio-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-evenly;
        }

        .portfolio-item {
            background-color: #f9f9f9;
            width: 30%;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            text-align: center;
            margin-top: 2rem;
            transition: transform 0.3s ease;
        }

        .portfolio-item:hover {
            transform: scale(1.05);
        }

        .portfolio-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .portfolio-item button {
            background-color: #ff7f50;
            color: white;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .portfolio-item button:hover {
            background-color: #e67e22;
        }

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
        z-index: 999; /* Ensure the modal appears above other elements */
    }

    .modal-content {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        width: 400px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
        position: relative; /* To position the close button */
    }

    .modal-content h2 {
        text-align: center;
        margin-bottom: 15px;
    }

    .modal-content label {
        display: block;
        margin-bottom: 8px;
    }

    .modal-content input,
    .modal-content textarea {
        width: 100%;
        padding: 8px;
        margin-bottom: 15px;
        border-radius: 5px;
        border: 1px solid #ddd;
    }

    .modal-content button {
        background-color: #ff7f50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        width: 100%;
    }

    .modal-content button:hover {
        background-color: #e67e22;
    }
    .btn-add {
            background-color: #ff7f50;
            color: white;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 14px;
            margin-left: 5rem;
            transition: background-color 0.3s ease;
        }
        .btn-add:hover{
            background-color: #e67e22;
        }
    .close {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 30px; /* Increase size */
        color: #aaa;
        cursor: pointer;
        transition: color 0.3s ease;
        z-index: 1000; /* Ensure the close button is above other elements */
    }

    .close:hover {
        color: #e74c3c; /* Red color on hover */
    }

       
    </style>
</head>

<body>

    <div class="container">
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

        <div class="content">
            <div class="header">Manage Your Portfolio</div>

            <button class="btn-add" onclick="showAddForm()">Add New Portfolio Item</button>

            <div class="portfolio-container">
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    // Fetch the image path directly from the database
                    $imagePath = $row['image_url']; // This will be 'images/port1.jpg'
                    $correctImagePath = '../' . $imagePath; // Add '../' to go one directory up
                ?>
                    <div class="portfolio-item">
                        <img src="<?php echo $correctImagePath; ?>" alt="<?php echo $row['title']; ?>">
                        <h4><?php echo htmlspecialchars($row['title']); ?></h4>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="delete" class="btn-delete">Delete</button>
                        </form>
                        <button onclick="showUpdateForm(<?php echo $row['id']; ?>, '<?php echo $row['title']; ?>', '<?php echo $row['description']; ?>', '<?php echo $row['image_url']; ?>')">Edit</button>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

   <!-- Add Portfolio Item Modal -->
<div id="addModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeAddModal()">&times;</span>
        <h2>Add New Portfolio Item</h2>
        <form method="POST" enctype="multipart/form-data">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required >

            <label for="image">Image:</label>
            <input type="file" id="image" name="image" accept="image/*" required>

            <button type="submit" name="add" class="btn-update">Add Portfolio Item</button>
        </form>
    </div>
</div>

   <!-- Update Portfolio Item Modal -->
<div id="updateModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeUpdateModal()">&times;</span>
        <h2>Update Portfolio Item</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" id="update-id" name="id">

            <label for="update-title">Title:</label>
            <input type="text" id="update-title" name="title" required>

            <label for="update-image">Image:</label>
            <input type="file" id="update-image" name="image" accept="image/*" required>
            <input type="hidden" id="old-image" name="old_image">

            <button type="submit" name="update" class="btn-update">Update Portfolio Item</button>
        </form>
    </div>
</div>

    <script>
        function showAddForm() {
            document.getElementById("addModal").style.display = "flex";
        }

        function closeAddModal() {
            document.getElementById("addModal").style.display = "none";
        }

        function showUpdateForm(id, title, description, image_url) {
            document.getElementById("update-id").value = id;
            document.getElementById("update-title").value = title;
            document.getElementById("old-image").value = image_url;

            // Preload the image path into the modal
            const imagePath = image_url; 
            document.getElementById("update-image").value = '';

            document.getElementById("updateModal").style.display = "flex";
        }

        function closeUpdateModal() {
            document.getElementById("updateModal").style.display = "none";
        }
    </script>
</body>

</html>

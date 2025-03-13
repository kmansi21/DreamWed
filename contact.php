<?php
include 'dbconnection.php';

if(isset($_POST['send'])) {
    // Sanitize and validate form inputs
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $number = filter_var($_POST['number'], FILTER_SANITIZE_NUMBER_INT);
    $plan = filter_var($_POST['plan'], FILTER_SANITIZE_STRING);
    $address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
    $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

    // Validate if fields are empty
    if (empty($name) || empty($email) || empty($number) || empty($plan) || empty($address) || empty($message)) {
        echo "Error: All fields are required!";
    } 
    // Validate email format (like Gmail)
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Error: Invalid email format!";
    } 
    // Validate phone number (should be exactly 10 digits, numeric)
    elseif (strlen($number) != 10 || !is_numeric($number)) {
        echo "Error: Invalid phone number! It should be 10 digits.";
    } 
    // Validate address (should not contain any numbers)
    elseif (preg_match('/\d/', $address)) {
        echo "Error: Address should not contain any numbers!";
    } 
    // Validate message (should not contain any numbers)
    elseif (preg_match('/\d/', $message)) {
        echo "Error: Message should not contain any numbers!";
    } 
    // Insert data into the database
    else {
        $stmt = $conn->prepare("INSERT INTO contact_form (name, email, number, plan, address, message) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $email, $number, $plan, $address, $message);

        if ($stmt->execute()) {
            // Trigger popup and clear form data on page load
            echo "<script>
                    window.onload = function() { 
                        showPopup(); 
                        document.getElementById('contactForm').reset();
                        window.history.replaceState(null, null, window.location.href); // Prevent resubmission warning
                    }
                  </script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
    <style>
        /* Popup container */
        .popup {
            display: none; /* Hidden by default */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Transparent background */
            z-index: 9999;
        }

        /* Popup content box */
        .popup-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 450px;
        }

        /* Close button */
        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            color: #5a5a5a;
            cursor: pointer;
        }

        /* Title for the popup */
        .popup-content h2 {
            font-size: 26px;
            color: #222;
            margin-bottom: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Message style */
        .popup-content p {
            font-size: 18px;
            color: #222;
            line-height: 1.6;
        }

        /* Accent color */
        .popup-content .accent {
            color: #daa520; /* Elegant wedding-themed color */
            font-weight: bold;
        }

        /* Optional animation for popup */
        /* @keyframes fadeIn {
            0% { opacity: 0; transform: scale(0.9); }
            100% { opacity: 1; transform: scale(1); }
        } */

        .popup-content {
            animation: fadeIn 0.4s ease-out;
        }

        /* Error messages and input highlights */
        .error-message {
            color: red;
            font-size: 14px;
            display: none;
        }

        .invalid-input {
            border-color: red;
        }
    </style>
</head>
<body>

<div class="container">
    <?php @include 'header.php';?>

    <section class="contact">
        <h1 class="heading">Contact Us</h1>

        <form id="contactForm" action="contact.php" method="post" onsubmit="return validateForm()"> 
            <div class="flex">
                <div class="inputbox">
                    <span>Your Name</span>
                    <input type="text" id="name" placeholder="Enter your name" name="name" required>
                    <div class="error-message" id="nameError">Please enter a valid name (only letters and spaces).</div>
                </div>

                <div class="inputbox">
                    <span>Your Email</span>
                    <input type="email" id="email" placeholder="Enter your email" name="email" required>
                    <div class="error-message" id="emailError">Please enter a valid email address.</div>
                </div>

                <div class="inputbox">
                    <span>Your Number</span>
                    <input type="text" id="number" placeholder="Enter your number" name="number" required>
                    <div class="error-message" id="numberError">Please enter a valid phone number (10 digits).</div>
                </div>

                <div class="inputbox">
                    <span>Choose Plan</span>
                    <select name="plan" required>
                        <option value="basic">Basic Plan</option>
                        <option value="premium">Premium Plan</option>
                        <option value="ultimate">Ultimate Plan</option>
                    </select>
                </div>

                <div class="inputbox">
                    <span>Your Address</span>
                    <textarea id="address" name="address" placeholder="Enter your address" required cols="30" rows="5"></textarea>
                    <div class="error-message" id="addressError">Address should not contain any numbers.</div>
                </div>

                <div class="inputbox">
                    <span>Your Message</span>
                    <textarea id="message" name="message" placeholder="Enter your message" required cols="30" rows="5"></textarea>
                    <div class="error-message" id="messageError">Message should not contain any numbers.</div>
                </div>
            </div>

            <input type="submit" value="Send Message" name="send" class="btn">
        </form>
    </section>

    <?php @include 'footer.php';?>
</div>

<!-- Modal Popup -->
<div class="popup" id="popup">
    <div class="popup-content">
        <span class="close" onclick="closePopup()">&times;</span>
        <h2>Thank you for reaching out! 💖</h2>
        <p>We’re thrilled to assist you in planning your dream wedding. 💍 Our team will contact you soon to discuss the next steps.</p>
        <p class="accent">Wishing you all the best in your wedding preparations! 🌸</p>
    </div>
</div>

<script>
    // Show the popup when the form is successfully submitted
    function showPopup() {
        document.getElementById('popup').style.display = 'block';
    }

    // Close the popup when the close button is clicked
    function closePopup() {
        document.getElementById('popup').style.display = 'none';
    }

    // Client-side validation (Gmail-like)
    function validateForm() {
        let isValid = true;

        // Clear previous error messages and highlights
        document.querySelectorAll('.error-message').forEach((el) => el.style.display = 'none');
        document.querySelectorAll('.invalid-input').forEach((el) => el.classList.remove('invalid-input'));

        // Validate name (letters and spaces only)
        var name = document.getElementById('name').value;
        if (!name || !/^[A-Za-z\s]+$/.test(name)) {
            document.getElementById('nameError').style.display = 'block';
            document.getElementById('name').classList.add('invalid-input');
            isValid = false;
        }

        // Validate email format
        var email = document.getElementById('email').value;
        if (!email || !/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(email)) {
            document.getElementById('emailError').style.display = 'block';
            document.getElementById('email').classList.add('invalid-input');
            isValid = false;
        }

        // Validate number (10 digits)
        var number = document.getElementById('number').value;
        if (!number || number.length !== 10 || isNaN(number)) {
            document.getElementById('numberError').style.display = 'block';
            document.getElementById('number').classList.add('invalid-input');
            isValid = false;
        }

        // Validate address (no numbers)
        var address = document.getElementById('address').value;
        if (/\d/.test(address)) {
            document.getElementById('addressError').style.display = 'block';
            document.getElementById('address').classList.add('invalid-input');
            isValid = false;
        }

        // Validate message (no numbers)
        var message = document.getElementById('message').value;
        if (/\d/.test(message)) {
            document.getElementById('messageError').style.display = 'block';
            document.getElementById('message').classList.add('invalid-input');
            isValid = false;
        }

        return isValid; // Allow form submission if valid
    }
</script>

</body>
</html>

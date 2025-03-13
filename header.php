<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Responsive Navbar</title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
 <link rel="stylesheet" href="style.css">
</head>
<body>
  <section class="header">
    <a href="home.php" class="logo">DreamWed<span class="noto--ring"></span></a>
    <nav class="navbar">
      <a href="home.php">Home</a>
      <a href="about.php">About</a>
      <a href="portfolio.php">Portfolio</a>
      <a href="pricing.php">Pricing</a>
      <a href="Contact.php">Contact</a>
      <a href="admin/admin_login.php">Admin</a>
    </nav>
    <div id="menu-btn" class="fas fa-bars"></div>
  </section>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
        // Get the current page filename without query parameters
        let currentPage = window.location.pathname.split("/").pop().toLowerCase();

        if (currentPage === "") {
            currentPage = "home.php"; // Default to home if no file is found (optional)
        }

        // Select all navbar links
        const navLinks = document.querySelectorAll(".navbar a");

        navLinks.forEach(link => {
            // Extract only the filename from the link's href (ignoring the full URL)
            const linkPage = link.getAttribute("href").split("/").pop().toLowerCase();

            // Check if the href matches the current page
            if (currentPage === linkPage) {
                link.classList.add("active-link"); // Apply active class
            }
        });
    });

    // Navbar Toggle
    const menu = document.querySelector("#menu-btn");
    const navbar = document.querySelector(".header .navbar");

    menu.onclick = () => {
        menu.classList.toggle("fa-times");
        navbar.classList.toggle("active");
    };

    // Close navbar on scroll
    window.onscroll = () => {
        menu.classList.remove("fa-times");
        navbar.classList.remove("active");
    };
</script>


 
</body>
</html>

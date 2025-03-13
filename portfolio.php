<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portfolio</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.4.0/css/lightgallery.min.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css">
</head>

<body>

  <div class="container">
    <?php @include 'header.php'; ?>

    <section class="portfolio">
      <h1 class="heading">Our Portfolio</h1>

      <div class="portfolio-container">
        <?php
        // Include the database connection
        @include 'dbconnection.php'; // Adjust the path if necessary

        // Fetch portfolio data from the database
        $query = "SELECT * FROM portfolio";
        $result = mysqli_query($conn, $query);

        // Check if the query was successful
        if ($result) {
            // Loop through each portfolio item and display it
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
          <a href="<?php echo $row['image_url']; ?>" class="box">
            <div class="image">
              <img src="<?php echo $row['image_url']; ?>" alt="">
            </div>
            <h3><?php echo htmlspecialchars($row['title']); ?></h3>
          </a>
        <?php
            }
        } else {
            echo "<p>No portfolio items found.</p>";
        }
        ?>
      </div>
    </section>

    <?php @include 'footer.php'; ?>
  </div>

  <!-- Load jQuery first -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

  <!-- Load lightGallery -->
  <script src="https://cdn.jsdelivr.net/npm/lightgallery@1.6.0/js/lightgallery.min.js"></script>

  <!-- Load Swiper -->
  <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

  <!-- Custom Script -->
  <script src="script.js"></script>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      // Check if lightGallery is available
      if (typeof lightGallery !== 'undefined') {
        console.log("lightGallery is loaded");
        lightGallery(document.querySelector('.portfolio-container'));
      } else {
        console.error("lightGallery is not defined");
      }
    });
  </script>

</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>about</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css">
</head>

<body>

  <div class="container">
    <?php @include 'header.php'; ?>
    <section class="about">
      <img src="images/about us.jpg" alt="">
      <h3>about us</h3>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Expedita suscipit similique deserunt! Dolorum, tenetur aperiam iste harum impedit quae dolorem quos aspernatur possimus vel, asperiores voluptas iusto nemo. Aliquid, saepe.</p>

      <a href="contact.php" class="btn">Contact Us</a>

    </section>


    <section class="team">
      <h1 class="heading">our team</h1>
      <div class="box-container">
        <div class="box">
          <img src="images/team1.jpg" alt="">
          <h3>lyla smith</h3>
          <p>wedding planner</p>
          <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
          </div>
        </div>

        <div class="box">
          <img src="images/team3.jpg" alt="">
          <h3>eden williams </h3>
          <p>wedding planner</p>
          <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
          </div>
        </div>

        <div class="box">
          <img src="images/team2.jpg" alt="">
          <h3>Amelie miller</h3>
          <p>wedding planner</p>
          <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
          </div>
        </div>

        <div class="box">
          <img src="images/team4.jpg" alt="">
          <h3>iris walker</h3>
          <p>wedding planner</p>
          <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
          </div>
        </div>


      </div>
    </section>

    <?php @include 'footer.php'; ?>
  </div>













  <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
  <script src="script.js"></script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>home</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css">
</head>

<body>

  <div class="container">
    <?php @include 'header.php'; ?>

    <section class="home">
      <div class="swiper home-slider">
        <div class="swiper-wrapper">

          <div class="swiper-slide slide" style="background: url(images/wedding1.jpeg) no-repeat;">
            <div class="content">
              <h3>plan your wedding!</h3>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maiores, vitae voluptas debitis et inventore dolore vel deleniti veritatis, est omnis pariatur dicta aliquam doloremque porro. Consequuntur possimus autem omnis nam?</p>
              <a href="about.php" class="btn">discover more</a>
            </div>

          </div>

          <div class="swiper-slide slide" style="background: url(images/wedding2.jpg) no-repeat;">
            <div class="content">
              <h3>plan your wedding!</h3>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maiores, vitae voluptas debitis et inventore dolore vel deleniti veritatis, est omnis pariatur dicta aliquam doloremque porro. Consequuntur possimus autem omnis nam?</p>
              <a href="about.php" class="btn">discover more</a>
            </div>

          </div>
          <div class="swiper-slide slide" style="background: url(images/wedding3.jpg) no-repeat;">
            <div class="content">
              <h3>plan your wedding!</h3>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maiores, vitae voluptas debitis et inventore dolore vel deleniti veritatis, est omnis pariatur dicta aliquam doloremque porro. Consequuntur possimus autem omnis nam?</p>
              <a href="about.php" class="btn">discover more</a>
            </div>

          </div>
        </div>

        <div class="swiper-pagination"></div>

      </div>
    </section>
    <section class="services">
      <h1 class="heading">our services</h1>
      <div class="swiper service-slider">
        <div class="swiper-wrapper">
          <div class="swiper-slide slide">
            <img src="images/service1.jpg" alt="">
            <div class="content">
              <h3>photography</h3>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem, ipsum.</p>
              <a href="about.php" class="btn">about us</a>
            </div>
          </div>
          <div class="swiper-slide slide">
            <img src="images/service2.jpg" alt="">
            <div class="content">
              <h3>wedding registry</h3>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Qui, magnam.</p>
              <a href="about.php" class="btn">about us</a>
            </div>
          </div>
          <div class="swiper-slide slide">
            <img src="images/service3.jpg" alt="">
            <div class="content">
              <h3>guest list</h3>
              <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Odio, debitis.</p>
              <a href="about.php" class="btn">about us</a>
            </div>
          </div>
          <div class="swiper-slide slide">
            <img src="images/service4.jpg" alt="">
            <div class="content">
              <h3>wedding cake</h3>
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim, vitae.</p>
              <a href="about.php" class="btn">about us</a>
            </div>
          </div>
          <div class="swiper-slide slide">
            <img src="images/service5.jpg" alt="">
            <div class="content">
              <h3>wedding ceremony</h3>
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam, facilis?</p>
              <a href="about.php" class="btn">about us</a>
            </div>
          </div>
          <div class="swiper-slide slide">
            <img src="images/service6.jpg" alt="">
            <div class="content">
              <h3>fine dining </h3>
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus, iste.</p>
              <a href="about.php" class="btn">about us</a>
            </div>
          </div>

        </div>

        <div class="swiper-pagination"></div>

      </div>


    </section>




    <?php @include 'footer.php'; ?>
  </div>













  <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
  <script src="script.js"></script>
</body>

</html>
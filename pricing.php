<?php
@include 'dbconnection.php';

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
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
    <title>Pricing</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <?php @include 'header.php'; ?>

    <section class="pricing">
        <h1 class="heading">Our Pricing</h1>
        <div class="box-container">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="box">
                    <h3><?= htmlspecialchars($row['name']); ?></h3>
                    <div class="price">$<?= number_format($row['price'], 2); ?>/-</div>
                    <div class="list">
                        <?php
                        $features = explode(',', $row['features']);
                        foreach ($features as $feature) {
                            echo "<p><i class='fas fa-check'></i> " . htmlspecialchars(trim($feature)) . "</p>";
                        }
                        ?>
                    </div>
                    <a href="contact.php" class="btn">Choose Plan</a>
                </div>
            <?php } ?>
        </div>
    </section>

    <?php @include 'footer.php'; ?>
</div>

</body>
</html>

<?php
include('includes/global.php');
require('includes/connection.php');
$query = "SELECT * FROM products WHERE featured = 1";
$mainsql = mysqli_query($connection,$query);        

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <title>Wild Rose Foundry || WildRose.com</title>
    <?php include('includes/links.php');?>
</head>
<body>
    <?php include('includes/header.php');?>
    <main>
        <div class="container" id="container">
            <p class="featuretag">Featured Items</p>
            <ul id ="carousel">
                <?php
                //Pull all featured items
                    while($featured = mysqli_fetch_assoc($mainsql)){
                        $vendorid = $featured['vendor_id'];
                        $vendor_query = "SELECT name FROM vendors WHERE vendor_id = $vendorid";
                        $vendor = mysqli_fetch_assoc(mysqli_query($connection,$vendor_query));
                ?>
                <li class="products">
                    <a href="details.php?id=<?php echo $featured['product_id'];?>">
                        <img src="media/<?php echo $featured['image']?>" alt="<?php echo $featured['img_alt']?>">
                        <div>
                            <h2><? echo $featured['name']; ?></h2>
                            <p><? echo $featured['price']; ?></p>
                            <p><? echo $vendor['name']; ?></p>
                        </div>
                    </a>
                </li>
                <?php
                    }
                ?>
            </ul>
        </div>
        <p class="card about">Nestled in the heart of Alberta, Wild Rose Foundry is a modern artisan collective celebrating the creativity and craftsmanship of local makers. Every weekend, its converted warehouse space buzzes with energy — filled with pottery, jewelry, textiles, candles, and small-batch foods crafted by independent vendors from across the province. Shoppers come for the quality and stay for the sense of community, discovering new makers every visit. The foundry has one location in Diamond Valley right now, but hopes to expand to multiple locations across the province by 2028.</p>
    </main>
    <?php include('includes/footer.php');?>
    <script src='https://cdn.jsdelivr.net/npm/temporal-polyfill@0.3.0/global.min.js'></script>
    <script src="script/carousel.js"></script>
</body>
</html>
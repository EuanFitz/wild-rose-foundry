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
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include('includes/header.php');?>
    <main>
        <ul>
            <?php
                while($featured = mysqli_fetch_assoc($mainsql)){
                    $vendorid = $featured['vendor_id'];
                    $vendor_query = "SELECT name FROM vendors WHERE vendor_id = $vendorid";
                    $vendor = mysqli_fetch_assoc(mysqli_query($connection,$vendor_query));
            ?>
            <li>
                <img src="media/<?php echo $featured['image']?>" alt="<?php echo $featured['img_alt']?>">
                <h2><? echo $featured['name']; ?></h2>
                <p><? echo $featured['price']; ?></p>
                <p><? echo $vendor['name']; ?></p>
            </li>
            <?php
                }
            ?>
        </ul>
    </main>
    <?php include('includes/footer.php');?>
</body>
</html>
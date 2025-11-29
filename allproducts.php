<?php
require("connection.php");
$queryproduct = "SELECT p.* FROM `products` p 
JOIN `vendors` v ON p.vendor_id = v.vendor_id 
JOIN `product_category` pc ON p.product_id = pc.product_id 
JOIN `categories` c ON pc.category_id = c.category_id 
WHERE 1";
$vendoroption_query = "SELECT * FROM `vendors` v";
$groupproduct = " GROUP BY p.product_id";
$groupcategory = " GROUP BY category_id";
$limitfirst = 0;
$limitsecond = 24;
$limit = " LIMIT $limitfirst, $limitsecond";
if(!$connection){
    echo "There was an error connecting.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products|| WildRose.com</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        main{
            display: grid;
            grid-template-columns: repeat(3, minmax(200px, 1fr));
            gap: 2rem;
            padding: 2rem 1.5rem;
            grid-row: auto;
        }
        form{
            background: #BFBCB8;
            display:flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 3px 10px #00000070;
            padding: 1rem;
        }
        form input[type=submit]{
            background: none;
            border: none;
            font-size: large;
            cursor: pointer;
            color: #FFF4EA;
            padding: .8rem;
        }
        form input[type=submit]:hover{
            background: #BFBCB8;
        } 
        main section{
            border: 3px solid #8C8276;
            width: 100%;
            border-radius: 10px 10px 0 0;
            overflow: hidden;
        }
        main section > img{
            max-width: 100%;
            height: auto;
        }
        main section h2, main section p{
            padding-left: .5rem;
        }
        /* Repeating styles */
        main a, form{
         color: #3C3833;
        }
    </style>
</head>
<body>
    <?php
    include("header.php");
    ?>
    <form method="GET" action="allproducts.php">
        <div>
        <label for="category">Catagory</label>
        <select id="category" name="category">
            <option value="">All Categorys</option>
            <option value="">gsg</option>
        </select>
        </div>
        <div>
        <label for="vendor">Vendor</label>
        <select name="vendor" id="vendor">
            <option value="">All Vendors</option>
            <?php 
        $vendoroptionsql = mysqli_query($connection,$vendoroption_query);
        if (mysqli_num_rows($vendoroptionsql) > 0){
        while($vendor = mysqli_fetch_assoc($vendoroptionsql)){
            echo '<option value="'.$vendor['vendor_id'].'">'.$vendor['name'].'</option>';
        }

    }
        ?>
        </select>
        </div>
        <div>
            <span>Price</span>
            <label for="low-high">$-$$$</label>
            <input type="radio" name="price" id="low-high" value="low-high">
            <label for="high-low">$$$-$</label>
            <input type="radio" name="price" id="high-low" value="high-low">
        </div>
        <input type="submit" value="Go">
    </form>
    <main>
        <?php 
        $productsql = mysqli_query($connection,($queryproduct.= $groupproduct.= $limit));
        if(mysqli_num_rows($productsql)>0){
        while($product = mysqli_fetch_assoc($productsql)){
            $prod_id = $product["product_id"];

            $vendor_query = " SELECT * FROM `vendors` v JOIN `products` p ON v.vendor_id = p.vendor_id WHERE p.product_id = $prod_id ";
            $vendorsql = mysqli_query($connection,$vendor_query);
            $vendor = mysqli_fetch_assoc($vendorsql);
            ?>
        <a href="proudct.php?id=<?php echo $prod_id;?>">   
            <section>
                <img src="media/<?php echo $product["image"];?>" alt="<?php echo $product["img_alt"];?>" width="1024" height="1024">
                <h2><?php echo $product["name"];?></h2>
                <p><?php echo $vendor['name']?></p>
                <p><?php echo $product["price"];?></p>
            </section>
        </a>
        <?php
    }
}
    ?>
    </main>
    <?php
    include("footer.php");
    ?>
</body>
</html>
<?php
include('includes/global.php');
require('includes/connection.php');

//Queries
$queryproduct = "SELECT p.* FROM `products` p 
JOIN `vendors` v ON p.vendor_id = v.vendor_id 
JOIN `product_category` pc ON p.product_id = pc.product_id 
JOIN `categories` c ON pc.category_id = c.category_id 
WHERE 1";
$vendoroption_query = "SELECT * FROM `vendors`";
$category_query = "SELECT * FROM `categories`";

$groupproduct = " GROUP BY p.product_id";
$wherequery = '';
$orderquery = '';

//Pagination
$products_per_page = 24;

$rows_num = mysqli_query($connection, "SELECT COUNT(*) FROM products");
$rowstotal = mysqli_fetch_assoc($rows_num);
$count = $rowstotal['COUNT(*)'];

$links_needed= ceil($count/$products_per_page);
if(!isset($_GET['start'])){
    $start = 0;
}else{
    $start = $_GET['start'];
}
$limit = " LIMIT $start, $products_per_page";

//Filtering
if(isset($_POST['category']) && $_POST['category'] !== ''){
    $category = $_POST['category'];
    $wherequery .= " AND c.category_id = $category";
}
if(isset($_POST['vendor']) && $_POST['vendor'] !== ''){
    $vendor = $_POST['vendor'];
    $wherequery .= " AND v.vendor_id = $vendor";
}
if(isset($_POST['price'])){
    $price = $_POST['price'];
    $orderquery = " ORDER BY p.price $price";
}

//Query concatination
    $fullquery = $queryproduct .= $wherequery .= $groupproduct .= $orderquery .= $limit;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products|| WildRose.com</title>
    <?php include('includes/links.php');?>
</head>
<body>
    <?php
    include("includes/header.php");
    ?>
    <form class="filters" method="post" action="products.php">
        <div>
        <label for="category">Catagory</label>
        <select id="category" name="category">
            <option value="">All Categories</option>
            <?php
            $categorysql = mysqli_query($connection,$category_query);
            while($cat = mysqli_fetch_assoc($categorysql)){
            ?>
            <option value="<?php echo $cat['category_id']; ?>"><?php echo $cat['name']; ?>
            </option>           
            <?php
            }
            ?>

        </select>
        </div>
        <div>
        <label for="vendor">Vendor</label>
        <select name="vendor" id="vendor">
            <option value="">All Vendors</option>
        <?php 
            $vendoroptionsql = mysqli_query($connection,$vendoroption_query);
            while($vend = mysqli_fetch_assoc($vendoroptionsql)){
        ?>
            <option value="<?php echo $vend['vendor_id'];?>"><?php echo $vend['name'];?> </option>
        <?php
        }?>
        </select>
        </div>
        <div>
            <span>Price</span>
            <div>
                <label for="low-high">High</label>
                <input type="radio" name="price" id="low-high" value="ASC">
            </div>
            <div>
                <label for="high-low">Low</label>
                <input type="radio" name="price" id="high-low" value="DESC">
            </div>
        </div>
        <button type="submit">Go</button>
    </form>
    <main class="showproducts">
        <?php 
        $productsql = mysqli_query($connection,$fullquery);
        if(mysqli_num_rows($productsql)>0){
        while($product = mysqli_fetch_assoc($productsql)){
            $prod_id = $product["product_id"];

            $vendor_query = " SELECT v.* FROM `vendors` v JOIN `products` p ON v.vendor_id = p.vendor_id WHERE p.product_id = $prod_id ";
            $vendorsql = mysqli_query($connection,$vendor_query);
            $vendor = mysqli_fetch_assoc($vendorsql);
            ?>
        <a href="details.php?id=<?php echo $prod_id;?>">   
            <article class="product">
                <img src="media/<?php echo $product["image"];?>" alt="<?php echo $product["img_alt"];?>" width="1024" height="1024" loading="lazy">
                <h2><?php echo $product["name"];?></h2>
                <p><?php echo $vendor['name']?></p>
                <p><?php echo $product["price"];?></p>
            </article>
        </a>
        <?php
    }
}?>
    <div class="pagination">
        <?php
        for($i=0; $i<$links_needed; $i++){
            echo '<a href="products.php?start='.$i*$products_per_page.'">'.($i+1).'</a>';
        }
    ?>
    </div>
    </main>
    <?php
    include("includes/footer.php");
    ?>
</body>
</html>
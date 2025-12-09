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
    <link rel="stylesheet" href="styles.css">
    <style>
/* FORM */
    .filters{
        background: #BFBCB8;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 3px 10px #00000070;
        padding: 1rem;
        }
    .filters > div{
        display: flex;
    }
        .filters input[type=submit]{
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
    /* MAIN */
        main{
            display: grid;
            grid-template-columns: repeat(3, minmax(300px, 1fr));
            gap: 2rem;
            padding: 2rem 1.5rem;
        }
        main article {
            border: 3px solid #8C8276;
            width: 100%;
            border-radius: 10px 10px 0 0;
            overflow: hidden;
            background:#ffffff50;
        }
        main article > img{
            max-width: 100%;
            height: auto;
        }
        main a article h2, main a article p{
            padding-left: .5rem;
        }

/* Repeating styles */
        main a, form{
         color: #3C3833;
        }
        @media (max-width: 1000px){
            main{
                grid-template-columns: 1fr 1fr;
                grid-template-rows: repeat(auto-fill, auto);
                gap: .5rem;
                padding: 1rem .2rem;
            }
            .pagination{
                grid-column: span 2;
            }
            main article{
                font-size: small;
                height: 100%;
            }
        }
        @media(min-width: 780px){
            .filters{
            display: flex;
            }
            .filters > div{
                flex-direction: column;
            }
        }
    </style>
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
            <option value="<?php echo $vend['vendor_id'];?>"><?php echo $vend['name'];?> </option>';
        <?php
        }?>
        </select>
        </div>
        <div>
            <span>Price</span>
            <label for="low-high">$-$$$</label>
            <input type="radio" name="price" id="low-high" value="ASC">
            <label for="high-low">$$$-$</label>
            <input type="radio" name="price" id="high-low" value="DESC">
        </div>
        <input type="submit" value="Go">
    </form>
    <main>
        <?php 
        $productsql = mysqli_query($connection,$fullquery);
        if(mysqli_num_rows($productsql)>0){
        while($product = mysqli_fetch_assoc($productsql)){
            $prod_id = $product["product_id"];

            $vendor_query = " SELECT * FROM `vendors` v JOIN `products` p ON v.vendor_id = p.vendor_id WHERE p.product_id = $prod_id ";
            $vendorsql = mysqli_query($connection,$vendor_query);
            $vendor = mysqli_fetch_assoc($vendorsql);
            ?>
        <a href="details.php?id=<?php echo $prod_id;?>&var=0">   
            <article>
                <img src="media/<?php echo $product["image"];?>" alt="<?php echo $product["img_alt"];?>" width="1024" height="1024">
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
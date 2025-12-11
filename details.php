<?php
include('includes/global.php');
require('includes/connection.php');
if(isset($_GET['id']) && $_GET['id'] !== ''){
    $prod_id = $_GET['id'];
    $query = "SELECT * FROM products WHERE product_id = $prod_id";
    
    $varquery ="SELECT v.* FROM variants v 
    JOIN products p ON v.product_id = p.product_id
    WHERE v.product_id = $prod_id";
    
    $categoryquery = "SELECT c.* FROM categories c
    JOIN product_category pc ON c.category_id = pc.category_id
    JOIN products p ON pc.product_id = p.product_id
    WHERE pc.product_id = $prod_id
    GROUP BY c.category_id";
    
    $vendorquery = "SELECT v.* FROM vendors v 
    JOIN products p ON v.vendor_id = p.vendor_id WHERE p.product_id = $prod_id";
}
        if(isset($query)){
            $productsql = mysqli_query($connection,$query);
            $product = mysqli_fetch_assoc($productsql);
            $vendorsql = mysqli_query($connection,$vendorquery);
            $vendor = mysqli_fetch_assoc($vendorsql);
        
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php if(!isset($product)){ 
        echo "Details";}else{
            echo $product['name'];
        }?>|| WildRose.com
    </title>

    <?php include('includes/links.php');?>
    
    <style>
       main{
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap:3rem;
            padding: 1rem;
            justify-content: center;
            color: #3c3833;
        }
        @media(max-width: 600px){
            main{
                display: flex;
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <?php
    include('includes/header.php');
    ?>
    <main>
        <div class="detailimgs">
            <img title="<?php echo $product['name']?>" id="productimg" class="productimg" src="media/<?php echo $product['image'];?>" alt="<?php echo $product['img_alt'];?>" width="1024" height="1024">
            <div class="thumb" id="thumb">
                <?php
                $variantsql = mysqli_query($connection,$varquery);
                while($variant = mysqli_fetch_assoc($variantsql)){
                ?>
                <img class="variantimg" id="<?php echo $variant['variant_id']?>" title="<?php echo $variant['variant_value']?>" src="media/thumb/<?php echo $variant['image'];?>" height="250" width="250" alt="<?php echo $variant['img_alt']?>">
                <?php
                }
                ?>
            </div>
        </div>
        <section class="card detailwords">
            <div class="productinfo">
                <h2><?php echo $product['name']; ?></h2>
                <p>By: <a href="vendors.php?id=<?php echo $vendor['vendor_id']; ?>"><?php echo $vendor['name'];?></a></p>
                <p><?php echo $product['description']; ?></p>
                 <ul>
            <?php   
                $categorysql = mysqli_query($connection,$categoryquery);
                while($categories = mysqli_fetch_assoc($categorysql)){
            ?>
                    <li><?php echo $categories['name'];?></li>
            <?php
                }
            ?>
            </ul>
            </div>
            <div class="price-button">
                <p>$38.00</p>
                <form action="order.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $product['product_id'];?>">
                    <input type="hidden" id="varid" name=var value="0">
                   <button type="submit">Add to order</button>
                </form>
            </div>
        </section>
        <?php
            }else{?>
                <p>No product was selected.</p>
                <a class="nocontentbutton" href="products.php">All products</a>
            <?php
            }
        ?>
    </main>
    <?php
    include('includes/footer.php');
    ?>
    <script src="script/details.js"></script>
</body>
</html>
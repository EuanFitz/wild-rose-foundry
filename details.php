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
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>(ITEM NAME) || WildRose.com</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        main{
            display:grid;
            grid-template-columns: 1fr 1fr;
            gap:3rem;
            padding: 1rem;
            justify-content: center;
            color: #3c3833;
        }
        main > div{
            max-width: 100%;
        }
        .productimg{
            max-width: 100%;
            height: auto;
        }
        .thumb{
            display:grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;   
            justify-self: center;
        }
        .thumb img{
            max-width: 100%;
            height: auto;
        }
        .productinfo{
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 1rem;
            background: #FFFFFF20;
            border-radius: 10px;
            box-shadow: 0 3px 10px #00000070;
        }
        .productinfo div:last-of-type{
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    <?php
    include('includes/header.php');
    ?>
    <main>
        <?php
        if(isset($query)){
            $productsql = mysqli_query($connection,$query);
            $product = mysqli_fetch_assoc($productsql)
        ?>
        <div>
            <img class="productimg" src="media/<?php echo $product['image'];?>" alt="<?php echo $product['img_alt'];?>" width="" height="">
            <div class="thumb">
                <?php
                $variantsql = mysqli_query($connection,$varquery);
                while($variant = mysqli_fetch_assoc($variantsql)){
                ?>
                <button><img src="media/thumb/<?php echo $variant['image'];?>" height="250" width="250" alt="<?php echo $variant['img_alt']?>"></button>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="productinfo">
            <div>
                <h2><?php echo $product['name']; ?></h2>
                <p>By: Vendor Name</p>
                <p><?php $product['description']; ?></p>
            </div>
            <div>
                <p>$38.00</p>
                <form action="order.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $product['product_id'];?>">
                   <button type="submit">Add to order</button>
                </form>
            </div>
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
        <?php
            }else{?>
                <p>No product was selected.</p>
                <a href="products.php">All products</a>
            <?php
            }
        ?>
    </main>
    <?php
    include('includes/footer.php');
    ?>
</body>
</html>
<?php
include('includes/global.php');
require('includes/connection.php');

//Variables for later
    //Get current page url  
    $current_page = $_SERVER['PHP_SELF'];
    $price = 0;

//Create cart item
if(isset($_POST['id'])) {
    $cart_item = [
        "id" => $_POST['id'],
        "variant" => $_POST['var']
    ];
}


//Pull arrays to later check if items in cart exist
    $ids = array_column($_SESSION['products'], 'id');
    $variants = array_column($_SESSION['products'], 'variant');
    
    //Check if cart item exists
    if(isset($cart_item)){
        
        if($cart_item['variant'] == 0){
        if(!in_array($cart_item['id'],$ids)){
            $_SESSION['products'][] = $cart_item;
        }
        }else{
            if(!in_array($cart_item['variant'],$variants)){
                $_SESSION['products'][] = $cart_item;
            }
        }
    }


    //Clear cart and reload page
if(isset($_POST['clear'])){
    session_destroy();
    header("Location: $current_page");
}

//Variables

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order || WildRose.com</title>
    <?php include('includes/links.php');?>
    <style>
       main{
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 1rem;
        }
        main h2{
            grid-column: span 2;
            padding: .5rem;
            text-shadow: 0 3px 2px #00000055;
        }

        main section{
            width: 80%;
            margin: 2rem auto;
        }
        @media(max-width: 1000px){
            main{
                display: flex;
                flex-direction: column;
            }
            main section{
                max-width: 80%;
            }
        }
    </style>
</head>
<body>
    <?php
    include('includes/header.php');
    ?>
    <main>
        <h2>Shopping Cart</h2>
        <?php
        //Create order
             if((count($_SESSION['products']))){
        ?>
        <section class="card">
            <div class="order-overview">
                <?php

                //Actually pull cart items.
                foreach($_SESSION['products'] as $key => $item){
                    $item_product = $_SESSION['products'][$key]['id'];
                    $item_variant = $_SESSION['products'][$key]['variant'];

                    //If no array is set  aka doesn't 0 zero. Grab variant image
                    if($item_variant !== "0"){
                    $variantquery = "SELECT p.name, p.price, v.* FROM `products` p 
                    JOIN `variants` v ON p.product_id = v.product_id 
                    WHERE v.variant_id = $item_variant";

                    $variantsql = mysqli_query($connection,$variantquery);  
                    $variant_row = mysqli_fetch_assoc($variantsql);

                    $price += ((float)$variant_row['price']);
                    $varval = ucfirst($variant_row['variant_value']);
                    $varkey = ucfirst($variant_row['variant_key']);
                    ?>
                    <a href="details.php?id=<?php echo $item_product;?>">
                        <article class="cartitem">
                            <img src="media/thumb/<?php echo $variant_row['image'];?>" title="<?php echo $variant_row['variant_value']; ?>" alt="<?php echo $variant_row['img_alt']; ?>" height="250" width="250">
                            <div>
                                <h3><?php echo $variant_row['name']; ?></h3>
                                <p><?php echo "$varkey:  $varval";?></p>
                                <p><?php echo $variant_row['price']; ?></p>
                                <form action="order.php" method="POST">
                                    <button type="submit" class="removeitem" value="">X</button>
                                </form>
                            </div>
                        </article>
                    </a>

                <?php
                //In this case no variant was set (variat = 0) so display only product with
                }else{
                    $query = "SELECT * FROM products WHERE product_id = $item_product";
                    $productsql = mysqli_query($connection,$query);
                    $product = mysqli_fetch_assoc($productsql);

                    $price += ((float)$product['price']);
                    ?>
                    <a href="details.php?id=<?php echo $item_product;?>">
                        <article class="cartitem">
                            <img src="media/thumb/<?php echo $product['image']; ?>" alt="<?php echo $product['img_alt']; ?>" height="250" width="250">
                            <div>
                                <h3><?php echo $product['name']; ?></h3>
                                <p><?php echo $product['price']; ?></p>
                            </div>
                        </article>
                    </a>

                    <?php
                }
                }
                //Quick maths for calculating final cost
            $tax = number_format(($price*.05), 2);
            $total = number_format(($price + $tax), 2);
            ?>
            </div>
            <div class="ordertotal">
                <p>Subtotal:  $<?php echo number_format($price, 2); ?></p>
                <p>Tax (5%): $<?php echo $tax;?></p>
                <p>Total: $<?php echo $total;?></p>
            </div>
            <form action="order.php" method="post">
                    <button type="submit" value="Clear" name="clear">Clear Cart</button>
            </form>
        </section>
        <?php
        ?>
        <section class="card">
            <form class="order" action="complete.php" method="post">
                <div>
                    <label for="first">First Name</label>
                    <input type="text" id="first" name="first" required>
                </div>
                <div>
                    <label for="last">Last Name</label>
                    <input type="text" id="last" name="last" required>
                </div>
                <div>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div>
                    <label for="phone">Phone Number</label>
                    <input type="tel" name="phone" id="phone" required>
                </div>
                <input type="hidden" name="price" value="<?php echo $total;?>">
                
                <button type="submit" name="complete">Complete Order</button>
            </form>
        </section>
        <?php
        //Cart = empty
            }else{
        ?>
        <div class="card ordered">
            <p>Your cart is empty!</p>
            <a class="nocontentbutton" href="products.php">Keep shopping</a>
        </div>
            <?php
                }
            ?>
    </main>
        <?php
    include('includes/footer.php');
    ?>
</body>
</html>
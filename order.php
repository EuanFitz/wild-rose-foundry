<?php
include('includes/global.php');
require('includes/connection.php');
if(isset($_POST['id'])) {
    $cart_item = [
        "id" => $_POST['id'],
        "variant" => $_POST['var']
    ];
}
    $ids = array_column($_SESSION['products'], 'id');
    $variants = array_column($_SESSION['products'], 'variant');
    
    $inids = implode(" ,",$ids);
    $invariants = implode(" '", $variants);
if(isset($cart_item)){

    if(!in_array($cart_item['id'],$ids) && !in_array($cart_item['variant'],$variants)) {
    $_SESSION['products'][] = $cart_item;
}
}

if(isset($_POST['clear'])){
    session_destroy();
}

//Variables
$price = 0;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order || WildRose.com</title>
    <link rel="stylesheet" href="styles.css">
    <style>
       main{
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 1rem;
        }
        main h2{
            grid-column: span 2;
        }
        section .order-overview{
            background-color: var(--card);
            border-radius: 15px;
            border: 2px solid var(--darktext);
            display: flex;
            flex-direction: column;
            max-width: 100%;
            max-height: 300px;
            overflow: hidden;
            overflow-y: scroll;
            gap: 1rem;
            margin: 0 auto;
        }
        section div article{
            border-radius: 15px;
            max-width: 90%;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 3fr;
            gap: .5rem; 
            box-shadow: 0 2px 5px var(--darktext);
        }
        section div article img{
            border-radius: 15px 0 0 15px;
            max-height: 100px;
            width: auto;
        }
        .ordertotal{
            padding: 2rem;
        }
        main section form{
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }
        main section form div{
            display: grid;
            grid-template-columns: 150px 300px;
        }
        section form .clear{
            background: rgb(138, 48, 48);
            color: var(--light)
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
            main section form div{
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
             if((count($_SESSION['products']))> 0){
                
                $query = "SELECT * FROM `products` WHERE product_id IN($inids)";
                $productsql = mysqli_query($connection,$query);
        ?>
        <section class="card">
            <div class="order-overview">
                <?php
                while($product = mysqli_fetch_assoc($productsql)){
                    $price += ((float)$product['price']);
                ?>
                <article>
                    <img src="media/thumb/<?php echo $product['image']; ?>" alt="<?php echo $product['img_alt']; ?>" height="250" width="250">
                    <div>
                        <h3><?php echo $product['name']; ?></h3>
                        <p><?php echo $product['price']; ?></p>
                    </div>
                </article>
            <?php
            }
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
            }else{
        ?>
        <div class="card ordered">
            <p>Your cart is empty!</p>
            <a class="nocontentbutton" href="products.php">Keep shopping</a>
            <?php
                }
            ?>
        </div>
    </main>
        <?php
    include('includes/footer.php');
    ?>
</body>
</html>
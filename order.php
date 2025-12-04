<?php
include('includes/global.php');
require('includes/connection.php');
if(isset($_POST['id'])){
    $_SESSION['products'][] = $_POST['id'];
}
if(isset($_POST['clear'])){
    session_destroy();
}
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
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            gap: 2rem;
        }
        article{
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 50px 50px;
            gap: 3rem;
            overflow: hidden;
            border-radius: 14px;
            background: #ffffff80;
            margin: .8rem;
        }
        article img{
            border-radius: 10px;
            height: 100%;
            max-width: auto;
            padding: .8rem;
            grid-row: span 2;
        }
        article h2, article p{
            align-items: end;
        }
        .scroll{
            overflow-y: auto;
            height: 100%;
        }
        .order div{
            display: grid;
            grid-template-columns: 200px 250px;
        }
        .card{
            padding: 2rem;
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
        if(isset($_POST['complete'])){
            //Order information
            $first = $_POST['first'];
            $last = $_POST['last'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $items = $_POST['items'];
            $total = $_POST['price'];
            //Create order
            $order_query = "INSERT INTO `orders` (`order_id`, `first_name`, `last_name`, `phone`, `email`, `items`, `total`) VALUES (NULL, '$first', '$last', '$phone', '$email', '$items', '$total')";
            $ordersql = mysqli_query($connection,$order_query);

            //Show order number
            $getorder_query = "SELECT * FROM orders WHERE phone = $phone ORDER BY order_id DESC LIMIT 1";
            $getordersql = mysqli_query($connection,$getorder_query);
            $order = mysqli_fetch_assoc($getordersql);
            
            //End session
            session_destroy();
            ?>
            <h3>Thank you <?php echo $first; ?> for your order!</h3>
            <p>Your order number is: <?php echo $order['order_id']; ?></p>
            <p>Please have your order number ready on pickup.</p>
            <a href="products.php">Keep shopping</a>

            <?php
        }else{
             if((count($_SESSION['products']))> 0){
                $ids = implode(", ",$_SESSION['products']);
                $query = "SELECT * FROM `products` WHERE product_id IN($ids)";
                $productsql = mysqli_query($connection,$query);
        ?>
        <section class="card scroll">
            <?php
             while($product = mysqli_fetch_assoc($productsql)){
                $price += ((float)$product['price']);
            ?>
            <article>
                <img src="media/thumb/<?php echo $product['image']; ?>" alt="<?php echo $product['img_alt']; ?>" height="250" width="250">
                <h3><?php echo $product['name']; ?></h3>
                <p><?php echo $product['price']; ?></p>
            </article>
            <?php
            }
            $tax = number_format(($price*.05), 2);
            $total = number_format(($price + $tax), 2);
            ?>
            <form action="order.php" method="post">
                    <button type="submit" value="Clear" name="clear">Clear Cart</button>
            </form>
        </section>
        <?php
        ?>
        <section class="card">
            <div><p>Subtotal:  $<?php echo number_format($price, 2); ?></p>
                <p>Tax (5%): $<?php echo $tax;?></p>
                <p>Total: $<?php echo $total;?></p>
            </div>
            <form class="order" action="order.php" method="post">
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
                <input type="hidden" name="items" value="<?php echo $ids;?>">
                <input type="hidden" name="price" value="<?php echo $total;?>">
                <button type="submit" name="complete">Complete Order</button>
            </form>
        </section>
        <?php
            }else{
        ?>
        <p>Your cart is empty!</p>
        <a href="products.php">Keep shopping</a>
        <?php
            }}
            ?>
    </main>
        <?php
    include('includes/footer.php');
    ?>
</body>
</html>
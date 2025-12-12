<?php
include('includes/global.php');
require('includes/connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order ID || WildRose.com</title>
    <?php include('includes/links.php');?>
</head>
<body>
   <?php 
   include("includes/header.php");
   ?>
   <main>
   <?php
   //Check if the order has actually been created.
   if(isset($_POST['complete'])){
            //Order information from order page. Sanitized.
            $first = mysqli_real_escape_string($connection,$_POST['first']);
            $last = mysqli_real_escape_string($connection,$_POST['last']);
            $email = mysqli_real_escape_string($connection,$_POST['email']);
            $phone = mysqli_real_escape_string($connection,$_POST['phone']);
            $total = mysqli_real_escape_string($connection,$_POST['price']);



            //Create order
            $order_query = "INSERT INTO `orders` (`order_id`, `first_name`, `last_name`, `phone`, `email`, `total`) VALUES (NULL, '$first', '$last', '$phone', '$email', '$total')";
            $ordersql = mysqli_query($connection,$order_query);



            //Show order number
            $getorder_query = "SELECT * FROM orders WHERE phone = $phone ORDER BY order_id DESC LIMIT 1";
            $getordersql = mysqli_query($connection,$getorder_query);
            $order = mysqli_fetch_assoc($getordersql);
            $orderid = (int)$order['order_id'];
            

            //Populate order_product_variable page and insert into table with variant if set if variant = 0 Variant row will be NULL
            foreach($_SESSION['products'] as $key => $item){
                $order_product = (int)$_SESSION['products'][$key]['id'];
                $order_variant = (int)$_SESSION['products'][$key]['variant'];

                $orderproductquery = "INSERT INTO `order_product_variant` (`order_id`, `product_id`, `variant_id`) VALUES ($orderid,$order_product, NULLIF($order_variant,0))";

                mysqli_query($connection,$orderproductquery);
            }?>
            <div class="ordered card">
                <h3>Thank you <?php echo $first; ?> for your order!</h3>
                <p>Your order number is: <?php echo $order['order_id']; ?></p>
                <p>Please have your order number ready on pickup.</p>
                <a class="nocontentbutton" href="products.php">Keep shopping</a>
            </div>
            <?php
            //No order to show.
            }else{
        ?>
        <div class="card ordered">
            <p>No order...</p>
            <a class="nocontentbutton" href="products.php">Keep shopping</a>
        </div>
        <?php
    }
            ?>
        </main>
        <?php
        include("includes/footer.php");
            //End session
            session_destroy();
        ?>
        

</body>
</html>
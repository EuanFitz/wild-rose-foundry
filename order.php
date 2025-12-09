<?php
include('includes/global.php');
require('includes/connection.php');
if(isset($_POST['id'])) {
    $product = [
        "id" => $_POST['id'],
        "variant" => $_POST['var']
    ];
}
    $ids = array_column($_SESSION['products'], 'id');
    $variants = array_column($_SESSION['products'], 'variant');
    
    $inids = implode(" ,",$ids);
    $invariants = implode(" '", $variants);
if(isset($product)){

    if(!in_array($product['id'],$ids) && !in_array($product['variant'],$variants)) {
    $_SESSION['products'][] = $product;
}
}
// if(isset($_POST['id'])){
//     if(!in_array($_POST['id'], $_SESSION['products'])) {
//             $_SESSION['products'][] = [
//                 "id" => $_POST['id'],
//                 "variant" => $_POST['var']
//             ]
//     }
//     if(!in_array($_POST['var'], $_SESSION['variants'])){
//         $_SESSION['variants'][] = $_POST['var']; 
//     }
// }

// print_r($ids);
// print_r($variants);


print_r("(".$inids.")");
print_r("(".$invariants.")");
//I have a issue where the keys in the array arent imploding so it wont convert to a string properly..
//Potential fix would be to make a second array using variants but then I would have to find a way to associate them back to the product id before completing the order. 
//End session
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
            grid-template-columns: 100px 300px;
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
        if(isset($_POST['complete'])){
            //Order information
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
            
            //Populate order_product_variable page
            foreach($_SESSION['products'] as $key => $item){
                $order_product = (int)$_SESSION['products'][$key]['id'];
                $order_variant = (int)$_SESSION['products'][$key]['variant'];
                $orderproductquery = "INSERT INTO `order_product_variant` (`order_id`, `product_id`, `variant_id`) VALUES ($orderid,$order_product, NULLIF($order_variant,0))";
                //echo $orderproductquery;
                mysqli_query($connection,$orderproductquery);
            }
            ?>
            <h3>Thank you <?php echo $first; ?> for your order!</h3>
            <p>Your order number is: <?php echo $order['order_id']; ?></p>
            <p>Please have your order number ready on pickup.</p>
            <a href="products.php">Keep shopping</a>
            
            <?php
            //End session
            session_destroy();
        }else{
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
            }?>
            </div>
            <div class="ordertotal">
                <p>Subtotal:  $<?php echo number_format($price, 2); ?></p>
                <p>Tax (5%): $<?php echo $tax;?></p>
                <p>Total: $<?php echo $total;?></p>
            </div>
            <?php
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
                <input type="hidden" name="price" value="<?php echo $total;?>">
                <
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
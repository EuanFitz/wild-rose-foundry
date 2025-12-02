<?php
session_start();
if(isset($_POST['id'])){
    $product = [
        "id" => $_POST['id'],
        "name" => $_POST['name'],
        "image" => $_POST['image'],
        "alt" => $_POST['alt'],
        "price" => $_POST['price']
    ];
}
if(!isset($_SESSION['products'])){
    $_SESSION['products'][] = $product;
}else{
    foreach($_SESSION['products'] as $stored_product){
        $ids[] = $stored_product['id'];
    }
    if(!in_array($product['id'], $ids)){
            $_SESSION['products'][] = $product;
            $_SESSION['prices'][] = $products['price'];
            $_SESSION['items'][] = $products['id'];
    }
}
if(isset($_POST['clear'])){
    session_unset();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order || WildRose.com</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <p> <?php echo $_SESSION['products'][];?></p>
    <p> <?php echo $_SESSION['prices'];?></p>
    <p> <?php echo $_SESSION['items'];?></p>
    <?php
    include('header.php');
    ?>
    <section class="card">
        <?php 
        // foreach($_SESSION['products'] as $key => $stored_product){
        //     $row = $_SESSION['products'][$key];
        //     $img = preg_replace('/.png/', '', $row['image']);
        ?>
        <article>
            <img src="media/thumb/<?php// echo $img;?>-thumb.png" alt="<?php// echo $row['alt']; ?>">
            <p><?php// echo $row['name']; ?></p>
            <p><?php// echo $row['price']; ?></p>
        </article>
        <?php
        // }
        ?>
        <p>Subtotal</p>
        <p>Tax (5%)</p>
        <p>Total</p>
        <form action="order.php" method="post">
            <input type="hidden" value="" name="clear">
            <button type="submit">
        </form>
    </section>
    <form class="card" action="order.php" method="post">
        <label for="first">First Name</label>
        <input type="text" id="first" name="first" require>
        <label for="last">First Name</label>
        <input type="text" id="last" name="last" require>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" require>
        <label for="phoen"></label>
        <input type="tel" name="phone" id="phone" require>
        <input type="hidden" name="total" value="<?php// echo $prices; ?>">
        <input type="hidden" name="items" value="<?php// echo $item_array; ?>">
        <button type="submit">Complete Order</button>
    </form>
    <h2>Thank you User!</h2>
    <h3>Your order number is #1404</h3>
    <p>Please have your order number ready for pickup.</p>
    <?php
    include('footer.php');
    ?>
</body>
</html>
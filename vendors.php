<?php
include('includes/global.php');
require('includes/connection.php');
$query = "SELECT * FROM vendors WHERE 1";
$where = '';
$selectvend ='';
if(isset($_GET['id']) && $_GET['id'] !== ''){
    $vendor_id = $_GET['id'];
    $where .= " AND vendor_id = $vendor_id";
        
    $productquery = "SELECT * FROM products WHERE vendor_id = $vendor_id";
    $productsql = mysqli_query($connection,$productquery);
}
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php
    
    if(isset($vendor_id)){
    $namequery = "SELECT * FROM vendors WHERE vendor_id = $vendor_id";
    $namesql = mysqli_query($connection,$namequery);
    $vendorname = mysqli_fetch_assoc($namesql);
    $selectvend = $vendorname['name'];
    echo $selectvend;
    }else{
        echo "Vendors";
        }?> || WildRose</title>
    <?php include('includes/links.php');?>
</head>
<body>
    <?php
    include ("includes/header.php");
    ?>
    <form class="filters" action="vendors.php" method="GET">
        <select name="id" id="vendor">
            <option value="">All Vendors</option>
            <?php 
            $vendoroptionsql = mysqli_query($connection,$query);
            while($vendor = mysqli_fetch_assoc($vendoroptionsql)){
                echo '<option value="'.$vendor['vendor_id'].'">'.$vendor['name'].'</option>';
            }
            ?>
        </select>
        <button type="submit">Go</button>
    </form>
    <main>
        <?php 
        $vendoroptionsql = mysqli_query($connection,$query .= $where);
        while($vendor = mysqli_fetch_assoc($vendoroptionsql)){
            ?>
            <section class="vendor card">
                <a href="vendors.php?id=<?php echo $vendor['vendor_id'];?>"><img src="media/logos/<?php echo $vendor['logo']?>" alt="<?php echo $vendor['logo_alt'];?>" height="1024" width="1024"></a>
                <div class="card">
                    <div>
                        <h2><?php echo $vendor['name'];?></h2>
                        <p>Booth: <?php echo $vendor['booth_number'];?></p>
                    </div>
                        <p><?php echo $vendor['bio'];?></p>
                        <div class="contact">
                            <p>Email: <a><?php echo $vendor['email'];?></a></p>
                            <a href="https://www.instagram.com/<?php echo $vendor['instagram'];?>/"><img src="media/logos/instagramiconblack.svg" width="50" height="50" alt=""><?php echo $vendor['instagram'];?></a>
                        </div>
                    </div>
                </section>
                <?php 
            }
        if(isset($vendor_id)){
        ?>
            <section class="showproducts">
                <h3>All products from <?php echo $selectvend;?></h3>
        <?php
            while($product = mysqli_fetch_assoc($productsql)){
            $prod_id = $product["product_id"];
            ?>
         
        <a href="details.php?id=<?php echo $prod_id;?>">   
            <article class="product">
                <img src="media/<?php echo $product["image"];?>" alt="<?php echo $product["img_alt"];?>" width="1024" height="1024" loading="lazy">
                <h2><?php echo $product["name"];?></h2>
                <p><?php echo $product["price"];?></p>
            </article>
        </a>
        <?php
    }
     echo "</section>";
        }
         ?>
    </main>
    <?php
    include ("includes/footer.php");
    ?>
</body>
</html>
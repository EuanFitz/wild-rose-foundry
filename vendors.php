<?php
include('includes/global.php');
require('includes/connection.php');
$query = "SELECT * FROM vendors WHERE 1";
$where = '';
if(isset($_GET['id']) && $_GET['id'] !== ''){
    $vendor_id = $_GET['id'];
    $where .= " AND vendor_id = $vendor_id";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor name || WildRose</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        section{
            display: grid;
            grid-template-columns: 1fr 2fr;
        }
        section img{
            max-width: 300px;
            justify-self: flex-end;
        }
        .card{
            margin: 4rem;
            padding: 1.5rem;
            display:flex;
            flex-direction: column;
        }
        .card .contact{
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: flex-end;
            justify-self: flex-end;
        }
        .contact a, .contact p{
            display: flex;
            max-width: 100%;
            align-items: center;
        }
        .contact a{
            justify-self: flex-end;
        }
        .contact a img{
            max-width: 40px;
        }
    </style>
</head>
<body>
    <?php
    include ("includes/header.php");
    ?>
    <form action="vendors.php" method="GET">
        <select name="id" id="vendor">
            <option value="">All Vendors</option>
        <?php 
        $vendoroptionsql = mysqli_query($connection,$query);
        while($vendor = mysqli_fetch_assoc($vendoroptionsql)){
            echo '<option value="'.$vendor['vendor_id'].'">'.$vendor['name'].'</option>';
        }
        ?>
        <input type="submit" value="Go">
    </form>
    <main>
        <?php 
        $vendoroptionsql = mysqli_query($connection,$query .= $where);
        while($vendor = mysqli_fetch_assoc($vendoroptionsql)){
            ?>
            <section>
            <a href="vendors.php?id=<?php echo $vendor['vendor_id'];?>"><img src="media/logos/<?php echo $vendor['logo']?>" alt="<?php echo $vendor['logo_alt'];?>" height="1024" width="1024"></a>
            <div class="card">
                    <a href="vendors.php?id=<?php echo $vendor['vendor_id'];?>">
                        <h2><?php echo $vendor['name'];?></h2>
                        <p><?php echo $vendor['booth_number'];?></p>
                        <p><?php echo $vendor['bio'];?></p>
                    </a>
                        <div class="contact">
                            <p>Email: <a href="email"><?php echo $vendor['email'];?></a></p>
                            <a href="https://www.instagram.com/<?php echo $vendor['instagram'];?>/"><img src="media/logos/instagramicon.svg" alt="">@<?php echo $vendor['instagram'];?></a>
                        </div>
                </div>
            </section>
         <?php 
        }
         ?>
    </main>
    <?php
    include ("includes/footer.php");
    ?>
</body>
</html>
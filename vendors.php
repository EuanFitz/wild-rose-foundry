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
    <title><?php
    
    if(isset($vendor_id)){
    $namequery = "SELECT * FROM vendors WHERE vendor_id = $vendor_id";
    $namesql = mysqli_query($connection,$namequery);
    $vendorname = mysqli_fetch_assoc($namesql);
    echo $vendorname['name'];
    }else{
        echo "Vendors";
        }?> || WildRose</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .vendor{
            display: grid;
            grid-template-columns: 1fr 3fr;
        }
        .vendor div{
            margin: 2rem 1rem;
        }
        .vendor img{
            max-width: 100%;
            height: auto;
        }
        .contact img{
            width: 25px;
        }
        .vendor .contact{
            display: flex;
            text-decoration: underline;
            gap: 2rem;
            margin-top: 3rem;
        }
        @media (max-width: 900px){
            main section > div{
                grid-column: span 2;
            }
        }
    </style>
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
            <section class="vendor">
            <a href="vendors.php?id=<?php echo $vendor['vendor_id'];?>"><img src="media/logos/<?php echo $vendor['logo']?>" alt="<?php echo $vendor['logo_alt'];?>" height="1024" width="1024"></a>
            <div class="card">
                    <a href="vendors.php?id=<?php echo $vendor['vendor_id'];?>">
                        <h2><?php echo $vendor['name'];?></h2>
                        <p>Booth: <?php echo $vendor['booth_number'];?></p>
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
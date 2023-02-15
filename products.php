<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php"); // connection to db
error_reporting(0);
session_start();

include_once 'product-action.php'; //including controller

?>


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title>Bagong Ani - Products</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet"> 
</head>

<body>    
    <!--header starts-->
    <?php
        include_once 'header.php';
    ?>


    <div class="page-wrapper">
        <!-- top Links -->
        <div class="top-links">
            <div class="container">
                <ul class="row links">
                    <li class="col-xs-12 col-sm-4 link-item"><span>1</span><a href="farms.php">Choose A Preferred Farm</a></li>
                    <li class="col-xs-12 col-sm-4 link-item active"><span>2</span><a href="#">Pick Your Desired Product</a></li>                    
                    <li class="col-xs-12 col-sm-4 link-item"><span>3</span><a href="#">Order And Pay Online</a></li>
                </ul>
            </div>
        </div>
        <!-- end:Top links -->

        <!-- start: Inner page hero -->
        <?php 
            $ress= mysqli_query($db,"select * from farms where farm_id='$_GET[farm_id]'");
            $rows=mysqli_fetch_array($ress);
            print_r($_GET["product_id"]);							  
        ?>

        <section class="inner-page-hero bg-image" data-image-src="images/img/products.jpg">
            <div class="profile">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12  col-md-4 col-lg-4 profile-img">
                            <div class="image-wrap">
                                <figure><?php echo '<img src="data:image/jpeg;base64,'.base64_encode($rows['image']).'" alt="farm logo">'; ?></figure>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 profile-desc">
                            <div class="pull-left right-text white-txt">
                                <h6><a href="#"><?php echo $rows['title']; ?></a></h6>
                                <p><?php echo $rows['address']; ?></p>
                                <ul class="nav nav-inline">
                                    <li class="nav-item"> <a class="nav-link active" href="#"><i class="fa fa-check"></i> Min ₱ 100</a> </li>
                                    <li class="nav-item"> <a class="nav-link" href="#"><i class="fa fa-motorcycle"></i> 30 min</a> </li>
                                    <li class="nav-item ratings">
                                        <a class="nav-link" href="#"> 
                                            <span>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-o"></i>
                                            </span> 
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>	
                    </div>
                </div>
            </div>
        </section>
        <!-- end:Inner page hero -->

        
        <div class="container m-t-30">
            <div class="row">
                <div class="col-lg-6">
                    <div class="widget widget-cart">
                        <div class="widget-heading">
                            <h3 class="widget-title text-dark">Your Shopping Cart</h3>
                            <div class="clearfix"></div>
                        </div>
                        <div class="order-row bg-white">
                            <div class="widget-body">
                                <?php
                                    $item_total = 0;
                                    // fetch items define current into session ID
                                    foreach ($_SESSION["cart_item"] as $item){
                                ?>									
                                        
                                        <div class="title-row">     
                                            <div class="col-lg-6">                                       
                                                <?php                                                 
                                                    $fquery = mysqli_query($db,"select title from farms where farm_id='$item[farm_id]'");
                                                    $farm_title = mysqli_fetch_array($fquery);
                                                    echo $item["title"]; 
                                                ?>
                                            </div>
                                            <div class="col-lg-6">
                                                <?php echo "Farm: ".$farm_title['title']; ?>                                            
                                                <a href="products.php?farm_id=<?php echo $_GET['farm_id'];?>&action=remove&id=<?php echo $item["product_id"];?>">                                            
                                                <i class="fa fa-trash pull-right"></i></a>
                                            </div>
                                        </div>
                                            
                                        <div class="form-group row no-gutter">
                                            <div class="col-xs-4">
                                                <input type="text" class="form-control" readonly value='<?php echo "Price: ₱".$item["price"]; ?>'  id="exampleSelect1">                                                        
                                            </div>
                                            <div class="col-xs-4">
                                                <?php                                                 
                                                    $UOM_query = mysqli_query($db,"select UOM from products where product_id='$item[product_id]'");
                                                    $UOM = mysqli_fetch_array($UOM_query);
                                                ?>
                                                <input class="form-control" type="text" readonly value='<?php echo "| Quantity: ".$item["quantity"]." ".$UOM["UOM"]."(s)"; ?>' id="example-number-input"> 
                                            </div>
                                            <div class="col-xs-4">
                                                <input class="form-control" type="text" readonly value='<?php echo "| Total: ₱".($item["price"]*$item["quantity"]); ?>' id="example-number-input"> 
                                            </div>
                                        </div>
                                        
                                <?php
                                    $item_total += ($item["price"]*$item["quantity"]); // calculating current price into cart
                                    }
                                ?>	
                            </div>
                        </div>
                        <!-- end:Order row -->                             
                        <div class="widget-body">
                            <div class="price-wrap text-xs-center">
                                <p>TOTAL</p>
                                <h3 class="value"><strong><?php echo "₱".$item_total; ?></strong></h3>
                                <p>Free Shipping</p>
                                <?php if ($item_total > 0) { ?>
                                    <a href="checkout.php?farm_id=<?php echo $_GET['farm_id'];?>&action=check"  class="btn theme-btn btn-lg">Checkout</a>
                                <?php } else { ?>
                                    <a href="#" class="btn theme-btn btn-lg" disabled>Checkout</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <!-- end:Widget menu -->
                    <div class="menu-widget" id="2">
                        <div class="widget-heading">
                            <h3 class="widget-title text-dark">
                                Available Products from the Farm<a class="btn btn-link pull-right" data-toggle="collapse" href="#popular2" aria-expanded="true">
                                <i class="fa fa-angle-right pull-right"></i>
                                <i class="fa fa-angle-down pull-right"></i>
                                </a>
                            </h3>
                            <div class="clearfix"></div>
                        </div>
                        <div class="collapse in" id="popular2">
                            <?php  // display values and item of products/products
                                $stmt = $db->prepare("SELECT * FROM products WHERE farm_id='$_GET[farm_id]' ORDER BY (CASE WHEN product_id = '$_GET[product_id]' THEN 0 ELSE 1 END), product_id");
                                $stmt->execute();
                                $products = $stmt->get_result();
                                if (!empty($products)){
                                    foreach($products as $product){		 
                            ?>
                                    <div class="product-item">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-lg-8">
                                                <form method="post" action='products.php?farm_id=<?php echo $_GET['farm_id'];?>&action=add&id=<?php echo $product['product_id']; ?>'>
                                                    <div class="farm-logo pull-left">                                                        
                                                        <a class="farm-logo pull-left" href="#"><?php echo '<img src="data:image/jpeg;base64,'.base64_encode($product['image']).'" alt="products logo">'; ?></a>
                                                    </div>
                                                    <!-- end:Logo -->
                                                    <div class="farm-descr">
                                                        <h6><a href="#"><?php echo $product['title']; ?></a></h6>
                                                        <p> <?php echo $product['slogan']; ?></p>
                                                    </div>
                                                    <!-- end:Description -->
                                                </div>
                                                <!-- end:col -->
                                                <div class="col-xs-12 col-sm-12 col-lg-4 pull-right item-cart-info"> 
                                                    <span class="price pull-left" >₱<?php echo $product['price']; ?> per <?php echo $product['UOM']; ?></span>
                                                    <input class="b-r-0" type="text" name="quantity"  style="margin-left:70px;" value="1" size="2" />
                                                    <br>
                                                    <input type="submit" class="btn theme-btn" style="margin-left:40px;" value="Add To Cart" />
                                                </div>
                                            </form>
                                        </div>
                                        <!-- end:row -->
                                    </div>
                                    <!-- end:products item -->
                            <?php
                                    }
                                }
                                
                            ?>
                        </div>
                        <!-- end:Collapse -->
                    </div>
                    <!-- end:Widget menu -->
                    
                </div>
                <!-- end:Bar -->
            </div>
            <!-- end:row -->
        </div>
        <!-- end:Container -->            
    </div>
    <!-- end:page wrapper -->

    <!--footer starts-->
    <?php
        include_once 'footer.php';
    ?>
</body>
</html>

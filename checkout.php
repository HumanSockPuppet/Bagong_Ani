<!DOCTYPE html>
<html lang="en">

<?php
    include("connection/connect.php");
    include_once 'product-action.php';
    error_reporting(0);
    session_start();
    if(empty($_SESSION["user_id"])){
        header('location:login.php');
    }
    else{                                            
        foreach ($_SESSION["cart_item"] as $item){
            $item_total += ($item["price"]*$item["quantity"]);                       
            if($_POST['submit']){
            echo "User ID: ". $_SESSION["user_id"] . " | Product ID: " . $item["product_id"] . " | Farm ID: " . $item["farm_id"] . " | Title: " . $item["title"] . " | Quantity: " . $item["quantity"] . " | Price: " . $item["price"];
            echo '<br>';

            $buyers_user_id = $_SESSION["user_id"];
            $product_id = $item["product_id"];
            $farm_id = $item["farm_id"];
            $title = $item["title"];
            $price = $item["price"];
            $quantity = $item["quantity"];
            
            $date = date("Y-m-d h-i-s");
            $SQL = "INSERT INTO users_orders (buyers_user_id, product_id, farm_id, title, price, quantity, UOM, status, date) VALUES ('$buyers_user_id','$product_id','$farm_id','$title', '$price', '$quantity', '', 'getting prepared', '$date')";
            $result = mysqli_query($db,$SQL);
            if (!$result) {
                die("Query failed: " . mysqli_error($db));
            }                
            $UOM_query = "UPDATE users_orders uo JOIN products p ON p.product_id = uo.product_id SET uo.UOM = p.UOM WHERE p.product_id = '$item[product_id]'";
            mysqli_query($db,$UOM_query);
            unset($_SESSION["cart_item"]);
            header('location:index.php?order=success');
                
            }
        }
?>


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title>Bagong Ani - Checkout</title>
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
                    <li class="col-xs-12 col-sm-4 link-item"><span>2</span><a href="#">Pick Your Desired Product</a></li>
                    <li class="col-xs-12 col-sm-4 link-item active"><span>3</span><a href="#">Order And Pay Online</a></li>
                </ul>
            </div>
        </div>
        <!-- end:Top links -->
        
        <div class="container">
            <span style="color:green;">
                <?php echo $success; ?>
            </span>                
        </div>          
        
        <div class="container m-t-30">
            <form action="" method="post">
                <div class="widget clearfix">                
                    <div class="widget-body">
                        <form method="post" action="#">
                            <div class="row">                                
                                <div class="col-sm-12">
                                    <div class="cart-totals margin-b-20">
                                        <div class="cart-totals-title">
                                            <h4>Cart Summary</h4> 
                                        </div>
                                        <div class="cart-totals-fields">                                        
                                            <table class="table">
                                                <tbody>
                                                    <tr> <!-- cart summary --> 
                                                                    <div class="order-row bg-white">
                                                                        <div class="widget-body">
                                                                            <?php
                                                                                // fetch items define current into session ID
                                                                                foreach ($_SESSION["cart_item"] as $item){
                                                                            ?>									
                                                                                    
                                                                                    <div class="title-row">     
                                                                                        <div class="col-lg-6">                                       
                                                                                            <?php                                                 
                                                                                                $fquery = mysqli_query($db,"select title from farms where farm_id='$item[farm_id]'");
                                                                                                $farm_title = mysqli_fetch_array($fquery);
                                                                                                echo "Product: ".$item["title"]; 
                                                                                            ?>
                                                                                        </div>
                                                                                        <div class="col-lg-6">
                                                                                            <?php echo "Farm: ".$farm_title['title']; ?>
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
                                                                                }
                                                                            ?>	
                                                                        </div>
                                                                    </div>
                                                        <!-- /cart summary -->
                                                    </tr>
                                                    <tr>
                                                        <td>Cart Subtotal</td>
                                                        <td> <?php echo "₱".$item_total; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Shipping &amp; Handling</td>
                                                        <td>FREE SHIPPING</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-color"><strong>Total</strong></td>
                                                        <td class="text-color"><strong> <?php echo "₱".$item_total; ?></strong></td>
                                                    </tr>                                                
                                                </tbody>     
                                            </table>
                                        </div>
                                    </div>
                                    <!--cart summary-->
                                    <div class="payment-option">
                                        <ul class=" list-unstyled">
                                            <li>
                                                <label class="custom-control custom-radio  m-b-20">
                                                    <input name="mod" id="radioStacked1" checked value="COD" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">Payment on delivery</span>
                                                    <br> 
                                                    <span>Please send your cheque to Store Name, Store Street, Store Town, Store State / County, Store Postcode.</span> 
                                                </label>
                                            </li>
                                            <li>
                                                <label class="custom-control custom-radio  m-b-10">
                                                    <input name="mod"  type="radio" value="gcash" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description"><img src="images/gcash-logo.png" alt="" width="40"> Gcash </span> 
                                                </label>
                                            </li>
                                            <li>
                                                <label class="custom-control custom-radio  m-b-10">
                                                    <input name="mod"  type="radio" value="paymaya" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description"><img src="images/paymaya-logo.png" alt="" width="40"> Paymaya </span> 
                                                </label>
                                            </li>
                                            <li>
                                                <label class="custom-control custom-radio  m-b-10">
                                                    <input name="mod"  type="radio" value="unionbank" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description"><img src="images/unionbank-logo.png" alt="" width="40"> Unionbank </span> 
                                                </label>
                                            </li>
                                        </ul>
                                        <p class="text-xs-center"> <input type="submit" onclick="return confirm('Are you sure?');" name="submit"  class="btn btn-outline-success btn-block" value="Order Now"> </p>
                                    </div>
                                    </form>
                                </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>            
    </div>
    <!-- end:page wrapper -->     

    <!--footer starts-->
    <?php
        include_once 'footer.php';
    ?>
</body>

</html>

<?php
}
?>

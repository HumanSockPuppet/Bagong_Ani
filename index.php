<!DOCTYPE html>
<html lang="en">

<?php    
    include("connection/connect.php");  //include connection file
    error_reporting(0);  // using to hide undefine undex errors
    session_start(); //start temp session until logout/browser closed
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title>Bagong Ani</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom styles-->
    <link href="css/style.css" rel="stylesheet"> 
</head>

<body class="home">    
    <!--header starts-->
    <?php
        include_once 'header.php';
    ?>

    <!-- banner part starts -->
    <section class="hero bg-image" data-image-src="images/img/main.jpg" style="height: 400px;">
        <div class="hero-inner">
            <div class="container text-center hero-text font-white">
                <h1>Order Fresh Farm Produce </h1>
                <div class="banner-form">
                    <form class="form-inline" method="post">
                        <div class="form-group">                            
                            <div class="form-group">
                                <input type="text" class="form-control form-control-lg" id="exampleInputAmount" placeholder="Find farms and products..." name="search_term"> 
                            </div>
                        </div> 
                        <button type="submit" class="btn theme-btn btn-lg">Search</button>
                    </form>
                </div>                  
            </div>
        </div>
        <!--end:Hero inner -->
    </section>
    <!-- banner part ends --> 
	
    <!-- Popular block starts -->
    <section class="popular">
        <div class="container">
            <?php 
                echo '<div class="title text-xs-center m-b-30">';  // div container for the <h2> tag
                    if (isset($_POST['search_term']) && $_POST['search_term'] != NULL) 
                    {
                        echo "<h2>Product results for '" .$_POST["search_term"]. "'</h2>;";
                    }else {
                        echo '<h2>Available Products</h2>';
                    }

                echo '</div>

                <div class="row">';                        
                            if (isset($_POST['search_term'])) {   // if user inputted something in the search bar
                                $search_term = $_POST['search_term'];
                                $prod_query = mysqli_query($db,"SELECT p.* FROM products p JOIN farms f ON p.farm_id = f.farm_id WHERE f.user_id != '{$_SESSION["user_id"]}' AND p.title LIKE '%$search_term%'");
                            }else{  // just print out all products if no search activity
                                $prod_query = mysqli_query($db,"SELECT p.* FROM products p JOIN farms f ON p.farm_id = f.farm_id WHERE f.user_id != '{$_SESSION["user_id"]}'");
                            }

                            if (mysqli_num_rows($prod_query) > 0) {  //if search result is not null, print items
                                $product_array = array();
                                while ($a = mysqli_fetch_array($prod_query)) {
                                    $product_array[] = $a;
                                }
                                shuffle($product_array);
                                foreach ($product_array as $r) {
                                    echo '<div class="col-lg-2 product-item">
                                        <div class="product-item-wrap">
                                            <div class="figure-wrap bg-image" style="height:164px;" data-image-src="data:image/jpeg;base64,';?><?php echo base64_encode($r['image']); ?><?php echo'">
                                                <div class="distance"><i class="fa fa-pin"></i>1 km</div>
                                                <div class="rating pull-left"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> </div>
                                                <div class="review pull-left"><a href="#">1000 reviews</a> </div>
                                            </div>
                                            <div class="content"> 
                                                <center>
                                                    <h5><a href="products.php?farm_id='.$r['farm_id'].'&product_id='.$r['product_id'].'">' . $r['title'] . '</a></h5>
                                                    <div class="product-name">' . $r['slogan'] . '</div>
                                                </center>
                                            </div>
                                            <div class="content2">                                            
                                                <center>
                                                    <div class="price-btn-block"><span style="margin:0px;" class="price">₱'.$r['price'].'</span><br><p style="margin:0px;">per '.$r['UOM'].'</p> <a href="products.php?farm_id='.$r['farm_id'].'&product_id='.$r['product_id'].'" class="btn theme-btn-dash">Order Now</a></div>
                                                </center>
                                            </div>
                                        </div>
                                    </div>';
                                }
                            }else{ //if search result is NULL, print 'No results found.'
                                echo '<center><h5>No results found!</h5></center>';
                            }
                echo '</div>';
            ?>
        </div>
    </section>
    <!-- Popular block ends -->

    <!-- Featured farms starts -->
    <section class="featured-farms">
        <div class="container">
            <?php 
                echo '<div class="title text-xs-center m-b-30">';  // div container for the <h2> tag
                    if (isset($_POST['search_term']) && $_POST['search_term'] != NULL) 
                    {
                        echo "<h2>Farm results for '" .$_POST["search_term"]. "'</h2>;";
                    }else {
                        echo '<h2>Available Farms</h2>';
                    }
                echo '</div>
                
                <div class="row">;
                    <div class="farm-listing">';
                        if (isset($_POST['search_term'])) {   // if user inputted something in the search bar
                            $search_term = $_POST['search_term'];
                            $farm_query = mysqli_query($db,"SELECT * FROM farms WHERE user_id != '{$_SESSION["user_id"]}' AND title LIKE '%$search_term%'");
                        }else{  // just print out all farms if no search activity
                            $farm_query = mysqli_query($db,"SELECT * FROM farms  WHERE user_id != '{$_SESSION["user_id"]}'");
                        }

                        if (mysqli_num_rows($farm_query) > 0) { //if search result is not null, print items
                            $farm_array = array();
                            while ($b = mysqli_fetch_array($farm_query)) {
                                $farm_array[] = $b;
                            }
                            shuffle($farm_array);
                            foreach ($farm_array as $f) 
                            {
                                echo ' <div class="col-lg-4 single-farm all">
                                    <div class="farm-wrap">
                                        <div class="row">
                                            <div class="col-lg-3 text-xs-center">
                                                <a class="farm-logo" href="products.php?farm_id=' . $f['farm_id'] . '" > <img src="data:image/jpeg;base64,';?><?php echo base64_encode($f['image']); ?><?php echo'" " alt="farm logo"> </a>
                                            </div>
                                            <!--end:col -->
                                            <div class="col-lg-9">
                                                <h5><a href="products.php?farm_id=' . $f['farm_id'] . '" >' . $f['title'] . '</a></h5> <span>' . $f['address'] . '</span>
                                                <div class="bottom-part">
                                                    <div class="cost"><i class="fa fa-check"></i> Min ₱ 100</div>
                                                    <div class="mins"><i class="fa fa-motorcycle"></i> 30 min</div>
                                                    <div class="ratings"> 
                                                        <span>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-o"></i>
                                                        </span> (122 reviews) 
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end:col -->
                                        </div>
                                        <!-- end:row -->
                                    </div>
                                    <!--end:farm wrap -->
                                </div>';
                            }
                        }else{ //if search result is NULL, print 'No results found.'
                            echo '<center><h5>No results found!</h5></center>';
                        }                     
                    echo '</div>
                </div>';
            ?>
        </div>
    </section>
    <!-- Featured farms ends -->

    <!--footer starts-->
    <?php
        include_once 'footer.php';
    ?>
</body>
</html>
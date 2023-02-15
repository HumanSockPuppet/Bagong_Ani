<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
error_reporting(0);
session_start();
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title>Bagong Ani - Farms/Sellers</title>
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
                    <li class="col-xs-12 col-sm-4 link-item active"><span>1</span><a href="farms.php">Choose A Preferred Farm</a></li>
                    <li class="col-xs-12 col-sm-4 link-item"><span>2</span><a href="#">Pick Your Desired Product</a></li>
                    <li class="col-xs-12 col-sm-4 link-item"><span>3</span><a href="#">Order And Pay Online</a></li>
                </ul>
            </div>
        </div>
        <!-- end:Top links -->

        <!-- start: Inner page hero -->
        <div class="hero bg-image" data-image-src="images/img/farm2.jpg">
            <div class="hero-inner">
                <div class="container text-center hero-text font-white">
                    <h1>Choose your preferred farm or seller</h1>                 
                </div>
            </div>
            <!--end:Hero inner -->
        </div>

        <!-- Featured farms starts -->
        <section class="featured-farms">
            <div class="container">
                <!-- farms listing starts -->
                <div class="row">
                    <div class="farm-listing">
                        <?php  //fetching records from table and filter using html data-filter tag
                        $farm_query= mysqli_query($db,"SELECT * FROM farms WHERE user_id != '{$_SESSION["user_id"]}'");
                        $farm_array = array();
                        while($b = mysqli_fetch_array($farm_query))
                        {
                            $farm_array[] = $b;
                        }
                        shuffle($farm_array); 
                            foreach($farm_array as $f)
                            {
                                echo ' <div class="col-lg-4 single-farm all">
                                    <div class="farm-wrap">
                                        <div class="row">
                                            <div class="col-lg-3 text-xs-center">
                                                <a class="farm-logo" href="products.php?farm_id=' . $f['farm_id'] . '" > <img src="data:image/jpeg;base64,';?><?php echo base64_encode($f['image']); ?><?php echo'" " alt="farm logo"> </a>
                                            </div>
                                            <!--end:col -->
                                            <div class="col-lg-9">
                                                <h5><a href="products.php?farm_id='.$f['farm_id'].'" >'.$f['title'].'</a></h5> <span>'.$f['address'].'</span>
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
                        ?>
                    </div>
                </div>
                <!-- farms listing ends -->
            </div>
        </section>
        <!-- Featured farms ends -->        
    </div>

    <!--footer starts-->
    <?php
        include_once 'footer.php';
    ?>
</body>
</html>
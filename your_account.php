<!DOCTYPE html>
<html lang="en">

<?php // connect db
    include("connection/connect.php");
    error_reporting(0);
    session_start();

    if(empty($_SESSION['user_id']))  //if usser is not login redirected baack to login page
    {
        header('location:login.php');
    }
    else
    {

    $edit_farm_id = null;
    $edit_prod_id = null;
    $farmID_prod_edit = 0;
    $productID_edit = 0;
?>

<?php // submit farm
    if(isset($_POST["submit_farm"])) {
        $user_id = $_SESSION["user_id"];
        $title = $_POST["title"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $url = $_POST["url"];
        $open_hour = $_POST["open_hour"];
        $close_hour = $_POST["close_hour"];
        $open_days = $_POST["open_days"];
        $address = $_POST["address"];
        if (!empty($_FILES["image"]["tmp_name"])) {
            $image = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));
        } else {
            $image = '';
        }
        $date = date("Y-m-d h-i-s");

        $sql = "INSERT INTO farms (user_id, title, email, phone, url, open_hour, close_hour, open_days, address, image, date)
            VALUES ('$user_id', '$title', '$email', '$phone', '$url', '$open_hour', '$close_hour', '$open_days', '$address', '$image', '$date')";


        if (empty($title) || empty($email) || empty($phone) || empty($url) || empty($open_hour) || empty($close_hour) || empty($open_days) || empty($address) || empty($address)) {
            ?>
            <script>
                alert('Error: One or more inputs are empty');
            </script>
            <?php
        } else {
            mysqli_query($db, $sql);
            header("Location: your_account.php");
            ?>            
            <script>
                alert('Farm successfully added.');
            </script>
            <?php
        }        
    }
?>

<?php  // submit products
    if(isset($_POST["submit_prod"])) {
        $farm_id = $_POST["farm_id"];
        $title = $_POST["title"];
        $slogan = $_POST["slogan"];
        $UOM = $_POST["UOM"];
        $price = $_POST["price"];
        if (!empty($_FILES["image"]["tmp_name"])) {
            $image = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));
        } else {
            $image = '';
        }

        $sql = "INSERT INTO products (farm_id, title, slogan, price, UOM, image)
                VALUES ('$farm_id', '$title', '$slogan', '$price', '$UOM', '$image')";

        if (empty($title) || empty($slogan) || empty($price) || empty($image) || empty($UOM)) {
            ?>
            <script>
                alert('Error: One or more inputs are empty');
            </script>
            <?php
        } else {
            mysqli_query($db, $sql);
            ?>
            <script>
                alert('Product successfully added.');
            </script>
            <?php
        } 
    }
?>

<?php  // delete farms
    if(isset($_POST["delete_farm"])) {
        $id = $_POST["delete_farm"];
        $sql = "DELETE FROM farms WHERE farm_id = $id";
        $sql2 = "DELETE FROM products WHERE farm_id = $id";
        mysqli_query($db, $sql);
        mysqli_query($db, $sql2);  
        header("Location: your_account.php");
    }
?>

<?php  // delete products
    if(isset($_POST["delete_product"])) {
        $id = $_POST["delete_product"];
        $sql = "DELETE FROM products WHERE product_id = $id";
        mysqli_query($db, $sql);
        header("Location: your_account.php");
    }
?>

<?php  // edit farms
    if(isset($_POST["edit_farm"])) {
        $farm_id = $_POST["farm_id"];
        $title = $_POST["title"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $url = $_POST["url"];
        $open_hour = $_POST["open_hour"];
        $close_hour = $_POST["close_hour"];
        $open_days = $_POST["open_days"];
        $address = $_POST["address"];
        if (!empty($_FILES["image"]["tmp_name"])) {
            $image = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));
        } else {
            $image = '';
        }

        $sql = "UPDATE farms SET 
            title = '$title',
            email = '$email',
            phone = '$phone',
            url = '$url',
            open_hour = '$open_hour',
            close_hour = '$close_hour',
            open_days = '$open_days',            
            address = '$address'
        WHERE farm_id = '$farm_id'";

        

        if (empty($title) || empty($email) || empty($phone) || empty($url) || empty($open_hour) || empty($close_hour) || empty($open_days) || empty($address)) {
            ?>
            <script>
                alert('Error: One or more inputs are empty');
            </script>
            <?php
        } else {
            mysqli_query($db, $sql);
            ?>
            <script>
                alert('Farm successfully edited.');
            </script>
            <?php
        }

        
        $sql2 = "UPDATE farms SET 
            image = '$image'
        WHERE farm_id = '$farm_id'";

        if (!empty($image)) {
            mysqli_query($db, $sql2);
        } 
        
    }
?>


<?php  // edit products
    if(isset($_POST["edit_prod"])) {
        $product_id = $_POST["product_id"];
        $title = $_POST["prod_title"];
        $slogan = $_POST["prod_slogan"];
        $price = $_POST["prod_price"];
        $UOM = $_POST["prod_UOM"];
        if (!empty($_FILES["prod_image"]["tmp_name"])) {
            $image = addslashes(file_get_contents($_FILES["prod_image"]["tmp_name"]));
        } else {
            $image = '';
        }

        $sql = "UPDATE products SET 
            title = '$title',            
            slogan = '$slogan',            
            price = '$price',
            UOM = '$UOM'
        WHERE product_id = '$product_id'";

        if (empty($title) || empty($slogan) || empty($price) || empty($UOM)) {
            ?>
            <script>
                alert('Error: One or more inputs are empty');
            </script>
            <?php
        } else {
            mysqli_query($db, $sql);
            ?>
            <script>
                alert('Product successfully edited.');
            </script>
            <?php
        } 

        $sql2 = "UPDATE products SET 
            image = '$image'
        WHERE product_id = '$product_id'";

        if (!empty($image)) {
            mysqli_query($db, $sql2);
        } 
    }
?>

<?php  // edit orders
    if(isset($_POST["edit_order"])) {
        $order_id = $_POST["order_id"];
        $status = $_POST["status"];

        $sql = "UPDATE users_orders SET 
            status = '$status'
        WHERE order_id = '$order_id'";
        
        mysqli_query($db, $sql);       
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
    <title>Bagong Ani - Your Account</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <style type="text/css" rel="stylesheet">

        #farm-form, #prod-form {
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 2px 2px 5px #ccc;
            width: 90%;
            margin: 10px auto;
        }

        input[type="text"], input[type="number"], select {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 100%;
            margin-top: 0px;
            font-size: 16px;
            box-sizing: border-box;
        }

        input[type="file"]{
            padding: 10px;
            width: 100%;
            margin-top: 0px;
            font-size: 16px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            margin-top: 20px;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #3e8e41;
        }

        label {
            margin: 0;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .col-3 {
            width: 25%;
            padding: 0px;
            margin: 0px;
        }

        .form-container {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        .form-column {
            width: 49%;
        }


        table { 
            width: 1200px; 
            border-collapse: collapse; 
            margin: auto;
            
            }

        /* Zebra striping */
        tr:nth-of-type(odd) { 
            background: #eee; 
            }

        th { 
            background: #ff3300; 
            color: white; 
            font-weight: bold; 
            
            }

        td, th { 
            padding: 10px; 
            border: 1px solid #ccc; 
            text-align: center; 
            font-size: 14px;            
            }

        /* 
        Max width before this PARTICULAR table gets nasty
        This query will take effect for any screen smaller than 760px
        and also iPads specifically.
        */
        @media 
        only screen and (max-width: 760px),
        (min-device-width: 768px) and (max-device-width: 1024px){

            table { 
                width: 100%; 
            }

            /* Force table to not be like tables anymore */
            table, thead, tbody, th, td, tr { 
                display: block; 
            }
            
            /* Hide table headers (but not display: none;, for accessibility) */
            thead tr { 
                position: absolute;
                top: -9999px;
                left: -9999px;
            }
            
            tr { border: 1px solid #ccc; }
            
            td { 
                /* Behave  like a "row" */
                border: none;
                border-bottom: 1px solid #eee; 
                position: relative;
                padding-left: 50%; 
            }

            td:before { 
                /* Now like a table header */
                position: absolute;
                /* Top/left values mimic padding */
                top: 6px;
                left: 6px;
                width: 45%; 
                padding-right: 10px; 
                white-space: nowrap;
                /* Label the data */
                content: attr(data-column);

                color: #000;
                font-weight: bold;
            }
        }
    </style>
</head>

<body>    
    <!-- Header -->
    <?php
        include_once 'header.php';
    ?>

    <!-- Inner page hero -->
    <div class="hero bg-image" style="height:200px; background-image: url('images/img/farm2.jpg');">
        <div class="hero-inner">
            <div class="container text-center hero-text font-white">
                <?php
                    $name_result = mysqli_query($db, "SELECT first_name FROM users WHERE user_id='".$_SESSION['user_id']."'");
                    $name = mysqli_fetch_all($name_result, MYSQLI_ASSOC);         
                ?>
                <h1>Welcome back, <?php echo $name[0]['first_name']; ?></h1>                 
            </div>
        </div>        
    </div>
    <!--end: Inner page hero -->
      
    <!-- add/edit farms,products-->
    <div class="row" style="margin-top:40px;">
        <!-- add farms -->
        <div class="col-3">
            
            <form id="farm-form" action="" method="post" enctype="multipart/form-data">
                <h2 style="text-align: center;">Add Farm</h2><br>
                <div class="form-container">
                    <div class="form-column">
                        <label>Farm Title: </label>
                        <input type="text" name="title" placeholder="Title">
                        <label>Email: </label>
                        <input type="text" name="email" placeholder="Email">
                        <label>Phone: </label>
                        <input type="text" name="phone" placeholder="Phone">
                        <label>Website: </label>
                        <input type="text" name="url" placeholder="URL">
                    </div>

                    <div class="form-column">
                        <label>Time Open: </label>
                        <input type="text" name="open_hour" placeholder="Open Hour">
                        <label>Time Closed: </label>
                        <input type="text" name="close_hour" placeholder="Close Hour">
                        <label>Days Open: </label>
                        <input type="text" name="open_days" placeholder="Open Days">
                        <label>Address: </label>
                        <input type="text" name="address" placeholder="Address">
                        
                    </div>
                </div>
                <br>
                <label>Upload Farm Photo: </label>
                <input type="file" name="image" placeholder="Image">     
                <input type="submit" name="submit_farm" value="Add Farm">
            </form>
        </div>
        <!-- end: add farms -->

        <!-- add product -->
        <div class="col-3">
            <form id="prod-form" action="" method="post" enctype="multipart/form-data">
                <h2 style="text-align: center;">Add Product</h2><br>
                <label>Select Farm: </label>                    
                <select id="prod_add_farm_id" name="farm_id">
                    <option value="" style="text-align: center;">------------Select a Farm------------</option>
                    <?php
                    $sql = "SELECT farm_id, title FROM farms WHERE user_id='".$_SESSION['user_id']."'";
                    $result = mysqli_query($db, $sql);
                    while($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . $row['farm_id'] . '">' . $row['title'] . '</option>';
                    }
                    ?>
                </select>
                <label>Product Title: </label>
                <input type="text" name="title" placeholder="Title">
                <label>Slogan: </label>
                <input type="text" name="slogan" placeholder="Slogan">
                <label>Price: </label>
                <input type="number" name="price" placeholder="Price">
                <label>Unit of Measurement: </label>
                <select id="UOM_select" name="UOM">
                    <option style="text-align: center;">-------Select a Unit of Measurement-------</option>
                    <option style="text-align: center;" disabled>Weight</option>
                    <option>gram</option>
                    <option>kilo</option>
                    <option>ton</option>
                    <option style="text-align: center;" disabled>Volume</option>
                    <option>liter</option>
                    <option>gallon</option>
                    <option>cubic meter</option>
                    <option style="text-align: center;" disabled>Quantity</option>
                    <option>piece</option>
                    <option>bundle</option>
                    <option>sack</option>
                </select>
                <br><br>
                <label>Upload Product Photo: </label>
                <input type="file" name="image" placeholder="Image">
                <input type="submit" name="submit_prod" id="submit_prod" value="Add Product" disabled>
            </form>
        </div>
        <!-- end: add product -->

        <!-- edit farms -->
        <div class="col-3">
            <!-- add farms and products part-->
            <form id="farm-form" action="" method="post" enctype="multipart/form-data">
                <h2 style="text-align: center;">Edit Farm</h2><br>
                <div>
                    <label>Select Farm: </label>
                    <select id="farm_select" name="farm_select">
                        <option value="" style="text-align: center;">------------Select a Farm------------</option>
                        <?php
                        $sql = "SELECT farm_id, title FROM farms WHERE user_id='".$_SESSION['user_id']."'";
                        $result = mysqli_query($db, $sql);
                        while($row = mysqli_fetch_assoc($result)) {
                            echo '<option value="' . $row['farm_id'] . '">' . $row['title'] . '</option>';
                            $edit_farm_id = $row['farm_id'];
                        }
                        ?>
                    </select>   
                </div>

                <div class="form-container">
                    <div class="form-column">                            
                        <input type="text" id="farm_id" name="farm_id" style="display: none;">
                        <label>Edit Title: </label>
                        <input type="text" id="title" name="title" placeholder="Title">
                        <label>Edit Email: </label>
                        <input type="text" id="email" name="email" placeholder="Email">
                        <label>Edit Phone: </label>
                        <input type="text" id="phone" name="phone" placeholder="Phone">
                        <label>Edit Website: </label>
                        <input type="text" id="url" name="url" placeholder="Website">
                    </div>
                    

                    <div class="form-column">
                        <label>Edit Hour Open: </label>
                        <input type="text" id="open_hour" name="open_hour" placeholder="Time Open">
                        <label>Edit Hour Closed: </label>
                        <input type="text" id="close_hour" name="close_hour" placeholder="Time Closed">
                        <label>Edit Days Open: </label>
                        <input type="text" id="open_days" name="open_days" placeholder="Days Open">
                        <label>Edit Address: </label>
                        <input type="text" id="address" name="address" placeholder="Address">                            
                    </div>
                    
                </div>
                <br>
                <label>Edit Farm Photo: </label>
                <input type="file" name="image" placeholder="Image">     
                <input type="submit" id="edit_farm" name="edit_farm" value="Edit Farm" disabled>
            </form>
        </div>
        <!-- end: edit farms -->

        <!-- edit product -->
        <div class="col-3">
            <form id="prod-form" action="" method="post" enctype="multipart/form-data">                     
                <h2 style="text-align: center;">Edit Product</h2><br>

                <label>Select Farm with Available Products: </label>
                <select id="farm_select_prod_edit">
                    <option value="0" style="text-align: center;">------------Select a Farm------------</option>
                    <?php
                        $sql = "SELECT farm_id, title FROM farms WHERE farm_id IN (SELECT farm_id FROM products) AND user_id='".$_SESSION['user_id']."'";
                        $result = mysqli_query($db, $sql);
                        while($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['farm_id'] . "'>" . $row['title'] . "</option>";
                        }
                    ?>
                </select>

                <label>Select Product: </label>
                <select id="product_select">
                    <?php
                        $sql = "SELECT product_id, title FROM products WHERE products.farm_id = $farmID_prod_edit";
                        $result = mysqli_query($db, $sql);
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='" . $row['product_id'] . "'>" . $row['title'] . "</option>";
                            $edit_prod_id = $row['product_id'];
                        }
                    ?>
                </select>                    

                <input type="text" id="product_id" name="product_id"  style="display: none;">
                <label>Edit Product Name: </label>
                <input type="text" name="prod_title" id="prod_title" placeholder="Title">
                <label>Edit Slogan: </label>
                <input type="text" name="prod_slogan" id="prod_slogan" placeholder="Slogan">
                <label>Edit Price: </label>
                <input type="number" name="prod_price" id="prod_price" placeholder="Price">
                <label>Edit Unit of Measurement: </label>
                <input type="text" name="prod_UOM" id="prod_UOM" placeholder="Unit of Measurement">                
                <br><br>
                <label>Edit Product Photo: </label>
                <input type="file" id="prod_image" name="prod_image" placeholder="Image">
                <input type="submit" id="edit_prod" name="edit_prod" value="Edit Product" disabled>
            </form>
        </div>
        <!-- end: edit product -->
    </div>
    <!-- end: add/edit farms,products-->

    <!-- show farms,products-->
    <div class="page-wrapper">   
        <h2 style="text-align:center;">Your Farms</h2> 
        <?php      
            $result = mysqli_query($db, "SELECT * FROM farms WHERE farms.user_id = '".$_SESSION['user_id']."'");
            while($row = mysqli_fetch_array($result)) {
            echo '<div class="col-lg-12">                  
                    <table style="margin-top: 40px;"> 
                        <tr>                    
                            <th>Farm ID</th>
                            <th>User ID</th>
                            <th>Title</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Url</th>
                            <th>Open Hour</th>
                            <th>Close Hour</th>
                            <th>Open Days</th>
                            <th>Address</th>
                            <th>Image</th>
                            <th>Date</th>
                            <th>Delete</th>
                            <th>Minimize</th>                                 
                        </tr>';                                

                        echo "<tr>";
                            echo "<td>" . $row["farm_id"] . "</td>";
                            echo "<td>" . $row["user_id"] . "</td>";
                            echo "<td>" . $row["title"] . "</td>";
                            echo "<td>" . $row["email"] . "</td>";
                            echo "<td>" . $row["phone"] . "</td>";
                            echo "<td>" . $row["url"] . "</td>";
                            echo "<td>" . $row["open_hour"] . "</td>";
                            echo "<td>" . $row["close_hour"] . "</td>";
                            echo "<td>" . $row["open_days"] . "</td>";
                            echo "<td>" . $row["address"] . "</td>";
                            echo '<td><img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" style="max-width: 150px; max-height: 150px;" /></td>';
                            echo "<td>" . $row["date"] . "</td>";
                            echo '<td>
                                <form action="your_account.php" method="post">                                    
                                    <input type="hidden" name="delete_farm" value="'; ?><?php echo $row["farm_id"]; echo '">
                                    <input type="submit" onclick="return confirm(\'Are you sure you want to delete the farm?\');" name="delete" value="Delete&#10;Farm">
                                </form>';
                            echo '</td>';
                            echo '<td>';
                                echo'<button id="minimize_btn_'; ?><?php echo $row["farm_id"]; ?><?php echo '" onclick="toggleTable(\''; ?><?php echo $row["farm_id"]; ?><?php echo '\')" style="
                                    background-color: #4CAF50;
                                    color: white;
                                    padding: 10px 20px;
                                    border-radius: 5px;
                                    border: none;
                                    cursor: pointer;
                                    margin-top: 20px;
                                    width: 100%;
                                ">Minimize<br>Products</button>';
                            echo '</td>';

                        echo "</tr>";
                                                                        
                        $result_prod = mysqli_query($db, "SELECT * FROM products WHERE products.farm_id = $row[farm_id]");                
                        if (mysqli_num_rows($result_prod) > 0) {
                            // code to process the result if it's not empty                    
                            echo '<div class="col-lg-10">
                                <table id="table_';?><?php echo $row['farm_id']; echo'" style="display: block;">
                                    <tr>
                                        <th></th>    
                                        <th>Farm ID</th>
                                        <th>Product ID</th>
                                        <th>Title</th>
                                        <th>Slogan</th>
                                        <th>Price</th>
                                        <th>UOM</th>
                                        <th>Image</th>
                                        <th>Delete</th>    
                                    </tr>';
                        } else {
                            // code to handle an empty result
                            echo '<div class="col-lg-10">
                            <table id="table_';?><?php echo $row['farm_id']; echo'" style="float: right; display: block;">';                                
                        }
                        while($row_prod = mysqli_fetch_array($result_prod)) {
                            echo "<tr>";
                                echo '<td><img src="images/arrow.png" style="max-width: 150px; max-height: 150px;" /></td>';                                
                                echo "<td>" . $row_prod["farm_id"] . "</td>";
                                echo "<td>" . $row_prod["product_id"] . "</td>";
                                echo "<td>" . $row_prod["title"] . "</td>";
                                echo "<td>" . $row_prod["slogan"] . "</td>";
                                echo "<td>" . $row_prod["price"] . "</td>";
                                echo "<td>" . $row_prod["UOM"] . "</td>";
                                echo '<td><img src="data:image/jpeg;base64,' . base64_encode($row_prod['image']) . '" style="max-width: 150px; max-height: 150px;" /></td>';
                                echo '<td>
                                    <form action="your_account.php" method="post">
                                        <input type="hidden" name="delete_product" value="';?><?php echo $row_prod["product_id"]; echo'">
                                        <input type="submit" onclick="return confirm(\'Are you sure you want to delete the product?\');" name="delete" value="Delete&#10;Product">
                                    </form>';
                                echo'</td>';
                            echo "</tr>";
                        }                     

                            echo "</table>";                    
                        echo "</div";
                    echo "</table>";             
            echo "</div>"; 
            }
        ?>
        <!-- end of add farms and products -->
    </div>
    <!-- end: show farms,products-->


    <div class="container" style="margin-top: 40px;"></div>
    <!-- orders from buyers-->
    <div style="margin-bottom: 40px;">
        <section class="orders-page" style="margin-top: 40px;">
            <div class="container">
                <button id="minimize_buyers_order" onclick="toggleTable2()">Minimize</button>
                <h2 style="text-align:center;">Orders from Buyers</h2>
                <div class="bg-gray farm-entry">
                    <div class="col-lg-12">
                        <table id="buyers_order_table" style="display: block;">
                            <thead>
                                <tr>                                        
                                    <th>Order ID</th>
                                    <th>Buyer Name</th>
                                    <th>Product ID</th>
                                    <th>Farm ID</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>UOM</th> 
                                    <th>Status</th>
                                    <th>Date</th>                                           
                                </tr>
                            </thead>
                            <tbody>                       
                
                                <?php 
                                    // displaying current session user login orders
                                    $buyers_orders = mysqli_query($db,"SELECT uo.* FROM users_orders uo JOIN farms f ON uo.farm_id = f.farm_id WHERE f.user_id = '{$_SESSION["user_id"]}'");                                  
                                    if(!mysqli_num_rows($buyers_orders) > 0 ){
                                        echo '<td colspan="10"><center>You have no current buyers.</center></td>';
                                    }
                                    else{
                                        while ($row = mysqli_fetch_array($buyers_orders)) {
                                ?>
                                            <tr>	
                                                <td data-column="order_id"><center> <?php echo $row['order_id']; ?></center></td>
                                                <td data-column="buyers_user_id"><center><?php 
                                                    $sql = mysqli_query($db,"SELECT first_name,last_name FROM users WHERE user_id = '".$row['buyers_user_id']."'");
                                                    $buyer_name = mysqli_fetch_array($sql);
                                                    echo $buyer_name['first_name']." ".$buyer_name['last_name']; 
                                                ?></center></td>
                                                <td data-column="product_id"><center><?php echo $row['product_id']; ?></center></td>
                                                <td data-column="farm_id"><center><?php echo $row['farm_id']; ?></center></td>
                                                <td data-column="title"><center><?php echo $row['title']; ?></center></td>                                           
                                                <td data-column="price"><center><?php echo $row['price']; ?></center></td>
                                                <td data-column="quantity"><center><?php echo $row['quantity']; ?></center></td> 
                                                <td data-column="UOM"><center><?php echo $row['UOM']; ?></center></td> 
                                                <td data-column="status"><center><?php echo $row['status']; ?></center>
                                                    <form action="your_account.php" method="post">
                                                        <select id="status_select" name="status" style="width:200px;">
                                                            <option style="text-align: center;">getting prepared</option>
                                                            <option style="text-align: center;">pending</option>
                                                            <option style="text-align: center;">closed</option>
                                                            <option style="text-align: center;">rejected</option>
                                                        </select>                                                                                            
                                                        <input type="hidden" id="order_id" name="order_id" value="<?php echo $row["order_id"] ?>" style="width:100px;">
                                                        <input type="submit" onclick="return confirm('Are you sure you want to edit the order status?');" id="edit_order" name="edit_order" value="Edit" style="width:70%;">
                                                    </form>
                                                </td> 
                                                <td data-column="date"><center><?php echo $row['date']; ?></center></td>                                                        
                                            </tr>

                                <?php
                                        } 
                                    }                                             
                                ?>	
                            </tbody>
                        </table>
                    </div>
                    <!--end:row -->
                </div>
            </div>
        </section>
    </div>
    <!-- end: orders from buyers-->


    <div class="container" style="margin-top: 40px;"></div>
    <!-- show orders-->
    <div style="margin-bottom: 40px;">
        <section class="orders-page" style="margin-top: 40px;">
            <div class="container">
                <button id="minimize_your_orders" onclick="toggleTable3()">Minimize</button>
                <h2 style="text-align:center;">Cart Order Status</h2>
                <div class="bg-gray farm-entry">
                    <div class="col-lg-12">
                        <table id="your_order_table" style="display: block;">
                            <thead>
                                <tr>                                        
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Unit of Measurement</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>                                            
                                </tr>
                            </thead>
                            <tbody>                       
                
                                <?php 
                                    // displaying current session user login orders 
                                    $query_res= mysqli_query($db,"select * from users_orders where buyers_user_id='".$_SESSION['user_id']."'");                                    
                                    if(!mysqli_num_rows($query_res) > 0 ){
                                        echo '<td colspan="8"><center>You have no orders placed.</center></td>';
                                    }
                                    else{
                                        while ($row = mysqli_fetch_array($query_res)) {
                                ?>
                                    
                                            <tr>	
                                                <td data-column="item"><center> <?php echo $row['title']; ?></center></td>
                                                <td data-column="quantity"><center><?php echo $row['quantity']; ?></center></td>
                                                <td data-column="UOM"><center><?php echo $row['UOM']; ?></center></td>
                                                <td data-column="price"><center>₱<?php echo $row['price']; ?></center></td>
                                                <td data-column="total"><center>₱<?php echo $row['price']*$row['quantity']; ?></center></td>
                                                
                                                <td data-column="status"><center> 
                                                    <?php
                                                    $status = $row['status'];
                                                    if ($status == "getting prepared") {
                                                        ?>

                                                        <button type="button" class="btn btn-info" style="font-weight:bold;">Preparation for Delivery</button>

                                                        <?php
                                                    }
                                                    if ($status == "pending") {
                                                        ?>

                                                        <button type="button" class="btn btn-warning"><span class="fa fa-cog fa-spin"  aria-hidden="true" ></span>On The Way</button>

                                                        <?php
                                                    }
                                                    if ($status == "closed") {
                                                        ?>

                                                        <button type="button" class="btn btn-success" ><span  class="fa fa-check-circle" aria-hidden="true">Delivered</button> 
                                                    
                                                        <?php
                                                    }
                                                    ?>
                                                    
                                                        <?php
                                                    if ($status == "rejected") {
                                                        ?>

                                                        <button type="button" class="btn btn-danger"> <i class="fa fa-close"></i>Cancelled</button>

                                                        <?php
                                                    }
                                                        ?>
                                                    </center>
                                                </td>
                                                <td data-column="Date"><center><?php echo $row['date']; ?></center></td>
                                                <td data-column="Action">
                                                    <center> 
                                                        <a href="delete_orders.php?order_del=<?php echo $row['order_id']; ?>" onclick="return confirm('Are you sure you want to cancel your order?');" class="btn btn-danger btn-flat btn-addon btn-xs m-b-10"><i class="fa fa-trash-o" style="font-size:16px"></i></a> 
                                                    </center>
                                                </td>                                                                
                                            </tr>

                                <?php
                                        } 
                                    }                                             
                                ?>	
                            </tbody>
                        </table>
                    </div>
                    <!--end:row -->
                </div>
            </div>
        </section>
    </div>
    <!-- end: show orders-->

    <!--footer starts-->
    <?php
        include_once 'footer.php';
    ?>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
   
    <script> //script for minimizing the product tables
        function toggleTable(farm_id) {
        var table = document.getElementById("table_" + farm_id);
        var btn = document.getElementById("minimize_btn_" + farm_id);

        if (table.style.display === "block") {
        table.style.display = "none";
        btn.innerHTML = "Maximize<br>Products";
        } else {
        table.style.display = "block";
        btn.innerHTML = "Minimize<br>Products";
        }
        }
    </script>

    <script> //script for automatic value of input when a farm is selected in edit farms
        var farmData = {
            <?php
            // Query to get all farm_id and title, user_id, email, phone, url, open_hour, close_hour from the farms table
            $query = "SELECT * FROM farms";
            $result = mysqli_query($db, $query);
            while ($row = mysqli_fetch_assoc($result)) {
            echo $row['farm_id'] . ': {"farm_id": "' . $row['farm_id'] . '", "title": "' . $row['title'] . '", "open_days": "' . $row['open_days'] . '", "email": "' . $row['email'] . '", "phone": "' . $row['phone'] . '", "url": "' . $row['url'] . '", "open_hour": "' . $row['open_hour'] . '", "close_hour": "' . $row['close_hour'] .'", "address": "' . $row['address'] .'"}, ';
            }
            ?>
        };

        document.getElementById("farm_select").addEventListener("change", function() {
            document.getElementById("farm_select").options[0].disabled = true;
            document.getElementById("edit_farm").removeAttribute("disabled");
            var selectedFarmId = this.value;
            var farm = farmData[selectedFarmId];
            document.getElementById("farm_id").value = farm.farm_id;
            document.getElementById("title").value = farm.title;
            document.getElementById("email").value = farm.email;
            document.getElementById("phone").value = farm.phone;
            document.getElementById("url").value = farm.url;
            document.getElementById("open_hour").value = farm.open_hour;
            document.getElementById("close_hour").value = farm.close_hour;
            document.getElementById("open_days").value = farm.open_days;
            document.getElementById("address").value = farm.address;
        });
    </script>

    <script> // script for the add products
        document.getElementById("prod_add_farm_id").addEventListener("change", function() {
            document.getElementById("prod_add_farm_id").options[0].disabled = true;
            document.getElementById("UOM_select").addEventListener("change", function() {
                document.getElementById("UOM_select").options[0].disabled = true;
                document.getElementById("submit_prod").removeAttribute("disabled");  
            });   
        }); 
    </script>

    <script>  // script for the edit products
        $("#product_select").change();

        document.getElementById("farm_select_prod_edit").addEventListener("change", function() {
            document.getElementById("farm_select_prod_edit").options[0].disabled = true;
            document.getElementById("edit_prod").removeAttribute("disabled");
        });

        $("#farm_select_prod_edit").change(function() {
            // Get the selected farm ID
            var farmID_prod_edit = $(this).val();
            // Refresh the options of the second select using the selected farm ID
            $.ajax({
            type: "POST",
            url: "get_products.php",
            data: { farm_id: farmID_prod_edit },
            success: function(data) {
                $("#product_select").html(data);
                $("#product_select").trigger("change");
            }
            });
        });

        $("#product_select").change(function() {
            // Get the selected product ID
            var productID_edit = $(this).val();
            // Get the product details using the selected product ID
            $.ajax({
            type: "POST",
            url: "get_product_details.php",
            data: { product_id: productID_edit },
            success: function(data) {
                var productDetails = JSON.parse(data);
                // Update the values of the input fields using the product details
                $("#product_id").val(productDetails.product_id);
                $("#prod_title").val(productDetails.title);
                $("#prod_slogan").val(productDetails.slogan);
                $("#prod_price").val(productDetails.price);
                $("#prod_UOM").val(productDetails.UOM);        
            }
            });    
        });

    </script>
        
    <script> //script for minimizing the buyers order tables
        function toggleTable2() {
        var table = document.getElementById("buyers_order_table");
        var btn = document.getElementById("minimize_buyers_order");

        if (table.style.display === "block") {
        table.style.display = "none";
        btn.innerHTML = "Maximize";
        } else {
        table.style.display = "block";
        btn.innerHTML = "Minimize";
        }
        }
    </script>

    <script> //script for minimizing the you order tables
        function toggleTable3() {
        var table = document.getElementById("your_order_table");
        var btn = document.getElementById("minimize_your_orders");

        if (table.style.display === "block") {
        table.style.display = "none";
        btn.innerHTML = "Maximize";
        } else {
        table.style.display = "block";
        btn.innerHTML = "Minimize";
        }
        }
    </script>
    
</body>

</html>
<?php
}
?>









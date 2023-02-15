<?php
include("connection/connect.php"); //connection to db
error_reporting(0);
session_start();

// sending query
mysqli_query($db,"UPDATE users_orders SET status = 'rejected' WHERE order_id = '".$_GET['order_del']."'"); // deletig records on the bases of ID
header("location:your_account.php");  //once deleted success redireted back to current page
?>

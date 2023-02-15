<?php // connect db
include("connection/connect.php");
?>

<?php
  // Check if product_id is received
  if(isset($_POST["product_id"])) {
    $productID_edit = $_POST["product_id"];
    // Get the product details using the selected product ID
    $sql = "SELECT product_id,title,slogan,price,UOM FROM products WHERE product_id = $productID_edit";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);
    // Output the product details as JSON
    echo json_encode($row);
  }
?>
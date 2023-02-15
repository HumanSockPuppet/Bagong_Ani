<?php // connect db
include("connection/connect.php");
?>

<?php
  // Check if farm_id is received
  if(isset($_POST["farm_id"])) {
    $farmID_prod_edit = $_POST["farm_id"];
    // Get the products using the selected farm ID
    $sql = "SELECT product_id, title FROM products WHERE farm_id = $farmID_prod_edit";
    $result = mysqli_query($db, $sql);
    // Generate the options for the second select    
    while($row = mysqli_fetch_assoc($result)) {
      echo "<option value='" . $row['product_id'] . "'>" . $row['title'] . "</option>";
    }
  }
?>

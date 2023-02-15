<!DOCTYPE html>
<html lang="en">

<?php
    include("connection/connect.php");
?>

<body>   
    <form action="search.php" method="post">
        <input type="text" name="search_term">
        <input type="submit" value="Search">
    </form>

    <?php
        if (isset($_POST['search_term'])) {
            $search_term = $_POST['search_term'];
            $query = "SELECT * FROM products WHERE title LIKE '%$search_term%'";
            $result = mysqli_query($db, $query);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo $row['product_id'] . " " . $row['title']; 
                    echo "<br>";
                }
            } else {
                echo "No results found.";
            }

            $query = "SELECT * FROM farms WHERE title LIKE '%$search_term%'";
            $result = mysqli_query($db, $query);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo $row['farm_id'] . " " . $row['title']; 
                    echo "<br>";
                }
            } else {
                echo "No results found.";
            }
        }
    ?>
</body>
</html>
<?php
    session_start();
    
    if(isset($_POST['productId'])) {
    $productId = $_POST['productId'];

    // Fetch the latest price from the menu table
    $query = "SELECT productPrice FROM `menu` WHERE productID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row['productPrice'];
    } else {
        echo '0'; // Handle the case where the product is not found
    }
}
?>
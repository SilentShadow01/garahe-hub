<?php
// Include the connection to the database
include '../assets/connection.php';

// Handle the updated value sent from the client
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['productID']) && isset($_POST['productQuantity'])) {
    $productID = intval($_POST['productID']);
    $updatedQuantity = intval($_POST['productQuantity']);

    // Update the product quantity in the users_cart_tbl table
    $updateQuery = "UPDATE users_cart_tbl SET productQuantity = $updatedQuantity WHERE productID = $productID";

    if (mysqli_query($conn, $updateQuery)) {
        echo "Product quantity updated successfully!";
    } else {
        echo "Error updating product quantity: " . mysqli_error($conn);
    }
}
?>

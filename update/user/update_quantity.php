<?php
include '../assets/connection.php'; // Include your database connection
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['productId']) && isset($_POST['newQuantity']) && isset($_SESSION['users_email'])) {
    $productId = $_POST['productId'];
    $newQuantity = $_POST['newQuantity'];
    $usersEmail = $_SESSION['users_email'];

    // Perform a query to update the quantity in the database
    $query = "UPDATE users_cart_tbl SET productQuantity = $newQuantity WHERE productID = '$productId' AND usersEmail = '$usersEmail'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Quantity updated successfully";
    } else {
        echo "Error updating quantity: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request";
}
?>

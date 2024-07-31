<?php
// cancelOrder.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection code here
    include '../assets/connection.php';

    // Retrieve the transaction number from the AJAX request
    $transactionNumber = $_POST["transactionNumber"];

    // Perform the cancellation logic
    // For example, update the order status to "cancelled" in your database
    $query = "UPDATE user_delivery_tbl SET orderStatus = 'cancelled' WHERE transactionNumber = '$transactionNumber'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Order cancelled successfully.";
    } else {
        echo "Error cancelling order.";
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    echo "Invalid request.";
}
?>

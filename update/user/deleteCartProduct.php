<?php
session_start();
include '../assets/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['users_email'])) {
        // Handle unauthorized access
        http_response_code(403); // Forbidden
        echo "Unauthorized access";
        exit();
    }

    // Sanitize and validate the product IDs
    $productIDs = isset($_POST['productID']) ? $_POST['productID'] : [];

    // Check if $productIDs is an array
    if (!is_array($productIDs)) {
        // Convert it to an array if it's not
        $productIDs = [$productIDs];
    }

    // Perform the deletion from the database using prepared statements
    $usersEmail = $_SESSION['users_email'];

    // Create placeholders for the product IDs
    $placeholders = implode(',', array_fill(0, count($productIDs), '?'));

    $query = "DELETE FROM users_cart_tbl WHERE usersEmail = ? AND productID IN ($placeholders)";

    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        // Combine the user's email and product IDs for binding
        $bindParams = array_merge(['s'], array_fill(0, count($productIDs), 's'));
        $bindValues = array_merge([$usersEmail], $productIDs);
        mysqli_stmt_bind_param($stmt, implode('', $bindParams), ...$bindValues);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>window.location.href='cart.php';</script>";
        } else {
            echo "Error deleting items: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }
} else {
    // Handle invalid request method
    http_response_code(405); // Method Not Allowed
    echo "Invalid request method";
}
?>

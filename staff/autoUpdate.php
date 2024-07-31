<?php
include '../assets/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the POST request
    $transactionNumber = $_POST['transactionNumber'];
    $newStatus = $_POST['newStatus'];

    // Update the reservation status in the database
    $query = "UPDATE users_reservation_tbl SET reservationStatus = ? WHERE transactionNumber = ?";
    $stmt = mysqli_prepare($conn, $query);
    
    // Bind parameters and execute the query
    mysqli_stmt_bind_param($stmt, 'ss', $newStatus, $transactionNumber);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        // Return success response if the update was successful
        echo json_encode(['status' => 'success', 'message' => 'Reservation status updated successfully.']);
    } else {
        // Return error response if the update failed
        echo json_encode(['status' => 'error', 'message' => 'Error updating reservation status.']);
    }

    // Close the statement and database connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    // Return error response if the request method is not POST
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>

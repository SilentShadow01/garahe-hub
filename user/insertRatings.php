<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include '../assets/connection.php';

    // Assuming you have productQualityRating and productID in the POST data
    $productQualityRating = $_POST['productQualityRating'];
    $productID = $_POST['productID'];

    // Assuming you have userID in your session
    $userID = $_SESSION['users_email'];

    // Check if the record already exists in the database
    $checkQuery = "SELECT * FROM user_ratings_tbl WHERE productID = ? AND userEmail = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param('ss', $productID, $userID);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // If the record exists, update it
        $updateQuery = "UPDATE user_ratings_tbl SET productQuality = ? WHERE productID = ? AND userEmail = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param('iss', $productQualityRating, $productID, $userID);
        $updateStmt->execute();
    } else {
        // If the record doesn't exist, insert it
        $insertQuery = "INSERT INTO user_ratings_tbl (productQuality, productID, userEmail) VALUES (?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param('iss', $productQualityRating, $productID, $userID);
        $insertStmt->execute();
    }

    // Close the database connection
    $conn->close();

    // Send a response if needed
    echo "Ratings updated/inserted successfully";
} else {
    // Handle invalid requests
    http_response_code(400);
    echo "Invalid request";
}
?>

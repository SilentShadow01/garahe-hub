<?php
// insertRatings.php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the ratings from the POST data
    $productQualityRating = $_POST["productQualityRating"];
    $deliveryServiceRating = $_POST["deliveryServiceRating"];

    // Include the database connection file
    include '../assets/connection.php';

    // Start the session
    session_start();

    // Get the user ID (you may need to modify this based on your authentication system)
    $userId = isset($_SESSION['users_email']) ? $_SESSION['users_email'] : null;

    // Insert the ratings into the user_ratings_tbl table
    if ($userId) {
        $timestamp = date("Y-m-d H:i:s"); // Current timestamp

        $insertQuery = "INSERT INTO user_ratings_tbl (userEmail, productQuality, deliveryService)
                        VALUES ('$userId', '$productQualityRating', '$deliveryServiceRating')";
        
        if ($conn->query($insertQuery) === TRUE) {
            // Successful insertion
            echo "Ratings inserted successfully!";
        } else {
            // Error in insertion
            http_response_code(500);
            echo "Error: " . $conn->error;
        }
    } else {
        // User not authenticated, handle accordingly
        http_response_code(401);
        echo "User not authenticated!";
    }
} else {
    // Invalid request method
    http_response_code(405);
    echo "Invalid request method!";
}
?>

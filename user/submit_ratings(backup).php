<?php
// Function to connect to the database
function connectToDatabase() {
    $servername = 'localhost';
    $username = 'lstvroot';
    $password = 'Lstv@2016';
    $dbname = 'bluebirdhotel';
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

// Function to get ratings data from the request
function getRatingsData() {
    $data = json_decode(file_get_contents('php://input'), true);
    error_log('Received data: ' . print_r($data, true));
    return $data;
}

// Function to update product rating in the database
function updateProductRating($conn, $productId, $ratingValue) {
    $stmt = $conn->prepare("SELECT productRating, ratingCount FROM product_tbl WHERE productID = ?");
    $stmt->bind_param('s', $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentRating = (float)$row['productRating'];
        $ratingCount = (int)$row['ratingCount'];

        // Compute the new rating
        $newRatingCount = $ratingCount + 1;
        $newRating = (($currentRating * $ratingCount) + $ratingValue) / $newRatingCount;

        $updateStmt = $conn->prepare("UPDATE product_tbl SET productRating = ?, ratingCount = ? WHERE productID = ?");
        $updateStmt->bind_param('dis', $newRating, $newRatingCount, $productId);

        if ($updateStmt->execute()) {
            $updateStmt->close();
            return ['status' => 'success', 'message' => 'Rating updated successfully'];
        } else {
            error_log("SQL Error: " . $updateStmt->error);
            $updateStmt->close();
            return ['status' => 'error', 'message' => 'Error updating rating'];
        }
    } else {
        return ['status' => 'error', 'message' => "Product ID $productId does not exist in the database"];
    }
}

// Function to handle ratings data and update the database
function handleRatings($conn, $data) {
    $response = ['status' => 'error', 'message' => 'No ratings received']; // Default response

    if (!empty($data['ratings'])) {
        foreach ($data['ratings'] as $rating) {
            $productId = $rating['productId']; // Use the productId from the request
            $ratingValue = (float)$rating['rating'];

            $response = updateProductRating($conn, $productId, $ratingValue);
        }
    } else {
        $response = ['status' => 'error', 'message' => 'No ratings data received'];
    }

    return $response;
}

// Main script execution
$conn = connectToDatabase();
$data = getRatingsData();
$response = handleRatings($conn, $data);

header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>

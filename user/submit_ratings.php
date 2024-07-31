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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = connectToDatabase();
    
    // Prepare SQL statement
    $stmt = $conn->prepare("UPDATE product_tbl SET productRating = ?, ratingCount = ratingCount + 1 WHERE productID = ?");
    
    // Retrieve ratings and product IDs
    $productIds = $_POST['ratings']['product_id'] ?? [];
    $ratings = $_POST['ratings']['rating'] ?? [];
    
    foreach ($productIds as $index => $productId) {
        $rating = $ratings[$index] ?? 0;
        
        // Bind parameters and execute statement
        $stmt->bind_param('is', $rating, $productId);
        $stmt->execute();
    }

    if ($stmt->affected_rows > 0) {
        echo "Ratings updated successfully.";
    } else {
        echo "No rows updated.";
    }
    
    // Close connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>

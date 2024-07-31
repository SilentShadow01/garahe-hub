<?php
    if (isset($_POST['addToCart' . $productID])) {
        

        $productQuantity = $_POST['productQuantity'];
        $usersEmail = $_SESSION['users_email'];
        $productID = $_SESSION['product_ID'];
        $productImage = $_SESSION['productImage'];
        $productName = $_SESSION['productName'];

        if ($productQuantity == 0) {
            echo "<script>alert('Product Quantity is 0.'); window.location.href = 'menu.php';</script>";
        }
        else
        {
            echo "<script>
                document.getElementById('addToCartMessage').innerText = 'Added to cart.';
                setTimeout(function() {
                    document.getElementById('addToCartMessage').innerText = '';
                    window.location.href='menu.php';
                }, 1500);  // Display the message for 5 seconds (5000 milliseconds)
            </script>";

            $stmt = $conn->prepare("SELECT * FROM users_cart_tbl WHERE productID = ? AND usersEmail = ?");
            $stmt->bind_param("ss", $productID, $usersEmail);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) { 
                $row = $result->fetch_assoc();
                $currentQuantity = $row['productQuantity'];
                $newQuantity = $currentQuantity + $productQuantity;
            
                $updateStmt = $conn->prepare("UPDATE users_cart_tbl SET productImage = ?, productName = ?, productQuantity = ?, productPrice = ? WHERE productID = ? AND usersEmail = ?");
                $updateStmt->bind_param("ssiiss", $productImage, $productName, $newQuantity, $productPrice, $productID, $usersEmail);
                $updateStmt->execute();
                $updateStmt->close();
                
            }
            else {
                // If the row doesn't exist, insert a new row
                $insertStmt = $conn->prepare("INSERT INTO users_cart_tbl (productID, usersEmail, productQuantity, productPrice, productImage, productName) VALUES (?, ?, ?, ?, ?, ?)");
                $insertStmt->bind_param("ssiiss", $productID, $usersEmail, $productQuantity, $productPrice, $productImage, $productName);
                $insertStmt->execute();
                $insertStmt->close();

            }

            // Close the original statement
            $stmt->close();
        }
    }

?>
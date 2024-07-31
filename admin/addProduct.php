<?php
include '../assets/connection.php';

if(isset($_POST['createProduct'])) {
    // Retrieve form inputs
    $productName = $_POST['productName'];
    $productQuantity = $_POST['productQuantity'];
    $productPrice = $_POST['productPrice'];
    $productID = $_POST['productID'];
    $productStatus = $_POST['productStatus'];
    $productCategory = $_POST['productCategory'];
    // Upload product image
    $productImage = $_FILES['productImage']['name'];
    $productImageTemp = $_FILES['productImage']['tmp_name'];
    $targetDirectory = "images/products/"; // Specify the directory where you want to store the uploaded images
    $imageFileType = strtolower(pathinfo($productImage, PATHINFO_EXTENSION));
    $allowedExtensions = array("jpg", "jpeg", "png", "gif"); // Allowed image file types
    $maxFileSize = 10 * 1024 * 1024; // 10MB

    // Check if the file is a valid image
    if (in_array($imageFileType, $allowedExtensions)) {
        // Check the file size
        if ($_FILES['productImage']['size'] <= $maxFileSize) {
            // Generate the new filename using the productID
            $newFilename = $productID . "." . $imageFileType;
            $targetFile = $targetDirectory . $newFilename;

            // Move the uploaded file to the target directory with the new filename
            if (move_uploaded_file($productImageTemp, $targetFile)) {
                // Check if productID already exists
                $checkQuery = "SELECT * FROM product_tbl WHERE productID = '$productID'";
                $checkResult = mysqli_query($conn, $checkQuery);

                if(mysqli_num_rows($checkResult) > 0) {
                    // Product ID already exists
                    $error[] = 'Product already exists!';
                }
                else {
                    // Insert data into the database
                    $query = "INSERT INTO product_tbl (productName, productPrice, productID, productImage, productCategory, productType, productStocks)
                            VALUES ('$productName', '$productPrice', '$productID', '$newFilename', '$productCategory', '$productStatus', '$productQuantity')";

                    if (mysqli_query($conn, $query)) {
                        echo "<script>window.location.href='products.php';</script>";
                    }
                    else {
                        // Error inserting product
                        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
                    }
                }
            }
            else {
                // Error moving uploaded file
                $error[] ='Error moving uploaded file.';
            }
        }
        else {
            // File size exceeds the limit
            $error[] ='File size exceeds the limit. Please upload an image up to 10MB in size.';
        }
    }
    else {
        // Invalid file type
        $error[] = 'Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.';
    }

    mysqli_close($conn);
}
if(isset($_POST['editRequestBtn']))
{
    $editProductName = $_POST['editProductName'];
    $editProductPrice = $_POST['editProductPrice'];
    $editProductStatus = $_POST['editProductStatus'];  // Changed the variable name
    $editProductID = $_POST['editProductID'];
    $productCategory = $_POST['productCategory'];
    $productQuantity = $_POST['productQuantity'];
    // Prepare the SQL query with placeholders
    $query = "UPDATE `product_tbl` SET `productName` = ?, `productPrice` = ?, `productType` = ?, `productCategory` = ?, `productStocks` = ? WHERE `productID` = ?";
    
    // Prepare the statement
    $stmt = $conn->prepare($query);

    // Bind the parameters and their types
    $stmt->bind_param("ssssss", $editProductName, $editProductPrice, $editProductStatus, $productCategory, $productQuantity, $editProductID);
    
    // Execute the statement
    $stmt->execute();

    // Check if the update was successful
    if ($stmt->affected_rows > 0) {
        // Update successful
        echo "<script>window.location.href='products.php';</script>";
    } else {
        // Update failed
        echo "Failed to update product.";
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteProductBtn'])) {
    $productID = $_POST['editProductID'];
 
    // Perform the deletion in your database
    $deleteQuery = "DELETE FROM product_tbl WHERE `productID` = '$productID'";
    $result = mysqli_query($conn, $deleteQuery);
 
    if ($result) {
       // Optionally, redirect back to the page after deletion
       echo "<script>window.location.href='products.php';</script>";
       exit();
    } else {
       // Handle database error
       echo "Error deleting record";
    }
 }
?>

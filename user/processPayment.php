<?php
include '../assets/connection.php';

if (!isset($_SESSION['users_email'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['placeOrder'])) {
    $receiverName = $_POST['receiverName'];
    $receiverPhoneNumber = $_POST['receiverPhoneNumber'];
    $userEmail = $_SESSION['users_email'];
    $modeOfClaim = $_POST['modeOfClaim'];
    $productIDs = $_POST['productID'];
    $productQuantities = $_POST['productQuantity'];
    $productNames = $_POST['productName'];
    $productPrices = $_POST['productPrice'];
    $transactionNumber = $_POST['transactionNumber'];
    $productImages = $_POST['productImage'];

    // IMAGE PROPERTIES
    $validID = isset($_FILES["paymentProof"]["tmp_name"]) ? addslashes(file_get_contents($_FILES["paymentProof"]["tmp_name"])) : '';
    $fileType = isset($_FILES["paymentProof"]["type"]) ? $_FILES["paymentProof"]["type"] : '';
    $fileSize = isset($_FILES["paymentProof"]["size"]) ? $_FILES["paymentProof"]["size"] : '';
    $fileName = isset($_FILES["paymentProof"]["name"]) ? $_FILES["paymentProof"]["name"] : '';
    $fileError = isset($_FILES["paymentProof"]["error"]) ? $_FILES["paymentProof"]["error"] : '';


    if ($fileError == 0)
    {
        if($fileSize > 10000000)
        {
            $error[] = 'File size is too large! File size must at least 10mb!';
        }
        else
        {
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            $fileExtensionLoc = strtolower($fileExtension);
            $allowedFileExtension = array("jpg", "jpeg", "png");
            if(in_array($fileExtensionLoc, $allowedFileExtension))
            {
                if($modeOfClaim === 'pickUp')
                {
                    $newFileName = 'PROOFOFPAYMENT-' . $transactionNumber . '.' . $fileExtensionLoc;
                    $filePath = 'images/proof/pickup/'.$newFileName;
                    move_uploaded_file($_FILES["paymentProof"]["tmp_name"], $filePath);
                    $newValidIDName = $newFileName;

                    // Initialize totalSum
                    $totalSum = 0;

                    // Iterate through each product and calculate total
                    for ($i = 0; $i < count($productIDs); $i++) {
                        $productID = $productIDs[$i];
                        $quantity = $productQuantities[$i];

                        // Calculate total price
                        $totalPrice = $quantity * $productPrices[$i];
                        $totalSum += $totalPrice;

                        // Prepare the UPDATE query to subtract purchased quantities from productStocks
                        $updateProductQuery = "UPDATE product_tbl 
                                            SET productStocks = productStocks - $quantity 
                                            WHERE productID = '$productID'";

                        // Execute the UPDATE query
                        mysqli_query($conn, $updateProductQuery);

                        // Prepare the DELETE query for the item in the cart
                        $deleteProductQuery = "DELETE FROM users_cart_tbl 
                                            WHERE productID = '$productID' 
                                            AND usersEmail = '$userEmail'";

                        // Execute the DELETE query
                        mysqli_query($conn, $deleteProductQuery);
                    }

                    // Insert order and product details in a single query
                    $insertOrderAndProductQuery = "INSERT INTO user_delivery_tbl (receiverName, receiverPhoneNumber, totalAmount, transactionNumber, modeOfClaim, proofOfPayment, productID, productName, productQuantity, productPrice, productImage, userEmailAddress, orderDate, orderTime)
                                            VALUES ('$receiverName', '$receiverPhoneNumber', '$totalSum', '$transactionNumber', '$modeOfClaim', '$newValidIDName', ?, ?, ?, ?, ?, ?, CURDATE(), TIME_FORMAT(CURTIME(), '%h:%i %p'))";


                    // Prepare the statement
                    $stmt = mysqli_prepare($conn, $insertOrderAndProductQuery);

                    if ($stmt) {
                        // Bind parameters and execute the statement for each product
                        for ($i = 0; $i < count($productIDs); $i++) {
                            mysqli_stmt_bind_param($stmt, 'sssdss', $productIDs[$i], $productNames[$i], $productQuantities[$i], $productPrices[$i], $productImages[$i], $userEmail);
                            mysqli_stmt_execute($stmt);
                        }

                        // Close the statement
                        mysqli_stmt_close($stmt);
                    } else {
                        // Handle the error, you can redirect the user to an error page or show a message
                        exit("Failed to prepare the statement. Please try again.");
                    }
                    echo "<script>window.location.href='orders.php';</script>";
                    exit();
                }
                else
                {
                    $userStreet = $_POST['userStreet'];
                    $PurokhouseNumber = $_POST['PurokhouseNumber'];
                    $userLandmark = $_POST['userLandmark'];
                    $newFileName = 'PROOFOFPAYMENT-' . $transactionNumber . '.' . $fileExtensionLoc;
                    $filePath = 'images/proof/pickup/'.$newFileName;
                    move_uploaded_file($_FILES["paymentProof"]["tmp_name"], $filePath);
                    $newValidIDName = $newFileName;
                    $receiverAddress = $_POST['receiverAddress'];
                    // Initialize totalSum
                    $totalSum = 0;

                    // Iterate through each product and calculate total
                    for ($i = 0; $i < count($productIDs); $i++) {
                        $productID = $productIDs[$i];
                        $totalPrice = $productQuantities[$i] * $productPrices[$i];
                        $totalSum += $totalPrice;
                        // Prepare the DELETE query
                        $deleteProductQuery = "DELETE FROM users_cart_tbl WHERE productID = '$productID' AND usersEmail = '$userEmail'";

                        // Execute the DELETE query
                        mysqli_query($conn, $deleteProductQuery);
                    }

                    // Insert order and product details in a single query
                    $insertOrderAndProductQuery = "INSERT INTO user_delivery_tbl (userStreet, userPurok, userLandmark, receiverName, receiverPhoneNumber, receiverAddress, totalAmount, transactionNumber, modeOfClaim, proofOfPayment, productID, productName, productQuantity, productPrice, productImage, userEmailAddress, orderDate, orderTime)
                                            VALUES ('$userStreet', '$PurokhouseNumber', '$userLandmark', '$receiverName', '$receiverPhoneNumber', '$receiverAddress', '$totalSum', '$transactionNumber', '$modeOfClaim','$newValidIDName',  ?, ?, ?, ?, ?, ?, CURDATE(), TIME_FORMAT(CURTIME(), '%h:%i %p'))";


                    // Prepare the statement
                    $stmt = mysqli_prepare($conn, $insertOrderAndProductQuery);

                    if ($stmt) {
                        // Bind parameters and execute the statement for each product
                        for ($i = 0; $i < count($productIDs); $i++) {
                            mysqli_stmt_bind_param($stmt, 'sssdss', $productIDs[$i], $productNames[$i], $productQuantities[$i], $productPrices[$i], $productImages[$i], $userEmail);
                            mysqli_stmt_execute($stmt);
                        }

                        // Close the statement
                        mysqli_stmt_close($stmt);
                    } else {
                        // Handle the error, you can redirect the user to an error page or show a message
                        exit("Failed to prepare the statement. Please try again.");
                    }
                    echo "<script>window.location.href='orders.php';</script>";
                    exit();
                }
            }
            else
            {
                $error[] = 'Only jpg, jpeg, and png files are allowed!';
            }
        }
    }
    else
    {
        echo "<script>alert('An error has been encountered!');</script>";
    }
}
?>

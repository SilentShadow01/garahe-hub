<?php
    include '../assets/connection.php';
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editOrderStatus'])) {
        // Get the form data
        $userEmailAddress = mysqli_real_escape_string($conn, $_POST['userEmailAddress']);
        $orderDate = date('Y-m-d', strtotime($_POST['orderDate']));
        $orderTime = mysqli_real_escape_string($conn, $_POST['orderTime']);
        $newOrderStatus = mysqli_real_escape_string($conn, $_POST['orderStatus']);
        // var_dump($_POST);
        // Fetch the rows that match the condition
        $additionalSql = "SELECT * FROM user_delivery_tbl WHERE orderDate = '$orderDate' AND orderTime= '$orderTime'";
        // var_dump($additionalSql);
        $additionalResult = mysqli_query($conn, $additionalSql);
        while ($additionalRow = mysqli_fetch_assoc($additionalResult))
        {
            // var_dump($additionalRow);
            $rowID = $additionalRow['ID'];
            // var_dump($rowID); 
            $updateQuery = "UPDATE user_delivery_tbl SET orderStatus = '$newOrderStatus' WHERE ID = '$rowID'";
            $updateResult = mysqli_query($conn, $updateQuery);
        }
        header("Location: toReceived.php");
    }
?>
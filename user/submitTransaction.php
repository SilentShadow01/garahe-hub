<?php 
$servername = 'localhost';
$username = 'lstvroot';
$password = 'Lstv@2016';
$dbname = 'bluebirdhotel';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
   $transactionNumber = mysqli_real_escape_string($conn, $_POST['transactionNumber']);

    // Insert transactionNumber into transaction_num_rated_tbl
    $insertSql = "INSERT INTO transaction_num_rated_tbl (transactionNumber) VALUES ('$transactionNumber')";

    if (mysqli_query($conn, $insertSql)) {
        echo "<script>window.location.href='orders.php';</script>";
    } else {
        echo "Error inserting transaction number: " . mysqli_error($conn);
    }
} else {
    echo "Transaction number not received or invalid request method.";
}

mysqli_close($conn);
?>
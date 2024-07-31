<?php
include 'connection.php';
if (isset($_POST['emailAddress'])) {
    // Get the email address from the AJAX request
    $email = $_POST['emailAddress'];

    $stmt = $conn->prepare("SELECT userEmailAddress FROM usermanagement_tbl WHERE userEmailAddress = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if there are any rows with the given email
    if ($stmt->num_rows == 1) {
        echo "Email address is already exist!";
    } 
    else 
    {
    }

    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();
}
?>

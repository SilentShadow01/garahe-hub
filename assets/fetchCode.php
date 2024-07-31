<?php
include 'connection.php';
$requestData = json_decode(file_get_contents('php://input'));
if (isset($requestData->getCodeInput) && isset($requestData->getInputEmail)) {
    $codeInput = $requestData->getCodeInput;
    $emailAddressPlaceholder = $requestData->getInputEmail;

    // Use prepared statements to prevent SQL injection
    $query = "SELECT * FROM `userverification_tbl` WHERE `userEmail` = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $emailAddressPlaceholder);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $databaseCode = $row['verificationCode'];

        if ($codeInput != $databaseCode) {
            echo "not match";
        } else if ($codeInput == $databaseCode){
            echo "success";
        }
    } else {
        echo "does not exist";
    }
} else {
    echo "error"; // Handle the case where data is not provided properly
}
?>

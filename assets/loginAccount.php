<?php
session_start();
include 'connection.php';
$requestData = json_decode(file_get_contents('php://input'));
if (isset($requestData->valueEmail) && isset($requestData->valuePassword)) {
    $inputEmail = $requestData->valueEmail;
    $inputPassword = $requestData->valuePassword;

    $query = "SELECT * FROM `usermanagement_tbl` WHERE `userEmailAddress` = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $inputEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $databasePassword = $row['userPassword'];

        if ($inputPassword != $databasePassword) {
            echo json_encode(array("error" => "Password do not match!"));
        } else if ($inputPassword == $databasePassword){
            $userType = $row['userType'];
            $userFirstName = $row['firstName'];
            if($userType == "user") {
                $_SESSION['users_name'] = filter_var($row['firstName'], FILTER_SANITIZE_STRING);
                $_SESSION['users_email'] = filter_var($row['userEmailAddress'], FILTER_SANITIZE_STRING);
                echo json_encode(array("type" => "user", "firstName" => $userFirstName));
            } else if($userType == "admin") {
                $_SESSION['admin_name'] = filter_var($row['firstName'], FILTER_SANITIZE_STRING);
                echo json_encode(array("type" => "admin", "firstName" => $userFirstName));
            }else if($userType == "staff") {
                $_SESSION['admin_name'] = filter_var($row['firstName'], FILTER_SANITIZE_STRING);
                echo json_encode(array("type" => "staff", "firstName" => $userFirstName));
            }
        }
        
    } else {
        echo json_encode(array("error" => "Account does not exist!"));
    }

    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();
}
?>

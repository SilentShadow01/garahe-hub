<?php
include 'connection.php'; // Ensure you have a valid database connection here

if (
    isset($_POST['inputFirstName']) && isset($_POST['inputMiddleName']) &&
    isset($_POST['inputLastName']) && isset($_POST['inputExtensionName']) && isset($_POST['inputEmailAddress']) &&
    isset($_POST['inputUserPassword']) && isset($_POST['inputContactNumber']) && isset($_POST['inputUserAddress'])
) {
    $inputFirstName = $_POST['inputFirstName'];
    $inputMiddleName = ($_POST['inputMiddleName'] == "None") ? NULL : $_POST['inputMiddleName'];
    $inputLastName = $_POST['inputLastName'];
    $inputExtensionName = ($_POST['inputExtensionName'] == "None") ? NULL : $_POST['inputExtensionName'];
    $inputEmailAddress = $_POST['inputEmailAddress'];
    $inputUserPassword = $_POST['inputUserPassword'];
    $inputContactNumber = $_POST['inputContactNumber'];
    $inputUserAddress = $_POST['inputUserAddress'];

    // Handle Valid ID upload
    if (isset($_FILES["inputValidID"])) {
        $validIDTmp = $_FILES["inputValidID"]["tmp_name"];
        $validIDName = $_FILES["inputValidID"]["name"];
        $validIDExtension = pathinfo($validIDName, PATHINFO_EXTENSION);
        $newValidIDName = 'ValidID-' . $inputFirstName . '.' . $validIDExtension;
        $validIDPath = 'images/validID/' . $newValidIDName;

        move_uploaded_file($validIDTmp, $validIDPath);
    }

    // Use prepared statements to prevent SQL injection
    $query = "INSERT INTO usermanagement_tbl (firstName, middleName, lastName, extensionName, userEmailAddress, userPassword, contactNumber, userAddress, validID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param(
        "sssssssss",
        $inputFirstName,
        $inputMiddleName,
        $inputLastName,
        $inputExtensionName,
        $inputEmailAddress,
        $inputUserPassword,
        $inputContactNumber,
        $inputUserAddress,
        $newValidIDName
    );

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Insert Failed: " . $stmt->error;
    }
} else {
    echo "Error request data"; // Handle the case where data is not provided properly
}
?>

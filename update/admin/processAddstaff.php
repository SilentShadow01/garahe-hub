<?php
include '../assets/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize
    $firstName = htmlspecialchars($_POST["firstName"]);
    $middleName = htmlspecialchars($_POST["middleName"]);
    $lastName = htmlspecialchars($_POST["lastName"]);
    $phoneNumber = htmlspecialchars($_POST["phoneNumber"]);
    $emailAddress = htmlspecialchars($_POST["emailAddress"]);
    $extensionName = htmlspecialchars($_POST["extensionName"]);
    $address = htmlspecialchars($_POST["address"]);
    $birthdate = htmlspecialchars($_POST["birthdate"]);
    $username = htmlspecialchars($_POST["username"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash the password

    // Process the file upload (move uploaded file to a designated folder)
    $targetDir = __DIR__ . "/uploads/";

    // Generate a unique filename for the uploaded file
    $fileName = basename($_FILES["pictureID"]["name"]);
    $targetFilePath = $targetDir . $fileName;

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES["pictureID"]["tmp_name"], $targetFilePath)) {
        echo "The file " . htmlspecialchars($fileName) . " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
        exit(); // Exit script on file upload failure
    }

    // Insert data into the database
    $stmt = $conn->prepare("INSERT INTO user_staff_tbl (firstName, middleName, lastName, phoneNumber, emailAddress, extensionName, address, birthdate, pictureId, username, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssssssbss", $firstName, $middleName, $lastName, $phoneNumber, $emailAddress, $extensionName, $address, $birthdate, $fileName, $username, $password);

    if ($stmt->execute()) {
        echo "Data and file uploaded successfully.";
    } else {
        echo "Error uploading data and file: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    // If the form was not submitted, redirect to the form page
    header("Location: addStaff.php");
    exit();
}
?>

<?php
include '../assets/connection.php';
session_start();
if (!isset($_SESSION['admin_name'])) {
    // Redirect to login page
    echo "<script>window.location.href='../index.php';</script>";
    exit();
}
function generateUserID() {
    // Generate 4 random numbers
    $numbers = mt_rand(1000, 9999);

    // Generate a random string of 3 letters
    $letters = strtoupper(substr(str_shuffle('abcdefghjkmnopqrstuvwxyz'), 0, 3)); // Excluding 'i' for clarity

    // Combine numbers and letters
    $mixedString = $numbers . $letters;

    // Shuffle the combined string to mix numbers and letters
    $mixedString = str_shuffle($mixedString);

    return $mixedString;
}

// Generate a unique userID
$userID = generateUserID();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signupSubmitBtn'])) {
    // Form is submitted, process the data
    $userFirstName = mysqli_real_escape_string($conn, $_POST['userFirstName']);
    $userMiddleName = mysqli_real_escape_string($conn, $_POST['userMiddleName']);
    $userLastName = mysqli_real_escape_string($conn, $_POST['userLastName']);
    $userExtensionName = mysqli_real_escape_string($conn, $_POST['userExtensionName']);
    $userEmailAddress = mysqli_real_escape_string($conn, $_POST['userEmailAddress']);
    $userContactNumber = mysqli_real_escape_string($conn, $_POST['userContactNumber']);
    $userAddress = mysqli_real_escape_string($conn, $_POST['userAddress']);
    $userPassword = $_POST['userPassword'];
    $userType = 'staff';

    // Check if the email address already exists
    $emailCheckQuery = "SELECT * FROM usermanagement_tbl WHERE userEmailAddress = '$userEmailAddress' AND userType ='$userType'";
    $emailCheckResult = mysqli_query($conn, $emailCheckQuery);

    if (mysqli_num_rows($emailCheckResult) > 0) {
        echo "<script>alert('Email address already exists.');</script>";

    } else {
        // Handle file upload (valid ID)
        $targetDirectory = "path/to/upload/directory/"; // Change this to the actual path
        $validIDFileName = basename($_FILES["inputValidID"]["name"]);
        $targetFilePath = $targetDirectory . $validIDFileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        $validIDTmp = $_FILES["inputValidID"]["tmp_name"];
        $validIDName = $_FILES["inputValidID"]["name"];
        $validIDExtension = pathinfo($validIDName, PATHINFO_EXTENSION);
        $newValidIDName = 'ValidID-' . $userFirstName . '.' . $validIDExtension;
        $validIDPath = '../assets/images/validID/staff/' . $newValidIDName;

        // Check if the file is an image
        $allowTypes = array('jpg', 'png', 'jpeg');
        if (in_array($fileType, $allowTypes)) {
            // Move the uploaded file to the destination directory
            move_uploaded_file($validIDTmp, $validIDPath);

            // Insert data into the database
            $sql = "INSERT INTO usermanagement_tbl (firstName, middleName, lastName, extensionName, userEmailAddress, contactNumber, userAddress, userPassword, validID, userType) 
                    VALUES ('$userFirstName', '$userMiddleName', '$userLastName', '$userExtensionName', '$userEmailAddress', '$userContactNumber', '$userAddress', '$userPassword', '$newValidIDName', '$userType')";

            if (mysqli_query($conn, $sql)) {
                echo "<script>window.location.href='AddStaff.php';</script>";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        } else {
            echo "Invalid file type. Allowed types: jpg, png, jpeg, gif";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
    <!-- Include Pikaday CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.8.0/css/pikaday.min.css">
    
    <!-- Include Moment.js for Pikaday -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    
    <!-- Include Pikaday JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.8.0/pikaday.min.js"></script>

  <title>Event</title>
  <style>
        #company-name, #titleStocks, 
        #titleReservation, #titleDelivery, #titleOrders{
            font-family: "Source Serif 4", Georgia, serif;
        }
        .font-num {
            font-family: "Times New Roman", Times, serif;
        }
  </style>
</head>
<body style="background-color: #C08261;">
    <div class="container-fluid">
        <div class="row">
            <header class="navbar sticky-top flex-md-nowrap p-2 shadow" style="background-color: #800000 !important ;">
                <h2 class="logo text-light p-1" id="company-name">Garahe Food House</h2>
            </header>
            <?php include 'sidenavbar.php'; ?>
                 <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="background-color: #F2E8C6;">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom border-dark">
                        <h1 class="h2" id="currentPage"><i class="fa-regular fa-user"></i>&nbsp Add Staff</h1>
                    </div>
                    <div class="container">
                       <form method="POST" enctype="multipart/form-data">
                            <div class="card my-5">
                                <div class="card-header text-light" style="background-color: #800000 !important ;">
                                    <h1 class="card-title font-num">Staff Information</h1>
                                </div>
                                <div class="card-body">
                                    <div class="input-group d-flex justify-content-center">
                                        <div id="errorMessage" class="text-danger fw-medium">
                                        </div>
                                        <div id="successMessage" class="text-success fw-medium">
                                        </div>
                                    </div>
                                    <div class="input-group mt-3">
                                        <span class="input-group-text col-md-4">First Name:</span>
                                        <input id="userFirstName" name="userFirstName" type="text" aria-label="firstName" onkeydown="return (event.keyCode < 48 || event.keyCode > 57)" class="form-control" required>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-text col-md-4">Middle Name:</span>
                                        <input id="userMiddleName" name="userMiddleName" type="text" aria-label="middleName" onkeydown="return (event.keyCode < 48 || event.keyCode > 57)" class="form-control">
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-text col-md-4">Last Name:</span>
                                        <input id="userLastName" name="userLastName" type="text" aria-label="lastName" onkeydown="return (event.keyCode < 48 || event.keyCode > 57)" class="form-control" required>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-text col-md-4">Extension Name:</span>
                                        <input id="userExtensionName" name="userExtensionName" type="text" aria-label="extensionName" onkeydown="return (event.keyCode < 48 || event.keyCode > 57)" class="form-control">
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-text col-md-4">Email Address:</span>
                                        <input id="userEmailAdd" name="userEmailAddress" type="email" aria-label="emailAddress" class="form-control" required>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-text col-md-4">Contact Number:</span>
                                        <input id="userContactNumber" name="userContactNumber" type="tel" aria-label="contactNumber" class="form-control" pattern="[0-9]{11}" maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '');" placeholder="ex. 09123456789" required>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-text col-md-4">Address:</span>
                                        <input id="userAddress" name="userAddress" type="text" aria-label="userAddress" class="form-control" required>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-text col-md-4">Password:</span>
                                        <input type="password" id="userPassword" name="userPassword" aria-label="userPassword" class="form-control" required>
                                        <button class="btn btn-outline-dark border border-dark" type="button" id="signup-toggle-password">
                                            <i class="fa-regular fa-eye"></i>
                                        </button>
                                    </div> 
                                    <!--<div class="input-group">-->
                                    <!--    <span class="input-group-text col-md-4">Confirm Password:</span>-->
                                    <!--    <input type="password" id="confirmPassword" name="confirmPassword" aria-label="confirmPassword" class="form-control" required>-->
                                    <!--    <button class="btn btn-outline-dark border border-dark" type="button" id="signup-toggle-cpassword">-->
                                    <!--        <i class="fa-regular fa-eye"></i>-->
                                    <!--    </button>-->
                                    <!--</div>-->
                                    <div class="input-group">
                                        <span class="input-group-text col-md-4">Valid ID:</span>
                                        <input type="file" class="form-control" name="inputValidID" id="inputValidID" accept=".jpg, .jpeg, .png">
                                    </div>
                                </div>
                                <div class="card-foooter d-flex justify-content-center my-3">
                                    <button id="signupSubmitBtn" type="submit" name="signupSubmitBtn" class="btn btn-success">Submit</button>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </main>
            </div>
        </div>
        <footer class="fixed-bottom bg-dark text-center" style="background-color: #800000 !important ;">
            <div class="text-light">
                <script>document.write(new Date().getFullYear())</script> &copy; All right reserved to the developers of the system.</a> 
            </div>
        </footer>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>

</body>
</html> 
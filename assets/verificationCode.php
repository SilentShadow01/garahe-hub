<?php
    include 'connection.php';
    require_once "PHPMailer-6.8.0/src/PHPMailer.php";
    require_once "PHPMailer-6.8.0/src/SMTP.php";
    require_once "PHPMailer-6.8.0/src/Exception.php";

    use \PHPMailer\PHPMailer\PHPMailer;
    use \PHPMailer\PHPMailer\SMTP;
    use \PHPMailer\PHPMailer\Exception;

    // Check if there is any request data
    $requestData = file_get_contents('php://input');
    if (!empty($requestData)) {
        // Decode the JSON data
        $data = json_decode($requestData);

        // Check if 'emailAddress' exists in the decoded data
        if (isset($data->emailAddress)) {
            $userEmailAdd = $data->emailAddress;

            // Generate a random verification code
            $verificationCode = mt_rand(100000, 999999);
            

            $selectTable = "SELECT * FROM userverification_tbl WHERE `userEmail` = '$userEmailAdd'";
            $conResult = mysqli_query($conn, $selectTable);
            $numRows = mysqli_num_rows($conResult);

            if($numRows == 1)
            {
                $updateCode = "UPDATE userverification_tbl SET verificationCode = ? WHERE userEmail = ?";
                $stmtUpdate = $conn->prepare($updateCode);
                $stmtUpdate->bind_param("is", $verificationCode, $userEmailAdd);
                if($stmtUpdate->execute())
                {
                    $_SESSION['usersEmailAddress'] = $userEmailAdd;
                }
                else
                {

                }
            }
            else
            {
                $insertCode = "INSERT INTO userverification_tbl (verificationCode, userEmail)VALUES(?, ?)";
                $stmtInsert = mysqli_prepare($conn, $insertCode);
                $stmtInsert->bind_param("is",$verificationCode,$userEmailAdd);
                if($stmtInsert->execute())
                {
                    $_SESSION['usersEmailAddress'] = $userEmailAdd;
                }
                else
                {

                }
            }

            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'juandelacruz17262@gmail.com';
            $mail->Password = 'ggfbagygejrsflqc';
            $mail->Port = 465;
            $mail->SMTPSecure = 'ssl';

            // Set email parameters
            $mail->setFrom('juandelacruz17262@gmail.com', 'GARAHE FOOD HOUSE');
            $mail->addAddress($userEmailAdd);
            $mail->isHTML(true);

            // Set the email subject and body
            $mail->Subject = "Verification Code";
            $mail->Body = "Thank you for signing up with GaraheHub Online Services! To complete your registration and activate your account, please use the following verification code:<br><br>Verification Code: $verificationCode. <br><br> Please enter this code in the designated field on our website to verify your email address. If you did not sign up for GaraheHub Online Services, please disregard this email. <br><br> Thank you for choosing GaraheHub! <br><br> Best Regards,
                The GaraheHub Team ";

            // Send the email notification
            if ($mail->send()) {
                // Email sent successfully, log a success message
                echo "success";
            } else {
                // Email sending failed, log an error message
                echo "error: " . $mail->ErrorInfo;
            }        
        } else {
            // Handle the case where 'emailAddress' is not in the JSON data
            echo "error: 'emailAddress' not provided in JSON data";
        }
    } else {
        // Handle the case where there is no request data
    }
?>

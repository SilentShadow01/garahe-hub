<?php
    session_start();
    include '../assets/connection.php';

    if (!isset($_SESSION['users_email']))
    {
        // Redirect to login page
        echo "<script>window.location.href='../index.php';</script>";
        exit();
    }
    // Check if the form was submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userUpdateInfo'])) {
        // Retrieve values from the form
        $usersEmail = $_POST['usersEmailAdd'];
        $firstName = $_POST['usersFirstName'];
        $middleName = $_POST['usersMiddleName'];
        $lastName = $_POST['usersLastName'];
        $extensionName = $_POST['usersExtensionName'];
        $userPassword = $_POST['usersPassword'];
        $contactNumber = $_POST['contactNumber'];
        $userAddress = $_POST['userAddress'];

        // Update the user information in the database
        $updateQuery = "UPDATE usermanagement_tbl 
                        SET firstName='$firstName', middleName='$middleName', lastName='$lastName', extensionName='$extensionName', userPassword='$userPassword', 
                        contactNumber='$contactNumber', userAddress='$userAddress' WHERE userEmailAddress='$usersEmail'";

        if (mysqli_query($conn, $updateQuery)) {
            // Redirect to a page after successful update
            header("Location: account.php");
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
    <style>
        *{
            font-family: "Source Serif 4", Georgia, serif;
        }
        .font-num {
            font-family: "Times New Roman", Times, serif;
        }
        .nav-item{
            text-align: center;
            position: relative;
        }
        @media (max-width: 991.98px)
        {
            .offcanvas-body{
                background-color: #E2C799;
            }
            h1#h1Carousel{
                font-size: 30px;
            }
            a.nav-link.fs-5{
                color: black;
            }
            li.nav-item .nav-link:after{
                background-color: black;
            }
            li.nav-item {
                margin-right: 0;
            }
            #dropdownWrapper, #userCartWrapper{
                display: none;
            }
            a.nav-link.fs-5.active {
                color: #800000 !important;
            }
        }
        @media (min-width: 1399.98px)
        {
            .nav-link{
                color: #F2E8C6;
            }
            #userLogout{
                display: none;
            }
        }
        #h1Carousel{
            font-size: 52px;
            line-height: 76px;
            text-shadow: 2px 4px 4px rgba(0, 0, 0, 0.4);
        }

        .nav-item .nav-link {
            position: relative;
            text-decoration: none;
            color: #DAD4B5;
        }

        .nav-item .nav-link:after {
            content: "";
            position: absolute;
            bottom: -2px;
            left: 50%;
            width: 0;
            height: 2px;
            background-color: #F2E8C6;
            transition: width 0.6s, transform 0.7s;
            transform: translateX(-50%);
            transform-origin: center;
        }

        .nav-item .nav-link:hover:after,
        .nav-item.show .nav-link:after {
            width: 100%;
            transform: translateX(-50%) scaleX(1);
        }

        .nav-item .nav-link.active:after {
            display: none;
        }
        #dropdownUser:after{
            color: #DAD4B5;
        }
        #ovalText{
            border-radius: 0% 100% 62% 38% / 0% 41% 59% 100%;
        }
        .dataTables_filter input {
            margin-bottom: 2rem;
        }

        .dataTables_length select {
            margin-bottom: 2rem;
        }
        a.nav-link.fs-5.active {
            color: #FFE17B;
        }
    </style>

</head>
<body style="background-color: #F2E8C6;">
    <header class="nav-header">
        <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top" style="background-color: #800000 !important ;">
            <div class="container-fluid">
                <a class="navbar-brand text-light fs-3 p-3" href="index.php" id="navbarLogo">Garahe lomi atbp</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header" style="background-color: #800000 !important ;">
                        <h5 class="offcanvas-title text-light" id="offcanvasNavbarLabel">User <?= $_SESSION['users_name']; ?></h5>
                        <a class="text-light nav-link text-center" href="cart.php"><i class="fas fa-shopping-cart"></i></a>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                            <li class="nav-item mt-2 me-3">
                                <a class="nav-link fs-5" aria-current="page" href="index.php">Home</a>
                            </li>
                            <li class="nav-item mt-2 me-3">
                                <a class="nav-link fs-5" href="menu.php">Menu</a>
                            </li>
                            <li class="nav-item mt-2 me-3">
                                <a class="nav-link fs-5" href="reservations.php">Reservation</a>
                            </li>
                            <li class="nav-item mt-2 me-3">
                                <a class="nav-link fs-5 active" href="account.php">Account</a>
                            </li>
                            <li class="nav-item mt-2 me-3">
                                <a class="nav-link fs-5" href="orders.php">My Orders</a>
                            </li>
                            <li class="nav-item mt-2" id="userLogout">
                                <a class="nav-link fs-5" href="" data-bs-toggle="modal" data-bs-target="#rateModal" id="requestActionBtn">Logout</a>
                            </li>
                        </ul>
                        <div class="d-flex justify-content-end me-5" id="userName">
                            <ul class="navbar-nav mt-2 ">
                                <li class="nav-item me-2 position-relative" id="userCartWrapper">
                                    <a class="nav-link text-center" href="cart.php"><i class="fas fa-shopping-cart"></i></a>
                                    <?php
                                        $usersEmail = $_SESSION['users_email'];
                                        $usersEmail = mysqli_real_escape_string($conn, $usersEmail); // Escape the email for safety

                                        $query = "SELECT SUM(productQuantity) as totalQuantity FROM users_cart_tbl WHERE usersEmail = '$usersEmail'";
                                        $result = mysqli_query($conn, $query);

                                        // Check if the query was successful
                                        if ($result) {
                                            $row = mysqli_fetch_assoc($result);
                                            $totalQuantity = $row['totalQuantity'];
                                        } else {
                                            $totalQuantity = 0;
                                        }
                                    ?>
                                    <?php 
                                        if($totalQuantity > 0) 
                                        { ?>
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            <?= $totalQuantity; ?>
                                            </span>
                                        <?php } else {

                                        } 
                                    
                                    ?>
                                </li>
                                <li class="dropdown" id="dropdownWrapper">
                                    <a class="nav-link dropdown-toggle" id="dropdownUser" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        User <?= $_SESSION['users_name']; ?>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <div class="main-content">
        <div class="container">
            <ul class="nav nav-tabs mt-2 border-dark" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-dark active" id="account-info-tab" data-bs-toggle="tab" href="#profile-info" role="tab" aria-controls="profile-info" aria-selected="true">Profile</a>
                </li>
                <!-- <li class="nav-item" role="presentation">
                    <a class="nav-link text-dark" id="cart-tab" data-bs-toggle="tab" href="#address-info" role="tab" aria-controls="address-info" aria-selected="false">Address</a>
                </li> -->
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-dark" id="reservations-tab" data-bs-toggle="tab" href="#reservations" role="tab" aria-controls="reservations" aria-selected="false">Reservations</a>
                </li>
            </ul>
            <div class="tab-content mt-2 rounded p-2 border-dark" id="myTabContent">
                <div class="tab-pane fade show active" id="profile-info" role="tabpanel" aria-labelledby="account-info-tab">
                    <!-- Content for Account Information -->
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <form method="POST">
                                        <div class="form-group">
                                            <?php
                                                $usersEmail = $_SESSION['users_email'];
                                                $query = "SELECT * FROM usermanagement_tbl WHERE userEmailAddress = '$usersEmail'";
                                                $result = mysqli_query($conn, $query);
                                                $row = mysqli_fetch_assoc($result);
                                                if ($result)
                                                { ?> 
                                                    <div class="d-flex justify-content-center">
                                                        <h2 class="fw-bold text-center" id="accountInfoText">ACCOUNT INFORMATION</h2>
                                                    </div>
                                                    <div class="input-group mt-1 col-md-5">
                                                        <span class="input-group-text col-5">Email Address</span>
                                                        <input type="text" class="form-control text-center" id="usersEmailAdd" name="usersEmailAdd" value="<?= $row['userEmailAddress']; ?>"readonly>
                                                    </div>
                                                    <div class="input-group mt-1 col-md-5">
                                                        <span class="input-group-text col-5">First Name</span>
                                                        <input type="text" class="form-control text-center" id="usersFirstName" name="usersFirstName" value="<?= $row['firstName']; ?>"readonly>
                                                    </div>
                                                    <div class="input-group mt-1 col-md-5">
                                                        <span class="input-group-text col-5">Middle Name</span>
                                                        <input type="text" class="form-control text-center" id="usersMiddleName" name="usersMiddleName" value="<?= $row['middleName']; ?>"readonly>
                                                    </div>
                                                    <div class="input-group mt-1 col-md-5">
                                                        <span class="input-group-text col-5">Last Name</span>
                                                        <input type="text" class="form-control text-center" id="usersLastName" name="usersLastName" value="<?= $row['lastName']; ?>"readonly>
                                                    </div>
                                                    <div class="input-group mt-1 col-md-5">
                                                        <span class="input-group-text col-5">Extension Name</span>
                                                        <input type="text" class="form-control text-center" id="usersExtensionName" name="usersExtensionName" value="<?= $row['extensionName']; ?>"readonly>
                                                    </div>
                                                    <div class="input-group mt-1 col-md-5">
                                                        <span class="input-group-text col-5">Contact Number</span>
                                                        <input type="text" class="form-control text-center" id="contactNumber" name="contactNumber" value="<?= $row['contactNumber']; ?>"readonly>
                                                    </div>
                                                    <div class="input-group mt-1 col-md-5">
                                                        <span class="input-group-text col-5">Address</span>
                                                        <input type="text" class="form-control text-center" id="userAddress" name="userAddress" value="<?= $row['userAddress']; ?>"readonly>
                                                    </div>
                                                    <div class="input-group mt-1 col-md-5">
                                                        <span class="input-group-text col-5">Password</span>
                                                        <input type="password" class="form-control text-center" id="usersPassword" name="usersPassword" value="<?= $row['userPassword']; ?>"readonly>
                                                    </div>
                                                    <div class="input-group mt-1 col-md-5">
                                                        <span class="input-group-text col-5">Account Status</span>
                                                        <input type="text" class="form-control text-center" id="usersPassword" name="usersPassword" value="
                                                        <?php 
                                                            if($row['accountStatus'] == 'verified') {
                                                                echo 'Verified';
                                                            }
                                                            else if($row['accountStatus'] == 'Pending') {
                                                                echo 'Pending';
                                                            }
                                                            else if($row['accountStatus'] == 'not-verified') {
                                                                echo 'Not Verified';
                                                            }
                                                        
                                                        ?>"readonly>
                                                    </div>
                                                    <div class="d-flex justify-content-center mt-3" id="changeInfoBtnWrapper">
                                                        <button type="button" class="btn btn-success" id="changeInfoBtn" onclick="showInformation()">Update Info &nbsp<i class="fa-regular fa-pen-to-square"></i></button>
                                                    </div>
                                                    <div class="d-flex justify-content-end d-none mt-3" id="footerWrapper">
                                                        <div class="btn-group">
                                                            <button type="submit" class="btn btn-success" name="userUpdateInfo"><i class="fa-regular fa-floppy-disk"></i>&nbsp Save Changes</button>
                                                            <button type="button" class="btn btn-danger" onclick="hideInformation()"><i class="fa-solid fa-ban"></i>&nbsp Cancel</button>
                                                        </div>
                                                    </div>
                                                <?php }
                                                else
                                                {
                                                    echo "Error: " . mysqli_error($conn);
                                                }
                                            ?>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                </div>
                <div class="tab-pane fade" id="reservations" role="tabpanel" aria-labelledby="reservations-tab">
                    <!-- Content for Reservations -->
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="table-responsive">
                                <table id="reservationTable">
                                    <thead class="text-light" style="background-color: #800000 !important ;">
                                        <tr>
                                            <th class="border border-secondary">Transaction No.</th>
                                            <th class="border border-secondary">Reservation Type</th>
                                            <th class="border border-secondary">Date</th>
                                            <th class="border border-secondary">Time</th>
                                            <th class="border border-secondary">Status</th>
                                            <th class="border border-secondary">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border border-secondary">
                                        <?php
                                            $usersEmail2 = $_SESSION['users_email'];
                                            $query2 = "SELECT * FROM `users_reservation_tbl` WHERE userEmailAddress = '$usersEmail2'";
                                            $result2 = mysqli_query($conn, $query2);
            
                                            if (mysqli_num_rows($result2) > 0)
                                            { 
                                                while ($row = mysqli_fetch_assoc($result2))
                                                { ?>
                                                    <tr>
                                                        <td class="font-num border border-secondary"><?= $row['transactionNumber'] ?></td>
                                                        <td class="font-num border border-secondary"><?= ($row['reservationType'] === 'event') ? 'Event' : 'Dine In'; ?></td>
                                                        <td class="font-num border border-secondary"><?= date('F d, Y', strtotime($row['reservationDate'])); ?></td>
                                                        <td class="font-num border border-secondary"><?= $row['reservationTime'] ?></td>
                                                        <td class="font-num border border-secondary">
                                                            <?php
                                                                if($row['reservationStatus'] == 'Pending')
                                                                {
                                                                    echo '<span class="d-flex justify-content-center text-dark bg-info p-1 rounded">Pending</span>';
                                                                }
                                                                else if ($row['reservationStatus'] == 'complete')
                                                                {
                                                                    echo '<span class="d-flex justify-content-center text-light bg-success p-1 rounded">Complete</span>';
                                                                }
                                                                else if ($row['reservationStatus'] == 'Approved')
                                                                {
                                                                    echo '<span class="d-flex justify-content-center text-danger bg-warning p-1 rounded">Approved</span>';
                                                                }
                                                                else if ($row['reservationStatus'] == 'Cancelled')
                                                                {
                                                                    echo'<span class="d-flex justify-content-center bg-danger text-light p-1 rounded">Cancelled</span>';
                                                                }
                                                                else if ($row['reservationStatus'] == 'Reject')
                                                                {
                                                                    echo'<span class="d-flex justify-content-center bg-danger text-light p-1 rounded">Reject</span>';
                                                                }
                                                                else
                                                                {
                                                                    echo'<span class="d-flex justify-content-center bg-danger text-light p-1 rounded">Error</span>';
                                                                }
                                                            ?>
                                                        </td>
                                                        <td class="font-num border border-secondary">
                                                            <a href="" class="btn btn-outline-dark d-flex justify-content-center" data-bs-toggle="modal" data-bs-target="#pendingModal<?= $row['ID']; ?>" id="requestActionBtn">
                                                                Check
                                                            </a>
                                                        </td>
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="pendingModal<?= $row['ID']; ?>" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">                                <div class="modal-content">
                                                                    <div class="modal-header text-light" style="background-color: #800000 !important ;">
                                                                        <h5 class="font-num modal-title" id="actionModal<?= $row['ID']; ?>Label">Order Information</h5>
                                                                        <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body bg-body-tertiary">
                                                                        <div class="container">
                                                                            <div class="" id="message"></div>
                                                                            <form method="POST" action="updateDeliver.php">
                                                                                <div class="input-group mt-1">
                                                                                    <strong class="font-num input-group-text col-4">Transaction Number</strong>
                                                                                    <input type="text" class="font-num form-control text-center" value="<?= $row['transactionNumber']; ?>" readonly>
                                                                                </div>
                                                                                <div class="input-group mt-1">
                                                                                    <strong class="font-num input-group-text col-4">Reservation Type</strong>
                                                                                    <input type="text" class="font-num form-control text-center" value="<?php echo ($row['reservationType'] === 'event') ? 'Event' : 'Dine In'; ?>" readonly>
                                                                                </div>
                                                                                <div class="input-group mt-1">
                                                                                    <strong class="font-num input-group-text col-4">Full Name</strong>
                                                                                    <input type="text" class="font-num form-control text-center" value="<?= $row['reservationFullName']; ?>" readonly>
                                                                                </div>
                                                                                <div class="input-group mt-1">
                                                                                    <strong class="font-num input-group-text col-4">Date of Reservation</strong>
                                                                                    <input type="text" class="font-num form-control text-center" value="<?= date('F d, Y', strtotime($row['reservationDate'])); ?>" readonly>
                                                                                </div>
                                                                                <div class="input-group mt-1">
                                                                                    <strong class="font-num input-group-text col-4">Time of Reservation</strong>
                                                                                    <input type="text" class="font-num form-control text-center" value="<?= $row['reservationTime']; ?>" readonly>
                                                                                </div>
                                                                                <div class="input-group mt-1">
                                                                                    <strong class="font-num input-group-text col-4">Phone Number</strong>
                                                                                    <input type="text" class="font-num form-control text-center" value="<?= $row['reservationPhoneNumber']; ?>" readonly>
                                                                                </div>
                                                                                <div class="input-group mt-1">
                                                                                    <strong class="font-num input-group-text col-4">Number of Person</strong>
                                                                                    <input type="text" class="font-num form-control text-center" value="<?= $row['reservationPersonNumber']; ?>" readonly>
                                                                                </div>
                                                                                <?php
                                                                                    if($row['reservationType'] === 'event')
                                                                                    { ?>
                                                                                        <div class="input-group mt-1">
                                                                                            <span class="input-group-text col-4">Request/Note</span>
                                                                                            <textarea class="form-control text-center" id="RequestNote" name="RequestNote" rows="6" readonly><?= $row['userRequestNote'];?></textarea>
                                                                                        </div>
                                                                                    <?php }
                                                                                    else{}
                                                                                ?>
                                                                                <div class="input-group mt-1">
                                                                                    <span class="input-group-text col-4" for="paymentProof">Proof of Payment<span class="text-danger"> * </span></span>
                                                                                    <img class="form-control text-center" src="images/proof/reservations/<?= $row['proofofPayment'];?>" alt="Proof Of Payment">
                                                                                </div>
                                                                                <div class="modal-footer btn-group bg-dark-tertiary">
                                                                                    <button type="button" class="font-num btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                                                </div>   
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                        <!-- END MODAL -->
                                                    </tr>
                                                <?php }
                                            }
                                            else
                                            {
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                </div>
                <div class="tab-pane fade" id="address-info" role="tabpanel" aria-labelledby="cart-tab">
                    <!-- Content for Cart -->
                    <p></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const navbarHeight = document.querySelector('.navbar').offsetHeight;
            document.querySelector('.main-content').style.paddingTop = navbarHeight + 'px';
        });
    </script>
    <!-- SHOW AND HIDE INFORMATIONS -->
    <script>
        let originalValues = {};
        function showInformation()
        {
            const formElements = ['usersEmailAdd', 'usersFirstName', 'usersMiddleName', 'usersLastName', 'usersExtensionName', 'usersPassword', 'contactNumber', 'userAddress'];
            formElements.forEach(elementId => {
                const element = document.getElementById(elementId);
                originalValues[elementId] = element.value;
            });

            const changeInfoBtn = document.getElementById('changeInfoBtn');
            const changeInfoBtnWrapper = document.getElementById('changeInfoBtnWrapper');
            const footerWrapper = document.getElementById('footerWrapper');

            changeInfoBtnWrapper.classList.add('d-none');
            footerWrapper.classList.remove('d-none');

            const usersEmailAdd = document.getElementById('usersEmailAdd');
            const usersFirstName = document.getElementById('usersFirstName');
            const usersMiddleName = document.getElementById('usersMiddleName');
            const usersLastName = document.getElementById('usersLastName');
            const usersExtensionName = document.getElementById('usersExtensionName');
            const usersPassword = document.getElementById('usersPassword');
            const contactNumber = document.getElementById('contactNumber');
            const userAddress = document.getElementById('userAddress');

            usersEmailAdd.removeAttribute('readonly');
            usersFirstName.removeAttribute('readonly');
            usersMiddleName.removeAttribute('readonly');
            usersLastName.removeAttribute('readonly');
            usersExtensionName.removeAttribute('readonly');
            usersPassword.removeAttribute('readonly');
            contactNumber.removeAttribute('readonly');
            userAddress.removeAttribute('readonly');

            usersEmailAdd.setAttribute('required', 'true');
            usersFirstName.setAttribute('required', 'true');
            usersLastName.setAttribute('required', 'true');
            usersPassword.setAttribute('required', 'true');
            contactNumber.setAttribute('required', 'true');
            userAddress.setAttribute('required', 'true');

            usersEmailAdd.classList.add('border-success');
            usersFirstName.classList.add('border-success');
            usersMiddleName.classList.add('border-success');
            usersLastName.classList.add('border-success');
            usersExtensionName.classList.add('border-success');
            usersPassword.classList.add('border-success');
            contactNumber.classList.add('border-success');
            userAddress.classList.add('border-success');

            usersPassword.type = 'text';
        }
        function hideInformation()
        {
            const formElements = ['usersEmailAdd', 'usersFirstName', 'usersMiddleName', 'usersLastName', 'usersExtensionName', 'usersPassword', 'contactNumber', 'userAddress'];
            formElements.forEach(elementId => {
                const element = document.getElementById(elementId);
                element.value = originalValues[elementId];
            });

            const changeInfoBtn = document.getElementById('changeInfoBtn');
            const changeInfoBtnWrapper = document.getElementById('changeInfoBtnWrapper');
            const footerWrapper = document.getElementById('footerWrapper');

            changeInfoBtnWrapper.classList.remove('d-none');
            footerWrapper.classList.add('d-none');

            const usersEmailAdd = document.getElementById('usersEmailAdd');
            const usersFirstName = document.getElementById('usersFirstName');
            const usersMiddleName = document.getElementById('usersMiddleName');
            const usersLastName = document.getElementById('usersLastName');
            const usersExtensionName = document.getElementById('usersExtensionName');
            const usersPassword = document.getElementById('usersPassword');
            const contactNumber = document.getElementById('contactNumber');
            const userAddress = document.getElementById('userAddress');

            usersEmailAdd.setAttribute('readonly', 'true');
            usersFirstName.setAttribute('readonly', 'true');
            usersMiddleName.setAttribute('readonly', 'true');
            usersLastName.setAttribute('readonly', 'true');
            usersExtensionName.setAttribute('readonly', 'true');
            usersPassword.setAttribute('readonly', 'true');
            contactNumber.setAttribute('readonly', 'true');
            userAddress.setAttribute('readonly', 'true');

            usersEmailAdd.removeAttribute('required');
            usersFirstName.removeAttribute('required');
            usersLastName.removeAttribute('required');
            usersPassword.removeAttribute('required');
            contactNumber.removeAttribute('required');
            userAddress.removeAttribute('required');

            usersEmailAdd.classList.remove('border-success');
            usersFirstName.classList.remove('border-success');
            usersMiddleName.classList.remove('border-success');
            usersLastName.classList.remove('border-success');
            usersExtensionName.classList.remove('border-success');
            usersPassword.classList.remove('border-success');
            contactNumber.classList.remove('border-success');
            userAddress.classList.remove('border-success');


            usersPassword.type = 'password';
        }
    </script>
    <!-- DATATABLES RESERVATIONS -->
    <script>
        $(document).ready(function() {
            $('#reservationTable').DataTable({
                "ordering": true,
                "order": [[0, "desc"]],
                "language": {
                    "sortAsc": "<i class='bi bi-sort-alpha-down'></i>",
                    "sortDesc": "<i class='bi bi-sort-alpha-up-alt'></i>"
                },
            });
        });
    </script>

</body>
</html>

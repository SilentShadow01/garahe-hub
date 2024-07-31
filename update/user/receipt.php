<?php
    session_start();
    include '../assets/connection.php';

    if (!isset($_SESSION['users_email']))
    {
        // Redirect to login page
        echo "<script>window.location.href='../index.php';</script>";
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        #navbarLogo, .nav-item, #offcanvasNavbarLabel, #h1Carousel, 
        #userName, #userWelcome, #placeOrder, #ovalText {
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
                                <a class="nav-link fs-5" href="account.php">Account</a>
                            </li>
                            <li class="nav-item mt-2 me-3">
                                <a class="nav-link fs-5" href="orders.php">My Orders</a>
                            </li>
                            <li class="nav-item mt-2" id="userLogout">
                                <a class="nav-link fs-5" href="logout.php">Logout</a>
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
            <div class="card shadow-lg mt-2 mb-5 bg-body-tertiary rounded">
                <div class="card-body">
                    <h5 class="card-title text-center border-bottom">Receipt</h5>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header text-light" style="background-color: #800000 !important ;">
                                    <h5 class="card-title">
                                        <i class="fa-regular fa-credit-card"></i>&nbsp Reservation Details
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group text-center mt-1 mb-3">
                                    </div>
                                    <div class="input-group mt-1">
                                        <span class="input-group-text col-5">Transaction Number</span>
                                        <input type="text" class="form-control text-center" value="<?php echo $_SESSION['transactionNum']; ?>" name="transactionNum" id="transactionNum" readonly>
                                    </div>
                                    <div class="input-group mt-1">
                                        <span class="input-group-text col-5">Mode of Payment</span>
                                        <input type="text" class="form-control text-center" value="Gcash" readonly>
                                    </div>
                                    <div class="input-group mt-1">
                                        <span class="input-group-text col-5">Reservation Type</span>
                                        <input type="text" class="form-control text-center" value="<?php echo ($_SESSION['reservationType'] === 'event') ? 'Event' : 'Dine In'; ?>" name="userFullName" id="userFullName" readonly>
                                    </div>
                                    <div class="input-group mt-1">
                                        <span class="input-group-text col-5">Full Name</span>
                                        <input type="text" class="form-control text-center" value="<?php echo $_SESSION['reservationFullName']; ?>" name="userFullName" id="userFullName" readonly>
                                    </div>
                                    <div class="input-group mt-1">
                                        <span class="input-group-text col-5">Date of reservation</span>
                                        <input type="text" class="form-control text-center" id="userReservationDate" name="userReservationDate" value="<?= date('F d, Y', strtotime($_SESSION['reservationDate'])); ?>" readonly>
                                    </div>
                                    <div class="input-group mt-1">
                                        <span class="input-group-text col-5">Time of reservation</span>
                                        <input type="text" class="form-control text-center" value="<?= $_SESSION['reservationTime']; ?>" name="userReservationTime" id="userReservationTime" readonly>
                                    </div>
                                    <div class="input-group mt-1">
                                        <span class="input-group-text col-5">Phone Number</span>
                                        <input type="text" class="form-control text-center" value="<?= $_SESSION['reservationPhone']; ?>" name="userPhoneNumber" id="userPhoneNumber" readonly>
                                    </div>
                                    <div class="input-group mt-1">
                                        <span class="input-group-text col-5">Number of person</span>
                                        <input type="text" class="form-control text-center" value="<?= $_SESSION['reservationPerson'];?>" name="numberPerson" id="numberPerson" readonly>
                                    </div>
                                    <?php
                                        if($_SESSION['reservationType'] === 'event')
                                        { ?>
                                            <div class="input-group mt-1">
                                                <span class="input-group-text col-5">Request/Note</span>
                                                <textarea class="form-control text-center" id="RequestNote" name="RequestNote" rows="6" readonly><?= $_SESSION['userNote'];?></textarea>
                                            </div>
                                        <?php }
                                        else{}
                                    ?>
                                    <div class="input-group mt-1">
                                        <span class="input-group-text col-5" for="paymentProof">Proof of Payment<span class="text-danger"> * </span></span>
                                        <img class="form-control text-center" src="images/proof/reservations/<?= $_SESSION['proofOfPayment'];?>" alt="Proof Of Payment">
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-center" style="background-color: #800000 !important ;">
                                    <a class="btn btn-danger text-light font-num" href="reservations.php">Close</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const navbarHeight = document.querySelector('.navbar').offsetHeight;
            document.querySelector('.main-content').style.paddingTop = navbarHeight + 'px';
        });
    </script>
</body>
</html>

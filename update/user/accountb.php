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
    <title>Account</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
    <style>
        *{
            font-family: "Source Serif 4", Georgia, serif;
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
        .dataTables_filter input {
            margin-bottom: 2rem;
        }

        .dataTables_length select {
            margin-bottom: 2rem;
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
                            <li class="nav-item mt-2" id="userLogout">
                                <a class="nav-link fs-5" href="logout.php">Logout</a>
                            </li>
                            
                        </ul>
                        <div class="d-flex justify-content-end me-5" id="userName">
                            <ul class="navbar-nav mt-2 ">
                                <li class="nav-item me-2 position-relative">
                                    <a class="nav-link text-center" id="cart-tab" data-bs-toggle="tab" href="#cart" role="tab" aria-controls="cart" aria-selected="false"><i class="fas fa-shopping-cart"></i></a>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
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
                                        // Display the total quantity in the badge
                                        echo $totalQuantity;
                                    ?>

                                        <span class="visually-hidden">unread messages</span>
                                    </span>
                                </li>
                                <li class="dropdown">
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
                    <a class="nav-link text-dark active" id="account-info-tab" data-bs-toggle="tab" href="#account-info" role="tab" aria-controls="account-info" aria-selected="true">Account Information</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-dark" id="reservations-tab" data-bs-toggle="tab" href="#reservations" role="tab" aria-controls="reservations" aria-selected="false">Reservations</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-dark" id="cart-tab" data-bs-toggle="tab" href="#cart" role="tab" aria-controls="cart" aria-selected="false">Cart</a>
                </li>
            </ul>
            <div class="tab-content mt-2 rounded p-2 border-dark" id="myTabContent">
                <div class="tab-pane fade show active" id="account-info" role="tabpanel" aria-labelledby="account-info-tab">
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
                                                        <input type="text" class="form-control text-center" id="usersEmailAdd" value="<?= $row['userEmailAddress']; ?>"readonly>
                                                    </div>
                                                    <div class="input-group mt-1 col-md-5">
                                                        <span class="input-group-text col-5">First Name</span>
                                                        <input type="text" class="form-control text-center" id="usersFirstName" value="<?= $row['firstName']; ?>"readonly>
                                                    </div>
                                                    <div class="input-group mt-1 col-md-5">
                                                        <span class="input-group-text col-5">Middle Name</span>
                                                        <input type="text" class="form-control text-center" id="usersMiddleName" value="<?= $row['middleName']; ?>"readonly>
                                                    </div>
                                                    <div class="input-group mt-1 col-md-5">
                                                        <span class="input-group-text col-5">Last Name</span>
                                                        <input type="text" class="form-control text-center" id="usersLastName" value="<?= $row['lastName']; ?>"readonly>
                                                    </div>
                                                    <div class="input-group mt-1 col-md-5">
                                                        <span class="input-group-text col-5">Extension Name</span>
                                                        <input type="text" class="form-control text-center" id="usersExtensionName" value="<?= $row['extensionName']; ?>"readonly>
                                                    </div>
                                                    <div class="input-group mt-1 col-md-5">
                                                        <span class="input-group-text col-5">Password</span>
                                                        <input type="password" class="form-control text-center" id="usersPassword" value="<?= $row['userPassword']; ?>"readonly>
                                                    </div>
                                                    <div class="d-flex justify-content-center mt-3" id="changeInfoBtnWrapper">
                                                        <button type="button" class="btn btn-success" id="changeInfoBtn" onclick="showInformation()">Update Info &nbsp<i class="fa-regular fa-pen-to-square"></i></button>
                                                    </div>
                                                    <div class="d-flex justify-content-end d-none mt-3" id="footerWrapper">
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-success" id="changeInfoBtn"><i class="fa-regular fa-floppy-disk"></i>&nbsp Save Changes</button>
                                                            <button type="button" class="btn btn-danger" id="changeInfoBtn" onclick="hideInformation()"><i class="fa-solid fa-ban"></i>&nbsp Cancel</button>
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
                                            <th class="border border-dark">Transaction No.</th>
                                            <th class="border border-dark">Reservation Type</th>
                                            <th class="border border-dark">Phone Number</th>
                                            <th class="border border-dark">Date</th>
                                            <th class="border border-dark">Time</th>
                                            <th class="border border-dark">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border-dark">
                                        <?php
                                            $usersEmail2 = $_SESSION['users_email'];
                                            $query2 = "SELECT * FROM `users_reservation_tbl` WHERE userEmailAddress = '$usersEmail2'";
                                            $result2 = mysqli_query($conn, $query2);
            
                                            if (mysqli_num_rows($result2) > 0)
                                            { 
                                                while ($row = mysqli_fetch_assoc($result2))
                                                { ?>
                                                    <tr>
                                                        <td class="border border-dark"><?= $row['transactionNumber'] ?></td>
                                                        <td class="border border-dark"><?= ($row['reservationType'] === 'event') ? 'Event' : 'Dine In'; ?></td>
                                                        <td class="border border-dark"><?= $row['reservationPhoneNumber'] ?></td>
                                                        <td class="border border-dark"><?= date('F d, Y', strtotime($row['reservationDate'])); ?></td>
                                                        <td class="border border-dark"><?= $row['reservationTime'] ?></td>
                                                        <td class="border border-dark"><?= $row['reservationStatus'] ?></td>
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
                <div class="tab-pane fade" id="cart" role="tabpanel" aria-labelledby="cart-tab">
                    <!-- Content for Cart -->
                    <div class="row mb-3 mx-5">
                        <div class="col-md-4 rounded-start" style="background-color: #800000 !important ;">
                            <div class="card-header p-2">
                                <h4 class="header-title text-light">Products</h4>
                            </div>
                        </div>
                        <div class="col-md-2" style="background-color: #800000 !important ;">
                            <div class="card-header p-2">
                                <h4 class="header-title text-light">Unit Price</h4>
                            </div>
                        </div>
                        <div class="col-md-2" style="background-color: #800000 !important ;">
                            <div class="card-header p-2">
                                <h4 class="header-title text-light">Quantity</h4>
                            </div>
                        </div>
                        <div class="col-md-2" style="background-color: #800000 !important ;">
                            <div class="card-header p-2">
                                <h4 class="header-title text-light">Total Price</h4>
                            </div>
                        </div>
                        <div class="col-md-2 rounded-end" style="background-color: #800000 !important ;">
                            <div class="card-header p-2">
                                <h4 class="header-title text-light">Actions</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-5 bg-white bg-gradient">
                        <?php 
                            $usersEmail3 = $_SESSION['users_email'];
                            $query3 = "SELECT * FROM `users_cart_tbl` WHERE usersEmail = '$usersEmail3'";
                            $result3 = mysqli_query($conn, $query3);
                            if (mysqli_num_rows($result3) > 0)
                            {
                                while ($row = mysqli_fetch_assoc($result3))
                                { ?>
                                    <div class="col-md-12 border border-secondary rounded">
                                        <div class="row">
                                            <div class="col-md-2 py-3">
                                                <img class="w-100 rounded d-flex justify-content-start" height="140px" src="../admin/images/products/<?= $row['productImage']?>">
                                            </div> 
                                            <div class="col-md-2 py-3">
                                                <h3 class="fw-200 mt-5 text-center"><?= $row['productName']?></h3>
                                            </div>
                                            <div class="col-md-2 py-3">
                                                <h3 class="fw-200 mt-5 text-center">₱<?= $row['productPrice']?></h3>
                                            </div>
                                            <div class="col-md-2 py-5">
                                                <div class="input-group py-3">
                                                    <button class="btn btn-outline-secondary" type="button" id="decrementBtn">-</button>
                                                    <input type="text" class="form-control text-center border border-secondary" id="quantityInput" value="<?= $row['productQuantity']?>">
                                                    <button class="btn btn-outline-secondary" type="button" id="incrementBtn">+</button>
                                                </div>
                                            </div>
                                            <div class="col-md-2"></div>
                                            <div class="col-md-2"></div>
                                        </div>
                                    </div>
                                <?php }
                            }
                            else
                            { ?>
                                <h1 class="text-center">Cart is empty.</h1>
                            <?php
                            }
                        ?>

                    </div>
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
        function showInformation()
        {
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

            usersEmailAdd.removeAttribute('readonly');
            usersFirstName.removeAttribute('readonly');
            usersMiddleName.removeAttribute('readonly');
            usersLastName.removeAttribute('readonly');
            usersExtensionName.removeAttribute('readonly');
            usersPassword.removeAttribute('readonly');

            usersEmailAdd.classList.add('border-success');
            usersFirstName.classList.add('border-success');
            usersMiddleName.classList.add('border-success');
            usersLastName.classList.add('border-success');
            usersExtensionName.classList.add('border-success');
            usersPassword.classList.add('border-success');

            usersPassword.type = 'text';
        }
        function hideInformation()
        {
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

            usersEmailAdd.setAttribute('readonly', 'true');
            usersFirstName.setAttribute('readonly', 'true');
            usersMiddleName.setAttribute('readonly', 'true');
            usersLastName.setAttribute('readonly', 'true');
            usersExtensionName.setAttribute('readonly', 'true');
            usersPassword.setAttribute('readonly', 'true');

            usersEmailAdd.classList.remove('border-success');
            usersFirstName.classList.remove('border-success');
            usersMiddleName.classList.remove('border-success');
            usersLastName.classList.remove('border-success');
            usersExtensionName.classList.remove('border-success');
            usersPassword.classList.remove('border-success');

            usersPassword.type = 'password';
        }
    </script>
    <!-- DATATABLES -->
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

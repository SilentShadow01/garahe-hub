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
    <title>My Orders</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
    <style>
        #navbarLogo, .nav-item, #offcanvasNavbarLabel, #h1Carousel, 
        #userName, #userWelcome, #placeOrder, #ovalText, #menuTitle, #productPriceTag, 
        #addToCart, .table_head, .font_me{
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
        .star {
            cursor: pointer;
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
                                <a class="nav-link fs-5 active" href="orders.php">My Orders</a>
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
            <ul class="nav nav-tabs mt-2 border-dark" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-dark active" id="pending-tab" data-bs-toggle="tab" href="#pending" role="tab" aria-controls="pending" aria-selected="true">Pending</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-dark" id="approved-tab" data-bs-toggle="tab" href="#approved" role="tab" aria-controls="approved" aria-selected="true">Approved</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-dark" id="deliver-tab" data-bs-toggle="tab" href="#deliver" role="tab" aria-controls="deliver" aria-selected="false">To be deliver</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-dark" id="complete-tab" data-bs-toggle="tab" href="#complete" role="tab" aria-controls="complete" aria-selected="false">Completed</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-dark" id="cancelled-tab" data-bs-toggle="tab" href="#cancelled" role="tab" aria-controls="cancelled" aria-selected="false">Cancelled</a>
                </li>
            </ul>
            <div class="tab-content mt-2 rounded p-2 border-dark" id="myTabContent">
                <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                    <!-- Content for pending -->
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="table-responsive">
                                <table id="pendingTable">
                                    <thead class="text-light" style="background-color: #800000 !important ;">
                                        <tr>
                                            <th class="font_me border border-secondary">Transaction Number</th>
                                            <th class="font_me border border-secondary">Total</th>
                                            <th class="font_me border border-secondary">Mode of Claim</th>
                                            <th class="font_me border border-secondary">Date of Order</th>
                                            <th class="font_me border border-secondary">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border border-secondary">
                                        <?php
                                            $usersEmail2 = $_SESSION['users_email'];
                                            $query2 = "SELECT *
                                            FROM user_delivery_tbl
                                            WHERE orderStatus = 'pending' AND userEmailAddress = '$usersEmail2' 
                                            GROUP BY userEmailAddress, orderDate, orderTime";
                                            $result2 = mysqli_query($conn, $query2);
            
                                            if (mysqli_num_rows($result2) > 0)
                                            { 
                                                while ($row = mysqli_fetch_assoc($result2))
                                                { 
                                                    $productQuantity = $row['productQuantity'];
                                                    $productPrice = $row['productPrice'];
                                                    $totalAmount = $row['totalAmount'];
                                                    ?> 
                                                    <tr>
                                                        <td class="font-num border border-secondary"><?= $row['transactionNumber'] ?></td>
                                                        <td class="font-num border border-secondary">₱<?= $totalAmount ?></td>
                                                        <td class="font-num border border-secondary">
                                                            <?php
                                                            if ($row['modeOfClaim'] == 'delivery')
                                                            {
                                                                echo 'Delivery';
                                                            }
                                                            else
                                                            {
                                                                echo 'Pick up';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="font-num border border-secondary"><?= date('F d, Y', strtotime($row['orderDate'])); ?></td>
                                                        <td class="font-num border border-secondary d-flex justify-content-center">
                                                            <a href="" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#pendingModal<?= $row['ID']; ?>" id="requestActionBtn">
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
                                                                            <form method="POST">
                                                                                <div class="input-group mt-1">
                                                                                    <strong class="font-num input-group-text col-4">Transaction Number</strong>
                                                                                    <input type="text" class="font-num form-control text-center" name="transactionNumber" value="<?= $row['transactionNumber']; ?>" readonly>
                                                                                </div>
                                                                                <div class="input-group mt-1">
                                                                                    <strong class="font-num input-group-text col-4">User Email</strong>
                                                                                    <input type="text" class="font-num form-control text-center" name="userEmailAddress" value="<?= $row['userEmailAddress']; ?>" readonly>
                                                                                </div>
                                                                                <!-- DISPLAY EACH ITEMS THAT HAS BEEN GROUPED HERE -->
                                                                                <?php 
                                                                                    $rowDate = $row['orderDate'];
                                                                                    $rowTime = $row['orderTime'];
                                                                                    $additionalSql = "SELECT * FROM user_delivery_tbl WHERE orderDate = '$rowDate' AND orderTime= '$rowTime' AND orderStatus = 'pending'";
                                                                                    $additionalResult = mysqli_query($conn, $additionalSql);
                                                                                    while ($additionalRow = mysqli_fetch_assoc($additionalResult))
                                                                                    { 
                                                                                        $additionalQuantity = $additionalRow['productQuantity'];
                                                                                        $additionalPrice = $additionalRow['productPrice'];
                                                                                        $additionalTotal = $additionalQuantity * $additionalPrice;
                                                                                        ?>
                                                                                        <div class="form-control mt-1">
                                                                                            <div class="row">
                                                                                                <div class="col-md-4">
                                                                                                    <img class="rounded w-50" src="../admin/images/products/<?= $additionalRow['productImage']; ?>" alt="<?= $row['productName']; ?>" style="height: 100px;">
                                                                                                    <label class="font-num form-check-label" >
                                                                                                        <span class="font_me fw-bold col-md-2"><?= $additionalRow['productName']; ?>
                                                                                                    </label>
                                                                                                </div>
                                                                                                <div class="col-md-2">
                                                                                                    <label class="font-num pt-4 form-check-label font-num fw-semibold" >
                                                                                                        <?= $row['productID']; ?>
                                                                                                    </label>
                                                                                                </div>
                                                                                                <div class="col-md-2">
                                                                                                    <label class="font-num pt-4 form-check-label font-num fw-semibold">
                                                                                                        <span class="font-num ">Quantity: </span><?= $additionalRow['productQuantity']; ?>
                                                                                                    </label>
                                                                                                </div>
                                                                                                <div class="col-md-2">
                                                                                                    <label class="font-num pt-4 form-check-label font-num fw-semibold">
                                                                                                        <span class="font-num ">Unit Price: </span><?= $additionalRow['productPrice']; ?>
                                                                                                    </label>
                                                                                                </div>
                                                                                                <div class="col-md-2">
                                                                                                    <label class="pt-4 form-check-label d-flex justify-content-center font-num fw-semibold">
                                                                                                        <span class="font-num ">Total Price: </span><?= $additionalTotal ; ?>
                                                                                                    </label>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    <?php }
                                                                                ?>
                                                                                
                                                                                <!-- END OF DISPLAY -->
                                                                                <div class="input-group mt-1">
                                                                                    <strong class="font-num input-group-text col-4">Contact Number</strong>    
                                                                                    <input type="text" class="font-num form-control text-center" name="orderDate" value="<?= $row['receiverPhoneNumber']; ?>" readonly>
                                                                                </div>
                                                                                <?php
                                                                                    if($row['modeOfClaim'] === 'delivery')
                                                                                    { ?>
                                                                                        <div class="input-group mt-1">
                                                                                            <strong class="font-num input-group-text col-4">Street</strong>    
                                                                                            <input type="text" class="font-num form-control text-center" name="orderDate" value="<?= $row['userStreet']; ?>" readonly>
                                                                                        </div>
                                                                                        <div class="input-group mt-1">
                                                                                            <strong class="font-num input-group-text col-4">Purok/House Number</strong>    
                                                                                            <input type="text" class="font-num form-control text-center" name="orderDate" value="<?= $row['userPurok']; ?>" readonly>
                                                                                        </div>
                                                                                        <div class="input-group mt-1">
                                                                                            <strong class="font-num input-group-text col-4">Landmark</strong>    
                                                                                            <input type="text" class="font-num form-control text-center" name="orderDate" value="<?= $row['userLandmark']; ?>" readonly>
                                                                                        </div>
                                                                                    <?php } else {}
                                                                                ?>
                                                                                <div class="input-group mt-1">
                                                                                    <strong class="font-num input-group-text col-4">Date of Order</strong>    
                                                                                    <input type="text" class="font-num form-control text-center" name="orderDate" value="<?= date('F d, Y', strtotime($row['orderDate'])); ?>" readonly>
                                                                                </div>
                                                                                <div class="input-group mt-1">
                                                                                    <strong class="font-num input-group-text col-4">Time of Order</strong> 
                                                                                    <input type="text" class="font-num form-control text-center" name="orderTime" value="<?= $row['orderTime']; ?>" readonly>   
                                                                                </div>
                                                                                <div class="input-group mt-1">
                                                                                    <strong class="font-num input-group-text col-4">Total</strong> 
                                                                                    <input type="text" class="font-num form-control text-center"  value="₱<?= $row['totalAmount']; ?>" readonly>   
                                                                                </div>
                                                                                <div class="input-group mt-1">
                                                                                    <strong class="font-num input-group-text col-4">Proof of payment</strong> 
                                                                                    <img src="images/proof/pickup/<?= $row['proofOfPayment']; ?>" class="col-md-8">
                                                                                </div>
                                                                                <div class="modal-footer btn-group bg-dark-tertiary">
                                                                                    <button type="button" class="font-num btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                                                    <button type="button" class="font-num btn btn-danger" onclick="cancelOrder('<?= $row['transactionNumber']; ?>')" data-bs-dismiss="modal">Cancel Order</button>
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
                <div class="tab-pane fade" id="approved" role="tabpanel" aria-labelledby="approved-tab">
                    <!-- Content for approved -->
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                        <div class="table-responsive">
                                <table id="toShipTable">
                                    <thead class="text-light" style="background-color: #800000 !important ;">
                                        <tr>
                                            <th class="font_me border border-secondary">Transaction Number</th>
                                            <th class="font_me border border-secondary">Total</th>
                                            <th class="font_me border border-secondary">Mode of Claim</th>
                                            <th class="font_me border border-secondary">Date of Order</th>
                                            <th class="font_me border border-secondary">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border border-secondary">
                                        <?php
                                            $usersEmail2 = $_SESSION['users_email'];
                                            $query2 = "SELECT *
                                            FROM user_delivery_tbl WHERE orderStatus = 'to-ship' AND userEmailAddress = '$usersEmail2' 
                                            GROUP BY userEmailAddress, orderDate, orderTime";
                                            $result2 = mysqli_query($conn, $query2);
            
                                            if (mysqli_num_rows($result2) > 0)
                                            { 
                                                while ($row = mysqli_fetch_assoc($result2))
                                                { 
                                                    $productQuantity = $row['productQuantity'];
                                                    $productPrice = $row['productPrice'];
                                                    $totalAmount = $row['totalAmount'];
                                                    ?>
                                                    <tr>
                                                        <td class="font-num border border-secondary"><?= $row['transactionNumber'] ?></td>
                                                        <td class="font-num border border-secondary">₱<?= $totalAmount; ?></td>
                                                        <td class="font-num border border-secondary">
                                                            <?php
                                                            if ($row['modeOfClaim'] == 'delivery')
                                                            {
                                                                echo 'Delivery';
                                                            }
                                                            else
                                                            {
                                                                echo 'Pick up';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="font-num border border-secondary"><?= date('F d, Y', strtotime($row['orderDate'])); ?></td>
                                                        <td class="font-num border border-secondary d-flex justify-content-center">
                                                            <a href="" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#toShipModal<?= $row['ID']; ?>" id="requestActionBtn">
                                                                Check
                                                            </a>
                                                        </td>
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="toShipModal<?= $row['ID']; ?>" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">                                <div class="modal-content">
                                                                    <div class="modal-header text-light" style="background-color: #800000 !important ;">
                                                                        <h5 class="font-num modal-title" id="actionModal<?= $row['ID']; ?>Label">Order Information</h5>
                                                                        <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body bg-body-tertiary">
                                                                        <div class="container">
                                                                            <div class="" id="message"></div>
                                                                            <form method="POST">
                                                                                <div class="input-group mt-1">
                                                                                    <strong class="font-num input-group-text col-4">Transaction Number</strong>
                                                                                    <input type="text" class="font-num form-control text-center" name="transactionNumber" value="<?= $row['transactionNumber']; ?>" readonly>
                                                                                </div>
                                                                                <div class="input-group mt-1">
                                                                                    <strong class="font-num input-group-text col-4">User Email</strong>
                                                                                    <input type="text" class="font-num form-control text-center" name="userEmailAddress" value="<?= $row['userEmailAddress']; ?>" readonly>
                                                                                </div>
                                                                                <!-- DISPLAY EACH ITEMS THAT HAS BEEN GROUPED HERE -->
                                                                                <?php 
                                                                                    $rowDate = $row['orderDate'];
                                                                                    $rowTime = $row['orderTime'];
                                                                                    $additionalSql = "SELECT * FROM user_delivery_tbl WHERE orderDate = '$rowDate' AND orderTime= '$rowTime' AND orderStatus = 'to-ship'";
                                                                                    $additionalResult = mysqli_query($conn, $additionalSql);
                                                                                    while ($additionalRow = mysqli_fetch_assoc($additionalResult))
                                                                                    { 
                                                                                        $additionalQuantity = $additionalRow['productQuantity'];
                                                                                        $additionalPrice = $additionalRow['productPrice'];
                                                                                        $additionalTotal = $additionalQuantity * $additionalPrice;
                                                                                        ?>
                                                                                        <div class="form-control mt-1">
                                                                                            <div class="row">
                                                                                                <div class="col-md-4">
                                                                                                    <img class="rounded w-50" src="../admin/images/products/<?= $additionalRow['productImage']; ?>" alt="<?= $row['productName']; ?>" style="height: 100px;">
                                                                                                    <label class="font-num form-check-label">
                                                                                                        <span class="font_me fw-bold col-md-2"><?= $additionalRow['productName']; ?>
                                                                                                    </label>
                                                                                                </div>
                                                                                                <div class="col-md-2">
                                                                                                    <label class="font-num pt-4 form-check-label font-num fw-semibold">
                                                                                                        <?= $row['productID']; ?>
                                                                                                    </label>
                                                                                                </div>
                                                                                                <div class="col-md-2">
                                                                                                    <label class="font-num pt-4 form-check-label font-num fw-semibold">
                                                                                                        <span class="font-num ">Quantity: </span><?= $additionalRow['productQuantity']; ?>
                                                                                                    </label>
                                                                                                </div>
                                                                                                <div class="col-md-2">
                                                                                                    <label class="font-num pt-4 form-check-label font-num fw-semibold">
                                                                                                        <span class="font-num ">Unit Price: </span><?= $additionalRow['productPrice']; ?>
                                                                                                    </label>
                                                                                                </div>
                                                                                                <div class="col-md-2">
                                                                                                    <label class="pt-4 form-check-label d-flex justify-content-center font-num fw-semibold">
                                                                                                        <span class="font-num ">Total Price: </span><?= $additionalTotal ; ?>
                                                                                                    </label>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    <?php }
                                                                                ?>
                                                                                
                                                                                <!-- END OF DISPLAY -->
                                                                                <div class="input-group mt-1">
                                                                                    <strong class="font-num input-group-text col-4">Contact Number</strong>    
                                                                                    <input type="text" class="font-num form-control text-center" name="orderDate" value="<?= $row['receiverPhoneNumber']; ?>" readonly>
                                                                                </div>
                                                                                <?php
                                                                                    if($row['modeOfClaim'] === 'delivery')
                                                                                    { ?>
                                                                                        <div class="input-group mt-1">
                                                                                            <strong class="font-num input-group-text col-4">Street</strong>    
                                                                                            <input type="text" class="font-num form-control text-center" name="orderDate" value="<?= $row['userStreet']; ?>" readonly>
                                                                                        </div>
                                                                                        <div class="input-group mt-1">
                                                                                            <strong class="font-num input-group-text col-4">Purok/House Number</strong>    
                                                                                            <input type="text" class="font-num form-control text-center" name="orderDate" value="<?= $row['userPurok']; ?>" readonly>
                                                                                        </div>
                                                                                        <div class="input-group mt-1">
                                                                                            <strong class="font-num input-group-text col-4">Landmark</strong>    
                                                                                            <input type="text" class="font-num form-control text-center" name="orderDate" value="<?= $row['userLandmark']; ?>" readonly>
                                                                                        </div>
                                                                                    <?php } else {}
                                                                                ?>
                                                                                <div class="input-group mt-1">
                                                                                    <strong class="font-num input-group-text col-4">Date of Order</strong>    
                                                                                    <input type="text" class="font-num form-control text-center" name="orderDate" value="<?= date('F d, Y', strtotime($row['orderDate'])); ?>" readonly>
                                                                                </div>
                                                                                <div class="input-group mt-1">
                                                                                    <strong class="font-num input-group-text col-4">Time of Order</strong> 
                                                                                    <input type="text" class="font-num form-control text-center" name="orderTime" value="<?= $row['orderTime']; ?>" readonly>   
                                                                                </div>
                                                                                <div class="input-group mt-1">
                                                                                    <strong class="font-num input-group-text col-4">Total</strong> 
                                                                                    <input type="text" class="font-num form-control text-center"  value="₱<?= $row['totalAmount']; ?>" readonly>   
                                                                                </div>
                                                                                <div class="input-group mt-1">
                                                                                    <strong class="font-num input-group-text col-4">Proof of payment</strong> 
                                                                                    <img src="images/proof/pickup/<?= $row['proofOfPayment']; ?>" class="col-md-8">
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
                <div class="tab-pane fade" id="deliver" role="tabpanel" aria-labelledby="deliver-tab">
                    <!-- Content for Reservations -->
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                        <div class="table-responsive">
                                <table id="toDeliverTable">
                                    <thead class="text-light" style="background-color: #800000 !important ;">
                                        <tr>
                                            <th class="font_me border border-secondary">Transaction #</th>
                                            <th class="font_me border border-secondary">Total</th>
                                            <th class="font_me border border-secondary">Mode of Claim</th>
                                            <th class="font_me border border-secondary">Date of Order</th>
                                            <th class="font_me border border-secondary">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border border-secondary">
                                        <?php
                                            $usersEmail2 = $_SESSION['users_email'];
                                            $query2 = "SELECT *
                                            FROM user_delivery_tbl WHERE orderStatus = 'complete' AND userEmailAddress = '$usersEmail2' 
                                            GROUP BY userEmailAddress, orderDate, orderTime";
                                            $result2 = mysqli_query($conn, $query2);
            
                                            if (mysqli_num_rows($result2) > 0)
                                            { 
                                                while ($row = mysqli_fetch_assoc($result2))
                                                { 
                                                    $productQuantity = $row['productQuantity'];
                                                    $productPrice = $row['productPrice'];
                                                    $totalAmount = $row['totalAmount'];
                                                    ?>
                                                    <tr>
                                                        <td class="font-num border border-secondary"><?= $row['transactionNumber'] ?></td>
                                                        <td class="font-num border border-secondary">₱<?= $totalAmount; ?></td>
                                                        <td class="font-num border border-secondary">
                                                            <?php
                                                            if ($row['modeOfClaim'] == 'delivery')
                                                            {
                                                                echo 'Delivery';
                                                            }
                                                            else
                                                            {
                                                                echo 'Pick up';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="font-num border border-secondary"><?= date('F d, Y', strtotime($row['orderDate'])); ?></td>
                                                        <td class="font-num border border-secondary d-flex justify-content-center">
                                                            <a href="" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#infoModal<?= $row['ID']; ?>" id="requestActionBtn">
                                                                Check
                                                            </a>
                                                        </td>
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="infoModal<?= $row['ID']; ?>" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">                                <div class="modal-content">
                                                                    <div class="modal-header text-light" style="background-color: #800000 !important ;">
                                                                        <h5 class="font-num modal-title" id="actionModal<?= $row['ID']; ?>Label">Order Information</h5>
                                                                        <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body bg-body-tertiary">
                                                                        <div class="container">
                                                                            <div class="" id="message"></div>
                                                                            <form method="POST">
                                                                                <div class="input-group mt-1">
                                                                                    <strong class="font-num input-group-text col-4">Transaction Number</strong>
                                                                                    <input type="text" class="font-num form-control text-center" name="transactionNumber" value="<?= $row['transactionNumber']; ?>" readonly>
                                                                                </div>
                                                                                <div class="input-group mt-1">
                                                                                    <strong class="font-num input-group-text col-4">User Email</strong>
                                                                                    <input type="text" class="font-num form-control text-center" name="userEmailAddress" value="<?= $row['userEmailAddress']; ?>" readonly>
                                                                                </div>
                                                                                <!-- DISPLAY EACH ITEMS THAT HAS BEEN GROUPED HERE -->
                                                                                <?php 
                                                                                    $rowDate = $row['orderDate'];
                                                                                    $rowTime = $row['orderTime'];
                                                                                    $additionalSql = "SELECT * FROM user_delivery_tbl WHERE orderDate = '$rowDate' AND orderTime= '$rowTime' AND orderStatus = 'to-received'";
                                                                                    $additionalResult = mysqli_query($conn, $additionalSql);
                                                                                    while ($additionalRow = mysqli_fetch_assoc($additionalResult))
                                                                                    { 
                                                                                        $additionalQuantity = $additionalRow['productQuantity'];
                                                                                        $additionalPrice = $additionalRow['productPrice'];
                                                                                        $additionalTotal = $additionalQuantity * $additionalPrice;
                                                                                        ?>
                                                                                        <div class="form-control mt-1">
                                                                                            <div class="row">
                                                                                                <div class="col-md-4">
                                                                                                    <img class="rounded w-50" src="../admin/images/products/<?= $additionalRow['productImage']; ?>" alt="<?= $row['productName']; ?>" style="height: 100px;">
                                                                                                    <label class="font-num form-check-label">
                                                                                                        <span class="font_me fw-bold col-md-2"><?= $additionalRow['productName']; ?>
                                                                                                    </label>
                                                                                                </div>
                                                                                                <div class="col-md-2">
                                                                                                    <label class="font-num pt-4 form-check-label font-num fw-semibold">
                                                                                                        <?= $row['productID']; ?>
                                                                                                    </label>
                                                                                                </div>
                                                                                                <div class="col-md-2">
                                                                                                    <label class="font-num pt-4 form-check-label font-num fw-semibold">
                                                                                                        <span class="font-num ">Quantity: </span><?= $additionalRow['productQuantity']; ?>
                                                                                                    </label>
                                                                                                </div>
                                                                                                <div class="col-md-2">
                                                                                                    <label class="font-num pt-4 form-check-label font-num fw-semibold"
                                                                                                        <span class="font-num ">Unit Price: </span><?= $additionalRow['productPrice']; ?>
                                                                                                    </label>
                                                                                                </div>
                                                                                                <div class="col-md-2">
                                                                                                    <label class="pt-4 form-check-label d-flex justify-content-center font-num fw-semibold">
                                                                                                        <span class="font-num ">Total Price: </span><?= $additionalTotal ; ?>
                                                                                                    </label>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    <?php }
                                                                                ?>
                                                                                
                                                                                <!-- END OF DISPLAY -->
                                                                                <div class="input-group mt-1">
                                                                                    <strong class="font-num input-group-text col-4">Contact Number</strong>    
                                                                                    <input type="text" class="font-num form-control text-center" name="orderDate" value="<?= $row['receiverPhoneNumber']; ?>" readonly>
                                                                                </div>
                                                                                <?php
                                                                                    if($row['modeOfClaim'] === 'delivery')
                                                                                    { ?>
                                                                                        <div class="input-group mt-1">
                                                                                            <strong class="font-num input-group-text col-4">Street</strong>    
                                                                                            <input type="text" class="font-num form-control text-center" name="orderDate" value="<?= $row['userStreet']; ?>" readonly>
                                                                                        </div>
                                                                                        <div class="input-group mt-1">
                                                                                            <strong class="font-num input-group-text col-4">Purok/House Number</strong>    
                                                                                            <input type="text" class="font-num form-control text-center" name="orderDate" value="<?= $row['userPurok']; ?>" readonly>
                                                                                        </div>
                                                                                        <div class="input-group mt-1">
                                                                                            <strong class="font-num input-group-text col-4">Landmark</strong>    
                                                                                            <input type="text" class="font-num form-control text-center" name="orderDate" value="<?= $row['userLandmark']; ?>" readonly>
                                                                                        </div>
                                                                                    <?php } else {}
                                                                                ?>
                                                                                <div class="input-group mt-1">
                                                                                    <strong class="font-num input-group-text col-4">Date of Order</strong>    
                                                                                    <input type="text" class="font-num form-control text-center" name="orderDate" value="<?= date('F d, Y', strtotime($row['orderDate'])); ?>" readonly>
                                                                                </div>
                                                                                <div class="input-group mt-1">
                                                                                    <strong class="font-num input-group-text col-4">Time of Order</strong> 
                                                                                    <input type="text" class="font-num form-control text-center" name="orderTime" value="<?= $row['orderTime']; ?>" readonly>   
                                                                                </div>
                                                                                <div class="input-group mt-1">
                                                                                    <strong class="font-num input-group-text col-4">Total</strong> 
                                                                                    <input type="text" class="font-num form-control text-center"  value="₱<?= $row['totalAmount']; ?>" readonly>   
                                                                                </div>
                                                                                <div class="input-group mt-1">
                                                                                    <strong class="font-num input-group-text col-4">Proof of payment</strong> 
                                                                                    <img src="images/proof/pickup/<?= $row['proofOfPayment']; ?>" class="col-md-8">
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
                <div class="tab-pane fade" id="complete" role="tabpanel" aria-labelledby="complete-tab">
                    <!-- Content for complete -->
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                        <div class="table-responsive">
                                <table id="completeTable">
                                    <thead class="text-light" style="background-color: #800000 !important ;">
                                        <tr>
                                            <th class="font_me border border-secondary">Transaction #</th>
                                            <th class="font_me border border-secondary">Total</th>
                                            <th class="font_me border border-secondary">Mode of Claim</th>
                                            <th class="font_me border border-secondary">Date of Order</th>
                                            <th class="font_me border border-secondary">Time of Order</th>
                                            <th class="font_me border border-secondary">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border border-secondary">
                                        <?php
                                            $usersEmail2 = $_SESSION['users_email'];
                                            $query2 = "SELECT *
                                            FROM user_delivery_tbl WHERE orderStatus = 'complete' AND userEmailAddress = '$usersEmail2' 
                                            GROUP BY userEmailAddress, orderDate, orderTime";
                                            $result2 = mysqli_query($conn, $query2);
            
                                            if (mysqli_num_rows($result2) > 0)
                                            { 
                                                while ($row = mysqli_fetch_assoc($result2))
                                                { 
                                                    $productQuantity = $row['productQuantity'];
                                                    $productPrice = $row['productPrice'];
                                                    $totalAmount = $row['totalAmount'];
                                                    ?>
                                                    <tr>
                                                        <td class="font-num border border-secondary"><?= $row['transactionNumber'] ?></td>
                                                        <td class="font-num border border-secondary">₱<?= $totalAmount; ?></td>
                                                        <td class="font-num border border-secondary">
                                                            <?php
                                                            if ($row['modeOfClaim'] == 'delivery')
                                                            {
                                                                echo 'Delivery';
                                                            }
                                                            else
                                                            {
                                                                echo 'Pick up';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="font-num border border-secondary"><?= date('F d, Y', strtotime($row['orderDate'])); ?></td>
                                                        <td class="font-num border border-secondary"><?= $row['orderTime'] ?></td>
                                                        <td class="font-num border border-secondary">
                                                            <div class="btn-group d-flex justify-content-center shadow-sm">
                                                                <a href="" class="btn btn-primary text-light" data-bs-toggle="modal" data-bs-target="#actionModal<?= $row['ID']; ?>" id="requestActionBtn">
                                                                    Check
                                                                </a>
                                                                <a href="" class="btn btn-success text-light" data-bs-toggle="modal" data-bs-target="#rateModal<?= $row['ID']; ?>" id="requestActionBtn">
                                                                    Rate
                                                                </a>
                                                            </div>
                                                        </td>
                                                        <!-- Modal for check -->
                                                        <div class="modal fade" id="actionModal<?= $row['ID']; ?>" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">                                <div class="modal-content">
                                                                    <div class="modal-header text-light" style="background-color: #800000 !important ;">
                                                                        <h5 class="font-num modal-title" id="actionModal<?= $row['ID']; ?>Label">Order Information</h5>
                                                                        <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body bg-body-tertiary">
                                                                        <div class="container">
                                                                            <div class="" id="message"></div>
                                                                            <form method="POST">
                                                                                <div class="input-group mt-1">
                                                                                    <strong class="font-num input-group-text col-4">Transaction Number</strong>
                                                                                    <input type="text" class="font-num form-control text-center" name="transactionNumber" value="<?= $row['transactionNumber']; ?>" readonly>
                                                                                </div>
                                                                                <div class="input-group mt-1">
                                                                                    <strong class="font-num input-group-text col-4">User Email</strong>
                                                                                    <input type="text" class="font-num form-control text-center" name="userEmailAddress" value="<?= $row['userEmailAddress']; ?>" readonly>
                                                                                </div>
                                                                                <!-- DISPLAY EACH ITEMS THAT HAS BEEN GROUPED HERE -->
                                                                                <?php 
                                                                                    $rowDate = $row['orderDate'];
                                                                                    $rowTime = $row['orderTime'];
                                                                                    $additionalSql = "SELECT * FROM user_delivery_tbl WHERE orderDate = '$rowDate' AND orderTime= '$rowTime' AND orderStatus = 'complete'";
                                                                                    $additionalResult = mysqli_query($conn, $additionalSql);
                                                                                    while ($additionalRow = mysqli_fetch_assoc($additionalResult))
                                                                                    { 
                                                                                        $additionalQuantity = $additionalRow['productQuantity'];
                                                                                        $additionalPrice = $additionalRow['productPrice'];
                                                                                        $additionalTotal = $additionalQuantity * $additionalPrice;
                                                                                        ?>
                                                                                        <div class="form-control mt-1">
                                                                                            <div class="row">
                                                                                                <div class="col-md-4">
                                                                                                    <img class="rounded w-50" src="../admin/images/products/<?= $additionalRow['productImage']; ?>" alt="<?= $row['productName']; ?>" style="height: 100px;">
                                                                                                    <label class="font-num form-check-label">
                                                                                                        <span class="font_me fw-bold col-md-2"><?= $additionalRow['productName']; ?>
                                                                                                    </label>
                                                                                                </div>
                                                                                                <div class="col-md-2">
                                                                                                    <label class="font-num pt-4 form-check-label font-num fw-semibold" >
                                                                                                        <?= $row['productID']; ?>
                                                                                                    </label>
                                                                                                </div>
                                                                                                <div class="col-md-2">
                                                                                                    <label class="font-num pt-4 form-check-label font-num fw-semibold" >
                                                                                                        <span class="font-num ">Quantity: </span><?= $additionalRow['productQuantity']; ?>
                                                                                                    </label>
                                                                                                </div>
                                                                                                <div class="col-md-2">
                                                                                                    <label class="font-num pt-4 form-check-label font-num fw-semibold" >
                                                                                                        <span class="font-num ">Unit Price: </span><?= $additionalRow['productPrice']; ?>
                                                                                                    </label>
                                                                                                </div>
                                                                                                <div class="col-md-2">
                                                                                                    <label class="pt-4 form-check-label d-flex justify-content-center font-num fw-semibold">
                                                                                                        <span class="font-num ">Total Price: </span><?= $additionalTotal ; ?>
                                                                                                    </label>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    <?php }
                                                                                ?>
                                                                                
                                                                                <!-- END OF DISPLAY -->
                                                                                <div class="input-group mt-1">
                                                                                    <strong class="font-num input-group-text col-4">Contact Number</strong>    
                                                                                    <input type="text" class="font-num form-control text-center" name="orderDate" value="<?= $row['receiverPhoneNumber']; ?>" readonly>
                                                                                </div>
                                                                                <?php
                                                                                    if($row['modeOfClaim'] === 'delivery')
                                                                                    { ?>
                                                                                        <div class="input-group mt-1">
                                                                                            <strong class="font-num input-group-text col-4">Street</strong>    
                                                                                            <input type="text" class="font-num form-control text-center" name="orderDate" value="<?= $row['userStreet']; ?>" readonly>
                                                                                        </div>
                                                                                        <div class="input-group mt-1">
                                                                                            <strong class="font-num input-group-text col-4">Purok/House Number</strong>    
                                                                                            <input type="text" class="font-num form-control text-center" name="orderDate" value="<?= $row['userPurok']; ?>" readonly>
                                                                                        </div>
                                                                                        <div class="input-group mt-1">
                                                                                            <strong class="font-num input-group-text col-4">Landmark</strong>    
                                                                                            <input type="text" class="font-num form-control text-center" name="orderDate" value="<?= $row['userLandmark']; ?>" readonly>
                                                                                        </div>
                                                                                    <?php } else {}
                                                                                ?>
                                                                                <div class="input-group mt-1">
                                                                                    <strong class="font-num input-group-text col-4">Date of Order</strong>    
                                                                                    <input type="text" class="font-num form-control text-center" name="orderDate" value="<?= date('F d, Y', strtotime($row['orderDate'])); ?>" readonly>
                                                                                </div>
                                                                                <div class="input-group mt-1">
                                                                                    <strong class="font-num input-group-text col-4">Time of Order</strong> 
                                                                                    <input type="text" class="font-num form-control text-center" name="orderTime" value="<?= $row['orderTime']; ?>" readonly>   
                                                                                </div>
                                                                                <div class="input-group mt-1">
                                                                                    <strong class="font-num input-group-text col-4">Total</strong> 
                                                                                    <input type="text" class="font-num form-control text-center"  value="₱<?= $row['totalAmount']; ?>" readonly>   
                                                                                </div>
                                                                                <div class="input-group mt-1">
                                                                                    <strong class="font-num input-group-text col-4">Proof of payment</strong> 
                                                                                    <img src="images/proof/pickup/<?= $row['proofOfPayment']; ?>" class="col-md-8">
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
                                                        <!-- Modal for rate -->
                                                        <div class="modal fade" id="rateModal<?= $row['ID']; ?>" tabindex="-1" aria-labelledby="rateModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">                                <div class="modal-content">
                                                                    <div class="modal-header text-light" style="background-color: #800000 !important ;">
                                                                        <h5 class="font-num modal-title" id="rateModal<?= $row['ID']; ?>Label">Order Information</h5>
                                                                        <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body bg-body-tertiary">
                                                                        <div class="container">
                                                                            <div class="" id="message"></div>
                                                                            <form method="POST" id="ratingsForm">
                                                                                <div class="input-group mt-1">
                                                                                    <strong class="font-num input-group-text col-4">Transaction Number</strong>
                                                                                    <input type="text" class="font-num form-control text-center" name="transactionNumber" value="<?= $row['transactionNumber']; ?>" readonly>
                                                                                </div>
                                                                                <div class="input-group mt-1">
                                                                                    <strong class="font-num input-group-text col-4">User Email</strong>
                                                                                    <input type="text" class="font-num form-control text-center" name="userEmailAddress" value="<?= $row['userEmailAddress']; ?>" readonly>
                                                                                </div>
                                                                                <!-- DISPLAY EACH ITEMS THAT HAS BEEN GROUPED HERE -->
                                                                                <?php 
                                                                                    $rowDate = $row['orderDate'];
                                                                                    $rowTime = $row['orderTime'];
                                                                                    $additionalSql = "SELECT * FROM user_delivery_tbl WHERE orderDate = '$rowDate' AND orderTime= '$rowTime' AND orderStatus = 'complete'";
                                                                                    $additionalResult = mysqli_query($conn, $additionalSql);
                                                                                    while ($additionalRow = mysqli_fetch_assoc($additionalResult))
                                                                                    { 
                                                                                        $additionalQuantity = $additionalRow['productQuantity'];
                                                                                        $additionalPrice = $additionalRow['productPrice'];
                                                                                        $additionalTotal = $additionalQuantity * $additionalPrice;
                                                                                        ?>
                                                                                        <div class="form-control mt-1">
                                                                                            <div class="row">
                                                                                                <div class="col-md-4">
                                                                                                    <img class="rounded w-50" src="../admin/images/products/<?= $additionalRow['productImage']; ?>" alt="<?= $row['productName']; ?>" style="height: 100px;">
                                                                                                    <label class="font-num form-check-label">
                                                                                                        <span class="font_me fw-bold col-md-2"><?= $additionalRow['productName']; ?>
                                                                                                    </label>
                                                                                                </div>
                                                                                                <div class="col-md-2">
                                                                                                    <label class="font-num pt-4 form-check-label font-num fw-semibold" >
                                                                                                        <?= $row['productID']; ?>
                                                                                                    </label>
                                                                                                </div>
                                                                                                <div class="col-md-6">
                                                                                                    <div class="rate containerClass d-flex justify-content-center" data-product-id="<?= $additionalRow['productID']; ?>">
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    <?php }
                                                                                ?>
                                                                                <div class="input-group mt-1 d-flex justify-content-end">
                                                                                    <button type="button" id="sendRatingsBtn" class="btn btn-success">Send Ratings</button>
                                                                                </div>
                                                                                <!-- END OF DISPLAY -->
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                        <!-- END MODAL -->
                                                    </tr>
                                                <?php 
                                                }
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
                <div class="tab-pane fade" id="cancelled" role="tabpanel" aria-labelledby="cancelled-tab">
                    <!-- Content for Cancelled Orders -->
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="table-responsive">
                                <table id="cancelledTable">
                                    <thead class="text-light" style="background-color: #800000 !important ;">
                                        <tr>
                                            <th class="font_me border border-secondary">Transaction Number</th>
                                            <th class="font_me border border-secondary">Total</th>
                                            <th class="font_me border border-secondary">Mode of Claim</th>
                                            <th class="font_me border border-secondary">Date of Order</th>
                                            <th class="font_me border border-secondary">Time of Order</th>
                                            <th class="font_me border border-secondary">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border border-secondary">
                                        <?php
                                        $usersEmail2 = $_SESSION['users_email'];
                                        $query2 = "SELECT *
                                            FROM user_delivery_tbl
                                            WHERE orderStatus = 'cancelled' AND userEmailAddress = '$usersEmail2' 
                                            GROUP BY userEmailAddress, orderDate, orderTime";
                                        $result2 = mysqli_query($conn, $query2);
                
                                        if (mysqli_num_rows($result2) > 0) {
                                            while ($row = mysqli_fetch_assoc($result2)) {
                                                $productQuantity = $row['productQuantity'];
                                                $productPrice = $row['productPrice'];
                                                $totalAmount = $row['totalAmount'];
                                                ?>
                                                <tr>
                                                    <td class="font-num border border-secondary"><?= $row['transactionNumber'] ?></td>
                                                    <td class="font-num border border-secondary">₱<?= $totalAmount ?></td>
                                                    <td class="font-num border border-secondary">
                                                        <?php
                                                        if ($row['modeOfClaim'] == 'delivery')
                                                        {
                                                            echo 'Delivery';
                                                        }
                                                        else
                                                        {
                                                            echo 'Pick up';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="font-num border border-secondary"><?= date('F d, Y', strtotime($row['orderDate'])); ?></td>
                                                    <td class="font-num border border-secondary"><?= $row['orderTime'] ?></td>
                                                    <td class="font-num border border-secondary d-flex justify-content-center">
                                                        <a href="#" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#cancelledModal<?= $row['ID']; ?>" id="requestActionBtn">
                                                            Check
                                                        </a>
                                                    </td>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="cancelledModal<?= $row['ID']; ?>" tabindex="-1" aria-labelledby="cancelledModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header text-light" style="background-color: #800000 !important ;">
                                                                    <h5 class="font-num modal-title" id="cancelledModal<?= $row['ID']; ?>Label">Cancelled Order Information</h5>
                                                                    <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body bg-body-tertiary">
                                                                    <div class="container">
                                                                        <div class="" id="message"></div>
                                                                        <form method="POST" action="updateDeliver.php">
                                                                            <div class="input-group mt-1">
                                                                                <strong class="font-num input-group-text col-4">Transaction Number</strong>
                                                                                <input type="text" class="font-num form-control text-center" name="transactionNumber" value="<?= $row['transactionNumber']; ?>" readonly>
                                                                            </div>
                                                                            <div class="input-group mt-1">
                                                                                <strong class="font-num input-group-text col-4">User Email</strong>
                                                                                <input type="text" class="font-num form-control text-center" name="userEmailAddress" value="<?= $row['userEmailAddress']; ?>" readonly>
                                                                            </div>
                                                                            <!-- DISPLAY EACH ITEM THAT HAS BEEN GROUPED HERE -->
                                                                            <?php 
                                                                                $rowDate = $row['orderDate'];
                                                                                $rowTime = $row['orderTime'];
                                                                                $additionalSql = "SELECT * FROM user_delivery_tbl WHERE orderDate = '$rowDate' AND orderTime = '$rowTime' AND orderStatus = 'cancelled'";
                                                                                $additionalResult = mysqli_query($conn, $additionalSql);
                                                                                while ($additionalRow = mysqli_fetch_assoc($additionalResult)) { 
                                                                                    $additionalQuantity = $additionalRow['productQuantity'];
                                                                                    $additionalPrice = $additionalRow['productPrice'];
                                                                                    $additionalTotal = $additionalQuantity * $additionalPrice;
                                                                            ?>
                                                                            <div class="form-control mt-1">
                                                                                <div class="row">
                                                                                    <div class="col-md-4">
                                                                                        <img class="rounded w-50" src="../admin/images/products/<?= $additionalRow['productImage']; ?>" alt="<?= $additionalRow['productName']; ?>" style="height: 100px;">
                                                                                        <label class="font-num form-check-label" >
                                                                                            <span class="font_me fw-bold col-md-2"><?= $additionalRow['productName']; ?></span>
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                        <label class="font-num pt-4 form-check-label font-num fw-semibold">
                                                                                            <?= $additionalRow['productID']; ?>
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                        <label class="font-num pt-4 form-check-label font-num fw-semibold">
                                                                                            <span class="font-num">Quantity: </span><?= $additionalRow['productQuantity']; ?>
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                        <label class="font-num pt-4 form-check-label font-num fw-semibold">
                                                                                            <span class="font-num">Unit Price: </span><?= $additionalRow['productPrice']; ?>
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                        <label class="pt-4 form-check-label d-flex justify-content-center font-num fw-semibold">
                                                                                            <span class="font-num">Total Price: </span><?= $additionalTotal ; ?>
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <?php } ?>
                                                                            
                                                                            <!-- END OF DISPLAY -->
                                                                            <div class="input-group mt-1">
                                                                                <strong class="font-num input-group-text col-4">Contact Number</strong>    
                                                                                <input type="text" class="font-num form-control text-center" name="orderDate" value="<?= $row['receiverPhoneNumber']; ?>" readonly>
                                                                            </div>
                                                                            <?php
                                                                                if($row['modeOfClaim'] === 'delivery')
                                                                                { ?>
                                                                                    <div class="input-group mt-1">
                                                                                        <strong class="font-num input-group-text col-4">Street</strong>    
                                                                                        <input type="text" class="font-num form-control text-center" name="orderDate" value="<?= $row['userStreet']; ?>" readonly>
                                                                                    </div>
                                                                                    <div class="input-group mt-1">
                                                                                        <strong class="font-num input-group-text col-4">Purok/House Number</strong>    
                                                                                        <input type="text" class="font-num form-control text-center" name="orderDate" value="<?= $row['userPurok']; ?>" readonly>
                                                                                    </div>
                                                                                    <div class="input-group mt-1">
                                                                                        <strong class="font-num input-group-text col-4">Landmark</strong>    
                                                                                        <input type="text" class="font-num form-control text-center" name="orderDate" value="<?= $row['userLandmark']; ?>" readonly>
                                                                                    </div>
                                                                                <?php } else {}
                                                                            ?>
                                                                            <div class="input-group mt-1">
                                                                                <strong class="font-num input-group-text col-4">Date of Order</strong>    
                                                                                <input type="text" class="font-num form-control text-center" name="orderDate" value="<?= date('F d, Y', strtotime($row['orderDate'])); ?>" readonly>
                                                                            </div>
                                                                            <div class="input-group mt-1">
                                                                                <strong class="font-num input-group-text col-4">Time of Order</strong> 
                                                                                <input type="text" class="font-num form-control text-center" name="orderTime" value="<?= $row['orderTime']; ?>" readonly>   
                                                                            </div>
                                                                            <div class="input-group mt-1">
                                                                                <strong class="font-num input-group-text col-4">Total</strong> 
                                                                                <input type="text" class="font-num form-control text-center"  value="₱<?= $row['totalAmount']; ?>" readonly>   
                                                                            </div>
                                                                            <div class="input-group mt-1">
                                                                                <strong class="font-num input-group-text col-4">Proof of payment</strong> 
                                                                                <img src="images/proof/pickup/<?= $row['proofOfPayment']; ?>" class="col-md-8">
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
                                        } else {
                                            echo '<tr><td colspan="6" class="text-center">No cancelled orders found.</td></tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
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
        document.addEventListener('DOMContentLoaded', function() {
    // Get all the star rating elements
    const starContainers = document.querySelectorAll('.rate');

    starContainers.forEach(container => {
        const stars = container.querySelectorAll('.star');
        const selectedRatingInput = container.querySelector('.selectedRating');
        const productId = container.dataset.productId;

        let currentRating = parseInt(selectedRatingInput.value, 10) || 0;

        function updateStars(rating) {
            stars.forEach(star => {
                if (parseInt(star.dataset.value, 10) <= rating) {
                    star.style.color = 'gold';  // Highlighted color
                } else {
                    star.style.color = 'gray';  // Default color
                }
            });
        }

        container.addEventListener('mouseenter', function() {
            const tempRating = parseInt(container.dataset.tempRating, 10) || currentRating;
            updateStars(tempRating);
        });

        container.addEventListener('mouseleave', function() {
            updateStars(currentRating);
        });

        stars.forEach(star => {
            star.addEventListener('mouseenter', function() {
                const rating = parseInt(star.dataset.value, 10);
                container.dataset.tempRating = rating;
                updateStars(rating);
            });

            star.addEventListener('click', function() {
                const rating = parseInt(star.dataset.value, 10);
                currentRating = rating;
                selectedRatingInput.value = rating;
                updateStars(rating);
            });
        });
    });

    // Function to display only the selected ratings and product IDs
    function displayRatingsAndProductIDs() {
        console.clear(); // Clear the console for a fresh display
        console.log("Displaying current ratings and product IDs:");

        document.querySelectorAll('.selectedRating').forEach(input => {
            const rating = parseInt(input.value, 10) || 0; // Ensure the rating is an integer
            if (rating > 0) { // Only display ratings that are greater than 0
                const productIdMatch = input.name.match(/rating\[(.*?)\]/);
                if (productIdMatch) {
                    const productId = productIdMatch[1]; // Extract product ID as a string
                    console.log(`Product ID: ${productId}, Rating: ${rating}`);
                } else {
                    console.error("Product ID could not be extracted from input name:", input.name);
                }
            }
        });
    }

    // Add click event listener to the 'sendRatingsBtn' button
    const sendRatingsBtn = document.getElementById('sendRatingsBtn');
    if (sendRatingsBtn) {
        console.log("Send Ratings Button found, adding click event listener");
        sendRatingsBtn.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default form submission if applicable
            displayRatingsAndProductIDs(); // Display the selected ratings and product IDs in the console
        });
    } else {
        console.error("Send Ratings Button not found");
    }
});


    </script>
    <script>
        function cancelOrder(transactionNumber) {
            // Send AJAX request to cancelOrder.php
            $.ajax({
                type: "POST",
                url: "cancelOrder.php",
                data: { transactionNumber: transactionNumber },
                success: function (response) {
                    window.location.href='orders.php';
                },
                error: function () {
                    alert("Error cancelling order.");
                }
            });
        }
    </script>
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
    <!-- DATATABLES RESERVATIONS -->
    <script>
        $(document).ready(function() {
            // Define a common options object for DataTables
            var commonOptions = {
                "ordering": true,
                "order": [[0, "desc"]],
                "language": {
                    "sortAsc": "<i class='bi bi-sort-alpha-down'></i>",
                    "sortDesc": "<i class='bi bi-sort-alpha-up-alt'></i>"
                }
            };
        
            // Initialize DataTables for each table
            $('#toShipTable').DataTable(commonOptions);
            $('#toDeliverTable').DataTable(commonOptions);
            $('#completeTable').DataTable(commonOptions);
            $('#pendingTable').DataTable(commonOptions);
            $('#cancelledTable').DataTable(commonOptions);
        });
    </script>


</body>
</html>

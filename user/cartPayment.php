
<?php
session_start();
include '../assets/connection.php';

if (!isset($_SESSION['users_email'])) {
    echo "<script>window.location.href='../index.php';</script>";
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
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
            margin-top: 2rem;
        }

        .dataTables_length select {
            margin-bottom: 2rem;
            margin-top: 2rem;
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
                            <li class="nav-item mt-2 me-3">
                                <a class="nav-link fs-5" href="ratings.php">Rate</a>
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
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card mt-3">
                    <?php include 'processPayment.php' ?>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="card-header" style="background-color: #800000 !important ;">
                            <h1 class="font_me header-title text-light"><i class="fa-solid fa-person-walking-luggage"></i>&nbsp Cart Payment</h1>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-3">
                            <?php
                                if(isset($error))
                                {
                                    foreach($error as $error)
                                    {
                                        echo '<span class="text-light bg-danger p-2 rounded">'.$error.'</span>';
                                    };
                                };
                            ?>
                            </div>
                            <?php
                                $totalSum = 0;
                                if(isset($_GET['productID'])) {
                                $productIDs = $_GET['productID'];
                                $usersEmail = $_SESSION['users_email'];
                                $productNames = array();

                                if ($conn) {
                                    $placeholders = implode(', ', array_fill(0, count($productIDs), '?'));

                                    // Fetch product names from the database
                                    $query = "SELECT productID, productName, productImage, productQuantity, productPrice FROM users_cart_tbl WHERE usersEmail = ? AND productID IN ($placeholders)";
                                    $stmt = mysqli_prepare($conn, $query);

                                    if ($stmt) {
                                    // Bind the parameters and execute the query
                                    mysqli_stmt_bind_param($stmt, str_repeat('s', count($productIDs) + 1), $usersEmail, ...$productIDs);
                                    mysqli_stmt_execute($stmt);
                                    mysqli_stmt_bind_result($stmt, $fetchedProductID, $fetchedProductName, $fetchedProductImage, $fetchedProductQuantity, $fetchedProductPrice);

                                    while (mysqli_stmt_fetch($stmt)) 
                                    { 
                                        $totalPrice = $fetchedProductQuantity * $fetchedProductPrice; 
                                        $totalSum += $totalPrice;
                                        ?>
                                        <div class="form-control border border-secondary rounded mb-3 p-3">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <input class="font-num fw-semibold border-0 bg-transparent text-dark" id="productID[]" name="productID[]" value="<?= $fetchedProductID; ?>" readonly></input>
                                                </div>
                                                <div class="col-md-2">
                                                    <img class="rounded w-100" src="../admin/images/products/<?= $fetchedProductImage; ?>" alt="<?= $fetchedProductImage; ?>" style="height: 70px;" >
                                                    <input type="hidden" name="productImage[]" value="<?= $fetchedProductImage; ?>" readonly>
                                                </div>
                                                <div class="col-md-2">
                                                    <input class="fw-bold font-num border-0 bg-transparent text-dark" name="productName[]" value="<?= $fetchedProductName; ?>" readonly></input>
                                                </div>
                                                <div class="col-md-2">
                                                    <span class="fw-bold font-num ">Price: ₱<?= $fetchedProductPrice; ?></span>
                                                    <input class="fw-semibold font-num border-0 bg-transparent text-dark" name="productPrice[]" value="<?= $fetchedProductPrice; ?>" hidden></input>
                                                </div> 
                                                <div class="col-md-2">
                                                    <span class="fw-bold font-num">Quantity: </span>
                                                    <input class="fw-semibold border-0 font-num bg-transparent text-dark" name="productQuantity[]" value="<?= $fetchedProductQuantity; ?>" readonly></input>
                                                </div>
                                                <div class="col-md-2">
                                                <span class="fw-bold font-num ">Total: </span>
                                                    <span class="fw-semibold font-num">₱<?= $totalPrice; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <input type="hidden" name="productTotal[]" value="<?= $totalPrice; ?>">
                                    <?php
                                    mysqli_stmt_close($stmt);
                                    } else {
                                    echo "<li>Failed to prepare the statement.</li>";
                                    }

                                } else {
                                    echo "<li>Database connection error.</li>";
                                }
                                } else {
                                echo "<li>No product IDs selected.</li>";
                                }
                            ?>
                            <input type="hidden" name="totalSum" value="<?= $totalSum; ?>">
                            <div class="form-control border border-secondary rounded">
                                <div class="row">
                                    <?php
                                        $currentEmail = $_SESSION['users_email'];
                                        $query = "SELECT * FROM usermanagement_tbl WHERE userEmailAddress = '$currentEmail'";
                                        $result = mysqli_query($conn, $query);

                                        if ($result) {
                                            $row = mysqli_fetch_assoc($result);

                                            if ($row) 
                                            {
                                                $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                                                $random_letters = '';
                                                for ($i = 0; $i < 4; $i++) {
                                                    $random_letters .= $characters[rand(0, strlen($characters) - 1)];
                                                }
                                        
                                                $random_numbers = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
                                                $transactionNumber = $random_letters . $random_numbers;
                                                ?>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <div class="input-group mt-3">
                                                            <span class="font-num input-group-text col-5 border border-info">Transaction Number</span>
                                                            <input type="text" class="font-num form-control text-center border border-info" value="<?= $transactionNumber ?>" id="transactionNumber" name="transactionNumber" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <div class="input-group mt-3">
                                                            <span class="font-num input-group-text col-5 border border-success">Receiver Name</span>
                                                            <input type="text" class="font-num form-control text-center border border-success" id="receiverName" name="receiverName" value="<?= $row['firstName'] . (!empty($row['middleName']) ? " " . $row['middleName'] : "") . (!empty($row['lastName']) ? " " . $row['lastName'] : "") . (!empty($row['extensionName']) ? " " . $row['extensionName'] : ""); ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Eto lang Binago ko rito sa cartPayment at meron pa sa baba naka script sya, yung last script. ~Julius -->
                                                
                                                <div class="col-md-4">
                                                    <div class="input-group my-3">
                                                        <span class="font-num input-group-text col-5 border border-success" for="modeOfClaim">Mode of Claim</span>
                                                        <select class="font-num form-select border border-success" id="modeOfClaim" name="modeOfClaim" required>
                                                            <option class="text-center" value="" disabled selected>Select Here</option>
                                                            <option class="text-center" value="pickUp">Pick Up</option>
                                                            <option class="text-center" value="delivery">Delivery</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="input-group mt-3">
                                                        <span class="font-num input-group-text col-5 border border-success">Phone Number</span>
                                                        <input type="tel" class="font-num form-control text-center border border-success" id="receiverPhoneNumber" name="receiverPhoneNumber" pattern="[0-9]{11}" maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required placeholder="ex. 09123456789" value="<?=$row['contactNumber'];?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 d-none mt-3" id="addressWrapper">
                                                    <div class="input-group">
                                                        <span class="font-num input-group-text col-5 border border-success" for="receiverAddress">Barangay</span>
                                                        <select class="font-num form-select border border-success" id="receiverAddress" name="receiverAddress" onchange="updateShippingFee()">
                                                            <option class="text-center" value="" disabled selected>Select Here</option>
                                                            <option class="text-center" value="Bayambang">Bayambang</option>
                                                            <option class="text-center" value="Batang">Batang</option>
                                                            <option class="text-center" value="Cato">Cato</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <!-- Additional form elements for delivery address -->
                                                <div class="col-md-4 d-none mt-3" id="addressStreet">
                                                    <!-- Street input -->
                                                    <div class="input-group">
                                                        <span class="font-num input-group-text col-5 border border-success" for="street">Street</span>
                                                        <input type="text" class="font-num form-control text-center border border-success" id="street" name="userStreet">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 d-none mt-3" id="addressPurok">
                                                    <!-- Purok & House Number input -->
                                                    <div class="input-group" >
                                                        <span class="font-num input-group-text col-5 border border-success">Purok/House Number</span>
                                                        <input type="text" class="font-num form-control text-center border border-success" id="PurokhouseNumber" name="PurokhouseNumber" placeholder="Optional">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 d-none mt-3" id="addressLandmark">
                                                    <!-- Landamrk input -->
                                                    <div class="input-group">
                                                        <span class="font-num input-group-text col-5 border border-success">Nearest Landmark</span>
                                                        <input type="text" class="font-num form-control text-center border border-success" id="Landmark" name="userLandmark">
                                                    </div>
                                                </div>

                                                                         <!-- Hanggang dito ~Julius -->
                                                                         
                                                <div class="col-md-4 mt-3 d-none" id="shippingFeeLabel">
                                                    <div class="input-group">
                                                        <label class="form-control text-center w-100 border border-info font-num" id="shippingFeeDisplay">Shipping Fee: </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mt-3" id="proofOfPayment">
                                                    <div class="input-group">
                                                        <span class="input-group-text col-5 border border-success font-num" for="paymentProof">Proof of Payment</span>
                                                        <input type="file" class="form-control border border-success" id="paymentProof" name="paymentProof" accept=".jpg, .jpeg, .png" required>    
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="input-group mt-3">
                                                        <span class="font-num input-group-text col-5 border border-info">Total</span>
                                                        <input type="tel" class="font-num form-control text-center border border-info" value="₱<?= $totalSum; ?>" id="totalSumPickUp" name="totalSumPickUp" readonly>
                                                        <input type="tel" class="font-num form-control text-center border border-info d-none" value="₱<?= $totalSum; ?>" id="shippingDefault" name="totalSumDelivery" readonly>
                                                        <input type="tel" class="font-num form-control text-center border border-info d-none" value="₱<?= $totalSum + 20; ?>" id="shippingBayambang" name="totalSumDelivery" readonly>
                                                        <input type="tel" class="font-num form-control text-center border border-info d-none" value="₱<?= $totalSum + 30; ?>" id="shippingBatang" name="totalSumDelivery" readonly>
                                                        <input type="tel" class="font-num form-control text-center border border-info d-none" value="₱<?= $totalSum + 40; ?>" id="shippingCato" name="totalSumDelivery" readonly>
                                                    </div>
                                                </div>
                                            <?php } else {
                                                echo '<label class="form-label">Contact Number: Not Available</label>';
                                            }

                                            mysqli_free_result($result);
                                        } else {
                                            echo '<label class="form-label">Contact Number: Error fetching data</label>';
                                        }
                                    ?>
                                </div>
                            </div>
                        </div><!-- CARD-BODY END -->
                        <div class="card-footer" style="background-color: #800000 !important ;">
                            <div class="d-flex justify-content-end">
                                <button class="font-num btn btn-warning fw-semibold" type="submit" name="placeOrder">Place Order &nbsp<i class="fa-solid fa-motorcycle"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const navbarHeight = document.querySelector('.navbar').offsetHeight;
            document.querySelector('.main-content').style.paddingTop = navbarHeight + 'px';
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function(){
            const modeOfClaim = document.getElementById('modeOfClaim');
            const addressWrapper = document.getElementById('addressWrapper');
            const receiverAddress = document.getElementById('receiverAddress');
            const shippingFeeLabel = document.getElementById('shippingFeeLabel');
            const totalSumPickUp = document.getElementById('totalSumPickUp');

            const shippingCato = document.getElementById('shippingCato');
            const shippingBatang = document.getElementById('shippingBatang');
            const shippingBayambang = document.getElementById('shippingBayambang');
            const shippingDefault = document.getElementById('shippingDefault');

            const addressStreet = document.getElementById('addressStreet');
            const addressPurok = document.getElementById('addressPurok');
            const addressLandmark = document.getElementById('addressLandmark');
            
            const inputLandmark = document.getElementById('Landmark');
            const inputPurok = document.getElementById('PurokhouseNumber');
            const inputStreet = document.getElementById('street');

            modeOfClaim.addEventListener('change', function() {
                const selectedValue = modeOfClaim.value;
                if(selectedValue === "pickUp")
                {
                    addressWrapper.classList.add('d-none');
                    shippingFeeLabel.classList.add('d-none');
                    
                    totalSumPickUp.classList.remove('d-none');
                    receiverAddress.removeAttribute('required');
                    addressStreet.classList.add('d-none');
                    addressPurok.classList.add('d-none');
                    addressLandmark.classList.add('d-none');

                    inputLandmark.removeAttribute('required');
                    inputPurok.removeAttribute('required');
                    inputStreet.removeAttribute('required');

                    shippingCato.classList.add('d-none');
                    shippingBatang.classList.add('d-none');
                    shippingBayambang.classList.add('d-none');
                }
                else
                {
                    addressWrapper.classList.remove('d-none');
                    shippingFeeLabel.classList.remove('d-none');

                    shippingCato.classList.add('d-none');
                    shippingBatang.classList.add('d-none');
                    shippingBayambang.classList.add('d-none');

                    totalSumPickUp.classList.add('d-none');
                    receiverAddress.setAttribute('required', 'true');
                    addressStreet.classList.remove('d-none');
                    addressPurok.classList.remove('d-none');
                    addressLandmark.classList.remove('d-none');

                    inputLandmark.setAttribute('required', 'true');
                    inputPurok.setAttribute('true');
                    inputStreet.setAttribute('required', 'true');

                    shippingCato.classList.add('d-none');
                    shippingBatang.classList.add('d-none');
                    shippingBayambang.classList.add('d-none');
                    shippingDefault.classList.remove('d-none');
                }
            })
        })
    </script>

                    <!-- Function for Barangay/Street/House Number/Purok(Start) ~ Julius  -->
<!-- JavaScript to show/hide additional form elements -->
<script>
    $(document).ready(function () {
        // Listen for changes in the modeOfClaim select
        $('#modeOfClaim').change(function () {
            // If delivery is selected, show the addressWrapper
            if ($(this).val() === 'delivery') {
                $('#addressWrapper').removeClass('d-none');
            } else {
                // If not, hide the addressWrapper
                $('#addressWrapper').addClass('d-none');
            }
        });

        // Listen for changes in the receiverAddress select
        $('#receiverAddress').change(function () {
            // If a barangay is selected, show the deliveryAddress
            if ($(this).val() !== '') {
                $('#deliveryAddress').removeClass('d-none');
            } else {
                // If not, hide the deliveryAddress
                $('#deliveryAddress').addClass('d-none');
            }
        });
    });
</script>
            <!-- Function for Barangay/Street/House Number/Purok(End) ~ Julius  -->
<script>
    function updateShippingFee() {
        var dropdown = document.getElementById("receiverAddress");
        var selectedValue = dropdown.options[dropdown.selectedIndex].value;
        var shippingFeeLabel = document.getElementById("shippingFeeDisplay");
        const shippingCato = document.getElementById('shippingCato');
        const shippingBatang = document.getElementById('shippingBatang');
        const shippingBayambang = document.getElementById('shippingBayambang');
        const shippingDefault = document.getElementById('shippingDefault');

        // You can customize this logic based on your specific requirements
        switch (selectedValue) {
            case "Bayambang":
                shippingFeeLabel.textContent = "Shipping Fee: ₱20";
                shippingDefault.classList.add('d-none');
                shippingCato.classList.add('d-none');
                shippingBatang.classList.add('d-none');
                shippingBayambang.classList.remove('d-none');
                break;
            case "Batang":
                shippingFeeLabel.textContent = "Shipping Fee: ₱30";
                shippingDefault.classList.add('d-none');
                shippingCato.classList.add('d-none');
                shippingBatang.classList.remove('d-none');
                shippingBayambang.classList.add('d-none');
                break;
            case "Cato":
                shippingFeeLabel.textContent = "Shipping Fee: ₱40";
                shippingDefault.classList.add('d-none');
                shippingCato.classList.remove('d-none');
                shippingBatang.classList.add('d-none');
                shippingBayambang.classList.add('d-none');
                break;
            default:
                shippingFeeLabel.textContent = "Shipping Fee: ₱0"; // Default or handle other cases
                shippingDefault.classList.remove('d-none');
                shippingCato.classList.add('d-none');
                shippingBatang.classList.add('d-none');
                shippingBayambang.classList.add('d-none');
                break;
        }
    }
</script>          
</body>
</html>

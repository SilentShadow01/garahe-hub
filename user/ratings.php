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
    <title>Ratings</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        #navbarLogo, .nav-item, #offcanvasNavbarLabel, #h1Carousel, 
        #userName, #userWelcome, #placeOrder, #ovalText, #menuTitle, #productPriceTag, 
        #addToCart{
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
            #mainCourse-tab, #drinks-tab, #desserts-tab, #addToCart{
                font-size: 14px!important;
            }
            #productPriceTag{
                font-size: 18px!important;
            }
            #productImage1, #productImage2, #productImage3{
                height: 140px!important;
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
        a.nav-link.fs-5.active {
            color: #FFE17B;
        }
            /* START RATING CSS */
        .rating {
            flex-direction: row-reverse;
            gap: 0.3rem;
            --stroke: #666;
            --fill: #ffc73a;
            }

            .rating input {
            appearance: unset;
            }

            .rating label {
            cursor: pointer;
            }

            .rating svg {
            width: 2rem;
            height: 2rem;
            overflow: visible;
            fill: transparent;
            stroke: var(--stroke);
            stroke-linejoin: bevel;
            stroke-dasharray: 12;
            animation: idle 4s linear infinite;
            transition: stroke 0.2s, fill 0.5s;
            }

            @keyframes idle {
            from {
                stroke-dashoffset: 24;
            }
            }

            .rating label:hover svg {
            stroke: var(--fill);
            }

            .rating input:checked ~ label svg {
            transition: 0s;
            animation: idle 4s linear infinite, yippee 0.75s backwards;
            fill: var(--fill);
            stroke: var(--fill);
            stroke-opacity: 0;
            stroke-dasharray: 0;
            stroke-linejoin: miter;
            stroke-width: 8px;
            }

            @keyframes yippee {
                0% {
                    transform: scale(1);
                    fill: var(--fill);
                    fill-opacity: 0;
                    stroke-opacity: 1;
                    stroke: var(--stroke);
                    stroke-dasharray: 10;
                    stroke-width: 1px;
                    stroke-linejoin: bevel;
                }

                30% {
                    transform: scale(0);
                    fill: var(--fill);
                    fill-opacity: 0;
                    stroke-opacity: 1;
                    stroke: var(--stroke);
                    stroke-dasharray: 10;
                    stroke-width: 1px;
                    stroke-linejoin: bevel;
                }

                30.1% {
                    stroke: var(--fill);
                    stroke-dasharray: 0;
                    stroke-linejoin: miter;
                    stroke-width: 8px;
                }

                60% {
                    transform: scale(1.2);
                    fill: var(--fill);
                }
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
                                <a class="nav-link fs-5 " href="menu.php">Menu</a>
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
                                <a class="nav-link fs-5 active" href="ratings.php">Rate</a>
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
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class="card mt-4">
                        <div class="card-header" style="background-color: #800000 !important ;">
                            <h1 class="card-title text-light" id="menuTitle"><i class="fa-solid fa-list"></i>&nbsp Products</h1>
                        </div>
                        <div class="card-body">
                            <div id="addToCartMessage" class="text-success fw-bold text-center fs-2">
                                <ul class="nav nav-tabs mt-2 border-dark" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link text-dark active fs-4" id="mainCourse-tab" data-bs-toggle="tab" href="#mainCourse" role="tab" aria-controls="mainCourse" aria-selected="true">Main Course</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link text-dark fs-4" id="beverages-tab" data-bs-toggle="tab" href="#beverages" role="tab" aria-controls="beverages" aria-selected="true">Beverages</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link text-dark fs-4" id="sides-tab" data-bs-toggle="tab" href="#sides" role="tab" aria-controls="sides" aria-selected="false">Sides</a>
                                    </li>
                                </ul>
                                <div class="tab-content mt-2 rounded border-dark" id="myTabContent">
                                    <!-- START THANK YOU MODAL -->
                                    <div class="modal fade" id="thankYouModal" tabindex="-1" aria-labelledby="thankYouModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background-color: #28a745 !important;">
                                                    <h1 class="modal-title fs-5 fw-medium text-light" id="thankYouModalLabel">Thank You for Your Ratings!</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeAndReload()"></button>
                                                </div>
                                                <div class="modal-body text-center fs-5">
                                                    <p class="font-num">We appreciate your feedback. Your ratings have been recorded.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END THANK YOU MODAL -->
                                    <div class="tab-pane fade show active" id="mainCourse" role="tabpanel" aria-labelledby="mainCourse-tab">
                                        <div class="row">
                                            <?php
                                                $query = "SELECT * FROM `product_tbl` WHERE productCategory = 'mainCourse' AND productStocks > 0";
                                                $stmt = $conn->prepare($query);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                if($result->num_rows > 0)
                                                {
                                                    while ($row = $result->fetch_assoc()) { 
                                                        $_SESSION['product_ID'] = $row['productID'];
                                                        $productID = $row['productID'];
                                                        $productName = $row['productName'];
                                                        $productPrice = $row['productPrice'];
                                                        $imageName = $row['productImage']; // Assuming this is the column containing the image names
                                                        $_SESSION['productImage'] = $row['productImage'];
                                                        $_SESSION['productName'] = $row['productName'];
                                                        $imageUrl = "../admin/images/products/" . $imageName;
                                                ?>
                                                <?php include 'bratings.php'; ?>
                                                    <div class="col-md-3 mt-2"> 
                                                        <form method="POST">  
                                                            <div class="card">
                                                                <?php   include 'addToCart.php'; ?>
                                                                    <div class="d-flex justify-content-between">
                                                                        <h5 class="text-center p-2 font-num" id="productPriceTag"><?= $productName ?></h5>
                                                                    </div>
                                                                    <img src="<?= $imageUrl; ?>" alt="123" class="w-100 rounded-top" height="220px" id="productImage2">
                                                                    <button type="button" class="text-light border border-0 py-2 rounded-bottom fs-4" style="background-color: #800000 !important ;" data-bs-target="#ratingsModal<?= $productID ?>" data-bs-toggle="modal"><i class="fa-solid fa-star"></i>&nbsp Rate &nbsp<i class="fa-solid fa-star"></i></button>
                                                                </div>
                                                        </form>
                                                    </div>
                                                <?php }
                                                }
                                                else
                                                { ?>
                                                    <h1 class="text-center">No data found.</h1>
                                                <?php }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-content rounded border-dark" id="myTabContent">
                                    <div class="tab-pane fade show" id="beverages" role="tabpanel" aria-labelledby="beverages-tab">
                                    <div class="row">
                                            <?php
                                                $query = "SELECT * FROM `product_tbl` WHERE productCategory = 'beverages' AND productStocks > 0";
                                                $stmt = $conn->prepare($query);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                if($result->num_rows > 0)
                                                {
                                                    while ($row = $result->fetch_assoc()) { 
                                                        $_SESSION['product_ID'] = $row['productID'];
                                                        $productID = $row['productID'];
                                                        $productName = $row['productName'];
                                                        $productPrice = $row['productPrice'];
                                                        $imageName = $row['productImage']; // Assuming this is the column containing the image names
                                                        $_SESSION['productImage'] = $row['productImage'];
                                                        $_SESSION['productName'] = $row['productName'];
                                                        $imageUrl = "../admin/images/products/" . $imageName;
                                                ?>
                                                <?php include 'bratings.php'; ?>
                                                    <div class="col-md-3 mt-2"> 
                                                        <form method="POST">  
                                                            <div class="card">
                                                                <?php   include 'addToCart.php'; ?>
                                                                    <div class="d-flex justify-content-between">
                                                                        <h5 class="text-center p-2 font-num" id="productPriceTag"><?= $productName ?></h5>
                                                                    </div>
                                                                    <img src="<?= $imageUrl; ?>" alt="123" class="w-100 rounded-top" height="220px" id="productImage2">
                                                                    <button type="button" class="text-light border border-0 py-2 rounded-bottom fs-4" style="background-color: #800000 !important ;" data-bs-target="#ratingsModal<?= $productID ?>" data-bs-toggle="modal"><i class="fa-solid fa-star"></i>&nbsp Rate &nbsp<i class="fa-solid fa-star"></i></button>
                                                                </div>
                                                        </form>
                                                    </div>
                                                <?php }
                                                }
                                                else
                                                { ?>
                                                    <h1 class="text-center">No data found.</h1>
                                                <?php }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-content rounded border-dark" id="myTabContent">
                                    <div class="tab-pane fade show" id="sides" role="tabpanel" aria-labelledby="sides-tab">
                                    <div class="row">
                                            <?php
                                                $query = "SELECT * FROM `product_tbl` WHERE productCategory = 'sides' AND productStocks > 0";
                                                $stmt = $conn->prepare($query);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                if($result->num_rows > 0)
                                                {
                                                    while ($row = $result->fetch_assoc()) { 
                                                        $_SESSION['product_ID'] = $row['productID'];
                                                        $productID = $row['productID'];
                                                        $productName = $row['productName'];
                                                        $productPrice = $row['productPrice'];
                                                        $imageName = $row['productImage']; // Assuming this is the column containing the image names
                                                        $_SESSION['productImage'] = $row['productImage'];
                                                        $_SESSION['productName'] = $row['productName'];
                                                        $imageUrl = "../admin/images/products/" . $imageName;
                                                ?>
                                                <?php include 'bratings.php'; ?>
                                                    <div class="col-md-3 mt-2"> 
                                                        <form method="POST">  
                                                            <div class="card">
                                                                <?php   include 'addToCart.php'; ?>
                                                                    <div class="d-flex justify-content-between">
                                                                        <h5 class="text-center p-2 font-num" id="productPriceTag"><?= $productName ?></h5>
                                                                    </div>
                                                                    <img src="<?= $imageUrl; ?>" alt="123" class="w-100 rounded-top" height="220px" id="productImage2">
                                                                    <button type="button" class="text-light border border-0 py-2 rounded-bottom fs-4" style="background-color: #800000 !important ;" data-bs-target="#ratingsModal<?= $productID ?>" data-bs-toggle="modal"><i class="fa-solid fa-star"></i>&nbsp Rate &nbsp<i class="fa-solid fa-star"></i></button>
                                                                </div>
                                                        </form>
                                                    </div>
                                                <?php }
                                                }
                                                else
                                                { ?>
                                                    <h1 class="text-center">No data found.</h1>
                                                <?php }
                                            ?>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-"></div>
            </div>
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
        document.addEventListener('DOMContentLoaded', function() {
            // Get all elements with the class 'font-num' and adjust font size
            var priceTagElements = document.querySelectorAll('#productPriceTag');
    
            // Loop through each element and adjust font size based on text length
            priceTagElements.forEach(function(element) {
                var textLength = element.textContent.length;
    
                // Set the base font size and the maximum text length
                var baseFontSize = 18; // Set your base font size
                var maxTextLength = 23;
    
                // Adjust font size based on text length
                if (textLength > maxTextLength) {
                    var fontSizeAdjustment = baseFontSize * maxTextLength / textLength;
                    element.style.fontSize = fontSizeAdjustment + 'px';
                } else {
                    element.style.fontSize = baseFontSize + 'px';
                }
            });
        });
    </script>

</body>
</html>

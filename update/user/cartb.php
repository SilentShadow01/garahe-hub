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
                                    <a class="nav-link text-center" href="cart.php"><i class="fas fa-shopping-cart"></i></a>
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
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class="table-responsive">
                        <table class="table-hover mt-3" id="cartTable">
                            <thead class="text-light" style="background-color: #800000 !important ;">
                                <tr>
                                    <th class="table_head border border-secondary">ID</th>
                                    <th class="table_head border border-secondary">Image</th>
                                    <th class="table_head border border-secondary">Products</th>
                                    <th class="table_head border border-secondary">Unit Price</th>
                                    <th class="table_head border border-secondary">Quantity</th>
                                    <th class="table_head border border-secondary">Total Price</th>
                                    <th class="table_head border border-secondary">Actions</th>
                                </tr>
                            </thead>
                            
                                <?php
                                    $usersEmail3 = $_SESSION['users_email'];
                                    $query3 = "SELECT * FROM `users_cart_tbl` WHERE usersEmail = '$usersEmail3'";
                                    $result3 = mysqli_query($conn, $query3);
                                    if (mysqli_num_rows($result3) > 0)
                                    { ?>
                                        <tbody>
                                            <?php 
                                                while ($row = mysqli_fetch_assoc($result3))
                                                { 
                                                    $productPrice = $row['productPrice'];
                                                    $productQuantity = $row['productQuantity'];
                                                    $totalPrice = $productQuantity * $productPrice;
                                                    ?>
                                                    <tr>
                                                        <td class="border border-secondary"><?= $row['productID']?></td>
                                                        <td class="border border-secondary border-end-0"><img class="w-100 rounded d-flex justify-content-start" height="140px" src="../admin/images/products/<?= $row['productImage']?>"></td>
                                                        <td class="font_me border border-secondary fw-200 border-start-0"><?= $row['productName']?></td>
                                                        <td class="border border-secondary fw-200">₱<?= $row['productPrice']?></td>
                                                        <td class="border border-secondary fw-200"><?= $row['productQuantity']?></td>
                                                        <td class="border border-secondary fw-200">₱<?= $totalPrice; ?></td>
                                                        <td class="border border-secondary"><button class="font_me btn btn-warning text-danger fw-100">Check Out</button></td>
                                                    </tr>
                                                <?php }
                                            ?>
                                        </tbody>
                                    <?php }
                                    else
                                    { ?>
                                        <tbody class="border border-secondary">
                                            <tr>
                                                <td colspan="7" class="text-center">Cart is empty.</td>
                                            </tr>
                                        </tbody>
                                    <?php }
                                ?>
                            
                        </table>
                    </div>
                    <div class="col-md-1"></div>
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
    <!-- DATATABLES CART -->
    <script>
        $(document).ready(function() {
            $('#cartTable').DataTable({
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

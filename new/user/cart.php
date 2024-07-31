<?php
    session_start();
    
    include '../assets/connection.php';
    if (!isset($_SESSION['users_email']))
    {
        // Redirect to login page
        echo "<script>window.location.href='../index.php';</script>";
        exit();
    }
    
    
    // Check if 'cart' is not already set in the session
if (!isset($_SESSION['cart'])) {
    // If not, initialize it as an empty array
    $_SESSION['cart'] = array();
}

// Function to get the latest product prices
function getLatestPrices($conn)
{
    $prices = array();

    $query = "SELECT productID, productPrice FROM product_tbl";
    $result = mysqli_query($conn, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $prices[$row['productID']] = $row['productPrice'];
        }
    }

    return $prices;
}

// Check if the user is logged in
if (isset($_SESSION['users_email'])) {
    $usersEmail = mysqli_real_escape_string($conn, $_SESSION['users_email']);

    // Fetch latest product prices
    $latestPrices = getLatestPrices($conn);

// Update the cart with the latest prices
$updateQuery = "UPDATE users_cart_tbl
                JOIN product_tbl ON users_cart_tbl.productID = product_tbl.productID
                SET users_cart_tbl.productPrice = product_tbl.productPrice
                WHERE users_cart_tbl.usersEmail = '$usersEmail'";
mysqli_query($conn, $updateQuery);


    // Display the cart
    $cartItemsHTML = '<div id="selectedProductsDisplay">';
    // Your existing cart item display logic here
    $cartItemsHTML .= '</div>';
} else {
    $cartItemsHTML = '<h1 class="font_me text-center">User not logged in.</h1>';
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
                            <?php
                                $usersEmail = mysqli_real_escape_string($conn, $_SESSION['users_email']);

                                $queryDelivery = "SELECT * FROM user_delivery_tbl WHERE userEmailAddress = '$usersEmail' AND orderStatus = 'complete'";
                                $resultDelivery = mysqli_query($conn, $queryDelivery);

                                if(mysqli_num_rows($resultDelivery) == 0)
                                {
                                }
                                else
                                {
                                    // Query to check if the users_email exists in the database
                                    $query = "SELECT * FROM user_ratings_tbl WHERE userEmail = '$usersEmail'";
                                    $result = mysqli_query($conn, $query);
                                    if (mysqli_num_rows($result) == 0) { ?>
                                        <li class="nav-item mt-2 me-3">
                                            <a class="nav-link fs-5" href="#" data-bs-target="#ratingsModal" data-bs-toggle="modal">Rate</a>
                                        </li>
                                    <?php }
                                    else
                                    { }
                                }
                            ?>
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
    <?php include 'ratings.php'; ?>
    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                <div id="selectedProductsDisplay"></div>
                    <div class="card mt-4">
                        <form method="POST" id="cartForm" action="deleteCartProduct.php"> <!-- May nadagdag na code rito sa line na ito -->
                            <div class="card-header" style="background-color: #A73121;">
                                <h2 class="font_me text-light"><i class="fa-solid fa-cart-shopping"></i>&nbsp Cart</h2>
                            </div>
                            <div class="card-body m-3" style="max-height: 60vh; overflow-y: auto;">
                                <?php
                                    $usersEmail3 = $_SESSION['users_email'];
                                    $query3 = "SELECT * FROM `users_cart_tbl` WHERE usersEmail = '$usersEmail3'";
                                    $result3 = mysqli_query($conn, $query3);

                                    if (mysqli_num_rows($result3) > 0) {
                                        while ($row = mysqli_fetch_assoc($result3)) 
                                        {
                                            $productPrice = $row['productPrice'];
                                            $productQuantity = $row['productQuantity'];
                                            $totalPrice = $productQuantity * $productPrice;
                                ?>
                                <div class="form-check border border-secondary rounded mb-3 p-3">
                                    <input class="p-2 form-check-input border border-2 border-primary cart-checkbox" type="checkbox" value="<?= $row['productID']; ?>" id="checkbox_<?= $row['productID']; ?>" data-product-id="<?= $row['productID']; ?>">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <img class="rounded w-100" src="../admin/images/products/<?= $row['productImage']; ?>" alt="<?= $row['productName']; ?>" style="height: 100px;">
                                        </div>
                                        <div class="col-md-3">
                                            <span class="font_me fw-bold col-md-4"><?= $row['productName']; ?>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-check-label font-num fw-semibold" for="productCheckbox<?= $row['productID']; ?>">
                                                <span class="font_me">Quantity:</span>
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control form-control-sm text-center quantity-input" id="quantityInput<?= $row['productID']; ?>" name="quantityInput<?= $row['productID']; ?>" value="<?= $row['productQuantity']; ?>" oninput="validateAndChange(this, '<?= $row['productID']; ?>')" data-product-price="<?= $row['productPrice']; ?>">

                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="pt-4 form-check-label font-num fw-semibold" for="productCheckbox<?= $row['productID']; ?>">
                                                <span class="font_me">Unit Price: </span><?= $row['productPrice']; ?>
                                            </label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="pt-4 form-check-label d-flex justify-content-center font-num fw-semibold" for="productCheckbox<?= $row['productID']; ?>">
                                                <span id="totalPrice_quantityInput<?= $row['productID']; ?>">Total Price: <?= $totalPrice ; ?></span>
                                                <input type="hidden" id="totalInput_quantityInput<?= $row['productID']; ?>" name="totalInput<?= $row['productID']; ?>" value="<?= $totalPrice ?>">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                        }
                                    } else { ?>
                                        <h1 class="font_me text-center">No items at the cart.</h1>
                                    <?php }
                                ?>
                            </div>
                            <div class="card-footer" style="background-color: #A73121;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAllCheckbox">
                                        <label class="form-check-label font-me text-white" for="selectAllCheckbox">Select All</label>
                                    </div>
                                    <div class="d-flex">
                                    <button type="button" class="font_me border border-danger btn btn-warning text-dark fw-semibold" onclick="deleteSelected()">Delete Selected &nbsp;<i class="fa-solid fa-trash"></i></button>
                                        <div style="margin-right: 10px;"></div>
                                        <button type="button" class="font_me border border-danger btn btn-warning text-dark fw-semibold" onclick="checkout()">Check Out &nbsp;<i class="fa-solid fa-cart-shopping"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-2"></div>
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
    <script>
        function checkout() {
            const selectedItems = [];
            const checkboxes = document.querySelectorAll('.cart-checkbox:checked');

            if (checkboxes.length === 0) {
                alert('No item selected');
                return; // Prevent redirection if no items are selected
            }
            checkboxes.forEach(checkbox => {
                selectedItems.push(checkbox.getAttribute('data-product-id'));
            });

            const params = new URLSearchParams();
            selectedItems.forEach(item => params.append('productID[]', item));

            window.location.href = `cartPayment.php?${params.toString()}`;
        }
    </script>
    
                                                                                <!-- Select All and Delete Function (by Julius) -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Get reference to the "Select All" checkbox
            var selectAllCheckbox = document.getElementById('selectAllCheckbox');
    
            // Get references to all product checkboxes
            var productCheckboxes = document.querySelectorAll('.cart-checkbox');
    
            // Add click event listener to "Select All" checkbox
            selectAllCheckbox.addEventListener('click', function () {
                // Iterate through all product checkboxes and set their state to match "Select All"
                productCheckboxes.forEach(function (checkbox) {
                    checkbox.checked = selectAllCheckbox.checked;
                });
            });
    
            // Add click event listener to individual product checkboxes
            productCheckboxes.forEach(function (checkbox) {
                checkbox.addEventListener('click', function () {
                    // If any product checkbox is unchecked, uncheck "Select All"
                    if (!checkbox.checked) {
                        selectAllCheckbox.checked = false;
                    } else {
                        // Check "Select All" if all product checkboxes are checked
                        var allChecked = Array.from(productCheckboxes).every(function (checkbox) {
                            return checkbox.checked;
                        });
                        selectAllCheckbox.checked = allChecked;
                    }
                });
            });
        });
    </script>

    <script>
        function deleteSelected() {
            // Get references to all product checkboxes
            var productCheckboxes = document.querySelectorAll('.cart-checkbox:checked');
        
            if (productCheckboxes.length === 0) {
                alert('No item selected for deletion');
                return;
            }
        
            // Create an array to store the selected product IDs
            var selectedItems = Array.from(productCheckboxes).map(function (checkbox) {
                return checkbox.getAttribute('data-product-id');
            });
        
            // Show confirmation dialog
            var confirmDelete = confirm("Are you sure you want to delete the selected item(s)?");
        
            if (confirmDelete) {
                // Add hidden inputs to the form for each selected product ID
                var form = document.getElementById('cartForm');
                selectedItems.forEach(function (productId) {
                    var input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'productID[]'; // Use array syntax to handle multiple values
                    input.value = productId;
                    form.appendChild(input);
                });
        
                // Submit the form
                form.submit();
            }
        }
    </script>
    <script>
        function validateAndChange(input, productId) {
            // Validate the input value (you can customize this validation)
            var newValue = parseInt(input.value);
            if (isNaN(newValue) || newValue < 1) {
                // If the input is not a number or less than 1, set it to 1
                input.value = '';
                newValue = 1;
            }

            // Update the quantity in the database
            updateQuantity(productId, newValue);
        }

        function updateQuantity(productId, newQuantity) {
            // Make an AJAX request to update the quantity in the database
            $.ajax({
                type: "POST",
                url: "update_quantity.php",
                data: { productId: productId, newQuantity: newQuantity },
                success: function(response) {
                    console.log(response);
                    // You can display a message or perform any other actions on success
                },
                error: function(error) {
                    console.log("Error updating quantity: " + error);
                    // Handle the error as needed
                }
            });
        }
    </script>
                                                                                            <!-- Select All and Delete Function (by Julius) -->
</body>
</html>

<?php
    include '../assets/loginAccount.php';
    include 'assets/getInformations.php';
    if (!isset($_SESSION['admin_name']))
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <title>Home Page</title>
  <style>
        #company-name, #titleStocks, 
        #titleReservation, #titleDelivery, #titleOrders{
            font-family: "Source Serif 4", Georgia, serif;
        }
        .font-me {
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
                    <h1 class="h2" id="currentPage"><i class="fa-solid fa-house"></i>&nbsp Home</h1>
                </div>
                <div class="container mt-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mb-5" height="250px;">
                                <h1 class="p-3 fs-5" id="titleStocks">Users:</h1>
                                <h1 class="text-center fw-bold font-me"><?= $totalUser; ?></h1>
                            </div>
                        </div> 
                        <div class="col-md-4">
                            <div class="card mb-5" height="250px;">
                                <h1 class="p-3 fs-5" id="titleStocks">Product Quality Ratings:</h1>
                                <h1 class="text-center fw-bold font-me"><?= $productQualityRatings; ?>&nbsp<i class="fa-solid fa-star"></i></h1>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-5" height="250px;">
                                <h1 class="p-3 fs-5" id="titleStocks">Delivery Service Ratings:</h1>
                                <h1 class="text-center fw-bold font-me"><?= $deliveryServiceRatings; ?>&nbsp<i class="fa-solid fa-star"></i></h1>
                            </div>
                        </div>
                    </div> 
                    <div class="row d-flx justify-content-between">
                        <div class="col-md-3">              
                            <div class="card">
                                <h1 class="p-3 fs-5" id="titleReservation">Pending Reservation:</h1>
                                <h1 class="text-center fw-bold font-me"><?= $pendingReservation; ?></h1>
                            </div>
                        </div>
                        <div class="col-md-3">              
                            <div class="card">
                                <h1 class="p-3 fs-5" id="titleDelivery">Pending Delivery</h1>
                                <h1 class="text-center fw-bold font-me"><?= $deliveryToday; ?></h1>
                            </div>
                        </div>
                        <div class="col-md-3">              
                            <div class="card">
                                <h1 class="p-3 fs-5" id="titleDelivery">Pending Pick Up</h1>
                                <h1 class="text-center fw-bold font-me"><?= $pickUpToday; ?></h1>
                            </div>
                        </div>
                        <div class="col-md-3">              
                            <div class="card">
                                <h1 class="p-3 fs-5" id="titleOrders">Completed Orders:</h1>
                                <h1 class="text-center fw-bold font-me"><?= $completeOrder; ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="fixed-bottom bg-dark text-center" style="background-color: #800000 !important ;">
                <div class="text-light">
                    <script>document.write(new Date().getFullYear())</script> &copy; All right reserved to the developers of the system.</a> 
                </div>
            </footer>
        </div>
    </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
    include '../assets/loginAccount.php';
    if (!isset($_SESSION['admin_name']))
    {
        // Redirect to login page
        echo "<script>window.location.href='../index.php';</script>";
        exit();
    }    
    include '../assets/connection.php';
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editOrderStatus'])) {
        // Get the form data
        $userEmailAddress = mysqli_real_escape_string($conn, $_POST['userEmailAddress']);
        $orderDate = date('Y-m-d', strtotime($_POST['orderDate']));
        $orderTime = mysqli_real_escape_string($conn, $_POST['orderTime']);
        $newOrderStatus = mysqli_real_escape_string($conn, $_POST['orderStatus']);
        // var_dump($_POST);
        // Fetch the rows that match the condition
        $additionalSql = "SELECT * FROM user_delivery_tbl WHERE orderDate = '$orderDate' AND orderTime= '$orderTime' AND orderStatus = 'to-ship'";
        // var_dump($additionalSql);
        $additionalResult = mysqli_query($conn, $additionalSql);
        while ($additionalRow = mysqli_fetch_assoc($additionalResult))
        {
            // var_dump($additionalRow);
            $rowID = $additionalRow['ID'];
            // var_dump($rowID); 
            $updateQuery = "UPDATE user_delivery_tbl SET orderStatus = '$newOrderStatus' WHERE ID = '$rowID' AND orderStatus = 'to-ship'";
            $updateResult = mysqli_query($conn, $updateQuery);
        }
        header("Location: ptoShip.php");
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
  <title>To be shipped</title>
  <style>
        #company-name, #titleStocks, 
        #titleReservation, #titleDelivery, #titleOrders, .font_me{
            font-family: "Source Serif 4", Georgia, serif;
        }
        .font-num {
            font-family: "Times New Roman", Times, serif;
        }
        .dataTables_filter input {
            margin-bottom: 2rem;
        }

        .dataTables_length select {
            margin-bottom: 2rem;
        }
  </style>
</head>
<body class="bg-light bg-gradient">
    <div class="container-fluid">
        <div class="row">
            <header class="navbar sticky-top flex-md-nowrap p-2 shadow" style="background-color: #800000 !important ;">
                <h2 class="logo text-light p-1" id="company-name">Garahe Food House</h2>
            </header>
            <?php include 'sidenavbar.php'; ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="background-color: #F2E8C6;">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom border-dark">
                    <h1 class="h2" id="currentPage"><i class="fa-solid fa-truck"></i>&nbsp To be shipped</h1>
                </div>
                <div class="table-responsive">
                    <table class="border border-secondary" id="tableDineIn">
                        <thead class="text-light" style="background-color: #800000 !important ;">
                            <tr>
                                <th class="font_me border border-secondary">Transaction #</th>
                                <th class="font_me border border-secondary">Date of Order</th>
                                <th class="font_me border border-secondary">Time of Order</th>
                                <th class="font_me border border-secondary">Contact #</th>
                                <th class="font_me border border-secondary">Mode of Claim</th>
                                <th class="font_me border border-secondary">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="border border-secondary">
                            <?php

                                $sql = "SELECT *
                                FROM user_delivery_tbl WHERE orderStatus = 'to-ship' AND modeOfClaim = 'pickUp'
                                GROUP BY userEmailAddress, orderDate, orderTime";

                                $result = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($result) > 0)
                                {
                                    while ($row = mysqli_fetch_assoc($result))
                                    { 
                                        $productQuantity = $row['productQuantity'];
                                        $productPrice = $row['productPrice'];
                                        $totalAmount = $productQuantity * $productPrice;
                                        ?>
                                        <tr>
                                            <td class="border border-secondary font-num"><?= $row['transactionNumber'] ?></td>
                                            <td class="border border-secondary font-num"><?= date('F d, Y', strtotime($row['orderDate'])); ?></td>
                                            <td class="border border-secondary font-num"><?= $row['orderTime'] ?></td>
                                            <td class="border border-secondary font-num"><?= $row['receiverPhoneNumber'] ?></td>
                                            <td class="border border-secondary font-num">
                                                <?php 
                                                    if($row['modeOfClaim'] == 'pickUp')
                                                    {
                                                        echo 'Pick up';
                                                    }
                                                    else
                                                    {
                                                        echo 'Deliver';
                                                    }
                                                ?>
                                            </td>
                                            <td class="border border-secondary d-flex justify-content-center font-num">
                                                <?php
                                                    if ($row['orderStatus'] === 'complete')
                                                    { ?>
                                                        <a href="" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#actionModal<?= $row['ID']; ?>" id="requestActionBtn">
                                                            Check
                                                        </a>
                                                    <?php }
                                                    else
                                                    { ?>
                                                        <a href="" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#actionModal<?= $row['ID']; ?>" id="requestActionBtn">
                                                            Info
                                                        </a>
                                                    <?php }
                                                ?>
                                            </td>
                                            <!-- Modal -->
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
                                                                                        <img class="rounded w-50" src="images/products/<?= $additionalRow['productImage']; ?>" alt="<?= $row['productName']; ?>" style="height: 100px;">
                                                                                        <label class="font-num form-check-label" for="productCheckbox<?= $additionalRow['productID']; ?>">
                                                                                            <span class="font_me fw-bold col-md-2"><?= $additionalRow['productName']; ?>
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                        <label class="font-num pt-4 form-check-label font-num fw-semibold" for="productCheckbox<?= $additionalRow['productID']; ?>">
                                                                                            <?= $row['productID']; ?>
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                        <label class="font-num pt-4 form-check-label font-num fw-semibold" for="productCheckbox<?= $additionalRow['productID']; ?>">
                                                                                            <span class="font-num ">Quantity: </span><?= $additionalRow['productQuantity']; ?>
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                        <label class="font-num pt-4 form-check-label font-num fw-semibold" for="productCheckbox<?= $additionalRow['productID']; ?>">
                                                                                            <span class="font-num ">Unit Price: </span><?= $additionalRow['productPrice']; ?>
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                        <label class="pt-4 form-check-label d-flex justify-content-center font-num fw-semibold" for="productCheckbox<?= $row['productID']; ?>">
                                                                                            <span class="font-num ">Total Price: </span><?= $additionalTotal ; ?>
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        <?php }
                                                                    ?>
                                                                    
                                                                    <!-- END OF DISPLAY -->
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
                                                                        <strong class="font-num input-group-text col-4">Status </strong> 
                                                                        <select class="font-num form-control text-center" name="orderStatus" id="orderStatus" type="text" value="<?= $row['orderStatus']; ?>">
                                                                            <option value="to-ship" class="bg-info text-dark" <?= $row['orderStatus'] == 'to-ship' ? 'selected' : '' ?> disabled>To ship</option>
                                                                            <option value="to-received" class="bg-warning text-danger" <?= $row['orderStatus'] == 'to-received' ? 'selected' : '' ?>>To Received</option>
                                                                        </select>
                                                                    </div>
                                                                    <?php include 'updateDeliver.php';?>
                                                                    <div class="modal-footer btn-group bg-dark-tertiary">
                                                                        <button type="submit" class="font-num btn btn-success" name="editOrderStatus">Save</button>
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
            </main>
            <footer class="fixed-bottom bg-dark text-center" style="background-color: #800000 !important ;">
                <div class="text-light">
                    <script>document.write(new Date().getFullYear())</script> &copy; All right reserved to the developers of the system.</a> 
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tableDineIn').DataTable({
                "ordering": true,
                "order": [[1, "desc"]],
                "language": {
                    "sortAsc": "<i class='bi bi-sort-alpha-down'></i>",
                    "sortDesc": "<i class='bi bi-sort-alpha-up-alt'></i>"
                },
            });
        });
    </script>
</body>
</html>

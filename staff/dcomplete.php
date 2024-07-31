<?php
    include '../assets/connection.php';
    include '../assets/loginAccount.php';
    if (!isset($_SESSION['admin_name']))
    {
        // Redirect to login page
        echo "<script>window.location.href='../index.php';</script>";
        exit();
    }
    if (isset($_POST['editReservationBtn'])) {
        $transactionNumber = $_POST['transactionNumber'];
        $reservationStatus = $_POST['reservationStatus'];

        // Update reservationStatus in the database
        $updateQuery = "UPDATE users_reservation_tbl SET reservationStatus = '$reservationStatus' WHERE transactionNumber = '$transactionNumber'";
        $updateResult = mysqli_query($conn, $updateQuery);

        $admin_name = $_SESSION['admin_name'];
        $log_message = "<strong>$admin_name</strong> set the Reservation Status into <strong>$reservationStatus</strong> where Transaction number is <strong>$transactionNumber</strong>.";
        $sql_insert_log = "INSERT INTO transaction_log_tbl (transactionLogMsg, logDateTime) VALUES (?, NOW())";
        $stmt_insert_log = $conn->prepare($sql_insert_log);
        $stmt_insert_log->bind_param("s", $log_message);
        $stmt_insert_log->execute();
        if ($updateResult) {
            echo "<script>window.location.href = 'dineIn.php';</script>";
        } else {
            echo "<script>console.error('Error updating reservation status: " . mysqli_error($conn) . "');</script>";
        }
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
    <title>Dine In</title>
    <style>
            #company-name, #titleStocks, 
            #titleReservation, #titleDelivery, #titleOrders
            , .font_me{
                font-family: "Source Serif 4", Georgia, serif;
            }
            .dataTables_filter input {
                margin-bottom: 1rem;
            }

            .dataTables_length select {
                margin-bottom: 1rem;
            }
    </style>
</head>
<body style="background-color: #C08261 !important ;">
    <div class="container-fluid">
        <div class="row">
            <header class="navbar sticky-top flex-md-nowrap p-2 shadow" style="background-color: #800000 !important ;">
                <h2 class="logo text-light p-1" id="company-name">Garahe Food House</h2>
            </header>
            <?php include 'sidenavbar.php'; ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="background-color: #F2E8C6;">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom border-dark">
                    <h1 class="h2" id="currentPage"><i class="fa-solid fa-house"></i>&nbsp Dine In > Complete</h1>
                </div>
                <div class="table-responsive mb-5">
                    <table class="border border-secondary" id="tableDineIn">
                        <thead class="text-light" style="background-color: #800000 !important ;">
                            <tr>
                                <th class="font_me border border-secondary">Transaction Number</th>
                                <th class="font_me border border-secondary">Date of Reservation</th>
                                <th class="font_me border border-secondary">Time of Reservation</th>
                                <th class="font_me border border-secondary">Email Address</th>
                                <th class="font_me border border-secondary">Status</th>
                                <th class="font_me border border-secondary">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="border border-secondary">
                            <?php

                                $query = "SELECT * FROM users_reservation_tbl WHERE reservationType = 'dineIn' AND reservationStatus = 'complete'";
                                $result = mysqli_query($conn, $query);

                                if (mysqli_num_rows($result) > 0)
                                {
                                    while ($row = mysqli_fetch_assoc($result))
                                    { 
                                        $_SESSION['transactionNumber'] = $row['transactionNumber'];
                                        ?>
                                        <tr>
                                            <td class="border border-secondary"><?= $row['transactionNumber'] ?></td>
                                            <td class="border border-secondary"><?= date('F d, Y', strtotime($row['reservationDate'])); ?></td>
                                            <td class="border border-secondary"><?= $row['reservationTime'] ?></td>
                                            <td class="border border-secondary"><?= $row['userEmailAddress'] ?></td>
                                            <td class="border border-secondary"><?= $row['reservationStatus'] ?></td>
                                            <td class="border border-secondary d-flex justify-content-center">
                                                <?php
                                                    if ($row['reservationStatus'] === 'Pending')
                                                    { ?>
                                                        <a href="" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#actionModal<?= $row['ID']; ?>" id="requestActionBtn">
                                                            Check
                                                        </a>
                                                    <?php }
                                                    else
                                                    { ?>
                                                        <a href="" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#infoModal<?= $row['ID']; ?>" id="requestActionBtn">
                                                            Info
                                                        </a>
                                                    <?php }
                                                ?>
                                            </td>
                                            <!-- Modal -->
                                            <div class="modal fade" id="actionModal<?= $row['ID']; ?>" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">                                <div class="modal-content">
                                                        <div class="modal-header text-light" style="background-color: #800000 !important ;">
                                                            <h5 class="modal-title" id="actionModal<?= $row['ID']; ?>Label">Reservation Information</h5>
                                                            <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body bg-body-tertiary">
                                                            <div class="container">
                                                                <div class="" id="message"></div>
                                                                <form method="POST">
                                                                    <div class="input-group mt-1">
                                                                        <strong class="input-group-text col-4">Transaction Number</strong>
                                                                        <input type="text" class="form-control text-center" id="transactionNumber" name="transactionNumber" value="<?= $row['transactionNumber']; ?>" readonly>
                                                                    </div>
                                                                    <div class="input-group mt-1">
                                                                        <strong class="input-group-text col-4">User Name</strong>   
                                                                        <input type="text" class="form-control text-center" id="referenceNum" name="referenceNum" value="<?= $row['reservationFullName']; ?>" readonly> 
                                                                    </div>
                                                                    <div class="input-group mt-1">
                                                                        <strong class="input-group-text col-4">Date of Reservation</strong>    
                                                                        <input type="text" class="form-control text-center" id="documentName" name="documentName" value="<?= date('F d, Y', strtotime($row['reservationDate'])); ?>" readonly>
                                                                    </div>
                                                                    <div class="input-group mt-1">
                                                                        <strong class="input-group-text col-4">Time of Reservation</strong> 
                                                                        <input type="text" class="form-control text-center" id="quantityDocs" name="quantityDocs" value="<?= $row['reservationTime']; ?>" readonly>   
                                                                    </div>
                                                                    <div class="input-group mt-1">
                                                                        <strong class="input-group-text col-4">Phone Number</strong> 
                                                                        <input type="text" class="form-control text-center" id="quantityDocs" name="quantityDocs" value="<?= $row['reservationPhoneNumber']; ?>" readonly>   
                                                                    </div>
                                                                    <div class="input-group mt-1">
                                                                        <strong class="input-group-text col-4">Email Address</strong> 
                                                                        <input type="text" class="form-control text-center" id="quantityDocs" name="quantityDocs" value="<?= $row['userEmailAddress']; ?>" readonly>   
                                                                    </div>
                                                                    <div class="input-group mt-1">
                                                                        <strong class="input-group-text col-4">Proof of Payment</strong> 
                                                                        <img src="../user/images/proof/reservations/<?= $row['proofofPayment']; ?>" class="form-control text-center" alt="No Proof of Purchase">
                                                                    </div>
                                                                    <div class="input-group mt-1">
                                                                        <strong class="input-group-text col-4">Status </strong> 
                                                                        <select class="form-control text-center" name="reservationStatus" id="reservationStatus" type="text" value="<?= $row['reservationStatus']; ?>">
                                                                            <option value="Pending" class="bg-info text-dark" <?= $row['reservationStatus'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                                                            <option value="Approved" class="bg-success text-light" <?= $row['reservationStatus'] == 'Approved' ? 'selected' : '' ?>>Approved</option>
                                                                            <option value="Reject" class="bg-danger text-light" <?= $row['reservationStatus'] == 'Reject' ? 'selected' : '' ?>>Reject</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="modal-footer btn-group bg-dark-tertiary">
                                                                        <button type="submit" class="btn btn-success" name="editReservationBtn">Save</button>
                                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                                    </div>   
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                            <!-- END MODAL -->
                                            <!-- INFO MODAL -->
                                            <!-- Modal -->
                                            <div class="modal fade" id="infoModal<?= $row['ID']; ?>" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">                                <div class="modal-content">
                                                        <div class="modal-header text-light" style="background-color: #800000 !important ;">
                                                            <h5 class="modal-title" id="infoModal<?= $row['ID']; ?>Label">Reservation Information</h5>
                                                            <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body bg-body-tertiary">
                                                            <div class="container">
                                                                <div class="" id="message"></div>
                                                                <form method="POST">
                                                                    <div class="input-group mt-1">
                                                                        <strong class="input-group-text col-4">Transaction Number</strong>
                                                                        <input type="text" class="form-control text-center" id="transactionNumber" name="transactionNumber" value="<?= $row['transactionNumber']; ?>" readonly>
                                                                    </div>
                                                                    <div class="input-group mt-1">
                                                                        <strong class="input-group-text col-4">User Name</strong>   
                                                                        <input type="text" class="form-control text-center" id="referenceNum" name="referenceNum" value="<?= $row['reservationFullName']; ?>" readonly> 
                                                                    </div>
                                                                    <div class="input-group mt-1">
                                                                        <strong class="input-group-text col-4">Date of Reservation</strong>    
                                                                        <input type="text" class="form-control text-center" id="documentName" name="documentName" value="<?= date('F d, Y', strtotime($row['reservationDate'])); ?>" readonly>
                                                                    </div>
                                                                    <div class="input-group mt-1">
                                                                        <strong class="input-group-text col-4">Time of Reservation</strong> 
                                                                        <input type="text" class="form-control text-center" id="quantityDocs" name="quantityDocs" value="<?= $row['reservationTime']; ?>" readonly>   
                                                                    </div>
                                                                    <div class="input-group mt-1">
                                                                        <strong class="input-group-text col-4">Phone Number</strong> 
                                                                        <input type="text" class="form-control text-center" id="quantityDocs" name="quantityDocs" value="<?= $row['reservationPhoneNumber']; ?>" readonly>   
                                                                    </div>
                                                                    <div class="input-group mt-1">
                                                                        <strong class="input-group-text col-4">Email Address</strong> 
                                                                        <input type="text" class="form-control text-center" id="quantityDocs" name="quantityDocs" value="<?= $row['userEmailAddress']; ?>" readonly>   
                                                                    </div>
                                                                    <div class="input-group mt-1">
                                                                        <strong class="input-group-text col-4">Proof of Payment</strong> 
                                                                        <img src="../user/images/proof/reservations/<?= $row['proofofPayment']; ?>" class="form-control text-center" alt="No Proof of Purchase" readonly>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                            <!-- END INFO MODAL -->
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

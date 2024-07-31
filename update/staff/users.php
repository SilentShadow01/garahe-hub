<?php
session_start();
include '../assets/connection.php';
if (!isset($_SESSION['admin_name'])) {
    // Redirect to login page
    echo "<script>window.location.href='../index.php';</script>";
    exit();
}
if (isset($_POST['btnUpdateUserStatus'])) {
        // Retrieve values from the form
        $usersEmail = $_POST['userEmailAddress'];
        $userStatus = $_POST['userStatus'];
        $accountStatus = $_POST['accountStatus'];

        // Update the user information in the database
        $updateQuery = "UPDATE usermanagement_tbl 
                        SET userStatus='$userStatus', accountStatus='$accountStatus' WHERE userEmailAddress='$usersEmail'";

        $admin_name = $_SESSION['admin_name'];
        $log_message = "<strong>$admin_name</strong> updated the User Status into <strong>$userStatus</strong> and Account status into <strong>$accountStatus</strong> for <strong>$usersEmail</strong>.";
        $sql_insert_log = "INSERT INTO transaction_log_tbl (transactionLogMsg, logDateTime) VALUES (?, NOW())";
        $stmt_insert_log = $conn->prepare($sql_insert_log);
        $stmt_insert_log->bind_param("s", $log_message);
        $stmt_insert_log->execute();
        
        if (mysqli_query($conn, $updateQuery)) {
            // Redirect to a page after successful update
            header("Location: users.php");
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Users</title>
    <style>
        #company-name,
        #currentPage {
            font-family: "Source Serif 4", Georgia, serif;
        }

        .dataTables_filter input {
            margin-bottom: 2rem;
        }

        .dataTables_length select {
            margin-bottom: 2rem;
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
                    <h1 class="h2" id="currentPage"><i class="fa-solid fa-users"></i>&nbsp Users</h1>
                </div>
                <div class="table-responsive mb-5">
                    <table class="rounded border border-1  border-dark" id="usersTable">
                        <thead class="text-light" style="background-color: #800000 !important ;">
                            <tr>
                                <th class="border border-dark">ID</th>
                                <th class="border border-dark">First Name</th>
                                <th class="border border-dark">Last Name</th>
                                <th class="border border-dark">Email</th>
                                <th class="border border-dark">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include '../assets/connection.php';

                            $query = "SELECT * FROM usermanagement_tbl WHERE `userType` ='user'";
                            $result = mysqli_query($conn, $query);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                    <tr>
                                        <td class="border border-dark"> <?= $row['ID'] ?> </td>
                                        <td class="border border-dark"> <?= $row['firstName'] ?> </td>
                                        <td class="border border-dark"> <?= $row['lastName'] ?> </td>
                                        <td class="border border-dark"> <?= $row['userEmailAddress'] ?> </td>
                                        <td class="border border-secondary font-num">
                                            <a href="#" class="btn btn-outline-dark d-flex justify-content-center" data-bs-toggle="modal" data-bs-target="#actionModal<?= $row['ID']; ?>" id="requestActionBtn">
                                                <i class="fas fa-info-circle"></i>
                                            </a>
                                        </td>
                                    </tr>
                               
                                    <!-- Modal for user credentials -->
                                    <div class="modal fade" id="actionModal<?= $row['ID']; ?>" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
                                            <div class="modal-content">
                                            <form method="POST">
                                                <div class="modal-header text-light" style="background-color: #800000 !important ;">
                                                    <h5 class="modal-title" id="actionModalLabel">User Information</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="input-group mt-1">
                                                        <strong class="input-group-text col-4">First Name</strong>
                                                        <input type="text" class="form-control text-center" value="<?= $row['firstName']; ?>" readonly>
                                                    </div>
                                                    <div class="input-group mt-1">
                                                        <strong class="input-group-text col-4">Middle Name</strong>
                                                        <input type="text" class="form-control text-center" value="<?= $row['middleName']; ?>" readonly>
                                                    </div>
                                                    <div class="input-group mt-1">
                                                        <strong class="input-group-text col-4">Last Name</strong>
                                                        <input type="text" class="form-control text-center" value="<?= $row['lastName']; ?>" readonly>
                                                    </div>
                                                    <div class="input-group mt-1">
                                                        <strong class="input-group-text col-4">Extension Name</strong>
                                                        <input type="text" class="form-control text-center" value="<?= $row['extensionName']; ?>" readonly>
                                                    </div>
                                                    <div class="input-group mt-1">
                                                        <strong class="input-group-text col-4">Email Address</strong>
                                                        <input type="text" class="form-control text-center" id="userEmailAddress" name="userEmailAddress" value="<?= $row['userEmailAddress']; ?>" readonly>
                                                    </div>
                                                    <div class="input-group mt-1">
                                                        <strong class="input-group-text col-4">Contact Number</strong>
                                                        <input type="text" class="form-control text-center" value="<?= $row['contactNumber']; ?>" readonly>
                                                    </div>
                                                    <div class="input-group mt-1">
                                                        <strong class="input-group-text col-4">Address</strong>
                                                        <input type="text" class="form-control text-center" value="<?= $row['userAddress']; ?>" readonly>
                                                    </div>
                                                    <div class="input-group mt-1">
                                                        <strong class="input-group-text col-4">Valid ID</strong>
                                                        <img src="../assets/images/validID/<?= $row['validID']; ?>" class="form-control text-center" alt="No Valid ID">
                                                    </div>
                                                    <div class="input-group mt-1">
                                                        <strong class="input-group-text col-4">User Status </strong> 
                                                        <select class="form-control text-center" name="userStatus" id="userStatus" type="text" value="<?= $row['userStatus']; ?>">
                                                            <option value="active" class="bg-success text-light" <?= $row['userStatus'] == 'active' ? 'selected' : '' ?>>Active</option>
                                                            <option value="inactive" class="bg-danger text-light" <?= $row['userStatus'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                                        </select>
                                                    </div>
                                                    <div class="input-group mt-1">
                                                        <strong class="input-group-text col-4">User Status </strong> 
                                                        <select class="form-control text-center" name="accountStatus" id="accountStatus" type="text" value="<?= $row['accountStatus']; ?>">
                                                            <option value="pending" class="bg-info text-warning" <?= $row['accountStatus'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                                            <option value="verified" class="bg-success text-light" <?= $row['accountStatus'] == 'verified' ? 'selected' : '' ?>>Verified</option>
                                                            <option value="not-verified" class="bg-danger text-light" <?= $row['accountStatus'] == 'not-verified' ? 'selected' : '' ?>>Not Verified</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer btn-group" style="background-color: #800000 !important ;">
                                                    <button type="submit" class="btn btn-success" name="btnUpdateUserStatus">Save</button>
                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                
                            <?php
                                }
                            } else {
                            ?>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </main>
            <footer class="fixed-bottom bg-dark text-center" style="background-color: #800000 !important ;">
                <div class="text-light">
                    <script>
                        document.write(new Date().getFullYear())
                    </script> &copy; All right reserved to the developers of the system.</a>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#usersTable').DataTable({
                "ordering": true,
                "order": [
                    [0, "desc"]
                ],
                "language": {
                    "sortAsc": "<i class='bi bi-sort-alpha-down'></i>",
                    "sortDesc": "<i class='bi bi-sort-alpha-up-alt'></i>"
                },
            });
        });
    </script>
</body>

</html>

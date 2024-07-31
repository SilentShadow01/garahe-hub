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
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Transaction Log</h1>
                </div>
                <div class="table-responsive mb-5">
                  <table class="rounded border border-1  border-dar" id="transactionTable">
                    <thead class="text-light" style="background-color: #800000 !important ;">
                      <tr>
                            <th class="border border-1 border-secondary">Admin / Co-admin Transaction Log</th>
                            <th class="border border-1 border-secondary">Date and Time</th>
                      </tr>
                    </thead>
                    <?php
$query = "SELECT * FROM transaction_log_tbl ORDER BY logDateTime DESC";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    ?>
    <tbody>
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr class="table-light">
            <td class="border border-1 border-secondary">
                <?= $row['transactionLogMsg']; ?>
            </td>
            <td class="border border-1 border-secondary"><?= $row['logDateTime']; ?></td>
        </tr>
        <?php
    }
    ?>
    </tbody>
    <?php
} else {
    // Handle the case when there are no transactions
    ?>
    <tbody>
        <tr class="table-light">
            <td colspan="2" class="text-center">No transactions found</td>
        </tr>
    </tbody>
    <?php
}
?>
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
            $('#transactionTable').DataTable({
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

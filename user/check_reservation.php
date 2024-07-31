<?php
include '../assets/connection.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['date'])) {
    $selectedDate = $_POST['date'];

    // Perform a query to retrieve reservation details
    $query = "SELECT * FROM users_reservation_tbl WHERE reservationDate = '$selectedDate' AND reservationStatus = 'Approved'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $reservationDetails = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $reservationPersonNumber = $row['reservationPersonNumber'];
            $reservationStatus = $row['reservationStatus'];

            // Determine the number of tables based on reservationPersonNumber
            $tablesNeeded = ceil($reservationPersonNumber / 6);

            // Add details to the array
            $reservationDetails[] = array(
                'reservationPersonNumber' => $reservationPersonNumber,
                'reservationStatus' => $reservationStatus,
                'tablesNeeded' => $tablesNeeded,
            );
        }

        // Return the JSON-encoded array
        echo json_encode($reservationDetails);
    } else {
        echo "Error querying the database.";
    }
}
?>

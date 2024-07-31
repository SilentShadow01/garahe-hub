<?php
include '../assets/connection.php';

if (isset($_GET['date'])) {
    // Case 1: Fetch reservations for a specific date
    $selectedDate = $_GET['date'];
    $query = "SELECT reservationFullName, reservationTime, reservationType FROM users_reservation_tbl WHERE reservationStatus='Approved' AND reservationDate = '$selectedDate'";
    $result = mysqli_query($conn, $query);

    $reservations = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Format the time and date as ISO 8601 format
            $isoTime = date('H:i:s', strtotime($row['reservationTime']));
            $start = $selectedDate . 'T' . $isoTime;
            $end = $selectedDate . 'T' . $isoTime;

            // Create a properly formatted event object
            $event = array(
                'title' => $row['reservationFullName'],
                'start' => $start,
                'end' => $end,
                'reservationFullName' => $row['reservationFullName'],
                'reservationTime' => $row['reservationTime'],
                'reservationType' => $row['reservationType'],
            );

            // Add the event to the events array
            $reservations[] = $event;
        }
    }

    header('Content-Type: application/json');
    echo json_encode($reservations);
} else {
    // Case 2: Fetch all events for FullCalendar
    $query = "SELECT reservationDate, reservationTime, reservationType, reservationFullName FROM users_reservation_tbl WHERE reservationStatus='Approved'";
    $result = mysqli_query($conn, $query);

    $events = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Check if essential fields are not empty
            if (!empty($row['reservationTime']) && !empty($row['reservationType'])) {
                // Format the time and date as ISO 8601 format
                $isoTime = date('H:i:s', strtotime($row['reservationTime']));
                $start = $row['reservationDate'] . 'T' . $isoTime;
                $end = $row['reservationDate'] . 'T' . $isoTime;

                // Create a properly formatted event object
                $event = array(
                    'title' => $row['reservationFullName'],
                    'start' => $start,
                    'end' => $end,
                    'reservationFullName' => $row['reservationFullName'],
                    'reservationTime' => $row['reservationTime'],
                    'reservationType' => $row['reservationType'],
                );

                // Add the event to the events array
                $events[] = $event;
            }
        }
    }

    header('Content-Type: application/json');
    echo json_encode($events);
}
?>

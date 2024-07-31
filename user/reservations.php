<?php
    session_start();
    include '../assets/connection.php';

    if (!isset($_SESSION['users_email']))
    {
        // Redirect to login page
        echo "<script>window.location.href='../index.php';</script>";
        exit();
    }
    if(isset($_POST['submitReservation']))
    {
        // Set the session variables
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $random_letters = '';

        // Generate 4 random letters
        for ($i = 0; $i < 4; $i++) {
            $random_letters .= $characters[rand(0, strlen($characters) - 1)];
        }

        $random_numbers = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        $_SESSION['transactionNum'] = $random_letters . $random_numbers;
        $_SESSION['reservationType'] = $_POST['reservationType'];
        $_SESSION['reservationDate'] = $_POST['reservationDate'];
        $_SESSION['reservationTime'] = date('h:i A', strtotime($_POST['reservationTime']));
        $_SESSION['reservationFullName'] = $_POST['reservationFullName'];
        $_SESSION['reservationPhone'] = $_POST['reservationPhone'];
        $_SESSION['reservationPerson'] = $_POST['reservationPerson'];

        if ($_POST['reservationType'] === 'event') {
            $_SESSION['userNote'] = $_POST['userNote'];
            $_SESSION['eventTypeDropdown'] = $_POST['eventTypeDropdown'];
        }
        echo "<script>window.location.href='payment.php';</script>";
    }
    $queryDates = "SELECT reservationDate FROM users_reservation_tbl WHERE reservationStatus = 'Approved'";
    $resultDates = $conn->query($queryDates);

    $queryTimes = "SELECT reservationTime FROM users_reservation_tbl WHERE reservationStatus = 'Approved'";
    $resultTimes = $conn->query($queryTimes);

    // Check if there are rows returned
    if ($resultDates->num_rows > 0) {
        // Fetch the reserved dates and store them in an array
        $reservedDates = array();
        while ($row = $resultDates->fetch_assoc()) {
            $reservedDates[] = $row["reservationDate"];
        }
    } else {
        // If no records found with status 'Approved', initialize an empty array
        $reservedDates = array();
    }

    if ($resultTimes->num_rows > 0) {
        // Fetch the reserved times and store them in an array
        $reservedTimes = array();
        while ($row = $resultTimes->fetch_assoc()) {
            $reservedTimes[] = $row["reservationTime"];
        }
    } else {
        // If no records found with status 'Approved', initialize an empty array
        $reservedTimes = array();
    }
    
    $userID = $_SESSION['users_email'];
    // Use prepared statement to avoid SQL injection
    $query = "SELECT accountStatus FROM usermanagement_tbl WHERE userEmailAddress = ?";
    $statement = $conn->prepare($query);
    
    // Check if the statement was successfully prepared
    if ($statement) {
        $statement->bind_param('s', $userID); // 's' represents a string, adjust if needed
        $statement->execute();
        $result = $statement->get_result()->fetch_assoc();
    
        // Check the user's account status
        if ($result && in_array($result['accountStatus'], ['pending', 'not-verified'])) {
            $disableButton = true;
        } else {
            $disableButton = false;
        }
    
        // Close the statement
        $statement->close();
    } else {
        // Handle statement preparation failure
        echo "Statement preparation failed: " . $conn->error;
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
 
    <style>
        #navbarLogo, .nav-item, #offcanvasNavbarLabel, #h1Carousel, 
        #userName, #userWelcome, #placeOrder, #ovalText, #menuTitle, #productPriceTag, 
        #addToCart, #reservationH5, #eventCalendar, #currentPage{
            font-family: "Source Serif 4", Georgia, serif;
        }
        .nav-item{
            text-align: center;
            position: relative;
        }
        .font_me{
                font-family: "Source Serif 4", Georgia, serif;
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
        a.nav-link.fs-5.active {
            color: #FFE17B;
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
                                <a class="nav-link fs-5 active" href="reservations.php">Reservation</a>
                            </li>
                            <li class="nav-item mt-2 me-3">
                                <a class="nav-link fs-5" href="account.php">Account</a>
                            </li>
                            <li class="nav-item mt-2 me-3">
                                <a class="nav-link fs-5" href="orders.php">My Orders</a>
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
            <div class="card shadow-lg mt-3 mb-5 bg-body-tertiary rounded">
                <div class="card-body text-center">
                    <h2 class="card-title border-bottom" id="currentPage"><i class="fa-regular fa-address-book"></i>&nbsp RESERVATIONS</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card border-dark mt-3">
                                <div class="card-header text-light" style="background-color: #800000 !important ;">
                                    <h5 class="card-title" id="eventCalendar"><i class="fa-regular fa-calendar"></i>&nbsp Event Calendar</h5>
                                </div>
                                <div class="card-body">
                                    <div id="calendar">
                                        <div class="modal fade" id="reservationModal" tabindex="-1" role="dialog" aria-labelledby="reservationModalLabel">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header text-light" style="background-color: #800000 !important;">
                                                        <h1 class="modal-title fs-5" id="signUpModalLabel"><i class="fa-regular fa-calendar"></i>&nbsp Events</h1>
                                                    </div> 
                                                    <div class="modal-body d-flex justify-content-center" id="reservationModalBody">
                                                        <!-- Reservation details will be displayed here -->
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <?php if ($disableButton)
                            {
                            ?>
                            <div class="card border-dark mt-3">
                                <div class="card-header text-light" style="background-color: #800000 !important ;">
                                    <h5 class="card-title" id="reservationH5">Please wait for the admin to verify your account!</h5>
                                </div>
                            </div>
                            <?php } 
                            else
                            { ?>
                            <div class="card border-dark mt-3">
                                <div class="card-header text-light" style="background-color: #800000 !important ;">
                                    <h5 class="card-title" id="reservationH5"><i class="fa-solid fa-plus"></i>&nbsp Add Reservations</h5>
                                </div>
                                <form method="POST">
                                    <div class="card-body">
                                        <div class="input-group my-3">
                                            <span class="input-group-text col-5" for="reservationType">Reservation Type</span>
                                            <select class="form-select" id="reservationType" name="reservationType">
                                                <option class="text-center" selected disabled>Select Here</option>
                                                <option class="text-center" value="dineIn">Dine in</option>
                                                <option class="text-center" value="event">Event</option>
                                            </select>
                                        </div>
                                        <div class="d-none" id="eventDineIn">
                                            <small class="text-success fw-semibold text-uppercase" id="reservationStatus"></small>
                                            <div class="input-group mt-3">
                                                <span class="input-group-text col-5">Date</span>
                                                <input type="text" class="form-control text-center" id="reservationDate" name="reservationDate" placeholder="Select here" required>
                                            </div>
                                            <div class="input-group mt-3">
                                                <span class="input-group-text col-5">Time</span>
                                                <input type="time" class="form-control text-center" id="reservationTime" name="reservationTime" required>
                                            </div>
                                            <?php
                                                $usersName = $_SESSION['users_name'];

                                                $query = "SELECT * FROM usermanagement_tbl WHERE firstName = ?";
                                                $stmt = $conn->prepare($query);
                                                $stmt->bind_param("s", $usersName);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                $row = $result->fetch_assoc();

                                                if ($row) {
                                                    $firstName = $row['firstName'];
                                                    $middleName = $row['middleName'];
                                                    $lastName = $row['lastName'];
                                                    $extensionName = $row['extensionName'];

                                                    $userFullName = $firstName . ' ' . $middleName . ' ' . $lastName . ' ' . $extensionName;

                                                } else {
                                                    echo "No user found with the given first name.";
                                                }
                                            ?>
                                            <div class="input-group mt-3">
                                                <span class="input-group-text col-5">Full Name</span>
                                                <input type="text" class="form-control text-center" id="reservationFullName" value="<?= $userFullName; ?>" name="reservationFullName" readonly>
                                            </div>
                                            <div class="input-group mt-3">
                                                <span class="input-group-text col-5">Phone Number</span>
                                                <input type="tel" class="form-control text-center" id="reservationPhone" value="<?= $row['contactNumber']; ?>" name="reservationPhone" pattern="[0-9]{11}" maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required placeholder="ex. 09123456789">
                                            </div>
                                            <div class="input-group my-3">
                                                <strong class="input-group-text col-5">Number of Diners</strong>
                                                <input type="number" class="form-control text-center" id="reservationPerson" name="reservationPerson" min="1" max="50" required>
                                            </div>
                                        </div>
                                        <div class="d-none" id="eventWrapper">
                                            <div class="input-group mb-3">
                                                <strong class="input-group-text col-5">Event Type</strong>
                                                <select class="form-control text-center" id="eventTypeDropdown" name="eventTypeDropdown">
                                                    <option value="" selected disabled>Select here</option>
                                                    <option value="Anniversary">Anniversary</option>
                                                    <option value="Birthday">Birthday</option>
                                                    <option value="Reunion">Reunion</option>
                                                    <option value="Graduation">Graduation Celebration</option>
                                                    <option value="Debut">Debut</option>
                                                    <option value="Others">Others</option>
                                                </select>
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text col-5">Request/Note</span>
                                                <textarea class="form-control text-center" id="userNote" name="userNote" rows="6" placeholder="Type your requests here (OPTIONAL)"></textarea>
                                            </div>
                                        </div>
                                    <div class="card-footer text-light d-none" style="background-color: #800000 !important ;" id="submitButton">
                                        <button type="submit" class="btn btn-success" name="submitReservation" onclick="submitForm()">Continue &nbsp<i class="fa-solid fa-arrow-right"></i></button>
                                            <div>
                                                <small class="text-danger text-white" style="font-size: 1em;">
                                                    <em>
                                                        <strong>Note:</strong> In the event of a no-show, if the customer doesn't arrive within 15 minutes of the reserved time, the reservation will be automatically canceled, and the deposit may be forfeited.
                                                    </em>
                                                </small>
                                            </div>
                                    </div>
                                </form>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
document.addEventListener("DOMContentLoaded", function () {
    // Initialize FullCalendar
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        events: 'events.php',  // URL to fetch event data
        type: 'GET',
        error: function () {
            alert('Error fetching events');
        },
        success: function (events) {
            // Map the event data to FullCalendar event format with customized title
            var formattedEvents = events.map(function (event) {
                // Customize the event title to include reservation details
                var title = event.reservationFullName + ' - ' + event.reservationTime + ' - ' + event.reservationType;

                return {
                    "title": title,
                    "start": event.start,
                    "end": event.end,
                    // Store additional data in the event object
                    "reservationFullName": event.reservationFullName,
                    "reservationTime": event.reservationTime,
                    "reservationType": event.reservationType
                };
            });

            // Update FullCalendar with the formatted event data
            $('#calendar').fullCalendar('removeEvents');
            $('#calendar').fullCalendar('addEventSource', formattedEvents);
            $('#calendar').fullCalendar('rerenderEvents');
        },
        // Add a callback for when a date is clicked
        dayClick: function (date, jsEvent, view) {
            // Fetch reservations for the clicked date
            fetchReservationsForDate(date.format('YYYY-MM-DD'));
        }
    });

    // Function to fetch and display reservations for a specific date
    function fetchReservationsForDate(selectedDate) {
        $.ajax({
            url: 'events.php',
            type: 'GET',
            data: { date: selectedDate },
            success: function (reservations) {
                // Display the reservations in the modal
                displayReservationsModal(reservations);
            },
            error: function () {
                alert('Error fetching reservations');
            }
        });
    }

    // Function to display reservations in the modal
    function displayReservationsModal(reservations) {
        var modalBody = '<ul>';
        reservations.forEach(function (reservation) {
            // Check if reservationType is "dineIn" or "event" and display accordingly
            var reservationTypeDisplay = (reservation.reservationType === 'dineIn') ? 'Dine In' : ((reservation.reservationType === 'event') ? 'Event' : reservation.reservationType);

            modalBody += '<li><strong class="font_me">Name:</strong> <span class="font_me fw-semibold">' + reservation.reservationFullName + '</span><br><strong class="font_me">Time:</strong> <span class="font_me fw-semibold">' + reservation.reservationTime + ' </span><br><strong class="font_me">Type:</strong> <span class="font_me fw-semibold mb-3">' + reservationTypeDisplay + '</span></li>';
        });
        modalBody += '</ul>';

        // Update the modal content and show the modal
        $('#reservationModalBody').html(modalBody);
        $('#reservationModal').modal('show');
    }
});
</script>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const navbarHeight = document.querySelector('.navbar').offsetHeight;
            document.querySelector('.main-content').style.paddingTop = navbarHeight + 'px';
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr('#reservationDate', {
                altInput: true, // Enable alternative input field
                altFormat: "F j, Y", // Format for the alternative input field
                dateFormat: "Y-m-d", // Format for submitting to the server
                 minDate: "today", // Set the minimum date to today
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const reservationTypeSelect = document.getElementById('reservationType');
            const eventWrapper = document.getElementById('eventWrapper');
            const eventDineIn = document.getElementById('eventDineIn');
            const submitButton = document.getElementById('submitButton');
            const eventTypeDropdown = document.getElementById('eventTypeDropdown');

            reservationTypeSelect.addEventListener('change', function() {
                const selectedValue = reservationTypeSelect.value;

                if (selectedValue === 'event') {
                    eventWrapper.classList.remove('d-none');
                    eventDineIn.classList.remove('d-none');
                    submitButton.classList.remove('d-none');
                    eventTypeDropdown.setAttribute('required', 'true');
                }
                else if (selectedValue === 'dineIn')
                {
                    eventWrapper.classList.add('d-none');
                    eventDineIn.classList.remove('d-none');
                    submitButton.classList.remove('d-none');
                    eventTypeDropdown.removeAttribute('required');
                } 
                else {
                    eventWrapper.classList.add('d-none');
                    eventDineIn.classList.add('d-none');
                    submitButton.classList.add('d-none');
                }
            });
        });
    </script>
    
    <script>
        var reservedDates = <?php echo json_encode($reservedDates); ?>;
        var reservedTimes = <?php echo json_encode($reservedTimes); ?>;
        
    
        document.getElementById('reservationTime').addEventListener('input', function() {
            // Get the selected date from flatpickr input
            var selectedDate = document.getElementById('reservationDate').value;
    
            // Format the selected time to match the database time format
            var selectedTime = moment(this.value, 'hh:mm A').format('hh:mm A');
    
            // Combine date and time for comparison
            var selectedDateTime = selectedDate + ' ' + selectedTime;
    
            // Check if the selected date and time slot is in the reservedDates and reservedTimes arrays
            if (reservedDates.includes(selectedDate) && reservedTimes.includes(selectedTime)) {
                alert('Schedule has already been selected!');
                this.value = ''; // Clear the input
                return;
            }
    
            // Check if the selected time is within 30 minutes after any approved time
            var isWithin30Minutes = reservedTimes.some(function(approvedTime) {
                return moment(selectedTime, 'hh:mm A').isBetween(moment(approvedTime, 'hh:mm A'), moment(approvedTime, 'hh:mm A').add(30, 'minutes'));
            });
    
            if (reservedDates.includes(selectedDate) && isWithin30Minutes) {
                alert('Time slot is within 30 minutes of an approved schedule. Please select another time.');
                this.value = ''; // Clear the input
            }
    
            console.log('Is within 30 minutes:', isWithin30Minutes);
        });
    </script>
    <script>
        $(document).ready(function() {
            // Attach event listener to the reservationType dropdown
            $("#reservationType").change(function() {
                // Clear the message when the reservation type changes
                $("#reservationStatus").text("");
        
                // Get the selected reservation type
                var selectedReservationType = $(this).val();
        
                // Update the max attribute of the reservationPerson input based on the selected reservation type
                if (selectedReservationType === "dineIn") {
                    $("#reservationPerson").attr("min", 1);
                    $("#reservationPerson").attr("max", 30);
                } else if (selectedReservationType === "event") {
                    $("#reservationPerson").attr("min", 20);
                    $("#reservationPerson").attr("max", 50);
                }
            });
        
            // Attach an event listener to the date input
            $("#reservationDate").change(function() {
                // Get the selected date
                var selectedDate = $(this).val();
        
                // Get the selected reservation type
                var selectedReservationType = $("#reservationType").val();
        
                // Check if the reservation type is "dineIn"
                if (selectedReservationType === "dineIn") {
                    // Make an AJAX request to the server
                    $.ajax({
                        type: "POST",
                        url: "check_reservation.php",
                        data: { date: selectedDate },
                        success: function(response) {
                            // Parse the JSON response
                            var reservationDetails = JSON.parse(response);
        
                            // Calculate total tables needed
                            var totalTablesNeeded = 0;
                            for (var i = 0; i < reservationDetails.length; i++) {
                                totalTablesNeeded += reservationDetails[i].tablesNeeded;
                            }
        
                            // Calculate remaining tables
                            var remainingTables = 5 - totalTablesNeeded;
        
                            // Display a message in the HTML element
                            var statusMessage = (remainingTables <= 0)
                                ? "Reservations for this date are already full."
                                : "Remaining available tables: " + remainingTables;
        
                            // Update the reservationStatus element
                            $("#reservationStatus").text(statusMessage);
                        }
                    });
                }
            });
        });
    </script>



</body>
</html>

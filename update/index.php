<?php
    session_start();
    include 'assets/verificationCode.php';
    include 'assets/indexModals.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/index.css">
    <style>
        /* Add your CSS styles for the carousel here */
        .gallery-container {
            width: 100%;
            margin-top: 160px;
            overflow: hidden; 
        }
        .gallery {
            display: flex;
            animation-timing-function: linear;
        }
        .gallery-item {
            flex: 0 0 200px; /* Adjust the width as needed */
            margin-right: 20px; /* Adjust the spacing between images */
        }
        .gallery-item img {
            width: 200px;
            height: 250px;
            border-radius: 30px;
        }
        .nav-link.active, .nav-link:hover{
            background-color: #F2E8C6 !important ;
            border-radius: 20px;
            color: black;
        }
        .nav-link{
            border-radius: 20px;
        }
        #navbarLogo{
            color: white;
        }
        @media (max-width: 991.98px){
            #companyName{
                font-size: 50px;
            }
            #tagLine{
                font-size: 15px!important;
            }
            li.nav-item{
                margin-right: 0!important;
            }
            #getStartedBtn{
                margin-top: 5rem;
            }
        }
    </style>
</head>
<body>
    <header class="nav-header">
        <nav class="navbar navbar-expand-lg bg-body-light fixed-top" style="background-color: #800000 !important ;">
            <div class="container-fluid">
                <a class="navbar-brand fs-3 p-3 font-me" href="index.php" id="navbarLogo">Garahe lomi atbp</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header" style="background-color: #800000 !important ;">
                        <h5 class="offcanvas-title text-light p-2" id="offcanvasNavbarLabel">Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                            <li class="nav-item mt-2 me-4">
                                <a class="nav-link fs-5 active font-me" href="#">Home</a>
                            </li>
                            <li class="nav-item mt-2 me-4">
                                <a class="nav-link fs-5 font-me" href="#" data-bs-target="#aboutUsModal" data-bs-toggle="modal">About Us</a>
                            </li>
                            <li class="nav-item mt-2 me-4">
                                <a class="nav-link fs-5 font-me" href="#" data-bs-target="#contactUsModal" data-bs-toggle="modal">Contact Us</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <!-- Main Content Section -->
    <div class="main-content">
        <!-- Your content goes here -->
        <div class="company-name">
            <h1 class="text-center company-name-text font-me" id="companyName">Garahe Food House</h1>
        </div>
        <div class="company-tagline d-flex justify-content-center">
            <h1 class="p-2 fs-4 rounded badge badge-primary badge-color-cycle font-me" id="tagLine">
                SWAK sa panlasa pero sa presyong pangmasa!
            </h1>
        </div>
        <button class="btn btn-lg position-absolute top-50 start-50 translate-middle font-me" data-bs-target="#LogInModal" data-bs-toggle="modal" style="background-color: #952323; color: #F2E8C6;" id="getStartedBtn">Get Started</button>
        
        <div class="gallery-container">
            <div class="gallery" id="gallery">
                <div class="gallery-item">
                    <img src="assets/images/1.jpg" alt="Image 1">
                </div>
                <div class="gallery-item">
                    <img src="assets/images/2.jpg" alt="Image 2">
                </div>
                <div class="gallery-item">
                    <img src="assets/images/3.jpg" alt="Image 3">
                </div>
                <div class="gallery-item">
                    <img src="assets/images/4.jpg" alt="Image 4">
                </div>
                <div class="gallery-item">
                    <img src="assets/images/5.jpg" alt="Image 5">
                </div>
                <div class="gallery-item">
                    <img src="assets/images/6.png" alt="Image 6">
                </div>
                <div class="gallery-item">
                    <img src="assets/images/7.jpg" alt="Image 7">
                </div>
                <div class="gallery-item">
                    <img src="assets/images/8.jpg" alt="Image 8">
                </div>
                <div class="gallery-item">
                    <img src="assets/images/9.png" alt="Image 9">
                </div>
                <div class="gallery-item">
                    <img src="assets/images/14.jpg" alt="Image 7">
                </div>
            </div>
        </div>    
    </div>
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<!-- Add this to include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
   document.addEventListener("DOMContentLoaded", function () {
        const signUpModal = new bootstrap.Modal(document.getElementById("signUpModal"));
        const verificationModal = new bootstrap.Modal(document.getElementById("VerificationModal"));

        const signupSubmitBtn = document.getElementById("signupSubmitBtn");
        const passwordInput = document.querySelector('input[aria-label="userPassword"]');
        const confirmPasswordInput = document.querySelector('input[aria-label="confirmPassword"]');
        const errorMessage = document.getElementById("errorMessage");
        const successMessage = document.getElementById("successMessage");
        const emailAddressPlaceholder = document.getElementById("emailAddressPlaceholder");

        // Function to handle the response from the server
        function handleResponse(responseText, emailAddress) {
            if (responseText === "Email address is already exist!") {
                // Handle the case where the email already exists
            } else {
                signUpModal.hide();
                verificationModal.show();
                emailAddressPlaceholder.textContent = emailAddress;
            }
        }

        signupSubmitBtn.addEventListener("click", function () {
        event.preventDefault();

        // Get values from input fields
        const firstName = document.getElementById("userFirstName").value;
        const lastName = document.getElementById("userLastName").value;
        const emailAddress = document.getElementById("userEmailAdd").value;
        const inputValidID = document.getElementById("inputValidID").value;
        const userAddress = document.getElementById("userAddress").value;
        const contactNumber = document.getElementById("userContactNumber").value;
        
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;

        // Clear previous error messages
        errorMessage.innerHTML = "";
        successMessage.innerHTML = ""

        // Additional conditions for inputValidID
        const fileInput = document.getElementById("inputValidID");
        const file = fileInput.files[0];

        

        // Check if required fields are filled in
        if (firstName && lastName && emailAddress && password && confirmPassword && contactNumber && userAddress) 
        {
            if (file) 
            {
                // Check if the file is an image
                if (file.type.startsWith("image/")) 
                {
                    // Check if the file size is below 5MB
                    if (file.size <= 5 * 1024 * 1024) 
                    {
                        if(document.getElementById("agreement1").checked)
                        {
                            // Check if passwords match
                            if (password === confirmPassword) {
                                // Passwords match, proceed to check email existence

                                const xhr = new XMLHttpRequest();
                                xhr.open("POST", "assets/check_email.php", true);
                                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                                // Define the callback function when the request is complete
                                xhr.onreadystatechange = function () {
                                    if (xhr.readyState === 4 && xhr.status === 200) {
                                        // Handle the response from the server and pass emailAddress as a parameter
                                        errorMessage.innerHTML = xhr.responseText;

                                        if (xhr.responseText === "Email address is already exist!") {
                                            // Handle the case where the email already exists
                                        } else {
                                            successMessage.innerHTML = "Loading...Please wait!";
                                            sendVerificationCode(emailAddress);
                                        }
                                    }
                                };

                                // Send the request with the email address as data
                                xhr.send("emailAddress=" + encodeURIComponent(emailAddress));
                            } else {
                                errorMessage.innerHTML = "Passwords do not match.";
                            }
                        }
                        else
                        {
                            errorMessage.innerHTML = "Please read Terms and Conditions.";
                        }
                    } 
                    else 
                    {
                        errorMessage.innerHTML = "File size must be below 5MB.";
                        return; // Stop execution if file size condition is not met
                    }
                } 
                else 
                {
                    errorMessage.innerHTML = "File must be an image.";
                    return; // Stop execution if file type condition is not met
                }
            } else {
                errorMessage.innerHTML = "Please upload a Valid ID.";
                return; // Stop execution if no file is uploaded
            }
        } else {
            errorMessage.innerHTML = "Please fill in all required fields.";
        }
    });

        function sendVerificationCode(emailAddress) {
            // Make an AJAX request to a PHP script responsible for sending the verification code
            fetch("assets/verificationCode.php", {
                method: "POST",
                body: JSON.stringify({ emailAddress }), // You can use JSON to send data
                headers: {
                    "Content-Type": "application/json"
                }
            })
            .then(response => response.text())
            .then(data => {
                if (data === "success") {
                    // Show the verification modal
                    const verificationModal = new bootstrap.Modal(document.getElementById("VerificationModal"));
                    signUpModal.hide();
                    verificationModal.show();
                    emailAddressPlaceholder.textContent = emailAddress;
                } else {
                    // Handle the case where sending the verification code failed
                    alert("Sending verification code failed!");
                }
            })
            .catch(error => {
                // Handle any errors that occurred during the fetch request
                console.error("Fetch error:", error);
            });
        }
    });
</script> 
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const submitButton = document.getElementById("createAccount");
        const errorCodeMessage = document.getElementById("errorCode");
        const getEmailAdd = document.getElementById("userEmailAdd");
        const LogInModal = new bootstrap.Modal(document.getElementById("LogInModal"));

        submitButton.addEventListener("click", function () {
            event.preventDefault();
            const codeInput = document.getElementById("verificationCode");
            const form = document.getElementById("signUpForm");
            const formData = new FormData(form);

            const getInputEmail = getEmailAdd.value;
            const getCodeInput = codeInput.value;

            fetch("assets/fetchCode.php", {
                method: "POST",
                body: JSON.stringify({ getCodeInput, getInputEmail }),
                headers: {
                    "Content-Type": "application/json"
                }
            })
            .then(response => response.text())
            .then(data => {
                console.log("Response from server:", data);
                if (data === "success") {
                    const inputFirstName = formData.get("userFirstName");
                    const inputMiddleName = formData.get("userMiddleName") || "None";
                    const inputExtensionName = formData.get("userExtensionName") || "None";
                    const inputLastName = formData.get("userLastName");
                    const inputEmailAddress = formData.get("userEmailAddress");
                    const inputUserPassword = formData.get("confirmPassword");
                    const inputContactNumber = formData.get("userContactNumber");
                    const inputUserAddress = formData.get("userAddress");

                    formData.append("inputFirstName", inputFirstName);
                    formData.append("inputMiddleName", inputMiddleName);
                    formData.append("inputExtensionName", inputExtensionName);
                    formData.append("inputLastName", inputLastName);
                    formData.append("inputEmailAddress", inputEmailAddress);
                    formData.append("inputUserPassword", inputUserPassword);
                    formData.append("inputContactNumber", inputContactNumber);
                    formData.append("inputUserAddress", inputUserAddress);

                    fetch("assets/registerAccount.php", {
                        method: "POST",
                        body: formData,
                        // Note: No need for Content-Type header for FormData
                        // It will be set automatically
                        // cache: "no-cache", // This line was removed; you can add it if needed
                    })
                    .then(response => response.text())
                    .then(data => {
                        // Handle response as needed
                    })
                    .catch(error => {
                        // Handle any errors that occurred during the fetch request
                        console.error("Fetch error:", error);
                    });

                    setTimeout(function() {
                        window.location.href = 'index.php';
                    }, 2000);
                } else if (data === "not match") {
                    errorCodeMessage.textContent = "Incorrect verification code.";
                } else if (data === "does not exist") {
                    errorCodeMessage.textContent = "Email doesn't exist!";
                } else {
                    errorCodeMessage.textContent = "An error has occurred.";
                }
            })
            .catch(error => {
                // Handle any errors that occurred during the fetch request
                console.error("Fetch error:", error);
            });
        });
    });
</script>
<!-- AJAX FOR LOGIN  -->
<script>
    document.addEventListener("DOMContentLoaded", function ()
    {
        const inputEmail = document.getElementById("loginEmail");
        const inputPassword = document.getElementById("loginPassword");
        const loginButton = document.getElementById("loginButton");
        const loginMessage = document.getElementById("loginMessage");
        const approveMessage = document.getElementById("approveMessage");

        loginButton.addEventListener("click", function () 
        {
            const valueEmail = inputEmail.value;
            const valuePassword = inputPassword.value;

            loginMessage.innerHTML = ""
            approveMessage.innerHTML = ""
            
            event.preventDefault();
            if(valueEmail && valuePassword)
            {
                fetch("assets/loginAccount.php",
                {
                    method: "POST",
                    body: JSON.stringify({ valueEmail, valuePassword }),
                    headers:
                    {
                        "Content-Type": "application/json"
                    }
                })
                .then(response => response.text())
                .then(data =>
                {
                    const response = JSON.parse(data);
                    if(response.error) 
                    {
                        loginMessage.innerHTML = response.error;
                    }
                    else
                    {
                        const userType = response.type;
                        const userFirstName = response.firstName;
                        if(data == "Password do not match!")
                        {
                            loginMessage.innerHTML= "Password do not match!";
                        }
                        else if(data == "Account does not exist!")
                        {
                            loginMessage.innerHTML = "Account does not exist!";
                        }
                        else if (userType === "user") 
                        {
                            approveMessage.innerHTML = "Welcome!";
                            setTimeout(function () {
                                window.location.href = 'user/index.php';
                            }, 2000);
                        } 
                        else if (userType === "admin") 
                        {
                            approveMessage.innerHTML = "Welcome back Admin!";
                            setTimeout(function () {
                                window.location.href = 'admin/index.php';
                            }, 2000);
                        }
                        else if (userType === "staff") 
                        {
                            approveMessage.innerHTML = "Welcome back " + userFirstName + "!";
                            setTimeout(function () {
                                window.location.href = 'staff/index.php';
                            }, 2000);
                        }
                    }
                })
            }
            else
            {
                loginMessage.innerHTML= "PLEASE FILL ALL THE BLANKS!";
            }
        });        
    })
</script>
<script>
    function togglePasswordVisibility(toggleButton, passwordInput) {
        toggleButton.addEventListener('click', function (e) {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    }

    const togglePassword = document.querySelector('#toggle-password');
    const password = document.querySelector('#loginPassword');
    togglePasswordVisibility(togglePassword, password);

    const togglePassword2 = document.querySelector('#signup-toggle-password');
    const password2 = document.querySelector('#userPassword');
    togglePasswordVisibility(togglePassword2, password2);

    const togglePassword3 = document.querySelector('#signup-toggle-cpassword');
    const password3 = document.querySelector('#confirmPassword');
    togglePasswordVisibility(togglePassword3, password3);
</script>
<script>
    // JavaScript to continuously loop all carousel items
    const carousel = document.getElementById('gallery');
    const carouselItems = carousel.querySelectorAll('.gallery-item');
    const animationDuration = 60; // Adjust animation duration in seconds

    const totalWidth = carouselItems.length * (200 + 20); // Total width of all items
    carousel.style.width = totalWidth + 'px';

    carouselItems.forEach((item) => {
        const clone = item.cloneNode(true);
        carousel.appendChild(clone);
    });

    const keyframes = `@keyframes carousel-animation {
        0% {
            transform: translateX(0);
        }
        100% {
            transform: translateX(-${totalWidth}px);
        }
    }`;

    const styleSheet = document.styleSheets[0];
    styleSheet.insertRule(keyframes, styleSheet.cssRules.length);

    carousel.style.animation = `carousel-animation ${animationDuration}s linear infinite`;
</script>
<script>
   document.addEventListener("DOMContentLoaded", function () {
        const countdownElement = document.getElementById("countdownTimer");
        const submitButton = document.getElementById("createAccount");
        const btnResendCode = document.getElementById("btnResendCode");

        const form = document.getElementById("signUpForm");
        const formData = new FormData(form);
        

        let countdown = 30; // 5 minutes in seconds

        function updateCountdown() {
            const minutes = Math.floor(countdown / 60);
            const seconds = countdown % 60;
            const formattedTime = `${minutes < 10 ? '0' : ''}${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
            countdownElement.textContent = formattedTime;
        }

        function decrementCountdown() {
            if (countdown > 0) {
                countdown--;
                updateCountdown();
            } else {
                btnResendCode.classList.remove('d-none');
                countdownElement.classList.add('d-none');
            }
        }

        function resetCountdown() {
            // Reset the countdown
            countdown = 30;
            updateCountdown();
            btnResendCode.classList.add('d-none');
            countdownElement.classList.remove('d-none');
        }

        function resendVerificationCode() {
            event.preventDefault();
            const getEmailAdd = document.getElementById("userEmailAdd");
            const getInputEmail = getEmailAdd.value;
            // Trigger the verificationCode.php using Fetch API
            console.log("Email Address:", getInputEmail);
            fetch("assets/resendCode.php", {
                method: "POST",
                body: JSON.stringify({ getInputEmail }),
                headers: {
                    "Content-Type": "application/json"
                }
            })
            .then(response => response.text())
            .then(data => {
                // Handle the response if needed
                console.log(data);
                if (data === "success") {
                    // Show the verification modal
                    alert("Sending verification code success!");
                } else {
                    // Handle the case where sending the verification code failed
                    alert("Sending verification code failed!");
                }
            })
            .catch(error => {
                console.error("Fetch error:", error);
            });
        }

        // Listen for the modal's shown.bs.modal event
        const verificationModal = new bootstrap.Modal(document.getElementById("VerificationModal"));
        verificationModal._element.addEventListener("shown.bs.modal", function () {
            // Start the countdown when the modal is shown
            setInterval(decrementCountdown, 1000);
        });

        btnResendCode.addEventListener("click", function () {
            resendVerificationCode();
            resetCountdown();
        });

        // Initial display
        updateCountdown();
    });
</script>
</body>
</html>
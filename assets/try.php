<!DOCTYPE html>
<html>
<head>
    <title>Trial and Error</title>
</head>
<body>
<form>
    <label for="email">Email Address:</label>
    <input type="email" id="email" name="email" required>
    <button type="button" id="checkEmail">Check Email</button>
</form>
<div id="result"></div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const checkEmailButton = document.getElementById("checkEmail");
    const emailInput = document.getElementById("email");
    const resultContainer = document.getElementById("result");

    checkEmailButton.addEventListener("click", function () {
        // Get the email address from the input field
        const email = emailInput.value;

        // Create an AJAX request
        const xhr = new XMLHttpRequest();

        // Configure the request
        xhr.open("POST", "check_email.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        // Define the callback function when the request is complete
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Handle the response from the server
                resultContainer.innerHTML = xhr.responseText;
            }
        };

        // Send the request with the email address as data
        xhr.send("email=" + encodeURIComponent(email));
    });
});
</script>
</body>
</html>

document.addEventListener("DOMContentLoaded", function () {
    const btnProducts = document.getElementById("btnProducts");
    const btnReservations = document.getElementById("btnReservations");

    btnProducts.addEventListener("click", function() {
        window.location.href = 'products.php';
    });
    btnReservations.addEventListener("click", function() {
        window.location.href = 'reservations.php';
    });
});

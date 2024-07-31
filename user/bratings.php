<style>
    /* START RATING CSS */
    .rating {
        flex-direction: row-reverse;
        gap: 0.3rem;
        --stroke: #666;
        --fill: #ffc73a;
    }

    .rating input {
        appearance: unset;
    }

    .rating label {
        cursor: pointer;
    }

    .rating svg {
        width: 2rem;
        height: 2rem;
        overflow: visible;
        fill: transparent;
        stroke: var(--stroke);
        stroke-linejoin: bevel;
        stroke-dasharray: 12;
        animation: idle 4s linear infinite;
        transition: stroke 0.2s, fill 0.5s;
    }

    @keyframes idle {
        from {
            stroke-dashoffset: 24;
        }
    }

    .rating label:hover svg {
        stroke: var(--fill);
    }

    .rating input:checked ~ label svg {
        transition: 0s;
        animation: idle 4s linear infinite, yippee 0.75s backwards;
        fill: var(--fill);
        stroke: var(--fill);
        stroke-opacity: 0;
        stroke-dasharray: 0;
        stroke-linejoin: miter;
        stroke-width: 8px;
    }

    @keyframes yippee {
        0% {
            transform: scale(1);
            fill: var(--fill);
            fill-opacity: 0;
            stroke-opacity: 1;
            stroke: var(--stroke);
            stroke-dasharray: 10;
            stroke-width: 1px;
            stroke-linejoin: bevel;
        }

        30% {
            transform: scale(0);
            fill: var(--fill);
            fill-opacity: 0;
            stroke-opacity: 1;
            stroke: var(--stroke);
            stroke-dasharray: 10;
            stroke-width: 1px;
            stroke-linejoin: bevel;
        }

        30.1% {
            stroke: var(--fill);
            stroke-dasharray: 0;
            stroke-linejoin: miter;
            stroke-width: 8px;
        }

        60% {
            transform: scale(1.2);
            fill: var(--fill);
        }
    }
    /* END RATING CSS */
</style>

<!-- START RATINGS MODAL -->
<div class="modal fade" id="ratingsModal<?= $productID ?>" tabindex="-1" aria-labelledby="ratingsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #800000 !important;">
                <h1 class="modal-title fs-5 fw-medium text-light" id="ratingsModalLabel"><i class="fa-regular fa-star"></i>&nbsp; Rate Your Experience</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center fs-5">
                <form id="ratingsForm<?= $productID ?>" method="POST">
                    <!-- Product Quality Rating -->
                    <label for="productQualityRating<?= $productID ?>" class="form-label fw-semibold">Rate our menu</label>
                    <div class="rating d-flex justify-content-center">
                        
                        <input type="radio" id="star-1-<?= $productID ?>" name="star-radio-<?= $productID ?>" value="5">
                        <label for="star-1-<?= $productID ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path pathLength="360" d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z"></path></svg>
                        </label>
                        <input type="radio" id="star-2-<?= $productID ?>" name="star-radio-<?= $productID ?>" value="4">
                        <label for="star-2-<?= $productID ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path pathLength="360" d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z"></path></svg>
                        </label>
                        <input type="radio" id="star-3-<?= $productID ?>" name="star-radio-<?= $productID ?>" value="3">
                        <label for="star-3-<?= $productID ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path pathLength="360" d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z"></path></svg>
                        </label>
                        <input type="radio" id="star-4-<?= $productID ?>" name="star-radio-<?= $productID ?>" value="2">
                        <label for="star-4-<?= $productID ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path pathLength="360" d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z"></path></svg>
                        </label>
                        <input type="radio" id="star-5-<?= $productID ?>" name="star-radio-<?= $productID ?>" value="1">
                        <label for="star-5-<?= $productID ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path pathLength="360" d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z"></path></svg>
                        </label>
                    </div>
                    <!-- Delivery Service Rating -->
                    <button type="button" class="btn btn-success mt-3" onclick="submitRatings()"><i class="fa-solid fa-star"></i>&nbsp Submit &nbsp<i class="fa-solid fa-star"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END RATINGS MODAL -->
<script>
    function submitRatings() {
        // Find the modal element that is currently open
        const openModal = document.querySelector('.modal.show');

        // Check if a modal is open
        if (openModal) {
            // Extract the productID from the open modal's ID
            const productID = openModal.id.replace('ratingsModal', '');

            // Get the selected ratings
            const productQualityRatingInput = document.querySelector(`input[name="star-radio-${productID}"]:checked`);

            // Check if a radio button is checked before accessing its value
            const productQualityRating = productQualityRatingInput ? productQualityRatingInput.value : null;

            // Send the ratings to the server using AJAX
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'insertRatings.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Handle the response from the server if needed
                    console.log(xhr.responseText);
                    $('#thankYouModal').modal('show');
                }
            };
            xhr.send(`productQualityRating=${productQualityRating}&productID=${productID}`);

            // Close the modal after submitting
            $(`#${openModal.id}`).modal('hide');
        }
    }
</script>

    <script>
        function closeAndReload() {
            // Hide the modal
            $('#thankYouModal').modal('hide');
            
            // Reload the window after a short delay (adjust the delay if needed)
            setTimeout(function () {
                window.location.reload();
            }, 500);
        }
    </script>

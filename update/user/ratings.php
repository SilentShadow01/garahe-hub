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
<div class="modal fade" id="ratingsModal" tabindex="-1" aria-labelledby="ratingsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #800000 !important;">
                    <h1 class="modal-title fs-5 fw-medium text-light" id="ratingsModalLabel"><i class="fa-regular fa-star"></i>&nbsp; Rate Your Experience</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center fs-5">
                    <form id="ratingsForm" method="POST">
                        <!-- Product Quality Rating -->
                        <label for="productQualityRating" class="form-label fw-semibold">Product Quality:</label>
                        <div class="rating d-flex justify-content-center">
                            <input type="radio" id="star-1" name="star-radio" value="5">
                            <label for="star-1">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path pathLength="360" d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z"></path></svg>
                            </label>
                            <input type="radio" id="star-2" name="star-radio" value="4">
                            <label for="star-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path pathLength="360" d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z"></path></svg>
                            </label>
                            <input type="radio" id="star-3" name="star-radio" value="3">
                            <label for="star-3">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path pathLength="360" d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z"></path></svg>
                            </label>
                            <input type="radio" id="star-4" name="star-radio" value="2">
                            <label for="star-4">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path pathLength="360" d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z"></path></svg>
                            </label>
                            <input type="radio" id="star-5" name="star-radio" value="1">
                            <label for="star-5">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path pathLength="360" d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z"></path></svg>
                            </label>
                        </div>
                        <!-- Delivery Service Rating -->
                        <label for="deliveryServiceRating" class="form-label">Delivery Service:</label>
                        <div class="rating d-flex justify-content-center">
                            <input type="radio" id="star-6" name="star-radio2" value="5">
                            <label for="star-6">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path pathLength="360" d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z"></path></svg>
                            </label>
                            <input type="radio" id="star-7" name="star-radio2" value="4">
                            <label for="star-7">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path pathLength="360" d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z"></path></svg>
                            </label>
                            <input type="radio" id="star-8" name="star-radio2" value="3">
                            <label for="star-8">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path pathLength="360" d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z"></path></svg>
                            </label>
                            <input type="radio" id="star-9" name="star-radio2" value="2">
                            <label for="star-9">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path pathLength="360" d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z"></path></svg>
                            </label>
                            <input type="radio" id="star-10" name="star-radio2" value="1">
                            <label for="star-10">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path pathLength="360" d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z"></path></svg>
                            </label>
                        </div>

                        <button type="button" class="btn btn-success mt-3" onclick="submitRatings()">Submit Ratings</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END RATINGS MODAL -->
    <!-- START THANK YOU MODAL -->
    <div class="modal fade" id="thankYouModal" tabindex="-1" aria-labelledby="thankYouModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #28a745 !important;">
                    <h1 class="modal-title fs-5 fw-medium text-light" id="thankYouModalLabel">Thank You for Your Ratings!</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeAndReload()"></button>
                </div>
                <div class="modal-body text-center fs-5">
                    <p class="font-num">We appreciate your feedback. Your ratings have been recorded.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- END THANK YOU MODAL -->

    <script>
        function submitRatings() {
            // Get the selected ratings
            const productQualityRatingInput = document.querySelector('input[name="star-radio"]:checked');
            const deliveryServiceRatingInput = document.querySelector('input[name="star-radio2"]:checked');

            // Check if a radio button is checked before accessing its value
            const productQualityRating = productQualityRatingInput ? productQualityRatingInput.value : null;
            const deliveryServiceRating = deliveryServiceRatingInput ? deliveryServiceRatingInput.value : null;

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
            xhr.send(`productQualityRating=${productQualityRating}&deliveryServiceRating=${deliveryServiceRating}`);
            
            // Close the modal after submitting
            $('#ratingsModal').modal('hide');
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

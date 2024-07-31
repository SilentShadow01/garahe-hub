<!-- START MODALS -->
    
<div class="modal fade" id="signUpModal" aria-hidden="true" aria-labelledby="signUpModalLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header text-light" style="background-color: #800000 !important ;">
                <h1 class="modal-title fs-5" id="signUpModalLabel"><i class="fa-solid fa-user-plus"></i>&nbsp Sign Up</h1>
                <button type="button" class="btn-close-light bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> 
            <div class="modal-body">
                <form method="POST" id="signUpForm" enctype="multipart/form-data">
                    <div class="input-group d-flex justify-content-center">
                        <div id="errorMessage" class="text-danger fw-medium">
                        </div>
                        <div id="successMessage" class="text-success fw-medium">
                        </div>
                    </div>
                    <div class="input-group mt-3">
                        <span class="input-group-text col-md-4">First Name:</span>
                        <input id="userFirstName" name="userFirstName" type="text" aria-label="firstName" onkeydown="return (event.keyCode < 48 || event.keyCode > 57)" class="form-control" required>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text col-md-4">Middle Name:</span>
                        <input id="userMiddleName" name="userMiddleName" type="text" aria-label="middleName" onkeydown="return (event.keyCode < 48 || event.keyCode > 57)" class="form-control">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text col-md-4">Last Name:</span>
                        <input id="userLastName" name="userLastName" type="text" aria-label="lastName" onkeydown="return (event.keyCode < 48 || event.keyCode > 57)" class="form-control" required>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text col-md-4">Extension Name:</span>
                        <input id="userExtensionName" name="userExtensionName" type="text" aria-label="extensionName" onkeydown="return (event.keyCode < 48 || event.keyCode > 57)" class="form-control">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text col-md-4">Email Address:</span>
                        <input id="userEmailAdd" name="userEmailAddress" type="email" aria-label="emailAddress" class="form-control" required>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text col-md-4">Contact Number:</span>
                        <input id="userContactNumber" name="userContactNumber" type="tel" aria-label="contactNumber" class="form-control" pattern="[0-9]{11}" maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '');" placeholder="ex. 09123456789" required>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text col-md-4">Address:</span>
                        <input id="userAddress" name="userAddress" type="text" aria-label="userAddress" class="form-control" required>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text col-md-4">Password:</span>
                        <input type="password" id="userPassword" aria-label="userPassword" class="form-control" required>
                        <button class="btn btn-outline-dark border border-dark" type="button" id="signup-toggle-password">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div> 
                    <div class="input-group">
                        <span class="input-group-text col-md-4">Confirm Password:</span>
                        <input type="password" id="confirmPassword" name="confirmPassword" aria-label="confirmPassword" class="form-control" required>
                        <button class="btn btn-outline-dark border border-dark" type="button" id="signup-toggle-cpassword">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text col-md-4">Valid ID:</span>
                        <input type="file" class="form-control" name="inputValidID" id="inputValidID">
                    </div>
                    <div class="text-center my-3">
                        <input class="form-check-input border-success" type="checkbox" id="agreement1" required>
                        <label class="form-check-label" for="agreement1">
                            &nbsp I have read and understood all the terms and conditions. 
                        </label>
                        <br>
                        <a href="#" data-bs-target="#agreementModal" data-bs-toggle="modal">
                            Read Terms and Conditions here.
                        </a>
                    </div>

                    <div class="modal-footer d-flex justify-content-center">
                        <button id="signupSubmitBtn" type="submit" name="signupSubmitBtn" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <a href="#" class="text-primary" data-bs-target="#LogInModal" data-bs-toggle="modal">Already had an account</a>
            </div>
        </div>
    </div>
</div>
        <!-- Modal -->
        <div class="modal fade" id="agreementModal" aria-hidden="true" aria-labelledby="agreementModalLabel" tabindex="-1">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header justify-content-center bg-body-tertiary">
                        <h1 class="modal-title fs-4 fw-semibold" id="agreementModalLabel">Terms & Conditions</h1>
                    </div>
                    <div class="modal-body bg-body-tertiary">
                        <p class="text-justify"><span class="fw-semibold">Terms of Service and Privacy Policy:</span></p>
                        </p>Welcome to Garahehub Lomi Atbp. By opting to use our services, you are agreeing to the terms and conditions detailed below. Your engagement with our services signifies your acknowledgment, understanding, and acceptance of these terms. Please ensure that your use of our services is in compliance with applicable laws and regulations.
                        </p>
                        
                    <p class="text-justify"> In adherence to the Philippine Data Privacy Act (Republic Act No. 10173), we collect personal information such as names, contact details, and preferences solely for the purpose of order processing and service enhancement. The information collected is used strictly for the intended purposes, and we are committed to ensuring the confidentiality, integrity, and availability of your data. While we implement reasonable security measures to protect your data, it is important to recognize that no method of transmission over the internet or electronic storage is entirely secure. Your personal information will not be sold, traded, or transferred to external parties without providing you with prior notice and obtaining your consent. By utilizing our services, you explicitly consent to the terms outlined in our Privacy Policy, aligning with the Philippine Data Privacy Act.
                     </p>
                     <p class="text-justify"> We strive for transparency in our menu and pricing, though please be aware that they are subject to change without prior notice. Payment for orders is securely processed through our chosen payment gateway, ensuring a safe and reliable transaction. All content on Garahehub Lomi Atbp is protected by applicable intellectual property laws, and any unauthorized use is strictly prohibited. We reserve the right to terminate or suspend your access to our services without prior notice. Garahehub Lomi Atbp cannot be held liable for any direct, indirect, incidental, or consequential damages arising from the use or inability to use our services. These terms are governed by the laws of the Republic of the Philippines. For any questions or concerns regarding these terms, please reach out to us at rmontevirgen.1012@yahoo.com. Thank you for choosing Garahehub Lomi Atbp, we look forward to serving you. 
                     </p>
 
                        <p class="text-justify"><span class="fw-semibold">CONFIRMATION: </span>
                        All reservations are considered tentative and must be confirmed by our staff. We appreciate your understanding that reservation confirmation is subject to verification by our dedicated team, guaranteeing the flawless coordination of our services and the best possible experience for our valued customers.
                        </p>
                        <p class="text-justify"><span class="fw-semibold">DEPOSIT: </span></p>
                            <h8><strong>Event Reservation:</strong></h8>
                                <p>To secure your event reservation, a deposit of 50% will be required. This deposit will be subtracted from the total bill. If there is a no-show for the reservation, and the guests fail to arrive, their deposit may be forfeited.</p>
                                
                            <h8><strong>Dine-in Reservation:</strong></h8>
                                <p>A deposit of P20 per diner will be required for dine-in reservations, which will be deducted from the total amount of the bill. In the event of a no-show, if the customer doesn't arrive within 15 minutes of the reserved time, the reservation will be automatically canceled, and the deposit may be forfeited.</p>
                                
                        <p class="text-justify"><span class="fw-semibold">MENUS AND DRINKS </span></p>
                        <p> Personal food and beverages are not permitted on the restaurant premises. The management has the right to not serve alcoholic drinks to customers who seem a bit tipsy or noticeably affected by alcohol.</p>
                        
                        <p class="text-justify"><span class="fw-semibold">LOSS AND DAMAGE: </span></p>
                        <p> For the safety and security of all our valued guests, we strongly recommend that you exercise caution and refrain from leaving any personal belongings unattended during your visit. It is important to note that the management cannot be held liable or responsible for any potential loss, theft, or damage to your personal items. We appreciate your cooperation in ensuring a secure and enjoyable experience for everyone. 
                        </p>
                        <p class="text-justify"><span class="fw-semibold">Amendment and Cancellation of Orders: </span></p>
                        <p> Once your order is accepted by us, you will not have the right to amend or cancel it. It is essential to understand that the acceptance of your order initiates our fulfillment process, and alterations or cancellations may not be accommodated thereafter. We kindly request that you review your order carefully before confirming, as our commitment to efficiency and prompt service may limit the possibility of modifications once the acceptance process has commenced. Your understanding and cooperation are appreciated in ensuring a smooth and satisfactory experience with our services.
                        </p>
                    </div>
                    <div class="modal-footer justify-content-center bg-body-tertiary">
                        <a href="#" class="btn btn-success" data-bs-target="#signUpModal" data-bs-toggle="modal">Go Back</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal -->
        <div class="modal fade" id="LogInModal" aria-hidden="true" aria-labelledby="LogInModalLabel" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header text-light" style="background-color: #800000 !important ;">
                        <h1 class="fs-5 text-center" id="LogInModalLabel"><i class="fa-regular fa-circle-user"></i>&nbsp Login</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="POST">
                            <div class="input-group d-flex justify-content-center">
                                <div id="loginMessage" class="text-danger fw-medium">
                                </div>
                                <div id="approveMessage" class="text-success fs-3 fw-medium">
                                </div>
                            </div>
                            <div class="input-group mt-3">
                                <span class="input-group-text col-md-3">Email:</span>
                                <input id="loginEmail" name="loginEmail" type="email" aria-label="Email" class="form-control" required>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text col-md-3">Password:</span>
                                <input id="loginPassword" name="loginPassword" type="password" aria-label="loginPassword" class="form-control" required> 
                                <button class="btn btn-outline-dark border border-dark" type="button" id="toggle-password">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                            </div>
                            <div class="modal-footer d-flex justify-content-center">
                                <button id="loginButton" name="loginButton" type="button" class="btn btn-success">Login</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <a href="#" class="text-primary" data-bs-target="#signUpModal" data-bs-toggle="modal">Create account here.</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="VerificationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="VerificationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="VerificationModalLabel"><i class="fa-solid fa-shield-halved"></i>&nbsp Verification</h1>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            <div class="d-flex justify-content-center">
                                <p class="text-center text-success">A verification code was sent to <strong id="emailAddressPlaceholder"></strong></p>.
                            </div>
                            <div class="input-group d-flex justify-content-center">
                                <div id="errorCode" class="text-danger fw-medium"></div>
                            </div>
                            <div class="input-group mt-3">
                                <span class="input-group-text col-md-4">Verification Code:</span>
                                <input type="number" id="verificationCode" name="verificationCode" aria-label="verificationCode" class="form-control" min="0" required>
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                <p id="countdownTimer" class="text-muted"></p>
                                <a class="d-none" id="btnResendCode">Resend Code</a>
                            </div>
                            <div class="modal-footer d-flex justify-content-center mt-3">
                                <button type="button" id="createAccount" name="createAccount" class="btn btn-success">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="aboutUsModal" tabindex="-1" aria-labelledby="aboutUsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
            <div class="modal-header" style="background-color: #800000 !important ;">
                <h1 class="modal-title fs-5 text-light font-me" id="aboutUsModalLabel"><i class="fa-regular fa-circle-question"></i>&nbsp About Us </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal font-me" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h1 class="text-center fw-semibold font-me">Garahe Lomi atbp</h1>
                <br>
                <h4 class="text-center font-me">Since our modest beginnings in 2021 with a little space in Resettlement, Bayambang, Infanta, Pangasinan, GARAHE LOMI ATBP‘s development has been enlivened with the energy to cook and serve solid. In contrast to other Filipino eateries, GARAHE LOMI ATBP. was made with the explicit expectation to appear as something else.
                    We realize numerous individuals love Filipino sustenance, yet a large number of them loathe or are unconscious of the regularly unfortunate fixings that make run-of-the-mill Filipino nourishment taste so great.
                    Our menu highlights things that utilize the sound and fragrant flavors, however, forget the stuffing ghee, spread, oil, and overwhelming cream. GARAHE LOMI ATBP. has developed to incorporate for takeout areas in Resettlement, Bayambang, Pangasinan, with additional to come sooner rather than later.
                </h4>
                <h4 class="text-center font-me">
                    Our group takes pride in the way that we can furnish our new and faithful clients with extraordinary tasting Filipino nourishment that is not normal for that some other Filipino eateries you visit.
                    Our expectation is that you’ll join the developing pattern that such a large number of others have officially found and you will attempt GARAHE LOMI ATBP as a remarkable option to other Filipino eateries as well as to all other solid sustenance alternatives out there!
                </h4>
                <br>
                <h4 class="fw-bold text-center font-me">VISION</h4>
                <h4 class="text-center font-me">To become the go-to restaurant in our community by providing excellent food, quality service, and friendly amenities.</h4>
                <br>
                <h4 class="fw-bold text-center font-me">MISSION</h4>
                <h4 class="text-center font-me">To serve fresh, delicious meals at affordable prices while delivering exceptional customer service and maintaining a pleasant, welcoming atmosphere for our guests.</h4>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-danger text-light font-me" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
        </div>
        <div class="modal fade" id="contactUsModal" tabindex="-1" aria-labelledby="contactUsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header" style="background-color: #800000 !important ;">
                <h1 class="modal-title fs-5 fw-medium text-light" id="contactUsModalLabel"><i class="fa-regular fa-address-card"></i>&nbsp Contact Us</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center fs-5">
                <!-- Facebook Icon -->
                <p class="font-num"><i class="fa-brands fa-facebook"></i>&nbsp Visit our Facebook Page <a href="https://www.facebook.com/profile.php?id=100068285684819" class="text-dark" target="_blank">here.</a></p>
                                
                <!-- Email Icon -->
                <p class="font-num"><i class="fa-solid fa-envelope"></i>&nbsp <a href="mailto:rmontevirgen.1012@yahoo.com" class="text-dark text-decoration-none">Email us at rmontevirgen.1012@yahoo.com</a></p>
                
                <!-- Phone Icon -->
                <p class="font-num"><i class="fa-solid fa-phone"></i>&nbsp Call us at 09311476312</p>
                <button type="button" class="btn btn-danger mt-3" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
        </div>
        <!-- END MODALS -->
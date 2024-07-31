<style>
    .nav-item {
        position: relative;
    }

    .nav-item .nav-link {
        position: relative;
        text-decoration: none;
        color: #DAD4B5;
    }
    .font-num {
        font-family: "Times New Roman", Times, serif;
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
    nav#sidebarMenu{
        height: 90vh;
        background-color: #C08261;
    }
</style>
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">  
    <div class="position-sticky pt-3 sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item mt-2">
                <a class="font-num nav-link text-start ms-2" href="index.php">
                <i class="fa-solid fa-house"></i>
                    Home
                </a>
            </li>
            <li class="nav-item mt-2">
                <a class="font-num nav-link text-start ms-2" data-bs-toggle="collapse" href="#requestCollapse" aria-expanded="false" aria-controls="requestCollapse">
                    <i class="fa-solid fa-address-book"></i>
                    Reservation
                </a>
                <div class="collapse" id="requestCollapse">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item ms-4">
                            <a class="font-num nav-link" href="dineIn.php"><i class="fa-solid fa-circle-dot"></i>&nbsp Dine In</a>
                        </li>
                        <li class="nav-item ms-4">
                            <a class="font-num nav-link" href="event.php"><i class="fa-solid fa-circle-dot"></i>&nbsp Event</a>
                        </li>
                        <li class="nav-item ms-4">
                            <a class="font-num nav-link" href="approved.php"><i class="fa-solid fa-circle-dot"></i>&nbsp Approved</a>
                        </li>
                        <li class="nav-item ms-4">
                            <a class="font-num nav-link" href="complete.php"><i class="fa-solid fa-circle-dot"></i>&nbsp Complete</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item mt-2">
                <a class="font-num nav-link text-start ms-2" data-bs-toggle="collapse" href="#deliverCollapse" aria-expanded="false" aria-controls="deliverCollapse">
                    <i class="fa-solid fa-file-import"></i>
                    Deliver
                </a>
                <div class="collapse" id="deliverCollapse">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item ms-4">
                            <a class="font-num nav-link" href="pending.php"><i class="fa-solid fa-circle-dot"></i>&nbsp Pending</a>
                        </li>
                        <li class="nav-item ms-4">
                            <a class="font-num nav-link" href="toShip.php"><i class="fa-solid fa-circle-dot"></i>&nbsp Approved</a>
                        </li>
                        <li class="nav-item ms-4">
                            <a class="font-num nav-link" href="toReceived.php"><i class="fa-solid fa-circle-dot"></i>&nbsp To be delivered</a>
                        </li>
                        <li class="nav-item ms-4">
                            <a class="font-num nav-link" href="completeDeliver.php"><i class="fa-solid fa-circle-dot"></i>&nbsp Completed</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item mt-2">
                <a class="font-num nav-link text-start ms-2" data-bs-toggle="collapse" href="#pickupCollapse" aria-expanded="false" aria-controls="deliverCollapse">
                    <i class="fa-solid fa-truck-pickup"></i>
                    Pick up
                </a>
                <div class="collapse" id="pickupCollapse">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item ms-4">
                            <a class="font-num nav-link" href="ppending.php"><i class="fa-solid fa-circle-dot"></i>&nbsp Pending</a>
                        </li>
                        <li class="nav-item ms-4">
                            <a class="font-num nav-link" href="ptoShip.php"><i class="fa-solid fa-circle-dot"></i>&nbsp Approved</a>
                        </li>
                        <li class="nav-item ms-4">
                            <a class="font-num nav-link" href="ptoReceived.php"><i class="fa-solid fa-circle-dot"></i>&nbsp Ready to Pick-up</a>
                        </li>
                        <li class="nav-item ms-4">
                            <a class="font-num nav-link" href="pcompleteDeliver.php"><i class="fa-solid fa-circle-dot"></i>&nbsp Completed</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item mt-2">
                <a class="font-num nav-link text-start ms-2" href="users.php">
                    <i class="fa-solid fa-users"></i>
                    Customers
                </a>
            </li>
             <!--
            <li class="nav-item mt-2">
                <a class="font-num nav-link text-start ms-2" href="transactionLog.php">
                    <i class="fa-solid fa-file-signature"></i>
                    Transaction Log
                </a>
            </li>
            <li class="nav-item mt-2">
                <a class="font-num nav-link text-start ms-2" href="products.php">
                    <i class="fa-solid fa-file-signature"></i>
                    Products
                </a>
            </li>
           <li class="nav-item mt-2">
                <a class="nav-link text-start ms-2" href="history.php">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    History
                </a>
            </li>
            <li class="nav-item mt-2">
                <a class="nav-link text-start ms-2" href="records.php">
                    <i class="fa-solid fa-clipboard"></i>
                    Records
                </a>
            </li>
            <li class="nav-item mt-2">
                <a class="nav-link text-start ms-2" href="transaction.php">
                    <i class="fa-regular fa-paste"></i>
                    Transaction Log
                </a>
            </li> -->
            <li class="nav-item fs-6 mt-2">
                <a class="font-num nav-link text-start ms-2" href="logout.php">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Log out
                </a>
            </li>
        </ul>
    </div>
</nav>
<div class="modal fade" id="rateModal<?php echo $row['ID']; ?>" tabindex="-1" aria-labelledby="rateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-light" style="background-color: #800000 !important;">
                <h5 class="font-num modal-title" id="rateModal<?php echo $row['ID']; ?>Label">Order Information</h5>
                <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-body-tertiary">
                <div class="container">
                    <div id="message"></div>
                    <form method="POST" id="formRatings">
                        <div class="input-group mt-1">
                            <strong class="font-num input-group-text col-4">Transaction Number</strong>
                            <input type="text" class="font-num form-control text-center" name="transactionNumber" value="<?php echo  $row['transactionNumber']; ?>" readonly>
                        </div>
                        <div class="input-group mt-1">
                            <strong class="font-num input-group-text col-4">User Email</strong>
                            <input type="text" class="font-num form-control text-center" name="userEmailAddress" value="<?php echo  $row['userEmailAddress']; ?>" readonly>
                        </div>
                        <!-- DISPLAY EACH ITEMS THAT HAS BEEN GROUPED HERE -->
                        <?php 
                            $xtran_num = $row['transactionNumber'];
                            $xsql = "SELECT * FROM user_delivery_tbl WHERE transactionNumber = ?";
                            $xstmt = $conn->prepare($xsql);
                            $xstmt->bind_param('s', $xtran_num);
                            $xstmt->execute();
                            $xrs = $xstmt->get_result();

                            $xrs_data = [];
                            while ($row = $xrs->fetch_assoc()) {
                                $xrs_data['prod_id']    = $row['productID'];
                                $xrs_data['tran_num']   = $row['transactionNumber'];
                                $xrs_data['prod_img']   = $row['productImage'];
                                $xrs_data['prod_name']  = $row['productName'];

                                $xsql2 = "SELECT * FROM product_tbl WHERE productID = ?";
                                $xstmt2 = $conn->prepare($xsql2);
                                $xstmt2->bind_param('s', $xrs_data['prod_id']);
                                $xstmt2->execute();
                                $xrs2 = $xstmt2->get_result()->fetch_assoc();
                        ?>
                        <div class="form-control mt-1">
                            <div class="row">
                                <div class="col-md-4">
                                    <img class="rounded w-50" src="../admin/images/products/<?php echo $xrs_data['prod_img'] ; ?>" alt="<?php echo $xrs_data['prod_name']; ?>" style="height: 100px;">
                                    <label class="font-num form-check-label">
                                        <span class="font_me fw-bold col-md-2"><?php echo $xrs_data['prod_name']; ?>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="font-num pt-4 form-check-label font-num fw-semibold">
                                        <?php echo $xrs_data['prod_id']; ?>
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <div class="rate d-flex justify-content-center" data-product-id="<?php echo $xrs_data['prod_id']; ?>">
                                        <span class="star" data-value="1" title="1 stars">★</span>
                                        <span class="star" data-value="2" title="2 stars">★</span>
                                        <span class="star" data-value="3" title="3 stars">★</span>
                                        <span class="star" data-value="4" title="4 stars">★</span>
                                        <span class="star" data-value="5" title="5 stars">★</span>
                                        <input class="selectedRating" id="rating[<?php echo $xrs2['productID']; ?>]" name="rating[<?php echo $xrs2['productID']; ?>]" value="<?php echo $xrs2['productRating'];?>" data-transaction-number="<?php echo $xrs_data['tran_num']; ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="input-group mt-1 d-flex justify-content-end">
                            <input type="button"id="sendRatingsBtn" class="btn btn-success" value="Send Ratings" onclick="sendRate('<?php echo $xrs_data['tran_num']; ?>')">
                        </div>
                        <!-- END OF DISPLAY -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
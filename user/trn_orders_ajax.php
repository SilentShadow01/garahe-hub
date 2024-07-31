<?php 
require_once '../assets/connection.php';
$xres = [];

if (isset($_POST['event_action']) && $_POST['event_action'] == 'sendRatings') {
    $xproduct_id = $_POST['product_id'];
    $xproduct_rate = $_POST['product_rate'];
    $xtransac_num = $_POST['transac_num'];

    $xqry1 = "SELECT * FROM user_delivery_tbl WHERE transactionNumber = ?";
    $xstmt1 = $conn->prepare($xqry1);
    $xstmt1->bind_param("s", $xtransac_num);
    $xstmt1->execute();
    $xrs = $xstmt1->get_result();
    
    if ($xrs->num_rows > 0) {
        $xarr_product_id = [];
        while ($xtransac_data = $xrs->fetch_assoc()) {
            $xarr_product_id[] = $xtransac_data['productID'];
        }

        $xqry2 = "UPDATE product_tbl SET productRating = ? WHERE productID = ?";
        $xstmt2 = $conn->prepare($xqry2);
        foreach ($xarr_product_id as $productID) {
            
            $xstmt2->bind_param("ss", $xproduct_rate, $productID);
        }
        $xres['stat'] = 'error';
        $xres['msg'] = 'error' . $xstmt2->error;
        if ($xstmt2->execute()) {
            $xres['stat'] = 'success';
            $xres['msg'] = 'Product Rating Added Successfully';
        }
    }
    $xstmt1->close();
}
echo json_encode($xres);
?>
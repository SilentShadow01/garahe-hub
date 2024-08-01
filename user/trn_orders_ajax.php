<?php 
require_once '../assets/connection.php';
$xres = [];

if (isset($_POST['event_action']) && $_POST['event_action'] == 'sendRatings') {

    $xtransac_num = $_POST['transac_num'];

    $xrate_val = [];
    foreach ($_POST['ratings'] as $xrating) {
        $xprod_id   = isset($xrating['product_id']) ? $xrating['product_id'] : '';
        $xprod_rate = isset($xrating['product_rate']) ? $xrating['product_rate'] : '';

        $xrate_val[] = [
            'prod_id'   => $xprod_id,
            'prod_rate' => $xprod_rate
        ];
    }

    $xqry2 = "UPDATE product_tbl SET productRating = ? WHERE productID = ?";
    $xstmt2 = $conn->prepare($xqry2);

    if ($xstmt2 === false) {
        $xres['stat'] = 'error';
        $xres['msg'] = 'error' . $conn->error;
    }

    $xbool = true;
    foreach ($xrate_val as $xrs_rate_val) {
        $prod_id = $xrs_rate_val['prod_id'];
        $prod_rate = $xrs_rate_val['prod_rate'];

        $xstmt2->bind_param("ss", $prod_rate, $prod_id);

        if (!$xstmt2->execute()) {
            $xbool = false;
            $xres['stat'] = 'error';
            $xres['msg'] = 'error' . $xstmt2->error;
        }
    }

    if ($xbool) {
        $xres['stat'] = 'success';
        $xres['msg'] = 'Product Rating Updated Successfully';
    }

    $xstmt2->close();
}

echo json_encode($xres);
?>
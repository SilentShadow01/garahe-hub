<?php
   require_once('../assets/connection.php');
   $getmonth = date("m");
   $sql_pros = "SELECT count(*) AS `Count` FROM usermanagement_tbl WHERE userType = 'user'";
   $results_pros = mysqli_query($conn, $sql_pros);
   if (mysqli_num_rows($results_pros) > 0)
    {
        while($row_cat = mysqli_fetch_array($results_pros))
        {
            $totalUser = $row_cat['Count'];
        }
    }
    else 
    {
        $totalUser =0;
    }
    $sql_pros = "SELECT ROUND(productQuality) AS avgRating FROM user_ratings_tbl";
    $results_pros = mysqli_query($conn, $sql_pros);
    if (mysqli_num_rows($results_pros) > 0)
    {
        while($row_cat = mysqli_fetch_array($results_pros))
        {
            $productQualityRatings = $row_cat['avgRating'];
        }
    }
    else 
    {
        $productQualityRatings = 0;
    }
    $sql_pros = "SELECT ROUND(deliveryService) AS avgRating FROM user_ratings_tbl";
    $results_pros = mysqli_query($conn, $sql_pros);
    if (mysqli_num_rows($results_pros) > 0)
    {
        while($row_cat = mysqli_fetch_array($results_pros))
        {
            $deliveryServiceRatings = $row_cat['avgRating'];
        }
    }
    else 
    {
        $deliveryServiceRatings = 0;
    }
    $sql_pros = "SELECT count(*) AS value_sum FROM users_reservation_tbl WHERE `reservationStatus` = 'Pending' AND DATE(`reservationDate`) = CURDATE()";
    $results_pros = mysqli_query($conn, $sql_pros);
    if (mysqli_num_rows($results_pros) > 0)
    {
        while($row_cat = mysqli_fetch_array($results_pros))
        {
            $reservationToday = $row_cat['value_sum'];
        }
    }
    else
    {
        $reservationToday = 0;
    }
    $sql_pros = "SELECT count(*) AS value_sum FROM user_delivery_tbl WHERE `orderStatus` = 'pending' AND `modeOfClaim` = 'delivery' AND DATE(`orderDate`) = CURDATE()";
    $results_pros = mysqli_query($conn, $sql_pros);
    if (mysqli_num_rows($results_pros) > 0)
    {
        while($row_cat = mysqli_fetch_array($results_pros))
        {
            $deliveryToday = $row_cat['value_sum'];
        }
    }
    else
    {
        $deliveryToday = 0;
    }
    $sql_pros = "SELECT count(*) AS value_sum FROM user_delivery_tbl WHERE `orderStatus` = 'pending' AND `modeOfClaim` = 'pickUp' AND DATE(`orderDate`) = CURDATE()";
    $results_pros = mysqli_query($conn, $sql_pros);
    if (mysqli_num_rows($results_pros) > 0)
    {
        while($row_cat = mysqli_fetch_array($results_pros))
        {
            $pickUpToday = $row_cat['value_sum'];
        }
    }
    else
    {
        $pickUpToday = 0;
    }
    $sql_pros = "SELECT count(*) AS value_sum FROM users_reservation_tbl WHERE `reservationStatus` = 'Pending'";
    $results_pros = mysqli_query($conn, $sql_pros);
    if (mysqli_num_rows($results_pros) > 0)
    {
        while($row_cat = mysqli_fetch_array($results_pros))
        {
            $pendingReservation = $row_cat['value_sum'];
        }
    } 
    else
    {
        $pendingReservation = 0;
    }
    $sql_pros = "SELECT count(*) AS value_sum FROM user_delivery_tbl WHERE `orderStatus` = 'complete'";
    $results_pros = mysqli_query($conn, $sql_pros);
    if (mysqli_num_rows($results_pros) > 0)
    {
        while($row_cat = mysqli_fetch_array($results_pros))
        {
            $completeOrder = $row_cat['value_sum'];
        }
    }
    else
    {
        $completeOrder = 0;
    }
    // $sql_pros = "SELECT MONTH(`dateRequest`) as `Month` , COUNT(`dateRequest`)  as `Count` FROM student_tbl_request WHERE `studentID` = '$userNumber' AND `dateRequest` >= NOW() - INTERVAL 1 YEAR GROUP BY MONTH(`dateRequest`)";
    // $results_pros = mysqli_query($conn, $sql_pros);
    // if (mysqli_num_rows($results_pros) > 0)
    // {
    //     while($row_cat = mysqli_fetch_array($results_pros))
    //     {
    //         if ($getmonth == $row_cat['Month'])
    //         {                          
    //             $total_month = $row_cat['Count'];
    //         }
    //         else
    //         {
    //             $total_month = 0;
    //         }
    //     }
    // }
    // else
    // {
    //     $total_month =0;
    // }
    // $sql_pros = "SELECT MONTH(`dateRequest`) as `Month` , COUNT(`dateRequest`)  as `Count` FROM student_tbl_request WHERE `studentID` = '$userNumber' AND `dateRequest` >= NOW() - INTERVAL 1 YEAR GROUP BY MONTH(`dateRequest`)";
    // $results_pros = mysqli_query($conn, $sql_pros);
    // if (mysqli_num_rows($results_pros) > 0)
    // {
    //     while($row_cat = mysqli_fetch_array($results_pros))
    //     {
    //         if (($getmonth - 1) == $row_cat['Month'])
    //         {                          
    //             $total_month_last = $row_cat['Count'];
    //         }
    //         else
    //         {
    //             $total_month_last = 0;
    //         }
    //     }
    // }
    // else
    // {
    //     $total_month_last =0;
    // }
?>
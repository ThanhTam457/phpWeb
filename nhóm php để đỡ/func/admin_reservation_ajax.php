<?php
include "../func/init.php";

$reservationObj = new Reservation($conn);

if(isset($_REQUEST["page"]) && isset($_REQUEST["status"])){
    $page = (int)$_REQUEST["page"];
    $status = (int)$_REQUEST["status"];
    if($page < 1){
        $page = 1;
    }   

    $reservationList = $reservationObj->getReservation($limit = 10, $offset = 10 * ($page - 1), $status = $status);

    print json_encode($reservationList);
} elseif (isset($_REQUEST["confirmReservationId"])){
    $id = (int)$_REQUEST["confirmReservationId"];
    $reservationObj->confirmReservation($id);
}
?>
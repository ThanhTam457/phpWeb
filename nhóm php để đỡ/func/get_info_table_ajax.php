<?php
include "../func/init.php";

$date = $_REQUEST["date"];
$date = str_replace('/', '-',$date);
$time = $_REQUEST["time"];
$people_num = $_REQUEST["people_num"];

$combinedDT = date('Y-m-d H:i:s', strtotime("$date $time"));

$sql = "SELECT DISTINCT tables.id AS table_id
        FROM tables LEFT JOIN booking_tables ON tables.id=booking_tables.table_id
        WHERE booking_tables.booking_date=?";

if($people_num <= 4)
        $sql .= " AND tables.num_seat=4";
elseif($people_num > 4 && $people_num <= 6)
        $sql .= " AND tables.num_seat=6";
else
        $sql .= " AND tables.num_seat=8";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $combinedDT);
$stmt->execute();
$result = $stmt->get_result();
$booked_table = $result->fetch_all(MYSQLI_ASSOC);

print json_encode($booked_table);
?>
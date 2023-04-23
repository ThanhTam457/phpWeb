<?php
include "../func/init.php";

$id = $_REQUEST['id'];
global $conn;
$sql = "SELECT custom_foods.bill_id, foods.name,foods.price, custom_foods.num_item
        FROM custom_foods JOIN foods on custom_foods.food_id=foods.id WHERE custom_foods.bill_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows >0){
    $result = $result -> fetch_all(MYSQLI_ASSOC);
}

print json_encode($result);


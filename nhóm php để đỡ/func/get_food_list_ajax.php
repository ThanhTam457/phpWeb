<?php
include "../func/init.php";

$category = $_REQUEST['category'];
$page = $_REQUEST['page'];
if($page < 1){
    $page = 1;
}

$foodObj = new Food($conn);

$results = $foodObj->getfoods($limit = 9, $offset = 9 * ($page - 1), $category = $category);

print json_encode($results);
?>
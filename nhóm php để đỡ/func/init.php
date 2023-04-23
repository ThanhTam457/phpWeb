<?php
session_start();
if(!isset($_SESSION['logged_in'])) {
    $_SESSION['logged_in'] = false;
}

if(!isset($_SESSION['shopping-food-cart'])) {
    $_SESSION['shopping-food-cart'] = [];
}

$page_name_php = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

// loads classes from classes dir
function classLoader($className) {
    global $page_name_php;
    switch($page_name_php){
        case "get_info_table_ajax.php":
        case "get_food_list_ajax.php":
        case "shopping_cart_handle_ajax.php":
        case "get_order_food_detail_ajax.php":
        case "admin_reservation_ajax.php":
            include "../classes/" . $className . ".php";
            break;
        default:
            include "classes/" . $className . ".php";
            break;
    }
}

spl_autoload_register('classLoader');
$db = new DB("localhost", "root", "", "golden_res_2022");
$conn = $db->getConn();

$message = [];

switch($page_name_php){
    case "get_info_table_ajax.php":
    case "get_food_list_ajax.php":
    case "shopping_cart_handle_ajax.php":
    case "get_order_food_detail_ajax.php":
    case "admin_reservation_ajax.php":
        include "../func/func.php";
        break;
    default:
        include "func/func.php";
        break;
}
?>
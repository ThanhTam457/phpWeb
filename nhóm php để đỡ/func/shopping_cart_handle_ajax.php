<?php
include "../func/init.php";

if(isset($_REQUEST['food_id']) && $_REQUEST['food_amount']) {
    $food_id = $_REQUEST['food_id'];
    $food_amount = (int)$_REQUEST['food_amount'];

    $foodObj = new Food($conn);
    $result = $foodObj->getfood($food_id);

    if(isset($_SESSION['shopping-food-cart'][$result['name']])){
        $_SESSION['shopping-food-cart'][$result['name']]['count'] += $food_amount;
    } else {
        $_SESSION['shopping-food-cart'][$result['name']] = $result;
        $_SESSION['shopping-food-cart'][$result['name']]['count'] = $food_amount;
    }

    // $_SESSION['shopping-food-cart'] = [];

    print json_encode($result);

} elseif (isset($_REQUEST['remove_food_name'])){
    $remove_food_name = $_REQUEST['remove_food_name'];
    
    unset($_SESSION['shopping-food-cart'][$remove_food_name]);
}

?>
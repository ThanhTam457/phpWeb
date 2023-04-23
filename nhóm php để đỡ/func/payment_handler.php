<?php

//Booking table function//

function createBookingBill($custom_id, $table_id, $booking_date, $num_people) {
    global $conn;
    $total_pay_amount = 5;
    $sql = "INSERT INTO bills (custom_id, total_pay_amount) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $custom_id, $total_pay_amount);
    $stmt->execute();
    if($stmt->affected_rows === 1) {
        $billId = $stmt->insert_id;
        insertBooking_table($_SESSION['user_id'], $table_id, $billId, $booking_date, $num_people, 0);
        header("Location: index.php");
        $_SESSION['msg'] = "Payment success!!!";
        $_SESSION['msg_class'] = "success";
        sessionMsg();
    }  else {
        $_SESSION['msg'] = "Payment is wrong!!";
        $_SESSION['msg_class'] = "danger";    
    }
}

function insertBooking_table($custom_id, $table_id, $billId, $booking_date, $num_people, $status) {
    global $conn;
    $sql = "INSERT INTO booking_tables (custom_id, table_id, bill_id, booking_date, num_people, status) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiisii", $custom_id, $table_id , $billId, $booking_date, $num_people, $status);
    $stmt->execute();
}

//Ordering food function//
function createOrderingBill($custom_id, $food, $total_pay) {
    global $conn;
    $sql = "INSERT INTO bills (custom_id, total_pay_amount) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("id", $custom_id, $total_pay);
    $stmt->execute();
    if($stmt->affected_rows === 1) {
        $billId = $stmt->insert_id;
        insertCustom_food($_SESSION['user_id'], $food, $billId);
        header("Location: index.php");
        $_SESSION['msg'] = "Payment success!!!";
        $_SESSION['msg_class'] = "success";
        sessionMsg();
    }  else {
        $_SESSION['msg'] = "Payment is wrong!!";
        $_SESSION['msg_class'] = "danger"; 
    }
}

function insertCustom_food($custom_id, $food, $billId){
    global $conn;
    
    $sql = "INSERT INTO custom_foods (custom_id, food_id, bill_id, num_item) VALUES (?,?,?,?)";
    $stmt = $conn->prepare($sql);
    foreach($food as $singleFood){
        $stmt->bind_param("iiii", $custom_id, $singleFood['id'], $billId, $singleFood['count']);
        $stmt->execute();
    }
}

//validate form input//
$form_user = [
    "card-number"=>"",
    "card-number_err"=>false,
    "card-date"=>"",
    "card-date_err"=>false,
    "card-CVV-CVC"=>"",
    "card-CVV-CVC_err"=>false,
    "card-name"=>"",
    "card-name_err"=>false
];

function checkCard_number($card_number){
    if(preg_match('/^[0-9]{10}+$/', $card_number)) {
        return true;
    }else{
          return false;
    }
}



function checkCVV($input){
    if((preg_match('/^[0-9]{3}+$/', $input)) || (preg_match('/^[0-9]{4}+$/', $input))) {
        return true;
    }else{
          return false;
    }
}

function validateForm($user, &$form_user){
    $form_user['card-number'] = htmlspecialchars($user['card-number']);
    $form_user['card-date'] = htmlspecialchars($user['card-date']);
    $form_user['card-CVV-CVC'] = htmlspecialchars($user['card-CVV-CVC']);
    $form_user['card-name'] = htmlspecialchars($user['card-name']);
    
    if(checkCard_number($form_user['card-number']) === false) {
        $form_user['card-number_err'] = true;
    }

    if(checkCVV($form_user['card-CVV-CVC']) === false){
        $form_user['card-CVV-CVC_err'] = true;
    }

    if($form_user['card-name'] === ""){
        $form_user['card-name_err'] =true;
    }

    if(!array_search(true, $form_user, true)) {
        if(isset($_POST['table_id'])){
            $temp = $_POST['date'];
            $temp = str_replace("/", "-", $temp);
            $date = strtotime($temp); //chuyển sang php
            $store_date = date("Y-m-d", $date);
            $store_datetime = $store_date." ".$_POST['time'];
    
            createBookingBill($_SESSION['user_id'], (int)$_POST['table_id'], $store_datetime, $_POST['amount_people']);
            
        }elseif(isset($_POST['order_food_check_out'])){
            $initTotalPay = 0.0;
        
            foreach($_SESSION['shopping-food-cart'] as $item){
                $initTotalPay += $item['price'] * $item['count'];
            }

            createOrderingBill($_SESSION['user_id'], $_SESSION['shopping-food-cart'], $initTotalPay);
            unset($_SESSION['shopping-food-cart']);
        }
    }else{
        setMsg("There was an error with your submission!", "danger");
      }
    
}

function checkValid($field, $arr) {
    $key = $field . "_err"; 
    if($arr[$key]) {
       echo "is-invalid";
    }
 }

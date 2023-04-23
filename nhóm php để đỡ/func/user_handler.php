<?php

//////////////////////////////////edit user////////////////////////
$edit_user = [
    "F_name" => "",
    "F_name_err" => false,
    "L_name" => "",
    "L_name_err" => false,
    "address" =>"",
    "address_err" => false
];

function checkValid($field, $arr) {
    $key = $field . "_err"; 
    if($arr[$key]) {
       echo "is-invalid";
    }
 }

function validateEdit($user, &$edit_user){
    $edit_user['F_name'] = htmlspecialchars($user['F_name']);
    $edit_user['L_name'] = htmlspecialchars($user['L_name']);
    $edit_user['address'] = htmlspecialchars($user['address']);
    if(strlen($edit_user['address']) < 1) {
        $edit_user['address_err'] = true;
    }

    if(!array_search(true, $edit_user, true)) {
        editUser($edit_user);
    } else {
        setMsg("There was an error with your submission!", "danger");
    }
}

 function editUser($user){
    global $conn;
    $update_user = [
        "F_name" => $user['F_name'],
        "L_name" => $user['L_name'],
        "address" => $user['address']
    ];
    global $conn;
    $sql = "UPDATE accounts SET F_name =? , L_name =?, address = ? WHERE id=? ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $update_user['F_name'], $update_user['L_name'] , $update_user['address'], $_SESSION["user_id"]);
    $stmt->execute();
    if($stmt->affected_rows == 1) {
        $set_user = getUser($_SESSION["user_id"]);
        setUser($set_user);
    }
}

function setUser($user) {
    $_SESSION['phone_num'] = $user['phone_num'];
    $_SESSION['F_name'] = $user['F_name'];
    $_SESSION['L_name'] = $user['L_name'];
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['address'] = $user['address'];

    header("Location: user.php");
 }


 function getUser($user) {
    global $conn;
    $sql = "SELECT * FROM accounts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0) {
       return $result->fetch_assoc();
    } else {
       return 0;
    }
 }

 //////////////////////////view history///////////////////////////
 function getHistoryBooking($user){
    global $conn;
    $sql = "SELECT * FROM booking_tables JOIN bills ON booking_tables.bill_id=bills.id WHERE booking_tables.custom_id=? ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i",$user);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows >0){
        return $result->fetch_all(MYSQLI_ASSOC);
    }else{
        return 0;
    }
 }


function getHistoryOrderFood($user){
    global $conn;

    $sql = "SELECT *
            FROM bills join custom_foods on bills.id=custom_foods.bill_id 
            WHERE custom_foods.custom_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i",$user);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows >0){
        $sql_check = "SELECT bills.id, sum(custom_foods.num_item) as amount, bills.total_pay_amount, bills.bill_date
        FROM bills join custom_foods on bills.id=custom_foods.bill_id 
        WHERE custom_foods.custom_id=?
        GROUP BY bills.id";
        $statement = $conn->prepare($sql_check);
        $statement->bind_param("i",$user);
        $statement->execute();
        $result_check = $statement->get_result();
        if($result_check->num_rows >0){
            return $result_check->fetch_all(MYSQLI_ASSOC);
        }
    }else{
        return 0;
    }
}

function getBillFromId($bill_id){
    global $conn;
    $sql = "SELECT custom_foods.bill_id, foods.name,foods.price, custom_foods.num_item
            FROM custom_foods JOIN foods on custom_foods.food_id=foods.id WHERE custom_foods.bill_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bill_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows >0){
        return $result->fetch_all(MYSQLI_ASSOC);
    }else{
        return 0;
    }
}

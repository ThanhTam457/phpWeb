<?php
   $new_user = [
      "phone_num" => "",
      "phone_num_err" => false,
      "password" => "",
      "password_err" => false,
      "password_confirm" => "",
      "password_confirm_err"=> false,
      "F_name" =>"",
      "L_name" =>""
   ];

   // login user arr to store login data and errors
   $login_user = [
      "phone_num" => "",
      "phone_num_err" => false,
      "password" => "",
      "password_err" => false
   ];

   function validateLogin($user, &$login_user, $last_page_visit = "index") {
      global $conn;
      // assign values to login_user arr, sanitize phone_num
      $login_user['phone_num'] = htmlspecialchars($user['phone_num']); //$_POST['phone_num']
      $login_user['password'] = $user['password'];

      //bring in the users as an assoc arr
      $user = getUser($login_user['phone_num']);
      if(empty($user)) {
         setMsg("phone number not found!", "danger");
         $login_user['phone_num_err'] = true;
      } else {
         // next step: check user pw against the hash in the db
         // access the user using the index
         if(password_verify($login_user['password'], $user['password_hash'])) {
            //login the user
            loginUser($user, $last_page_visit);
         } else {
            // output error msg about PW
            $login_user['password_err'] = true;
            setMsg("Incorrect password!", "danger");
         }
      }
   }

   function checkPhone_number($phone_number){
      if(preg_match('/^[0-9]{10}+$/', $phone_number)) {
          return true;
         }else{
            return false;
         }
      }

  
   function validateNewUser($user, &$new_user, $last_page_visit = "index") {
      $new_user['phone_num'] = htmlspecialchars($user['phone_num']);
      $new_user['password'] = htmlspecialchars($user['password']);
      $new_user['password_confirm'] = htmlspecialchars($user['password_confirm']);
      $new_user['F_name'] = htmlspecialchars($user['F_name']);
      $new_user['L_name'] = htmlspecialchars($user['L_name']);
      //input validation
      $user = getUser($new_user['phone_num']);
      // check phone_num have no letters
      if((checkPhone_number($new_user['phone_num']) === false) || (!empty($user))) {
         $new_user['phone_num_err'] = true;
      }
      // check password > 5 chars
      if(strlen($new_user['password']) < 5) {
         $new_user['password_err'] = true;
      }
      // check password a = password b
      if($new_user['password'] != $new_user['password_confirm']) {
         $new_user['password_confirm_err'] = true;
      }
      // check if any _err == true in $new_user, if no error create account, else output error msg setMsg($msg, $class)
      if(!array_search(true, $new_user, true)) {
        // create new account, login the user then redirect to home page
         createNewUser($new_user, $last_page_visit);
      } else {
         setMsg("There was an error with your submission!", "danger");
      }
   }

   function createNewUser($new_user, $last_page_visit = "index") {
      global $conn;
      $user = [
         "F_name" => $new_user['F_name'],
         "L_name" => $new_user['L_name'],
         "phone_num" => $new_user['phone_num'],
         "password" => password_hash($new_user['password'], PASSWORD_DEFAULT)
      ];
      $sql = "INSERT INTO accounts (phone_num,  password_hash, F_name, L_name) VALUES (?, ?, ?, ?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ssss", $user['phone_num'], $user['password'], $user['F_name'], $user['L_name']);
      $stmt->execute();
      if($stmt->affected_rows == 1) {
         $loginuser = getUser($user['phone_num']);
         loginUser($loginuser, $last_page_visit);
      }
   }

   function loginUser($user, $last_page_visit = "index") {
      $_SESSION['phone_num'] = $user['phone_num'];
      $_SESSION['F_name'] = $user['F_name'];
      $_SESSION['L_name'] = $user['L_name'];
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['role'] = $user['role'];
      $_SESSION['logged_in'] = true;
      $_SESSION['msg'] = "Logged in successfully!";
      $_SESSION['msg_class'] = "success";
      // send user back to homepage
      header("Location: " . $last_page_visit . ".php");
   }


   function getUser($user) {
      global $conn;
      $sql = "SELECT * FROM accounts WHERE phone_num = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $user);
      $stmt->execute();
      $result = $stmt->get_result();
      if($result->num_rows > 0) {
         return $result->fetch_assoc();
      } else {
         return 0;
      }
   }
   // helper function to output error class in input
   function checkValid($field, $arr) {
      $key = $field . "_err"; // phone_num + _err => $new_user['phone_num_err']
      if($arr[$key]) {
         echo "is-invalid";
      }
   }
?>

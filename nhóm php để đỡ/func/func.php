<?php
function sessionMsg() {
    if(isset($_SESSION['msg'])) {
      echo "<div class='container my-3'><div class='alert alert-{$_SESSION['msg_class']}'>
            {$_SESSION['msg']}
            </div></div>";
      unset($_SESSION['msg']);
      unset($_SESSION['msg_class']);
    }
  }


function setMsg($msg, $class) {
    global $message;
    $message['msg'] = $msg;
    $message['class'] = $class;
}

function arrayHtmlSpecialChar($array) {
  $newArray = [];
  foreach($array as $item){
    array_push($newArray, htmlspecialchars($item));
  }

  return $newArray;
}

?>
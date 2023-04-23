<?php 
include 'inc/head.php';
include 'func/payment_handler.php';

if(!isset($_POST['table_id']) && !isset($_POST['order_food_check_out'])){
    if (isset($_GET['payfor'])){
        switch($_GET['payfor']){
            case "booking_table":
                header("Location: booking_table.php");
                break;
            case "order_food":
                header("Location: order_food.php");
                break;
            default: //tránh trường hợp có payfor nhưng ko hợp lệ
                header("Location: index.php");
                break;
        }
    } else {
        //không có $_GET['payfor']
        header("Location: index.php");
    }
}

// process to payment: kiểm tra credit card nhập vào (format là được rồi)
// xong nếu ok thì insert vô bảng booking table
// còn bảng bill nữa
// nhớ dùng isset

if(isset($_POST['table_id'])){
    $temp = $_POST['date'];
    $temp = str_replace("/", "-", $temp);
    $date = strtotime($temp); //chuyển sang php
    $store_date = date("Y-m-d", $date);
    $store_datetime = $store_date." ".$_POST['time'];

}elseif(isset($_POST['order_food_check_out'])){
    $initTotalPay = 0.0;

    foreach($_SESSION['shopping-food-cart'] as $item){
        $initTotalPay += $item['price'] * $item['count'];
    }
}

if(isset($_POST['submitPayment'])){
    validateForm($_POST, $form_user);
}
    

?>

<div class="main-wrapper">       
    <h1 class="text-center my-4 mx-5 pay-text">PAYMENT</h1>    

    <!-- payfor bookingtable -->
    <?php if (isset($_POST['table_id'])) : ?> 
    <div class="text-center fs-4 container detail">
        <ul style="background-color: whitesmoke; margin-left: 20rem; margin-right: 20rem; border-radius: 25px;">
            <p>Date and time: <?php echo $_POST['date']." ".$_POST['time'] ?></p>
            <p>Table for <?php echo $_POST['amount_people'] ?> person(s): <?php echo $_POST['table_id'] ?></p>
        </ul>
        <ul mt-2>
            <hr style="height: 3px; margin-left: 200px; margin-right: 200px;">
            <a href="booking_table.php" class="btn btn-booking-table">Change selection</a>
        </ul>
    </div>
    
    <!-- html cho phần order food -->
    <?php elseif(isset($_POST['order_food_check_out'])): ?>
        <div class="modal-content mb-3">
            <div class="modal-header">
                <h3 class="modal-title text-center" id="staticBackdropLabel">My Shopping Cart</h3>
            </div>
            <div class="modal-body food-list-added">
                <table class="food-list-added-table table table-striped fs-4">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Amount</th>                        
                        </tr>
                    </thead>
                    <!-- food item in shopping cart -->
                    <tbody>
                        <?php $index_food = 1; foreach($_SESSION['shopping-food-cart'] as $item): ?> 
                            <tr>
                                <th scope="row"><?= $index_food++; ?></th>
                                <td class="food-name-item-cart"><?= $item['name'] ?></td>
                                <td class="food-added-price">$<?= $item['price'] ?></td>
                                <td class="amount-food-added"><?= $item['count'] ?></td>
                            </tr>
                        <?php endforeach; unset($index_food) ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <h4 class="total-pay m-auto ms-3">Total: $<span><?= $initTotalPay ?></span></h4>
            </div>
        </div>
    <?php endif; ?>

    <div class="container payment">
        <form action="payment.php" method="POST" class="payment-form px-5 py-3">
        <?php if (isset($_POST['table_id'])) : ?>
            <input type="hidden" id="table_id" name="table_id" value = "<?php echo $_POST['table_id']; ?>">
            <input type="hidden" id="date" name="date" value = "<?php echo $_POST['date']; ?>">
            <input type="hidden" id="time" name="time" value = "<?php echo $_POST['time']; ?>">
            <input type="hidden" id="amount_people" name="amount_people" value = "<?php echo $_POST['amount_people']; ?>">
        <?php elseif(isset($_POST['order_food_check_out'])): ?>
            <input type="hidden" id="order_food_check_out" name="order_food_check_out" value = "<?php echo $_POST['order_food_check_out']; ?>">
        <?php endif; ?>
            <p class="mb-1">Card Number: </p>
            <div class="payment-card position-relative">
                <input type="text" name="card-number" placeholder="Bank card number"  style="font-family:Arial, FontAwesome" class="payment-bar <?php checkValid("card-number", $form_user) ?>">
                <div class="invalid-feedback">
                    Card number invalid
                </div>
                <span class="d-sm-flex position-absolute payment-icon d-none">
                    <img src="images/svg/american-express-card.png" alt="">
                    <img src="images/svg/jcb-card.png" alt="">
                    <img src="images/svg/master-card.png" alt="">
                    <img src="images/svg/visa-card.png" alt="">
                </span> 
            </div>           
            <div class="row mt-1 mb-2">
               <div class="payment-detail col-md-4">
                <p class="mb-1">Expiration date</p>
                <input type="text" name="card-date" placeholder="MM/YY" class="payment-bar <?php checkValid("card-date", $form_user) ?>">
                <div class="invalid-feedback">
                    Date invalid
                </div>
               </div>
               <div class="payment-detail col-md-4">
                <p class="mb-1">CVV/CVC</p>
                <input type="text" name="card-CVV-CVC" placeholder="3 or 4 digit number" class="payment-bar <?php checkValid("card-CVV-CVC", $form_user) ?>">
                <div class="invalid-feedback">
                    Number invalid
                </div>
               </div>
               <div class="payment-detail col-md-4">
                <p class="mb-1">Cardholer's name</p>
                <input type="text" name="card-name" placeholder="Name"class="payment-bar <?php checkValid("card-name", $form_user) ?>">
                <div class="invalid-feedback">
                    Must write your name here!
                </div>
               </div> 
            </div>   
            <div class="input-group p-2">
            <div class="input-group-prepend">
                <div class="input-group-text p-0 m-2">
                    <input type="checkbox" aria-label="Checkbox for following text input" class=" payment-input">
                </div>
            </div>
            <p>Save the card information for future payments</p>
            </div>
            <div class="justify-content-center payment-button-container text-center mt-4">
                <button class="payment-button border-0 w-50 p-3" name="submitPayment" type="submit" value="true">Proceed to payment</button>
            </div> 
        </form>
    </div>
    

</div>

<?php include 'inc/footer.php' ?>
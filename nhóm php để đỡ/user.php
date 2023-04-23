<?php
include "inc/head.php";
include "func/user_handler.php";


$history_booking_table = [];
$history_order_food = [];

$history_booking_table = getHistoryBooking($_SESSION["user_id"]);
$history_order_food = getHistoryOrderFood($_SESSION['user_id']);


if(!empty($_POST['update'])){
    validateEdit($_POST, $edit_user);
}


?>

<div class="container ">
<?php
    // to set use the setMsg() fn
    if (!empty($message)) {
        echo "<div class='alert alert-{$message['class']}'>
              {$message['msg']}
            </div>";
    }
    ?>
    <div class="row">
        <div class="user col-lg-3 me-3 mt-3 ">

            <img src="images/user/Avatar.jpg" alt="Avatar" class="avatar rounded mx-auto my-3 d-block ">
            <h3 class="name orange-400 mt-1"><?= $_SESSION['L_name']." ".$_SESSION['F_name']; ?></h3>
            <?php if (isset($_SESSION['address'])) : ?>
            <h5 class="text-light mt-1"><?= $_SESSION['address']; ?></h5>
            <?php endif; ?>

            <div class="justify-content-center py-5" id="contact" >
                <button type="button" class="edit-btn" data-bs-toggle="modal" data-bs-target="#editModal" data-bs-whatever="@mdo">Edit</button>
                <div class="d-flex container1 mx-1 px-2" style="justify-content: space-between;">
                    <form action="user.php?history=booking_table" method="POST">
                        <button type="submit" name="booking_table" class="btn1" href="">History of booking tables</button>
                    </form>
                    <form action="user.php?history=order_food" method="POST">
                        <button type="submit" name="order_food" class="btn1" href="">History of order food</button>
                    </form>
                </div>
                
            </div>

            <!------------------------------- Edit name using bootstrap modal----------------------->
            <form action = "user.php" method="POST" id="editUserForm" name="edit" role="form">
                <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header position-relative">
                                <h1 class="modal-title fs-5 position-absolute top-50 start-50 translate-middle" id="exampleModalLabel">Edit</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                        
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">First Name:</label>
                                    <input type="text" class="form-control <?php checkValid("F_name", $edit_user) ?>" name="F_name" value="<?php echo $_SESSION['F_name'];?>">
                                    <div class="invalid-feedback">
                                        Must have something in here!!
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="recipient-L_name" class="col-form-label">Last Name:</label>
                                    <input type="text" class="form-control <?php checkValid("L_name", $edit_user) ?>" name="L_name" value="<?php echo $_SESSION['L_name'];?>">
                                    <div class="invalid-feedback">
                                        Must have something in here!!
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label id="recipient-address" class="col-form-label">Address:</label>
                                    <input type="text" class="form-control <?php checkValid("address", $edit_user) ?>" name="address">
                                    <div class="invalid-feedback">
                                        Must have something in here!!
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="update">Accept</button>
                            </div>
                        
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-------------------------------End of Edit Name------------------------->

    <!--------------------------------------------------View history----------------------------------------------------------->

        <!-----------------Table of booking history--------------------->
        <div class="col user-dashboard  mt-3">
        <?php if(isset($_GET['history'])): ?>
            <?php if ($_GET['history']==="booking_table" && (!empty($history_booking_table)) ):?>
                <div class="modal-content mb-3 mt-2 border-none">
                    <div class="modal-body ">
                        <table class="food-list-added-table table table-striped history-table fs-4">
                            <thead>
                                <tr>
                                    <th scope="col">Table ID</th>
                                    <th scope="col">Date of bill</th>
                                    <th scope="col">Amount of people</th>
                                    <th scope="col">Booking date</th>
                                    <th scope="col">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($history_booking_table as $item): ?>
                                <tr>
                                    <th scope="table_id"><?= $item['table_id'] ?></th>
                                    <td class="bill_date"><?= $item['bill_date'] ?></th>
                                    <td class="amount_people"><?= $item['num_people'] ?></td>
                                    <td class="booking date"><?= $item['booking_date'] ?></td>
                                    <td class="price">$5</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <!----------------------------End table----------------------->
            
            <!----------------------------Table of ordering food----------------------->
            <?php elseif($_GET['history']==="order_food"  && (!empty($history_order_food))):?>
                <div class="modal-content mb-3 mt-2 border-none">
                    <div class="modal-body ">
                        <table class="food-list-added-table table table-striped history-table fs-4">
                            <thead>
                                <tr>
                                    <th scope="col">Bill Id</th>
                                    <th scope="col">Ordering date</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                        <tbody>
                        <?php foreach($history_order_food as $item): ?>
                            <tr>
                                <th scope="name"><?= $item['id'] ?></th>
                                <td class="bill_date"><?= $item['bill_date'] ?></td>
                                <td class="food_number"><?= $item['amount'] ?></td>
                                <td class="food_amount"><?= $item['total_pay_amount'] ?></td>
                                <td class="ps-3"><button type="button" id="btn_show" data-id=<?= $item['id'] ?> class="show-detail-button btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onClick="get_history_id()">Show detail <i class="show-detail-history bi bi-info-circle ms-4"></i></button></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <hr>
            </div>
            <?php elseif(($_GET['history']==="booking_table"  && (empty($history_booking_table))) || ($_GET['history']==="order_food"  && (empty($history_order_food)))):?>
                <div>
                    <p>Sorry! Nothing here!!!</p>
                </div>
        <?php endif; ?>
    <?php endif;?>
        </div>
    </div>
</div>

<!----------------------------------Show detail modal------------------------->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-center" id="staticBackdropLabel">History detail</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body history-list">
                <table class="history-list-table table table-striped fs-4">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Amount</th>
                        </tr>
                    </thead>
                    <!-- food item in history -->
                    <tbody class="bill_food_detail">
                            
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <!-- <h4 class="total-pay m-auto ms-3">Total: $<span><?php //echo $initTotalPay ?></span></h4> -->
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="script/user.js"></script>
<?php
include "inc/footer.php";
?>
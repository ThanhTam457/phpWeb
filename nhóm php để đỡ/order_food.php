<?php
include "inc/head.php";

$foodObj = new Food($conn);

//default at load page
$foodCountList = $foodObj->getToalAmountEachFoodType();

$initTotalPay = 0.0;

foreach($_SESSION['shopping-food-cart'] as $item){
    $initTotalPay += $item['price'] * $item['count'];
}

?>

<script type="text/javascript">
    let numberFoodItemCart = <?= count($_SESSION['shopping-food-cart']) ?>;
    const foodCountList = <?= json_encode($foodCountList); ?>;
</script>

<!-- Button trigger shopping cart modal -->
<button type="button" class="shoping-cart-btn btn btn-warning p-4 position-fixed" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
    <i class="fas fa-shopping-cart fs-3"></i>
</button>

<!-- Shopping Cart Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-center" id="staticBackdropLabel">My Shopping Cart</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body food-list-added">
                <table class="food-list-added-table table table-striped fs-4">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Remove</th>
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
                                <td class="ps-3"><i class="remove-food-item fas fa-trash ms-4" onClick="removeItem(this)"></i></td>
                            </tr>
                        <?php endforeach; unset($index_food) ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <h4 class="total-pay m-auto ms-3">Total: $<span><?= $initTotalPay ?></span></h4>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <form action="payment.php?payfor=order_food" method="post">
                    <input name="order_food_check_out" type="hidden">
                    <button type="submit" class="btn btn-primary go-checkout">Checkout</button>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="main-bg-order-food">
    <div class="container text-center text-white">
        <img src="images/design_web/GoldenLogo.png" alt="">
        <h1>Food Order</h1>
        <p>The restaurant is a life savior when one doesn’t feel like cooking or wants to eat something else.</p>
        <p class="header-divider">divider</p>
    </div>
</div>

<div class="selection-categories mt-5">
    <div class="container text-center">
        <h1>Categories</h1>
        <p class="header-divider">divider</p>
        <div class="row mt-2">
            <button class="btn selection-active col-lg-3 col-sm-6" id="all food">All</button>
            <button class="btn selection-unactive col-lg-3 col-sm-6" id="main coursed">Main Courses</button>
            <button class="btn selection-unactive col-lg-3 col-sm-6" id="dessert">Desserts</button>
            <button class="btn selection-unactive col-lg-3 col-sm-6" id="beverage">Beverages</button>
        </div>
    </div>
</div>

<ul class="pagination justify-content-center mb-0"></ul>

<div class="list-food-area">
    <div class="container">
        <div class="row">

        </div>
    </div>
</div>

<ul class="pagination justify-content-center mb-0 mt-4"></ul>

<script type="text/javascript" src="script/orderfood.js"></script>

<?php
include "inc/footer.php";
?>
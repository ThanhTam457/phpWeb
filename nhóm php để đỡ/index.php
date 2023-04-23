<?php
include "inc/head.php";
?>

<!-- Main Banner Home-Page -->
<div class="container mb-5">
    <div class="row main-banner-homepage">
        <div class="col-lg-6 align-self-center mb-lg-0 mb-4">
            <p>Welcome To Our <span>Golden Restaurant</span> Website !</p>
            <div class="row">
                <a href="booking_table.php" class="col-6"><button class="btn btn-outline-warning h-100 w-100">Booking Table</button></a>
                <a href="order_food.php" class="col-6"><button type="button" class="btn btn-outline-warning h-100 w-100">Order Food</button></a>
            </div>
        </div>
        <img src="images/design_web/GoldenLogo.png" alt="Golden Logo" class="col-lg-6">
    </div>
</div> <!-- End Of Main Banner -->

<!-- Explore Food Area -->
<div class="explore-food mt-5">
    <div class="container">
        <h2 class="text-center">Our Food Dish Signaure</h2>
        <div class="d-flex justify-content-center">
            <hr class="w-10">
        </div>
        <div class="category-food-btn mb-3">
            <div class="d-flex justify-content-center">
                <button type="button" class="btn main-course-btn">Main Coursed</button>
                <button type="button" class="btn beverage-btn">Beverage</button>
            </div>
        </div>
        <div class="signature-food-showing-area">
            <div class="row main-coursed">
                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                    <div class="card">
                        <img src="images/Foods/MainCoursed/BanhMi.jpg" class="card-img-top" alt="Banh Mi image">
                        <div class="card-body text-center">
                            <p class="card-text fw-bold text-orange">3.0 $</p>
                            <h5 class="card-title">Banh Mi</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                    <div class="card">
                        <img src="images/Foods/MainCoursed/GoiCuon.jpg" class="card-img-top" alt="Spring Rolls image">
                        <div class="card-body text-center">
                            <p class="card-text fw-bold text-orange">3.5 $</p>
                            <h5 class="card-title">Spring Rolls</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                    <div class="card">
                        <img src="images/Foods/MainCoursed/Pho.jpg" class="card-img-top" alt="Pho image">
                        <div class="card-body text-center">
                            <p class="card-text fw-bold text-orange">5.0 $</p>
                            <h5 class="card-title">Pho</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                    <div class="card">
                        <img src="images/Foods/MainCoursed/SupCua.jpg" class="card-img-top" alt="Crab Soup image">
                        <div class="card-body text-center">
                            <p class="card-text fw-bold text-orange">5.0 $</p>
                            <h5 class="card-title">Crab Soup</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row beverage d-none">
                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                    <div class="card">
                        <img src="images/Foods/Beverages/TraDao.jpg" class="card-img-top" alt="Peach Tea image">
                        <div class="card-body text-center">
                            <p class="card-text fw-bold text-orange">2.0 $</p>
                            <h5 class="card-title">Peach Tea</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                    <div class="card">
                        <img src="images/Foods/Beverages/TraVai.jpg" class="card-img-top" alt="Lychee Tea image">
                        <div class="card-body text-center">
                            <p class="card-text fw-bold text-orange">2.0 $</p>
                            <h5 class="card-title">Lychee Tea</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                    <div class="card">
                        <img src="images/Foods/Beverages/TraSua.jpg" class="card-img-top" alt="Bubble Tea image">
                        <div class="card-body text-center">
                            <p class="card-text fw-bold text-orange">3.0 $</p>
                            <h5 class="card-title">Bubble Tea</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                    <div class="card">
                        <img src="images/Foods/Beverages/CaPheSua.jpg" class="card-img-top" alt="Milk Tea image">
                        <div class="card-body text-center">
                            <p class="card-text fw-bold text-orange">2.5 $</p>
                            <h5 class="card-title">Milk Tea</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- End Of Explore Food Area -->
<script src="script/mainpage.js"></script>

<?php
include "inc/footer.php";
?>
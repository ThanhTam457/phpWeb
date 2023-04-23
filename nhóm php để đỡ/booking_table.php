<?php
include "inc/head.php";
?>

<div class="container">
    <?php if ($_SESSION['logged_in']) : ?>
        <div class="bg-darksolomon">
            <div class="search-available-table">
                <div class="main-booking-section-wrapper">
                    <h2 class="text-center p-3 bg-dark text-white">SELECT DATE AND TIME FOR YOUR RESERVATION</h2>
                    <form action="booking_table.php" method="post" enctype="multipart/form-data">
                        <div class="row px-3">
                            <div class="col-xl-3 col-md-6 mt-3">
                                <h2 class="ms-2">Date:</h2>
                                <div class="position-relative date-picker-wrapper w-100">
                                    <div class="date-picker border-radius-25px position-absolute w-100 z-index-infront-all">
                                        <div class="input">
                                            <div class="result">Select Date: <input type='text' name="date-booking" class="date-booking pe-none p-0" value="<?= str_replace("-", "/", date("d-m-Y")) ?>" /></div>
                                            <button class="bg-secondary" type="button"><i class="fa fa-calendar"></i></button>
                                        </div>
                                        <div class="calendar"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6 mt-3">
                                <h2 class="ms-2">Time:</h2>
                                <div class="time-picker-section form-group">
                                    <div class='input-group date h-100 border-radius-25px' id='timepicker'>
                                        <input name="time-booking" type='text' class="time-booking form-control pe-none left-border-radius-25px ps-4" />
                                        <div class="input-group-addon w-100 h-100 position-absolute z-index-infront-all"></div>
                                        <button type="button" class="btn btn-secondary py-2 px-3 right-border-radius-25px">
                                            <i class="fas fa-clock"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-2 col-md-6 mt-3">
                                <h2 class="ms-2">People:</h2>
                                <div class="people-amount form-group d-flex border-radius-25px">
                                    <input name="amount-people-booking" type='text' class="amount-people-booking form-control pe-none left-border-radius-25px h-100 ps-4" id="spinner" value="1" />
                                    <button type="button" class="btn btn-secondary p-2 rounded-0" id="stepUp"><i class="fa-solid fa-arrow-up"></i></button>
                                    <button type="button" class="btn btn-secondary p-2 right-border-radius-25px" id="stepDown"><i class="fa-solid fa-arrow-down"></i></button>
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-6 mt-4 align-self-end">
                                <button class="btn btn-danger w-100 m-0 border-radius-25px mt-1" type="button" aria-hidden="true" onclick="get_table_data()">Check Availability</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

            <div class="booking-section"></div>

            <div class="booking-section-note p-4">
                <div class=" container ">
                    <div class="bg-light mt-4 text-center pb-3">
                        <div class="bg-dark p-4">
                            <h5 class="mb-0 text-white">Click "Check Availability" button to reveal the booking section</h5>
                        </div>
                        <img src="images/design_web/qiqi-fallen.png" alt="qiqi fallen">
                    </div>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="my-5">
            <div class="row bg-white position-relative">
                <div class="col-md-12 bg-dark">
                    <h1 class="text-white m-0 text-center p-3">Look like you have not login yet!</h1>
                </div>
                <img class="col-md-6" src="images/design_web/login-banner.png" alt="login banner">
                <div class="col-md-6 align-self-center text-center pb-4">
                    <h2 class="">Login to book the table!</h2>
                    <a href="login.php?last_visit=booking_table" class="btn btn-primary btn-lg">Go to Login</a>
                </div>
            </div>
        </div>
    <?php endif ?>
</div>

<script type="text/javascript" src="script/bookingtable.js"></script>

<?php
include "inc/footer.php";
?>
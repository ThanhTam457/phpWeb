<?php
include "inc/head.php";
?>

<body>
    <div class="container mt-5">
        <div class="row main-banner-homepage contact">
            <iframe class="col-lg-6 align-self-center p-5"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2692.6956572804993!2d106.68109885609414!3d10.762891104474834!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f1c06f4e1dd%3A0x43900f1d4539a3d!2sUniversity%20of%20Science%20-%20VNUHCM!5e0!3m2!1sen!2s!4v1642059695858!5m2!1sen!2s">
            </iframe>

            <div class="col-lg-6 align-self-center mb-lg-0 mb-4 bg-white p-5">
                <h3 class="fw-light"><i class="fa-solid fa-phone pe-2"></i>Keep in touch with <span
                        style="color: orange">Golden</span></h3>
                <hr>
                <form>
                    <?php if ($_SESSION['logged_in']) : ?>
                    <div class="form-group p-1">
                        <label>What can we help you with ?</label>
                        <textarea class="form-control form-message" placeholder="Enter here..."></textarea>
                    </div>
                    <button class="btn btn-outline-warning p-2 mt-3 w-100" font="10" type="submit" name="login"
                        value="true">Contact us</button>

                    <?php else : ?>
                    <div class="form-group p-1">
                        <label>Your name</label>
                        <input class="form-control">
                    </div>
                    <div class="form-group p-1">
                        <label>Your Phone</label>
                        <input class="form-control">
                    </div>
                    <div class="form-group p-1">
                        <label>What can we help you with ?</label>
                        <textarea class="form-control form-message" placeholder="Enter here..."></textarea>
                    </div>
                    <button class="btn btn-outline-warning p-2 mt-3 w-100" font="10" type="submit" name="login"
                        value="true">Contact us</button>
                </form>
            </div>
        </div>
        <?php endif ?>
    </div>
</body>
<script src="script/mainpage.js"></script>

<?php
include "inc/footer.php";
?>
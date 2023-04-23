<?php
include "inc/head.php";
include 'func/loginhandler.php';

if (isset($_POST['login'])) {
    if (isset($_GET['last_visit']))
        validateLogin($_POST, $login_user, $_GET['last_visit']);
    else
        validateLogin($_POST, $login_user);
}
?>
<div class="container mb-5">
    <?php
    // to set use the setMsg() fn
    if (!empty($message)) {
        echo "<div class='alert alert-{$message['class']}'>
              {$message['msg']}
            </div>";
    }
    ?>
    <div class="row main-banner-homepage">
        <img src="images/design_web/GoldenLogo.png" alt="Golden Logo" class="col-lg-6">
        <div class="col-lg-6 align-self-center mb-lg-0 mb-4 bg-white p-5">
            <h3 class="fw-light">Login to Account</h3>
            <hr>
            <form action="login.php<?php if (isset($_GET['last_visit'])) echo "?last_visit=" . $_GET['last_visit'] ?>" method="post">
                <div class="form-group">
                    <input type="number" class="phone-number-input form-control my-4" placeholder="Enter phone number..." name="phone_num" autocomplete="off" onkeydown="return event.keyCode !== 69">
                    <div class="invalid-feedback">
                        Phone number invalid
                    </div>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control my-4" placeholder="Enter a password..." name="password">
                    <div class="invalid-feedback">
                        Password invalid!
                    </div>
                </div>
                <button class="btn btn-outline-danger p-2 mt-3 w-100" type="submit" name="login" value="true">Continue</button>
                <div class="a-divider a-divider-break mt-3">
                    <hr class="mt-5 mb-0">
                    <h6 class="mt-0 text-center">Don't have an account?</h6>
                    <a href="signup.php<?php if (isset($_GET['last_visit'])) echo "?last_visit=" . $_GET['last_visit'] ?>" class="btn btn-outline-success mt-2 p-2 w-100" type="submit" name="Sign up" value="true">Sign up</a>
                </div>

            </form>
        </div>
    </div>
</div>

<?php
include "inc/footer.php";
?>
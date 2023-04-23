<?php
include "inc/head.php";
include "func/loginhandler.php";
if (isset($_POST['create'])) {
    if (isset($_GET['last_visit']))
        validateNewUser($_POST, $new_user, $_GET['last_visit']);
    else
        validateNewUser($_POST, $new_user);
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
    <div class="row main-banner-signup">
        <img src="images/design_web/GoldenLogo.png" alt="Golden Logo" class="col-lg-6">
        <div class="col-lg-6 align-self-center mb-lg-0 mb-4 bg-white p-4">
            <h3 class="fw-light">Create Account</h3>
            <hr>
            <form action="signup.php" method="post">
                <div class="form-group">
                    <label for="F_name" style="font-weight:700">First name</label>
                    <input type="text" class="form-control my-2" name="F_name" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="L_name" style="font-weight:700">Last name</label>
                    <input type="text" class="form-control my-2" name="L_name" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="phone_num" style="font-weight:700">Mobile number</label>
                    <input type="number" class="form-control my-2 phone-number-input <?php checkValid("phone_num", $new_user) ?>" name="phone_num" onkeydown="return event.keyCode !== 69">
                    <div class="invalid-feedback">
                        Phone number invalid!
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" style="font-weight:700">Password</label>
                    <input type="password" class="form-control my-2 <?php checkValid("password", $new_user) ?>" placeholder="At least 5 characters" name="password">
                    <div class="invalid-feedback">
                        Password invalid!
                    </div>
                </div>
                <div class="form-group">
                    <label for="password_confirm" style="font-weight:700">Re-enter password</label>
                    <input type="password" class="form-control my-2 <?php checkValid("password_confirm", $new_user) ?>" name="password_confirm">
                    <div class="invalid-feedback">
                        Password don't match!
                    </div>
                </div>
                <button class="btn btn-outline-danger p-2 mt-3 w-100" type="submit" name="create" value="true">Continue</button>
                <div class="a-divider a-divider-break mt-3">
                    <hr class="mt-5">
                    <h6 class="mt-3">Already have an account? <a href="login.php<?php if (isset($_GET['last_visit'])) echo "?last_visit=" . $_GET['last_visit'] ?>" class="text-decoration-none ms-1">Login <i class="fa-solid fa-caret-right"></i></a></h6>
                </div>

            </form>
        </div>
    </div>
</div>

<?php
include "inc/footer.php";
?>
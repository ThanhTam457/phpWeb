<?php
include "func/init.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <script>
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }
  </script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Group Restaurant Team</title>

  <!-- Plz remember, always write css after bootstrap to overwrite it -->

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet" />
  <!-- BootStrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

  <!-- CSS Files -->
  <link href="style.css" rel="stylesheet">

  <!-- Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link href="http://fonts.cdnfonts.com/css/telegrafico" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Thasadith&display=swap" rel="stylesheet">

  <!-- jquery script -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js" type="text/javascript"></script>
  <script type="text/javascript" src="script/import plugin/jquery.twbsPagination.js"></script>
  <script type="text/javascript" src="script/import plugin/jquery.twbsPagination.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-toaster@4.0.1/css/bootstrap-toaster.css"/>
  <script src="script/jqueryPassiveaAddEventListenner.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js" type="text/javascript"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
</head>

<body>
  <!-- Header,NavBar -->
  <nav class="navbar navbar-expand-xl">
    <div class="container">
      <!-- hamburguer button -->
      <button class="navbar-toggler navbar-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <a class="nav-item navbar-brand nav-link px-2 title" href="index.php">Golden</a>

      <div class="collapse navbar-collapse justify-content-end" id="navbarToggler">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active pe-3 home" aria-current="page" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link home pe-3" aria-current="page" href="order_food.php">Menu</a>
          </li>
          <li class="nav-item">
            <a class="nav-link home pe-3" aria-current="page" href="our-story.php">Our Story</a>
          </li>
          <li class="nav-item">
            <a class="nav-link home pe-3 me-4" aria-current="page" href="contact.php">Contact</a>
          </li>
          <?php if ($_SESSION['logged_in'] == true) : ?>
            </li>
            <a class="nav-link home pe-3 me-4" href="user.php"><i class="fa fa-user-circle" aria-hidden="true"></i>
              <?= $_SESSION['L_name']; ?><span class="sr-only">(current)</span></a>
            </li>
            </li>
            <a class="nav-link home Login-BT" href="logout.php">Logout<span class="sr-only">(current)</span></a>
            </li>
          <?php else : ?>
            <li class="nav-item">
              <a class="nav-link home me-3 SignUp-BT mb-3 mb-xl-0" aria-current="page" href="signup.php">Sign-up</a>
            </li>
            <li class="nav-item">
              <a class="nav-link home Login-BT" aria-current="page" href="login.php">Login</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
  <!-- End Header -->
  
  <?php sessionMsg() ?>
<?php
if (!isset($_GET['view'])) {
    header('Location: admin_panel.php?view=home');
}
include "func/init.php";

$reservationObj = new Reservation($conn);
$foodObj = new Food($conn);
$billObj = new Bill($conn);
$accountObj = new Account($conn);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- jquery script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js" type="text/javascript"></script>
    <!-- CSS Files -->
    <link href="dashboardstyle.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet" />
    <!-- BootStrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <!-- pagination -->
    <script type="text/javascript" src="script/import plugin/jquery.twbsPagination.js"></script>
    <script type="text/javascript" src="script/import plugin/jquery.twbsPagination.min.js"></script>

    <!-- Toast Notify -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-toaster@4.0.1/css/bootstrap-toaster.css" />

    <!-- Chart JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0-rc.1/chartjs-plugin-datalabels.js"></script>
</head>

<body>
    <?php if (!$_SESSION['logged_in'] || false && $_SESSION['role'] == 3) : ?>
        <div class="access-denied text-center bg-warning">
            <h1>403</h1>
            <div class="txt">
                <h1 class="ms-4">Access Denied<span class="blink">_</span></h1>
            </div>
            <img src="images/design_web/access-denied.png" class="mt-3" alt="">
        </div>
    <?php else : ?>
        <div class="container-fluid bg-oldlace">
            <div class="row flex-nowrap">
                <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
                    <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                        <a href="#" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                            <span class="fs-5 d-none d-sm-inline">Admin Menu</span>
                        </a>
                        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                            <li class="nav-item">
                                <a href="admin_panel.php?view=home" class="nav-link align-middle px-0">
                                    <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Home</span>
                                </a>
                            </li>
                            <li>
                                <a href="admin_panel.php?view=dashboard" class="nav-link px-0 align-middle">
                                    <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline">Dasboard</span></a>
                            </li>
                            <li>
                                <a href="admin_panel.php?view=reservation" class="nav-link px-0 align-middle">
                                    <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Reservations</span></a>
                            </li>
                            <li>
                                <a href="admin_panel.php?view=order" class="nav-link px-0 align-middle">
                                    <i class="fs-4 bi-inboxes"></i> <span class="ms-1 d-none d-sm-inline">Orders</span></a>
                            </li>
                            <li>
                                <a href="admin_panel.php?view=product" class="nav-link px-0 align-middle">
                                    <i class="fs-4 bi-grid"></i> <span class="ms-1 d-none d-sm-inline">Products</span></a>
                            </li>
                            <li>
                                <a href="admin_panel.php?view=customer" class="nav-link px-0 align-middle">
                                    <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline">Customers</span> </a>
                            </li>
                        </ul>
                        <hr>

                    </div>
                </div>
                <div class="col py-3 overflow-auto">
                    <?php switch ($_GET['view']):
                        case "home": ?>
                            <div id="home" class="text-center">
                                <h2>Welcome back <span class="text-danger"><?= $_SESSION['F_name'] . " " .  $_SESSION['L_name'] . " !" ?><span></h2>
                                <img src="images/design_web/welcome_robot.png" alt="" srcset="" id="hello-robot">
                                <h3>Your role is <span class="text-primary"><?php if ($_SESSION['role'] == 1) echo "administrator";
                                                                            else echo "epmloyee"; ?></span></h3>
                            </div>
                            <?php break; ?>
                        <?php
                        case "dashboard":
                            $totalFoodSold = $foodObj->getTotalFoodSold();
                            $totalTableSold = $reservationObj->getTotalTableBooked();
                            $totalEarnings = $billObj->getTotalEarnings();
                            $totalAccounts = $accountObj->getTotalAccounts();
                            $totalEachFoodTypeSold = $foodObj->foodOrderedEachType();
                            $foodStatistic = $foodObj->food_trending();
                            $foodNotSoldYet = $foodObj->getFoodNotSoldYet();
                        ?>
                            <script type="text/javascript">
                                const totalEachFoodTypeSold = <?= json_encode($totalEachFoodTypeSold); ?>;
                            </script>
                            <div class="dashboard-area px-2">
                                <h1 class="mb-3 text-center">Dashboard</h1>
                                <div class="row">
                                    <div class="col-lg-3 col-sm-6 food-item-sale px-3 mb-3">
                                        <div class="d-flex bg-powderblue justify-content-between align-content-center align-items-center p-4 border-radius-25px h-100">
                                            <i class="fas fa-shopping-bag fs-1"></i>
                                            <div class="d-block text-end">
                                                <span class="food-sale-total fs-4 fw-bold"><?= $totalFoodSold ?></span>
                                                <p class="p-0 m-0 text-muted">Food Sold</p>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-lg-3 col-sm-6 food-item-sale px-3 mb-3">
                                        <div class="d-flex bg-mediumspringgreen justify-content-between align-content-center align-items-center p-4 border-radius-25px h-100">
                                            <i class="fas fa-table fs-1"></i>
                                            <div class="d-block text-end">
                                                <span class="reservation-total fs-4 fw-bold"><?= $totalTableSold ?></span>
                                                <p class="p-0 m-0 text-muted">Table Booked</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-sm-6 food-item-sale px-3 mb-3">
                                        <div class="d-flex bg-plum justify-content-between align-content-center align-items-center p-4 border-radius-25px h-100">
                                            <i class="fas fa-tag fs-1"></i>
                                            <div class="d-block text-end">
                                                <span class="earning-total fs-4 fw-bold">$ <?= round($totalEarnings, 2) ?></span>
                                                <p class="p-0 m-0 text-muted">Earnings</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-sm-6 food-item-sale px-3 mb-3">
                                        <div class="d-flex bg-lightcoral justify-content-between align-content-center align-items-center p-4 border-radius-25px h-100">
                                            <i class="fas fa-users fs-1"></i>
                                            <div class="d-block text-end">
                                                <span class="account-total fs-4 fw-bold"><?= $totalAccounts ?></span>
                                                <p class="p-0 m-0 text-muted">Accounts</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row graph-area mt-3">
                                    <div class="chart-container table-rate col-md-6 col-xl-5 mb-4 mb-md-0">
                                        <canvas id="myChart"></canvas>
                                    </div>
                                    <div class="col-md-6 col-xl-7 align-self-center">
                                        <div class="block-content block-content-full text-center bg-secondary border-radius-top-25px">
                                            <h5 class="fs-lg fw-semibold text-white py-3 mb-0">Food Trending</h5>
                                        </div>
                                        <div class="block-content block-content-full bg-white">
                                            <table class="table table-borderless table-striped table-hover mb-0 fs-sm">
                                                <tbody>
                                                    <tr>
                                                        <td class="fw-medium ps-3">Top Choices:</td>
                                                        <td class="text-center">
                                                            <span class="fw-semibold text-primary"><?= $foodStatistic['top_choices'] ?></span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-medium ps-3">Least Favorites:</td>
                                                        <td class="text-center">
                                                            <span class="fw-semibold text-danger"><?= $foodStatistic['least_favorite'] ?></span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-medium ps-3">Most Profitable:</td>
                                                        <td class="text-center">
                                                            <span class="fw-semibold text-success"><?= $foodStatistic['most_profitable'] ?></span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-medium ps-3">Low Profitable:</td>
                                                        <td class="text-center">
                                                            <span class="fw-semibold text-warning"><?= $foodStatistic['low_profitable'] ?></span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <p class="text-muted mt-3 mb-0">
                                            *Note: data above is only count for any food that had been sold as least one time. There are maybe <a class="text-decoration-underline text-primary" data-bs-toggle="tooltip" title="" data-bs-original-title="<?php $i = 0;
                                            if (!empty($foodNotSoldYet)) {
                                                foreach ($foodNotSoldYet as $eachFood) {
                                                    if ($i < count($foodNotSoldYet) - 1)
                                                        echo $eachFood['name'] . ", ";
                                                    else
                                                        echo $eachFood['name'] . ".";
                                                    $i++;
                                                }
                                            }
                                            else echo "All of your product has been sold, congrat ^o^";
                                            ?>">some food product that has not sold</a> yet!</p>
                                    </div>
                                </div>
                            </div>
                            <?php break; ?>
                        <?php
                        case "reservation":
                            //default at start page                            
                            $reservationCount = $reservationObj->getCountReservation();
                        ?>
                            <script type="text/javascript">
                                const reservationCountList = <?= json_encode($reservationCount); ?>;
                            </script>
                            <div class="list-reservation overflow-auto" style="max-height: 88vh;">
                                <h2>Reservation List</h2>
                                <div class="d-flex align-items-baseline">
                                    <p class="me-2">Select Status:</p>
                                    <select class="form-select w-auto my-2" aria-label="Default select example" onchange="chagenViewStatusReservation(this.value)">
                                        <option value="0" selected>unconfirm</option>
                                        <option value="1">confirm</option>
                                    </select>
                                </div>
                                <table class="table table-striped fs-4">
                                    <thead>
                                        <tr class="fs-6">
                                            <th scope="col">Date</th>
                                            <th scope="col">Time</th>
                                            <th scope="col">People</th>
                                            <th scope="col">Table No.</th>
                                            <th scope="col">Customer</th>
                                            <th scope="col">Phone Number</th>
                                            <th scope="col">Status</th>
                                            <th scope="col" class="reservation-action-column">Action</th>
                                        </tr>
                                    </thead>
                                    <!-- list of reservation -->
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <?php break; ?>
                        <?php
                        case "order": ?>
                            <div>order</div>
                            <?php break; ?>
                        <?php
                        case "product": ?>
                            <div>product</div>
                            <?php break; ?>
                        <?php
                        case "customer": ?>
                            <div>customer</div>
                            <?php break; ?>
                        <?php
                        default: ?>
                            <div>invalid item menu</div>
                            <?php break; ?>
                    <?php endswitch; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <ul class="pagination justify-content-center bottom-0 position-fixed flex-wrap me-4"></ul>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap-toaster@4.0.1/js/bootstrap-toaster.js"></script>
    <script type="text/javascript">
        Toast.setTheme(TOAST_THEME.LIGHT);
        Toast.setPlacement(TOAST_PLACEMENT.BOTTOM_LEFT);
        Toast.setMaxCount(3);
    </script>
</body>

<footer>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
</script>
<script src="script/adminpannel.js"></script>

</html>
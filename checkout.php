<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
include_once 'product-action.php';
error_reporting(0);
session_start();
if(empty($_SESSION["user_id"]))
{
	header('location:login.php');
}
else {
    $item_total = 0; // Initialize item_total variable

    // Calculate total price of items in the cart
    foreach ($_SESSION["cart_item"] as $item) {
        $item_total += ($item["price"] * $item["quantity"]);
    }

    // Process payment if form is submitted
    if(isset($_POST['submit'])) {
        foreach ($_SESSION["cart_item"] as $item) {
            if($_POST['mod'] == 'COD') {
                // Handle Cash on Delivery logic
                $SQL = "INSERT INTO users_orders (u_id, title, quantity, price) VALUES ('".$_SESSION["user_id"]."', '".$item["title"]."', '".$item["quantity"]."', '".$item["price"]."')";
                mysqli_query($db, $SQL);
                $success = "Thank you! Your order has been placed successfully!";
            } elseif($_POST['mod'] == 'paypal') {
                // Handle PayPal logic
                // Redirect to PayPal payment page or process payment here
                // Example redirection:
                header('location: paypal_payment.php');
                exit;
            } elseif($_POST['mod'] == 'gpay' || $_POST['mod'] == 'paytm' || $_POST['mod'] == 'phonepe') {
                // Handle Indian payment gateways (GPay, Paytm, PhonePe) logic
                // Implement the respective API integrations for these gateways
                // Example: Redirect to respective payment processing page
                // Replace with actual integration logic
                header('location: online_pay.php?method='.$_POST['mod']);
                exit;
            }
        }
    }
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title>Checkout</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet"> </head>
<body>
    
    <div class="site-wrapper">
        <!--header starts-->
        <header id="header" class="header-scroll top-header headrom">
            <!-- .navbar -->
            <nav class="navbar navbar-dark">
                <div class="container">
                    <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#mainNavbarCollapse">&#9776;</button>
                    <a class="navbar-brand" href="index.html"> <img class="img-rounded" src="images/food-picky-logo1.png" alt=""> </a>
                    <div class="collapse navbar-toggleable-md  float-lg-right" id="mainNavbarCollapse">
                        <ul class="nav navbar-nav">
                            <li class="nav-item"> <a class="nav-link active" href="index.php">Home <span class="sr-only">(current)</span></a> </li>
                            <li class="nav-item"> <a class="nav-link active" href="restaurants.php">Restaurants <span class="sr-only"></span></a> </li>
                            
                            <?php
                            if(empty($_SESSION["user_id"])) {
                                echo '<li class="nav-item"><a href="login.php" class="nav-link active">Login</a></li>
                                      <li class="nav-item"><a href="registration.php" class="nav-link active">Signup</a></li>';
                            } else {
                                echo '<li class="nav-item"><a href="your_orders.php" class="nav-link active">Your Orders</a></li>';
                                echo '<li class="nav-item"><a href="logout.php" class="nav-link active">Logout</a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- /.navbar -->
        </header>
        <div class="page-wrapper">
            <div class="top-links">
                <div class="container">
                    <ul class="row links">
                        <li class="col-xs-12 col-sm-4 link-item"><span>1</span><a href="restaurants.php">Choose Restaurant</a></li>
                        <li class="col-xs-12 col-sm-4 link-item"><span>2</span><a href="#">Order Food</a></li>
                        <li class="col-xs-12 col-sm-4 link-item active"><span>3</span><a href="checkout.php">Pay and Order</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="container">
                <span style="color:green;">
                    <?php echo $success; ?>
                </span>
            </div>
            
            <div class="container m-t-30">
                <form action="" method="post">
                    <div class="widget clearfix">
                        <div class="widget-body">
                            <form method="post" action="#">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="cart-totals margin-b-20">
                                            <div class="cart-totals-title">
                                                <h4>Cart</h4>
                                            </div>
                                            <div class="cart-totals-fields">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td>Subtotal</td>
                                                            <td><?php echo "Rs".$item_total; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Delivery Charges</td>
                                                            <td>Free</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-color"><strong>Total</strong></td>
                                                            <td class="text-color"><strong><?php echo "Rs".$item_total; ?></strong></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- Payment options and submit button -->
                                        <div class="payment-option">
                                            <ul class="list-unstyled">
                                                <li>
                                                    <label class="custom-control custom-radio m-b-20">
                                                        <input name="mod" id="radioStacked1" checked value="COD" type="radio" class="custom-control-input">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">Cash on Delivery</span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="custom-control custom-radio m-b-10">
                                                        <input name="mod" type="radio" value="gpay" class="custom-control-input">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">GPay</span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="custom-control custom-radio m-b-10">
                                                        <input name="mod" type="radio" value="paytm" class="custom-control-input">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">Paytm</span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="custom-control custom-radio m-b-10">
                                                        <input name="mod" type="radio" value="phonepe" class="custom-control-input">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">PhonePe</span>
                                                    </label>
                                                </li>
                                            </ul>
                                            <p class="text-xs-center">
                                                <input type="submit" onclick="return confirm('Are you sure?');" name="submit" class="btn btn-outline-success btn-block" value="Pay Now">
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </form>
            </div>
            
            <section class="app-section">
                <div class="app-wrap">
                    <div class="container">
                        <div class="row text-img-block text-xs-left">
                            <div class="container">
                                <div class="col-xs-12 col-sm-5 right-image text-center">
                                    <figure> <img src="images/app.png" alt="Right Image" class="img-fluid"> </figure>
                                </div>
                                <div class="col-xs-12 col-sm-7 left-text">
                                    <h3>Order Food Now!</h3>
                                    <div class="social-btns">
                                        <a href="https://www.apple.com/in/store" class="app-btn apple-button clearfix">
                                            <div class="pull-left"><i class="fa fa-apple"></i> </div>
                                            <div class="pull-right"> <span class="text">Available on the</span> <span class="text-2">App Store</span> </div>
                                        </a>
                                        <a href="https://play.google.com/store/apps?hl=en" class="app-btn android-button clearfix">
                                            <div class="pull-left"><i class="fa fa-android"></i> </div>
                                            <div class="pull-right"> <span class="text">Available on the</span> <span class="text-2">Play store</span> </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- start: FOOTER -->
            <footer class="footer">
                <div class="container">
                    <!-- top footer statrs -->
                    <div class="row top-footer">
                        <div class="col-xs-12 col-sm-3 footer-logo-block color-gray">
                            <a href="index.php"> <img src="images/food-picky-logo1.png" alt="Footer logo"> </a> <span>Order Delivery &amp; Take-Out </span> </div>
                        <div class="col-xs-12 col-sm-2 about color-gray">
                            <h5>About Us</h5>
                            <ul>
                                <li><a href="about-us.php">About us</a> </li>
                                <li><a href="history.php">History</a> </li>
                                <li><a href="our-team.php">Our Team</a> </li>
                                <li><a href="we-are-hiring.php">We are hiring</a> </li>
                            </ul>
                        </div>
                        <div class="col-xs-12 col-sm-2 how-it-works-links color-gray">
                            <h5>How it Works</h5>
                            <ul>
                                <li><a href="restaurants.php">Choose restaurant</a> </li>
                                <li><a href="your_orders.php">Choose food</a> </li>
                                <li><a href="checkout.php">Pay via credit card</a> </li>
                            </ul>
                        </div>
                        <div class="col-xs-12 col-sm-2 pages color-gray">
                            <h5>Pages</h5>
                            <ul>
                                <li><a href="login.php">User Sign Up Page</a> </li>
                                <li><a href="checkout.php">Make order</a> </li>
                                <li><a href="checkout.php">Add to cart</a> </li>
                            </ul>
                        </div>
                        <div class="col-xs-12 col-sm-3 popular-locations color-gray">
                            <h5>Top Locations</h5>
                            <ul>
                                <li><a href="https://www.google.com/maps?q=Jammu" target="_blank">Jammu</a></li>
                                <li><a href="https://www.google.com/maps?q=Udhampur" target="_blank">Udhampur</a></li>
                                <li><a href="https://www.google.com/maps?q=Reasi" target="_blank">Reasi</a></li>
                                <li><a href="https://www.google.com/maps?q=Dehradun" target="_blank">Dehradun</a></li>
                                <li><a href="https://www.google.com/maps?q=New+Delhi" target="_blank">New Delhi</a></li>
                                <li><a href="https://www.google.com/maps?q=Srinagar" target="_blank">Srinagar</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- top footer ends -->
                    <!-- bottom footer statrs -->
                    <div class="bottom-footer">
                        <div class="row">
                            <div class="col-xs-12 col-sm-3 payment-options color-gray">
                                <h5>Pay Options</h5>
                                <ul>
                                    <li>
                                        <a href="#"> <img src="images/paypal.png" alt="Paypal"> </a>
                                    </li>
                                    <li>
                                        <a href="#"> <img src="images/mastercard.png" alt="Mastercard"> </a>
                                    </li>
                                    <li>
                                        <a href="#"> <img src="images/maestro.png" alt="Maestro"> </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-xs-12 col-sm-4 address color-gray">
                                <a href="https://www.google.com/maps/place/Karan+Nagar,+Udhampur+182101/@32.9187219,75.1391184,15z/data=!3m1!4b1!4m15!1m8!3m7!1s0x391dd2bf6294ee91:0xe536574cfe583d14!2sUdhampur+182101!3b1!8m2!3d32.9159847!4d75.1416173!16zL20vMDV6aDJj!3m5!1s0x391dd2bd43249c97:0x263aa7d5c7a0aa23!8m2!3d32.9192156!4d75.1384848!16s%2Fg%2F11h08chtt?entry=ttu">Address
                                <p>Food Treasure by Arun , Udhampur(182101) Jammu and Kashmir</p>
                            </div>
                            <div>
                                <h5>Phone: <a href="tel:+916006176359">+91 6006176359</a></h5> </div>
                            </div>
                        </div>
                    </div>
                    <!-- bottom footer ends -->
                </div>
            </footer>
            <!-- end:Footer -->
        </div>
        <!-- end:page wrapper -->
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="js/jquery.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/animsition.min.js"></script>
    <script src="js/bootstrap-slider.min.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/headroom.js"></script>
    <script src="js/foodpicky.min.js"></script>
</body>
</html>

<?php
}
?>

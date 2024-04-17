<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>Filter</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" type="text/css" href="css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="images/fevicon.png" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <!-- fonts -->
      <link href="https://fonts.googleapis.com/css?family=Great+Vibes|Open+Sans:400,700&display=swap&subset=latin-ext" rel="stylesheet">
      <!-- owl stylesheets --> 
      <link rel="stylesheet" href="css/owl.carousel.min.css">
      <link rel="stylesheet" href="css/owl.theme.default.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
      <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
   </head>
<body>
    <!-- header section start -->
      <div class="header_section">
         <div class="container-fluid">
            <nav class="navbar navbar-light bg-light justify-content-between">
               <div id="mySidenav" class="sidenav">
                  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                  <a href="index.php">Home</a>
                  <a href="products.php">Products</a>
                  <a href="about.html">About</a>
                  <!-- <a href="client.html">Client</a> -->
                  <a href="contact.html">Contact</a>
               </div>
               <span class="toggle_icon" onclick="openNav()"><img src="images/toggle-icon.png"></span>
               <a class="logo" href="index.php"><img src="images/logo.png"></a></a>
               <form class="form-inline ">
                  <div class="login_text">
                     <ul>
                        <li><a href="#"><img src="images/user-icon.png"></a></li>
                        <!--
                        <li><a href="#"><img src="images/bag-icon.png"></a></li>
                        <li><a href="#"><img src="images/search-icon.png"></a></li>
                        -->
                     </ul>
                  </div>
               </form>
            </nav>
         </div>
      </div>
      <!-- header section end -->

      <div class="about_section layout_padding">
         <div class="container">
            <div class="about_section_main">
               <div class="row">
                  <div class="col-md-6">
                     <div class="filter_main">

    <h1>Make your choice</h1>

    <?php
    // to be modified or read from database
    $variations = array(
        array(
            'productId' => 'p1',
            'color' => 'Red',
            'size' => 'Small',
            'price' => 19.99
        ),
        array(
            'productId' => 'p2',
            'color' => 'Blue',
            'size' => 'Medium',
            'price' => 24.99
        ),
        array(
            'productId' => 'p3',
            'color' => 'Green',
            'size' => 'Large',
            'price' => 29.99
        )
    );

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['variation'])&&isset($_POST['quantity']))
        {
        // Get selected variation ID and quantity
        $selectedVariationId = $_POST['variation'];
        $quantity = $_POST['quantity'];
            // Validate and process the data
        if (!empty($selectedVariationId) && is_numeric($quantity) && $quantity > 0) {
            // Redirect to cart.php with the selected variation ID and quantity as query parameters
            header("Location: cart.php?productId=" . urlencode($selectedVariationId) . "&quantity=" . urlencode($quantity));
            exit();
        } else {
            echo "Invalid input. Please select a variation and enter a valid quantity.";
        }
        }
        
    }
    ?>

    <form method="POST" action="">
        <?php foreach ($variations as $variation) : ?>
            <div class="<?php echo isset($_POST['variation']) && $_POST['variation'] === $variation['productId'] ? 'selected' : ''; ?>">
                <input type="radio" name="variation" value="<?php echo $variation['productId']; ?>" <?php echo isset($_POST['variation']) && $_POST['variation'] === $variation['productId'] ? 'checked' : ''; ?>>
                <?php echo $variation['color'] . ' - ' . $variation['size'] . ' - $' . $variation['price']; ?>
            </div>
        <?php endforeach; ?>
        
        <br>

        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" id="quantity" min="1" value="1">
        <br>
        <input type="submit" value="Confirm">
    </form>

                    </div>
                  </div>
                  
               </div>
            </div>
         </div>
      </div>

      <!-- footer section start -->
      <div class="footer_section layout_padding">
         <div class="container">
            <div class="footer_logo"><a href="index.php"><img src="images/footer-logo.png"></a></div>
            <div class="contact_section_2">
               <div class="row">
                  <div class="col-sm-4">
                     <h3 class="address_text">Contact Us</h3>
                     <div class="address_bt">
                        <ul>
                           <li>
                              <a href="#">
                              <i class="fa fa-map-marker" aria-hidden="true"></i><span class="padding_left10">Address : Cityu</span>
                              </a>
                           </li>
                           <li>
                              <a href="#">
                              <i class="fa fa-phone" aria-hidden="true"></i><span class="padding_left10">Call : +852 1234567890</span>
                              </a>
                           </li>
                           <li>
                              <a href="#">
                              <i class="fa fa-envelope" aria-hidden="true"></i><span class="padding_left10">Email : abc@gmail.com</span>
                              </a>
                           </li>
                        </ul>
                     </div>
                  </div>
                  <!--
                  <div class="col-sm-4">
                     <div class="footer_logo_1"><a href="index.php"><img src="images/footer-logo.png"></a></div>
                     <p class="dummy_text">commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non</p>
                  </div>
                  <div class="col-sm-4">
                     <div class="main">
                        <h3 class="address_text">Best Products</h3>
                        <p class="ipsum_text">dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non</p>
                     </div>
                  </div>
                  -->
               </div>
            </div>
            <!--
            <div class="social_icon">
               <ul>
                  <li>
                     <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                  </li>
                  <li>
                     <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                  </li>
                  <li>
                     <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                  </li>
                  <li>
                     <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                  </li>
               </ul>
            </div>
            -->
         </div>
      </div>
      <!-- footer section end -->
      <!-- Javascript files-->
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <script src="js/plugin.js"></script>
      <!-- sidebar -->
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="js/custom.js"></script>
      <!-- javascript --> 
      <script src="js/owl.carousel.js"></script>
      <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>  
      <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
      <script>
         function openNav() {
           document.getElementById("mySidenav").style.width = "100%";
         }
         
         function closeNav() {
           document.getElementById("mySidenav").style.width = "0";
         }
      </script> 
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Purchase Summary</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
    <style>
   
        .container-fluid {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar-brand img {
            max-height: 20px;
        }

        .navbar {
            font-size: 1.8em;
        }

        .nav-item.nav-link {
            padding: 0 1em;
        }

        .contact_section {
            background-color: #f5f0eb;
            padding: 50px 0;
            display: flex;
            justify-content: center;
        }

        .box {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 40px;
            margin: 40px auto;
            width: 80%;
            max-width: 500px;
        }

        .container-fluid {
            background-color: #f5f0eb;
            padding: 10px 20px;
            margin-bottom: 40px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 40px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .contact_section {
            background-color: #f5f0eb;
            padding: 50px 0;
            margin-top: 50px;
        }

        .btn-space {
            margin-top: 20px;
        }

        .custom-button {
            background-color: #303b53;
            color: white;
            border: none;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
        }

        /* 新添加的样式 */
        .form-container h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: none;
            font-size: 16px;
        }

        .form-container textarea {
            height: 150px;
        }

        .form-container button {
            background-color: #303b53;
            color: white;
            border: none;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-container button:hover {
            background-color: #24303f;
        }

        /* 新添加的样式 */
        .contact-section {
            text-align: center;
            margin-top: 50px;
        }

        .contact-section h2 {
            margin-bottom: 20px;
        }

        .contact-section p {
            margin-bottom: 10px;
        }

        .back-button {
            margin-top: 20px;
        }

        .back-button a {
            background-color: #303b53;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .back-button a:hover {
            background-color: #24303f;
        }
    </style>
</head>
<body>

<!-- 顶部导航栏 -->
<div class="container-fluid">
    <!-- Logo placed on the left side -->
    <a class="navbar-brand" href="index.php"><img src="images/logo.png" alt="Logo"></a>

    <!-- Navigation links placed on the right side -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-end">
        <div class="navbar-nav">
            <a class="nav-item nav-link" href="index.php">Home</a>
            <a class="nav-item nav-link" href="products.php">Products</a>
            <a class="nav-item nav-link" href="about.html">About</a>
            <a class="nav-item nav-link" href="contact.html">Contact</a>
        </div>
    </nav>
</div>

<div class="storageVolumes clearfix control_main_disk_right" ng-controller="buySucceedCtrl">
    <div class="buySucceedBox">
        <img src="images/storage/v3-buySucceed-icon.png" alt="" />
        <strong>Purchase Successful!</strong>
        <p>Total Price: $<?php echo $total; ?></p>
        <p><span class="js-wait"></span>10s to automatically redirect to the console</p>
    </div>

    <div class="back-disk-console">
        <a href="http://localhost" class="custom-button">Back</a>
    </div>
</div>

<div class="contact_section layout_padding">
    <div class="container">
        <div class="form-container">
            <h1>Contact Us</h1>
            <form>
                <input type="text" name="name" placeholder="Your Name" required><br>
                <input type="email" name="email" placeholder="Your Email" required><br>
                <textarea placeholder="Your Message" required></textarea><br>
                <button type="submit" class="custom-button">Submit</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>

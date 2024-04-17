<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['identity']) || $_SESSION['identity'] !== 'admin') {
    // If not admin, redirect to login page
    header("Location: login.php");
    exit;
}

// Define the path to the products file and the images directory
$productsFile = 'products.txt';
$imagesDirectory = 'images/';

// Function to read products from the file
function readProducts($filename) {
    $products = [];
    $file = fopen($filename, 'r');
    while (($line = fgetcsv($file)) !== FALSE) {
        $products[] = [
            'name' => $line[0],
            'description' => $line[1],
            'price' => $line[2],
            'detailsPage' => $line[3],
            'image' => $line[4]
        ];
    }
    fclose($file);
    return $products;
}

// Function to save products to the file
function saveProducts($filename, $products) {
    $file = fopen($filename, 'w');
    foreach ($products as $prod) {
        fputcsv($file, $prod);
    }
    fclose($file);

    $file = fopen($filename, 'w');
    if ($file) {
        foreach ($products as $prod) {
            // Remove double quotes from each field and concatenate them with a comma
            $line = implode(',', array_map(function($field) {
                return str_replace('"', '', $field);
            }, $prod));
            fwrite($file, $line . "\n"); // Add newline character at the end of each line
        }
        fclose($file);
    } else {
        die("Failed to open products file for writing.");
    }
}

$products = readProducts($productsFile);

// Handling form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add']) || isset($_POST['update'])) {
        // Process file upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $uploadDir = $imagesDirectory;
            $tmpName = $_FILES['image']['tmp_name'];
            $fileName = basename($_FILES['image']['name']);
            $uploadFile = $uploadDir . $fileName;

            // Ensure the file is an image
            if (getimagesize($tmpName)) {
                move_uploaded_file($tmpName, $uploadFile);
            } else {
                die("File is not an image.");
            }
        } else {
            $uploadFile = $_POST['existingImage']; // In case of update without changing the image
        }

        // Collecting other post data and handling add/update
        $productData = [
            $_POST['name'],
            $_POST['description'],
            $_POST['price'],
            $_POST['detailsPage'],
            $uploadFile  // Save the path of the uploaded image
        ];

        // Validate input fields
        if (empty($_POST['name']) || empty($_POST['description']) || empty($_POST['price']) || empty($_POST['detailsPage']) || empty($_FILES['image']['name'])) {
            echo "<script>alert('All fields are required.')</script>";
        } else {
            if (isset($_POST['add'])) {
                $products[] = $productData;
            } elseif (isset($_POST['update'])) {
                $index = $_POST['index'];
                $products[$index] = $productData;
            }

            saveProducts($productsFile, $products);
        }
    } elseif (isset($_POST['delete'])) {
        // Check if the user confirmed the deletion
        if (isset($_POST['confirm_delete']) && $_POST['confirm_delete'] === 'yes') {
            $index = $_POST['index'];
            array_splice($products, $index, 1);
            saveProducts($productsFile, $products);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
</head>
<body>
    <h1>Product Management</h1>

    <!-- Display products -->
    <h2>Current Products</h2>
    <ul>
        <?php foreach ($products as $index => $prod): ?>
            <li>
                <?php echo htmlspecialchars($prod['name']); ?> -
                <?php echo htmlspecialchars($prod['description']); ?> -
                <?php echo htmlspecialchars($prod['price']); ?> -
                <a href="<?php echo htmlspecialchars($prod['detailsPage']); ?>">Details</a> -
                <img src="<?php echo htmlspecialchars($prod['image']); ?>" alt="Product Image" style="width:100px;">
                <!-- Update and Delete forms -->
                <form method="post" action="?edit=<?php echo $index; ?>">
                    <input type="hidden" name="index" value="<?php echo $index; ?>">
                    <input type="submit" value="Edit">
                </form>
                <form method="post" onsubmit="return confirm('Are you sure you want to delete this product?')">
                    <input type="hidden" name="index" value="<?php echo $index; ?>">
                    <input type="submit" name="delete" value="Delete">
                    <input type="hidden" name="confirm_delete" value="yes">
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- Add or update product form -->
    <h2><?php echo isset($_GET['edit']) ? 'Update' : 'Add'; ?> Product</h2>
    <form method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
        <?php
        if (isset($_GET['edit'])) {
            $editProduct = $products[$_GET['edit']];
        }
        ?>
        <input type="hidden" name="index" value="<?php echo $_GET['edit'] ?? ''; ?>">
        <label>Name: <input type="text" name="name" value="<?php echo $editProduct['name'] ?? ''; ?>"></label><br>
        <label>Description: <input type="text" name="description" value="<?php echo $editProduct['description'] ?? ''; ?>"></label><br>
        <label>Price: <input type="text" name="price" value="<?php echo $editProduct['price'] ?? ''; ?>"></label><br>
        <label>Details Page: <input type="text" name="detailsPage" value="Product Details.html"></label><br>
        <label>Image: <input type="file" name="image"><br>
        <img src="<?php echo $editProduct['image'] ?? ''; ?>" alt="Product Image" style="width:100px;"></label><br>
        <input type="hidden" name="existingImage" value="<?php echo $editProduct['image'] ?? ''; ?>">
        <input type="submit" name="<?php echo isset($_GET['edit']) ? 'update' : 'add'; ?>" value="<?php echo isset($_GET['edit']) ? 'Update' : 'Add'; ?> Product">
    </form>
    <a href="admin.php">Back to Admin Page</a>

    <script>
    function validateForm() {
        var name = document.forms[0]["name"].value;
        var description = document.forms[0]["description"].value;
        var price = document.forms[0]["price"].value;
        var detailsPage = document.forms[0]["detailsPage"].value;
        var image = document.forms[0]["image"].value;
        if (name == "" || description == "" || price == "" || detailsPage == "" || image == "") {
            alert("All fields are required.");
            return false;
        }
        return true;
    }
    </script>
</body>
</html>

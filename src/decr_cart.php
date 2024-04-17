<?php
// Retrieve the product and quantity parameters
$product = $_POST['product'];
$quantity = $_POST['quantity'];

// 读取cart.txt
$cartContents = file_get_contents('cart.txt');

// Modify the contents based on the product and quantity
$lines = explode("\n", $cartContents);
foreach ($lines as &$line) {
    $columns = explode(",", $line);
    $itemProduct = trim($columns[0]);
    if ($itemProduct === $product) {
        $itemQuantity = (int) $columns[3];
        $itemQuantity -= 1;
        $columns[3] = $itemQuantity;
        $line = implode(",", $columns);
    }
}

// 写cart.txt
$modifiedContents = implode("\n", $lines);
file_put_contents('cart.txt', $modifiedContents);

// Set cache control headers to prevent caching
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Send a response back to the client
$response = [
    'status' => 'success',
    'message' => 'Cart modified successfully.'
];
header('Content-Type: application/json');
echo json_encode($response);
?>
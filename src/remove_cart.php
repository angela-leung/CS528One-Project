<?php
// Retrieve the product parameter
$product = $_POST['product'];

// 读取cart.txt
$cartContents = file_get_contents('cart.txt');

// Remove the line with matching product
$lines = explode("\n", $cartContents);
$modifiedLines = array_filter($lines, function($line) use ($product) {
    $columns = explode(",", $line);
    $itemProduct = trim($columns[0]);
    return ($itemProduct !== $product);
});

// 写cart.txt
$modifiedContents = implode("\n", $modifiedLines);
file_put_contents('cart.txt', $modifiedContents);

// Set cache control headers to prevent caching
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Send a response back to the client
$response = [
    'status' => 'success',
    'message' => 'Line removed from cart successfully.'
];
header('Content-Type: application/json');
echo json_encode($response);
?>
<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['identity']) || $_SESSION['identity'] !== 'admin') {
    // If not admin, redirect to login page
    header("Location: login.php");
    exit;
}

// Include your database connection here
// require_once 'path/to/your/database/connection/file.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .dashboard {
            display: flex;
            justify-content: space-around;
            padding: 20px;
        }
        .dashboard div {
            border: 1px solid #ccc;
            padding: 10px;
            width: 20%;
        }
    </style>
</head>
<body>
    <h1> Admin Dashboard</h1>
    <div class="dashboard">
        <div>
            <h3>Product Management</h3>
            <p>Manage your products, add new products, update existing products, and delete unwanted products.</p>
            <p><a href="manage_products.php">Manage Products</a></p>
        </div>
        <div>
            <h3>Order Management</h3>
            <p>View all orders, update order statuses, and manage returns and refunds.</p>
            <p><a href="manage_orders.php">Manage Orders</a></p>
        </div>
        <div>
            <h3>User Management</h3>
            <p>Manage user information, assign roles, and view user activity.</p>
            <p><a href="manage_users.php">Manage Users</a></p>
        </div>
        <div>
            <h3>Reports</h3>
            <p>View sales reports, customer analytics, and other data-driven insights.</p>
            <p><a href="reports.php">View Reports</a></p>
        </div>
    </div>
</body>
</html>

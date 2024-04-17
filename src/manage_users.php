<?php
session_start();

// Ensure the user is logged in and is an admin
if (!isset($_SESSION['identity']) || $_SESSION['identity'] !== 'admin') {
    header("Location: login.php"); // Redirect non-admins to the login page
    exit;
}

// Database connection setup
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "userdata";
$mysqli = new mysqli($servername, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Fetches all users from the database
function readUsers($mysqli) {
    $users = [];
    $result = $mysqli->query("SELECT * FROM users");
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    return $users;
}

// Updates user data except for password when not provided
function updateUser($mysqli, $userData) {
    $sql = empty($userData['password']) ?
           "UPDATE users SET username=?, email=?, identity=? WHERE id=?" :
           "UPDATE users SET username=?, email=?, password=?, identity=? WHERE id=?";
    $stmt = $mysqli->prepare($sql);
    if (empty($userData['password'])) {
        $stmt->bind_param("sssi", $userData['username'], $userData['email'], $userData['identity'], $userData['id']);
    } else {
        $hashedPassword = password_hash($userData['password'], PASSWORD_DEFAULT);
        $stmt->bind_param("ssssi", $userData['username'], $userData['email'], $hashedPassword, $userData['identity'], $userData['id']);
    }
    $stmt->execute();
    $stmt->close();
}

// Adds a new user with a hashed password
function addUser($mysqli, $userData) {
    $hashedPassword = password_hash($userData['password'], PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, email, password, identity) VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssss", $userData['username'], $userData['email'], $hashedPassword, $userData['identity']);
    $stmt->execute();
    $stmt->close();
}

// Deletes a user by ID
function deleteUser($mysqli, $id) {
    $sql = "DELETE FROM users WHERE id=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

$users = readUsers($mysqli); // Load users for display

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete'], $_POST['id'])) {
        deleteUser($mysqli, $_POST['id']);
    } elseif (isset($_POST['add'])) {
        addUser($mysqli, $_POST);
    } elseif (isset($_POST['update'], $_POST['id'])) {
        updateUser($mysqli, $_POST);
    }
    $users = readUsers($mysqli); // Refresh user list after any operation
}

$mysqli->close(); // Close database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
</head>
<body>
    <h1>User Management</h1>
    <h2>Current Users</h2>
    <ul>
        <?php foreach ($users as $user): ?>
            <li>
                <?php echo htmlspecialchars($user['username']); ?> -
                <?php echo htmlspecialchars($user['email']); ?> -
                [Password Hidden] -
                <?php echo htmlspecialchars($user['identity']); ?>
                <form method="post">
                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                    <input type="hidden" name="delete" value="Delete" onclick="return confirm('Are you sure you want to delete this user?');">
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
    <h2>Add User</h2>
    <form method="post">
        <input type="hidden" name="id" value="<?php echo $_GET['edit'] ?? ''; ?>">
        <label>Username: <input type="text" name="username" value="<?php echo $_GET['username'] ?? ''; ?>"></label><br>
        <label>Email: <input type="text" name="email" value="<?php echo $_GET['email'] ?? ''; ?>"></label><br>
        <label>Password: <input type of="password" name="password"></label><br>
        <label>Identity:</label>
        <label><input type="radio" name="identity" value="normal_user" <?php echo (isset($_GET['identity']) && $_GET['identity'] === 'normal_user') ? 'checked' : ''; ?>> Normal User</label>
        <label><input type="radio" name="identity" value="admin" <?php echo (isset($_GET['identity']) && $_GET['identity'] === 'admin') ? 'checked' : ''; ?>> Admin</label><br>
        <input type="submit" name="<?php echo isset($_GET['edit']) ? 'update' : 'add'; ?>" value="<?php echo isset($_GET['edit']) ? 'Update' : 'Add'; ?> User">

    </form>
    <a href="admin.php">Back to Admin Page</a>
</body>
</html>

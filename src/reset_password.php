<?php
session_start();

$host = 'localhost'; // 数据库服务器
$dbname = 'userdata'; // 数据库名
$user = 'root'; // 数据库用户名
$pass = ''; // 数据库密码

try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
} catch (PDOException $e) {
  die('数据库连接失败: ' . $e->getMessage());
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password == $confirm_password) {
        $passwordHash = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$passwordHash, $user_id]);
        header("Location: login.php");
        exit;
    } else {
        $error = "The password does not match.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <style>
        body, html {
    height: 100%;
    margin: 0;
    background-color: #fcf4ed; /* 统一背景色 */
}
.centered-form {
    text-align: center; /* 使内部内容居中 */
}

.centered-form h1 {
    margin-bottom: 20px; /* 在标题和输入框之间添加空间 */
}
/* 更新外部容器的样式 */
.center-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
}

/* 更新表单容器样式 */
.form-container {
    background-color: #ffffff;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    max-width: 600px; /* 保持这个宽度来决定外部容器的宽度 */
    width: 100%;
    box-sizing: border-box;
}

/* 新增输入框包装样式 */
.input-group {
    max-width: 80%; /* 输入框宽度为其包装元素的80% */
    margin: 0 auto; /* 使包装元素居中 */
}

/* 更新输入框样式 */
input[type="text"],
input[type="password"],
input[type="email"],
button {
    width: 100%; /* 输入框全宽相对于其包装元素 */
    padding: 15px; /* 增加内边距使输入框更大 */
    margin-bottom: 15px; /* 与下一个元素的间距 */
    border-radius: 5px; /* 轻微的圆角 */
    border: 1px solid #ddd; /* 边框颜色 */
    font-size: 1em;
    box-sizing: border-box; /* 防止内边距和边框影响宽度 */
    
}
</style>
</head>
<body>

<<div class="center-container">
    <div class="form-container centered-form">
        <h1>Confirm your new password</h1>
        <form method="post" action="reset_password.php">
            <input type="hidden" name="user_id" value="<?php echo $_GET['user_id']; ?>">
            <div class="input-group">
                <input type="password" name="new_password" placeholder="New password" required>
                <input type="password" name="confirm_password" placeholder="Confirm new password" required>
                <button type="submit" >Change password</button>
            </div>
        </form>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
    </div>
</div>


</body>
</html>

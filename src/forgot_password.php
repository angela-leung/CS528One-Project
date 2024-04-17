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


$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $realname = $_POST['realname'];
    $email = $_POST['email'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND realname = ? AND email = ?");
    $stmt->execute([$username, $realname, $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // 如果用户验证成功，跳转到密码重设页面
        header("Location: reset_password.php?user_id=".$user['id']);
        exit;
    } else {
        $error = "提供的信息不匹配，请重试。";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            background-color: #fcf4ed; /* 统一背景色 */
        }
        .center-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
        .form-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px; /* 调整宽度 */
            width: 100%;
            box-sizing: border-box;
        }
        input[type="text"],
        input[type="password"],
        input[type="email"],
        button {
            width: 100%;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 16px;
            box-sizing: border-box;
        }
        button {
            background-color: #303b53;
            color: white;
            border: none;
            padding: 10px 15px;
            font-size: 18px;
            cursor: pointer;
            border-radius: 5px;
        }
        .information-text {
            margin-top: 20px; /* 与按钮之间的间距 */
            font-size: 0.9em; /* 文本尺寸 */
            color: #303b53; /* 文本颜色，可按需修改 */
            text-align: center;
        }
    </style>
</head>
<body>

<div class="center-container">
    <div class="form-container">
        <h1>Forgot Password</h1>
        <form method="post" action="forgot_password.php">
            <input type="text" name="username" placeholder="Your username" required>
            <input type="text" name="realname" placeholder="What's your name?" required>
            <input type="email" name="email" placeholder="What's your email?" required>
            <button type="submit" class="change-password-button">Submit</button>
        </form>
        <?php if (!empty($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <p class="information-text">
            <a href="staffhelp.html">Don't remember the information?</a>
        </p>
    </div>
</div>

</body>
</html>
